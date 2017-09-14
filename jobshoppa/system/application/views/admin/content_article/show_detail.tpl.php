<?php
/*********
* Author: Jagannath Samanta
* Date  : 07 july 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
* View For content article in detail
* 
* @package Content Management
* @subpackage content
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/content_article/
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
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  	<tr>
          <td valign="top"><strong>Article Type:</strong> </td>
          <td colspan="3"><?php echo $info["s_content_type_name"];?></td>
        </tr>
        <tr>
          <th align="left" width="25%"><strong>Article Title:</strong></th>
          <th align="left" colspan="3"><?php echo $info["s_content_title"];?></th>
        </tr>
        <tr>
          <td valign="top"><strong>Short Description:</strong></td>
          <td colspan="3"><?php echo $info["s_content_short_description"];?></td>
        </tr>        
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_is_active"];?></td>
          <td><strong>Created on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td>
        </tr>  
      </table>
      </div> 
      </div>
</form>
</div>