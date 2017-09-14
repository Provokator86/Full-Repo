<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 24 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For meta_tags Add & Edit
* 
* @package Content Management
* @subpackage meta_tags
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/meta_tags/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>

<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
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
    var $this = $("#txt_page_title");
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
                      .insertAfter("#txt_page_title");
                      
                  }
                  else
                  {   
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

    
	 if($.trim($("#txt_page_title").val())=="") 
		{
			s_err +='Please provide page title.<br />';
			b_valid=false;
		}
	 if($.trim($("#txt_page").val())=="") 
		{
			s_err +='Please provide page .<br />';
			b_valid=false;
		}
	 if($.trim($("#txt_title").val())=="") 
		{
			s_err +='Please provide title.<br />';
			b_valid=false;
		}	
	if($.trim($("#txt_keywords").val())=="") 
		{
			s_err +='Please provide keywords.<br />';
			b_valid=false;
		}			
	
		
	 if($.trim($("#txt_description").val())=="") 
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
          <th width="30%" align="left" colspan="3"><h4><?php echo $heading;?></h4></th>
        </tr>  
		
        <tr>
          <td>Page Reference *:</td>
          <td><input id="txt_page" name="txt_page" value="<?php echo $posted["txt_page"];?>" type="text" size="50" <?php echo (decrypt($posted["h_id"])? 'readonly="readonly"' : '')?>  /></td>
          <td>&nbsp;</td>
        </tr>
              
		<tr>
          <td>Meta Page *:</td>
          <td><input id="txt_page_title" name="txt_page_title" value="<?php echo $posted["txt_page_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		
		
		<tr>
          <td>Meta Title *:</td>
          <td><input id="txt_title" name="txt_title" value="<?php echo $posted["txt_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Meta Keywords *:</td>
          <td><input id="txt_keywords" name="txt_keywords" value="<?php echo $posted["txt_keywords"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td valign="top">Meta Description *:</td>
          <td>
          <textarea name="txt_description" id="txt_description"  cols="47" rows="4"><?php echo $posted["txt_description"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
		
		<?php /*?><tr>
          <td>Revisit After *:</td>
          <td><input id="txt_revisit_after" name="txt_revisit_after" value="<?php echo $posted["txt_revisit_after"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td>Robots *:</td>
          <td><input id="txt_robots" name="txt_robots" value="<?php echo $posted["txt_robots"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Classifications *:</td>
          <td><input id="txt_classifications" name="txt_classifications" value="<?php echo $posted["txt_classifications"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td>Expires *:</td>
          <td><input id="txt_expires" name="txt_expires" value="<?php echo $posted["txt_expires"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Google Site Verification *:</td>
          <td><input id="txt_google_site" name="txt_google_site" value="<?php echo $posted["txt_google_site"];?>" type="text" size="50" />
          
          </td>
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