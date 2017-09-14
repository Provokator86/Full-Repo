  <script type="text/javascript">
  var max_allow_open = 3;
  var cnt = parseInt(<?php echo ($posted['cnt_opt_cat'])?$posted['cnt_opt_cat']:1 ?>);
          
          ///////////////////// Tooltips if a anchor tag has  class tools ////////////    
function simple_tooltip(target_items, name){
 $(target_items).each(function(i){
        $("body").append("<div class='"+name+"' id='"+name+i+"' style="+"display:none;"+"><p>"+$(this).attr('title')+"</p></div>");
        var my_tooltip = $("#"+name+i);

        $(this).removeAttr("title").mouseover(function(){
                my_tooltip.css({opacity:0.8, display:"none"}).fadeIn(400);
        }).mousemove(function(kmouse){
                my_tooltip.css({left:kmouse.pageX+15, top:kmouse.pageY+15});
        }).mouseout(function(){
                my_tooltip.fadeOut(400);
        });
    });
}
          
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){      
$("input[name='txt_dob']").datepicker({dateFormat: 'dd/mm/yy',
                                               changeYear: true,
											   yearRange: "-100:+0",
                                               changeMonth:true,
											
												beforeShow: function(input, inst) {$('#ui-datepicker-div div').show()}
                                              });//DOB    


$('#ui-datepicker-div').hide();
 simple_tooltip("a.tools","tooltip"); 
 
 
 $(".lightbox1_main").fancybox({
	'titlePosition'		: 'inside',
	'transitionIn'		: 'none',
	'transitionOut'		: 'none',
	'showCloseButton'	: true
});
/*$("input[name='txt_dob']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
											   yearRange: "-100:+0",
                                               changeMonth:true
                                              });//DOB    */



                                       
                                              
/*** generate category dropdown ***/

        /*$("#red_link").click(function(){
            var str = '';        
            str += '<div class="clr"></div>'+'<select style="width:300px;margin-top:5px;" name="opd_category'+cnt+'" id="opd_category'+cnt+'"><option value="">select category</option>'+"<?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 ",""); ?>"+'</select>'+
            '<a href="#" title="Help" class="tools"><img src="images/fe/icon-04.png" alt="" /></a> ';
            $("#parent_category").append(str);

            //$("#opd_category"+cnt).msDropDown();
            //$("#opd_category"+cnt).hide();            
            
            cnt++;
            if(cnt>=max_allow_open)
            {
                $("#red_link").remove();
            }
        });  */
    /*** end generate category ***/
    
    $("#red_link").click(function(){
                 
			var str = '<a href="javascript:void(0)" id="closecat_'+(cnt+1)+'" onclick="close_cat(this.id);"><img src="images/fe/close2.png" alt="" width="28" height="28" /></a>';
            var sel_cat=$("#category_div_"+1).html();
			

            $("#category_div_"+cnt).after('<div id="category_div_'+(cnt+1)+'"></div>');
            
            $("#category_div_"+(cnt+1)).append(sel_cat);
            $("#category_div_"+(cnt+1)+" select").val('');
             $("#category_div_"+(cnt+1)).append(str); 
            $("#category_div_"+(cnt+1)+" a[id^=closecat_]").attr('id','closecat_'+(cnt+1));
            //$("#opd_category"+cnt).msDropDown();
			
            //$("#opd_category"+cnt).hide();            
            
            cnt++;
            if(cnt>=max_allow_open)
            {
                $("#red_link").hide();
				//cnt = 1;
            }
			
        });
        
       
		
		
/* close the category dropdown */

		
    
///////////Submitting the form/////////
$("#form_treadsman_reg").submit(function(){    
    var b_valid=true;
    var s_err="";
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    
   // var reg_contact = /^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$/;   
    //var reg_contact = /^(\+44\s7\d{3}|\(?07\d{3}\)?)\s\d{3}\s\d{3}$/;
	var reg_contact = /^(\+447\d{9})|(07\d{9})$/;
    //var tel_number  = /^0(\d{3}\s\d{7}|\d{2}\s\d{4}\s\d{4})/ ; 
    var tel_number = /^0(\d){10}$/;
     
    var file_type = $("#f_image").val();
    var address = $.trim($("#txt_email").val());
    var con_address    =    $.trim($("#txt_con_email").val());
   // $("#div_err").hide("slow");     
    var pass    =    $.trim($("#txt_password").val());
    var con_pass    =    $.trim($("#txt_con_password").val());
    
    //alert($.trim($("#txt_name").val()));
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
    /*confirm email validation*/
    if(con_address== '')
    {
        s_err +='<div class="error_massage"><strong>Please confirm email.</strong></div>';
        b_valid=false;
    }
    else if(reg.test(con_address) == false) 
    {
        s_err +='<div class="error_massage"><strong>Please provide a valid email address.</strong></div>';
        b_valid=false;
    }
    else if(con_address != address)
    {
        s_err +='<div class="error_massage"><strong>Emails do not match.</strong></div>';
        b_valid=false;
    }
    /*confirm email validation*/
    else
    {
        //var txt_username =     $.trim($("#txt_username").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'user/check_email_exist',
                data: "s_email="+address,
                success: function(msg){
                   if(msg=='error')
                   {
                        s_err +='<div class="error_massage"><strong>Email address already exists.</strong></div>';
                        b_valid=false;                        
                   } 
                   
                }
            });    
    }
    
    if($.trim($("#txt_username").val())== '')
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
            
        }
    
    if(pass== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide a password.</strong></div>';
        b_valid=false;
    }
    else if(pass!='' && pass.length<6)
    {
        s_err +='<div class="error_massage"><strong>Please provide a password. Password should be at least 6 characters.</strong></div>';
        b_valid=false;
    }
    
    if(con_pass== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide a confirm password.</strong></div>';
        b_valid=false;
    }
    else if(pass != con_pass)
    {
        s_err +='<div class="error_massage"><strong>Please confirm password Passwords must match.</strong></div>';
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
        s_err +='<div class="error_massage"><strong>Landline number should be 11 digits.</strong></div>';
        b_valid=false;
        
    }
    if($.trim($("#txt_fax").val())!='' && tel_number.test($.trim($("#txt_fax").val())) == false)
    {
        s_err +='<div class="error_massage"><strong>Fax number should be 11 digits.</strong></div>';
        b_valid=false;
        
    }
    if($.trim($("#txt_address").val())== '')
    {
        s_err +='<div class="error_massage"><strong>Please provide an address.</strong></div>';
        b_valid=false;
    }    
    
    if($.trim($("#opt_state").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select a county.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#opt_city").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select a City/Town.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#opt_zip").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select your post code.</strong></div>';
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
    if($.trim($("#txt_about_me").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please fill in the about you and your business section.</strong></div>'; 
        b_valid=false;
    }
    if($.trim($("#txt_skills").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please add your skills.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#txt_qualification").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please add your qualifications.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#txt_business_name").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please add your Business name.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#f_image").val())!="" && (!file_type.match(/(?:jpg|jpeg|png)$/)))
    {
        s_err +='<div class="error_massage"><strong>Please select the correct image format. Format incorrect.</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#radius1").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select a particular radius.</strong></div>'; 
        b_valid=false;
    }
    if($.trim($("select.opd_category").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select a Category.</strong></div>';
        b_valid=false;
    }  
	
	
	/* new validation for payment type checkboxes 15-03-2012*/
	var fields = $("input[name='RadioGroup1[]']").serializeArray();  
    if (fields.length == 0) 
	  { 
		s_err +='<div class="error_massage"><strong>Please select which form of payment you prefer.</strong></div>';
        b_valid=false;
	  } 
    /* new validation for payment type checkboxes 15-03-2012*/
	
   
     if($.trim($("#recaptcha_response_field").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please confirm the security code.</strong></div>';
        b_valid=false;
    }   
    if($.trim($("#recaptcha_response_field").val())!="")
    {    
        var recaptcha_response_field =     $.trim($("#recaptcha_response_field").val());    
        var recaptcha_challenge_field=     $.trim($("#recaptcha_challenge_field").val());    
        $.ajax({
                type: "POST",
                async: false,
                url: base_url+'user/check_recapcha',
                data: "recaptcha_response_field="+recaptcha_response_field+'&recaptcha_challenge_field='+recaptcha_challenge_field,
                success: function(msg){
                   if(msg=='error')
                   {
                        s_err +='<div class="error_massage"><strong>Please provide the correct security code.</strong></div>';
                        b_valid=false;
                        //Recaptcha.reload();
                   } 
                   
                }
            });                
    }
    
    if(!$("input[name=i_accept_terms]:checkbox").is(":checkbox:checked"))
    {
        s_err +='<div class="error_massage"><strong>Please accept our terms and conditions.</strong></div>';
        b_valid=false;
    }    
    /////////validating//////
     if(!b_valid)
    {
       // $.unblockUI();  
	   Recaptcha.reload();
        $("#div_err").html(s_err).show("slow");
    }   

     return b_valid;
}); 


///////////end Submitting the form///////// 
    /*$('#btn_reg').click(function(){
        $("#form_buyer_reg").submit();
    }); */

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
                   }   
                }
            });
    //});    
}

/* function call_ajax_get_zipcode(ajaxURL,item_id,state_id,cngDv)
{
    //jQuery.noConflict();///$ can be used by other prototype which is not jquery
    //jQuery(function($) {
    //alert(decrypt(state_id));
          
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

<script type="text/javascript">
    var RecaptchaOptions = {
        theme : 'custom'
    };	
	
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
                <h3><span>Welcome to Jobshoppa,</span> please Signup</h3>
            </div>
            <div class="clr"></div>
            <div id="registration_box">
				<h4>Registration is totally <span style="color:#00B0CD;">FREE</span> and wont take more than a minute</h4>
                <p style="text-align:right;"><span class="red_txt">*</span> Required field</p>
				<?php
				if($chk_subscrption_status!=1)
				{
				?>
                <p class="big_txt15">Registration is <span style="color:#f68e29;">FREE</span></p>
				<?php } ?>
                <p>&nbsp;</p>
                <form name="form_treadsman_reg" id="form_treadsman_reg" action="<?php echo base_url().'user/registration/TWlOaFkzVT0'?>" method="post" enctype="multipart/form-data">
                <div class="label01">Full Name <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_name" id="txt_name" type="text" size="48" value="<?php echo $posted["txt_name"] ?>"/>
                </div>
                <div class="clr"></div>
                <div class="label01">Email Address <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_email" id="txt_email" type="text" size="48"  value="<?php echo $posted["txt_email"] ?>"/>
                </div>
                <div class="clr"></div>
                <div class="label01">Confirm Email Address <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_con_email" id="txt_con_email" type="text" size="48" value="<?php echo $posted["txt_con_email"] ?>"/>
                </div>
                <div class="clr"></div>
                <div class="title04" style="margin:20px 0;">
                    <h5><span>Login </span> Details</h5>
                </div>
                <div class="clr"></div>
                <div class="label01">Public Username <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_username" id="txt_username" type="text" size="48" value="<?php echo $posted["txt_username"] ?>" />
                </div>
                <div class="clr"></div>
                <div class="label01">Password <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_password" id="txt_password" type="password" size="48" value="<?php echo $posted["txt_password"] ?>"/> <a href="javascript:void(0);" title="Include at least 6 characters, don&acute;t user your name or email address, use a mix of upper and lower case letters, symbols and numbers. Make your password hard to guess. ." class="tools" ><img src="images/fe/icon-04.png" alt="Help" title="" /></a>
                </div>
                <div class="clr"></div>
                <div class="label01">Confirm Password <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_con_password" id="txt_con_password" type="password" size="48" value="<?php echo $posted["txt_con_password"] ?>" />
                </div>
                <div class="clr"></div>
                <div class="title04" style="margin:20px 0;">
                    <h5><span>Contact </span> Details</h5>
                </div>
                <div class="clr"></div>
                <div class="label01">Mobile Number <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_contact" id="txt_contact" type="text" size="48" value="<?php echo $posted["txt_contact"] ?>" /> <a href="javascript:void(0);" title="We will not share your contact details to anyone, other than the professional you select for carrying out the job." class="tools"><img src="images/fe/icon-04.png" alt="Help" title="" /></a>
                    
                </div>
                <div class="clr"></div>
                <div class="label01">Fax Number :</div>
                <div class="field01">
                    <input name="txt_fax" id="txt_fax" type="text" size="48" value="<?php echo $posted["txt_fax"] ?>"/>
                    <br/> Formats : 01234567890   
                </div>
                <div class="clr"></div>
                <div class="label01">Landline Number :</div>
                <div class="field01">
                    <input name="txt_landline" id="txt_landline" type="text" size="48" value="<?php echo $posted["txt_landline"] ?>" />
                    <br/> Formats : 01234567890  
                </div>
                <div class="clr"></div>
                <div class="label01">Skype IM :</div>
                <div class="field01">
                   <input name="txt_skype" id="txt_skype" type="text" size="48" value="<?php echo $posted["txt_skype"] ?>" />
                </div>
                <div class="clr"></div>
                <div class="label01">MSN IM :</div>
                <div class="field01">
                    <input name="txt_msn" id="txt_msn" type="text" size="48" value="<?php echo $posted["txt_msn"] ?> "/>
                </div>
                <div class="clr"></div>
                <div class="label01">YAHOO IM :</div>
                <div class="field01">
                    <input name="txt_yahoo" id="txt_yahoo" type="text" size="48" value="<?php echo $posted["txt_yahoo"] ?>"/>
                </div>
                <div class="clr"></div>
                <div class="label01">Facebook  Profile :</div>
                <div class="field01">
                    <input name="txt_facebook" id="txt_facebook" value="<?php echo $posted["txt_facebook"] ?>" type="text" size="48" /> 
                </div>
                <div class="clr"></div>
                <div class="title04" style="margin:20px 0;">
                    <h5><span>Address</span></h5>
                </div>
                <div class="clr"></div>
                <div class="label01">Address <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input type="text" name="txt_address" id="txt_address" value="<?php echo $posted["txt_address"] ?>" size="48"/>
                </div>
                <div class="clr"></div>
                  <div class="clr"></div>
                <div class="label01">County <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <select style="width:192px;" name="opt_state" id="opt_state" onchange='call_ajax_get_city("ajax_change_city_option_auto_complete",this.value,"parent_city");'>
                        <option value="">Select county</option>
                        <?php echo makeOptionState('',decrypt($posted['opt_state'])) ?>  
                    </select>
                </div>
                <div class="clr"></div>
                <div class="label01">City/Town <span class="red_txt">*</span> :</div>
                <div class="field01">
                <div id="parent_city">   
                    <select style="width:192px;" name="opt_city" id="opt_city" onchange='call_ajax_get_zipcode_list("ajax_change_zipcode_option_auto_complete",this.value,opt_state.value,"parent_zip");'>
                        <option value="">Select city</option>
                        <?php echo makeOptionCity(' state_id="'.decrypt($posted['opt_state']).'"',$posted['opt_city']) ?>
                    </select>
                </div>
                </div>
                <div class="clr"></div>
                <div class="label01">Post Code <span class="red_txt">*</span> :</div>
                <div class="field01">
                 <div id="parent_zip"> 
                    <input type="text"  name="txt_zip" id="txt_zip" onkeyup="get_zipcode_name(this.value)" autocomplete="off" style="width:180px;"/>
					
                   <?php /*?> <select name="opt_zip" id="opt_zip">
                        <option value="">Select postal code</option>
                        <?php echo makeOptionZip(' city_id="'.decrypt($posted['opt_city']).'"',decrypt($posted['opt_zip'])) ?>                                     
                    </select><?php */?>
					
					<input type="hidden" name="opt_zip" id="opt_zip" />
                  </div>
				  <div class="suggestionsBox" id="suggestionsSearch" style="display: none; overflow-x:hidden; position:absolute;">
								<div class="arrow_autocom"> &nbsp; </div>
								<div class="suggestionList" id="autoSuggestionsListSearch" style="height:130px; overflow:auto;"> &nbsp; </div>
			  
                              
                              
                              					  		
                    </div>
					<p>Type 3 characters to get postal code suggestion.</p>
                </div>
				
                <div class="clr"></div>
                <div class="title04" style="margin:20px 0;">
                    <h5><span>Professional</span> Profile</h5>
                </div>
                <div class="clr"></div>
                <div class="label01">Date of Birth <span class="red_txt">*</span> :</div>
                <div class="field01">
                      <input name="txt_dob" type="text" id="txt_dob" readonly="readonly" size="48" value="<?php echo $posted['txt_dob']; ?>"/>  <a href="javascript:void(0);" title="As per our terms and conditions, any individuals under the age of 18 are not allowed to use this site." class="tools"><img src="images/fe/icon-04.png" alt="Help" title="" /></a>
					 
                </div>
                <div class="clr"></div>
                <div class="label01">Profile Photo  :</div>
                <div class="field01">
                    <input name="f_image" type="file" id="f_image" size="40" /> <br>
                    <br>
                    [upload file type only jpg,jpeg,png] 
                </div>
                <div class="clr"></div>
                <div class="label01">Website   :</div>
                <div class="field01">
                    <input name="txt_website" id="txt_website" value="<?php echo $posted["txt_website"] ?>" type="text" size="48" /> 
                </div>
                <div class="clr"></div>
                <div class="label01">Tell us more about you and your Business<span class="red_txt">*</span> :</div>
                <div class="field01">
                    <textarea cols="" rows="4" name="txt_about_me" id="txt_about_me"><?php echo $posted["txt_about_me"] ?></textarea> 
                    <a href="javascript:void(0);" title="Quality information about you will really make your profile attractive, please ensure you fill this section properly." class="tools"><img src="images/fe/icon-04.png" alt="Help" title="" /></a>
                </div> 
                <div class="clr"></div>
                <div class="label01">Skills <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <input name="txt_skills" id="txt_skills" value="<?php echo $posted["txt_skills"] ?>" type="text" size="48" /> 
                    <a href="javascript:void(0);" title="This is one of the very crucial parts of your profile, potential clients will never overlook this section, please make sure you add all the relevant skills you have pertaining to you work. For example; if you are a personal trainer, the skills section will include things like; Nutrition, Weight Loss, Fitness, Gym" class="tools"><img src="images/fe/icon-04.png" alt="Help" title=""/></a>
                </div>
                <div class="clr"></div>
                <div class="label01">Qualification <span class="red_txt">*</span> :</div>
                <div class="field01">
                    <textarea cols="" rows="4" name="txt_qualification" id="txt_qualification"><?php echo $posted["txt_qualification"] ?></textarea> 
                    <a href="javascript:void(0);" title="You may have no formal qualifications, but have tonnes of experience in your field, make sure you have this information available for your clients in this section." class="tools"><img src="images/fe/icon-04.png" alt="Help" title=""/></a>
                </div>
                <div class="clr"></div>
                <div class="label01">Business Name<span class="red_txt"> *</span> :</div>
                <div class="field01">
                    <input name="txt_business_name" id="txt_business_name" value="<?php echo $posted["txt_business_name"] ?>" type="text" size="48" /> 
                    <a href="javascript:void(0);" title="If you are Limited Company, you could put the name of your Company, but if you are self employed or a sole proprietor, use your trading name." class="tools"><img src="images/fe/icon-04.png" alt="Help" title=""/></a>
                </div>
                <div class="clr"></div>
                <div class="label01">Category <span class="red_txt">*</span> :</div>
                <div class="field01">
                <?php 
                $cnt=1;
				
                foreach(empty($posted["opd_category"])?array(''):$posted["opd_category"] as $val)
                { ?>
                    <div id="category_div_<?php echo $cnt;?>"> 
                     <select name="opd_category[]" class="opd_category">
                        <option value="">select category</option>
                        <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 ",$val) ?>
                    </select>
                   			
                        <?php
                        if($cnt > 1) {?> 
				        <a href="javascript:void(0)"  id="closecat_<?php echo $cnt; ?>" onclick ="close_cat(this.id);"><img src="images/fe/close2.png" alt="" width="28" height="28" /></a>
                        <?php } ?>
						<img src="images/fe/icon-04.png" height="36px" width="2px" alt="" style="visibility:hidden;"/> 
                    </div>
                    <?php $cnt++; } ?>
                    <?php if($posted['cnt_opt_cat']<3)
                    {   ?>
                        <div><a href="javascript:void(0);" class="red_txt" id="red_link">Add another Category </a> </div>
                    <?php 
                    }  ?>
                    
                              <!--<a href="javascript:void(0)"><img src="images/fe/close2.png" alt="" width="28" height="28" /></a>--> 
                </div> 
                 
                <div class="clr"></div> 
                <div class="label01">Which form of payment do you prefer? <span class="red_txt">*</span> :</div>
                <div class="field03">
                    <!-- <input type="radio" name="RadioGroup1" value="1" id="RadioGroup1_0" <?php echo (!empty($posted['RadioGroup1']) && $posted['RadioGroup1']==1 ? 'checked="checked"' : '')?> />
                    Credit card
                    <input type="radio" name="RadioGroup1" value="2" id="RadioGroup1_1" <?php echo (!empty($posted['RadioGroup1']) && $posted['RadioGroup1']==2 ? 'checked="checked"' : '')?> />
                    Cheque
                    <input type="radio" name="RadioGroup1" value="0" id="RadioGroup1_2" <?php echo (empty($posted['RadioGroup1']) ? 'checked="checked"' : '')?> />
                    Cash -->
					 <input type="checkbox" name="RadioGroup1[]" value="1" id="RadioGroup1_0" <?php echo (!empty($posted['RadioGroup1']) && $posted['RadioGroup1']==1 ? 'checked="checked"' : '')?> />
                    Credit Cards
                    <input type="checkbox" name="RadioGroup1[]" value="2" id="RadioGroup1_1" <?php echo (!empty($posted['RadioGroup1']) && $posted['RadioGroup1']==2 ? 'checked="checked"' : '')?> />
                    Cheques
                    <input type="checkbox" name="RadioGroup1[]" value="3" id="RadioGroup1_2" <?php echo (empty($posted['RadioGroup1']) ? 'checked="checked"' : '')?> />
                    Cash 
				</div>
                <div class="clr"></div>
                <div class="label01">VAT Number :</div>
                <div class="field01"><input name="txt_vatno" id="txt_vatno" value="<?php echo $posted["txt_vatno"] ?>" type="text" size="48" /> <a href="javascript:void(0);" title="Only fill this if you are VAT Registered." class="tools"><img src="images/fe/icon-04.png" alt="Help" title=""/></a></div>
                <div class="clr"></div>
                <div class="label01">Can you do the job over the phone or internet? :</div>
                <div class="field03">
                    <input name="RadioGroup2" id="RadioGroup2_0" type="radio" value="1" <?php echo (!empty($posted['RadioGroup2']) && $posted['RadioGroup2']==1 ? 'checked="checked"' : '')?> />
                    Yes
                    <input name="RadioGroup2" id="RadioGroup2_1" type="radio" value="0" <?php echo (empty($posted['RadioGroup2']) ? 'checked="checked"' : '')?> />
                    No </div>
                <div class="clr"></div>
                <div class="label01">Can you travel to your client?<span class="red_txt"> *</span> :</div>
                <div class="field03">
                     <input name="RadioGroup3" id="RadioGroup3_0" type="radio" value="1" <?php echo (!empty($posted['RadioGroup3']) && $posted['RadioGroup3']==1 ? 'checked="checked"' : '')?> />
                    Yes
                    <input name="RadioGroup3" id="RadioGroup3_1" type="radio" value="0" <?php echo (empty($posted['RadioGroup3']) ? 'checked="checked"' : '')?> />
                    No </div>
                <div class="clr"></div>
                <div class="label01">Radius <span class="red_txt">*</span> :</div>
                <div class="field01">
                       <select name="radius1" id="radius1">
						  <!--<option>5</option>
						  <option>10</option>
						  <option>15</option>-->
						    <option value="">Select</option>
							<?php echo makeOptionRadiusOption('', encrypt($posted['radius1']))?> 
                        </select>
                    <a href="javascript:void(0);"  title="By choosing an appropriate distance, our algorithm will provide you leads in connection with how far you are willing to travel." class="tools"><img src="images/fe/icon-04.png" alt="" title=""/></a>
                </div>
                <div class="clr"></div>
                <div class="label01">Word Verification <span class="red_txt">*</span> :</div>
                <div class="field01">Type the characters you see in the picture below.</div>
                <div class="clr"></div>
                <div class="label01">&nbsp;</div>
               <div class="field01">
                <div id="recaptcha_container">
                                        
                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="text" />
                    <div id="recaptcha_image" style="margin-top:5px; margin-bottom:5px; border:1px solid #D1D1D1;"></div>
                    <!--<p>Choose captcha format: <a href="javascript:Recaptcha.switch_type('image');">Image</a> or <a href="javascript:Recaptcha.switch_type('audio');">Audio</a> </p>-->
                    <input type="button" id="recaptcha_reload_btn" value="Get new words" onclick="Recaptcha.reload();" />
                </div>
                </div>
                <script type="text/javascript" src="http://api.recaptcha.net/challenge?k=6LfC88gSAAAAAO2J7lo91pEgVje83SWy29brEsml">
                </script>
                <div class="clr"></div>
                <div class="field03">
                    <input name="i_inform_news" type="checkbox" value="1" <?php echo (!empty($posted["i_inform_news"]) && $posted["i_inform_news"]==1) ?'checked="checked"' : '';?> />
                    I would like to Receive updates, news and tips from Jobshoppa.</div>
                <div class="clr"></div>
                <div class="field03">
				<!--TmlOaFkzVT0= TlNOaFkzVT0=-->
                    <input name="i_accept_terms" id="i_accept_terms" type="checkbox" value="1" <?php echo (!empty($posted["i_accept_terms"]) && $posted["i_accept_terms"]==1) ?'checked="checked"' : '';?>/>
                    Accept <a href="<?php echo base_url().'user/show_cms_lightbox/TmlOaFkzVT0='?>" class="lightbox1_main">Terms & Conditions</a> and <a href="<?php echo base_url().'user/show_cms_lightbox/TlNOaFkzVT0='?>" class="lightbox1_main">Privacy Policy</a>.<span class="red_txt"> *</span></div>
                <div class="clr"></div>
                <div class="label01">&nbsp;</div>
                <div class="field01">
                    <input name="submit" type="submit" value="Register" />
                </div>
                </form>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
</div>
