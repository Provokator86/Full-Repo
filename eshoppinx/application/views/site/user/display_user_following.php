<?php 
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);
?>  
<!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
        <?php 
            $this->data['followingUserDetails'] = $userProfileDetails;
            $this->load->view('site/user/display_user_header',$this->data);
        ?>
            <?php /* ?>
            <div class="trending">
                <div class="trending_lft">
                    <ul class="tabs">                        
                        <li class="active"><a style="width:100%;" href="user/<?php echo $userProfileDetails->row()->user_name;?>"><?php if ($userProfileDetails->row()->full_name!=''){echo $userProfileDetails->row()->full_name;}else {echo $userProfileDetails->row()->user_name;}?> / Following</a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <?php */ ?>
            
            <!--<div class="brand_product panes odd" style="display:block;">-->               
            <div class="trading_people">               
            <?php 
                if($followingUserDetails->num_rows()>0){
                    foreach ($followingUserDetails->result() as $followingUserRow){
                    //print_r($followingUserRow);
                        $userImg = 'user-thumb1.png';
                        if ($followingUserRow->thumbnail != ''){
                            if (file_exists('images/users/'.$followingUserRow->thumbnail)){
                                $userImg = $followingUserRow->thumbnail;
                            }
                        } 
                        $followClass = 'follow_btn';
                        $followText = 'Follow';
                        if ($loginCheck != ''){
                            $followingListArr = explode(',', $userDetails->row()->following);
                            if (in_array($followingUserRow->id, $followingListArr)){
                                $followClass = 'following_btn';
                                $followText = 'Following';
                            }
                        } 
                ?>  
                
                <div class="box">
                    <div class="box_head">
                        
                        <a href="user/<?php echo $followingUserRow->user_name;?>">
                        <span class="follow_icon">
                        <img src="images/users/<?php echo $userImg;?>" alt="">
                        </span>
                        </a>
                        <a href="user/<?php echo $followingUserRow->user_name;?>"><h2><?php echo $followingUserRow->user_name;?></h2></a>
                        <span><?php echo $followingUserRow->following_count;?> Following</span>
                         <a class="<?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>" <?php if ($loginCheck != ''){?>data-uid="<?php echo $followingUserRow->id;?>" onclick="javascript:store_follow(this);"<?php }?> ><?php echo $followText;?></a>
                    </div>
                    <div class="box_body">
                        <div class="brand_product trading_product">
                            <ul>
                                <?php 
                               if (count($followingUserLikeDetails[$followingUserRow->id])>0){
                                   $limitCount = 0;
                                   foreach ($followingUserLikeDetails[$followingUserRow->id] as $likeProdRow){
                                       if ($limitCount==3)break;$limitCount++;
                                       $img = 'dummyProductImage.jpg';
                                       $imgArr = explode(',', $likeProdRow->image);
                                       if (count($imgArr)>0){
                                           foreach ($imgArr as $imgRow){
                                               if ($imgRow != ''){
                                                   if (file_exists('images/product/thumb/'.$imgRow)){
                                                       $img = $imgRow;
                                                       break;
                                                   }
                                               }
                                           }
                                       }
                                       if (isset($likeProdRow->web_link)){
                                           $prod_link = 'user/'.$followingUserRow->user_name.'/things/'.$likeProdRow->seller_product_id.'/'.url_title($likeProdRow->product_name,'-');
                                       }else{
                                           $prod_link = 'things/'.$likeProdRow->id.'/'.url_title($likeProdRow->product_name,'-');
                                       }
                                       
                               ?>
                                                                  
                                
                                                                  
                                <li>
                                    <div class="main-box2">
                                        <div class="brandPic">
                                            <table  cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td valign="middle" align="center">
                                                        <img src="images/product/thumb/<?php echo $img;?>" alt="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="overlay">
                                            <a href="user/<?php echo $followingUserRow->user_name;?>/things/<?php echo $likeProdRow->seller_product_id;?>/<?php echo url_title($likeProdRow->product_name,'-');?>"><h3><span>&#8377;</span> <?php echo $likeProdRow->price;?></h3></a>
                                            <h4><a href="user/<?php echo $followingUserRow->user_name;?>/things/<?php echo $likeProdRow->seller_product_id;?>/<?php echo url_title($likeProdRow->product_name,'-');?>"><?php echo $likeProdRow->product_name ?></a> </h4>
                                        </div>
                                    </div>    
                                    <div class="article2">
                                        <div class="brand"><a href="javascript:">Arrow</a></div>
                                    </div>
                                </li>                                
                                  <?php 
                                      }
                                  } else {
                                  ?>     
                                  <li>
                                    
                                    <div class="brandPic">
                                            <table  cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                    <tr>
                                                        <td valign="middle" align="center">
                                                        <img src="images/product/thumb/dummyProductImage.jpg" alt="">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div> 
                                    <div class="article2">
                                        <div class="brand"><a href="javascript:">&nbsp;</a></div>
                                    </div>
                                  </li>
                                  <?php } ?>             
                                
                            </ul>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>                                                  
                                
                <?php 
                    }
                }else {
               ?> 
                
                <p>0 <?php if($this->lang->line('display_following') != '') { echo stripslashes($this->lang->line('display_following')); } else echo "Following"; ?></p>
                <?php 
                }
                ?>                   
                         
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
$this->load->view('site/templates/footer',$this->data);
?>
