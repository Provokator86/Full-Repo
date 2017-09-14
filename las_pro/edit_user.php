<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');
 //echo $_GET['user_id'];
 $sql= 'SELECT * FROM user WHERE i_id= "'.$_GET['user_id'].'"'; 
 $result=$database->get_query($sql);
 $row=mysql_fetch_assoc($result);
if(isset($_POST['submit']))
	{	
		$firstname= checking_value($_POST['firstname']);
		$lastname= checking_value($_POST['lastname']);
		$email= checking_value($_POST['email']);
		$role= checking_value($_POST['role']);
		$department= checking_value($_POST['department']);
		$designation= checking_value($_POST['designation']);
		$date= $_POST['doj'];
		$status= $_POST['status'];


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
	
					if($role=='')
						{
							$error_role	=	'Invalid role';
							$error_flag		=	1;
						}
			if(	$department=='' || $department=='Select')
				{
					$error_department = 'Select department';
					$error_flag = 1;
				}				
		if($designation=='')
			{
				$error_designation	=	'Select designation';
				$error_flag		=	1;
			}
	if($date=='')
		{
			$error_date	=	'Invalid date';
			$error_flag		=	1;
		}

if ($error_flag==0)
	{	
			
			$sql= 'UPDATE user SET s_fname="'.inserting_value($firstname).'",s_lname="'.inserting_value($lastname).'",
			s_dept="'.inserting_value($department).'",s_desg="'.inserting_value($designation).'", 	d_joining="'.$date.'", 				           i_role="'.$role.'",s_email="'.inserting_value($email).'"	 WHERE i_id="'.$_GET['user_id'].'"';
		$result = $database->get_query($sql);
		$_SESSION['success_msg']='success';
		header('Location:manage_user.php');
		exit;
	}
}
$sql	=	'SELECT * FROM role';
$result	=	$database->get_query($sql);
?>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Edit User</h2>	
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
					value="<?php echo showing_value($row['s_fname']); ?>"/> 
				</p>
				<p>
					<label>Last Name</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="lastname" 
					value="<?php echo showing_value($row['s_lname']); ?>"/> 
				</p>
				<p>
					<label>Email</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="email" 
					value="<?php echo showing_value($row['s_email']); ?>"/> 
				</p>
				<p>
					<label>Role</label>              
					<select name="role" class="small-input">
					<?php 
						while($row123=mysql_fetch_assoc($result)){
							if($row['i_role']==$row123['i_id'])
								$sel	=	'selected';
							else
								$sel	=	'';
					?>
					<option <?php echo $sel; ?> value="<?php echo $row123['i_id']; ?>"><?php echo $row123['s_name']; ?></option>
					<?php } ?>				
				  </select>
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
				value="<?php echo showing_value($row['s_desg']); ?>"/> 
				</p>
			<p>
			<label>Date Of Joining</label>
			<input class="text-input small-input" type="text" id="small-input" value="<?php echo $row['d_joining']; ?>"
			name="doj" onclick="displayCalendar(document.user_frm.doj,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.doj,'yyyy-mm-dd',this,false)"  /> 
			</p>
				
				<p>
					<input class="button" type="submit" value="Submit" name="submit"/>
				</p>
		</fieldset>
	</form>
</div>


<?php
include('layout/footer.php');
?>

