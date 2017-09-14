<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

  $sql_leave='SELECT * FROM leave_history WHERE i_id ="'.$_GET['view_id'].'"'; 	
		$result_leave=$database->get_query($sql_leave);
		$row123=mysql_fetch_assoc($result_leave);
						
		if(isset($_POST['submit']))
			{
				$error_flag=0;
				$status=$_POST['status'];
			if($status=='' || $status=='ChangeStatus')
			{
				$error_status = 'Select status';
				$error_flag = 1;
			}
				
		if ($error_flag==0)
						{										
							 $sql='UPDATE leave_history SET i_status="'.$_POST['status'].'" WHERE i_id="'.$_GET['view_id'].'"';
							$result=$database->get_query($sql);
							$to_details	=	get_user_detail_by_id($row123['i_user_id']);
							$to=$to_details['s_email'];
							$from_detail	=	get_user_detail_by_id($_SESSION['user_id']);
							$from=$from_detail['s_email'];
							$subject		=	"leave application";
							$message		=	"reason";
							$headers		=	"FROM:$from";
							@mail($to,$subject,$message,$headers);
							$_SESSION['success_msg']='success';
							header('Location:pending_leave_admin.php');
							exit;
						} 		
 
 }
?>

<?php if(isset($_POST['submit']))
{if($error_flag=1){ ?>
<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					Error notification.=>Please Select Status In The Form below ...
				</div>
			</div>
			<?php } }?>
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Details Of Pending Leave</h2>	
					</div>
                    <div class="right_corner"></div>
				</div>
		<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">		
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>Name</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="name" 
					value="<?php echo get_username_by_id($row123['i_user_id']); ?>"/> 
					
				</p>
				<p>
					<label>Leave From</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="from" 
					value="<?php echo $row123['d_from']; ?>"/> 
					
				</p>
				<p>
					<label>Leave To</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="to" 
					value="<?php echo $row123['d_to']; ?>"/> 
					
				</p>
				<p>
					<label>Reason</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="reason" 
					value="<?php echo $row123['s_reason']; ?>"/> 
				</p>
				<p>
					<label>Status</label>              
					<select name="status" class="small-input">
						<option>ChangeStatus</option>
						<option value="1">Approved</option>
						<option value="2">NotApproved</option>
					</select> <span class="err_msg"><?php echo $error_status; ?></span>
				</p>
				<p>
					<input class="button" type="submit" value="submit" name="submit"/>
				</p>
			</fieldset>
		</form>
	</div>				

<?php
include('layout/footer.php');

?>