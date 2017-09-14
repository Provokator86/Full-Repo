<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 04 April 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
* view For bank transfer report List Showing
* 
* @package Report
* @subpackage Bank Transfer
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/job_live_report/
*/
?>
<script type="text/javascript" language="javascript" >
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

/* start to hide left side panel */
	$('#show_hide').click();
/* end left side panel */

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

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>

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

            <td width="15%">Tradesman Name :</td>

            <td width="20%">

            <input id="s_title" name="s_title" value="<?php echo $s_title;?>" type="text" size="28" />

            </td>
			
			<td width="7%">Buyer Name :</td>

            <td width="25%">
			<input id="s_title" name="s_title" value="<?php echo $s_title;?>" type="text" size="28" />
			</td>
			  
          </tr>
		  
		  <tr>

            <td width="15%">Payment From :</td>

            <td width="20%">

            <input id="txt_created_from" name="txt_created_from" value="<?php echo $txt_cretaed_from;?>" type="text" size="28" readonly="yes" />

            </td>
			
			<td width="7%">To :</td>

            <td width="25%">
			<input id="txt_created_to" name="txt_created_to" value="<?php echo $txt_cretaed_from;?>" type="text" size="28" readonly="yes" />
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