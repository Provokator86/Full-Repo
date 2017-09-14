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
    return false;
    
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

     	
<!-- Section_start -->
<div id="mid-panel">
        <div class="wrapper">
            <?php if($flash_data != '') { ?>
                <div class="errorContainer" id="<?php echo $flash_data_type;?>">
                    <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
                    <p><span><?php echo $flash_data;?></span></p>
                </div>
            <?php } ?>
            
            <div class="post_story">
                <h2><?php if($this->lang->line('add_a_storyboard') != '') { echo stripslashes($this->lang->line('add_a_storyboard')); } else echo "Post a story"; ?></h2>
                <form method="post" id="new_story" class="new_story" onsubmit="return story_validate();" action="site/stories/add_new_story" accept-charset="UTF-8">
                    <div>
                        <textarea placeholder="<?php if($this->lang->line('story_whatdowant') != '') { echo stripslashes($this->lang->line('story_whatdowant')); } else echo "What do you want to say";?>"  name="story_body" maxlength="500" id="story_body"></textarea>
                        
                        <!-- SELECTED PRODUCT LIST FROM NEXT STEP CLICK ON ADD PRODUCTS-->
                        <div class="stories-new-form-reorder-products stories-product-selector-products" ></div>
                        <div class="clear"></div>
                        <!-- SELECTED PRODUCT LIST FROM NEXT STEP CLICK ON ADD PRODUCTS-->
                        
                        <a class="add_product example25" href="#">
                        <img src="images/site_new/add_icon.jpg" alt="">
                        </a>
                        <div class="clear"></div>
                        <div class="social">
                        <a class="facebook" href="javascript:void(0);" onclick="javascript:fb_social(this)" id="facebook-check" ><?php if($this->lang->line('signup_facebook') != '') { echo stripslashes($this->lang->line('signup_facebook')); } else echo "Facebook"; ?><input type="hidden" value="false" name="publish_to_facebook" id="share-to-facebook"></a>
                        <a class="twitter" href="javascript:void(0);" onclick="javascript:twitter_social(this)" id="twitter-check" ><?php if($this->lang->line('signup_twitter') != '') { echo stripslashes($this->lang->line('signup_twitter')); } else echo "Twitter"; ?><input type="hidden" value="false" name="publish_to_twitter" id="share-to-twitter"></a>
                        <div class="clear"></div>
                        </div>
                        <input type="submit" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?>" class="submit button large wb-primary disabled" name="Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
      <div class="clear"></div>
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