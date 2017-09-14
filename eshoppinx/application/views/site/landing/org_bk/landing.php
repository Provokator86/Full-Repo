<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php if($this->config->item('google_verification')){ echo stripslashes($this->config->item('google_verification')); }
if ($heading == ''){?>
<title><?php echo $title;?></title>
<?php }else {?>
<title><?php echo $heading;?></title>
<?php }?>
<meta name="Title" content="<?php echo $meta_title;?>" />
<meta name="keywords" content="<?php echo $meta_keyword; ?>" />
<meta name="description" content="<?php echo $meta_description; ?>" />
<base href="<?php echo base_url(); ?>" />
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/logo/<?php echo $fevicon;?>"/>
<link rel="stylesheet" href="css/site/landing_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/banner_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/popup_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/developer.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/colorbox.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/site/style_responsive.css" />
<script type="text/javascript" src="js/site/jquery-1.5.1.min"></script>

<script type="text/javascript">

/*** 
    Simple jQuery Slideshow Script
    Released by Jon Raasch (jonraasch.com) under FreeBSD license: free to use or modify, not responsible for anything, etc.  Please link out to me if you like it :)
***/

function slideSwitch() {
    var $active = $('#slideshow IMG.active');

    if ( $active.length == 0 ) $active = $('#slideshow IMG:last');

    // use this to pull the images in the order they appear in the markup
    var $next =  $active.next().length ? $active.next()
        : $('#slideshow IMG:first');

    // uncomment the 3 lines below to pull the images in random order
    
    // var $sibs  = $active.siblings();
    // var rndNum = Math.floor(Math.random() * $sibs.length );
    // var $next  = $( $sibs[ rndNum ] );


    $active.addClass('last-active');

    $next.css({opacity: 0.0})
        .addClass('active')
        .animate({opacity: 1.0}, 1000, function() {
            $active.removeClass('active last-active');
        });
}

$(function() {
    setInterval( "slideSwitch()", 5000 );
});

</script>
<!--[if lt IE 9]>
<script src="js/site/html5shiv/dist/html5shiv.js"></script>
<![endif]-->
<script src="js/site/jquery.colorbox.js"></script>
<script>
$(document).ready(function(){

	//alert($( window ).width());	

		$(".cboxClose1").click(function(){
			$("#cboxOverlay,#colorbox").hide();
			});
		
	var landingwindowsize = $(window).width();
		
			if (landingwindowsize > 559) {
				$(".example5").colorbox({width:"560px",height:"700px", inline:true, href:"#inline_example5"});
				$(".example9").colorbox({width:"560px",height:"700px", inline:true, href:"#inline_example4"});
				$(".example12").colorbox({width:"560px",  height:"450px", inline:true, href:"#inline_example7"});
				$(".example13").colorbox({width:"560px", height:"600px", inline:true, href:"#inline_example8"});
				$(".example14").colorbox({width:"560px", height:"450px", inline:true, href:"#inline_example9"});
			} else {
				$(".example5").colorbox({width:"320px",height:"500px", inline:true, href:"#inline_example5"});
				$(".example9").colorbox({width:"320px",height:"500px", inline:true, href:"#inline_example4"});
				$(".example12").colorbox({width:"320px",  height:"450px", inline:true, href:"#inline_example7"});
				$(".example13").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example8"});
				$(".example14").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example9"});
			}
			
			
			$(".example10").colorbox({width:"560px",height:"700px", inline:true, href:"#inline_example5"});
			
			$(".example11").colorbox({width:"560px", inline:true, href:"#inline_example6"});
			
			
		
		//Example of preserving a JavaScript event for inline calls.
			$("#onLoad").click(function(){ 
				$('#onLoad').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});

});
</script>
</head>
<!-- Popup_start -->
<?php 
$this->load->view('site/templates/popup_templates.php',$this->data);
$this->load->view('site/landing/landing_popup',$this->data);
?>

<!-- Popup_end -->
<body>
<!-- header_start -->
<header>

	<div class="header_fixed">
    
    	<div class="main3">
    
   		 	<div id="logo"><a href="<?php echo base_url();?>" alt="<?php echo $siteTitle;?>" title="<?php echo $siteTitle;?>"><img src="images/logo/<?php echo $logo;?>"/></a></div>
            
            <div class="header_subtitle">Find and save products you love.</div>
            
            <div class="header_button">
            	
            	<a class="example5 header_join_btn" href="javascript:void(0);">Join</a>
                
                <a class="example9 header_sign_btn" href="javascript:void(0);"><?php if($this->lang->line('signup_sign_in') != '') { echo stripslashes($this->lang->line('signup_sign_in')); } else echo "Sign in"; ?></a>
                
            </div>
            
            <!--<ul class="header_right_nav">
        <li><a class="example9" href="javascript:void(0);"><?php if($this->lang->line('signup_sign_in') != '') { echo stripslashes($this->lang->line('signup_sign_in')); } else echo "Sign in"; ?></a></li>
      </ul>-->
    	
        </div>
    
    </div>



  <!--<div class="header_main">
    <div class="main">
      
      
    </div>
  </div>-->
</header>
<!-- header_end -->
<!-- Section_start -->
<section>
  <!--<div class="banner_main">
    <div class="banner_container">
      <h1 class="banner_container_heading"><?php if($this->lang->line('landing_all_stores') != '') { echo stripslashes($this->lang->line('landing_all_stores')); } else echo "All stores in one place"; ?>.</h1>
      <div class="banner_signup_main">
        <div class="banner_signup"> <a class="signup_facebook" onclick="window.location.href='<?php echo base_url().'facebook/user.php'; ?>'"><?php if($this->lang->line('landing_start_shop') != '') { echo stripslashes($this->lang->line('landing_start_shop')); } else echo "START SHOPPING"; ?></a> <span class="signup-or"><?php if($this->lang->line('landing_or') != '') { echo stripslashes($this->lang->line('landing_or')); } else echo "OR"; ?></span><div class="div_email1"></div>
            <form onsubmit="return register_user(this);" method="post" class="frm clearfix" name="SignupForm" id="SignupForm" >
                    
                   	<input type="text" id="email" name="email" value="" class="signup_scroll required email" placeholder="<?php if($this->lang->line('landing_your_mail') != '') { echo stripslashes($this->lang->line('landing_your_mail')); } else echo "Your Email"; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" /><div class="div_email"></div>
            
           
            <input type="text" name="username" value="" id="username" class="signup_scroll required" placeholder="<?php if($this->lang->line('signup_user_name') != '') { echo stripslashes($this->lang->line('signup_user_name')); } else echo "Username"; ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" /><div class="div_username"></div>
            
		    
			<input type="password" id="password" name="password" style="color:#000000; font-weight:bold;"  class="signup_scroll required" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;" placeholder="<?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?>"/><div class="div_password"></div>
                    
                    <input type="submit" id="next" name="next" value="<?php if($this->lang->line('landing_start_shop') != '') { echo stripslashes($this->lang->line('landing_start_shop')); } else echo "Start Shopping"; ?>" class="start_btn" /> <div class="processing"></div>
                    <input name="referrer" type="hidden" class="referrer" value="" />
                    <input name="invitation_key" type="hidden" class="invitation_key" value="" />
		</form>
      </div></div>
    </div>
    <div id="slideshow">
      <?php if($SliderDisplay->num_rows() > 0){
				foreach ($SliderDisplay->result() as $Slider){
				?>
      <img src="images/slider/<?php echo $Slider->image; ?>" alt="" class="active" />
      <?php }}?>
    </div>
  </div>-->
</section>
<!-- Section_end -->
<!-- Section_start -->
<section>
  <div class="main">
    <div class="product_main_landing">
      <!--<h1 style="font-weight: bold;"><a href="<?php echo base_url().'trending';?>"><?php if($this->lang->line('landing_trending_right') != '') { echo stripslashes($this->lang->line('landing_trending_right')); } else echo "Trending right now"; ?></a></h1>-->
      <ul class="product_thumb">
      <?php 
      if(count($productDetails) > 0){

      	foreach($productDetails as $TotProduct){
      		$imgArr = array_filter(explode(',', $TotProduct->image));
      		$img = 'dummyProductImage.jpg';
      		if (count($imgArr)>0){
      			foreach ($imgArr as $imgVal){
      				if ($imgVal != ''){
      					if (file_exists('images/product/thumb/'.$imgVal)){
      						$img = $imgVal;
      						break;

      					}
      				}
      			}
      		}
      		if (isset($TotProduct->web_link)){
      			$prod_link = 'user/'.$TotProduct->user_name.'/things/'.$TotProduct->seller_product_id.'/'.url_title($TotProduct->product_name,'-');
      		}else {
      			$prod_link = 'things/'.$TotProduct->id.'/'.url_title($TotProduct->product_name,'-');
      		}
      		echo '<li><a href="'.$prod_link.'"><img src="images/product/thumb/'.$img.'" /></a></li>';
      	}
      }
	  ?>
        
      </ul>
      <span class="example12"></span>
      <div class="join_main"> <a class="joinnow_btn example10" href="javascript:void(0);"><?php if($this->lang->line('landing_join_now') != '') { echo stripslashes($this->lang->line('landing_join_now')); } else echo "Join Now"; ?></a> <span class="join_text"><?php if($this->lang->line('landing_juicy_prods') != '') { echo stripslashes($this->lang->line('landing_juicy_prods')); } else echo "to see more juicy products"; ?> </span> </div>
    </div>
  </div>
  <input type="hidden" value="emailinfoPopContent" id="emailinfoPopContent" />
</section>
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript">
		var baseURL = '<?php echo base_url();?>';
</script>
<script>
	$("#SignupForm").validate();
</script>
<!-- Section_end -->
<?php if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code')); } 
$this->load->view('site/templates/footer');
?>
