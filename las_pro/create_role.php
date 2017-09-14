<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');


if(isset($_POST['submit']))
	{
		$rolename=checking_value($_POST['rolename']);
		$error_flag=0;
		
		if($rolename=='')
		{
			$error_rolename='invalid rolename';
			$error_flag=1;
		}
		
		if($error_flag==0)
			{
				$sql='INSERT INTO role (s_name) VALUES( "'.inserting_value($rolename).'")';
				$result=$database->get_query($sql);
				$_SESSION['success_msg']='success';
				header('Location:manage_role.php');
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
						<h2>Create New Role</h2>	
					</div>
                    <div class="right_corner"></div>
				</div>
				
		<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>Role Name</label>
					<input class="text-input small-input" type="text" id="small-input" name="rolename" 
					value="<?php echo showing_value($rolename); ?>"/> 
					<span class="err_msg"><?php echo $error_rolename; ?></span>
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