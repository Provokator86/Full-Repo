<?php 
session_start(); 
include('includes/database.php');

 $sql='SELECT * FROM user WHERE i_id="'.$_SESSION['user_id'].'"';
		$result=mysql_query($sql,$link);
		
?>

<div id="sidebar"><div id="sidebar-wrapper"> <!-- Sidebar with logo and menu -->

			<!--<h1 id="sidebar-title">Welcome <br/>To Acumen</h1>-->
		  <?php if($_SESSION['user_roll']==1){ ?>
		  <?php while ($row=mysql_fetch_array($result)){ ?>
		  <h1 id="sidebar-title">Welcome,<br/><?php echo $row['s_fname']; ?></h1><?php } ?>
		<div id="profile-links"><a href="manage_user.php">Admin Home</a> | <a href="logout.php" title="Sign Out">Log Out</a></div>        
			
			<ul id="main-nav">  <!-- Accordion Menu -->
			
								
				<li><a href="manage_user.php" class="nav-top-item ">Manage User</a>
					<ul>
						<li><a href="create_user.php">Create User</a></li>
						<li><a href="manage_user.php">User List</a></li>
					</ul>
				</li>
				
				<li><a href="pending_leave_admin.php" class="nav-top-item">Pending Leave</a>
					<ul>
						<li><a href="pending_leave_admin.php">Pending Leave List</a></li>
					</ul>
				</li>				
				<li><a href="leave_history_admin.php" class="nav-top-item">Leave History</a>
					<ul>
						<li><a href="leave_history_admin.php">Leave History</a></li>
					</ul>
				</li>
				<li><a href="holiday_list.php" class="nav-top-item">Holiday List</a>
					<ul>
						<li><a href="add_holiday.php">Create New Holiday</a></li>
						<li><a href="holiday_list.php">Holiday List</a></li>
					</ul>
				</li>
				
				<li><a href="manage_dept.php" class="nav-top-item">Manage Department</a>
					<ul>
						<li><a href="add_dept.php">Create New Department</a></li>
						<li><a href="manage_dept.php">Department List</a></li>
					</ul>
				</li>
                                
                <li><a href="manage_role.php" class="nav-top-item">Manage Role</a>
					<ul>
						<li><a href="create_role.php">Create New Role</a></li>
						<li><a href="manage_role.php">Role List</a></li>
					</ul>
				</li>
				</ul>
				<?php } if($_SESSION['user_roll']==2){ ?>
				 <?php while ($row=mysql_fetch_array($result)){ ?>
				<h1 id="sidebar-title">Welcome,<br/><?php echo $row['s_fname']; ?></h1><?php } ?>
				
				<div id="profile-links"><a href="pending_leave.php">Home</a> | <a href="logout.php" title="Sign Out">Log Out</a></div> 
				<ul id="main-nav">
                
                <li><a href="pending_leave.php" class="nav-top-item">Pending Leave</a>
					<ul>
						<li><a href="pending_leave.php">Pending Leave List</a></li>
					</ul>				
				</li>
                
                <li><a href="leave_history_manager.php" class="nav-top-item">Leave History</a>
					<ul>
						<li><a href="leave_history_manager.php">Leave history List</a></li>
					</ul>				
				</li>
				
				 <li><a href="apply_leave_manager.php" class="nav-top-item">Apply Leave</a>
				 	<ul>
						<li><a href="apply_leave_manager.php">Apply For Leave</a></li>
					</ul>
				 </li>
				 <li><a href="application_status_manager.php" class="nav-top-item">Application Status</a>
				 	<ul>
						<li><a href="application_status_manager.php">Status Of Applied Leave</a></li>
					</ul>
				 </li>
				 <li><a href="holiday_list_all.php" class="nav-top-item">Holiday List</a>
				 	<ul>
						<li><a href="holiday_list_all.php">Holiday List</a></li>
					</ul>
				 </li>
				 </ul>
				 
				<?php } if($_SESSION['user_roll']==3){ ?>
				 <?php while ($row=mysql_fetch_array($result)){ ?>
				
				<h1 id="sidebar-title">Welcome,<br/><?php echo $row['s_fname']; ?></h1><?php } ?>
				<div id="profile-links"><a href="apply_leave.php"> Home</a> | <a href="logout.php" title="Sign Out">Log Out</a></div> 
				<ul id="main-nav">
                
                <li><a href="apply_leave.php" class="nav-top-item">Apply Leave</a>
					<ul>
						<li><a href="apply_leave.php">Apply For Leave</a></li>
					</ul>
				</li>  
                
                <li><a href="application_status.php" class="nav-top-item">Application Status</a>
					<ul>
						<li><a href="application_status.php">Status Of Applied Leave</a></li>
					</ul>
				</li>
                
                <li><a href="leave_history_user.php" class="nav-top-item">Leave History</a>
					<ul>
						<li><a href="leave_history_user.php">Leave history List</a></li>
					</ul>				
				</li>
                
                <li><a href="holiday_list_all.php" class="nav-top-item">Holiday List</a>
					<ul>
						<li><a href="holiday_list_all.php">Holiday List</a></li>
					</ul>
				</li>  
				</ul>            
             <?php } ?>
				<br clear="all" />
			</ul> <!-- End #main-nav -->
			
			 <!-- End #messages -->
			<br clear="all" />
		</div></div>
				<div id="main-content">