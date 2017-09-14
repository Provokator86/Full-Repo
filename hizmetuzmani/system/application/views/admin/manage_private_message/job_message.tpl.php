<?php

/*********

* Author: Mrinmoy Mondal

* Date  : 22 Sept 2011

* Modified By: Koushik Rout

* Modified Date: 31 March 2012

* Purpose:

*  View For private message List Showing

* @package Content Management

* @subpackage user

* 

* @link InfController.php 

* @link My_Controller.php

* @link views/admin/private message/

*/



?>

<script type="text/javascript" language="javascript" >

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {

$(document).ready(function(){

$('input[id^="btn_del_"]').parent().remove();
/*$(':input[id^="dd_list"]').parent().remove();
$(':input[id^="chk_del_"]').parent().remove();
$(':input[id^="chk_all"]').parent().remove();*/

////////datePicker/////////

$("input[name='txt_created_on']").datepicker({dateFormat: 'yy-M-dd',

                                               changeYear: true,

                                               changeMonth:true

                                              });//DOB            



//////////Clicking the tabbed search/////

/*$("#tabbar ul li").each(function(i){

    $(this).click(function(){

        $("#btn_submit").attr("search",$(this).find("a").attr("id"));

    });    

});*/



$("#tab_search").tabs({

   cache: true,

   collapsible: true,

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

                                    

///////////Submitting the form1/////////

/*$("#frm_search_1").submit(function(){

    var b_valid=true;

    var s_err="";

    $("#frm_search_1 #div_err_1").hide("slow"); 



    if($.trim($("#frm_search_1 #txt_email").val())=="") 

    {

        s_err +='Please Provide Email Id.<br />';

        b_valid=false;

    }

    

    /////////validating//////

    if(!b_valid)

    {

        $.unblockUI();  

        $("#frm_search_1 #div_err_1").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");

    }

    

    return b_valid;

});   */ 

///////////end Submitting the form1/////////

///////////Submitting the form2/////////

$("#frm_search_2").submit(function(){

    var b_valid=true;

    var s_err="";

    $("#frm_search_2 #div_err_2").hide("slow"); 



/*    if($.trim($("#frm_search_2 #s_title").val())=="") 
    {
        s_err +='Please Provide Message Like.<br />';
        b_valid=false;
    }
  */
    

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

function jobAcceptReject(i_id,s_status)
{
    jQuery.noConflict();///$ can be used by other prototype which is not jquery

    jQuery(function($) {
        $('#div_err').removeClass('error_massage success_massage');
        var i_status   = (s_status=="approve")?1:2;
        if(i_status==1)
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to aapprove the message?'); 
        }
        else
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to reject the message?'); 
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
                            url: g_controller+'ajax_approve_reject',
                            data: "i_status="+i_status+"&i_id="+i_id,
                            success: function(msg){
                                if(msg=='ok')
                                {
                                   window.location.reload();
                                }
                                else if(msg=='error')
                                {
                                     $('#div_err').addClass('error_massage').html('Status has failed to change.').show(500).delay(1000).hide(500);    
                                }
                            }
                      });
                     
                },
                'No': function() {
                     $(this).dialog('close');
                    
                }
            }
        });
    });
    
}
</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can view all the messages for each job.</div>
	<div class="clr"></div>

    <div >

    

    <div id="tabcontent">

      <?php /*?><div id="div1" <?php //echo ($h_search=="basic"?"":'style="display: none;"') ?> >

      <form id="frm_search_1" name="frm_search_1" method="post" action="">

        <input type="hidden" id="h_search" name="h_search" value="basic" />

        <div id="div_err_1"></div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="15%">News Title *:</td>

            <td width="23%">

            <input id="txt_news_title" name="txt_news_title" value="<?php echo $txt_news_title;?>" type="text" size="28" />

            </td>

            <td width="5%">&nbsp;</td>

            <td width="23%">&nbsp;</td>

            <td width="10%">&nbsp;</td>

            <td width="24%">&nbsp;</td>

          </tr>

          <tr>

            <td>&nbsp;</td>

            <td>&nbsp;</td>

            <td>&nbsp;</td>

            <td>&nbsp;</td>

            <td>&nbsp;</td>

            <td>&nbsp;</td>

          </tr>

        </table>

      </form>  

      </div><?php */?>

      <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >

      <form id="frm_search_2" name="frm_search_2" method="post" action="" >

        <input type="hidden" id="h_search" name="h_search" value="advanced" />

        <div id="div_err_2"></div>        

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="15%">Job Title:</td>

            <td width="23%">

           <a title="View" href="<?php echo admin_base_url().'job_overview/index/'.encrypt($job_info["i_job_id"])?>"><?php echo $job_info['s_job_title'];?>

            </td>

            <td width="12%">Buyer:</td>

            <td colspan="3">
			<a alt='Click here to view profile' href='<?php echo admin_base_url().'buyers_profile/index/'.encrypt($job_info["i_buyer_id"])?>' target='_blank'>
           <?php echo $job_info['s_sender_user'];?>
			</a>	
            </td>

 		<td width="12%">Tradesman:</td>

            <td colspan="3">
			<a alt='Click here to view profile' href='<?php echo admin_base_url().'tradesman_profile_view/index/'.encrypt($job_info["i_tradesman_id"])?>' target='_blank'>
           <?php echo $job_info['s_receiver_user'];?>
			</a>	
            </td>
          </tr>

          


        </table>

      </form>  

      </div>

 

        

    </div>

    </div>

    <?php

    echo $table_view;

    ?>

  </div>