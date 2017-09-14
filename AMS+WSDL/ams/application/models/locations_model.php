<?php
/*********
* Author: Acumen CS
* Date  : 07 Feb 2014
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Model For Content Management
* 
* @package Content Management
* @subpackage Content
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/content.php
* @link views/admin/content/
*/

class Locations_model extends MY_Model
{
    private $conf;
    private $tbl, $tbl_rg_pg, $tbl_coun, $tbl_st, $tbl_ct, $tbl_zip, $tbl_team, $tbl_rg_map, $tbl_rg_map_st;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl        =   $this->db->REGION; 
          $this->tbl_rg_pg  = $this->db->REGION_PAGES;
          $this->tbl_fr     =   $this->db->FRANCHISE; 
          $this->tbl_fr_pg  = $this->db->FRANCHISE_PAGES;
          #$this->tbl_fr     =   $this->db->REGION; 
          $this->tbl_coun   =   $this->db->COUNTRY; 
          $this->tbl_st     =   $this->db->STATE; 
          $this->tbl_ct     =   $this->db->CITY; 
          $this->tbl_zip    =   $this->db->ZIPCODE; 
          $this->tbl_team   =   $this->db->REGION_FRANCHISE_TEAM; 
          $this->tbl_rg_map =   $this->db->REGION_MAP; 
          $this->tbl_rg_map_st    =   $this->db->REGION_MAP_STATES; 
          $this->tbl_user    =   $this->db->USER; 
          $this->tbl_user_role	=   $this->db->USERROLE; 
		  $this->conf	    =   & get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_region_meet_our_team($region_id=null)
    {
        if($region_id)
            $str = $region_id.',42';
        else
            $str = 42;
        #$str = "'".$str."'";
        $sql = "SELECT u.*,ur.i_region_id FROM {$this->tbl_user} AS u 
                    INNER JOIN {$this->tbl_user_role} AS ur ON ur.i_user_id = u.i_id
                    WHERE i_is_verified = 1 AND e_deleted = 'No' AND i_front_display=1 AND ur.i_region_id IN({$str}) AND ur.i_role_id!=10
                    GROUP BY u.i_id
                    ORDER BY FIELD(ur.i_region_id,{$str}) , u.i_sort_order ASC ";
    
        $rs=$this->db->query($sql);
        return $rs->result_array();
    }
    
    public function fetch_franchisee_meet_our_team($franchise_id=null,$region_id=null)
    {
        $str= '';
        if($franchise_id)
            $str_fr = $franchise_id;
        if($region_id)
            $str.= ','.$region_id;
        $str .= ','.'42';
        #$str = "'".$str."'";
        $str = trim($str,',');
        #echo $region_id.'==='.$franchise_id;
        if($franchise_id)        
        {
            /*echo $sql = "SELECT u.*,ur.i_region_id, IF(ur.i_franchise_id={$str_fr},'F',IF(ur.i_region_id!=42,'R','M')) AS user_type 
                    FROM {$this->tbl_user} AS u 
                    INNER JOIN {$this->tbl_user_role} AS ur ON ur.i_user_id = u.i_id
                    WHERE i_is_verified = 1 AND e_deleted = 'No' AND i_front_display=1 
                    AND (ur.i_region_id IN({$str}) OR ur.i_franchise_id='".$str_fr."') AND ur.i_role_id!=9
                    GROUP BY u.i_id
                    ORDER BY FIELD(user_type,'F','R','M') , u.i_sort_order ASC ";*/
            $sql = "SELECT IF(ur.i_franchise_id={$franchise_id},'F',IF(ur.i_region_id!=42,'R','M')) AS user_type ,u.*,ur.i_region_id
                FROM {$this->tbl_user} AS u 
                INNER JOIN {$this->tbl_user_role} AS ur ON ur.i_user_id = u.i_id 
                WHERE i_is_verified = 1 AND e_deleted = 'No' AND i_front_display=1 
                AND ((ur.i_region_id ={$region_id} AND ur.i_franchise_id={$franchise_id}) 
                            OR (ur.i_region_id ={$region_id} AND ur.i_franchise_id='0')
                            OR ur.i_region_id =42 ) 
                AND ur.i_role_id!=10
                GROUP BY u.i_id ORDER BY FIELD(user_type,'F','R','M') , u.i_sort_order ASC";
        }
        else
        {
        
            $sql = "SELECT u.*,ur.i_region_id FROM {$this->tbl_user} AS u 
                        INNER JOIN {$this->tbl_user_role} AS ur ON ur.i_user_id = u.i_id
                        WHERE i_is_verified = 1 AND e_deleted = 'No' AND i_front_display=1 AND ur.i_region_id IN({$str}) AND ur.i_role_id!=10
                        GROUP BY u.i_id
                        ORDER BY FIELD(ur.i_region_id,{$str}) , u.i_sort_order ASC ";
        }
    
        $rs=$this->db->query($sql);
        return $rs->result_array();
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
			if($s_where) $this->db->where($s_where, '', false);
			return $this->db->get($this->tbl, $i_limit, $i_start)->result_array();
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
			//if($s_where) $this->db->where($s_where, '' , false);
			//return $this->db->count_all($this->tbl);	$ret_=0;
          $s_qry="Select count(*) as i_total "
                 ."From ".$this->tbl." n "
                 .($s_where!=""?' WHERE '.$s_where:"" );
                
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
			return $this->db->get_where($this->tbl, array('i_id'=>$i_id))->result_array();
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
            return $this->write_log($attr["msg"],decrypt(get_userLoggedIn("user_id")),($attr["sql"]?$attr["sql"]:""));
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
    public function fetch_all_country($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {            
            $s_cond = " WHERE c.i_status=1 AND c.i_is_deleted=0 ";
            $ret_=array();
            $s_qry="SELECT c.i_id,c.name FROM ".$this->tbl_coun." c "
            .($s_cond!=""?$s_cond:"" )." ORDER BY c.name DESC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $i_cnt=0;
            if($rs->num_rows()>0)
            {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["i_id"]     =   $row->i_id;////always integer
                  $ret_[$i_cnt]["name"]     =   $row->name;
                  #$ret_[$i_cnt]["sub_reg"]  =   $this->fetch_all_regions($s_where,$i_start,$i_limit,$row->i_id);
                  $ret_[$i_cnt]["sub_reg"]  =   $this->fetch_all_states($s_where,$i_start,$i_limit,$row->i_id);
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
    
    public function fetch_all_states($s_where=null,$i_start=null,$i_limit=null,$i_country_id=null)
    {
        try
        {            
            if($i_country_id)
            $s_where = $s_where." AND n.i_country_id ='".addslashes($i_country_id)."' ";
            
            $ret_=array();
            $s_qry="SELECT n.i_id,n.name AS s_name,n.Code FROM ".$this->tbl_st." n " 
            .($s_where!=""?$s_where:"" )
            ." ORDER BY name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_all_regions($s_where=null,$i_start=null,$i_limit=null,$i_country_id=null)
    {
        try
        {
            $s_where .= " AND n.s_name!='Corporate Office' ";
            if($i_country_id)
            $s_where = $s_where." AND n.i_country_id='".addslashes($i_country_id)."' ";
            
            $ret_=array();
            $s_qry="SELECT n.i_id,n.s_name,n.s_region_url,n.i_country_id,n.i_state_id,st.name FROM ".$this->tbl." n "
            ." LEFT JOIN ".$this->tbl_st." AS st ON st.i_id=n.i_state_id "
            .($s_where!=""?$s_where:"" )
            ." ORDER BY s_name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_region_pages($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.* FROM ".$this->tbl_rg_pg." n "
            .($s_where!=""?$s_where:"" )
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_franchise_pages($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.* FROM ".$this->tbl_fr_pg." n "
            .($s_where!=""?$s_where:"" )
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }    
    
    public function fetch_all_offices($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.i_id,n.s_franchise_name,n.i_office_number,n.s_franchise_url,n.i_country_id ,n.s_about,n.i_region_id
            FROM ".$this->tbl_fr." n "
            .($s_where!=""?$s_where:"" )." ORDER BY n.s_franchise_name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }  
    
    // fetch team members or partners
    public function fetch_team_partners($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.*,con.name AS country,st.name AS state,ct.name AS city FROM ".$this->tbl_team." n "
            ." LEFT JOIN ".$this->tbl_coun." AS con ON con.i_id = n.i_country_id "
            ." LEFT JOIN ".$this->tbl_st." AS st ON st.i_id = n.i_state_id "
            ." LEFT JOIN ".$this->tbl_ct." AS ct ON ct.i_id = n.i_city_id "
            .($s_where!=""?$s_where:"" )." ORDER BY n.i_sort_order ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    // codeed on 29dec 2015 
    public function fetch_region_map_local_office($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.*, r.i_id AS region_id,r.s_region_url,r.s_name 
            FROM ".$this->tbl_rg_map." n "            
            ." LEFT JOIN ".$this->tbl." AS r ON r.i_region_number = n.i_region_no "
            .($s_where!=""?$s_where:"" )." ORDER BY n.s_name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_region_of_states($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.*, r.i_id AS region_id,r.s_region_url,r.s_name,rm.i_id AS region_map_pk,rm.i_region_no, rm.i_parent_id,rm.s_name,rm.s_seo_url,
            rm.s_state_id,rm.s_franchisee 
            FROM ".$this->tbl_rg_map_st." n "            
            ." LEFT JOIN ".$this->tbl_rg_map." AS rm ON rm.i_id = n.i_region_id "
            ." LEFT JOIN ".$this->tbl." AS r ON r.i_region_number = rm.i_region_no "
            .($s_where!=""?$s_where:"" )." ORDER BY rm.s_name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();  
            for($i_cnt=0;$i_cnt<count($ret_);$i_cnt++)
            {
                $s_cond = " WHERE n.i_parent_id='".$ret_[$i_cnt]['region_map_pk']."' ";
                $ret_[$i_cnt]["sub_regions"]  =   $this->fetch_sub_regions($s_cond);
            }
            
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_sub_regions($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.*, r.i_id AS region_id,r.s_region_url,r.s_name AS region_name
            FROM ".$this->tbl_rg_map." n "  
            ." LEFT JOIN ".$this->tbl." AS r ON r.i_region_number = n.i_region_no "
            .($s_where!=""?$s_where:"" )." ORDER BY n.s_name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array(); 
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function fetch_map_regions_of_region($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT n.i_id, n.i_region_no, n.s_name, n.s_seo_url,n.s_franchisee, 
            r.i_id AS region_id,r.s_region_url,r.s_name AS region_name
            FROM ".$this->tbl_rg_map." n "  
            ." LEFT JOIN ".$this->tbl." AS r ON r.i_region_number = n.i_region_no "
            .($s_where!=""?$s_where:"" )." ORDER BY n.s_name ASC "
            .(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();  
            for($i_cnt=0;$i_cnt<count($ret_);$i_cnt++)
            {
                $s_cond = " WHERE n.i_parent_id='".$ret_[$i_cnt]['i_id']."' ";
                $ret_[$i_cnt]["sub_regions"]  =   $this->fetch_sub_regions($s_cond);
            }
            
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function zero_parent_ids_mp_reg()
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT GROUP_CONCAT(n.i_id separator ',') as pk_ids FROM ".$this->tbl_rg_map." AS n WHERE n.i_parent_id=0 ";
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array(); 
            unset($s_qry,$rs); 
            return $ret_[0]['pk_ids'];
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function get_state_information($s_where=null)
    {
        try
        {
            $ret_=array();
            $s_qry="SELECT i_id,name FROM ".$this->tbl_st."  "
            .($s_where!=""?$s_where:"" )." ORDER BY name ASC ";
            //.(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            $rs=$this->db->query($s_qry);
            $ret_ = $rs->result_array();
            unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
            return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    // destruct
    public function __destruct()
    {} 
}
///end of class
?>