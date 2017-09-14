<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');


$sql='SELECT * FROM holidays WHERE i_id= "'.$_GET['holidays_id'].'"';
$result=$database->get_query($sql);
$row=mysql_fetch_assoc($result);


if(isset($_POST['submit']))
	{
		$date=checking_value($_POST['doh']);
		$reason=checking_value($_POST['reason']);
		$status= $_POST['status'];
		$error_flag=0;
		
		
	if($date=='')
				{
					$error_date	=	'select date';
					$error_flag		=	1;
				}
				if($reason=='')
						{
								$error_reason	=	'you cant keep reason empty';
								$error_flag		=	1;
						}
														
								
		if($error_flag==0)
		{
			
			$sql='UPDATE holidays SET d_date="'.$date.'",s_for="'.$reason.'"
			WHERE i_id="'.$_GET['holidays_id'].'"';
			$result=$database->get_query($sql);
			$_SESSION['success_msg']='success';
				header('Location:holiday_list.php');
				exit;
			}
			
	}				

?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
							<h2>Edit Holiday</h2>	
					</div>
                    <div class="right_corner"></div>					
				</div>
<div class="content-box-content">
<div class="tab-content default-tab" id="tab1">
	<form action="" method="post" name="user_frm">	
		<fieldset>
				 <p>
					<label>Date</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="doh" 
					value="<?php echo showing_value($row['d_date']); ?>" onclick="displayCalendar(document.user_frm.doh,'yyyy-mm-dd',this,false)" readonly="readonly" />
					<img src="images/icon-cal.gif" alt="" width="25" height="20"  onclick="displayCalendar(document.user_frm.doh,'yyyy-mm-dd',this,false)"  />
				</p>	
				
				<p>
					<label>Reason</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="reason" 
					value="<?php echo showing_value($row['s_for']); ?>"/> 
					<span class="err_msg"><?php echo $error_reason; ?></span>
				</p>
				<?php /*?><p>
					<label>Status</label>
					<input class="text-input medium-input" type="text" id="medium-input" name="status" 
					value="<?php echo $row['i_status']==1?'Active':'Inactive'; ?>"/> 
				</p>	
				<?php */?>
				<p>
					<input class="button" type="submit" value="Submit" name="submit"/>
				</p>
			</fieldset>
		</form>
	</div>	

<?php
include('layout/footer.php');

?>