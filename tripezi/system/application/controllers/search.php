<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 06 July 2012
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Search extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title'] = "Property List";////Browser Title
		  $this->data['ctrlr'] = "property";

          $this->cls_msg=array();
		  $this->cls_msg["no_result"]	= "No information found about latest property."; 
		  $this->cls_msg["city_err"]	= "Please provide proper location";
          $this->pathtoclass			= base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          $this->load->model("property_model","mod_rect");
		  $this->load->model("city_model","mod_city");
		  $this->load->model("assets_model","mod_assets");
		
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    public function index($i_city_id='')
    {
        try
        {					
			$this->s_meta_type = 'property';
			$this->data['breadcrumb'] = array('Property'=>'');
			
			$sessArrTmp = array();
			/* get session values */
			$session_array_data	=	$this->session->userdata('property_session');
			
			if($i_city_id)
			{
			$sessArrTmp['src_i_city_id'] = $i_city_id;
			$city_detail	=	$this->mod_city->fetch_this($i_city_id);
			$sessArrTmp['txt_address_src'] 	= $city_detail["s_city"].', '.$city_detail["s_state"].', '.$city_detail["s_country"];
				
			}
			else if($_POST)
			{
				
				//pr($session_array_data);
						
				$sessArrTmp['src_room_type']	= trim($this->input->post('h_str_room'),',');
				$sessArrTmp['src_amenity']		= trim($this->input->post('h_str_amenity'),',');
				$sessArrTmp['src_total_guests'] = $this->input->post('guests');
				$sessArrTmp['src_i_check_in']  	= strtotime($this->input->post('i_check_in'));
				$sessArrTmp['src_i_check_out']  = strtotime($this->input->post('i_check_out'));
				
				$sessArrTmp['sort_property_by'] = $this->input->post('opt_property');
				
				/******************* find city id from address ***********************/
				//$sessArrTmp['txt_address_src'] 	= $session_array_data["txt_address_src"]?$session_array_data["txt_address_src"]:$this->input->post('txt_search');
				$sessArrTmp['txt_address_src'] 	= $this->input->post('txt_search')?$this->input->post('txt_search'):$session_array_data["txt_address_src"];
				$txt_str		=	explode(',',$sessArrTmp['txt_address_src']);
				$txt_city		=	trim($txt_str[0]);
				$txt_state		=	trim($txt_str[1]);
				$txt_country	=	trim($txt_str[2]);				
				$s_qry			=	"WHERE c.s_city ='".$txt_city."' AND s.s_state = '".$txt_state."' AND country.s_country = '".$txt_country."'  ";
				$result			=	$this->mod_city->fetch_multi($s_qry);
				
				if(!empty($result))
				{
					//$sessArrTmp['src_i_city_id'] = $session_array_data["src_i_city_id"]?$session_array_data["src_i_city_id"]:$result[0]["id"];
					$sessArrTmp['src_i_city_id'] = $result[0]["id"]?$result[0]["id"]:$session_array_data["src_i_city_id"];
				}
				/*else
				{			
					$this->session->set_userdata(array('message'=>$this->cls_msg["city_err"],'message_type'=>'err'));	
					redirect(base_url());
				}*/
				/********************* find city id from address *********************/
				
			}
			
			//pr($sessArrTmp["src_amenity"]);
			$this->session->set_userdata(array('property_session'=>$sessArrTmp));	// to store data in session
			//pr($this->session->userdata('property_session'));
			
			$this->data['posted'] = $sessArrTmp;
			unset($txt_str,$txt_city,$txt_state,$txt_country);
			$s_where	=	"WHERE a.i_status = 1 ";
			$this->data["amenity"]	=	$this->mod_assets->fetch_amenity_list($s_where);
			
			
			ob_start();
			$this->ajax_property_list(0,1);
			$contents = ob_get_contents();
			ob_end_clean();
			$property = explode('^',$contents);			
			$this->data['property'] 		= $property[0];
			$this->data['total_property']	= $property[1];
			
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/* ajax call to get property with paginatin */
	function ajax_property_list($start=0,$param=0) {	
	
		$s_where ='';	
		$s_order = '';
		//pr($this->data["loggedin"]);
		/* get session data */
		$session_array_data	=	$this->session->userdata('property_session');
		//pr($session_array_data);
		$sessArrTmp['src_total_guests'] 	= $session_array_data["src_total_guests"];
		$sessArrTmp['src_i_city_id']  		= $session_array_data["src_i_city_id"];
		$sessArrTmp['src_room_type']  		= $session_array_data["src_room_type"];
		$sessArrTmp['src_amenity']  		= $session_array_data["src_amenity"];
		$sessArrTmp['src_i_check_in']  		= $session_array_data["src_i_check_in"];
		$sessArrTmp['src_i_check_out']  	= $session_array_data["src_i_check_out"];
		$sessArrTmp['sort_property_by']  	= $session_array_data["sort_property_by"];
		
		/* end get session data */
		if($_POST)
		{
		$price_end 		= $this->input->post('price_end');
		$price_start 	= $this->input->post('price_start');
		}
		//pr($sessArrTmp);
		/******************************* search query start  here*******************************/	
		
		$arr_search[] = " p.i_status =1 AND u.i_phone_verified = 1 "; 
		/* search by price range */
		if(!empty($price_start) && !empty($price_end))
		{
			$arr_search[] =" new.o_price >= ".getAmountByCurrency($price_start,$this->curId)." AND new.o_price <= ".getAmountByCurrency($price_end,$this->curId)." ";
		}
		/* search by price range */
		if($sessArrTmp['src_i_city_id'])
		{
			$arr_search[] =" p.i_city_id=".$sessArrTmp['src_i_city_id'];
		}
		if($sessArrTmp['src_total_guests'])
		{
			$arr_search[] =" p.i_total_guests >=".$sessArrTmp['src_total_guests'];
		}
		if($sessArrTmp['src_room_type'])
		{
			$arr_search[] =" p.e_accommodation_type IN ({$sessArrTmp['src_room_type']}) ";
		}
		if($sessArrTmp['src_amenity'])
		{
			$arr_search[] =" pa.i_amenity_id IN ({$sessArrTmp['src_amenity']}) ";
		}
	
		if($sessArrTmp['src_i_check_in'] && $sessArrTmp['src_i_check_out'])
		{
			$check_in 	= $sessArrTmp['src_i_check_in'];
			$check_out	= $sessArrTmp['src_i_check_out'];			
			
			$arr_search[] = " p.i_id NOT IN( SELECT i_property_id FROM ".$this->db->PROPERTYBLOCKED." WHERE dt_blocked_date>=".$check_in." AND dt_blocked_date <".$check_out.")";
			
			$arr_search[] = " p.i_id NOT IN( SELECT i_property_id FROM ".$this->db->BOOKING." WHERE (dt_booked_from BETWEEN ".$check_in." AND ".$check_out.")	OR ( dt_booked_to-3600*24 BETWEEN ".$check_in." AND ".$check_out." ))";
			
		}
		if($sessArrTmp['sort_property_by']=='')
		{
			$s_order .= " ORDER BY p.dt_created_on DESC ";
		}		
		else if($sessArrTmp['sort_property_by']=='name')
		{
			$s_order .= " ORDER BY p.s_property_name DESC ";
		}
		else if($sessArrTmp['sort_property_by']=='price_asc')
		{
			$s_order .= " ORDER BY new.o_price ASC ";
		}
		else if($sessArrTmp['sort_property_by']=='price_desc')
		{
			$s_order .= " ORDER BY new.o_price DESC ";
		}
			
		$s_where .= (count($arr_search) !=0)?' WHERE '.implode(' AND ',$arr_search):'';
		/******************************* search query end  here*******************************/	
		/* checking for add to favourites if the user login */
		if(!empty($this->data["loggedin"]))
		{
			$login_id = decrypt($this->data["loggedin"]["user_id"]);
		}
		else
		{
			$login_id = '';
		}
		
		/* checking for add to favourites if the user login */
		$limit	=  2;
		$this->data['property_list']	= $this->mod_rect->fetch_properties_on_search($s_where,$s_order,intval($start),$limit,$login_id);	
		
		$total_rows 					= $this->mod_rect->gettotal_properties_on_search_info($s_where);
		//pr($total_rows);	
		//pr($this->data['property_list'],1);
		/* pagination start @ defined in common-helper */
		$ctrl_path 	= base_url().'search/ajax_property_list/';
		$paging_div = 'property_list';
		$this->data['page_links'] 	= fe_ajax_pagination($ctrl_path, count($total_rows), $start, $limit, $paging_div);
		$this->data['total_rows'] 	= count($total_rows);
		$this->data['start'] 		= $start;
		
		if(empty($param))
			$job_vw = $this->load->view('fe/search/ajax_property_list.tpl.php',$this->data,TRUE);
		else
			$job_vw = $this->load->view('fe/search/ajax_property_list.tpl.php',$this->data,TRUE).'^'.count($total_rows);
		echo $job_vw;
		/* pagination end */

	
	}	
	
	
	public function details($enc_property_id)
    {
        try
        {
            
			$this->s_meta_type = 'property_details';
			$this->data['breadcrumb'] = array('Property'=>base_url().'search','Property Details'=>'');
            
            $i_property_id  =   decrypt($enc_property_id);
            
            $info   =   $this->mod_rect->fetch_this($i_property_id);            
			$this->data['info'] =   $info ;
			//pr($info,1);
			if(!empty($info))
			{
			$this->load->model('user_model','mod_user');
			$owner_info 				= $this->mod_user->fetch_this($info["i_owner_user_id"]);
			$this->data['owner_info']	= $owner_info;
			}
			//pr($owner_info,1);
            
            // fetch the all amenity of a property
            $s_where        =   " WHERE pa.i_property_id= ".$i_property_id." AND a.i_status=1";
            $info_amenity   =   $this->mod_rect->fetch_property_amenity($s_where) ;
            //pr($info_amenity,1);
            $this->data['info_amenity'] =   $info_amenity;
            /***************************** FETCH PROPERTY IMAGES   *******************************/
            $s_where        =   " WHERE pi.i_property_id= ".$i_property_id." " ;
            $info_image     =   $this->mod_rect->fetch_property_image($s_where) ;
            
            $arr_image   =   array();
            if(!empty($info_image))
            {
                $i  =   0;
                foreach($info_image as $val)
                {
                    $file_name  =   getFilenameWithoutExtension($val["s_property_image"]);
                    $arr_image[$i]["large"]  =   $file_name."_large.jpg";
                    $arr_image[$i]["min"]  	 =   $file_name."_min.jpg";
                    $i++; 
                }
            }
            $this->data["arr_image"]    =   $arr_image ;
			/***************************** FETCH PROPERTY IMAGES   *******************************/
			
			/***************************** FETCH OTHER PROPERTY   *******************************/
			$s_where = " WHERE p.i_id!=".$i_property_id." AND p.i_status =1 ";
			$other_property = $this->mod_rect->fetch_multi($s_where,0,2);
			$this->data["other_property"]	=	$other_property;
			//pr($other_property,1);
			/***************************** FETCH OTHER PROPERTY   *******************************/
			if($_POST)
            {
                $selected_month  =   $this->input->post('selectmonth');
                $arr_month  =   explode('_',$selected_month);
                $time_str   =   strtotime('01-'.$arr_month[0].'-'.$arr_month[1]) ;
                $this->data['selected_month']   =   $selected_month ;
                $this->data['index']            =   1 ;
                
                
            }
            else
            {
               $time_str = time(); 
            }
			/***************************** TO GENERATE CALENDER   *******************************/
			
			$days = get_first_day_and_total_days_of_a_month($time_str);
			$arr_day = explode('^',$days);
			$this->data["start_day"]  = $arr_day[0];
			$this->data["total_days"] = $arr_day[1];
			/***************************** TO GENERATE CALENDER*******************************/
            
            
           
           
            /************************ END MONTH ******************/
            unset($info,$info_image,$info_amenity,$owner_info);
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
    
    public function testing()
    {
        try
        {
           $time    =   strtotime('01-07-2012') ;
           echo date('D',$time) ;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

	
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

