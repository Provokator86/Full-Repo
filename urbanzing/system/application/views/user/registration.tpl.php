<div class="sign_up">
     <script type="text/javascript">
 var RecaptchaOptions = {
   theme: 'custom',
   lang: 'en',
   custom_theme_widget: 'div_recaptcha'
};
 </script>
    <h1><?=$user_signup_upper[0]['title']?></h1>
    <div class="margin15"></div>
    <?php /*?><h2><?=$user_signup_upper[0]['title']?></h2><?php */?>
    <div class="margin15"></div>
    <?=html_entity_decode( $user_signup_upper[0]['description'])?>
    <div class="margin15"></div>
    <!--Left Part-->
    <div class="signup_left">
    <!--<h3>take some time and fill out the form below</h3>-->
    <?
    $this->load->view('admin/common/message_page.tpl.php');
    ?>
    <h6>* marked fileds are mandatory</h6>
    
    <div class="margin15"></div>
    <form action="<?=base_url().'user/save_registration'?>" method="post" name="frm_reg" id="frm_reg" enctype="multipart/form-data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
        <td align="right" width="30%">Email  <span>*</span></td>
        <td><input id="email" name="email" type="text" value="<?=$old_values['email']?>"/></td>
      </tr>
      <tr>
        <td align="right">First Name <span>*</span></td>
        <td><input id="f_name" name="f_name" type="text" value="<?=$old_values['f_name']?>" /></td>
      </tr>
       <tr>
        <td align="right">Last Name <span>*</span></td>
        <td><input id="l_name" name="l_name" type="text" value="<?=$old_values['l_name']?>" /></td>
      </tr>
      <tr>
        <td align="right">Screen name </td>
        <td><input id="screen_name" name="screen_name" type="text" value="<?=$old_values['screen_name']?>"/></td>
      </tr>
      
      <tr>
        <td align="right">Password  <span>*</span></td>
        <td><span style="font-size:11px; color:#EB1018; font-weight:normal" >
		Enter a new password for your urbanZing account</span>
		<input id="password" name="password" type="password" value="<?=$old_values['password']?>"/></td>
      </tr>
<!--      <tr>
        <td align="right">Confirm Password  <span>*</span></td>
        <td><input id="c_password" name="c_password" type="password" value="<?=$old_values['c_password']?>"/></td>
      </tr>
      <tr>
        <td align="right">Pincode  <span>*</span></td>
        <td><span style="font-size:11px; color:#EB1018; font-weight:normal" >
		To keep this form short we have removed the need for you to enter your entire address. All we need is your pincode! Please enter it here</span>
		<input id="zip_id" name="zip_id" type="text" value="<?=$old_values['zip_id']?>"/></td>
      </tr>
      <tr>
        <td align="right" valign="top">About yourself</td>
        <td><textarea id="about_yourself" name="about_yourself"><?=$old_values['about_yourself']?></textarea></td>
      </tr>-->
       <tr>
        <td align="right">Photo</td>
        <td><input id="img_name" name="img_name" type="file" /></td>
      </tr>
       <tr>
        <td align="right">Type the characters shown <span>*</span></td>
        <td>
            <div id="div_recaptcha" style="display:none;">
                <div id="recaptcha_image" style="float:left"></div><div style="float:right; width:10px;">
				<a href="javascript:Recaptcha.reload()" title="Regenerate Image"><img src="<?=base_url().'images/front/'?>refresh.jpeg" border="0" /></a></div>
                    <input name="recaptcha_response_field" id="recaptcha_response_field" type="text" class="txtfld" />
             </div>
            <?=$recaptcha_html?>
			
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td height="40">
            <input type="hidden" id="user_type_id" name="user_type_id" value="2"/>
            <input class="button_02" type="submit" value="Submit >>" />&nbsp;&nbsp;
            <input class="button_02"  type="reset" value="Reset >>" /></td>
      </tr>
    </table>
       
                            </form>
    </div>
    <div class="signup_right">
            <h3>Or simply use your Facebook identity</h3>
         <div class="margin15"></div>
         <fb:login-button v="2"  onlogin="facebook_onlogin();" length="long" ><fb:intl>Login with Facebook</fb:intl></fb:login-button>
    </div>
    <div class="clear"></div>
</div>

 <script type="text/javascript"> 
 FB.init("<?=$api_key?>", "/xd_receiver.htm");
/*
      FB.init({appId: '109132209139296', status: true,
      cookie: true, xfbml: true});*/
      /*FB.Event.subscribe('auth.login', function(response) {
        window.location.reload();
      });*/
	/*function facebook_onlogin() {
        FB.Connect.showPermissionDialog(
    "publish_stream,offline_access,photo_upload",
    permissionHandler,true);
    } */
/*	function facebook_onlogin() {
        FB.Connect.showPermissionDialog( "email,user_birthday,user_website",permissionHandler);
		//document.location.href=document.location.href;
    } 
	 function permissionHandler()
	   {
	    	//document.location.href=document.location.href;
			document.location.href = base_url + 'user/facebook_regular_user_signup/2';
	   }*/
	  
</script>