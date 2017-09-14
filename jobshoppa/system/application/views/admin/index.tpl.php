<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<base href="<?php echo base_url(); ?>" />
<title>JOBSHOPPA</title>
<link href="css/admin/style.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="js/admin/curvycorners.src.js"></script>

<? /////////Jquery////// ?>
<script language="javascript" type="text/javascript" src="js/jquery/jquery-1.4.2.js"></script>
<?php /*<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/redmond/jquery.ui.all.css" />*/?>
<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/ui-darkness/ui.all.css" />
<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/jquery.ui.tooltip.css" />

<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.core.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.tooltip.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.dialog.js"></script>

<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/prettyPhoto/prettyPhoto.css" />
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.prettyPhoto.js"></script>
<? /////////end Jquery////// ?>

<script type="text/javascript" language="javascript" >
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    $("#frm_login").submit(function(){
        $.blockUI({ message: 'Just a moment please...' });
        var b_valid=true;
        var s_err="";
        $("#div_err").hide("slow");  
        
        if($.trim($("#txt_user_name").val())=="") 
        {
            s_err='<div id="err_msg" class="error_massage">Please provide user name.</div>';
            b_valid=false;
        }
        
        if($.trim($("#txt_password").val())=="") 
        {
            s_err+='<div id="err_msg" class="error_massage">Please provide password.</div>';
            b_valid=false;
        }        
        
        /////////validating//////
        if(!b_valid)
        {
            $.unblockUI();  
            $("#div_err").html(s_err).show("slow");
        }
        
        return b_valid;        
    });
})});   
</script>

</head>

<body>
<div id="header">
  <div id="logo"><img src="images/admin/logo.png" alt="###SITE_NAME_UC###" title="###SITE_NAME_UC###" /></div>
  <div class="clr"></div>
</div>
<div class="clr"></div>
<div id="navigation">&nbsp;</div>
<div class="clr"></div>
<div id="content">
  <div id="welcome_box">Welcome to ###SITE_NAME_LC### admin panel</div>	
  <div id="black_box">
  <form id="frm_login" action="" method="post">
    <p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>      
    </p>
    <p>&nbsp;</p>
    <div class="lable">User Name :</div>
    <div class="field"><input id="txt_user_name" name="txt_user_name" value="<?php if(isset($txt_user_name))echo $txt_user_name;?>" type="text" size="34" maxlength="20" /></div>
    <br class="clr" />
    <div class="lable">Password :</div>
    <div class="field"><input id="txt_password" name="txt_password" type="password" size="34" maxlength="12" /></div>
    <br class="clr" />
    <div class="lable">&nbsp;</div>
    <div class="field"><input type="submit" value="Submit" />
    </div>
    <br class="clr" />
	<div class="lable">&nbsp;</div>
    <div class="field"><a href="<?php echo admin_base_url()?>forgot_password" style="color:#FFFFFF;text-decoration:none;">Forgot Password?</a></div>
    <br class="clr" />
  </form>  
  </div>
</div>
<div class="clr"></div>
<div id="footer">
  <p>&copy; 2011 Copyright JOBSHOPPA</p>
  <p>&nbsp;</p>
</div>
</body>
</html>
