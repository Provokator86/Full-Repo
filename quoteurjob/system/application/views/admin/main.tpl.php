<?php
/*
* Modified By: Mrinmoy MOndal
* Modified date: 12 Sep 2011
*
* Purpose: Main template

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<base href="<?php echo base_url(); ?>" />

<title>QUOTE YOUR JOB Admin Panel :: <?php echo $title;?></title>

<link href="css/admin/style.css" rel="stylesheet" type="text/css" media="screen" />

<link rel="stylesheet" media="all" type="text/css" href="css/admin/menu.css" />



<? /////////Jquery////// ?>

<script language="javascript" type="text/javascript" src="js/jquery/jquery-1.4.2.js"></script>

<?php /*<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/redmond/jquery.ui.all.css" />*/?>

<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/smoothness/ui.all.css" />

<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/jquery.ui.tooltip.css" />



<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.core.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.tooltip.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.blockUI.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.dialog.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>



<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/prettyPhoto/prettyPhoto.css" />

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.prettyPhoto.js"></script>
<script language="javascript" type="text/javascript" src="js/json2.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery/ui/alphanumeric/jquery.alphanumeric.pack.js"></script>
<? /////////end Jquery////// ?>





<!--<script type="text/javascript" src="js/admin/tab.js"></script>-->

<script type="text/javascript" language="javascript" >
var base_url = '<?php echo base_url()?>';
jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {
$(document).ready(function(){
        $('#right_panel').css({width:'96.0%'});
		$('#show_hide').toggle(
		    function()
		    {
			    $('#left_panel').stop(true, true).hide(1000);

			    //$('#right_panel').css({width:'96.8%'});

			    $('#right_panel').stop(true, true).animate({width:'96.0%'},
                                          {
                                            duration: 2000, 
                                            specialEasing: {
                                            width: 'linear',
                                            height: 'easeOutBounce'
                                            }
                                          });
                $('#show_hide a img').attr('src','images/admin/show.gif').stop(true, true).show("slow");
		    },
		    function()
		    {
			    //$('#right_panel').css({width:'81.8%'});
                $('#right_panel').stop(true, true).animate({width:'81.7%'},
                                          {
                                            duration: 1000, 
                                            specialEasing: {
                                            width: 'linear',
                                            height: 'easeInBounce'
                                            }
                                          });            
			    $('#left_panel').stop(true, true).show(3000);
			    $('#show_hide a img').attr('src','images/admin/hide.gif').stop(true, true).show("slow");
		    }
		);
        /////////Page Transaction Animation////////
        $("#content").fadeIn(3000);
        /////////end Page Transaction Animation////////   

        //////When ajax starts Blocks the Page///////

        //$(document).ajaxStart($.blockUI({ message: 'Just a moment please...' }));

        //////When ajax stops Unblocks the Page///////
        $(document).ajaxStop($.unblockUI);      
        $.unblockUI();////unblock any opened blocking 
        /////Css for .info_massage added here////          
         var css_blockUI={
             "margin":"10px 0",
             "padding":"10px 10px 10px 50px",
             "background":"#d1e4f3 url(<?php echo base_url();?>images/admin/icon-info.png) no-repeat left",
             "border":"1px solid #4d8fcb",
             "font":"normal 12px Arial, Helvetica, sans-serif",
             "color":"#565656",
             "clear":"both",
             "width":'30%',
             "top":'40%',
             "left":'35%',
             "textAlign":'left',             
             "cursor":'wait'
         };
         //$.blockUI.defaults.themedCSS=css_blockUI;
         $.blockUI.defaults.css=css_blockUI;       
        <?php /*?> $.growlUI("","Landing <?php echo $title;?>...",3000);    <?php */?>
         //$.blockUI();

        ////////////end Customizing the BlockUI//////////

            

        /*////////useful sample JQ////

        $.growlUI("","This is cool");///For flashing Messages

        $.blockUI({ message: 'Just a moment please...' });

        $.unblockUI();

        ////////////Customizing the BlockUI//////////

        ///////////For Themed CSS//////

        $.blockUI.defaults.theme=true;

        $.blockUI.defaults.title='<img src="<?php echo base_url();?>images/admin/icon-info.png" style="float:left;witdth:26px;height:26px;">Information';

        $.blockUI.defaults.onBlock = function(){

                if($.blockUI.defaults.theme)

                {

                    //$(".blockTitle").hide();//for themed blocking 

                    $(".ui-dialog-content").html('<div class="info_massage">'+$(".ui-dialog-content").html()+'</div>');

                    //.show();                  

                }

                else

                {

                    //$(".blockMsg").addClass('info_massage');

                    //$(".blockMsg").html('<div class="info_massage">'+$(".blockMsg").html()+'</div>')

                    $(".blockMsg").attr("class","info_massage "+$(".blockMsg").attr("class"));

                }

                //$(".ui-dialog-content").html('<div class="info_massage">'+$(".ui-dialog-content").html()+'</div>')

            };   

          //////////end For Themed CSS///////        

        

        

        ////////Confirm dialog///// 

        $("#dialog-confirm #dialog_msg").html('<strong>These items will be permanently removed and cannot be recovered.</strong> Are you sure?');

       $("#dialog-confirm").dialog({

            resizable: false,

            height:240,

            width:350,

            modal: true,

            title: "Removal Confirmation?",

            buttons: {

                'Delete': function() {

                    $(this).dialog('close');

                    $("#frm_list").attr("action",g_controller+'remove_information/');

                    $("#frm_list").submit();

                },

                Cancel: function() {

                    $(this).dialog('close');

                }

            }

        });

       ////////end Confirm dialog/////      

       $("#tipId").tooltip({"content":function(){return "You cannot change the value.";}});  

        /////////end useful sample JQ///*/
        ///////////PrettyPhoto Configuration for popup windows//////
        $("a[rel^='prettyPhoto']").prettyPhoto({
            animation_speed: 'fast',
            show_title: true,
            allow_resize: true,
            default_width: 500,
            default_height: 344,
            theme: 'facebook', /* light_rounded / dark_rounded / light_square / dark_square / facebook */
            keyboard_shortcuts: false/* Set to false if you open forms inside prettyPhoto */
        });

        ///////////end PrettyPhoto Configuration for popup windows//////

        /*********

        * ex- $.prettyPhoto.open('images/fullscreen/image.jpg','Title','Description');

        */

       /**********Menu and shortcut Related,loggedin My_account selecting menus Jquery*************/
       $("ul[class='select'] a,ul[class='link'] a,ul[id='login_info'] a").each(function(i){
           //alert(i+" "+$(this).attr("id"));
          ///clicked in the menu or sub menu////////
          $(this).click(function(e){
              var menu= $(this).attr("id").split("_");   
              var s_loc=$(this).attr("href");   
              /////Ajax call for storing the menu id into session////
              $.post("<?php echo admin_base_url().'home/ajax_menu_track'?>",
                    {"h_menu":"mnu_"+menu[1]},
                    function(data)
                    {
                        if(data && s_loc)
                        {
                            $.blockUI({ message: 'Just a moment please...' });
                            window.location.href=s_loc;
                        }
                        //alert(data,s_loc);
                    }
                    );
              /////end Ajax call for storing the menu id into session////
              return false;
          }); 
          
          /////selectin the menu clicked last///
          if($(this).attr("id")=="<?php echo $h_menu;?>")
          {
              $(this).attr("class","active");
          }
          else
          {
              $(this).attr("class","");
          }
       });
       /**********end Menu Related Jquery*************/  
       
       /***********Access Controls for the Shortcut Menus*********/
       $("#left_panel .link li").each(function(i){
           var controller= $(this).find("a").attr("controller");
           var controllers_access=JSON.parse('<?php echo makeArrayJs($controllers_access);?>');
           //console.log(controllers_access);
           
           /**
           * If any controller doesnot exists 
           * OR 
           * No add,edit or delete is set
           */
           if(!controllers_access[controller]
                || (
                    controllers_access[controller]['action_add']==0 
                    && controllers_access[controller]['action_edit']==0 
                    && controllers_access[controller]['action_delete']==0 
                    )
             )
           {
               $(this).remove();
           }
           
       });
       /***********end Access Controls for the Shortcut Menus*********/        
})});   

</script>



</head>

<body>

<?php

///common Dialog Box///

?>

<div id="dialog-confirm" style="display: none;">

    <p><span id="alert_icon" class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>

      <strong id="dialog_msg"></strong>      

    </p>

</div>

<?php

///end common Dialog Box///

?>

<div id="header">

  <div id="logo"><img src="images/admin/logo.png" alt="###SITE_NAME_UC###" title="###SITE_NAME_UC###" /></div>
  <div id="toplink">

  <?php
    if(!empty($admin_loggedin))
    {
        $s_str='<ul>';
        $s_str.='<li><strong>'.$admin_loggedin["user_fullname"].'</strong></li>';
        $s_str.='<li>|</li>';
        $s_str.='<li><a id="mnu_0"  href="'.admin_base_url().'my_account/">My Account</a></li>';
        $s_str.='<li>|</li>';
		$s_str.='<li><a id="mnu_0" target="_blank"  href="'.base_url().'language/language_home">Language</a></li>';
        $s_str.='<li>|</li>';        
		$s_str.='<li><a href="'.admin_base_url().'home/logout">Logout</a></li>';
        $s_str.='</ul>';
        echo $s_str;
        unset($s_str);
    }
  ?>

  </div>

  <div class="clr"></div>

</div>

<div class="clr"></div>

<div id="navigation">

  <div id="pro_linedrop">
	<?php
	//////////generating the menus/////////
		create_menus($controllers_access);   
	//////////end generating the menus/////////    
	?>   
  

<!--    <ul class="select">

      <li  class="line"><a id="mnu_0" href="javascript:void(0);" class="active"><b>Home</b></a>
        <ul class="sub">			
          	<li><a id="mnu_0_0" href="<?php echo admin_base_url().'dashboard/';?>">Dashboard</a></li>
          	<li><a id= "mnu_0_1" href="<?php echo admin_base_url().'site_setting/';?>">Admin Site Setting</a></li>
			<li><a id= "mnu_0_2" href="<?php echo admin_base_url().'category/';?>">Category</a></li>
        </ul>
      </li>

      <li class="line"><a id="mnu_1" href="javascript:void(0);"><b>CMS</b></a>
        <ul class="sub">			
			<li><a id="mnu_1_0" href="<?=admin_base_url()?>content/">Content</a></li>
			<li><a id="mnu_1_1" href="<?=admin_base_url()?>content_article/">Content Article</a></li>
			<li><a id="mnu_1_2" href="<?=admin_base_url()?>faq/">Faq </a>
				<?php /*?><ul class="sub2">
					<li><a id="mnu_1_2_0" href="<?=admin_base_url()?>faq/">Buyers </a></li>
					<li><a id="mnu_1_2_1" href="<?=admin_base_url()?>faq/">Tradesman </a></li>
				</ul><?php */?>
			</li>				
			<li><a id="mnu_1_3" href="<?=admin_base_url()?>testimonial/">Testimonials </a></li>	
			<li><a id="mnu_1_4" href="<?=admin_base_url()?>news/">News </a></li>	
			<li><a id="mnu_1_5" href="<?=admin_base_url()?>auto_alert/">Auto Alert </a></li>
        </ul>
	 </li>
	 
	  <li  class="line"><a id="mnu_2" href="javascript:void(0);" class="active"><b>Mail</b></a>
        <ul class="sub">
			 <li><a id="mnu_2_0" href="<?=admin_base_url()?>auto_mail/">Automail</a></li>
			 <li><a id="mnu_2_1" href="<?=admin_base_url()?>newsletter">Newsletter</a></li>
			 <li><a id="mnu_2_2" href="<?=admin_base_url()?>newsletter_subscribers">Newsletter Subscribers</a></li>
        </ul>
      </li>
	  
	  <li  class="line"><a id="mnu_3" href="javascript:void(0);" class="active"><b>Gallery</b></a>
        <ul class="sub">
           <li><a id="mnu_3_0" href="<?=admin_base_url()?>homepage_images">Homepage Images</a></li>       
        </ul>
      </li>	
	   
	   <li  class="line"><a id="mnu_4" href="javascript:void(0);" class="active"><b>State Manage</b></a>
        <ul class="sub">
           <li><a id="mnu_4_0" href="<?=admin_base_url()?>state">State</a></li> 
		   <li><a id="mnu_4_1" href="<?=admin_base_url()?>city">City</a></li> 
		   <li><a id="mnu_4_1" href="<?=admin_base_url()?>zipcode">Zipcode</a></li>     
        </ul>
      </li>	 
	  
	  <li  class="line"><a id="mnu_5" href="javascript:void(0);" class="active"><b>Language</b></a>
        <ul class="sub">
           <li><a id="mnu_5_0" href="<?=admin_base_url()?>language">Language Manage</a></li>       
        </ul>
      </li>
	  
	   <li  class="line"><a id="mnu_6" href="javascript:void(0);" class="active"><b>Master Role</b></a>
        <ul class="sub">
           <li><a id="mnu_6_0" href="<?=admin_base_url()?>user_role_master">Master Role Manage</a></li>       
        </ul>
      </li>
	  
	  <li  class="line"><a id="mnu_7" href="javascript:void(0);" class="active"><b>Multilingual</b></a>
        <ul class="sub">
           <li><a id="mnu_7_0" href="<?=admin_base_url()?>cms">CMS Management</a></li>       
        </ul>
      </li>
	

    </ul>-->

  </div>

</div>

<div class="clr"></div>

<div id="content" style="display: none;">

  <?php /*?><div id="show_hide"><a href="javascript:void(0);"><img src="images/admin/hide.gif" alt="" width="10" height="25" /></a></div>

  <div id="left_panel">

    <h4>Shortcuts</h4>

    <ul class="link">


      <li><a  id= "mnu_0_1" controller="Dashboard" href="<?php echo admin_base_url().'dashboard/';?>"><img src="images/admin/Import.gif" alt="" /><!--Update Profile-->Dashboard</a></li>	  
	
	  <li><a  id= "mnu_0_1"  controller="Site_setting"  href="<?php echo admin_base_url().'site_setting/';?>"><img src="images/admin/Import.gif" alt="" />Admin Site Setting</a></li>
	  
	  
	  
    </ul>

   

  </div><?php */?>

  

  <?php

	echo $content;

  ?>

  

  

  

  

  <div class="clr"></div>

</div>

<div class="clr"></div>

<div id="footer">

  <p>&copy; 2011 Copyright ###SITE_NAME_LC###</p>

  <p>&nbsp;</p>

</div>

</body>

</html>