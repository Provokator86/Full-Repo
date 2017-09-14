<div id="top-content">
			<noscript> <!-- Show a notification if the user has disabled javascript -->
				<div class="notification error png_bg">
					<div>
						Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
					</div>
				</div>
			</noscript>
			
			<!-- Page Head -->
			<div>
            	<div id="logo"><img src="resources/images/logo.png" alt="" width="300" height="48" /></div>
                <div id="heading">Back Office <br />Administrator</div>
          	</div>
			<br clear="all" />
		  <ul class="shortcut-buttons-set"> <!-- Replace the icons URL's with your own -->
		  <?php if($_SESSION['user_roll']==1){ 	?>
				
				<li><a class="shortcut-button" href="manage_user.php"><span><img src="resources/images/users.png" alt="icon" style="margin-bottom:10px;" /><br />
      Manage user</span></a></li>
				
   		<li><a class="shortcut-button" href="pending_leave_admin.php"><span><img src="resources/images/pendingicon.jpg" alt="icon" style="margin-bottom:3px;" /><br />
	  Pending Leave</span></a></li>
				
	  <li><a class="shortcut-button" href="leave_history_admin.php"><span><img src="resources/images/icon-list.png" alt="icon" style="margin-bottom:13px;" /><br />
      Leave History</span></a></li>
				
	  <li><a class="shortcut-button" href="holiday_list.php"><span><img src="resources/images/Holidays.png" alt="icon" style="margin-bottom:4px;" /><br />
      Holiday List</span></a></li>
				
	  <li><a class="shortcut-button" href="manage_dept.php" ><span><img src="resources/images/icon_05.gif" alt="icon" style="margin-bottom:13px;" /><br />
      Manage Department</span></a></li>
                
      <li><a class="shortcut-button" href="manage_role.php" ><span><img src="resources/images/icon_role.png" alt="icon" style="margin-bottom:13px;" /><br />
      Manage Role</span></a></li>
	  
	  <?php } if($_SESSION['user_roll']==2){  ?>
      
      <li><a class="shortcut-button" href="pending_leave.php" ><span><img src="resources/images/pendingicon.jpg" alt="icon" style="margin-bottom:3px;" /><br />
      Pending Leave</span></a></li>
	  
	  <li><a class="shortcut-button" href="leave_history_manager.php"><span><img src="resources/images/icon-list.png" alt="icon" style="margin-bottom:13px;" /><br />
      Leave History</span></a></li>
	  
	  <li><a class="shortcut-button" href="apply_leave_manager.php"><span><img src="resources/images/apply-icon.gif" alt="icon" style="margin-bottom:13px;" /><br />
      Apply Leave</span></a></li>
	  
	  <li><a class="shortcut-button" href="application_status_manager.php"><span><img src="resources/images/status_icon.jpg" alt="icon" style="margin-bottom:3px;" /><br />
	  Application Status</span></a></li>
	  
	  <li><a class="shortcut-button" href="holiday_list_all.php" ><span><img src="resources/images/Holidays.png" alt="icon" style="margin-bottom:13px;" /><br />
      Holiday List</span></a></li>
	  <?php } if($_SESSION['user_roll']==3){  ?>
	  <li><a class="shortcut-button" href="apply_leave.php"><span><img src="resources/images/apply-icon.gif" alt="icon" style="margin-bottom:10px;" /><br />
      Apply Leave</span></a></li>
	  <li><a class="shortcut-button" href="application_status.php"><span><img src="resources/images/status_icon.jpg" alt="icon" style="margin-bottom:3px;" /><br />
	  Application Status</span></a></li>
	  <li><a class="shortcut-button" href="leave_history_user.php" ><span><img src="resources/images/icon-list.png" alt="icon" style="margin-bottom:13px;" /><br />
      Leave History</span></a></li>
	  <li><a class="shortcut-button" href="holiday_list_all.php" ><span><img src="resources/images/Holidays.png" alt="icon" style="margin-bottom:13px;" /><br />
      Holiday List</span></a></li>
	  
	  <?php } ?>	  
	  
		  </ul>
<!-- End .shortcut-buttons-set -->
			</div>
			<div class="clear"></div> <!-- End .clear -->
			
			<!--Message part start here -->
			
			<?php if(isset($_SESSION['success_msg'])) { ?>
				<div class="notification success png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php 
						echo $_SESSION['success_msg'];
						unset($_SESSION['success_msg']);
					?>
				</div>
			</div>
			<?php }  ?>
			<?php if(isset($_SESSION['error_msg'])) { ?>
				<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					<?php 
						echo $_SESSION['error_msg'];
						unset($_SESSION['error_msg']);
					?>
				</div>
			</div>
			<?php }  ?>