<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 10 June 2011
* Modified By: Jagannath Samanta
* Modified Date: 15 July 2011
* 
* Purpose:
* View For automail Add & Edit
* 
* @package Content Management
* @subpackage automail
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/automail/
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
	   //check_duplicate();
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
                  {
                     // $('<div id="err_msg" class="star_succ1">You can choose this year.</div>')
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
    var s_err="";
    $("#div_err").hide("slow"); 

	 if($.trim($("#txt_subject").val())=="") 
		{
			s_err +='Please provide automail subject in English.<br />';
			b_valid=false;
		}
	 if($.trim($("#txt_subject_french").val())=="") 
		{
			s_err +='Please provide automail subject in French.<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_content').getContent())=='') 
		{
			s_err +='Please provide automail content in English .<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_content_french').getContent())=='') 
		{
			s_err +='Please provide automail content in French .<br />';
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
<form id="frm_add_edit" name="frm_add_edit" method="post" action="<?php $edit_action?>">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
	<div class="info_box">From here Admin can edit the contents of the automail. Admin should not edit and delete the contents of enclosed under brackets [ ]</div>
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
          <td width="25%">Subject In english *:</td>
          <td width="66%"><input id="txt_subject" name="txt_subject" value="<?php echo $posted["txt_subject"];?>" type="text" size="50" /></td>
          <td width="9%">&nbsp;</td>
        </tr>
		
        <tr>
          <td valign="top">Content In English *:</td>		  
          <td>
          <textarea name="txt_content" id="txt_content" cols="46" rows="4" style="width:600px;"><?php echo $posted["txt_content"]; ?></textarea></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td width="25%">Subject In French *:</td>
          <td width="66%"><input id="txt_subject_french" name="txt_subject_french" value="<?php echo $posted["txt_subject_french"];?>" type="text" size="50" /></td>
          <td width="9%">&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Content In French *:</td>		  
          <td>
          <textarea name="txt_content_french" id="txt_content_french" cols="46" rows="4" style="width:600px;"><?php echo $posted["txt_content_french"]; ?></textarea></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Active:</td>
          <td><input id="i_automail_is_active" name="i_automail_is_active" value="1" <?php if($posted["i_automail_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
          <td>&nbsp;</td>
        </tr>
      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <!--<input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>-->
    </div>
    
</form>
</div>