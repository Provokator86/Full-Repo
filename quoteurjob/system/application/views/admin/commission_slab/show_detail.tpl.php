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
          <th align="left" width="25%"><strong>Person Name:</strong></th>
          <th align="left" colspan="3" ><?php echo $info["s_person_name"];?></th>
          
          
        </tr>
        <tr>
		  <th align="left" width="25%"><strong>Image:</strong></th>
          <th align="left" >
		  <img src="<?=base_url()?>uploaded/testimonial/thumb/thumb_<?=$info["s_person_image"]?>" height="50"  border="0"/>
		  <?php //echo $info["s_person_image"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr> 
        <tr>
          <td valign="top"><strong>Description:</strong></td>
          <td colspan="3"><?php echo $info["s_content"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Person Adderss:</strong></td>
          <td colspan="3"><?php echo $info["s_person_address"];?></td>
        </tr>
        <tr>
          <td valign="top"><strong>Phone:</strong></td>
          <td colspan="3"><?php echo $info["s_person_phone"];?></td>
        </tr>
        <tr>
          <td valign="top"><strong>Email:</strong></td>
          <td colspan="3"><?php echo $info["s_person_email"];?></td>
        </tr>       
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_is_active"];?></td>
          <td><strong>Created on:</strong></td>
          <td><?php echo $info["dt_entry_date"];?></td>
        </tr>  
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>