<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 23 May 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For feedback Add & Edit
* 
* @package Content Management
* @subpackage feedback
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_feedback/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<!--<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>-->

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
	  // check_duplicate();
   }); 
});    
    

    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
	var myRadio = $("input[name='i_positive']:checked").val();
    
	if($("#s_comments").val()=='')
	{
		s_err +='Please provide comments .<br />';
        b_valid=false;
	}
	if(myRadio==1)
		{
			if($("#opt_rate option:selected").val()<=2)
			{
				s_err +='Please provide rating greater than 2 .<br />';
        		b_valid=false;
			}
			
		}
	else
	{
		if($("#opt_rate option:selected").val()>2)
		{
			s_err +='Please provide rating less than 3 .<br />';
        	b_valid=false;
		}
		
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
          <td width="27%">Job Title:</td>
          <td width="62%"><?php echo $posted["s_job_title"];?></td>
          <td width="11%">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Comments *:</td>
          <td>
          <textarea name="s_comments" style="width:300px; height:100px;" id="s_comments"><?php echo $posted["s_comments"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td>Rating *:</td>
          <td>
		  <select style="width:100px;" name="opt_rate" id="opt_rate">
		  <?php echo makeRating($arr_rating,$posted["opt_rate"]); ?>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		 <tr>
          <td>Type *:</td>
          <td  valign="middle">
		  <input type="radio" name="i_positive" value="0" <?php if($posted["i_positive"]==0) echo 'checked="checked"';?>/> Negative <input type="radio" name="i_positive" value="1" <?php if($posted["i_positive"]==1) echo 'checked="checked"';?>/> Positive
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