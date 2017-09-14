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
	  	$("#err_f_image").text('<?php echo addslashes(t('Please upload a image'))?>').slideDown('slow');
		b_valid  =  false;
	}	
	else if(!file_type.match(/(?:jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/))
	{
		$("#err_f_image").text('<?php echo addslashes(t('Please upload a proper image file'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_f_image").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }
	/*if($.trim($("#txt_title").val())=="") 
	{
	  	$("#err_txt_title").text('<?php echo addslashes(t('Please provide title'))?>').slideDown('slow');
		b_valid  =  false;
	}
	else
    {
        $("#err_txt_title").slideUp('slow').text('<?php echo addslashes(t(''))?>');
    }*/
    
    /////////validating//////
    if(!b_valid)
    {       
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////  






});	

////////////// Start Delete image by clicking image /////////////
var image_id ; 
function delete_album_image(img_id)
{
    image_id  =   img_id
    show_dialog('photo_zoom02');
     
}

function  clickDialog(clickVlaue)
{
    if(clickVlaue==0)
    {
        hide_dialog();
    }
    else
    {
        hide_dialog();
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'tradesman/ajax_delete_album_image',
                data: "img_id="+image_id,
                success: function(msg){
                    if(msg)
                    {
                        var arr_img     =    msg.split('^');
                        $("#image_list").html(arr_img[0]);
                         
                    }
                }
            });
        
    }
}

////////////// End Delete image by clicking image ///////////// 
	
</script>
<style>
.err{ margin-left:160px;}
</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
		  <div class="username_box">
				<div class="right_box03">
					<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
					<div id="div_err">
							
					</div>	
				
					  <h4><?php echo addslashes(t('My Album'))?></h4>
					  <form name="upload_frm" id="upload_frm" action="<?php echo base_url().'tradesman/album' ?>" method="post" enctype="multipart/form-data">
					  <div class="filter_option_box">
							<div class="lable03"><?php echo addslashes(t('Upload Photo'))?><span>*</span></div>
							<div class="textfell02">
								  <input type="file" name="f_image" id="f_image" class="width05 fist brows"/>
								   <div class="mass"><?php echo addslashes(t('Permitted file formats'))?>:jpg, jpeg, gif, png </div>
							</div>
							<div class="spacer"></div>
                 			<div id="err_f_image" class="err"><?php echo form_error('f_image'); ?></div>
						   
							<div class="spacer"></div>
							<div class="lable03 margin05"><?php echo addslashes(t('Title'))?><span></span></div>
							<div class="textfell">
								  <input type="text"  name="txt_title" id="txt_title" value="<?php echo $posted['txt_title'] ?>" maxlength="50" />
								  
							</div>
							<div class="spacer"></div>
							<div class="lable03 margin05"></div>
								<span class="mass02">(<?php echo addslashes(t('maximum 50 characters')) ; ?>)</span>
							
							
							<div class="spacer"></div>
                 			<div id="err_txt_title" class="err"><?php echo form_error('txt_title'); ?></div>
							
							<div class="spacer"></div>
							<div class="lable03"></div>
							<div class="textfell02">
							<input id="btn_save" name="btn_save"  class="small_button marginright02" type="button" value="<?php echo addslashes(t('Save'))?>"/>
							 <a href="<?php echo base_url().'tradesman/album' ?>"><?php echo addslashes(t('Cancel'))?></a>
							</div>
							<div class="spacer"></div>
							
							<h5><?php echo addslashes(t('Adding illegal content may result account suspension'))?></h5>
							
					  </div>
					  </form>
					 
							<div id="image_list">
							<?php echo $images ?>
							</div>
							
		  <div class="spacer"></div>
				  
				</div>
				<?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
				<div class="spacer"></div>
		  </div>
		  <div class="spacer"></div>
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>


<!--lightbox Accept-->
<div class="lightbox05 photo_zoom02 box02 overflow02">
<div id="div_err1">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h2><?php echo addslashes(t('Are you sure want to delete this image.'))?>?</h2>

<div class="buttondiv">
<input type="hidden" name="h_data" id="h_data" value="" />
<input class="login_button flote02" type="button" onclick="clickDialog(1);" value="Yes" />
<input class="login_button flote02" type="button" onclick="clickDialog(0);" value="No" />
</div>
</div>
<!--lightbox Accept-->