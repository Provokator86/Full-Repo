<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 29 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For language Add & Edit
* 
* @package Content Management
* @subpackage language
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/language/
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
    var $this = $("#txt_language");
	var $lang_code = $("#txt_short_name");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val(),
				"h_code":$lang_code.val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate Language or Language code exists.</div>')
                      .insertAfter("#txt_language");
                      
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

   
	 if($.trim($("#txt_language").val())=="") 
    {
        s_err +='Please provide language.<br />';
        b_valid=false;
    }
     if($.trim($("#txt_short_name").val())=="") 
    {
        s_err +='Please provide language code.<br />';
        b_valid=false;
    }
	if($.trim($("#txt_flag_image").val())=="" && $.trim($("#h_image_name").val())=="") 
    {
        s_err +='Please browse flag image.<br />';
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
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
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
          <td>Lnaguage *:</td>
          <td><input id="txt_language" name="txt_language" value="<?php echo ($posted["txt_language"]);?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Lnaguage Code *:</td>
          <td><input id="txt_short_name" name="txt_short_name" value="<?php echo ($posted["txt_short_name"]);?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td> Flag Image *:</td>
          <td>
		  <?php  
			if(!empty($posted["txt_flag_image"]))
			{
				echo '<img src="'.base_url().'uploaded/language/'.$posted["txt_flag_image"].'"  border="0"/><br><br>';
				echo '<input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted["txt_flag_image"].'" />';
			}
			
			?>
            <input id="txt_flag_image" name="txt_flag_image" type="file" size="30" />
			
            </td>
			<td>&nbsp;</td>
        </tr>
		
		<?php /*?><tr>
          <td>Default:</td>
          <td><input id="i_default_select" name="i_default_select" value="1" <?php if($posted["i_default_select"]==0) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Active:</td>
          <td><input id="i_is_active" name="i_is_active" value="1" <?php if($posted["i_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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