<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');



$sql='SELECT * FROM user WHERE i_role=1';
		$result=$database->get_query($sql);
		while($row123=mysql_fetch_assoc($result))
		{ 
		$to=$row123['s_email'];
				}

		
 
if(isset($_POST['submit']))
	{	
		$error_flag=0;
		$df = checking_value($_POST['df']);
		$dt= checking_value($_POST['to']);
		$reason= checking_value($_POST['reason']);
		
		
		

		if($df=='')
			{
				$error_df	=	'please select a date here';
				$error_flag		=	1;
			}


			if($dt=='')
				{
				$error_dt	=	'please select a date here';
					$error_flag		=	1;
				}
				
	if($df>=$dt && $df!='' && $dt!='')
	{
			$error_inp='date to should be greater than date from';
			$error_flag=1;
	}			
	
			if(	$reason=='')
				{
					$error_reason = 'please filled this part';
					$error_flag = 1;
				}	
	
	
if($error_flag==0)
	{		
		$sql='INSERT INTO leave_history(i_user_id,d_from,d_to,s_reason,i_status) 
				VALUES("'.$_SESSION['user_id'].'","'.inserting_value($df).'",
					"'.inserting_value($dt).'","'.inserting_value($reason).'",0)';
					
					$result = $database->get_query($sql);
					
					$from_detail	=	get_user_detail_by_id($_SESSION['user_id']);
					$from			=	$from_detail['s_email'];
					$subject		=	"leave application";
					$message		=	$reason;
					$headers		=	"FROM:$from";
					@mail($to,$subject,$message,$headers);
				$_SESSION['success_msg']='Application succesfully sent';
			header('Location:application_status_manager.php');					
			exit;	
		
	}	
}	
		
?>

<?php if(isset($_POST['submit'])){ 
 if($error_flag==1) { ?>
<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					Error notification.=> correct the form below.
				</div>
			</div>
			<?php }  } ?>
			
<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Apply For Leave</h2>	
					</div>
                    <div class="right_corner"></div>
				</div>
				
<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>Date From</label>
					<input class="text-input small-input" type="text" id="small-input" name="df" 
					value="<?php echo showing_value($df); ?>" onclick="displayCalendar(document.user_frm.df,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.df,'yyyy-mm-dd',this,false)"  />  
					<span class="err_msg"><?php echo $error_df; ?></span>
				</p>
				<p>
					<label>Date To</label>
					<input class="text-input small-input" type="text" id="small-input" name="to" 
					value="<?php echo showing_value($dt); ?>" onclick="displayCalendar(document.user_frm.to,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.to,'yyyy-mm-dd',this,false)"  />  
					<span class="err_msg"><?php echo $error_dt; ?></span>
					<span class="err_msg"><?php echo $error_inp; ?></span>
					
				</p>
				<p>
					<label>Reason For Leave</label>
					<textarea class="text-input textarea wysiwyg" id="textarea" name="reason" cols="79" rows="15">
					<?php echo showing_value($reason); ?></textarea>
					<span class="err_msg"><?php echo $error_reason; ?></span>
				</p>
				<p>
					<input class="button" type="submit" value="Submit" name="submit"/>
				</p>
								
		</fieldset>
	</form>
</div>	
</div>	
				
				
				
<?php
include('layout/footer.php');
?>