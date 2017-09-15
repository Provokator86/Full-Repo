<?php
class My_model extends Model
{
	private $conId;
  	public function __construct()
    {
		parent::__construct();
	}	

  	public function check_duplicate($config,$databaseTbl)
	{
		if(!$config || !is_array($config) || !isset($config['tableName']))
			return false;
		
		foreach($databaseTbl as $key=>$value)
        {
            $sub_cond = $key."='".htmlentities($value)."'";
            if($config['id'] && $config['id']!='' && $config['id']!=-1)
                $sub_cond   .= " AND id!='{$config['id']}'";
            $sql = $this->db->query("SELECT * FROM {$this->db->dbprefix}{$config['tableName']} where $sub_cond");
           
		    $total  = $sql->num_rows();
            if($total>0)
                return WD('Duplicate value');
        }
	}
	
	public function check_duplicate_all($config,$databaseTbl)
	{
		if(!$config || !is_array($config) || !isset($config['tableName']))
			return false;
		$sub_cond	= ' 1 ';
		foreach($databaseTbl as $key=>$value)
            $sub_cond .= ' and '.$key."='".htmlentities($value)."'";
		if($config['id'] && $config['id']!='' && $config['id']!=-1)
        	$sub_cond   .= " AND id!='{$config['id']}'";
        $sql = $this->db->query("SELECT * FROM {$this->db->dbprefix}{$config['tableName']} where $sub_cond");
        $total  = $sql->num_rows();
        if($total>0)
        	return WD('Duplicate value');
	}
	
	function set_data_insert($tableName,$arr)
    {
        if( !$tableName || $tableName=='' ||  count($arr)==0 )
			return false;
		if($this->db->insert($tableName, $arr))
            return $this->db->insert_id();
        else
            return false;
    }
	
	function set_data_update($tableName,$arr,$id=-1) 
	{
        if(!$tableName || $tableName=='' || count($arr)==0 )
            return false;
        $cond   = '';
        if(is_array($id))
            $cond   = $id;
        else
            $cond   = array('id'=>$id);
        if($this->db->update($tableName, $arr, $cond))
            return true;
        else
            return false;				
	}
	
	function set_data_delete($tableName, $id=-1) 
	{
        if(!$tableName || $tableName=='' || !$id || $id=='')
			return false;
		if(is_array($id))
		{
			if($this->db->delete($tableName, $id))
				return true;
       		 else
            	return false;
		}
		else
		{
			if($this->db->delete($tableName, array('id'=>$id)))
           		 return true;
        	else
				return false;			
		}
					
	}
	
	function generalAdminData()
	{
		$this->set_connect();
		$sql = "CALL admin_fixed_data()";
		$query = $this->conId->query($sql);
		return $query->result_array();
		 
	}
	
	private function set_connect()
	{
		if($this->conId)
			$this->conId->close();
		$this->conId = $this->load->database('default',true);
        
	}
	
	function change_data_status($tablename,$id,$status)
    {
		//echo $tablename.'===='.$id.'===='.$status;
        /*if(!$id || !is_numeric($id))
            return false;*/
        $status      = 1-$status;
		
        if(!$id || $id=='' || !is_numeric($id))
            return false;
			$sql	= "UPDATE ".$this->db->dbprefix.$tablename." SET status='$status' WHERE id=$id";
			$this->db->query($sql);
        return true;
    }

    function get_unique_rendomcode($database,$field,$string='',$characters=15)
    {
        $rndCode	= get_rendom_code($string,$characters);
        $flg    = false;
        while ($flg==false)
        {
            $sql    = "SELECT * FROM {$this->db->dbprefix}$database WHERE $field='$rndCode'";
            $query = $this->db->query($sql);
            $tot    = $query->num_rows();
            if($tot>0)
                $rndCode	= get_rendom_code($string,$characters);
            else
                $flg    = true;
        }
        return $rndCode;
    }
	
	
    function get_query_result($sql)
    {
        $query  = $this->db->query($sql);
        $res    = $query->result_array();
        return $res;
    }
}