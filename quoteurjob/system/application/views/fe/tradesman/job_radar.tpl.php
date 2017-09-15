<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){
	var max_allow_open = 3;
		var cnt = <?php echo $cnt;?>;

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 $('#txt_postal_code').alphanumeric({allow:" "});
/*** generate category dropdown ***/
		
		$("#red_link").click(function(){
			var str = '';			
			str += '<select style="width:244px;	margin-top:5px;" name="opt_category_id'+cnt+'" id="opt_category_id'+cnt+'"><option value=""><?php echo addslashes(t('Select'))?></option>'+"<?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id",""); ?>"+'</select>';
			$("#parent_category").append(str);
			//$("#opd_category"+cnt).msDropDown();
			//$("#opd_category"+cnt).hide();			
			
			cnt++;
			
			if(cnt>=max_allow_open)
			{
				$("#red_link").remove();
			}
		});
	/*** end generate category ***/

    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_adv_src").submit();
   }); 
});    


///////////Submitting the form/////////
$("#frm_adv_src").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_postal_code").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide postal code.'));?></strong></span></div>';
			b_valid=false;
		}	
	if($.trim($("#opt_radius option:selected").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select radar value.'));?></strong></span></div>';
			b_valid=false;
		}	
		if($.trim($("#opt_category_id option:selected").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select one category.'));?></strong></span></div>';
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

})
//});
</script>

<div id="div_container">
      <div class="body_bg">
             <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
            <div class="body_right">
        
                        <h1><img src="images/fe/general.png" alt="" /><?php echo get_title_string(t('Job Radar'))?></span></h1>
                         <h4><?php echo t('You dont want to miss out business within your reach.')?></h4> 
                          <div class="shadow_big">
                              <div class="right_box_all_inner">
							  <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
							  	<div id="div_err">
									
										<?php
											show_msg("error");  
											echo validation_errors();
										?>
								</div>	
								<div id="div_succ">
										<?php
											show_msg("success");  
											
										?>
								</div>	
							  <form name="frm_adv_src" id="frm_adv_src" action="" method="post">
                                    <div class="left_txt"><span>*</span><?php echo t('Required field')?> </div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    <div class="lable01"><?php echo t('Postal Code')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['txt_postal_code']?>"  style="width:230px;" />
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"><?php echo t('Radius')?> <span class="red_text"> * </span></div>
                                    <div class="fld01">
                                             <select name="opt_radius" id="opt_radius" style="width:244px;">
									<option value=""><?php echo t('Radius')?></option>
                                    <?php echo makeOptionRadiusOption('', $posted['opt_radius'])?>                             
							  </select>	 <?php echo t('Miles')?>
                                    </div>
                                   
                                    <div class="spacer"></div>
                                   
                                 <div class="lable01"><?php echo t('Category')?><span class="red_text"> * </span></div>
                                    <div class="fld01"  style="width:380px;">
									<div style="padding-bottom:5px;">
									<div id="parent_category">
									<select name="opt_category_id[]" id="opt_category_id" style="width:244px;" multiple="multiple">
									<?php echo makeOptionCategoryList(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id", $posted['opt_category_id']);?>
									</select>
									
									
                                    
									
<?php /*?>									<select name="opt_category_id" id="opt_category_id" style="width:244px;">                     
							  		<option value=""> <?php echo t('Select')?></option>
                                    <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id", $posted['opt_category_id']);?>
                              </select>
                                 		<?php if(count($radar_cat)>1)
										{
											for($i=1;$i<count($radar_cat);$i++) {
										?>
											<select style="width:244px;	margin-top:5px;" name="opt_category_id<?=$i?>" id="opt_category_id<?=$i?>" style="width:244px;">                     
							  		<option value=""> <?php echo t('Select')?></option>
                                    <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id", encrypt($radar_cat[$i]['i_category_id']));?>
                              </select>
							  				
											<?php
											}
										}
										?><?php */?>
										
										
										
								   </div>
								   <?php echo t('Press CRLT for select more than one category.');?>
									<!-- <a href="javascript:void(0);" class="red_link" id="red_link"><?php echo t('Add another Category')?> </a> -->
									 </div>		
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;">
										<input type="hidden" name="h_id" value="<?php echo $posted['h_id'];?>" />
										<input  class="button" id="btn_save" type="button" value="<?php echo t('Save')?>" />
                                    </div>
									</form>
                                    <div class="spacer"></div>
                              </div>
                        </div>
                        
               
            </div>
            <div class="spacer"></div>
      </div>
</div>