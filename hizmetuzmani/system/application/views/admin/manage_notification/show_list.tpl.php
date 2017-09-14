<?php

/*********
* Author: mronmoy mondal
* Date  : 02 Apr 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For Manage Notification List Showing
* 
* @package CMS
* @subpackage Manage Notification 
* 
* @link InfController.php 
* @link My_Controller.php
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

                                              });//created on          


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
	<div class="info_box">From here Admin can view the notifications.</div>
	<div class="clr"></div>

    <?php

    echo $table_view;
	echo $val;

    ?>

  </div>