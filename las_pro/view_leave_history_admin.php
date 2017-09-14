<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

$sql_leave='SELECT * FROM leave_history WHERE 
	i_id ="'.$_GET['view_id'].'"' ;
			$result_leave=$database->get_query($sql_leave);
				$row123=mysql_fetch_assoc($result_leave);
				
			
				
?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Leave History Details</h2>	
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
					<input class="text-input medium-input" type="text" id="medium-input" name="status" 
					value="<?php if($row123['i_status']==0){echo 'pending';}
					else if ($row123['i_status']==1){echo 'approved';}
						else {echo 'not approved';} ?>	"/>
				</p>
				
			</fieldset>
		</form>
	</div>	

<?php 
include('layout/footer.php');
?>