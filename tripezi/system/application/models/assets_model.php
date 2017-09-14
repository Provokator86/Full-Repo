<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Model For Manage Assets
* 
* @package Manage Assets
* @subpackage 
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/amenity.php
* @link views/admin/assets/
*/


class Assets_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl_amenity;///used for this class
	private $tbl_property_type;
	private $tbl_bed_type;
	private $tbl_cancel_policy;
	

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl_amenity 		= $this->db->AMENITY; 
		  $this->tbl_property_type 	= $this->db->PROPERTYTYPE ;  
		  $this->tbl_bed_type 		= $this->db->PROPERTYBEDTYPE ;  
		  $this->tbl_cancel_policy 	= $this->db->PROPERTYCANCELLATIONPOLICY ;  
          $this->conf 				= & get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

   
	
	public function fetch_multi_sorted_cancellation_policy($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT c.* FROM ".$this->tbl_cancel_policy." c "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_description"]= nl2br(get_unformatted_string($row->s_description)); 
				  $ret_[$i_cnt]["d_cancellation_charge_percentage"]	= doubleval($row->d_cancellation_charge_percentage);                
                  $ret_[$i_cnt]["i_status"]		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function fetch_multi_sorted_property_type_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT p.* FROM ".$this->tbl_property_type." p "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name);                   
                  $ret_[$i_cnt]["i_status"]		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function fetch_multi_sorted_amenity_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT a.* FROM ".$this->tbl_amenity." a "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name);                   
                  $ret_[$i_cnt]["i_status"]		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function fetch_multi_sorted_bed_type_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT b.* FROM ".$this->tbl_bed_type." b "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name);                   
                  $ret_[$i_cnt]["i_status"]		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function gettotal_cancellation_policy_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="SELECT COUNT(*) as i_total "
                ."FROM ".$this->tbl_cancel_policy." c "
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
	
	public function gettotal_amenity_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="SELECT COUNT(*) as i_total "
                ."FROM ".$this->tbl_amenity." a "
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
	
	public function gettotal_property_type_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="SELECT COUNT(*) as i_total "
                ."FROM ".$this->tbl_property_type." p "
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
	
	public function gettotal_bed_type_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="SELECT COUNT(*) as i_total "
                ."FROM ".$this->tbl_bed_type." b "
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
	
	/* fetch a single record from cancellation_policy table */
	public function fetch_this_cancellation_policy($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT c.* FROM ".$this->tbl_cancel_policy." c "
                ." WHERE c.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]			= $row->i_id;////always integer
				  $ret_["s_name"]		= get_unformatted_string($row->s_name);
				  $ret_["s_description"]= get_unformatted_string($row->s_description); 
				  $ret_["d_cancellation_charge"]	= doubleval($row->d_cancellation_charge_percentage);
                  $ret_["i_status"]		= intval($row->i_status); 
				  $ret_["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
		  
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
	
	/* fetch a single record from amenity table */
	public function fetch_this_amenity($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT a.* FROM ".$this->tbl_amenity." a "
                ." WHERE a.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]			= $row->i_id;////always integer
				  $ret_["s_name"]		= get_unformatted_string($row->s_name);
                  $ret_["i_status"]		= intval($row->i_status); 
				  $ret_["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
		  
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
	
	/* fetch a single record from property_type table */
	public function fetch_this_property_type($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT p.* FROM ".$this->tbl_property_type." p "
                ." WHERE p.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]			= $row->i_id;////always integer
				  $ret_["s_name"]		= get_unformatted_string($row->s_name);
                  $ret_["i_status"]		= intval($row->i_status); 
				  $ret_["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
		  
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
	
	/* fetch a single record from bed_type table */
	public function fetch_this_bed_type($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="SELECT b.* FROM ".$this->tbl_bed_type." b "
                ." WHERE b.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]			= $row->i_id;////always integer
				  $ret_["s_name"]		= get_unformatted_string($row->s_name);
                  $ret_["i_status"]		= intval($row->i_status); 
				  $ret_["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
		  
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
          
	
	/* inserts new record for amenity */
	public function add_new_amenity($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_amenity." Set ";
                $s_qry.=" s_name=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_name"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl_amenity." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_name"])
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
	
	/* inserts new record for property type 
	* $this->tbl_property_type
	*/
	public function add_new_property_type($info)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_property_type." Set ";
                $s_qry.=" s_name=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_name"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl_property_type." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_name"])
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

      
	
	/* edit record for amenity */
	public function edit_amenity($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"UPDATE ".$this->tbl_amenity." SET ";
				$s_qry.=" s_name=? ";
                $s_qry.=" WHERE i_id=? ";
                
                $i_ret_ = $this->db->query($s_qry,array(        
												  get_formatted_string($info["s_name"]),
												  intval($i_id)

												 ));
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_amenity." ";
                    $logi["sql"]= serialize(array($s_qry,array(        
												  get_formatted_string($info["s_name"]),
												  intval($i_id)

												 )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $info,$i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
	/*========================== START OF Infmodel function declaration ===========================*/
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {}
    public function gettotal_info($s_where=null)
    {} 	
    public function fetch_this($i_id)
    {} 	
    public function add_info($info)
    {} 
	
	public function edit_info($info,$i_id)
    {}
    public function delete_info($i_id)
    {} 
	/*========================== END OF Infmodel function declaration ===========================*/


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
	
	
	
    public function fetch_amenity_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
          $s_qry="SELECT a.* FROM ".$this->tbl_amenity." a "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
        
            //echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]            = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]        = get_unformatted_string($row->s_name);                   
                  $ret_[$i_cnt]["i_status"]      = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]      = (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function fetch_property_type_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
          $s_qry="SELECT t.* FROM ".$this->tbl_property_type." t "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
        
            //echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]            = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]        = get_unformatted_string($row->s_name);                   
                  $ret_[$i_cnt]["i_status"]      = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]      = (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function fetch_bed_type_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
          $s_qry="SELECT b.* FROM ".$this->tbl_bed_type." b "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
        
            //echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]            = $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]        = get_unformatted_string($row->s_name);                   
                  $ret_[$i_cnt]["i_status"]      = intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]      = (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	public function fetch_cancellation_policy_list($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
          $s_qry="SELECT c.* FROM ".$this->tbl_cancel_policy." c "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
        
            //echo $s_qry;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]			= $row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]		= get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_description"]= nl2br(get_unformatted_string($row->s_description)); 
				  $ret_[$i_cnt]["d_cancellation_charge_percentage"]	= doubleval($row->d_cancellation_charge_percentage);
                  $ret_[$i_cnt]["i_status"]		= intval($row->i_status); 
				  $ret_[$i_cnt]["s_status"]		= (intval($row->i_status)==1?"Active":"Inactive");
                  
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
		
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>