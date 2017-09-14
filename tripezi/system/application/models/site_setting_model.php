<?php
/*********
* Author: Koushik 
* Date  : 02 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For Site Setting
* 
* @package Site Setting
* @subpackage Site Setting
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/site_setting.php
* @link views/admin/site_setting/
*/


class Site_setting_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl 	= 	$this->db->SITESETTING;        
          $this->conf 	=	&get_config();
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
	/****
    * Fetch Total records
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function gettotal_info($s_where=null)
    {
        try
        {
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }         
    

    /*******
    * Fetches One record from db.
    * 
    * @param blank
    * @returns array
    */
    public function fetch_this($null)
    {
        try
        {
          $ret_=array();
		  $s_qry="Select * From {$this->tbl} u ";
          $rs = $this->db->query($s_qry);
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["i_id"]							=	$row->i_id;		////always integer
				  $ret_["s_admin_email"]				=	get_unformatted_string($row->s_admin_email); 
				  $ret_["s_paypal_email"]				=	get_unformatted_string($row->s_paypal_email); 
				  $ret_["s_facebook_address"]			=	get_unformatted_string($row->s_facebook_address); 
				  $ret_["s_twitter_address"]			=	get_unformatted_string($row->s_twitter_address);
				  $ret_["s_linkedin_address"]			=	get_unformatted_string($row->s_linkedin_address); 
				  $ret_["s_google_plus_address"]		=	get_unformatted_string($row->s_google_plus_address); 
				  $ret_["s_youtube_address"]			=	get_unformatted_string($row->s_youtube_address); 
				  $ret_["s_sms_gateway_key"]			=	get_unformatted_string($row->s_sms_gateway_key);   
				  $ret_["s_google_map_key"]				=	get_unformatted_string($row->s_google_map_key);
				  $ret_["s_google_map_key_gmap3"]		=	get_unformatted_string($row->s_google_map_key_gmap3); 
				  $ret_["d_service_charge_percentage"]	=	$row->d_service_charge_percentage;
				  $ret_["d_site_comission_percentage"]	=	$row->d_site_comission_percentage;
				  $ret_["s_youtube_snippet_for_how_it_works"] = $row->s_youtube_snippet_for_how_it_works;
                  $ret_["s_smtp_host"]                  =    get_unformatted_string($row->s_smtp_host); 
                  $ret_["s_smtp_password"]              =    get_unformatted_string($row->s_smtp_password); 
                  $ret_["s_smtp_userid"]                =    get_unformatted_string($row->s_smtp_userid);
              }    
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
        
    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_info($info)
    {
        try
        { 
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }            

    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_admin_email=? ";
				$s_qry.=", s_paypal_email=? ";
				$s_qry.=", s_facebook_address=? ";				
                $s_qry.=", s_twitter_address=? ";
                $s_qry.=", s_linkedin_address=? ";
				$s_qry.=", s_google_plus_address=? ";
				$s_qry.=", s_youtube_address=? ";
                //$s_qry.=", s_sms_gateway_key=? ";
				$s_qry.=", s_google_map_key=? ";
				$s_qry.=", s_google_map_key_gmap3=? ";
				$s_qry.=", d_service_charge_percentage=? ";
				$s_qry.=", d_site_comission_percentage=? ";
				$s_qry.=", s_youtube_snippet_for_how_it_works=? ";
                $s_qry.=", s_smtp_host=? ";
                $s_qry.=", s_smtp_password=? ";
                $s_qry.=", s_smtp_userid=? ";
				
                $s_qry.=" Where i_id=? ";
				
               $i_ret_ = $this->db->query($s_qry,array(		
												get_formatted_string($info["s_admin_email"]),
												get_formatted_string($info["s_paypal_email"]),
                                                get_formatted_string($info["s_facebook_address"]),
                                                get_formatted_string($info["s_twitter_address"]),
												get_formatted_string($info["s_linkedin_address"]),
												get_formatted_string($info["s_google_plus_address"]),
												get_formatted_string($info["s_youtube_address"]),
                                                //get_formatted_string($info["s_sms_gateway_key"]),
												get_formatted_string($info["s_google_map_key"]),
												get_formatted_string($info["s_google_map_key_gmap3"]),
												doubleval($info["d_service_charge_percentage"]),
												doubleval($info["d_site_comission_percentage"]),
												$info["s_youtube_snippet_for_how_it_works"],
                                                get_formatted_string($info["s_smtp_host"]),
                                                get_formatted_string($info["s_smtp_password"]),
                                                get_formatted_string($info["s_smtp_userid"]),
												intval($i_id)
                                              ));
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(		
												get_formatted_string($info["s_admin_email"]),
												get_formatted_string($info["s_paypal_email"]),
                                                get_formatted_string($info["s_facebook_address"]),
                                                get_formatted_string($info["s_twitter_address"]),
												get_formatted_string($info["s_linkedin_address"]),
												get_formatted_string($info["s_google_plus_address"]),
												get_formatted_string($info["s_youtube_address"]),
                                                //get_formatted_string($info["s_sms_gateway_key"]),
												get_formatted_string($info["s_google_map_key"]),
												get_formatted_string($info["s_google_map_key_gmap3"]),
												doubleval($info["d_service_charge_percentage"]),
												doubleval($info["d_site_comission_percentage"]),
												$info["s_youtube_snippet_for_how_it_works"],
                                                get_formatted_string($info["s_smtp_host"]),
                                                get_formatted_string($info["s_smtp_password"]),
                                                get_formatted_string($info["s_smtp_userid"]),
												intval($i_id)
                                              )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry,$info,$i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }      
    /******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {
        try
        { 
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }      

    /****
    * Register a log for add,edit and delete operation
    * 
    * @param mixed $attr
    * @returns TRUE on success and FALSE if failed 
    */
    public function log_info($attr)
    {
        try
        {
            $logindata=$this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"],decrypt($logindata["user_id"]),($attr["sql"]?$attr["sql"]:""));
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