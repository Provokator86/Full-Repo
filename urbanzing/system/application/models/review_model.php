<?php
class Review_model extends My_model
{
   public function __construct()
    {
        parent::__construct();
    }

    function set_business_review_update($business_id)
    {
       
		if(!isset($business_id) || $business_id=='' || $business_id<1)
            return false;
        global $CI;
        $CI->load->model('business_model');
        $tmp    = $CI->business_model->get_business_review_avg($business_id);
        if(isset($tmp))
        {
            $sql    = "UPDATE {$this->db->dbprefix}business
                SET avg_review='{$tmp[0]['avg']}',tot_review='{$tmp[0]['tot']}'
                WHERE id='$business_id'
                ";
                $this->db->query($sql);
        }
    }

    
	/**
	*added ...count_like, no_of_times_reported part (subquery ) if( $this->session->userdata('user_id') != '') added
	*Purnendu shaw
	* old one is kept by name get_review_detail_old
	*/
	function get_review_detail($toshow=-1,$page=0,$arr=array(),$order_by='br.cr_date',$order_type='DESC')
    {
        
		
		$limit		= "";
        $subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='')
            $subcond	.= " and br.business_id='{$arr['business_id']}' ";
        if(isset($arr['text']) && $arr['text']!='')
            $subcond	.= " and br.comment LIKE '%{$arr['text']}%' ";
		//these subconditions is newly written by purnendu (17.11.2010 )
		if(isset($arr['review_id']) && $arr['review_id']!='')
            $subcond	.= " and br.id = '{$arr['review_id']}' ";
		if(isset($arr['user_id']) && $arr['user_id']!='')
            $subcond	.= " and br.cr_by = '{$arr['user_id']}' ";
		if(isset($arr['search_text']) && $arr['search_text']!='')
            $subcond	.= " and br.comment LIKE  '%{$arr['search_text']}%' ";	
		if( $this->session->userdata('user_id') != '') 
        {
		$sql    = "SELECT br.*,b.name b_name, u.screen_name, ct.name ct_name, c.name c_name,
                    u.img_name u_img, u.f_name,u.l_name, u.email ,(SELECT COUNT(*)  FROM {$this->db->dbprefix}business_review_like l WHERE l.review_id = br.id AND status = 1) count_like , (SELECT COUNT(*)  FROM {$this->db->dbprefix}business_review_rating brr WHERE brr.review_id = br.id AND brr.cr_by = {$this->session->userdata('user_id')}) no_of_times_reported
                    FROM {$this->db->dbprefix}business_reviews br
                    INNER JOIN {$this->db->dbprefix}business b ON b.id=br.business_id
                    INNER JOIN {$this->db->dbprefix}users u ON u.id=br.user_id
                    LEFT JOIN {$this->db->dbprefix}city ct ON u.city_id=ct.id
                    LEFT JOIN {$this->db->dbprefix}country c ON u.country_id=c.id
                    $subcond
                    order by $order_by $order_type
                    ";
		}
		else
		{
		 $sql    = "SELECT br.*,b.name b_name, u.screen_name, ct.name ct_name, c.name c_name,
                    u.img_name u_img, u.f_name,u.l_name, u.email , (SELECT COUNT(*)  FROM {$this->db->dbprefix}business_review_like l WHERE l.review_id = br.id AND status = 1) count_like
                    FROM {$this->db->dbprefix}business_reviews br
                    INNER JOIN {$this->db->dbprefix}business b ON b.id=br.business_id
                    INNER JOIN {$this->db->dbprefix}users u ON u.id=br.user_id
                    LEFT JOIN {$this->db->dbprefix}city ct ON u.city_id=ct.id
                    LEFT JOIN {$this->db->dbprefix}country c ON u.country_id=c.id
                    $subcond
                    order by $order_by $order_type
                    ";
		
		}			
		//echo $sql;exit;
        $query1 = $this->db->query($sql);
        if($toshow>0)
        {
            $page=$page*$toshow;
            $limit	= " limit $page,$toshow ";
        }
        $sql .= $limit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $result['0']['tot_row'] = $query1->num_rows();
        foreach($result as $k=>$v)
        {
            /*$tmp    = $this->get_review_avg($v['id']);
            if(isset($tmp))
            {
                $result[$k]['review_avg']   = $tmp[0]['avg'];
                $result[$k]['review_tot']   = $tmp[0]['tot'];
            }*/
            $tmp    = $this->get_review_like($v['id'],$this->session->userdata('user_id'));
            if(isset($tmp))
            {
                $result[$k]['review_like']   = $tmp[0]['status'];
            }
        }
        return $result;
    }

    
	
	function get_review_detail_old($toshow=-1,$page=0,$arr=array(),$order_by='br.cr_date',$order_type='DESC')
    {
        $limit		= "";
        $subcond	= " where 1 ";
        if(isset($arr['business_id']) && $arr['business_id']!='')
            $subcond	.= " and br.business_id='{$arr['business_id']}' ";
        if(isset($arr['text']) && $arr['text']!='')
            $subcond	.= " and br.comment LIKE '%{$arr['text']}%' ";
		//this subcondition is newly written by purnendu (17.11.2010 )
		if(isset($arr['review_id']) && $arr['review_id']!='')
            $subcond	.= " and br.id = '{$arr['review_id']}' ";
		if(isset($arr['user_id']) && $arr['user_id']!='')
            $subcond	.= " and br.cr_by = '{$arr['user_id']}' ";
		if( $this->session->userdata('user_id') != '')
        {
		$sql    = "SELECT br.*,b.name b_name, u.screen_name, ct.name ct_name, c.name c_name,
                    u.img_name u_img, u.f_name,u.l_name, (SELECT COUNT(*)  FROM {$this->db->dbprefix}business_review_like l WHERE l.review_id = br.id AND status = 1) count_like , (SELECT COUNT(*)  FROM {$this->db->dbprefix}business_review_rating brr WHERE brr.review_id = br.id AND brr.cr_by = {$this->session->userdata('user_id')}) no_of_times_reported
                    FROM {$this->db->dbprefix}business_reviews br
                    INNER JOIN {$this->db->dbprefix}business b ON b.id=br.business_id
                    INNER JOIN {$this->db->dbprefix}users u ON u.id=br.user_id
                    LEFT JOIN {$this->db->dbprefix}city ct ON u.city_id=ct.id
                    LEFT JOIN {$this->db->dbprefix}country c ON u.country_id=c.id
                    $subcond
                    order by $order_by $order_type
                    ";
		}
		else
		{
		 $sql    = "SELECT br.*,b.name b_name, u.screen_name, ct.name ct_name, c.name c_name,
                    u.img_name u_img, u.f_name,u.l_name, (SELECT COUNT(*)  FROM {$this->db->dbprefix}business_review_like l WHERE l.review_id = br.id AND status = 1) count_like
                    FROM {$this->db->dbprefix}business_reviews br
                    INNER JOIN {$this->db->dbprefix}business b ON b.id=br.business_id
                    INNER JOIN {$this->db->dbprefix}users u ON u.id=br.user_id
                    LEFT JOIN {$this->db->dbprefix}city ct ON u.city_id=ct.id
                    LEFT JOIN {$this->db->dbprefix}country c ON u.country_id=c.id
                    $subcond
                    order by $order_by $order_type
                    ";

		}
		//echo $sql;exit;
        $query1 = $this->db->query($sql);
        if($toshow>0)
        {
            $page=$page*$toshow;
            $limit	= " limit $page,$toshow ";
        }
        $sql .= $limit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $result['0']['tot_row'] = $query1->num_rows();
        foreach($result as $k=>$v)
        {
            /*$tmp    = $this->get_review_avg($v['id']);
            if(isset($tmp))
            {
                $result[$k]['review_avg']   = $tmp[0]['avg'];
                $result[$k]['review_tot']   = $tmp[0]['tot'];
            }*/
            $tmp    = $this->get_review_like($v['id'],$this->session->userdata('user_id'));
            if(isset($tmp))
            {
                $result[$k]['review_like']   = $tmp[0]['status'];
            }
        }
        return $result;
    }
	
	
	function get_review_detail_business($user_id)
    {
        if(!isset($user_id) || $user_id<1)
            return false;
        $sql    = "SELECT br.*,b.name b_name, ct.name ct_name, c.name c_name,bp.img_name
                    FROM {$this->db->dbprefix}business_reviews br
                    INNER JOIN {$this->db->dbprefix}business b ON b.id=br.business_id
                    LEFT JOIN {$this->db->dbprefix}city ct ON b.city_id=ct.id
                    LEFT JOIN {$this->db->dbprefix}country c ON b.country_id=c.id
                    LEFT JOIN {$this->db->dbprefix}business_picture bp ON b.id=bp.business_id AND bp.cover_picture='Y'
                    WHERE br.cr_by=$user_id
                    GROUP BY br.id
                    order by br.id DESC
                    ";

		if($toshow>0)
        {
            $page=$page*$toshow;
            $limit	= " limit $page,$toshow ";
        }
        $sql .= $limit;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        /*foreach($result as $k=>$v)
        {
            $tmp    = $this->get_review_avg($v['id']);
            if(isset($tmp))
            {
                $result[$k]['review_avg']   = $tmp[0]['avg'];
                $result[$k]['review_tot']   = $tmp[0]['tot'];
            }
        }*/
        return $result;
    }

//    function get_revier

    function get_review_avg($review_id)
    {
        if(!isset($review_id))
            return false;
        $sql    = "SELECT CEIL(SUM(rating)/COUNT(id)) avg,COUNT(id) tot FROM {$this->db->dbprefix}business_review_rating WHERE review_id=$review_id GROUP BY review_id";
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }

    function get_business_first_review($business_id)
    {
        $sql = "SELECT u.screen_name, u.f_name, u.l_name, u.id, u.img_name
				FROM {$this->db->dbprefix}business_reviews br
				INNER JOIN {$this->db->dbprefix}users u ON u.id = br.user_id
				WHERE br.business_id = $business_id
				order by br.cr_date ASC LIMIT 0, 1";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function get_review_like($review_id,$user_id)
    {
        if(!isset($user_id) || $user_id<1 || !isset($review_id) || $review_id<1)
            return false;
        $sql    = "SELECT * FROM {$this->db->dbprefix}business_review_like WHERE cr_by=$user_id AND review_id=$review_id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function set_review_like_status($review_id,$user_id)
    {
        if(!isset($user_id) || $user_id<1 || !isset($review_id) || $review_id<1)
            return false;
        $result = $this->get_review_like($review_id,$user_id);
        $msg    = '';
        if(isset($result) && count($result)>0 && count($result[0])>0)
        {
            $cond   = array('review_id'=>$review_id,
                    'cr_by'=>$user_id);
            if($result[0]['status']==1)
            {
                $arr    = array('status'=>'0');
                $msg    = 'Like this';
            }
            else
            {
                $arr    = array('status'=>'1');
                $msg    = 'Dislike this';
            }
            $this->set_data_update('business_review_like',$arr,$cond);
        }
        else
        {
            $arr    = array('review_id'=>$review_id,
                            'cr_by'=>$user_id,
                            'status'=>1);
            $this->set_data_insert('business_review_like',$arr);
            $msg    = 'Dislike this';
        }
        return $msg;
    }

	/**
	 *
	 * Purnendu
	 */
	function get_review($review_id)
	{
		$sql = sprintf("SELECT R.comment, R.review_title,R.star_rating,R.user_id, B.name,R.id,R.business_id
							FROM urban_business_reviews R, urban_business B
							WHERE R.id = '%s' AND  R.business_id = B.id",
						$review_id );
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
	}


	function save_updated_review($review_id,$review_title,$review_comment,$star_rating)
	{
		$sql = sprintf("UPDATE {$this->db->dbprefix}business_reviews SET review_title = '%s' , comment = '%s',star_rating = %s WHERE id = %s", $review_title,$review_comment ,$star_rating,$review_id  );
		$this->db->query($sql);

	}

	function delete_review($business_review_id)
	{
		$sql = sprintf("DELETE FROM {$this->db->dbprefix}business_reviews WHERE id = %s",$business_review_id);
		$query = $this->db->query($sql);

	}


}


			