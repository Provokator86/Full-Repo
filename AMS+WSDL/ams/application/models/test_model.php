<?php
/*
* FIle Name: business_model.com
* Author: SWI Team
* Date  : 27 July, 2015
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Business listing, add, edit and etc.
* @link controllers/manage_listing.php
* @link views/web_master/manage_listing/
*/

class Test_model extends MY_Model{

    private $conf;
    private $tbl, $tbl_in_year, $tbl_user, $tbl_pic, $tbl_doc, $tbl_rl_est, $tbl_mcin, $tbl_fr, $tbl_closing_data; // Table used for this class

    public function __construct() 
    {
        try 
        {
            parent::__construct();
           
            $this->tbl_user_list  = $this->db->BUSINESS_INC_YEAR;
           
        } 
        catch (Exception $err_obj) 
        {
            show_error($err_obj->getMessage());
        }
    }
    

    public function fetch_all_data($table,$s_where = null, $order_name, $order_by, $i_start = null, $i_limit = null)
    {
        try
        {
            $sql = "SELECT *  FROM {$table} "                                                    
                    .($s_where!=""? ' WHERE '.$s_where:"" )
                    //.(" ORDER BY {$order_name} {$order_by}")
                    .(is_numeric($i_start) && is_numeric($i_limit)? " Limit ".intval($i_start).",".intval($i_limit):"" );
            return $this->db->query($sql)->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
    
    // Count all
    public function count_all($table,$s_where = '')
    {
        $sql = "SELECT * 
                FROM  {$table} ".($s_where!=""? ' WHERE '.$s_where:"" );
        return count($this->db->query($sql)->result_array());
    }
    
   
   /*********** FUNCTION FOR DASHBOARD AND REPORT SECTION STARTS BELOW 29Oct 2015 ************/
    public function __destruct() {
        
    }

}

///end of class
?>