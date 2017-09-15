<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 15 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For news Add & Edit
* 
* @package Content Management
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/news/
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
      // $("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_email");
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
                      $('<div id="err_msg" class="star_err1">Duplicate title exists.</div>')
                      .insertAfter("#txt_email");
                      
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
	var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;  
    var s_err="";
    $("#div_err").hide("slow"); 
	

	 if($.trim($("#opt_user_type").val())=="") 
		{
			s_err +='Please select user type.<br />';
			b_valid=false;
		}
		
	if($.trim($("#txt_first_name").val())=="") 
		{
			s_err +='Please provide firstname.<br />';
			b_valid=false;
		}	
	if($.trim($("#txt_last_name").val())=="") 
		{
			s_err +='Please provide lastname.<br />';
			b_valid=false;
		}	
		
	 if($.trim($("#txt_email").val())=="") 
		{
			s_err +='Please provide email.<br />';
			b_valid=false;
		}
	else if(!emailPattern.test($.trim($("#txt_email").val())))
		{
			s_err +='Please provide proper email.<br />';
			b_valid=false;
		}	
	if($.trim($("#txt_user_name").val())=="") 
		{
			s_err +='Please provide username.<br />';
			b_valid=false;
		}
		
	if($.trim($("#txt_pwd").val())=="") 
		{
			s_err +='Please provide password.<br />';
			b_valid=false;
		}
	if($.trim($("#txt_con_pwd").val())=="") 
		{
			s_err +='Please provide confirm password.<br />';
			b_valid=false;
		}
	else if($.trim($("#txt_pwd").val())!=$.trim($("#txt_con_pwd").val()))
		{
			s_err +='Please give two password same.<br />';
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
          <td>User Type *:</td>
          <td>
		  <select name="opt_user_type" id="opt_user_type">
		  	<option value="">Select</option>
			<?php echo makeOptionUser('',$posted['opt_user_type']) ?>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Firstname *:</td>
          <td><input id="txt_first_name" name="txt_first_name" value="<?php echo $posted["txt_first_name"] ?>" type="text" size="50" autocomplete="off" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Lastname *:</td>
          <td><input id="txt_last_name" name="txt_last_name" value="<?php echo $posted["txt_last_name"] ?>" type="text" size="50" autocomplete="off" /></td>
          <td>&nbsp;</td>
        </tr> 
		
		<tr>
          <td>Username *:</td>
          <td><input id="txt_user_name" name="txt_user_name" value="<?php echo $posted["txt_user_name"] ?>" type="text" size="50" autocomplete="off" /></td>
          <td>&nbsp;</td>
        </tr>
		      
		<tr>
          <td>Email Id *:</td>
          <td><input id="txt_email" name="txt_email" value="<?php echo $posted["txt_email"] ?>" type="text" size="50" autocomplete="off" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Password *:</td>
          <td><input id="txt_pwd" name="txt_pwd" value="" type="password" size="34" maxlength="12" style="border: 1px solid #A7A7A7;"  /></td>
          <td>&nbsp;</td>
        </tr> 
		
		<tr>
          <td>Confirm Password *:</td>
          <td><input id="txt_con_pwd" name="txt_con_pwd" value="" type="password" size="34" maxlength="12" style="border: 1px solid #A7A7A7;" /></td>
          <td>&nbsp;</td>
        </tr>
           
        <tr>
          <td>Active:</td>
          <td><input id="i_user_is_active" name="i_user_is_active" value="1" <?php if($posted["i_user_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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