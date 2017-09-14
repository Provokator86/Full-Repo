<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 19 Jan 2013
* Modified By: 
* Modified Date:
* Purpose:
*  View For book category Add & Edit
* @package General
* @subpackage book category
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/book_category/
*/
?>
<?php
    /////////Javascript For add edit //////////
?>
<script language="javascript" type="text/javascript" src="js/admin/ajaxupload.3.5.js"></script>
<link rel="stylesheet" href="css/admin/ajaxupload_style.css" />

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
    
//////////Checking Duplicate/////////

    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
	var reg_address   = /^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)/;
	var website_add   = $("#s_url").val();
    $("#div_err").hide("slow"); 
    

	if($.trim($("#s_url").val())=="") 
	{
		s_err +='Please provide url.<br />';
		b_valid=false;
	}
	
	if(website_add!="" && reg_address.test(website_add) == false)
	{
		s_err +='Please provide proper url.<br />';
		b_valid=false;
	}
	
	if($.trim($("#s_image").val())=="" && $.trim($("#h_s_image").val())=="") 
	{
		s_err += 'Please provide image.<br />';
		b_valid = false;
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
 
});   







 
</script>    
<?php
    ///////// End Javascript For add edit //////////
?>
<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
<input type="hidden" id="IMAGE_ALREADY_UPLOADED" name="IMAGE_ALREADY_UPLOADED" value="<?php echo $IMAGE_ALREADY_UPLOADED;?>"  />
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg();  
              echo validation_errors();
			/*  pr($posted);*/
            ?>
        </div>     
    
    <?php //pr($posted);?>
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <?php // pr($posted);echo $mode;?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
          
        </tr>        
		
        <tr>
						<td>Banner Url * :</td>
						<td><input id="s_url" name="s_url" value="<?php echo my_showtext($posted["s_url"]); ?>"  type="text" size="50" autocomplete="off" /></td>
						<td>&nbsp;</td>
				</tr>
        
        <!--=============Image upload start====================-->	
				<tr>
          <td>Banner Image * :<span style="color:red; font-family:Arial, Helvetica, sans-serif"><b>(Please upload images of minimum dimension 650 * 400 for best view)</b></span></td>
          	<td>
			<?php
			if($posted["s_image"] !="")
			{
			?>
			<span id="user_image">
				<img src="uploaded/home_banner_add/main_thumb/thumb_<?php echo $posted["s_image"];?>" /><br />
				<input id="h_s_image" name="h_s_image"  type="hidden" value="<?php echo $posted["s_image"];?>" />
			</span>
			<?php }?>
			<input id="s_image" name="s_image"  type="file" /></td>
          	<td>&nbsp;</td>
        </tr>
				
				
			<!--=============Image upload end====================-->	
        
        <?php //echo $posted["i_is_active"];?>
       <tr>
						<td>Is Active :</td>
						<td><input id="i_is_active" name="i_is_active" value="1" type="checkbox" <?php if($mode==add) {?>checked="checked" <?php } echo $posted["i_is_active"]==1?'checked="checked"':'' ?> size="34" maxlength="12" style="border: 1px solid #A7A7A7;" /> &nbsp;</td>
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