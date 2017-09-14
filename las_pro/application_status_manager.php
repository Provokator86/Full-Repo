<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

$sql='SELECT * FROM leave_history WHERE i_user_id="'.$_SESSION['user_id'].'"';
$pager = new PS_Pagination($conn, $sql, 5, 5, "");
$result = $pager->paginate();
?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
						<h2>Application Status</h2>
					</div>
                    <div class="right_corner"></div>
										
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1">
					
					<table>
							
							<thead>
								<tr>
								   
								   <th>From</th>
								   <th>To</th>
								   <th>Reason</th>
								   <th>Status</th>
								</tr>
							</thead>
					
						 
							<tbody>
								<?php if($result){
									while($row=mysql_fetch_assoc($result)){ ?>
								<tr>
									
									<td align="center"><?php echo $row['d_from']; ?></td>
									<td align="center"><?php echo $row['d_to']; ?></td>
									<td><?php echo $row['s_reason']; ?></td>
								<td align="center"><?php if($row['i_status']==0){echo 'pending';}
											else if ($row['i_status']==1){echo 'approved';}
												else {echo 'not approved';} ?></td>
								</tr>
								<?php } } ?>
								</tbody>
						</table>
						<div align="right" style="padding-top:10px;">
						
									<?php echo $pager->renderFullNav(); ?>
									</div>
						
				  </div> 
			</div>
	</div>				


<?php
include('layout/footer.php');
?>
