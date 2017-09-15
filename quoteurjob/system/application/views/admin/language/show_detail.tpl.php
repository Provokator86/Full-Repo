<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 12 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For language detail
* 
* @package Content Management
* @subpackage language
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/language/
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
          <th align="left"><strong>Language:</strong></th>
          <th align="left"><?php echo $info["s_language"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
      <tr>
		  <th align="left" width="25%"><strong>Image:</strong></th>
		  <th align="left" >
		  <img src="<?=base_url()?>uploaded/language/<?=$info["s_flag_image"]?>"  border="0"/>
		  <?php //echo $info["s_flag_image"];?></th>
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