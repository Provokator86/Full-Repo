<script>
function get_business_name(inputString) {
		var p = $("#search_for");
		var offset = p.offset();
		if(inputString.length>1) {	
			var search_category = $("#search_category").val();
			$.post("<?=base_url()?>search/auto_complete_business_name/" + search_category , {queryString: "" + inputString + ""}, function(data){
					if(data.length >0) {
					
						$('#suggestionsSearch').show();
						$('#autoSuggestionsListSearch').html(data);
						$('#suggestionsSearch').css('left',offset.left);
					}
					else
					{
						$('#suggestionsSearch').hide();
					}
				});
			}
			else
				$('#suggestionsSearch').hide();	
	} // lookup
	
	function business_fill(thisValue) {
		var b=new Array();
		b["&amp;"]="&";
		b["&quot;"]='"';
		b["&#039;"]="'";
		b["&lt;"]="<";
		b["&gt;"]=">";
		var r;
		for(var i in b){
			r=new RegExp(i,"g");
			thisValue = thisValue.replace(r,b[i]);
		}
		$('#search_for').val(thisValue);
		$('#suggestionsSearch').hide();
		
	}
</script>
<!--
<script src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>
-->
<div id="header" style="position: relative; z-index: 90">
	<div class="header_top"></div>
	<div class="header_mid">
		<div class="header_left">
			<a href="<?=base_url().'home'?>"><img src="<?=base_url()?>images/front/logo.png" alt="" /></a>
		</div>
		<div class="header_right">
			<div class="login">
				<?php if($this->session->userdata('user_id') != '') { ?>

				<a style="text-transform:uppercase;font-size:12px;" href="<?=base_url().'profile'?>">Your Account<!--Welcome <?=$this->session->userdata('user_username')?>--></a>&nbsp;&nbsp;  |   &nbsp;&nbsp;
				<a style="text-transform:uppercase;font-size:12px;" href="<?=base_url().'user/logout'?>">Signout</a>&nbsp;&nbsp;&nbsp;
				<a href="<?=base_url().'profile'?>" style="text-transform:uppercase;font-size:12px;">
					<?php if($this->session->userdata('user_img_name') != '') { ?>
					<img align="absmiddle" alt="" width="30" height="30" src="<?php echo $this->config->item('view_image_folder_user').$this->config->item('image_folder_thumb').$this->session->userdata('user_img_name')?>" />
					<?php } else { ?>
					<img align="absmiddle" alt="" width="30" height="30" src="<?=base_url().'images/front/img_04.jpg'?>" />
					<?php } ?>
				</a>

				<?php } else { ?>

				<a style="text-transform:uppercase; font-size:12px;" href="<?=base_url().'home/login'?>">login</a>&nbsp;&nbsp;  |   &nbsp;&nbsp;
				<a style="text-transform:uppercase;font-size:12px;" href="<?=base_url().'user'?>">Signup</a>&nbsp;&nbsp;&nbsp;
				<!--<a href="#"><img align="absmiddle" src="<?=base_url()?>images/front/face_book.png" alt="" /></a>-->
				<fb:login-button v="2"  onlogin="facebook_onlogin();" length="long" ><fb:intl>Login with Facebook</fb:intl></fb:login-button>
				
				<?php } ?>
			</div>
			<div class="search_box">
				<form action="<?=base_url().'search/search_post'?>" method="post" id="src_business" name="src_business">
					<div class="cell_01">
						<h1>Search for <span>(Kolkata Restaurants, Bars, Beauty Parlours, Gyms etc.)</span></h1>
						<div style="float: left;">
							<input type="text" id="search_for" name="search_for" value="<?php echo $search_for; ?>" onkeyup="get_business_name(this.value)" autocomplete="off" />&nbsp;
							IN&nbsp;
							<select name="search_category" id="search_category">
								<?php
								foreach($list_root_categories as $k => $v)
								{
									$tmp_search_selected = ($k == $search_category) ? ' selected="selected"' : '';
								?>
								<option value="<?php echo $k; ?>"<?php echo $tmp_search_selected; ?>><?php echo $v; ?></option>
								<?php } ?>
							</select>
							<div class="suggestionsBox" id="suggestionsSearch" style="display: none; position:absolute;">
							<img src="<?=base_url()?>images/front/upArrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
							 		<div class="suggestionList" id="autoSuggestionsListSearch">
&nbsp;								</div>
							</div>
							
						</div>
						
					</div>

					<?php /*?><div class="cell_02">
						<h1>In <span>(Address, Neighborhood, City, State or Zip)</span></h1>
						<input type="text" id="search_in" name="search_in" value="<?=$this->session->userdata('search_in')?>"/>
					</div><?php */?>
					
					<div class="cell_03">
						<?php /*<input type="hidden" name="search_category" id="search_category" value="<?=(isset($search_category ) && !empty($search_category)) ? $search_category : '0'?>" />*/?>
						<input class="button_02" type="submit" value="SEARCH >>" />
					</div>
					<div class="clear"></div>
				</form>
			</div>

			<div class="margin10"></div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="header_botm">
		<div class="botm_left">
			<div class="drop_down">
				<ul id="sddm">
					<li><a href="#" onmouseover="mopen('m1')" onmouseout="mclosetime()">Kolkata</a>
						<div id="m1" onmouseover="mcancelclosetime()" onmouseout="mclosetime()">
							<a href="#">Bengaluru - Coming Soon!</a>
							<a href="#">Delhi - Coming Soon!</a>
							<a href="#">Mumbai - Coming Soon!</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="botm_right">
			<form name="invite_frnd" action="<?=base_url().'home/send_frnd_invitation'?>" method="post">
				<div class="cell_04">Invite friends</div>
				<div class="cell_05">
					<input id="invited_email" type="text" name="invited_email" value='Friend’s Email Address' onclick="if(this.value=='Friend’s Email Address') document.getElementById('invited_email').value ='';" onblur="if(this.value=='') document.getElementById('invited_email').value ='Friend’s Email Address';" /></div>
				<div class="cell_06"><input id="source_name" type="text" name="source_name" value="Your Name" onclick="if(this.value=='Your Name') document.getElementById('source_name').value ='';" onblur="if(this.value=='') document.getElementById('source_name').value ='Your Name';" /></div>
				<div class="cell_07"><input class="button_02" type="submit" value="SUBMIT >>" /></div>
			</form>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<script type="text/javascript"> 
	FB.init("<?=$api_key?>", "/xd_receiver.htm");
	/*
	 FB.init({appId: '109132209139296', status: true,
	 cookie: true, xfbml: true});*/
	/*FB.Event.subscribe('auth.login', function(response) {
	   window.location.reload();
	 });*/
	/*function facebook_onlogin() {
	   FB.Connect.showPermissionDialog(
   "publish_stream,offline_access,photo_upload",
   permissionHandler,true);
   } */
	function facebook_onlogin() {
		FB.Connect.showPermissionDialog( "email,user_birthday,user_website",permissionHandler);
		//document.location.href=document.location.href;
	}
	/*	 function permissionHandler()
	  {
		   //document.location.href=document.location.href;
		   document.location.href = base_url + 'user/facebook_regular_user_signup/2';
	  }*/
	function permissionHandler()
	{
		//document.location.href=document.location.href;
		//document.location.href = base_url+'user/facebook_login';
		document.location.href = base_url + 'user/facebook_regular_user_signup/2';
	}
</script>		  

<?php
/* 
loader path: 
<img src="' + base_url + 'images/front/ajax-loader.gif" alt=""/>
*/ 
?>