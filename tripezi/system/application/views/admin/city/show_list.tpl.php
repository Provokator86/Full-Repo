<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date 
* Purpose
*  View For city List Showing
* @package Content Management
* @subpackage city
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/city/
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
                                              });
											  

/********** For the project 
* By Mrinmoy
* Function change the status of top destination 
* remove as top destination to mark as top destination and viceversa  
*/
$("a[id^='destination_img_id_']").click(function(){
        var arr_arg,temp_id;
        temp_id = $(this).attr('id');
        arr_arg = temp_id.split('_');
         var i_status   = (arr_arg[4]=="yes")?1:0;
         
         $('#div_err').removeClass('error_massage success_massage');
         
        ////////Confirm///// 
        if(i_status)
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to mark as top destination?'); 
        }
        else
        {
            $("#dialog-confirm #dialog_msg").html('Are you sure to remove as top destination?'); 
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
                            url: g_controller+'ajax_change_destination_status',
                            data: "i_status="+i_status+"&h_id="+arr_arg[3],
                            success: function(msg){
                               if(msg=="ok") 
                               {
                                   if(i_status)
                                    {    
                                        $("a[id='"+temp_id+"'] > img").attr({'src':'images/admin/remove_mark.png','title':'Remove top destination','alt':'Remove top destination'});
                                        $("a[id='"+temp_id+"']").attr({'id':temp_id.replace("yes","not")});

                                    }
                                    else
                                    {
                                        $("a[id='"+temp_id+"'] > img").attr({'src':'images/admin/add_mark.png','title':'Mark top destination','title':'Mark top destination'}); 
                                        $("a[id='"+temp_id+"']").attr({'id':temp_id.replace("not","yes")});   

                                    }
                                     $('#div_err').addClass('success_massage').html('Destination status has changed successfully.').show(500).delay(1000).hide(500);    
                               }
                               else
                               {
                                   $('#div_err').addClass('error_massage').html('Status has failed to change.').show(500).delay(1000).hide(500);    
                                   
                               }

                            }
                       } ); 
                },
                'No': function(){
                     $(this).dialog('close');
                    
                }
            }
       });
    

    
    
    
}); 
/////////Admin change mark by ajax/////


											  

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


$("#opt_country").change(function(){
     var country_id =   $(this).val();  
     $("#opt_state").hide().prev("span").show();
     
     $.ajax({
                type: "POST",
                url: base_url+'ajax_common/ajax_change_state_option',
                data: "country_id="+country_id,
                success: function(msg){
                   if(msg!='')
                   {
                        $("#opt_state").prev("span").hide();
                        $("#opt_state").show();
                        $("#opt_state").html(msg);
                   }   
                }
            });
})  ;


$("#opt_state").change(function(){
     var state_id =   $(this).val();  
     $("#opt_city").hide().prev("span").show();
     
     $.ajax({
                type: "POST",
                url: base_url+'ajax_common/ajax_change_city_option',
                data: "state_id="+state_id,
                success: function(msg){
                   if(msg!='')
                   {
                        $("#opt_city").prev("span").hide();
                        $("#opt_city").show();
                        $("#opt_city").html(msg);
                   }   
                }
            });
})  ;

                                                                         

})});   

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can view the cities presnt in the database.Admin can also add cities here, if he need to add a new city.</div>
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
             <td width="15%">Country :</td>

            <td width="40%">
            <select name="opt_country" id="opt_country" >
                <option value="">Select Country</option>
                <?php echo makeOptionCountry('',$opt_country); ?>
            </select>
            </td>
            
			<td width="12%">State :</td>

            <td colspan="3">
             <span style="display: none;"> <img src="images/admin/loading.gif" alt="loading"></span>  
             <select name="opt_state" id="opt_state">
                <option value="">Select State</option>
                <?php if($opt_country){
                       echo makeOptionState(' WHERE i_country_id='.decrypt($opt_country).' ',$opt_state) ;
                    
                } ?>
                <?php // echo makeOptionState('',$opt_state); ?>
            </select>
            </td>
            
          </tr>
		  
		  <tr>
           
             <td width="15%">City :</td>
            <td width="40%">
            <input id="txt_city" name="txt_city" value="<?php echo $txt_city;?>" type="text" size="28" />
            </td>
             <td width="15%">Destination :</td>

            <td width="40%">
            <select name="opt_destination" id="opt_destination" >
                <option value="">All</option>
                <option value="1" <?php echo ($opt_destination==1)?"selected='selected'":""; ?>>Top destination</option>
            </select>
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