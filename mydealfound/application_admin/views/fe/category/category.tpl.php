





<div id="body_container">
            <div class="separator"></div>
        	<div class="f_body">
            	<div class="fixed_banner">
                	<img src="<?php echo base_url();?>images/fe/fixed_banner.png" alt="banner"/> 
                </div>
            	<div class="clear">&nbsp;</div>
                
                
                <div id="category_coupon"> <?php echo $result;?></div>
                
                
                
                
                
                
                <div class="right_part">
                	
                    <div class="clear"></div>
                     <!--JOIN US-->
                	 <?php include_once(APPPATH."views/fe/common/right_panel_join_us.tpl.php"); ?>
                	 <!--JOIN US-->
                      <!--similar store-->
                	 <?php include_once(APPPATH."views/fe/common/similar_store.tpl.php"); ?>
                	 <!--similar store-->
                        
                    <!--<div class="ad">
                        <a href="#"><img src="<?php //echo base_url();?>images/fe/1click1call.png" alt="advertisement"/></a>
                    </div>-->
                     
                    <!--Subscribe-->
                    <?php include_once(APPPATH."views/fe/common/common_subscribe.tpl.php"); ?>
                    <!--Subscribe-->
                        
                        <!--google add-->
                    <?php if($google_adds){?>
                       <div class="google_ad">
                        	<?php echo $google_adds[0]['s_description'];?>
                        </div>
                        <?php }?>
                        
                        
                        <?php if($banner){ foreach($banner as $val) {?>
                    	<div class="ad">
                        	<a href="<?php echo make_valid_url($val['s_url']);?>" target="_blank"><img src="<?php echo base_url().'uploaded/banner/thumb/thumb_'.$val['s_image']; ?>" alt="advertisement"/></a>
                        
                        </div>
                        
                        <?php } ?><?php }?>
                    
                </div>
              <div class="clear">&nbsp;</div>  
            </div>
            </div>
            
            
            
