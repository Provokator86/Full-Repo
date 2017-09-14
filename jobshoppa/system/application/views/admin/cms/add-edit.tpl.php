<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 20 Aug 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  add edit For content 
* 
* @package Content Management
* @subpackage content
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/content/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>

<script type="text/javascript" src="js/jquery/colorpicker/js/colorpicker.js"></script>
<script type="text/javascript" src="js/jquery/colorpicker/js/eye.js"></script>
<script type="text/javascript" src="js/jquery/colorpicker/js/utils.js"></script>
<link rel="stylesheet" href="js/jquery/colorpicker/css/colorpicker.css" type="text/css" />


<script>
var g_controller="<?php echo $pathtoclass;?>";//controller Path 
</script>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"add_information";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
   }); 
});    
    
//////////Checking Duplicate/////////
/*$("#txt_user_type").blur(function(){
    $(this).next().remove("#err_msg");  
    if($(this).val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$(this).val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $("#txt_user_type").focus();
                      $('<div id="err_msg" class="error_massage">Duplicate user type name exists.</div>')
                      .insertAfter("#txt_user_type");
                  }
                  else
                  {
                      $('<div id="err_msg" class="success_massage">You can choose this user type name.</div>')
                      .insertAfter("#txt_user_type");                      
                  }
                });
    }

});   */
//////////end Checking Duplicate///////// 
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	if($.trim($("#opt_title").val())=="") 
		{
			s_err +='Please Select Type.<br />';
			b_valid=false;
		}
	
		
	
	if($.trim($("#txt_content_title").val())=="") 
		{
			s_err +='Please Provide Tilte.<br />';
			b_valid=false;
		}		
	if((text = tinyMCE.get('txt_content_description').getContent())=='') 
		{
			s_err +='Please provide Description .';
			b_valid=false;
		}	
   
	if(! $("input[name=i_content_is_active]:checkbox").is(":checkbox:checked"))
		{
			s_err +='Please activate this content.<br />';
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
    
	/* Color Picker**/
	
	$('#txt_color_code').ColorPicker({
				color: '#00abff',
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).css('backgroundColor', '#' + hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				},
				onChange: function (hsb, hex, rgb) {
				$('#txt_color_code').css('backgroundColor', '#' + hex);
				}
			})
			.bind('keyup', function(){
				$(this).ColorPickerSetColor(this.value);
			});
})});    

// Ajax call to get content

function call_ajax_to_get_content(ajaxURL,type_id)
{
	jQuery.noConflict();
	jQuery(function($){
	
		$.ajax({
				
				type:"POST",
				url:g_controller+ajaxURL,
				data: "type_id="+type_id,
				dataType:"json",
				success: function(msg){			
				
					if(msg!=null)
					{
						$("#txt_content_title").val(msg.s_title);						
						tinyMCE.get("txt_content_description").setContent(msg.s_description);
					}
					else
					{
						$("#txt_content_title").val('');						
						tinyMCE.get("txt_content_description").setContent('');
					}	
				
				}	
				
			});
	
		});
}


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
    <div class="info_box">From here Admin must select the page name  to enter the title and description of that particular page .</div>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              //show_msg("error");  
			  show_msg();  
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
          <td>Page *:</td>
          <td>
		  <select id="opt_title" name="opt_title" onchange='call_ajax_to_get_content("ajax_get_content",this.value);'>
		  	<option value="">Select</option>
			<?php  echo makeOptionContentType('', $posted["opt_title"])?>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr>
		

		
		<tr>
          <td>Title *:</td>
          <td><input type="text" name="txt_content_title" id="txt_content_title" value="<?php echo $posted["txt_content_title"];?>"  />
		  </td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td valign="top">Description *:</td>
          <td><!--<input id="txt_user_type" name="txt_user_type" value="<?php echo $posted["txt_content_description"];?>" type="text" size="50" />-->
          <textarea name="txt_content_description" id="txt_content_description" cols="40" rows="20"><?php echo $posted["txt_content_description"]; ?></textarea></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr style="display:none;">
          <td>Active *:</td>
          <td><input id="i_content_is_active" name="i_content_is_active" value="1" <?php if($posted["i_content_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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