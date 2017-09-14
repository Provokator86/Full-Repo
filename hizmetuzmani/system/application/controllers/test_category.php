<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose: 
* Frontend test_category Page
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Test_category extends My_Controller 
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
	
    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->data['title'] = "Rss Feed";
			$this->cls_msg=array();
			
			$this->pathtoclass=base_url().$this->router->fetch_class()."/";//for redirecting from this class
			$this->load->model('category_model','mod_cat');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    /***
    * 
    * 
    */
    public function index()
    {
        try
        {
			$this->data['heading'] 		= 	"";
			$this->data['breadcrumb']	=	array('Test Category'=>'');
			$this->data['ctrlr'] 		= 	"test_category";
			
			/**fetch job category **/
		    $this->load->model('category_model');
		    $s_where = " WHERE n.i_parent_id != 0 ";  
		    $category =  $this->mod_cat->test_category_fetch_multi($s_where);
		    /**end fetch job category **/	
			$category_parent_arr	=	array();
			if(!empty($category))
			{
				$parent_id = $category[0]["i_parent_id"];
				$i = 0;
				foreach($category as $key=>$val)
				{				
					if($parent_id == $val["i_parent_id"])	
					{
						$category_parent_arr[$val["s_parent_name"]][$i++] = array('id'=>$val["id"],'sub_category'=>$val["s_category_name"]);		
					}
					else
					{
						$i = 0;
						$parent_id = $val["i_parent_id"];
						$category_parent_arr[$val["s_parent_name"]][$i++] = array('id'=>$val["id"],'sub_category'=>$val["s_category_name"]);
					}		
				}
			}
			
			$this->data["category_parent_arr"]	= $category_parent_arr;
					
			//pr($category_parent_arr,1);
			/* for dropdown */
			$category_arr	=	array();
			if(!empty($category))
			{
				foreach($category as $key=>$val)
				{					
					$category_arr[$val["s_parent_name"]][$val["id"]] = $val["s_category_name"];				
				}
			}
			$this->data["category_arr"] = $category_arr;
			$this->render();
			unset($s_where,$start,$limit);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	 	    
    }    
  
    /****
    * Display the static contents For this controller
    * 
    */

    public function show_cms()
    {

    } 

    public function __destruct()
    {}           
}
