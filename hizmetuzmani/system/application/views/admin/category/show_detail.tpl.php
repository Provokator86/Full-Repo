<?php
 /*********
* Author: Koushik rout
* Date  :  29 March 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Show detail Category 
* 
* @package General
* @subpackage Category 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/category_model.php
* @link controler/admin/Category.php
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
          <th align="left"><strong>Category Name:</strong></th>
          <th align="left"><?php echo $info["s_category_name"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
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