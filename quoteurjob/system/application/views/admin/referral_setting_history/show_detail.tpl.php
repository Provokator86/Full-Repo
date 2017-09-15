<?php
/*********
* Author: Jagannath Samanta
* Date  : 18 June 2011
* Modified By: 
* Modified Date: 
* 
* Purpose:
* view For testimonial Details Showing
* 
* @package Content Management
* @subpackage testimonial
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/testimonial/
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
          <th align="left" width="50%"><strong>Commission Slab:</strong></th>
          <td align="left" colspan="3" ><?php echo $info["i_waiver_commission"];?></td>
        </tr> 
		<tr>
          <td valign="top" width="50%"><strong>Status:</strong></td>
          <td colspan="3"><?php echo $info["s_is_active"];?></td>
        </tr>
        <tr>
          <td valign="top" width="50%"><strong>Created on</strong></td>
          <td colspan="3"><?php echo $info["dt_created_on"];?></td>
        </tr>
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>