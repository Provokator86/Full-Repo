<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 31 March 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For Job History detail
* 
* @package jobs
* @subpackage news
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_jobs/
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

$('.description tr').filter(':odd').css('background','#f2f2f2');

  $('#admin_popup').tinyscrollbar({ sizethumb: 80 });      
})});    
</script>    

<div>


    <p class="heading_here">&nbsp;</p>
    <div id="div_err">
        <?php
          show_msg();  
        ?>
    </div> 
           
<div class="add_edit">
    <? /*****end of listing*******/?>
     <div id="admin_popup">
        <div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
        <div class="viewport">
             <div class="overview">
    <div class="description">
      <table width="490px" border="0" cellspacing="0" cellpadding="0">
       
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
					  <td align="left"><strong><?php echo $val['msg_string']?>	</strong></td>
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
    <? /*****end of listing*******/?>  
            </div>
        </div>
    </div> 
    <!--END OF SCROLLBAR  -->     
</div>
           
</div>