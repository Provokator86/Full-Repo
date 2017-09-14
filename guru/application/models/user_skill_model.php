<?php
/**
* User skill
* 
*/

class User_skill_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
    * @param mixed $condition, 
    *               "id" can be passed
    *               array("field1"=>value1,"field2 !="=>value2..)
    * @param mixed $order_by,  ex='title desc, name asc'
    * 
    * @return stdObj of admin db table.
    */
    public function user_skill_load($condition,$limit=NULL,$offset=NULL,$order_by=NULL)
    { 
        return $this->load_("user_skill",$condition,$limit,$offset,$order_by);
    }
    
    /**
    * Insert 
    * @param array $values=>array("admin_type_id"=>3,"s_admin_name"=>"test user"...);
    *        object $values=new stdClass();
    *               $values->admin_type_id=3; $values->s_admin_name="test user"...
    */
    public function add_user_skill($values)
    {
        
        return $this->add_("user_skill",$values);
        //$this->db->insert('', $data); 
        
        
    }
    
    /**
    * Update 
    * @param mixed $values, array("admin_type_id"=>3,"s_admin_name"=>"test user"...); OR 
    *              $values=new stdClass();
    *               $values->admin_type_id=3; $values->s_admin_name="test user"...
    * @param mixed $where,  array('name' => $name, 'title' => $title, 'status' => $status); OR 
    *                       array('name !=' => $name, 'id <' => $id, 'date >' => $date); OR 
    *                       "name='Joe' AND status='boss' OR status='active'";
    */
    public function update_user_skill($values,$where)
    {
        return $this->update_("user_skill",$values,$where);
    }    
    
       
    
    /**
    * Delete 
    * @param mixed $where,  array('id' => $id, 'title' => $title, 'status' => $status); OR 
    *                       array('name !=' => $name, 'id <' => $id, 'date >' => $date); OR 
    *                       "name='Joe' AND status='boss' OR status='active'";
    */
    public function delete_user_skill($where)
    {
        return  $this->delete_("user_skill",$where);
       
    }    
    

    public function count_endorsement($uid)
    {
        $this->db->select_sum("i_endorse_count");
        $this->db->group_by("uid");
        $rs=$this->db
            ->get_where("user_skill",
                        array("uid"=>$uid)
            )
            ->row();                

        if(!empty($rs))
        {
            return intval($rs->i_endorse_count);
        }
        return 0;
    }
	
	
	public function checking_duplicate_skills($uid,$skill="")
    {
        $rs=$this->db
            ->get_where("user_skill",
                        array("uid"=>$uid,
							"s_skill_name"=>$skill)
            )
            ->row();                

        if(!empty($rs))
        {
            return true;
        }
        return false;
    }    


    public function __destruct(){}
    
}

?>
