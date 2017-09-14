<?php
/*********
* Author: Koushik Rout
* Date  : 17 Nov 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For customer_support detail
* 
* @package Content Management
* @subpackage  customer_support
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/customer_support/
*/

    /////////Css For Popup View//////////
    echo $css;
?>

<?php
    /////////Javascript For Popup View//////////
    echo $js;
?>
<script type="text/javascript" src="<?=base_url()?>js/flowplayer-3.2.6.min.js"></script>
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
          <th align="left"><strong>Question:</strong></th>
          <th align="left"><?php echo $info["s_question"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
        <tr>
          <td valign="top"><strong>Answer:</strong></td>
          <td colspan="3"><?php echo $info["s_answer"];?></td>
        </tr> 

        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_is_active"];?></td>
          <td><strong>Created on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td>
        </tr>  
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>