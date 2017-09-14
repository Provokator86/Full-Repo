<div class="heading_box"><?php echo $tot_job?> Job(s) found</div>	
		<?php
		//pr($job_list);
		  if($job_list)
		  {
			$i=1;
			  foreach($job_list as $val)
			  {
		  ?>

		<div class="<?php echo ($i++%2) ? 'job_box':'job_box white01'?>">
			<div class="left_content_box">
				<p class="blue_txt18"><?php echo $val['s_title']?></p>
				<p class="grey_txt12">Posted on: <?php echo $val['dt_entry_date']?></p>
				<p><?php echo $val['s_description']?></p>
				<p>&nbsp;</p>
				<p><span class="blue_txt">Category:</span> <?php echo $val['s_category_name']?></p>
				<p><span class="blue_txt">Location:</span> <?php echo $val['s_state']?>, <?php echo $val['s_city']?>,  <?php echo $val['s_postal_code']?></p>
				<p><span class="blue_txt">Professional:</span> <?php echo $val['s_username']?></p>
				<p><span class="blue_txt">Completed On:</span> <?php echo $val['dt_completed_date']?></p>
			</div>
			<div class="right_content_box">
				<div class="top_c">&nbsp;</div>
				<div class="mid_c">
					<ul>
						<li class="last"><a href="<?php echo base_url().'job/job_details/'.encrypt($val['id']);?>"><img src="images/fe/icon-29.png" alt="" /> View Job</a></li>
					</ul>
				</div>
				<div class="bot_c">&nbsp;</div>
			</div>
		</div>
		<?php 
			}
		} else echo t('No Record Found');?>     
		
		<div class="paging_box" style="padding:10px;">
		  
			   <?php echo $page_links;?>
			
		</div>						

