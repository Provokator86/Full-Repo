<?php

/*********
* Author: Koushik
* Email:koushik.r@acumensoft.info     
* Date  : 4 July 2012
* Modified By: 
* Modified Date:
* Purpose:

*  View For blog List Showing

* @package Content Management

* @subpackage blog
* @Controller blog.php
* @model blog_model.php
*/
?>

<script type="text/javascript" language="javascript" >
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
////////datePicker/////////
$("input[name='txt_created_on']").datepicker({dateFormat: 'dd-mm-yy',
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
    
                 <div class="info_box">From here Admin can can view, add and delete the Blog .</div>     
    <div id="tab_search">

    <div id="tabbar">

      <ul>
	  
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
            <td width="15%">Blog Title :</td>
            <td width="35%">
            <input id="txt_blog_title" name="txt_blog_title" value="<?php echo $txt_blog_title;?>" type="text" size="28" />
            </td>
            <td width="12%">Created On:</td>
            <td colspan="3">
            <input id="txt_created_on" name="txt_created_on" value="<?php echo $txt_created_on;?>" type="text" size="28"  readonly="yes"/>
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
        </tr>
      </table>  
    </div>
    </div>
    <?php
    echo $table_view;
    ?>
  </div>