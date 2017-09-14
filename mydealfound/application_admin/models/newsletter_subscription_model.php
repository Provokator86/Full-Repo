<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of location_model
 *
 * @author user
 */
class Newsletter_subscription_model extends MY_Model {
    //put your code here
    
    public $table_name;
    public function __construct() {
        parent::__construct();
        $this->table_name = 'cd_newsletter_subscription';
    }
    

    /**
     * get the list of all data in table 
     */
   
}

?>
