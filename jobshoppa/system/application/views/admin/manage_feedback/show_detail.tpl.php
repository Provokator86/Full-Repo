<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For feedback detail
* 
* @package Content Management
* @subpackage feedback
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/feedback/
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
          <td valign="top"><strong>Feedback By:</strong></td>
          <td colspan="3"><?php echo $info["s_sender_user"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Feedback To:</strong></td>
          <td colspan="3"><?php echo $info["s_receiver_user"];?></td>
        </tr> 
          
        <tr>
          <td valign="top"><strong>Feedback:</strong></td>
          <td colspan="3"><?php echo $info["s_comments"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Rating:</strong></td>
          <td colspan="3"><?php echo $info["i_rating"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Feedback Type:</strong></td>
          <td colspan="3"><?php echo $info["s_positive"];?></td>
        </tr>        
        <tr>
          
          <td><strong>Created on:</strong></td>
          <td colspan="3"><?php echo $info["dt_created_on"];?></td>
        </tr>  
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>