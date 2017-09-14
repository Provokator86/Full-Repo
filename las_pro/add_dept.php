<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');



if(isset($_POST['submit']))
	{
		$deptname= checking_value($_POST['deptname']);
		$status=$_POST['status'];
		$error_flag=0;
		
		if($deptname=='')
			{
				$error_deptname='select a Department';
				$error_flag=1;
			}
			
		if($status=='0' || $status=='Select')
			{
				$error_status='wrong status';
				$error_flag=1;
			}	
		if($error_flag==0)
			{
				$sql='INSERT INTO dept (s_name,i_status) VALUES( "'.inserting_value($deptname).'","'.$status.'")';
				$result=$database->get_query($sql);
				$_SESSION['success_msg']='success';
				header('Location:manage_dept.php');
				exit;
			}
			
	}					

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
							<h2>Create New Department</h2>	
					</div>
                    <div class="right_corner"></div>
					
				</div>
<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>Department Name</label>
					<input class="text-input small-input" type="text" id="small-input" name="deptname" 
					value="<?php echo showing_value($deptname); ?>"/> 
					<span class="err_msg"><?php echo $error_deptname; ?></span>
				</p>
				
				<p>
					<label>Status</label>
					<select name="status" class="small-input">
					<option>Select</option>
						<option value="1">Active</option>
						<option value="0">Inactive</option>
						</select>
						<span class="err_msg"><?php echo $error_status; ?></span>
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

