<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $title; ?></title>
<script type="text/javascript">//<![CDATA[
var Book={l:{},at:function(n){Book.l[n]=new Date().getTime();}};Book.at("zero");var w=(window.name||"").toString();window.name="";(w.indexOf("z:")===0)&&(Book.l["orig"]=w.substr(2));//]]>
</script>
<meta property="fb:app_id" content="100763636656765" /> 
<meta property="og:site_name" content="urbanzing.com"/> 
<meta property="og:title" content="Urbanzing"/> 
<meta property="og:type" content="website"/> 
<meta property="og:url" content="<?php echo base_url(); ?>"/>
<meta property="og:image" content="<?php echo base_url(); ?>images/front/logo.png"/>
<meta property="og:description" content="<?php echo $meta_desc; ?>"/>

<?php if (isset($meta_keywords) && !empty($meta_keywords)) { ?>
<meta name="keywords" content="<?php echo $meta_keywords; ?>"/>
<?php } ?>

<meta name="description" content="<?php echo $meta_desc; ?>"/>
<meta name='revisit_after' content='<?php echo $meta_revisit_after; ?>' />
<meta name='robots' content='<?php echo $meta_robots; ?>' />
<meta name='language' content='<?php echo $meta_language; ?>' />
<meta name='expires' content='<?php echo $meta_expires; ?>' />

<?php if (isset($meta_google_site_verification) && !empty($meta_google_site_verification)) { ?>
<meta name="google-site-verification" content="<?php echo $meta_google_site_verification; ?>" />
<?php } ?>

<?php if (isset($meta_y_key) && !empty($meta_y_key)) { ?>
<meta name="y_key" content="<?php echo $meta_y_key; ?>" />
<?php } ?>

<meta name="alexaVerifyID" content="I8GemXsFwUCBcNbisKzytRxSF7I" />

<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
<?php /*?><script type="text/javascript" src="http://static.ak.fbcdn.net/rsrc.php/zDQYS/hash/707f6bxd.js"></script><?php */?>

<script type="text/javascript">Book.at("page");</script>

<script type="text/javascript">
var base_url = '<?=base_url()?>';
</script>
<?php echo $js; ?>
<?php echo $css; ?>
<!--<script type="text/javascript" src="http://localhost/urbanzing/js/thickbox.js"></script>
-->
<script type="text/javascript">
<!--
var timeout         = 500;
var closetimer		= 0;
var ddmenuitem      = 0;

// open hidden layer
function mopen(id)
{
	// cancel close timer
	mcancelclosetime();

	// close old layer
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';

	// get new layer and show it
	ddmenuitem = document.getElementById(id);
	ddmenuitem.style.visibility = 'visible';
}

// close showed layer
function mclose()
{
	if(ddmenuitem) ddmenuitem.style.visibility = 'hidden';
}

// go close timer
function mclosetime()
{
	closetimer = window.setTimeout(mclose, timeout);
}

// cancel close timer
function mcancelclosetime()
{
	if(closetimer)
	{
		window.clearTimeout(closetimer);
		closetimer = null;
	}
}

// close layer when click-out
document.onclick = mclose;
// -->
</script>
</head>

<body>
<div id="global">
	<!--Header Section Start-->
	<?php
		$this->load->view('layouts/header.tpl.php');
	?>
	<!--Header Section End-->

	<!--Body Section Start-->
	<div id="body_part">
		<?php
		$this->load->view('layouts/header_menu.tpl.php');
		?>
		<!--Menu Section End-->

		<div class="cont_sction">
			<div class="margin15"></div>
			<div class="main_content">
				<div class="left_panel">
					<?php
					foreach( $this->include_files as $value ) :
						$this->load->view($value.'.tpl.php');
					endforeach;
					?>
				</div>
				<!--Left Panel End-->

				<?php
				$this->load->view('partials/advertisement_right.tpl.php');
				?>
				<div class="clear"></div>
			</div>
		</div>

		<div class="botm_section"></div>
	</div>
	<!--Body Section End-->

	<!--Footer Start-->
	<div id="footer">
		<div class="footer_left">
			<p>&copy; Copyright <?php echo date('Y'); ?> All Rights Reserved by UrbanZing.com</p>
			<p>Designed &amp; Developed by: <a href="http://www.acumensofttech.com/" target="_blank">Acumen CS</a></p>
		</div>

		<div class="footer_mid">
			<a href="http://www.facebook.com/urbanzing" target="_blank"><img src="<?php echo base_url(); ?>images/front/facebook_badge.gif" border="0" alt="Facebook" /></a>
			&nbsp;
			<a href="http://www.twitter.com/urbanzing" target="_blank"><img src="<?php echo base_url(); ?>images/front/twitter.gif" border="0" alt="Twitter" /></a>
		</div>

		<div class="footer_right">
			<a href="http://theurbanzingblog.wordpress.com/" target="_blank">Blog</a>
			&nbsp;|&nbsp;
			<a href="<?=base_url().'home/site_content/about_us'?>">About us</a>
			&nbsp;|&nbsp;
			<a href="<?=base_url().'home/site_content/careers'?>">Careers</a>
			&nbsp;|&nbsp;
			<a href="<?=base_url().'home/site_content/contact_us'?>">Contact us</a>
			&nbsp;|&nbsp;
			<a href="<?=base_url().'home/site_content/terms'?>">Terms and Conditions</a>
			&nbsp;|&nbsp;
			<a href="<?=base_url().'home/site_content/privacy'?>">Privacy</a>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19026883-1']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</body>
</html>
