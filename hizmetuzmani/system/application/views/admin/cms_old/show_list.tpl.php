<?php

/*********

* Author: Mrinmoy Mondal

* Date  : 9 June 2011

* Modified By: Jagannath samanta 

* Modified Date: 05 July 2011

* 

* Purpose:

*  View For Content List Showing

* 

* @package Content Management

* @subpackage content

* 

* @link InfController.php 

* @link My_Controller.php

* @link views/admin/content/

*/



?>

<script type="text/javascript" language="javascript" >

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {

$(document).ready(function(){



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

$("#frm_search_1").submit(function(){

    var b_valid=true;

    var s_err="";

    $("#frm_search_1 #div_err_1").hide("slow"); 



    if($.trim($("#frm_search_1 #txt_content_title").val())=="") 

    {

        s_err='Please provide Page Title.';

        b_valid=false;

    }

    

    /////////validating//////

    if(!b_valid)

    {

        $.unblockUI();  

        $("#frm_search_1 #div_err_1").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");

    }

    

    return b_valid;

});    

///////////end Submitting the form1/////////

///////////Submitting the form2/////////

$("#frm_search_2").submit(function(){

    var b_valid=true;

    var s_err="";

    $("#frm_search_2 #div_err_2").hide("slow"); 



    if($.trim($("#frm_search_2 #txt_content_title").val())=="") 

    {

        s_err +='Please provide Page Title.<br />';

        b_valid=false;

    }
   	
	/*if($.trim($("#frm_search_2 #txt_created_on").val())=="") 

    {

        s_err +='Please provide Created On.<br />';

        b_valid=false;

    }*/
    

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

    <div id="tab_search">

    <div id="tabbar">

      <ul><?php //javascript:void(0)?>

        <li id="test"><a href="#div1" <?php echo ($h_search=="basic"?'class="select"':'') ?> id="1"><span>Basic Search</span></a></li>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Advanced Search</span></a></li>

      </ul>      

    </div>

    <div id="tabcontent">

      <div id="div1" <?php //echo ($h_search=="basic"?"":'style="display: none;"') ?> >

      <form id="frm_search_1" name="frm_search_1" method="post" action="">

        <input type="hidden" id="h_search" name="h_search" value="basic" />

		<input type="hidden" id="h_content_type" name="h_content_type" value="<?php echo $h_content_type;?>" />	

        <div id="div_err_1"></div>

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="10%">Page Title *:</td>

            <td width="23%">

            <input id="txt_content_title" name="txt_content_title" value="<?php echo $txt_content_title;?>" type="text" size="28" />

            </td>

            <td width="10%">&nbsp;</td>

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

      </div>

      <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >

      <form id="frm_search_2" name="frm_search_2" method="post" action="" >

        <input type="hidden" id="h_search" name="h_search" value="advanced" />

		<input type="hidden" id="h_content_type" name="h_content_type" value="<?php echo $h_content_type;?>" />		

        <div id="div_err_2"></div>        

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="10%">Page Title *:</td>

            <td width="23%">

            <input id="txt_content_title" name="txt_content_title" value="<?php echo $txt_content_title;?>" type="text" size="28" />

            </td>

            <td width="12%">Created On:</td>

            <td width="21%">

            <input id="txt_created_on" name="txt_created_on" value="<?php echo $txt_created_on;?>" type="text" size="28"  readonly="yes"/>

            </td>

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

      </div>

      <form id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action;?>"><input type="hidden" id="h_search" name="h_search" value=""><input type="hidden" id="h_content_type" name="h_content_type" value="<?php echo $h_content_type;?>" /></form>

      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_button">

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