<script type="text/javascript">
$(document).ready(function() {
			$(".lightbox_main").fancybox({
				'titlePosition'		: 'inside',
				'transitionIn'		: 'none',
				'transitionOut'		: 'none'
			});

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
 

    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#upload_frm").submit();
   }); 
});    


///////////Submitting the form/////////
$("#upload_frm").submit(function(){
    var b_valid=true;
    var s_err="";
	var file_type = $("#f_image").val();
    $("#div_err").show("slow"); 

    
	 if($.trim($("#f_image").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please browse photo'))?>.</strong></span></div>';
			b_valid=false;
		}	
	else if(!file_type.match(/(?:jpg|jpeg|png)$/))
 		{
    		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select proper image file type'))?> .</strong></span></div>';
			b_valid=false;
		}

	
    
    /////////validating//////
     if(!b_valid)
    {       
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////   

})	
	
</script>
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
                  <h1><img src="images/fe/account.png" alt="" /> <?php echo get_title_string(t('My Album'))?></span></h1>
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
                              <input type="text"  name="txt_title" id="txt_title" value="<?php echo $posted['txt_title'] ?>" maxlength="50" /><br/>
							  [<?php echo t('provide title upto 50 characters') ?>]
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01"></div>
                        <div class="fld01" style="padding-top:10px;">
                              <input id="btn_save" name="btn_save"  class="button" type="submit" value="<?php echo t('Save')?>"/>
                              <input id="btn_cancel" name="btn_cancel"  class="button" type="submit" value="<?php echo t('Cancel')?>"/>
                        </div>
                        <div class="spacer"></div>
                  </div>
				  </form>
				 <h3 style="border:0px; font-style:italic;"><?php echo t('My uploaded photos'); ?></h3>
				 <div class="spacer"></div>
                  <div class="photo_edit_box">
				  
				  <?php if($images)
						  {
							foreach($images as $val)
							{	
				  ?>
                        <div class="photo_box"  id="photo_box_<?php echo $val['id'] ?>">
                              <div class="delete_div">							  								  							  
							  	<a href="<?php echo $pathtoclass.'chk_delete/'.encrypt($val['id'])?>" class="lightbox_main right" ><img src="images/fe/close.png" alt="<?php echo t('close')?>" title="<?php echo t('close')?>"/> </a>							  							  
							  </div>
                              <div class="photo"><a rel="gallery_group" href="<?php echo base_url().'uploaded/gallery/'.$val['s_image'] ?>" title=""><img alt="" src="<?php echo base_url().'uploaded/gallery/thumb/thumb_'.$val['s_image'] ?>" /></a></div>
                              <?php echo $val['fn_entry_date'] ?>
                              <h5><?php echo substr($val['s_title'],0,50) ?></h5>
                        </div>                        
                   <?php 
				   			} 				   
				   		}
						
				   ?>    
                        
                        
                        <div class="spacer"></div>
						
                  </div>
				  
                  
                  <div class="page">
				  <?php //echo $pagination ?>
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