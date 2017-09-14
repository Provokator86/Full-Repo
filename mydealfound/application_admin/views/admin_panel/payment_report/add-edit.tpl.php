<?php
 /*********
* Author: 
* Date  : 
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For Set access control for user Admin
* 
* @package User Admin
* @subpackage user admin
* 
* @link InfController.php 
* @link My_Controller.php
* @link Controler/admin/user_admin/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<!--<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>-->
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script>

<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
jQuery(document).ready(function(){

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
	
	/*if((text = tinyMCE.get('s_description').getContent())=='') 
	{
		s_err +='Please provide description .<br />';
		b_valid=false;
	}*/
	
	//b_valid=false; 
	if($.trim($("#s_description").val())=="") 
	{
		s_err +='Please provide description.<br />';
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
 
<?php /////////end Javascript For List View//////////   ?> 

<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>     
    
    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <?php /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
          
        </tr> 
		
		 
				
		
        <tr>
						<td valign="top">Advertisement script * :</td>
						<td><textarea id="s_description" name="s_description" type="text" size="50" autocomplete="off" style="vertical-align:top"  class="" cols="50" rows="4" ><?php echo my_showtext($posted["s_description"]); ?></textarea></td>
						<td>&nbsp;</td>
				</tr>
				
        
         <tr>
          <td>Is Active :</td>
          <td><input id="i_is_active" name="i_is_active" value="1" type="checkbox"  <?php echo $posted["i_is_active"]==1?' checked="checked"':'' ?> size="34" style="border: 1px solid #A7A7A7;" /></td>
          <td>&nbsp;</td>
        </tr>

      </table>
      </div>
    <?php /***** end Modify Section *******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
    
</form>
</div>