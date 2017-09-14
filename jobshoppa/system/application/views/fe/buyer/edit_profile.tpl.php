<script>
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 


$("input[name='txt_dob']").datepicker({dateFormat: 'dd/mm/yy',
                                               changeYear: true,
											   yearRange: "-100:+0",
                                               changeMonth:true,
											    											
												beforeShow: function(input, inst) {$('#ui-datepicker-div div').show()}
                                              });//DOB    


$('#ui-datepicker-div').hide(); 



$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_edit_profile").submit();
	  
	   //check_duplicate();
   }); 
}); 


//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_username");
    //$this.next().remove("#err_msg");  
	//$(".star_err1").remove();
	//$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        //$.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {
                "h_duplicate_value":$this.val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      /*$('<div id="err_msg" class="star_err1">Duplicate exists.</div>')
                      .insertAfter("#txt_username"); */         
					  $("#div_err").html('<div class="error_massage"><strong>Username already exist.</strong></div>').show("slow");            
                  }
                  else
                  {
                     // $('<div id="err_msg" class="star_succ1">You can choose this year.</div>')
                    //  .insertAfter("#txt_milestones_year");     
                      $("#frm_edit_profile").submit();                 
                  }
                });
    }
    else
    {
         $("#frm_edit_profile").submit();  
    }
}


   
	
///////////Submitting the form/////////
$("#frm_edit_profile").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	
	var file_type = $("#f_image").val();
	var address = $.trim($("#txt_email").val());
   // $("#div_err").hide("slow");     
	
	if($.trim($("#txt_name").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide your full name.</strong></div>';
		b_valid=false;
	}
	if(address== '')
	{
		s_err +='<div class="error_massage"><strong>Please provide an email address.</strong></div>';
		b_valid=false;
	}
	else if(reg.test(address) == false) 
	{
		s_err +='<div class="error_massage"><strong>Please provide a valid email address.</strong></div>';
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
	if($.trim($("#txt_dob").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide your date of birth.</strong></div>';
		b_valid=false;
	}
	if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|jpeg|png)$/)))
	{
		s_err +='<div class="error_massage"><strong>Please select proper image file type.</strong></div>';
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
					   call_ajax_get_zipcode("ajax_change_zipcode_option",0,0,"parent_zip"); // to repopulate zip options

				   }   
				}
			});
	//});	
}

function call_ajax_get_zipcode(ajaxURL,item_id,state_id,cngDv)
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
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>My</span> Profile</h3>
            </div>
            <div class="clr"></div>
            <h6>&nbsp;</h6>
            <div class="clr"></div>
            <div id="account_container">
			<form name="frm_edit_profile" id="frm_edit_profile" method="post" action="<?php echo base_url().'buyer/edit_profile'?>" enctype="multipart/form-data">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:862px;">
                            <p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
                            <div id="form_box01">
                                <div class="label03">Name <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                     <input type="text"  name="txt_name" id="txt_name" value="<?php echo $posted['txt_name']; ?>"/>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Email <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text"  name="txt_email" id="txt_email"  value="<?php echo $posted['txt_email'] ?>"/>
                                </div>
                                <div class="clr"></div>
                               <!-- <div class="label03">Phone Number <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input type="text" value="01701 425316" size="48" />
                                </div>
                                <div class="clr"></div>-->
                                <div class="label03">Public Username <span class="red_txt">*</span> :</div>
                                <div class="field03">
									<label><?php echo $posted["txt_username"]; ?></label>
                                     <input type="hidden"  name="txt_username" id="txt_username"  value="<?php echo $posted['txt_username'] ?>"/>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Date of Birth <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input name="txt_dob" type="text" id="txt_dob" size="48" value="<?php echo $posted["txt_dob"] ?>" readonly=""/>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <ul class="photo3">
                                        <li>
                                                <?php echo showThumbImageDefault('user_profile',$posted['image'][0]['s_user_image'],100,90);?>	
										</li>
                                    </ul>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Profile Photo :</div>
                                <div class="field03">
									<?php                                     
                                    echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted['image'][0]['s_user_image'].'" />';
                                     ?>
                                    <input type="file" name="f_image" id="f_image"/>
                                     <br>
                                     [upload file type only jpg,jpeg,png]
                                </div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input name="chk_newletter" id="chk_newsletter" type="checkbox" value="1"  <?php 
                            if($posted['chk_newletter'])
                            {
                               echo "checked"; 
                            }
                            ?> />
                                    I would like to receive your Newsletter</div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input type="button" value="Submit"  name="btn_save" id="btn_save"/>
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