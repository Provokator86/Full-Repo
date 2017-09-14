 <?php
/*********
* Author: Koushik Rout
* Date  : 18 Nov 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  View For Blog_details  fe
*
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/fe/home/blog_details/
*/

?>
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
                <h3><span>Blog</span></h3>
            </div>
            <div class="blog_box">
                <div class="heading_box">
                    <div class="left"><a href="<?php echo base_url().'home/blog_details/'.encrypt($blog_details['id']); ?>"><?php echo $blog_details['s_title'];?> </a></div>
                    <div class="right">Author : Admin &nbsp; | &nbsp;  <?php echo $blog_details['blog_created_on'];?>   &nbsp; | &nbsp; <a href="<?php echo base_url().'home/blog_comment/'.encrypt($blog_details['id']); ?>">Comments</a> </div>
                </div>
                <div class="clr"></div>
                <div class="blog_detail">
                    <div class="img_box"><a href="blog-details.html"><?php echo showThumbImageDefault('manage_blog',$blog_details["s_image"],230,190);?></a></div>
                    <div class="txt_box">
                        <?php echo $blog_details['s_desc_full'];?>

                    </div>
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
