<?php

 /********** 
Author: 
* Date  : 13 May 2014
* Modified By: 
* Modified Date: 
* 
* Purpose:
* Controller For Manage Payment Report
* 
* @package Content Management
* @subpackage State
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/payment_report/
*/
?>
 <?php
    /////////Javascript For List View//////////
?>

<script language="javascript">

jQuery(function($) {

	jQuery(document).ready(function(){
	
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
			   		$("#frm_import").attr("action","<?php echo $search_action;?>");
					$("#frm_import").submit();
				}); 	
		});    
		
		///////////Submitting the form/////////
		
		$("#frm_add_edit").submit(function(){
			
			var b_valid=true;	
			var s_err="";	
			$("#div_err").hide("slow");
			//b_valid=false; 	
			if($.trim($("#s_description").val())=="") 	
			{	
				s_err +='Please provide description.<br />';	
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
	
	})
});    

</script>    

 

<?php /////////end Javascript For List View//////////   ?> 



<div id="right_panel">

<form id="frm_import" name="frm_import" method="post" action="" enctype="multipart/form-data">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
            ?>
        </div>   
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>

    <div class="add_edit">

    <?php /*****Modify Section Starts*******/?>

    <div>

      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
        </tr> 		

		<tr>		
			<td valign="top">CSV File * :</td>		
			<td>
			<input type="file" name="s_file" id="s_file">   
			</td>		
			<td>&nbsp;</td>		
		</tr>
      </table>

      </div>

    <?php /***** end Modify Section *******/?>      

    </div>

    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>   

</form>
</div>