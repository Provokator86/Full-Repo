<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 * This controller contains the common functions
 * @author Teamtweaks
 *
 */
class MY_Controller extends CI_Controller {
	public $privStatus;
	public $data = array();
	function __construct()
	{
		parent::__construct();
		ob_start();
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->helper('url');
		$this->load->helper('text');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->load->library('session');

		/*
		 * Connecting Database
		 */
		$this->load->database();

		$this->data['demoserverChk'] = $demoserverChk = strpos($this->input->server('DOCUMENT_ROOT'),'kaviraj/');
		
		/*
		 * Loading Footer Widgets
		 */
		if ($_SESSION['footerWidget'] == ''){
			$footerWidget = $this->db->query('select * from '.FOOTER.' where `status`="Active"');
			$_SESSION['footerWidget'] = $footerWidget->result_array();
		}
		$this->data['footerWidget'] = $_SESSION['footerWidget'];
		
		/*
		 * Loading CMS Pages
		 */
		if ($_SESSION['cmsPages'] == ''){
			$cmsPages = $this->db->query('select * from '.CMS.' where `status`="Publish" and `hidden_page`="No" order by `priority` asc');
			$_SESSION['cmsPages'] = $cmsPages->result_array();
		}
		$this->data['cmsPages'] = $_SESSION['cmsPages'];

		/*
		 * Getting fancybox count
		 */
		if ($_SESSION['fancyBoxCount'] == ''){
			$fancyBoxList = $this->db->query('select * from '.FANCYYBOX.' where `status`="Publish"');
			$_SESSION['fancyBoxCount'] = $fancyBoxList->num_rows();
		}
		$this->data['fancyBoxCount'] = $_SESSION['fancyBoxCount'];
        
        
        /* New code Jan 2015
         * Getting root Categories
         */
        if ($_SESSION['MainCategoryList'] == ''){
            $fancyBoxList = $this->db->query('select seourl,cat_name from '.CATEGORY.' where `status`="Active" AND rootID=0 ');
            $_SESSION['MainCategoryList'] = $fancyBoxList->result_array();
        }
        $this->data['MainCategoryList'] = $_SESSION['MainCategoryList'];
        //pr($this->data['MainCategoryList']);

		/*
		 * Getting Categories
		 */
		if ($_SESSION['CategoryList'] == ''){
			$fancyBoxList = $this->db->query('select seourl,cat_name from '.CATEGORY.' where `status`="Active"');
			$_SESSION['CategoryList'] = $fancyBoxList->result_array();
		}
		$this->data['CategoryList'] = $_SESSION['CategoryList'];
		//print_r($this->data['CategoryList']);

		/*
		 * Loading active languages
		 */
		if ($_SESSION['activeLgs'] == ''){
			$activeLgsList = $this->db->query('select * from '.LANGUAGES.' where `status`="Active"');
			$_SESSION['activeLgs'] = $activeLgsList->result_array();
		}
		$this->data['activeLgs'] = $_SESSION['activeLgs'];

		/*
		 * Checking user language and loading user details
		 */
		if($this->checkLogin('U')!=''){
			$this->data['userDetails'] = $this->db->query('select * from '.USERS.' where `id`="'.$this->checkLogin('U').'"');
				
			/*			$selectedLangCode = $this->session->userdata('language_code');
	 		if ($this->data['userDetails']->row()->language != $selectedLangCode){
	 		$this->session->set_userdata('language_code',$this->data['userDetails']->row()->language);
	 		$this->session->keep_flashdata('sErrMSGType');
	 		$this->session->keep_flashdata('sErrMSG');
	 		redirect($this->uri->uri_string());
	 		}
	 		*/		}

			$uriMethod = $this->uri->segment('3','0');
			if (substr($uriMethod, 0,7) == 'display' || substr($uriMethod, 0,4) == 'view' || $uriMethod == '0'){
				$this->privStatus = '0';
			}else if (substr($uriMethod, 0,3) == 'add'){
				$this->privStatus = '1';
			}else if (substr($uriMethod, 0,4) == 'edit' || substr($uriMethod, 0,6) == 'insert' || substr($uriMethod, 0,6) == 'change'){
				$this->privStatus = '2';
			}else if (substr($uriMethod, 0,6) == 'delete'){
				$this->privStatus = '3';
			}
			$this->data['title'] = $this->config->item('meta_title');;
			$this->data['heading'] = '';
			$this->data['flash_data'] = $this->session->flashdata('sErrMSG');
			$this->data['flash_data_type'] = $this->session->flashdata('sErrMSGType');
			$this->data['adminPrevArr'] = $this->config->item('adminPrev');
			$this->data['adminEmail'] = $this->config->item('email');
			$this->data['privileges'] = $this->session->userdata('fc_session_admin_privileges');
			$this->data['subAdminMail'] = $this->session->userdata('fc_session_admin_email');
			$this->data['loginID'] = $this->session->userdata('fc_session_user_id');
			$this->data['allPrev'] = '0';
			$this->data['logo'] = $this->config->item('logo_image');
			$this->data['fevicon'] = $this->config->item('fevicon_image');
			$this->data['footer'] = $this->config->item('footer_content');
			$this->data['siteContactMail'] = $this->config->item('site_contact_mail');
			$this->data['WebsiteTitle'] = $this->config->item('email_title');
			$this->data['siteTitle'] = $this->config->item('email_title');
			$this->data['meta_title'] = $this->config->item('meta_title');
			$this->data['meta_keyword'] = $this->config->item('meta_keyword');
			$this->data['meta_description'] = $this->config->item('meta_description');
			$this->data['giftcard_status'] = $this->config->item('giftcard_status');
			$this->data['sidebar_id'] = $this->session->userdata('session_sidebar_id');
			if ($this->session->userdata('fc_session_admin_name') == $this->config->item('admin_name')){
				$this->data['allPrev'] = '1';
			}
			$this->data['paypal_ipn_settings'] = unserialize($this->config->item('payment_0'));
			$this->data['paypal_credit_card_settings'] = unserialize($this->config->item('payment_1'));
			$this->data['authorize_net_settings'] = unserialize($this->config->item('payment_2'));
			$this->data['currencySymbol'] = $this->config->item('currency_currency_symbol');
			//		$this->data['currencySymbol'] = html_entity_decode($this->config->item('currency_currency_symbol'));
			$this->data['currencyType'] = $this->config->item('currency_currency_type');
			$this->data['datestring'] = "%Y-%m-%d %h:%i:%s";
			if($this->checkLogin('U')!=''){
				$this->data['common_user_id'] = $this->checkLogin('U');
			}elseif($this->checkLogin('T')!=''){
				$this->data['common_user_id'] = $this->checkLogin('T');
			}else{
				$temp_id = substr(number_format(time() * rand(),0,'',''),0,6);
				$this->session->set_userdata('fc_session_temp_id',$temp_id);
				$this->data['common_user_id'] = $temp_id;
			}
			$this->data['emailArr'] = $this->config->item('emailArr');
			$this->data['notyArr'] = $this->config->item('notyArr');
			$this->load->model('minicart_model');
			$this->load->model('product_model');
			$this->data['MiniCartViewSet'] = $this->minicart_model->mini_cart_view($this->data['common_user_id']);

			/*
			 * Like button texts
			 */
			define(LIKE_BUTTON, $this->config->item('like_text'));
			define(LIKED_BUTTON, $this->config->item('liked_text'));
			define(UNLIKE_BUTTON, $this->config->item('unlike_text'));

			if($_SESSION['authUrl'] == ''){
				//header( 'Location:http://192.168.1.253/fancyclone/');
			}


			/*Refereral Start */

			if($this->input->get('ref') != '')
			{
				//echo $this->input->get('ref');
				$referenceName = $this->input->get('ref');
				$this->session->set_userdata('referenceName',$referenceName);
			}

			/*Refereral End */

			/* Multilanguage start*/
			if($this->uri->segment('1') != 'admin')
			{
					
				$selectedLanguage = $this->session->userdata('language_code');
				$defaultLanguage = 'en';
				$filePath = APPPATH."language/".$selectedLanguage."/".$selectedLanguage."_lang.php";
				if($selectedLanguage != '')
				{
						
					if(!(is_file($filePath)))
					{
							
						$this->lang->load($defaultLanguage, $defaultLanguage);
					}
					else
					{
						$this->lang->load($selectedLanguage, $selectedLanguage);
					}

				}
				else
				{
					$selectedLanguage = $this->session->userdata('site_lang');
					if ($selectedLanguage == ''){
						$lg_details = $this->db->query('select * from '.LANGUAGES.' where `status`="Active" and `is_default`="Yes"');
						if ($lg_details->num_rows()==1){
							$this->lang->load($lg_details->row()->lang_code,$lg_details->row()->lang_code);
							$this->session->set_userdata('site_lang',$lg_details->row()->lang_code);
						}else {
							$this->lang->load('en','en');
							$this->session->set_userdata('site_lang','en');
						}
					}else {
						$defaultLanguage = 'en';
						$filePath = APPPATH."language/".$selectedLanguage."/".$selectedLanguage."_lang.php";
						if(!(is_file($filePath)))
						{
								
							$this->lang->load($defaultLanguage, $defaultLanguage);
						}
						else
						{
							$this->lang->load($selectedLanguage, $selectedLanguage);
						}
					}
				}
			}
			/* Multilanguage end*/

			/*Loading Default Language*/


	}

	/**
	 *
	 * This function return the session value based on param
	 * @param $type
	 */
	public function checkLogin($type=''){
		if ($type == 'A'){
			return $this->session->userdata('fc_session_admin_id');
		}else if ($type == 'N'){
			return $this->session->userdata('fc_session_admin_name');
		}else if ($type == 'M'){
			return $this->session->userdata('fc_session_admin_email');
		}else if ($type == 'P'){
			return $this->session->userdata('fc_session_admin_privileges');
		}else if ($type == 'U'){
			return $this->session->userdata('fc_session_user_id');
		}else if ($type == 'T'){
			return $this->session->userdata('fc_session_temp_id');
				
		}
	}

	/**
	 *
	 * This function set the error message and type in session
	 * @param string $type
	 * @param string $msg
	 */
	public function setErrorMessage($type='',$msg=''){
		($type == 'success') ? $msgVal = 'message-green' : $msgVal = 'message-red';
		$this->session->set_flashdata('sErrMSGType', $msgVal);
		$this->session->set_flashdata('sErrMSG', $msg);
	}
	/**
	 *
	 * This function check the admin privileges
	 * @param String $name	->	Management Name
	 * @param Integer $right	->	0 for view, 1 for add, 2 for edit, 3 delete
	 */
	public function checkPrivileges($name='',$right=''){
		$prev = '0';
		$privileges = $this->session->userdata('fc_session_admin_privileges');
		extract($privileges);
		$userName =  $this->session->userdata('fc_session_admin_name');
		$adminName = $this->config->item('admin_name');
		if ($userName == $adminName){
			$prev = '1';
		}
		if (isset(${$name}) && is_array(${$name}) && in_array($right, ${$name})){
			$prev = '1';
		}
		if ($prev == '1'){
			return TRUE;
		}else {
			return FALSE;
		}
	}
	 
	/**
	 *
	 * Generate random string
	 * @param Integer $length
	 */
	public function get_rand_str($length='6'){
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}
	 
	/**
	 *
	 * Unsetting array element
	 * @param Array $productImage
	 * @param Integer $position
	 */
	public function setPictureProducts($productImage,$position){
		unset($productImage[$position]);
		return $productImage;
	}

	/**
	 *
	 * Resize the image
	 * @param int target_width
	 * @param int target_height
	 * @param string image_name
	 * @param string target_path
	 */
	public function imageResizeWithSpace($box_w,$box_h,$userImage,$savepath){
			
		$thumb_file = $savepath.$userImage;
			
		$dist_file = $savepath.'/thumb/'.$userImage;

		list($w, $h, $type, $attr) = getimagesize($thumb_file);

		$size=getimagesize($thumb_file);
		switch($size["mime"]){
			case "image/jpeg":
				$img = imagecreatefromjpeg($thumb_file); //jpeg file
				break;
			case "image/gif":
				$img = imagecreatefromgif($thumb_file); //gif file
				break;
			case "image/png":
				$img = imagecreatefrompng($thumb_file); //png file
				break;

			default:
				$im=false;
				break;
		}

		$new = imagecreatetruecolor($box_w, $box_h);
		if($new === false) {
			//creation failed -- probably not enough memory
			return null;
		}


		$fill = imagecolorallocate($new, 255, 255, 255);
		imagefill($new, 0, 0, $fill);

		//compute resize ratio
		$hratio = $box_h / imagesy($img);
		$wratio = $box_w / imagesx($img);
		$ratio = min($hratio, $wratio);

		if($ratio > 1.0)
		$ratio = 1.0;

		//compute sizes
		$sy = floor(imagesy($img) * $ratio);
		$sx = floor(imagesx($img) * $ratio);

		$m_y = floor(($box_h - $sy) / 2);
		$m_x = floor(($box_w - $sx) / 2);

		if(!imagecopyresampled($new, $img,
		$m_x, $m_y, //dest x, y (margins)
		0, 0, //src x, y (0,0 means top left)
		$sx, $sy,//dest w, h (resample to this size (computed above)
		imagesx($img), imagesy($img)) //src w, h (the full size of the original)
		) {
			//copy failed
			imagedestroy($new);
			return null;

		}
		imagedestroy($i);
		imagejpeg($new, $dist_file, 99);
			
	}

	public function crop_and_resize_image($new_width,$new_height,$file_path,$file_name,$des_path){

		define ('MAX_WIDTH', 1500);//max image width
		define ('MAX_HEIGHT', 1500);//max image height
		define ('MAX_FILE_SIZE', 10485760);
		$file = $file_path.$file_name;
		//iamge save path
		$path = $des_path;

		//size of the resize image
		//    $new_width = 128;
		//   $new_height = 128;

		//name of the new image
		$nameOfFile = $file_name;

		$image_type = $file['type'];
		$image_size = $file['size'];
		$image_error = $file['error'];
		$image_file = $file['tmp_name'];
		$image_name = $file['name'];

		$image_info = getimagesize($file);

		//check image type
		if ($image_info['mime'] == 'image/jpeg' or $image_info['mime'] == 'image/jpg'){
		}
		else if ($image_info['mime'] == 'image/png'){
		}
		else if ($image_info['mime'] == 'image/gif'){
		}
		else{
			//set error invalid file type
		}

		if ($image_error){
			//set error image upload error
		}

		if ( $image_size > MAX_FILE_SIZE ){
			//set error image size invalid
		}

		switch ($image_info['mime']) {
			case 'image/jpg': //This isn't a valid mime type so we should probably remove it
			case 'image/jpeg':
				$image = imagecreatefromjpeg ($file);
				break;
			case 'image/png':
				$image = imagecreatefrompng ($file);
				break;
			case 'image/gif':
				$image = imagecreatefromgif ($file);
				break;
		}

		if ($new_width == 0 && $new_height == 0) {
			$new_width = 100;
			$new_height = 100;
		}

		// ensure size limits can not be abused
		$new_width = min ($new_width, MAX_WIDTH);
		$new_height = min ($new_height, MAX_HEIGHT);

		//get original image h/w
		$width = imagesx ($image);
		$height = imagesy ($image);

		//$align = 'b';
		$zoom_crop = 1;
		$origin_x = 0;
		$origin_y = 0;
		//TODO setting Memory

		// generate new w/h if not provided
		if ($new_width && !$new_height) {
			$new_height = floor ($height * ($new_width / $width));
		} else if ($new_height && !$new_width) {
			$new_width = floor ($width * ($new_height / $height));
		}

		// scale down and add borders
		if ($zoom_crop == 3) {

			$final_height = $height * ($new_width / $width);

			if ($final_height > $new_height) {
				$new_width = $width * ($new_height / $height);
			} else {
				$new_height = $final_height;
			}

		}

		// create a new true color image
		$canvas = imagecreatetruecolor ($new_width, $new_height);
		imagealphablending ($canvas, false);


		//        if (strlen ($canvas_color) < 6) {
		$canvas_color = 'ffffff';
		//       }

		$canvas_color_R = hexdec (substr ($canvas_color, 0, 2));
		$canvas_color_G = hexdec (substr ($canvas_color, 2, 2));
		$canvas_color_B = hexdec (substr ($canvas_color, 2, 2));

		// Create a new transparent color for image
		$color = imagecolorallocatealpha ($canvas, $canvas_color_R, $canvas_color_G, $canvas_color_B, 127);

		// Completely fill the background of the new image with allocated color.
		imagefill ($canvas, 0, 0, $color);

		// scale down and add borders
		if ($zoom_crop == 2) {

			$final_height = $height * ($new_width / $width);

			if ($final_height > $new_height) {
				$origin_x = $new_width / 2;
				$new_width = $width * ($new_height / $height);
				$origin_x = round ($origin_x - ($new_width / 2));
			} else {

				$origin_y = $new_height / 2;
				$new_height = $final_height;
				$origin_y = round ($origin_y - ($new_height / 2));

			}

		}

		// Restore transparency blending
		imagesavealpha ($canvas, true);

		if ($zoom_crop > 0) {

			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;

			$cmp_x = $width / $new_width;
			$cmp_y = $height / $new_height;

			// calculate x or y coordinate and width or height of source
			if ($cmp_x > $cmp_y) {
				$src_w = round ($width / $cmp_x * $cmp_y);
				$src_x = round (($width - ($width / $cmp_x * $cmp_y)) / 2);
			} else if ($cmp_y > $cmp_x) {
				$src_h = round ($height / $cmp_y * $cmp_x);
				$src_y = round (($height - ($height / $cmp_y * $cmp_x)) / 2);
			}

			// positional cropping!
			$align = false;
			if ($align) {
				if (strpos ($align, 't') !== false) {
					$src_y = 0;
				}
				if (strpos ($align, 'b') !== false) {
					$src_y = $height - $src_h;
				}
				if (strpos ($align, 'l') !== false) {
					$src_x = 0;
				}
				if (strpos ($align, 'r') !== false) {
					$src_x = $width - $src_w;
				}
			}

			// positional cropping!
			imagecopyresampled ($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);

		} else {
			imagecopyresampled ($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
		}
		//Straight from Wordpress core code. Reduces filesize by up to 70% for PNG's
		if ( (IMAGETYPE_PNG == $image_info[2] || IMAGETYPE_GIF == $image_info[2]) && function_exists('imageistruecolor') && !imageistruecolor( $image ) && imagecolortransparent( $image ) > 0 ){
			imagetruecolortopalette( $canvas, false, imagecolorstotal( $image ) );
		}
		$quality = 100;
		$nameOfFile = $file_name;

		if (preg_match('/^image\/(?:jpg|jpeg)$/i', $image_info['mime'])){
			imagejpeg($canvas, $path.$nameOfFile, $quality);

		} else if (preg_match('/^image\/png$/i', $image_info['mime'])){
			imagepng($canvas, $path.$nameOfFile, floor($quality * 0.09));

		} else if (preg_match('/^image\/gif$/i', $image_info['mime'])){
			imagegif($canvas, $path.$nameOfFile);

		}
	}

}
