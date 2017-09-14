<?php
/*********
* Author: Mrinmoy
* Date  : 02 Dec 2013
* Modified By: 
* Modified Date: 
* 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

/*define("MohammadDayyan", true);
include(BASEPATH.'application/controllers/include/DayyanRandomCharactersClass.php');*/


// Change these
define('API_KEY',      '75benbt0nxi3mg');
define('API_SECRET',   'znJj6eLYKT9SqB8X');
//define('REDIRECT_URI', 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['SCRIPT_NAME']);
define('REDIRECT_URI', 'http://www.acumencs.com/jobshoppa/new_captcha/index');
define('SCOPE',        'r_fullprofile r_emailaddress rw_nus r_contactinfo');
 

class New_captcha extends My_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    
    public function __construct()
    {
        try
        { 
          parent::__construct(); 
          $this->data['title']="Home";////Browser Title
		  $this->data['ctrlr'] = "home";
          $this->cls_msg=array();
		  $this->cls_msg["no_result"]="No information found.";
          $this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
		  
		  parse_str($_SERVER['QUERY_STRING'], $_GET);
		  		  
		 // $this->load->model('auto_mail','mod_auto');
		  
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
			
			
		
		// Congratulations! You have a valid token. Now fetch your profile 
		if(isset($_GET['code']))
		{
			if ($_SESSION['state'] == $_GET['state']) {
				// Get token so you can make API calls
				$this->getAccessToken();
			}
			$user = $this->fetch('GET', '/v1/people/~:(firstName,lastName,summary,emailAddress,phoneNumbers,educations,headline,pictureUrl,positions,id,certifications,dateOfBirth)');
		}
		
		if(isset($_GET['code']))
		{
			/*print "Hello $user->firstName $user->lastName($user->emailAddress).";
			print "<br>Id: $user->id";
			print "<br>Headline:$user->headline";
			print "<br><img src='{$user->pictureUrl}'/>";
			
			
			
			print "<br>Positions:";
			echo '<pre>';
			print_r($user->positions);
			
			print 'Educations<br>';
			print_r($user->educations);
			echo '</pre>';*/
			
			
			print "<br>All data:";
			echo '<pre>';
			print_r($user);
			exit;
		}
		
		
			if($_POST)
			{
				$captcha = $this->input->post('txt_captcha');
				
				if($_SESSION['captcha'] == $captcha)
				{
					echo 'Santi hoyechhe.. .Hulo .. .. ?';
				} else {
					echo 'Moja pabe ki kore..??';
				}
			}
			
			$this->data["txt_email"] = $user->emailAddress;
			$this->data["txt_name"] = $user->firstName;
			$this->data["txt_username"] = $user->lastName;
		       
			$this->render();
		}

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	public function connect_linkedin()
    {
	
		
       	// OAuth 2 Control Flow
		if (isset($_GET['error'])) {
			// LinkedIn returned an error
			print $_GET['error'] . ': ' . $_GET['error_description'];
			exit;
		} elseif (isset($_GET['code'])) {
			// User authorized your application
			if ($_SESSION['state'] == $_GET['state']) {
				// Get token so you can make API calls
				$this->getAccessToken();
			} else {
				// CSRF attack? Or did you mix up your states?
				exit;
			}
		} else { 
			$this->getAuthorizationCode();
			if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
				// Token has expired, clear the state
				$_SESSION = array();
			}
			if (empty($_SESSION['access_token'])) {
				// Start authorization process
				$this->getAuthorizationCode();
			}
		}
		 
    }
	
	
	function getAuthorizationCode() {
		$params = array('response_type' => 'code',
						'client_id' => API_KEY,
						'scope' => SCOPE,
						'state' => uniqid('', true), // unique long string
						'redirect_uri' => REDIRECT_URI,
				  );
	 
		// Authentication request
		$url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
		 
		// Needed to identify request when it returns to us
		$_SESSION['state'] = $params['state'];
	 
		// Redirect user to authenticate
		header("Location: $url");
		exit;
	}
		 
	function getAccessToken() {
		$params = array('grant_type' => 'authorization_code',
						'client_id' => API_KEY,
						'client_secret' => API_SECRET,
						'code' => $_GET['code'],
						'redirect_uri' => REDIRECT_URI,
				  );
		 
		// Access Token request
		$url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
		 
		// Tell streams to make a POST request
		$context = stream_context_create(
						array('http' => 
							array('method' => 'POST',
							)
						)
					);
	 
		// Retrieve access token information
		$response = file_get_contents($url, false, $context);
	 
		// Native PHP object, please
		$token = json_decode($response);
	 
		// Store access token and expiration time
		$_SESSION['access_token'] = $token->access_token; // guard this! 
		$_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
		$_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
		 
		return true;
	}
	 
	function fetch($method, $resource, $body = '') {
		$params = array('oauth2_access_token' => $_SESSION['access_token'],
						'format' => 'json',
				  );
		 
		// Need to use HTTPS
		$url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
		// Tell streams to make a (GET, POST, PUT, or DELETE) request
		$context = stream_context_create(
						array('http' => 
							array('method' => $method,
							)
						)
					);
	 
	 
		// Hocus Pocus
		$response = file_get_contents($url, false, $context);
	 
		// Native PHP object, please
		return json_decode($response);
	}
		
    public function __destruct()

    {}           

}



/* End of file welcome.php */

/* Location: ./system/application/controllers/welcome.php */

