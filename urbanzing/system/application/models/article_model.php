<?php
class Article_model extends Model
{
    public $article_category       = array( 'contact_us'=>'Contact Us',
											'home_page_text'=>'Home Page Text',
											'login_page_upper'=>'Login Page Upper',
											'login_page_lower'=>'Login Page Lower',
											'user_signup_upper'=>'User Sign Up Upper',
											'promote_business_page_upper_text' => 'Promote Business Page Upper Text',
											'promote_business_page_middle_text' => 'Promote Business Page Middle Text',
											'promote_business_page_lower_text' => 'Promote Business Page Lower Text',
											'user_merchant_registration_page_text'=>'User Merchant registration Page',
											'business_add_page_text'=>'Business Add Page Text',
											'business_claim_page_text'=>'Business Claim Page Text',
											'profile_edit_page_text'=>'Profile Edit Page Text',
											'message_page_text'=>'Message page Text',
											'about_us' =>'About us',
											'careers'=>'Careers',
											'contact_us'=>'Contact Us',
											'terms'=>'Terms & Conditions',
											'privacy'=>'Privacy',
											'edit_user_profile' => 'Edit User Profile Text',
											'write_review_upper_text' =>'Write review Page Text',
											'upload_picture_upper_text' =>'Upload Picture Upper Page Text',
											'normal_user_page_text'=>'Normal User Page Text',
											'marchant_user_page_text'=>'Marchant User Page Text',
											'edit_business_page_text' => 'Edit Business Page Text',                                                                                        
                                                                                        'party_add'=>'Party Page Text',
                                                                                        'other'=>'Other'
    );
    
    public function __construct()
    {
        parent::__construct();
    }

    function get_article_list($toshow=-1,$page=0,$id=-1,$title='',$status=-1,$category='',$order_name='title',$order_type='asc')
    {
        $sucond = ' where 1 ';
        $limit='';
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($title!='')
            $sucond .= " and (title like '%$title%') ";
        if($status!=-1 && is_numeric($status) && $status!='')
            $sucond .= " and status=$status ";
        if($category!='' && $category!=-1)
            $sucond .= " and category_id='$category'";

        $sql    = sprintf("select * from %sarticle ",$this->db->dbprefix);
        if($toshow>0)
			$limit	= ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.' '.$limit;
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }

    function get_article_list_count($id=-1,$title='',$status=-1,$category='')
    {
         $sucond = ' where 1 ';
         if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($title!='')
            $sucond .= " and (title like '%$title%') ";
        if($status!=-1 && is_numeric($status) && $status!='')
            $sucond .= " and status=$status ";
        if($category!='' && $category!=-1)
            $sucond .= " and category_id='$category'";
            
        $sql    = sprintf("select * from %sarticle ",$this->db->dbprefix);

        $sql    .= $sucond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }

    function change_article_status($id,$status)
    {
        if(!$id || !is_numeric($id))
            return false;
        $status      = 1-$status;
        if(!$id || $id=='' || !is_numeric($id))
            return false;
        $this->db->update($this->db->dbprefix.'article',array("status"=>$status),array("id"=>$id));
        return true;
    }

    function delete_article($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "delete from {$this->db->dbprefix}article where id= $id";
        return $this->db->query($sql);
    }

    function set_article_insert($arr)
    {
        if( count($arr)==0 )
			return false;
		if($this->db->insert('article', $arr))
            return $this->db->insert_id();
        else
            return false;
    }

    function is_valid_article($id)
    {
		$sql = sprintf("SELECT * FROM %sarticle where id = '%s' ", $this->db->dbprefix, $id);
		$query = $this->db->query($sql);
		if($query->num_rows()==0)
			return false;
		else
			return true;
	}

    function set_article_update($arr,$id)
    {
        if( count($arr)==0 || !$id || !is_numeric($id) || $id=='' || $id<1)
			return false;

		if(!$this->is_valid_article($id))
            return false;
		if($this->db->update('article', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }
    
	function delete_image($id) 
	{
        if(!$id || !is_numeric($id))
            return false;
        if($this->db->update('article', array('img'=>''), array('id'=>$id)))
        	return true;
        return false;		
	}
}