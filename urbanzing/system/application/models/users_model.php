<?php
class Users_model extends my_model
{
	public $user_type = array(1=>'Admin',2=>'Regular',3=>'Elite',4=>'Merchant');
	
    public function __construct()
    {
	parent::__construct();
    }

    function get_user_detail_light_box($arr=array())
    {
        $subcond	= " where 1 ";
        if(isset($arr['id']) && $arr['id']!='')
            $subcond	.= " and u.id='{$arr['id']}' ";
        $sql    = "SELECT u.*, ct.name ct_name, c.name c_name,s.name,z.zipcode,z.place
                    FROM {$this->db->dbprefix}users u 
                    LEFT JOIN {$this->db->dbprefix}zipcode z ON u.zipcode=z.id
                    LEFT JOIN {$this->db->dbprefix}city ct ON u.city_id=ct.id
                    LEFT JOIN {$this->db->dbprefix}state s ON u.state_id=s.id
                    LEFT JOIN {$this->db->dbprefix}country c ON u.country_id=c.id
                    $subcond";
        $query1 = $this->db->query($sql);
        $limit	= " limit 0,1 ";
        $sql .= $limit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
       	return $result;
    }

    function get_user_list($toshow=-1,$page=0,$arr=array(),$order_name='f_name',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        //if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
		if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']))
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['user_type_id']) && $arr['user_type_id']!=-1 && is_numeric($arr['user_type_id']) )
            $sucond .= " AND user_type_id={$arr['user_type_id']} ";
        if(isset($arr['email']) && $arr['email']!='')
            $sucond .= " AND email='".$this->db->escape_str($arr['email'])."' ";
        if(isset($arr['user_code']) && $arr['user_code']!='')
            $sucond .= " AND user_code='".$this->db->escape_str($arr['user_code'])."' ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND f_name LIKE '%{$arr['name']}%' ";
        if(isset($arr['username']) && $arr['username']!='')
            $sucond .= " AND username LIKE '%{$arr['username']}%' ";
        if(isset($arr['restricted']) && $arr['restricted']!=-1 && is_numeric($arr['restricted']) && $arr['restricted']!='')
            $sucond .= " AND restricted={$arr['restricted']} ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}users ";
        if($toshow>0)
        	$pageLimit	= ' LIMIT '.$page.','.$toshow;
        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    function get_user_list_count($arr=array())
    {
        $sucond = ' WHERE 1 ';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
         if(isset($arr['user_type_id']) && $arr['user_type_id']!=-1 && is_numeric($arr['user_type_id']) )
            $sucond .= " AND user_type_id={$arr['user_type_id']} ";
        if(isset($arr['email']) && $arr['email']!='')
            $sucond .= " AND email='".$this->db->escape_str($arr['email'])."' ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND f_name LIKE '%{$arr['name']}%' ";
        if(isset($arr) && $arr['username']!='')
            $sucond .= " AND username LIKE '%{$arr['username']}%' ";
        if(isset($arr['restricted']) && $arr['restricted']!=-1 && is_numeric($arr['restricted']) && $arr['restricted']!='')
            $sucond .= " AND restricted={$arr['restricted']} ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}users ";
        $sql    .= $sucond;

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function generate_user_rendom_dode()
    {
        $code   = get_rendom_code();
        $sql    = "SELECT user_code FROM {$this->db->dbprefix}user WHERE user_code='$code'";
        $query = $this->db->query($sql);
        if($query->num_rows()>0)
            $this->generate_user_rendom_dode();
        else
            return $code;
    }

    function get_user_duplicate($databaseTbl,$id=-1)
    {
        foreach($databaseTbl as $key=>$value)
        {
            $sub_cond = $key."='".htmlentities($value)."'";
            if($id && $id!='' && $id!=-1)
                $sub_cond   .= " AND id!='{$id}'";
            $sql = $this->db->query("SELECT * FROM {$this->db->dbprefix}user WHERE $sub_cond");
            $total  = $sql->num_rows();
            if($total>0)
                return 'Duplicate '.$value;
        }
    }
	
	function set_user_password_update($arr,$id)
    {
        if( count($arr)==0 || !$id || !is_numeric($id) || $id=='' || $id<1)
            return false;
        if(!$this->is_valid_user($id))
            return false;
        if($this->db->update('users', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }
	
	
	

    function get_user_hand($code,$position,$child_code='')
    {
        if(!isset($code) || $code=='')
            return false;
        $subcond    = '';
        if(isset($child_code) && $child_code!='')
        {
            if($position=='L')
                $subcond    .= " AND left_child!='$child_code'";
            else
                $subcond    .= " AND right_child!='$child_code'";
        }
        $sql    = "SELECT left_child,right_child FROM {$this->db->dbprefix}user WHERE user_code='$code' $subcond";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if($position=='L' && $result_arr[0]['left_child']!='')
            return "Position, what you have select is not vacant";
        elseif($position=='R' && $result_arr[0]['right_child']!='')
            return "Position, what you have select is not vacant";
    }

    function get_check_user_valid_pincode($code,$pin,$used_user='')
    {
        if(!isset($code) || $code=='' )
            return false;
        $subcond    = '';
        if(isset ($used_user) && $used_user!='')
        {
            $id = $this->get_user_pincode_id($code,$pin,$used_user);
            if($id && is_numeric($id) && $id>0)
                return;
        }
        $sql    = "SELECT id FROM {$this->db->dbprefix}user_pincode WHERE user_code='$code' AND pin_code='$pin'  AND status=0 $subcond";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return "Pincode is not valid for this promoter";
    }

    private function get_user_pincode_id($code,$pin,$used_user)
    {
        $sql    = "SELECT id FROM {$this->db->dbprefix}user_pincode WHERE user_code='$code' AND pin_code='$pin'  AND status=1 AND used_user='$used_user'";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return  (isset($result_arr) && isset($result_arr[0]['id']))?$result_arr[0]['id']:false;
    }

    function get_user_level($p_code)
    {
        if(!isset($p_code) || $p_code=='')
            return  0;
        $sql    = "SELECT level FROM {$this->db->dbprefix}user WHERE user_code='$p_code'";
        $query  = $this->db->query($sql);
        if($query->num_rows()>0)
        {
            $rs = $query->result_array();
            return ($rs[0]['level']+1);
        }
        return 0;
    }
    
    function update_user_heand($user_code,$child_code,$heand)
    {
        if(!isset($user_code) || $user_code=='')
            return false;
        if($heand=='L')
            $subcond    .= " left_child='$child_code' ";
        else
            $subcond    .= " right_child='$child_code' ";
        $sql    = "UPDATE {$this->db->dbprefix}user SET $subcond WHERE user_code='$user_code'";
        $this->db->query($sql);
    }

    function update_user_old_heand($user_code,$child_code)
    {
        if(!isset($user_code) || $user_code=='')
            return false;
        $sql    = "UPDATE {$this->db->dbprefix}user SET left_child='' WHERE user_code='$user_code' AND left_child='$child_code'";
        
        $this->db->query($sql);
        $sql    = "UPDATE {$this->db->dbprefix}user SET right_child='' WHERE user_code='$user_code' AND right_child='$child_code'";
        $this->db->query($sql);
    }

    function set_user_insert($arr,$salt)
    {
        if( count($arr)==0 && $salt!=get_salt() )
			return false;
		if($this->db->insert('user', $arr))
            return $this->db->insert_id();
        else
            return false;
    }

    function set_user_tmp_insert($arr)
    {
        if( count($arr)==0)
            return false;
        if($this->db->insert('user_tmp', $arr))
            return $this->db->insert_id();
        else
            return false;
    }

    function check_paren_exists($user_code)
    {
        if(!isset($user_code) || $user_code=='')
            return false;
        
        $sql    = "SELECT id FROM {$this->db->dbprefix}user WHERE user_code='$user_code'";
        $query  = $this->db->query($sql);
        if($query->num_rows()==0)
            return "Promoter what you have select, does not exists";
    }

    function get_user_with_pincode($user_id)
    {
        if(!isset($user_id) || $user_id=='')
            return false;
        $sql    = "SELECT u.id,u.name,u.user_code,p.pin_code, p.date_creation, uu.name used_name,uu.user_code used_code
                        FROM {$this->db->dbprefix}user u
                        LEFT JOIN {$this->db->dbprefix}user_pincode p ON u.user_code=p.user_code
                        LEFT JOIN {$this->db->dbprefix}user uu ON p.used_user=uu.user_code
                        WHERE u.id=$user_id
                        ORDER BY p.date_creation DESC
                        ";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    public function generate_user_rendom_pin()
    {
        $code   = get_rendom_code('',12);
        $sql    = "SELECT pin_code FROM {$this->db->dbprefix}user_pincode WHERE pin_code='$code'";
        $query = $this->db->query($sql);
        if($query->num_rows()>0)
            $this->generate_user_rendom_dode('',12);
        else
            return $code;
    }

    function set_user_pin_insert($arr)
    {
        if( count($arr)==0  )
            return false;
        if($this->db->insert('user_pincode', $arr))
            return $this->db->insert_id();
        else
            return false;
    }

    function delete_user_pin($code)
    {
        if(!$code || $code=='')
            return false;
        $sql    = "DELETE FROM {$this->db->dbprefix}user_pincode WHERE pin_code= '$code'";
        return $this->db->query($sql);
    }

    function change_user_status($id,$status)
    {
        if(!$id || !is_numeric($id))
            return false;
        $status      = 1-$status;
        if(!$id || $id=='' || !is_numeric($id))
            return false;
        $this->db->update($this->db->dbprefix.'users',array("restricted"=>$status),array("id"=>$id));
		if($status==0)
			$this->db->update($this->db->dbprefix.'mailing_list',array("email_opt_in"=>"N"),array("user_id"=>$id));
		else
			$this->db->update($this->db->dbprefix.'mailing_list',array("email_opt_in"=>"Y"),array("user_id"=>$id));
        return true;
    }

    function is_valid_user($id)
    {
        $sql = "SELECT * FROM {$this->db->dbprefix}users WHERE id = '$id' ";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return false;
        else
            return true;
    }
    
    function is_valid_user_arr($arr=array())
    {
        if(!isset($arr) || count($arr)==0)
            return false;
        $subcond    = ' 1 ';
        if(isset($arr['username']) && $arr['username']!='')
            $subcond    .= " AND username='{$arr['username']}' ";
        $sql = "SELECT * FROM {$this->db->dbprefix}user WHERE $subcond ";
        $query = $this->db->query($sql);
        if($query->num_rows()==0)
            return false;
        else
            return true;
    }

    function get_user_position_in_parent($user_code,$parent_code)
    {
        if(!isset($user_code) || $user_code=='' || !isset($parent_code) || $parent_code=='')
            return false;
        $sql    = "SELECT left_child,right_child FROM {$this->db->dbprefix}user WHERE user_code='$parent_code'";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if($result_arr[0]['right_child']==$user_code)
            return "R";
        else
            return "L";
    }

    function set_user_pin_code_update($arr,$code)
    {
        if( count($arr)==0 || !$code || $code=='')
            return false;
        if($this->db->update('user_pincode', $arr, array('pin_code'=>$code)))
            return true;
        else
            return false;
    }

    function set_user_update($arr,$id)
    {
        if( count($arr)==0 || !$id || $id=='')
            return false;
        if($this->db->update('user', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }

    function set_user_update_total_paid($amount,$code)
    {
        if( !$code || $code=='')
            return false;
        $sql    = " UPDATE {$this->db->dbprefix}user SET total_paid=total_paid+'$amount' WHERE user_code='$code' ";
        $this->db->query($sql);
        return true;
    }

    function get_user_binary_html($code='',$level_up_to=-1)
    {
        $html   = '';
        if(!isset($code) || $code=='')
            return $html;
        $subcond    = " ";
        if($level_up_to>0)
            $subcond    .= " AND level<$level_up_to ";
        $sql    = "SELECT * FROM {$this->db->dbprefix}user WHERE user_code='$code' $subcond ";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(isset($result_arr))
        {
            $html   .= '<tr>';
            $html   .= '<td align="center">'.$result_arr[0]['user_code'].'</td>';
            $html   .= '<td align="center">'.$result_arr[0]['p_id'].'</td>';
            $html   .= '<td align="center">'.(date('d-m-Y',$result_arr[0]['join_date'])).'</td>';
            $html   .= '<td align="center">'.$result_arr[0]['level'].'</td>';
            $html   .= '</tr>';
            if(isset($result_arr[0]['left_child']) && $result_arr[0]['left_child']!='')
                $html   .= $this->get_user_binary_html($result_arr[0]['left_child'],$level_up_to);
            if(isset($result_arr[0]['right_child']) && $result_arr[0]['right_child']!='')
                $html   .= $this->get_user_binary_html($result_arr[0]['right_child'],$level_up_to);
        }
        return $html;
    }
    
    function get_user_tree_frontend($code='',$level=-1,$level_up_to=-1)
    {
        if(!isset($code) || $code=='' || !isset($level) || !is_numeric($level) || $level<0)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}user WHERE user_code='$code' AND level<$level_up_to";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(isset($result_arr))
        {
            $arr['name']   = $result_arr[0]['username'];
            $arr['user_code']   = $result_arr[0]['user_code'];
            $arr['level']   = $result_arr[0]['level'];
            $arr['p_id']   = $result_arr[0]['p_id'];
            $arr['htm']     = '<a onmouseover="ShowContentToolTip(\''.base_url().'user/ajax_user_detail/'.$arr['user_code'].'\'); return true;" onmouseout="HideContentToolTip(); return true;" href="'.base_url().'profile/geneology/'.$arr['user_code'].'/'.$arr['level'].'"><img style="border:0px;" src="'.base_url().'images/admin/icon_4.png" alt="" /></a><p>'.$arr['name'].'</p>';
            if(isset($result_arr[0]['left_child']) && $result_arr[0]['left_child']!='')
                $arr['left_child']   = $this->get_user_tree_frontend($result_arr[0]['left_child'],($result_arr[0]['level']+1),$level_up_to);
            if(isset($result_arr[0]['right_child']) && $result_arr[0]['right_child']!='')
                $arr['right_child']   = $this->get_user_tree_frontend($result_arr[0]['right_child'],($result_arr[0]['level']+1),$level_up_to);
        }
        return $arr;
    }
    
    function get_user_tree($code='',$level=-1,$level_up_to=-1)
    {
        if(!isset($code) || $code=='' || !isset($level) || !is_numeric($level) || $level<0)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}user WHERE user_code='$code' AND level<$level_up_to";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(isset($result_arr))
        {
            $arr['name']   = $result_arr[0]['name'];
            $arr['user_code']   = $result_arr[0]['user_code'];
            $arr['level']   = $result_arr[0]['level'];
            $arr['p_id']   = $result_arr[0]['p_id'];
            $arr['htm']     = '<a onmouseover="ShowContentToolTip(\''.base_url().'admin/user/ajax_user_detail/'.$arr['user_code'].'\'); return true;" onmouseout="HideContentToolTip(); return true;" href="'.base_url().'admin/user/tree/'.$arr['user_code'].'/'.$arr['level'].'"><img style="border:0px;" src="images/admin/icon_4.png" alt="" /></a><p>'.$arr['name'].'</p>';
            if(isset($result_arr[0]['left_child']) && $result_arr[0]['left_child']!='')
                $arr['left_child']   = $this->get_user_tree($result_arr[0]['left_child'],($result_arr[0]['level']+1),$level_up_to);
            if(isset($result_arr[0]['right_child']) && $result_arr[0]['right_child']!='')
                $arr['right_child']   = $this->get_user_tree($result_arr[0]['right_child'],($result_arr[0]['level']+1),$level_up_to);
        }
        return $arr;
    }

    public function get_user_parent($user_code='')
    {
        $subcond    = " 1 ";
        if(isset($user_code) && $user_code!='')
            $subcond    .= " AND u.user_code='$user_code'";
        $sql    = "SELECT u.join_date,u.name,u.username,u.email,u.user_code,u.total_income,p.name p_name,p.user_code p_user_code
                    FROM {$this->db->dbprefix}user u LEFT JOIN {$this->db->dbprefix}user p ON p.user_code=u.p_id
                    WHERE $subcond ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function get_user_with_child($user_code)
    {
        if(!isset($user_code) || $user_code=='')
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}user WHERE user_code='$user_code'";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(isset($result_arr))
        {
            $result_arr[0]['left_total']    = $this->get_total_child($result_arr[0]['left_child']);
            $result_arr[0]['right_total']    = $this->get_total_child($result_arr[0]['right_child']);
        }
        return $result_arr;
    }

    function get_total_child($user_code)
    {
        $return_value   = 0;
        if(!isset($user_code) || $user_code=='')
            return 0;

        $sql    = "SELECT COUNT(id) tot,left_child,right_child
                    FROM {$this->db->dbprefix}user WHERE user_code='$user_code' GROUP BY id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(isset($result_arr))
        {
            if($result_arr[0]['tot']>0)
                $return_value++;
            if (isset($result_arr[0]['left_child']) && $result_arr[0]['left_child']!='')
                $return_value   = $return_value + $this->get_total_child($result_arr[0]['left_child']);
            if (isset($result_arr[0]['right_child']) && $result_arr[0]['right_child']!='')
                $return_value   = $return_value + $this->get_total_child($result_arr[0]['right_child']);
        }
        return $return_value;
    }

    function authenticate($login, $password)
    {
        $sql = "SELECT id,  password, f_name, l_name, user_type_id, email,img_name
                FROM {$this->db->dbprefix}users  where email  = '".$this->db->escape_str($login)."' and password = '$password' and verified = 2 AND restricted=1";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if( isset($result_arr[0]) )
            return $result_arr[0];
        else
            return false;
    }
	function facebook_authenticate($login)
    {
        $sql = "SELECT id,  password, f_name, l_name, user_type_id, email,img_name
                FROM {$this->db->dbprefix}users  where email  = '".$this->db->escape_str($login)."' and verified = 2";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if( isset($result_arr[0]) )
            return $result_arr[0];
        else
            return false;
    }

    function log_this_login($user_data)
    {
        $session_data   = array('user_type'=>($user_data['user_type']==0)?'admin':'non_admin',
                                        'user_id'=>$user_data['id'],
                                        'user_username'=>$user_data['f_name'],
                                        'user_email'=>$user_data['email'],
                                        'user_type_id'=>$user_data['user_type_id'],
                                        'user_img_name'=>$user_data['img_name']
        );
        $this->session->set_userdata($session_data);
	}

	function logout_this_login()
    {
        $session_data   = array('user_type'=>'',
                                    'user_id'=>'',
                                    'user_username'=>'',
                                    'user_email'=>'',
                                    'user_type_id'=>'',
                                    'user_img_name'=>''
        );
        $this->session->unset_userdata($session_data);
		//var_dump($this->session->unset_userdata($session_data));
		
	}

    public function set_user_payment_insert($user_code,$p_mode,$card_type='',$card_number='',$e_date='',$card_v_number='')
    {
        $reshash = $this->session->userdata('reshash');
        $arr    = array('pay_type'=>$p_mode,'amount'=>$reshash['AMT'],'p_date'=>time(),'user_code'=>$user_code,'card_type'=>$card_type,'card_number'=>$card_number,'e_date'=>$e_date,'card_v_number'=>$card_v_number);
        $this->session->set_userdata(array('reshash'=>''));
        if($this->db->insert('uesr_payment', $arr))
            return $this->db->insert_id();
        else
            return false;
    }



    function get_user_option($user_code='')
    {
        $sql    = "SELECT user_code,name FROM {$this->db->dbprefix}user ORDER BY name";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $html   = '';
        foreach($result_arr as $k=>$v)
        {
            $selected   = '';
            if($v['user_code']==$user_code)
                $selected   = ' selected ';
            $html   .=  '<option value="'.$v['user_code'].'" '.$selected.'>'.$v['name'].'</option>';
        }
        return $html;
    }

    function get_user_list_report($toshow=-1,$page=0,$arr=array(),$order_name='name',$order_type='asc')
    {
        $sucond = ' WHERE 1 ';
        $pageLimit	= '';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['user_code']) && $arr['user_code']!='')
            $sucond .= " AND user_code='".$this->db->escape_str($arr['user_code'])."' ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND name LIKE '%{$arr['name']}%' ";
        if(isset($arr['username']) && $arr['username']!='')
            $sucond .= " AND username LIKE '%{$arr['username']}%' ";
        if(isset($arr['restricted']) && $arr['restricted']!=-1 && is_numeric($arr['restricted']) && $arr['restricted']!='')
            $sucond .= " AND restricted={$arr['restricted']} ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}user ";
        if($toshow>0)
        	$pageLimit	= ' LIMIT '.$page.','.$toshow;
        $sql    .= $sucond.' ORDER BY '.$order_name.' '.$order_type.$pageLimit;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        foreach ($result_arr as $k=>$v)
        {
            $result_arr[$k]['p_name']   = '';
            if($v['p_id']!='')
            {
                $tmp    = $this->get_user_list_report(1,0,array('user_code'=>$v['p_id']));
                $result_arr[$k]['p_name']   = $tmp[0]['name'];
            }
            $result_arr[$k]['left_total']    = $this->get_total_child($v['left_child']);
            $result_arr[$k]['right_total']    = $this->get_total_child($v['right_child']);
        }
        return $result_arr;
    }

    function get_user_list_report_count($arr=array())
    {
        $sucond = ' WHERE 1 ';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $sucond .= " AND id={$arr['id']} ";
        if(isset($arr['name']) && $arr['name']!='')
            $sucond .= " AND name LIKE '%{$arr['name']}%' ";
        if(isset($arr) && $arr['username']!='')
            $sucond .= " AND username LIKE '%{$arr['username']}%' ";
        if(isset($arr['restricted']) && $arr['restricted']!=-1 && is_numeric($arr['restricted']) && $arr['restricted']!='')
            $sucond .= " AND restricted={$arr['restricted']} ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $sucond .= $arr['ext_cond'];
        $sql    = "SELECT * FROM {$this->db->dbprefix}user ";
        $sql    .= $sucond;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	
	function confirem_user($user_id,$code)
	{
		if($code=='')
			return false;
		$sql	= "select id from {$this->db->dbprefix}users where verification_code='$code' and id=$user_id";
		
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		//var_dump($result_arr);
		//die();
		if($result_arr && $result_arr[0]['id'] && is_numeric($result_arr[0]['id']))
		{
			$this->db->update('users', array('verification_code'=>'','verified'=>2), array('id'=>$result_arr[0]['id']));
			return $result_arr[0]['id'];
		}
		else
			return false;
	}	
	
	function get_invite_user_list($toshow=-1,$page=0,$arr=array(),$order_by='invited_date',$order_type='asc')
	{
        $subcond = ' WHERE 1 ';
        if(isset($arr['id']) && $arr['id']!=-1 && is_numeric($arr['id']) && $arr['id']>0)
            $subcond .= " AND id={$arr['id']} ";
        if(isset($arr['invited_email']) && $arr['invited_email']!='')
            $subcond .= " AND invited_email ='{$arr['invited_email']}'";
        if(isset($arr['email_opt_in']) && $arr['email_opt_in']!='')
            $subcond .= " AND email_opt_in ='{$arr['email_opt_in']}'";
        if(isset($arr['invite_accepted']) && $arr['invite_accepted']!='')
            $subcond .= " AND invite_accepted ='{$arr['invite_accepted']}'";
        if(isset($arr['user_type_id']) && $arr['user_type_id']!=-1 && is_numeric($arr['user_type_id']) && $arr['user_type_id']>=0)
            $subcond .= " AND user_type_id={$arr['user_type_id']} ";
			
		$sql		= " select *
						from {$this->db->dbprefix}mailing_list 
						$subcond
						order by $order_by $order_type
							";
		if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		$sql .= $limit; 
	//echo $sql;
	
		$query = $this->db->query($sql);
		//die();
		$result = $query->result_array();	
		return $result;
		
	}

	/**
	 *This function is for delete user image from urban_users table when user wants to delete his picture
	 */
	function update_user_image($tableName, $id = -1 )
	{
		$msg = '';
		$sql = "UPDATE {$this->db->dbprefix}{$tableName} SET img_name = '' WHERE id = {$id}";
		if( $this->db->query($sql))
			$msg = 'Deleted the picture Successfully';
		else
			$msg = 'Can not delete the picture.';
		return $msg;
	}
	
	function delete_users_uploaded_picture($tableName, $arr)
	{
		$msg = '';
		$subcond  = " WHERE 1";
		$sql = "DELETE FROM  {$this->db->dbprefix}{$tableName}";

		if( isset($arr['id']) && $arr['id'] != -1)
		{
		   $result = $this->get_user_business_picture_details( $arr);
		   if(empty($result))
			{
				$msg = 'Can not be deleted the picture';
	
			}
		}
		else
		{
			$msg = 'Picture can not be deleted';

		}

		if($msg == '')
		{
			$subcond = " WHERE id = {$arr['id']}";
			$sql.= $subcond;

			if( $this->db->query($sql))
				$msg = 'Deleted the picture Successfully';
			else
				$msg = 'Can not be deleted the picture.';
		}
		
		return  $msg;
    }

	function get_user_business_picture_details( $arr = '')
	{
		$sql = "SELECT * FROM {$this->db->dbprefix}business_picture WHERE 1";
		$subcond = '';
		if( isset($arr['id']) && $arr['id'] != -1)
		{
			$subcond.=" AND id = {$arr['id']}";
		}
		$sql.= $subcond ;
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	function user_report($page= 0,$toshow = -1, $order_by = 'f_name')
	{
		$subcond = '';
		if( $toshow > 0)
			$subcond = " LIMIT $page,$toshow ";
		$sql = "SELECT * FROM urban_view_user_report WHERE cnt_bus >= 15 OR cnt_reviews>=20 OR (cnt_bus >= 5 AND cnt_reviews>=15 )
		
			ORDER BY $order_by $subcond 
		";
			
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return $result;
	}
	
	function get_user_report_count()
	{
		$sql = "SELECT COUNT(*) tot FROM urban_view_user_report WHERE cnt_bus >= 15 OR cnt_reviews>=20 OR (cnt_bus >= 5 AND cnt_reviews>=15 )";
			
		$query = $this->db->query($sql);
		$result = $query->result_array();
		return  $result[0]['tot'];

	}
	
	function get_user_report_csv($page=0,$toshow=2, $order_by = 'f_name')
	{
	
		$sql = "SELECT f_name as 'Name', email as 'Email Id', user_type, cnt_bus as 'Business Added', cnt_reviews as 'Review Written' FROM urban_view_user_report WHERE cnt_bus >= 15 OR cnt_reviews>=20 OR (cnt_bus >= 5 AND cnt_reviews>=15 )
	
		ORDER BY $order_by  
		";
			
		$query = $this->db->query($sql);
		return $query;
	
	}
	
	

	function get_user_list_csv($toshow=-1,$page=0,$arr=array(),$order_name='f_name',$order_type='asc')
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}users ";
 
        $query = $this->db->query($sql);
        
        return $query ;
    }
	
	
	
}
