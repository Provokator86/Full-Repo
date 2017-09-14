<?php
include_once 'application/views/site/user/make_user_link.php';
$make_user_link = new MyCallback($users_list);
$this->load->view('site/templates/header',$this->data);
$this->load->view('site/templates/popup_product_detail.php',$this->data);

?>
<style>
</style> 
<script type="text/javascript">
$(document).ready(function(){

	//To switch directions up/down and left/right just place a "-" in front of the top/left attribute
	//Vertical Sliding

	$('.boxgrid.captionful').hover(function(){
	//	$(".cover1", this).stop().animate({top:'0px'},{queue:false,duration:750});
		 $(".cover", this).css({ 'display': 'block' });
	}, function() {
	//	$(".cover1", this).stop().animate({top:'295px'},{queue:false,duration:750});
		 $(".cover", this).css({ 'display': 'none' });
	});
	//Caption Sliding (Partially Hidden to Visible)
	
});
</script>
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
                        <li><a href="<?php echo base_url('user') ?>/<?php echo $userProfileDetails->row()->user_name;?>"><span><?php echo $total_saved; ?></span> <?php if($this->lang->line('user_saved') != '') { echo stripslashes($this->lang->line('user_saved')); } else echo "Saved Products"; ?></a></li>
                        <li class="active"><a href="user/<?php echo $userProfileDetails->row()->user_name;?>/stories"><span><?php echo $total_story ?></span> <?php if($this->lang->line('story_stores') != '') { echo stripslashes($this->lang->line('story_stores')); } else echo "Stories"; ?></a></li>
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
            
            <div class="brand_product panes">
                <div class="clear"></div>
            </div>
            
            <div class="people_story panes" style="display:block;">
            <?php 
             //  echo "<pre>"; print_r($stories_details->result());
              if($stories_details->num_rows() > 0){
              
               foreach($stories_details->result() as $stories_details_row){

                    $StoriesuserName = 'administrator';
                    $StoriesfullName = 'administrator';
                    if ($stories_details_row->user_id > 0){
                        $StoriesuserName = $stories_details_row->user_name;
                        $StoriesfullName = $stories_details_row->full_name;
                    }
                    if ($StoriesfullName == ''){
                        $StoriesfullName = $StoriesuserName;
                    }
                    
                    $userImg = 'default_user.jpg';
                    if ($stories_details_row->thumbnail != ''){
                        $userImg = $stories_details_row->thumbnail;
                    } 
             ?>
                <div class="people_story_lt">
                    <img style="max-height: 68px; max-width: 79px;" src="images/users/<?php echo $userImg;?>" alt="">
                </div>
                
                <div class="people_story_rht">
                    <div class="people_story_rht_top">
                        <h2><?php echo $StoriesuserName; ?> <span>posted from</span> Whatevers</h2>
                        <em>
                        <?php $time_ago1 =strtotime($stories_details_row->dateAdded); echo time_stamp($time_ago1); ?>
                        </em>
                    </div>
                    
                    <div class="people_story_rht_bottom">
                        <h2><?php echo $stories_details_row->description; ?> </h2>
                        
                        <div class="brand_product odd">
                            <ul>
             <?php                      
                    /*echo '<pre>';print_r($ProductDetails[$stories_details_row->id]['StoriesProduct']);
                    print_r($ProductDetails[$stories_details_row->id]['StoriesUserProduct']);*/
                      
                if($ProductDetails[$stories_details_row->id]['StoriesProduct']!='' && count($ProductDetails[$stories_details_row->id]['StoriesProduct']) >0){
                
                foreach($ProductDetails[$stories_details_row->id]['StoriesProduct'] as $ProductDetailsRow ){ 
                
                                $prodImg = 'dummyProductImage.jpg';
                                $prodImgArr = array_filter(explode(',', $ProductDetailsRow[0]->image));
                                if (count($prodImgArr)>0){
                                    foreach ($prodImgArr as $prodImgArrRow){
                                        if (file_exists('images/product/'.$prodImgArrRow)){
                                            $prodImg = $prodImgArrRow;
                                            break;    
                                        }
                                    }
                                }
                                
                                $prod_uname = $ProductDetailsRow[0]->user_name;
                                if ($prod_uname=='') $prod_uname='anonymous';
                                    
                                $userName = 'administrator';
                                $fullName = 'administrator';
                                if ($ProductDetailsRow[0]->user_id > 0){
                                    $userName = $ProductDetailsRow[0]->user_name;
                                    $fullName = $ProductDetailsRow[0]->full_name;
                                }
                                if ($fullName == ''){
                                    $fullName = $userName;
                                }
                                $userImg = 'default_user.jpg';
                                if ($ProductDetailsRow[0]->thumbnail != ''){
                                    $userImg = $ProductDetailsRow[0]->thumbnail;
                                } 
                                if (isset($ProductDetailsRow[0]->web_link)){
                                    
                                    $prod_link = 'user/'.$userName.'/things/'.$ProductDetailsRow[0]->seller_product_id.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
                                }else {
                                    $prod_link = 'things/'.$ProductDetailsRow[0]->PID.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
                                }
                                
                ?>
                                <!--<li>
                                    <img style="max-height: 204px; max-width: 172px;" src="images/product/<?php echo $prodImg;?>" alt="">
                                    <div class="overlay">
                                        <a href="<?php echo $prod_link; ?>"><h3><span>&#8377;</span> <?php echo $ProductDetailsRow[0]->price ?></h3></a>
                                        <h4><a href="<?php echo $prod_link; ?>"><?php echo $ProductDetailsRow[0]->product_name ?></a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                                        <span class="brand"><a href="javascript:">Arrow</a></span> 
                                         
                                        <div class="butn-overlay save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>"> <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong> <span><?php echo $ProductDetailsRow[0]->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span> 
                                        </div>
                                        
                                    </div>
                                </li>-->
                                
                                <li>
                                    <div class="main-box2">
                                        <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                        <div class="overlay">
                                            <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $ProductDetailsRow[0]->price;?></h3></a>
                                            <h4><a href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name;?></a> </h4> 
                                        </div>
                                    </div>
                                    <div class="article2">
                                        <h4><span><a href="user/<?php echo $prod_uname;?>">By <?php echo $fullName;?></a></span>  </h4>
                                          <span class="brand"><a href="javascript:">Arrow</a></span>
                                    </div>
                                </li>
              <?php  }
                }
              ?>
                
             <?php
                if($ProductDetails[$stories_details_row->id]['StoriesUserProduct']!='' && count($ProductDetails[$stories_details_row->id]['StoriesUserProduct']) >0){
                
                foreach($ProductDetails[$stories_details_row->id]['StoriesUserProduct'] as $ProductDetailsRow ){ 
                        $prodImg = 'dummyProductImage.jpg';
                                $prodImgArr = array_filter(explode(',', $ProductDetailsRow[0]->image));
                                if (count($prodImgArr)>0){
                                    foreach ($prodImgArr as $prodImgArrRow){
                                        if (file_exists('images/product/'.$prodImgArrRow)){
                                            $prodImg = $prodImgArrRow;
                                            break;    
                                        }
                                    }
                                }
                                $userName = 'anonymous';
                                $fullName = 'Anonymous';
                                //echo $ProductDetailsRow[0][0]->user_name;
                                if ($ProductDetailsRow[0]->user_id > 0){
                                    $userName = $ProductDetailsRow[0]->user_name;
                                    $fullName = $ProductDetailsRow[0]->full_name;
                                    if ($userName==''){ 
                                        $userName = 'anonymous';
                                        $fullName = 'Anonymous';
                                    }
                                }
                                if ($fullName == ''){
                                    $fullName = $userName;
                                }
                                $userImg = 'default_user.jpg';
                                if ($ProductDetailsRow[0]->thumbnail != ''){
                                    $userImg = $ProductDetailsRow[0]->thumbnail;
                                } 
                                if (isset($ProductDetailsRow[0]->web_link)){
                                    $prod_link = 'user/'.$userName.'/things/'.$ProductDetailsRow[0]->seller_product_id.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
                                }else {
                                    $prod_link = 'things/'.$ProductDetailsRow[0]->PID.'/'.url_title($ProductDetailsRow[0]->product_name,'-');
                                }    
                ?>
                                <!--<li>
                                    <img style="max-height: 204px; max-width: 172px;" src="images/product/<?php echo $prodImg;?>" alt="">
                                    <div class="overlay">
                                        <a href="<?php echo $prod_link; ?>"><h3><span>&#8377;</span> <?php echo $ProductDetailsRow[0]->price ?></h3></a>
                                        <h4><a href="<?php echo $prod_link; ?>"><?php echo $ProductDetailsRow[0]->product_name ?></a> <span><a href="people_details.html">By M MERRY</a></span> </h4>
                                        <span class="brand"><a href="javascript:">Arrow</a></span> 
                                         
                                        <div class="butn-overlay save <?php if ($loginCheck==''){echo 'sign_box';}?>" data-pid="<?php echo $ProductDetailsRow[0]->seller_product_id;?>"> <strong><?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?></strong> <span><?php echo $ProductDetailsRow[0]->likes;?> <?php if($this->lang->line('product_saves') != '') { echo stripslashes($this->lang->line('product_saves')); } else echo "saves"; ?></span> 
                                        </div>
                                        
                                    </div>
                                </li>-->
                                
                                
                                
                                <li>
                                    <div class="main-box2">
                                        <img src="images/product/thumb/<?php echo $prodImg;?>" alt="">
                                        <div class="overlay">
                                            <a href="<?php echo $prod_link;?>"><h3><span>&#8377;</span> <?php echo $ProductDetailsRow[0]->price;?></h3></a>
                                            <h4><a href="<?php echo $prod_link;?>"><?php echo $ProductDetailsRow[0]->product_name;?></a> </h4> 
                                        </div>
                                    </div>
                                    <div class="article2">
                                        <h4><span><a href="user/<?php echo $userName;?>">By <?php echo $fullName;?></a></span>  </h4>
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
                        <div class="like_share">
                            <span>1 people liked this</span>
                            <a href="javascript:">· Like</a>
                            <a href="javascript:">· Share</a>
                            <a href="javascript:">· Repost</a>
                        </div>
                    </div>
                    
                    <div class="post_blog">
                        <ul>
    <?php 
    if ($storiesComment[$stories_details_row->id]->num_rows() > 0 && $storiesComment[$stories_details_row->id]!=''){
        foreach ($storiesComment[$stories_details_row->id]->result() as $cmtrow){
            $cmt_uname = $cmtrow->full_name;
            if ($cmt_uname==''){
                $cmt_uname = $cmtrow->UserName;
            }
            //if ($cmtrow->status == 'Active'){
                
        
    ?>
                            <li>
                                <img src="imagesimages/users/<?php if($cmtrow->thumbnail!=''){ echo $cmtrow->thumbnail;}else{echo 'user-thumb.png';}?>"  alt="">
                                <h2><?php echo ucfirst($cmt_uname);?></h2>
                                
                                <p class="comments_detail_email cmt_cnt_<?php echo $cmtrow->id;?>">
    <?php 
    $cmt = preg_replace_callback("/@(\w+)/", array($make_user_link, 'make_user_link'), $cmtrow->comments);
    echo preg_replace("/#(\w+)/", "<a target=\"_self\" href=\"".base_url()."tag/$1\">#$1</a>", $cmt);
   ?>
                                </p>
                                
                                <span>
                                <?php  
                                 $time_ago =strtotime($cmtrow->dateAdded);
                                echo time_stamp($time_ago); ?> <!--<a href="javascript:">report</a>-->
                                <?php if ($loginCheck  != '' && $loginCheck == $stories_details_row->user_id){ ?>
                                <a style="cursor: pointer;" onclick="javascript:deleteStoriesCmt(this);" data-tid="<?php echo $stories_details_row->id;?>" data-cid="<?php echo $cmtrow->id;?>"><?php if($this->lang->line('product_delte') != '') { echo stripslashes($this->lang->line('product_delte')); } else echo "Delete"; ?></a>
                                <?php } ?> 
                                </span>
                                <div class="clear"></div>
                            </li>
    <?php
        }
    }
    ?>
                        </ul>
                        <div class="clear"></div>
                        <div class="comment_area">
                        <form action="#" method="post" class="new_comment" name="post<?php echo $stories_details_row->id;?>">
                        <input type="hidden" name="cproduct_id" id="cproduct_id<?php echo $stories_details_row->id;?>" value="<?php echo $stories_details_row->id;?>"/>
                          <input type="hidden" name="user_id" id="user_id" value="<?php echo $loginCheck ;?>"/>
                                <div>
                                    <img style="max-height: 53px; max-width: 53px;" src="images/users/<?php if($loginCheck != '' && $userDetails->row()->thumbnail!=''){ echo $userDetails->row()->thumbnail; }else{ echo 'default_user.jpg';}?>" alt="">
                                    <input type="text" class="input1" name="comments" placeholder="<?php if($this->lang->line('header_write_comment') != '') { echo stripslashes($this->lang->line('header_write_comment')); } else echo "Write a comment"; ?>..." id="comments<?php echo $stories_details_row->id;?>" >
                                    
                                    <input <?php if($loginCheck==''){ ?>require-login='true'<?php }?> type="submit" class="post submit<?php echo $stories_details_row->id;?>" value="<?php if($this->lang->line('header_post_comment') != '') { echo stripslashes($this->lang->line('header_post_comment')); } else echo "POST"; ?>">
                                </div>
                            </form>
                        </div>
                        <?php 
                        if ($this->lang->line('lg_cmt_emt')!=''){
                            $lg_cmt_emt = $this->lang->line('lg_cmt_emt');
                        }else {
                            $lg_cmt_emt = 'Your comment is empty';
                        }
                        ?>
                        <script type="text/javascript">
                        $(function() {

                            $(".submit<?php echo $stories_details_row->id;?>").click(function() {
                            
                                var requirelogin = $(this).attr('require-login');
                                var $submit = $(this);
                                if(requirelogin){
                                    var thingURL = $(this).parent().next().find('a:first').attr('href');
                                    $(".sign_box:first").trigger('click');
                                    return false;
                                }
                                if($submit.hasClass('posting')) return false;
                                $submit.css('opacity',0.1).addClass('posting');
                                var comments = $("#comments<?php echo $stories_details_row->id;?>").val();
                                var product_id = $("#cproduct_id<?php echo $stories_details_row->id;?>").val();
                                var dataString = '&comments=' + comments + '&cproduct_id=' + product_id;
                                
                                if(comments=='')
                                {
                                    alert('<?php echo $lg_cmt_emt;?>');
                                    $submit.css('opacity',1).removeClass('posting');
                                }
                                else
                                {
                                    $.ajax({
                                        type: "POST",
                                        url: baseURL+'site/stories/insert_stories_comment',
                                        data: dataString,
                                        cache: false,
                                        dataType:'json',
                                        success: function(json){
                                            if(json.status_code == 1){
                                                alert('Your comment is waiting for approval');
                                                window.location.reload();
                                            }
                                        
                                        },
                                        complete:function(){
                                            $submit.css('opacity',1).removeClass('posting');
                                        }
                                    });
                                }
                                return false;
                            });
                        });
                        </script>
                        <div class="clear"></div>
                    </div>
                    
                </div>
           <?php }}else{ ?>
               <div class="activity-feed-item">                
                    <?php if($this->lang->line('story_notfound') != '') { echo stripslashes($this->lang->line('story_notfound')); } else echo "No Stories Found"; ?>.             
               </div>              
           <?php } ?>
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
<?php
//Php Time_Ago Script v1.0.0
//Scripted by D.Harish Kumar@TYSON567
function time_stamp($time_ago)
{
$cur_time=time();
$time_ago;
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
return "ago $seconds seconds";
}
//Minutes
else if($minutes <=60)
{
if($minutes==1)
{
return "ago 1 minute";
}
else
{
return "ago $minutes minutes";
}
}
//Hours
else if($hours <=24)
{
if($hours==1)
{
return "ago 1 hour";
}
else
{
return "ago $hours hours";
}
}
//Days
else if($days <= 7)
{
if($days==1)
{
return "yesterday";
}
else
{
return "ago $days days";
}
}
//Weeks
else if($weeks <= 4.3)
{
if($weeks==1)
{
return "ago 1 week";
}
else
{
return "ago $weeks weeks";
}
}
//Months
else if($months <=12)
{
if($months==1)
{
return "ago 1 month";
}
else
{
return "ago $months months";
}
}
//Years
else
{
if($years==1)
{
return "ago 1 year";
}
else
{
return "ago $years years";
}
}
}
?>
<?php
$this->load->view('site/templates/footer');
?>