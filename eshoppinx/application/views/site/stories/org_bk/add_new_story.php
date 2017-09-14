<?php 
$this->load->view('site/templates/header');
$this->load->view('site/templates/popup_product_detail.php');
?>
 <!-- Section_start -->
 <script src="http://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript">
function showView(val){
	if($('#showlist'+val).css('display')=='block'){
		$('#showlist'+val).hide();	
	}else{
		$('#showlist'+val).show();
	}	
}
function load_collection_products(cid){
	$('.stories-new-saves').html('Loading...');
	if(cid != ''){
		$.ajax({
			type:'post',
			url:baseURL+'site/stories/get_collection_products',
			data:{cid:cid},
			dataType:'json',
			success:function(json){
				$('.stories-new-saves').html(json.content);
			},
			complete:function(){
				$('#showlist2').hide();	
			}
		});
	}
}
function select_product(evt){
	var pid = $(evt).data('pid');
	var curDiv = $(evt).find('span');
	var pcount = $('.stories-new-form').data('pcount');
	if(pcount>8){
		alert('9 products already added');
	}else{
		if(curDiv.hasClass('selector-active')){
			curDiv.removeClass('selector-active');
			$('.stories-new-form-reorder-products').find('.imgCnt'+pid).remove();
			pcount--;
			if(pcount<0)pcount=0;
		}else{
			curDiv.addClass('selector-active');
			var imgCnt = $(evt).html();
			$('.stories-new-form-reorder-products').append('<div style="float:left;margin:5px;position:relative;" class="imgCnt'+pid+' imgCntCon" data-pid="'+pid+'"><input type="hidden" name="story_pid[]" value="'+pid+'"><a href="javascript:removeImgCnt(\''+pid+'\');" style="float:right;position:absolute;top:5px;right:5px;color:#000;font-weight:bold;">X</a>'+imgCnt+'</div>');
			pcount++;
			if(pcount<0)pcount=0;
		}
		$('.stories-new-form').data('pcount',pcount);
		if(pcount>8){
			$('.stories-new-product-add').hide();
		}
	}
}

function fb_social(evt){
	var f_id = '<?php echo $userDetails->row()->facebook ?>';
	if(f_id == ''){
		FB.init({
			appId:'<?php echo $this->config->item('facebook_app_id');?>',
			cookie:true,
			status:true,
			xfbml:true,
			oauth : true
		});
		FB.login(function(response){
			if(response.authResponse){
				FB.api('/me', function(response){
					url = baseURL+'site/stories/get_facebook_id';
					$.post(url,{'fb_id':response.id},function(data){
						if(data ==1){
							alert("This facebook Account already Exists."); 
						}else{
							var curDiv = $(evt).find('span');
							var curIpt = $(evt).find('input');
							if(curDiv.hasClass('selector-active')){
								curDiv.removeClass('selector-active');
								curIpt.val('false');
							}else{
								curDiv.addClass('selector-active');
								curIpt.val('true');
							}
						}
					}); 
				});
			}else{
				alert('User cancelled login or did not fully authorize.');
			}
		});
	}else{
		var curDiv = $(evt).find('span');
		var curIpt = $(evt).find('input');
		if(curDiv.hasClass('selector-active')){
			curDiv.removeClass('selector-active');
			curIpt.val('false');
		}else{
			curDiv.addClass('selector-active');
			curIpt.val('true');
		}
	}
}
function twitter_social(evt){
    
	var twitter_id = '<?php echo $userDetails->row()->twitter ?>';
	if(twitter_id==''){
		var loc = baseURL;
		var param = {'location':loc};
		var popup = window.open('about:blank','_blank', 'height=300,width=800,left=250,top=100,resizable=yes', true);
			$.post(
				baseURL+'site/stories/connect_twitter',
				param, 
				function(json){
					if (json.status_code==1){
						popup.location.href = json.url;						
					}
					else if (json.status_code==0){
						alert(json.message);
					}   
				},
				'json'
			);
	}else{
		var curDiv = $(evt).find('span');
		var curIpt = $(evt).find('input');
		if(curDiv.hasClass('selector-active')){
			curDiv.removeClass('selector-active');
			curIpt.val('false');
		}else{
			curDiv.addClass('selector-active');
			curIpt.val('true');
		}
	}
}
function removeImgCnt(pid){
	var pcount = $('.stories-new-form').data('pcount');
	$('.stories-new-form-reorder-products').find('.imgCnt'+pid).remove();
	pcount--;
	if(pcount<0)pcount=0;
	$('.stories-new-form').data('pcount',pcount);
	if(pcount<9){
		$('.stories-new-product-add').show();
	}
}
function story_validate(){
var description = document.getElementById("story_body").value;
	if(description==''){
		alert("Please say something about description");
		return false;
	}
}
</script>
<style>
.stories-new-form .stories-new-share .facebook a, .stories-new-form .stories-new-share .twitter a, .stories-new-form .stories-new-share .pinterest a { 
	background:none!important;
}
.stories-new-form .stories-new-share .facebook {
	border-right: medium none;
	width: 190px;
	background: url(images/fb-img.png) no-repeat 10%;
	text-indent: 30px;
}
.stories-new-form .stories-new-share .twitter  {
	
	width: 190px;
	background: url(images/tw-img.png) no-repeat 10%;
	text-indent: 30px;
}

.stories-new-form .stories-new-form-submit input.button.large { 
	background:url( images/plus-white.png) no-repeat #0097D8 35%;
}

</style>

     	<section>
        
        	<div class="section_main" style="background:#FFF">
            
            	<div class="main1">
                <?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
<div class="left_side">                   
	<div id="outer" class="container push-body" style="margin-top: 50px;">
		<div id="inner">
		<div class="stories-new-container">
		<div class="stories-new-header">
		<h2><?php if($this->lang->line('add_a_storyboard') != '') { echo stripslashes($this->lang->line('add_a_storyboard')); } else echo "Add a Storyboard"; ?></h2>
		</div>
		<div class="stories-new-form" data-pcount="0">
		<form method="post" id="new_story" class="new_story" onsubmit="return story_validate();" action="site/stories/add_new_story" accept-charset="UTF-8">
		<div class="control-group">
		<textarea rows="20" placeholder="<?php if($this->lang->line('story_whatdowant') != '') { echo stripslashes($this->lang->line('story_whatdowant')); } else echo "Say something...";?>"  name="story_body" maxlength="500" id="story_body" cols="40" ></textarea>
		</div>
		<div class="stories-new-form-reorder-products stories-product-selector-products" style="width:630px;"></div>
		<div class="stories-new-product-add example25">
		<a href="#"><span class="image-plus"></span>
		<?php if($this->lang->line('story_addprod') != '') { echo stripslashes($this->lang->line('story_addprod')); } else echo "add products"; ?>
		</a></div>
		<div class="clearfix"></div>
		<div class="stories-new-share">	
<div data-no-refresh="true" class="facebook js-facebook-connect-button" onclick="javascript:fb_social(this)" id="facebook-check" style="border-right:1px solid #cccccc;">
	<a href="javascript:void(0)"><?php if($this->lang->line('signup_facebook') != '') { echo stripslashes($this->lang->line('signup_facebook')); } else echo "Facebook"; ?>
	<span class="stories-new-share-icon round-selector">
	<i class="icon-ok"></i>
	<i class="icon-remove"></i>
	</span>
	<input type="hidden" value="false" name="publish_to_facebook" id="share-to-facebook">
</a></div>

<div data-no-refresh="true" class="twitter js-twitter-connect-button" onclick="javascript:twitter_social(this)" id="twitter-check">
	<a href="javascript:void(0)"><?php if($this->lang->line('signup_twitter') != '') { echo stripslashes($this->lang->line('signup_twitter')); } else echo "Twitter"; ?>
	<span class="stories-new-share-icon round-selector">
	<i class="icon-ok"></i>
	<i class="icon-remove"></i>
	</span>
	<input type="hidden" value="false" name="publish_to_twitter" id="share-to-twitter">
</a></div>
<!--<div data-no-refresh="true" class="instagram js-instagram-connect-button" onclick="javascript:share_social(this)" id="instagram-check">
	<a href="javascript:void(0)"><?php if($this->lang->line('signup_instagram') != '') { echo stripslashes($this->lang->line('signup_instagram')); } else echo "Instagram"; ?>
	<span class="stories-new-share-icon round-selector">
	<i class="icon-ok"></i>
	<i class="icon-remove"></i>
	</span>
	<input type="hidden" value="false" name="publish_to_instagram" id="share-to-instagram">
</a></div>
<div data-no-refresh="true" class="pinterest js-pinterest-connect-button" onclick="javascript:share_social(this)" id="pinterest-check">
	<a href="javascript:void(0)"><?php if($this->lang->line('signup_pinterest') != '') { echo stripslashes($this->lang->line('signup_pinterest')); } else echo "Pinterest"; ?>
	<span class="stories-new-share-icon round-selector">
	<i class="icon-ok"></i>
	<i class="icon-remove"></i>
	</span>
	<input type="hidden" value="false" name="publish_to_pinterest" id="share-to-pinterest">
</a></div>-->

</div>
<div class="control-group stories-new-form-submit"  style="width:575px">
<input type="submit" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?>" name="commit" class="button large wb-primary disabled">
</div>
</form>
</div>
</div>
</div>
</div>   
                      </div>
                </div>
            </div>
		</section>
   <!-- Section_end -->
<?php 
$this->load->view('site/templates/footer');
?>
<!--if(f_id == ''){
		FB.init({
			appId:'<?php echo $this->config->item('facebook_app_id');?>',
			cookie:true,
			status:true,
			xfbml:true,
			oauth : true,
		});
		FB.login(function(response){
			if(response.authResponse){
				FB.api('/me', function(response){
					url = baseURL+'site/stories/get_facebook_id';
					$.post(url,{'fb_id':response.id},function(data){
						if(data ==1){
							alert("This facebook Account already Exists."); 
						}else{
							var curDiv = $(evt).find('span');
							var curIpt = $(evt).find('input');
							if(curDiv.hasClass('selector-active')){
								curDiv.removeClass('selector-active');
								curIpt.val('false');
							}else{
								curDiv.addClass('selector-active');
								curIpt.val('true');
							}
						}
					}); 
				});
			}else{
				alert('User cancelled login or did not fully authorize.');
			}
		},{perms: 'read_stream,publish_stream,offline_access'});
	}
-->