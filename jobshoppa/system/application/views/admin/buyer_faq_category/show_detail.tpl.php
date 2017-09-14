<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 9 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For state detail
* 
* @package Content Management
* @subpackage state
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/state/
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
          <th align="left"><strong>Category Name :</strong></th>
          <th align="left"><?php echo $info[0]["s_category_name"];?></th>
          <th align="left"></th>
          <th align="left"></th>
        </tr>
       
		<tr>
        
		  <td valign="top"><strong>Create Date :</strong></td>
          <td><?php echo $info[0]["dt_created_on"];?></td>
		    <td valign="top"></td>
          <td></td>
        </tr>   
		     
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info[0]["s_is_active"];?></td>
          <td></td>
          <td></td>
        </tr> 
		 
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>