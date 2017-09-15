<?php
//for MLM
class Automail_base_model extends Model
{
    public $automail_type   = array(
                                    //'add_user'=> 'Add user',
                                    'user_registration'=> 'User registration (Regular)',
									'welcome_signup_mail'=> 'Welcome user mail(Regular)',
									'invite_party' => 'Invite Party',
                                    'user_registration_merchant'=> 'User registration (Merchant)',
									'admin_added_user_registration'=> 'Admin added user registration',
									'business_claim_admin' => 'Business Claim (Admin)',
									'invite_user' => 'Invite User',
                                    'forgot_password'=>'Forgot password',
                                    'invite_party_reply'=>'Reply Against Party Mail Invitation',
									'report_against_review'=>'Report Against Report review',
									'like_review'=>'Report review like',
									'welcome_yuva_signup_mail'=>'Welcome user mail from yuva',
									'review_writer_mail'=>'Send mail to review writer',
    );

    public $manualArr  = array();

    public function __construct()
    {
        parent::__construct();
    }

    function get_automail_all($item_type='')
    {
        if($item_type=='')
            return false;
        $sql    = sprintf("select * from %sautomail where item_type='$item_type' ",$this->db->dbprefix);

        $sql    .= ' limit 0,1';
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }

    function get_dynamic_options_html_for_cms()
    {
            $arr_table=$this->getDBTableName();
            $html="";
            foreach($arr_table as $table)
            {
                    if(substr($table,0,strlen($this->db->dbprefix))!=$this->db->dbprefix)continue;

                    $table_without_prefix=split($this->db->dbprefix,$table);
                    $table_without_prefix=$table_without_prefix[1];
                    if(!in_array($table_without_prefix,array('cms','var_cache')))
                    {
                            $arr_col=$this->getDBColName($table);
                            foreach($arr_col as $col)
                            {
                                    $tmp=explode("_",strtolower($col));
                                    if(in_array("id",$tmp) && !in_array("login",$tmp))continue;
                                    if(in_array("status",$tmp))continue;
                                    if(in_array("permission",$tmp))continue;

                                    $html.="<option value=\"%%{$table_without_prefix}__{$col}%%\">{$table_without_prefix}__{$col}</option>";
                            }
                    }
            }
            return $html;
    }

	function getDBTableName()
	{
		$arr=array();
		$sql="SHOW TABLES FROM {$this->db->database}";
                $query = $this->db->query($sql);
                $result_arr = $query->result_array();
//                var_dump($result_arr);
                $field_name = 'Tables_in_'.$this->db->database;
		foreach($result_arr as $k=>$v)
		{
//                    var_dump($v);
//                    echo '<br>';
			if((!$this->db->dbprefix) || (strpos($v[$field_name],$this->db->dbprefix)===0))
				$arr[]=$v[$field_name];
		}
		return $arr;
	}

	function getDBColName($table_name)
	{
		$db_col_array = $this->getDBColDetail($table_name);
		$arr=array();
		foreach($db_col_array as $col)
			$arr[]=$col["field"];
		return $arr;
	}

	function getDBColDetail($table_name,$only_att='')
	{
		$db_col_array = array();
		if($only_att)
			$db_col_array_only_att = array();

		$sql="DESCRIBE $table_name";
		$query = $this->db->query($sql);
                $result_arr = $query->result_array();
		foreach($result_arr as $key=>$value)
		{
			foreach($value as $k => $v)
			{
				if(is_numeric($k)) unset($row[$k]);
				else
				{
					$row[$k]=$v;
					$row[strtolower($k)]=$v;
					$row[strtoupper($k)]=$v;
				}
			}
			$db_col_array[]=$row;
	        if($only_att)
			$db_col_array_only_att[]=$row[$only_att];
		}

		if($only_att)
			$db_col_array=$db_col_array_only_att;

		return $db_col_array;
	}

    function set_automail_update($arr,$id=-1)
    {

        $sql = sprintf("SELECT * FROM %sautomail where id=$id ", $this->db->dbprefix);
		$query = $this->db->query($sql);
		if($query->num_rows()==0)
            return $this->db->insert('automail', $arr);
        else
            return $this->db->update('automail', $arr, array('id'=>$id));
    }

    function send_automail_to_user($tableName,$row,$mail_type,$mailTo,$mailCC='',$mailBCC='')
    {
    	if (!$row || !is_array($row) || !$mail_type || $mail_type==''|| !$mailTo || $mailTo=='' || !$tableName || $tableName=='')
    		return false;
    	$mail_detail	= $this->get_automail_all($mail_type);
    	$mail_body=html_entity_decode($this->send_email_dynamic_body_composer(base64_decode($mail_detail[0]['description']),$row,$tableName));
		
        return $this->project_send_mail($mail_detail[0]['subject'],$mail_body,$mailTo,$mailCC,$mailBCC);
    }

    private function get_sender_information()
    {
    	$sender_detail	= $this->get_send_mail_from_detail();
    	$config['protocol'] = ($sender_detail && $sender_detail['mail_protocol'])?$sender_detail['mail_protocol']:'smtp';
        $config['mail_from_name'] = ($sender_detail && $sender_detail['mail_from_name'])?$sender_detail['mail_from_name']:'';
        $config['mail_from_email'] = ($sender_detail && $sender_detail['mail_from_email'])?$sender_detail['mail_from_email']:'donotReply@'.$sender_detail['site_name'];
        $config['mail_replay_name'] = ($sender_detail && $sender_detail['mail_replay_name'])?$sender_detail['mail_replay_name']:'';
        $config['mail_replay_email'] = ($sender_detail && $sender_detail['mail_replay_email'])?$sender_detail['mail_replay_email']:'donotReply@'.$sender_detail['site_name'];
        $config['smtp_host'] = $sender_detail['smtp_host'];
        $config['smtp_user'] = $sender_detail['smtp_user'];
        $config['smtp_pass'] = $sender_detail['smtp_pass'];
        return 	$config;
    }

    function project_send_mail($mailSubject,$mailBody,$mailTo,$mailCC='',$mailBCC='')
    {

    	$this->load->library('email');
    	$senderData	= $this->get_sender_information();
    	$config['charset'] = 'utf-8';
    	$config['mailtype'] = 'html';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['protocol'] = $senderData['protocol'];
    	if($config['protocol']=='smtp')
        {
            $config['smtp_host'] = $senderData['smtp_host'];
            $config['smtp_user'] = $senderData['smtp_user'];
            $config['smtp_pass'] = $senderData['smtp_pass'];
        }
    	$this->email->initialize($config);

		$this->email->from($senderData['mail_from_email'], $senderData['mail_from_name']);
		$this->email->reply_to($senderData['mail_replay_email'], $senderData['mail_replay_name']);

		$this->email->to($mailTo);
		if($mailCC && $mailCC!='')
			$this->email->cc($mailCC);
		if($mailBCC && $mailBCC!='')
			$this->email->bcc($mailBCC);

		$this->email->subject($mailSubject);
		$this->email->message($mailBody);

		$this->email->send();

    	//echo $this->email->print_debugger();
		return true;
    }

	private function send_email_dynamic_body_composer($mail_body,$row,$add_table_name_to_default='',$remove_extra_scrap=true)
	 {
	  //print_r($add_table_name_to_default);
	  foreach($row as $col=>$val)
	  {
	   if(!is_numeric($col))
	   {
	    if(is_array($add_table_name_to_default))
	    {
	     foreach($add_table_name_to_default as $key=>$tbl)
	     {
	      //echo $tbl.'=='.$col.'<br>';
	      if($tbl && !strstr($col,'__'))
	      //{
	       $col_tmp="{$tbl}__{$col}";

	      //echo $col.'<br>';}
	      $mail_body=str_replace("%%$col_tmp%%",$val,$mail_body);
	     }
	    }
	    else
	    {
	     if($add_table_name_to_default && !strstr($col,'__'))
	      $col="{$add_table_name_to_default}__{$col}";
	     $mail_body=str_replace("%%$col%%",$val,$mail_body);
	    }
	   }
	  }
          if(is_array($this->manualArr) && count($this->manualArr)>0)
          {
              foreach ($this->manualArr as $k=>$v)
                $mail_body=str_replace("%%$k%%",$v,$mail_body);
          }
	  if($remove_extra_scrap)
	   $mail_body=preg_replace('/%%[^%]+%%/',"",$mail_body);
	  return $mail_body;
	 }

	 function did_user_get_mail($mail_type,$user_email)
	{
		$sql	= "select n.mail from {$this->db->dbprefix}user_automail_right n inner join {$this->db->dbprefix}users u on u.id=n.user_id where u.email='$user_email' and n.mail='$mail_type'";
		$query	= $this->db->query($sql);
		$tot	= $query->num_rows();
		if($tot >0)
			return true;
		return false;
	}

    private function get_send_mail_from_detail()
    {
    	$this->load->model('site_settings_model');
    	$setingsArr	= array();
    	return $this->site_settings_model->get_site_settings(array('mail_from_name','mail_from_email','mail_replay_name','mail_replay_email','mail_protocol','site_name','smtp_host','smtp_user','smtp_pass'));
    }
}