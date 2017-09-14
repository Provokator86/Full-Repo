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


<script type="text/javascript">
var baseURL = '<?php echo base_url();?>';
var base_url = '<?php echo base_url();?>';
var BaseURL = '<?php echo base_url();?>';
var siteTitle = '<?php echo $siteTitle;?>';
</script>
<!--<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>-->
<!--[if lt IE 9]>
<script src="js/site/html5shiv/dist/html5shiv.js"></script>
<![endif]-->

<!-- ############################ new coding ########################### -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>js/site/select2.js"></script>
<?php /*?><script src="<?php echo base_url();?>js/site/owl.carousel.min.js"></script>
<script src="<?php echo base_url();?>js/owl.carousel.js"></script><?php */?>
<script src="<?php echo base_url();?>js/site/jquery.ui.widget.js"></script>
<script src="<?php echo base_url();?>js/site/ui.checkbox.js"></script>
<script src="<?php echo base_url();?>js/site/jquery.meanmenu.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/site/scrolltopcontrol.js"></script>
<script src="<?php echo base_url();?>js/site/script.js"></script>
<!--[if IE]><style type="text/css">.pie {behavior:url(PIE.htc);}</style><![endif]-->
<!--[if lt IE 9]>
    <script src="js/respond-1.1.0.min.js"></script>
<![endif]-->
<script src="js/validation.js"></script>
<script src="js/site/jquery.colorbox.js"></script>
<script src="js/site/add_product.js"></script>
<script src="js/validation.js"></script>
<script src="js/site/custom-scripts/category.js"></script>
<script src="js/site/custom-scripts/ModalDialog.js"></script>
<script src="js/site/custom-scripts/jquery.infinitescroll.js"></script>
<script src="js/site/custom-scripts/page_infinite_scroller.js"></script>
<!-- ############################ new coding ########################### -->

<script>
$(document).ready(function(){
   $('input:checkbox').checkBox();
});
</script>

</head>

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
    
    <?php 
    $this->load->view('site/templates/cat_srch_menu',$this->data);
    ?>
    
  </div>
  <!-- header_end -->
  
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">            
            <!-- PRODUCTS LISTS -->
            <div class="product_box">   
                <div class="product-listing">
                    <div id="product_ajax">
                        <?php echo $product_list; ?>
                    </div>
                </div>
                
                <div id="infscr-loading">
                    <img src="<?php echo base_url('images/scrolling_content_loader.gif') ?>" alt="Loading...">
                    <div>Loading</div>
                </div>                
                <div class="clear"></div>
            </div>            
            <!-- PRODUCTS LISTS -->
        </div>     
        
    </div>
    <div class="clear"></div>
    <!-- Section_end -->
  
<?php 
if($this->config->item('google_verification_code')){ 
    echo stripslashes($this->config->item('google_verification_code')); 
} 
$this->load->view('site/templates/footer',$this->data);
?>
