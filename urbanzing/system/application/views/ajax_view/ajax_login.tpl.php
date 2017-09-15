<!--
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
-->
<script type="text/javascript">
    $(document).ready(function() {
		$('form#ajax_frm_login').ajaxForm({
			//		dataType:  'script'
			beforeSubmit: ajax_login_before_ajaxform,
			success:      ajax_login_after_ajaxform
		});

		$('form#ajax_frm_login').submit(function() {
			// inside event callbacks 'this' is the DOM element so we first
			// wrap it in a jQuery object and then invoke ajaxSubmit
			//$(this).ajaxSubmit();

			// !!! Important !!!
			// always return false to prevent standard browser submit and page navigation
			return false;
		});
	});

	function ajax_login_before_ajaxform()
	{
		document.getElementById('tbl_msg').style.display    = 'none';
	}

	function ajax_login_after_ajaxform(responseText)
	{
		var sub = responseText.substring(0,3);

		if(responseText!='' && sub!='IBF' && sub!='RUR' && sub!='AAP' && sub!='BRR' && sub!='RLU' && sub!='ANB' && sub!='UBM' && sub!='BRC')
		{
			document.getElementById('tbl_msg').style.display    = 'block';
			document.getElementById('td_message').innerHTML     = responseText;
		}
		else
		{
			var org = responseText.substring(3);
			if(sub=='RUR' || sub=='ANB')
				window.location.href    = org;
			else if(sub=='IBF')
				tb_show('Incorrect business','<?=base_url()?>ajax_controller/ajax_show_incorrect_business/incorrct_business/'+org+'?height=300&width=450');
			else if(sub=='AAP')
				tb_show('Upload business photo','<?=base_url()?>ajax_controller/ajax_show_upload_business_photo/upload_business_photo/'+org+'?height=200&width=450');
			else if(sub=='UBM')
				tb_show('Upload business menu','<?=base_url()?>ajax_controller/ajax_show_upload_menu/upload_menu/'+org+'?height=200&width=450');
			else if(sub=='BRR')
				tb_show('Review Report','<?=base_url()?>ajax_controller/ajax_show_review_report/review_report/'+org+'?height=200&width=450');
			else if(sub=='BRC')
			{
				tb_show('Request coupon','<?=base_url()?>ajax_controller/ajax_request_coupon/'+org+'?height=50&width=400');
				setTimeout('window.location.reload()',5000);
			}
			else if(sub=='RLU')
				window.location.reload();

		}

	}

</script>
<div class="sign_up" style="width: 375px;">
	<div class="margin15"></div>
	<div class="signup_left" style="border: 0px;">
        <form name="ajax_frm_login" id="ajax_frm_login" class="ajax_frm_login" action="<?=base_url().'ajax_controller/ajax_login'?>" method="post">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td colspan="2"><h5>Please enter your email address and password to log in. </h5></td>
				</tr>
				<tr>
					<td colspan="2">
						<table id="tbl_msg" style="display: none;"  width="97%" cellspacing="0" cellpadding="5" border="0" class="msg_error">
							<tr>
								<td id="td_message" style="padding-left: 25px;"></td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td align="right">Email</td>
					<td><input style="width:200px;" type="text" name="uid" id="uid" /></td>
				</tr>
				<tr>
					<td align="right">Password</td>
					<td><input style="width:200px;" type="password" name="pwd" id="pwd" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td height="40">
						<input type="hidden" name="is_posted" value="1" />
						<input type="hidden" name="item_type" value="<?=$item_type?>" />
						<input type="hidden" name="item_id" value="<?=$item_id?>" />
						<input class="button_02" type="submit" value="Submit >>" />
					</td>
				</tr>
			</table>
        </form>
	</div>
	<div class="clear"></div>
	<div class="signup_right" align="left">
		<h3>Or simply use your Facebook identity</h3>
		<div class="margin15"></div>
		<fb:login-button v="2" onlogin="facebook_onlogin();" length="long"><fb:intl>Login with Facebook</fb:intl></fb:login-button>
		<!--<a href="#"><img align="absmiddle" src="<?=base_url()?>images/front/face_book.png" /></a>-->
	</div>
	<div style="clear:both"></div>
	<div style=" font-size:14px;color:#FF790A; padding-top:15px; padding-left:115px; font-weight:bold;">Not registered yet? <a style="color:#FF790A" href="<?=base_url()?>user">Click here</a></div>
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
			document.location.href = base_url+'user/facebook_login';
	   }
	 */
</script>