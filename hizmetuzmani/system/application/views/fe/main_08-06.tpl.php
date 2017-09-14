<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
<title>::Hizmetuzmani::</title>
<?php if($language_now =='en'){ ?>
<link href="css/fe/style.css" rel="stylesheet" type="text/css" />
<?php }else { ?>
<link href="css/fe/styletr.css" rel="stylesheet" type="text/css" />
<?php } ?>

<link href="css/fe/dd.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/fe/jquery-1.5.2.js"></script>
<script type="text/javascript" src="js/fe/jquery.dd.js"></script>
<!--nav-->
<script type="text/javascript" src="js/fe/ddsmoothmenu.js"></script>
<!--nav-->
<!--login-->
<link href="css/fe/login.css" rel="stylesheet" type="text/css" />
<script src="js/fe/login.js" type="text/javascript"></script>
<!--login-->
<!--light box-->
<script type="text/javascript" src="js/fe/ModalDialog.js"></script>
<script type="text/javascript" src="js/fe/lightbox.js"></script>
<script type="text/javascript" src="js/fe/common.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<!--light box-->
<!--banner-->
<script src="js/fe/tabs.js" type="text/javascript"></script>
<!--banner-->
<!--tooltip-->
<script type="text/javascript" src="js/fe/tooltip.js"></script>
<!--tooltip-->
<!--Tooltip-->
<script type="text/javascript" src="js/fe/jquery.betterTooltip.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		
		
      
        $('.tTip').betterTooltip({speed: 150, delay: 300});
		$("input").focus(function() {
		
	//	$(this).addClass('tTip');
		 });
		
	});
</script>
<!--Tooltip-->
	  
<!--Testimonials and news-->
<script src="js/fe/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<script type="text/javascript">
var base_url    =   "<?php echo base_url(); ?>";

$(function() {

	
	$(".testimonial").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 2,
		auto:500,
		speed:3000
	});
	
		$(".newsticker").jCarouselLite({
		vertical: true,
		hoverPause:true,
		visible: 6,
		auto:500,
		speed:3000
	});
});
</script>
</head>
<body>
<div class="wrapper">
  <!--top_part-->
  <?php include_once(APPPATH."views/fe/common/header.tpl.php"); ?>
  <!--top_part-->
  <div class="spacer"></div>
  <!--banner-->
  <!--banner-->
  <!--bar-->
  <!--bar-->
  <!--body-->
  <!--body-->
  <!--job_categories-->
  <?php echo $content;?>
  <!--job_categories-->
  <!--body 02-->
  
  <!--body 02-->
</div>
<!--footer-->
<?php include_once(APPPATH."views/fe/common/footer.tpl.php"); ?>
<!--footer-->

</body>
</html>
