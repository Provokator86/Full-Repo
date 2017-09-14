<?php

/*********
* Author: Mrinmoy
* Date  : 05 Mar 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage affiliates
* @package Master settting
* @subpackage Manage Affiliates
* @link InfController.php 
* @link My_Controller.php
* @link model/affiliates_model.php
* @link views/admin/manage_affiliates/
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

})

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

          <th align="left"><strong>Affiliate:</strong></th>

          <th align="left"><?php echo $info["s_name"];?></th>

          <th>&nbsp;</th>

          <th>&nbsp;</th>

        </tr>
		
		<tr>

          <th align="left"><strong>Link:</strong></th>

          <th align="left"><?php echo $info["s_link"];?></th>

          <th>&nbsp;</th>

          <th>&nbsp;</th>

        </tr>

        <tr>

          <td><strong>Status:</strong></td>

          <td><?php echo $info["s_status"];?></td>

		  <td>&nbsp;</td>

		  <td>&nbsp;</td>

         <?php /*?> <td><strong>Created on:</strong></td>

          <td><?php echo $info["dt_created_on"];?></td><?php */?>

        </tr> 

		 

      </table>

      </div>

    <? /*****end Modify Section*******/?>      

    </div>

</form>

</div>