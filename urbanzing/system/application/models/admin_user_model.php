<?php
//for MLM
class Admin_user_model extends Model
{
    public function __construct()
    {
	parent::__construct();
    }

    function authenticate($login, $password)
    {
        $sql            = "SELECT id, username, password, name, email
                        FROM {$this->db->dbprefix}admin WHERE
                            username = '".$this->db->escape_str($login)."' AND password = '".$this->db->escape_str($password)."' AND restricted = 1";
	$query          = $this->db->query($sql);
	$result_arr     = $query->result_array();
	if( isset($result_arr[0]) )
            return $result_arr[0];
	else
            return false;
    }
    
    function log_this_login($user_data)
    {
        $sql            = "UPDATE {$this->db->dbprefix}admin
                            SET lastlogin = '".time()."', login_status=1
                            WHERE id = '{$user_data['id']}'";
        $this->db->query($sql);
        $session_data   = array('admin_user_id'=>$user_data['id'],
                            'admin_user_username'=>$user_data['username'],
                            'admin_user_email'=>$user_data['email'],
                            'admin_role'=>true
                            );
        $this->session->set_userdata($session_data);
    }
    
    function logout_this_login()
    {
        $sql            = "UPDATE {$this->db->dbprefix}admin
                                SET login_status=0
                                WHERE id = '{$this->session->userdata('user_id')}'";
        $this->db->query($sql);
        $session_data   = array('admin_user_id'=>'',
                                'admin_user_username'=>'',
        			'admin_user_email'=>'',
                                'admin_role'=>''
            );
        $this->session->unset_userdata($session_data);
    }

    function get_user_list($toshow=-1,$page=0,$arr=array(),$order_name='name',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        $arr    = $this->db->escape_str($arr);
        if(isset ($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']}";
        if(isset ($arr['email']) && $arr['email']!='')
            $sucond .= " AND email='{$arr['email']}'";
        if(isset ($arr['name']) && $arr['name']!='')
            $sucond .= " AND name LIKE '%{$arr['name']}%'";
        if(isset ($arr['username']) && $arr['username']!='')
            $sucond .= " AND username LIKE '%{$arr['username']}%'";
        if(isset ($arr['restricted']) && $arr['restricted']!='' && $arr['restricted']!=-1 && is_numeric($arr['restricted']))
            $sucond .= " AND restricted ={$arr['restricted']}";
        $sql    = "SELECT * FROM {$this->db->dbprefix}admin ";
        if($toshow>0)
        	$pageLimit	= ' LIMIT '.$page.','.$toshow;
        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;
        $query = $this->db->query($sql);
	$result_arr = $query->result_array();
	return $result_arr;
    }

    function get_user_list_count($arr=array())
    {
        $sucond = ' where 1 ';
        $arr    = $this->db->escape_str($arr);
        if(isset ($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']}";
        if(isset ($arr['email']) && $arr['email']!='')
            $sucond .= " AND email={$arr['email']}";
        if(isset ($arr['name']) && $arr['name']!='')
            $sucond .= " AND name LIKE '%{$arr['name']}%'";
        if(isset ($arr['username']) && $arr['username']!='')
            $sucond .= " AND username LIKE '%{$arr['username']}%'";
        if(isset ($arr['restricted']) && $arr['restricted']!='' && $arr['restricted']!=-1 && is_numeric($arr['restricted']))
            $sucond .= " AND restricted ={$arr['restricted']}";
        $sql    = "SELECT * FROM {$this->db->dbprefix}admin ";
        $sql    .= $sucond;
        $query = $this->db->query($sql);
	return $query->num_rows();
    }

    function get_admin_duplicate($databaseTbl,$id=-1)
    {
        foreach($databaseTbl as $key=>$value)
        {
            $sub_cond = $key."='".htmlentities($value)."'";
            if($id && $id!='' && $id!=-1)
                $sub_cond   .= " AND id!='{$id}'";
            $sql = $this->db->query("SELECT * FROM {$this->db->dbprefix}admin WHERE $sub_cond");
            $total  = $sql->num_rows();
            if($total>0)
                return 'Duplicate '.$value;
        }
    }

    function set_user_insert($arr,$salt)
    {
        if( count($arr)==0 && $salt!=get_salt() )
			return false;
		if($this->db->insert('admin', $arr))
            return $this->db->insert_id();
        else
            return false;
    }

    function change_user_status($id,$status)
    {
        if(!$id || !is_numeric($id))
            return false;
        $status      = 1-$status;
        if(!$id || $id=='' || !is_numeric($id))
            return false;
        $this->db->update($this->db->dbprefix.'admin',array("restricted"=>$status),array("id"=>$id));
        return true;
    }

    function delete_user($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "DELETE FROM {$this->db->dbprefix}admin WHERE id= $id";
        return $this->db->query($sql);
    }

    function is_valid_user($id)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}admin WHERE id = '$id' ";
        $query  = $this->db->query($sql);
        if($query->num_rows()==0)
            return false;
        else
            return true;
    }

    function set_user_update($arr,$id)
    {
        if( count($arr)==0 || !$id || !is_numeric($id) || $id=='' || $id<1)
			return false;

		if(!$this->is_valid_user($id))
            return false;
		if($this->db->update('admin', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }

    function set_user_password_update($arr,$id)
    {
        if( count($arr)==0 || !$id || !is_numeric($id) || $id=='' || $id<1)
            return false;
        if(!$this->is_valid_user($id))
            return false;
        if($this->db->update('admin', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }

    

































    

    

    

    

    

    
    
    

	
    
    

    
	
	function confirem_user($code)
	{
		if($code=='')
			return false;
		$sql	= "select id from {$this->db->dbprefix}users where verification_code='$code'";
		
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		if($result_arr && $result_arr[0]['id'] && is_numeric($result_arr[0]['id']))
		{
			$this->db->update('users', array('verification_code'=>'','verified'=>1), array('id'=>$result_arr[0]['id']));
			return $result_arr[0]['id'];
		}
		else
			return false;
	}
	
	function set_send_email_settings($user_id=-1,$email='')
   	{
    	if(!is_array($email)|| !$email || $email=='' || !$user_id || !is_numeric($user_id) || $user_id==-1 || $user_id=='')
        	return false;
        $this->set_delete_send_email_settings($user_id);
        foreach($email as $values)
        	$this->db->insert('user_automail_right', array('user_id'=>$user_id,'mail'=>$values));
   	}
   	
   	function set_delete_send_email_settings($user_id)
   	{
   		if(!$user_id || !is_numeric($user_id) || $user_id==-1 || $user_id=='')
        	return false;
   		$sql    = "delete from {$this->db->dbprefix}user_automail_right where user_id= $user_id ";
        $this->db->query($sql);
   	}
   
	function get_email_rights($user_id)
   	{
    	$sql = "select * from {$this->db->dbprefix}user_automail_right where user_id='".$user_id."'";
      	$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		$data = array();
		foreach($result_arr as $key=>$value)
		$data[$value['mail']][] = $value;
		return $data;
   }
   
   function get_user_photo($user_id,$id=-1)
   {
   		if(!$user_id || $user_id=='' || !is_numeric($user_id) || $user_id<1)
   			return false;
   		$sub_cond	= '';
   		if($id && $id>0)
   			$sub_cond	.= " and id=$id";
   		$sql	= "select * from {$this->db->dbprefix}user_image where user_id=$user_id $sub_cond";
   		$query	= $this->db->query($sql);
   		return $query->result_array();
   }
   
	function set_user_photo_upload($arr)
    {
        if( count($arr)==0 )
			return false;
		if($this->db->insert('user_image', $arr))
            return $this->db->insert_id();
        else
            return false;
    }
    
	function delete_image($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "delete from {$this->db->dbprefix}user_image where id= $id";
        return $this->db->query($sql);
    }
    
	function update_visit($user_id)
	{
		$sql = sprintf("UPDATE %susers SET visitor = visitor+1 WHERE id={$user_id}",$this->db->dbprefix);
		mysql_query($sql);
	}
	
	function get_user_history($toshow=-1,
    		$page=0,
    		$name='',
    		$username='',
    		$restricted=-1,
    		$role='user',
    		$order_name='username',
    		$order_type='asc'
    		)
    {
        $sucond = ' where 1 ';
        $pageLimit	= '';
        if($name!='')
            $sucond .= " and (f_name like '%$name%' or l_name like '%$name%') ";
        if($username!='')
            $sucond .= " and username like '%$username%' ";
        if($restricted!=-1 && is_numeric($restricted) && $restricted!='')
            $sucond .= " and restricted=$restricted ";
        if($role=='' || $role==-1)
            $sucond .= " and role!=0";
        elseif($role=='admin')
            $sucond .= " and role=0";
        elseif($role>0 && is_numeric($role))
            $sucond .= " and role=$role";

        $sql	= "select u.id,u.username,u.role,u.restricted,u.date,u.lastlogin,u.pack_date,u.online_status,
        					p.pack_title,i.tot
         			from {$this->db->dbprefix}users u
  						left join {$this->db->dbprefix}package p on u.packid=p.id
  						left join (select si.user_id,sum(si.tot_amount) tot from {$this->db->dbprefix}invoice si group by si.user_id) i on i.user_id=u.id";
        if($toshow>0)
        	$pageLimit	= ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.$pageLimit;
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		
		return $result_arr;
    }

    function get_user_history_count($name='',$username='',$restricted=-1,$role='user')
    {
         $sucond = ' where 1 ';
        if($name!='')
            $sucond .= " and (f_name like '%$name%' or l_name like '%$name%') ";
        if($username!='')
            $sucond .= " and username like '%$username%' ";
        if($restricted!=-1 && is_numeric($restricted) && $restricted!='')
            $sucond .= " and restricted=$restricted ";
        if($role=='' || $role==-1)
            $sucond .= " and role!=0";
        elseif($role=='admin')
            $sucond .= " and role=0";
        elseif($role>0 && is_numeric($role))
            $sucond .= " and role=$role";
        $sql	= "select u.id
         			from {$this->db->dbprefix}users u
  						left join {$this->db->dbprefix}package p on u.packid=p.id
  						left join (select si.user_id,sum(si.tot_amount) tot from {$this->db->dbprefix}invoice si group by si.user_id) i on i.user_id=u.id";
        
        $sql    .= $sucond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }
    
    function get_buyer_job_history($id=-1)
    {
    	if(!$id || !is_numeric($id) || $id<=0)
    		return false;
    		
    	$sql = " select j.id,j.title, c.name,u.username,u.id, j.status, j.target_date, bn.bid_number,wt.username winner, f.message
  					from {$this->db->dbprefix}jobs j
    					inner join {$this->db->dbprefix}category c on j.category_id=c.id
    					inner join {$this->db->dbprefix}users u on j.user_id=u.id
    					left join (SELECT count(id) bid_number,job_id FROM {$this->db->dbprefix}quotes group by job_id) bn on bn.job_id=j.id
    					left join {$this->db->dbprefix}users wt on j.tradesman_id=wt.id
    					left join {$this->db->dbprefix}job_feedbacks f on j.id=f.job_id
					where u.id=$id order by j.target_date desc ";
    	$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		
		return $result_arr;
    }
    
	function get_tradesman_job_history($id=-1)
    {
    	if(!$id || !is_numeric($id) || $id<=0)
    		return false;
    		
    	$sql = " select u.username, q.quote, j.title,j.status,j.target_date, jp.username poster_name,c.name, bn.bid_number,wt.username winner,f.message
    				from {$this->db->dbprefix}users u
    					inner join {$this->db->dbprefix}quotes q on q.user_id=u.id
    					inner join {$this->db->dbprefix}jobs j on j.id=q.job_id
    					inner join {$this->db->dbprefix}category c on j.category_id=c.id
    					inner join {$this->db->dbprefix}users jp on jp.id=j.user_id
    					left join (SELECT count(id) bid_number,job_id FROM {$this->db->dbprefix}quotes group by job_id) bn on bn.job_id=j.id
    					left join {$this->db->dbprefix}users wt on j.tradesman_id=wt.id
    					left join {$this->db->dbprefix}job_feedbacks f on j.id=f.job_id
					where u.id=$id order by j.target_date desc ";
    	$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		
		return $result_arr;
    }
    
	function posting_notification($arr_jobb)
	{
	    $keyword_cond   = '';
	    $keyWord    = explode(',', $arr_jobb[0]['keword']);
	    foreach($keyWord as $value)
	        $keyword_cond   .= " or find_in_set('$value',keyword) ";
	
	    $sql    = "select * from {$this->db->dbprefix}users 
	                        where city = '{$arr_jobb[0]['city']}' or find_in_set('{$arr_jobb[0]['category_id']}',job_rader) $keyword_cond";
	    $query   = $this->db->query($sql);
	    $result_arr = $query->result_array();
		
		return $result_arr;
	}
}
?>