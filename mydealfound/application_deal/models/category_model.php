<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * Description of category_model
 * @author user
 */

class Category_model extends MY_Model {
    //put your code here

    public $table_name;
    public function __construct() {

        parent::__construct();
        $this->table_name = 'cd_category';
    }
	
	public function fetch_category_chain($s_where=null,$i_start=null,$i_limit=null,$order_by=false)
    {
        try
        {
          $ret_=array();
            
          $s_qry="SELECT n.*,p.s_category AS parent_category FROM ".$this->table_name." AS n "   
		   		." LEFT JOIN ".$this->table_name." AS p "
				." ON p.i_id = n.i_parent_id "                             
                .($s_where!=""?$s_where:"" )
				." ORDER BY n.i_parent_id ASC ";
		  $s_qry.=(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		  $rs=$this->db->query($s_qry);		  
		  //echo $this->db->last_query();
		  $ret_ = $rs->result_array();
		  
          unset($s_qry,$rs,$s_where,$i_start,$i_limit);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }


	/* get categoery list*/
    public function get_category_list($s_where=null,$i_start=null,$i_limit=null) 
	{
		$ret_=array();
		$s_qry="SELECT * FROM ".$this->table_name." "
				.($s_where!=""?$s_where:"" )." ORDER BY s_category ASC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		$rs	= $this->db->query($s_qry);
		//echo $this->db->last_query();
		$ret_ = $rs->result_array();
		return $ret_;
    }
	

    /**
     * get the list of all data in table 
     */
}
?>