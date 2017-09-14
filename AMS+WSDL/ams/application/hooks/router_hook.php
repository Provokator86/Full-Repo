<?php
class Router_Hook
{
    protected $tablename, $tableregion, $tablefranchise;
    
    public function __construct()
    {
        include(APPPATH.'config/database'.EXT);
        $this->tablename= $db[$active_group]['CMS'];
        $this->tableregion= $db[$active_group]['REGION'];
        $this->tablefranchise= $db[$active_group]['FRANCHISE'];
    }
  /**
   * Loads routes from database.
   *
   * @access public
   * @params array : hostname, username, password, database, db_prefix
   * @return void
   */
  function dynamic_route($params) {
        global $cms_dyn_route;  // This is initialized in the main index.php. It will be used in
        $request_uri = $_SERVER['REQUEST_URI'];
        $request_uri_arr = explode('/',$request_uri);
        if(in_array('web_master',$request_uri_arr))
        {
            //do nothing for web_master
        }
        else
        {
            //echo 'here==>'.$_SERVER['REQUEST_URI'] ; exit;            
            /*$path_parts = explode('/', $request_uri);
            if($_SERVER['SERVER_NAME']!='murphyword.com')
            $desired_output = $path_parts[2]; 
            else
            $desired_output = $path_parts[1];             
            $str = $desired_output;*/
            $str = substr(strrchr($request_uri, '/'), 1);
            if($str) // found url last string
            {
                //echo $this->uri->segment(3);
                //echo '<pre>'; print_r($params);
                // let's do something here
                mysql_connect($params['server'],$params['user'],$params['password']);
                mysql_select_db($params['database']);       
                $res = mysql_query("SELECT * FROM {$this->tableregion} WHERE s_region_url ='".addslashes($str)."'");
                if($row = mysql_fetch_object($res))
                {
                    #echo '<pre>';print_r($row); exit;
                    $_SERVER['REQUEST_URI'] = '/corporate_information/regions/'.$str;
                }
                else
                {  
                    //echo '<pre>';print_r($_SERVER);
                    $ses_url = "http://".$_SERVER['SERVER_NAME']."/".$str;
                    $ses_url2 = 'http://www.murphybusiness.com/'.$str;
                   //$res2= mysql_query("SELECT * FROM {$this->tablefranchise} WHERE s_franchise_url ='".addslashes($str)."'");
                   $res2= mysql_query("SELECT * FROM {$this->tablefranchise} WHERE (s_franchise_url ='".addslashes($str)."' OR s_franchise_url= '".addslashes($ses_url)."' OR s_franchise_url= '".addslashes($ses_url2)."') ");
                   /*echo "SELECT * FROM {$this->tablefranchise} WHERE (s_franchise_url ='".addslashes($str)."' OR n.s_franchise_url= '".addslashes($ses_url)."' OR n.s_franchise_url= '".addslashes($ses_url2)."') ";*/
                   if($row2 = mysql_fetch_object($res2))                                
                   {
                        //echo '<pre>';print_r($row); exit;
                        $_SERVER['REQUEST_URI'] = '/corporate_information/franchisees/'.$str;
                   }
                   else
                   {
                       
                       $str = substr(strrchr($request_uri, '/'), 1);
                        //$res3 = mysql_query("SELECT * FROM {$this->tablename} WHERE s_url ='".addslashes($str)."'");  
                        $res3 = mysql_query("SELECT * FROM {$this->tablename} WHERE s_url ='".addslashes($str)."' AND i_id NOT IN (2,6,7,19,21,45,46) ");  
                        if($row3 = mysql_fetch_object($res3))
                        {
                            #echo '<pre>';print_r($row); exit;
                            //$_SERVER['ORIG_PATH_INFO'] = '/corporate-information/'.$str;
                            //$_SERVER['REQUEST_URI'] = '/corporate-information/'.$str;
                            $_SERVER['REQUEST_URI'] = '/cms/'.$str;
                        }  
                   }
                }
                mysql_free_result($res);
            }
        }
        
  }
}
