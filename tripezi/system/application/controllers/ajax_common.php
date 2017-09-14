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
class Ajax_common extends My_Controller
{
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          /********* START LOAD MODEL ********/
          $this->load->model('common_model','mod_common');
		  $this->load->model('state_model');
          
          /********* END LOAD MODEL ********/  
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    public function index()
    {}
	
	/*function ajax_change_city_option()
    {
		$this->load->model('city_model');
        $state_id  = decrypt($this->input->post('state_id'));
		$parent_city_option = $this->city_model->get_city_selectlist($state_id);
		
        echo '<select id="opt_city_id" name="opt_city_id" style="width:192px;" onchange="call_ajax_get_zipcode(\'ajax_change_zipcode_option\',this.value,'.$state_id.',\'parent_zip\');">
              <option value="">Select city</option>'.$parent_city_option.'</select>';
    }*/		


    /* this function returns 
	* the state dropdown on changing the country
	* author @ mrinmoy
	*/
    public function ajax_change_state_option()
    {
        $this->load->model('state_model');
        $country_id  = decrypt($this->input->post('country_id'));
        $state_option = $this->state_model->get_state_selectlist($country_id);
        
       /* echo '<select id="opt_state" name="opt_state" style="width:280px;">
              <option value="">Select state</option>'.$parent_state_option.'</select>';*/
        
        echo   '<option value="">Select State</option>'.$state_option ;
         
       
    }  
    
    
     public function ajax_change_city_option()
    {
        $this->load->model('city_model');
        $state_id  = decrypt($this->input->post('state_id'));
        $city_option = $this->city_model->get_city_selectlist($state_id);
        
      
        
        echo   '<option value="">Select City</option>'.$city_option ;
         
       
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
                    //$is_username_exist    =    $this->mod_buyer->fetch_multi($s_where);    

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
                   
					//$is_email_exist    =    $this->mod_buyer->fetch_multi($s_where); 
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
	
	function ajax_change_country_with_change_state_option()
    {
        try
        {
            $this->load->model('state_model'); // Load state model 
            $country_id  = decrypt($this->input->post('country_id'));
            
            $parent_country_option = $this->state_model->get_state_selectlist($country_id);
            
            echo '<select id="opt_state" name="opt_state" style="width:269px;" onchange="ajax_change_city_option(\'ajax_change_state\',this.value,\''.$country_id.'\',\'parent_city\');">
                  <option value="">'.'Select State'.'</option>'.$parent_country_option.'</select>';
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
    
    /* generate state dropdown on changing country option */
    function ajax_change_country()
    {
        try
        {
            $this->load->model('state_model'); // Load state model 
            $country_id  = decrypt($this->input->post('country_id'));
            
            $parent_country_option = $this->state_model->get_state_selectlist($country_id);
            
            echo '<select id="opt_state" name="opt_state" style="width:269px;">
                  <option value="">'.'Select State'.'</option>'.$parent_country_option.'</select>';
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
	
	/* generate city dropdown on changing state dropdown */
	function ajax_change_state()
    {
        try
        {
            $this->load->model('city_model'); // Load state model 
            $country_id = $this->input->post('country_id');
			$state_id	= decrypt($this->input->post('state_id'));
            
            $parent_city_option = $this->city_model->get_city_selectlist($country_id,$state_id);
            
            echo '<select id="opt_city" name="opt_city" style="width:269px;">
                  <option value="">'.'Select City'.'</option>'.$parent_city_option.'</select>';
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
        
    }
    
    
    /***
    * delete profile image
    * @author Koushik
    */
    public function ajax_property_delete_image()
    {
        try
        {
            
            $image_id          = decrypt(trim($this->input->post("image_id")));
            $image_name        = trim($this->input->post("image_name"));
            //pr($posted,1);

            $this->load->model('property_model','mod_property');
            $i_rect               = $this->mod_property->delete_an_image($image_id); 
            
            if($i_rect)
            {
                 $i_deleted            = delete_images_from_system('property_image',$image_name); // delete all images from system
                 echo "ok";     
            }
            else///Not saved, show the form again
            {
                echo "error" ;
            }
            
            unset($image_id,$image_name,$i_rect);
              
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
   

}


