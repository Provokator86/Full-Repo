<?php
class Procedure_model extends Model
{
	private $conId;
	public function __construct()
    {
		parent::__construct();
	}
	
	private function set_connect()
	{
		if($this->conId)
			mysql_close( $this->conId );
		$this->conId=mysql_connect($this->db->hostname, $this->db->username, $this->db->password, TRUE,131072);
        mysql_select_db( $this->db->database,$this->conId );
	}

   function get_help_search($toshow=-1,$page=0,$search='')
   {
   		$this->set_connect();
   		$limit	= '';
   	 	if($toshow>0)
			$limit	= ' limit '.$page.','.$toshow;
   		$sql    = "CALL text_search('".$search."','','','".$limit."')";
        $rs = mysql_query($sql, $this->conId);
        $data=array();
        while($row = mysql_fetch_array($rs))
        	$data[]=$row;
		return $data;
   }
   
	function get_help_search_total($search='')
   	{
   		$this->set_connect();
   		$sql    = "CALL text_search('".$search."','','','')";
   		$rs = mysql_query($sql, $this->conId);
		return mysql_num_rows($rs);
   	}
}