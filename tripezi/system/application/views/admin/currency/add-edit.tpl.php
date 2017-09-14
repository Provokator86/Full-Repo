<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For currency Add & Edit
* 
* @package General
* @subpackage currency rate
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/currency/
*/

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
       //$("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_currency_code");
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
                      $('<div id="err_msg" class="star_err1">Duplicate currency code exists.</div>')
                      .insertAfter("#txt_currency_code");
                      
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
	//var pattern = /^[a-zA-Z]+/;
	var pattern = /^\+?[0-9]*\.?[0-9]+$/;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	if($.trim($("#txt_currency_code").val())=="")
	{
		s_err +='Please provide currency code.<br />';
        b_valid=false;
	}
	if($.trim($("#d_currency_rate").val())=="")
	{
		s_err +='Please provide currency rate.<br />';
        b_valid=false;
	}
	else if(!pattern.test($("#d_currency_rate").val()))	
	{
		s_err +='Please provide proper rate.<br />';
		b_valid=false;
	}
	if($.trim($("#txt_currency_symbol").val())=="")
	{
		s_err +='Please provide currency code.<br />';
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
	<div class="info_box">From here Admin can edit the curreny rate for different currencies (except USD) with respect to USD as USD has been set default currency .</div>
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
   
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
          
        </tr>             
		
		<tr>
          <td>Currency Code *:</td>
          <td><input id="txt_currency_code" name="txt_currency_code" value="<?php echo $posted["txt_currency_code"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		
		<tr>
          <td>Currency Rate *:</td>
          <td>
		  <input id="d_currency_rate" name="d_currency_rate" value="<?php echo $posted["d_currency_rate"];?>" <?php echo ($posted['i_default']==1)?"readonly='readonly'":"" ?> type="text" size="50" />
		  </td>
          <td>&nbsp;</td>
        </tr>		
      
	   
	   <tr>
          <td>Currency symbol *:</td>
          <td><input id="txt_currency_symbol" name="txt_currency_symbol" value="<?php echo $posted["txt_currency_symbol"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
	   
      </table>
      </div>
    
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
    
</form>
</div>