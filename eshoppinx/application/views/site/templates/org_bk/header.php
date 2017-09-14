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
<link rel="stylesheet" href="css/site/font-awesome.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/landing_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/style.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/colorbox.css" media="all" />
<link rel="stylesheet" href="css/site/popup_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/developer.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/deal_hover.css" />
<link rel="stylesheet" href="css/site/setting.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/style_responsive.css" />




<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript">
var baseURL = '<?php echo base_url();?>';
var BaseURL = '<?php echo base_url();?>';
var siteTitle = '<?php echo $siteTitle;?>';
var likeTXT = '<?php echo addslashes(LIKE_BUTTON);?>';
var likedTXT = '<?php echo addslashes(LIKED_BUTTON);?>';
var unlikeTXT = '<?php echo addslashes(UNLIKE_BUTTON);?>';
var lg_currency_symbol = '<?php echo $currencySymbol;?>';
var lg_delete = 'Delete';
<?php if($this->lang->line('shipping_delete') != '') {?>
var lg_delete = '<?php echo $this->lang->line('shipping_delete');?>';
<?php }?>
var lg_deleting = 'Deleting';
<?php if($this->lang->line('deleting') != '') {?>
var lg_deleting = '<?php echo $this->lang->line('deleting');?>';
<?php }?>
var lg_change_name = 'Change Name';
<?php if($this->lang->line('change_name') != '') {?>
var lg_change_name = '<?php echo $this->lang->line('change_name');?>';
<?php }?>
var lg_change = 'Change';
<?php if($this->lang->line('change') != '') {?>
var lg_change = '<?php echo $this->lang->line('change');?>';
<?php }?>
var lg_changing = 'Changing';
<?php if($this->lang->line('changing') != '') {?>
var lg_changing = '<?php echo $this->lang->line('changing');?>';
<?php }?>
var lg_r_u_sure = 'Are you sure';
<?php if($this->lang->line('r_u_sure') != '') {?>
var lg_r_u_sure = '<?php echo $this->lang->line('r_u_sure');?>';
<?php }?>
var lg_col_del_succ = 'Collection deleted successfully';
<?php if($this->lang->line('col_del_succ') != '') {?>
var lg_col_del_succ = '<?php echo $this->lang->line('col_del_succ');?>';
<?php }?>
var lg_som_went_wrong = 'Something went wrong';
<?php if($this->lang->line('som_went_wrong') != '') {?>
var lg_som_went_wrong = '<?php echo $this->lang->line('som_went_wrong');?>';
<?php }?>
var lg_col_name_req = 'Collection name required';
<?php if($this->lang->line('col_name_req') != '') {?>
var lg_col_name_req = '<?php echo $this->lang->line('col_name_req');?>';
<?php }?>
var lg_col_id_req = 'Collection Id required';
<?php if($this->lang->line('col_id_req') != '') {?>
var lg_col_id_req = '<?php echo $this->lang->line('col_id_req');?>';
<?php }?>
var lg_msg_sent_succ = 'Message sent successfully';
<?php if($this->lang->line('send_message') != '') {?>
var lg_msg_sent_succ = '<?php echo $this->lang->line('send_message');?>';
<?php }?>
var lg_wait = 'Wait';
<?php if($this->lang->line('wait') != '') {?>
var lg_wait = '<?php echo $this->lang->line('wait');?>';
<?php }?>
var lg_follow = 'Follow';
<?php if($this->lang->line('onboarding_follow') != '') {?>
var lg_follow = '<?php echo $this->lang->line('onboarding_follow');?>';
<?php }?>
var lg_following = 'Following';
<?php if($this->lang->line('display_following') != '') {?>
var lg_following = '<?php echo $this->lang->line('display_following');?>';
<?php }?>
var lg_enter_ur_msg = 'Enter your message';
<?php if($this->lang->line('enter_ur_msg') != '') {?>
var lg_enter_ur_msg = '<?php echo $this->lang->line('enter_ur_msg');?>';
<?php }?>
var lg_saved = 'Saved';
<?php if($this->lang->line('prod_saved') != '') {?>
var lg_saved = '<?php echo $this->lang->line('prod_saved');?>';
<?php }?>
var lg_saves = 'saves';
<?php if($this->lang->line('product_saves') != '') {?>
var lg_saves = '<?php echo $this->lang->line('product_saves');?>';
<?php }?>
var lg_tagged = 'Tagged';
<?php if($this->lang->line('tagged') != '') {?>
var lg_tagged = '<?php echo $this->lang->line('tagged');?>';
<?php }?>
var lg_uploading = 'Uploading...';
<?php if($this->lang->line('settings_uploading') != '') {?>
var lg_uploading = '<?php echo $this->lang->line('settings_uploading');?>';
<?php }?>
var lg_upload = 'Upload';
<?php if($this->lang->line('header_upload') != '') {?>
var lg_upload = '<?php echo $this->lang->line('header_upload');?>';
<?php }?>
var lg_pls_sel_fil_uplod = 'Please select a file to upload';
<?php if($this->lang->line('pls_sel_fil_uplod') != '') {?>
var lg_pls_sel_fil_uplod = '<?php echo $this->lang->line('pls_sel_fil_uplod');?>';
<?php }?>
var lg_header_img_format = 'The image must be in one of the following formats: .jpeg, .jpg, .gif or .png.';
<?php if($this->lang->line('header_img_format') != '') {?>
var lg_header_img_format = '<?php echo $this->lang->line('header_img_format');?>';
<?php }?>
var lg_som_wnt_ron_up_agin = 'Something went wrong. Please upload again';
<?php if($this->lang->line('som_wnt_ron_up_agin') != '') {?>
var lg_som_wnt_ron_up_agin = '<?php echo $this->lang->line('som_wnt_ron_up_agin');?>';
<?php }?>
var lg_pls_nter_tit = 'Please enter title';
<?php if($this->lang->line('pls_nter_tit') != '') {?>
var lg_pls_nter_tit = '<?php echo $this->lang->line('pls_nter_tit');?>';
<?php }?>
var lg_pls_nter_link = 'Please enter link';
<?php if($this->lang->line('pls_nter_link') != '') {?>
var lg_pls_nter_link = '<?php echo $this->lang->line('pls_nter_link');?>';
<?php }?>
var lg_pls_nter_price = 'Please enter price';
<?php if($this->lang->line('pls_nter_price') != '') {?>
var lg_pls_nter_price = '<?php echo $this->lang->line('pls_nter_price');?>';
<?php }?>
var lg_price_must_int = 'Price must be an integer';
<?php if($this->lang->line('price_must_int') != '') {?>
var lg_price_must_int = '<?php echo $this->lang->line('price_must_int');?>';
<?php }?>
var lg_adding = 'Adding';
<?php if($this->lang->line('adding') != '') {?>
var lg_adding = '<?php echo $this->lang->line('adding');?>';
<?php }?>
var lg_add_to = 'Add to';
<?php if($this->lang->line('header_add_to') != '') {?>
var lg_add_to = '<?php echo $this->lang->line('header_add_to');?>';
<?php }?>
var lg_pls_nter_web_addr = 'Please enter a website address';
<?php if($this->lang->line('pls_nter_web_addr') != '') {?>
var lg_pls_nter_web_addr = '<?php echo $this->lang->line('pls_nter_web_addr');?>';
<?php }?>
var lg_not_found_gud_img = 'Oops! Couldn\'t find any good images for the page';
<?php if($this->lang->line('not_found_gud_img') != '') {?>
var lg_not_found_gud_img = '<?php echo addslashes($this->lang->line('not_found_gud_img'));?>';
<?php }?>
var lg_submit = 'Submit';
<?php if($this->lang->line('templates_submit') != '') {?>
var lg_submit = '<?php echo $this->lang->line('templates_submit');?>';
<?php }?>
var lg_sure_del = 'Are you sure to delete this comment ?';
<?php if($this->lang->line('lg_sure_del') != '') {?>
var lg_sure_del = '<?php echo $this->lang->line('lg_sure_del');?>';
<?php }?>
var lg_undone = 'This action cannot be undone.';
<?php if($this->lang->line('lg_undone') != '') {?>
var lg_undone = '<?php echo $this->lang->line('lg_undone');?>';
<?php }?>
var lg_editing = 'Editing';
<?php if($this->lang->line('lg_editing') != '') {?>
var lg_editing = '<?php echo $this->lang->line('lg_editing');?>';
<?php }?>
var lg_edit = 'Edit';
<?php if($this->lang->line('shipping_edit') != '') {?>
var lg_edit = '<?php echo $this->lang->line('shipping_edit');?>';
<?php }?>
var lg_updating = 'Updating';
<?php if($this->lang->line('lg_updating') != '') {?>
var lg_updating = '<?php echo $this->lang->line('lg_updating');?>';
<?php }?>
var lg_cmt_emt = 'Your comment is empty';
<?php if($this->lang->line('lg_cmt_emt') != '') {?>
var lg_cmt_emt = '<?php echo $this->lang->line('lg_cmt_emt');?>';
<?php }?>
			$(document).ready(function(){
				//To switch directions up/down and left/right just place a "-" in front of the top/left attribute
				//Vertical Sliding
			
				$('.boxgrid.captionfull').hover(function(){
					//$(".cover", this).stop().animate({top:'0px'},{queue:false,duration:750});
					 $(".cover", this).css({ 'display': 'block' });
				}, function() {
					//$(".cover", this).stop().animate({top:'283px'},{queue:false,duration:750});
					 $(".cover", this).css({ 'display': 'none' });
				});
				//Caption Sliding (Partially Hidden to Visible)
				
			});
		</script>

<!--[if lt IE 9]>
<script src="js/site/html5shiv/dist/html5shiv.js"></script>
<![endif]-->

<script src="js/validation.js"></script>
<script src="js/site/jquery.colorbox.js"></script>
<script src="js/site/add_product.js"></script>
<script>
$(document).ready(function(){
	
	
	var boxpostwindowsize = $(window).width();

		$(".cboxClose1").click(function(){
			$("#cboxOverlay,#colorbox").hide();
			});

			
			
			if (boxpostwindowsize > 559) {
				
				$(".box_post").colorbox({width:"600px", height:"380px", inline:true, href:"#inline_example10"});
				$(".example25").colorbox({width:"540px", height:"450px", inline:true, href:"#inline_example20"});
				$(".example15").colorbox({width:"560px", height:"450px", inline:true, href:"#inline_example10"});
				$(".example20").colorbox({width:"560px", inline:true, href:"#inline_example15"});
				$(".example21").colorbox({width:"560px", inline:true, href:"#inline_example16"});
				$(".example22").colorbox({width:"560px", inline:true, href:"#inline_example17"});
				$(".tag_box").colorbox({width:"560px", inline:true, href:"#inline_example18"});
				$(".example23").colorbox({width:"560px", inline:true, href:"#inline_example18"});
//				<!--$(".example24").colorbox({width:"560px", height:"450px", inline:true, href:"#inline_example19"});-->
//				$(".save_box").colorbox({width:"560px", height:"450px", inline:true, href:"#inline_example19"});
				$(".example17").colorbox({width:"560px", inline:true, href:"#inline_example12"});
				$(".example12").colorbox({width:"560px",  height:"450px", inline:true, href:"#inline_example7"});
				$(".example18").colorbox({width:"560px", inline:true, href:"#inline_example13"});
				$(".sign_box").colorbox({width:"560px",height:"700px", inline:true, href:"#inline_example4"});
				$(".log_box").colorbox({width:"560px", inline:true, href:"#inline_example5"});
				$(".example19").colorbox({width:"870px", inline:true, href:"#inline_example14"});
				$(".example13").colorbox({width:"560px", height:"600px", inline:true, href:"#inline_example8"});
				$(".example14").colorbox({width:"560px", height:"450px", inline:true, href:"#inline_example9"});
				$(".contact_seller_btn").colorbox({width:"560px", height:"350px", inline:true, href:"#contact_seller_popup"});
			} else {
				$(".box_post").colorbox({width:"320px", inline:true, href:"#inline_example10"});
				$(".example25").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example20"});
				$(".example15").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example10"});
				$(".example20").colorbox({width:"320px", inline:true, href:"#inline_example15"});
				$(".example21").colorbox({width:"320px", inline:true, href:"#inline_example16"});
				$(".example22").colorbox({width:"320px", inline:true, href:"#inline_example17"});
				$(".tag_box").colorbox({width:"320px", inline:true, href:"#inline_example18"});
				$(".example23").colorbox({width:"320px", inline:true, href:"#inline_example18"});
//				<!--$(".example24").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example19"});-->
				$(".save_box").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example19"});
				$(".example17").colorbox({width:"320px", inline:true, href:"#inline_example12"});
				$(".example12").colorbox({width:"320px",  height:"450px", inline:true, href:"#inline_example7"});
				$(".example18").colorbox({width:"320px", inline:true, href:"#inline_example13"});
				$(".sign_box").colorbox({width:"320px",height:"450px", inline:true, href:"#inline_example4"});
				$(".log_box").colorbox({width:"320px", inline:true, href:"#inline_example5"});
				$(".example19").colorbox({width:"320px", inline:true, href:"#inline_example14"});
				$(".example13").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example8"});
				$(".example14").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example9"});
				$(".contact_seller_btn").colorbox({width:"320px", height:"350px", inline:true, href:"#contact_seller_popup"});
				
			}
			

			$(".report_pop").colorbox({width:"600px", height:"300px", inline:true, href:"#report_popup"});
			
			$(".example16").colorbox({width:"1140px", inline:true, href:"#inline_example11"});
			
			

//			<!--$(".example11").colorbox({width:"900px", inline:true, href:"#inline_example6"});-->

			

		
		//Example of preserving a JavaScript event for inline calls.
			$("#onLoad").click(function(){ 
				$('#onLoad').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
				return false;
			});

			//Menu Hover
/*			$('.top_nav li').hover(function(){
				$(this).find('ul').css('visibility','visible');
			},function(){
				$(this).find('ul').delay('5000').css('visibility','hidden');
			});
*/
});
function showView(val){

	if($('#showlist'+val).css('display')=='block'){
		$('#showlist'+val).hide('');	
	}else{
		$('#showlist'+val).show('');
	}	
}
</script>


</head>
<style>
.feed-notification li .photo {

top: 13px;
left: 10px;
width: 32px;
height: 32px;
border-radius: 2px;
}
</style>

<!-- Popup_start -->

<?php 
$this->load->view('site/landing/landing_popup.php',$this->data);
$this->load->view('site/templates/popup_templates.php',$this->data);
$current_user_img = 'default_user.jpg';
if ($loginCheck != ''){

	if ($userDetails->row()->thumbnail != ''){
		if (file_exists('images/users/'.$userDetails->row()->thumbnail)){
			$current_user_img = $userDetails->row()->thumbnail;
		}
	}
}
?>
<style type="text/css">
.feed-back {
	position: fixed;
	z-index: 11;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: rgba(0,0,0,0);
	margin: 0;
	box-shadow: none;
	cursor: pointer;
}
.feed-notification {
	width:280px;
	margin-left:-140px;
}
.feed-notification li {
	position:relative;
	line-height:16px;
	float:left;
	clear:both;
	padding:10px 10px 10px 52px;
	width:218px;
	color:#373d48;
	font-size:12px;
	border-bottom:1px solid #e5e5e5;
	min-height:32px;
}
.feed-notification li:hover {
	background:#f4f4f4;
}
.feed-notification li .photo{
	position:absolute;
	top:13px;
	left:10px;
	width:32px;
	height:32px;
	border-radius:2px;
}

</style>

<!-- Popup_end -->


<body>

	<!-- header_start -->

        <header>
        	
            <div class="header_main">
            <?php 

if ($loginCheck != '' && $userDetails->row()->is_verified == 'No'){
?>  
<!-- <div class="notify-default">
<div id="notibar-email-confirm" class="inner">
<p><?php if($this->lang->line('header_cofirm_email') != '') { echo stripslashes($this->lang->line('header_cofirm_email')); } else echo "Please confirm your email address. If you haven't received anything you can"; ?> <a href="settings"><?php if($this->lang->line('header_update_email') != '') { echo stripslashes($this->lang->line('header_update_email')); } else echo "update your email"; ?></a> <?php if($this->lang->line('credit_or') != '') { echo stripslashes($this->lang->line('credit_or')); } else echo "or"; ?> <a style="cursor: pointer;"><?php if($this->lang->line('settings_resendconfm') != '') { echo stripslashes($this->lang->line('settings_resendconfm')); } else echo "resend confirmation"; ?>.</a></p>
</div>
</div>
 -->
<?php }?>
                <div class="main2">
            
                 <h1 class="logo_main"><?php if($this->config->item('logo_icon_option')=='yes'){ ?><span class="logo_icon"><img style="max-height: 37px;" src="images/logo/<?php echo $this->config->item('logo_icon'); ?>" /></span><?php } ?><a id="logo" href="<?php echo base_url();?>" alt="<?php echo $siteTitle;?>" title="<?php echo $siteTitle;?>"><img style="max-height: 37px;" src="images/logo/<?php echo $logo;?>"/></a></h1>
                
              
                 <ul class="nav_tab">
                 
                    
                    <li><a <?php if ($this->uri->segment(1,0)=='magic'){?>id="nav_active"<?php }?> href="magic"><?php if($this->lang->line('lg_magic') != '') { echo stripslashes($this->lang->line('lg_magic')); } else echo "MAGIC";?></a></li>
                    
                    <li><a <?php if ($this->uri->segment(1,0)=='myfeed'){?>id="nav_active"<?php }?> href="myfeed"><?php if($this->lang->line('trending_myfeed') != '') { echo stripslashes($this->lang->line('trending_myfeed')); } else echo "My Feed"; ?></a></li>
                    
                    <li><a <?php if ($this->uri->segment(1,0)=='trending'){?>id="nav_active"<?php }?> href="trending"><?php if($this->lang->line('trending_trend') != '') { echo stripslashes($this->lang->line('trending_trend')); } else echo "Trending"; ?></a></li>
                 	
                 </ul>
                
				<ul class="top_nav res_nav">
                
                	<li style="margin:0 5px;" title="Category"><a class="default_categories" href="javascript:void(0);"><img width="14px" height="12px" src="images/categories-up.png"  /></a>
                    	
                        <ul class="categories_drop_down">
                        
                        	<li><span class="arrow_icon"><img src="images/drop_arrow.png" /></span></li>
                            
                            <li>
                            
                            	<ul class="categories_drop1">
                            <?php //print_r($CategoryList);
							foreach($CategoryList as $Catlist){
							 echo '<li><a href="category/'.$Catlist["seourl"].'">'.$Catlist["cat_name"].'</a></li>';
							}
							 ?>
                             
                            	 </ul>
                                 
                                 <div class="categories_drop2">
                                 
                                 	<ol class="categories_drop2_links">
                        
                                        <li><span class="arrow_icon2 res_arrow"><img src="images/drop_arrow.png" /></span></li>
                                        
                                        <li><a href="<?php base_url(); ?>stories/"><?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories";?></a></li>
                                        
                                        <li><a href="<?php base_url(); ?>stores/"><?php if($this->lang->line('templates_topstories') != '') { echo stripslashes($this->lang->line('templates_topstories')); } else echo "Top Stores"; ?></a></li>
                                        
                                        <li><a href="<?php base_url(); ?>people/"><?php if($this->lang->line('templates_toppeople') != '') { echo stripslashes($this->lang->line('templates_toppeople')); } else echo "Top People"; ?></a></li>
                                        
                                        <li class="divider"></li>
                                        
                                        <li><a href="recent"><?php if($this->lang->line('templates_just_posted') != '') { echo stripslashes($this->lang->line('templates_just_posted')); } else echo "Just Posted"; ?></a></li>
                                        
                                        
                                        <li><a href="popular">Most Popular</a></li>
                                        
                                        <?php 
                                        if (count($cmsPages)>0){
                                        ?>
                                        <li class="divider"></li>
                                       <?php
                                       foreach ($cmsPages as $cms_row){
                                        if (strtolower($cms_row['category']) == 'main'){
                                       ?> 
                                        <li><a href="pages/<?php echo $cms_row['seourl'];?>"><?php echo $cms_row['page_name']; ?></a></li>
                                       <?php 
                                        }
                                        }
                                       ?> 
                                        <?php }?>
                        		</ol>
<!--                                 
                                	<div class="categories_menu_share">
                                
                                		<a class="cate_icon insta_icon" href="#"></a>
                                        
                                        <a class="cate_icon face_icon" href="#"></a>
                                        
                                        <a class="cate_icon twit_icon" href="#"></a>
                                 
                                 	</div>
 -->                                 
                                 </li>
                        	
                        </ul>
                    
                    
                    
                    </li>
                
                
                </ul>
                
                
                
                <div class="search_main">
                	<form action="<?php base_url();?>shopby/all" class="search">
                    
                    	<input type="text" name="q" class="scroll-5" id="search-query" placeholder="<?php if($this->lang->line('templates_find') != '') { echo stripslashes($this->lang->line('templates_find')); } else echo "Find"; ?> <?php echo $siteTitle;?> <?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?>" value="" autocomplete="off" />
                        
                        <input type="submit" value="<?php if($this->lang->line('templates_go') != '') { echo stripslashes($this->lang->line('templates_go')); } else echo "Go"; ?>" class="search_btn" />
                        <div class="feed-search" style="display: none;">
				<h4><?php if($this->lang->line('header_suggestions') != '') { echo stripslashes($this->lang->line('header_suggestions')); } else echo "Suggestions"; ?></h4>
				<div class="loading" style="display: block;"><i></i>
				<img class="loader" src="images/site/loading.gif">
				</div>
			</div>
                	</form>
                </div> 
                
                
                
                <?php if ($loginCheck != ''){ ?>
                <div id="MiniCartViewDisp">
                <?php //echo $MiniCartViewSet;?>
               </div>
                <?php }?>
                 
                	
                <ul class="top_nav res_nav" <?php if ($loginCheck==''){echo 'style="float: right;"';}else {if ($userDetails->row()->group=='User'){echo 'style="float: left;"';}else {echo 'style="float: left;"';}}?>>
                    <li class="post_tab"><a class="post <?php if ($loginCheck==''){echo 'sign_box';}else {echo 'box_post';}?>" href="#"><?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "Post"; ?> +</a></li>
<?php 
if ($loginCheck != ''){
?>                    
                    <li style="margin:0 13px 0px 5px;"><a class="default" href="<?php echo 'user/'.$userDetails->row()->user_name;?>"><img width="33px" height="31px" src="images/users/<?php echo $current_user_img;?>" /></a>
                    	
                        <ul id="drop-list">
                        
                        	<li><span class="arrow_icon"><img src="images/drop_arrow.png" /></span></li>
                            
                        	<li><a href="<?php echo 'user/'.$userDetails->row()->user_name;?>"><?php if($this->lang->line('header_profile') != '') { echo stripslashes($this->lang->line('header_profile')); } else echo "Profile"; ?></a></li>
                            <?php if ($loginCheck != ''){?>
                            <li><a href="bookmarklets">Get Bookmarklet</a></li>
                            <li><a href="invite-friends"><?php if($this->lang->line('onboarding_invite_frd') != '') { echo stripslashes($this->lang->line('onboarding_invite_frd')); } else echo "Invite Friends";?></a></li>
							<?php }?>   
                            <li><a href="settings"><?php if($this->lang->line('header_settings') != '') { echo stripslashes($this->lang->line('header_settings')); } else echo "Settings"; ?></a></li>
                            <li><a href="logout"><?php if($this->lang->line('header_signout') != '') { echo stripslashes($this->lang->line('header_signout')); } else echo "Sign out"; ?></a></li>
                           
                           
                        </ul>
                    
                    
                    
                    </li>
                     <li style="background: url('images/logo-icon.png') no-repeat #FFFFFF;background-position: -25px -13px;text-indent: -9000px;background-size: 700%; border: 1px solid #dadada;border-radius: 2px;" class="notifination gnb-notification" href="<?php echo base_url();?>notifications">0
                    	
                       
                           	<ul class="feed-notification notification_sub" style="text-indent: 0px;">
                           	<li><span class="arrow_icon2"><img src="images/drop_arrow.png"/></span></li> 
                           			<li class="loading res-load"><?php if($this->lang->line('display_loading') != '') { echo stripslashes($this->lang->line('display_loading')); } else echo "Loading"; ?>...</li>
						</ul>
<!--  					<ul class="moreFeed" style="display:none;"><li><a href="<?php echo base_url();?>notifications">See all notofications</a></li></ul>
       -->	                     
                    
                    
                    
                    </li>
                    
                    
<?php 
}else {
?>     
                     <li><a class="post log_box" href="#"><?php if($this->lang->line('templates_join') != '') { echo stripslashes($this->lang->line('templates_join')); } else echo "Join"; ?></a></li>
                     <li><a class="post sign_box" href="javascript:void(0);"><?php if($this->lang->line('signup_sign_in') != '') { echo stripslashes($this->lang->line('signup_sign_in')); } else echo "Sign in"; ?></a></li>
<?php 
}
?>                
                
                	<!--<li class="res_more right"><a class="more" href="javascript:void(0);"><?php if($this->lang->line('fancy_more') != '') { echo stripslashes($this->lang->line('fancy_more')); } else echo "More"; ?></a>-->
                    
                    	
                    
                    
                    </li>
                </ul>     
                
                
                
                           
                 
            
                </div>
            
            </div>
             
       <div style="clear:both; margin-top:20px;">&nbsp;</div> 
        </header>
        <?php 
        if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code')); }
 

if ($loginCheck != '' && $userDetails->row()->is_verified == 'No'){
?>  
<?php }?>
<span class="example12"></span>
	<!-- header_end -->
