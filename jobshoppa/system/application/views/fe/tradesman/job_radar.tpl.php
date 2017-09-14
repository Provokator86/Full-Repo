<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 
$('#txt_postal_code').alphanumeric({allow:" "});
    
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
    //$("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_postal_code").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please provide postal code.</strong></div>';
			b_valid=false;
		}	
	if($.trim($("#opt_radius option:selected").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please select distance value</strong></div>';
			b_valid=false;
		}	
		if($.trim($("#opt_category_id option:selected").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please select a  category</strong></div>';
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
	<div id="div_err">
         <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); 
            //show_msg("error");  
            echo validation_errors();
            //pr($posted);
        ?>
     </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Job </span> Radar Settings</h3>
            </div>
            <div class="clr"></div>
            <!--<h6> Enter the distance you are willing to travel and the Radar will display jobs within that range .</h6>-->
			<p>Tailor your settings below and start receiving job alerts</p>
			<p>&nbsp;</p>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
						  <form name="frm_adv_src" id="frm_adv_src" action="" method="post">
                            <div id="form_box01">
                                <div class="label03">Post Code :</div>
                                <div class="field03">
                                    <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['txt_postal_code']?>"  style="48" />
                                	<p style="font-size:10px;">[Example: GY9 3AG, DD11 2PP, etc.]</p>
								</div>
                                <div class="clr"></div>
                                <div class="label03">Distance :</div>
                                <div class="field04">
                                     <select name="opt_radius" id="opt_radius">
										<option value="">Distance</option>
										<?php echo makeOptionRadiusOption('', $posted['opt_radius'])?>                             
							  		</select>	 
                                </div>
                                <div class="clr"></div>
								
								<div class="label03">Category :</div>
                                <div class="field04">
								<div id="parent_category">
                                     <select name="opt_category_id[]" id="opt_category_id" style="height:200px;" multiple="multiple">
									<?php echo makeOptionCategoryList(" c.s_category_type='job' AND c.i_status=1 ", $posted['opt_category_id']);?>
									</select> 
								</div><?php echo 'Press Ctrl or Cmd to select more than one category'?>	
                                </div>
                                <div class="clr"></div>
								
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
									<input type="hidden" name="h_id" value="<?php echo $posted['h_id'];?>" />
									<input name="btn_save"  id="btn_save" type="submit" value="Save" />
									<!--<input name="btn_cancel"  id="btn_cancel" type="reset" value="Cancel" />-->                            
                                    
                                </div>
                                <div class="clr"></div>
                            </div>
						</form>	
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                 <?php
                    include_once(APPPATH."views/fe/common/tradesman_right_menu.tpl.php");
                ?>   
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>