<?php
class User_type_model extends My_model
{

  public function __construct()
    {
		parent::__construct();
	}	

    function get_user_type_list($arr=array(),$toshow=-1,$page=0,$order_by='user_type',$order_type='asc')
    {
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['user_type']) && $arr['user_type']!='')
			$subcond	.= " and user_type LIKE '%{$arr['user_type']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}user_type 
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
	
    function get_user_type_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['user_type']) && $arr['user_type']!='')
			$subcond	.= " and user_type LIKE '%{$arr['user_type']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
			
         $sql		= " select *
						from {$this->db->dbprefix}user_type 
						";

         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	
}