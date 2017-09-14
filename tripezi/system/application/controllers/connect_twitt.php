<?php
class Connect_twitt extends My_Controller 
{
    public  $CONSUMER_KEY;
    public  $CONSUMER_SECRET;
    public  $OAUTH_CALLBACK;
    public function __construct()
    {
        
        try
        { 
          parent::__construct();
          /*define('CONSUMER_KEY', 'w1y06nk8P42Iny6bo5ByQ');
          define('CONSUMER_SECRET', 'Yffp8NfH26WnshGqwRQ0CUD23cURCHntHgeXEL9API');
          define('OAUTH_CALLBACK', base_url().'twitter_connect/callback'); */
          
          //FOR ACUMENCS
          /*
          $this->CONSUMER_KEY   =   'w1y06nk8P42Iny6bo5ByQ';
          $this->CONSUMER_SECRET   =   'Yffp8NfH26WnshGqwRQ0CUD23cURCHntHgeXEL9API';
          $this->OAUTH_CALLBACK   =   base_url().'connect_twitt/callback'; */
          
          //FOR TRIPEZI
          /*
          $this->CONSUMER_KEY      =   '4vedS5jR6rnaNnIXGsttRA';
          $this->CONSUMER_SECRET   =   'ykXMrveJrOzPspw8phGwL96W3g4peQegmS1BDpeiPqQ';
          $this->OAUTH_CALLBACK    =   base_url().'connect_twitt/callback';
           */
          
          $this->CONSUMER_KEY      =   $this->config->item('TWITTER_CONSUMER_KEY');
          $this->CONSUMER_SECRET   =   $this->config->item('TWITTER_CONSUMER_SECRET');
          $this->OAUTH_CALLBACK    =   base_url().'connect_twitt/callback'; 
           
           
          
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
            redirect(base_url().'connect_twitt/redirect');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
      public function redirect($screen_name='')
      {
          try
          {
              require_once(APPPATH.'controllers/'.'twitteroauth/twitteroauth.php');  
             
            
             if($screen_name)
             {
                 $this->session->set_userdata('session_screen_name',$screen_name) ;
             }
              /* Build TwitterOAuth object with client credentials. */
              $connection = new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET);
              
              /* Get temporary credentials. */
              $request_token = $connection->getRequestToken($this->OAUTH_CALLBACK);
              
              
              /* Save temporary credentials to session. */
               $token = $request_token['oauth_token'];
               $request_token['oauth_token_secret'];
              $this->session->set_userdata('oauth_token',$token) ;
              $this->session->set_userdata('oauth_token_secret',$request_token['oauth_token_secret']) ;
              
            
            
              
              
              /* If last connection failed don't display authorization link. */
                switch ($connection->http_code) {
                  case 200:
                    /* Build authorize URL and redirect user to Twitter. */
                    $url = $connection->getAuthorizeURL($token);

                    header('Location: ' . $url); 
                    break;
                  default:
                    /* Show notification if something went wrong. */
                    echo 'Could not connect to Twitter. Refresh the page or try again later.';
                }
                
              
          }
          catch(Exception $err_obj)
          {
            show_error($err_obj->getMessage());
          }
      }
      
      public function callback()
      {
          try
          {
              require_once(APPPATH.'controllers/'.'twitteroauth/twitteroauth.php');       
              /* If the oauth_token is old redirect to the connect page. */
              if (isset($_REQUEST['oauth_token']) && $this->session->userdata('oauth_token') !== $_REQUEST['oauth_token']) {
               
               $this->session->set_userdata('oauth_status','oldtoken') ;  
                redirect(base_url().'twitter_connect/'.'clear_session');
                }
                
              /* Create TwitteroAuth object with app key/secret and token key/secret from default phase */
              $connection = new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET, $this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret'));
              
              /* Request access tokens from twitter */
              $access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
              
              $this->session->set_userdata('access_token',$access_token);
              
              
              /* Remove no longer needed request tokens */
              $this->session->unset_userdata('oauth_token');
              $this->session->unset_userdata('oauth_token_secret');
              
              /* If HTTP response is 200 continue otherwise send to connect page to retry */
             if (200 == $connection->http_code) {
              /* The user has been verified and the access tokens can be saved for future use */
              $this->session->userdata('status','verified') ;
               redirect(base_url().'connect_twitt/response_twitt');
             } 
             else {
              /* Save HTTP status for error dialog on connnect page.*/
              redirect(base_url().'twitter_connect/'.'clear_session'); 
             }  
          }
          catch(Exception $err_obj)
          {
            show_error($err_obj->getMessage());
          }
      }
      
      
      public function response_twitt()
      {
          try
          {
               require_once(APPPATH.'controllers/'.'twitteroauth/twitteroauth.php'); 
               /* If the oauth_token is old redirect to the connect page. */
            if (isset($_REQUEST['oauth_token']) && $this->session->userdata('oauth_token') !== $_REQUEST['oauth_token']) {
              $this->session->set_userdata('oauth_status','oldtoken');
              redirect(base_url().'twitter_connect/'.'clear_session'); 
            }
            
            /* Get user access tokens out of the session. */
            $access_token = $this->session->userdata('access_token');
          
            if($access_token['screen_name']==$this->session->userdata('session_screen_name'))
            {
                $this->session->unset_userdata('session_screen_name');
                $this->session->set_userdata('linkedin_address_verified',1);
            }
          

            /* Create a TwitterOauth object with consumer/user tokens. */
            $connection = new TwitterOAuth($this->CONSUMER_KEY, $this->CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);

            /* If method is set change API call made. Test is called by default. */
            $content    =    $connection->get('account/verify_credentials');
             
            
            
            if($content && $this->session->userdata('linkedin_address_verified'))
            {
             ?>
            <script type="text/javascript">

            //window.opener.location.reload();
            //window.opener.location.href    =    'http://acumencs.com/tripezi/twitt/index.php?data=1';
            window.opener.twitter_address_verification_result(true);
            window.close();
            </script>
            <?php
           
            }
            else 
            {
            ?>
            <script type="text/javascript">

            //window.opener.location.reload();
            //window.opener.location.href    =    'http://acumencs.com/tripezi/twitt/index.php?data=1';
            window.opener.twitter_address_verification_result(false);
            window.close();
            </script>
                
            <?php
            }
           
          }
          catch(Exception $err_obj)
          {
            show_error($err_obj->getMessage());
          }
      }
      
      
      public function clear_session()
      {
          try
          {
              $this->session->unset_userdata('oauth_token') ;
              $this->session->unset_userdata('oauth_token_secret') ;
              $this->session->unset_userdata('access_token') ;
              redirect(base_url().'twitter_connect/redirect');
              
          }
          catch(Exception $err_obj)
          {
            show_error($err_obj->getMessage());
          }
          
      }
    
    public function __destruct()

    {} 
}