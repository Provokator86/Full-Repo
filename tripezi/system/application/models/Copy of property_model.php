<?php
/*********
* Author: Koushik 
* Email: koushik.r@acumensoft.info
* Date  : 03 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Blog
* 
* @package Content Management
* @subpackage blog
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/blog.php
* @link views/admin/blog/
*/


class Property_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $tbl_user;
    private $tbl_country;
    private $tbl_state;
    private $tbl_city;
    private $tbl_currency;
    private $tbl_property_type;
    private $tbl_bed_type;
    private $tbl_cancellation_policy;
    private $tbl_aminity;
    private $tbl_property_amenity;
    private $tbl_property_image;
    private $tbl_booking;
	private $tbl_property_blocked;
	private $tbl_review_rating;
	private $tbl_favourite_property;

    public function __construct()
    {
        try
        {
          parent::__construct();
        
          $this->tbl 						= $this->db->PROPERTY;          
          $this->tbl_user 					= $this->db->USER;          
          $this->tbl_country 				= $this->db->COUNTRY;          
          $this->tbl_state 					= $this->db->STATE;          
          $this->tbl_city 					= $this->db->CITY;          
          $this->tbl_currency 				= $this->db->CURRENCY;          
          $this->tbl_property_type 			= $this->db->PROPERTYTYPE;          
          $this->tbl_bed_type 				= $this->db->PROPERTYBEDTYPE;          
          $this->tbl_cancellation_policy 	= $this->db->PROPERTYCANCELLATIONPOLICY; 
          $this->tbl_aminity            	= $this->db->AMENITY;          
          $this->tbl_property_amenity   	= $this->db->PROPERTYAMENITY;                    
          $this->tbl_property_image   		= $this->db->PROPERTYIMAGE;  
		  
		  $this->tbl_booking   				= $this->db->BOOKING;        
          $this->tbl_property_blocked       = $this->db->PROPERTYBLOCKED ;
		  $this->tbl_review_rating       	= $this->db->REVIEWSRATING ;
		  $this->tbl_favourite_property     = $this->db->FAVOURITES ;
          
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
            $s_qry="SELECT p.*,pt.s_name s_property_type,u.s_first_name,u.s_last_name,u.s_email,u.s_image,u.i_phone_verified,co.s_country,s.s_state,ci.s_city,
            cu.d_currency_rate,cu.s_currency_symbol,pa.i_amenity_id,CONCAT(u.s_first_name,' ',u.s_last_name) s_user_name 
             FROM ".$this->tbl." p "
            ." LEFT JOIN ".$this->tbl_user." u           ON p.i_owner_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_country." co       ON p.i_country_id=co.i_id "
            ." LEFT JOIN ".$this->tbl_state." s          ON p.i_state_id=s.i_id "
            ." LEFT JOIN ".$this->tbl_city." ci          ON p.i_city_id=ci.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu      ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_property_amenity." pa ON pa.i_property_id=p.i_id "
			." LEFT JOIN ".$this->tbl_property_type." pt ON pt.i_id = p.i_property_type_id "
           
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
				  $ret_[$i_cnt]["i_total_guests"]         	= intval($row->i_total_guests);
				  $ret_[$i_cnt]["s_description"]          	= get_unformatted_string($row->s_description);
				  
                  $ret_[$i_cnt]["s_zipcode"]                = get_unformatted_string($row->s_zipcode);
                  $ret_[$i_cnt]["d_standard_price"]         = $row->d_standard_price;
                  $ret_[$i_cnt]["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_[$i_cnt]["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_[$i_cnt]["d_additional_price"]       = $row->d_additional_price;
                  $ret_[$i_cnt]["dt_created_on"]            = date($this->conf["site_date_format"],intval($row->dt_created_on));                  
                  $ret_[$i_cnt]["i_status"]                 = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]                 = (intval($row->i_status)==1?"Active":"Inactive");
                  
				  $ret_[$i_cnt]["i_currency_id"]          	= intval($row->i_currency_id);
                  $ret_[$i_cnt]["d_currency_rate"]          = $row->d_currency_rate;
                  $ret_[$i_cnt]["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol); 
                  
                  //from user table
                  $ret_[$i_cnt]["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_[$i_cnt]["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_[$i_cnt]["s_email"]                  = get_unformatted_string($row->s_email);
				  $ret_[$i_cnt]["s_image"]                  = get_unformatted_string($row->s_image); 
                  $ret_[$i_cnt]["s_country"]                = get_unformatted_string($row->s_country); 
                  $ret_[$i_cnt]["s_state"]                  = get_unformatted_string($row->s_state); 
                  $ret_[$i_cnt]["s_city"]                   = get_unformatted_string($row->s_city); 
				  $ret_[$i_cnt]["i_phone_verified"]         = get_unformatted_string($row->i_phone_verified);
				  
				  $s_where	=	"WHERE pi.i_property_id = ".$ret_[$i_cnt]["id"]." ";
				  $order_by	=	" ORDER BY RAND() ";
				  $ret_[$i_cnt]["s_property_image"]         = $this->fetch_property_image($s_where,$order_by,0,1);
				  
				  $s_where = "WHERE b.i_property_id = ".$ret_[$i_cnt]["id"]." ";
				  $ret_[$i_cnt]["total_review"]				= $this->fetch_rating_review($s_where);
				  
				  // check is this proerty is in favourite list of loggedin user
				  if($login_id!='')
				  {
				  	$s_where = "WHERE f.i_property_id = ".$ret_[$i_cnt]["id"]." AND f.i_user_id = ".$login_id."  ";
				  	$ret_[$i_cnt]["i_favourite"]	= $this->count_favourite_exist($s_where);
				  }
                  
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
    /* ." LEFT JOIN ".$this->tbl_property_type." pt ON p.i_property_type_id=pt.i_id "
     ." LEFT JOIN ".$this->tbl_bed_type." bt      ON p.i_bed_type_id=bt.i_id "  */
    
    public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
              $ret_=array();
            $s_qry="SELECT p.*,u.s_first_name,u.s_last_name,u.s_email,co.s_country,s.s_state,ci.s_city,
            cu.d_currency_rate,cu.s_currency_symbol,pa.i_amenity_id,CONCAT(u.s_first_name,' ',u.s_last_name) s_user_name 
             FROM ".$this->tbl." p "
            ." LEFT JOIN ".$this->tbl_user." u           ON p.i_owner_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_country." co       ON p.i_country_id=co.i_id "
            ." LEFT JOIN ".$this->tbl_state." s          ON p.i_state_id=s.i_id "
            ." LEFT JOIN ".$this->tbl_city." ci          ON p.i_city_id=ci.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu      ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_property_amenity." pa ON pa.i_property_id=p.i_id "
           
                .($s_where!=""?$s_where:"" )." GROUP BY p.i_id "." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_property_id"]            = get_unformatted_string($row->s_property_id);
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);
                  $ret_[$i_cnt]["s_zipcode"]                = get_unformatted_string($row->s_zipcode);
                  $ret_[$i_cnt]["d_standard_price"]         = $row->d_standard_price;
                  $ret_[$i_cnt]["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_[$i_cnt]["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_[$i_cnt]["d_additional_price"]       = $row->d_additional_price;
                  $ret_[$i_cnt]["dt_created_on"]            = date($this->conf["site_date_format"],intval($row->dt_created_on));                  
                  $ret_[$i_cnt]["i_status"]                 = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]                 = (intval($row->i_status)==1?"Active":"Inactive");
                  
                  $ret_[$i_cnt]["d_currency_rate"]          = $row->d_currency_rate;
                  $ret_[$i_cnt]["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol); 
                  
                  //from user table
                  $ret_[$i_cnt]["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_[$i_cnt]["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_[$i_cnt]["s_email"]                  = get_unformatted_string($row->s_email); 
                  $ret_[$i_cnt]["s_country"]                = get_unformatted_string($row->s_country); 
                  $ret_[$i_cnt]["s_state"]                  = get_unformatted_string($row->s_state); 
                  $ret_[$i_cnt]["s_city"]                   = get_unformatted_string($row->s_city); 
                  
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
	
	/* this function fetch properties after search 
	 *
	 */
	public function fetch_properties_on_search($s_where=null,$s_order='',$i_start=null,$i_limit=null,$login_id='')
    {
        try
        {   
          
            $ret_=array();
            $s_qry="SELECT p.*,pt.s_name AS s_property_type,u.s_first_name,u.s_last_name,u.s_email,u.s_image,u.i_phone_verified,
			co.s_country,s.s_state,ci.s_city,cu.d_currency_rate,cu.s_currency_symbol, 
			pa.i_amenity_id,CONCAT(u.s_first_name,' ',u.s_last_name) s_user_name 
             FROM ".$this->tbl." p "
            ." LEFT JOIN ".$this->tbl_user." u           ON p.i_owner_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_country." co       ON p.i_country_id=co.i_id "
            ." LEFT JOIN ".$this->tbl_state." s          ON p.i_state_id=s.i_id "
            ." LEFT JOIN ".$this->tbl_city." ci          ON p.i_city_id=ci.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu      ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_property_amenity." pa ON pa.i_property_id=p.i_id "
			." LEFT JOIN ".$this->tbl_property_type." pt ON pt.i_id = p.i_property_type_id "
           
            .($s_where!=""?$s_where:"" )." GROUP BY p.i_id ".($s_order!=""?$s_order:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
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
				  $ret_[$i_cnt]["i_total_guests"]         	= intval($row->i_total_guests);
				  $ret_[$i_cnt]["s_description"]          	= get_unformatted_string($row->s_description);
				  
				  $ret_[$i_cnt]["s_lattitude"]              = get_unformatted_string($row->s_lattitude);
				  $ret_[$i_cnt]["s_longitude"]              = get_unformatted_string($row->s_longitude);
                  $ret_[$i_cnt]["s_zipcode"]                = get_unformatted_string($row->s_zipcode);
                  $ret_[$i_cnt]["d_standard_price"]         = $row->d_standard_price;
                  $ret_[$i_cnt]["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_[$i_cnt]["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_[$i_cnt]["d_additional_price"]       = $row->d_additional_price;
                  $ret_[$i_cnt]["dt_created_on"]            = date($this->conf["site_date_format"],intval($row->dt_created_on));                  
                  $ret_[$i_cnt]["i_status"]                 = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]                 = (intval($row->i_status)==1?"Active":"Inactive");
                  
				  $ret_[$i_cnt]["i_currency_id"]          	= intval($row->i_currency_id);
                  $ret_[$i_cnt]["d_currency_rate"]          = $row->d_currency_rate;
                  $ret_[$i_cnt]["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol); 
                  
                  //from user table
                  $ret_[$i_cnt]["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_[$i_cnt]["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_[$i_cnt]["s_email"]                  = get_unformatted_string($row->s_email);
				  $ret_[$i_cnt]["s_image"]                  = get_unformatted_string($row->s_image); 
                  $ret_[$i_cnt]["s_country"]                = get_unformatted_string($row->s_country); 
                  $ret_[$i_cnt]["s_state"]                  = get_unformatted_string($row->s_state); 
                  $ret_[$i_cnt]["s_city"]                   = get_unformatted_string($row->s_city); 
				  $ret_[$i_cnt]["i_phone_verified"]         = get_unformatted_string($row->i_phone_verified);
				  $ret_[$i_cnt]["i_owner_id"]         		= intval($row->i_owner_user_id);
				  
				  $s_where	=	"WHERE pi.i_property_id = ".$ret_[$i_cnt]["id"]." ";
				  $order_by	=	" ORDER BY RAND() ";
				  $ret_[$i_cnt]["s_property_image"]         = $this->fetch_property_image($s_where,$order_by,0,1);
				  
				  $s_where = " WHERE b.i_property_id=".$ret_[$i_cnt]["id"]." ";
				  $ret_[$i_cnt]["review_rate"]			= $this->fetch_rating_review($s_where);
				  
				  // check is this proerty is in favourite list of loggedin user
				  if($login_id!='')
				  {
				  	$s_where = "WHERE f.i_property_id = ".$ret_[$i_cnt]["id"]." AND f.i_user_id = ".$login_id."  ";
				  	$ret_[$i_cnt]["i_favourite"]	= $this->count_favourite_exist($s_where);
				  }
                  
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
	
	
	/* this functions returns random property , and their single images random */
	public function fetch_random_property_and_images($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {   
          
              $ret_=array();
            $s_qry="SELECT p.i_id,p.s_property_name FROM ".$this->tbl." p "        
                .($s_where!=""?$s_where:"" )." ORDER BY RAND() ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);  
				  $s_where	=	"WHERE pi.i_property_id = ".$ret_[$i_cnt]["id"]." ";
				  $order_by	=	" ORDER BY RAND() ";
				  $ret_[$i_cnt]["s_property_image"]         = $this->fetch_property_image($s_where,$order_by,0,1);
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
                ."From ".$this->tbl." p "
                ." LEFT JOIN ".$this->tbl_user." u   ON p.i_owner_user_id=u.i_id "
                ." LEFT JOIN ".$this->tbl_property_amenity." pa ON pa.i_property_id=p.i_id "
                .($s_where!=""?$s_where:"" )." GROUP BY p.i_id ";
                
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
	
	
	 public function gettotal_properties_on_search_info($s_where=null)
    {
        try
        {
          $ret_=array();
          $s_qry="SELECT * "
                ."FROM ".$this->tbl." p "
                ." LEFT JOIN ".$this->tbl_user." u   ON p.i_owner_user_id=u.i_id "
                ." LEFT JOIN ".$this->tbl_property_amenity." pa ON pa.i_property_id=p.i_id "
                .($s_where!=""?$s_where:"" )." GROUP BY p.i_id ";
					//." LEFT JOIN ".$this->tbl_property_blocked." block ON block.i_property_id = p.i_id "
                
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=intval($row->i_id); 
				  $i_cnt++;
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
	
	public function gettotal_property_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." p "
                ." LEFT JOIN ".$this->tbl_user." u   ON p.i_owner_user_id=u.i_id "
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
	
	
	
	public function fetch_top_destinations($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
				
		 /* $s_qry = "SELECT DISTINCT c.* FROM ".$this->tbl_city." c "
				.($s_where!=""?$s_where:"" )
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );*/
							
		  $s_qry = "SELECT DISTINCT c.s_city,p.i_no_property,c.* FROM ".$this->tbl_city." c "
				."INNER JOIN (SELECT COUNT(*) i_no_property,pp.i_city_id,pp.i_status FROM ".$this->tbl." pp "
				." WHERE pp.i_status = 1 GROUP BY(i_city_id) ) p "
				." ON c.i_id = p.i_city_id "
				.($s_where!=""?$s_where:"" )				
				." ORDER BY p.i_no_property DESC "
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );	
		
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_city"]=get_unformatted_string($row->s_city); 
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
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
            $s_qry="SELECT p.*,u.s_first_name,u.s_last_name,u.s_email,u.s_phone_number,co.s_country,s.s_state,ci.s_city,
            cu.d_currency_rate,cu.s_currency_symbol,pt.s_name s_property_type_name,bt.s_name s_bed_type_name,cp.s_name s_cancellation_policy_name 
             FROM ".$this->tbl." p "
            ." LEFT JOIN ".$this->tbl_user." u           ON p.i_owner_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_country." co       ON p.i_country_id=co.i_id "
            ." LEFT JOIN ".$this->tbl_state." s          ON p.i_state_id=s.i_id "
            ." LEFT JOIN ".$this->tbl_city." ci          ON p.i_city_id=ci.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu      ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_property_type." pt ON p.i_property_type_id=pt.i_id "
            ." LEFT JOIN ".$this->tbl_bed_type." bt      ON p.i_bed_type_id=bt.i_id "
            ." LEFT JOIN ".$this->tbl_cancellation_policy." cp      ON p.i_cancellation_policy_id=cp.i_id "
            ." Where p.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));           
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  
                  $ret_["id"]                       = $row->i_id;////always integer
                  $ret_["s_property_id"]            = get_unformatted_string($row->s_property_id);
                  $ret_["s_property_name"]          = get_unformatted_string($row->s_property_name);
                  $ret_["s_zipcode"]                = get_unformatted_string($row->s_zipcode);				  
				  $ret_["i_owner_user_id"]          = get_unformatted_string($row->i_owner_user_id);
				  
				  $ret_["s_lattitude"]          	= get_unformatted_string($row->s_lattitude);
				  $ret_["s_longitude"]          	= get_unformatted_string($row->s_longitude);
				  $ret_["s_youtube_snippet"]        = $row->s_youtube_snippet;
                  
                  $ret_["d_standard_price"]         = $row->d_standard_price;
                  $ret_["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_["d_additional_price"]       = $row->d_additional_price;
                  $ret_["dt_created_on"]            = date($this->conf["site_date_format"],intval($row->dt_created_on));                  
                  $ret_["i_status"]                 = intval($row->i_status); 
                  $ret_["s_status"]                 = (intval($row->i_status)==1?"Active":"Inactive");
                  $ret_["e_accommodation_type"]     = get_unformatted_string($row->e_accommodation_type);
                  $ret_["i_total_guests"]           = intval($row->i_total_guests);
                  $ret_["i_total_bedrooms"]         = intval($row->i_total_bedrooms);
                  $ret_["i_total_bathrooms"]        = intval($row->i_total_bathrooms);
                  $ret_["i_checkin_after"]          = intval($row->i_checkin_after);
                  $ret_["i_checkout_before"]        = intval($row->i_checkout_before);
                  $ret_["s_description"]            = get_unformatted_string($row->s_description);
                  $ret_["s_house_rules"]            = get_unformatted_string($row->s_house_rules);
                  $ret_["d_cleaning_fee"]           = $row->d_cleaning_fee;
                  $ret_["i_minimum_night_stay"]     = intval($row->i_minimum_night_stay);
                  $ret_["i_maximum_night_stay"]     = intval($row->i_maximum_night_stay);
                  
				  $ret_["i_currency_id"]            = intval($row->i_currency_id);
                  $ret_["d_currency_rate"]          = $row->d_currency_rate;
                  $ret_["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol); 
                  
                  //from user table
                  $ret_["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_["s_email"]                  = get_unformatted_string($row->s_email);
				  $ret_["s_phone_number"]           = get_unformatted_string($row->s_phone_number);
                   
                  $ret_["s_country"]                = get_unformatted_string($row->s_country); 
                  $ret_["s_state"]                  = get_unformatted_string($row->s_state); 
                  $ret_["s_city"]                   = get_unformatted_string($row->s_city);
				  $ret_["i_city_id"]                = intval($row->i_city_id);
                  
                  
                  $ret_["s_property_type_name"]     = get_unformatted_string($row->s_property_type_name);
                  $ret_["s_bed_type_name"]          = get_unformatted_string($row->s_bed_type_name);
                  $ret_["s_cancellation_policy_name"]= get_unformatted_string($row->s_cancellation_policy_name);
				  $ret_["i_cancellation_policy_id"]  = intval($row->i_cancellation_policy_id);
				  
				  //fetch_reviews_of_property 
				  $s_where	=	" WHERE b.i_property_id =".intval($i_id)." ";
				  $ret_["review_rate"]				= $this->fetch_rating_review($s_where);
				  				  
          
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
	
	
	/* delete property with cheking dependencies 
	*  on : $this->tbl_booking
	*/
	public function delete_property($i_id)
    {
        try
        {
		  $s_qry = "SELECT COUNT(*) as i_total FROM  ".$this->tbl_booking." WHERE i_property_id =".$i_id." " ;        
          $rs	 = $this->db->query($s_qry);
		 
          if($rs->num_rows()>0)
          {
             return false;        
          }
		  else
		  {
		  	// delete images
		  	$sql = "DELETE FROM ".$this->tbl_property_image." WHERE i_property_id = ".$i_id." ";
			$res = $this->db->query($sql);
			
			// delete amenities
			$sql1 = "DELETE FROM ".$this->tbl_property_amenity." WHERE i_property_id = ".$i_id." ";
			$res1 = $this->db->query($sql1);
			
			// delete from property table
			$sql = "DELETE FROM ".$this->tbl." WHERE i_id = ".$i_id." ";
			$res = $this->db->query($sql);
			
			//$i_ret_= $this->db->affected_rows();
			
			return true;
		  }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
	
	
	public function genUniqueId() 
    {
        try
        {            
             $num_length = 10;
             $char_length = 2;
             $char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
             $characters = '0123456789';
             $string = ''; 
             $string1 = '';   
              for ($p = 0; $p < $char_length; $p++) 
                {
                    $string1 .= $char[mt_rand(0, strlen($char))];
                }
              for ($p = 0; $p < $num_length; $p++)
                 {
                    $string .= $characters[mt_rand(0, strlen($characters))];
                 }
             $final_string = $string1.'-'.$string;
             $sql = "SELECT * FROM ".$this->tbl." WHERE s_property_id='".$final_string."'";
             $query=$this->db->query($sql);
             if($query->num_rows()>0)
                {
                     $this->genUniqueId();
                }
             else    
                 return $final_string;
            
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
    
     public function fetch_property_amenity($s_where='')
     {
         try
         {
             $ret_=array();
            $s_qry="SELECT a.*,pa.i_property_id   
             FROM ".$this->tbl_aminity." a "
            ." LEFT JOIN ".$this->tbl_property_amenity." pa ON a.i_id=pa.i_amenity_id "
            .($s_where!=""?$s_where:"" );
             
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_property_id"]            = intval($row->i_property_id);
                  $ret_[$i_cnt]["s_name"]                   = get_unformatted_string($row->s_name);
                  $i_cnt++;
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
     
     
      public function fetch_property_image($s_where='',$order_by='',$i_start='',$i_limit='')
     {
         try
         {
             $ret_=array();
            $s_qry="SELECT pi.*   
             FROM ".$this->tbl_property_image." pi "
            .($s_where!=""?$s_where:"" ).($order_by!=""?$order_by:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_property_id"]            = intval($row->i_property_id);
                  $ret_[$i_cnt]["s_property_image"]         = get_unformatted_string($row->s_property_image);
                  $i_cnt++;
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
    
    /**
    * delete a property image
    *  
    * @param mixed $image_id
    */
     public function delete_an_image($image_id)
     {
         try
         {
            $sql = "DELETE FROM ".$this->tbl_property_image." WHERE i_id = ".$image_id." ";
            
            $res = $this->db->query($sql);
         
            $i_ret_=$this->db->affected_rows();
            
            return $i_ret_;
             
         }
         catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            }
     }
     
     
     public function property_booked_date($s_where)
     {
         try
         {
              $ret_=array();
              $s_qry = "SELECT  * FROM  ".$this->tbl_property_blocked.($s_where!=""?$s_where:"") ;        
              $rs     = $this->db->query($s_qry);
              $i_cnt=0;
              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {
                      //$ret_[$i_cnt]["id"]                       = $row->i_id;////always integer 
                      //$ret_[$i_cnt]["dt_blocked_date"]          = $row->dt_blocked_date;
                      $ret_[$i_cnt]                   = date('d',$row->dt_blocked_date);
                      $i_cnt++;
                  }   
              }    
              $rs->free_result();
              unset($s_qry,$rs,$row,$i_cnt,$s_where);
             return $ret_;
         }
         catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
     }
     
     
     /**
     * This function is for unblocking date
     * 
     * @param mixed $property_id
     * @param mixed $date_month_year
     */
     function unblock_property($property_id,$date_month_year)
     {
         try
         {
             $i_aff =   0 ;
             //$s_qry =   " DELETE FROM ".$this->tbl_property_blocked." WHERE i_property_id=".$property_id." AND FROM_UNIXTIME( dt_blocked_date , '%d-%m-%Y' )=".$date_month_year ;
             
             $s_qry =   " DELETE FROM ".$this->tbl_property_blocked." WHERE i_property_id=".$property_id." AND dt_blocked_date=".$date_month_year ;
             
             $this->db->query($s_qry);
             
             $i_aff=$this->db->affected_rows();
            
             return $i_aff;
             
         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
     } 
     
     
     /**
     * This function is for blocking a date
     * a new entry made time of blocking
     * 
     * @param mixed $info
     */
     function block_property($info)
     {
         try
         {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_property_blocked." Set ";
                $s_qry.=" i_property_id=? ";
                $s_qry.=", dt_blocked_date=? ";
                
                $this->db->query($s_qry,array(
                                              $info["i_property_id"],
                                              $info["dt_blocked_date"]                                              
                                                 
                                              ));
              
                $i_ret_=$this->db->insert_id();     
               
            }
            unset($s_qry, $info );
            return $i_ret_;
             
         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
     }
     
     
     /**
     * This function is for booking a property for the first time
     * 
     * @param mixed $info
     */
     public function booking_property($info)
     {
         try
         {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_booking." Set ";
                $s_qry.=" s_booking_id=? ";
                $s_qry.=", i_traveler_user_id=? ";
                $s_qry.=", i_property_id=? ";
                $s_qry.=", dt_booked_on=? ";
                $s_qry.=", dt_booked_from=? ";
                $s_qry.=", dt_booked_to=? ";
                $s_qry.=", e_status=? ";
                
                $this->db->query($s_qry,array(
                                              $info["s_booking_id"],
                                              $info["i_traveler_user_id"],                                              
                                              $info["i_property_id"],                                              
                                              $info["dt_booked_on"] ,                                             
                                              $info["dt_booked_from"] ,                                             
                                              $info["dt_booked_to"] ,                                             
                                              $info["e_status"]                                              
                                              ));
              
                $i_ret_=$this->db->insert_id();     
               
            }
            unset($s_qry, $info );
            return $i_ret_;

         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
     }
     
     
     
     public function fetch_booked_date($s_where)
     {
         try
         {
              $ret_=array();
              $s_qry = "SELECT  * FROM  ".$this->tbl_booking.($s_where!=""?$s_where:"") ;        
              $rs     = $this->db->query($s_qry);
              $i_cnt=0;
              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {
                     
                      $ret_[$i_cnt]['i_property_id']       = $row->i_property_id;
                      $ret_[$i_cnt]['booked_from_date']      = date('d',$row->dt_booked_from);
                      $ret_[$i_cnt]['booked_to_date']        = date('d',$row->dt_booked_to);
                      $ret_[$i_cnt]['booked_from_month']     = date('m',$row->dt_booked_from);
                      $ret_[$i_cnt]['booked_to_month']       = date('m',$row->dt_booked_to);
                      $ret_[$i_cnt]['booked_from_year']      = date('y',$row->dt_booked_from);
                      $ret_[$i_cnt]['booked_to_year']        = date('y',$row->dt_booked_to);
                      
                      $ret_[$i_cnt]['dt_booked_from']        = date('d-m-Y',$row->dt_booked_from);
                      $ret_[$i_cnt]['dt_booked_to']          = date('d-m-Y',$row->dt_booked_to);
                      $i_cnt++;
                  }   
              }    
              $rs->free_result();
              unset($s_qry,$rs,$row,$i_cnt,$s_where);
              return $ret_;
             
             
         }
         catch(Exception $err_obj)
         {
             show_error($err_obj->getMessage());
         }
     } 
     
     
    /**
    *  this function fetch booking list
    *
    */
    public function fetch_booking_list($s_where=null,$i_start=null,$i_limit=null,$user_id='')
    {
        try
        {   
          
            $ret_=array();
            $s_qry="SELECT b.*,p.s_property_name,p.e_accommodation_type,p.i_total_guests property_total_guests,p.i_currency_id,p.d_standard_price,p.d_weekly_price,p.d_monthly_price,p.i_owner_user_id,u.s_first_name,u.s_last_name,cu.d_currency_rate,cu.s_currency_symbol,us.s_first_name owner_first_name,us.s_last_name owner_last_name   
             FROM ".$this->tbl_booking." b "
            ." LEFT JOIN ".$this->tbl." p   ON b.i_property_id=p.i_id "
            ." LEFT JOIN ".$this->tbl_user." u  ON b.i_traveler_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_user." us  ON p.i_owner_user_id=us.i_id "

           
                .($s_where!=""?$s_where:"" )." ORDER BY dt_booked_on DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
         //echo '<br>'.$this->db->last_query();
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
               $order_by    =    " ORDER BY RAND() ";
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer 
                  $ret_[$i_cnt]["s_booking_id"]             = get_unformatted_string($row->s_booking_id);
                  $ret_[$i_cnt]["i_traveler_user_id"]       = intval($row->i_traveler_user_id);
                  $ret_[$i_cnt]["i_property_id"]            = intval($row->i_property_id);
                  $ret_[$i_cnt]["dt_booked_on"]             = date($this->conf["site_date_format"],intval($row->dt_booked_on));
                  $ret_[$i_cnt]["dt_booked_from"]           = date($this->conf["site_date_format"],intval($row->dt_booked_from));
                  $ret_[$i_cnt]["dt_booked_to"]             = date($this->conf["site_date_format"],intval($row->dt_booked_to));
                  $ret_[$i_cnt]["t_booked_from"]            = intval($row->dt_booked_from);
                  $ret_[$i_cnt]["t_booked_to"]              = intval($row->dt_booked_to);
                  
                  $ret_[$i_cnt]["e_status"]                 = get_unformatted_string($row->e_status);
                  $ret_[$i_cnt]["i_total_guest"]            = intval($row->i_total_guest);
                  $ret_[$i_cnt]["d_amount_paid"]            = $row->d_amount_paid;
                  $ret_[$i_cnt]["d_service_charge_amount"]  = $row->d_service_charge_amount;
                  $ret_[$i_cnt]["d_host_amount"]            = $row->d_host_amount;
                 
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);
                  $ret_[$i_cnt]["s_accommodation"]          = get_unformatted_string($row->e_accommodation_type);
                
                  $ret_[$i_cnt]["i_total_guests"]           = intval($row->property_total_guests);
                  $ret_[$i_cnt]["d_standard_price"]         = $row->d_standard_price;
                  $ret_[$i_cnt]["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_[$i_cnt]["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_[$i_cnt]["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol);
				  $ret_[$i_cnt]["i_currency_id"]            = intval($row->i_currency_id);

                  
                  //from user table
                  $ret_[$i_cnt]["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_[$i_cnt]["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  
                  $ret_[$i_cnt]["owner_first_name"]         = get_unformatted_string($row->owner_first_name); 
                  $ret_[$i_cnt]["owner_last_name"]          = get_unformatted_string($row->owner_last_name); 
                  $ret_[$i_cnt]["i_owner_user_id"]          = intval($row->i_owner_user_id); 
                 
                  $s_where    =    "WHERE pi.i_property_id = ".$ret_[$i_cnt]["i_property_id"]." ";
                  $ret_[$i_cnt]["s_property_image"]         = $this->fetch_property_image($s_where,$order_by,0,1);
				  if($user_id!='')
				  {
				  $s_where = " WHERE r.i_booking_id = ".$ret_[$i_cnt]["id"]." AND r.i_user_id = ".$user_id." ";
				  $ret_[$i_cnt]["i_count_review"]         	= count($this->fetch_review_exist($s_where));
				  }
				  //fetch_average_rating_review
				  $s_where = " WHERE r.i_booking_id=".$ret_[$i_cnt]["id"]." ";
				  $ret_[$i_cnt]["rate"]			= $this->fetch_average_rating_review($s_where);
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
          
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    
    
    public function gettotal_property_booking($s_where=null)
    {
        try
        {
          $ret_=0;
           $s_qry="Select count(*) as i_total 
           FROM ".$this->tbl_booking." b "
             ." LEFT JOIN ".$this->tbl." p   ON b.i_property_id=p.i_id "
            ." LEFT JOIN ".$this->tbl_user." u  ON b.i_traveler_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_user." us  ON p.i_owner_user_id=us.i_id "
                .($s_where!=""?$s_where:"" ) ;
                
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
    
    
    public function fetch_property_info($property_id)
    {
        try
        {
            $ret_=array();
          ////Using Prepared Statement///
            $s_qry="SELECT p.*,u.s_first_name,u.s_last_name,u.s_email 
             FROM ".$this->tbl." p "
            ." LEFT JOIN ".$this->tbl_user." u ON p.i_owner_user_id=u.i_id "
            ." Where p.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($property_id)));           
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  
                  $ret_["id"]                       = $row->i_id;////always integer
                  $ret_["s_property_id"]            = get_unformatted_string($row->s_property_id);
                  $ret_["s_property_name"]          = get_unformatted_string($row->s_property_name);                  
                  $ret_["i_owner_user_id"]          = get_unformatted_string($row->i_owner_user_id);
                  //from user table
                  $ret_["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_["s_email"]                  = get_unformatted_string($row->s_email);
                  $ret_["i_minimum_night_stay"]     = intval($row->i_minimum_night_stay);
                  $ret_["i_maximum_night_stay"]     = intval($row->i_maximum_night_stay);
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	/********************** following functions are for review and rating ***************************/
	public function fetch_review_exist($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT b.i_property_id,r.* FROM ".$this->tbl_review_rating." r "
            ." LEFT JOIN ".$this->tbl_booking." b ON b.i_id = r.i_booking_id "           
            .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_comment"]            	= get_unformatted_string($row->s_comment);               
                  $ret_[$i_cnt]["dt_created_on"]            = date($this->conf["site_date_format"],intval($row->dt_created_on));            
                  
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
	
	public function fetch_review_content($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT owner.s_image s_owner_image,p.i_owner_user_id,b.i_property_id,r.* FROM ".$this->tbl_review_rating." r "
            //." LEFT JOIN ".$this->tbl_user." u ON u.i_id = r.i_user_id "   
			." LEFT JOIN ".$this->tbl_booking." b ON b.i_id = r.i_booking_id" 
			." LEFT JOIN ".$this->tbl." p ON p.i_id = b.i_property_id "  
			." LEFT JOIN ".$this->tbl_user." owner ON owner.i_id = p.i_owner_user_id "      
            .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          // echo '<br/>'.$s_qry;  
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]				= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_comment"]		= get_unformatted_string($row->s_comment);               
                  $ret_[$i_cnt]["dt_created_on"]	= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  $ret_[$i_cnt]["s_review_image"]	= $row->s_review_image;   
				  $ret_[$i_cnt]["i_rating"]			= intval($row->i_rating);  
				  $ret_[$i_cnt]["s_owner_image"]	= get_unformatted_string($row->s_owner_image);         
                  
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
	
	public function fetch_average_rating_review($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT COUNT(*) AS i_total,avg(i_rating) AS avg_rating FROM ".$this->tbl_review_rating." r "     
            .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          // echo '<br/>'.$s_qry;  
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                  
				  $ret_[$i_cnt]["avg_rating"]	= $row->avg_rating;  
				  $ret_[$i_cnt]["i_total"]		= intval($row->i_total);         
                  
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
	
	/* if you have only property id then you can get rating/reviews count 
	* using this functions
	* if property has any booking then it returns total review and rating 
	*  	
	*/
	public function fetch_rating_review($s_where=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT COUNT(*) AS i_total,avg(i_rating) AS avg_rating FROM ".$this->tbl_review_rating." r " 
			." INNER JOIN ".$this->tbl_booking." b ON b.i_id = r.i_booking_id "	   
			." INNER JOIN ".$this->tbl." p ON p.i_id = b.i_property_id " 
            .($s_where!=""?$s_where:"" );
          // echo '<br/>'.$s_qry;  
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {                  
				  $ret_["avg_rating"]	= round($row->avg_rating);  
				  $ret_["i_total"]		= intval($row->i_total);         
                  
                  //$i_cnt++;
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
	
	public function fetch_reviews_of_property($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT owner.s_image s_owner_image,travel.s_image s_traveler_image,p.i_owner_user_id,b.i_property_id,
			r.* FROM ".$this->tbl_review_rating." r "
            ." LEFT JOIN ".$this->tbl_user." travel ON travel.i_id = r.i_user_id "   
			." LEFT JOIN ".$this->tbl_booking." b ON b.i_id = r.i_booking_id" 
			." LEFT JOIN ".$this->tbl." p ON p.i_id = b.i_property_id "  
			." LEFT JOIN ".$this->tbl_user." owner ON owner.i_id = p.i_owner_user_id "      
            .($s_where!=""?$s_where:"" )." ORDER BY r.dt_created_on DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          // echo '<br/>'.$s_qry;  
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]				= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_comment"]		= get_unformatted_string($row->s_comment);               
                  $ret_[$i_cnt]["dt_created_on"]	= date($this->conf["site_date_format"],intval($row->dt_created_on));
				  $ret_[$i_cnt]["dt_reviewed_on"]	= date("M Y",intval($row->dt_created_on));
				  $ret_[$i_cnt]["s_review_image"]	= $row->s_review_image;   
				  $ret_[$i_cnt]["i_rating"]			= intval($row->i_rating);  
				  $ret_[$i_cnt]["s_owner_image"]	= get_unformatted_string($row->s_owner_image); 
				  $ret_[$i_cnt]["s_traveler_image"]	= get_unformatted_string($row->s_traveler_image);         
                  
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
	
	/********************** end functions for review and rating ******************************/
    
    
     /**
    *  this function fetch booking list
    *
    */
    public function fetch_booking_info($booking_id)
    {
        try
        {   
          
            $ret_=array();
            $s_qry="SELECT b.*,p.s_property_name,p.s_property_id,p.e_accommodation_type,p.i_total_guests property_total_guests,p.d_standard_price,p.d_weekly_price,p.d_monthly_price,p.i_owner_user_id,co.s_country property_country,s.s_state property_state,ci.s_city property_city,p.s_zipcode property_zipcode,cu.d_currency_rate,cu.s_currency_symbol 
             FROM ".$this->tbl_booking." b "
            ." LEFT JOIN ".$this->tbl." p   ON b.i_property_id=p.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu ON b.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_country." co ON p.i_country_id=co.i_id "
            ." LEFT JOIN ".$this->tbl_state." s    ON p.i_state_id=s.i_id "
            ." LEFT JOIN ".$this->tbl_city." ci    ON p.i_city_id=ci.i_id "
            
            ." WHERE b.i_id=?";   
           
               
             
          $rs=$this->db->query($s_qry,array($booking_id));
         //echo '<br>'.$this->db->last_query();
          
          if($rs->num_rows()>0)
          {
              
              foreach($rs->result() as $row)
              {
                  $ret_["id"]                       = $row->i_id;////always integer 
                  $ret_["s_booking_id"]             = get_unformatted_string($row->s_booking_id);
                  $ret_["i_traveler_user_id"]       = intval($row->i_traveler_user_id);
                  $ret_["i_property_id"]            = intval($row->i_property_id);
                  $ret_["dt_booked_on"]             = date($this->conf["site_date_format"],intval($row->dt_booked_on));
                  $ret_["dt_booked_from"]           = date($this->conf["site_date_format"],intval($row->dt_booked_from));
                  $ret_["dt_booked_to"]             = date($this->conf["site_date_format"],intval($row->dt_booked_to));
                  $ret_["t_booked_from"]            = intval($row->dt_booked_from);
                  $ret_["t_booked_to"]              = intval($row->dt_booked_to);
                  
                  $ret_["e_status"]                 = get_unformatted_string($row->e_status);
                  $ret_["i_total_guest"]            = intval($row->i_total_guest);
                  $ret_["d_amount_paid"]            = $row->d_amount_paid;
                  $ret_["d_service_charge_amount"]  = $row->d_service_charge_amount;
                  $ret_["d_host_amount"]            = $row->d_host_amount;
                 
                  $ret_["s_property_name"]          = get_unformatted_string($row->s_property_name);
                  $ret_["s_property_id"]            = get_unformatted_string($row->s_property_id);
                  $ret_["s_accommodation"]          = get_unformatted_string($row->e_accommodation_type);
                 
                  $ret_["i_total_guests"]           = intval($row->property_total_guests);
                  $ret_["d_standard_price"]         = $row->d_standard_price;
                  $ret_["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol);


                  $ret_["i_owner_user_id"]          = intval($row->i_owner_user_id); 
                  $ret_["property_country"]         = get_unformatted_string($row->property_country); 
                  $ret_["property_state"]           = get_unformatted_string($row->property_state); 
                  $ret_["property_city"]            = get_unformatted_string($row->property_city); 
                  $ret_["property_zipcode"]         = get_unformatted_string($row->s_zipcode); 

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
    
    
    
    /**
    *  this function fetch booking order list for admin 
    *
    */
    public function fetch_booking_order_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {   
          
            $ret_=array();
            $s_qry="SELECT b.*,p.s_property_name,p.e_accommodation_type,
            p.i_total_guests property_total_guests,p.d_standard_price,p.d_weekly_price,
            p.d_monthly_price,p.i_owner_user_id,u.s_first_name,u.s_last_name,
            u.s_email,us.s_first_name owner_first_name,
            us.s_last_name owner_last_name,us.s_email owner_email,p.s_property_id s_property_id    
             FROM ".$this->tbl_booking." b "
            ." LEFT JOIN ".$this->tbl." p   ON b.i_property_id=p.i_id "
            ." LEFT JOIN ".$this->tbl_user." u  ON b.i_traveler_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_user." us  ON p.i_owner_user_id=us.i_id "

           
                .($s_where!=""?$s_where:"" )." ORDER BY dt_booked_on DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
         //echo '<br>'.$this->db->last_query();
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
               $order_by    =    " ORDER BY RAND() ";
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer 
                  $ret_[$i_cnt]["s_booking_id"]             = get_unformatted_string($row->s_booking_id);
                  $ret_[$i_cnt]["i_traveler_user_id"]       = intval($row->i_traveler_user_id);
                  $ret_[$i_cnt]["i_property_id"]            = intval($row->i_property_id);
                  $ret_[$i_cnt]["dt_booked_on"]             = date($this->conf["site_date_format"],intval($row->dt_booked_on));
                  $ret_[$i_cnt]["dt_canceled_on"]           = date($this->conf["site_date_format"],intval($row->dt_canceled_on));
                  $ret_[$i_cnt]["dt_booked_from"]           = date($this->conf["site_date_format"],intval($row->dt_booked_from));
                  $ret_[$i_cnt]["dt_booked_to"]             = date($this->conf["site_date_format"],intval($row->dt_booked_to));
                  $ret_[$i_cnt]["t_booked_from"]            = intval($row->dt_booked_from);
                  $ret_[$i_cnt]["t_booked_to"]              = intval($row->dt_booked_to);
                  
                  $ret_[$i_cnt]["e_status"]                 = get_unformatted_string($row->e_status);
                  $ret_[$i_cnt]["i_total_guest"]            = intval($row->i_total_guest);
                  $ret_[$i_cnt]["d_amount_paid"]            = $row->d_amount_paid;
                  $ret_[$i_cnt]["d_service_charge_amount"]  = $row->d_service_charge_amount;
                  $ret_[$i_cnt]["d_host_amount"]            = $row->d_host_amount;
                 
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);
                  $ret_[$i_cnt]["s_property_id"]            = get_unformatted_string($row->s_property_id);
                  
                  $ret_[$i_cnt]["s_accommodation"]          = get_unformatted_string($row->e_accommodation_type);
                
                  $ret_[$i_cnt]["i_total_guests"]           = intval($row->property_total_guests);
                  $ret_[$i_cnt]["d_standard_price"]         = $row->d_standard_price;
                  $ret_[$i_cnt]["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_[$i_cnt]["d_monthly_price"]          = $row->d_monthly_price;

                  //from user table
                  $ret_[$i_cnt]["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_[$i_cnt]["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_[$i_cnt]["s_email"]                  = get_unformatted_string($row->s_email); 
                  
                  $ret_[$i_cnt]["owner_first_name"]         = get_unformatted_string($row->owner_first_name); 
                  $ret_[$i_cnt]["owner_last_name"]          = get_unformatted_string($row->owner_last_name); 
                  $ret_[$i_cnt]["owner_email"]              = get_unformatted_string($row->owner_email); 
                  $ret_[$i_cnt]["i_owner_user_id"]          = intval($row->i_owner_user_id); 
                  

                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
          
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    
     public function gettotal_property_booking_order($s_where=null)
    {
        try
        {
          $ret_=0;
           $s_qry="Select count(*) as i_total 
           FROM ".$this->tbl_booking." b "
             ." LEFT JOIN ".$this->tbl." p   ON b.i_property_id=p.i_id "
            ." LEFT JOIN ".$this->tbl_user." u  ON b.i_traveler_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu ON p.i_currency_id=cu.i_id "
            ." LEFT JOIN ".$this->tbl_user." us  ON p.i_owner_user_id=us.i_id "
                .($s_where!=""?$s_where:"" ) ;
                
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
    
    
    
    /**
    *  this function fetch booking details for admin
    *
    */
    public function fetch_booking_details($booking_id='')
    {
        try
        {   
          
            $ret_=array();
            $s_qry="SELECT b.*,u.s_first_name,u.s_last_name,cu.d_currency_rate,cu.s_currency_symbol,cu.s_currency_code
               
             FROM ".$this->tbl_booking." b "
            ." LEFT JOIN ".$this->tbl." p   ON b.i_property_id=p.i_id "
            ." LEFT JOIN ".$this->tbl_user." u  ON b.i_traveler_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu ON b.i_currency_id=cu.i_id "
           
            ." WHERE b.i_id=?";   

          $rs=$this->db->query($s_qry,array($booking_id));

          if($rs->num_rows()>0)
          {
               $order_by    =    " ORDER BY RAND() ";
              foreach($rs->result() as $row)
              {
                  $ret_["id"]                       = $row->i_id;////always integer 
                  $ret_["s_booking_id"]             = get_unformatted_string($row->s_booking_id);
                  $ret_["i_traveler_user_id"]       = intval($row->i_traveler_user_id);
                  $ret_["i_property_id"]            = intval($row->i_property_id);
                  $ret_["dt_booked_on"]             = date($this->conf["site_date_format"],intval($row->dt_booked_on));
                  $ret_["dt_booked_from"]           = date($this->conf["site_date_format"],intval($row->dt_booked_from));
                  $ret_["dt_booked_to"]             = date($this->conf["site_date_format"],intval($row->dt_booked_to));
                  $ret_["t_booked_from"]            = intval($row->dt_booked_from);
                  $ret_["t_booked_to"]              = intval($row->dt_booked_to);
                  
                  $ret_["e_status"]                 = get_unformatted_string($row->e_status);
                  $ret_["i_total_guest"]            = intval($row->i_total_guest);
                  $ret_["d_amount_paid"]            = $row->d_amount_paid;
                  $ret_["d_service_charge_amount"]  = $row->d_service_charge_amount;
                  $ret_["d_host_amount"]            = $row->d_host_amount;
                  
                  $ret_["d_currency_rate_gbp"]      = $row->d_currency_rate_gbp;
                  $ret_["d_currency_rate_usd"]      = $row->d_currency_rate_usd;
                  $ret_["d_currency_rate_euro"]     = $row->d_currency_rate_euro;

                  $ret_["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol);
                  $ret_["s_currency_code"]          = get_unformatted_string($row->s_currency_code);
                  $ret_["d_currency_rate"]          = get_unformatted_string($row->d_currency_rate);

                  //from user table
                  $ret_["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_["s_last_name"]              = get_unformatted_string($row->s_last_name); 

              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
          
        
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	// $this->tbl_favourite_property
	/* fetch if the favourite property exist for same user or not*/
	public function count_favourite_exist($s_where=null)
    {
        try
        {
          $ret_=0;
           $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_favourite_property." f "
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
	
	/* this function for favourites property listing
	* 
	*/
	public function fetch_favourite_property_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {   
         
            $ret_=array();
            $s_qry="SELECT fp.i_user_id,fp.i_property_id,fp.dt_created_on,p.*,pt.s_name s_property_type,u.s_first_name,u.s_last_name,u.s_email,u.s_image,u.i_phone_verified,
            cu.d_currency_rate,cu.s_currency_symbol,CONCAT(u.s_first_name,' ',u.s_last_name) s_user_name 
             FROM ".$this->tbl_favourite_property." fp "
			." LEFT JOIN ".$this->tbl." p 				 ON p.i_id = fp.i_property_id "
            ." LEFT JOIN ".$this->tbl_user." u           ON fp.i_user_id=u.i_id "
            ." LEFT JOIN ".$this->tbl_currency." cu      ON p.i_currency_id=cu.i_id "
			." LEFT JOIN ".$this->tbl_property_type." pt ON pt.i_id = p.i_property_type_id "
           
                .($s_where!=""?$s_where:"" )." GROUP BY fp.i_property_id "." ORDER BY fp.dt_created_on DESC ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
             
          $rs=$this->db->query($s_qry);
		 //echo '<br>'.$this->db->last_query();
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer 
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);
				  $ret_[$i_cnt]["s_accommodation"]          = get_unformatted_string($row->e_accommodation_type);
				  $ret_[$i_cnt]["s_property_type"]          = get_unformatted_string($row->s_property_type);
				  $ret_[$i_cnt]["i_total_bedrooms"]         = intval($row->i_total_bedrooms);
				  $ret_[$i_cnt]["i_total_guests"]         	= intval($row->i_total_guests);
				  $ret_[$i_cnt]["s_description"]          	= get_unformatted_string($row->s_description);
				  
                  $ret_[$i_cnt]["s_lattitude"]              = get_unformatted_string($row->s_lattitude);
				  $ret_[$i_cnt]["s_longitude"]              = get_unformatted_string($row->s_longitude);
                  $ret_[$i_cnt]["s_zipcode"]                = get_unformatted_string($row->s_zipcode);
                  $ret_[$i_cnt]["d_standard_price"]         = $row->d_standard_price;
                  $ret_[$i_cnt]["d_weekly_price"]           = $row->d_weekly_price;
                  $ret_[$i_cnt]["d_monthly_price"]          = $row->d_monthly_price;
                  $ret_[$i_cnt]["d_additional_price"]       = $row->d_additional_price;
                  $ret_[$i_cnt]["dt_created_on"]            = date($this->conf["site_date_format"],intval($row->dt_created_on));                  
                  $ret_[$i_cnt]["i_status"]                 = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]                 = (intval($row->i_status)==1?"Active":"Inactive");
                  
				  $ret_[$i_cnt]["i_currency_id"]          	= intval($row->i_currency_id);
                  $ret_[$i_cnt]["d_currency_rate"]          = $row->d_currency_rate;
                  $ret_[$i_cnt]["s_currency_symbol"]        = get_unformatted_string($row->s_currency_symbol); 
                  
                  //from user table
                  $ret_[$i_cnt]["s_first_name"]             = get_unformatted_string($row->s_first_name); 
                  $ret_[$i_cnt]["s_last_name"]              = get_unformatted_string($row->s_last_name); 
                  $ret_[$i_cnt]["s_email"]                  = get_unformatted_string($row->s_email);
				  $ret_[$i_cnt]["s_image"]                  = get_unformatted_string($row->s_image); 
                  $ret_[$i_cnt]["s_country"]                = get_unformatted_string($row->s_country); 
                  $ret_[$i_cnt]["s_state"]                  = get_unformatted_string($row->s_state); 
                  $ret_[$i_cnt]["s_city"]                   = get_unformatted_string($row->s_city); 
				  $ret_[$i_cnt]["i_phone_verified"]         = get_unformatted_string($row->i_phone_verified);
				  
				  $s_where	=	"WHERE pi.i_property_id = ".$ret_[$i_cnt]["id"]." ";
				  $order_by	=	" ORDER BY RAND() ";
				  $ret_[$i_cnt]["s_property_image"]         = $this->fetch_property_image($s_where,$order_by,0,1);
				  
				  $s_where = " WHERE b.i_property_id=".$ret_[$i_cnt]["id"]." ";
				  $ret_[$i_cnt]["review_rate"]			= $this->fetch_rating_review($s_where);
				  
				  
				  
                  
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
	
	/* this function count total favourite property */
	public function gettotal_favourite_property_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_favourite_property." fp "
				." LEFT JOIN ".$this->tbl." p		ON p.i_id = fp.i_property_id "
                ." LEFT JOIN ".$this->tbl_user." u   ON fp.i_user_id=u.i_id "
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
	
        
    public function __destruct()
    {}                 
  
  
}
