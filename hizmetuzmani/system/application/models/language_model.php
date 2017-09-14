<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 29 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Language
* 
* @package Content Management
* @subpackage news
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/language.php
* @link views/admin/language/
*/


class Language_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $tbl_faq;
    private $tbl_cms;
	private $tbl_cat_type;
	private $tbl_cat;
	private $tbl_help;
    private $tbl_how_it_work;
   
    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl        	= $this->db->LANGUAGE;
          $this->tbl_faq    	= $this->db->FAQ;  
          $this->tbl_cms    	= $this->db->CMS; 
		  $this->tbl_cat_type  	= $this->db->CATEGORYTYPE; 
		  $this->tbl_cat  		= $this->db->CATEGORY;   
		  $this->tbl_help  		= $this->db->HELP; 
          $this->tbl_how_it_work= $this->db->HOWITWORKS;
          
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
			
			 $s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" )
				.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
        
		  
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
                  $ret_[$i_cnt]["s_language"]       =   get_unformatted_string($row->s_language);
				  $ret_[$i_cnt]["s_flag_image"]     =   get_unformatted_string($row->s_flag_image); 
				  $ret_[$i_cnt]["s_short_name"]     =   get_unformatted_string($row->s_short_name); 
                  $ret_[$i_cnt]["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_[$i_cnt]["i_selected"]       =   intval($row->i_default); 
				  $ret_[$i_cnt]["s_selected"]       =   (intval($row->i_default)==1?"Yes":"No");
                  $ret_[$i_cnt]["i_is_active"]      =   intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
                  
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
	
	
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
		
        try
        {
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
		  $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
                  $ret_[$i_cnt]["s_language"]       =   get_unformatted_string($row->s_language);
				  $ret_[$i_cnt]["s_flag_image"]     =   get_unformatted_string($row->s_flag_image); 
				  $ret_[$i_cnt]["s_short_name"]     =   get_unformatted_string($row->s_short_name); 
                  $ret_[$i_cnt]["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_[$i_cnt]["i_selected"]       =   intval($row->i_default); 
				  $ret_[$i_cnt]["s_selected"]       =   (intval($row->i_default)==1?"Yes":"No");
                  $ret_[$i_cnt]["i_is_active"]      =   intval($row->i_status); 
				  $ret_[$i_cnt]["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
                  
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
                ."From ".$this->tbl." n "
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
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]               =   $row->i_id;////always integer
                  $ret_["s_language"]       =   get_unformatted_string($row->s_language);
				  $ret_["s_short_name"]     =   get_unformatted_string($row->s_short_name);
				  $ret_["s_flag_image"]     =   get_unformatted_string($row->s_flag_image); 
                  $ret_["dt_created_on"]    =   date($this->conf["site_date_format"],intval($row->dt_entry_date)); 
				  $ret_["i_selected"]       =   intval($row->i_default); 
				  $ret_["s_selected"]       =   (intval($row->i_default)==1?"Yes":"No");
                  $ret_["i_is_active"]      =   intval($row->i_status); 
				  $ret_["s_is_active"]      =   (intval($row->i_status)==1?"Active":"Inactive");
		  
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
                $s_qry.=" s_language=? ";
                $s_qry.=", s_short_name=? "; 
                $s_qry.=", s_flag_image=? ";
				//$s_qry.=", i_default=? ";
                //$s_qry.=", i_status=? ";
                $s_qry.=", dt_entry_date=? ";
                
                $this->db->query($s_qry,array(
												  get_formatted_string($info["s_language"]),
                                                  get_formatted_string($info["s_short_name"]), 
												  get_formatted_string($info["s_flag_image"]),
												  //intval($info["i_default"]),
												  //intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(
												  get_formatted_string($info["s_language"]),
                                                  get_formatted_string($info["s_short_name"]),  
												  get_formatted_string($info["s_flag_image"]),
												  //intval($info["i_default"]),
												  //intval($info["i_status"]),
												  intval($info["dt_entry_date"])
												 )) ) ;
                                                 
                    $this->log_info($logi);
                   
                    $this->add_lang_column(trim($info["s_short_name"]))  ; 
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
            $info_lang  =   $this->fetch_this($i_id);
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_language=? ";
                $s_qry.=", s_short_name=? ";
                $s_qry.=", s_flag_image=? ";
				//$s_qry.=", i_default=? ";
                //$s_qry.=", i_status=? ";
				$s_qry.=", dt_entry_date=? ";
                $s_qry.=" Where i_id=? ";
                
                $this->db->query($s_qry,array(

												  get_formatted_string($info["s_language"]),
                                                  get_formatted_string($info["s_short_name"]), 
												  get_formatted_string($info["s_flag_image"]),
												  //intval($info["i_default"]),
												  //intval($info["i_status"]),
												  intval($info["dt_entry_date"]),
												  intval($i_id)
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
				
					if($info["s_short_name"]!=$info_lang["s_short_name"])
                    {
                        $this->change_column_name($info_lang["s_short_name"],$info["s_short_name"])  ;
                    }
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(

												  get_formatted_string($info["s_language"]),
                                                  get_formatted_string($info["s_short_name"]),  
												  get_formatted_string($info["s_flag_image"]),
												  //intval($info["i_default"]),
												  //intval($info["i_status"]),
												  intval($info["dt_entry_date"]),
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
	
	
	/****  FOR CHECKING DEFAULT LANGUAGE SLECTED   *****/
	public function set_default_language($info,$id)
	{
		try
		{
			$i_ret_=0;////Returns false
			if(!empty($info))
			{
				if($info['i_default'] == 1)
				{
					$s_qry	=	"Update ".$this->tbl." Set ";
					$s_qry.=" i_default= ?";
					$s_qry.=" Where i_default=? ";
					
					$this->db->query($s_qry,array(
													intval(0),
													intval(1)
												));
					$i_ret_=$this->db->affected_rows();   
					
					$s_qry_1	=	"Update ".$this->tbl." Set ";
					$s_qry_1.=" i_default= ?";
					$s_qry_1.=" Where i_id=? ";
					
					$this->db->query($s_qry_1,array(
														intval($info["i_default"]),
														intval($id)
													));
					if($i_ret_)
					{
						$logi["msg"]="Updating ".$this->tbl." ";
						$logi["sql"]= serialize(array($s_qry,array(
													intval(0),
													intval(1)
												)) ) ;                                 
						$this->log_info($logi); 
						$logi_1["msg"]="Updating ".$this->tbl." ";
						$logi_1["sql"]= serialize(array($s_qry_1,array(
														intval($info["i_default"]),
														intval($id)
													)) ) ;                                 
						$this->log_info($logi_1); 
						unset($logi);
					}  
				}
				else
				$i_ret_ = true;
			}
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
                $info_lang  =   $this->fetch_this($i_id) ;
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    
                    if(!empty($info_lang))
                    {
                        $this->remove_column_name($info_lang['s_short_name']) ;
                    }
                    $logi["msg"]="Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
            {
                $info_lang  =   $this->fetch_multi() ;
				$s_qry="DELETE FROM ".$this->tbl." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    
                    if(!empty($info_lang))
                    {
                        foreach($info_lang as $value)
                        {
                            $this->remove_column_name($value['s_short_name']) ;
                        }
                        
                    }
                    
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
    
    /**
    * Add new column to the tables contain multiple language field
    *  
	* By Koushik Rout
    * @param String language prefix "en,fr,ger...."
    * Column properties can be type,constraint,null,default,auto_increment
    */ 
	
    public function add_lang_column($s_lang_prefix='')
    {
        try
        {
            $this->load->dbforge(); //load dbforge class to manipulation table. 
            ///////ADD COLUMN FAQ TABLE////////  
            $fields = array(
                        $s_lang_prefix.'_s_question'  => array('type' => 'TEXT',
																'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',	
                                                                'null'=>FALSE),
                        $s_lang_prefix.'_s_answer'    => array('type' => 'TEXT',
															    'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',
                                                               'null'=>FALSE)
                        
                        );
            $this->dbforge->add_column($this->tbl_faq, $fields);
            /////Updating log for faq table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_faq." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi);
            
            ///////ADD COLUMN CMS TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_title'  => array('type' => 'VARCHAR',
															 'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',
                                                            'constraint'=>100,
                                                              'null'=>FALSE),
                        $s_lang_prefix.'_s_description'    => array('type' => 'TEXT',
																    'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',
                                                              'null'=>FALSE)
                        
                        );
            $this->dbforge->add_column($this->tbl_cms, $fields);
            /////Updating log for cms table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_cms." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi);
		
			
			///////ADD COLUMN  CATEGORY TABLE////////$this->tbl_help
            $fields = array(
                        $s_lang_prefix.'_s_category_name'    => array('type' => 'VARCHAR',
															  'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',
															  'constraint'=>255,
                                                              'null'=>FALSE)
                        
                        );
            $this->dbforge->add_column($this->tbl_cat, $fields);
            /////Updating log for CATEGORY table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_cat." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi); 
           
			///////ADD COLUMN  HELP TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_question'  => array('type' => 'TEXT',
															  'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',
                                                              'null'=>FALSE),
                        $s_lang_prefix.'_s_answer'    => array('type' => 'TEXT',
															  'charset'=>'utf8',
															    'collate'=>'utf8_general_ci',	
                                                              'null'=>FALSE)
                        
                        );
            $this->dbforge->add_column($this->tbl_help, $fields);
            
            /////Updating log for HELP table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_help." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi); 
            
            ///////ADD COLUMN  HOW IT WORKS TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_content1'  => array('type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',
                                                              'null'=>FALSE),
                        $s_lang_prefix.'_s_content2'    => array('type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE),
                       $s_lang_prefix.'_s_content3'    => array('type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE),
                       $s_lang_prefix.'_s_content4'    => array('type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE),
                       $s_lang_prefix.'_s_content5'    => array('type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE)                                       
                        
                        );
            $this->dbforge->add_column($this->tbl_how_it_work, $fields);
            
            /////Updating log for HOW IT WORKS table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_how_it_work." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi); 
			
            unset($fields,$logi); 
			 
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }
    
    /**
    * this function is to remove column name in each table which are language specific
    * 
    * @param string $s_lang_prefix
    * @return string
    */
    public function remove_column_name($s_lang_prefix='')
    {
        try
        {
             $this->load->dbforge(); //load dbforge class to manipulation table. 
            ///////REMOVE COLUMN FROM FAQ TABLE////////  
            
            $this->dbforge->drop_column($this->tbl_faq, $s_lang_prefix.'_s_question');
            $this->dbforge->drop_column($this->tbl_faq, $s_lang_prefix.'_s_answer');

            ///////REMOVE COLUMN FROM CMS TABLE////////

            $this->dbforge->drop_column($this->tbl_cms, $s_lang_prefix.'_s_title');
            $this->dbforge->drop_column($this->tbl_cms, $s_lang_prefix.'_s_description');           
            

            ///////REMOVE COLUMN FROM CATEGORY TABLE////////
           
            $this->dbforge->drop_column($this->tbl_cat, $s_lang_prefix.'_s_category_name');
			
			///////REMOVE COLUMN FROM HELP////////
			$this->dbforge->drop_column($this->tbl_help, $s_lang_prefix.'_s_question');
            $this->dbforge->drop_column($this->tbl_help, $s_lang_prefix.'_s_answer');
            
            ///////REMOVE COLUMN FROM HOW IT WORK////////
            $this->dbforge->drop_column($this->tbl_how_it_work, $s_lang_prefix.'_s_content1');
            $this->dbforge->drop_column($this->tbl_how_it_work, $s_lang_prefix.'_s_content2');
            $this->dbforge->drop_column($this->tbl_how_it_work, $s_lang_prefix.'_s_content3');
            $this->dbforge->drop_column($this->tbl_how_it_work, $s_lang_prefix.'_s_content4');
            $this->dbforge->drop_column($this->tbl_how_it_work, $s_lang_prefix.'_s_content5');
			
            unset($s_lang_prefix) ;
           
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
   
   /**
   * Time of edit language if short name change table name also change accordingly
   *  
   * @param string $s_lang_prefix
   * @param string $new_lang_prefix
   */
    public function change_column_name($s_lang_prefix='',$new_lang_prefix='')
    {
        try
        {
            $this->load->dbforge(); //load dbforge class to manipulation table. 
            ///////UPDATE COLUMN FAQ TABLE////////  
            $fields = array(
                        $s_lang_prefix.'_s_question'  => array( 'name'=> $new_lang_prefix.'_s_question',
                                                                'type' => 'TEXT',
                                                                'null'=>FALSE),
                        $s_lang_prefix.'_s_answer'    => array(
                                                                'name'=> $new_lang_prefix.'_s_answer',
                                                                'type' => 'TEXT',
                                                                'null'=>FALSE)
                        
                        );
            $this->dbforge->modify_column($this->tbl_faq, $fields);
            /////Updating log for faq table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_faq." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi);
            
            ///////UPDATE COLUMN CMS TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_title'  => array(    'name'=> $new_lang_prefix.'_s_title',
                                                                'type' => 'VARCHAR',
                                                                'constraint'=>100,
                                                                'null'=>FALSE),
                        $s_lang_prefix.'_s_description'    => array( 
                                                                    'name'=> $new_lang_prefix.'_s_description',
                                                                    'type' => 'TEXT',
                                                                    'null'=>FALSE)
                        
                        );
            $this->dbforge->modify_column($this->tbl_cms, $fields);
            /////Updating log for cms table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_cms." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi);
            
           
          
            
            ///////UPDATE COLUMN  CATEGORY TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_category_name'    => array(
                                                                        'name'=> $new_lang_prefix.'_s_category_name',
                                                                        'type' => 'VARCHAR',
                                                                        'constraint'=>255,
                                                                        'null'=>FALSE)
                        
                        );
            $this->dbforge->modify_column($this->tbl_cat, $fields);
            /////Updating log for CATEGORY table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_cat." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi); 
            unset($fields,$logi); 
			
			///////UPDATE COLUMN  HELP TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_question'  => array( 'name'=> $new_lang_prefix.'_s_question',
                                                                'type' => 'TEXT',
                                                                'null'=>FALSE),
                        $s_lang_prefix.'_s_answer'    => array(
                                                                'name'=> $new_lang_prefix.'_s_answer',
                                                                'type' => 'TEXT',
                                                                'null'=>FALSE)
                        
                        );
            $this->dbforge->modify_column($this->tbl_help, $fields);
            /////Updating log for HELP table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_help." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi); 
            unset($fields,$logi); 
            
            
             ///////UPDATE COLUMN  HOW IT WORKS TABLE////////
            $fields = array(
                        $s_lang_prefix.'_s_content1'  => array('name'=> $new_lang_prefix.'_s_content1',
                                                                'type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',
                                                              'null'=>FALSE),
                        $s_lang_prefix.'_s_content2'    => array('name'=> $new_lang_prefix.'_s_content2',
                                                                'type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE),
                       $s_lang_prefix.'_s_content3'    => array('name'=> $new_lang_prefix.'_s_content3',
                                                                'type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE),
                       $s_lang_prefix.'_s_content4'    => array('name'=> $new_lang_prefix.'_s_content4',
                                                                'type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE),
                       $s_lang_prefix.'_s_content5'    => array('name'=> $new_lang_prefix.'_s_content5',
                                                                'type' => 'TEXT',
                                                              'charset'=>'utf8',
                                                                'collate'=>'utf8_general_ci',    
                                                              'null'=>FALSE)                                       
                        
                        );
            $this->dbforge->modify_column($this->tbl_how_it_work, $fields);
			/////Updating log for HOW IT WORKS table//////
            $logi["msg"]    =   "Altering table  ".$this->tbl_how_it_work." ";
            $logi["sql"]    =   $this->db->last_query();                              
            $this->log_info($logi); 
             
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    public function fetch_language_list()
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.i_id,n.s_language FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]               =   $row->i_id;////always integer
                  $ret_[$i_cnt]["s_language"]       =   get_unformatted_string($row->s_language);
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
    public function __destruct()
    {}                 
  
  
}
///end of class
?>