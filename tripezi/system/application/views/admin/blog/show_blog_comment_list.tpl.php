<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* Purpose:
*  View For private message List Showing
* @package Content Management
* @subpackage user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/private message/
*/

?>

<script type="text/javascript" language="javascript" >
jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {
$(document).ready(function(){

/* Hide Delete Button **/
$('input[id^="btn_del_"]').parent().remove();
$(':input[id^="dd_list"]').parent().remove();
$(':input[id^="chk_del_"]').parent().remove();
$(':input[id^="chk_all"]').parent().remove();


////////datePicker/////////

$("input[name='txt_created_on']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
                                               changeMonth:true
                                              });
											  
//////////Clicking the tabbed search/////


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
	<div class="info_box">From here Admin can view all the comments posted by all the different users.</div>
	<div class="clr"></div>
    <div>

    <div id="tabcontent">
    

      <div id="div2" <?php //echo ($h_search=="advanced"?"":'style="display: none;"') ?> >

      <form id="frm_search_2" name="frm_search_2" method="post" action="" >

        <input type="hidden" id="h_search" name="h_search" value="advanced" />

        <div id="div_err_2"></div>        

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="15%">Blog Title:</td>

            <td width="60%">
		   	  <span style="color:#3B5998;"><?php echo $blog_info['s_title'];?></span>
            </td>

            <td width="12%"></td>

            <td colspan="3">
			
			
			
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