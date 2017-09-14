 <?php
/*********
* Author: Koushik Rout
* Date  : 26 April 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For province detail
* 
* @package General
* @subpackage province
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/province/
*/

    /////////Css For Popup View//////////
    echo $css;
?>

<?php
    /////////Javascript For Popup View//////////
    echo $js;
?>
<base href="<?php echo base_url(); ?>" />  
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
       
    <div style="float: left;   width: 200px; height: 200px;">
      <img src="images/admin/user_acc.jpg" alt="user" title="user" width="200px" height="200px">
    </div>
     <div style="float: right;   width: 360px; height: 210px;">
        <h2 style="margin-top: -5px; margin-bottom: 5px;">Robert Pattintion</h2>
        <table>
        <tr><td><strong>Email :</strong></td><td>robee.pattintion@gmail.com</td></tr>
        <tr><td><strong>Phone :</strong></td><td>+91-8756599932</td></tr>
        <tr><td><strong>Facebook :</strong></td><td>www.facebook/robee_patt</td></tr>
        <tr><td><strong>Twitter :</strong></td><td>www.twitter/robee_patt</td></tr>
        <tr><td><strong>LinkedIn :</strong></td><td>www.linkedin/robee_part</td></tr>
        <tr><td><strong>Joined On :</strong></td><td>22-06-2012</td></tr>
        </table>

    </div>
    <div style="clear: both;"></div>
    <div> 
     <strong>About User :</strong> Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages.
     </div>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>
