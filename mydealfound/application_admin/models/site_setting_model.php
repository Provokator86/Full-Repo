<?php

/*********

* Author: Jagannath Samanta

* Date  : 24 June 2011

* Modified By: 

* Modified Date:

* 

* Purpose:

* Model For Site Setting

* 

* @package Site Setting

* @subpackage Site Setting

* 

* @link InfModel.php 

* @link MY_Model.php

* @link controllers/site_setting.php

* @link views/admin/site_setting/

*/





class Site_setting_model extends MY_Model implements InfModel

{

    private $conf;

    private $tbl;///used for this class

    private $tbl_lang ;



    public function __construct()

    {

        try

        {

          parent::__construct();

          $this->tbl 	        = 	$this->db->SITESETTING;   

          //$this->tbl_currency 	=       $this->db->CURRENCY; 

          //$this->tbl_lang       =       $this->db->LANGUAGE ; 

		  

          //$this->tbl_admin 	= 	$this->db->USER;     

          $this->conf 	=	&get_config();

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

          	$s_qry="SELECT * 

					FROM ".$this->tbl." n "

					.($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?

					"Limit ".intval($i_start).",".intval($i_limit):"" );

          $rs=$this->db->query($s_qry);

          $i_cnt=0;

          if($rs->num_rows()>0)

          {

              foreach($rs->result() as $row)

              {

                  $ret_[$i_cnt]["id"]				=	$row->i_id;////always integer

                  $ret_[$i_cnt]["s_title"]			=	get_unformatted_string($row->s_title); 

				  $s_desc 							= 	strip_tags(get_unformatted_string($row->s_description));

				  if(strlen($s_desc)>197)

				  	$s_desc 						= 	substr_replace($s_desc,'...',200);

                  $ret_[$i_cnt]["s_description"]	= 	$s_desc ; 

                  $ret_[$i_cnt]["s_photo"]			=	get_unformatted_string($row->s_photo); 

                  $ret_[$i_cnt]["dt_created_on"]	=	date($this->conf["site_date_format"],intval($row->dt_cr_date)); 

                  $ret_[$i_cnt]["i_is_active"]		=	intval($row->i_is_active); 

				  $ret_[$i_cnt]["s_is_active"]		=	(intval($row->i_is_active)==1?"Active":"Inactive");

                  

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

    * Fetches One record from db.

    * 

    * @param blank

    * @returns array

    */

    public function fetch_this($null)

    {

        try

        {

          $ret_=array();

          $s_qry="Select u.* From {$this->tbl} u " ;

		  //."INNER JOIN {$this->tbl_lang} l ON u.i_default_language  = l.i_id "

		  //."INNER JOIN {$this->tbl_currency} cur ON u.i_default_currency = cur.i_id ";

                

          $rs=$this->db->query($s_qry);

          if($rs->num_rows()>0)

          {

              foreach($rs->result() as $row)

              {

              }    				$ret_["i_id"]						=	$row->i_id;		////always integer

				//$ret_["s_rss_feed_url"]			= stripslashes($row->s_rss_feed_url); 

				$ret_["s_site_title"]				= get_unformatted_string($row->s_site_title);

				$ret_["s_contact_us_email"]			= get_unformatted_string($row->s_contact_us_email); 

				$ret_["s_address"]					= get_unformatted_string($row->s_address); 

				$ret_["s_address"]					= get_unformatted_string($row->s_address); 

				$ret_["s_telephone"]				= get_unformatted_string($row->s_telephone); 

				$ret_["i_records_per_page"]			= stripslashes(intval($row->i_records_per_page)); 

				$ret_["s_copyrite"]					= get_unformatted_string($row->s_copyrite);   

				$ret_["i_default_currency"]			= @intval($row->i_default_currency); 

				$ret_["s_short_name"]				= @get_unformatted_string($row->s_short_name); 

				$ret_["i_discount_rate1"]			= @intval($row->i_discount_rate1); 

				$ret_["i_discount_rate2"]			= @intval($row->i_discount_rate2); 

				$ret_["i_num_category"]				= @intval($row->i_num_category); 

				$ret_["i_num_story"]				= @intval($row->i_num_story);

				$ret_["s_twitter_url"]				= get_unformatted_string($row->s_twitter_url);

				$ret_["s_facebook_url"]				= get_unformatted_string($row->s_facebook_url);

				$ret_["s_google_plus_url"]			= get_unformatted_string($row->s_google_plus_url);

				$ret_["s_pinterest_url"]			= get_unformatted_string($row->s_pinterest_url);

				$ret_["s_google_analitics_coupon"]			= get_unformatted_string($row->s_google_analitics_coupon);

				$ret_["s_google_analitics_deal"]			= get_unformatted_string($row->s_google_analitics_deal);
				
				$ret_["d_min_balance"]				= $row->d_min_balance;
				$ret_["d_cashback"]					= $row->d_cashback;



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

	

	public function auth_pass($pass)

	{

		try

        {

			$s_password 	= 	md5(trim($pass).$this->conf["security_salt"]);

			$mix_data 		= 	$this->session->userdata('admin_loggedin');

			$i_id 			= 	decrypt($mix_data['user_id']);

			

			$this->db->select('id');

			$this->db->where('s_password', $s_password);

			$this->db->where('id',$i_id);

			

			$res 		= 	$this->db->get($this->tbl);

			$i_count 	= 	$res->num_rows();

			

			unset($s_password, $mix_data,  $i_id, $res);

			return $i_count;

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

                $s_qry.=" s_title=? ";

                $s_qry.=", s_description=? ";

                $s_qry.=", s_photo=? ";

                $s_qry.=", i_is_active=? ";

                $s_qry.=", dt_cr_date=? ";

                

                $this->db->query($s_qry,array(get_formatted_string($info["s_title"]),

                                                      get_formatted_string($info["s_description"]),

                                                      get_formatted_string($info["s_photo"]),

                                                      intval($info["i_is_active"]),

                                                      intval($info["dt_cr_date"])

                                                     ));

                $i_ret_=$this->db->insert_id();     

                if($i_ret_)

                {

                    $logi["msg"]="Inserting into ".$this->tbl." ";

                    $logi["sql"]= serialize(array($s_qry,array(get_formatted_string($info["s_title"]),

                                                      get_formatted_string($info["s_description"]),

                                                      get_formatted_string($info["s_photo"]),

                                                      intval($info["i_is_active"]),

                                                      intval($info["dt_cr_date"])

                                                     )) ) ;

                    $this->log_info($logi); 

                    unset($logi,$logindata);

                }

            }

            unset($s_qry, $info);

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
                $s_qry	=	"Update ".$this->tbl." Set ";
				$s_qry.=" s_site_title=? ";
				$s_qry.=", s_address=? ";
				$s_qry.=", i_records_per_page=? ";
				$s_qry.=", s_telephone=? ";
				$s_qry.=", s_copyrite=? ";
				$s_qry.=", s_contact_us_email=? ";
				$s_qry.=", s_twitter_url=? ";
				$s_qry.=", s_facebook_url=? ";
				$s_qry.=", s_google_plus_url=? ";
				$s_qry.=", s_google_analitics_deal=? ";
				$s_qry.=", s_google_analitics_coupon=? ";
				$s_qry.=", s_pinterest_url=? ";
				
				$s_qry.=", d_min_balance=? ";
				$s_qry.=", d_cashback=? ";

                $s_qry.=" Where i_id=? ";

				

                $i_ret_= $this->db->query($s_qry,array(		

                                                    get_formatted_string($info["s_site_title"]),
                                                    get_formatted_string($info["s_address"]),
                                                    get_formatted_string($info["i_records_per_page"]),
                                                    trim($info["s_telephone"]),
                                                    trim($info["s_copyrite"]),
                                                    trim($info["s_contact_us_email"]),
                                                    trim($info["s_twitter_url"]),
                                                    trim($info["s_facebook_url"]),
                                                    trim($info["s_google_plus_url"]),
                                                    trim($info["s_google_analitics_deal"]),
                                                    trim($info["s_google_analitics_coupon"]),
                                                    trim($info["s_pinterest_url"]),
                                                    trim($info["d_min_balance"]),
                                                    trim($info["d_cashback"]),
                                                    intval($i_id)

                                              ));

                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {

					/* to change default language 
					* @see language_model set_default_language()
					*
					*/
					/*$arr['i_default'] = 1;
					$arr['id'] = intval($info["i_default_language"]);
					$arr['i_id'] = intval($info["i_default_currency"]);  // default currency primary id
					$CI =& get_instance();
		  			$CI->load->model('language_model');
					$CI->load->model('currency_model');
					$CI->language_model->set_default_language($arr,$arr['id']); // for selecting default language
					$CI->currency_model->set_default_currency($arr,$arr['i_id']); // for selecting default currency*/				

					//pr($info,1);
					//$this->set_admin_email($info);					

                   /* $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array()) ) ;   
                    $this->log_info($logi); 
                    unset($logi,$logindata);*/

                }                                                

            }

            unset($s_qry,$info,$i_id);

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

                $photo = $this->get_photo_name($i_id);

				get_file_deleted($this->uploaddir, $photo);

				get_file_deleted($this->thumbdir, $photo);



				$s_qry="DELETE FROM ".$this->tbl." ";

                $s_qry.=" Where i_id=? ";

                $this->db->query($s_qry, array(intval($i_id)) );

                $i_ret_=$this->db->affected_rows();        

                if($i_ret_)

                {

                    $logi["msg"]	=	"Deleting ".$this->tbl." ";

                    $logi["sql"]	= 	serialize(array($s_qry, array(intval($i_id))) ) ;

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

                    $logi["msg"]	=	"Deleting all information from ".$this->tbl." ";

                    $logi["sql"]	= 	serialize(array($s_qry) ) ;

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

	

	public function set_admin_email($info)

	{

		try

        {

			$i_ret_ = 0;

			$email = $info['s_admin_email'];

			

			$s_qry	=	"Update ".$this->tbl_admin." Set s_email = '{$email}' Where i_user_type_id = 0";  

			$this->db->query($s_qry);   

			$i_ret_=$this->db->affected_rows();      	

        }

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        } 

	}

	

	

	/****

    * Deleting the image name from table

    * 

    * @param int $i_id

    * @returns TRUE on success and FALSE if failed 

    */

    public function del_pic($i_id)

	{

		try

        {

			return $this->db->update($this->tbl, array('s_photo'=>''), array('i_id'=>$i_id));

		}

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }  

	}

	

	/****

    * get the image name from table

    * 

    * @param int $i_id

    * @returns string

    */

    public function get_photo_name($i_id)

	{

		try

        {

			$this->db->select('s_photo');

			$this->db->where(array('i_id'=>$i_id));

			$mix_res = $this->db->get_where($this->tbl);

			$mix_name_array = $mix_res->result_array();

			return $mix_name_array[0]['s_photo'];

		}

        catch(Exception $err_obj)

        {

            show_error($err_obj->getMessage());

        }  

	}

function get_current_date_and_time()

	{

		  $sql 			= "SELECT NOW() AS my_date_time";

		  $query  	= $this->db->query($sql);

		  $rslt   	= $query->row_array();

		  

		  return $rslt['my_date_time'];

	} 

  

    public function __destruct()

    {}                 

  

  

}

///end of class

?>