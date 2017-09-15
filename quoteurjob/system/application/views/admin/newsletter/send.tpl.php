<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 23 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For newsletter send
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

<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

////////datePicker/////////
$("input[name='i_send_date']").datepicker({dateFormat: 'yy-M-dd',

										   changeYear: true,

										   changeMonth:true

										  });//DOB
										  
										  


var g_controller="<?php echo $pathtoclass;?>";//controller Path 
var maxNoAllowedEmail = "<?php echo $maxEmailAllowed;?>";  // Maximum no of email allowed
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
	 
   }); 
});    
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
    $("#div_err").hide("slow"); 

	 if($.trim($("#txt_to").val())=="" && (!$("input[name=i_all]:checkbox").is(":checkbox:checked")) 
	 	 && (!$("input[name=i_tradesman]:checkbox").is(":checkbox:checked")) && (!$("input[name=i_buyers]:checkbox").is(":checkbox:checked"))
		&& (!$("input[name=i_general]:checkbox").is(":checkbox:checked"))
		 ) 
			{
				s_err +='Please provide a email address or select any checkbox.<br />';
				b_valid=false;
			}
			
	else if($.trim($("#txt_to").val())!="")
	{
		var elem = $.trim($("#txt_to").val()).split(',');
		if(elem.length > maxNoAllowedEmail)
		{
			s_err +='Max '+maxNoAllowedEmail+' emails are allowed.<br />';
			 b_valid=false;
		}
		else
		{
			for(var i=0;i<elem.length;i++)
			{
				if(!emailPattern.test(elem[i]))
				{
					 s_err +='Invalid email address found.<br />';
					 b_valid=false;
					 break;
				}
				
			}
		}
		
	}
	if($.trim($("#i_send_date").val())=="")
	{
		s_err +='Please select date of sending.<br />';
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
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
        </tr>
        <tr>
          <td>To :</td>
          <td>
          	<textarea name="txt_to" id="txt_to" cols="46" rows="4"></textarea>
			<br />[Only 20 email at a time and please seperate email by comma ]
		  </td>
          <td valign="middle" align="left"></td>
        </tr>
		
		<tr>
			<td>Only Buyers :</td>
			<td><input id="i_buyers" name="i_buyers" value="1"   type="checkbox" /></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>Only Tradesmen :</td>
			<td><input id="i_tradesman" name="i_tradesman" value="2"   type="checkbox" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>All :</td>
			<td><input id="i_all" name="i_all" value="3"  type="checkbox" /></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>General Subscribers :</td>
			<td><input id="i_general" name="i_general" value="4"   type="checkbox" width="50px" /></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Date Of Sending :</td>
			<td><input id="i_send_date" name="i_send_date" type="text" readonly="readonly" /></td>
			<td>&nbsp;</td>
		</tr>
      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Send" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
    
</form>
</div>