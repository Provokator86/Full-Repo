<?php
/*********
* Author: Jagannath Samanta
* Date  : 07 july 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* View for add edit of content article
* 
* @package Content Artical Management
* @subpackage content article
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/content_article/
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
	
		if($.trim($("#opt_type_id").val())=="") 
		{
			s_err +='Please select content article type.<br />';
			b_valid=false;
		}
		if((text = tinyMCE.get('txt_content_article_title').getContent())=='') 
		{
			s_err +='Please provide content article title.<br />';
			b_valid=false;
		}
		if((text = tinyMCE.get('txt_content_short_description').getContent())=='') 
		{
			s_err +='Please provide short description .';
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
</script>    

<div id="right_panel">
	<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
		<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
		<h2><?php echo $heading;?></h2>
		<p>&nbsp;</p>
		<div id="div_err">
			<?php
				show_msg("error");  
				echo validation_errors();
			?>
		</div>     
		<div class="left"></div>
		<div class="add_edit">
		<? /*****Modify Section Starts*******/?>
		<div>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<th  align="left" colspan="3"><h4><?php echo $heading;?></h4></th>
					
				</tr>
				<tr>
					<td>Article Type *:</td>
					<td>
						<select name="opt_type_id" id="opt_type_id">
								<option value="">Select type </option>
								<?php  echo makeOptionContentType('i_parent_id=0', $posted["opt_type_id"])?>
						</select>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">Article Title *:</td>
					<td>
						<textarea name="txt_content_article_title" id="txt_content_article_title" cols="46" rows="4">
							<?php echo $posted["txt_content_article_title"];?>
						</textarea>
						<!--<input type="text" id="txt_content_article_title" name="txt_content_article_title" 
						value="<?php echo $posted["txt_content_article_title"];?>"  size="50"  /> -->
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">Short Description *:</td>
					<td>
					<textarea name="txt_content_short_description" id="txt_content_short_description" cols="46" rows="4">
						<?php echo $posted["txt_content_short_description"]; ?>
					</textarea>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td valign="top">Long Description :</td>
					<td>
					<textarea name="txt_content_long_description" id="txt_content_long_description" cols="46" rows="4">
						<?php echo $posted["txt_content_long_description"]; ?>
					</textarea>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td>Active:</td>
					<td>
						<input id="i_content_is_active" name="i_content_is_active" value="1" 
						<?php if($posted["i_content_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" />
					</td>
					<td>&nbsp;</td>
				</tr>
			</table>
		</div>
		<? /***** end Modify Section *******/?>      
		</div>
		<div class="left">
			<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
			<input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" 
			title="Click here to cancel saving information and return to previous page."/>
		</div>
	</form>
</div>