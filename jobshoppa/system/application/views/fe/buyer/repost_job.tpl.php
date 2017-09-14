<?php
/*********
* Author: Koushik Rout
* Date  : 30 Nov 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View for edit job for client
* 
* @package Client
* @subpackage 
* 
* @link controllers/buyer.php
*/
?>
<script>
$(document).ready(function(){

$("input[name='txt_time']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
											   //yearRange: "-100:+0",
                                               changeMonth:true,
											    minDate: 0,												
												beforeShow: function(input, inst) {$('#ui-datepicker-div div').show()}
                                              });//DOB    


$('#ui-datepicker-div').hide();




    /*** generate upload file button ***/
        var max_allow_open = 5;
        var cnt = parseInt(<?php echo count($posted['job_files'])+1; ?>);  
        $("#blue_link").click(function(){
            var str = '';            
            str += '<input type="file"  name="f_image_'+cnt+'" size="40"/>';
            $("#attch_div").append(str);
            cnt++;
            if(cnt>=max_allow_open)
            {
                $("#blue_link").remove();
            }
        });
    /*** end generate upload file button ***/
    

    
    
///////////Submitting the form/////////
$("#frm_edit_job").submit(function(){    
    var b_valid=true;
    var s_err="";
   // $("#div_err").hide("slow");     
    //alert( typeof( $( 'frm_job_post' )));

    if($.trim($("#txt_title").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide job title</strong>.</div>';
        b_valid=false;
    }
    if($.trim($("#opd_category_id").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select category.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#opt_state").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select county.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#opt_city").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select City/Town.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#opt_zip").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select postal code.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#txt_description").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select description.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#txt_keyword").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select keyword.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#opd_quoting_period_days").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select quote period.</strong></div>';
        b_valid=false;
    }    
    if($.trim($("#txt_budget_price").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide budget price.</strong></div>';
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
    $('#btn_job_post').click(function(){
        $("#frm_job_post").submit();
    }); 

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
                       //call_ajax_get_zipcode("ajax_change_zipcode_option",0,0,"parent_zip"); // to repopulate zip options
					    $('#txt_zip').val('');
						$('#opt_zip').val('');

                   }   
                }
            });
    //});    
}

/*function call_ajax_get_zipcode(ajaxURL,item_id,state_id,cngDv)
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
}*/

function call_ajax_get_zipcode_list(ajaxURL,item_id,state_id,cngDv)
{
	//jQuery.noConflict();///$ can be used by other prototype which is not jquery
	//jQuery(function($) {
	//alert(decrypt(state_id));
		//document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';	
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "city_id="+item_id+"&state_id="+state_id,
				success: function(msg){
				   if(msg!='')
				   {}	
				   		$('#txt_zip').val('');
						$('#opt_zip').val('');
						$('#suggestionsSearch').hide();
				   
					   //document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_zip").msDropDown();
				}
			});
	//});	
}


function get_zipcode_name(inputString) {
		var p = $("#txt_zip");
		var offset = p.offset();
		
		if(inputString.length>2) {	
			var opt_state = $("#opt_state").val();
			var opt_city = $("#opt_city").val();
			var txt_zip = $("#txt_zip").val();
			
			$.post("<?=base_url()?>home/ajax_autocomplete_zipcode/"+opt_city+"/"+ opt_state+"/"+txt_zip, {queryString: "" + inputString + ""}, function(data){
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
		$('#txt_zip').val(prop_val[0]);
		$('#opt_zip').val(prop_val[1]);
		$('#suggestionsSearch').hide();
		
	}

function select_available(param)
{
    if(param==1)
    {
        $("#show_specific").hide();
        $("#show_flexi").show();
    }    
    else
    {
        $("#show_flexi").hide();
        $("#show_specific").show();
    }
            
    
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
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
     <div id="div_err">
         <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); 
            //show_msg("error");  
            echo validation_errors();
            //pr($posted);
        ?>
      </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Post</span> Job</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; Try to give service providers as much information as possible in order to get a reasonable amount of quality bids. &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
            
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;">
                            <p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
                            <form name="frm_edit_job" id="frm_edit_job" method="post" action="" enctype="multipart/form-data"> 
                            <div id="form_box01">
                                <div class="label03">Job Title <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text"  name="txt_title" id="txt_title"  value="<?php echo $posted['txt_title']?>"  size="48" />  
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Category <span class="red_txt">*</span> :</div>
                                <div class="field04">
                                    <select name="opd_category_id" id="opd_category_id" >
                                        <option value="">Select category</option>
                                         <?php echo makeOptionCategory(" s_category_type='job'",encrypt($posted['opd_category_id'])) ?>
                                   </select>
                                </div>
                                <div class="clr"></div>
                                <div class="title">
                                    <h5><span>Where do</span> you need the job done</h5>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">County <span class="red_txt">*</span> :</div>
                                <div class="field04">
                                     <select id="opt_state" name="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option_auto_complete",this.value,"parent_city");'>
                                        <option value="">Select county</option>
                                         <?php echo makeOptionState('',$posted['opt_province_id']) ?> 
                                     </select>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">City/Town <span class="red_txt">*</span> :</div>
                                <div class="field03">
                               <div id="parent_city">
                                    <select name="opt_city" id="opt_city" style="width:192px;" onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
                                        <option value="">Select city </option>
                                        <?php echo makeOptionCity('',encrypt($posted['opt_city_id'])) ?> 
                                    </select>
                                    </div>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Postal Code <span class="red_txt">*</span> :</div>
                                <div class="field03">
                               <div id="parent_zip">  
										<input type="text"  name="txt_zip" id="txt_zip" value="<?php echo $posted['s_zip'];?>" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;"/>
										<?php /*?><select name="opt_zip" id="opt_zip" style="width:192px; ">
											<option value="">Select postal code</option>
											<?php echo makeOptionZip(' city_id="'.$posted['opt_city_id'].'"',$posted['i_zipcode_id']) ?>
										</select><?php */?>
										<input type="hidden" name="opt_zip" id="opt_zip" value="<?php echo encrypt($posted['i_zipcode_id']);?>" />
                                    </div>
									 <div class="suggestionsBox" id="suggestionsSearch" style="display: none;  position:absolute;">
								<div class="arrow_autocom"> &nbsp; </div>
								<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; width:190px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
                              </div>
							  <p>Type 3 characters to get postal code suggestion.</p>
                                </div>
                                <div class="clr"></div>
                                <div class="title">
                                    <h5><span>What work</span> is required</h5>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Description <span class="red_txt">*</span> :</div>
                                <div class="field04">
                                    
                                    <textarea name="txt_description" id="txt_description" cols="50" rows="5" ><?php echo $posted['txt_description']?></textarea>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Should Professional Provide Material <span class="red_txt">*</span> :</div>
                                <div class="field04" style="margin-top:22px;">
                                     <input name="chk_supply_material" type="radio" value="1" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==1 ? 'checked="checked"' : '')?>  /> 
                                        Yes
                                        <input name="chk_supply_material" type="radio" value="2" <?php echo (!empty($posted['chk_supply_material']) && $posted['chk_supply_material']==2 ? 'checked="checked"' : '')?>/>
                                        No
                                        <input name="chk_supply_material" type="radio" value="0"  <?php echo (empty($posted['chk_supply_material']) ? 'checked="checked"' : '')?> />
                                        Doesn't Matter</div>
                                <div class="clr"></div>
                                <div class="label03">Keywords <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    
                                     <input type="text"  name="txt_keyword" id="txt_keyword" size="48" value="<?php echo $posted['txt_keyword']?>" />
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Quoting Period <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                   <select name="opd_quoting_period_days" id="opd_quoting_period_days" style="width:110px;">
                                        <?php
                                        for($i=1;$i<=60;$i++)
                                        {
                                            $select="";  
                                            if($posted["opd_quoting_period_days"]== $i)
                                            {
                                               $select=" selected "; 
                                            }
                                        ?>
                                              <option value="<?php echo $i;?>" <?php echo $select ?>><?php echo $i;?></option>
                                        <?php } ?>      
                                     </select>
                                    day(s) </div>
                                <div class="clr"></div>
                                <div class="label03">Starting Price :</div>
                                <div class="field03">
                                    <input type="text"  name="txt_budget_price" id="txt_budget_price"  size="20" style="width:100px;"  value="<?php echo $posted['txt_budget_price']?>" />£
                                </div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <ul style="list-style-type: none;">
                                    <?php foreach($posted['job_files'] as $files)
                                    {
                                    ?>
                                        <li><a href="<?php echo base_url().'job/download_job_files/'.encrypt($files['s_file_name']);?>" ><?php echo $files['s_file_name']; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                    </ul>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Attach Pictures/Files  :</div>
                                <div class="field03" id="attch_div">
                                    <input type="file" name="f_image_0"  size="40"/>
                                    
                                    
                                </div>
                                
                                <div class="clr"></div>
                                 <div class="label03">&nbsp;</div>
                                <div class="field03" >
                                <span style="font-size:11px; float:left;">Permitted file formats: .jpg, .gif, .png, .pdf.</span>
                                <?php if(count($posted['job_files'])<4)
                                    {
                                ?>
                                    <div class="attach_more"><a href="javascript:void(0)" id="blue_link">Attach more files</a></div>
                                <?php
                                    }
                                ?>
                                </div>
                                <div class="clr"></div>
<div class="title">
                                    <h5><span>When should </span> they start?</h5>
                                </div>
                                <div class="clr"></div>
                                <div class="label04">
                                    <input name="rd_available_time" type="radio" value="1"  style="margin-right:10px;" onclick="select_available(1);" <?php echo ($posted["rd_available_time"]==1)?"checked":"";?>/>
                                    I'm Flexible</div>
                                <div class="label04">
                                    <input name="rd_available_time" type="radio" value="2"  style="margin-right:10px;" onclick="select_available(2);" <?php echo ($posted["rd_available_time"]==2)?"checked":"";?>/>
                                    At a specific date and time</div>
                                <div class="clr"></div>
                                <div id="show_flexi" <?php echo ($posted["rd_available_time"]==2)?'style="display:none;"':'';?> >  
                                <div class="label03">&nbsp;</div>
                                <div class="field04" >
                                        <select name="opd_available_time" style="width:150px;">
                                            <?php echo makeOptionAvailableTime('',encrypt($posted["opd_available_time"])) ?>
                                        </select>
                                </div>
                                </div>
                                <div class="clr"></div>
                                 <div id="show_specific" <?php echo ($posted["rd_available_time"]==1)?'style="display:none;"':'';?> >
                                <div class="label03">&nbsp;</div>
                                <div  class="field07">
                                    <input type="text" name="txt_time" id="txt_time" value="<?php echo $posted['txt_time']?>"/>
                                    <a href="javascript:void(0)"><img src="images/fe/Calender.png" alt="" id="show_calender"  /></a>
                                    <select  name="txt_time_from" >
                                                <?php
                                                $j=1;
                                                $m = '  am';
                                                $select="";
                                                for($i=1;$i<=24;$i++)
                                                {
                                                    $select=""; 
                                                    if($i==13)
                                                    {
                                                        $j = 1;
                                                        $m = '  pm';
                                                    }
                                                    if($posted['txt_time_from']==$j.$m)
                                                    {
                                                       $select=" selected "; 
                                                    }
                                                ?>
                                                    
                                                <option value="<?php echo $j.$m;?>" <?php echo $select; ?>><?php echo $j.$m;?></option>
                                                <?php 
                                                    $j++;
                                                } ?>    
                            
                                            </select> 
                                    <select name="txt_time_to" >
                                                <?php
                                                $j=1;
                                                $m = '  am';
                                                for($i=1;$i<=24;$i++)
                                                {
                                                    $select=""; 
                                                    if($i==13)
                                                    {
                                                        $j = 1;
                                                        $m = '  pm';
                                                    }
                                                    if($posted['txt_time_to']==$j.$m)
                                                    {
                                                       $select=" selected "; 
                                                    }
                                                ?>
                                                    
                                                <option value="<?php echo $j.$m;?>" <?php echo $select; ?>><?php echo $j.$m;?></option>
                                                <?php 
                                                    $j++;
                                                } ?>    
                            
                                            </select>  
                                </div>
                                </div>
                                <div class="clr" style="padding-bottom:15px;"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input type="submit" value="Save" />
                                </div>
                                <div class="clr"></div>
                            </div>
                            </form> 
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>                 
                <?php
                    include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php");
                ?>
                
                
                
            </div>
            <div class="clr"></div>
        </div>
        
        
        
        <div class="clr"></div>
</div>
</div>
