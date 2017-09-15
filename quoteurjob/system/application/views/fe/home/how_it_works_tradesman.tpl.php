<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <div class="static_content">
						
                        <h1><?php echo t('How')?> <span><?php echo t('it works for tradesman')?> </span> </h1>
						<?php foreach($info as $val) { ?>
                        <div class="top_box">
                           
							  <?php echo $val["s_basic_content"] ?>
                        </div>
                        <div class="shadow_big">
                              <ul class="tab6">
                                    <li><a href="JavaScript:void(0);" title="post_a_Job" class="tab1 active1"><span><?php echo t('Search for Job')?></span></a></li>
                                    <li class="pink_txt" style="padding-top:5px;">|</li>
                                    <li><a href="JavaScript:void(0);" title="get_quotes" class="tab1"><span> <?php echo t('Post your queries on the Jobs')?></span></a></li>
                                    <li class="pink_txt" style="padding-top:5px;">|</li>
                                    <li><a href="JavaScript:void(0);" title="tradesman" class="tab1"><span> <?php echo t('Quote on the Job of your choice')?></span></a></li>
                              </ul>
                              <div class="right_box_all_inner">
                                    <div class="tsb_text" id="post_a_Job">
                                          
										  <?php echo $val["s_search_job_content"] ?>
                                    </div>
                                    <div class="tsb_text" id="get_quotes" style="display:none;">
                                          
                                    	<?php echo $val["s_post_queries_content"] ?>	
									</div>
                                    <div class="tsb_text" id="tradesman" style="display:none;">
                                          
                                    	 <?php echo $val["s_quote_on_job_content"] ?>
									</div>
                              </div>
                        </div>
                       <?php /*?><div style="text-align:right; margin-bottom:20px;">
					    <input  class="button" type="button" value="Sign Up"  onclick="window.location.href='<?php echo base_url().'user/registration/TWlOaFkzVT0' ?>'" />
					   </div><?php */?>
      
                  <?php } ?>
                 
            </div>
            <div class="spacer"></div>
      </div>