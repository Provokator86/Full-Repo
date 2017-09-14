<?php 
include('layout/header.php');
include('layout/sidebar.php');
 include('layout/top_content.php');


if(isset($_POST['submit']))
	{
		$date=checking_value($_POST['doh']);
		$reason=checking_value($_POST['reason']);
		$status= checking_value($_POST['status']);
		$error_flag=0;
		
		
	if($date=='')
				{
					$error_date	=	'select date';
					$error_flag		=	1;
				}
			if($reason=='')
					{
							$error_reason	=	'give reason';
							$error_flag		=	1;
					}
					
			if($status=='0' || $status=='Select')
					{
							$error_status	=	'Select Active status';
							$error_flag		=	1;
					}		
					
											
	if($error_flag==0)
		{			
				$sql='SELECT * FROM holidays WHERE d_date="'.$date.'"';
				$result=mysql_query($sql) or die (mysql_error());
				$num=mysql_numrows($result);
				if($num>0){
					echo 'you cant add another holiday on same date';
					
					}
				else{
						 $sql='INSERT INTO holidays (d_date,s_for,i_status)
				 			VALUES("'.$date.'","'.inserting_value($reason).'","'.$status.'")';
							$result= $database->get_query($sql);
							$_SESSION['success_msg']='success';
							header('Location:holiday_list.php');
							exit;
				
			 		}					
		
			 
			
	}
	
}
							
?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
					<h2>Add New Holiday</h2>
					</div>
                    <div class="right_corner"></div>					
				</div>
				
<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>date</label>
					<input class="text-input small-input" type="text" id="small-input" name="doh" 
					value="<?php echo showing_value($date); ?>" onclick="displayCalendar(document.user_frm.doh,'yyyy-mm-dd',this,false)" readonly="readonly" />
				<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.doh,'yyyy-mm-dd',this,false)"/> <span class="err_msg"><?php echo $error_date; ?></span>
				</p>	
				
				<p>
					<label>Reason</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="reason" 
					value="<?php echo showing_value($reason); ?>" />	
					<span class="err_msg"><?php echo $error_reason; ?></span>
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

<?php
include('layout/footer.php');
?>