<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage food dining offer
* @package Food & Dining
* @subpackage Manage Offer
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_offer/
*/

?>

<?php

    /////////Javascript For add edit //////////

?>

<script language="javascript" type="text/javascript">

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
		$("#div_err").hide("slow"); 
		if($.trim($("#s_offer").val())=="") 
		{
			s_err +='Please provide offer name.<br />';
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

    

});    

</script>    

<?php

    ///////// End Javascript For add edit //////////

?>

<div id="right_panel">

<form id="frm_add_edit" name="frm_add_edit" method="post" action="">

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

          <td>Offer Name *:</td>

          <td><input id="s_offer" name="s_offer" value="<?php echo $posted["s_offer"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>          

        <tr>

          <td>Active:</td>

          <td><input id="i_is_active" name="i_is_active" value="1" <?php if($posted["i_is_active"]==1) { echo 'checked="checked"';}?>  type="checkbox" /></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

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