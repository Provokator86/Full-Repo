<script>
function send_msg(param)
{
	$('#opd_job').val(param);
	$('#frm_msg').submit();
}
</script>
<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
            <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
            <div class="body_right">
                  <h1><img src="images/fe/job.png" alt="" /> <?php echo get_title_string(t('All Jobs'))?> <span>(<?php echo $i_tot_jobs;?>)</span></h1>
                  <h4 style="font-size:14px;"><?php echo t('This section consists of all jobs and their history posted by you')?></h4>
                  <!--<div class="grey_box02">
                              <h3 style="border:0px;"> Filter options</h3>
                              <span class="left"> Status: &nbsp;</span>
                              <select name="status" id="status" style="width:150px; margin-right:15px;">
                                    <option>All</option>
                                    <option> Pending </option>
                                    <option> Active </option>
                                    <option> Rejected </option>
                                    <option> Assigned </option>
                                    <option> In Progress </option>
                                    <option> Feedback Asked </option>
                                    <option> Completed </option>
                                    <option> Expired </option>
                              </select>
                              <script type="text/javascript">
							$(document).ready(function(arg) {
								$("#status").msDropDown();
								$("#status").hide();
							})
						</script>
                              <span class="left">Category : &nbsp;</span>
                              <select name="category" id="category" style="width:270px;">
                                    <option>All</option>
                                    <option>..</option>
                              </select>
                              <script type="text/javascript">
							$(document).ready(function(arg) {
								$("#category").msDropDown();
								$("#category").hide();
							})
						</script>
                              <div class="spacer"></div>
                              <br />
                              <input  class="button" type="button" value="Search" style="margin-left:45px;" />
                              &nbsp;
                              <input  class="button" type="button" value="Show All" />
                        </div>-->
				<div id="job_list">		
                  	<?php echo $job_contents;?>
				</div>  
				  
            </div>
            <div class="spacer"></div>
      </div>
</div>


<div style="display: none;">
                                    <div id="history_div" class="lightbox">
                                          <h1>History</h1>
                                          <div style=" height:400px; overflow:auto; width:500px;">
                                                <div class="white_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="sky_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="white_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="sky_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="white_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="sky_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="white_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                                <div class="sky_box"> Rahul has posted the Job: <strong>Painter</strong> on 08/09/2011<br />
                                                      Admin has approved the Job: <strong>Painter</strong>.</div>
                                          </div>
                                    </div>
                              </div>