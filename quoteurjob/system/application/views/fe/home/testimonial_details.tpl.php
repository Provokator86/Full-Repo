<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            
            <div class="static_content">
                 
                        <h1><?php echo get_title_string(t('Testimonial'))?> </h1>
                       <div class="shadow_big">
                              <div class="right_box_all_inner">
							  <?php
							  	if($testimonial_details){ if($testimonial_details['i_is_active']==2){
							  ?>
                                      <img src="images/fe/dot1.png" alt=""  /> 
                                      <div class="left_box02" style="border-bottom:0px;padding:0px;"> 									                                   
                                         <?php echo $testimonial_details['s_content'];?>
                                          <img src="images/fe/dot2.png" alt=""  class="right"/> <br />
                                          <h2 style="text-align:right"><em>- <?php echo $testimonial_details['s_person_name'];?> </em><br />
                                                <span><?php echo $testimonial_details['fn_created_on'];?></span></h2>
                                            <div class="spacer"></div>
                                    </div>
								<?php } else echo t("No records found");}?>	
									
                              </div>
                        </div> 
             
            </div>
         
      </div>
</div>