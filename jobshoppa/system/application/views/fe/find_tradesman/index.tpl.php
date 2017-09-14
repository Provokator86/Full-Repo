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
	
	/*if(postal!='' && postal.length!=7)
	{
		s_err +='<div class="error_massage"><strong>Please provide postal code with 7 characters.</strong></div>';
		b_valid=false;
	}*/
    
    /////////validating//////
    if(!b_valid)
    {
        //$.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show();
    }
    
    return b_valid;
}); 	
		
		
});

function get_city_state_name(inputString) {
		var p = $("#txt_city");
		var offset = p.offset();
		
		if(inputString.length>2) {	
			//var opt_state = $("#opt_state").val();
			var opt_city = $("#txt_city").val();
			//var txt_zip = $("#txt_zip").val();
			
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
		
	}


</script>
<div id="banner_section"> 
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
	?>
	
<div id="content_section">
    <div id="content">
		<div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
        </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Search </span>Professionals</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>Find a local service professional</h6>-->
            <p>&nbsp;</p>
			<form name="frm_adv_src" id="frm_adv_src" action="<?php echo base_url().'find_tradesman'?>" method="post">			
            <div class="search_job_02">
                <div class="label02">Category :</div>
                <div class="field01">
                     <select name="i_category_id" id="i_category_id">                     
					  	<option > <?php echo t('All')?></option>
						<?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 ", $posted['src_tradesman_category_id']);?>
					 </select>
                </div>
                <div class="label02">City/Town : </div>
                <div class="field01">
                	<?php /*?><select name="opt_city_id" id="opt_city_id">
						<option value="">All</option>
						<?php echo makeOptionCity('', $posted['src_tradesman_city_id'])?>
                    </select>  <?php */?> 
					<div class="parent_city" style="width:300px;">
						<input type="text"  name="txt_city" id="txt_city" onkeyup="get_city_state_name(this.value)" value="<?php echo $posted['txt_city'] ?>" autocomplete="off" style="width:218px;"/>
						<input type="hidden" name="opt_city_id" id="opt_city_id"  />
					</div>       
					<div class="suggestionsBox" id="suggestionsSearch" style="display: none; width:220px; overflow-x:hidden; position:absolute;">
								<div class="arrow_autocom"> &nbsp; </div>
								<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
                    </div>       
                    <p style="font-size:10px;">Please enter 3 characters to get a suggestion</p>
                </div>
                <div class="clr"></div>
                <div class="label02">Post Code : </div>
                <div class="field01">
                    <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['src_tradesman_postal_code']?>" maxlength="8" />
					<p style="font-size:10px;">[Example: GY9 3AG, DD11 2PP, etc.]</p>
                </div>
                <div class="label02">Radius : </div>
                <div class="field01">
					<select name="opt_radius" id="opt_radius">
							<option value="">Select</option>
							<?php echo makeOptionRadiusOption('', $posted['src_tradesman_radius'])?>                             
				   </select>	
                </div>
                <div class="clr"></div>
                <!--      <div class="label02">Job Type : </div>
                <div class="field01">
                    <select name="">
                        <option>Open</option>
                        <option>Assigned</option>
                        <option>Hired</option>
                    </select>
                </div>-->
                <div class="label02">Sort by : </div>
                <div class="field01">
                    <select name="opt_sort" id="opt_sort">
						<?php /*?><option  value=""<?php if($posted['src_tradesman_sort'] == '') echo 'selected'; ?>><?php echo t('None')?></option><?php */?>
						<option value="1" <?php if($posted['src_tradesman_sort'] == 1) echo 'selected'; ?>><?php echo t('Review Rating')?></option>
						<option value="2" <?php if($posted['src_tradesman_sort'] == 2) echo 'selected'; ?>><?php echo t('Jobs won')?> </option>
				   </select>
                </div>
                <div class="label02"> Results / Page : </div>
                <div class="field01">
                     <select name="opt_record" id="opt_record">
							<option value="">Select</option>
							<?php echo makeOptionPaginationOption('',$posted['src_tradesman_record']);?>
                     </select>
                </div>
                <div class="clr"></div>
                <div class="search_button">
					<input type="hidden" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_tradesman_fulltext_src']?>" />
					<input type="hidden" name="txt_fulladd_src" id="txt_fulladd_src" value="<?php echo $posted['src_tradesman_fulladd_src']?>" />
				  <input  name="btn_save" id="btn_save"  type="submit" value="Search" />
                    
                </div>
                <div class="clr"></div>
            </div>
		
			
            <div class="search_job_result" id="tradesman_list">
                <?php echo $job_contents;?>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>