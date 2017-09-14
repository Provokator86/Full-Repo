<script type="text/javascript">
$(document).ready(function(){
	$('#txt_postal_code').alphanumeric({allow:" "});
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
	//include_once(APPPATH."views/fe/common/common_search.tpl.php");
	?>
<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
           
	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>

	  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>

<?php } else {?>

	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } ?>	
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
	//include_once(APPPATH."views/fe/common/message.tpl.php");
	?>
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
                <h3><span>Find </span> a Job</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>You can find jobs easily by specifying job category</h6>-->
            <p>&nbsp;</p>
			
			<form name="frm_adv_src" id="frm_adv_src" action="<?php echo base_url().'job/find_job'?>" method="post">
            <div class="search_job_02">
                <div class="label02">Category :</div>
                <div class="field01">
                    <select name="i_category_id" id="i_category_id">                     
					  <option value="">All</option>
							<?php echo makeOptionCategory(" s_category_type='job' AND i_status=1", $posted['src_job_category_id']);?>
					<?php //echo makeOptionCategory(" s_category_type='job' AND i_status=1", ($posted['src_job_category_id_ses'])!=""?$posted['src_job_category_id_ses']:$posted['src_job_category_id']);?>
							
					  </select>
                </div>
                <div class="label02">City/Town : </div>
                <div class="field01">
				 <?php /*?> <select name="opt_city_id" id="opt_city_id">
						<option value="">All</option>
						<?php echo makeOptionCity('', $posted['src_job_city_id'])?>
				  </select><?php */?>
				  <div class="parent_city">
						<input type="text"  name="txt_city" id="txt_city" onkeyup="get_city_state_name(this.value)" value="<?php echo $posted['txt_city'] ?>" autocomplete="off" style="width:218px;"/>
						<input type="hidden" name="opt_city_id" id="opt_city_id"  />
					</div>       
					<div class="suggestionsBox" id="suggestionsSearch" style="display: none; width:230px; overflow-x:hidden; position:absolute;">
						<div class="arrow_autocom"> &nbsp; </div>
						<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
                    </div>     
                    <p style="font-size:10px;">Please enter 3 characters to get a suggestion</p>
                </div>
                <div class="clr"></div>
                <div class="label02">Post Code : </div>
                <div class="field01">
                    <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['src_job_postal_code']?>" maxlength="8" />
                	<p style="font-size:10px;">[Example: GY9 3AG, DD11 2PP, etc.]</p>
				</div>
                <div class="label02">Radius : </div>
                <div class="field01">
                   <select name="opt_radius" id="opt_radius">
						<option value="">Select</option>
						<?php echo makeOptionRadiusOption('', $posted['src_job_radius'])?>                             
				  </select>	
                </div>
                <div class="clr"></div>
                <div class="label02">Job Type : </div>
                <div class="field01">
                    <select name="opt_status" id="opt_status">
						<option value="">All</option>
						<?php //echo makeOptionJobStatus(array("0","2"), $posted['src_job_status'])?>
						<?php echo makeOption($arr_find_job_status,$posted['src_job_status']);?>
				  </select>
                </div>
                <div class="label02">Results / Page: </div>
                <div class="field01">
                    <select name="opt_record" id="opt_record">
							<option value="">Select</option>
							<?php echo makeOptionPaginationOption('',$posted['src_job_record']);?>
					  </select>
                </div>
                <div class="clr"></div>
                <div class="search_button">
				<input type="hidden" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_job_fulltext_src']?>" />
				<input type="hidden" name="txt_fulladd_src" id="txt_fulladd_src" value="<?php echo $posted['src_job_fulladd_src']?>" />
                <input type="submit" value="Search" />
                </div>
                <div class="clr"></div>
            </div>
			</form>
			
            <div class="search_job_result">
                <div class="result_box">
                    <div class="top">&nbsp;</div>
                    <div class="mid"  id="job_list">
                       
                        <?php echo $job_contents;?>
                        
                        
                       
                        <div class="clr"></div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
            </div>
        </div>
		
		
        <div class="clr"></div>
</div>
</div>
