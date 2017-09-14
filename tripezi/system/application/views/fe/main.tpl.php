<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='page' content='<?php echo $meta_page; ?>' />
<meta name='title' content='<?php echo $meta_title; ?>' />
<meta name='keywords' content='<?php echo $meta_keyword; ?>' />
<meta name="description" content="<?php echo $meta_description; ?>" />
<meta name='language' content='en' />

<base href="<?php echo base_url(); ?>" />
<title>::TRIPEZI::</title>

<link href="css/fe/style.css" rel="stylesheet" type="text/css" />
<link href="css/fe/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<link href="css/fe/colorbox.css" rel="stylesheet" type="text/css" />
<link href="css/fe/jquery.alerts.css" rel="stylesheet" type="text/css" />

<link  type="text/css" rel="stylesheet" media="screen" href="js/jquery/themes/redmond/ui.all.css" />
<link href="css/fe/dd.css" rel="stylesheet" type="text/css" />
<!-- FAVICON -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url(); ?>fab-icon.ico">

<script type="text/javascript" src="js/fe/jquery-1.5.2.js"></script>
<!--text auto fell-->
<script type="text/javascript" src="js/fe/jquery.autofill.js"></script>
<!--text auto fell-->
<!--Tooltip-->
<script type="text/javascript" src="js/fe/tooltip.js"></script>
<!--Tooltip-->
<!--checkbox-->
<script type="text/javascript" src="js/fe/custom-form.js" ></script>
<!--checkbox-->
<!--textfell-->
<script type="text/javascript" src="js/fe/jquery.dd.js"></script>

<script type="text/javascript" src="js/fe/dropdown.js"></script>
<script type="text/javascript" src="js/fe/jquery.autocomplete.js"></script>
<script type="text/javascript" src="js/fe/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="js/fe/jquery.alerts.js"></script>
<!--textfell-->
<!--calendar-->
<!--<link rel="stylesheet" type="text/css" media="all" href="css/fe/jsDatePick_ltr.min.css" />-->
<!--<script type="text/javascript" src="js/fe/jsDatePick.jquery.min.1.3.js"></script>-->
<!--<script type="text/javascript" src="js/fe/calendar.js"></script>-->

<!--calendar-->
<!--light box-->
<script type="text/javascript" src="js/fe/ModalDialog.js"></script>
<!--light box-->
<!--banner-->
<script type="text/javascript" src="js/fe/jquery.easing.1.2.js"></script>
<script type="text/javascript" src="js/fe/jquery.anythingslider.js" charset="utf-8"></script>
<!--banner-->
<!--[if IE 7]>
<body class="ie7">
<![endif]-->
<!--[if IE 8]>
<body class="ie8">
<![endif]-->
<!--[if IE 9]>
<body class="ie9">
<![endif]-->
<script type="text/javascript">
var base_url    =   "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="<?php echo base_url(); ?>system/application/helpers/gmap3/libgmap3/libgmap3.js"></script>

</head>
<body>

<div class="container">
      <!--top bar-->
     <?php include_once(APPPATH."views/fe/common/header.tpl.php"); ?>
	  <!--part-one-->
	  <!--part-two-->                 
	  <!--part-two-->                  
	  <!--part-three-->
	 <?php echo $content ?>
	  <!--part-three-->
	  <br class="spacer" />
	  <!--part-four-->                  
	  <!--part-four-->           
      <!--body part-->
      <!--footer link part-->
     <?php include_once(APPPATH."views/fe/common/footer.tpl.php"); ?>
      <!--footer link part-->
</div>


</body>
</html>
