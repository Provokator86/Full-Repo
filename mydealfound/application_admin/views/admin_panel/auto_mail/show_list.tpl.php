<?php

/*********

* Author: Mrinmmoy Mondal

* Date  : 10 Jan 2012

* Modified By: 

* Modified Date: 

* 

* Purpose:

*  View For automail List Showing

* 

* @package Content Management

* @subpackage automail

* 

* @link InfController.php 

* @link My_Controller.php

* @link views/admin/automail/

*/



?>

<script type="text/javascript" language="javascript" >

//jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {

$(document).ready(function(){

// to remove insert button
$('input[id^="btn_add_"]').remove();
// to remove delete button
$('input[id^="btn_del_"]').remove();
$(':input[id^="dd_list"]').remove();
$(':input[id^="chk_del_"]').remove();
$(':input[id^="chk_all"]').remove();

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
    $("#btn_srchall").click();   

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

   /* if($.trim($("#frm_search_2 #txt_subject").val())=="") 
    {
        s_err +='Please provide automail subject.<br />';
        b_valid=false;
    }  */ 

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
	<div class="info_box">From here Admin can edit the contents of the automails to be sent.</div>
	<div class="clr"></div>

    <div id="tab_search">

    <div id="tabbar">

      <ul><?php //javascript:void(0)?>

        <?php /*?><li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li><?php */?>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Search</span></a></li>

      </ul>      

    </div>

    <div id="tabcontent">

      <?php /*?><div id="div1" <?php //echo ($h_search=="basic"?"":'style="display: none;"') ?> >

      <form id="frm_search_1" name="frm_search_1" method="post" action="">

        <input type="hidden" id="h_search" name="h_search" value="basic" />

        <div id="div_err_1"></div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="15%">Subject *:</td>

            <td width="23%">

            <input id="txt_subject" name="txt_subject" value="<?php echo $txt_subject;?>" type="text" size="28" />

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

            <td width="15%">Subject :</td>

            <td width="45%">

            <input id="txt_subject" name="txt_subject" value="<?php echo $txt_subject;?>" type="text" size="28" />

            </td>
			
         </tr>

        </table>

      </form>  

      </div>

      <form id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action;?>"><input type="hidden" id="h_search" name="h_search" value=""></form>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-top:1px solid #a7a7a7;">

        <tr>

          <td width="250">

          <input id="btn_submit" name="btn_submit" type="button" value="Search" title="Click to search information." search="<?php echo ($h_search!="advanced"?1:2); ?>"/>&nbsp;<input id="btn_clear" name="btn_clear" type="reset" value="Clear" title="Clear all values within the fields." />&nbsp;<input id="btn_srchall" name="btn_srchall" type="submit" value="Show all" title="Show all information." />

          </td>

          <?php /*

          <td width="100"> Saved Searches</td>

          <td><select name="">

              <option>-- None --</option>

            </select></td>

          <?php */?>

          <td>&nbsp;</td>

          

        </tr>

      </table>  

    </div>

    </div>

    <?php

    echo $table_view;

    ?>

  </div>