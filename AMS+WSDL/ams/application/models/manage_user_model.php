<?php
/*********
* Author: SWI
* Date  : 31 March 2017
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For User
* 
* @package User
* @subpackage User
* 
* @link MY_Model.php
* @link controllers/manage_user.php
* @link views/web_master/manage_user/
*/



class Manage_user_model extends MY_Model
{
    private $conf;
    private $tbl, $tbl_ut;///used for this class

    public function __construct()
    {
        try
        {
			parent::__construct();
			//$this->tbl		= $this->db->EMPLOYEE;
			$this->tbl		= $this->db->USER;
			$this->tbl_ut	= $this->db->USER_TYPE;
			$this->conf		= & get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi($s_where = NULL, $i_start = NULL, $i_limit = NULL)
    {
        try
        {
			/*return $this->db->select('u.*, ut.s_user_type')
							->where($s_where, '', false)
					 		->join($this->tbl_ut.' AS ut', 'ut.id = u.i_user_type', 'left')
					 		->order_by('i_id', 'desc')
					 		->get($this->tbl.' AS u', $i_limit, $i_start)
					 		->result_array();*/
			$ret_=array();
			$s_qry="SELECT u.*, ut.s_user_type FROM {$this->tbl} AS u "
				." LEFT JOIN {$this->tbl_ut} AS ut ON ut.id = u.i_user_type"
				.($s_where!=""?$s_where:"" )
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			$rs=$this->db->query($s_qry);
			return $rs->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   //End of function fetch_multi
	
	
	public function fetch_multi_sorted_list($s_where = NULL, $order_name, $order_by, $i_start = NULL, $i_limit = NULL)
    {
        try
        {			
			$ret_=array();
			$s_qry="SELECT u.*, ut.s_user_type FROM {$this->tbl} AS u "
				." LEFT JOIN {$this->tbl_ut} AS ut ON ut.id = u.i_user_type"
				.($s_where!=""?$s_where:"" )
				." ORDER BY {$order_name} {$order_by}"
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			$rs=$this->db->query($s_qry);
			return $rs->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
    public function gettotal_info($s_where = NULL)
    {
        try
        {
			$ret_=0;
			$s_qry="SELECT COUNT(u.i_id) as i_total "
				 ."FROM ".$this->tbl." u "
				 ." LEFT JOIN {$this->tbl_ut} AS ut ON ut.id = u.i_user_type"
				 .($s_where!=""?$s_where:"" );				
			$rs=$this->db->query($s_qry);
			$i_cnt=0;
			if($rs->num_rows()>0)
			{
			  foreach($rs->result() as $row)
			  {
				  $ret_=intval($row->i_total); 
			  }    
			  $rs->free_result();          
			}
			unset($s_qry,$rs,$row,$i_cnt,$s_where);
			return $ret_;
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }  //End of function gettotal_info        
    

    
    
    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $i_id
    * @returns array
    */
	
    public function fetch_this($i_id)
    {
        try
        {
			$tmp = $this->db->get_where($this->tbl, array('i_id'=>$i_id))->result_array();
			return $tmp[0];
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }  //End of function fetch_this    
	
	public function fetch_all_user_type()
	{
		$ret = array();
		$tmp = $this->db->select('id,s_user_type')->get_where($this->tbl_ut, array('i_status' => 1, 'id > '=> 1))->result_array();
		for($i = 0; $i < count($tmp); $i++)
			$ret[$tmp[$i]['id']] = $tmp[$i]['s_user_type'];
		unset($tmp);
		return $ret;
	} 
	
	
    public function __destruct()
    {}                 
}
///end of class
?>
