<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php'); 

if(isset($_POST['submit']))
	{	
				
				$firstname= checking_value($_POST['firstname']);
				$lastname= checking_value($_POST['lastname']);
				$department= checking_value($_POST['department']);
				$designation= checking_value($_POST['designation']);
				$email= checking_value($_POST['email']);
				$password= checking_value($_POST['password']);
				$date= $_POST['doj'];
				$status= $_POST['status'];
				$role= $_POST['role'];

			$error_flag=0;

	if($firstname=='')
				{
					$error_firstname	=	'Invalid firstname';
					$error_flag		=	1;
				}
				if($email=='')
						{
								$error_email	=	'Invalid email';
								$error_flag		=	1;
						}
						if(	$lastname=='')
								{
										$error_lastname = 'Invalid Lastname';
										$error_flag = 1;
								}	
								if($password=='')
										{
											$error_password	=	'Invalid password';
											$error_flag		=	1;
										}
								if($role=='' || $role=='Select')
								{
										$error_role	=	'Select A role';
										$error_flag		=	1;
								}	
						if(	$department=='' || $department=='Select')
							{
									$error_department = 'Select A department';
									$error_flag = 1;
							}		
			if($designation=='')
						{
							$error_designation	=	'Invalid designation';
							$error_flag		=	1;
						}
		if($date=='')
				{
					$error_date	=	'Invalid date';
					$error_flag		=	1;
				}
	if(	$status=='0' || $status=='Select')
			{
				$error_status = 'Please Select Active status';
				$error_flag = 1;
			}				
	
	
if(	$error_flag==0)
		
		{	
			//------CHECKING IF THE USER EXIST----------//
			$sql='SELECT * FROM user WHERE s_email="'.$email.'"';
									$result = mysql_query($sql) or die (mysql_error());
									$num = mysql_numrows($result);
										if ($num > 0) {
									echo "Email already exists<br>";
													}
									else{	
									
									$sql='INSERT INTO user	(s_fname,s_lname,s_dept,s_desg,
										d_joining,s_pass,s_email,i_status,i_role)
									VALUES("'.inserting_value($firstname).'","'.inserting_value($lastname).'",
										"'.inserting_value($department).'","'.inserting_value($designation).'",
									"'.$date.'","'.md5($password).'","'.$email.'","'.$status.'","'.$role.'")';
					
							$result= $database->get_query($sql);
							$_SESSION['success_msg']='user created successfully';
							header('Location:manage_user.php');
									exit;
									
									}
			 
		}
		
	}
$sql	=	'SELECT * FROM role';
$result	=	$database->get_query($sql);
?>
<?php if(isset($_POST['submit']))
{if($error_flag=1){ ?>
<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					Error notification.=>Please Fill The Form below Correctly...
				</div>
			</div>
			<?php } }?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Create New User</h2>				
					
					</div>
                    <div class="right_corner"></div>
					
				</div>
				<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>First Name</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="firstname" 
					value="<?php echo showing_value($firstname); ?>"/> 
					<span class="err_msg"><?php echo $error_firstname; ?></span>
				</p>
				<p>
					<label>Last Name</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="lastname" 
					value="<?php echo showing_value($lastname); ?>"/> 
					<span class="err_msg"><?php echo $error_lastname; ?></span>
				</p>
				<p>
					<label>Email</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="email" 
					value="<?php echo showing_value($email); ?>"/> 
					<span class="err_msg"><?php echo $error_email; ?></span>
				</p>
				<p>
					<label>Password</label>
					<input class="text-input medium-input" type="password" id="medium-input" name="password" /> 
					<span class="err_msg"><?php echo $error_password; ?></span>
				</p>
				<p>
					<label>Role</label>              
					<select name="role" class="small-input">
						<option>Select</option>
						<option value="1">Admin</option>
						<option value="2">Manager</option>
						<option value="3">User</option>
					</select> <span class="err_msg"><?php echo $error_role; ?></span>
				</p>
				<p>
					<label>Department</label>
					<select name="department" class="small-input">
						<option>Select</option>
						<option value="1">.NET</option>
						<option value="2">J.S</option>
						<option value="3">PHP</option>
						</select> <span class="err_msg"><?php echo $error_department; ?></span>
				</p>
				<p>
				<label>Designation</label>
				<input class="text-input small-input" type="text" id="small-input" name="designation" 
				value="<?php echo showing_value($designation); ?>"/> 
				<span class="err_msg"><?php echo $error_designation; ?></span>
				</p>
			<p>
			<label>Date Of Joining</label>
		<input class="text-input small-input" type="text" id="small-input" name="doj" value="<?php echo showing_value($date);?>"
			onclick="displayCalendar(document.user_frm.doj,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.doj,'yyyy-mm-dd',this,false)"  /> 
			<span class="err_msg"><?php echo $error_date; ?></span>
			</p>
				<p>
					<label>Status</label>
					<select name="status" class="small-input">
					<option>Select</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
						</select> <span class="err_msg"><?php echo $error_status; ?></span>
				</p>
				<p>
					<input class="button" type="submit" value="Submit" name="submit"/>
				</p>
		</fieldset>
	</form>
</div>	
</div>
</div>	

<?php
include('layout/footer.php');
?>