<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 09 June 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For automail detail
* 
* @package Content Management
* @subpackage automail
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/automail/
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
          <th align="left"><strong>Subject:</strong></th>
          <th align="left"><?php echo $info["s_subject"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
        <tr>
          <td valign="top"><strong>Content:</strong></td>
          <td colspan="3"><?php echo $info["s_content"];?></td>
        </tr>        
        <tr>         
          <td><strong>Created on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td>
		  <td><strong>Status:</strong></td>
          <td><?php echo $info["s_status"];?></td>
        </tr>  
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>