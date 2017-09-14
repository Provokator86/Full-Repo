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

$("input[name^='txt_date_']").datepicker({dateFormat: 'dd-mm-yy',
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


function show_property_details(enc_id)
{
    jQuery(function($) { 
     
     var pop_w   =   "width=800";
        
     var pop_h   =   "height=400";
      $.prettyPhoto.open(g_controller+'property_details/'+enc_id+'/iframe'
                       +(pop_w!=""||pop_h!=""?"?"+pop_w+"&"+pop_h:"")
                        ,'<?php echo $caption;?>');
      });  
} 



</script>

<div id="right_panel">

    <h2><?php echo $heading;?></h2>
    
                 <div class="info_box">From here Admin can can view property details .</div>     
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

            <td width="15%">News Title *:</td>

            <td width="23%">

            <input id="txt_news_title" name="txt_news_title" value="<?php echo $txt_news_title;?>" type="text" size="28" />

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

            <td width="15%">Property ID :</td>

            <td width="40%">

            <input id="txt_property_id" name="txt_property_id" value="<?php echo $txt_property_id;?>" type="text" size="28" />

            </td>

            <td width="12%">Property Name:</td>

            <td colspan="3">

            <input id="txt_property_name" name="txt_property_name" value="<?php echo $txt_property_name;?>" type="text" size="28"   />

            </td>

          </tr>
          <tr>

            <td width="15%">Owner Name :</td>

            <td width="40%">

            <input id="txt_owner_name" name="txt_owner_name" value="<?php echo $txt_owner_name;?>" type="text" size="28" />

            </td>

            <td width="12%">Owner Email :</td>

            <td colspan="3">

            <input id="txt_owner_email" name="txt_owner_email" value="<?php echo $txt_owner_email;?>" type="text" size="28"   />

            </td>
          </tr>
          
          <tr>

            <td width="15%">Standard price :</td>

            <td width="40%">

            <input id="txt_price" name="txt_price" value="<?php echo $txt_price;?>" type="text" size="28" />

            </td>

            <td width="12%">Amenity :</td>

            <td colspan="3">
           
                <select name="opt_amenity" id="opt_amenity">
                    <option value="">Select Amenity</option>
                   <?php echo makeOptionAmenity('',$opt_amenity); ?>
                </select>
            </td>
          </tr>
          
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
                 <span style="display: none;"> <img src="images/admin/loading.gif" alt="loading"></span>
                 <select name="opt_city" id="opt_city">
                <option value="">Select City</option>
                    <?php if($opt_state){
                           echo makeOptionCity(' WHERE i_state_id='.decrypt($opt_state).' ',$opt_city) ;
                        
                    } ?>    
                </select>
             
            </td>

            <td width="12%">Zipcode :</td>

            <td colspan="3">

            <input id="txt_zipcode" name="txt_zipcode" value="<?php echo $txt_zipcode;?>" type="text" size="28"   />

            </td>
          </tr>

          <tr>

            <td width="15%">Created Date From :</td>

            <td width="23%">

            <input id="txt_date_from" name="txt_date_from" value="<?php echo $txt_date_from;?>" type="text" size="31" readonly="yes"/>

            </td>

            <td width="12%">Created Date To :</td>

            <td colspan="3">

            <input id="txt_date_to" name="txt_date_to" value="<?php echo $txt_date_to;?>" type="text" size="31"  readonly="yes" />

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