<?php
$this->load->view('site/templates/header',$this->data);
//$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>
<!-- Section_start -->
<div id="mid-panel">
    <div class="wrapper">
        <?php if($flash_data != '') { ?>
        <div class="errorContainer" id="<?php echo $flash_data_type;?>">
            <script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
            <p><span><?php echo $flash_data;?></span></p>
        </div>
        <div class="clear"></div>
        <?php } ?>
        
        <?php $this->load->view('site/brand/brand_menu',$this->data); ?>
        
        
        <div class="trending">
            <div class="trending_lft">
                <ul class="tabs">
                    <li class="active"><a href="#"> <span><?php echo $tot_products ?></span><?php if($this->lang->line('templates_products') != '') { echo stripslashes($this->lang->line('templates_products')); } else echo "Products"; ?></a></li>
                    
                    <!--<li class="trending_rht"><a href="#">Men</a></li>
                    <li class="trending_rht"><a href="#">Women</a></li>
                    <li class="trending_rht"><a href="#">Independent</a></li>
                    <li class="trending_rht"><a href="#">Recommended</a></li>-->
                </ul>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        
        
        
        <div class="brand_product store_prod panes" style="display:block;">
            <?php if($product_details->num_rows()>0){?>
            <ul class="product_main_thumb">            
                <?php 
                foreach ($product_details->result() as $productLikeDetailsRow){
                    $imgName = 'dummyProductImage.jpg';
                    $imgArr = explode(',', $productLikeDetailsRow->image);
                    if (count($imgArr)>0){
                        foreach ($imgArr as $imgRow){
                            if ($imgRow!=''){
                                if (file_exists('images/product/thumb/'.$imgRow)){
                                    $imgName = $imgRow;
                                    break;
                                }
                            }
                        }
                    }
                    $fancyClass = 'fancy';
                    $fancyText = LIKE_BUTTON;
                    if (count($likedProducts)>0 && $likedProducts->num_rows()>0){
                        foreach ($likedProducts->result() as $likeProRow){
                            if ($likeProRow->product_id == $productLikeDetailsRow->seller_product_id){
                                $fancyClass = 'fancyd';$fancyText = LIKED_BUTTON;break;
                            }
                        }
                    }
                    $userImg = 'default_user.jpg';
                    if ($productLikeDetailsRow->thumbnail != ''){
                        $userImg = $productLikeDetailsRow->thumbnail;
                    } 
                    if (isset($productLikeDetailsRow->web_link)){
                        $prod_link = 'user/'.$productLikeDetailsRow->user_name.'/things/'.$productLikeDetailsRow->seller_product_id.'/'.str_replace(' ','-',$productLikeDetailsRow->product_name);
                    }else {
                        $prod_link = 'things/'.$productLikeDetailsRow->id.'/'.str_replace(' ','-',$productLikeDetailsRow->product_name);
                    }
                    if ($productLikeDetailsRow->user_name == ''){
                        //$fullName = 'administrator';
                        $fullName = 'admin';
                    }else {
                        $fullName = $productLikeDetailsRow->full_name;
                        if ($fullName == ''){
                            $fullName = $productLikeDetailsRow->user_name;
                        }else {
                            $fullName = character_limiter($fullName,20);
                            if (strlen($fullName)>20){
                                $fullName = substr($fullName, 0,20).'..';
                            }
                        }
                    }
                    
                    $userName = $productLikeDetailsRow->user_name;
                    if($userName == ''){
                    //$userName = 'administrator';
                    $userName = 'admin';
                    }
                    
                ?>
                <li>
                    <div class="main-box2">
                        <div class="brandPic">
                            <table  cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td valign="middle" align="center">
                                        <img src="images/product/thumb/<?php echo $imgName;?>" alt="">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="overlay">
                            <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php //if (!isset($productLikeDetailsRow->web_link)){echo $currencySymbol.$productLikeDetailsRow->sale_price;}else {echo $currencySymbol;?><?php echo $productLikeDetailsRow->price;//}?></h3></a>
                            <h4><a href="<?php echo $prod_link;?>"><?php echo character_limiter($productLikeDetailsRow->product_name,25);?></a> </h4> 
                        </div>
                    </div>
                    <div class="article2">
                        <h4><span><a href="<?php if ($productLikeDetailsRow->user_name == ''){echo 'user/administrator';}else {echo 'user/'.$productLikeDetailsRow->user_name;}?>">By <?php echo $fullName;?></a></span>  </h4>
                          <!--<span class="brand"><a href="javascript:">Arrow</a></span>-->
                    </div>
                </li>
                <?php
                }
                ?>
            </ul>
            
            <div id="infscr-loading" style="display:none;">
                <span class="loading">Loading...</span>
               </div>                
            <div class="pagination" style="display:none">
                 <?php echo $paginationDisplay; ?>
            </div>
            
            
            <?php }else {?>
            <div class="no-result">
            <p style="padding: 20px;float: left;text-align:"><?php if($this->lang->line('product_noavail') != '') { echo stripslashes($this->lang->line('product_noavail')); } else echo "No products available"; ?></p>
            </div>
            <?php }?>
            <div class="clear"></div>
        </div>
        
        <!--<div class="brand_product panes">
            <div class="clear"></div>
        </div>
        
        <div class="brand_product panes">
            <div class="clear"></div>
        </div>
        
        <div class="brand_product panes">
            <div class="clear"></div>
        </div>
        
        <div class="brand_product panes">
            <div class="clear"></div>
        </div>-->
        
        
    </div>
</div>
<div class="clear"></div>
<!-- Section_end -->
<?php
$this->load->view('site/templates/footer');
?>
<script type="text/javascript">
</script>
<script type="text/javascript">
$(document).ready(function(){
    
    $('ul.tabs li').click(function(){
        var index = $(this).index();
        $('ul.tabs li').removeClass('active');
        $(this).addClass('active');
        $('.panes').hide();
        $('.panes').eq(index).show();
        return false;
    });
    
    
    

var loading=false;
var $win     = $(window),
$stream  = $('ul.product_main_thumb');
$(window).scroll(function() { 
    //detect page scroll
    
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

                    if($html.find('ul.product_main_thumb').text() == ''){
                        //$stream.append('<ul class="product_main_thumb"><li style="width: 100%;"><p class="noproducts">No more products available</p></li></ul>');
                    }else {
                        $stream.append( $html.find('ul.product_main_thumb').html());
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
    
})
</script>