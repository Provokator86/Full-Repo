<?php
$this->load->view('site/templates/header');
?>
<script type="text/javascript">
  (function() {
   var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
   po.src = 'https://apis.google.com/js/client:plusone.js';
   var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
 })();
</script>
<section>
<div class="section_main" style="background:none;">
            
            	<div class="main2">
		
<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>

	<div id="content">
			<h1><b> <?php if($this->lang->line('onboarding_invite_friends') != '') { echo $this->lang->line('onboarding_invite_friends'); } else echo "Invite friends to";echo " ".$siteTitle;?>
			</b></h1><br>
			<h3><?php if($this->lang->line('invite_friends_tag') != '') { echo $this->lang->line('invite_friends_tag'); } else echo "Search services you use to invite friends to"; ?>
			<?php echo " ".$siteTitle;?>. 
			</h3>
			<div class="shop_text" style="width: 95%;">
				<div class="scroll">
					<div class="intxt">
						<dl class="sns-people">
							<dt>
								<i class="ic-fb"></i> <span><b><?php if($this->lang->line('signup_facebook') != '') { echo stripslashes($this->lang->line('signup_facebook')); } else echo "Facebook"; ?>
								</b> </span>
								<button class="btns-gray-embo facebook">
								<?php if($this->lang->line('invite_frds') != '') { echo stripslashes($this->lang->line('invite_frds')); } else echo "Invite friends"; ?>
								</button>
							</dt>
						</dl>
						<dl class="sns-people">
							<dt>
								<i class="ic-tw"></i> <span><b><?php if($this->lang->line('signup_twitter') != '') { echo stripslashes($this->lang->line('signup_twitter')); } else echo "Twitter"; ?>
								</b> </span>
								<!-- 					<button class="btns-gray-embo"><?php if($this->lang->line('onboarding_find_frds') != '') { echo stripslashes($this->lang->line('onboarding_find_frds')); } else echo "Find friends"; ?></button></dt> -->
								<button class="btns-gray-embo twitter btn_twitter">
								<?php if($this->lang->line('invite_frds') != '') { echo stripslashes($this->lang->line('invite_frds')); } else echo "Invite friends"; ?>
								</button>
							</dt>
						</dl>
						<!--				<dl class="sns-people">
					<dt><i class="ic-gg"></i> <span><b><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Google"; ?>+</b></span>
					<button class="close"><span class="tooltip"><small><b></b><?php if($this->lang->line('onboarding_close') != '') { echo stripslashes($this->lang->line('onboarding_close')); } else echo "Close"; ?></small></span></button>
					<button id="fancy-gplus-link" class="btns-gray-embo" data-gapiattached="true"><?php if($this->lang->line('onboarding_find_frds') != '') { echo stripslashes($this->lang->line('onboarding_find_frds')); } else echo "Invite friends"; ?></button></dt>
				</dl>
 -->
						<dl class="sns-people">
							<dt>
								<b><i class="ic-gg"></i> <span><b><?php if($this->lang->line('signup_google') != '') { echo stripslashes($this->lang->line('signup_google')); } else echo "Google"; ?>
									</b> </span> </b>
<!-- 								<button class="btns-gray-embo gmail">
								<?php if($this->lang->line('invite_frds') != '') { echo stripslashes($this->lang->line('invite_frds')); } else echo "Invite friends"; ?>
								</button>
 -->								<button class="btns-gray-embo g-interactivepost gmail"
								data-clientid="<?php echo $this->config->item("google_client_id");?>"
								data-contenturl="<?php echo base_url();?>"
								data-calltoactionlabel="INVITE"
								data-calltoactionurl="<?php echo base_url();?>"
								data-cookiepolicy="single_host_origin"
								data-prefilltext="Join me on <?php echo $siteTitle;?> and discover amazing things"
								>
								<?php if($this->lang->line('invite_frds') != '') { echo stripslashes($this->lang->line('invite_frds')); } else echo "Invite friends"; ?>
								</button>
							</dt>
						</dl>
							<dl class="sns-people">
							<dt>
								<b><i class="ic-gm"></i> <span><b><?php if($this->lang->line('onboarding_gmail') != '') { echo stripslashes($this->lang->line('onboarding_gmail')); } else echo "Gmail"; ?>
									</b> </span> </b>
								<button class="btns-gray-embo twitter btn_gmail">
								<?php if($this->lang->line('invite_frds') != '') { echo stripslashes($this->lang->line('invite_frds')); } else echo "Invite friends"; ?>
								</button>
							</dt>
						</dl>
						<p class="sns-notify">
						<?php if($this->lang->line('onboarding_choose_srvce') != '') { echo stripslashes($this->lang->line('onboarding_choose_srvce')); } else echo "Choosing a service will open a window for you to log in securely and invite your contacts to"; ?>
						<?php echo " ".$siteTitle;?>
							.
						</p>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</section>
<style>
<!--
.tit {
	position: relative;
	z-index: 2;
	color: #92959c;
	font-size: 13px;
	line-height: 22px;
	padding: 26px 20px 20px;
	border-bottom: 1px solid #ebecef;
}

.tit b {
	color: #393d4d;
	font-size: 18px;
}

.txt {
	position: relative;
	height: 400px;
	overflow: hidden;
	z-index: 1;
}

.txt .scroll {
	height: 100%;
	overflow: auto;
	margin-right: -7px;
	padding-right: 10px;
	overflow-x: hidden;
}

.intxt {
	position: relative;
	float: left;
	width: 100%;
}

.sns-people {
	border: 1px solid #d9dadb;
	border-bottom: 0;
	border-top-color: #ebecef;
	margin: 0 20px;
}

.sns-people:first-child {
	border-top-color: #d9dadb;
	border-radius: 3px 3px 0 0;
	margin-top: 20px;
}

.sns-people dt {
	position: relative;
	padding: 15px 17px;
	line-height: 40px;
}

.sns-people [class ^="ic-"] {
	background: url(images/site/onboarding.png) no-repeat;
	background-size: 430px 500px;
}

.sns-people [class ^="ic-"] {
	display: inline-block;
	width: 40px;
	height: 40px;
	border-radius: 3px;
	vertical-align: middle;
	margin-right: 7px;
}

.sns-people .ic-fb {
	background-position: -172px -313px;
	background-color: #526996;
}

.sns-people dt span {
	display: inline-block;
	line-height: 18px;
	vertical-align: middle;
	font-size: 13px;
	color: #92959c;
}

.sns-people dt span b {
	display: block;
	color: #393d4d;
}

button {
	cursor: pointer;
	vertical-align: middle;
}

.btns-gray-embo,a.btns-gray-embo {
	display: inline-block;
	text-shadow: 0 1px 0 #fff;
	color: #393d4d;
	font-weight: bold;
	padding: 0 13px;
	height: 30px;
	line-height: 28px;
	font-size: 13px;
	border: 1px solid #959595;
	border-color: #c1c1c1 rgb(180, 180, 180) rgb(163, 163, 163);
	box-shadow: inset 0 1px 0px rgb(252, 252, 252), 0 1px 1px
		rgba(0, 0, 0, 0.1);
	background: -webkit-linear-gradient(top, rgb(253, 253, 253), #f0f0f0 );
	background: -ms-linear-gradient(top, #fcfcfc, #f0f0f0);
	background: -moz-linear-gradient(top, #fcfcfc, #f0f0f0);
	background: -o-linear-gradient(top, #fcfcfc, #f0f0f0);
	filter: progid : DXImageTransform.Microsoft.gradient ( startColorstr =
		'#fcfcfc', endColorstr = '#f0f0f0' );
	border-radius: 3px;
}

.sns-people dt .btns-gray-embo {
	position: absolute;
	top: 50%;
	right: 15px;
	margin-top: -15px;
}

.sns-people .ic-tw {
	background-position: -212px -392px;
	background-color: #4bace2;
}

.sns-people .ic-gm {
	background-position: -253px -351px;
	background-color: #c0cdd2;
}
.sns-people .ic-gg {
	background-position: -213px -314px;
	background-color: #dd4b39;
}

.sns-notify {
	border: 1px solid #d9dadb;
	border-top-color: #ebecef;
	border-radius: 0 0 3px 3px;
	margin: 0 20px 20px;
	font-size: 12px;
	padding: 17px 18px;
	line-height: 16px;
	color: #92959c;
}
-->
</style>
<?php if ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off'){?>
<script src="http://connect.facebook.net/en_US/all.js"></script>
<?php }else {?>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<?php }?>
<script type="text/javascript">
FB.init({
	    appId:'<?php echo $this->config->item('facebook_app_id');?>',
	    cookie:true,
	    status:true,
	    xfbml:true,
		oauth : true
    });

$('button.facebook').click(function() {
	FB.ui({
	    method: 'apprequests',
	    message: 'Invites you to join on <?php echo $siteTitle;?> (<?php echo base_url();?>?ref=<?php echo $userDetails->row()->user_name;?>)'
	});
    });
/*****************************Twitter Login****************************/
	$('.btn_twitter').click(function(){
		var loc = "<?php echo base_url()?>";
		var param = {'location':loc};
		var popup = window.open(null, '_blank', 'height=400,width=800,left=250,top=100,resizable=yes', true);			
		$.post('<?php echo base_url()?>site/invitefriend/twitter_friends',param, 
			function(json){
				if (json.status_code==1) {
					popup.location.href = json.url;						
					}
				else if (json.status_code==0) {
					alert(json.message);
				}  
			},
			'json'
		);
	});
/*******************************End***********************************/
$('.btn_gmail').click(function() {
  var loc = location.protocol+'//'+location.host;
 var param = {'location':loc};
	var popup = window.open(null, '_blank', 'height=550,width=900,left=250,top=100,resizable=yes', true);
  var $btn = $(this);
	$.post(
		baseURL+'site/invitefriend/gmail_friends',
		param, 
		function(json){
			if (json.status_code==1) {
				popup.location.href = json.url;	
			}
			else if (json.status_code==0) {
				alert(json.message);
			}  
		},
		'json'
	);
});
</script>
		<?php
		$this->load->view('site/templates/footer');
		?>