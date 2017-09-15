<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            
            <div class="static_content">
      
                        <h1><?php echo get_title_string(t('Testimonial'))?> </h1>
                        <div class="shadow_big">
							<div class="right_box_all_inner " style="padding:0px;">
						<?php
						if($testimonial_list){
						$i=1;
							foreach($testimonial_list as $val)
							{
								$class = ($i++%2) ? 'left_box02 white_box' : 'left_box02 sky_box';
						?>
                             
                                    <div class="<?php echo $class?>"> <img src="images/fe/dot1.png" alt="" class="left" />
                                          <p style="padding-bottom:0px;"> <?php echo $val['s_large_content']?></p>
                                          <img src="images/fe/dot2.png" alt=""  class="right"/>
                                          <div class="spacer"></div>
                                          <a href="<?php echo base_url().'home/testimonial_details/'.encrypt($val['id']);?>" class="blue_link left"><?php echo t('Read more..')?></a>
                                          <h2 style="text-align:right"><em>- <?php echo $val['s_person_name']?> </em><br />
                                                <span><?php echo $val['fn_entry_date']?></span></h2>
                                          <div class="spacer"></div>
                                    </div>
							  
						<?php }
						 } else {
							echo '<div class="right_box_all_inner " style="padding:0px;">'.t('No record found').'</div>';
						} ?>		
                            </div>	        
                                    
                              
                        </div>
                      <!--  <div class="page"> <a href="#"  class="active"> 1 </a> <a href="#"> 2 </a> <a href="#"> 3 </a> <a href="#"> 4 </a> <a href="#"> 5 </a><a href="#" style="background:none; color:#ff416b;">&gt;</a></div>-->
					<div class="page"> <?php echo $pagination;?></div>	
            </div>
            <div class="spacer"></div>
      </div>
</div>