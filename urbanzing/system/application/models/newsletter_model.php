<?php
class Newsletter_model extends Model
{
	public function __construct()
    {
		parent::__construct();
	}
	
	function set_insert_newsletter($email='',$from_site=0)
	{
		if(!$email || $email=='')
			return false;
		$isExists	=$this->ck_email_exits($email); 
		if(!$isExists)
		{
			if($this->db->insert('newsletter_email', array('email'=>$email,'site_member'=>$from_site)))
	            return $this->db->insert_id();
	        else
	            return false;
		}
		else
			$this->db->update('newsletter_email', array('site_member'=>$from_site), array('id'=>$isExists));
		return $isExists;
	}
	
	private function ck_email_exits($email='')
	{
		if(!$email || $email=='')
			return false;
		$sql = "SELECT id
                	FROM {$this->db->dbprefix}newsletter_email  where email = '".mysql_real_escape_string($email)."' ";

		$query = $this->db->query($sql);
		$result_arr = $query->result_array();

		if( isset($result_arr[0]) )
			return $result_arr[0]['id'];
		else
			return false;
	}
	
	function delete_newsletter($email)
	{
		if(!$email || $email=='')
			return false;
		$sql    = "delete from {$this->db->dbprefix}newsletter_email where email= '$email'";
        return $this->db->query($sql);
	}
	
	function get_newsletter($toshow=-1,
    		$page=0,
    		$id=-1,
    		$name='',
    		$subject='',
    		$p_from='',
			$p_to='',
    		$order_name='id',
    		$order_type='desc')
    {
        $sucond   = " where 1 ";
        $pageLimit	= '';
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($name && $name!='')
            $sucond .= " and campaign_name like '%".mysql_real_escape_string($name)."%' ";
        if($subject!='')
            $sucond .= " and subject like '%$subject%' ";
        if($p_from && $p_from!='' && $p_to && $p_to!='' && strtotime($p_to)>=strtotime($p_from))
			$sucond	.= " and (add_date between ".strtotime($p_from)." and ".strtotime($p_to).")";
        $sql    = sprintf("select * from %snewsletter ",$this->db->dbprefix);
        if($toshow>0)
        	$pageLimit	= ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.$pageLimit;
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }
    
	function get_newsletter_count($id=-1,
    		$name='',
    		$subject='',
    		$p_from='',
	        $p_to=''
    		)
    {
        $sucond   = " where 1 ";
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($name && $name!='')
            $sucond .= " and campaign_name like '%".mysql_real_escape_string($name)."%' ";
        if($subject!='')
            $sucond .= " and subject like '%$subject%' ";
        if($p_from && $p_from!='' && $p_to && $p_to!='' && strtotime($p_to)>=strtotime($p_from))
			$sucond	.= " and (add_date between ".strtotime($p_from)." and ".strtotime($p_to).")"; 
        $sql    = sprintf("select * from %snewsletter ",$this->db->dbprefix);
        $sql    .= $sucond;
        $query = $this->db->query($sql);
		return $query->num_rows();
    }
    
    function get_newsletter_user($arr=array())
    {
    	$sql    = sprintf("select * from %snewsletter_email order by email",$this->db->dbprefix);
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }
    
    function set_newsletter_update($arr=array(),$id=-1)
    {
    	if( count($arr)==0)
			return false;
		if($id>0)
		{
			if($this->db->update('newsletter', $arr, array('id'=>$id)))
            	return $id;
		}
		else
		{
			if($this->db->insert('newsletter', $arr))
            	return $this->db->insert_id();
		}
		return false;
    }
    
	function set_send_newsletter_mail($last_newsletter_id=-1,$arr=array(),$config=array())
    {

        $content = '';
        if($arr['body']!="")
            $body=$arr['body'];
        else if($arr['emailbody_plain']!="")
            $body="@@@".$config['site_name']."@@@"."<br/>".$arr['emailbody_plain']."<br>@@@TEST@@@";
        else if($arr['file_upload_path']!="")
        {
            chmod("{$arr['file_upload_path']}",0777);
            if ($fp = fopen($arr['file_upload_path'], 'r'))
            {
                $content = '';
                  // keep reading until there's nothing left
                while ($line = fread($fp, 1024))
                    $content .= $line;
            }
            else
                echo "error";
            $body=$content;
        }
        else if($arr['txturl']!="")
        {
            $sitelink=substr($arr['txturl'],0,strrpos($arr['txturl'],'/'));
            if ($fp = fopen($arr['txturl'], 'r'))
            {
                while ($line = fread($fp, 1024))
                    $content .= $line;
                $pos=strrpos($arr['txturl'],"/");
                $sitelink=substr($arr['txturl'],0,$pos);
                $pos_imglink=strpos($content,'src="http://');
                if($pos_imglink==0)
                    $content=str_replace('src="','src="'.$sitelink.'/',$content);
                $content=str_replace('<param name="movie" value="','<param name="movie" value="'.$sitelink.'/',$content);
                $content=str_replace('<link href="','<link href="'.$sitelink.'/',$content);
            }
            else
                echo "error";
            $body=$content;
        }
        $replace_str    =  "<body><br/><img src='".base_url()."admin/newsletter/newsletter_report/".$last_newsletter_id."/emailcheck' border='0' width='250' height='100'/>";
        $message=str_replace("<body>",$replace_str,$body);
        $message=str_replace('<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">',$replace_str,$message);
        $message=str_replace("@@@".$config['site_name']."@@@",$replace_str,$message);
        $link=" ";
        $link=$link."<br/></body>";
        $message=str_replace("</body>",$link,$message);
        $link123=$link;
        $message=str_replace("@@@TEST@@@",$link123,$message);
        $from_address=$arr['txtcampaign_fromname']."<".$arr['txtEmail'].">";

        $subject=$arr['txtSubject'];
        
        $this->delete_newsletter_history_user('',$last_newsletter_id);
        
        $sent_count=0;
        $mailTo=array();
        $mailBCC=array();
		
		foreach($arr['nuser_id'] as $value)
        {
			$this->newsletter_user_data_update($last_newsletter_id,$value);
			if($sent_count>0)
				$mailBCC[($sent_count-1)]=$value;
			else
				$mailTo[$sent_count]=$value;
			$sent_count++;
        }
		
       /* if($arr['recevier_type']==2)
        {
            foreach($arr['nuser_id'] as $value)
            {
                $this->newsletter_user_data_update($last_newsletter_id,$value);
                if($sent_count>0)
                    $mailBCC[($sent_count-1)]=$value;
                else
                    $mailTo[$sent_count]=$value;
                $sent_count++;
            }
        }
        else
        {
            $newsUser   = $this->get_newsletter_user();
            foreach($newsUser as $key=>$value)
            {
                $this->newsletter_user_data_update($last_newsletter_id,$value["email"]);
                if($sent_count>0)
                    $mailBCC[($sent_count-1)]=$value["email"];
                else
                    $mailTo[$sent_count]=$value["email"];
                $sent_count++;
            }
        }*/
        $ci	= get_instance();
        $ci->load->model('automail_model');
        $ci->automail_model->send_newsletter_mail($subject,$message,$mailTo,$mailBCC);
        return $sent_count;
    }
    
    private function delete_newsletter_history_user($email='',$newsletter_id=-1)
    {
    	$subcond	= '';
    	if($email && $email!='')
    		$subcond	.= " and email = '$email' ";
    	if($newsletter_id && $newsletter_id!='' && is_numeric($newsletter_id))
    		$subcond	.= " and newsletter_id = '$newsletter_id' ";
        $sql    = "delete from {$this->db->dbprefix}newsletter_user where 1 $subcond";
        return $this->db->query($sql);
    }
    
 	private function newsletter_user_data_update($newsletter_id=-1,$email='')
    {

        if(!$newsletter_id || !is_numeric($newsletter_id) || !$email)
            return false;
        $sql    = "select * from {$this->db->dbprefix}newsletter_user where  newsletter_id=$newsletter_id and email='$email' ";
        $query = $this->db->query($sql);
		if($query->num_rows()>0)
            return false;
        $this->db->insert('newsletter_user', array('newsletter_id'=>$newsletter_id,'email'=>$email));
    }
    
	function set_delete_newsletter($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "DELETE FROM {$this->db->dbprefix}newsletter WHERE id=$id";
        return $this->db->query($sql);
    }
    
    function get_newsletter_old_user($newsletter_id=-1)
    {
    	if(!$newsletter_id || !is_numeric($newsletter_id))
            return false;
        $sql	= "select * from {$this->db->dbprefix}newsletter_user where newsletter_id=$newsletter_id";
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }
    
	function set_publish_newsletter($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "UPDATE {$this->db->dbprefix}newsletter SET
                                        `published`=1-`published`
                                        WHERE id='$id'";
        return $this->db->query($sql);
    }
    
	function set_update_open_count($id)
    {
    	if(!$id || !is_numeric($id))
            return false;
        $sql    ="update {$this->db->dbprefix}newsletter set open_count=open_count+1 where id=$id";
        return mysql_query($sql);
    }
}