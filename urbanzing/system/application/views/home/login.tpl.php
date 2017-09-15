<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>


<div class="sign_up">
        <h1><?=$login_page_upper_text[0]['title']?></h1>
        <div class="margin15"></div>
        <?php /*?><h2><?=$login_page_upper_text[0]['title']?></h2><?php */?>
        <div class="margin15"></div>
        <?=html_entity_decode( $login_page_upper_text[0]['description'])?>

        <div class="margin15"></div>
        <!--Left Part-->
        <div class="signup_left">
        <h3>Login</h3>
        <div class="margin15"></div>
        <form name="frm_login" action="<?=base_url().'user/login'?>" method="post">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
             <td colspan="2"><h5>Please enter your email address and password to log in. </h5></td>
             </tr>
          <tr>
		  <tr>
		  	<td colspan="2">
			  <?php
               $this->load->view('admin/common/message_page.tpl.php');
			  ?>
			</td>
		  </tr>
            <td align="right">Email</td>
            <td><input style="width:200px;"  type="text" name="uid" id="uid" /></td>
          </tr>
          <tr>
            <td align="right">Password</td>
            <td><input style="width:200px;"  type="password" name="pwd" id="pwd" /></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><h6><a href="<?=base_url().'user/forget_password'?>">Forgot your password ?</a></h6></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td height="40">
                                                        <input type="hidden" name="is_posted" value="1" />
                                                        <input class="button_02" type="submit" value="Submit >>" onclick="document.frm_login.submit();" /></td>
          </tr>
        </table>
        </form>
        <div class="margin15"></div>
        </div>
        <div class="signup_right">
                <h3>Or simply use your Facebook identity</h3>
             <div class="margin15"></div>
			 <fb:login-button v="2"  onlogin="facebook_onlogin();" length="long" ><fb:intl>Login with Facebook</fb:intl></fb:login-button>
             <!--<a href="#"><img align="absmiddle" src="<?=base_url()?>images/front/face_book.png" /></a>-->
        </div>

        <div class="clear"></div>
        <h2><?=$login_page_lower[0]['title']?></h2>
        <div class="margin15"></div>
        <?=html_entity_decode( $login_page_lower[0]['description'])?>
        <div class="margin15"></div>
        <input class="button_02" onclick="window.location.href='<?=base_url().'user'?>'" name="submit_button" type="button" value="SIGN UP" />
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
	/*function facebook_onlogin() {
        FB.Connect.showPermissionDialog( "email,user_birthday,user_website",permissionHandler);
		//document.location.href=document.location.href;
    } 
	 function permissionHandler()
	   {
	    	//document.location.href=document.location.href;
			document.location.href = base_url+'user/facebook_login';
	   }*/
	  
</script>