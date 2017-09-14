<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

if(isset($_POST['submit']))
	{	
		$error_flag=0;
		$df = $_POST['df'];
		$dt= $_POST['to'];
		$reason= checking_value($_POST['reason']);
		$manager=$_POST['manager'];
	
	

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
	
	if($df>=$dt&&$df!=''&&$dt!='')
	{
			$error_inp	=	'date to should be greater than date from';
			$error_flag	=	1;
	}
				
					if(	$reason=='')
						{
							$error_reason = 'please filled this part';
							$error_flag = 1;
						}	
	
							if($manager=='')
								{
									$error_manager='select a manager';
									$error_flag=1;
								}	
		if($error_flag==0)
					{		
	
   			
			 		$sql='INSERT INTO leave_history(i_manager_id,i_user_id,d_from,d_to,s_reason,i_status) 
					VALUES("'.$manager.'","'.$_SESSION['user_id'].'","'.$df.'",
					"'.$dt.'",	"'.inserting_value($reason).'",0)';
			
					$result = $database->get_query($sql);
					
							
					$to_detail		=	get_user_detail_by_id($manager);
					$to				=	$to_detail['s_email'];
					$from_detail	=	get_user_detail_by_id($_SESSION['user_id']);
					$from			=	$from_detail['s_email'];
					$subject		=	"leave application";
					$message		=	$reason;
					$headers		=	"FROM:$from";
					@mail($to,$subject,$message,$headers);
					$_SESSION['success_msg']='succesfully sent';
					header('Location:application_status.php');					
					exit;	
		
				}	
}	
		
?>
<?php if(isset($_POST['submit'])){ 
 if($df >= $dt&&$df!=''&&$dt!='') { ?>

<div class="notification error png_bg">
				<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
				<div>
					Error notification.=> date to should be greater than date from.
				</div>
			</div>
			<?php } } ?>



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
					value="<?php echo $df; ?>" onclick="displayCalendar(document.user_frm.df,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.df,'yyyy-mm-dd',this,false)"  />  
					<span class="err_msg"><?php echo $error_df; ?></span>
				</p>
				<p>
					<label>Date To</label>
					<input class="text-input small-input" type="text" id="small-input" name="to" 
					value="<?php echo $dt; ?>" onclick="displayCalendar(document.user_frm.to,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.to,'yyyy-mm-dd',this,false)"  />  
					<span class="err_msg"><?php echo $error_dt; ?></span>
				</p>
				<p>
					<label>Reason For Leave</label>
					<textarea class="text-input textarea wysiwyg" id="textarea" name="reason" cols="79" rows="15">
					<?php echo showing_value($reason); ?></textarea>
					<span class="err_msg"><?php echo $error_reason; ?></span>
				</p>
				<p>
					<label>Select Manager</label>              
					<select name="manager" class="small-input">
						<option></option>
						<?php 
						 $sql= 'SELECT * FROM user WHERE i_role=2';
  							$result=$database->get_query($sql);  
						while($row=mysql_fetch_assoc($result)){
							if($_POST['manager']==$row['i_id'])
								$sel	=	'selected';
							else
								$sel	=	'';
							
					?>
					<option <?php echo $sel; ?> value="<?php echo $row['i_id']; ?>">
					<?php echo $row['s_fname'].' '.$row['s_lname']; ?></option>
					<?php } ?>				
					</select><span class="err_msg"><?php echo $error_manager; ?></span>
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