<?php

/*********

* Author: Koushik
* Date  : 19 Jul 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
* view For payment Report 

* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/report/
*/

?>

<script type="text/javascript" language="javascript" >

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {
$(document).ready(function(){

////////datePicker/////////

$("input[name^='txt_date_']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
                                               changeMonth:true

                                              }); 
                                              
$("input[name^='txt_check_']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
                                               changeMonth:true

                                              }); 
                                              
           
  $('.view_details').click(function(){
        //var tmp=JSON.parse('<?php echo makeArrayJs($headers[0]);?>');
       
        
        //var pop_w=(tmp["popup_width"]?"width="+tmp["popup_width"]:"");
        //var pop_h=(tmp["popup_height"]?"height="+tmp["popup_height"]:""); 
        
        var pop_w   =   "width=800";
        
        var pop_h   =   "height=400";
          $.prettyPhoto.open(g_controller+'property_details/'+'/iframe'
                           +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                            ,'<?php echo $caption;?>');
        
    })  ;
     $('.view_user').click(function(){
        //var tmp=JSON.parse('<?php echo makeArrayJs($headers[0]);?>');
       
        
        //var pop_w=(tmp["popup_width"]?"width="+tmp["popup_width"]:"");
        //var pop_h=(tmp["popup_height"]?"height="+tmp["popup_height"]:""); 
        
        var pop_w   =   "width=600";
        
        var pop_h   =   "height=400";
          $.prettyPhoto.open(g_controller+'user_details/'+'/iframe'
                           +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                            ,'<?php echo $caption;?>');
        
    })  ;
    
    
   
  


//////////Clicking the tabbed search/////

/*$("#tabbar ul li").each(function(i){

    $(this).click(function(){

        $("#btn_submit").attr("search",$(this).find("a").attr("id"));

    });    

});*/



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

function show_property_details(enc_id)
{
    jQuery(function($) { 
   
     var pop_w   =   "width=800";
      
     var pop_h   =   "height=400";
      $.prettyPhoto.open(base_url+'admin/manage_property/property_details/'+enc_id+'/iframe'
                       +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                        ,'<?php echo $caption;?>');
      });  
}

function show_user_details(enc_id)
{
    jQuery(function($) { 
 
         var pop_w   =   "width=700";        
         var pop_h   =   "height=400";
         $.prettyPhoto.open(base_url+'admin/user/user_details/'+enc_id+'/iframe'
                           +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                            ,'<?php echo $caption;?>'); 
    });
} 

function show_booking_details(enc_id)
{
    jQuery(function($) { 
   
     var pop_w   =   "width=400";
      
     var pop_h   =   "height=400";
      $.prettyPhoto.open(base_url+'admin/manage_booking/booking_details/'+enc_id+'/iframe'
                       +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                        ,'<?php echo $caption;?>');
      });  
}

/**
* First param booking id
* Status (pay to host, withdraw tax, withdraw commission)
* Current object (this) to remove the link
*/
function reportAction(enc_booking_id,status,cur_obj)
{
     jQuery(function($) {
        ////////Confirm///// 
       $("#dialog-confirm #dialog_msg").html('<strong>These booking status will be permanently changed and cannot be rechange.</strong> Are you sure?');       
       $("#dialog-confirm").dialog({
            resizable: false,
            height:240,
            width:350,
            modal: true,
            title: "Changing Confirmation?",
            buttons: {
                'Ok': function() {
                    $(this).dialog('close');
                    $.blockUI({ message: 'Just a moment please...' });
                    $.ajax({
                            type: "POST",
                            async: false,
                            url: base_url+'admin/report/ajax_report_status',
                            data: "booking_id="+enc_booking_id+"&status="+status,
                            success: function(msg){
                                if(msg='ok')
                                {
                                    $.unblockUI();
                                    if(status=='pay_to_host')
                                    {
                                        $(cur_obj).parent().html('Paid to host');
                                    }
                                    else if(status=='withdraw_tax')
                                    {
                                        $(cur_obj).parent().html('Tax withdrawn');
                                    }
                                    else if(status=='withdraw_commission')
                                    {
                                        $(cur_obj).parent().html('Commission withdrawn');
                                    }
                                      
                                }
                                
                            }
                            });
                    
                },
                'Cancel': function() {
                    
                    $(this).dialog('close');
                }
            }
        });

      });
    
} 

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
    <div class="info_box">From here Admin can view report .</div>
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
            <td width="15%">Booked by :</td>
            <td width="35%">
            <input id="txt_traveler_name" name="txt_traveler_name" value="<?php echo $txt_traveler_name;?>" type="text" size="28" />
            </td>
            <td width="12%">Traveler Email :</td>
            <td colspan="3">
            <input id="txt_traveler_email" name="txt_traveler_email" value="<?php echo $txt_traveler_email;?>" type="text" size="28"   />
            </td>
          </tr>
          
           <tr>
            <td width="15%">Owner name :</td>
            <td width="40%">
            <input id="txt_owner_name" name="txt_owner_name" value="<?php echo $txt_owner_name;?>" type="text" size="28" />
            </td>
            <td width="12%">Owner email :</td>
            <td colspan="3">
            <input id="txt_owner_email" name="txt_owner_email" value="<?php echo $txt_owner_email;?>" type="text" size="28"   />
            </td>
          </tr>
          
          <tr>
             <td >Booking ID :</td>
            <td >
            <input id="txt_booking_id" name="txt_booking_id" value="<?php echo $txt_booking_id;?>" type="text" size="28"   />
            </td>
            <td width="12%">Property ID :</td>
            <td colspan="3">
            <input id="txt_property_id" name="txt_property_id" value="<?php echo $txt_property_id;?>" type="text" size="28"   />
            </td>
          </tr>
          
          <tr>
            <td width="18%">Check in date :</td>
            <td width="23%">
            <input id="txt_check_in_date" name="txt_check_in_date" value="<?php echo $txt_check_in_date;?>" type="text" size="31" readonly="yes"/>
            </td>
            <td width="18%">Check out date :</td>
            <td colspan="3">
            <input id="txt_check_out_date" name="txt_check_out_date" value="<?php echo $txt_check_out_date;?>" type="text" size="31"  readonly="yes"/>
            </td>
          </tr>
          
          <tr>
            <td width="15%">Booking on date from :</td>
            <td width="23%">
            <input id="txt_date_from" name="txt_date_from" value="<?php echo $txt_date_from;?>" type="text" size="31" readonly="yes"/>
            </td>
            <td width="12%">Booking on date to :</td>
            <td colspan="3">
            <input id="txt_date_to" name="txt_date_to" value="<?php echo $txt_date_to;?>" type="text" size="31"  readonly="yes"/>
            </td>
          </tr>
          <tr>
            
            
            <td width="15%">Property name :</td>
            <td width="40%">
            <input id="txt_property_name" name="txt_property_name" value="<?php echo $txt_property_name;?>" type="text" size="28" />
            </td>
           
              <td >Tax withdrawn :</td>
            <td >
            <select name="opt_tax_withdraw" id="opt_tax_withdraw" >
                   <?php echo makeOptionNoEncrypt($arr_status,$opt_tax_withdraw); ?> 
            </select>
            </td>
          </tr>
          <tr>
           <td >Paid to host :</td>
            <td >
                <select name="opt_pay_host" id="opt_pay_host" >
                    <?php echo makeOptionNoEncrypt($arr_status,$opt_pay_host); ?>
                </select>
            </td>
           <td width="12%">Commission withdrawn :</td>
            <td  colspan="3">
            <select name="opt_commission_withdraw" id="opt_commission_withdraw" >
                     <?php echo makeOptionNoEncrypt($arr_status,$opt_commission_withdraw); ?> 
            </select>
            </td>

          </tr>
         


      </form>  

      </div>

      <form id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action;?>"><input type="hidden" id="h_search" name="h_search" value=""></form>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_button">

        <tr>

          <td width="250">

          <input id="btn_submit" name="btn_submit" type="button" value="Search" title="Click to search information." search="<?php echo ($h_search!="advanced"?1:2); ?>"/>&nbsp;<input id="btn_clear" name="btn_clear" type="reset" value="Clear" title="Clear all values within the fields." />&nbsp;<input id="btn_srchall" name="btn_srchall" type="submit" value="Show all" title="Show all information." />
          
          <span style="float: right"><strong>Total Booking :  </strong><?php echo $total_booking;?></span>
          </td>

         
        </tr>
        

      </table> 
      <table style="border: 1px solid #3B5998; width: 40%; float: right;">
      <tr>
      <th style="text-align: left;">&nbsp;</th>
      <th style="text-align: left;"><strong>GBP</strong></th>
      <th style="text-align: left;"><strong>USD</strong></th>
      <th style="text-align: left;"><strong>EURO</strong></th>
      </tr>
      <tr><td width="40%"><em>Total Amount Paid</em></em></td><td><?php echo round($total_amount_paid[3],2); ?></td><td><?php echo round($total_amount_paid[1],2); ?></td><td><?php echo round($total_amount_paid[2],2); ?></td></tr>
      <tr><td><em>Total Service Charge</em></td><td><?php echo round($total_amount_service_charge[3],2); ?></td><td><?php echo round($total_amount_service_charge[1],2); ?></td><td><?php echo round($total_amount_service_charge[2],2); ?></td></tr>
      <tr><td><em>Total Site Commission</em></td><td><?php echo round($total_amount_site_commission[3],2); ?></td><td><?php echo round($total_amount_site_commission[1],2); ?></td><td><?php echo round($total_amount_site_commission[2],2); ?></td></tr>
      <tr><td><em>Total Host Amount</em></td><td><?php echo round($total_amount_host[3],2); ?></td><td><?php echo round($total_amount_host[1],2); ?></td><td><?php echo round($total_amount_host[2],2); ?></td></tr>
      </table> 

    </div>

    </div>

    <?php

    echo $table_view;

    ?>

  </div>