<script>
$(document).ready(function(){

		
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
   
       //$.blockUI({ message: 'Just a moment please...' });
       $("#tradesman_srch").submit();
	   //check_duplicate();
   }); 
});  

///////////Submitting the form/////////
$("#tradesman_srch").submit(function(){
    var b_valid=true;
	var pattern = /^[a-zA-Z]+/;
    var s_err="";
    $("#div_err").hide(); 
	
    /////////validating//////
    if(!b_valid)
    {
        //$.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show();
    }
    
    return b_valid;
}); 	
		
		
});

// Ajax call to populate province options
function call_ajax_get_province(ajaxURL,item_id,cngDv)
{
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'ajax_fe/'+ajaxURL,
				data: "city_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   $("#opt_state").msDropDown();
					   $("#opt_state").hide();
					   $('#opt_state_msdd').css("background-image", "url(images/fe/select02.png)");
					   $('#opt_state_msdd').css("background-repeat", "no-repeat");
					   $('#opt_state_msdd').css("width", "249px");
					   $('#opt_state_msdd').css("margin-top", "0px");
					   $('#opt_state_msdd').css("padding", "0px");
					   $('#opt_state_msdd').css("height", "38px");
					   

				   }   
				}
			});
}
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
	<div class="top_part"></div>
      <div class="midd_part height02">
         <div class="spacer"></div>
                 
          <?php include_once(APPPATH.'views/fe/common/tradesman_category_list.tpl.php'); ?>
                
		<form name="tradesman_srch" id="tradesman_srch" action="" method="post">		  
		  <div class="find_job">
				<h5><?php echo addslashes(t('Find Tradesman'))?></h5>
				<div class="found_box"><img src="images/fe/search.png" alt="" /> <?php echo $tot_rows ?> <?php echo addslashes(t('Tradesman(s) found'))?></div>
				<p class="required02"><?php echo addslashes(t('You can find tradesmans easily specifing keywords, category and location'))?></p>
				<div class="spacer"></div>
				<div class="job_search_box">
				<div class="lable"><?php echo addslashes(t('Category'))?></div>
				<div class="textfell05">
				<select id="category" name="category" style=" width:249px;">
				<option value=""> <?php echo addslashes(t('All'))?></option>
                     <?php echo makeOptionCategory(" c.i_status=1 ", $posted['src_tradesman_category_id']);?>
				</select>
				<script type="text/javascript">
				$(document).ready(function() {
				  $("#category").msDropDown();
				   $("#category").hide();
				   $('#category_msdd').css("background-image", "url(images/fe/select02.png)");
				   $('#category_msdd').css("background-repeat", "no-repeat");
				   $('#category_msdd').css("width", "249px");
				   $('#category_msdd').css("margin-top", "0px");
				   $('#category_msdd').css("padding", "0px");
					$('#category_msdd').css("height", "38px");
					 $('#category_msdd').css("margin-right", "10px");
				});
			
			</script>
				</div>
				
				 <div class="lable"><?php echo addslashes(t('City'))?> </div>
				<div class="textfell05">
				<select id="opt_city" name="opt_city" style=" width:249px;" onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_state");'>
				<option value=""><?php echo addslashes(t('Select City'))?></option>
				<?php echo makeOptionCity('',$posted['src_tradesman_city_id']); ?>
				</select>
				<script type="text/javascript">
				$(document).ready(function() {
				  $("#opt_city").msDropDown();
				   $("#opt_city").hide();
				   $('#opt_city_msdd').css("background-image", "url(images/fe/select02.png)");
				   $('#opt_city_msdd').css("background-repeat", "no-repeat");
				   $('#opt_city_msdd').css("width", "249px");
				   $('#opt_city_msdd').css("margin-top", "0px");
				   $('#opt_city_msdd').css("padding", "0px");
					$('#opt_city_msdd').css("height", "38px");
				});
			
			</script>
				</div>
				<div class="spacer"></div>
				<div class="margin05"></div>
				
				  <div class="lable"><?php echo addslashes(t('Keywords'))?> </div>
				<div class="textfell06">
				<input name="txt_keyword" id="txt_keyword" value="<?php echo $posted['src_tradesman_keyword'] ?>" type="text" />
				</div>

				   <div class="lable"><?php echo addslashes(t('Province'))?></div>
				<div class="textfell05">
				
				<div id="parent_state">
					<select id="opt_state" name="opt_state" style=" width:249px;">
					<option value=""><?php echo addslashes(t('Select Province')) ?></option>
					<?php echo makeOptionProvince(' i_city_id ="'.decrypt($posted['src_tradesman_city_id']).'" ',$posted['src_tradesman_province_id']); ?>
					</select>
				</div>
			  <script type="text/javascript">
				$(document).ready(function() {
				  $("#opt_state").msDropDown();
				   $("#opt_state").hide();
				   $('#opt_state_msdd').css("background-image", "url(images/fe/select02.png)");
				   $('#opt_state_msdd').css("background-repeat", "no-repeat");
				   $('#opt_state_msdd').css("width", "249px");
				   $('#opt_state_msdd').css("margin-top", "0px");
				   $('#opt_state_msdd').css("padding", "0px");
					$('#opt_state_msdd').css("height", "38px");
					$('#opt_state_msdd').css("margin-right", "20px");
				  
				});
			
			</script>
				</div>
										  
			   <div class="spacer"></div>
			   <div class="textfell06 nobackground">
			   <input name="i_verify" id="i_verify" type="checkbox" value="1" <?php if($posted['src_tradesman_verified']==1) echo "checked='checked'"; ?> /></div>
				<div class="lable width02"><?php echo addslashes(t('Only Verified Tredsman'))?> </div>
				
				<div class="textfell06 nobackground">
				<input name="i_holiday" id="i_holiday" type="checkbox" value="1" <?php if($posted['src_tradesman_holiday']==1) echo "checked='checked'"; ?> /></div>
				<div class="lable width02"><?php echo addslashes(t('Work on Holidays'))?> </div>
			
				
				<div class="textfell06 nobackground">
				<input name="i_weekend" id="i_weekend" type="checkbox" value="1" <?php if($posted['src_tradesman_weekend']==1) echo "checked='checked'"; ?>/></div>
				<div class="lable width02"><?php echo addslashes(t('Weekends'))?> </div>
				
				<input class="small_button" style="float:right; margin-right:25px;" id="btn_save" name="btn_save" value="<?php echo addslashes(t('Search'))?>" type="button"/>

				 <div class="spacer"></div>
				
				</div>
		</form>		
			<!--find_tradesman_box-->
			<div id="trades_list">
			<?php echo $tradesman_list ?>
			</div>			 
			<!--find_tradesman_box-->
		  <div class=" spacer"></div>
		  <?php //pr($loggedin); 
			 if(empty($loggedin) || decrypt($loggedin['user_type_id'])!=2) {
			  ?>
				 <h5 class="righttext">
				<a href="<?php echo base_url().'job/job-post' ?>"><?php echo addslashes(t('Are you ready to post your job for free'))?>?</a>
				</h5>
		<?php } ?>
		  
		  </div>
                  <div class="spacer"></div>
      </div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>