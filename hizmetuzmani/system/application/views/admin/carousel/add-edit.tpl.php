<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 07 June 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For carousel images Add & Edit
* 
* @package Content Management
* @subpackage carousel
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/carousel/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>

	
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
    

    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 
   
	if($.trim($("#txt_image_name").val())=="" && $.trim($("#h_image_name").val())=="") 
    {
        s_err +='Please browse photo.<br />';
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
          <td>Tab Name *:</td>
          <td><input id="txt_banner_title" name="txt_banner_title" value="<?php echo $posted["txt_banner_title"];?>" readonly="readonly" type="text" size="30" /></td>
          <td>&nbsp;</td>
        </tr>      
        <tr>
          <td>Photo *:</td>
          <td>
		  	<?php  
				if(!empty($posted["txt_image_name"]))
				{
					echo '<img src="'.$thumbDir.'thumb_'.$posted["txt_image_name"].'" width="50" height="50"  border="0"/><br><br>';
					echo ' <input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted["txt_image_name"].'" />';
				}
			
			?>
		  	<input id="txt_image_name" name="txt_image_name" type="file" size="30" /> <br />
		  	</td>
          <td>&nbsp;</td>
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