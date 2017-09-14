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
    $("#show_hide").click();
	$("#tabbar2 ul li a").click(function() {
		
		   $( '#tabbar2 ul li a').each(function(){
			 $('#tabbar2 ul li a').removeClass();
			 currentId = $(this).attr('id');
			 $('#div'+currentId).hide();
		   }); 
		   
		   $(this).addClass('select');
		   currentId = $(this).attr('id');
		   $('#div'+currentId).show();
		});
})});    
</script>    

<div id="right_panel">
    <h2><?php echo $info["s_title"];?></h2>
    <p>&nbsp;</p>
    
    	<div id="tabbar2">
        <ul>
          <li><a href="javascript:void(0)" class="select" id="1"><span>Verification Details</span></a></li>
        
        </ul>
      </div>
	  <div id="tabcontent">
		  <div id="div1">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width="15%" align="left"><h4>Details Information</h4></th>
				<th width="35%" align="left">&nbsp;</th>
				<th width="15%">&nbsp;</th>
				<th width="35%">&nbsp;</th>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Username:</td>
				<td><?php echo $info["s_username"];?></td>
				<td bgcolor="#f1f1f1">Professional Name:</td>
				<td><?php echo $info["s_name"];?></td>
				
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Email: </td>
				<td><?php echo $info["s_email"];?></td>
				<td bgcolor="#f1f1f1">Contact No.: </td>
				<td><?php echo $info["s_contact_no"];?></td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Verification Type: </td>
				<td><?php echo $info["s_verify_type"];?></td>
				<td bgcolor="#f1f1f1">Verification Status: </td>
				<td><?php echo $info["s_verify_status"];?></td>
			  </tr>
			  <tr>
				<td bgcolor="#f1f1f1">Request On: </td>
				<td><?php echo $info["dt_created_on"];?> </td>          
				<td bgcolor="#f1f1f1"></td>
				<td></td>
			  </tr>
			 
			</table>
		 
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<th width="15%" align="left"><h4>File(s)</h4></th>
				<th colspan="3"align="left">&nbsp;</th>
				
			  </tr>
			  <?php
			  
			   if(count($info['cred_files'])>0)
			  {
			  	$i=1;
			  		foreach($info['cred_files'] as $file)
					{
			  ?>
				  <tr>
					<td bgcolor="#f1f1f1"><?php echo 'File '.$i++;?></td>
					<td colspan="3"><a href="<?php echo base_url().'admin/verification_overview/download_cred_files/'.encrypt($file['s_file_name']);?>"><?php echo t('Download')?></a></td>
					
				  </tr>
				  <?php
				  	}
				}
				else
				{
					?>
					 <tr>
						<td colspan="4" bgcolor="#f1f1f1">No file attached.</td>
						
					  </tr>
					<?php
				}
				  
				  ?>
			
			</table>
			
		  </div>
		  
		  
	  </div>
  

  </div>