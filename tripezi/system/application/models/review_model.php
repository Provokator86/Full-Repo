<?php
/*********
* Author: Mrinmoy Mondal 
* Date  : 25 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For review
* 
* @package Users
* @subpackage blog
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_review.php
* @link views/admin/manage_review/
*/


class Review_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $tbl_user;
    private $tbl_country;
    private $tbl_state;
    private $tbl_city;
    private $tbl_booking;
	private $tbl_property;

    public function __construct()
    {
        try
        {
          parent::__construct();
        
          $this->tbl 						= $this->db->REVIEWSRATING;          
          $this->tbl_user 					= $this->db->USER;          
          $this->tbl_country 				= $this->db->COUNTRY;          
          $this->tbl_state 					= $this->db->STATE;          
          $this->tbl_city 					= $this->db->CITY; 
		  $this->tbl_booking   				= $this->db->BOOKING;   
		  $this->tbl_property       	    = $this->db->PROPERTY ;
          
          $this->conf =& get_config();
		  
		  
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$login_id='')
    {
        try
        {   
         
            $ret_=array();
            $s_qry="SELECT r.*,u.s_last_name,co.s_country,s.s_state,ci.s_city,CONCAT(u.s_first_name,' ',u.s_last_name) s_user_name 
             FROM ".$this->tbl." p "
            ." LEFT JOIN ".$this->tbl_user." u           ON p.i_owner_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_country." co       ON p.i_country_id=co.i_id "
            ." LEFT JOIN ".$this->tbl_state." s          ON p.i_state_id=s.i_id "
            ." LEFT JOIN ".$this->tbl_city." ci          ON p.i_city_id=ci.i_id "
           
                .($s_where!=""?$s_where:"" )." GROUP BY p.i_id "." ORDER BY p.dt_created_on DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
		 //echo '<br>'.$this->db->last_query();
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer 
                  $ret_[$i_cnt]["s_property_id"]            = get_unformatted_string($row->s_property_id);
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);
				  $ret_[$i_cnt]["s_accommodation"]          = get_unformatted_string($row->e_accommodation_type);
				  $ret_[$i_cnt]["s_property_type"]          = get_unformatted_string($row->s_property_type);
				  $ret_[$i_cnt]["i_total_bedrooms"]         = intval($row->i_total_bedrooms);
				 
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
          return $ret_;
          
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
 
    
    public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {				
		  
           $ret_=array();
           $s_qry="SELECT r.*,u.s_first_name,u.s_last_name,b.i_property_id, p.s_property_name,p.s_property_id,
		   		p.s_zipcode,co.s_country,s.s_state,c.s_city,CONCAT(u.s_first_name,' ',u.s_last_name) s_reviewer_name
		   		FROM ".$this->tbl." r "
		   		." LEFT JOIN ".$this->tbl_user." u ON r.i_user_id = u.i_id "
		   		." LEFT JOIN ".$this->tbl_booking." b ON r.i_booking_id = b.i_id "
				." LEFT JOIN ".$this->tbl_property." p ON b.i_property_id = p.i_id "
				." LEFT JOIN ".$this->tbl_country." co ON p.i_country_id = co.i_id "
				." LEFT JOIN ".$this->tbl_state." s ON p.i_state_id = s.i_id "
				." LEFT JOIN ".$this->tbl_city." c ON p.i_city_id = c.i_id "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]				= $row->i_id;////always integer 
				  $ret_[$i_cnt]["s_comment"]		= get_unformatted_string($row->s_comment);
				  $ret_[$i_cnt]["s_review_image"]	= get_unformatted_string($row->s_review_image);
				  $ret_[$i_cnt]["i_rating"]         = intval($row->i_rating);
				  $ret_[$i_cnt]["dt_created_on"]	= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  
				  $ret_[$i_cnt]["i_property_id"]	= intval($row->i_property_id);
                  $ret_[$i_cnt]["s_property_id"]	= get_unformatted_string($row->s_property_id);
                  $ret_[$i_cnt]["s_property_name"]	= get_unformatted_string($row->s_property_name);
				  $ret_[$i_cnt]["s_country"]		= get_unformatted_string($row->s_country);
				  $ret_[$i_cnt]["s_state"]          = get_unformatted_string($row->s_state);
				  $ret_[$i_cnt]["s_city"]          	= get_unformatted_string($row->s_city);
				  $ret_[$i_cnt]["s_zipcode"]		= get_unformatted_string($row->s_zipcode);
				  
				  $ret_[$i_cnt]["s_first_name"]		= get_unformatted_string($row->s_first_name);
				  $ret_[$i_cnt]["s_last_name"]		= get_unformatted_string($row->s_last_name);
				  $ret_[$i_cnt]["s_reviewer_name"]	= get_unformatted_string($row->s_reviewer_name);
				  
				 
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
          return $ret_;
          
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
          $ret_=0;
           $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." r "
                ." LEFT JOIN ".$this->tbl_user." u ON r.i_user_id = u.i_id "
		   		." LEFT JOIN ".$this->tbl_booking." b ON r.i_booking_id = b.i_id "
				." LEFT JOIN ".$this->tbl_property." p ON b.i_property_id = p.i_id "
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
          $ret_=array();
          ////Using Prepared Statement///
            $s_qry="SELECT r.* FROM ".$this->tbl." r "
            ." WHERE r.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));           
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  
                  $ret_["id"]			= $row->i_id;////always integer
                  $ret_["s_comment"]	= get_unformatted_string($row->s_comment);
                  $ret_["i_rating"]		= intval($row->i_rating);
          
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id,$s_where);
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
				$s_qry.=" s_comment=? ";
                $s_qry.=", i_rating=? ";
                $s_qry.=" Where i_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(
												  get_formatted_string($info["s_comment"]),
                                                  intval($info["i_rating"]),
												  intval($i_id)

											 ));
											 
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_comment"]),
                                                  intval($info["i_rating"]),
												  intval($i_id)

												 )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $info,$id);
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
