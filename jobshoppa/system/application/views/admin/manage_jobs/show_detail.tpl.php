<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 9 june 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For news detail
* 
* @package Content Management
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/news/
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
          <th align="left"><strong>Title:</strong></th>
          <th align="left"><?php echo $info["s_title"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
          
        <tr>
          <td valign="top"><strong>Description:</strong></td>
          <td colspan="3"><?php echo $info["s_description"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Expired On:</strong></td>
          <td colspan="3"><?php echo $info["dt_expired_on"];?></td>
        </tr>
		<tr>
          <td valign="top"><strong>Buyer Name:</strong></td>
          <td colspan="3"><?php echo $info["s_buyer_name"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Category Name:</strong></td>
          <td colspan="3"><?php echo $info["s_category_name"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Budget Price:</strong></td>
          <td colspan="3"><?php echo $info["d_budget_price"];?></td>
        </tr> 
		<tr>
          <td valign="top"><strong>Quoting Period days:</strong></td>
          <td colspan="3"><?php echo $info["i_quoting_period_days"];?></td>
        </tr>
		<tr>
          <td valign="top"><strong>Keyword:</strong></td>
          <td colspan="3"><?php echo $info["s_keyword"];?></td>
        </tr>
		   
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_is_active"];?></td>
          <td><strong>Posted on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td>
        </tr>  
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>