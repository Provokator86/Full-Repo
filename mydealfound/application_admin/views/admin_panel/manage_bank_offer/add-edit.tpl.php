<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage bank offer
* @package Travel
* @subpackage Manage Category
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_store/
*/
?>

 <?php
    /////////Javascript For List View//////////
?>
<?php /*?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script><?php */?>

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
	
	if($.trim($("#s_bank").val())=="") 
	{
		s_err +='Please provide bank offer.<br />';
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
	<div class="info_box">From here Admin can add/edit the bank offer. </div>
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
          <td width="25%">Bank *:</td>
          <td width="66%"><input id="s_bank" name="s_bank" value="<?php echo my_render($posted["s_bank"]);?>" type="text" size="50" /></td>
          <td width="9%">&nbsp;</td>
        </tr>

      
		<tr>
          <td>Active:</td>
          <td><input id="i_status" name="i_status" value="1" <?php if($posted["i_status"]==0) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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