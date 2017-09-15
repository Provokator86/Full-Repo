<?php
class Occupation_model extends My_model
{

  public function __construct()
    {
		parent::__construct();
	}	

    function get_occupation_list($arr=array(),$toshow=-1,$page=0,$order_by='occupation',$order_type='asc')
    {
		$limit		= "";
		$subcond	= " where 1 ";
		if(isset($arr['id']) && $arr['id']!='')
			$subcond	.= " and id='{$arr['id']}' ";
		if(isset($arr['occupation']) && $arr['occupation']!='')
			$subcond	.= " and occupation LIKE '%{$arr['occupation']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
		$sql		= " select *
						from {$this->db->dbprefix}occupation 
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
	
    function get_occupation_list_count($arr=array())
    {
       $subcond	= " where 1 ";
		if(isset($arr['occupation']) && $arr['occupation']!='')
			$subcond	.= " and occupation LIKE '%{$arr['occupation']}%' ";
		if(isset($arr['status']) && $arr['status']!='' && $arr['status']!=-1)
			$subcond	.= " and status='{$arr['status']}' ";					
			
         $sql		= " select *
						from {$this->db->dbprefix}occupation 
						";

         $sql    .= $subcond;

        $query = $this->db->query($sql);
		return $query->num_rows();
    }	

    function get_occupation_option($id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}occupation ORDER BY occupation";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $html   = '';
        foreach($result as $k=>$v)
        {
            $selected   = '';
            if($v['id']==$id)
                $selected   = ' selected ';
            $html   .= "<option value='{$v['id']}' $selected>{$v['occupation']}</option> ";
        }
        return $html;
    }	
	
	                                                        
}