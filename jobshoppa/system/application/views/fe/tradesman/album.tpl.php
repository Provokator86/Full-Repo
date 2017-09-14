<script type="text/javascript">
/*$(document).ready(function() {
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

		});*/
	jQuery(document).ready(function() {
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
		//console.log($(".lightbox1_main"));
});	
		
		
		$(document).ready(function() {
			$("a[rel=gallery_group]").fancybox({
				'transitionIn'		: 'none',
				'transitionOut'		: 'none',
				'titlePosition' 	: 'over',
				'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				}
			});
	});
</script>

<script>	
	
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

///////////Submitting the form/////////
$("#frm_upload_photo").submit(function(){
    var b_valid=true;
    var s_err="";
	var file_type = $("#f_image").val();
    var cnt_image = parseInt(<?php echo count($images); ?>) ;
    
	 if($.trim($("#f_image").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please select an image.</strong></div>';
			b_valid=false;
		}
    	
	else if(!file_type.match(/(?:jpg|jpeg|png)$/))
 		{
    		s_err +='<div class="error_massage"><strong>Please select an appropriate  image format, we accept JPEG, PNG and GIF formats only</strong></div>';
			b_valid=false;
		}
    else if(cnt_image>=5)
    {
        s_err +='<div class="error_massage"><strong>You can not upload more than 5 picture .</strong></div>';
        b_valid=false;
    }
     

	
    
    /////////validating//////
     if(!b_valid)
    {       
        $("#div_err").html(s_err).show("slow");
    }   
    $("#h_cnt_image").val(cnt_image+1);
    return b_valid;
});    
///////////end Submitting the form/////////   

})	
	
</script>
<?php /*
<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
			 		<?php
						show_msg("error");  
						echo validation_errors();
					?>
			</div>	
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
            
            <div class="body_right">
                  <h1><img src="images/fe/account.png" alt="" /> <?php echo t('My')?> <span> <?php echo t('Album')?></span></h1>
                  <form name="upload_frm" id="upload_frm" action="<?php echo base_url().'tradesman/album' ?>" method="post" enctype="multipart/form-data">
				  <div class="grey_box02">
                        <div class="lable01"><?php echo t('Upload Photo')?> <span class="red_text"> * </span></div>
                        <div class="fld01">
         
                              <div class="spacer"></div>
                              <input type="file" name="f_image" id="f_image" size="33"/><br/>
							  [<?php echo t('upload file type only jpg,jpeg,png') ?>]
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01"><?php echo t('Title')?></div>
                        <div class="fld01">
                              <input type="text"  name="txt_title" id="txt_title" value="<?php echo $posted['txt_title'] ?>"  />
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01"></div>
                        <div class="fld01" style="padding-top:10px;">
                              <input id="btn_save" name="btn_save"  class="button" type="submit" value="Save"/>
                              <input id="btn_cancel" name="btn_cancel"  class="button" type="submit" value="Cancel"/>
                        </div>
                        <div class="spacer"></div>
                  </div>
				  </form>
				 
                  <div class="photo_edit_box">
				  
				  <?php if($images)
						  {
							foreach($images as $val)
							{	
				  ?>
                        <div class="photo_box" id="photo_box_<?php echo $val['id'] ?>">
                              <div class="delete_div">
							  	<!--<a href="#delete_div" class="lightbox_main right"><img src="images/fe/close.png" alt="close"/> </a>-->							  							  
							  	<a href="<?php echo $pathtoclass.'chk_delete/'.encrypt($val['id'])?>" class="lightbox_main right" ><img src="images/fe/close.png" alt="close"/> </a>							  							  
							  </div>
                              <div class="photo"><a rel="gallery_group" href="<?php echo base_url().'uploaded/gallery/'.$val['s_image'] ?>" title=""><img alt="" src="<?php echo base_url().'uploaded/gallery/thumb/thumb_'.$val['s_image'] ?>" /></a></div>
                              <?php echo $val['fn_entry_date'] ?>
                              <h5><?php echo $val['s_title'] ?></h5>
                        </div>                        
                   <?php 
				   			} 				   
				   		}
						
				   ?>    
                        
                        
                        <div class="spacer"></div>
						
                  </div>
				  
                  
                  <div class="page">
				  <?php echo $pagination ?>
				  </div>
				  <div style="display: none;">
                        <!--<div id="delete_div" class="lightbox">
                              <h1>Are you sure you want to delete the Photo?</h1>
                              <div style="text-align:center">
                                    <input name="submit"  class="pink_button01" type="submit" value="Yes" />
                                    &nbsp;
                                    <input name="submit"  class="pink_button01" type="submit" value="No" />
                              </div>
                        </div>-->
                  </div>
            </div>
            <div class="spacer"></div>
      </div>
                
 */ ?>     
<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
             <div class="title">
                <h3><span>Manage</span>Photos</h3>
            </div>
            <div class="clr"></div>
            <h6>&nbsp;</h6>
            <div class="clr"></div>
            <div id="account_container">
            <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
                            <div id="form_box01">
                            <form name="frm_upload_photo" id="frm_upload_photo" action="" method="post" enctype="multipart/form-data">
                                <div class="label03">Photo :</div>
                                <div class="field03">
                                    <input type="hidden" name="h_cnt_image" id="h_cnt_image" val="" /> <!-- This hidden field is to store number of image  for server side validation -->
                                    <input name="f_image" type="file" id="f_image" size="48" />
                                    <br />
                                    <span style="font-size:11px; font-style:italic;">Select a new photo to upload: (JPEGs, GIFs and PNGs only please) (You can upload upto 5 photos)</span></div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input id="btn_photos" type="submit" value="Add Photos" />
                                </div>
                                <div class="clr"></div>
                                <!--<ul class="photo3">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>-->
                                <div class="grey_box02">
                                    <h6>Photos:</h6>
									 <?php
    
										if(!empty($images))
										{
											foreach($images as $val)
											{

                                        ?>
                                    <ul class="photo2">                                       
									   										
                                        <li><a href="<?php echo $pathtoclass.'chk_delete/'.encrypt($val['id'])?>" class="lightbox1_main" >
										<img src="images/fe/small_red.png" alt="Delete" title="Delete" class="close_02"/></a>
										<a rel="gallery_group" href="<?php echo base_url().'uploaded/gallery/'.$val['s_image']; ?>" title="">
										<?php echo showThumbImageDefault('trades_album',$val['s_image'],110,101); ?></a>
										</li>                                        
                                       
                                    </ul>
									 <?php
											}
										}
                                        else
                                        {
                                            echo '<p>No images available.</p>';
                                        }
										?>
                                </div>
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>             <?php include_once(APPPATH.'views/fe/common/tradesman_right_menu.tpl.php'); ?> 
            </div>
            <div class="clr"></div>
        </div>         
        
        <div class="clr"></div>
</div>
</div>       