<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 21 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For job Add & Edit
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/job/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<!--<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>-->
<script>
var g_controller="<?php echo $pathtoclass;?>";//controller Path 
</script>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

$('#i_quoting_period_days').numeric();
    
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

    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;	
    var s_err="";
    $("#div_err").hide("slow"); 
	var keys = $.trim($("#s_keyword").val());	
	var key_len = keys.split(',');
	
	 if($.trim($("#s_title").val())=="") 
		{
			s_err +='Please provide title.<br />';
			b_valid=false;
		}
	
	 if($.trim($("#s_description").val())=="") 
		{
			s_err +='Please provide description.<br />';
			b_valid=false;
		}	
	/*if((text = tinyMCE.get('s_description').getContent())=='') 
		{
			s_err +='Please provide description .<br />';
			b_valid=false;
		}*/
	 if($.trim($("#s_keyword").val())=="") 
		{
			s_err +='Please provide a keywords.<br />';
			b_valid=false;
		}
	 else if(key_len.length>8 || key_len.length<4)
		{
			s_err +='Please provide minimum 4 keywords and maximum 8 keywords.<br />';
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
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th> 
        </tr> 
		       
		<tr>
          <td width="18%">Job Title *:</td>
          <td width="31%"><input id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" size="50" /></td>
          <td width="1%">&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Description *:</td>
          <td><textarea name="s_description" id="s_description" cols="46" rows="4" ><?php echo $posted["s_description"]; ?></textarea> 
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Keywords *:</td>
          <td>
		  <input id="s_keyword" name="s_keyword" value="<?php echo $posted["s_keyword"];?>" type="text" size="50" /><br/>
		  [Keywords should be comma seperated like windows,cleaning etc.]
		  </td>
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