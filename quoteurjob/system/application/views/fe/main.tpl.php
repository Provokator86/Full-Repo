<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
<title>QUOTEYOURJOB.CA</title>
<?php if($i_lang_id ==1){ ?>
<link href="css/fe/style.css" rel="stylesheet" type="text/css" />
<?php }else { ?>
<link href="css/fe/style_fr.css" rel="stylesheet" type="text/css" />
<?php } ?>
<link rel="stylesheet" href="css/fe/nivo-slider.css" type="text/css" />
<link href="css/fe/login.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/fe/fancybox.css"  />
<?php echo $css?>
<script src="js/jquery-1.5.2.js" type="text/javascript"></script>
<script src="js/fe/login.js" type="text/javascript"></script>
<script src="js/fe/tabs.js" type="text/javascript"></script>
<script src="js/fe/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<script src="js/fe/nivo.slider.js" type="text/javascript" ></script>
<script src="js/fe/jquery.fancybox-1.3.4.js" type="text/javascript"></script>
<script src="js/jquery/ui/alphanumeric/jquery.alphanumeric.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="js/jquery.fancybox.blockui_1.1.0.pack.js"></script>
<?php echo $js?>
<script type="text/javascript">
var base_url = '<?php echo base_url();?>';
$(function() {
	$(".newsticker").jCarouselLite({
		btnNext: ".prev",
      	btnPrev: ".next",
		vertical: true,
		hoverPause:true,
        auto: false,
        hoverPause: false,
		visible: <?php echo $tot_news?>,
		speed:1000,
		scroll: 2
	});
	
	$(".testimonial").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 2,
		auto:500,
		speed:3000
	});
});
</script>

<script type="text/javascript">
 $(window).load(function() {
        $('#slider').nivoSlider();
    });
</script>

<script type="text/javascript">
	$(document).ready(function() {
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});
		});
/*		
function validate_registration()
{
	 var obj = document.forms['frm1'].getElementsByTagName('input');
	 var chk = false;
	 var text1 = '';
	 for(i=0;i<obj.length;i++)
	 {
		  type = obj[i].getAttribute('type');
		  name = obj[i].getAttribute('name');
		  if(type == 'radio' && 'registration' == name && obj[i].checked) 
		  {
			text1 = obj[i].value;
		  }
			if(text1 == 'buyer_registration')
				{
				 document.forms['frm1'].action='register_buyer.html';	
				}
			else
				{
				 document.forms['frm1'].action='register_tradesman.html';	
				 }
	 }
	return true;
}*/
</script>
</head>
<body>
<div id="header_top">
<?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
?>
</div>
<div id="header">
<?php
	include_once(APPPATH."views/fe/common/header.tpl.php");
?>
</div>
<div id="div_container">
      <?php echo $content;?>
</div>
<div class="footer">
<?php
	include_once(APPPATH."views/fe/common/footer.tpl.php");
?>
<form name="frm_msg" id="frm_msg" method="post" action="<?php echo base_url().'private_message/private_message_board'?>">
<input type="hidden" name="opd_job" id="opd_job" />
</form>
<form name="frm_msg_tra" id="frm_msg_tra" method="post" action="<?php echo base_url().'private_message/private_msg_land'?>">
<input type="hidden" name="opd_job" id="opd_job" />
</form>
</div>
</body>
</html>
