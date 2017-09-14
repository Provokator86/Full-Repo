<?php
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

 $sql	=	'SELECT * FROM user';
 
//$result	=	$database->get_query($sql);
$pager = new PS_Pagination($conn, $sql, 4, 5, "");
$result = $pager->paginate();


?>
			
			<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">
					
					<h2>Manage User</h2>
					<ul class="content-box-tabs">
						</ul>
					</div>
                    <div class="right_corner"></div>
					
					
				</div> <!-- End .content-box-header -->
				
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div.  -->
						
						<form method="post" action="">
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>Name</th>
								   <th>Role</th>
								   <th>Status</th>
								   <th>Action</th>
								   <th>&nbsp;</th>
								   <th>&nbsp;</th>
								</tr>
							</thead>
							
																				
						 <tbody>
							<?php  while($row = mysql_fetch_assoc($result)){ ?>
								<tr>
									<td><input type="checkbox" name="user_id[]" value="<?php echo $row['i_id']; ?>" /></td>
									<td><?php echo showing_value($row['s_fname']).' '.$row['s_lname']; ?></td>
									<td><?php echo get_role_name_by_id($row['i_role']); ?></td>
									<td align="center"><?php echo $row['i_status']==1?'Active':'Inactive'; ?></td>
																						
							<td>
										<!-- Icons -->
										<a href="edit_user.php?user_id=<?php echo $row['i_id']; ?>" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
					<a href="delete_user.php?user_id=<?php echo $row['i_id']; ?>" title="Delete" onclick="return confirm('Are u sure want to delete?');"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
							</td>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
								</tr>
								<?php } ?>	
								</tbody>
						</table>
						</form>
						<div align="right" style="padding-top:10px;">
						
									<?php echo $pager->renderFullNav(); ?>
									</div>
				  </div> <!-- End #tab1 -->
					
				</div> <!-- End .content-box-content -->
				
		  </div> <!-- End .content-box -->
			
<?php
include('layout/footer.php');
?>
