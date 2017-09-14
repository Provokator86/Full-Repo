<?php
$current_url =  str_replace('=','',base64_encode(base_url().substr(uri_string(),1)));

if(isset($_COOKIE['User']) && isset($_COOKIE['pass']))
{	
	$user_name	=	$_COOKIE['User'];
	$password	=	$_COOKIE['pass'];
	$checked	=	'checked="checked"';
}
else
{	
	$user_name	=	addslashes(t('Username'));
	$password	=	addslashes(t('Password'));
	$checked	=	'';
}

/* set the value for search for job and service */
if($srch_str!='' && $srch_type!='')
{
$search_str  = $srch_str;
$seacrh_type = $srch_type;
}
else
{
$search_str  = addslashes(t('Ex.plumber , parpenter , painter ....'));
$seacrh_type = addslashes(t('job'));
}
/* end set the value for search for job and service */
 ?>
<script type="text/javascript">

function blink_continue()
{
	$("#blink_msg").animate({
	top:"0px"},2000).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100).fadeOut(100).fadeIn(100);
}
setInterval("blink_continue()", 1000);


function submit_form()
{
	var s_type = $("#job_select option:selected").val();
	if(s_type=='job')
	{
	var job_srch = '<?php echo base_url().'job/find-job' ?>';	
	$("#quick_search").attr("action",job_srch);
	$("#quick_search").submit();
	}
	else if(s_type=='service')
	{
	var trade_srch = '<?php echo base_url().'find-tradesman' ?>';	
	$("#quick_search").attr("action",trade_srch);
	$("#quick_search").submit();
	}
}
</script>
<div class="top_part">
	
	  <div class=" spacer"></div>
    <div id="logo"><a href="<?php echo base_url() ?>"><img src="images/fe/logo.png" alt="" /></a></div>
    <div class="right_part">
    <div class="flag">
	 
      <a href="<?php echo base_url().'home/change_lang/'.encrypt(1).'/'.$current_url ?>"><img src="images/fe/english.png" alt="" onmouseover="this.src='images/fe/english-hover.png'" onmouseout="this.src='images/fe/english.png'" /></a>
      <a href="<?php echo base_url().'home/change_lang/'.encrypt(2).'/'.$current_url ?>"><img src="images/fe/turkey.png" alt="" onmouseover="this.src='images/fe/turkey-hover.png'" onmouseout="this.src='images/fe/turkey.png'" /></a>
      
	 
      </div>
					 <!--start  header_top.tpl.php -->
                  <div class="signin">
                        <ul>
							<?php if(empty($loggedin)) { ?>
                              <li><a href="javascript:void(0);" id="signin"><?php echo addslashes(t('login'))?></a></li>
                              <li>|</li>
                              <li><a href="javascript:void(0);" onclick="show_dialog('photo_zoom')"><?php echo addslashes(t('sign up'))?></a></li>
							<?php } else {  ?>  
							  <li><?php echo addslashes(t('welcome'))?> <?php echo $loggedin['user_name']?></li>
                              <li>|</li>
							  <li><a href="<?php echo base_url().'user/dashboard'?>"><?php echo addslashes(t('dashboard'))?></a>
							  <?php if($i_new_message || $tot_new_quotes) { ?> (<span id="blink_msg"><?php echo ($i_new_message+$tot_new_quotes) ?></span>) <?php } ?>
							  </li>
                              <li>|</li>
                              <li><a href="<?php echo base_url().'user/logout'?>"><?php echo addslashes(t('signout'))?></a></li>
							 <?php } ?> 
                        </ul>
                        <div id="signin_menu">
            <div class="signin_menu_content">
				<form name="login_form" action="<?php echo base_url().'user/login/TVNOaFkzVT0'?>" method="post">
			
                  <input id="usrname" name="txt_user_name" type="text"  value="<?php echo $user_name?>"  size="35"  onclick="if(this.value=='<?php echo addslashes($user_name)?>') document.getElementById('usrname').value ='';" onblur="if(this.value=='') document.getElementById('usrname').value ='<?php echo addslashes($user_name)?>';" autocomplete="off" />
                 
				  <input id="pswrd" name="txt_password" type="password"  value="<?php echo $password?>" size="35" onclick="if(this.value=='<?php echo $password?>') document.getElementById('pswrd').value ='';" onblur="if(this.value=='') document.getElementById('pswrd').value ='<?php echo $password?>';" autocomplete="off" />
				 
                  <a href="<?php echo base_url().'forget-password'?>"><?php echo addslashes(t('Forgot your password'))?>?</a>
			  <div class="login_btn">
					<div class="left">
					<div class="text_box">
					<input name="remember_me" type="checkbox" value="1" <?php echo $checked?>/>                             
						  <?php echo addslashes(t('Keep me logged in'))?>  </div>
					<input name="login_btn" type="submit" value="<?php echo addslashes(t('Login'))?>"  class="login_button"/>
					</div>
					
					<div class="spacer"></div>
			  </div>
			</form>  
		</div>
      </div>
                  </div>
				  <!--end header_top.tpl.php -->
				  
                  <div class="spacer"></div>
                  <div class="spacer"></div>
				  <form name="quick_search" id="quick_search" action="" method="post">
                  <div class="search_bg">
                        <input type="button" id="btn_src" class="search_button" onclick="submit_form()" value="" />
                        <div class="job">
					  <select name="job_select" id="job_select" style="width:86px;" class="job">
						<option <?php if($seacrh_type=='job') { echo 'selected="selected"';} ?> value="job"><?php echo addslashes(t('Job'))?></option>
						<option <?php if($seacrh_type=='service') { echo 'selected="selected"';} ?> value="service"><?php echo addslashes(t('Service'))?></option>
					  </select>
                              <script type="text/javascript">
						$(document).ready(function() {
						  $("#job_select").msDropDown();
						   $("#job_select").hide();
						   $('#job_select_msdd').css("background-image", "url(images/fe/select-bg.png)");
						   $('#job_select_msdd').css("background-repeat", "no-repeat");
						   $('#job_select_msdd').css("width", "86px");
						   //$('#job_select_msdd').css("margin-top", "0px");
						   //$('#job_select_msdd').css("padding", "0px");
						   //$('#job_select_msdd').css("padding-left", "10px");
						});
					
					</script>
                        </div>
                        <div class="search_box">
                              <input type="text" onblur="if(this.value=='') document.getElementById('txt_fulltext_src')
.value ='<?php echo $search_str ?>';" onclick="if(this.value=='<?php echo $search_str ?>')
 document.getElementById('txt_fulltext_src').value ='';" size="35" value="<?php echo $search_str ?>" name="txt_fulltext_src" id="txt_fulltext_src" />
                        </div>
                  </div>
				  </form>
                  <div class="spacer"></div>
                  <!--nav-->
                  <div class="nav">
                        <div class="nav_left"></div>
                        <div class="nav_midd">
                              <div id="myjquerymenu" class="jquerycssmenu">
                                    <ul>
                                          <li class="#"><a href="javascript:void(0);"><?php echo addslashes(t('I have a job to be done'))?><img src="images/fe/arrow.png" alt="" /></a>
                                                <ul>
                                                      <li><a href="<?php echo base_url().'job/job-post' ?>" ><?php echo addslashes(t('Post your job'))?>! </a> </li>
                                                        <li><a href="<?php echo base_url().'find-tradesman' ?>"><?php echo addslashes(t('Tradesmen by category'))?></a></li>
                                                      <li><a href="<?php echo base_url().'find-best-tradesman' ?>"><?php echo addslashes(t('How to find the best tradesmen'))?></a></li>
                                                </ul>
                                          </li>
                                          <li class="dvi"></li>
                                          <li><a href="javascript:void(0);" ><?php echo addslashes(t('I am a tradesmen'))?> <img src="images/fe/arrow.png" alt="" /></a>
                                                <ul>
                                                      <li><a href="<?php echo base_url().'job/find-job' ?>" ><?php echo addslashes(t('New added jobs '))?></a> </li>
                                                      <li><a href="<?php echo base_url().'job/find-job' ?>"><?php echo addslashes(t('Jobs by category'))?> </a></li>  <li><a href="<?php echo base_url().'find-customer' ?>"><?php echo addslashes(t('How am i gonna find customer'))?> ?</a></li>
                                                      <li><a href="<?php echo base_url().'articles' ?>"><?php echo addslashes(t('Read Articles'))?></a></li>
                                                </ul>
                                          </li>
                                          <li class="dvi"></li>
                                          <li><a href="javascript:void(0);" ><?php echo addslashes(t('Support'))?> <img src="images/fe/arrow.png" alt="" /></a>
                                                <ul>
                                                      <li><a href="<?php echo base_url().'contact-us' ?>" class="last" ><?php echo addslashes(t('Ask Us'))?></a> </li>
                                                      <li><a href="<?php echo base_url().'terms-condition' ?>" class="last"><?php echo addslashes(t('Terms &amp; Conditions'))?></a></li>
                                                      <li><a href="<?php echo base_url().'help' ?>" class="last"><?php echo addslashes(t('Help'))?></a></li>
                                                      <li><a href="<?php echo base_url().'about-us' ?>" class="last"><?php echo addslashes(t('Legal Agreement'))?></a></li>
                                                </ul>
                                          </li>
                                    </ul>
                              </div>
                        </div>
                        <div class="nav_right"></div>
                  </div>
                  <!--nav-->
            </div>
  </div>
  
<script type="text/javascript">
$(document).ready(function() {
	$("#btn_submit").click(function(){
	
		var user_type = $("input[name=btn_radio]:checked").val();
		if(user_type==1)
		{
		window.location.href = "<?php echo base_url().'user/registration/'.encrypt(1) ?>";
		}
		else
		{
		window.location.href = "<?php echo base_url().'user/registration/'.encrypt(2) ?>";
		}
	});
});
</script>
<!--lightbox-->
<div class="lightbox02 photo_zoom"> 
<div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
    <h3><?php echo addslashes(t('Register'))?> </h3>
    <p><?php echo addslashes(t('How do you like to choose to use hizmetuzmani'))?></p>
    
    <div class="inner_box">
    <div class="box01"><input name="btn_radio" type="radio" value="1" /><?php echo addslashes(t('Buyer Registration'))?></div>
    <div class="box01 marginright"><input name="btn_radio" type="radio" value="2" checked="checked" /><?php echo addslashes(t('Tradesman Registration'))?></div>
    <div class="spacer"></div>
    </div>
    <input  class="small_button marginleft" value="<?php echo addslashes(t('Submit'))?>" type="button" id="btn_submit"/>
</div>
<!--lightbox-->