<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!--<html xmlns="http://www.w3.org/1999/xhtml">
--><html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='page' content='<?php echo $meta_page; ?>' />
<meta name='title' content='<?php echo $meta_title; ?>' />
<meta name='keywords' content='<?php echo $meta_keyword; ?>' />
<meta name='revisit_after' content='<?php echo $meta_revisit_after; ?>' />
<meta name='robots' content='<?php echo $meta_robots; ?>' />
<meta name='language' content='en' />
<meta name='Classification' content='<?php echo $meta_classification; ?>' />
<meta name='expires' content='<?php echo $meta_expires; ?>' />

<base href="<?php echo base_url(); ?>" />
<title>::: JobShoppa.com :::</title>
<link href="css/fe/style.css" rel="stylesheet" type="text/css" media="screen" />
<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/smoothness/ui.all.css" />
<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/jquery.ui.tooltip.css" />
<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/prettyPhoto/prettyPhoto.css" />
<link rel="stylesheet" type="text/css" href="css/fe/fancybox.css"  />
<?php echo $css?>
<script type="text/javascript" src="js/fe/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/fe/jquery.easing.1.3.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/jquery-1.4.2.js"></script>
<script type="text/javascript" src="js/fe/script.js"></script>
<script type="text/javascript" src="js/fe/ModalDialog.js"></script>
<script type="text/javascript" src="js/fe/lightbox.js"></script>
<script type="text/javascript" src="js/fe/tab.js"></script>
<script type="text/javascript" src="js/fe/tab2.js"></script>  
<script type="text/javascript" src="js/fe/accordion.js"></script>

<script type="text/javascript" src="js/fe/jcarousellite_1.0.1c4.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.core.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery-ui-1.8.4.custom.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.tooltip.js"></script> 
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.blockUI.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.dialog.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.ui.tabs.js"></script>
<!--<script language="javascript" type="text/javascript" src="js/jquery/ui/jquery.prettyPhoto.js"></script>-->
<script language="javascript" type="text/javascript" src="js/json2.js"></script>
<script language="javascript" type="text/javascript" src="js/jquery/ui/alphanumeric/jquery.alphanumeric.pack.js"></script>
<script src="js/fe/jquery.fancybox-1.3.4.js" type="text/javascript"></script>
<script src="js/jquery.form.js" type="text/javascript"></script>
<!--<script language="javascript" type="text/javascript" src="js/jquery.fancybox.blockui_1.1.0.pack.js"></script>-->
<?php echo $js?>
<? /////////end Jquery////// ?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';

$(function() {
    $("input[name='txt_dob']").click(  function() {
        $('#ui-datepicker-div a').each(function (i) {
            $(this).attr('href', 'javascript:void(0)');
        });
    } );
}); 
/*$(document).ready( function(){	
	$('#lofslidecontent45').lofJSidernews 
	({
		interval:4000,
   		direction:'opacity',
   		duration:1000,
   		easing:'easeInOutSine'
	});						
});*/

/*$(function() {
	$(".testimonial").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 1,
		auto:200,
		speed:3000
	});
});*/
</script>


<?php /*?><script type="text/javascript" src="http://platform.linkedin.com/in.js">
	api_key: 75benbt0nxi3mg
	authorize: true
</script>
<script type="text/javascript">


	function onLinkedInAuth() {
		IN.API.Profile("me")
		.fields(["id" ,"first-name","lastName","headline", "email-address"])
		.result( function(me) {
			console.log(me);
			var id = me.values[0].id;
			var first_name = me.values[0].first-name;
			var last_name = me.values[0].lastName;
			var email = me.values[0].email-address;
			// AJAX call to pass back id to your server
		});
		
	}
	
</script><?php */?>


</head>
<body>
<!--<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>-->

<!-- HEADER SECTION -->
<div id="header_section">
    <?php
	include_once(APPPATH."views/fe/common/header.tpl.php");
	?>
</div>
<!-- /HEADER SECTION -->
<!-- BANNER SECTION -->

<!--<div id="content_section">-->
	<?php echo $content;?>
   <div class="clr"></div>
<!--</div>-->
<!-- /CONTENT SECTION -->
<!-- FOOTER SECTION -->
<div id="footer_section">
<?php
	include_once(APPPATH."views/fe/common/footer.tpl.php");
?>
</div>
<!-- /FOOTER SECTION -->


<form name="frm_msg" id="frm_msg" method="post" action="<?php echo base_url().'private_message/private_message_board'?>">
<input type="hidden" name="opd_job" id="opd_job" />
</form>
<form name="frm_msg_tra" id="frm_msg_tra" method="post" action="<?php echo base_url().'private_message/private_msg_land'?>">
<input type="hidden" name="opd_job" id="opd_job" />
</form>
</body>
</html>
<div id="fb-root"></div>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">   
  FB.init({appId: '<?=$facebook_app_id?>', status: true, cookie: true, xfbml: true, oauth: true});
   function fblogincheck(){  
   	FB.login(function(response) {	
	 if (response.authResponse) {
	 	  var access_token = response.authResponse.accessToken;
	  //var encoded = enc(access_token);
	  //$('#loading_fconnect').show();      
	 // animated_period_fn();
		   
	  window.location.href = '<?=base_url()?>'+'user/fconnect/'+access_token;
	  
	 } else {
	 // user cancelled login
	 }
	});
   }
   
  function fblogoutcheck(){ 
   FB.logout(function(response) {
   window.location.href = '<?=base_url()?>'+'users/logout';
   });   
  }							
							
	</script>						

<!--<script>
  window.fbAsyncInit = function() {
	FB.init({
	  appId      : '<?=$facebook_app_id?>',
	  status     : true, 
	  cookie     : true,
	  xfbml      : true,
	  oauth      : true,
	});

	FB.login(function(response) {								
	 if (response.authResponse) {	 
	  var access_token = response.authResponse.accessToken;
	  //var encoded = enc(access_token);
	  //$('#loading_fconnect').show();      
	 // animated_period_fn();		   
	  window.location.href = '<?=base_url()?>'+'user/fconnect/'+access_token;
	  
	 } else {
	 // user cancelled login
	 }
	});	
	
  };

  (function(d){
	 var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
	 js = d.createElement('script'); js.id = id; js.async = true;
	 js.src = "//connect.facebook.net/en_US/all.js";
	 d.getElementsByTagName('head')[0].appendChild(js);
   }(document));
</script>
-->