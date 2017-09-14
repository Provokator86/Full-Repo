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
<!--<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/logo/<?php echo $fevicon;?>"/>-->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>images/favicon.ico"/>
<!--<link rel="stylesheet" href="css/site/font-awesome.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/landing_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/style.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/colorbox.css" media="all" />
<link rel="stylesheet" href="css/site/popup_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/developer.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/deal_hover.css" />
<link rel="stylesheet" href="css/site/setting.css" type="text/css" media="all"/>
<link rel="stylesheet" type="text/css" href="css/site/style_responsive.css" />-->

<!-- ############################ new coding ########################### -->
<link href="<?php echo base_url();?>css/site/style.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>css/site/select2.css" rel="stylesheet"/>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
<link href="<?php echo base_url();?>css/site/owl.carousel.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>css/site/meanmenu.css" rel="stylesheet" type="text/css" media="all">
<link href="<?php echo base_url();?>css/site/responsive.css" rel="stylesheet" type="text/css" media="all">
<!-- ############################ new coding ########################### -->
<link rel="stylesheet" type="text/css" href="css/site/colorbox.css" media="all" />
<link rel="stylesheet" href="css/site/popup_style.css" type="text/css" media="all"/>
<link rel="stylesheet" href="css/site/setting.css" type="text/css" media="all"/>



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
<script src="js/validation.js"></script>

<!-- ############################ new coding ########################### -->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>-->
<script src="js/site/select2.js"></script>
<script src="js/site/owl.carousel.min.js"></script>
<script src="js/site/jquery.meanmenu.js"></script>
<script type="text/javascript" src="js/site/scrolltopcontrol.js"></script>
<script src="js/site/script.js"></script>
<!--[if IE]><style type="text/css">.pie {behavior:url(PIE.htc);}</style><![endif]-->
<!--[if lt IE 9]>
    <script src="js/respond-1.1.0.min.js"></script>
<![endif]-->
<!-- ############################ new coding ########################### -->

<script>
$(document).ready(function(){
	var boxpostwindowsize = $(window).width();

        $(".cboxClose1").click(function(){
            $("#cboxOverlay,#colorbox").hide();
            });

            
            
            if (boxpostwindowsize > 559) {
                //$(".box_post").colorbox({width:"600px", height:"380px", inline:true, href:"#inline_example10"});
                $(".box_post").colorbox({width:"762px", height:"529px", inline:true, href:"#inline_example10"});
                $(".example19").colorbox({width:"870px",height:"379px", inline:true, href:"#inline_example14"});
                $(".example20").colorbox({width:"700px", inline:true, href:"#inline_example15"});
                $(".example21").colorbox({width:"700px", inline:true, href:"#inline_example16"});
                $(".example22").colorbox({width:"700px", inline:true, href:"#inline_example17"});
                $(".example25").colorbox({width:"700px", height:"450px", inline:true, href:"#inline_example20"});
                
                $(".sign_box").colorbox({width:"560px",height:"700px", inline:true, href:"#inline_example4"});
            } 
            else {
                //$(".box_post").colorbox({width:"320px", inline:true, href:"#inline_example10"});
                $(".box_post").colorbox({width:"320px", inline:true, href:"#inline_example10"});
                $(".example19").colorbox({width:"320px", inline:true, href:"#inline_example14"});
                $(".example20").colorbox({width:"320px", inline:true, href:"#inline_example15"});
                $(".example21").colorbox({width:"320px", inline:true, href:"#inline_example16"});
                $(".example22").colorbox({width:"320px", inline:true, href:"#inline_example17"});
                $(".example25").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example20"});
                
                $(".sign_box").colorbox({width:"320px",height:"450px", inline:true, href:"#inline_example4"});     
            }
            

        
        //Example of preserving a JavaScript event for inline calls.
            $("#onLoad").click(function(){ 
                $('#onLoad').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
                return false;
            });

            
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

<!-- Popup_start -->

<?php 
$this->load->view('site/landing/landing_popup.php',$this->data);
$this->load->view('site/templates/popup_templates.php',$this->data);

?>
<!-- Popup_end -->

<body>
<a href="#top"></a>
<!-- container_start -->
<div id="container">
<!-- header_start -->
  <div id="header">
    <?php 
    $this->load->view('site/templates/logo_head',$this->data);
    ?>
    
    <?php 
    $this->load->view('site/templates/nav_menu',$this->data);
    ?>
    
    <?php 
    $this->load->view('site/templates/cat_menu',$this->data);
    ?>
    
    <div class="clear"></div>
    
    <?php if($flag_display_sub){ ?>
    <div class="sub-catog">
        <h4>Sitename<br> Collections</h4>
        <h3>all beyond the designer creative<br>all for the new experience</h3>
    </div>
    <?php } ?>
    
  </div>
  <!-- header_end -->
  <?php 
        if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code')); }
 

if ($loginCheck != '' && $userDetails->row()->is_verified == 'No'){
?>  
<?php }?>

	
