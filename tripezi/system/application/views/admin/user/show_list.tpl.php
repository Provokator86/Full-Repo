<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 05 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
* view For user List Showing
* 
* @package Users
* @subpackage Manage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/testimonial/
*/



?>

<script type="text/javascript" language="javascript" >

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {
$(document).ready(function(){
    
      // Open show detail page    
	
	$("a[id^='view_details_id_']").click(function(){
		var arr_arg,temp_id,user_id;
		temp_id = $(this).attr('id');
		arr_arg = temp_id.split('_');	
		user_id = arr_arg[3];
		
		 var pop_w   =   "width=700";        
         var pop_h   =   "height=400";
         $.prettyPhoto.open(g_controller+'user_details/'+user_id+'/iframe'
                           +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                            ,'<?php echo $caption;?>');
	
	});
	
		// verify phone number pop up	
	$("a[id^='verify_phone_id_']").click(function(){
			var arr_arg,temp_id;
			temp_id = $(this).attr('id');
			arr_arg = temp_id.split('_');
			 var i_status   = (arr_arg[4]=="verify")?1:0;
			 
			 $('#div_err').removeClass('error_massage success_massage');
			 
			////////Confirm///// 
			if(i_status)
			{
				$("#dialog-confirm #dialog_msg").html('Are you sure to verify phone number?'); 
			}
			else
			{
				$("#dialog-confirm #dialog_msg").html('Are you sure not to verify phone number?'); 
			}
				 
		   $("#dialog-confirm").dialog({
				resizable: false,
				height:240,
				width:350,
				modal: true,
				title: "Confirmation?",
				buttons: {
					'Yes': function() {
						$(this).dialog('close');
						 $.ajax({
								type: "POST",
								async: false,
								url: g_controller+'ajax_verify_phone',
								data: "i_status="+i_status+"&h_id="+arr_arg[3],
								success: function(msg){
								   if(msg=="ok") 
								   {			
								   	 if(i_status)
                                    	{    
                                        $("a[id='"+temp_id+"'] ").remove();
                                    	}						   
									 $('#div_err').addClass('success_massage').html('Phone number has verified successfully.').show(500).delay(1000).hide(500);    
								   }
								   else
								   {
									   $('#div_err').addClass('error_massage').html('Phone number verification failed to change.').show(500).delay(1000).hide(500);    
									   
								   }
	
								}
						   } ); 
					},
					'No': function(){
						 $(this).dialog('close');
						
					}
				}
		   });
		
	
		
		
		
	}); 
	
	/////////Admin verify phone number by ajax/////	

////////datePicker/////////

$("input[name^='txt_date_']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
                                               changeMonth:true

                                              });  



$("#tab_search").tabs({
   cache: true,
   collapsible: false,
   fx: { "height": 'toggle', "duration": 500 },

   show: function(clicked,show){ 
        $("#btn_submit").attr("search",$(show.tab).attr("id"));

        $("#tabbar ul li a").each(function(i){
           $(this).attr("class","");
        });

        $(show.tab).attr("class","select");

   }

});



$("#tab_search ul").each(function(i){
    $(this).removeClass("ui-widget-header");
    $("#tab_search").removeClass("ui-widget-content");

});


//////////end Clicking the tabbed search/////                                              

                                              

/////////Submitting the form//////                                              

$("#btn_submit").click(function(){
    $.blockUI({ message: 'Just a moment please...' });
    var formid=$(this).attr("search");
    $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
    $("#frm_search_"+formid).submit(); 

});                                              

/////////Submitting the form//////           



/////////clearing the form//////      

$("#btn_clear").click(function(){
    var formid=$("#btn_submit").attr("search"); 
    clear_form("#frm_search_"+formid);     

});                                        



function clear_form(formid)
{
    ///////Clearing input fields///

    $(formid).find("input")
    .each(function(m){        

        switch($(this).attr("type"))
        {
            case "text":
                $(this).attr("value",""); 
            break;

            case "password":
                $(this).attr("value",""); 
            break;            

            case "radio":
                 $(this).find(":checked").attr("checked",false);
            break;    

            case "checkbox":
                 $(this).find(":checked").attr("checked",false);
            break;                     

        }

    });

    ///////Clearing select fields///

    $(formid).find("select")

    .each(function(m){
        $(this).find("option:selected").attr("selected",false); 
    }); 

    ///////Clearing textarea fields///

    $(formid).find("textarea")
    .each(function(m){
        $(this).text(""); 
    });     

}

/////////clearing the form////// 



///////////Submitting the form2/////////

$("#frm_search_2").submit(function(){

    var b_valid=true;
    var s_err="";
    $("#frm_search_2 #div_err_2").hide("slow"); 

    /////////validating//////

    if(!b_valid)
    {
        $.unblockUI();  
        $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }

    return b_valid;

});    

///////////end Submitting the form2/////////



////////Submitting search all///

$("#btn_srchall").click(function(){
 $("#frm_search_3").submit();
});

////////end Submitting search all///                                 

})});   

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
    <div class="info_box">From here Admin can manage users .</div>
    <div class="clr"></div>

    <div id="tab_search">

    <div id="tabbar">

      <ul><?php //javascript:void(0)?>

        <?php /*?><li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li><?php */?>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Search</span></a></li>

      </ul>      

    </div>

    <div id="tabcontent">

     

      <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >

      <form id="frm_search_2" name="frm_search_2" method="post" action="" >

        <input type="hidden" id="h_search" name="h_search" value="advanced" />

        <div id="div_err_2"></div>        

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="15%">First Name :</td>

            <td width="23%">

            <input id="txt_first_name" name="txt_first_name" value="<?php echo $txt_first_name;?>" type="text" size="28" />

            </td>

            <td width="12%">Last Name:</td>

            <td >

            <input id="txt_last_name" name="txt_last_name" value="<?php echo $txt_last_name;?>" type="text" size="28" />

            </td>
            
            <td width="12%">Email:</td>

            <td >

            <input id="txt_email" name="txt_email" value="<?php echo $txt_email;?>" type="text" size="28"   />

            </td>

          </tr>
          <tr>

            <td width="25%">Registration Date From:</td>

            <td width="18%">

            <input id="txt_date_from" name="txt_date_from" value="<?php echo $txt_date_from;?>" type="text" size="31" readonly="yes"/>

            </td>

            <td width="12%">Date To :</td>

            <td colspan="3">

            <input id="txt_date_to" name="txt_date_to" value="<?php echo $txt_date_to;?>" type="text" size="31"  readonly="yes" />

            </td>

          </tr>


        </table>

      </form>  

      </div>

      <form id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action;?>"><input type="hidden" id="h_search" name="h_search" value=""></form>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_button">

        <tr>

          <td width="250">

          <input id="btn_submit" name="btn_submit" type="button" value="Search" title="Click to search information." search="<?php echo ($h_search!="advanced"?1:2); ?>"/>&nbsp;<input id="btn_clear" name="btn_clear" type="reset" value="Clear" title="Clear all values within the fields." />&nbsp;<input id="btn_srchall" name="btn_srchall" type="submit" value="Show all" title="Show all information." />

          </td>

         
        </tr>

      </table>  

    </div>

    </div>

    <?php

    echo $table_view;

    ?>

  </div>