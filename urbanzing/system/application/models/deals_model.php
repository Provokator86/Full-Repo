<?php
class Deals_model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
    * function to get deals category option list
    * 
    * @param int $id
    */
    public function get_deals_category_option($id = -1)
    {
        $this->db->select('id, cat_name');
        $this->db->where('status', '1');
        $ret_ = $this->db->get('deals_category');
        $arr_cat = $ret_->result_array();
        $html = '';
        
        if($ret_->num_rows()>0)
        {   
            foreach($arr_cat as $cat)
            {
                $selected   = '';
                if($id==$cat['id'])
                    $selected   = 'selected';
                $html   .= '<option value="'.$cat['id'].'" '.$selected.'>'.$cat['cat_name'].'</option>';
            }
        }
        
        return $html;
    }
    
    /**
    * function to get the category name by its id
    */
    public function get_deals_category_name()
    {
        $this->db->select('id, cat_name');
        //$this->db->where('stat', $id);
        $ret_ = $this->db->get('deals_category');
        $arr_cat = $ret_->result_array();
        $cat_ = array();
        if($ret_->num_rows()>0)
        { 
            foreach($arr_cat as $cat)
            {
                $cat_[$cat['id']] = $cat['cat_name'];
            }
        }
        return $cat_;
    }

    
    /**
    * function to get deals listing...
    * 
    * @param int $toshow
    * @param int $page
    * @param int $id
    * @param string $title
    * @param int $status
    * @param int $category
    * @param string $order_name
    * @param string $order_type
    */
    public function get_deals_list($toshow=-1,$page=0,$id=-1,$title='',$status=-1,$category='',$order_name='deal_start',$order_type='desc')
    {
        $sucond = ' where 1 ';
        $limit='';
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($title!='')
            $sucond .= " and (headline like '%$title%') ";
        if($status!=-1 && is_numeric($status) && $status!='')
            $sucond .= " and status=$status ";
        if($category!='' && $category!=-1)
            $sucond .= " and category_id='$category'";

        $sql    = sprintf("select * from %sdeals ",$this->db->dbprefix);
        if($toshow>0)
			$limit	= ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.' '.$limit;
        $query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr;
    }

    /**
    * function to count the no of list...
    * 
    * @param mixed $id
    * @param mixed $title
    * @param mixed $status
    * @param mixed $category
    */
    public function get_deals_list_count($id=-1,$title='',$status=-1,$category='')
    {
         $sucond = ' where 1 ';
         if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($title!='')
            $sucond .= " and (headline like '%$title%') ";
        if($status!=-1 && is_numeric($status) && $status!='')
            $sucond .= " and status=$status ";
        if($category!='' && $category!=-1)
            $sucond .= " and category_id='$category'";
            
        $sql    = sprintf("select * from %sdeals ",$this->db->dbprefix);

        $sql    .= $sucond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }
    
    
    //required for font end 
    /**
    * function for retrieving the data of current and upcomming deals
    * 
    * @param mixed $toshow
    * @param mixed $page
    * @param mixed $id
    * @param mixed $title
    * @param mixed $status
    * @param mixed $category
    * @param mixed $order_name
    * @param mixed $order_type
    */
    public function get_current_deals_list($toshow=-1,$page=0,$id=-1,$keyword='',$type=-1,$category_id=-1, $location = '',$order_name='deal_start',$order_type='desc')
    {
        // echo '<br />'.$keyword."+++++++".$type."+++++++".$category_id."+++++++".$location."+++++++";
        $sucond = ' WHERE deal_end > '.time().' AND deal_end > deal_start AND deal_start < '.time().'';
        $limit='';
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and d.id=$id ";

        if(!empty($keyword))
        {
            $keyword = addStar($keyword);
            $sucond .= " AND MATCH (headline, deal_description, source_name, fine_prints) AGAINST ('". $keyword ."' IN BOOLEAN MODE)";
        }
            
            //$sucond .= " AND (d.headline like '%$title%') ";

        if($type>0 && is_numeric($type) && $type!='')
        {
            $type = intval($type);
            if($type==2)
                $type = 0;
            $sucond .= " and d.type=$type ";
        }
            

        if($category_id!='' && $category_id!=-1)
            $sucond .= " and d.category_id='$category_id'";
            
        if(!empty($location))
        {
            $sucond .= " AND d.pin IN(SELECT id FROM ".$this->db->dbprefix."zipcode WHERE place LIKE '".$location."')";
        }

        $sql    = sprintf("SELECT d.* , ctry.name AS country, st.name AS state , ct.name AS city, dctry.cat_name AS category
                            FROM %1\$sdeals AS d
                            LEFT JOIN %1\$scountry AS ctry
                            ON ctry.id = d.country_id
                            LEFT JOIN %1\$sstate AS st
                            ON st.id = d.state_id
                            LEFT JOIN %1\$scity AS ct
                            ON ct.id = d.city_id
                            LEFT JOIN %1\$sdeals_category AS dctry
                            ON dctry.id = d.category_id
                            ",$this->db->dbprefix);
        if($toshow>0)
            $limit    = ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.' '.$limit;
        $query = $this->db->query($sql);
        // echo $this->db->last_query();
        if($query->num_rows()>0)
            $result_arr = $query->result_array();
        else
            $result_arr = array();
        return $result_arr;
    }
    
    
    /**
    * function for retrieving the no of current and upcomming deals
    * 
    * @param mixed $id
    * @param mixed $title
    * @param mixed $status
    * @param mixed $category
    */
    public function get_current_deals_list_count($id=-1,$keyword='',$type=-1,$category_id=-1, $location = '')
    {
         $sucond = ' WHERE deal_end > '.time().' AND deal_end > deal_start AND deal_start < '.time().'';
        $limit='';
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and d.id=$id ";

        if(!empty($keyword))
        {
            $keyword = addStar($keyword);
            $sucond .= " AND MATCH (headline, deal_description, source_name, fine_prints) AGAINST ('". $keyword ."' IN BOOLEAN MODE)";
        }
            
            //$sucond .= " AND (d.headline like '%$title%') ";

        if($type>0 && is_numeric($type) && $type!='')
        {
            $type = intval($type);
            if($type==2)
                $type = 0;
            $sucond .= " and d.type=$type ";
        }
            

        if($category_id!='' && $category_id!=-1)
            $sucond .= " and d.category_id='$category_id'";
            
        if(!empty($location))
        {
            $sucond .= " AND d.pin IN(SELECT id FROM ".$this->db->dbprefix."zipcode WHERE place LIKE '".$location."')";
        }
         
        $sql    = sprintf("select * from %sdeals AS d ",$this->db->dbprefix);

        $sql    .= $sucond;

        $query = $this->db->query($sql);
        // echo '<br /><br /><br />'.$this->db->last_query();
        return $query->num_rows();
    }
    
    /*
    not in scope now
    function get_past_deals_list($toshow=-1,$page=0,$id=-1,$title='',$status=-1,$category='',$order_name='deal_start',$order_type='desc')
    {
        $sucond = ' where deal_start < '.time().' AND deal_end > deal_start ';
        $limit='';
        if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($title!='')
            $sucond .= " and (headline like '%$title%') ";
        if($status!=-1 && is_numeric($status) && $status!='')
            $sucond .= " and status=$status ";
        if($category!='' && $category!=-1)
            $sucond .= " and category_id='$category'";

        $sql    = sprintf("select * from %sdeals ",$this->db->dbprefix);
        if($toshow>0)
            $limit    = ' limit '.$page.','.$toshow;
        $sql    .= $sucond.' order by '.$order_name.' '.$order_type.' '.$limit;
        $query = $this->db->query($sql);
        $result_arr = $query->result_array();
        return $result_arr;
    }
    
    function get_past_deals_list_count($id=-1,$title='',$status=-1,$category='')
    {
         $sucond = ' where deal_start < '.time().' AND deal_end > deal_start ';
         if($id!=-1 && is_numeric($id) && $id>0)
            $sucond .= " and id=$id ";
        if($title!='')
            $sucond .= " and (headline like '%$title%') ";
        if($status!=-1 && is_numeric($status) && $status!='')
            $sucond .= " and status=$status ";
        if($category!='' && $category!=-1)
            $sucond .= " and category_id='$category'";
            
        $sql    = sprintf("select * from %sdeals ",$this->db->dbprefix);

        $sql    .= $sucond;

        $query = $this->db->query($sql);
        return $query->num_rows();
    }
    */
    //required for font end 

    /**
    * function to change the status of deal i.e. enebled or disabled
    * 
    * @param mixed $id
    * @param mixed $status
    */
    public function change_deals_status($id,$status)
    {
        if(!$id || !is_numeric($id))
            return false;
        $status      = 1-$status;
        if(!$id || $id=='' || !is_numeric($id))
            return false;
        $this->db->update($this->db->dbprefix.'deals',array("status"=>$status),array("id"=>$id));
        return true;
    }

    /**
    * function to delete a deal from db...
    * 
    * @param mixed $id
    */
    public function delete_deals($id)
    {
        if(!$id || !is_numeric($id))
            return false;
        $sql    = "delete from {$this->db->dbprefix}deals where id= $id";
        return $this->db->query($sql);
    }

    public function set_deals_insert($arr)
    {
        if( count($arr)==0 )
			return false;
		if($this->db->insert('deals', $arr))
            return $this->db->insert_id();
        else
            return false;
    }

    /**
    * function to find wheather a deal is valid i.e. exists, or not.
    * 
    * @param mixed $id
    */
    public function is_valid_deals($id)
    {
        $id = intval($id);
		$sql = sprintf("SELECT * FROM %sdeals where id = '%s' ", $this->db->dbprefix, $id);
		$query = $this->db->query($sql);
		if($query->num_rows()==0)
			return false;
		else
			return true;
	}

    public function set_deals_update($arr,$id)
    {
        if( count($arr)==0 || !$id || !is_numeric($id) || $id=='' || $id<1)
			return false;

		if(!$this->is_valid_deals($id))
            return false;
		if($this->db->update('deals', $arr, array('id'=>$id)))
            return true;
        else
            return false;
    }

    /**
    * function to get location names...
    * 
    * @param string $place
    * @return string HTML
    */
    public function get_location_name_options($place)
    {
        $sql = "SELECT DISTINCT place FROM 
                {$this->db->dbprefix}zipcode ORDER BY place";
        
        $res_ = $this->db->query($sql);
        $ret_ = $res_->result_array();
        
        $html = '';
        
        if($res_->num_rows()>0)
        {   
            foreach($ret_ as $loc)
            {
                $selected   = '';
                if($place==$loc['place'])
                    $selected   = 'selected';
                $html   .= '<option value="'.$loc['place'].'" '.$selected.'>'.$loc['place'].'</option>';
            }
        }
        
        return $html;
        
    }
    
	function delete_image($id) 
	{
        if(!$id || !is_numeric($id))
            return false;
        if($this->db->update('deals', array('img'=>''), array('id'=>$id)))
        	return true;
        return false;		
	}


}