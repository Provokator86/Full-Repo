<?php
/*********
* Author: SWI
* Date  : 2 June 2017
* Modified By: SWI
* Modified Date: 20 July 2017
* 
* Purpose:
*  Controller For Admin Dashboard. "i_user_type_id"=0 is for super admin
* 
* @package Admin
* @subpackage 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/dashboard_model.php
* @link views/admin/dashboard/
*/
//error_reporting(E_ALL);
class Dashboard extends MY_Controller 
{
    public $cls_msg;//All defined error messages. 
    public $indian_symbol, $user_type, $user_id, $user_name, $tbl_user, $logged_in;
     
    public function __construct()
    {            
        try
        {
            parent::__construct();
            //Define Errors Here//
            $this->cls_msg=array();

            //end Define Errors Here//
            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
            $this->load->model("dashboard_model","mod_rect");
            
            $this->tbl_user = $this->db->USER;
            

            $this->logged_in 	= $logged_in = $this->session->userdata("admin_loggedin");
            $this->user_type    = decrypt($logged_in["user_type_id"]);
            $this->user_id      = decrypt($logged_in["user_id"]);		  
            $this->user_name    = $logged_in['user_name'];		  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    public function index()
    {
        try
        {
			//echo 'User Type==> '.$this->user_type.' ============== User ID==>'.$this->user_id.' ===== Username==> '.$this->user_name;
			//pr($this->logged_in);
			$this->data['pathtoclass']	=	$this->pathtoclass;			
			$this->data['BREADCRUMB']	=	array('Dashboard');			
            $this->data['title']        =   "Dashboard";////Browser Title
            $this->data['heading']      =   "Dashboard of Admin Panel";
            $this->data['user_type']    =   $this->user_type;
            $admin_loggedin             =   $this->session->userdata('admin_loggedin'); 
            
            // TOTAl USERS
            //$s_user_cond = " WHERE n.i_user_type=2 AND n.e_deleted='No' AND n.i_status=1 "; 
            $s_user_cond = " WHERE n.i_user_type=5 AND n.e_deleted='No' AND n.i_status=1 "; // new code 17 aug 2017
            $this->data["total_user"] = $this->mod_rect->gettotal_user_info($s_user_cond);
            
            // YTD BATCH RECEIVED            
            $ytd_st_dt = date('Y').'-01-01';  $ytd_end_dt = date("Y-m-d");             
            $s_batch_cond = " WHERE  DATE_FORMAT(dt_created, '%Y-%m-%d') >= '".$ytd_st_dt."' AND DATE_FORMAT(dt_created, '%Y-%m-%d') <= '".$ytd_end_dt."' ";
            if($this->user_type > 4 &&  $this->user_name != '')
				$s_batch_cond .= " AND  s_username ='".addslashes($this->user_name)."' "; 
				
            $this->data["ytd_batch_received"] = $this->mod_rect->gettotal_batch_count($s_batch_cond);
            
            // YTD BATCH ACCEPTED           
            $s_batch_cond = " WHERE  DATE_FORMAT(dt_change_status, '%Y-%m-%d') >= '".$ytd_st_dt."' AND DATE_FORMAT(dt_change_status, '%Y-%m-%d') <= '".$ytd_end_dt."' AND i_status>=2 "; // more than invoice paid 
            if($this->user_type > 4 &&  $this->user_name != '')
				$s_batch_cond .= " AND  s_username ='".addslashes($this->user_name)."' "; 
            $this->data["ytd_batch_accepted"] = $this->mod_rect->gettotal_batch_count($s_batch_cond);
            
            // YTD FILES DOWNLOADED          
            $s_file_cond = " WHERE  DATE_FORMAT(dt_download, '%Y-%m-%d') >= '".$ytd_st_dt."' AND DATE_FORMAT(dt_download, '%Y-%m-%d') <= '".$ytd_end_dt."' "; 
            if($this->user_type > 4 &&  $this->user_name != '')
				$sql_ascii .= " AND  i_created_by ='".addslashes($this->user_id)."' "; 
            $this->data["ytd_file_downloaded"] = $this->mod_rect->file_downloaded_count($s_file_cond);
            
            // FORMS AWAITING FOR SUBMISSION. MODIFIED 20 JULY, 2017 DEPENDING UPON USER            
            $sql = "SELECT i_id, s_batch_id FROM {$this->db->BATCH_MASTER} WHERE i_status = 4 "; 
             
            if($this->user_type > 4 &&  $this->user_name != '')
				$sql .= " AND s_username='".addslashes($this->user_name)."' "; // for user type greater than admin
				
            $batches = $this->acs_model->exc_query($sql, true); 
            $formsArr = array(); $subMissionArr = array();
            if(!empty($batches))
            {
				foreach($batches as $key=>$val)
				{
					$qry = " SELECT i_id, s_batch_code, s_form_id FROM {$this->db->FORMS_PAYER_PAYEE_HISTORY} WHERE s_batch_code='".addslashes($val["s_batch_id"])."' ";
					$forms = $this->acs_model->exc_query($qry, true);
					
					if(!empty($forms))
						$formsArr = array_merge($formsArr, $forms);
					
				}
			}
            #pr($formsArr, 1);
            $total_cnt = 0;
			if(!empty($formsArr))
			{
				foreach($formsArr as $k => $v)
				{
					$total_cnt = $total_cnt+1;
					
					$formId = $v["s_form_id"];
					if(array_key_exists($formId, $subMissionArr))
					{
						$cnt = $subMissionArr[$formId];
						$subMissionArr[$formId] = $cnt + 1;
					}
					else
						$subMissionArr[$formId] = $total_cnt;
				}
			}
			$this->data["subMissionArr"] = $subMissionArr;
			//pr($subMissionArr,1);
			// END FORMS AWAITING FOR SUBMISSION
			
			// START NON CLASSIFIED ASCII 			
            $sql_ascii = "SELECT i_id, s_batch_ids FROM {$this->db->BATCH_ASCII_FILE} WHERE i_status = 0 ";  
            
            if($this->user_type > 4 &&  $this->user_name != '')
				$sql_ascii .= " AND  i_created_by ='".addslashes($this->user_id)."' "; // 21 July for user type greater than admin
				
            $ascii_batches = $this->acs_model->exc_query($sql_ascii, true); 
            $asciiFormsArr = array(); $nonClsAsciiArr = array();
            
            if(!empty($ascii_batches))
            {
				foreach($ascii_batches as $key=>$val)
				{
					$str = "'".str_replace(',',"','",$val['s_batch_ids'])."'";
					$qry = " SELECT i_id, s_batch_code, s_form_id FROM {$this->db->FORMS_PAYER_PAYEE_HISTORY} WHERE s_batch_code IN (".$str.") ";
					$asciiForms = $this->acs_model->exc_query($qry, true);
					
					if(!empty($asciiForms))
						$asciiFormsArr = array_merge($asciiFormsArr, $asciiForms);
					
				}
			}
            //pr($asciiFormsArr, 1);            
            $total_cnt = 0;
			if(!empty($asciiFormsArr))
			{
				foreach($asciiFormsArr as $k => $v)
				{
					$total_cnt = $total_cnt+1;
					
					$formId = $v["s_form_id"];
					if(array_key_exists($formId, $nonClsAsciiArr))
					{
						$cnt = $nonClsAsciiArr[$formId];
						$nonClsAsciiArr[$formId] = $cnt + 1;
					}
					else
						$nonClsAsciiArr[$formId] = $total_cnt;
				}
			}
			$this->data["nonClsAsciiArr"] = $nonClsAsciiArr;
            
			// END NON CLASSIFIED ASCII
			
			// ********************* START GRAPH ************************ 			
			
			$sql1 = "SELECT 
					SUM(IF(month = 'Jan', total, 0)) AS 'Jan',
					SUM(IF(month = 'Feb', total, 0)) AS 'Feb',
					SUM(IF(month = 'Mar', total, 0)) AS 'Mar',
					SUM(IF(month = 'Apr', total, 0)) AS 'Apr',
					SUM(IF(month = 'May', total, 0)) AS 'May',
					SUM(IF(month = 'Jun', total, 0)) AS 'Jun',
					SUM(IF(month = 'Jul', total, 0)) AS 'Jul',
					SUM(IF(month = 'Aug', total, 0)) AS 'Aug',
					SUM(IF(month = 'Sep', total, 0)) AS 'Sep',
					SUM(IF(month = 'Oct', total, 0)) AS 'Oct',
					SUM(IF(month = 'Nov', total, 0)) AS 'Nov',
					SUM(IF(month = 'Dec', total, 0)) AS 'Dec'
					FROM (
				SELECT DATE_FORMAT(dt_created, '%b') AS month, COUNT(*) as total
				FROM {$this->db->BATCH_MASTER}
				WHERE dt_created <= NOW() and dt_created >= Date_add(Now(),interval - 12 month) ";
			
            if($this->user_type > 4 &&  $this->user_name != '')
				$sql1 .= " AND s_username='".addslashes($this->user_name)."' "; // 21 July for user type greater than admin
				
			$sql1 .= " GROUP BY DATE_FORMAT(dt_created, '%m-%Y')) as sub";
			
			$res1 = $this->acs_model->exc_query($sql1, true);
			$arrRec = $res1[0];
			unset($res, $sql1);
			
			
			$sql2 = "SELECT 
					SUM(IF(month = 'Jan', total, 0)) AS 'Jan',
					SUM(IF(month = 'Feb', total, 0)) AS 'Feb',
					SUM(IF(month = 'Mar', total, 0)) AS 'Mar',
					SUM(IF(month = 'Apr', total, 0)) AS 'Apr',
					SUM(IF(month = 'May', total, 0)) AS 'May',
					SUM(IF(month = 'Jun', total, 0)) AS 'Jun',
					SUM(IF(month = 'Jul', total, 0)) AS 'Jul',
					SUM(IF(month = 'Aug', total, 0)) AS 'Aug',
					SUM(IF(month = 'Sep', total, 0)) AS 'Sep',
					SUM(IF(month = 'Oct', total, 0)) AS 'Oct',
					SUM(IF(month = 'Nov', total, 0)) AS 'Nov',
					SUM(IF(month = 'Dec', total, 0)) AS 'Dec'
					FROM (
				SELECT DATE_FORMAT(dt_created, '%b') AS month, COUNT(*) as total
				FROM {$this->db->BATCH_MASTER}
				WHERE i_status>=2 AND dt_created <= NOW() and dt_created >= Date_add(Now(),interval - 12 month) ";
			
            if($this->user_type > 4 &&  $this->user_name != '')
				$sql2 .= " AND s_username='".addslashes($this->user_name)."' "; // 21 July for user type greater than admin
				
			$sql2 .= " GROUP BY DATE_FORMAT(dt_created, '%m-%Y')) as sub";
			
			$res2 = $this->acs_model->exc_query($sql2, true);
			$arrAcc = $res2[0];
			unset($res2, $sql2);
			//pr($res2,1);
			
			$newArr = array();
			$finalStr='';
			if(!empty($arrRec))
			{
				foreach($arrRec as $key => $val)
				{
					$acc = $arrAcc[$key];
					$finalStr .= "['".$key."',$val,$acc],";
				}
				
				$finalStr = trim($finalStr, ',');
			}
			$this->data['finalStr'] = $finalStr;
			
			// Earning - Last 12 months start
			$sql = "SELECT 
					SUM(IF(month = 'Jan', total, 0)) AS 'Jan',
					SUM(IF(month = 'Feb', total, 0)) AS 'Feb',
					SUM(IF(month = 'Mar', total, 0)) AS 'Mar',
					SUM(IF(month = 'Apr', total, 0)) AS 'Apr',
					SUM(IF(month = 'May', total, 0)) AS 'May',
					SUM(IF(month = 'Jun', total, 0)) AS 'Jun',
					SUM(IF(month = 'Jul', total, 0)) AS 'Jul',
					SUM(IF(month = 'Aug', total, 0)) AS 'Aug',
					SUM(IF(month = 'Sep', total, 0)) AS 'Sep',
					SUM(IF(month = 'Oct', total, 0)) AS 'Oct',
					SUM(IF(month = 'Nov', total, 0)) AS 'Nov',
					SUM(IF(month = 'Dec', total, 0)) AS 'Dec'
					FROM (
				SELECT DATE_FORMAT(dt_payment, '%b') AS month, SUM(d_amount) as total
				FROM {$this->db->PAYMENT_HISTORY}
				WHERE i_status=1 AND dt_payment <= NOW() and dt_payment >= Date_add(Now(),interval - 12 month) ";
			
            if($this->user_type > 4 &&  $this->user_name != '')
				$sql .= " AND s_user ='".addslashes($this->user_name)."' "; // 21 July for user type greater than admin
				
			$sql .= " GROUP BY DATE_FORMAT(dt_payment, '%m-%Y')) as sub";
			
			$res = $this->acs_model->exc_query($sql, true);
			$arrRes = $res[0];
			unset($res, $sql);$earningStr='';
			if(!empty($arrRes))
			{
				foreach($arrRes as $key => $val)
				{
					//$val = floor($val);
					$earningStr .= "['".$key."',$val],";
				}
				
				$earningStr = trim($earningStr, ',');
			}
			$this->data['earningStr'] = $earningStr;
			
			
			
			// Earning - Last 12 months end
						
			$this->render('dashboard/dashboard');  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
    
    
    // ajax call to get non classified ascii on date change 
    public function ajax_fetch_non_ascii_classified()
    {
		$res = array('html'=>'', 'msg'=>'');
		$startDate 	= $this->input->post('startDate');
		$endDate 	= $this->input->post('endDate');	
		
		$startDateArr 	= explode('/', $startDate);	
		$endDateArr 	= explode('/', $endDate);	
		
		$dt_from 	= $startDateArr[2].'-'.$startDateArr[0].'-'.$startDateArr[1];
		$dt_to 		= $endDateArr[2].'-'.$endDateArr[0].'-'.$endDateArr[1];
		// START NON CLASSIFIED ASCII 			
		$sql_ascii = "SELECT i_id, s_batch_ids FROM {$this->db->BATCH_ASCII_FILE} WHERE i_status = 0 AND DATE_FORMAT(dt_download, '%Y-%m-%d') >= '".$dt_from."' AND DATE_FORMAT(dt_download, '%Y-%m-%d') <= '".$dt_to."'   ";  
		
		if($this->user_type > 4 &&  $this->user_name != '')
			$sql_ascii .= " AND  i_created_by ='".addslashes($this->user_id)."' "; // 21 July for user type greater than admin
				
		$ascii_batches = $this->acs_model->exc_query($sql_ascii, true); 
		$asciiFormsArr = array(); $nonClsAsciiArr = array();
		
		if(!empty($ascii_batches))
		{
			foreach($ascii_batches as $key=>$val)
			{
				$str = "'".str_replace(',',"','",$val['s_batch_ids'])."'";
				$qry = " SELECT i_id, s_batch_code, s_form_id FROM {$this->db->FORMS_PAYER_PAYEE_HISTORY} WHERE s_batch_code IN (".$str.") ";
				$asciiForms = $this->acs_model->exc_query($qry, true);
				
				if(!empty($asciiForms))
					$asciiFormsArr = array_merge($asciiFormsArr, $asciiForms);
				
			}
		}
		//pr($asciiFormsArr, 1);            
		$total_cnt = 0;
		if(!empty($asciiFormsArr))
		{
			foreach($asciiFormsArr as $k => $v)
			{
				$total_cnt = $total_cnt+1;
				
				$formId = $v["s_form_id"];
				if(array_key_exists($formId, $nonClsAsciiArr))
				{
					$cnt = $nonClsAsciiArr[$formId];
					$nonClsAsciiArr[$formId] = $cnt + 1;
				}
				else
					$nonClsAsciiArr[$formId] = $total_cnt;
			}
		}
		
		// END NON CLASSIFIED ASCII
		$html = '<tr><th width="50%" align="center">Form</th><th width="50%" style="text-align: right;">Count</th></tr>';		
		if(!empty($nonClsAsciiArr)){
			foreach($nonClsAsciiArr as $key => $val){
				$html .= '<tr><td>'._form_title($key).'</td><td align="right">'.$val.'</td></tr>';   
			}
		} else {
			$html .= '<tr><td>N/A</td><td align="right">-</td></tr>';  
		}   
		    
		$res['html'] = $html;
		$res['msg'] = 'success';		
		echo json_encode($res);
			
		
	}
    
    
    public function nap_sendRQ() {
		
		$VAR = "<?xml version='1.0' encoding='UTF-8'?>
				<item>
				<Company>
				<PayerInfo>
				<TIN>526464659</TIN>
				<Year>2015</Year>	
				<TypeOfTIN>4</TypeOfTIN>	
				<AmountCode>2</AmountCode>	
				<TransferAgentIndicator>0</TransferAgentIndicator>
				<CompanyName>ABC Company</CompanyName>
				<CompanyNameLine2>ABC Company</CompanyNameLine2>
				<CompanyAddress>123 Some Street</CompanyAddress>
				<City>Some City</City>
				<State>ST</State>
				<Zipcode>123445</Zipcode>
				<Phone>8152264352</Phone>
				</PayerInfo>
				<Recipient id='1'>
				<PayeeTIN>374476543</PayeeTIN>
				<PayeeTypeOfTIN>1</PayeeTypeOfTIN>
				<PayeeName>RONALD TRUEDOE</PayeeName>
				<PayeeName2>RE</PayeeName2>
				<PayeeAddr>5278 S PALMTREE CT</PayeeAddr>
				<PayeeCity>SOMECITY</PayeeCity>
				<PayeeState>OK</PayeeState>
				<PayeeZipcode>743451111</PayeeZipcode>
				<Box1>452.67</Box1>
				<Box2>125.00</Box2>
				</Recipient>
				</Company>
				</item>";
			/*$VAR = <<<XML
<?xml version='1.0'?> 
<document>
 <title>Forty What?</title>
 <from>Joe</from>
 <to>Jane</to>
 <body>
  I know that's the answer -- but what's the question?
 </body>
</document>
XML;*/
			//phpinfo(); exit;
			$this->nap_sendRequest($VAR);
		
	}
    
    public function nap_sendRequest($requestXML)
	{
		//$server = 'http://www.something.com/myapp';
		
		$url = 'http://stagingapi.spiceandtea.com/ams/web_master/dashboard/nap_perform';
		/*$headers = array(
		"Content-type: text/xml"
		,"Content-length: ".strlen($requestXML)
		,"Connection: close"
		);
		
		$ch = curl_init(); 
		curl_setopt($ch, CURLOPT_URL, $server);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestXML);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$data = curl_exec($ch);

		if(curl_errno($ch)){
			print curl_error($ch);
			echo "  something went wrong..... try later";
		}else{
			echo $data;
			curl_close($ch);
		}*/
		
		//setting the curl parameters.
        $ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $requestXML );
		$result = curl_exec($ch);
		curl_close($ch);

		echo $result;
		#return $data;

	}
	
	public function nap_perform() {		
		$dataPOST = trim(file_get_contents('php://input'));		
		$xmlData = simplexml_load_string((string)$dataPOST);
		print_r($xmlData);	
	}
	

	# HTTP Post using cURL
	function do_post_request( $url, $fields, $optional_headers = null ){
		
		// http_build_query is preferred but doesn't seem to work!
		$fields_string = http_build_query($fields, '', '&', PHP_QUERY_RFC3986);
   
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $url);
		curl_setopt( $ch, CURLOPT_POST, count( $fields ) );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );
		
		$result = curl_exec( $ch );
	
		curl_close( $ch );
			
		return $result;
	}
	
	
	
	public function __destruct()
    {}
}
