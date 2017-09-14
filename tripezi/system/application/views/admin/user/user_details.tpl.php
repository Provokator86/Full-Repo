 <?php
/*********
* Author: Mrinmoy Mondal
* Date  : 04 July 2012
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For user detail
* 
* @package User
* @subpackage Manage User
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/user/
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

    <p>&nbsp;</p>
       
    <div style="float: left;   width: 200px; height: 200px;">
	<?php if($profile_image!='') { 
	echo '<img src="'.base_url().'uploaded/user/thumb/'.$profile_image.'_thumb.jpg'.'" alt="user" title="user" width="200px" height="200px">';
	 } else { ?>
      <img src="images/admin/no_image.jpg" alt="user" title="user" width="200px" height="200px">
	  <?php } ?>
    </div>
     <div style="float: right;   width: 460px; height: auto;">
        <h2 style="margin-top: -5px; margin-bottom: 5px;"><?php echo $info['s_first_name'].' '.$info['s_last_name'] ?></h2>
        <table>
			<tr>
				<td style="width:16px;">&nbsp;</td>
				<td style="width:85px;"><strong>Email :</strong></td><td><?php echo $info['s_email'] ?></td>
			</tr>
			<tr>
				<td valign="top"><?php if($info['i_phone_verified']==1) { ?>
				<img width="12" height="12" alt="Verified" title="Verified" src="images/admin/active.png">
				<?php } else { ?> &nbsp; <?php } ?></td>
				<td valign="top"><strong>Phone :</strong></td><td><?php echo $info['s_phone_number'] ?></td>
			</tr>
			<tr>
				<td valign="top"><?php if($info['i_facebook_verified']==1) { ?>
				<img width="12" height="12" alt="Verified" title="Verified" src="images/admin/active.png">
				<?php } else { ?> &nbsp; <?php } ?></td>
				<td valign="top"><strong>Facebook :</strong></td><td><?php echo $info['s_facebook_address'] ?></td>
			</tr>
			<tr>
				<td valign="top"><?php if($info['i_twitter_verified']==1) { ?>
				<img width="12" height="12" alt="Verified" title="Verified" src="images/admin/active.png">
				<?php } else { ?> &nbsp; <?php } ?></td>
				<td valign="top"><strong>Twitter :</strong></td><td><?php echo $info['s_twitter_address'] ?></td>
			</tr>
			<tr>
				<td valign="top"><?php if($info['i_linkedin_verified']==1) { ?>
				<img width="12" height="12" alt="Verified" title="Verified" src="images/admin/active.png">
				<?php } else { ?> &nbsp; <?php } ?></td>
				<td valign="top"><strong>LinkedIn :</strong></td><td><?php echo $info['s_linkedin_address'] ?></td>
			</tr>
            <tr>
                <td style="width:16px;">&nbsp;</td>
                <td style="width:85px;" valign="top"><strong>Address :</strong></td><td><?php echo $info['s_city'].','.$info['s_state'] ?>
                <br/>
                <?php echo $info['s_country']; ?><br/>
                <?php echo $info['s_address']; ?>
                </td>
            </tr>
			<tr>
				<td >&nbsp;</td>
				<td><strong>Joined On :</strong></td><td><?php echo $info['dt_created_on'] ?></td>
			</tr>
			<tr>
				<td >&nbsp;</td>
				<td><strong>Last Login :</strong></td><td><?php echo $info['dt_last_login'] ?></td>
			</tr>
            
            <tr>
                <td >&nbsp;</td>
                <td style="width:115px;"><strong>Paypal Details :</strong></td><td><?php echo $info['s_paypal_details'] ?></td>
            </tr>
        </table>

    </div>
    <div style="clear: both;"></div>
		<div> 
		 <strong>About User :</strong> <?php echo $info['s_about_me']; ?>
		 </div>
 </div>
   
