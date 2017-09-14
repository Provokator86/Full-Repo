<?php

/*********
* Author: Mrinmoy Mondal
* Date  : 10 Jan 2012
* Modified By: 
* Modified Date: 
* Purpose:
* View For automail Add & Edit
* @package Content Management
* @subpackage automail
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/automail/
*/
?>

 <?php
    /////////Javascript For List View//////////
?>

<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script>

<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

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
	
	if($.trim($("#txt_subject").val())=="") 
	{
		s_err +='Please provide automail subject in English.<br />';
		b_valid=false;
	}

	if((text = tinyMCE.get('txt_content').getContent())=='') 	
	{	
		s_err +='Please provide automail content in English .<br />';	
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

});    

</script>    

 
<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can edit the contents of the automail. <strong>Admin should not edit OR delete the contents of enclosed under brackets [ ]</strong></div>
	<div class="clr"></div>
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
          <th  align="left" colspan="3"><h4><?php echo $heading;?></h4></th>  
        </tr>

		<tr>
          <td width="25%">Subject *:</td>
          <td width="66%"><input id="txt_subject" name="txt_subject" value="<?php echo my_render($posted["txt_subject"]);?>" type="text" size="50" /></td>
          <td width="9%">&nbsp;</td>
        </tr>

        <tr>

          <td valign="top">Content *:</td>
          <td>
          <textarea name="txt_content" id="txt_content" cols="46" rows="4" style="width:600px;" class="mceEditor"><?php echo my_render($posted["txt_content"]); ?></textarea></td>
          <td>&nbsp;</td>

        </tr>

		<?php /*?><tr>
          <td>Active:</td>
          <td><input id="i_automail_is_active" name="i_automail_is_active" value="1" <?php if($posted["i_automail_is_active"]==0) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
          <td>&nbsp;</td>

        </tr><?php */?>

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