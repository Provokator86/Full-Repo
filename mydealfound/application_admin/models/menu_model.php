<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 3 Jan 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Menu
* 
* @package Content Management
* @subpackage news
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/news.php
* @link views/admin/news/
*/


class Menu_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $tbl_permit;

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->MENU;    
		  $this->tbl_permit = $this->db->MENUPERMIT;      
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
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$s_action_wh=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT n.* FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name));    
				  $ret_[$i_cnt]["s_link"]=stripslashes(htmlspecialchars_decode($row->s_link));
                  $ret_[$i_cnt]["s_action_permit"]=stripslashes(htmlspecialchars_decode($row->s_action_permit));  
				  if($s_action_wh!=null)
				  {
				   $s_wh=$s_action_wh." And p.i_menu_id ={$row->i_id} ";
				  
				   $ret_[$i_cnt]['actions'] = $this->fetch_action($s_wh);
				  }
					
				                
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
	
	
	public function fetch_all_menus($s_where=null,$i_start=null,$i_limit=null,$i_user_type_id)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name));    
				  
				  
				  $s_wh = " WHERE n.i_main_id='".$ret_[$i_cnt]["id"]."' And n.s_link!='' ";
				  $s_action_wh = " WHERE i_user_type={$i_user_type_id} ";
				  $ret_[$i_cnt]["s_sub_menu"] = $this->fetch_multi($s_wh,'','',$s_action_wh); 
				  
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
	
	
	/* to set the menus in top navigation depending on user type 
	*  @see common_helper.php create_menus()
	*/
	
	public function fetch_menus_navigation($s_where=null,$i_user_type_id)
    {
        try
        {
            $i_start = 0;
            $i_limit= NULL; 
          	$ret_=array();
			$s_qry="SELECT n.*, (SELECT count(*) FROM {$this->tbl_permit} 
							WHERE i_menu_id = n.i_id And (i_user_type={$i_user_type_id} OR s_action='Default') ) AS i_total_controls
			        FROM ".$this->tbl." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name));    
				  $ret_[$i_cnt]["s_link"]=stripslashes(htmlspecialchars_decode($row->s_link)); 
				  $ret_[$i_cnt]["i_total_controls"]=$row->i_total_controls; 
				                
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
	
	
	
	
	
	
	
	public function fetch_action($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_permit." p  "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  //$ret_[$i_cnt]["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name));    
				  $ret_[$i_cnt]["s_action"]=stripslashes(htmlspecialchars_decode($row->s_action));                
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
				  
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name)); 
				  $ret_["s_link"]=stripslashes(htmlspecialchars_decode($row->s_link)); 
                 
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
            {}
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
            $i_ret_=0;////Returns false
            if(!empty($info))
            {}
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
    {}      

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

	public function fetch_main_menu($s_where='')
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.* FROM ".$this->tbl." n WHERE n.i_parent_id IN (0,-99) AND i_main_id=0";
                
              $rs=$this->db->query($s_qry);
              $i_cnt=0;
              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {
                      $ret_[$i_cnt]["id"]       =       $row->i_id;////always integer
                      $ret_[$i_cnt]["s_name"]   =       stripslashes(htmlspecialchars_decode($row->s_name)); 
                      $ret_[$i_cnt]["i_parent_id"]=     $row->i_parent_id ; 
                      $ret_[$i_cnt]["status"]   =       ($row->i_parent_id==-99)?'hidden':'showing';   
                      $i_cnt++;
                  }    
                  $rs->free_result();          
             }
          unset($s_qry,$rs,$row,$i_cnt);
          return $ret_;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function add_main_menu($info)
    {
        try
        {
            $i_ret_ =   0;
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl." Set ";
                $s_qry.=" s_name=? ";
                $s_qry.=" ,s_link=? ";
                $s_qry.=", i_parent_id=? ";
                $s_qry.=", i_main_id=? ";
                
                $this->db->query($s_qry,array(
                                                  trim(htmlspecialchars($info["s_name"])),
                                                  trim(htmlspecialchars($info["s_link"])),
                                                  $info["i_parent_id"],
                                                  $info["i_main_id"]
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
    
    public function edit_main_menu($info,$id)
    {
        try
        {
            $i_ret_ =   0;
            if(!empty($info))
            {
                $i_ret_  =   $this->db->update($this->tbl,$info,array('i_id'=>$id));
            }

            unset($s_qry, $info );
            return $i_ret_;
            
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    public function fetch_sub_menu($s_where='')
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.* FROM ".$this->tbl." n ".($s_where!=""?$s_where:"" );
                
              $rs=$this->db->query($s_qry);
              $i_cnt=0;
              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {
                      $ret_[$i_cnt]["id"]       =       $row->i_id;////always integer
                      $ret_[$i_cnt]["s_name"]   =       stripslashes(htmlspecialchars_decode($row->s_name)); 
                      $ret_[$i_cnt]["s_link"]   =       stripslashes(htmlspecialchars_decode($row->s_link)); 
                      $ret_[$i_cnt]["i_parent_id"]=     $row->i_parent_id ; 
                      $ret_[$i_cnt]["i_main_id"]  =     $row->i_main_id ;
                      $ret_[$i_cnt]["status"]   =       ($row->i_parent_id==-99)?'hidden':'showing';   
                      $i_cnt++;
                  }    
                  $rs->free_result();          
             }
          unset($s_qry,$rs,$row,$i_cnt);
          return $ret_;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    
    public function fetch_menu_permission($s_where='')
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.* FROM ".$this->tbl_permit." n ".($s_where!=""?$s_where:"" );
                
              $rs=$this->db->query($s_qry);
             
              $i_cnt=0;
              if($rs->num_rows()>0)
              {
                  foreach($rs->result() as $row)
                  {
                      $ret_[$i_cnt]["id"]           =    $row->i_id;////always integer
                      $ret_[$i_cnt]["i_menu_id"]    =    intval($row->i_menu_id); 
                      $ret_[$i_cnt]["s_action"]     =    stripslashes(htmlspecialchars_decode($row->s_action)); 
                      $ret_[$i_cnt]["s_link"]       =    stripslashes(htmlspecialchars_decode($row->s_link)) ; 
                      $ret_[$i_cnt]["i_user_type"]  =    $row->i_user_type ;
                      $i_cnt++;
                  }    
                  $rs->free_result();          
             }
          unset($s_qry,$rs,$row,$i_cnt);
          return $ret_;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    public function add_menu_permit($info)
    {
        try
        {
            $i_ret_ =   0;
            if(!empty($info))
            {
                $s_qry="Insert Into ".$this->tbl_permit." Set ";
                $s_qry.=" i_menu_id=? ";
                $s_qry.=" ,s_action=? ";
                $s_qry.=" ,s_link=? ";
                $s_qry.=", i_user_type=? ";
                
                $this->db->query($s_qry,array(
                                                  intval($info["i_menu_id"]),
                                                  trim(htmlspecialchars($info["s_action"])),
                                                  trim(htmlspecialchars($info["s_link"])),
                                                  $info["i_user_type"]
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
    
    public function edit_menu_permit($info,$id)
    {
        try
        {
            $i_ret_ =   0;
            if(!empty($info))
            {
                $i_ret_  =   $this->db->update($this->tbl_permit,$info,array('i_id'=>$id));
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
   * Delete Main menus with all there submenus label 1 and label 2
   * with all the permission given to all the submenu.
   *  
   * @param mixed $i_main_menu_id
   */
   public function delete_main_menu($i_main_menu_id='')
   {
       try
       {
           $s_qry   =   " SELECT * FROM ".$this->tbl." WHERE i_main_id = ".$i_main_menu_id ;
           $ret_    =   array();
           
           $rs=$this->db->query($s_qry);
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]       =       $row->i_id;////always integer
                  $ret_[$i_cnt]["i_parent_id"]=     $row->i_parent_id ; 
                  $ret_[$i_cnt]["status"]   =       ($row->i_parent_id==-99)?'hidden':'showing';   
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($rs,$row,$i_cnt);
          
          if(!empty($ret_))
          {
              foreach($ret_ as $value)
              {
                  $this->delete_menu_permission($value['id']);
              }
          }
          
          $s_qry    =   " DELETE FROM ".$this->tbl." WHERE i_main_id = ".$i_main_menu_id." OR i_id = ".$i_main_menu_id ;
          $this->db->query($s_qry);
          $i_ret_=$this->db->affected_rows();
          unset($s_qry);
          return $i_ret_ ;
           
       }
       catch(Exception $err_obj)
       {
            show_error($err_obj->getMessage());
       }
   } 
   
   /**
   * Delete Submenu label 1 or 2 
   * In case of submenu 1 check whether it has submenu label or not
   * Delete menus with there menu permission.
   * 
   * @param int $i_sub_menu_id
   */
   public function delete_sub_menu($i_sub_menu_id='')
   {
       try
       {
           $s_qry   =   " SELECT * FROM ".$this->tbl." WHERE i_parent_id = ".$i_sub_menu_id ;
           $ret_    =   array();
           
           $rs=$this->db->query($s_qry);
           $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]       =       $row->i_id;////always integer
                  $ret_[$i_cnt]["i_parent_id"]=     $row->i_parent_id ; 
                  $ret_[$i_cnt]["status"]   =       ($row->i_parent_id==-99)?'hidden':'showing';   
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($rs,$row,$i_cnt);
          
          if(!empty($ret_))
          {
              foreach($ret_ as $value)
              {
                  $this->delete_menu_permission($value['id']);
              }
          }
          else
          {
              $this->delete_menu_permission($i_sub_menu_id);
          }
          
          $s_qry    =   " DELETE FROM ".$this->tbl." WHERE i_parent_id = ".$i_sub_menu_id." OR i_id = ".$i_sub_menu_id ;
          $this->db->query($s_qry);
          $i_ret_   =   $this->db->affected_rows();
          unset($s_qry);
          return $i_ret_ ;   
       }
       catch(Exception $err_obj)
       {
            show_error($err_obj->getMessage());
       }
   }
   
   /**
   * Delete from menu permit table all the permission associate with menu .
   * 
   * @param int $i_menu_id
   */
   public function  delete_menu_permission($i_menu_id='')
   {
       try
       {
           $s_qry   =   " DELETE  FROM ".$this->tbl_permit." WHERE i_menu_id =  ".$i_menu_id ;
           $this->db->query($s_qry);
           $i_ret_   =   $this->db->affected_rows();
           unset($s_qry);
           return $i_ret_ ;
           
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