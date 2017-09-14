<div id="body_container">
            <div class="separator"></div>
        	<div class="f_body">
            	<div class="fixed_banner">
                	<img src="<?php echo base_url()?>images/fe/fixed_banner.png" alt="banner"/> 
                </div>
            	<div class="clear">&nbsp;</div>
                <div class="left_part">
                    
                    <div class="active_coupons top_coupons">
                    	<h2>New<span> Coupons</span></h2>
                        
                        
                       	  	<div id="new_coupon">
								<?php echo $result;?>
							</div> 
                       
                        <div class="clear"></div>  
                    </div>
					
                </div>
				
				<!--Dont Know why this needed..if you remove this design will get destoted-->
				
				
                <div class="right_part">
                	
                    <div class="clear"></div>
                    <!--JOIN US-->
     <?php include_once(APPPATH."views/fe/common/right_panel_join_us.tpl.php"); ?>
     <!--JOIN US-->
                     
     <!--Discount Store-->
     <?php include_once(APPPATH."views/fe/common/max_discount_store.tpl.php"); ?>
     <!--Discount Store-->
                        
                    
                     
                     <!--Subscribe-->
    <?php include_once(APPPATH."views/fe/common/common_subscribe.tpl.php"); ?>
    <!--Subscribe-->  
					
                    <?php if($google_adds){?>
                       <div class="google_ad">
                        	<?php echo $google_adds[0]['s_description'];?>
                        </div>
                        <?php }?>
                    	
					<?php if($banner){ foreach($banner as $val) {?>
                    	<div class="ad">
                        	<a href="<?php echo make_valid_url($val['s_url']);?>" target="_blank"><img src="<?php echo base_url().'uploaded/banner/thumb/thumb_'.$val['s_image']; ?>" alt="advertisement"/></a>
                        
                        </div>
                        
                        <?php } ?><?php }else {?>  
						
						
						
						<?php } ?>
                    
                </div>
				
				
              <div class="clear">&nbsp;</div>  
            </div>
            </div>