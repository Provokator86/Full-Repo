<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 18 Jan 2013
* Modified By: 
* Modified Date 
* Purpose
*  View For country List Showing
* @package general
* @subpackage country
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/country/
*/
?>

<script type="text/javascript" language="javascript" >

$(document).ready(function(){

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
    //clear_form("#frm_search_"+formid);   
	$(':input',"#frm_search_"+formid)
 .not(':button, :submit, :reset, :hidden')
 .val('')
 .removeAttr('checked')
 .removeAttr('selected');

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
                                                                         

});

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can view the countries presnt in the database.Admin can also add country here, if he need to add a new country.</div>
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
            <td width="15%">Country name :</td>
            <td width="23%">
            <input id="txt_country" name="txt_country" value="<?php echo $txt_country;?>" type="text" size="28" />
            </td>
            <td colspan="4">
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