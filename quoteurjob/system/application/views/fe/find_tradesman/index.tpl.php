<script type="text/javascript">
/*function check_char()
{
	
	var curVal = document.getElementById("txt_postal_code");
	var alphanum=/^[/s0-9a-bA-B]+$/; //This contains A to Z , 0 to 9 and A to B
	if(curVal.value == '')
	{
		return true;
	}
	else if (curVal.value.match(alphanum)) 
	{
		return true;
		
	}
	else
	{
		var s_err ='<div class="error"><span class="left"><strong><?php echo t('Postal code must be alphanumeric.')?>.</strong></span></div>';
		$("#div_err").html(s_err).show("slow");
		return false;
	}
	
}*/

</script>
<script>
$(document).ready(function(){
	$('#txt_postal_code').alphanumeric({allow:" "});
	 var strhgt= $(".divheight").height();
 		$(".scrollDiv").height(strhgt);
		
		
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
   
       //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_adv_src").submit();
	   //check_duplicate();
   }); 
});  

///////////Submitting the form/////////
$("#frm_adv_src").submit(function(){
    var b_valid=true;
	var pattern = /^[a-zA-Z]+/;
    var s_err="";
    $("#div_err").hide(); 

	var postal = $.trim($("#txt_postal_code").val());
	
	if(postal!='' && postal.length!=7)
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide postal code with 7 characters'))?>.</strong></span></div>';
		b_valid=false;
	}
    
    /////////validating//////
    if(!b_valid)
    {
        //$.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show();
    }
    
    return b_valid;
}); 	
		
		
});
</script>

<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
            <div class="body_left">
               <?php include_once(APPPATH.'views/fe/common/tradesman_category_list.tpl.php'); ?>
				  
				  
            </div>
            <div class="body_right">
					<div id="div_err">
					<?php
						echo validation_errors();
					?>
					</div>
                  <h1><?php echo get_title_string(t('Find Tradesman'))?></h1>
                  <h4 class="left"><img src="images/fe/search.png" alt="" style="vertical-align:middle" /> <span><?php echo $tot_job?></span> <?php echo t('Tradesman(s) found')?></h4>
                  <?php /*?><span class="right" style="color:#989898"><?php echo t('You can find Tradesman easily specifing job type, category and location')?>.</span><?php */?>
                  <div class="spacer"></div>
				  <div class="divheight">
				  <form name="frm_adv_src" id="frm_adv_src" action="" method="post">
                  <div class="grey_box02">
                        <div class="lable01" style="width:90px;"><?php echo t('Category')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="i_category_id" id="i_category_id" style="width:244px;">                     
							  <option > <?php echo t('All')?></option>
                                    <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id", $posted['src_tradesman_category_id']);?>
                              </select>
                              <script type="text/javascript">
                                $(document).ready(function(arg) {
                                  //  $("#i_category_id").msDropDown();
                                 //   $("#i_category_id").hide();
                                })
                            </script>
                        </div>
						
						
						
                        <div class="lable01" style="width:90px;"><?php echo t('Postal code')?></div>
                        <div class="fld01" style="width:240px;">
                              <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['src_tradesman_postal_code']?>"  style="width:230px;" maxlength="7" />
                        </div>						
						
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"><?php echo t('City')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_city_id" id="opt_city_id" style="width:244px;">
                                    <option value=""> <?php echo t('All')?></option>
									<?php echo makeOptionCity('', $posted['src_tradesman_city_id'])?>
                              </select>
                              <script type="text/javascript">
                                        $(document).ready(function(arg) {
                                            //$("#opt_city_id").msDropDown();
                                           // $("#opt_city_id").hide();
                                        })
                                    </script>
                        </div>
						
                        <div class="lable01" style="width:90px;"><?php echo t('Radius')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_radius" id="opt_radius" style="width:244px;">
									<option value=""><?php echo t('Select')?></option>
                                    <?php echo makeOptionRadiusOption('', $posted['src_tradesman_radius'])?>                             
							  </select>							  
                              <script type="text/javascript">
								$(document).ready(function(arg) {
								//	$("#opt_radius").msDropDown();
								//	$("#opt_radius").hide();
								})
							</script>
                        </div>
                        <div class="spacer"></div>
						
						
                        <div class="lable01" style="width:90px;"><?php echo t('Results / Page')?></div>
                        <div class="fld01" style="width:240px;">
                               <select name="opt_record" id="opt_record" style="width:244px;">
                                    <option value=""><?php echo t('Select')?></option>
                                    <?php echo makeOptionPaginationOption('',$posted['src_tradesman_record']);?>
                              </select>
                              <script type="text/javascript">
								$(document).ready(function(arg) {
									//$("#opt_record").msDropDown();
									//$("#opt_record").hide();
								})
							</script>
                        </div>
                      
						<div class="lable01" style="width:90px;"> <?php echo t('Sort by')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_sort" id="opt_sort" style="width:244px;">
                                    <?php /*?><option  value=""<?php if($posted['src_tradesman_sort'] == '') echo 'selected'; ?>><?php echo t('None')?></option><?php */?>
									<option value="1" <?php if($posted['src_tradesman_sort'] == 1) echo 'selected'; ?>><?php echo t('Feedback Rating')?></option>
                                    <option value="2" <?php if($posted['src_tradesman_sort'] == 2) echo 'selected'; ?>><?php echo t('Jobs own')?> </option>
                              </select>
                              <script type="text/javascript">
							$(document).ready(function(arg) {
								//$("#sort_for").msDropDown();
								//$("#sort_for").hide();
							})
						</script>
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"></div>
                        <div class="fld01" style="width:240px;">
								<input type="hidden" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_tradesman_fulltext_src']?>" />
								<input type="hidden" name="txt_fulladd_src" id="txt_fulladd_src" value="<?php echo $posted['src_tradesman_fulladd_src']?>" />
                              <input  name="btn_save" id="btn_save" class="button" type="Submit" value="<?php echo t('Search')?>" />
                        </div>
                        <div class="spacer"></div>
                  </div>
				  </form>
				  <div id="job_list">
                  <?php echo $job_contents;?>
				  </div>
				  <div class="divheight">
            </div>
            <div class="spacer"></div>
      </div>
</div>