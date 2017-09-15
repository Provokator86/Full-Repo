<?php
class entries_model extends My_model
{

  public function __construct()
    {
		parent::__construct();
	}	
 	function get_entries_option($id=-1)
    {
        $sql    = "SELECT * FROM {$this->db->dbprefix}entries ORDER BY id";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        $html   = '';
        foreach($result as $k=>$v)
        {
            $selected   = '';
            if($v['id']==$id)
                $selected   = ' selected ';
            $html   .= "<option value='{$v['id']}' $selected>{$v['entries']}</option> ";
        }
        return $html;
    }	
	                                                        
}


