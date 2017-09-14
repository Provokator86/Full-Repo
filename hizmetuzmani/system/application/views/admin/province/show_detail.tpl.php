<?php
/*********
* Author: Koushik Rout
* Date  : 26 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For province detail
* 
* @package General
* @subpackage province
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/province/
*/

    /////////Css For Popup View//////////
    echo $css;
?>

<?php
    /////////Javascript For Popup View//////////
    echo $js;
?>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
})});    
</script>    

<div>
<form id="frm_add_edit" name="frm_add_edit" method="post" action="">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $info["id"];?>"> 
    <p>&nbsp;</p>
    <div id="div_err">
        <?php
          show_msg();  
        ?>
    </div>     
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
       
		<tr>
          <th align="left"><strong>Name:</strong></th>
          <th align="left"><?php echo $info["s_province"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <th align="left"><strong>City Name:</strong></th>
          <th align="left"><?php echo $info["s_city"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
      <?php /*?>  <tr>
          <td valign="top"><strong>Abbreviation:</strong></td>
          <td colspan="3"><?php echo $info["s_abbreviation"];?></td>
        </tr>   <?php */?>
		     
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_is_active"];?></td>
         <?php /*?> <td><strong>Created on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td><?php */?>
        </tr> 
		 
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>