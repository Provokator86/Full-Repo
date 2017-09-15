<div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <div class="static_content">
     					
                        <h1><?php echo t('How')?> <span><?php echo t('it works for buyers')?> </span> </h1>
						<?php foreach($info as $val) {?>
                        <div class="top_box">
                             <!-- <h3>Find reliable local Tradesman  - <span>for FREE! </span></h3>
                              <ul class="category">
                                    <li>Post your jobs online & receive multiple quotes today</li>
                                    <li>You could save up to 30%</li>
                                    <li>Tradesman and handymen are rated by other customers so you know what you're getting</li>
                              </ul>-->
							   <?php echo $val["s_basic_content"] ?>
                        </div>
                        <div class="shadow_big">
                              <ul class="tab6">
                                    <li><a href="JavaScript:void(0);" title="post_a_Job" class="tab1 active1"><span><?php echo t('Post a Job for free')?> </span></a></li>
                                    <li class="pink_txt" style="padding-top:5px;">|</li>
                                    <li><a href="JavaScript:void(0);" title="get_quotes" class="tab1"><span> <?php echo t('Get Quotes From Tradesman')?></span></a></li>
                                    <li class="pink_txt" style="padding-top:5px;">|</li>
                                    <li><a href="JavaScript:void(0);" title="tradesman" class="tab1"><span> <?php echo t('Hire the best Tradesman')?></span></a></li>
                                    <li class="pink_txt" style="padding-top:5px;">|</li>
                                    <li><a href="JavaScript:void(0);" title="leave_feedback" class="tab1"><span> <?php echo t('Leave Feedback')?></span></a></li>
                              </ul>
                              <div class="right_box_all_inner">
                                    <div class="tsb_text" id="post_a_Job">
                                          <!--<p>Fill up the online form to post a job. It takes just a few minutes. Just make sure that your job description is clear and detailed so that only those contractors or tradesmen capable of meeting your requirements quote for your job.</p>
                                          <div class="post_a_Job">
                                                Try to include the following information:
                                                <ul class="category">
                                                      <li>Anticipated start date</li>
                                                      <li>Dimensions (exact or approximate)</li>
                                                      <li>Any images such as photographs or plans</li>
                                                </ul>
                                            
                                          </div>-->
										   <?php echo $val["s_post_job_content"] ?>
                                    </div>
                                    <div class="tsb_text" id="get_quotes" style="display:none;">
                                          <!--<p>Builders, plumbers, gardeners, roofers, cleaning services and a host of other contractors or handymen who are registered with us will quote for relevant jobs posted on our site. At Rush-job you are assured to find the best workman for yourself. Your description needs to be spot on however. Tradesmen will offer you competitive rates for their services, and you can thus be assured of the best bargain. The feedback system ensures the reliability of tradesmen.</p>-->
                                            <?php echo $val["s_get_quote_from_tradesman_content"] ?>
                                    </div>
                                    <div class="tsb_text" id="tradesman" style="display:none;">
                                          <!--<p>Having received quotes it’s time to pick the tradesman who can do the job best for you. Refer to the feedbacks of other users on contractors and handymen. Shortlist those with impressive feedbacks on them and interview them. During the interview find out if a workman or contractor understands your needs perfectly. Weigh pros and cons and go ahead with picking your man.</p>-->
                                      		 <?php echo $val["s_hire_best_tradesman_content"] ?>
                                    </div>
                                    <div class="tsb_text" id="leave_feedback" style="display:none;">
                                          <!--<p>Having availed of the services of the workman or the contractor, do leave a feedback on the same on the site. Feedbacks act as guidelines for users in picking the right tradesman or handyman. If a workman has satisfied you then he deserves to find more work, and other users should benefit from his services as well. Thus, a wonderful community of satisfied customers and efficient tradesmen keeps growing on our site. On the other hand negative feedbacks on tradesmen who aren’t good enough protects customers from listless services.</p>-->
                                       		 <?php echo $val["s_leave_feeedback_content"] ?>
                                    </div>
                              </div>
                        </div>
                        <?php /*?><div style="text-align:right; margin-bottom:20px;">
                              <input  class="button2" type="button" value="Post your Job now"  onclick="window.location.href='<?php echo base_url().'job/job_post' ?>'" />
                        </div><?php */?>
      
                <?php } ?>
                 
            </div>
            
      </div>