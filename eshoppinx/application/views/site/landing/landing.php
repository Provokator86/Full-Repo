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



<!--<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>-->
<!--[if lt IE 9]>
<script src="js/site/html5shiv/dist/html5shiv.js"></script>
<![endif]-->

<!-- ############################ new coding ########################### -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="<?php echo base_url();?>js/site/select2.js"></script>
<script src="<?php echo base_url();?>js/site/owl.carousel.min.js"></script>
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
<!-- ############################ new coding ########################### -->

<script>
$(document).ready(function(){
   
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

<!-- Section_start -->
<div id="mid-panel">
    <div class="wrapper">
    <?php 
    if (count($products_list) > 0){
    ?>
      <div id="owl-demo" class="product_main_thumb"> 
        <?php 
        foreach ($products_list as $products_list_row){
        
            $prodImg = 'dummyProductImage.jpg';
            $prodImgArr = array_filter(explode(',', $products_list_row->image));
            if (count($prodImgArr)>0){
                foreach ($prodImgArr as $prodImgArrRow){
                    if (file_exists('images/product/thumb/'.$prodImgArrRow)){
                        $prodImg = $prodImgArrRow;
                        break;    
                    }
                }
            }
            $userName = 'admin';
            $fullName = 'admin';
            if ($products_list_row->user_id > 0){
                $userName = $products_list_row->user_name?$products_list_row->user_name:$userName;
                $fullName = $products_list_row->full_name?character_limiter($products_list_row->full_name,20):$fullName;
                if (strlen($fullName)>20){
                    $fullName = substr($fullName, 0,20).'..';    
                }
            }
            if ($fullName == ''){
                $fullName = $userName;
            }
            $userImg = 'default_user.jpg';
            if ($products_list_row->thumbnail != ''){
                $userImg = $products_list_row->thumbnail;
            } 
            if (isset($products_list_row->web_link)){
                $prod_link = 'user/'.$userName.'/things/'.$products_list_row->seller_product_id.'/'.url_title($products_list_row->product_name,'-');
            }else {
                $prod_link = 'things/'.$products_list_row->id.'/'.url_title($products_list_row->product_name,'-');
            }
        ?>
        
        <!----  Single Block ----->
        <div class="main-box">
            <div class="article-square item-rec">
              <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row->price;?></h3></a>
              <h4><a href="<?php echo $prod_link;?>"><?php echo $products_list_row->product_name;?></a></h4>
              
              <a href="<?php echo $prod_link;?>" class="cover"><!--  --></a>
              <img src="images/product/thumb/<?php echo $prodImg;?>" alt="" style="left:0px;" />
            </div>
            
            <div class="article">
                <span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span>
                <div class="brand"><a href="javascript:">Arrow</a></div>
            </div>
        </div>
        <!----  Single Block -----> 
        <?php 
            }
         ?>
        
      </div>
      
        <div id="infscr-loading" style="display:none;">
            <span class="loading">Loading...</span>
        </div>
            
        <div class="pagination" style="display:none">
            <?php echo $paginationDisplay; ?>
        </div>
      <?php 
        }else {
       ?> 
        <h3><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></h3>
        <?php 
        }
        ?>                        
    </div>
  </div>
  <div class="clear"></div>

<!-- Section_end -->
<script type="text/javascript">
$('.example16').click(function(){
    $('#inline_example11 .popup_page').html('<div class="cnt_load"><img src="images/ajax-loader.gif"/></div>');
    var pid = $(this).data('pid');
    var pname = $(this).text();
    var purl = baseURL+$(this).attr('href');
    $.ajax({
        type:'get',
        url:baseURL+'site/product/get_product_popup',
        data:{'pid':pid},
        dataType:'html',
        success:function(data){
            window.history.pushState({"html":data,"pageTitle":pname},"", purl);
            $('#inline_example11 .popup_page').html(data);
        }
    });
});
var loading=false;
var $win     = $(window),
$stream  = $('div.product_main_thumb');
$(window).scroll(function() { //detect page scroll
    if($(window).scrollTop() + $(window).height() == $(document).height())  //user scrolled to bottom of the page?
    {
        var $url = $('.btn-more').attr('href');
        if(!$url) $url='';
        if($url != '' && loading==false) //there's more data to load
        {
            loading = true; //prevent further ajax loading
            $('#infscr-loading').show(); //show loading image
            //var vmode = $('.figure.classic').css('display');
            //load data from the server using a HTTP POST request
            
            $.ajax({
                    type:'post',
                    url:$url,
                    success:function(html){
//                        alert(data);    
                
                
                        var $html = $($.trim(html)),
                        $more = $('.pagination > a'),
                        $new_more = $html.find('.pagination > a');

                    if($html.find('div.product_main_thumb').text() == ''){
                        //$stream.append('<ul class="product_main_thumb"><li style="width: 100%;"><p class="noproducts">No more products available</p></li></ul>');
                    }else {
                        $stream.append( $html.find('div.product_main_thumb').html());
                    }
                    if($new_more.length) $('.pagination').append($new_more);
                    $more.remove();
                
                
                //hide loading image
                $('#infscr-loading').hide(); //hide loading image once data is received
                
                loading = false; 
                after_ajax_load();
            
                },
                fail:function(xhr, ajaxOptions, thrownError) { //any errors?
                    
                    alert(thrownError); //alert with HTTP error
                    $('#infscr-loading').hide(); //hide loading image
                    loading = false;
                
                }
            });
            
        }
    }
});
</script> 

<?php if($this->config->item('google_verification_code')){ echo stripslashes($this->config->item('google_verification_code')); } 
$this->load->view('site/templates/footer');
?>

    
