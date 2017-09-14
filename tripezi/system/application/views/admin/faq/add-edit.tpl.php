<?php
/*********
* Author: Mrinmoy
* Email: koushik.r@acumensoft.info
* Date  : 01 Aug 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For faq Add & Edit
* 
* @package CMS
* @subpackage FAQ
* 
* @link InfController.php 
* @link My_Controller.php
* @Controller jobs.php
* @Model faq_model.php
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

// end of select checkbox at once

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       //$("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    


//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_question");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val(),
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate exists.</div>')
                      .insertAfter("#txt_question");
                      
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

	 if($.trim($("#txt_question").val())=="") 
		{
			s_err +='Please provide question.<br />';
			b_valid=false;
		}
		
	
	if((text = tinyMCE.get('ta_answer').getContent())=='') 
		{
			s_err +='Please provide answer .<br />';
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
	<div class="info_box">From here Admin can create new FAQ for the site.</div>
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
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>  
        </tr>
		<tr>
          <td width="22%">Question *:</td>
          <td width="73%">
		  <input id="txt_question" name="txt_question" value="<?php echo $posted["txt_question"];?>" type="text" size="80" />
		  </td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Answer *:</td>
          <td>
          <textarea name="ta_answer" id="ta_answer" cols="100" rows="20"><?php echo $posted["ta_answer"]; ?></textarea>
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