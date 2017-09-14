<?php
/*********
* Author: Koushik Rout
* Date  : 26 06 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For All tpl 
*   It a dummy controller for the project property space listing
*   it just fetch tpl file  
* 
* @link views/admin/dummy/
*/


class Dummy extends My_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    public $add_info_link ;
    public $edit_info_link ;
    

    public function __construct()
    {
            
        try
        {
          
          parent::__construct();
          $this->data['title']="Dummy";////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          /*$this->cls_msg["no_result"]="No information found about city.";
          $this->cls_msg["save_err"]="Information about city failed to save.";
          $this->cls_msg["save_succ"]="Information about city saved successfully.";
          $this->cls_msg["delete_err"]="Information about city failed to remove.";
          $this->cls_msg["delete_succ"]="Information about city removed successfully."; */
          ////////end Define Errors Here//////
          $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
          
          //////// loading default model here //////////////
         
         //$this->load->model("","");
         
          //////// end loading default model here //////////////
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    public function index($param='')
    {
        try
        {
            $this->add_info_link        =   'add/'.$param;
            $this->edit_info_link       =   'edit/'.$param.'/';
            //redirect($this->pathtoclass."show_list");
              $table_view=array();   
              $table_view["detail_view"]=false; 
            if($param=='site_setting')
            {
                 $this->data['title']    =    "Admin Site Setting";////Browser Title
                 $this->data['heading']    =    "Admin Site Setting";
                
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="edit";
                
                $this->render('dummy/site_setting');
            }  
            if($param=='my_account')
            {
                $this->data['title']="My Account";////Browser Title
                $this->data['heading']="My Account of Admin Panel";
                
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="edit";
                
                $this->render('dummy/my_account');
            }  
            if($param=='country')
            {
                
                 $this->data['heading']="Country";
               
                 $table_view["caption"]="Country";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="50%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Country Name";
                 $table_view["headers"][1]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Kolkata";
                $table_view["tablerows"][0][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Bhubaneswar";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Delhi";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/country_show_list'); 
            }
            
            if($param=='state')
            {
                
                 $this->data['heading']="State";
                
                 $table_view["caption"]="State";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="30%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="State Name";
                 $table_view["headers"][1]["val"]    ="Country Name";
                 $table_view["headers"][2]["val"]    ="Status";
                
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "West Bengal";
                $table_view["tablerows"][0][$i_col++]    = "India";
                $table_view["tablerows"][0][$i_col++]    = Active;
                
                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Gujurat";
                $table_view["tablerows"][1][$i_col++]    = "India";
                $table_view["tablerows"][1][$i_col++]    = Active;
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Andra Pradesh";
                $table_view["tablerows"][2][$i_col++]    = "India";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/state_show_list'); 
            }
             if($param=='city')
            {
                
                 $this->data['heading']="City";
              
                 $table_view["caption"]="City";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="30%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="City Name"; 
                 $table_view["headers"][1]["val"]    ="State Name";
                 $table_view["headers"][2]["val"]    ="Country Name";
                 $table_view["headers"][3]["val"]    ="Status";
                
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Kolkata";
                $table_view["tablerows"][0][$i_col++]    = "West Bengal";
                $table_view["tablerows"][0][$i_col++]    = "India";
                $table_view["tablerows"][0][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Surat";
                $table_view["tablerows"][1][$i_col++]    = "Gujurat";
                $table_view["tablerows"][1][$i_col++]    = "India";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Visakhapatnam";
                $table_view["tablerows"][2][$i_col++]    = "Andra Pradesh";
                $table_view["tablerows"][2][$i_col++]    = "India";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/city_show_list'); 
            }
            
            if($param=='currency_rate')
            {
                $this->data['action_allowed']['Delete']  =   0;
                $this->data['action_allowed']['Add']  =   0;
                $this->data['heading']="Currency";
                 
                 $table_view["caption"]="Currency";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Currency Code";
                 $table_view["headers"][1]["val"]    ="Currency Rate";
                 $table_view["headers"][2]["val"]    ="Symbol";
                 $table_view["headers"][3]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "USD";
                $table_view["tablerows"][0][$i_col++]    = "1";
                $table_view["tablerows"][0][$i_col++]    = "$";
                $table_view["tablerows"][0][$i_col++]    = "Active";    
                
                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1; 
                $table_view["tablerows"][1][$i_col++]    = "EUR";
                $table_view["tablerows"][1][$i_col++]    = "0.5";
                $table_view["tablerows"][1][$i_col++]    = "&#8364";
                $table_view["tablerows"][1][$i_col++]    = "Active";

                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;
                $table_view["tablerows"][2][$i_col++]    = "GBP";
                $table_view["tablerows"][2][$i_col++]    = "1.2";
                $table_view["tablerows"][2][$i_col++]    = "&#163";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
               /* $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }   */
                 
               
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/currency_show_list'); 
                
            }
             if($param=='cms')
            {
                 $this->data['title']    =    "Cms";////Browser Title
                 $this->data['heading']    =    "Cms";
                
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="edit";
                
                $this->render('dummy/cms');
            }
                
             if($param=='testimonial')
            {
                
                 $this->data['action_allowed']['Add']  =   0;
                 $this->data['heading']="Testimonial";
                
                 $table_view["caption"]="Testimonial";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="User Name";
                 $table_view["headers"][1]["val"]    ="Description";
                 $table_view["headers"][2]["val"]    ="Created On";
                 $table_view["headers"][3]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Jhon Miller";
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
                $table_view["tablerows"][0][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][0][$i_col++]    = "Active";    
                

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Jhon Miller";
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
                $table_view["tablerows"][1][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Jhon Miller";
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
                $table_view["tablerows"][2][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                 
               
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/testimonial_show_list'); 
                
            }
            
            if($param=='automail')
            {
                 $this->data['heading']="Automail";
                
                 $table_view["caption"]="Automail";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="75%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]      ="Subject";
                 
                 $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Registration Mail";
              

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Contact us";

                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Account Activate";
               
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);
                $this->render("dummy/automail_show_list");
                
            } 
            if($param=='autosms')
            {
                 $this->data['heading']="Auto SMS";
                
                 $table_view["caption"]="Auto SMS";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ='auto';
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]      ="Subject";
                 
                 $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Registration Sms";
              

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Contact us Sms";

                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Account Activate Sms";
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);
                $this->render("dummy/autosms_show_list");  
            }
            
            
             if($param=='press')
             {
                 $this->data['heading']="Press Release";
                
                 $table_view["caption"]="Press Release";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Title";
                 $table_view["headers"][1]["val"]    ="Description";
                 $table_view["headers"][2]["val"]    ="Created On";
                 $table_view["headers"][3]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown...";
                $table_view["tablerows"][0][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][0][$i_col++]    = "Active";    
                

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown...";
                $table_view["tablerows"][1][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown...";
                $table_view["tablerows"][2][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                 
               
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/press_show_list'); 
                
            }
            
             if($param=='blog')
             {
                 $this->data['heading']="Blog";
               
                 $table_view["caption"]="Blog";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Blog Title";

                 $table_view["headers"][1]["val"]    ="Created On";
                 $table_view["headers"][2]["val"]    ="No Of Comments";
                 $table_view["headers"][3]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][0][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][0][$i_col++]    = "3";
                $table_view["tablerows"][0][$i_col++]    = "Active";    
                

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][1][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][1][$i_col++]    = "3";
                $table_view["tablerows"][1][$i_col++]    = "Active";    
                
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][2][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][2][$i_col++]    = "3";
                $table_view["tablerows"][2][$i_col++]    = "Active";    
                
               
                $action .= '<a  href="'.admin_base_url().'dummy/index/blog_comment" ><img width="12" height="12" title="See Comments" alt="See Comments" src="images/admin/comment.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/blog_show_list'); 
                
            }
            
            if($param=='blog_comment')
             {
                 $this->data['action_allowed']['Delete']  =   0;
                 $this->data['action_allowed']['Add']  =   0;
                 $this->data['action_allowed']['Edit']  =   0;
                 
                 
                 $this->data['heading']="Blog Comments";
               
                 $table_view["caption"]="Blog Comments";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="50%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Comment";

                 $table_view["headers"][1]["val"]    ="Created On";
                 $table_view["headers"][2]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
                $table_view["tablerows"][0][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][0][$i_col++]    = "Active";    
                

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
                $table_view["tablerows"][1][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][1][$i_col++]    = "Active";    
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry.";
                $table_view["tablerows"][2][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][2][$i_col++]    = "Active";   
                
              /*  $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
               
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                } */

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/blog_comments_show_list'); 
                
            }
            
            if($param=='user')
             {
                
                 $this->data['heading']="User";
                 $this->data['action_allowed']['Delete']  =   0;
                 $this->data['action_allowed']['Add']  =   0;
                 
                 $table_view["caption"]="User";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]  ="20%";
                 $table_view["headers"][0]["align"]  ="left";
                 $table_view["headers"][0]["val"]    ="First Name";
                 $table_view["headers"][1]["val"]    ="Last Name";
                 $table_view["headers"][2]["val"]    ="Email";
                 $table_view["headers"][3]["val"]    ="Phone";
                 $table_view["headers"][4]["val"]    ="Registration Date";
                 $table_view["headers"][5]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Robert";
                $table_view["tablerows"][0][$i_col++]    = "Pattinson";
                $table_view["tablerows"][0][$i_col++]    = "robert.patt@gmail.com" ;
                $table_view["tablerows"][0][$i_col++]    = "7745874411";    
                $table_view["tablerows"][0][$i_col++]    = "22-06-2012";    
                $table_view["tablerows"][0][$i_col++]    = "Active";    
                

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK  
                $table_view["tablerows"][1][$i_col++]    = "Robert";
                $table_view["tablerows"][1][$i_col++]    = "Pattinson";
                $table_view["tablerows"][1][$i_col++]    = "robert.patt@gmail.com" ;
                $table_view["tablerows"][1][$i_col++]    = "7745874411";    
                $table_view["tablerows"][1][$i_col++]    = "22-06-2012";    
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK  
                $table_view["tablerows"][2][$i_col++]    = "Robert";
                $table_view["tablerows"][2][$i_col++]    = "Pattinson";
                $table_view["tablerows"][2][$i_col++]    = "robert.patt@gmail.com" ;
                $table_view["tablerows"][2][$i_col++]    = "7745874411";    
                $table_view["tablerows"][2][$i_col++]    = "22-06-2012";    
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Verify Phone" alt="Verify Phone" src="images/admin/cellphone.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" class="view_details"><img width="12" height="12" title="View Details" alt="View Details" src="images/admin/view.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                $this->render('dummy/user_show_list'); 
            }  
			
			
			 if($param=='property')
             {
                 $this->add_info_link        =   '';
                 $this->edit_info_link       =   '';
                 $this->data['heading']="Property";
                 
                 $this->data['action_allowed']['Delete']  =   0;
                 $this->data['action_allowed']['Add']  =   0;
                
                 $table_view["caption"]="Property";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;

                 $table_view["headers"][0]["width"]  ="30%";
                 $table_view["headers"][0]["align"]  ="left";
                 $table_view["headers"][0]["val"]    ="Proprety Information";
				 $table_view["headers"][1]["width"]  ="30%";
                 $table_view["headers"][1]["val"]    ="Owner Information";
				 $table_view["headers"][2]["width"]  ="20%";
                 $table_view["headers"][2]["val"]    ="Price";
				 $table_view["headers"][3]["width"]  ="8%";
                 $table_view["headers"][3]["val"]    ="Created on";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td width=\"35%\">Property ID</td><td>1999</td></tr>
                                                                <tr><td width=\"35%\">Property Name</td><td>Lorem Ipsum</td></tr>
																<tr><td rowspan=\"2\">Location</td><td>Bardwell,Bardwell</td></tr>
																<tr><td>Essex,236598</td></tr></table>";
																
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td width=\"35%\">Property Owner</td><td>Mario Balotelli</td></tr>
																<tr><td>Email</td><td>m.balotelli@gmail.com</td></tr>
															</table>";
      
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td width=\"60%\">Standard Price</td><td>$200</td></tr>
																<tr><td>Weekly Rate</td><td>$1000</td></tr>
																<tr><td>Monthly Rate</td><td>$10000</td></tr>
																<tr><td>Additional Guests</td><td>$100</td></tr></table>";   
                $table_view["tablerows"][0][$i_col++]    = "22-06-2012";  
                

                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "<table><tr><td width=\"35%\">Property ID</td><td>1999</td></tr>
                                                                <tr><td width=\"35%\">Property Name</td><td>Lorem Ipsum</td></tr>
                                                                <tr><td rowspan=\"2\">Location</td><td>Bardwell,Bardwell</td></tr>
                                                                <tr><td>Essex,236598</td></tr></table>";
                                                                
                $table_view["tablerows"][1][$i_col++]    = "<table><tr><td width=\"35%\">Property Owner</td><td>Mario Balotelli</td></tr>
                                                                <tr><td>Email</td><td>m.balotelli@gmail.com</td></tr>
                                                            </table>";
      
                $table_view["tablerows"][1][$i_col++]    = "<table><tr><td width=\"60%\">Standard Price</td><td>$200</td></tr>
                                                                <tr><td>Weekly Rate</td><td>$1000</td></tr>
                                                                <tr><td>Monthly Rate</td><td>$10000</td></tr>
                                                                <tr><td>Additional Guests</td><td>$100</td></tr></table>";   
                $table_view["tablerows"][1][$i_col++]    = "22-06-2012";    
                
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td width=\"35%\">Property ID</td><td>1999</td></tr>
                                                                <tr><td width=\"35%\">Property Name</td><td>Lorem Ipsum</td></tr>
                                                                <tr><td rowspan=\"2\">Location</td><td>Bardwell,Bardwell</td></tr>
                                                                <tr><td>Essex,236598</td></tr></table>";
                                                                
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td width=\"35%\">Property Owner</td><td>Mario Balotelli</td></tr>
                                                                <tr><td>Email</td><td>m.balotelli@gmail.com</td></tr>
                                                            </table>";
      
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td width=\"60%\">Standard Price</td><td>$200</td></tr>
                                                                <tr><td>Weekly Rate</td><td>$1000</td></tr>
                                                                <tr><td>Monthly Rate</td><td>$10000</td></tr>
                                                                <tr><td>Additional Guests</td><td>$100</td></tr></table>";   
                $table_view["tablerows"][2][$i_col++]    = "22-06-2012";    
                
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                $action .= '<a  href="javascript:void(0);" class="view_details"><img width="12" height="12" title="View Details" alt="View Details" src="images/admin/view.png"></a>';
               
               
              
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                    $table_view["rows_action"][3]    = $action;     
                }

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                $this->render('dummy/property_show_list'); 
            }
			
			
			 if($param=='reviews')
             {
                 
                 $this->data['action_allowed']['Add']  =   0;

                 $this->data['heading']="Reviews";
               
                 $table_view["caption"]="Reviews";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
				
                 $table_view["headers"][0]["width"]  ="30%";
                 $table_view["headers"][0]["align"]  ="left";
                 $table_view["headers"][0]["val"]    ="Proprety Name";
                 $table_view["headers"][1]["val"]    ="Comment";
                 $table_view["headers"][2]["val"]    ="Rating";
                 $table_view["headers"][3]["val"]    ="Reviewed by";
                 $table_view["headers"][4]["val"]    ="date";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum";
      
                $table_view["tablerows"][0][$i_col++]    = "3";   
                $table_view["tablerows"][0][$i_col++]    = "hughe jack";   
                $table_view["tablerows"][0][$i_col++]    = "22-06-2012";    
                

                  $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum" ;
      
                $table_view["tablerows"][1][$i_col++]    = "4";   
                $table_view["tablerows"][1][$i_col++]    = "hugh jack";   
                $table_view["tablerows"][1][$i_col++]    = "12-06-2012";  
                
                   $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum" ;
      
                $table_view["tablerows"][2][$i_col++]    = "2";   
                $table_view["tablerows"][2][$i_col++]    = "jack jell";   
                $table_view["tablerows"][2][$i_col++]    = "22-06-2012"; 
                
              
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                    $table_view["rows_action"][3]    = $action;     
                }

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                $this->render('dummy/review_show_list'); 
            }
            
             if($param=='booking')
             {
                 $this->data['action_allowed']['Delete']  =   0;
                 $this->data['action_allowed']['Add']  =   0;

                 $this->data['heading']="Booking property";
                 
                 $table_view["caption"]="User";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]  ="30%";
                 $table_view["headers"][0]["align"]  ="left";
                 $table_view["headers"][0]["val"]    ="Proprety Name";
                 $table_view["headers"][1]["val"]    ="Booking Information";
                 $table_view["headers"][2]["val"]    ="Booked On";
                 $table_view["headers"][3]["val"]    ="Amount";
                 $table_view["headers"][4]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td>Property Id</td><td>#1999</td></tr>
                                                                    <tr><td>Property Name</td><td><a href=\"javascript:void(0);\" class=\"view_details\">Lorem Ipsum</a></td></tr>
                                                                    <tr><td>Owner Name</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Billy Doctrov</a></td></tr>
                                                                    <tr><td>Email</td><td>billy.doct@ymail.com</td></tr></table>" ;
                                                                    
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td>Booked By :</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Robert Pattinson</a></td></tr>
                                                                    <tr><td>Email :</td><td>robee.patt@gmail.com</td></tr>
                                                                    <tr><td colspan=\"2\" >from 20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;
      
                $table_view["tablerows"][0][$i_col++]    = "12-06-2012";   
                $table_view["tablerows"][0][$i_col++]    = "$200";   
                $table_view["tablerows"][0][$i_col++]    = "Request Sent";    
                

                  $i_col=0;
                 $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                 $table_view["tablerows"][1][$i_col++]    = "<table><tr><td>Property Id</td><td>#1999</td></tr>
                                                                    <tr><td>Property Name</td><td><a href=\"javascript:void(0);\" class=\"view_details\">Lorem Ipsum</a></td></tr>
                                                                    <tr><td>Owner Name</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Billy Doctrov</a></td></tr>
                                                                    <tr><td>Email</td><td>billy.doct@ymail.com</td></tr></table>" ;
                                                                    
                 $table_view["tablerows"][1][$i_col++]    = "<table><tr><td>Booked By :</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Robert Pattinson</a></td></tr>
                                                                    <tr><td>Email :</td><td>robee.patt@gmail.com</td></tr>
                                                                    <tr><td colspan=\"2\" >from 20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;
      
                $table_view["tablerows"][1][$i_col++]    = "12-06-2012";   
                $table_view["tablerows"][1][$i_col++]    = "$200";   
                $table_view["tablerows"][1][$i_col++]    = "Approve by user";  
                
                   $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td>Property Id</td><td>#1999</td></tr>
                                                                    <tr><td>Property Name</td><td><a href=\"javascript:void(0);\" class=\"view_details\">Lorem Ipsum</a></td></tr>
                                                                    <tr><td>Owner Name</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Billy Doctrov</a></td></tr>
                                                                    <tr><td>Email</td><td>billy.doct@ymail.com</td></tr></table>" ;
                                                                    
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td>Booked By :</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Robert Pattinson</a></td></tr>
                                                                    <tr><td>Email :</td><td>robee.patt@gmail.com</td></tr>
                                                                    <tr><td colspan=\"2\" >from 20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;
      
                $table_view["tablerows"][2][$i_col++]    = "22-06-2012";   
                $table_view["tablerows"][2][$i_col++]    = "$200";   
                $table_view["tablerows"][2][$i_col++]    = "Amount paid"; 
                
                
                $i_col=0;
                $table_view["tablerows"][3][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][3][$i_col++]    = "<table><tr><td>Property Id</td><td>#1999</td></tr>
                                                                    <tr><td>Property Name</td><td><a href=\"javascript:void(0);\" class=\"view_details\">Lorem Ipsum</a></td></tr>
                                                                    <tr><td>Owner Name</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Billy Doctrov</a></td></tr>
                                                                    <tr><td>Email</td><td>billy.doct@ymail.com</td></tr></table>" ;
                                                                    
                 $table_view["tablerows"][3][$i_col++]    = "<table><tr><td>Booked By :</td><td><a href=\"javascript:void(0);\" class=\"view_user\">Robert Pattinson</a></td></tr>
                                                                    <tr><td>Email :</td><td>robee.patt@gmail.com</td></tr>
                                                                    <tr><td colspan=\"2\" >from 20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;
      
                $table_view["tablerows"][3][$i_col++]    = "12-06-2012";   
                $table_view["tablerows"][3][$i_col++]    = "$200";   
                $table_view["tablerows"][3][$i_col++]    = "Cancelled"; 
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
              
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                    $table_view["rows_action"][3]    = $action;     
                }

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                $this->render('dummy/booking_show_list'); 
            }
            
            if($param=='meta_tags')
            {
                 $this->data['heading']="";
               
                 $table_view["caption"]="Meta Tag Setting";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]      ="Meta Tag";
                 $table_view["headers"][1]["val"]      ="Description";
                 
                 $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "about us";
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popu";
              

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Contact us";
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popu";

                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);
                $this->render("dummy/meta_tags_show_list");  
            }
            
             if($param=='newsletter')
             {
                 $this->data['heading']="Newsletter";
                 
                 $table_view["caption"]="Newsletter";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Subject";
                 $table_view["headers"][1]["val"]    ="Content";
                 $table_view["headers"][2]["val"]    ="Created On";

                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown...";
                $table_view["tablerows"][0][$i_col++]    = "26-06-2012";

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown...";
                $table_view["tablerows"][1][$i_col++]    = "26-06-2012";
 
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum";
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown...";
                $table_view["tablerows"][2][$i_col++]    = "26-06-2012";
				
				$action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Broadcast" alt="Broadcast" src="images/admin/broadcast.png"></a>&nbsp;';
               
              
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                    $table_view["rows_action"][3]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/newsletter_show_list'); 
                
            }
            
            if($param=='subscribers')
             {
                 $this->data['action_allowed']['Delete']  =   0;
                 $this->data['action_allowed']['Add']  =   0;
                 
                 $this->data['heading']="Newsletter Subscriber";
                
                 $table_view["caption"]="Newsletter Subscriber";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="User Name";
                 $table_view["headers"][1]["val"]    ="Email";
                 $table_view["headers"][2]["val"]    ="Subscribed On";
                 $table_view["headers"][3]["val"]    ="Status";
       
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Johan Botha";
                $table_view["tablerows"][0][$i_col++]    = "johan.b@gmail.com";
                $table_view["tablerows"][0][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][0][$i_col++]    = "Subscribed";

                  $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Johan Botha";
                $table_view["tablerows"][1][$i_col++]    = "johan.b@gmail.com";
                $table_view["tablerows"][1][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][1][$i_col++]    = "Unsubscribed";
 
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Johan Botha";
                $table_view["tablerows"][2][$i_col++]    = "johan.b@gmail.com";
                $table_view["tablerows"][2][$i_col++]    = "26-06-2012";
                $table_view["tablerows"][2][$i_col++]    = "Subscribed";

                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Subscribe" alt="Subscribe" src="images/admin/subscribe.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Unsubscribe" alt="Unsubscribe" src="images/admin/unsubscribe.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/subscribers_show_list'); 
                
            }
            

            if($param=='payment_report')
             {
                 $this->data['action_allowed']['Delete']  =   0;
                 $this->data['action_allowed']['Add']  =   0;
                 $this->data['action_allowed']['Edit']  =   0;
                 
                 
                
                 $this->data['heading']="Payment Report";
                
                 $table_view["caption"]="Payment Report";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["detail_view"]=false;
                 $table_view["headers"][0]["width"]  ="40%";
                 $table_view["headers"][0]["align"]  ="left";
                 $table_view["headers"][0]["val"]    ="Proprety Information";
                 $table_view["headers"][1]["width"]  ="40%";  
                 $table_view["headers"][1]["val"]    ="Booking Information";
                 $table_view["headers"][2]["val"]    ="Payment Amount";
                 $table_view["headers"][3]["val"]    ="Payment Date";
                 
                
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td>Property Name</td><td>Lorem Ipsum(#1999)</td></tr>
                                                                    <tr><td>Property Owner</td><td>Ajar Rehman</td></tr>
                                                                    <tr><td rowspan=3>Location</td><td>221B Baker Street</td></tr>
                                                                    <tr><td>Los Angeles</td></tr>
                                                                    <tr><td>USA</td></tr></table>" ;
                
                $table_view["tablerows"][0][$i_col++]    = "<table><tr><td>Booked By</td><td>Robert Pattinson</td></tr>
                                                                    <tr><td>Booked On</td><td>12-06-2012</td></tr>
                                                                    <tr><td colspan=\"2\" >20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;  
                $table_view["tablerows"][0][$i_col++]    = "$200";   
                $table_view["tablerows"][0][$i_col++]    = "19-06-2012";   
                 
                

                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "<table><tr><td>Property Name</td><td>Lorem Ipsum(#1999)</td></tr>
                                                                    <tr><td>Property Owner</td><td>Ajar Rehman</td></tr>
                                                                    <tr><td rowspan=3>Location</td><td>221B Baker Street</td></tr>
                                                                    <tr><td>Los Angeles</td></tr>
                                                                    <tr><td>USA</td></tr></table>" ;
                
                $table_view["tablerows"][1][$i_col++]    = "<table><tr><td>Booked By</td><td>Robert Pattinson</td></tr>
                                                                    <tr><td>Booked On</td><td>12-06-2012</td></tr>
                                                                    <tr><td colspan=\"2\" >20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;  
                $table_view["tablerows"][1][$i_col++]    = "$200";   
                $table_view["tablerows"][1][$i_col++]    = "19-06-2012";      

                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td>Property Name</td><td>Lorem Ipsum(#1999)</td></tr>
                                                                    <tr><td>Property Owner</td><td>Ajar Rehman</td></tr>
                                                                    <tr><td rowspan=3>Location</td><td>221B Baker Street</td></tr>
                                                                    <tr><td>Los Angeles</td></tr>
                                                                    <tr><td>USA</td></tr></table>" ;
                
                $table_view["tablerows"][2][$i_col++]    = "<table><tr><td>Booked By</td><td>Robert Pattinson</td></tr>
                                                                    <tr><td>Booked On</td><td>12-06-2012</td></tr>
                                                                    <tr><td colspan=\"2\" >20-06-2012 to 25-06-2012</td></tr>
                                                                    <tr><td>Guests</td><td>2</td></tr></table>" ;  
                $table_view["tablerows"][2][$i_col++]    = "$200";   
                $table_view["tablerows"][2][$i_col++]    = "19-06-2012";   
                

                $this->data["table_view"]=$this->admin_showin_order_table($table_view);  
                
                $this->render('dummy/property_payment_show_list'); 
            }
            
            
            if($param=='amenity')
            {
                
                 $this->data['heading']="Amenity";
               
                 $table_view["caption"]="Amenity";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="50%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Amenities";
                 $table_view["headers"][1]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "TV";
                $table_view["tablerows"][0][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Wireless Internet";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Ac";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/amenity_show_list'); 
            } 
             
            if($param=='property_type')
            {
                
                 $this->data['heading']="Property Type";
               
                 $table_view["caption"]="Property Type";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="50%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Property Type";
                 $table_view["headers"][1]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "house";
                $table_view["tablerows"][0][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "house";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "house";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/property_type_show_list'); 
            }
            
            if($param=='bed_type')
            {
                
                 $this->data['heading']="Bed Type";
               
                 $table_view["caption"]="Bed Type";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="50%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Bed Type";
                 $table_view["headers"][1]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "Floor";
                $table_view["tablerows"][0][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "Floor";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                 $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "Floor";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/bed_type_show_list'); 
            }
           
                
            if($param=='cacellation_policy')
            {
                
                 $this->data['heading']="Cacellation Policy";
               
                 $table_view["caption"]="Cacellation Policy";
                 $table_view["total_rows"]=5;
                 $table_view["total_db_records"]=5;
                 $table_view["headers"][0]["width"]    ="20%";
                 $table_view["headers"][0]["align"]    ="left";
                 $table_view["headers"][0]["val"]    ="Cacellation Policy Name";
                 $table_view["headers"][1]["val"]    ="Cancellation Charge(%)";
                 $table_view["headers"][2]["val"]    ="Description";
                 $table_view["headers"][3]["val"]    ="Status";
                 
                 
                $i_col=0;
                $table_view["tablerows"][0][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][0][$i_col++]    = "strict";
                $table_view["tablerows"][0][$i_col++]    = "10.5";
                $table_view["tablerows"][0][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";
                $table_view["tablerows"][0][$i_col++]    = "Active";
                
                $i_col=0;
                $table_view["tablerows"][1][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][1][$i_col++]    = "strict";
                $table_view["tablerows"][1][$i_col++]    = "10.5";
                $table_view["tablerows"][1][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";
                $table_view["tablerows"][1][$i_col++]    = "Active";
                
                $i_col=0;
                $table_view["tablerows"][2][$i_col++]    = 1;////Index 0 must be the encrypted PK 
                $table_view["tablerows"][2][$i_col++]    = "strict";
                $table_view["tablerows"][2][$i_col++]    = "10.5";
                $table_view["tablerows"][2][$i_col++]    = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.";
                $table_view["tablerows"][2][$i_col++]    = "Active";
                
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Inactive" alt="Inactive" src="images/admin/inactive.png"></a>&nbsp;';
                $action .= '<a  href="javascript:void(0);" ><img width="12" height="12" title="Active" alt="Active" src="images/admin/active.png"></a>';
                if($action!='')
                {
                    $table_view["rows_action"][0]    = $action;     
                    $table_view["rows_action"][1]    = $action;     
                    $table_view["rows_action"][2]    = $action;     
                }
                
                $this->data["table_view"]=$this->admin_showin_order_table($table_view);   
                
                $this->render('dummy/cancellation_policy_show_list'); 
            }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
       
    public function add($param='')
    {
        try
        {
            
            if($param=='country')
            {
                $this->data['title']="Country";////Browser Title
                $this->data['heading']="Country";
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="add";
                
                $this->render("dummy/country_add_edit"); 
            }
            if($param=='state')
            {
                $this->data['title']="State";////Browser Title
                $this->data['heading']="State";
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="add";
                
                $this->render("dummy/state_add_edit"); 
            }
             if($param=='city')
                {
                $this->data['title']="City";////Browser Title
                $this->data['heading']="City";
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="add";
                $this->render("dummy/city_add_edit"); 
                }
              if($param=='currency_rate')
                {
                    $this->data['title']="Currency Rate";////Browser Title
                    $this->data['heading']="Currency Rate";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/currency_add_edit") ;
                }
            if($param=='testimonial')
            {
                    $this->data['title']="Testimonial";////Browser Title
                    $this->data['heading']="Testimonial";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/testimonial_add_edit") ;
            }
            if($param=='automail')
            {
                    $this->data['title']="Automail";////Browser Title
                    $this->data['heading']="Automail";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/automail_add_edit") ;
            }
            if($param=='autosms')
            {
                    $this->data['title']="Autosms";////Browser Title
                    $this->data['heading']="Autosms";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/autosms_add_edit") ;
            }
            if($param=='press')
            {
                    $this->data['title']="Press Release";////Browser Title
                    $this->data['heading']="Press Release";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/press_add_edit") ;
            }
          if($param=='blog')
            {
                    $this->data['title']="Blog";////Browser Title
                    $this->data['heading']="Blog";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/blog_add_edit") ;
            }
            if($param=='user')
                {
                        $this->data['title']="User";////Browser Title
                        $this->data['heading']="User";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="add";
                        $this->render("dummy/user_add_edit") ;
                }
              if($param=='meta_tags')
                {
                        $this->data['title']="Meta Tags Setting";////Browser Title
                        $this->data['heading']="Meta Tags Setting";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="add";
                        $this->render("dummy/meta_tags_add_edit") ;
                }
               if($param=='newsletter')
                {
                    $this->data['title']="Newsletter";////Browser Title
                    $this->data['heading']="Newsletter";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/newsletter_add_edit") ;
                }
                if($param=='subscribers')
                {
                    $this->data['title']="Newsletter Subscriber";////Browser Title
                    $this->data['heading']="Newsletter Subscriber";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    $this->render("dummy/subscribers_add_edit") ;
                }
                  
                if($param=='amenity')
                {
                    $this->data['title']="Amenity";////Browser Title
                    $this->data['heading']="Amenity";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    
                    $this->render("dummy/amenity_add_edit"); 
                }
                if($param=='property_type')
                {
                    $this->data['title']="Property Type";////Browser Title
                    $this->data['heading']="Property Type";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    
                    $this->render("dummy/property_type_add_edit"); 
                }
                if($param=='bed_type')
                {
                    $this->data['title']="Bed Type";////Browser Title
                    $this->data['heading']="Bed Type";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    
                    $this->render("dummy/bed_type_add_edit"); 
                }
                if($param=='cacellation_policy')
                {
                    $this->data['title']="Cacellation Policy";////Browser Title
                    $this->data['heading']="Cacellation Policy";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="add";
                    
                    $this->render("dummy/cancellation_policy_add_edit"); 
                }
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function edit($param='',$row='')
    {
        try
        {

                if($param=='country')
                {
                $this->data['title']="Country";////Browser Title
                $this->data['heading']="Country";
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="edit";
                
                $this->render("dummy/country_add_edit"); 
                }
                if($param=='state')
                {
                $this->data['title']="State";////Browser Title
                $this->data['heading']="State";
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="edit";
                
                $this->render("dummy/state_add_edit"); 
                }
                if($param=='city')
                {
                $this->data['title']="City";////Browser Title
                $this->data['heading']="City";
                $this->data['pathtoclass']=$this->pathtoclass;
                $this->data['mode']="edit";
                
                $this->render("dummy/city_add_edit"); 
                }
                if($param=='currency_rate')
                {
                     $this->data['title']="Currency Rate";////Browser Title
                    $this->data['heading']="Currency Rate";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    
                    $this->render("dummy/currency_add_edit") ;
                }
                if($param=='testimonial')
                {
                        $this->data['title']="Testimonial";////Browser Title
                        $this->data['heading']="Testimonial";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/testimonial_add_edit") ;
                }
                 if($param=='automail')
                {
                        $this->data['title']="Automail";////Browser Title
                        $this->data['heading']="Automail";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/automail_add_edit") ;
                }
                if($param=='autosms')
                {
                        $this->data['title']="Autosms";////Browser Title
                        $this->data['heading']="Autosms";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/autosms_add_edit") ;
                }
                if($param=='press')
                {
                        $this->data['title']="Press Release";////Browser Title
                        $this->data['heading']="Press Release";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/press_add_edit") ;
                }
                if($param=='blog')
                {
                        $this->data['title']="Blog";////Browser Title
                        $this->data['heading']="Blog";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/blog_add_edit") ;
                }
                if($param=='user')
                {
                        $this->data['title']="User";////Browser Title
                        $this->data['heading']="User";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/user_add_edit") ;
                }
                if($param=='meta_tags')
                {
                        $this->data['title']="Meta Tags Setting";////Browser Title
                        $this->data['heading']="Meta Tags Setting";
                        $this->data['pathtoclass']=$this->pathtoclass;
                        $this->data['mode']="edit";
                        $this->render("dummy/meta_tags_add_edit") ;
                }
                if($param=='newsletter')
                {
                    $this->data['title']="Newsletter";////Browser Title
                    $this->data['heading']="Newsletter";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    $this->render("dummy/newsletter_add_edit") ;
                }
                 if($param=='subscribers')
                {
                    $this->data['title']="Newsletter Subscriber";////Browser Title
                    $this->data['heading']="Newsletter Subscriber";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    $this->render("dummy/subscribers_add_edit") ;
                }
				if($param=='reviews')
                {
                    $this->data['title']="Edit Review";////Browser Title
                    $this->data['heading']="Edit review";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    $this->render("dummy/review_add_edit") ;
                }
                if($param=='amenity')
                {
                    $this->data['title']="Amenity";////Browser Title
                    $this->data['heading']="Amenity";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    
                    $this->render("dummy/amenity_add_edit"); 
                }
                if($param=='property_type')
                {
                    $this->data['title']="Property Type";////Browser Title
                    $this->data['heading']="Property Type";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    
                    $this->render("dummy/property_type_add_edit"); 
                }
                if($param=='bed_type')
                {
                    $this->data['title']="Bed Type";////Browser Title
                    $this->data['heading']="Bed Type";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    
                    $this->render("dummy/bed_type_add_edit"); 
                }
                
                if($param=='cacellation_policy')
                {
                    $this->data['title']="Cacellation Policy";////Browser Title
                    $this->data['heading']="Cacellation Policy";
                    $this->data['pathtoclass']=$this->pathtoclass;
                    $this->data['mode']="edit";
                    
                    $this->render("dummy/cancellation_policy_add_edit"); 
                }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function property_details()
    {
        try
        {
            //$this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_js("images/slide/jquery.ad-gallery.js");///include main css
            //$this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
           
            $this->render("dummy/property_details",TRUE);
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
     public function user_details()
    {
        try
        {
            //$this->add_css("css/admin/style.css");///include main css
            $this->add_js("js/jquery/jquery-1.4.2.js");///include main css
            $this->add_js("images/slide/jquery.ad-gallery.js");///include main css
            //$this->add_css("js/jquery/themes/ui-darkness/ui.all.css");///include jquery css
           
            $this->render("dummy/user_details",TRUE);
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function show_list()
    {
    }
    
    public function add_information()           
    {
    }
    
    public function modify_information($i_id=0)
    {
    }
     
    public function remove_information($i_id=0)
    {
    }
    
    public function show_detail($i_id=0)
    {
    }
    
    public function __destruct()
    {}
}