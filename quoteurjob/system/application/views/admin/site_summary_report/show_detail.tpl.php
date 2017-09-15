<?php
/*********
* Author: Jagannath Samanta
* Date  : 18 June 2011
* Modified By: Mrinmoy Mondal
* Modified Date: 12 Sep 2011
* 
* Purpose:
* View For event Add & Edit Testimonial
* 
* @package Content Management
* @subpackage testimonial
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/testimonial/
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
       window.location.href=g_controller;
   }); 
});      
    
    
    



    
})});

//$(#div_err).click(function(){$(this).hide();});


    
</script>    
 

<div id="right_panel">

    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>          
        </tr>  
		      
		<tr>
          <td>Total Number of Buyers:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Total Number of Tradesman: </td>
          <td></td>
          <td>&nbsp;</td>
        </tr> 
		
        <tr>
          <td>Total Buyers Signup:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td>Total Tradesman Signup:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td>Total Quotes have been placed:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td>Total Message have been posted:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td>Total Jobs have been Accepted by the Tradesman:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Total Payments have been made:</td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td><input type="button" name="btn_cancel" id="btn_cancel" value="Back" /></td>
          <td></td>
          <td>&nbsp;</td>
        </tr>
				
      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    <div class="left">

    </div>
    

</div>