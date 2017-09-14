<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <base href="<?= base_url() ?>" />
	
    <title>:: SOAP API Documentation ::</title>
	<meta name="description" content="SOAP API Documentation" />
	<script type="text/javascript">
    <!--
		var doc_base_url = '<?= base_url() ?>';
    //-->
    </script>
    <script type="text/javascript" src="<?= base_url() ?>resources/js/jquery-1.11.3.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>resources/js/toTop/jquery-scrollToTop.js"></script>
	<script type="text/javascript" src="<?= base_url() ?>resources/js/custom-scripts/help/common_calls.js"></script>
	<link href="<?= base_url() ?>resources/css/help/main.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?= base_url() ?>resources/css/help/side-bar.css" rel="stylesheet" type="text/css" media="all" />
	<link href="<?= base_url() ?>resources/css/toTop/easing.css" rel="stylesheet" type="text/css" />
	<link href="<?= base_url() ?>resources/css/toTop/scrollToTop.css" rel="stylesheet" type="text/css" />

	<!-- The fav icon -->
	<link rel="shortcut icon" href="<?= base_url() ?>images/favicon.ico">
    
</head>

<body class="html not-front not-logged-in one-sidebar sidebar-first page-node page-node- page-node-730 node-type-api-doc i18n-en">

	<?php flush(); ?>
	
	<div class="Page Page--canopy is-narrow Page--basicStyles  Page--dev  Page--devDocumentation Page--apiDoc">
		<div class="Navigation Navigation--global is-loaded">
			<?php
				# header-navigation-part...
				include_once 'doc_header_navbar.php';
			?>
		</div>
		<div class=" Hero is-narrow Hero--dev">
			<div class="Hero-wrap"></div>
		</div>
		<section class="help-content">
			<div class="PageLayout  is-narrow PageLayout--leftColumn Grid">
				<div class="PageLayout-wrap">
				<?php
					# header-sidebar-part...
					include_once 'doc_sidebar.php';
				?>
				<div class="PageLayout-content Grid-cell u-size8of12 u-sm-sizeFill u-md-sizeFill">
						<article class="Content" id="main-content">
