<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<base href="<?php echo base_url(); ?>" />
<script type="text/javascript">
var base_url    =   "<?php echo base_url(); ?>";
</script>
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
<title>Fo Sho Time</title>
<link rel="stylesheet" type="text/css" href="css/fe/style.css" />

<script type="text/javascript" src="js/fe/jquery-1.8.0.js"></script>

<style>

.intro-banner {
height: 550px;
position: absolute;
bottom: 0px;
width: 620px;
}
#left_float_patch{
	width: 380px;
	position: absolute;
	top: 191px;
}
</style>
<script type="text/javascript">
	var winx='';
	var winy='';
	$(window).resize(function(){
		winx=$(window).width();
		winy=$(window).height();
		$('.grey_texture_new').css('min-height',winy);
		if(winy<=576){
			var winy = 567;
			$('.intro-maincontainer .container').css('height',winy-2);
			$('#left_float_patch').css('top',winy-410+'px');
			return;
		}
		//$('.intro-maincontainer .container').css('height',winy-2);
		//$('#left_float_patch').css('top',winy-462+'px');
		$('.intro-maincontainer .container').css('height',winy-2);
		$('#left_float_patch').css('top',winy-410+'px');
	
	});

</script>
<script type="text/javascript" src="js/fe/script.js"></script>
<link rel="stylesheet" type="text/css" href="css/fe/jquery-ui.css" />
<script type="text/javascript" src="js/fe/jquery-ui.js"></script>
<script type="text/javascript" src="js/fe/jquery-ui-autocomplete.js"></script>
<script type="text/javascript" src="shadowbox/shadowbox.js"></script>
<!-- paint js and css -->
<script type="text/javascript" src="js/admin/jquery.stringify.js"></script>
<link rel="stylesheet" href="paint/font/paint.css" type="text/css" charset="utf-8" />
<script type="text/javascript" src="paint/js/paint.js"></script>
<script type="text/javascript" src="paint/js/page_template.js"></script>
<script type="text/javascript" src="paint/js/book.js"></script>
<!-- paint js and css -->

<link type="text/css" href="css/fe/jquery.jscrollpane.css" rel="stylesheet"  />
<script src="js/fe/jquery.mousewheel.js" type="text/javascript"></script>
<script type="text/javascript" src="js/fe/jquery.jscrollpane.js"></script>
<script src="js/fe/jquery.customform.js" type="text/javascript"></script>

<link rel="stylesheet" type="text/css" href="css/fe/dd.css" />
<script type="text/javascript" src="js/fe/jquery.dd.js"></script>
<script type="text/javascript" src="js/fe/lazy_loading_pagination.js"></script>

<script type="text/javascript" src="js/fe/hexcolorcode.js"></script>
</head>
<body>
<?php  if($show_curl) {	?>
<?php  //if(true) {	?>
<img style="display:none" src="images/fe/intro-bg-less_new.png">
<img style="display:none" src="images/fe/intro-bg_new.png">
<?php } ?>

<div class="maincontainer curl_background"
<?php  if($show_curl) {	?>
<?php  //if(true) {	?>
		 style="display:none;"
	<?php } ?>

>
	<div class="gray_texture">
	


	<?php if($category_menu_available) { ?> 
    <div class="shadow-bg">
	<?php } ?>
    
      <div class="container">
        <!--left container part-->
     <?php include_once(APPPATH."views/fe/common/left_container.tpl.php"); ?>
       <!--left container part-->
            <div class="right-container <?php if($category_menu_available) { ?> right-container2 <?php } ?>">
                  <?php include_once(APPPATH."views/fe/common/header.tpl.php"); ?>
                  <?php if(!$category_menu_available) { ?><?php echo $content ?> <?php } ?>
            </div>
             <?php if($category_menu_available) { ?><?php echo $content ?> <?php } ?>
            <div class="clear"></div>
      </div>
      
      
      
       <!--footer link part-->
     <?php include_once(APPPATH."views/fe/common/footer.tpl.php"); ?>
      <!--footer link part-->
      
      
      <?php if($category_menu_available) { ?> </div><?php } ?>
    </div>  
</div>










<script type="text/javascript">


function showRoatedCanvas(obj,obj_param)
{
					//obj.child_obj.css({width:obj.child_obj.obj_param.width+'px',height:obj.child_obj.obj_param.height+'px'});
		
					
					var Dx = 0;
					var Dy = 0;
					var rad,degree;
			
					if(obj_param.angle!=0)
					{
						rad = obj_param.angle* (Math.PI / 180);
						degree = obj_param.angle;
						if ($.browser.msie  && parseInt($.browser.version, 10) <9 )
						{
							var COS_THETA = Math.cos(rad);
							var SIN_THETA = Math.sin(rad);
							
							////////////////////////////////////////////
							/*
							http://www.wiliam.com.au/wiliam-blog/sydney-web-design-rotating-html-elements-by-an-arbitrary-amount-cross-browser
							*/
							var ew = obj_param.width, eh = obj_param.height;
							var x1 = -ew / 2,
								x2 =  ew / 2,
								x3 =  ew / 2,
								x4 = -ew / 2,
								y1 =  eh / 2,
								y2 =  eh / 2,
								y3 = -eh / 2,
								y4 = -eh / 2;
			
							var x11 =  x1 * COS_THETA + y1 * SIN_THETA,
								y11 = -x1 * SIN_THETA + y1 * COS_THETA,
								x21 =  x2 * COS_THETA + y2 * SIN_THETA,
								y21 = -x2 * SIN_THETA + y2 * COS_THETA,
								x31 =  x3 * COS_THETA + y3 * SIN_THETA,
								y31 = -x3 * SIN_THETA + y3 * COS_THETA,
								x41 =  x4 * COS_THETA + y4 * SIN_THETA,
								y41 = -x4 * SIN_THETA + y4 * COS_THETA;
			
							var x_min = Math.min(x11, x21, x31, x41) + ew / 2,
								x_max = Math.max(x11, x21, x31, x41) + ew / 2;
			
							var y_min = Math.min(y11, y21, y31, y41) + eh / 2;
								y_max = Math.max(y11, y21, y31, y41) + eh / 2;
								
							Dx = x_min;
							Dy = y_min;
							////////////////////////////////////////////
						
							//obj_param.cx = (obj_param.cx+Dx);
							//obj_param.cy = (obj_param.cy+Dy);
							obj_param.Dx = Dx;
							obj_param.Dy = Dy;
							
							
						}
						
					}
			
			
					obj_param.left = (obj_param.cx + Dx - obj_param.width/2);
					obj_param.top = (obj_param.cy + Dy - obj_param.height/2);
					obj.css({width:obj_param.width+'px',height:obj_param.height+'px',left:obj_param.left+'px',top:obj_param.top+'px'/*,position:'absolute'*/});
					
					
					if(obj_param.angle!=0)
					{
						if ($.browser.msie  && parseInt($.browser.version, 10) <9 )
						{
							obj.css({	'filter':"progid:DXImageTransform.Microsoft.Matrix(M11 = "+COS_THETA+", M12 = "+(-SIN_THETA)+", M21 = "+SIN_THETA+", M22 = "+COS_THETA+",	sizingMethod = 'auto expand')"});
							obj.css({	'-ms-filter':"progid:DXImageTransform.Microsoft.Matrix(M11 = "+COS_THETA+", M12 = "+(-SIN_THETA)+", M21 = "+SIN_THETA+", M22 = "+COS_THETA+",	SizingMethod  = 'auto expand')"});
						}
						else
						{
							obj.css({'transform': 'rotate('+degree+'deg)'});    
							obj.css({'-ms-transform': 'rotate('+degree+'deg)'});    /* IE 9 */
							obj.css({'-moz-transform': 'rotate('+degree+'deg)'});    /* Firefox */
							obj.css({'-webkit-transform': 'rotate('+degree+'deg)'}); /* Safari and Chrome */
							obj.css({'-o-transform': 'rotate('+degree+'deg)'});      /* Opera */
						}
					}
					
}


$(document).ready(function(){
	//$('.curl_background').css({display:'none'});
	//setTimeout('init_curl();',5000);
	$('.see_the_world_on_intro, .login_on_intro, .join_on_intro, .explore_on_intro').live('click',function(){
		if($(this).attr('class').indexOf('login_on_intro')>-1 || $(this).attr('class').indexOf('join_on_intro')>-1)
		{
			init_curl('open_login');
		}
		<?php /*?>else if($(this).attr('class').indexOf('join_on_intro')>-1)
		{
			init_curl('open_join');
		}<?php */?>
		else
		{
			init_curl('');
		}
	});
});

function init_curl(arg)
{
	var win_width = $(document).width()+10;
	var win_height = $(document).height()-5;

	var curl_static_screen = $('.curl_static_screen');
	var curl_background = $('.curl_background');
	var curl_image = $('.curl_image');
	var curl_content = $('.curl_content');
	var curl_moving_screen = $('.curl_moving_screen');
	var curl_moving_screen_inner = $('.curl_moving_screen_inner');
	
	curl_static_screen.css({display:'block'});
	curl_background.css({display:'block'});
	curl_moving_screen_inner.html(curl_content.html());
	curl_content.html('');
	curl_content.css({display:'none'});
	
	
	
	curl_static_screen.css({left:'0px', top:'0px', width:win_width+'px', height:win_height+'px'});
	
	//curl_moving_screen.css({});
	var curl_moving_screen_width = win_width*1.25;
	var curl_moving_screen_height = win_height*2.5;
	
	curl_image.css({width:'600px',left:(curl_moving_screen_width-600*win_height/win_width)/2+'px',top:'-10px'});
	
	
	showRoatedCanvas(curl_moving_screen,{
											angle:45,
											cx:win_width/2,
											cy:win_height/2,
											width:curl_moving_screen_width,
											height:curl_moving_screen_height
										});
	
	var curl_moving_screen_inner_width = win_width;
	var curl_moving_screen_inner_height = win_height;
	showRoatedCanvas(curl_moving_screen_inner,{
											angle:360-45,
											cx:curl_moving_screen_width/2,
											cy:curl_moving_screen_height/2,
											width:curl_moving_screen_inner_width,
											height:curl_moving_screen_inner_height
										});
	curl_moving_screen_inner.css({backgroundColor:'black'});
	
	var curl_moving_screen_min_x = -win_width;
	var curl_moving_screen_max_y = win_height;
	
	var curl_moving_screen_x_delta_shift = -200;
	var curl_moving_screen_y_delta_shift = 200;
	
	if ($.browser.msie  && parseInt($.browser.version, 10) <9 )
	{
		curl_moving_screen_x_delta_shift = -2000;
		curl_moving_screen_y_delta_shift = 2000;
	}
	
	function move_curl()
	{
		var curl_image_width = curl_image.width()*1.04;
		curl_image.css({width:curl_image_width+'px',left:(curl_moving_screen_width-curl_image_width*win_height/win_width*0.9)/2+'px',top:'-10px'});
	
		var left = parseInt(curl_moving_screen.css('left'));
		var top = parseInt(curl_moving_screen.css('top'));
	
		if(
			left+curl_moving_screen_x_delta_shift>curl_moving_screen_min_x && 
			top+curl_moving_screen_y_delta_shift<curl_moving_screen_max_y
		)
		{
			left+=curl_moving_screen_x_delta_shift;
			top+=curl_moving_screen_y_delta_shift;
			curl_moving_screen.css({left:left+'px',top:top+'px'});
			
			//console.log('>'+top+','+left);
			
			var left_inner = parseInt(curl_moving_screen_inner.css('left'));
			var top_inner = parseInt(curl_moving_screen_inner.css('top'));
			
			var rad = (360-45)* (Math.PI / 180);
			
			
			
			left_inner-=curl_moving_screen_x_delta_shift*Math.cos(rad)-curl_moving_screen_y_delta_shift*Math.sin(rad);
			top_inner-=curl_moving_screen_x_delta_shift*Math.sin(rad)+curl_moving_screen_y_delta_shift*Math.cos(rad);
			
			
			
			//left_inner-= curl_moving_screen_x_delta_shift/2.5;
			//top_inner-=curl_moving_screen_y_delta_shift*1.1;
			
			//console.log(top_inner+','+left_inner);
			
			
			curl_moving_screen_inner.css({left:left_inner+'px',top:top_inner+'px'});
			
			setTimeout(function(){
				move_curl();
			},10);
		}
		else
		{
			curl_static_screen.css({display:'none'});
			//alert(1);
			if(typeof curl_done == 'function')
				curl_done(arg);
		}	

		if(curl_moving_screen_x_delta_shift==-200)
		{
			curl_moving_screen_x_delta_shift = -20;
			curl_moving_screen_y_delta_shift = 20*win_height/win_width*0.6;
			
		}
		else
		{
			curl_moving_screen_x_delta_shift*=1.1;
			curl_moving_screen_y_delta_shift*=1.1;
		}

	}
	
	move_curl();
}

var curl_done_flag = true;
function curl_done(arg)
{
	
	$.ajax({
			type: "POST",
			async: true,
			url: base_url+'home/curl_done',
			data: '',
			success: function(msg){
				
			}
   });
	if(arg=='open_login')
	{
		curl_done_flag = true;
		$("#login").click();
	}
	else if(arg=='open_join')
	{
		location.href = base_url+'user/registration';
	}
	else
	{
		curl_done_flag = true;
	}
}
	
</script>

<div class="curl_static_screen" style="display:none; overflow:hidden; position:absolute;z-index:30000000;width:0px; height:0px; border:0px blue solid;">
	<div class="curl_moving_screen" style="overflow:hidden;position:absolute; z-index:30000200;  border:0px red solid; background-color:#000000;">
		<img class="curl_image" src="images/curl2.png" style="position:absolute; z-index:30000400;">
		<div class="curl_moving_screen_inner" style="position:absolute; z-index:30000300;  border:0px black solid;"></div>
	</div>
</div>

<?php if($show_curl) {	?>
<script type="text/javascript">
	curl_done_flag = false;
</script>
<div class="curl_content">
<!-- ------------------------------------ -->
<div class="grey_texture_new">
<ul class="menu-link" id="menu_link">
      <li><a href="javascript:void(0);" class="explore_on_intro">Explore</a></li>
      <li>|</li>
      <li><a href="javascript:void(0);" id="intrologin" class="login_on_intro">Login</a> / <a href="javascript:void(0);" class="join_on_intro">Join</a></li>
</ul>
<div class="intro-maincontainer">
      <div class="container">
            <div class="intro-left-container">
                  <h1 class="logo"><a href="#"><img src="images/fe/logo.png"  alt=""/></a></h1>
                  <div id="left_float_patch">
                  <h2>Lorem ipsum <strong>dolor</strong> sit amet, <span>consectetuer <strong>adipiscing</strong> elit, sed diam</span> </h2>
                  <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut 
                        laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation </p>
                  <div class="seetheworld-btn-tab"> <a href="javascript:void()" class="see_the_world_on_intro">See the world</a> </div>
            	</div>
            </div>
            <div class="intro-right-container">
                  <!--<ul class="menu-link" id="menu_link">
                        <li><a href="#">About</a></li>
                        <li>|</li>
                          <li><a href="javascript:void(0);" id="login">Login</a> / <a href="registration.html">Join</a></li>
                  </ul>-->
                  <div class="intro-banner">
                        <ul>
                              <li class="intro-cotation01"><img src="images/fe/book1.png" alt="" /></li>
                              <li class="intro-cotation02"><img src="images/fe/book2.png" alt="" /></li>
                              <li class="intro-cotation03"><img src="images/fe/book3.png" alt="" /></li>
                              <li class="intro-cotation04"><img src="images/fe/book4.png" alt="" /></li>
                        </ul>
                  </div>
            </div>
            <div class="clear"></div>
      </div>
	  
      <!--<div id="loginDiv" class="lightbox">
            <div class="lightbox-content login-content">
                  <h2><img alt="" src="images/fe/login.png"> Login </h2>
                  <div class="form-block">
                        <div class="sting-input-tab">
                              <input type="text" class="input-val" value="Email / Username*">
                              <span class="error-msg">Please enter valid Email Address</span> </div>
                        <div class="sting-input-tab">
                              <input type="password" class="input-val" value="Password*">
                        </div>
                        <div class="float-left">
                              <input name="" type="checkbox" value="">
                              Remember me <a href="javascript:void(0);">Forget Password</a></div>
                        <div class="float-right">New user <a href="registration.html">Register Now</a></div>
                        <div class="clear"></div>
                        <br/>
                        <input type="button" onClick="window.location.href='category.html'" value="Login" class="submit-btn">
                  </div>
            </div>
      </div>-->
</div>
</div>
<!-- ------------------------------------ -->
</div>


<script type="text/javascript">

$(document).ready(function(){

	<?php /*?>$('.intro-maincontainer').css({background:'url("images/fe/intro-bg-less.jpg") no-repeat scroll right top transparent'});
	$('.intro-maincontainer').mousemove(function(evnt){
	
		var win_width = $(window).width();
		var win_height = $(window).height();
		
		if( win_width*0.85 <= evnt.pageX && evnt.pageX <= win_width 
			&&
			0 <= evnt.pageY && evnt.pageY <= win_height*0.15
		)
			$('.intro-maincontainer').css({background:'url("images/fe/intro-bg.jpg") no-repeat scroll right top transparent'});
		else
			$('.intro-maincontainer').css({background:'url("images/fe/intro-bg-less.jpg") no-repeat scroll right top transparent'});
	});<?php */?>
	
	$('.intro-maincontainer').css({background:'url("images/fe/intro-bg-less_new.png") no-repeat scroll right top transparent'});
	$('.intro-maincontainer').mousemove(function(evnt){
	
		var win_width = $(window).width();
		var win_height = $(window).height();
		
		if( win_width*0.85 <= evnt.pageX && evnt.pageX <= win_width 
			&&
			0 <= evnt.pageY && evnt.pageY <= win_height*0.15
		)
			$('.intro-maincontainer').css({background:'url("images/fe/intro-bg_new.png") no-repeat scroll right top transparent'});
		else
			$('.intro-maincontainer').css({background:'url("images/fe/intro-bg-less_new.png") no-repeat scroll right top transparent'});
	});
	
	
	
	
	
	$('.intro-maincontainer').mouseup(function(evnt){
	
		var win_width = $(window).width();
		var win_height = $(window).height();
		
		if( win_width*0.85 <= evnt.pageX && evnt.pageX <= win_width 
			&&
			0 <= evnt.pageY && evnt.pageY <= win_height*0.15
		)
		init_curl('');
	});

});

</script>
<?php } ?>




</body>
</html>
