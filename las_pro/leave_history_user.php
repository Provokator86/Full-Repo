<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

$sql= 'SELECT * FROM leave_history WHERE i_user_id="'.$_SESSION['user_id'].'"';

$pager = new PS_Pagination($conn, $sql, 5, 5, "");
$result = $pager->paginate();

?>
<div class="content-box"><!-- Start Content Box -->				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">					
						<h2>Leave History</h2>
					</div>
                    <div class="right_corner"></div>
					
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
						
						<table>
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>Name</th>
								   <th>LeaveFrom</th>
								   <th>LeaveTo</th>
								   <th>Status</th>
								   <th>Action</th>
								</tr>
							</thead>						 
																		 
					<tbody>
						<?php while($row=mysql_fetch_assoc($result)){	?>
						<tr>
							<td><input type="checkbox" /></td>
							<td><?php echo get_username_by_id($row['i_user_id']); ?></td>
							<td><?php echo $row['d_from']; ?></td>
							<td><?php echo $row['d_to']; ?></td>
							<td><?php if($row['i_status']==0){echo 'pending';}
									else if($row['i_status']==1){echo 'approved';}
										else {echo 'notapproved';} ?></td>
				<td align="center"><a href="view_leave_history_admin.php?view_id=<?php echo $row['i_id']; ?>">View</a></td>
	
						</tr>
							<?php } ?>
						</tbody>
					</table>
					<div align="right" style="padding-top:10px;">
						
									<?php echo $pager->renderFullNav(); ?>
									</div>
						
				  </div> <!-- End #tab1 -->
								   
			 </div> <!-- End .content-box-content -->
				
		  </div> 
	

<?php
include('layout/footer.php');
?>