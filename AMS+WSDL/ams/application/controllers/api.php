<?php
/*********
* Author: SWI
* Date  : 05 July 2016
* Modified By: 
* Modified Date: 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/
require(APPPATH.'/libraries/REST_Controller.php');
 
class Api extends REST_Controller
{
	function __construct()
    {
        // Construct the parent class
        parent::__construct();
        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        echo $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
    }


    function user_get()
    {
        if(!$this->get('id'))
        {
            $this->response(NULL, 400);
        }
 
        //$user = $this->user_model->get( $this->get('id') );
         
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response(NULL, 404);
        }
    }
}
/* End of file home.php */
