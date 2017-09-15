<?php
/*********
* Author: Iman Biswas
* Date  : 9 June 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For News
* 
* @package Content Management
* @subpackage news
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/news.php
* @link views/admin/news/
*/


class Category_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->CATEGORY;
		  $this->tbl_child = $this->db->CATEGORYCHILD;
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
	
	 public function fetch_multi_cat_temp($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT c.* FROM ".$this->tbl." c "
                .($s_where!=""?$s_where:"" )
				." ORDER BY s_category_name "
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_category_name"]=get_unformatted_string($row->s_category_name); 
				  $ret_[$i_cnt]["s_category_type"]=get_unformatted_string($this->db->CATEGORY_TYPE[$row->s_category_type]); 				  
                  $ret_[$i_cnt]["dt_created_on"]=date($this->conf["site_date_format"],strtotime($row->dt_created_on)); 
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]=(intval($row->i_status)==1?"Active":"Inactive");  
				  
				  
				  // to get cms-help page section in frontend
				  $CI =& get_instance();	
				  $s_where = " WHERE n.i_help_cat=".$row->id." ";				  
				  $CI->load->model('help_model','mod_help',true);
				  $ret_[$i_cnt]["ques_ans"] = $CI->mod_help->fetch_question_answer($s_where);
				                  
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT c.id,c.s_category_type,c.dt_created_on,c.i_status,
		  			cc.s_name,cc.i_lang_id FROM ".$this->tbl." c LEFT JOIN {$this->tbl_child} cc ON c.id = cc.i_cat_id"
                .($s_where!=""?$s_where:"" ).' ORDER BY cc.s_name ASC '
				.(is_numeric($i_start) && is_numeric($i_limit)?"  Limit ".intval($i_start).",".intval($i_limit):"" );
		//echo $s_qry; exit;
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_category_name"]=get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_category_type"]=get_unformatted_string($this->db->CATEGORY_TYPE[$row->s_category_type]); 				  
                  $ret_[$i_cnt]["dt_created_on"]=date($this->conf["site_date_format"],$row->dt_created_on); 
                  $ret_[$i_cnt]["i_is_active"]=intval($row->i_status); 
				  $ret_[$i_cnt]["i_lang_id"]=intval($row->i_lang_id); 
				  $ret_[$i_cnt]["s_is_active"]=(intval($row->i_status)==1?"Active":"Inactive");  
				  
				  
				  // to get cms-help page section in frontend
				  $CI =& get_instance();	
				  $s_where = " WHERE n.i_help_cat=".$row->id." ";				  
				  $CI->load->model('help_model','mod_help',true);
				  $ret_[$i_cnt]["ques_ans"] = $CI->mod_help->fetch_question_answer($s_where);
				                  
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
	
	
	
	// for frontend cms page help
	public function fetch_help_content($s_where=null,$i_start=null,$i_limit=null,$lang_query)
    {
        try
        {
          $ret_=array();
		   $s_qry="SELECT c.*,cc.s_name FROM ".$this->tbl." c LEFT JOIN {$this->tbl_child} cc ON c.id = cc.i_cat_id"
                .($s_where!=""?$s_where:"" )
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
		  
          if($rs->num_rows()>0)
          {		$CI =& get_instance();
		  		$CI->load->model('help_model','mod_help',true);
				 	
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_category_name"]=get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_category_type"]=get_unformatted_string($this->db->CATEGORY_TYPE[$row->s_category_type]); 				  
				  // to get cms-help page section in frontend
				  
				  $s_where = " WHERE n.i_help_cat=".$row->id.$lang_query;				  
				 
				  $ret_[$i_cnt]["ques_ans"] = $CI->mod_help->fetch_question_answer($s_where);
				                  
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
	
	
	
	// for frontend cms page job poster question, answer
	public function fetch_buyer_faq_content($s_where=null,$i_start=null,$i_limit=null,$lang_query,$i_lang_id=1)
    {
        try
        {
          $ret_=array();
		    $s_qry="SELECT c.*,cc.s_name FROM ".$this->tbl." c LEFT JOIN {$this->tbl_child} cc ON c.id = cc.i_cat_id"
                .($s_where!=""?$s_where." AND cc.i_lang_id=$i_lang_id":" WHERE cc.i_lang_id=$i_lang_id" )
				.(is_numeric($i_start) && is_numeric($i_limit)?" ORDER BY cc.s_name Limit ".intval($i_start).",".intval($i_limit):"" );
		
          $rs=$this->db->query($s_qry);
		  //echo  $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {		$CI =& get_instance();
		  		$CI->load->model('faq_model','mod_faq',true);
				 	
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_category_name"]=get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_category_type"]=get_unformatted_string($this->db->CATEGORY_TYPE[$row->s_category_type]); 				  
				  // to get cms-help page section in frontend
				  
				  $s_where = " WHERE n.i_faq_cat=".$row->id.$lang_query;				  
				 
				  $ret_[$i_cnt]["ques_ans"] = $CI->mod_faq->fetch_question_answer($s_where);
				                  
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
	
	
	
	// for frontend cms page tradesman question, answer
	public function fetch_tradesman_faq_content($s_where=null,$i_start=null,$i_limit=null,$lang_query,$i_lang_id=1)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT c.*,cc.s_name FROM ".$this->tbl." c LEFT JOIN {$this->tbl_child} cc ON c.id = cc.i_cat_id"
                .($s_where!=""?$s_where." AND cc.i_lang_id=$i_lang_id":" WHERE cc.i_lang_id=$i_lang_id" )
				.(is_numeric($i_start) && is_numeric($i_limit)?" ORDER BY cc.s_name Limit ".intval($i_start).",".intval($i_limit):"" );
		
          $rs=$this->db->query($s_qry);
		//  echo $s_qry;
          $i_cnt=0;
          if($rs->num_rows()>0)
          {		$CI =& get_instance();
		  		$CI->load->model('faq_tradesmen_model','mod_faq_tradesman',true);
				 	
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_category_name"]=get_unformatted_string($row->s_name); 
				  $ret_[$i_cnt]["s_category_type"]=get_unformatted_string($this->db->CATEGORY_TYPE[$row->s_category_type]); 				  
				  // to get cms-help page section in frontend
				  
				  $s_where = " WHERE n.i_faq_cat=".$row->id.$lang_query;				  
				 
				  $ret_[$i_cnt]["ques_ans"] = $CI->mod_faq_tradesman->fetch_question_answer($s_where);
				                  
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
                ."From ".$this->tbl." c  LEFT JOIN {$this->tbl_child} cc ON c.id = cc.i_cat_id"
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
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
         $s_qry="SELECT c.s_category_name, c.s_category_type, c.i_parent_id, 
		 			c.dt_created_on,c.i_status, c1.s_category_name s_parent_category FROM 
		  		    ".$this->tbl." c "
		  		    ." LEFT JOIN {$this->tbl} c1"
				    ." ON c.i_parent_id = c1.id"
                    ." Where c.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		  //echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
				  $ret_["s_category_name"]=get_unformatted_string($row->s_category_name);
				  $ret_["s_category_type"] = get_unformatted_string($row->s_category_type);
				  $ret_["s_parent_category"] = get_unformatted_string($row->s_parent_category);
                  $ret_["i_parent_id"] = intval($row->i_parent_id);
				  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_is_active"]= intval($row->i_status); 
				  $ret_["s_is_active"]=(intval($row->i_status)==1?"Active":"Inactive");
		  
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
	
	
	public function fetch_this_cat_name($i_id,$i_lang)
    {
        try
        {
          $ret_=array();
		  $s_where = " WHERE cc.i_cat_id ={$i_id} And cc.i_lang_id = {$i_lang} ";
          ////Using Prepared Statement///
         $s_qry="SELECT c.id,c.s_category_type,c.dt_created_on,c.i_status,
		  			cc.s_name,cc.i_lang_id FROM ".$this->tbl." c LEFT JOIN {$this->tbl_child} cc ON c.id = cc.i_cat_id"
                .($s_where!=""?$s_where:"" ).' ORDER BY cc.s_name ASC '
				.(is_numeric($i_start) && is_numeric($i_limit)?"  Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		  //echo $this->db->last_query();
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->id;////always integer
				  $ret_["s_category_name"]=get_unformatted_string($row->s_name);
				  $ret_["s_category_type"] = get_unformatted_string($row->s_category_type);
				  $ret_["s_parent_category"] = get_unformatted_string($row->s_parent_category);
                  $ret_["i_parent_id"] = intval($row->i_parent_id);
				  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_is_active"]= intval($row->i_status); 
				  $ret_["s_is_active"]=(intval($row->i_status)==1?"Active":"Inactive");
		  
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
	
	
	
	public function fetch_this_category($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
         $s_qry="SELECT * FROM 
		  		    ".$this->tbl_child." c "
                    ." Where c.i_cat_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
		  //echo $this->db->last_query();
		  $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
				  $ret_[$i_cnt]["i_lang_id"]=$row->i_lang_id;
				  $ret_[$i_cnt]["s_name"]=get_unformatted_string($row->s_name);	
				  $i_cnt++;	  
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
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                //$s_qry.="  s_category_name=? ";
                $s_qry.=" s_category_type=? ";
				$s_qry.=", i_parent_id=? ";
				$s_qry.=", dt_created_on=? ";
				$s_qry.=", i_status=? ";
                
                $this->db->query($s_qry,array(
												  //get_formatted_string($info["s_category_name"]),
												  get_formatted_string($info["s_category_type"]),
												  intval($info["i_parent_id"]),
												  intval($info["dt_created_on"]),
												  intval($info["i_status"])	
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  //get_formatted_string($info["s_category_name"]),
												  get_formatted_string($info["s_category_type"]),
												  intval($info["i_parent_id"]),
												  intval($info["dt_created_on"]),
												  intval($info["i_status"])	
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
    {
        try
        {
			//var_dump($info);exit;
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				//$s_qry.=" s_category_name=? ";
                $s_qry.=" s_category_type=? ";
				$s_qry.=", i_parent_id=? ";
                $s_qry.=", i_status=? ";
				$s_qry.=", dt_created_on=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(  //get_formatted_string($info["s_category_name"]),
												get_formatted_string($info["s_category_type"]),
												intval($info["i_parent_id"]),
												intval($info["i_status"]),
												intval($info["dt_created_on"]),
												intval($i_id)

                                             ));
                $i_ret_=$this->db->affected_rows(); 
				//echo   $i_ret_; exit;
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(  
												//get_formatted_string($info["s_category_name"]),
												get_formatted_string($info["s_category_type"]),
												intval($info["i_parent_id"]),
												intval($info["i_status"]),
												intval($info["dt_created_on"]),
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
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl." ";
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
	
	/* insert categories for multilingual */
	public function add_categories($info,$i_cat_id)
    {
        try
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
				$this->delete_previous_category($i_cat_id);
				
				foreach($info as $key=>$val)
				{
                $s_qry="Insert Into ".$this->tbl_child." Set ";
                $s_qry.=" s_name=? ";
				$s_qry.=", i_lang_id=? ";
				$s_qry.=", i_cat_id=? ";
                
                $this->db->query($s_qry,array(  
												  get_formatted_string($val),
												  intval($key),
												  intval($i_cat_id)	
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl_child." ";
                    $logi["sql"]= serialize(array($s_qry,array(  
												  get_formatted_string($val),
												  intval($key),
												  intval($i_cat_id)	
												 )) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }
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
	
	/* delete previous category setting */
	public function delete_previous_category($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_child." ";
                $s_qry.=" Where i_cat_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_child." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl_child." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl_child." ";
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
	  
	
	/****** for checking duplicate category while insert category ******/
	public function fetch_duplicate_category($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          $ret_=array();
		  $s_qry="SELECT * FROM ".$this->tbl." c "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_category_name"]=get_unformatted_string($row->s_category_name); 
				  $ret_[$i_cnt]["s_category_type"]=get_unformatted_string($row->s_category_type);
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
	
	
	/*
	* recursive function to create category as tree structure
	*/
	
    function get_cat_selectlist($item_type='',$current_cat_id=0, $count=0,$show_child=-1)
    {
        static $option_results;
        if (!isset($current_cat_id))
            $current_cat_id =0;
        $sub_cond   = '';
        if($item_type && $item_type!='-1')
            $sub_cond   .= " and s_category_type='$item_type'";
        $count = $count+1;

        $sql = "SELECT id, s_category_name from {$this->tbl} where i_parent_id = $current_cat_id $sub_cond order by s_category_name";

        $get_options = mysql_query($sql);
        $num_options = mysql_num_rows($get_options);
        if ($num_options > 0)
        {
            while ($row = mysql_fetch_array($get_options))
            {
                if ($current_cat_id!=0)
                {
                    $indent_flag = "";
                    for ($x=2; $x<=$count; $x++)
                        $indent_flag .= "&nbsp;&nbsp;&nbsp;";
                }
                $cat_name = (isset($indent_flag))?$indent_flag:'';
                $cat_name.= $row['s_category_name'];
                $option_results["{$row['id']}"] = $cat_name;
                if($show_child>0)
                    $this->get_cat_selectlist($item_type,$row['id'], $count,$show_child );
            }
        }
        return $option_results;
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
	function set_data_insert($tableName,$arr)
    {
        if( !$tableName || $tableName=='' ||  count($arr)==0 )
			return false;
		if($this->db->insert($tableName, $arr))
            return $this->db->insert_id();
        else
            return false;
    }	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>