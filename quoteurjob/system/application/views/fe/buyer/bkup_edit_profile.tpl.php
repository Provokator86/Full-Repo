
<script type="text/javascript">
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_edit_profile").submit();
	  
	   //check_duplicate();
   }); 
});    
	
///////////Submitting the form/////////
$("#frm_edit_profile").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	var file_type = $("#f_image").val();
	 var address = $.trim($("#txt_email").val());
   // $("#div_err").hide("slow");     
	
	if($.trim($("#txt_name").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide name'))?>.</strong></span></div>';
		b_valid=false;
	}
	
	if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|jpeg|png)$/)))
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select proper image file type'))?> .</strong></span></div>';
		b_valid=false;
	}
	if(address== '')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide email'))?>.</strong></span></div>';
		b_valid=false;
	}
	else if(reg.test(address) == false) 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide valid email'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#txt_address").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide address'))?>.</strong></span></div>';
		b_valid=false;
	}
	
	if($.trim($("#opt_state").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select province'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opt_city").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select city'))?>.</strong></span></div>';
		b_valid=false;
	}
	if($.trim($("#opt_zip").val())=="") 
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select postal code'))?>.</strong></span></div>';
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
	

});

// Ajax call to populate city options
function call_ajax_get_city(ajaxURL,item_id,cngDv)
{
	//jQuery.noConflict();///$ can be used by other prototype which is not jquery
	//jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "state_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_city").msDropDown();
					   call_ajax_get_zipcode("ajax_change_zipcode_option",0,0,"parent_zip"); // to repopulate zip options

				   }   
				}
			});
	//});	
}

function call_ajax_get_zipcode(ajaxURL,item_id,state_id,cngDv)
{
	//jQuery.noConflict();///$ can be used by other prototype which is not jquery
	//jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';	
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "city_id="+item_id+"&state_id="+state_id,
				success: function(msg){
				   if(msg!='')
					   document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_zip").msDropDown();
				}
			});
	//});	
}
</script>
<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			<div id="div_err">
				<?php
					echo validation_errors();
				?>
				</div>
            <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
			<form name="frm_edit_profile" id="frm_edit_profile" method="post" action="<?php echo base_url().'buyer/edit_profile'?>" enctype="multipart/form-data">

            <div class="body_right">
				
 
                        <h1><img src="images/fe/account.png" alt="" /> <?php echo get_title_string(t('Edit Profile'))?></h1>
                        <div class="shadow_big">
                              <div class="right_box_all_inner">							  		
											  
                                    <div class="left_txt"><span>*</span> <?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    
                                    <div class="lable01"> <?php echo t('Name')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_name" id="txt_name" value="<?php echo $info['s_name']; ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                 
                                 
                                    <div class="lable01"><?php echo t('Email')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_email" id="txt_email"  value="<?php echo $info['s_email'] ?>"/>
                                    </div>
                                    <div class="spacer"></div>
                                     <br />
                             		 <h3><?php echo t('Address')?> </h3>
                                  
                                    <div class="lable01"><?php echo t('Address')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <textarea  name="txt_address" id="txt_address"  cols="45" rows="5" style="width:290px; height:100px;"><?php echo $info['s_address'] ?></textarea>
										  
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Province')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                         <select id="opt_state" name="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option",this.value,"parent_city");'>
                                          <option value=""><?php echo t('Select a province')?> </option>
										  <?php echo makeOptionState('',$info['opt_state']) ?>
                                    </select>
                                    <!--<script type="text/javascript">
										$(document).ready(function(arg) {
											$("#opt_state").msDropDown();
											$("#opt_state").hide();
										})
									</script>-->
                                    </div>
                                    <div class="spacer"></div>
                                     <div class="lable01"><?php echo t('City')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                         <div id="parent_city">
                                    <select name="opt_city" id="opt_city" style="width:192px;">
                                          <option value=""><?php echo t('Select city')?> </option>
										  <?php echo makeOptionCity(' state_id="'.$info['opt_state'].'" ',encrypt($info['opt_city'])) ?>
                                    </select>
									  </div>		
									  <!--<script type="text/javascript">
										$(document).ready(function(arg) {
											$("#opt_city").msDropDown();
											$("#opt_city").hide();
										})
									  </script>-->
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Postal code')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <div id="parent_zip">
												<select name="opt_zip" id="opt_zip" style="width:192px;">
													  <option value=""><?php echo t('Select postal code')?> </option>
													  <?php echo makeOptionZip(' state_id="'.$info['opt_state'].'" AND city_id="'.$info['opt_city'].'" ',$info['opt_zip']) ?>
												</select>
										  </div>
										  <!--<script type="text/javascript">
											$(document).ready(function(arg) {
												$("#opt_zip").msDropDown();
												$("#opt_zip").hide();
											})
										  </script>	-->					
                                    </div>
                                    <div class="spacer"></div>
                            <br />
                              <h3><?php echo t('Buyer Profile')?> </h3>
                                         <div class="lable01"><?php echo t('Profile Photo')?> <!--<span class="red_text"> * </span>--></div>
                                    <div class="fld01">
									<?php if($info['image']) {  $user_image = $info['image'][0]['s_user_image']; ?>
									<div class="photo" style="margin-bottom:10px;">
									<img src="<?php echo base_url().'uploaded/user/thumb/thumb_'.$user_image?>" alt="" width="100px" height="75px" />
									<?php 									
									echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$user_image.'" />';
									 ?>
									</div> 
									<?php } else {?>
                                          <div class="photo" style="margin-bottom:10px;"><img src="images/fe/img.png" alt="" /></div> 
									<?php } ?>	  
                                          <div class="spacer"></div>
                                          <input type="file" name="f_image" id="f_image" value="1" size="30"/><br/>
							  				[<?php echo t('upload file type only jpg,jpeg,png') ?>]
                                    </div>
                                    <div class="spacer"></div>
                                       <div class="lable01"> </div>
                                    <div class="fld01" style="line-height:25px;">
                                          <input name="chk_newletter" id="chk_newsletter" type="checkbox" value="1" <?php echo (!empty($info["chk_newsletter"]) && $info["chk_newsletter"]==1) ?'checked="checked"' : '';?>/>
                                         <?php echo t('I would like to receive Newsletter')?> </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;">
                                          <input  class="button" type="button" name="btn_save" id="btn_save" value="<?php echo t('Save')?>"/>
                                          <input  class="button" type="button" name="btn_cancel" id="btn_cancel" value="<?php echo t('Cancel')?>"/>
                                    </div>
                                    <div class="spacer"></div>
									
                              </div>
                        </div>
                  
                  <div class="spacer"></div>
				  
            </div>
            <div class="spacer"></div>
			 </form> 
      </div>
	