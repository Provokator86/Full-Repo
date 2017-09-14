<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 23 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For newsletter Add & Edit
* 
* @package Content Management
* @subpackage newsletter
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/newsletter/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>
<script>
function check()
 {
 	var totalRows = 4,count=0;
        for(i = 1; i< totalRows; i++)   {
            if(document.getElementById("child_box"+i).checked){
                count= count+1;
            }
        }
		
        if(count ==totalRows - 1){
            //alert("check Main");
            document.getElementById("i_all").checked = true;
        }
        else
        {
            //alert("uncheck Main");
            document.getElementById("i_all").checked = false;
        }

 }
</script>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
function customRange(input) { 


    if (input.id == 'i_send_date') {
    return {
		//alert('sam');
      minDate: jQuery('#i_send_date').datepicker("getDate")
    };
  } else if (input.id == 'txt_created_on') {
    return {
      maxDate: jQuery('#txt_to').datepicker("getDate")
    };
  }
   
}

jQuery(function($) {
$(document).ready(function(){

////////datePicker/////////
$("input[name='i_send_date']").datepicker({dateFormat: 'dd-mm-yy',

										   changeYear: true,
										   beforeShow: customRange,
										   changeMonth:true

										  });//DOB
										  

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

// used to select/unselect all check boxes whenever all checkbox is select/unselect
$("#i_all").live( 'change', function() {
  $(".child_box").attr( 'checked', $( this ).is( ':checked' ) ? 'checked' : '' );
});





// end of select checkbox at once

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
      // $("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_subject");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate  exists.</div>')
                      .insertAfter("#txt_subject");
                      
                  }
                  else
                  {  // $('<div id="err_msg" class="star_succ1">You can choose this year.</div>')
                    //  .insertAfter("#txt_milestones_year");     
                      $("#frm_add_edit").submit();                 
                  }
                });
    }
    else
    {
         $("#frm_add_edit").submit();  
    }
    

}
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
	var send_date = $("#i_send_date").val();
	//var a = new Date();
	//var b = a.toISOString().split("T")[0].split("-");	
	//var ca = b[2] + "-" + b[1] + "-" + b[0];
    var s_err="";
    $("#div_err").hide("slow"); 
	
	var dateParts = send_date.split("-");

	var checkindate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
	var now = new Date();
	var difference = now - checkindate;
	var days = (difference / (1000*60*60*24))*1;
	//alert(days);
	var reg_exp = /^-\d*\.{0,1}\d*$/;
	
	
	
	 if($.trim($("#txt_subject").val())=="") 
		{
			s_err +='Please provide newsletter subject.<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_content').getContent())=='') 
		{
			s_err +='Please provide newsletter content .<br />';
			b_valid=false;
		}
	
	if($.trim($("#i_send_date").val())=="")
	{
		s_err +='Please provide send date .<br />';
		b_valid=false;
	}
	/*else if(!reg_exp.test(days))
	{
		s_err +='Please provide any date greater than today .<br />';
		b_valid=false;
	}*/
	else if(days>1)
	{
		s_err +='Please provide any date greater than yesterday .<br />';
		b_valid=false;
	}
   

    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////    
    
})});    
</script>    
 
<?php
  /////////end Javascript For List View//////////  
  /****
<div class="success_massage"><span>SUCCESS!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

<div class="error_massage"><span>ERROR!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

<div class="warning_massage"><span>Warning!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>

<div class="info_massage"><span>Information!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
  */
  
  
?> 

<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <div class="info_box">From here Admin can create and save the newsletters for all, only clients, only professionals and general subscribers of the site.</div>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
			/*  pr($posted);*/
            ?>
        </div>     
    
    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>  
        </tr>
		<tr>
          <td width="35%">Subject *:</td>
          <td width="51%"><input id="txt_subject" name="txt_subject" value="<?php echo $posted["txt_subject"];?>" type="text" size="50" /></td>
          <td width="14%">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Content *:</td>
          <td>
          <textarea name="txt_content" id="txt_content" style="width:500px;" cols="46"  rows="4"><?php echo $posted["txt_content"]; ?></textarea>          </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
			<td>All :</td>
			<td><input id="i_all" name="i_all" value="3" <?php if($posted["i_all"]==3) echo 'checked="checked"'; else echo '';?>  type="checkbox" /></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>Only Clients :</td>
			<td><input name="i_buyers" id="child_box1" value="1" <?php if($posted["i_buyers"]==1) echo 'checked="checked"'; else echo '';?> type="checkbox" class="child_box" onclick="check()"/></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>Only Professionals :</td>
			<td><input name="i_tradesman" id="child_box2" value="2" <?php if($posted["i_tradesman"]==2) echo 'checked="checked"'; else echo '';?> type="checkbox" class="child_box" onclick="check()"/></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>General Subscribers :</td>
			<td><input name="i_general" id="child_box3" value="4" <?php if($posted["i_general"]==4) echo 'checked="checked"'; else echo '';?>  type="checkbox"  class="child_box" onclick="check()"/></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Date of Sending *:</td>
			<td><input id="i_send_date" name="i_send_date" type="text" readonly="readonly" value="<?php echo $posted["dt_send_on"] ?>" /></td>
			<td>&nbsp;</td>
		</tr>
      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
    
</form>
</div>