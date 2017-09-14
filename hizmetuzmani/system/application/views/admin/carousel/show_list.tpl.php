<?php

/*********

* Author: Mrinmoy Mondal
* Date  : 07 June 2012
* Modified By: 
* Modified Date: 
* Purpose:
*  View For carousel images List Showing
* @package Content Management
* @subpackage banner
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/carousel/
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

                                    

///////////Submitting the form1/////////

$("#frm_search_1").submit(function(){

    var b_valid=true;
    var s_err="";

    $("#frm_search_1 #div_err_1").hide("slow"); 



    var inpVal="";            
      $("#frm_search_1 input[type!='hidden'],#frm_search_1 select,#frm_search_1 textarea").each(function(i){
        
            switch($(this).attr("type"))
            {
                case "text":
                    inpVal+=$(this).attr("value"); 
                break;
                case "password":
                    inpVal+=$(this).attr("value"); 
                break;            
                case "radio":
                     inpVal+=$(this).find(":checked").attr("value");
                break;    
                case "checkbox":
                     inpVal+=$(this).find(":checked").attr("value");
                break;                     
            }
               
        ///////select fields///
        if($(this).is("select"))
        {
            inpVal+=$(this).find("option:selected").attr("value"); 
        }

        ///////textarea fields///
        if($(this).is("textarea"))
        {
            inpVal+=$(this).text(""); 
        }            
      });
      
        if($.trim(inpVal)=="") 
        {
            s_err='Please provide Image Title.';
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


 var inpVal="";            
      $("#frm_search_2 input[type!='hidden'],#frm_search_2 select,#frm_search_2 textarea").each(function(i){
        
            switch($(this).attr("type"))
            {
                case "text":
                    inpVal+=$(this).attr("value"); 
                break;
                case "password":
                    inpVal+=$(this).attr("value"); 
                break;            
                case "radio":
                     inpVal+=$(this).find(":checked").attr("value");
                break;    
                case "checkbox":
                     inpVal+=$(this).find(":checked").attr("value");
                break;                     
            }
               
        ///////select fields///
        if($(this).is("select"))
        {
            inpVal+=$(this).find("option:selected").attr("value"); 
        }

        ///////textarea fields///
        if($(this).is("textarea"))
        {
            inpVal+=$(this).text(""); 
        }            
      });
      
        if($.trim(inpVal)=="") 
        {
            s_err='Please provide Image Title.<br />';
            b_valid=false;
        }
	/*	if($.trim($("#frm_search_2 #txt_created_on").val())=="") 
		{
			s_err +='Please provide Created On.';
			b_valid=false;
		}
    */
    

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
<?php /*?>
            <td width="10%">Image Title *:</td>

            <td width="10%">

            <input id="txt_banner_title" name="txt_banner_title" value="<?php echo $txt_banner_title;?>" type="text" size="28" />

            </td><?php */?>

            <td width="10%">Created On:</td>

            <td width="10%">

            <input id="txt_created_on" name="txt_created_on" value="<?php echo $txt_created_on;?>" type="text" size="28"  readonly="yes"/>

            </td>

           <?php /*?><td width="10%">Album</td>
            <td align="left" >
			<select name="opt_album_id" id="opt_album_id">
					<option value="">Select </option>
				<?php  echo makeOptionAlbum('id!=0', $opt_album_id)?>
			 </select>
			</td><?php */?>
			<td>&nbsp;</td>

            <td>&nbsp;</td>

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

      <form id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action;?>"><input type="hidden" id="h_search" name="h_search" value=""></form>

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