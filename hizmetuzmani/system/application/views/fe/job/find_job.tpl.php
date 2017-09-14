<script type="text/javascript">
$(document).ready(function() {


var data_str = '';
	$(".small_button02").click(function() {
	data_str = $(this).attr('rel');
	$("#h_job_id").val(data_str);
	show_dialog('photo_zoom02');
	});
$("#btn_quote").click(function() { 
		var b_valid = true;
		var quote_val = /^[0-9]+$/;
		if($.trim($("#txt_quote").val())=="") //// For  name 
		{
			$("#err_txt_quote").text('<?php echo addslashes(t('Please provide your bid'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else if(quote_val.test($.trim($("#txt_quote").val()))==false)
		{
			$("#err_txt_quote").text('<?php echo addslashes(t('Please provide numeric value with no decimal point'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_txt_quote").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		if($.trim($("#ta_message").val())=="") //// For  name 
		{
			$("#err_ta_message").text('<?php echo addslashes(t('Please provide message'))?>').slideDown('slow');
			b_valid  =  false;
		}
		else
		{
			$("#err_ta_message").slideUp('slow').text('<?php echo addslashes(t(''))?>');
		}
		 if(!b_valid)
		{
		   // $.unblockUI();  
			//$("#div_err").html(s_err).show("slow");
		}
		
		else
		{
		//$("#ajax_frm_job_confirm").submit();
		var quote 	= $("#txt_quote").val();
		var comment = $("#ta_message").val();
		var job_id = $("#h_job_id").val();
		 		$.ajax({
                        type: "POST",
                        async: false,
                        url: base_url+'job/save_quote_job',
                        data: "txt_quote="+quote+"&ta_message="+comment+"&h_job_id="+job_id,
                        success: function(res){
                            if(res)
                            {
								res = res.split('|');
								var s_res = res[1];								
								if(res[0]==1)
								{
									$('#div_err11').html('<div class="success_massage">'+s_res+'<div>');
								}
								else
									$('#div_err11').html('<div class="error_massage">'+s_res+'<div>');
							}
                        }
                    });
			setTimeout('window.location.reload()',2000);		
		}
		return false;
	});	

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
    var s_err="";
    $("#div_err").hide("slow"); 
	   
    /////////validating//////
    if(!b_valid)
    {
        //$.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
}); 		
		
<?php if($posted['src_job_category_id']) { ?>

var cat_id = <?php echo decrypt($posted['src_job_category_id']) ?>;

//i_category_id_child   === i_category_id_msa_0
//alert($("#i_category_id_msa_1").text());

<?php } ?>

});  // end of document ready

/*function get_city_state_name(inputString) {
		var p = $("#txt_city");
		var offset = p.offset();
		
		if(inputString.length>1) {	
			
			var opt_city = $("#txt_city").val();
			
			$.post("<?=base_url()?>home/ajax_autocomplete_city_state/"+opt_city+"/", {queryString: "" + inputString + ""}, function(data){
					if(data.length >0) {
					
						$('#suggestionsSearch').show();
						$('#autoSuggestionsListSearch').html(data);
						$('#suggestionsSearch').css('left',offset.left);
					}
					else
					{
						$('#suggestionsSearch').hide();
					}
				});
			}
			else
				$('#suggestionsSearch').hide();	
	} // lookup

	function business_fill(thisValue) {
		var b=new Array();
		b["&amp;"]="&";
		b["&quot;"]='"';
		b["&#039;"]="'";
		b["&lt;"]="<";
		b["&gt;"]=">";
		var r;
		for(var i in b){
			r=new RegExp(i,"g");
			thisValue = thisValue.replace(r,b[i]);
		}
		var prop_val = thisValue.split('^');		
		
		$('#opt_city_id').val(prop_val[1]);
		$('#txt_city').val(prop_val[0]);
		$('#suggestionsSearch').hide();
		
	}*/
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <?php include_once(APPPATH."views/fe/common/job_category_list.tpl.php"); ?>
                  <div class="find_job">
                        <h5><?php echo addslashes(t('Find Job'))?></h5>
                        <div class="found_box"><img src="images/fe/search.png" alt="" /> <?php echo $tot_job?> <?php echo addslashes(t('Job(s) found'))?></div>
                        <p class="required02"><?php echo addslashes(t('You can search jobs easily specifing job type, category and location'))?></p>
                        <div class="spacer"></div>
						
						<form name="frm_adv_src" id="frm_adv_src" action="<?php echo base_url().'job/find-job'?>" method="post">
						
                        <div class="job_search_box">
                        
                        <div class="lable"><?php echo addslashes(t('Category'))?></div>
                        <div class="textfell05"><?php //echo '=='.decrypt($posted['src_job_category_id']) ?>
						<select name="i_category_id" id="i_category_id" style="width:244px;">                     
						<option value=""> <?php echo addslashes(t('All'))?></option>
                     <?php echo makeOptionCategory(" c.i_status=1 ", $posted['src_job_category_id']);?>
                        </select>
						<!--<select id="category" name="category" style=" width:249px;">
                        <option>All</option>
                        </select>-->
                        <script type="text/javascript">
						$(document).ready(function() {
						  $("#i_category_id").msDropDown();
						   $("#i_category_id").hide();
						   $('#i_category_id_msdd').css("background-image", "url(images/fe/select02.png)");
						   $('#i_category_id_msdd').css("background-repeat", "no-repeat");
						   $('#i_category_id_msdd').css("width", "249px");
						   $('#i_category_id_msdd').css("margin-top", "0px");
						   $('#i_category_id_msdd').css("padding", "0px");
						    $('#i_category_id_msdd').css("height", "38px");
						     $('#i_category_id_msdd').css("margin-right", "20px");
						});
					
					</script>
                        </div>                        
                        
               
                     <div class="lable"><?php echo addslashes(t('City'))?> </div>
                        <div class="textfell05">
						<!-- autocomplete code for city -->
						<?php /*?><div class="parent_city">
						<input type="text"  name="txt_city" id="txt_city" onkeyup="get_city_state_name(this.value)" value="<?php echo $posted['txt_city'] ?>" autocomplete="off" />
						<input type="hidden" name="opt_city_id" id="opt_city_id"  />
					</div>
					<div class="suggestionsBox" id="suggestionsSearch" style="display: none; width:230px; overflow-x:hidden; position:absolute;">
					<div class="arrow_autocom"> &nbsp; </div>
					<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
                              					  		
                    </div>     
                    <span><?php echo addslashes(t('Please enter 2 characters to get a suggestion'))?></span><?php */?>
						<!-- end autocomplete code for city -->
						
						<!-- make city dropdown code -->
					
						<select id="opt_city_id" name="opt_city_id" style=" width:249px;">
                        <option value=""><?php echo addslashes(t('All'))?></option>
						<?php echo makeOptionCity('',$posted['src_job_city_id']) ?>
                        </select>
                        <script type="text/javascript">
						$(document).ready(function() {
						  $("#opt_city_id").msDropDown();
						   $("#opt_city_id").hide();
						   $('#opt_city_id_msdd').css("background-image", "url(images/fe/select02.png)");
						   $('#opt_city_id_msdd').css("background-repeat", "no-repeat");
						   $('#opt_city_id_msdd').css("width", "249px");
						   $('#opt_city_id_msdd').css("margin-top", "0px");
						   $('#opt_city_id_msdd').css("padding", "0px");
						    $('#opt_city_id_msdd').css("height", "38px");
						   
						});
					
					</script>
                        </div>       
                             <!-- make city dropdown code -->
                        
                          <div class="spacer margin05"></div>
                          <div class="lable"><?php echo addslashes(t('Keywords'))?> </div>
                        <div class="textfell07">
                        <input name="txt_keyword" id="txt_keyword" value="<?php echo $posted['src_job_keyword']?>" type="text" />
                        </div>
						<?php /*?><input type="hidden" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_job_fulltext_src']?>" />
				<input type="hidden" name="txt_fulladd_src" id="txt_fulladd_src" value="<?php echo $posted['src_job_fulladd_src']?>" /><?php */?>
						<div class="spacer"></div>
						
						<div class="textfell06 nobackground" style="width:50px;">
                         <input name="i_status[]" id="i_open" type="checkbox" value="1" <?php if($posted['src_job_status']){ foreach($posted['src_job_status'] as $status) { if($status==1) {echo "checked='checked'";} } } ?> />
                        </div>
						<div class="lable width02"><?php echo addslashes(t('Active'))?> </div>
						
						
						<div class="textfell06 nobackground" style="width:50px;">
                         <input name="i_status[]" id="i_active" type="checkbox" value="2" <?php if($posted['src_job_status']){ foreach($posted['src_job_status'] as $status) { if($status==2) {echo "checked='checked'";} } } ?> />
                        </div>
						<div class="lable width02"><?php echo addslashes(t('Frozen'))?> </div>
						
						
						<div class="textfell06 nobackground" style="width:50px;">
                         <input name="i_status[]" id="i_hired" type="checkbox" value="3" <?php if($posted['src_job_status']){ foreach($posted['src_job_status'] as $status) { if($status==3) {echo "checked='checked'";} } } ?> />
                        </div>
						<div class="lable width02"><?php echo addslashes(t('Hired'))?> </div>
						
						
						<div class="textfell06 nobackground" style="width:50px;">
                         <input name="i_status[]" id="i_completed" type="checkbox" value="4" <?php if($posted['src_job_status']){ foreach($posted['src_job_status'] as $status) { if($status==4) {echo "checked='checked'";} } } ?> />
                        </div>
						<div class="lable width02"><?php echo addslashes(t('Completed'))?> </div>
						
						
                        <input class="small_button margintop0" id="btn_save" value="<?php echo addslashes(t('Search'))?>" type="button"/>
                        <div class="spacer"></div>
                        
                         
                        
                        <div class="spacer"></div>
                        
                        </div>
						
						</form>
                        
						<!-- job listing  -->
                        <div class="find_box02" id="job_list">
						
                         	<?php echo $job_contents;?>
							
                        </div>
						<!-- job listing  -->
						<!-- pagination div -->
                       
                  		<!-- pagination div -->
                      <div class="spacer"></div>
					 <?php //pr($loggedin); 
					 if(empty($loggedin) || decrypt($loggedin['user_type_id'])!=1) {
					  ?>
						 <h5 class="righttext">
						<a href="<?php echo base_url().'user/registration/'.encrypt(2) ?>"><?php echo addslashes(t('Create your profile to quote'))?></a>
						</h5>
				<?php } ?>
                  </div>
                  
                  
                  <div class="spacer"></div>
                  
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
	  
	  
<form name="ajax_frm_job_quote" id="ajax_frm_job_quote" method="post" action="<?php echo base_url().'job/save_quote_job'?>">
<!--lightbox-->
<div class="lightbox02 photo_zoom02 width04">
<div id="div_err11">
</div>
      <div class="close"><a href="javascript:void(0);" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      <h3><?php echo addslashes(t('Place Quote'))?></h3>
      <div class="lable04"><?php echo addslashes(t('Your bid'))?> :</div>
      <div class="textfell">
            <input type="hidden" name="h_job_id" id="h_job_id" value="" />
            <input name="txt_quote" id="txt_quote" type="text" />
      </div>  <div class="lable03">TL</div>
	  <div class="spacer"></div>
	  <div id="err_txt_quote" class="err" style="margin-left:130px;"><?php echo form_error('txt_quote') ?></div>
      <div class="spacer"></div>
       <div class=" lable04"><?php echo addslashes(t('Message'))?> :</div>
      <div class="textfell06">
          <textarea name="ta_message" id="ta_message"></textarea>
      </div>
	  <div class="spacer"></div>
	  <div id="err_ta_message" class="err" style="margin-left:130px;"><?php echo form_error('ta_message') ?></div>
      <div class="spacer"></div>
      <div class="lable04"></div>
      <input class="small_button" type="button" id="btn_quote" value="<?php echo addslashes(t('Submit'))?>" />
</div>
<!--lightbox-->
</form>	  