<script>
$(document).ready(function(){

///////////Submitting the form/////////
$("#frm_job_edit").submit(function(){	
    var b_valid=true;
    var s_err="";
   // $("#div_err").hide("slow");     
	if($.trim($("#opd_quote_period").val())=="") 
	{
		
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please select quote days'))?>.</strong></span></div>';
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
	$('#btn_save_job').click(function(){
		$("#frm_job_edit").submit();
	}); 

});
</script>
<div id="div_container">
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
            <div class="body_right">

                        <h1><img src="images/fe/job.png" alt="" /> <?php  echo get_title_string(t('Edit Job'))?></h1>
						<form name="frm_job_edit" id="frm_job_edit" method="post" action="">
                        <div class="shadow_big">
                              <div class="right_box_all_inner">
                                    <div class="left_txt"><span>*</span> <?php echo t('Required field')?></div>
                                    <div class="brd"><?php echo t('Please take a moment and fill the form out below.')?></div>
                                    
                                    <div class="lable01">  <?php echo t('Quote Period')?><span class="red_text"> * </span></div>
                                    <div class="fld01">
                                          <select name="opd_quote_period" id="opd_quote_period" style="width:300px;">
                                                <option value=""><?php echo t('Quote Period')?> </option>
												<?php
												for($i=$i_quote_days_start;$i<=(60-i_quote_days_start);$i++)
												{
												?>
												<option value="<?php echo $i;?>"><?php echo $i;?></option>
												<?php } ?>	
                                          </select>
                                         <!-- <script type="text/javascript">
											$(document).ready(function(arg) {
												$("#opd_quote_period").msDropDown();
												$("#opd_quote_period").hide();
											})
										</script>-->
                                    </div>
                                    <div class="spacer"></div>
                                    <div class="lable01"></div>
                                    <div class="fld01" style="padding-top:10px;">
                                          <input  class="button" type="button" id="btn_save_job" value="<?php echo t('Save')?>"/>
                                         <!-- <input  class="button" type="button" value="Cancel"/>-->
                                    </div>
                                    <div class="spacer"></div>
                              </div>
                        </div>
                      </form>
 
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>
</div>