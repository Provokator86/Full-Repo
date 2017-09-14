<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

$sql	=	'SELECT * FROM dept WHERE i_id="'.$_GET['dept_id'].'"';
$result	=	$database->get_query($sql);
$row = mysql_fetch_assoc($result);

if(isset($_POST['submit']))
	{
		$deptname= checking_value($_POST['deptname']);
		$status=$_POST['status'];
		$error_flag=0;
		
		if($deptname=='')
			{
				$error_deptname='wrong deptname';
				$error_flag=1;
			}
			
		/*if($status=='Inactive')
			{
				$error_status='u cant kept inactive status';
				$error_flag=1;
			}	*/
		if($error_flag==0)
			{
									
				$sql='UPDATE dept SET s_name="'.inserting_value($deptname).'" 
				WHERE i_id="'.$_GET['dept_id'].'"'; 
				$result=$database->get_query($sql);
				$_SESSION['success_msg']='success';
				header('Location:manage_dept.php');
				exit;
			}
			
	}	


?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
							<h2>Edit Role</h2>			
					
					</div>
                    <div class="right_corner"></div>					
					
				</div>

<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>Department Name</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="deptname" 
					value="<?php echo showing_value($row['s_name']); ?>"/> 
					<span class="err_msg"><?php echo $error_deptname; ?></span>
				</p>
				
				<!--<p>
					<label>Status</label>
					<select name="status" class="small-input">
						<option value="1">Active</option>
						<option value="0">Inactive</option>
						</select> 
				</p>-->
				<p>
					<input class="button" type="submit" value="Submit" name="submit"/>
				</p>
		</fieldset>
	</form>
</div>

<?php 
include('layout/footer.php');
?>
