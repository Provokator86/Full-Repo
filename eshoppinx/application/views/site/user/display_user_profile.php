<?php
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);

?>
<style>
</style> 
<!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
        <?php 
            $this->data['followingUserDetails'] = $userProfileDetails;
            $this->load->view('site/user/display_user_header',$this->data);
        ?>
            
            <div class="trending">
                <div class="trending_lft">
                    <ul class="tabs">
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/lists"><span><?php echo $total_collection; ?></span> <?php if($this->lang->line('user_collections') != '') { echo stripslashes($this->lang->line('user_collections')); } else echo "Collections"; ?></a></li>
                        <li class="active"><a href="<?php echo base_url('user') ?>/<?php echo $userProfileDetails->row()->user_name;?>"><span><?php echo $total_saved; ?></span> <?php if($this->lang->line('user_saved') != '') { echo stripslashes($this->lang->line('user_saved')); } else echo "Saved Products"; ?></a></li>
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/stories"><span><?php echo $total_story; ?></span> <?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories"; ?></a></li>
                        <li class="trending_rht odd"><a href="javascript:">New Collection</a></li>
                        <li class="trending_rht odd"><a href="javascript:">Organize</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="trading_people panes">
                
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes odd" style="display:block;">
                <?php if(count($product_details)>0){?>
                <ul>
                <?php 
                foreach ($product_details as $productLikeDetailsRow){
                    /*echo '<pre>';
                    print_r($productLikeDetailsRow);*/
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
                        $prod_uname = $productLikeDetailsRow->user_name;
                        if ($prod_uname=='') $prod_uname='anonymous';
                        //$prod_link = 'user/'.$productLikeDetailsRow->user_name.'/things/'.$productLikeDetailsRow->seller_product_id.'/'.url_title($productLikeDetailsRow->product_name,'-');
                        $prod_link = 'user/'.$prod_uname.'/things/'.$productLikeDetailsRow->seller_product_id.'/'.url_title($productLikeDetailsRow->product_name,'-');
                    }else {
                        $prod_link = 'things/'.$productLikeDetailsRow->id.'/'.url_title($productLikeDetailsRow->product_name,'-');
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
                    ?>
                    <!--<li>
                        <img style="max-height: 204px;" src="images/product/thumb/<?php echo $imgName;?>" alt="">
                        <div class="overlay">
                            <a href="<?php echo $prod_link; ?>"><h3><span>&#8377;</span> <?php echo $productLikeDetailsRow->price; ?></h3></a>
                            <h4><a href="<?php echo $prod_link; ?>"><?php echo $productLikeDetailsRow->product_name; ?></a> <span><a href="<?php echo $prod_link; ?>">By <?php echo $fullName; ?></a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>

                            <div class="butn-overlay save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $productLikeDetailsRow->seller_product_id;?>"> <?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?> <span><?php echo $productLikeDetailsRow->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?> </span>
                            </div>
                        </div>
                    </li>-->
                    
                    <li>
                        <div class="main-box2">
                            <!--<img src="images/product/thumb/<?php echo $imgName;?>" alt="">-->
                            <div class="brandPic">
                                <table cellspacing="0" cellpadding="0" border="0">
                                    <tbody>
                                        <tr>
                                            <td valign="middle" align="center">
                                            <img alt="" src="images/product/thumb/<?php echo $imgName;?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="overlay">
                                <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $productLikeDetailsRow->price;?></h3></a>
                                <h4><a href="<?php echo $prod_link;?>"><?php echo $productLikeDetailsRow->product_name;?></a> </h4> 
                            </div>
                        </div>
                        <div class="article2">
                            <h4><span><a href="user/<?php echo $prod_uname;?>">By <?php echo $fullName;?></a></span>  </h4>
                              <span class="brand"><a href="javascript:">Arrow</a></span>
                        </div>
                    </li>
                    
                    
                    <?php } ?>
                </ul>
                <?php }else {?>
                <div class="no-result">
                    <?php 
                    if ($userProfileDetails->row()->likes>0){
                    ?>
                    <b>Product details not available</b>
                    <?php }else {
                    $userName = $userProfileDetails->row()->full_name;
                    if ($userName == ''){
                        $userName = $userProfileDetails->row()->user_name;
                    }
                    ?>
                    <b><?php echo $userName;?></b> <?php if($this->lang->line('display_has_not') != '') { echo stripslashes($this->lang->line('display_has_not')); } else echo "has not"; ?> <?php echo LIKED_BUTTON;?> <?php if($this->lang->line('display_any_yet') != '') { echo stripslashes($this->lang->line('display_any_yet')); } else echo "anything yet"; ?>.
                    <?php }?>
                </div>
                <?php } ?>
                <div class="clear"></div>
            </div>
            
            <div class="people_story panes">
                <div class="people_story_lt">
                    <img src="images/site_new/profile_pic2_small.jpg" alt="">
                </div>
                
                <div class="people_story_rht">
                    <div class="people_story_rht_top">
                        <h2>Jeniffer <span>posted from</span> Whatevers</h2>
                        <em>7 months ago</em>
                    </div>
                    
                    <div class="people_story_rht_bottom">
                        <h2>shoutout to my boyscouts out there </h2>
                        
                        <div class="brand_product odd">
                            <ul>
                                <li>
                                    <img src="images/site_new/brand1.jpg" alt="">
                                    <div class="overlay">
                                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                                    </div>
                                </li>
                                <li>
                                    <img src="images/site_new/brand2.jpg" alt="">
                                    <div class="overlay">
                                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                                    </div>
                                </li>
                                <li>
                                    <img src="images/site_new/brand3.jpg" alt="">
                                    <div class="overlay">
                                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                                    </div>
                                </li>
                                <li>
                                    <img src="images/site_new/brand4.jpg" alt="">
                                    <div class="overlay">
                                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                                    </div>
                                </li>
                                <li>
                                    <img src="images/site_new/brand5.jpg" alt="">
                                    <div class="overlay">
                                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                                    </div>
                                </li>
                                <li>
                                    <img src="images/site_new/brand6.jpg" alt="">
                                    <div class="overlay">
                                        <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                                        <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
          <span class="brand"><a href="brand_details.html">Arrow</a></span>
                                        <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                                    </div>
                                </li>
                            </ul>
                            <div class="clear"></div>
                        </div>
                        <div class="like_share">
                            <span>8 people liked this</span>
                            <a href="#">· Like</a>
                            <a href="#">· Share</a>
                            <a href="#">· Repost</a>
                        </div>
                    </div>
                    
                    <div class="post_blog">
                        <ul>
                            <li>
                                <img src="images/site_new/blog_pic1.jpg" alt="">
                                <h2>sunkissedsteph</h2>
                                <p>Hi! I sent you an email earlier this week about featuring your Wanelo profile! Have a look and let me know what you think!</p>
                                <span>about a month ago <a href="#">report</a></span>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="images/site_new/blog_pic2.jpg" alt="">
                                <h2>sunkissedsteph</h2>
                                <p>Hi! I sent you an email earlier this week about featuring your Wanelo profile! Have a look and let me know what you think!</p>
                                <span>about a month ago <a href="#">report</a></span>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="images/site_new/blog_pic3.jpg" alt="">
                                <h2>sunkissedsteph</h2>
                                <p>Hi! I sent you an email earlier this week about featuring your Wanelo profile! Have a look and let me know what you think!</p>
                                <span>about a month ago <a href="#">report</a></span>
                                <div class="clear"></div>
                            </li>
                            <li>
                                <img src="images/site_new/blog_pic4.jpg" alt="">
                                <h2>sunkissedsteph</h2>
                                <p>Hi! I sent you an email earlier this week about featuring your Wanelo profile! Have a look and let me know what you think!</p>
                                <span>about a month ago <a href="#">report</a></span>
                                <div class="clear"></div>
                            </li>
                        </ul>
                        
                        <div class="comment_area">
                            <form action="#" method="post">
                                <div>
                                    <img src="images/site_new/profile_blank2.jpg" alt="">
                                    <input type="text" class="input1" placeholder="Comment, @mention, #hastag">
                                    <input type="submit" class="post" value="POST">
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
                <ul>
                    <li>
                        <img src="images/site_new/brand9.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand10.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand11.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand12.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    
                </ul>
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
                <ul>
                    <li>
                        <img src="images/site_new/brand9.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand10.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand11.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand12.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand5.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand5.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand6.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                    <li>
                        <img src="images/site_new/brand12.jpg" alt="">
                        <div class="overlay">
                            <a href="product_details.html"><h3><span>&#8377;</span> 499</h3></a>
                            <h4><a href="product_details.html">Time escape ss2014 lookbook</a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
<span class="brand"><a href="brand_details.html">Arrow</a></span>
                            <div class="butn-overlay"> SAVE <span>743  saves</span></div>
                        </div>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
<!-- Section_end -->
<script type="text/javascript">
</script>
<?php
$this->load->view('site/templates/footer');
?>