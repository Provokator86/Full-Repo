<?php
				
				$followClass = 'follow_btn';
				$followtext= stripslashes($this->lang->line('onboarding_follow'));
				if ($followtext == ''){
					$followtext = 'Follow';
				}
				if ($loginCheck != ''){
					$followingListArr = explode(',', $store_details->row()->followers);
					if (in_array($loginCheck, $followingListArr)){
						$followClass = 'following_btn';
						$followtext= stripslashes($this->lang->line('display_following'));
				        if ($followtext == ''){
							$followtext = 'Following';
						}
					}
				}
				?>
<div class="profile_main">
					
					
						<div class="profile_left">
					
							<div class="profile_left_title_txt">
							<?php
							$fullName = character_limiter($store_details->row()->store_name,35);
							if (strlen($fullName)>35){
								$fullName = substr($fullName, 0,35).'..';
							}
							$storeImg = 'dummy_store_logo.png';
                            if ($storelogoDetails->row()->store_logo != ''){
                            	$storeImg = $storelogoDetails->row()->store_logo;
                            }
							?>
								<div class="user-profile-avatar" style="float:left;width:200px;height: 200px;">
                                <?php if($storelogoDetails->row()->store_logo != '') { ?>
									<img alt="" class="avatar-image avatar-x200" style="margin-top:30px;" src="images/store/<?php echo $storeImg;?>"/>
                                <?php } else { ?>    
                                	<img alt="" class="avatar-image avatar-x200" src="images/store/<?php echo $storeImg;?>"/>
                                <?php } ?>
								</div>
								<div style="float: left;">
								<a title="<?php echo $fullName;?>"
										href="<?php echo prep_url($store_details->row()->store_url);?>"
										target="_blank" class="">
								<h1 style="margin-left: 20px;">
								<?php echo $fullName;?>
								</h1></a>
                                <?php if($storelogoDetails->row()->description!='') { ?>
                                	<div><p style="clear: both;margin: 10px 0 0 20px;text-align: left;float: left;"><?php echo $storelogoDetails->row()->description; ?></p></div>
                                	<div><p style="clear:both; margin:10px 0 0 20px; text-align:left; float:left;"><?php echo $claimDetails->row()->country; ?>&nbsp;<a href="<?php echo prep_url($storelogoDetails->row()->store_url);?>" target="_blank"><?php echo $storelogoDetails->row()->store_url; ?></a></p></div>
                                <?php } ?>
								<?php 
								if ($store_details->row()->user_id == 0){
								?>
								<p style="clear: both;margin: 10px 0 0 20px;text-align: left;float: left;">
								<?php /*?><?php if ($loginCheck!='' && $checkReq->num_rows()>0){?><?php */?>
                                <?php if ($loginCheck!='' && $checkReq->num_rows()>0){?>
								Requested
								<?php }else {?>
									<a title="<?php echo $store_details->row()->store_url;?>"
										href="<?php echo base_url().'store/'.$store_details->row()->store_url.'/claim'?>"
										class=""><?php if($this->lang->line('lg_own_this_claim') != '') { echo stripslashes($this->lang->line('lg_own_this_claim')); } else echo "Do you own this store? Claim it."; ?></a>
								<?php }?>
								</p>
								<?php }?>
								</div>
							</div>
					
						</div>
					
						<div class="profile_right" style="width: auto;">
					
							<ul class="profile_right_links">
					
								<li><a
									href="<?php echo base_url();?>store/<?php echo $store_details->row()->store_url;?>/followers"><strong><?php echo $store_details->row()->followers_count;?>
									</strong> <span><?php if($this->lang->line('display_followers') != '') { echo stripslashes($this->lang->line('display_followers')); } else echo "Followers"; ?>
									</span> </a></li>
					
					
								<li><a
									class="edit_btn <?php echo $followClass.' '; if ($loginCheck==''){echo 'sign_box';}?>"
									<?php if ($loginCheck != ''){?>
									data-uid="<?php echo $store_details->row()->id;?>"
									onclick="javascript:follow_store(this);" <?php }?>><?php echo $followtext;?>
								</a></li>
                                <?php //if($claimDetails->row()->store_id) { 
									if($loginCheck!= '' && $loginCheck==$store_details->row()->user_id) {
								?>
                                    <li><a href="site/store/claim_update/<?php echo $claimDetails->row()->store_id; ?>">Edit</a></li>
                                <?php } ?>    
							</ul>
						</div>
					</div>