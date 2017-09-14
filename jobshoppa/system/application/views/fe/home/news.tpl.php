<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <div class="static_content">
                  <h1><?php echo t('News')?> </h1>
                  <div class="shadow_big">
                        <div class="right_box_all_inner">
                              <div class="left_box02" style="border-bottom:0px;">
							  <?php
							  if($news_details){
							  ?>
                                    <h3 style="padding:0px; border:0px; margin:0px;"><span><?php echo $news_details['s_title']?></span></h3>
                                    <h2 style="padding-bottom:5px;"> <span><?php echo $news_details['fn_created_on']?></span></h2>
                                    <?php echo $news_details['s_description']?>
							<?php } else {
								echo '<h3 style="padding:0px; border:0px; margin:0px;"><span>No record found</span></h3>';
								}
							?>		
                                    
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</div>