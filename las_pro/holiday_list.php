<?php 
include('layout/header.php');
include('layout/sidebar.php');
include('layout/top_content.php');

$sql='SELECT * FROM holidays WHERE 1';

$pager = new PS_Pagination($conn, $sql, 10, 5, "");
$result = $pager->paginate();
?>

<div class="content-box"><!-- Start Content Box -->
				
				<div class="content-box-header">
					<div class="left_corner"></div>
                    <div class="mid_section">	
					<h2>Holiday List</h2>
				</div>
                    <div class="right_corner"></div>
					
				</div> <!-- End .content-box-header -->
				
				<div class="content-box-content">
					
					<div class="tab-content default-tab" id="tab1"> <!-- This is the target div. id must match the href of this div's tab -->
						
						
						<table>
							
							<thead>
								<tr>
								   <th><input class="check-all" type="checkbox" /></th>
								   <th>Date</th>
								   <th>Reason</th>
								   <th>Status</th>
								   <th>Action</th>
								   <th>&nbsp;</th>
								</tr>
							</thead>
							
						 
							<tbody>
							<?php  while($row = mysql_fetch_assoc($result)){ ?>
								<tr>
									<td><input type="checkbox" /></td>
									<td><?php echo $row['d_date']; ?></td>
									<td><?php echo $row['s_for']; ?></td>
									<td align="center"><?php if($row['i_status']==1){echo 'active';}
															else {echo 'inactive';} ?>
									</td>		
									<td>
										<!-- Icons -->
										 <a href="edit_holiday.php?holidays_id=<?php echo $row['i_id']; ?>" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
		 <a href="delete_holiday.php?holidays_id=<?php echo $row['i_id']; ?>" title="Delete" onclick="return confirm('Are U Sure Want To Delete?');"><img src="resources/images/icons/cross.png" alt="Delete" /></a> 
									</td>
								    <td>&nbsp;</td>
								</tr>
								<?php } ?>	
								</tbody>
						</table>
						<div align="right" style="padding-top:10px;">
						
									<?php echo $pager->renderFullNav(); ?>
									</div>
						
				  </div> <!-- End #tab1 -->
					
					<div class="tab-content" id="tab2">
					
						<form action="" method="post">
							
							<fieldset> <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->
								
								<p>
									<label>Small form input</label>
										<input class="text-input small-input" type="text" id="small-input" name="small-input" /> <span class="input-notification success png_bg">Successful message</span> <!-- Classes for input-notification: success, error, information, attention -->
										<br /><small>A small description of the field</small>
								</p>
								
								<p>
									<label>Medium form input</label>
									<input class="text-input medium-input" type="text" id="medium-input" name="medium-input" /> <span class="input-notification error png_bg">Error message</span>
								</p>
								
								<p>
									<label>Large form input</label>
									<input class="text-input large-input" type="text" id="large-input" name="large-input" />
								</p>
								
								<p>
									<label>Checkboxes</label>
									<input type="checkbox" name="checkbox1" /> This is a checkbox <input type="checkbox" name="checkbox2" /> And this is another checkbox
								</p>
								
								<p>
									<label>Radio buttons</label>
									<input type="radio" name="radio1" /> This is a radio button<br />
									<input type="radio" name="radio2" /> This is another radio button
								</p>
								
								<p>
									<label>This is a drop down list</label>              
									<select name="dropdown" class="small-input">
										<option value="option1">Option 1</option>
										<option value="option2">Option 2</option>
										<option value="option3">Option 3</option>
										<option value="option4">Option 4</option>
									</select> 
								</p>
								
								<p>
									<label>Textarea with WYSIWYG</label>
									<textarea class="text-input textarea wysiwyg" id="textarea" name="textfield" cols="79" rows="15"></textarea>
								</p>
								
								<p>
									<input class="button" type="submit" value="Submit" />
								</p>
								
							</fieldset>
							
							<div class="clear"></div><!-- End .clear -->
							
						</form>
						
					</div> <!-- End #tab2 -->        
					
				</div> <!-- End .content-box-content -->
				
		  </div>

	
<?php
include('layout/footer.php');
?>