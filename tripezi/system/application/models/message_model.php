 <?php
/*********
* Author: Koushik 
* Email: koushik.r@acumensoft.info
* Date  : 23 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Blog
* 
* @package User
* @subpackage Internal message
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/Message.php
* @link views/admin/message/
*/


class Message_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    private $tbl_user;
    private $tbl_booking;
    private $tbl_property;

    public function __construct()
    {
        try
        {
          parent::__construct();
        
          $this->tbl             = $this->db->MESSAGE;          
          $this->tbl_user        = $this->db->USER;         
          $this->tbl_booking     = $this->db->BOOKING;         
          $this->tbl_property    = $this->db->PROPERTY;         
          $this->conf            = & get_config();
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
    * @param string $s_order, ex- " ORDER BY dt_created_on ASC " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi($s_where=null,$s_order=null,$i_start=null,$i_limit=null)
    {
        try
        {
            $ret_=array();
            $s_qry=" SELECT m.*,p.s_property_name,b.e_status,b.dt_booked_from,b.dt_booked_to,  
            r.s_first_name receiver_first_name,r.s_last_name receiver_last_name,s.s_first_name sender_first_name,s.s_last_name sender_last_name  
            FROM ".$this->tbl." m ".
            " LEFT JOIN ".$this->tbl_user." r ON m.i_receiver_user_id=r.i_id ".
            " LEFT JOIN ".$this->tbl_user." s ON m.i_sender_user_id=s.i_id ".
            " LEFT JOIN ".$this->tbl_booking." b ON m.i_booking_id=b.i_id ".
            " LEFT JOIN ".$this->tbl_property." p ON b.i_property_id=p.i_id ".
            ($s_where!=""?$s_where:"" ).($s_order!=""?$s_order:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]                       = $row->i_id;////always integer
                  $ret_[$i_cnt]["i_receiver_user_id"]       = intval($row->i_receiver_user_id);
                  $ret_[$i_cnt]["i_sender_user_id"]         = intval($row->i_sender_user_id);

                  $ret_[$i_cnt]["s_subject"]                = get_unformatted_string($row->s_subject);
                  $ret_[$i_cnt]["s_body"]                   = get_unformatted_string($row->s_body); 
                  $ret_[$i_cnt]["i_receiver_read"]          = intval($row->i_receiver_read); 
                  $ret_[$i_cnt]["i_sender_read"]            = intval($row->i_sender_read);
                  $ret_[$i_cnt]["i_receiver_copy"]          = intval($row->i_receiver_copy);
                  $ret_[$i_cnt]["i_sender_copy"]            = intval($row->i_sender_copy);
                  $ret_[$i_cnt]["i_booking_id"]             = intval($row->i_booking_id);
                  
                  $ret_[$i_cnt]["dt_date_send"]             = date('d M',intval($row->dt_date_send));
                  
                   
                  $ret_[$i_cnt]["receiver_first_name"]      = get_unformatted_string($row->receiver_first_name); 
                  $ret_[$i_cnt]["receiver_last_name"]       = get_unformatted_string($row->receiver_last_name); 
                  $ret_[$i_cnt]["sender_first_name"]        = get_unformatted_string($row->sender_first_name); 
                  $ret_[$i_cnt]["sender_last_name"]         = get_unformatted_string($row->sender_last_name); 
                  
                  
                  $ret_[$i_cnt]["s_property_name"]          = get_unformatted_string($row->s_property_name);
                   
                  $ret_[$i_cnt]["e_status"]                 = get_unformatted_string($row->e_status); 
                  $ret_[$i_cnt]["t_booked_from"]            = $row->dt_booked_from; 
                  $ret_[$i_cnt]["t_booked_to"]              = $row->dt_booked_to; 

                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$s_order);
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
    * 
    * 
    * IMPORTANT this function is used for  frontend count no of messages
    */
    public function gettotal_message($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl." m ".
                " LEFT JOIN ".$this->tbl_user." r ON m.i_receiver_user_id=r.i_id ".
                " LEFT JOIN ".$this->tbl_user." s ON m.i_sender_user_id=s.i_id ".
                 ($s_where!=""?$s_where:"" );
                
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
    
    
    public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
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
    
    /* fetch the comments of a blog
    * param @ s_where
    * returns array
    */
    public function fetch_blog_comments($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
            
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
    public function gettotal_blog_comments($s_where=null)
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
