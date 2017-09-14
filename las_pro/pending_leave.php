<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

$sql= 'SELECT * FROM leave_history WHERE (i_manager_id="'. $_SESSION['user_id'].'" AND i_status=0)';
$pager = new PS_Pagination($conn, $sql, 5, 5, "");
$result = $pager->paginate();
?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
					<h2>Pending Leave</h2>
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
								   <th>Leave From</th>
								   <th>Leave To</th>
								   <th>Action</th>
								</tr>
							</thead>						 												 
							<tbody>
							<?php while($row=mysql_fetch_assoc($result)){ ?>
								<tr>
									<td><input type="checkbox" /></td>
									<td><?php echo get_username_by_id($row['i_user_id']); ?></td>
									<td><?php echo $row['d_from']; ?></td>
									<td align="center"><?php echo $row['d_to']; ?></td>
										<!-- Icons -->
								 <td>
										 <a href="view_pending_leave.php?view_id=<?php echo $row['i_id']; ?>" title="Edit Meta"><img src="resources/images/icons/hammer_screwdriver.png" alt="Edit Meta" /></a></td>
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
