<?php
class archieve_model extends my_model
{
	
	
    public function __construct()
    {
		parent::__construct();
    }

   function count_table_row($tbl_name)
   {
		return $this->db->count_all($tbl_name);
	
   }	
   
   function get_archieve_list( $page= 0,$toshow= -1, $arr = array(), $order_name='cr_date',$order_type='desc' )
   {
   
   		$limit = '';
   		$subcond   = '  WHERE 1 ';
		if( isset($arr['id'] ))
			$subcond   .= " AND id = {$arr['id']} ";
   		$sql = "SELECT * FROM {$this->db->dbprefix}archieve_master ";
		
		$subcond .= " ORDER BY $order_name $order_type ";
		
		
		if( $toshow > 0)
			$subcond .= " LIMIT $page, $toshow ";
		$sql     .= $subcond;	
		$query = $this->db->query($sql);
   		$result_arr = $query->result_array();
   		return $result_arr;
   }
   
   function get_archieve_image_list($tbl_name, $arr = array())
   {
   
   		$subcond   = '  WHERE 1 ';
		if( isset($arr['archieve_id']))
			$subcond .= " AND archieve_id = {$arr['archieve_id']}";
   		$sql = "SELECT * FROM $tbl_name ";
		$sql .= $subcond;
		$query = $this->db->query($sql);
   		$result_arr = $query->result_array();
   		return $result_arr;
      
   }
   
   function check_url_exist($url)
   {
   
   		$sql = "SELECT COUNT(*) tot FROM {$this->db->dbprefix}archieve_master WHERE url = '{$url}'";
		$query = $this->db->query($sql);
		$result_arr = $query->result_array();
		return $result_arr[0]['tot'];
   
   
   }
   
   
  
   

	
}
?>