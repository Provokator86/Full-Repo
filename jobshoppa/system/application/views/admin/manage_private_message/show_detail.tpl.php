<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For private message detail
* 
* @package Content Management
* @subpackage Manage_private_message
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_private_message/
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
          <th align="left"><strong>Job Title:</strong></th>
          <th align="left"><?php echo $info["s_job_title"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
        <tr>
          <td valign="top"><strong>Message:</strong></td>
          <td colspan="3"><?php echo $info["s_message"];?></td>
        </tr> 
		
		<tr>
          <td valign="top"><strong>Sender:</strong></td>
          <td colspan="3"><?php echo $info["s_sender_user"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Receiver:</strong></td>
          <td colspan="3"><?php echo $info["s_receiver_user"];?></td>
        </tr> 
		   
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_status"];?></td>
          <td><strong>Posted on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td>
        </tr>  
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>