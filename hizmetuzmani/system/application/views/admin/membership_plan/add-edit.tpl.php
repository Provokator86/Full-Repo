<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 02 Apr 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For membership plan Add & Edit
* 
* @package General
* @subpackage membership plan
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/membership_plan/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>

<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

$('#txt_price').numeric();
$('#txt_add_price').numeric();

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
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
    $("#div_err").hide("slow"); 
	var mode = $("#h_mode").val();
	var int_reg = /^[0-9]*$/;
	
    if(mode!='edit') // not to check at the time of edit
	{
		if($.trim($("#opt_type").val())=="") 
		{
			s_err +='Please provide membership type.<br />';
			b_valid=false;
		}
	}
	if($.trim($("#txt_quotes").val())=="") 
    {
        s_err +='Please provide quotes.<br />';
        b_valid=false;
    }
	
	else if(!int_reg.test($("#txt_quotes").val()))	
	{
		s_err +='Please provide quotes in integer.<br />';
		b_valid=false;
	}	
	
	if($.trim($("#txt_contact").val())=="") 
    {
        s_err +='Please provide contact.<br />';
        b_valid=false;
    }
	else if(!int_reg.test($("#txt_contact").val()))	
	{
		s_err +='Please provide contact in integer.<br />';
		b_valid=false;
	}
	if($.trim($("#txt_duration").val())=="") 
    {
        s_err +='Please provide duration.<br />';
        b_valid=false;
    }
	else if(!int_reg.test($("#txt_duration").val()))	
	{
		s_err +='Please provide duration in integer.<br />';
		b_valid=false;
	}
	if($.trim($("#txt_price").val())=="") 
    {
        s_err +='Please provide price.<br />';
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
<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here admin can edit the mebership plan offers .</div>
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
		<?php if($mode!="edit") { ?>      
		<tr>
          <td>Membership Type * :</td>
          <td>
		 	<select id="opt_type" name="opt_type">
				<option value="">Select</option>
				<?php echo makeOption($arr_type,$posted['opt_type']) ?>
			</select>
		  </td>
          <td>&nbsp;</td>
        </tr>
		<?php }
        else
        { ?>
        <tr>
          <td>Membership Type * :</td>
          <td>
             <input type="text" value="<?php echo $posted['s_type']; ?>" size="28" readonly="readonly" style="font-weight: bold;">
          </td>
          <td>&nbsp;</td>
        </tr>
            
        <?php    
        } ?>
        <tr>
          <td valign="top">Quotes *:</td>
          <td>
          <input id="txt_quotes" name="txt_quotes" value="<?php echo $posted["txt_quotes"];?>" type="text" size="28" />
          </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Contact Information *:</td>
          <td>
          <input id="txt_contact" name="txt_contact" value="<?php echo $posted["txt_contact"];?>" type="text" size="28" />
          </td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td valign="top">Duration (in days) *:</td>
          <td>
          <input id="txt_duration" name="txt_duration" value="<?php echo $posted["txt_duration"];?>" type="text" size="28" />
          </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Price *:</td>
          <td>
          <input id="txt_price" name="txt_price" value="<?php echo $posted["txt_price"];?>" type="text" size="28" />
          </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Price for Additional contact information :</td>
          <td>
          <input id="txt_add_price" name="txt_add_price" value="<?php echo $posted["txt_add_price"];?>" type="text" size="28" />
          </td>
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