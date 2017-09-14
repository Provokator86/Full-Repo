<?php
/*********
* Author: ACS
* Date  : 31 March 2014
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
* @link controllers/client.php
* @link views/web_master/client/
*/



class Client_model extends MY_Model
{
    private $conf;
    private $tbl, $tbl_c, $tbl_r, $tbl_com;///used for this class

    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->tbl_c	= $this->db->CLIENT;
			$this->tbl		= $this->db->CLIENT_CONTACT;
			$this->tbl_com	= $this->db->CLIENT_CONTACT_COMPANY;
			$this->tbl_r	= $this->db->CONTACT_ROLL;
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
            
            if($s_where) $this->db->where($s_where, '', false);
            $tmp = $this->db->select('cl.*', false)
                            ->order_by('cl.s_contact_person', 'asc')
                            ->get($this->tbl.' AS cl', $i_limit, $i_start)
                            ->result_array();
            
            for($i = 0; $i <count($tmp); $i++)
            {
                // Get client_contact_id 
                $client_contact_id = $this->db->select('GROUP_CONCAT(i_client_contact_id) AS client_contact_id', false)->get_where($this->tbl_com, array('i_client_id' => $tmp[$i]['i_id']))->result_array();
                
                if(intval($client_contact_id[0]['client_contact_id']) > 0)
                {
                    $client_name = $this->db->select('GROUP_CONCAT(s_client_name SEPARATOR ", ") AS client_name', false)->where("FIND_IN_SET(i_id, '".$client_contact_id[0]['client_contact_id']."')")->get($this->tbl_c)->result_array();
                    
                }
                $tmp[$i]['client'] = $client_name[0]['client_name'];
                unset($client_name, $client_contact_id);
            }
            return $tmp;
			// c.s_client_name, c.s_email, 
			/*if($s_where) $this->db->where($s_where, '', false);
			return $this->db->select('cl.*,
					(SELECT GROUP_CONCAT(s_client_name SEPARATOR ", ") FROM '.$this->tbl_c.' 
					WHERE i_id IN (SELECT i_client_contact_id FROM '.$this->tbl_com.' WHERE i_client_id = cl.i_id)) AS client', false)
							//->join($this->tbl_c.' AS c','cl.i_client_id = c.i_id', 'left')
							->order_by('cl.s_contact_person', 'asc')
							->get($this->tbl.' AS cl', $i_limit, $i_start)
							->result_array();*/
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   //End of function fetch_multi
	
	public function fetch_multi_client($s_where = NULL, $i_start = NULL, $i_limit = NULL, $order_by = 's_client_name', $sort_type= "asc")
    {
        try
        {
			$s_where = $s_where == '' ? 'c.i_id > 0' : $s_where;
			return $this->db->select('c.*')
							->where($s_where, '', false)
							->order_by($order_by, $sort_type)
							//->order_by('c.i_id', 'desc')
							->get($this->tbl_c.' AS c', $i_limit, $i_start)
							->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	public function get_total_client($s_where = NULL)
    {
        try
        {
			$s_where = $s_where == '' ? 'c.i_id > 0' : $s_where;
			return count($this->db->select('c.i_id')
							->where($s_where, '', false)
							->order_by('c.i_id', 'desc')
							->get($this->tbl_c.' AS c', $i_limit, $i_start)
							->result_array());
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	
	public function fetch_multi_sorted_list($s_where = NULL, $order_name, $order_by, $i_start = NULL, $i_limit = NULL)
    {
        try
        {
			if($s_where) $this->db->where($s_where, '', false);
			if($order_name !='' && $order_by != '') $this->db->order_by($order_name, $order_by);
			return $this->db->get($this->tbl, $i_limit, $i_start)->result_array();
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
			if($s_where) $this->db->where($s_where, '', false);
			return count($this->db->get($this->tbl.' AS cl')->result_array());
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }  //End of function gettotal_info        
    

    //fetch all certifications
	public function fetch_all_client()
	{
		$ret = array();
		$ret[-1] = 'Select';
		$tmp = $this->db->select('i_id, s_client_name')->order_by('s_client_name', 'asc')->get($this->tbl_c)->result_array();
		for($i = 0; $i < count($tmp); $i++)
			$ret[$tmp[$i]['i_id']] = $tmp[$i]['s_client_name'];
		unset($tmp);
		return $ret;
	}
    
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
	
	public function auth_pass($pass, $i_id = 0)
	{
		try
        {
			$s_password = md5(trim($pass).$this->conf["security_salt"]);
            if(intval($i_id) == 0)
            {
                $mix_data = $this->session->userdata('admin_loggedin');
                $i_id = decrypt($mix_data['user_id']);   
            }
            $rs = $this->db->select('count(i_id) AS total')->get_where($this->tbl, array('s_password'=>$s_password,'i_id' => $i_id))->result_array();
			unset($s_password, $mix_data,  $i_id);
			return intval($rs[0]['total']);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  
	}     
	
    public function __destruct()
    {}                 
}
///end of class
?>