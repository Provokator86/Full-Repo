<div class="right_box_all">
                        <h1 style="float:left"><?php echo get_title_string(t('Jobs Just Completed'))?></h1>
						
                        <div class="shadow_big">
                              <div class="right_box_all_inner" style="padding-bottom:0px;">
							  	<?php
								foreach($job_list as $val)
								{
									//pr($val);
								?>
                                    <div class="com_job"> <a href="<?=base_url().'job/job_details/'.encrypt($val['id'])?>" class="red_link"><strong><?=$val['s_title']?></strong></a>
                                          <p><?=$val['s_description']?></p>
                                          <div class="indx_work"><?=$val['s_category_name']?></div>
                                          <div class="indx_work2"><?=$val['s_city']?></div>
										   <div class="indx_work4"><b><?php echo t('Tradesman')?></b>:<?=$val['s_username']?></div>
                                          <div class="indx_work3"><em><?php echo t('Completed').t(' on')?>: <?=$val['dt_completed_date']?> </em></div>
                                          <div class="spacer"></div>
                                    </div>
								<?php } ?>	
									
                              </div>
                        </div>
                  </div>