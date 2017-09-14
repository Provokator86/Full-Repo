<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage food dining store
* @package Food & Dining
* @subpackage Manage Store
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_store/
*/
?>

<?php

    /////////Javascript For add edit //////////

?>
<?php /*?><script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script><?php */?>
<script language="javascript">

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
		   //check_duplicate();	
	   }); 
	
	});  
		
	
	///////////Submitting the form/////////
	
	$("#frm_add_edit").submit(function(){
		var b_valid=true;
		var s_err="";
		var reg_address   = /^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)/;
		var website_add   = $("#s_store_url").val();
		$("#div_err").hide("slow");     
	
		if($.trim($("#s_store_title").val())=="") 
		{
			s_err +='Please provide store name.<br />';
			b_valid=false;
		}
		/*if($.trim($("#s_store_url").val())=="") 
		{
			s_err +='Please provide url.<br />';
			b_valid=false;
		}
		if(website_add!="" && reg_address.test(website_add) == false)
		{
			s_err +='Please provide proper url.<br />';
			b_valid=false;
		}
		if($.trim($("#s_about_us").val())=="") 
		{
			s_err +='Please provide About store.<br />';
			b_valid=false;
		}
		if($.trim($("#s_store_logo").val())=="" && $.trim($("#h_s_image").val())=="") 
		{
			s_err += 'Please provide image.<br />';
			b_valid = false;
		}*/
		/*if($.trim($("#s_store_banner").val())=="" && $.trim($("#h_s_image_banner").val())=="") 
		{
			s_err += 'Please provide store banner.<br />';
			b_valid = false;
		}  
		if($.trim($("#i_affiliates_id").val())=="") 
		{
			s_err +='Please select affiliates.<br />';
			b_valid=false;
		} */ 
	
		/////////validating//////
		if(!b_valid)
		{
			$.unblockUI();  
			$("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
		}
		return b_valid;
	
	});    
	
	///////////end Submitting the form/////////    
	
		
	
});    

</script>    

<?php

    ///////// End Javascript For add edit //////////

?>

<div id="right_panel">

<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo $posted["s_store_logo"];?>"> 

    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error"); 
              echo validation_errors();
			  //pr($posted);
            ?>
        </div>   
    <?php //pr($posted);?>
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
          <td>Store Title *:</td>
          <td><input id="s_store_title" name="s_store_title" value="<?php echo $posted["s_store_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>         

        <tr>
          <td>Store Logo  :</td>
          	<td>
			<?php
			if($posted["s_store_logo"] !="")
			{
			?>

			<span id="user_image">
				<img src="uploaded/store/thumb/thumb_<?php echo $posted["s_store_logo"];?>" /><br/>
				<input id="h_s_image" name="h_s_image"  type="hidden" value="<?php echo $posted["s_store_logo"];?>" />
			</span>
			<?php }?>

			<input id="s_store_logo" name="s_store_logo"  type="file" />For best view resolution should be 200 px * 200 px</td>

          	<td>&nbsp;</td>
        </tr>

       
       <?php /*?> <tr>
          <td>Store Banner  :</td>
          	<td>
			<?php
			if($posted["s_store_banner"] !="")
			{
			?>
			<span id="user_image">
				<img src="uploaded/store/thumb/thumb_<?php echo $posted["s_store_banner"];?>" /><br/>
				<input id="h_s_image_banner" name="h_s_image_banner"  type="hidden" value="<?php echo $posted["s_store_banner"];?>" />
			</span>
			<?php }?>
			<input id="s_store_banner" name="s_store_banner"  type="file" />For best view resolution should be 350 px * 350 px</td>

          	<td>&nbsp;</td>
        </tr>
        

         <tr>
          <td>About store :</td>
          <td><textarea name="s_about_us" id="s_about_us" cols="50" rows="4"><?php echo $posted['s_about_us']?></textarea></td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td>Cash Back Amount:</td>
          <td><input id="s_cash_back" name="s_cash_back" value="<?php echo $posted["s_cash_back"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td valign="top">Cash Back Details:</td>
          <td>
          	<textarea id="s_cash_back_details" name="s_cash_back_details" cols="80" rows="10" class="mceEditor"><?php echo $posted["s_cash_back_details"];?></textarea></td>
          <td>&nbsp;</td>
        </tr><?php */?>

        <tr>
          <td>Store URL[Deeplink Url] :</td>
          <td><textarea name="s_store_url" id="s_store_url" cols="50" rows="4"><?php echo $posted['s_store_url']?></textarea></td>
          <td>&nbsp;</td>
        </tr>                   

         <?php /*?><tr>
          <td>Store Address :</td>
          <td><textarea name="s_address" id="s_address" cols="50" rows="4"><?php echo $posted['s_address']?></textarea></td>
          <td>&nbsp;</td>
        </tr>         

        <tr>
          <td>Category:</td>
          <td><select name="i_cat_id" id="i_cat_id">
		  <option value="">Select</option>
		  <?php echo makeOptionNoEncrypt($category,$posted['i_cat_id']);?>
		  </select></td>
          <td>&nbsp;</td>
        </tr>       

		<tr>
          <td>Affiliates :</td>
          <td>
		  <select name="i_affiliates_id" id="i_affiliates_id">
		  <option value="">Select</option>
		  <?php echo makeOptionAffiliates($posted['i_affiliates_id']);?>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr><?php */?>

		

        <tr>
          <td>Status:</td>
          <td><select name="i_is_active" id="i_is_active">
          <option value="1" <?php if($posted['i_is_active'] == '1') {echo 'selected="selected"';}?>>Active</option>
          <option value="0" <?php if($posted['i_is_active'] == '0') {echo 'selected="selected"';}?>>Inactive</option>
          </select></td>
          <td>&nbsp;</td>
        </tr>

         <?php /*?><tr>
          <td>Meta Title :</td>
          <td><input id="s_meta_title" name="s_meta_title" value="<?php echo $posted["s_meta_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Meta Description :</td>
          <td>
          <textarea rows="5" cols="45" name="s_meta_description" id="s_meta_description"><?php echo $posted["s_meta_description"];?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td>Meta Keyword :</td>
          <td><input id="s_meta_keyword" name="s_meta_keyword" value="<?php echo $posted["s_meta_keyword"];?>" type="text" size="50" /></td>
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