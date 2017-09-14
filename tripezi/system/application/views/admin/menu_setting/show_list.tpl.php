<?php

/*********
* Author: Koushik Rout
* Date  : 26 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For menu setting List Showing
* 
* @package 
* @subpackage 
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/menu_setting/

*/



?>

<script type="text/javascript" language="javascript" >

jQuery.noConflict();///$ can be used by other prototype which is not jquery

jQuery(function($) {

$(document).ready(function(){






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

$("#txt_menu_title").focus(function(){
    $(this).val('');
});

$("#btn_submit").click(function(){

    $.blockUI({ message: 'Just a moment please...' });
    var b_valid =   true;
    if($.trim($("#txt_menu_title").val())=='' || $.trim($("#txt_menu_title").val())=='Enter menu title' )
    {
        $("#txt_menu_title").val('Enter menu title');
        b_valid =   false;
    }

    if(b_valid)
    {
        $("#frm_2").submit();
    }
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



    if($.trim($("#frm_search_1 #txt_news_title").val())=="") 

    {

        s_err +='Please provide News Title.<br />';

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



/*    if($.trim($("#frm_search_2 #txt_news_title").val())=="") 
    {
        s_err +='Please provide News Title.<br />';
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


$("a[id^=edit_row_]").click(function(){
    var row_id  =   $(this).attr('id').split('_').pop();
    $(this).parent().prev('td').prev('td').find('span').text('');
    $(this).parent().prev('td').prev('td').find('input').show();
    $(this).hide().next().show();
});

$("a[id^=save_row_]").click(function(){
    var row_id  =   $(this).attr('id').split('_').pop();
    var edited_data =   $(this).parent().prev('td').prev('td').find('input').val();
    var obj_td  =   $(this).parent().prev('td').prev('td');
   $.ajax({
                type: "POST",
                url: base_url+'admin/menu_setting/ajax_edit_main_menu',
                data: "edited_data="+edited_data+"&row_id="+row_id,
                success: function(msg){
                    if(msg=='ok')
                    {
                         $(obj_td).find('input').hide();
                         $(obj_td).find('span').text(edited_data);
                        
                    }
                  
                }
   });
   
    
    $(this).hide().prev().show();
});

$("a[id^=change_row_]").click(function(){
    var row_id  =   $(this).attr('id').split('_').pop();
    var obj_td  =   $(this).parent().prev('td');
    var data =   $(this).parent().prev('td').text();
   $.ajax({
                type: "POST",
                url: base_url+'admin/menu_setting/ajax_change_status_main_menu',
                data: "data="+data+"&row_id="+row_id,
                success: function(msg){
                    if(msg!='error')
                    {  
                        window.location.reload();
                    }
                  
                }
   });
});


$("a[id^=delete_row_]").click(function(){
       var row_id  =   $(this).attr('id').split('_').pop();
     $("#dialog-confirm #dialog_msg").html('<strong>This menu wiil deleted permanently with submenu.</strong> Are you sure?');       
       $("#dialog-confirm").dialog({
            resizable: false,
            height:240,
            width:350,
            modal: true,
            title: "Removal Confirmation?",
            buttons: {
                'Delete': function() {
                    $(this).dialog('close');
                    $.blockUI({ message: 'Just a moment please...' });
                  
                     $.ajax({
                    type: "POST",
                    url: base_url+'admin/menu_setting/ajax_delete_main_menu',
                    data: "row_id="+row_id,
                    success: function(msg){
                        if(msg=='ok')
                        {  
                            window.location.reload();
                        }
                      
                    }
                    });
                  
                },
                Cancel: function() {
                    $(this).dialog('close');
                }
            }
        });
       ////////end Confirm/////
    
   
});


                                                                         

})});   

</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
	<div class="info_box">Here we set Main menu For the Project .</div>
	<div class="clr"></div>

    <div id="tab_search">

    <div id="tabbar">

      <ul>

        <li><a href="#div2" <?php echo ($h_search=="advanced"?'class="select"':'') ?> id="2"><span>Add Menu</span></a></li>

      </ul>      

    </div>

    <div id="tabcontent">

     

      <div id="div2" >

      <form id="frm_2" name="frm_2" method="post" action="" >


        <div id="div_err_2"></div>        

        <table width="100%" border="0" cellspacing="0" cellpadding="0">

          <tr>

            <td width="15%">Menu Title :</td>

            <td width="23%">

            <input id="txt_menu_title" name="txt_menu_title" value="" type="text" size="28" style="background: none;" />

            </td>

            <td width="12%">Menu status:</td>

            <td colspan="3">

                <select name="opt_status" id="opt_status" style="width: 232px;">
                    <option value="1">Show</option>
                    <option value="0">Hide</option>
                </select>
            </td>
          </tr>

        </table>
        
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="search_button">

        <tr>

          <td width="250">

          <input id="btn_submit" name="btn_submit" type="button" value="Add Menu" title="Click to Add new Menu." />&nbsp;<input id="btn_clear" name="btn_clear" type="reset" value="Clear" title="Clear all values within the fields." />

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