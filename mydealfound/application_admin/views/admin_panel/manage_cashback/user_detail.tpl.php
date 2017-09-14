<?php
/*********
* Author: MM
* Date  : 09 Apr 2014
* Modified By: 
* Modified Date:
* Purpose:
*  View For user detail
* @package Cashback
* @subpackage manage cashback user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_cashback/
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
	
	})
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
          <td align="left"><strong>Name:</strong></td>
          <td align="left"><?php echo $info["s_name"];?></td>
          <td align="left"><strong>Email:</strong></td>
          <td align="left"><?php echo $info["s_email"];?></td>
        </tr>
		
		<tr> 
          <td><strong>Uid:</strong></td>
          <td><?php echo $info["s_uid"];?></td>
		  <td><strong>Referrer:</strong></td>
          <td><?php echo $info["s_referrer_id"];?></td>
        </tr>

        <tr> 
          <td><strong>Created on:</strong></td>
          <td><?php echo date("Y-m-d",strtotime($info["t_timestamp"]));?></td>
		  <td><strong>Status:</strong></td>
          <td><?php echo $info["i_active"]==1?"Active":"Inactive";?></td>
        </tr>  
		
		<tr> 
          <td><strong>Bank Account Holder:</strong></td>
          <td><?php echo $info["s_neft_name"];?></td>
		  <td><strong>Bank name:</strong></td>
          <td><?php echo $info["s_neft_bank_name"];?></td>
        </tr>
		
		<tr> 
          <td><strong>Bank Branch:</strong></td>
          <td><?php echo $info["s_neft_branch_name"];?></td>
		  <td><strong>Account number:</strong></td>
          <td><?php echo $info["s_neft_account"];?></td>
        </tr>
		<tr> 
          <td><strong>IFSC Code :</strong></td>
          <td><?php echo $info["s_neft_ifsc"];?></td>
		  <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
		
		<tr> 
          <td><strong>Full Name on Address:</strong></td>
          <td><?php echo $info["s_cheque_name"];?></td>
		  <td><strong>Full Address:</strong></td>
          <td><?php echo $info["s_address"];?></td>
        </tr>
		
		<tr> 
          <td><strong>City:</strong></td>
          <td><?php echo $info["s_city"];?></td>
		  <td><strong>State :</strong></td>
          <td><?php echo $info["s_state"];?></td>
        </tr>
		<tr> 
          <td><strong>Postal Code :</strong></td>
          <td><?php echo $info["s_postal_code"];?></td>
          <td><strong>Contact Number :</strong></td>
          <td><?php echo $info["s_contact_number"];?></td>
        </tr>

      </table>

      </div>

    <? /*****end Modify Section*******/?>      

    </div>

</form>

</div>