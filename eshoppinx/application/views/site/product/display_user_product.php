<?php
include_once 'application/views/site/user/make_user_link.php';
$make_user_link = new MyCallback($users_list);
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>

<link href="css/site/jquery.bxslider.css" rel="stylesheet" type="text/css" media="all">
<script src="js/site/jquery.bxslider.js"></script>

<script type="text/javascript">
		$(function() {
    		$('.slide').bxSlider({
                pagerCustom: '#slide_thumb'
            });
		});
</script>
                        
<script type="text/javascript">
$(function() {

    $(".submit").click(function() {
        var requirelogin = $(this).attr('require-login');

        if(requirelogin){
            var thingURL = $(this).parent().next().find('a:first').attr('href');
            $(".sign_box:first").trigger('click');
            return false;
        }
        var comments = $("#comments").val();
        var product_id = $("#cproduct_id").val();
        var dataString = '&comments=' + comments + '&cproduct_id=' + product_id;

        if(comments=='')
        {
            alert('Your comment is empty');
        }
        else
        {
            $("#flash").show();
            $("#flash").fadeIn(400).html('<img src="images/ajax-loader.gif" align="absmiddle">&nbsp;<span class="loading">Loading Comment...</span>');
            $.ajax({
                type: "POST",
                url: baseURL+'site/order/insert_product_comment',
                data: dataString,
                cache: false,
                dataType:'json',
                success: function(json){
                    if(json.status_code == 1){
                    alert('Your comment is waiting for approval');
                    window.location.reload();
                    }
                    document.getElementById('comments').value='';
                    $("#flash").hide();
                }
            });
        }
        return false;
    });

});
</script>               

<?php if($productDetails->num_rows()==0) { ?>
    <?php if($this->lang->line('product_unavail') != '') { echo stripslashes($this->lang->line('product_unavail')); } else echo "Product details not available"; ?>
<?php } else { 
    $prodImg = 'dummyProductImage.jpg';
    $prodImgArr = array_filter(explode(',', $productDetails->row()->image));
    
    if (count($prodImgArr)>0){
        foreach ($prodImgArr as $prodImgArrRow){
            if (file_exists('images/product/'.$prodImgArrRow)){
                $prodImg = $prodImgArrRow;
                break;
            }
        }
    }
    $userName = 'administrator';
    $fullName = 'administrator';
    if ($productUserDetails->num_rows() > 0){
        $userName = $productUserDetails->row()->user_name;
        $fullName = $productUserDetails->row()->full_name;
        if ($fullName == '')$fullName=$userName;
    }
    $userImg = 'default_user.jpg';
    if ($productUserDetails->row()->thumbnail != ''){
        if (file_exists('images/users/'.$productUserDetails->row()->thumbnail)){
            $userImg = $productUserDetails->row()->thumbnail;
        }
    }
?>
<?php } ?>

<!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
            
        <?php 
        if ($loginCheck==''){ 
        ?>
        
            <?php 
            $current_user_img = 'default_user.jpg';
            if ($loginCheck != ''){
                if ($userDetails->row()->thumbnail != ''){
                    if (file_exists('images/users/'.$userDetails->row()->thumbnail)){
                        $current_user_img = $userDetails->row()->thumbnail;
                    }
                }
            }
            if ($productDetails->num_rows()==0){
            ?>            
            <?php 
            }else { 
            
                //$userImg = 'default_user.jpg';
                $userImg = 'profile_pic2.jpg';
                if ($productUserDetails->row()->thumbnail != ''){
                    if (file_exists('images/users/'.$productUserDetails->row()->thumbnail)){
                        $userImg = $productUserDetails->row()->thumbnail;
                    }
                }
                $prodImg = 'dummyProductImage.jpg';
                $prodImgArr = array_filter(explode(',', $productDetails->row()->image));
                if (count($prodImgArr)>0){
                    foreach ($prodImgArr as $prodImgArrRow){
                        if (file_exists('images/product/'.$prodImgArrRow)){
                            $prodImg = $prodImgArrRow;
                            break;
                        }
                    }
                }
                
                $userName = 'administrator';
                $fullName = 'administrator';
                if ($productUserDetails->num_rows() > 0){
                    $userName = $productUserDetails->row()->user_name?$productUserDetails->row()->user_name:$userName;
                    $fullName = $productUserDetails->row()->full_name;
                    if ($fullName == '')$fullName=$userName;
                }
                $followClass = 'follow_btn';
                $followText  = 'Follow';
                if ($loginCheck != ''){
                    $followingListArr = explode(',', $userDetails->row()->following);
                    if (in_array($productUserDetails->row()->id, $followingListArr)){
                        $followClass = 'following_btn';
                        $followText = 'Following';
                    }
                } 
                $web_link = $productDetails->row()->web_link;
                if ($web_link != ''){
                if (substr($web_link, 0,4) != 'http'){
                    $web_link = 'http://'.$web_link;    
                }
                if ($productDetails->row()->affiliate_code!=''){
                    $separator = (parse_url($web_link, PHP_URL_QUERY) == NULL) ? '?' : '&';
                       $web_link .= $separator . str_replace('"', "'", $productDetails->row()->affiliate_code);
                }
            }
               
            ?>
            <div class="product_dtls">
                <div class="product_dtls_top">
                    <img src="images/users/<?php echo $userImg;?>" alt="">
                    <h2><?php echo $fullName;?> <?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?> </h2>
                    <p><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo timespan($time_ago1); ?></p>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="product_dtls_mid">
                <div class="pro_dtls_lft">
                    
                    <?php if (count($prodImgArr)>0){ ?>
                    <ul class="slide">
                        <?php 
                            $prod_Img = 'dummyProductImage.jpg';
                            
                            foreach ($prodImgArr as $prodImgArrRow){
                                if (file_exists('images/product/'.$prodImgArrRow)){
                                      $prod_Img = $prodImgArrRow;
                                }
                                
                            
                        ?>
                        <li><img src="images/product/<?php echo $prod_Img; ?>" alt=""></li>
                        <?php  } ?>
                    </ul>
                    
                    <div id="slide_thumb">
                        <?php 
                            $prod_Img = 'dummyProductImage.jpg';
                            foreach ($prodImgArr as $prodImgArrRow){
                                if (file_exists('images/product/'.$prodImgArrRow)){
                                      $prod_Img = $prodImgArrRow;
                                }
                                
                            
                        ?>
                        <a data-slide-index="0" href="">
                        <img style="max-height: 62px; max-width: 72px;" src="images/product/thumb/<?php echo $prod_Img; ?>" alt=""></a>
                        <?php  } ?>
                    </div>
                    <?php } else { ?>
                        <ul class="slide">
                            <li><img src="images/product/<?php echo $prod_Img; ?>" alt=""></li>
                        </ul>
                        
                        <div id="slide_thumb">
                            <a data-slide-index="0" href="">
                            <img style="max-height: 62px; max-width: 72px;" src="images/product/thumb/<?php echo $prod_Img; ?>" alt="">
                            </a>
                        </div>
                    <?php } ?>
                   
                    
                    <!-- COMMENTS LIST START -->
                    <?php 
                        if ($productComment->num_rows() > 0){
                        foreach ($productComment->result() as $cmtrow){
                        if ($cmtrow->status == 'Active'){
                    ?>
                        <div class="tweet_comments_main" style="margin:0 0 0 80px">
                            <div class="tweet_comment" style="background:#FFF">
                                <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                                <div class="comments_detail_content">
                                    <a href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>" class="comments_detail_name"><?php echo ucfirst($cmtrow->user_name);?></a>
                                    <p class="comments_detail_email cmt_cnt_16">
                                    <?php
                                    $cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
                                    echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                                    ?>
                                    </p>
                                    <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded); echo time_stamp($time_ago); ?> </span>
                                </div>
                            </div>
                        </div>
                    <?php } } } ?>        
                    <!-- COMMENTS LIST END-->
                </div>
                
                <div class="pro_dtls_rht">
                    <h2><?php echo $productDetails->row()->product_name;?></h2>
                    <h3>
                        <?php if ($productDetails->row()->store_name != ''){?>
                          <?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From"; ?>
                          <a href="store/<?php echo $productDetails->row()->store_name;?>"> <?php echo $productDetails->row()->store_name;?></a>
                          <?php }else {?>
                      <?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From";?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                      <?php }?>
                      </h3>
                    
                    <div class="logo_link">
                        <?php if($store_details->row()->store_logo!=''){                        
                            $storeImg = 'dummy_store_logo.png';
                            if ($store_details->row()->store_logo != ''){
                                $storeImg = $store_details->row()->store_logo;
                            }
                        ?>
                        <a href="store/<?php echo $productDetails->row()->store_name;?>">                       
                            <div class="storePic">
                                <table  cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td valign="middle" align="center">
                                             <img src="images/store/<?php echo $storeImg;?>" alt="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </a>
                        <?php } ?>
                        <a href="javascript:"><img src="images/site_new/solly-logo.png" alt=""></a>
                    </div>
                    
                    <a href="#" class="sign-save sign_box">Sign in to save or buy this product</a>
                    
                   
                    <div class="clear"></div>
                    
                    
                </div>
                <div class="clear"></div>
            </div>
            
            <?php } ?>
            
        <?php } else { ?>
        
            <?php 
            $current_user_img = 'default_user.jpg';
            if ($loginCheck != ''){
                if ($userDetails->row()->thumbnail != ''){
                    if (file_exists('images/users/'.$userDetails->row()->thumbnail)){
                        $current_user_img = $userDetails->row()->thumbnail;
                    }
                }
            }
            if ($productDetails->num_rows()==0){
            ?>            
            <?php 
            }else { 
            
                //$userImg = 'default_user.jpg';
                $userImg = 'profile_pic2.jpg';
                if ($productUserDetails->row()->thumbnail != ''){
                    if (file_exists('images/users/'.$productUserDetails->row()->thumbnail)){
                        $userImg = $productUserDetails->row()->thumbnail;
                    }
                }
                $prodImg = 'dummyProductImage.jpg';
                $prodImgArr = array_filter(explode(',', $productDetails->row()->image));
                if (count($prodImgArr)>0){
                    foreach ($prodImgArr as $prodImgArrRow){
                        if (file_exists('images/product/'.$prodImgArrRow)){
                            $prodImg = $prodImgArrRow;
                            break;
                        }
                    }
                }
                
                $userName = 'administrator';
                $fullName = 'administrator';
                if ($productUserDetails->num_rows() > 0){
                    $userName = $productUserDetails->row()->user_name?$productUserDetails->row()->user_name:$userName;
                    $fullName = $productUserDetails->row()->full_name;
                    if ($fullName == '')$fullName=$userName;
                }
                $followClass = 'follow_btn';
                $followText  = 'Follow';
                if ($loginCheck != ''){
                    $followingListArr = explode(',', $userDetails->row()->following);
                    if (in_array($productUserDetails->row()->id, $followingListArr)){
                        $followClass = 'following_btn';
                        $followText = 'Following';
                    }
                } 
                $web_link = $productDetails->row()->web_link;
                if ($web_link != ''){
                if (substr($web_link, 0,4) != 'http'){
                    $web_link = 'http://'.$web_link;    
                }
                if ($productDetails->row()->affiliate_code!=''){
                    $separator = (parse_url($web_link, PHP_URL_QUERY) == NULL) ? '?' : '&';
                       $web_link .= $separator . str_replace('"', "'", $productDetails->row()->affiliate_code);
                }
            }
               
            ?>
            <div class="product_dtls">
                <div class="product_dtls_top">
                    <img src="images/users/<?php echo $userImg;?>" alt="">
                    <h2><?php echo $fullName;?> <?php if($this->lang->line('product_postedto') != '') { echo stripslashes($this->lang->line('product_postedto')); } else echo "posted this to"; ?> <?php echo $siteTitle;?> </h2>
                    <p><?php if($this->lang->line('settings_about') != '') { echo stripslashes($this->lang->line('settings_about')); } else echo "about"; ?> <?php $time_ago1 =strtotime($productDetails->row()->created); echo timespan($time_ago1); ?></p>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
           
            
            <div class="product_dtls_mid">
                <div class="pro_dtls_lft">
                    
                    <?php if (count($prodImgArr)>0){ ?>
                    <ul class="slide">
                        <?php 
                            $prod_Img = 'dummyProductImage.jpg';
                            
                            foreach ($prodImgArr as $prodImgArrRow){
                                if (file_exists('images/product/'.$prodImgArrRow)){
                                      $prod_Img = $prodImgArrRow;
                                }
                                
                            
                        ?>
                        <li><img src="images/product/<?php echo $prod_Img; ?>" alt=""></li>
                        <?php  } ?>
                    </ul>
                    
                    <div id="slide_thumb">
                        <?php 
                            $prod_Img = 'dummyProductImage.jpg';
                            foreach ($prodImgArr as $prodImgArrRow){
                                if (file_exists('images/product/'.$prodImgArrRow)){
                                      $prod_Img = $prodImgArrRow;
                                }
                                
                            
                        ?>
                        <a data-slide-index="0" href="">
                        <img style="max-height: 62px; max-width: 72px;" src="images/product/thumb/<?php echo $prod_Img; ?>" alt=""></a>
                        <?php  } ?>
                    </div>
                    <?php } else { ?>
                        <ul class="slide">
                            <li><img src="images/product/<?php echo $prod_Img; ?>" alt=""></li>
                        </ul>
                        
                        <div id="slide_thumb">
                            <a data-slide-index="0" href="">
                            <img style="max-height: 62px; max-width: 72px;" src="images/product/thumb/<?php echo $prod_Img; ?>" alt="">
                            </a>
                        </div>
                    <?php } ?>
                    
                    
                    <div class="social_info">
                        <a href="javascript:"><img src="images/site_new/social_icons.jpg" alt=""></a>
                    </div>
                    
                    <!-- COMMENTS LIST START -->
                    <?php 
                    if ($productComment->num_rows() > 0){
                    ?>
                    <div class="tweet_comments_main"> <a class="tweet_seemore" href="javascript:void(0);"><?php if($this->lang->line('product_comments') != '') { echo stripslashes($this->lang->line('product_comments')); } else echo "Comments"; ?></a>   
        
        
                    <?php 
                    if ($productComment->num_rows() > 0){
                        foreach ($productComment->result() as $cmtrow){
                            $cmt_uname = $cmtrow->full_name;
                            if ($cmt_uname==''){
                                $cmt_uname = $cmtrow->user_name;
                            }
                            if ($cmtrow->status == 'Active'){
                                
                        
                    ?>
                    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
                <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
                <?php 
                $cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
                echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                ?> 
                </p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
                echo time_stamp($time_ago); ?> </span> </div>
                <?php 
                if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id || $loginCheck != '' && $loginCheck == $cmtrow->CUID){
                ?>
                <p style="float:left;width:100%;text-align:left;">
                <?php if ($loginCheck == $cmtrow->CUID){?>
                            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
                <?php }?>
                            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
                <?php ?>        </p>
                <?php 
                }
                ?>  
                </div>
                    <?php 
                            }else {
                                if ($loginCheck != '' && $loginCheck == $productDetails->row()->user_id){
                    ?>
                    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
                <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
                <?php 
                $cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
                echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                ?> 
                </p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
                echo time_stamp($time_ago); ?> </span> </div>
                <p style="float:left;width:100%;text-align:left;">
                            <a style="font-size: 11px; color: #188A0E;cursor:pointer;" onclick="javascript:approveCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_approve') != '') { echo stripslashes($this->lang->line('product_approve')); } else echo "Approve"; ?></a>
                            <?php if ($loginCheck == $cmtrow->CUID){?>
                            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
                            <?php }?>
                            <a style="font-size: 11px; color: #f33;cursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
                        </p>
                </div>
                    
                    <?php         
                                }else {
                                    if ($loginCheck == $cmtrow->CUID){
                    ?>
                    
                    <div class="tweet_comment"> <span class="tweet_comment_avatar"><img src="images/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>" /></span>
                <div class="comments_detail_content"> <a class="comments_detail_name" href="<?php echo base_url();?>user/<?php echo $cmtrow->user_name;?>"><?php echo ucfirst($cmt_uname);?></a> 
                <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
                <?php 
                $cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
                echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
                ?> 
                </p> <span class="comments_detail_day"><?php  $time_ago =strtotime($cmtrow->dateAdded);
                echo time_stamp($time_ago); ?> </span> </div>
                <p style="float:left;width:100%;text-align:left;font-size: 11px; color: #188A0E; cursor:pointer;">
                            <?php if($this->lang->line('product_wait_appr') != '') { echo stripslashes($this->lang->line('product_wait_appr')); } else echo "Waiting for approval"; ?>
                            <a style="font-size: 11px; color: #0033FF;cursor:pointer;" onclick="javascript:editCmt(this);" data-uid="<?php echo $cmtrow->CUID;?>" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('shipping_edit') != '') { echo stripslashes($this->lang->line('shipping_edit')); } else echo "Edit"; ?></a>
                            <a style="font-size: 11px; color: #f33;margin-left:10pxcursor:pointer;" onclick="javascript:deleteCmt(this);" data-tid="<?php echo $productDetails->row()->seller_product_id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
                        </p>
                </div>
                    
                    <?php 
                                    }
                                }


                            }
                        }
                    }?>
                    
                    </div>
                    <div class="clear"></div>
                    <?php
                    }
                    ?>
                    <!-- COMMENTS LIST END-->
                    
                    <div class="comment_area odd">
                        <form action="#" method="post">
                            <input type="hidden" name="cproduct_id" id="cproduct_id" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
                            <div>
                                <img src="images/users/<?php echo $current_user_img;?>" alt="">
                                <input type="text" class="input1" name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Comment, @mention, #hastag"; ?>..." id="comments" >
                                <input type="submit" class="post post_btn1 submit button" <?php if($loginCheck==''){ ?>require-login='true'<?php }?> class="post_btn1 submit button" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "POST"; ?>">
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="pro_dtls_rht">
                    <h2><?php echo $productDetails->row()->product_name;?></h2>
                    <h3>
                        <?php if ($productDetails->row()->store_name != ''){?>
                          <?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From"; ?>
                          <a href="store/<?php echo $productDetails->row()->store_name;?>"> <?php echo $productDetails->row()->store_name;?></a>
                          <?php }else {?>
                      <?php if($this->lang->line('from') != '') { echo stripslashes($this->lang->line('from')); } else echo "From";?> <a href="user/<?php echo $userName;?>"><?php echo $fullName;?></a>
                      <?php }?>
                      </h3>
                    <?php 
                    /*echo '<pre>';
                    print_r($productDetails->row());*/
                    ?>
                    <div class="logo_link">
                        <?php if($store_details->row()->store_logo!=''){                        
                            $storeImg = 'dummy_store_logo.png';
                            if ($store_details->row()->store_logo != ''){
                                $storeImg = $store_details->row()->store_logo;
                            }
                        ?>
                        <a href="store/<?php echo $productDetails->row()->store_name;?>">                       
                            <div class="storePic">
                                <table  cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td valign="middle" align="center">
                                             <img src="images/store/<?php echo $storeImg;?>" alt="">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </a>
                        <?php } ?>
                        <a href="javascript:"><img src="images/site_new/solly-logo.png" alt=""></a>
                    </div>
                    
                    <div class="save_buy_box">
                        <a href="javascript:void(0);" data-pid="<?php echo $productDetails->row()->seller_product_id;?>" class="full_box save_btn save <?php if ($loginCheck==''){echo 'sign_box';}?>"><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "SAVE"; ?>:</a>
                        <a href="javascript:void(0);" data-pid="<?php echo $productDetails->row()->seller_product_id;?>" class="blank_box save_btn save <?php if ($loginCheck==''){echo 'sign_box';}?>"><?php echo $seller_prod->row()->count; ?></a>
                    </div>
                    
                    <?php 
                        $web_link = $productDetails->row()->web_link;
                        if ($web_link != ''){
                            if (substr($web_link, 0,4) != 'http'){
                                $web_link = 'http://'.$web_link;    
                            }
                            if ($productDetails->row()->affiliate_code!=''){
                                $separator = (parse_url($web_link, PHP_URL_QUERY) == NULL) ? '?' : '&';
                                   $web_link .= $separator . str_replace('"', "'", $productDetails->row()->affiliate_code);
                            }
                      ?>
          
                    <div class="save_buy_box">
                        <a href="<?php echo $web_link;?>" target="_blank" class="full_box"><?php if($this->lang->line('product_buy') != '') { echo stripslashes($this->lang->line('product_buy')); } else echo "BUY"; ?>:</a>
                        <a href="<?php echo $web_link;?>" target="_blank" class="blank_box">
                        <span>&#8377;</span><?php echo $productDetails->row()->price; // $currencySymbol?></a>
                        <div class="clear"></div>
                    </div>
                    <?php }?>
                    <div class="clear"></div>
                    
                    <!--<a href="javascript:" class="blank_box2">#twentyonepilots</a>
                    <a href="javascript:" class="blank_box2">#thebestever</a>
                    <div class="clear"></div>-->
                    
                    <div class="social_area">
                        <a href="javascript:">
                            <img src="images/site_new/like.png" alt="">
                            <span>562241 </span>
                            <div class="clear"></div>
                        </a>
                        <a href="javascript:">
                            <img src="images/site_new/twitter3.png" alt="">
                            <span>562241 </span>
                            <div class="clear"></div>
                        </a>
                        <a href="javascript:">
                            <img src="images/site_new/printarest.png" alt="">
                            <span>562241</span>
                            <div class="clear"></div>
                        </a>
                    </div>
                    
                    
                    <?php
                    if ($moreStoreProducts != '' && $moreStoreProducts->num_rows()>0){
                        $followClass = 'follow_btn';
                        $followText  = 'Follow';
                        if ($this->lang->line('onboarding_follow') != ''){
                            $followText  = $this->lang->line('onboarding_follow');
                        }
                        if ($loginCheck != ''){
                            $followingListArr = explode(',', $store_details->row()->followers);
                            if (in_array($loginCheck, $followingListArr)){
                                $followClass = 'following_btn';
                                $followText = 'Following';
                                if ($this->lang->line('display_following') != ''){
                                    $followText  = $this->lang->line('display_following');
                                }
                            }
                        }
                    ?>
                    
                    <!--<a class="add_wishlist" href="javascript:">Add to Wishlist</a>-->
                    <h3><?php if($this->lang->line('product_morefrom') != '') { echo stripslashes($this->lang->line('product_morefrom')); } else echo "more from"; ?>  <a href="store/<?php echo $store_details->row()->store_name;?>"><?php echo $store_details->row()->store_name;?></a></h3>
                    <a 
                    class="fallow right <?php if ($loginCheck==''){echo 'sign_box';}?>  <?php echo $followClass;?>" 
                    href="javascript:" <?php if ($loginCheck != ''){?>
                    data-uid="<?php echo $store_details->row()->id;?>"
                    onclick="javascript:follow_store(this);" <?php }?> ><?php echo $followText;?>
                    </a>
                    
                    <div class="other_products">
                    <?php 
                    
                    
                    ?>
                        <ul>
                        <?php
                         $i = 0;
                         foreach ($moreStoreProducts->result() as $MoreFrom){
                        if($productDetails->row()->seller_product_id != $MoreFrom->seller_product_id){
                            $prodImg1= 'dummyProductImage.jpg';
                            $prodImgArr1 = array_filter(explode(',', $MoreFrom->image));
                            if(count($prodImgArr1)){
                                $prodImg1=$prodImgArr1[0];
                                if ($i++ == 6) break;
                            }
                            if (isset($MoreFrom->web_link)){
                                if($MoreFrom->user_name=='')
                                $MoreFrom->user_name = 'administrator';
                                $prod_link = 'user/'.$MoreFrom->user_name.'/things/'.$MoreFrom->seller_product_id.'/'.str_replace(' ','-',$MoreFrom->product_name);
                            }else {
                                $prod_link = 'things/'.$MoreFrom->id.'/'.str_replace(' ','-',$MoreFrom->product_name.'/'.$MoreFrom->seller_product_id);
                            }
                        ?>
                            <li><a href="<?php echo $prod_link; ?>">
                            <img src="<?php echo base_url();?>images/product/thumb/<?php echo $prodImg1;?>" alt=""></a>
                            </li>
                        <?php
                            $prodImg='';
                            } 
                         }  
                        ?>
                        </ul>
                        <div class="clear"></div>
                    </div>                    
                    <?php }?>
                    
                </div>
                <div class="clear"></div>
            </div>
            
            <?php } ?>
        
        <?php } // end login check ?>
            <div class="product_dtls_btm">
                <h2>shoutout to my boyscouts out there </h2>
                
                <div class="brand_product odd">
                <?php if (count($products_list) > 0) { ?>
                    <ul>
                    <?php 
                    //$query = $query->result_array();
                    $products_list=$products_list->result_array();
                    foreach ($products_list as $products_list_row){
                        $prodImg = 'dummyProductImage.jpg';
                        $prodImgArr = array_filter(explode(',', $products_list_row['image']));
                        if (count($prodImgArr)>0){
                            foreach ($prodImgArr as $prodImgArrRow){
                                if (file_exists('images/product/thumb/'.$prodImgArrRow)){
                                    $prodImg = $prodImgArrRow;
                                    break;    
                                }
                            }
                        }
                       
                        
                        $userName = 'administrator';
                        $fullName = 'administrator';
                        if ($products_list_row['user_id'] > 0){
                            $sql = "select * from ".USERS." where id='".$products_list_row['user_id']."'";
                            $query = $this->db->query($sql);
                            $sliderResult = $query->row_array();
                            $userName = $sliderResult['user_name']?$sliderResult['user_name']:$userName;
                            $fullName = $sliderResult['full_name']?character_limiter($sliderResult['full_name'],20):$userName;
                            if (strlen($fullName)>20){
                                $fullName = substr($fullName, 0,20).'..';    
                            }
                            $userImg = $sliderResult['thumbnail'];
                        }
                        
                        if ($fullName == ''){
                            $fullName = $userName;
                        }
                        
                        if ($userImg==''){
                            $userImg = 'default_user.jpg';
                        }
                        
                        if($products_list_row['web_link'] != 'None'){
                            $prod_link = 'user/'.$userName.'/things/'.$products_list_row['seller_product_id'].'/'.url_title($products_list_row['product_name'],'-');
                        }else {
                            $prod_link = 'things/'.$products_list_row['id'].'/'.url_title($products_list_row['product_name'],'-');
                        }
                    ?>
                        <li>
                            <div class="main-box2">
                                <!--<img src="images/product/thumb/<?php echo $prodImg;?>" alt="">-->                    
                                <div class="brandPic">
                                    <table  cellspacing="0" cellpadding="0" border="0">
                                        <tbody>
                                            <tr>
                                                <td valign="middle" align="center">
                                                <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="overlay">
                                <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $products_list_row['price'];?></h3></a>
                                <h4><a href="<?php echo $prod_link;?>"><?php echo $products_list_row['product_name'];?></a> </h4>
                                </div>
                            </div>
                            <div class="article2">
                                <h4><span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span> </h4>
                                  <span class="brand"><a href="javascript:">Arrow</a></span>
                            </div>
                    </li>
                    <?php 
                        }
                     ?>
                    </ul>
                <?php } ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>

<!-- Section_end -->
<?php 
if ($productDetails->row()->affiliate_script != ''){
echo $productDetails->row()->affiliate_script;
}
?>
<?php
//Php Time_Ago Script v1.0.0
//Scripted by D.Harish Kumar@TYSON567
function time_stamp($time_ago)
{
$cur_time=time();
$time_elapsed = $cur_time - $time_ago;
$seconds = $time_elapsed ;
$minutes = round($time_elapsed / 60 );
$hours = round($time_elapsed / 3600);
$days = round($time_elapsed / 86400 );
$weeks = round($time_elapsed / 604800);
$months = round($time_elapsed / 2600640 );
$years = round($time_elapsed / 31207680 );
// Seconds
if($seconds <= 60)
{
echo "$seconds seconds ago";
}
//Minutes
else if($minutes <=60)
{
if($minutes==1)
{
echo "one minute ago";
}
else
{
echo "$minutes minutes ago";
}
}
//Hours
else if($hours <=24)
{
if($hours==1)
{
echo "an hour ago";
}
else
{
echo "$hours hours ago";
}
}
//Days
else if($days <= 7)
{
if($days==1)
{
echo "yesterday";
}
else
{
echo "$days days ago";
}
}
//Weeks
else if($weeks <= 4.3)
{
if($weeks==1)
{
echo "a week ago";
}
else
{
echo "$weeks weeks ago";
}
}
//Months
else if($months <=12)
{
if($months==1)
{
echo "a month ago";
}
else
{
echo "$months months ago";
}
}
//Years
else
{
if($years==1)
{
echo "one year ago";
}
else
{
echo "$years years ago";
}
}
}
?>

<?php
$this->load->view('site/templates/footer');
?>

