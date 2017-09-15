<?php
/*********
* Author: Iman Biswas
* Date  : 14 sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For User Type Master
* 
* @package User
* @subpackage Access Control
* 
* @includes infModel.php 
* @includes MY_Model.php
* 
* @link MY_Model.php
*/


class User_type_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl=$this->db->USER_TYPE;          
          $this->conf=&get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
		
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl." ut "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              //while($row=)
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->id;////always integer
                  $ret_[$i_cnt]["s_user_type"]=stripslashes($row->s_user_type); 
                  $ret_[$i_cnt]["i_created_by"]=intval($row->i_created_by); 
                  $ret_[$i_cnt]["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_[$i_cnt]["i_status"]=intval($row->i_status); 
                  $ret_[$i_cnt]["s_status"]=(intval($row->i_status)==1?"Active":"Inactive"); 
                  
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
                ."From ".$this->tbl." ut "
                .($s_where!=""?$s_where:"" );
          //echo $s_qry;      
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              //while($row=)
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
          //return $this->db->count_all($this->tbl);
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
                ."From ".$this->tbl." ut  "
                ." Where ut.id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_["id"]=$row->id;////always integer
                  $ret_["s_user_type"]=stripslashes($row->s_user_type); 
                  $ret_["dt_created_on"]=date($this->conf["site_date_format"],intval($row->dt_created_on)); 
                  $ret_["i_status "]=intval($row->i_status ); 
                  $ret_["s_status"]=(intval($row->i_status )==1?"Active":"Inactive"); 
				  
				  $ret_["access_controll_array"] = $this->fetch_controller_access($ret_["id"]);
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
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" s_user_type=? ";
                $s_qry.=", dt_created_on=? ";
                //$s_qry.=", i_is_deleted=?";  ///have default value
                
                $this->db->query($s_qry,array(addslashes(htmlspecialchars(trim($info["s_user_type"]))),
                                                      intval($info["dt_created_on"])
                                                     ));
                $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    $logi["msg"]="Inserting into ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(addslashes(htmlspecialchars(trim($info["s_user_type"]))),
                                                      intval($info["dt_created_on"])
                                                     )) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }
            }
            unset($s_qry);
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
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry="Update ".$this->tbl." Set ";
                $s_qry.=" s_user_type=? ";
                //$s_qry.=", i_created_by=? ";
                //$s_qry.=", dt_created_on=? ";
                //$s_qry.=", i_is_deleted=? ";  ///have default value
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array( addslashes(htmlspecialchars(trim($info["s_user_type"]))) ,
                                                      /*intval($info["i_created_by"]),
                                                      intval($info["dt_created_on"]),*/
                                                      intval($i_id)
                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(addslashes(htmlspecialchars(trim($info["s_user_type"]))),
                                                      intval($info["i_created_by"]),
                                                      intval($info["dt_created_on"]),
                                                      intval($i_id)
                                                     )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry);
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
                $s_qry="Update ".$this->tbl." Set i_is_deleted=1 ";
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
                $s_qry="Update ".$this->tbl." Set i_is_deleted=1 ";
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
            unset($s_qry);
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
            $logindata=$this->session->userdata("loggedin");
            return $this->write_log($attr["msg"],decrypt($logindata["user_id"]),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	 /******
    * This method will fetch all records regarding controller access from the db. 
    *  * @param int $s_controller, i_user_type_id 
    
    * @returns array
    */
	public function fetch_controller_access($i_user_type_id=null,$s_controller=null)
    {
        try
        {
          $ret_=array();
          /////////////////Define your query here/////////////
		  $s_qry="Select uta.id,uta.i_user_type_id,uta.s_controller,uta.i_action_add,uta.i_action_edit,uta.i_action_delete,ut.s_user_type
                 ,uta.dt_created_on,uta.i_is_deleted  "
                ."From ".$this->db->USER_TYPE_ACCESS." uta "
				."Left Join ".$this->db->USER_TYPE." ut On uta.i_user_type_id=ut.id "
                ." Where uta.i_user_type_id=?";    
          /////////////////end Define your query here/////////////          
         
		  $this->db->trans_begin();///new      
          $rs=$this->db->query($s_qry,array(intval($i_user_type_id)));
          if(is_array($rs->result()))
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$row->s_controller]["id"]=$row->id;////always integer
				  $ret_[$row->s_controller]['controller']=get_unformatted_string($row->s_controller); 
				  $ret_[$row->s_controller]['i_action_add']=intval($row->i_action_add); 
				  $ret_[$row->s_controller]["i_action_edit"]=intval($row->i_action_edit); 
				  $ret_[$row->s_controller]["i_action_delete"]=intval($row->i_action_delete); 
				  $ret_[$row->s_controller]["i_user_type_id"]=intval($row->i_user_type_id); 
                  $ret_[$row->s_controller]["s_user_type"]=get_unformatted_string($row->s_user_type); 
                  $ret_[$row->s_controller]["dt_created_on"]=date($this->conf["site_date_format"],strtotime($row->dt_created_on)); 
                  $ret_[$row->s_controller]["i_is_deleted"]=intval($row->i_is_deleted); 
                  $ret_[$row->s_controller]["s_is_deleted"]=(intval($row->i_is_deleted)==1?"Removed":""); 
                  
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          $this->db->trans_commit();///new
          unset($s_qry,$rs,$row,$i_id);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }	
    /***
    * Update user type access records or insert anew row in db. 
    * @param array $info, $i_id with values,ex-$arr["field_name"]=value
    * @param $s_controller,$i_id to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function update_access($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false   
            if(!empty($info))
            {
              //check if row exist in access table
			 // $where = "uta.i_user_type_id='".$i_user_type_id."' AND uta.s_controller='".$s_controller."' "; 
			   if(intval($i_id)>0)//update
			  {
			     		  
			    $s_qry="UPDATE ".$this->db->USER_TYPE_ACCESS." SET ";
                $s_qry.=" i_action_add=? ";
				$s_qry.=", i_action_edit=? ";
				$s_qry.=", i_action_delete=? ";
                $s_qry.=" WHERE id=?";
                
                $this->db->trans_begin();///new  
				$this->db->query($s_qry,array(   intval($info["i_action_add"]),
												 intval($info["i_action_edit"]),
												 intval($info["i_action_delete"]),
												 intval($i_id)
														 ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
					    $logi["sql"]= serialize(array($s_qry,array(   intval($info["i_action_add"]),
												 intval($info["i_action_edit"]),
												 intval($info["i_action_delete"]),
												 intval($i_id)
														 )) ) ;         
                    $this->log_info($logi); 
                    unset($logi);
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                } 
			  }
			  else  //add new row
			  {
					$s_qry="INSERT INTO ".$this->db->USER_TYPE_ACCESS
					       ." ( i_user_type_id,
					            s_controller,
								i_action_add,
								i_action_edit,
								i_action_delete,
								dt_created_on)
							    VALUES (?,?,?,?,?,?)";
					$this->db->trans_begin();///new   
					$this->db->query($s_qry,array(intval($info["i_user_type_id"]),
												 ($info["s_controller"]),
												 intval($info["i_action_add"]),
												 intval($info["i_action_edit"]),
												 intval($info["i_action_delete"]),
												 date($this->conf["db_date_format"],strtotime($info["dt_created_on"]))
														 ));
					$i_ret_=$this->db->insert_id();     
					if($i_ret_)
					{
						$logi["msg"]="Inserting into ".$this->tbl." ";
						
					     
						$logi["sql"]= serialize(array($s_qry,array(intval($info["i_user_type_id"]),
												 ($info["s_controller"]),
												 intval($info["i_action_add"]),
												 intval($info["i_action_edit"]),
												 intval($info["i_action_delete"]),
												 date($this->conf["db_date_format"],strtotime($info["dt_created_on"]))
														 )) ) ;
						$this->log_info($logi); 
						unset($logi);
						$this->db->trans_commit();///new   
					}
					else
					{
						$this->db->trans_rollback();///new
					}
			  }
			  // //////////////////////
            }
            unset($s_qry);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }  	
	
	
	
    /****
    * Fetch Menus having access rights to control them. 
    * Company controller cannot be edited or deleted because in some of php scripts
    * the company id used are hardcodded.
    * 
    * @param int $i_user_type_id, user type; 0=> super admin
    * @returns array of menu controllers 
    */
    public function fetch_menus($i_user_type_id=null,$product_section=null)
    {
        try
        {   
            if($product_section=="Finance")
                $all_controllers=$this->db->FIN_CONTROLLER_NAME;
            else
                $all_controllers=$this->db->CONTROLLER_NAME;
               
            /*For superadmin and others dont allow these controllers to be 
            * inserted,edited or deleted
            * ex- Any user including super admin cannot edit or delete the company master
            */
			$force_controller_toreact=array();
            $force_controller_toreact=array(       
				'Auto_mail'=>array(
                    'action_add'=>0,
                    'action_edit'=>0,
                    'action_delete'=>0
                ),
				'Manage_feedback'=>array(
                    'action_add'=>0,
                    'action_edit'=>1,
                    'action_delete'=>0
                ),
				'Manage_jobs'=>array(
                    'action_add'=>0,
                    'action_edit'=>0,
                    'action_delete'=>1
                ),
				'Manage_private_message'=>array(
                    'action_add'=>0,
                    'action_edit'=>0,
                    'action_delete'=>1
                ),
				'Manage_tradesman'=>array(
                    'action_add'=>0,
                    'action_edit'=>1,
                    'action_delete'=>0
                ),
				'Manage_buyers'=>array(
                    'action_add'=>0,
                    'action_edit'=>1,
                    'action_delete'=>0
                ),
				'Newsletter_subscribers'=>array(
                    'action_add'=>0,
                    'action_edit'=>1,
                    'action_delete'=>0
                ),
				'How_it_works_tradesman'=>array(
                    'action_add'=>0,
                    'action_edit'=>1,
                    'action_delete'=>1
                ),
				'How_it_works_buyer'=>array(
                    'action_add'=>0,
                    'action_edit'=>1,
                    'action_delete'=>1
                ),
				'Comm_setting_history'=>array(
                    'action_add'=>0,
                    'action_edit'=>0,
                    'action_delete'=>1
                ),
				'Manage_invoice'=>array(
                    'action_add'=>0,
                    'action_edit'=>0,
                    'action_delete'=>1
                ),
				'Referral_setting_history'=>array(
                    'action_add'=>0,
                    'action_edit'=>0,
                    'action_delete'=>0
                )
				
            );    
            ///////////end force to act///////   
            /**
            * Alias Controllers:- when some controller depends on other controller 
            * then allow access to those controllers as well. 
            */  
            $alias_controllers=array();
                      
            $controllers_access=array();
			//pr($_SESSION);
			//echo $i_user_type_id;exit;
            if($i_user_type_id>0)
            {
                $s_qry="Select * From ".$this->db->USER_TYPE_ACCESS;
                $s_qry.=" Where i_user_type_id=? AND (i_action_add=1 OR i_action_edit=1 OR i_action_delete=1 OR s_controller='Dashboard')";///Dashboard is allowed to all users
                $this->db->trans_begin();///new                                   
                $rs=$this->db->query($s_qry, intval($i_user_type_id));
                $i_cnt=0;
                if(is_array($rs->result()) ) ///new
                {
                  foreach($rs->result() as $row)
                  {                  
                    $tmp_=stripslashes($row->s_controller);
                    $controllers_access[$tmp_]=$all_controllers[$tmp_];
                    /*For superadmin and others dont allow these controllers to be 
                    * inserted,edited or deleted
                    * ex- Any user including super admin cannot edit or delete the company master
                    */                    
                    if(!$force_controller_toreact[$tmp_])
                    {
                        if($controllers_access[$tmp_]["top_menu"]!="Report")
                        {
                            $controllers_access[$tmp_]["action_add"]=intval($row->i_action_add);
                            $controllers_access[$tmp_]["action_edit"]=intval($row->i_action_edit);
                            $controllers_access[$tmp_]["action_delete"]=intval($row->i_action_delete);                     
                        }
                        else
                        {
                            $controllers_access[$tmp_]["action_add"]=0;
                            $controllers_access[$tmp_]["action_edit"]=0;
                            $controllers_access[$tmp_]["action_delete"]=0;                        
                        }                         
                    }///////end if
                    else
                    {
                        $controllers_access[$tmp_]["action_add"]=$force_controller_toreact[$tmp_]["action_add"];
                        $controllers_access[$tmp_]["action_edit"]=$force_controller_toreact[$tmp_]["action_edit"];
                        $controllers_access[$tmp_]["action_delete"]=$force_controller_toreact[$tmp_]["action_delete"];
                    }///end else 
                    
                    /**
                    * Alias Controllers:- when some controller depends on other controller 
                    * then allow access to those controllers as well. 
                    * Alias Controllers can be comma seperated Controllers names
                    */
                    if(trim($controllers_access[$tmp_]["alias_controller"])!="")
                    {
                        $tmpAlis=explode(",",$controllers_access[$tmp_]["alias_controller"]);
                        if(is_array($tmpAlis))
                        {
                            foreach($tmpAlis as $ali)
                            {
                                $alias_name=$ali;
                                $alias_controllers[$alias_name]["action_add"]=0;
                                $alias_controllers[$alias_name]["action_edit"]=0;
                                $alias_controllers[$alias_name]["action_delete"]=0;                                 
                            }
                            unset($ali);
                        }
                        else
                        {
                            $alias_name=$controllers_access[$tmp_]["alias_controller"];
                            $alias_controllers[$alias_name]["action_add"]=0;
                            $alias_controllers[$alias_name]["action_edit"]=0;
                            $alias_controllers[$alias_name]["action_delete"]=0;                            
                        }
                        unset($alias_name,$tmpAlis);
                    }///end if Alias controller
                  }    
                  $rs->free_result();          
                }
                $this->db->trans_commit();///new
                unset($s_qry,$rs,$row,$i_cnt);
                ///////Keeping the access rights into the sessions/////                
            }
            else////for super admin
            {
                foreach($all_controllers as $k=>$menus)
                {
                    $tmp_=$k;
                    $controllers_access[$tmp_]=$all_controllers[$tmp_];
                    /*For superadmin and others dont allow these controllers to be 
                    * inserted,edited or deleted
                    * ex- Any user including super admin cannot edit or delete the company master
                    */                    
                    if(!$force_controller_toreact[$tmp_])
                    {                    
                        if($controllers_access[$tmp_]["top_menu"]!="Report")
                        {
                            $controllers_access[$tmp_]["action_add"]=1;
                            $controllers_access[$tmp_]["action_edit"]=1;
                            $controllers_access[$tmp_]["action_delete"]=1;                        
                        }
                        else
                        {
                            $controllers_access[$tmp_]["action_add"]=0;
                            $controllers_access[$tmp_]["action_edit"]=0;
                            $controllers_access[$tmp_]["action_delete"]=0;                        
                        }
                    }///////end if
                    else
                    {
                        $controllers_access[$tmp_]["action_add"]=$force_controller_toreact[$tmp_]["action_add"];
                        $controllers_access[$tmp_]["action_edit"]=$force_controller_toreact[$tmp_]["action_edit"];
                        $controllers_access[$tmp_]["action_delete"]=$force_controller_toreact[$tmp_]["action_delete"];
                    }///end else 
                    
                    /**
                    * Alias Controllers:- when some controller depends on other controller 
                    * then allow access to those controllers as well. 
                    */
                    if(trim($controllers_access[$tmp_]["alias_controller"])!="")
                    {
                        $tmpAlis=explode(",",$controllers_access[$tmp_]["alias_controller"]);
                        if(is_array($tmpAlis))
                        {
                            foreach($tmpAlis as $ali)
                            {
                                $alias_name=$ali;
                                $alias_controllers[$alias_name]["action_add"]=0;
                                $alias_controllers[$alias_name]["action_edit"]=0;
                                $alias_controllers[$alias_name]["action_delete"]=0;                                 
                            }
                            unset($ali);
                        }
                        else
                        {
                            $alias_name=$controllers_access[$tmp_]["alias_controller"];
                            $alias_controllers[$alias_name]["action_add"]=0;
                            $alias_controllers[$alias_name]["action_edit"]=0;
                            $alias_controllers[$alias_name]["action_delete"]=0;                            
                        }
                        unset($alias_name,$tmpAlis);
                    }///end if Alias controller                    
                }
            }
            
            //$this->session->set_userdata(array("controllers_access"=>$controllers_access));    
            //pr($this->session->userdata("controllers_access"),1); 
            
            /**
            * DEFAULT ACCESS TO DASHBOARD
            * For a special case:-
            * user had created but no access control assigned for that user type.
            * then dashboard will have default access to any user who logged in 
            */
                $controllers_access["Dashboard"]=$all_controllers["Dashboard"];
                $controllers_access["Dashboard"]["action_add"]=0;
                $controllers_access["Dashboard"]["action_edit"]=1;
                $controllers_access["Dashboard"]["action_delete"]=0;                  
            /////end DEFAULT ACCESS TO DASHBOARD///

            /**
            * Alias Controllers:- when some controller depends on other controller 
            * then allow access to those controllers as well. 
            * Finally assigning all alias controllers to main controllers.
            */
            if(!empty($alias_controllers))
            {
                foreach($alias_controllers as $al=>$arr)
                {
                    if(!array_key_exists($al,$controllers_access))
                    {
                        $controllers_access[$al]=$arr;
                    }
                }
                unset($al,$arr);
            }///end if Alias controller            
            //pr($controllers_access);
            unset($all_controllers,$tmp_,$k,$alias_controllers);      
            return $controllers_access;
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