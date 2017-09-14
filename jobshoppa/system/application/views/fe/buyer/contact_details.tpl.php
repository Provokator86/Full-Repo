<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#contact_form").submit();
	   //check_duplicate();
   }); 
});    


///////////Submitting the form/////////
$("#contact_form").submit(function(){
    var b_valid=true;
    var s_err="";
	//var reg_contact = /^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/;
	var reg_contact = /^(\+447\d{9})|(07\d{9})$/;
    var fax_number = /^0(\d){10}$/;
    $("#div_err").hide("slow"); 

    
	  if($.trim($("#txt_contact").val())== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide mobile number</strong></div>';
        b_valid=false;
    } 
    else if(reg_contact.test($.trim($("#txt_contact").val())) == false) 
    {
        s_err +='<div class="error_massage"><strong>Please provide valid mobile number</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#txt_landline").val())!='' && fax_number.test($.trim($("#txt_landline").val())) == false)
    {
        s_err +='<div class="error_massage"><strong>Please provide valid landline number of 11 digits</strong></div>';
        b_valid=false;
        
    }
    if($.trim($("#txt_fax").val())!='' && fax_number.test($.trim($("#txt_fax").val())) == false)
    {
        s_err +='<div class="error_massage"><strong>Please provide valid fax number of 11 digits</strong></div>';
        b_valid=false;
        
    }
        
    
    if($.trim($("#txt_address").val())== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide address.</strong></div>';
        b_valid=false;
    }    
    
       if($.trim($("#opt_state").val())=="") 
    {
         s_err +='<div class="error_massage"><strong>Please provide county</strong></div>'; 
        b_valid=false;
    }
    if($.trim($("#opt_city").val())=="") 
    {
         s_err +='<div class="error_massage"><strong>Please select city</strong></div>';       
        b_valid=false;
    }
    if($.trim($("#opt_zip").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select postal code</strong></div>';      
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
//});

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
                <h3><span>Contact </span> Details</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; Please take a moment and fill the form out below &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
            <form name="contact_form" id="contact_form" action="" method="post">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:862px;">
                            <p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
                            <div id="form_box01">
                                <div class="title">
                                    <h5><span>Details</span></h5>
                                </div>
                                <div class="clr"></div>
                                 <div class="label03">Mobile Number <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text"  name="txt_contact" id="txt_contact" value="<?php echo $posted['txt_contact'] ?>" size="48" /><br/><br/> Formats :  07222 555555 , 07222 555 555 
                                </div>
                                <div class="clr"></div>
                                                <div class="label03">Fax Number  :</div>
                                <div class="field03">
                                    <input name="txt_fax" id="txt_fax" type="text" size="48" value="<?php echo $posted["txt_fax"]; ?>"/>
                                    <br/> Formats : 01234567890
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Landline Number :</div>
                                <div class="field03">
                                    <input name="txt_landline" id="txt_landline" type="text" size="48" value="<?php echo $posted["txt_landline"]; ?>" />
                                    <br/> Formats : 01234567890 
                                </div>
                                <div class="clr"></div>
                               
                                <div class="label03">Skype IM :</div>
                                <div class="field03">
                                     <input name="txt_skype" id="txt_skype" type="text" size="48" value="<?php echo $posted["txt_skype"];?>" />
                                </div>
                                <div class="clr"></div>
                                <div class="label03">MSN IM :</div>
                                <div class="field03">
                                    <input name="txt_msn" id="txt_msn" type="text" size="48" value="<?php echo $posted["txt_msn"]; ?> "/>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">YAHOO IM :</div>
                                <div class="field03">
                                    <input name="txt_yahoo" id="txt_yahoo" type="text" size="48" value="<?php echo $posted["txt_yahoo"]; ?>"/>
                                </div>
                                <div class="clr"></div>
                                <div class="title">
                                    <h5><span>Address</span></h5>
                              </div>
                                <div class="clr"></div>
                                <div class="label03">Address <span class="red_txt">*</span> :</div>
                                <div class="field04">
                                  <input type="text" name="txt_address" id="txt_address" value="<?php echo $posted["txt_address"]; ?>" size="48"/>
                                </div>
                              <div class="clr"></div>
                                <div class="label03">County <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <select name="opt_state" id="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option",this.value,"parent_city");'>
                                            <option value="">Select county</option>
                                            <?php echo makeOptionState('',$posted["opt_province_id"]) ?>  
                                     </select>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">City <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                   <div id="parent_city">   
                                        <select name="opt_city" id="opt_city" style="width:192px;" onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
                                            <option value="">Select city</option>

                                             <?php echo makeOptionCity(' state_id="'.$posted["opt_province_id"].'"',encrypt($posted["opt_city_id"])) ;?>
                                            </select>
                                      </div>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Postal Code <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <div id="parent_zip"> 
										<input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;" value="<?php echo $posted['s_zip'];?>"/>
									
                                       <?php /*?> <select name="opt_zip" id="opt_zip" style="width:192px;">
                                            <option value="">Select postal code</option>
                                            <?php echo makeOptionZip(' city_id="'.$posted["opt_city_id"].'"',$posted["i_zipcode_id"]); ?>                                     
                                        </select><?php */?>
										<input type="hidden" name="opt_zip" id="opt_zip" value="<?php echo encrypt($posted['i_zipcode_id']);?>"/>
										
                                    </div>
									 <div class="suggestionsBox" id="suggestionsSearch" style="display: none; overflow-x:hidden; position:absolute;">
									<div class="arrow_autocom"> &nbsp; </div>
									<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
									</div>
									<p>Type 3 characters to get postal code suggestion.</p>
                                </div>
                                <div class="clr"></div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input type="submit" value="Save" />
                                    <input type="reset" value="Cancel" />
                                </div>
                                <div class="clr"></div>
                            </div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>     
               </form>
                <?php
                    include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php");
                ?>
                
                
                
            </div>
            <div class="clr"></div>
        </div>
        
        
        
        <div class="clr"></div>
</div>
</div>
      