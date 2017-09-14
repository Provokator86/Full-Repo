 <?php
    /////////Javascript For List View//////////
?>
<script language="javascript" type="text/javascript" src="<?php echo base_url()?>js/jquery/ui/alphanumeric/jquery.alphanumeric.pack.js"></script>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
/* start of allow selective charecter to text input fields */
$('#txt_user_type').alpha({allow:" .'\""});
/* end of allow selective charecter to text input fields */


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
       check_duplicate();
       //$("#frm_add_edit").submit();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_user_type");
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
                      $('<div id="err_msg" class="star_err1">Duplicate user type name exists.</div>')
                      .insertAfter("#txt_user_type");
                      
                  }
                  else
                  {
                      /*$('<div id="err_msg" class="star_succ1">You can choose this user type name.</div>')
                      .insertAfter("#txt_user_type");  */   
                      $("#frm_add_edit").submit();                 
                  }
                });
    }
    else
    {
         $("#frm_add_edit").submit();  
    }
    

}
//////////end Checking Duplicate///////// 
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
	$(".star_err1").remove();
    if($.trim($("#txt_user_type").val())=="") 
    {
        s_err='Please provide user type name.';
		$('<div class="star_err1">'+s_err+'</div>').insertAfter("#txt_user_type");
        b_valid=false;
    }
    
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
       // $("#div_err").html(s_err).show("slow");
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
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>     
    
    
    <div class="left"><input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="50%" align="left" colspan="2"><h4>User Type Information</h4></th>
          
          <th width="15%">&nbsp;</th>
          <th width="35%">&nbsp;</th>
        </tr>
        <tr>
          <td valign="top">Name <span class="star">*</span>:</td>
          <td><input name="txt_user_type" type="text" id="txt_user_type" value="<?php echo $posted["txt_user_type"];?>" size="50" maxlength="250" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
    <div class="left"><input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/></div>
    
</form>
</div>