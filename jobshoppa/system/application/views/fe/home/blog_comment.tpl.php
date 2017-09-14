 <?php
/*********
* Author: Koushik Rout
* Date  : 18 Nov 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  View For Blog_comment  fe
*
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/fe/home/blog_comment/
*/

?>
<script>
$(document).ready(function(){
    
    
///////////Submitting the form/////////
$("#detail_form").submit(function(){    
    var b_valid=true;
    var s_err="";
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());
    
    if($.trim($("#txt_name").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide name.</strong></div>';
        b_valid=false;
    }
    if(address== '')  
    {
        s_err +='<div class="error_massage"><strong>Please provide email.</strong></div>';
        b_valid=false;
    }
    else if(reg.test(address) == false) 
    {
        s_err +='<div class="error_massage"><strong>Please provide valid email.</strong></div>';
        b_valid=false;
    }    
    
   
    if($.trim($("#txt_msg").val())== '')   
    {
        s_err +='<div class="error_massage"><strong>Please provide message.</strong></div>';
        b_valid=false;
    }
     
    
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
    /*$('#btn_reg').click(function(){
        $("#form_buyer_reg").submit();
    }); */

});
</script>
  <div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    //include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
           
	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>

	  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>

<?php } else {?>

	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->

<div id="content_section"> 
    <div id="content"> 
         <div id="inner_container02">
            <div class="title">
                <h3><span>Comment</span></h3>
            </div>
            <div class="blog_box">
                <div class="heading_box">
                    <div class="left"><a href="<?php echo base_url().'home/blog_details/'.encrypt($blog_details['id']); ?>"><?php echo $blog_details['s_title'];?> </a></div>
                    <div class="right">Author : Admin &nbsp; | &nbsp;  <?php echo $blog_details['blog_created_on'];?>   &nbsp; | &nbsp; <a href="<?php echo base_url().'home/blog_comment/'.encrypt($blog_details['id']).'#post_comment'; ?>">Post Your Comments</a> </div>
                </div>
                <div class="clr"></div>
                <div class="blog_detail">
                    <div class="img_box"><a href="blog-details.html"><?php echo showThumbImageDefault('manage_blog',$blog_details["s_image"],230,190);?></a></div>
                    <div class="txt_box">
                        <?php echo $blog_details['s_description'];?>
                        <div class="view_more"><a href="<?php echo base_url().'home/blog_details/'.encrypt($blog_details['id']); ?>">Read More...</a></div>
                    </div>
                </div>
            </div>
            <div class="comment_box">
            <div class="comment_only" id="comment_only"> 
                <?php echo $comment_contents;?>
             </div>   
                <div id="form_box01"> <a name="post_comment"></a>
                    <div id="div_err">
                    <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
                    </div>
                    <h6>Post Your Comments</h6>
                    <form id="detail_form" action="" method="post" >
                    <div class="label01" style="width:150px;">Name <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text" name="txt_name" id="txt_name" value="<?php echo $_POST["txt_name"] ?>" size="48"/>
                    </div>
                    <div class="clr"></div>
                    <div class="label01" style="width:150px;">Email Address <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text" name="txt_email" id="txt_email" value="<?php echo $_POST["txt_email"] ?>" size="50"/>
                    </div>
                    <div class="clr"></div>
                    <div class="label01" style="width:150px;">Comments <span class="red_txt">*</span> :</div>
                    <div class="field01">  
                        <textarea  name="txt_msg" id="txt_msg"  cols="" rows="6" style="width:450px;" ><?php echo $_POST["txt_msg"] ?></textarea>
                                          
                    </div>
                    <div class="clr"></div>
                    <div class="label01" style="width:150px;">&nbsp;</div>
                    <div class="field01">
                        <input type="submit" value="Post Comments" />
                    </div>
                    </form>
                    <div class="clr"></div>
                </div>
            </div>
            <div class="clr"></div>
        </div>
     <!-- /INNER CONTAINER02 -->          
     <div class="clr"></div>               
</div>
<!-- /CONTENT-->                
     <div class="clr"></div>  
</div>
 <!-- /CONTENT SECTION -->

 
 
 
 
 
 
 
 
