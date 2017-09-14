<script type="text/javascript">
var max_allow_open = 3
var cnt = parseInt(<?php echo ($posted[cnt_opt_cat])?$posted[cnt_opt_cat]:1 ?>);  
$(document).ready(function(){
     
$("input[name='txt_dob']").datepicker({dateFormat: 'dd/mm/yy',
                                               changeYear: true,
											   yearRange: "-100:+0",
                                               changeMonth:true,											
												beforeShow: function(input, inst) {$('#ui-datepicker-div div').show()}
                                              });//DOB    


$('#ui-datepicker-div').hide(); 

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       //window.location.href=g_controller;
	   window.location.reload();
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_edit_profile").submit();
	   //check_duplicate();
   }); 
});    

/*** generate category dropdown ***/

		
		      $("#red_link").click(function(){
                 
                 var str = '<a href="javascript:void(0)" id="closecat_'+(cnt+1)+'" onclick="close_cat(this.id);"><img src="images/fe/close2.png" alt="" width="28" height="28" /></a>';
            var sel_cat=$("#category_div_"+1).html();

            $("#category_div_"+cnt).after('<div id="category_div_'+(cnt+1)+'" style="padding: 5px;"></div>');
            
            $("#category_div_"+(cnt+1)).append(sel_cat)  ;
            $("#category_div_"+(cnt+1)+" select").val('')  ;  
            $("#category_div_"+(cnt+1)).append(str);
            $("#category_div_"+(cnt+1)+" a[id^=closecat_]").attr('id','closecat_'+(cnt+1)); 
            cnt++;
            if(cnt>=max_allow_open)
            
            {
                $("#red_link").hide();
            }
        });
			
			

	/*** end generate category ***/
	
	
///////////Submitting the form/////////
$("#frm_edit_profile").submit(function(){	
    var b_valid=true;
    var s_err="";
	var file_type = $("#f_image").val();
    //var reg_contact = /^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/;
    //var tel_number = /^0(\d ?){10}$/;
    //var reg_contact = /^(\+44\s7\d{3}|\(?07\d{3}\)?)\s\d{3}\s\d{3}$/; 
	var reg_contact = /^(\+447\d{9})|(07\d{9})$/;
	//var tel_number  = /^0(\d{3}\s\d{7}|\d{2}\s\d{4}\s\d{4})/ ;
	var tel_number = /^0(\d){10}$/;
	
	
	if($.trim($("#txt_name").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide your full name.</strong></div>';
		b_valid=false;
	}
	/*if($.trim($("#txt_username").val())== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide a public username.</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#txt_username").val())!= '')
    {
        var txt_username =     $.trim($("#txt_username").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'user/check_username_exist',
                data: "s_username="+txt_username,
                success: function(msg){
                    if(msg)
                    {
                       if(msg=='error_pattern')
                       {
                            s_err +='<div class="error_massage"><strong>Please provide a public username. Public username must be at least 6 characters.</strong></div>';
                            b_valid=false;                        
                       } 
                    
                       if(msg=='error')
                       {
                            s_err +='<div class="error_massage"><strong>Public username already exist.</strong></div>';
                            b_valid=false;                        
                       } 
                   }
                }
            });    
            
        }*/
	if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|jpeg|png)$/)))
	{
		s_err +='<div class="error_massage"><strong>Please select proper image file type.</strong></div>';
		b_valid=false; 
	}
    
	 if($.trim($("#txt_contact").val())== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide a mobile number.</strong></div>';
        b_valid=false;
    } 
    else if(reg_contact.test($.trim($("#txt_contact").val())) == false) 
    {
        s_err +='<div class="error_massage"><strong>Please provide a valid mobile number.</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#txt_landline").val())!='' && tel_number.test($.trim($("#txt_landline").val())) == false)
    {
        s_err +='<div class="error_massage"><strong>Please provide your landline number. landline number should be 11 digits.</strong></div>';
        b_valid=false;
        
    }
    if($.trim($("#txt_fax").val())!='' && tel_number.test($.trim($("#txt_fax").val())) == false)
    {
        s_err +='<div class="error_massage"><strong>Please provide your fax number. fax number should be 11 digits.</strong></div>';
        b_valid=false;
        
    }
		
	
	if($.trim($("#txt_address").val())== '')
	{
	 s_err +='<div class="error_massage"><strong>Please provide an address.</strong></div>';
		b_valid=false;
	}	
	
	   if($.trim($("#opt_state").val())=="") 
    {
         s_err +='<div class="error_massage"><strong>Please provide a county</strong></div>'; 
        b_valid=false;
    }
	if($.trim($("#opt_city").val())=="") 
	{
		 s_err +='<div class="error_massage"><strong>Please select a City/Town</strong></div>';       
		b_valid=false;
	}
	if($.trim($("#opt_zip").val())=="") 
	{
        s_err +='<div class="error_massage"><strong>Please select your postal code</strong></div>';      
		b_valid=false;
	}
	if($.trim($("#txt_about_me").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please fill in the about you section.</strong></div>';       
		b_valid=false;
	}
	
	if($.trim($("#txt_business_name").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please add your Business name.</strong></div>';
		b_valid=false;
	}
    if($.trim($("#txt_dob").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide your date of birth.</strong></div>'; 
        b_valid=false;
    }
    else
    {   
        var txt_dob =     $.trim($("#txt_dob").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'user/ajax_check_dob',
                data: "s_dob="+txt_dob,
                success: function(msg){
                    if(msg)
                    {
                       if(msg=='error')
                       {
                            s_err +='<div class="error_massage"><strong>You must be over 18 to use this site.</strong></div>';
                            b_valid=false;                        
                       } 
                   }
                }
            });
        
    }  
	 if($.trim($("select.opd_category").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select a category.</strong></div>';
        b_valid=false;
    } 
    
     
	
	/*if(!$("input[name=i_accept_terms]:checkbox").is(":checkbox:checked"))
	{
		s_err +='<div class="error"><span class="left"><strong>Please accept terms & conditions.</strong></span></div>';
		b_valid=false;
	}	*/
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
	/*$('#btn_reg').click(function(){
		$("#form_buyer_reg").submit();
	}); */

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
					   $('#txt_zip').val('');
						$('#opt_zip').val('');
					   //$("#opt_city").msDropDown();
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
    
    
     function close_cat(param)
        {
            
          var div_id=param.split('_')[1];  
          
          $("#category_div_"+div_id).remove();
          var i=parseInt(div_id)+1;
          
          while(i<=cnt)
          {
              $("#category_div_"+i+" a[id^=closecat_]").attr('id','closecat_'+(i-1)); 
              $("#category_div_"+i).attr('id','category_div_'+(i-1));
             
             i++;  
          }
          cnt=cnt-1;
          $("#red_link").show();
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
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
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
                <h3><span>Edit </span> Professional Profile</h3>
            </div>
            <div class="clr"></div>
           <!-- <h6>&quot; Please take a moment and fill the form out below. &quot;</h6>-->
            <div class="clr"></div>
<div id="account_container">
	<div class="account_left_panel">
		<div class="round_container">
			<div class="top">&nbsp;</div>
			<div class="mid" style="min-height:918px;">
				<p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
<div id="form_box01">
	<form name="frm_edit_profile" id="frm_edit_profile" method="post" action="<?php echo base_url().'tradesman/edit_profile'?>" enctype="multipart/form-data">
	<div class="label03">Full Name <span class="red_txt">*</span> :</div>
	<div class="field03">
		<input name="txt_name" id="txt_name" type="text" size="48" value="<?php echo $posted["txt_name"]; ?>"/>
	</div>
	<div class="clr"></div>
	<div class="label03">Public Username <span class="red_txt">*</span> :</div>
	<div class="field03">
		<label><?php echo $posted["txt_username"]; ?></label>
		<input name="txt_username" id="txt_username" type="hidden" size="48" value="<?php echo $posted["txt_username"]; ?>" />
	</div>
	<div class="title">
		<h5><span>Contact</span> Details</h5>
	</div>
	<div class="clr"></div>
	<div class="label03">Mobile Number <span class="red_txt">*</span> :</div>
	<div class="field03">
		<input name="txt_contact" id="txt_contact" type="text" size="48" value="<?php echo $posted["txt_contact"]; ?>" />
		
	</div>
	<div class="clr"></div>
	<div class="label03">Fax Number :</div>
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
		<h5><span>Address</span> </h5>
	</div>
	<div class="clr"></div>
	<div class="label03">Address <span class="red_txt">*</span> :</div>
	<div class="field03">
		<input type="text" name="txt_address" id="txt_address" value="<?php echo $posted["txt_address"]; ?>" size="48"/>
	</div>
	<div class="clr"></div>
	<div class="label03">County <span class="red_txt">*</span> :</div>
	<div class="field03">
		 <select name="opt_state" id="opt_state" style="width:192px;" onchange='call_ajax_get_city("ajax_change_city_option",this.value,"parent_city");'>
				<option value="">Select county</option>
				<?php echo makeOptionState('',decrypt($posted["opt_province_id"])) ?>  
		 </select>
	</div>
	<div class="clr"></div>
	<div class="label03">City/Town <span class="red_txt">*</span> :</div>
	<div class="field03">
		 <div id="parent_city">   
			<select name="opt_city" id="opt_city" style="width:192px;" onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
				<option value="">Select city</option>

				 <?php echo makeOptionCity(' state_id="'.decrypt($posted["opt_province_id"]).'"',$posted["opt_city_id"]) ;?>
				</select>
		  </div>
	</div>
	<div class="clr"></div>
	<div class="label03">Postal Code <span class="red_txt">*</span> :</div>
	<div class="field03">
		<div id="parent_zip"> 
			<input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;" value="<?php echo $posted['s_zip'];?>"/>
			
			<?php /*?><select name="opt_zip" id="opt_zip" style="width:192px;">
				<option value="">Select postal code</option>
				<?php echo makeOptionZip(' city_id="'.decrypt($posted["opt_city_id"]).'"',decrypt($posted["i_zipcode_id"])); ?>                                     
			</select><?php */?>
			<input type="hidden" name="opt_zip" id="opt_zip" value="<?php echo $posted['i_zipcode_id'];?>"/>
			
		</div>
		 <div class="suggestionsBox" id="suggestionsSearch" style="display: none; overflow-x:hidden; position:absolute;">
								<div class="arrow_autocom"> &nbsp; </div>
								<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
		</div>
		<p>Type 3 characters to get postal code suggestion.</p>
	</div>
	<div class="clr"></div>
	<div class="title">
		<h5><span>Professional</span> Profile</h5>
	</div>
	<div class="clr"></div>
	<div class="label03">Business Name<span class="red_txt"> *</span> :</div>
	<div class="field03">
		<input name="txt_business_name" id="txt_business_name" value="<?php echo $posted['txt_business_name']; ?>" type="text" size="48" />
	</div>
	<div class="clr"></div>
	<div class="label03">Date of Birth <span class="red_txt">*</span> :</div>
	<div class="field02">
		 <input name="txt_dob" type="text" id="txt_dob" readonly="readonly" value="<?php echo $posted["txt_dob"]; ?>" size="48"/>
	</div>
	<div class="clr"></div>
	<div class="label03">Profile Photo :</div>   <!--<img src="<?php // echo base_url().'uploaded/user/thumb/thumb_'.$posted["s_user_image"]?>" alt="" width="100px" height="75px" />             -->
	<div class="field03">
		<div style="width:100px; height:100px;margin-bottom:10px;">  <?php echo showThumbImageDefault('user_profile',$posted["s_user_image"],100,100);?>
		<?php                                     
		echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted["s_user_image"].'" />';
		 ?></div>
		<input name="f_image" type="file" id="f_image" size="40" /> 
		 <br>
		 [upload file type only jpg,jpeg,png]      
	</div>
	<div class="clr"></div>
	<div class="label03">Website  :</div>
	<div class="field03">
		<input name="txt_website" id="txt_website" value="<?php echo $posted['txt_website']; ?>" type="text" size="48" />
	</div>
	<div class="clr"></div>
	<div class="label03">About me <span class="red_txt">*</span> :</div>
	<div class="field04">
		<textarea cols="60" rows="4" name="txt_about_me" id="txt_about_me"><?php echo $posted['txt_about_me'];?></textarea> 
	</div>
	<div class="clr"></div>
	<div class="label03">Category <span class="red_txt">*</span> :</div>
	<div class="field03">
   <?php 
		$cnt=1;
		foreach(empty($posted["opd_category"])?array(''):$posted["opd_category"] as $val)
		{ ?>
			<div id="category_div_<?php echo $cnt;?>" style="padding: 5px;"> 
			 <select name="opd_category[]" class="opd_category" style="width:358px;">
				<option value="">select category</option>
				<?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 ",$val) ?>
			</select>
			
			 <?php
                        if($cnt > 1) {?> 
                        <a href="javascript:void(0)"  id="closecat_<?php echo $cnt; ?>" onclick ="close_cat(this.id);"><img                         src="images/fe/close2.png" alt="" width="28" height="28" /></a>
                        <?php } ?>
			
			</div>
			 
	<?php $cnt++; } ?>
	<?php if($posted['cnt_opt_cat']<3)
		{   ?>
			<div><a href="javascript:void(0);" class="red_txt" id="red_link">Add another Category </a> </div>
		<?php 
		}  ?>

	</div>
	<div class="clr"></div>
	<div class="label03">Work History  :</div>
	<div class="field04">
		<textarea name="txt_work_history" id="txt_work_history" cols="60" rows="5"><?php echo $posted['txt_work_history']; ?></textarea>
	</div>
	<div class="clr"></div>
	<div class="label03">&nbsp;</div>
	<div class="field03">
		<input type="submit" value="Save" />
		<input type="reset" value="Cancel" />
	</div>
	<div class="clr"></div>
	</form>
</div>
				<!-- END OF FORMBOX-->
			</div>
			<div class="bot">&nbsp;</div>
		</div>
	</div>
   <?php include_once(APPPATH.'views/fe/common/tradesman_right_menu.tpl.php'); ?> 
</div>
            <div class="clr"></div>
        </div>         
        
        <div class="clr"></div>
</div>
</div>      
	