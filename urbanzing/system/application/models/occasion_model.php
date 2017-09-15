<?php
class Occasion_model extends My_model
{
  public function __construct()
    {
		parent::__construct();
	}	

    function get_occasion_list($arr=array(),$toshow=-1,$page=0,$order_by='occasion',$order_type='asc')
    {
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['occasion']) && $arr['occasion']!='')
			$subcond	.= " and occasion LIKE '%{$arr['occasion']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}occasion 
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
	
    function get_occasion_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['occasion']) && $arr['occasion']!='')
			$subcond	.= " and occasion LIKE '%{$arr['occasion']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
			
         $sql		= " select *
						from {$this->db->dbprefix}occasion 
						";

         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	
	
	
    function get_occasion_option($id=-1,$country_id=-1)
    {
        $subcond    = '';
        if($country_id>0)
            $subcond    .= " AND country_id=$country_id ";
        $sql    = " SELECT *
                    FROM {$this->db->dbprefix}occasion
                    WHERE status='1' $subcond
                    ORDER BY occasion";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $html   = '';
        if($result)
        {
            foreach($result as $k=>$v)
            {
                $selected   = '';
                if($v['id']==$id)
                    $selected   = ' selected ';
                $html   .= '<option value="'.$v['id'].'" '.$selected.'>'.$v['occasion'].'</option>';
            }
        }
        return $html;
    }
	
	                                                        
}