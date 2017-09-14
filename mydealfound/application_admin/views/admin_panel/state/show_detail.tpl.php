<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 18 Jan 2013
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For state detail
* 
* @package General
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
$(document).ready(function(){
    
});    
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
          <th align="left"><strong>State Name:</strong></th>
          <th align="left"><?php echo $info["s_state"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>
        <tr>
          <th align="left"><strong>Country Name:</strong></th>
          <th align="left"><?php echo $info["s_country"];?></th>
          <th>&nbsp;</th>
          <th>&nbsp;</th>
        </tr>  
		     
        <tr>
          <td><strong>Status:</strong></td>
          <td><?php echo $info["s_status"];?></td>
         <?php /*?> <td><strong>Created on:</strong></td>
          <td><?php echo $info["dt_created_on"];?></td><?php */?>
        </tr> 
		 
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>