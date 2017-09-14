<?php
/*********
* Author: Samarendu Ghosh
* Date  : 187 Oct 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For Tradesman
* 
* @package Content Management
* @subpackage Testimonial
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/find_tradesman.php
* @link views/fe/find_tradesman/
*/


class Recommend_model extends MY_Model 
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_city;
	private $tbl_zip;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->USERMANAGE;  
		  $this->tbl_city = $this->db->CITY;   
		  $this->tbl_zip = $this->db->ZIPCODE;  
		  $this->tbl_state = $this->db->STATE; 
		  $this->tbl_user_image = $this->db->USREIMAGE;   
		  $this->tbl_tradesman_detail = $this->db->TRADESMANDETAILS;
		  $this->tbl_tradesman_cat = $this->db->TRADESMANCAT; 
		  $this->tbl_cat = $this->db->CATEGORY; 
		  $this->tbl_news_subscript = $this->db->NEWSLETTERSUBCRIPTION;  
		  $this->tbl_testimonial = $this->db->TESTIMONIAL; 
		  
		  $this->tbl_recom = $this->db->REFERRER;
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_recom." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			//	echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_referred_email); 
				  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_referred_name); 
                  $ret_[$i_cnt]["dt_recommend_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 
				  //$ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Accepted":"Pending");
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Registered":"Pending Registration");
                  
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
	
	
	
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {	
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_recom." n "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}" .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
			//	echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_email"]			=	get_unformatted_string($row->s_referred_email); 
				  $ret_[$i_cnt]["s_name"]			=	get_unformatted_string($row->s_referred_name); 
                  $ret_[$i_cnt]["dt_recommend_on"]	=	date($this->conf["site_date_format"],intval($row->i_created_date)); 
				  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 
				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Accepted":"Pending");
                  
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
	
    /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_featured($s_where=null,$order_by,$i_start=null,$i_limit=null)
    {}
	
	
    
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
                ."From ".$this->tbl_recom."  n "
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
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
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
    {}            
        
    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_info($email,$name,$info,$id)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($email))
            {
				//$is_exist = $this->check_email($email);
				
				//if($is_exist<=0)
				
                $s_qry="Insert Into ".$this->tbl_recom." Set ";                
                $s_qry.=" s_referred_name=? ";
				$s_qry.=", s_referred_email=? ";
				$s_qry.=", s_referred_code=? ";				
				$s_qry.=", i_referrer_id=? ";	
				$s_qry.=", i_is_active=? ";			
				
                $s_qry.=", i_created_date=? ";
                
                $this->db->query($s_qry,array(  
												  get_formatted_string($name),
												  get_formatted_string($email),
												  trim(htmlspecialchars($info["s_verification_code"], ENT_QUOTES, 'utf-8')),
												  intval($id),
												  intval(0),
												  intval(time())
												 ));
												 
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
					
					
                    $logi["msg"]="Inserting into ".$this->tbl_recom." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  
												  get_formatted_string($value[0]),
												  get_formatted_string($val[0]),
												  trim(htmlspecialchars($info["s_referred_code"], ENT_QUOTES, 'utf-8')),
												  intval($id),
												  intval(0),
												  intval(time())
												 )) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }
            }
            unset($s_qry, $info );
            return $i_ret_;
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
    {}   
	
	
	public function update_status($info,$code)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_recom." Set ";
                $s_qry.=" i_is_active=? ";
                $s_qry.=" Where s_referred_code=? ";
                
                $this->db->query($s_qry,array(
                                                      intval($info["i_is_active"]),
													  get_formatted_string($code)
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_recom." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                                      intval($info["i_is_active"]),
													  get_formatted_string($code)
                                                     )) ) ;                                
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }    
	
	/* check for duplicate emails */
	 public function check_email($mail,$user_id)
    {
        try
        {
          $ret_=0;
           $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_recom." "
                ." Where s_referred_email='".$mail."' AND  i_referrer_id=".$user_id;
				
          $rs=$this->db->query($s_qry);
		  
		   $s_qry1="Select count(*) as i_total "
                ."From ".$this->db->USERMANAGE." "
                ." Where s_email='".$mail."' ";
				
          $rs1=$this->db->query($s_qry1);
          $i_cnt=0;
		//   echo $ret_;
          if($rs->num_rows()>0)
          {
		  	 foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }  
			//  echo $ret_;
		  	if($ret_!=0)
			$ret_ =1;
          }
		  if($rs1->num_rows()>0 &&$ret_==0)
          {
		  	 foreach($rs1->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }  
		  	if($ret_!=0)
			   $ret_ = 2;        
          }
		 // echo $ret_;
         
          return $ret_;
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
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_recom." ";
                $s_qry.=" Where id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_recom." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                
            }
            unset($s_qry, $i_id);
            return $i_ret_;
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