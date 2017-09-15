<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 

    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#test_form").submit();
   }); 
});    


///////////Submitting the form/////////
$("#test_form").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_content").val())=="") 
		{
		   s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide testimonial'))?>.</strong></span></div>';
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
      
                        <h1><img src="images/fe/general.png" alt="" /> <?php echo get_title_string(t('My Testimonial'))?></span></h1>
                        <div class="shadow_big">
                              <div class="right_box_all_inner">
							  <form name="test_form" id="test_form" action="tradesman/testimonial/<?php echo $user_id ?>" method="post">
                                    <div class="brd"><?php echo t('Please drop a line about our services, we sincerely hope you have had a wonderful experience')?></div>
                                     <div class="lable01" style="width:75px;"> <?php echo t('Testimonial')?> </div>
                                    <div class="fld01" style="width:600px;">
                                         <textarea name="txt_content" id="txt_content"  cols="45" rows="5" style="width:550px; height:200px;"><?php echo $posted['txt_content'] ?></textarea>
										
                                    </div>
                                    <div class="spacer"></div>
                                    <input  class="button" type="button" id="btn_save" value="<?php echo t('Submit')?>" style="margin-left:82px;"/>
							  </form>	
                              </div>
                              
                        </div>
                        
        
                        <h3 style="border:0px;"><?php echo t('Previous  Testimonials')?></h3>
                        <div class="shadow_big">
                              <div class="right_box_all_inner" style="padding:0px;">
                                    <div class="top_bg_banner">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td valign="top" width="9"></td>
                                                      <td valign="top" width="116" align="left"><?php echo t('Date')?></td>
                                                      <td valign="top" width="461" align="left"><?php echo t('Testimonial')?> </td>
                                                      <td valign="top" width="127" align="center"><?php echo t('Status')?> </td>
                                                </tr>
                                          </table>
                                    </div>
									<?php
									if($testimonial_list){
									$i=1;
										foreach($testimonial_list as $val)
										{
											$class = ($i++%2) ? 'white_box' : 'sky_box';
									?>
                                    <div class="<?php echo $class ?>">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td valign="top" width="112" align="left"><?php echo $val['fn_entry_date'] ?></td> 
                                                      <td valign="top" width="462"><?php echo $val['s_full_content']?></td>
                                                      <td valign="top" width="129" align="center" class=""><?php echo $val['s_is_active']?> </td>
                                                </tr>
                                          </table>
                                    </div>
                                    <?php }
									 } else {
										echo '<div class="right_box_all_inner " style="padding:5px;">'.t('No record found').'</div>';
									} ?>
                              </div>
                        </div>
                           <!--<div class="page"> <a href="#"  class="active"> 1 </a> <a href="#"> 2 </a> <a href="#"> 3 </a> <a href="#"> 4 </a> <a href="#"> 5 </a><a href="#" style="background:none; color:#ff416b;">&gt;</a></div>-->
               				<div class="page"> <?php echo $pagination;?></div>	
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>