<?php
class static_page_model extends my_model
{
	
	
    public function __construct()
    {
		parent::__construct();
    }

    function get_static_page_details($page = 0, $toshow = -1, $url = '', $arr = array(), $page_id = 0)
	{
	
		$subcond = ' WHERE 1 ';
		if($url != '')
			$subcond  = $subcond." AND  url = '$url'";
		if(	isset($arr['id']) && $arr['id'] != 0)	
		{
			$subcond .= " AND id = {$arr['id']} ";
		}
		if( $page_id != 0 ) 
			$subcond .= " AND  id <> $page_id";
		if( $toshow > 0 )
			$subcond  = " LIMIT $page, $toshow";
		$sql = "SELECT * FROM {$this->db->dbprefix}static_page";
		$sql .= $subcond;
		$query = $this->db->query($sql); 
		$result = $query->result_array();
		return $result;
	}
	
	
	function count_get_static_page_details()
	{
	
		$sql = "SELECT count(*) tot FROM {$this->db->dbprefix}static_page";
		$query = $this->db->query($sql); 
		$result = $query->result_array();
		return $result[0]['tot'];
	}
	
	
	function delete_static_page($arr)
	{
	
		$subcond  = " Where 1 ";
		if( isset($arr['id']) && $arr['id'] !=0)
			$subcond .= " AND id = {$arr['id']}";
		$sql = "DELETE FROM {$this->db->dbprefix}static_page ";
		$sql .= $subcond;
		$this->db->query($sql);
		
	 
	}
	
}
?>