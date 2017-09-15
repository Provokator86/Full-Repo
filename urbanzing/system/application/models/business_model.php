<?php
class Business_model extends My_model
{
  public $business_status = array(0=>'Pending',
  									1=> 'Approved',
									2 => 'Not Approved',
									3 => 'Claim Pending',
									4 => 'Claimed');

  public function __construct()
    {
		parent::__construct();
	}	
	
    function is_claimed_proper($business_id,$user_id,$code)
    {
        if(!isset($business_id) || $business_id<1 || !isset($user_id) || $user_id<1 || !isset($code) || $code=='')
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}business_claimed 
                        WHERE business_id=$business_id AND cr_by=$user_id AND verification_code='$code' AND verified='0'";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        if(isset ($result_arr) && isset ($result_arr[0]))
            return $result_arr[0]['id'];
        return false;
    }
	

	 function get_claimed_business_list($toshow=-1,$page=0,$user_id=-1,$order_by='b.cr_date',$order_type='DESC')
     {
        $limit		= "";
        $sql    = "SELECT b.* FROM {$this->db->dbprefix}business b 
                    INNER JOIN {$this->db->dbprefix}business_claimed c ON b.id=c.business_id
                    WHERE c.cr_by=$user_id AND c.verified='0'";
        if($toshow>0)
        {
            $page=$page*$toshow;
        	$limit	= ' LIMIT '.$page.','.$toshow;
        }
        $sql    .= ' ORDER BY '.$order_by.' '.$order_type.$limit;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        foreach($result_arr as $k=>$v)
        {
            $tmp    = $this->get_business_review_avg($v['id']);
            if(isset($tmp))
            {
                $result_arr[$k]['review_avg']   = $tmp[0]['avg'];
                $result_arr[$k]['review_tot']   = $tmp[0]['tot'];
            }

            $tmp    = $this->get_business_cover_image($v['id']);
            if($tmp)
                $result_arr[$k]['cover_image']   = $tmp;
            else
                $result_arr[$k]['cover_image']   = false;

            $tmp    = $this->get_business_cuisine($v['id']);
            $result_arr[$k]['all_cuisine']   = $tmp;
        }
        return $result_arr;
    }
	
    function get_claimed_business_list_count($user_id=-1)
    {
        $sql    = "SELECT b.* FROM {$this->db->dbprefix}business b
                    INNER JOIN {$this->db->dbprefix}business_claimed c ON b.id=c.business_id
                    WHERE c.cr_by=$user_id AND c.verified='0'";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }	
    function get_claim_business_list($toshow=-1,$page=0,$condition='',$user_id=-1,$order_by='cr_date',$order_type='DESC')
    {
        $limit		= "";
        $sql    = "SELECT * FROM
                    (SELECT b.*,c.cr_by c_cr_by FROM {$this->db->dbprefix}business b
                      LEFT JOIN {$this->db->dbprefix}business_claimed  c ON b.id=c.business_id AND c.cr_by=$user_id
                      WHERE 1 $condition
                    GROUP BY b.id) aa WHERE ISNULL(aa.c_cr_by)";
        if($toshow>0)
        {
            $page=$page*$toshow;
        	$limit	= ' LIMIT '.$page.','.$toshow;
        }
        $sql    .= ' ORDER BY '.$order_by.' '.$order_type.$limit;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        foreach($result_arr as $k=>$v)
        {
            $tmp    = $this->get_business_review_avg($v['id']);
            if(isset($tmp))
            {
                $result_arr[$k]['review_avg']   = $tmp[0]['avg'];
                $result_arr[$k]['review_tot']   = $tmp[0]['tot'];
            }
            
            $tmp    = $this->get_business_cover_image($v['id']);
            if($tmp)
                $result_arr[$k]['cover_image']   = $tmp;
            else
                $result_arr[$k]['cover_image']   = false;
            
            $tmp    = $this->get_business_cuisine($v['id']);
            $result_arr[$k]['all_cuisine']   = $tmp;
        }
        return $result_arr;
    }
    
    function get_claim_business_list_count($condition='',$user_id=-1)
    {
        $sql    = "SELECT * FROM
                    (SELECT b.*,c.cr_by c_cr_by FROM {$this->db->dbprefix}business b
                      LEFT JOIN {$this->db->dbprefix}business_claimed  c ON b.id=c.business_id AND c.cr_by=$user_id
                      WHERE 1 $condition
                    GROUP BY b.id) aa WHERE ISNULL(aa.c_cr_by)";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	
    function get_business_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {
		$CI = get_instance();
		$CI->load->model('users_model');
		$CI->load->model('category_model');
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['business_type_id']) && $arr['business_type_id']!='')
			$subcond	.= " and business_type_id='{$arr['business_type_id']}' ";	
		if(isset($arr['business_category']) && $arr['business_category']!='' && $arr['business_category']!=-1)
			$subcond	.= " and business_category='{$arr['business_category']}' ";	
			
		if(isset($arr['name']) && $arr['name']!='')
			$subcond	.= " and name LIKE '%{$arr['name']}%' ";
		if(isset($arr['name_back_wildcard']) && $arr['name_back_wildcard']!='')
			$subcond	.= " and name LIKE '{$arr['name_back_wildcard']}%' ";
			
		if(isset($arr['business_name']) && $arr['business_name']!='')
			$subcond	.= " and name = '{$arr['business_name']}' ";
			
		if(isset($arr['featured']) && $arr['featured']!='' && $arr['featured']!=-1)
			$subcond	.= " and is_featured='{$arr['featured']}' ";	
		if(isset($arr['other_cuisine']) && $arr['other_cuisine']!='')
			$subcond	.= " and other_cuisine LIKE '%{$arr['other_cuisine']}%' ";			
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}business 
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
		$result = $query->result_array();
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$arr = array('id'=>$value['business_owner_id']);
				$result[$key]['owner'] = $CI->users_model->get_user_list(1,0,$arr);
				$result[$key]['cuisine'] = $CI->business_model->get_business_cuisine($value['id']);
				$sql    = "SELECT * FROM {$this->db->dbprefix}business_picture WHERE business_id={$value['id']} AND cover_picture='Y'";
                $query1 = $this->db->query($sql);
                $result1 = $query1->result_array();
                if(isset($result1) && isset($result1[0]))
                $result[$key]['cover_image']  = $result1[0]['img_name'];
				$result[$key]['claim'] = count($this->business_claim_list($value['id']));
				$result[$key]['business_category_name'] = $CI->category_model->get_category_list(1,0,$value['business_category']);;
			}
		
		}
		return $result;
	}	

	/**
	 *
	 * @param array $arr
	 * @return array
	 *
	 * @author Rubel Debnath
	 * @author Arnab
	 */
    function get_business_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['name']) && $arr['name']!='')
			$subcond	.= " and name LIKE '%{$arr['name']}%' ";
		if(isset($arr['business_type_id']) && $arr['business_type_id']!='')
			$subcond	.= " and business_type_id='{$arr['business_type_id']}' ";
		if(isset($arr['business_category']) && $arr['business_category']!='' && $arr['business_category']!= -1)
			$subcond	.= " and business_category='{$arr['business_category']}' ";	
		if(isset($arr['business']) && $arr['business']!='')
			$subcond	.= " and business LIKE '%{$arr['business']}%' ";
		if(isset($arr['business_name']) && $arr['business_name']!='')
			$subcond	.= " and name = '{$arr['business_name']}' ";
		if(isset($arr['featured']) && $arr['featured']!='' && $arr['featured']!=-1)
			$subcond	.= " and is_featured='{$arr['featured']}' ";	
		if(isset($arr['other_cuisine']) && $arr['other_cuisine']!='')
			$subcond	.= " and other_cuisine LIKE '%{$arr['other_cuisine']}%' ";					
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";	
		if(isset($arr['cr_by']) && $arr['cr_by']!='')
			$subcond	.= " and cr_by='{$arr['cr_by']}' ";						
			
         $sql		= " select *
						from {$this->db->dbprefix}business 
						";

         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }
	
	function business_claim_list($business_id=-1)
	{
		if($business_id=='' || $business_id== -1)
		  return false;
		
		$CI = get_instance();
		$CI->load->model('users_model');
		$limit		= "";

		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and cl.id='{$arr['id']}' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and cl.status='{$arr['status']}' ";					
		$sql		= " select cl.*, bu.name
						from {$this->db->dbprefix}business_claimed cl
						INNER JOIN {$this->db->dbprefix}business bu
						ON cl.business_id = bu.id WHERE cl.business_id = {$business_id}
						$subcond
						order by cr_date desc
							";

	//echo $sql;
	
		$query = $this->db->query($sql);
		$result = $query->result_array();
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$arr = array('id'=>$value['cr_by']);
				$result[$key]['claim_by'] = $CI->users_model->get_user_list(1,0,$arr);
			}
		
		}
		return $result;
			
	}
	
	function get_home_page_image_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
	{
		$CI = get_instance();
		$CI->load->model('location_model');
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}home_page_image 
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
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$arr = array('id'=>$value['region_id']);
				$result[$key]['region'] = $CI->location_model->get_region_list(1,0,$arr);
			}
		}
		return $result;
	
	}
	
    function get_home_page_image_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
			
         $sql		= " select *
						from {$this->db->dbprefix}home_page_image 
						";
         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }
		
	function change_data_claim_status($tablename,$id,$status)
    {
		//echo $tablename.'===='.$id.'===='.$status;
        /*if(!$id || !is_numeric($id))
            return false;*/
        $status      = 1-$status;
		
        if(!$id || $id=='' || !is_numeric($id))
            return false;
			$sql	= "UPDATE ".$this->db->dbprefix.$tablename." SET verified='$status' WHERE id=$id";
			$this->db->query($sql);
        return true;
    }		
		
	function get_business_claim_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='desc')
	{
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['business_id']) && $arr['business_id']!='')
			$subcond	.= " and business_id='{$arr['business_id']}' ";
		if(isset($arr['verified']) && $arr['verified']!='' && $arr['verified']!=-1)
			$subcond	.= " and verified='{$arr['verified']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}business_claimed 
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
		$result = $query->result_array();
		return $result;
		
	}
	

	
	/*  Functions creted by rubel   */
	
    function get_business_user_profile($toshow=-1,$page=0,$arr=array(),$order_by='cr_date',$order_type='DESC')
    {
        $limit		= "";
        $subcond	= " where 1 ";
        if(isset($arr['id']) && $arr['id']!='')
            $subcond	.= " and b.id='{$arr['id']}' ";
        if(isset($arr['business']) && $arr['business']!='')
            $subcond	.= " and b.name LIKE '%{$arr['business']}%' ";
        if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
            $subcond	.= " and b.status='{$arr['status']}' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $subcond .= $arr['ext_cond'];
        $sql    = "SELECT b.*,c.name city_name,z.zipcode zipcode_code,r.region region_name, z.place zipcode_place
                    FROM {$this->db->dbprefix}business b INNER JOIN {$this->db->dbprefix}city c ON c.id=b.city_id
                    INNER JOIN {$this->db->dbprefix}zipcode z ON z.id=b.zipcode
                    INNER JOIN {$this->db->dbprefix}region r ON r.id=b.region_id
                    ";
        if($toshow>0)
        {
            $page=$page*$toshow;
        	$limit	= ' LIMIT '.$page.','.$toshow;
        }
        $sql    .= $subcond.' ORDER BY '.$order_by.' '.$order_type.$limit;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        foreach($result_arr as $k=>$v)
        {
            $tmp    = $this->get_business_review_avg($v['id']);
            if(isset($tmp))
            {
                $result_arr[$k]['review_avg']   = $tmp[0]['avg'];
                $result_arr[$k]['review_tot']   = $tmp[0]['tot'];
            }
            $tmp    = $this->get_user_business_claim($v['id'],$this->session->userdata('user_id'));
            if(isset($tmp) && $tmp>0)
                $result_arr[$k]['my_claim']   = true;
            else
                $result_arr[$k]['my_claim']   = false;

        }
        return $result_arr;
    }

    function get_business_review_avg($business_id)
    {
        if(!isset($business_id))
            return false;
        $sql    = "SELECT CEIL(SUM(star_rating)/COUNT(id)) avg,COUNT(id) tot FROM {$this->db->dbprefix}business_reviews WHERE business_id=$business_id GROUP BY business_id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    function get_business_user_profile_count($arr=array())
    {
        $subcond	= " where 1 ";
        if(isset($arr['id']) && $arr['id']!='')
            $subcond	.= " and b.id='{$arr['id']}' ";
        if(isset($arr['business']) && $arr['business']!='')
            $subcond	.= " and b.name LIKE '%{$arr['business']}%' ";
        if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
            $subcond	.= " and b.status='{$arr['status']}' ";
        if(isset($arr['ext_cond']) && $arr['ext_cond']!='')
            $subcond .= $arr['ext_cond'];
        $sql    = "SELECT b.*,c.name city_name,z.zipcode zipcode_code,r.region region_name
                    FROM {$this->db->dbprefix}business b INNER JOIN {$this->db->dbprefix}city c ON c.id=b.city_id
                    INNER JOIN {$this->db->dbprefix}zipcode z ON z.id=b.zipcode
                    INNER JOIN {$this->db->dbprefix}region r ON r.id=b.region_id
                    ";
        $sql    .= $subcond;
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
	
	function get_business_cuisine($business_id=-1,$toshaow=2)
    {
        if(!isset($business_id) || $business_id<1)
            return false;
        $sql    = "SELECT c.cuisine FROM {$this->db->dbprefix}cuisine c
                    INNER JOIN {$this->db->dbprefix}business_cuisine b ON c.id=b.cuisine_id
                    WHERE b.business_id=$business_id LIMIT $toshaow";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        $txt    = '';
        if($result_arr)
        {
            foreach($result_arr as $k=>$v)
                $txt    .= ' '.$v['cuisine'].',';
            $txt    = substr($txt, 0,strlen($txt)-1);
        }
        return $txt;
    }
	
    function get_business_cover_image($business_id=-1)
    {
        if(!isset($business_id) || $business_id<1)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}business_picture WHERE business_id=$business_id AND cover_picture='Y'";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr[0]['img_name'];
    }	
	
    function get_user_business_claim($business_id,$user_id)
    {
        if(!isset($business_id) || !isset($user_id))
            return false;
        $sql    = "SELECT id FROM {$this->db->dbprefix}business_claimed WHERE cr_by='$user_id' AND business_id='$business_id' ";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }      
	
	function claim_my_business_final($business_id)
	{
		if(!isset($business_id) || $business_id<1)
            return	array('Your have to select a business..','err');
			
        $user_id    = $this->session->userdata('user_id');
        $iscalimed  = $this->get_user_business_claim($business_id,$user_id);
        if($iscalimed>0)
            return	array('Your have already claimed this business..','err');
        $arr= array("business_id"=>$business_id,
                    "verification_code"=>$this->get_unique_rendomcode('business_claimed','verification_code','',8),
                    "verified"=>'0',
                    "cr_by"=>$user_id,
                    "cr_date"=>time()
                    );
        $this->set_data_insert('business_claimed',$arr);
		$CI = &get_instance();
		$CI->load->model('site_settings_model');
		$CI->load->model('automail_model');

		$admin_mail = $CI->site_settings_model->get_site_settings('admin_email');
		$mail_type = 'business_claim_admin';
		$CI->automail_model->send_business_claim_mail($admin_mail,$mail_type,$business_id);
        return array('Your request has been submitted. For your security you will be given full access to this business after admin verification.','succ');
	}
	
	function get_business_image_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {
        $limit		= "";
		$subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='' && $arr['business_id']>0)
            $subcond    .= " AND business_id={$arr['business_id']}";
        if(isset($arr['name']) && $arr['name']!='')
            $subcond	.= " and b.name LIKE '%{$arr['name']}%' ";	
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and pic.status='{$arr['status']}'";					
			
        if($arr['cover_picture']=='Y')
            $subcond    .= " AND cover_picture='Y' ";
        else
            $subcond    .= " AND cover_picture='N' ";
        //$sql    = "SELECT * FROM {$this->db->dbprefix}business_picture $subcond";
		
		$sql    = " SELECT pic.*, b.name
		 				FROM {$this->db->dbprefix}business_picture pic
						INNER JOIN {$this->db->dbprefix}business b
						ON b.id = pic.business_id 
						$subcond order by $order_by $order_type";
		if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		$sql .= $limit; 

		
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }
	
    function get_business_image_list_count($arr=array())
    {
       $subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='' && $arr['business_id']>0)
            $subcond    .= " AND business_id={$arr['business_id']}";
        if(isset($arr['name']) && $arr['name']!='')
            $subcond	.= " and b.name LIKE '%{$arr['name']}%' ";	
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and pic.status='{$arr['status']}' ";					
        if($arr['cover_picture']=='Y')
            $subcond    .= " AND cover_picture='Y' ";
        else
            $subcond    .= " AND cover_picture='N' ";
			
         $sql		= " SELECT pic.*, b.name
		 				FROM {$this->db->dbprefix}business_picture pic
						INNER JOIN {$this->db->dbprefix}business b
						ON b.id = pic.business_id";
						

        $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	
	  
	function get_business_coupon_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {
        $limit		= "";
		$subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='' && $arr['business_id']>0)
            $subcond    .= " AND business_id={$arr['business_id']}";
        if(isset($arr['name']) && $arr['name']!='')
            $subcond	.= " and b.name LIKE '%{$arr['name']}%' ";	
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and pic.status='{$arr['status']}' ";					
        //$sql    = "SELECT * FROM {$this->db->dbprefix}business_picture $subcond";
		
		$sql    = " SELECT pic.*, b.name, u.f_name
		 				FROM {$this->db->dbprefix}request_for_coupon pic
						INNER JOIN {$this->db->dbprefix}business b
						ON b.id = pic.business_id 
						INNER JOIN {$this->db->dbprefix}users u
						ON u.id = pic.cr_by
						$subcond order by $order_by $order_type";
		if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		$sql .= $limit; 

		
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }
	
    function get_business_coupon_list_count($arr=array())
    {
       $subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='' && $arr['business_id']>0)
            $subcond    .= " AND business_id={$arr['business_id']}";
        if(isset($arr['name']) && $arr['name']!='')
            $subcond	.= " and b.name LIKE '%{$arr['name']}%' ";	
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and pic.status='{$arr['status']}' ";					

			
         $sql		= " SELECT pic.*, b.name, u.f_name
		 				FROM {$this->db->dbprefix}request_for_coupon pic
						INNER JOIN {$this->db->dbprefix}business b
						ON b.id = pic.business_id 
						INNER JOIN {$this->db->dbprefix}users u
						ON u.id = pic.cr_by ";
						

        $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	   
	   
	function get_business_correction_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {
        $limit		= "";
		$subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='' && $arr['business_id']>0)
            $subcond    .= " AND business_id={$arr['business_id']}";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and pic.status='{$arr['status']}' ";					
        //$sql    = "SELECT * FROM {$this->db->dbprefix}business_picture $subcond";
		
		$sql    = " SELECT pic.*, b.name, u.f_name
		 				FROM {$this->db->dbprefix}business_correction pic
						INNER JOIN {$this->db->dbprefix}business b
						ON b.id = pic.business_id 
						INNER JOIN {$this->db->dbprefix}users u
						ON u.id = pic.cr_by
						$subcond order by $order_by $order_type";
		if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		$sql .= $limit; 

		
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }
	
    function get_business_correction_list_count($arr=array())
    {
       $subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='' && $arr['business_id']>0)
            $subcond    .= " AND business_id={$arr['business_id']}";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and pic.status='{$arr['status']}' ";					

			
         $sql		= "SELECT pic.*, b.name, u.f_name
		 				FROM {$this->db->dbprefix}business_correction pic
						INNER JOIN {$this->db->dbprefix}business b
						ON b.id = pic.business_id 
						INNER JOIN {$this->db->dbprefix}users u 
						ON u.id = pic.cr_by
						";
						

        $sql    .= $subcond;

        $query = $this->db->query($sql);
	return $query->num_rows();
    }

    /**
     *
     
     * @param Author Purnendu
      
     */


    function get_business_review_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {
            
        // table : urban_business, urban_business_reviews, urban_users
       //var_dump($arr); // [search text] and [category id ]
       
        $sql = "SELECT R.review_title, U.name, R.id, W.f_name, R.comment, R.cr_date
                FROM urban_business U, urban_business_reviews R, urban_users W
                WHERE U.id = R.business_id
                AND W.id = R.user_id";
               
                $limit		= "";
		$subcond	= "";
		if(isset($arr['name']) && $arr['name']!='')
			$subcond	.= " and  ( R.review_title LIKE '%{$arr['name']}%' OR R.comment LIKE '%{$arr['name']}%' ) ";
		
		if(isset($arr['business_category']) && $arr['business_category']!='' && $arr['business_category']!=-1)
			$subcond	.= " and U.business_category='{$arr['business_category']}' ";

                $sql.=$subcond;
                if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		$sql .= $limit;
               
                $query = $this->db->query($sql);
		$result_arr = $query->result_array();

                /*echo "<pre>";
                    print_r($result_arr);
                echo "</pre>";*/
                return $result_arr;

	}



    function get_business_review_list_count($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
    {

         // table : urban_business, urban_business_reviews, urban_users
       //var_dump($arr); // [search text] and [category id ]

        $sql = "SELECT R.review_title, U.name, W.f_name, R.comment, R.cr_date
                FROM urban_business U, urban_business_reviews R, urban_users W
                WHERE U.id = R.business_id
                AND W.id = R.user_id";

                $limit		= "";
		$subcond	= "";
		if(isset($arr['name']) && $arr['name']!='')
			$subcond	.= " and  ( R.review_title LIKE '%{$arr['name']}%' OR R.comment LIKE '%{$arr['name']}%' ) ";

		if(isset($arr['business_category']) && $arr['business_category']!='' && $arr['business_category']!=-1)
			$subcond	.= " and U.business_category='{$arr['business_category']}' ";

                 $sql.=$subcond;
         if($toshow>0)
		{
			$limit	= " limit $page,$toshow ";
		}
		

                $query = $this->db->query($sql);
		return $query->num_rows();

	}

        function get_review($id)
        {

            $sql = sprintf("SELECT comment FROM {$this->db->dbprefix}business_reviews WHERE id = %s",$id);
            $query = $this->db->query($sql);
            $result_arr = $query->result_array();
            return $result_arr[0]['comment'];

        }

		function get_business_added_by_user($user_id)
		{
			$sql = "SELECT * FROM {$this->db->dbprefix}business b
					WHERE b.cr_by = {$user_id} AND status = '1' ";
			$result = $this->db->query($sql);
			$result_arr = $result->result_array();
			return $result_arr;
		}

		function get_business_image($business_id )
		{
			$sql = "SELECT img_name FROM {$this->db->dbprefix}business_picture bp
					WHERE bp.business_id = {$business_id} AND bp.cover_picture = 'Y'";
			$result = $this->db->query($sql);
			$result_arr = $result->result_array();
			return $result_arr;


		}
		
	function get_auto_complete_business_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='asc')
     {
  $limit  = "";
  $subcond = " where 1 AND status='1'";
  if(isset($arr['id']) && $arr['id']!='')
   $subcond .= " and id='{$arr['id']}' ";
  if(isset($arr['business_type_id']) && !empty($arr['business_type_id']))
   $subcond .= " and business_type_id={$arr['business_type_id']}"; 
  if(isset($arr['business_category']) && $arr['business_category']!='' && $arr['business_category']!=-1)
   $subcond .= " and business_category='{$arr['business_category']}' "; 
   
  if(isset($arr['name']) && $arr['name']!='')
   $subcond .= " and name LIKE '%{$arr['name']}%' ";
  if(isset($arr['name_back_wildcard']) && $arr['name_back_wildcard']!='')
   $subcond .= " and name LIKE '{$arr['name_back_wildcard']}%' ";
   
  if(isset($arr['business_name']) && $arr['business_name']!='')
   $subcond .= " and name = '{$arr['business_name']}' ";
   
  if(isset($arr['featured']) && $arr['featured']!='' && $arr['featured']!=-1)
   $subcond .= " and is_featured='{$arr['featured']}' "; 
  if(isset($arr['other_cuisine']) && $arr['other_cuisine']!='')
   $subcond .= " and other_cuisine LIKE '%{$arr['other_cuisine']}%' ";   
  if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
   $subcond .= " and status='{$arr['status']}' ";  
      
  $sql  = " select distinct name
      from {$this->db->dbprefix}business 
      $subcond
      order by $order_by $order_type
       ";
  if($toshow>0)
  {
   $limit = " limit $page,$toshow ";
  }
  $sql .= $limit; 
  
 //echo $sql;
 
  $query = $this->db->query($sql);
  $result = $query->result_array();
  return $result;
 }
		
		
		

}