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
                        <li class="active"><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/lists"><span><?php echo $total_collection; ?></span> <?php if($this->lang->line('user_collections') != '') { echo stripslashes($this->lang->line('user_collections')); } else echo "Collections"; ?></a></li>
                        <li><a href="<?php echo base_url('user') ?>/<?php echo $userProfileDetails->row()->user_name;?>"><span><?php echo $total_saved; ?></span> <?php if($this->lang->line('user_saved') != '') { echo stripslashes($this->lang->line('user_saved')); } else echo "Saved Products"; ?></a></li>
                        <li><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/stories"><span><?php echo $total_story; ?></span> <?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories"; ?></a></li>
                        <li class="trending_rht odd"><a href="javascript:">New Collection</a></li>
                        <li class="trending_rht odd"><a href="javascript:">Organize</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            
            <div class="trading_people panes" style="display:block;">
                <?php 
                if (count($listDetails) > 0){
                    foreach ($listDetails->result() as $listDetails){
                    $followClass = 'follow_btn';
                        $followtext= stripslashes($this->lang->line('onboarding_follow'));
                        if ($followtext == ''){
                            $followtext = 'Follow';
                        }
                        if ($loginCheck != ''){
                            $followingListArr = explode(',', $userDetails->row()->following_user_lists);
                            if (in_array($listDetails->id, $followingListArr)){
                                $followClass = 'following_btn';
                                $followtext= stripslashes($this->lang->line('display_following'));
                                if ($followtext == ''){
                                    $followtext = 'Following';
                                }
                            }
                        }    
                ?>  
                <div class="box">
                    <div class="box_head">
                        <h2><?php echo $listDetails->name;?></h2>
                        <span>&nbsp;</span>
                        <!--<a class="follow inactive" href="#">Follow</a>-->
                        <a class="follow <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $listDetails->id;?>" onclick="javascript:list_follow(this);"<?php }?> ><?php echo $followtext;?></a>
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
<?php 
if($prodDetails[$listDetails->id] != '' && count($prodDetails[$listDetails->id])>0){
      $limitCount = 0;
    foreach ($prodDetails[$listDetails->id] as $listDcetailsvals){
        if ($limitCount==3)break;$limitCount++;
        $prodImg = 'dummyProductImage.jpg';
        $prodImgArr = array_filter(explode(',', $listDcetailsvals->image));
        if (count($prodImgArr)>0){
            foreach ($prodImgArr as $prodImgArrRow){
                if (file_exists('images/product/thumb/'.$prodImgArrRow)){
                    $prodImg = $prodImgArrRow;
                    break;
                }
            }
        }
        
        if (isset($listDcetailsvals->web_link)){
            $prod_uname = $listDcetailsvals->user_name;
            if ($prod_uname=='') $prod_uname='anonymous';
                                        
        //$prod_link = 'user/'.$listDcetailsvals->user_name.'/things/'.$listDcetailsvals->seller_product_id.'/'.url_title($listDcetailsvals->product_name,'-');
        $prod_link = 'user/'.$prod_uname.'/things/'.$listDcetailsvals->seller_product_id.'/'.url_title($listDcetailsvals->product_name,'-');
        }else {
        $prod_link = 'things/'.$listDcetailsvals->id.'/'.url_title($listDcetailsvals->product_name,'-');
        }
        
        if ($listDcetailsvals->user_name == ''){
            //$fullName = 'administrator';
            $fullName = 'admin';
        }else {
            $fullName = $listDcetailsvals->full_name;
            if ($fullName == ''){
                $fullName = $listDcetailsvals->user_name;
            }else {
                $fullName = character_limiter($fullName,20);
                if (strlen($fullName)>20){
                    $fullName = substr($fullName, 0,20).'..';
                }
            }
        }
        
        /*echo '<pre>';        
        print_r($listDcetailsvals);*/
                
?>
                            
                            <!--<li>
                                <img style="max-height: 204px;" src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                <div class="overlay">
                                    <a href="<?php echo $prod_link; ?>"><h3><span>&#8377;</span> <?php echo $listDcetailsvals->price; ?></h3></a>
                                    <h4><a href="<?php echo $prod_link; ?>"><?php echo $listDcetailsvals->product_name; ?></a> <span><a href="<?php echo $prod_link; ?>">By <?php echo $fullName; ?></a></span> </h4>
      <span class="brand"><a href="brand_details.html">Arrow</a></span>
      
                                    <div class="butn-overlay save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $listDcetailsvals->seller_product_id;?>"> <?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?> <span><?php echo $listDcetailsvals->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?> </span>
                                    </div>
                                </div>
                            </li>-->
                            
                            
                            <li>
                                <div class="main-box2">
                                    <!--<img src="images/product/thumb/<?php echo $prodImg;?>" alt="">-->
                                    <div class="brandPic">
                                        <table cellspacing="0" cellpadding="0" border="0">
                                            <tbody>
                                                <tr>
                                                    <td valign="middle" align="center">
                                                    <img alt="" src="images/product/thumb/<?php echo $prodImg;?>">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="overlay">
                                        <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $listDcetailsvals->price;?></h3></a>
                                        <h4><a href="<?php echo $prod_link;?>"><?php echo $listDcetailsvals->product_name;?></a> </h4> 
                                    </div>
                                </div>
                                <div class="article2">
                                    <h4><span><a href="user/<?php echo $prod_uname;?>">By <?php echo $fullName;?></a></span>  </h4>
                                      <span class="brand"><a href="javascript:">Arrow</a></span>
                                </div>
                            </li>
                                
<?php 
  }
}
?>                  
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <?php } } ?>        
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
               
                <div class="clear"></div>
            </div>
            
            <div class="people_story panes">                
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
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
</script>
<?php
$this->load->view('site/templates/footer');
?>