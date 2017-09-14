<?php
//pr($buyer_details);
?>

<div class="lightbox3" style="display:block;">
      <div class="close">
	  <!--<a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/close.png" alt="" /></a>-->
	  </div>
      <div class="top">&nbsp;</div>
      <div class="mid">
            <div class="client_profile">
                  <div class="img_box">
				  <?php
					if($buyer_details['image']) 
					{  
						$user_image = $buyer_details['image'][0]['s_user_image']; 
					?>					
					<img src="<?php echo base_url().'uploaded/user/thumb/thumb_'.$user_image?>" alt="" width="100" height="100" />
					<?php
					} else {
					?>
						<img src="images/fe/profile_photo.png" alt="" />
					<?php } ?>
				<!--  <img src="images/fe/img-05.jpg" alt="" width="100" height="100" />-->
				  </div>
                  <div class="txt_box">
                        <div id="client_profile">
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                          <td width="210">Client name :</td>
                                          <td width="10">&nbsp;</td>
                                          <td><?php echo $buyer_details['s_name']?></td>
                                    </tr>
                                    <tr>
                                          <td>Location :</td>
                                          <td>&nbsp;</td>
                                          <td><?php echo $buyer_details['s_state']?>, <?php echo $buyer_details['s_city']?>, <?php echo $buyer_details['s_zip']?></td>
                                    </tr>
                                    <tr>
                                          <td>Total Jobs posted:</td>
                                          <td>&nbsp;</td>
                                          <td><?php echo $buyer_details['i_total_job_posted']?></td>
                                    </tr>
                                    <tr>
                                          <td>Total Jobs awarded :</td>
                                          <td>&nbsp;</td>
                                          <td><?php echo $buyer_details['i_total_job_awarded']?></td>
                                    </tr>
                                    <tr>
                                          <td>Reviews received :</td>
                                          <td>&nbsp;</td>
                                          <td><?php echo $buyer_details['i_feedback_received']?></td>
                                    </tr>
                              </table>
                        </div>
                  </div>
            </div>
            <div class="review">
                  <h6><span class="blue"><?php echo $buyer_details['i_feedback_received']?></span> reviews</h6>
				  
				<div id="feedback_list">
					<?php echo $feedback_contents;?>
				</div>
				  
				  
                  <div class="clr"></div>
            </div>
      </div>
      <div class="bot">&nbsp;</div>
</div>