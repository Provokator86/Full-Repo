<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For manage buyers detail
* 
* @package Content Management
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_buyers/
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
          <th align="left"><?php echo $info["s_name"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
        <tr>
          <td valign="top"><strong>Email:</strong></td>
          <td colspan="3"><?php echo $info["s_email"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Contact No:</strong></td>
          <td ><?php echo $info["s_contact_no"];?></td>
		   <td valign="top"><strong>Yahoo Id:</strong></td>
          <td><?php echo $info["s_yahoo_id"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Skype Id:</strong></td>
          <td ><?php echo $info["s_skype_id"];?></td>
		   <td valign="top"><strong>MSN Id:</strong></td>
          <td><?php echo $info["s_msn_id"];?></td>
        </tr>
		
		<tr>
          <td valign="top"><strong>Address:</strong></td>
          <td ><?php echo $info["s_address"];?></td>
		   <td valign="top"><strong>City:</strong></td>
          <td ><?php echo $info["s_city"];?></td>
        </tr>  
		<tr>
          <td valign="top"><strong>State:</strong></td>
          <td ><?php echo $info["s_state"];?></td>
		   <td valign="top"><strong>Postal code:</strong></td>
          <td ><?php echo $info["s_zip"];?></td>
        </tr>
		<tr>
          <td valign="top"><strong>Total Job Post:</strong></td>
          <td ><?php echo $info["i_total_job_posted"];?></td>
		   <td valign="top"><strong>Total Job Awarded:</strong></td>
          <td ><?php echo $info["i_total_job_awarded"];?></td>
        </tr>
		<tr>
          <td valign="top"><strong>Feedback Rating:</strong></td>
          <td ><?php echo $info["i_feedback_rating"];?></td>
		   <td valign="top"><strong>Percentage Of Positive Feedback:</strong></td>
          <td ><?php echo $info["f_positive_feedback_percentage"];?></td>
        </tr>
		<tr>
          <td valign="top"><strong>Feedback Received:</strong></td>
          <td colspan="3"><?php echo $info["i_feedback_received"];?></td>
		  
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