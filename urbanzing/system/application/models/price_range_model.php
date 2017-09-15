<?php
class Price_range_model extends My_model
{
  public function __construct()
    {
		parent::__construct();
	}	

    function get_price_range_list($arr=array(),$toshow=-1,$page=0,$order_by='cr_date',$order_type='desc')
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
						from {$this->db->dbprefix}price_range 
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
				$arr = array('id'=>$value['country_id']);
				$result[$key]['country'] = $CI->location_model->get_country_list(1,0,$arr);
			}
		
		}	
		return $result;
	}	
	
    function get_price_range_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
			
         $sql		= " select *
						from {$this->db->dbprefix}price_range 
						";

         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	
    /*
     * By rubel
     */

    function get_price_range_option($id=-1,$country_id=-1)
    {
        $subcond    = '';
        if($country_id>0)
            $subcond    .= " AND country_id=$country_id ";
        $sql    = " SELECT *
                    FROM {$this->db->dbprefix}price_range
                    WHERE status='1' $subcond
                    ORDER BY price_from DESC";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $html   = '';
        if($result)
        {
            foreach($result as $k=>$v)
            {
				$price_range_text = $v['price_from'];
				if (!empty($v['price_to'])) {
					$price_range_text .= " - ".$v['price_to'];
				}
				
                $selected   = '';
                if($v['id']==$id)
                    $selected   = ' selected ';
                $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$price_range_text.'</option>';
            }
        }
        return $html;
    }

	
	                                                        
}