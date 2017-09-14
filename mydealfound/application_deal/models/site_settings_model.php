<?php



/*

 * To change this template, choose Tools | Templates

 * and open the template in the editor.

 */



/**

 * Description of location_model

 *

 * @author user

 */

class Site_settings_model extends MY_Model {

    //put your code here

    

    public $table_name;

    public function __construct() {

        parent::__construct();

        $this->table_name = 'cd_admin_site_settings';

    }    

    /**

     * get the list of all data in table 

     */
	 
	 public function fetch_this($null)
    {
        try
        {
          $ret_=array();
          $s_qry="Select u.* From {$this->table_name} u " ;
		  //."INNER JOIN {$this->tbl_lang} l ON u.i_default_language  = l.i_id "
		  //."INNER JOIN {$this->tbl_currency} cur ON u.i_default_currency = cur.i_id ";
                
          $rs=$this->db->query($s_qry);
          if($rs->num_rows()>0)
          {             		
			  $ret_	=        $rs->row_array(); 
              $rs->free_result();  
			  
          }
          unset($s_qry,$rs,$row);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    } 

}

