<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 27 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* add edit For Cashback Matrix 
* @package Content Management
* @subpackage content
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/content/
*/

?>

<?php
    /////////Javascript For List View//////////
?>
<script language="javascript">
var g_controller="<?php echo $pathtoclass;?>";//controller Path 

jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
	$(document).ready(function(){
		var g_controller="<?php echo $pathtoclass;?>";//controller Path 
		
		$('input[id^="btn_cancel"]').each(function(i){
		   $(this).click(function(){
			   $.blockUI({ message: 'Just a moment please...' });
			   window.location.href=g_controller+"modify_information";
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
			/////////validating//////	
			if(!b_valid)	
			{	
				$.unblockUI();  	
				$("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");	
			}	
			return b_valid;	
		}); 
		
		///////////end Submitting the form/////////   				
	
	})
});    

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
<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $mode;?>">
<?php /*?><input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"><?php */?> 
    <h2><?php echo $heading;?></h2>

	<div class="info_box">From here Admin can set cashback matrix for category.</div>
	<div class="clr"></div>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              //show_msg("error");  
			  show_msg();  
              echo validation_errors();
			  //pr($posted);
            ?>
        </div>       

    <div class="left"></div>

    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th colspan="6" align="left"><h4><?php echo $heading;?></h4></th>
        </tr>
		<tr>
			<th align="left" width="20%">Category</th>
			<th align="center" width="15%">0 - 499</th>
			<th align="center" width="15%">500 - 999</th>
			<th align="center" width="15%">1000 - 1499</th>
			<th align="center" width="15%">1500 - 1999</th>
			<th align="center" width="15%">2000 +</th>
		</tr>
		<?php if(!empty($info)) { 
			foreach($info as $key=>$val)
			{
		?>
		<tr>
			<td><?php echo $val["s_category"] ?>
			<input type="hidden" name="i_cat_id[]" id="i_cat_id_<?=$val["i_id"]?>" value="<?=$val["i_cat_id"]?>" />
			</td>
			<td align="center">
			<input id="0_499_<?=$val["i_id"]?>" name="0_499[]" value="<?php echo my_render($val["0-499"]);?>" type="text" size="15" />
			</td>
			<td align="center">
			<input id="500_999_<?=$val["i_id"]?>" name="500_999[]" value="<?php echo my_render($val["500-999"]);?>" type="text" size="15" />
			</td>
			<td align="center">
			<input id="1000_1499_<?=$val["i_id"]?>" name="1000_1499[]" value="<?php echo my_render($val["1000-1499"]);?>" type="text" size="15" />
			</td>
			<td align="center">
			<input id="1500_1999_<?=$val["i_id"]?>" name="1500_1999[]" value="<?php echo my_render($val["1500-1999"]);?>" type="text" size="15" />
			</td>
			<td align="center">
			<input id="2000_<?=$val["i_id"]?>" name="2000[]" value="<?php echo my_render($val["2000+"]);?>" type="text" size="15" />
			</td>
		</tr>
		<?php } } ?>
		
		

        
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