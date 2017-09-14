<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 9 June 2011
* Modified By: 
* Modified Date:
* Purpose:
*  View For news List Showing
* @package Content Management
* @subpackage news
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/news/
*/

?>

<script type="text/javascript" language="javascript" >

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {
$(document).ready(function(){

$(".do_na").parent().html('NA');


////////datePicker/////////

$("input[name^='txt_created_']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
                                               changeMonth:true
                                              });   


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


function delete_quote(i_id)
{
jQuery.noConflict();///$ can be used by other prototype which is not jquery

    jQuery(function($) {
        
        $('#div_err').removeClass('error_massage success_massage');
       
        if(i_id)
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to delete the quote?'); 
        }
        else
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to reject the job?'); 
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
                            url: g_controller+'ajax_delete_quote',
                            data: "i_id="+i_id,
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


function read_quote(i_id)
{
jQuery.noConflict();///$ can be used by other prototype which is not jquery

    jQuery(function($) {
        
        $('#div_err').removeClass('error_massage success_massage');
       
        if(i_id)
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to marked as read the quote?'); 
        }
        else
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure not to marked as read the quote?'); 
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
                            url: g_controller+'ajax_read_quote',
                            data: "i_id="+i_id,
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
	<div class="info_box">From here admin can view the quotes placed by tradesmen for jobs .</div>
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

            <td width="15%">Job Title :</td>

            <td width="23%">

            <input id="txt_title" name="txt_title" value="<?php echo $txt_title;?>" type="text" size="28" />

            </td>

            <td width="15%">Comment:</td>

            <td width="23%">

            <input id="txt_comment" name="txt_comment" value="<?php echo $txt_comment;?>" type="text" size="28"  />

            </td>

          </tr>
		  <tr>

            <td width="15%">Quoted From :</td>

            <td width="23%">

            <input id="txt_created_from" name="txt_created_from" value="<?php echo $txt_created_from;?>" type="text" size="28" readonly="yes"/>

            </td>

            <td width="15%">To :</td>

            <td colspan="3">

            <input id="txt_created_to" name="txt_created_to" value="<?php echo $txt_created_to;?>" type="text" size="28"  readonly="yes"/>

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