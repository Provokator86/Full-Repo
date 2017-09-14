<?php
include('layout/header.php');
include('layout/sidebar.php'); 
 include('layout/top_content.php');
$sql	=	'SELECT * FROM role';
$pager = new PS_Pagination($conn, $sql, 5, 5, "");
$result = $pager->paginate();

?>


<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
					<?php /*?><h2>Change Password</h2><?php */?>
					<h2>Manage Role</h2>	
					<ul class="content-box-tabs">
					</ul>
					</div>
                    <div class="right_corner"></div>
					
					
				</div> <!-- End .content-box-header -->
				
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1">
					
					<table>
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>Role</th>
								   <th>Action</th>
								   <th>&nbsp;</th>
								</tr>
							</thead>
							
													
							<tbody>
							<?php  while($row = mysql_fetch_assoc($result)){ ?>
									<tr>
									<td><input type="checkbox" /></td>
									<td><?php echo $row['s_name']; ?></td>
																						
									<td>
										<!-- Icons -->
			<a href="edit_role.php?role_id=<?php echo $row['i_id']; ?>" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
		<a href="delete_role.php?role_id=<?php echo $row['i_id']; ?>" title="Delete" onclick="return confirm('Are U Sure Want To Delete?');"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
									</td>
								    <td>&nbsp;</td>
								</tr>
								<?php } ?>
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