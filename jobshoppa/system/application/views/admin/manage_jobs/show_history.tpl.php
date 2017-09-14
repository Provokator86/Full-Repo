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
				  <th align="left"><strong>History</strong></th>
				 
			</tr>
		 <?php
				  if($history_details)
				  {
					
					$i=1;
						foreach($history_details as $val)
						{
				  ?>
				  <tr>
					  <td align="left"><strong><?=$val['msg_string']?>	</strong></td>
				  </tr>
				
				<?php }
					
				 } 
				 else
					{
						?>
							 <tr>
								  <td align="left"><strong>No records found.</strong></td>
							  </tr>
						<?php
					}
				 ?>
          
        
      </table>
      </div>
    <? /*****end Modify Section*******/?>      
    </div>
</form>
</div>