<?php
/*********
* Author: Koushik Rout
* Date  : 01 May 2012
* Modified By: 
* Modified Date: 
* 
* Propose Controler 
* Contains all the ajax function for FRONTEND
*/
class Ajax_fe extends My_Controller
{
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          /********* START LOAD MODEL ********/
          $this->load->model('common_model','mod_common');
          $this->load->model('manage_buyers_model','mod_buyer');
		  $this->load->model('category_model','mod_cat');
          /********* END LOAD MODEL ********/  
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    public function index()
    {}
    
    
    
  
	
	
  /**
   * This function used to check captcha text matched or not
   *  
   */
    function ajax_check_captcha()
    {
        $captcha 		 = $this->input->post('txt_captcha');
        $session_captcha = $_SESSION['captcha'];
        
		 if($captcha != $session_captcha)
			 echo 'error';
		 else
			 echo 'succ';             
        
    }
    
    
    /**
    * This is a ajax function to check username already exist or not.
    * this function also ckeck the pattern of username.
    * 
    */
    function ajax_check_username_exist()
    {
        try
        {
            $s_username = trim($this->input->post('s_username'));
            if(!preg_match('/^[A-Za-z0-9\S#_]{5,}$/', $s_username)) 
                echo 'error_pattern';
                else
                {
                    $s_where              =    " WHERE n.s_username='".get_formatted_string($s_username)."' ";
                    $is_username_exist    =    $this->mod_buyer->fetch_multi($s_where);    

                    if($is_username_exist)
                    {
                        echo 'error';
                    }     
                    else
                    {
                        echo 'ok';
                    }      
                    unset($s_where,$is_username_exist);  
                }
            unset($s_username);  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
                   
    }// End of ajax_check_username_exist
    
    
    
    /**
    * This is a ajax function check email already exist or not
    * This function also check the pattern.
    * 
    */
    function ajax_check_email_exist()
    {
        try
        {
            $s_email = trim($this->input->post('s_email'));
            $i_user_id  =   trim($this->input->post('user_id'));
            if(!preg_match('/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/', $s_email))
            {
                echo 'error_pattern';
            }
            else
            {
                
                    if($i_user_id=='')
                    {
                        $s_where           =    "  WHERE s_email= '".addslashes($s_email)."' ";
						//$s_where           =    array('s_email'=>addslashes($s_email));
                    }
                    else
                    {
                        $s_where           =    " WHERE s_email='".addslashes($s_email)."' AND i_id!=".decrypt($i_user_id);
                    }
                    
                    //$is_email_exist    =    $this->mod_mst_user->fetch_multi($s_where);  
					//$s_tablename = $this->db->MST_USER;  
					$is_email_exist    =    $this->mod_buyer->fetch_multi($s_where); 
                    if($is_email_exist)
                    {
                        echo 'error';
                    }    
                    else
                    {
                         echo 'succ';
                    }
                    unset($s_where,$is_email_exist);   
            }
            unset($s_email); 
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
                
    }//End of ajax_check_email_exist
	
	
	
	/*** ajax call to get province dropdown with zipcode dropdown onchanging the province***/
	
	function ajax_change_province_option_auto_complete()
    {
        $this->load->model('province_model');
        $city_id  = decrypt($this->input->post('city_id'));
        $parent_province_option = $this->province_model->get_province_selectlist($city_id);
        $i_city_id = encrypt($city_id);
        echo '<select id="opt_state" name="opt_state" style="width:269px;" onchange="call_ajax_get_zipcode(\'ajax_change_zipcode_option\',this.value,\''.$i_city_id.'\',\'parent_zip\');">
              <option value="">'.addslashes(t('Select province')).'</option>'.$parent_province_option.'</select>';
    }	
	
	/*** ajax call to get zip code dropdown ***/
	function ajax_change_zipcode_option()
	{
		$this->load->model('zipcode_model');
		$state_id = decrypt($this->input->post('state_id'));
		$city_id  = decrypt($this->input->post('city_id'));	
		$parent_zip_option = $this->zipcode_model->get_zip_selectlist($state_id,$city_id);
		echo '<select id="opt_zip" name="opt_zip" style="width:269px;" ><option value="">'.addslashes(t('Select zipcode')).'</option>'.$parent_zip_option.'</select>';		
	}
	
	
	/*** ajax call to get zip oce suggestion ***/
	function ajax_autocomplete_zipcode($city_id='', $province_id='', $postal_code='')
	{
		if(!$city_id || !$province_id || $postal_code='')
		{
			return false;
		}
		
	
		$city_id  	  = decrypt($city_id);
		$province_id  = decrypt($province_id);
	    $postal_code  = $this->uri->segment(5);
		//echo '===='.$postal_code;
		$this->load->model('zipcode_model');
		$s_where = " WHERE n.city_id={$city_id} AND n.province_id={$province_id} AND n.postal_code LIKE '%{$postal_code}%'";
		$zip_list = $this->zipcode_model->fetch_multi($s_where);
		if($zip_list)
		{
			foreach($zip_list as $val)
			{
				echo '<div class="autocomplete_link" onclick="business_fill(\''. htmlspecialchars ($val['postal_code']).'^'.encrypt($val['id']).'\');">'.$val['postal_code'].'</div>';
			}
		}
		
	}
	
	
	
    
    /**
    * Ajax function for autocomplete cityn name,state name
    * 
    */
    
    function ajax_autocomplete_city_state()
    {

       try
       {
            $s_city_name        = trim($this->input->post('opt_city'));
            $i_country_id       = trim($this->input->post('country_id'));

            $this->load->model('city_model');
            if($i_country_id!='')
            {
               $s_where = " WHERE  c.s_city_name LIKE '%{$s_city_name}%'  AND c.i_country_id =".intval(decrypt($i_country_id)); 
            }
            else
            {
               $s_where = " WHERE  c.s_city_name LIKE '%{$s_city_name}%'"; 
            }
            
            $city_list = $this->city_model->fetch_multi($s_where);

            if($city_list)
            {
                foreach($city_list as $val)
                {
                    echo '<div class="autocomplete_link" onclick="business_fill(\''. htmlspecialchars ($val['s_city_name'].' , '.$val['s_state_name']).'^'.encrypt($val['id']).'\');">'.$val['s_city_name'].' , '.$val['s_state_name'].'</div>';
                }
        }
           
       } 
       catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        

    }// End of ajax_autocomplete_city_state
    


/*** ajax call to get province dropdown ***/
	
	function ajax_change_province_option()
    {
        $this->load->model('province_model');
        $city_id  = decrypt($this->input->post('city_id'));
        $parent_province_option = $this->province_model->get_province_selectlist($city_id);
        $i_city_id = encrypt($city_id);
        echo '<select id="opt_state" name="opt_state" style="width:269px;">
              <option value="">'.addslashes(t('Select province')).'</option>'.$parent_province_option.'</select>';
    }
    
    /**
    * Update mst_user table usertype 
    * its append usertype ,1 or ,2 etc.
    * 
    */
    function ajax_activate_account()
    {
        try
        {
            $posted                 =   array();
            $posted['user_id']      =   trim($this->input->post('user_id'));
            $posted['user_type']    =   intval($this->input->post('user_type'));
         
            $arr_usertype  =   explode(',',$this->data['loggedin']['s_user_type']);
            if(!in_array($posted['user_type'],$arr_usertype)) 
            {
                $ret_   =   $this->mod_mst_user->activate_user_type($posted['user_type'],decrypt($posted['user_id']));
            
            
                if($ret_)
                {
                            $info_type  =   array();
                            $info_type['i_user_id']     =   decrypt($posted['user_id']);
                            $info_type['dt_entry_date'] =   time();

                            $db_tablename   =   strtoupper($this->db->USERTYPE[$posted["user_type"]]);
                            $table_name     =   $this->db->{$db_tablename};
                            $i_row_id       =   $this->mod_common->common_add_info($table_name,$info_type);
                            if($i_row_id)
                            {
                                echo "ok_updating";
                            }
                            else
                            {
                                echo "error";
                            }
                            unset($info_type,$db_tablename,$table_name,$i_row_id);
                }
                else
                {
                    echo "error";
                }
               
            }
            else
            {
                echo "error";
            }
            unset($posted);

            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }// End of ajax_activate_account
    
 
   

}


