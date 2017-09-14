 <!-- Footer_start -->
   
   	<footer>
    
    	<div class="main2">
        
        	<div class="footer_links_main">
                <span class="logo_icon"><img style="max-height: 37px;" src="images/logo/<?php echo $this->config->item('logo_icon'); ?>" /></span>
                <ul class="footer_links">
                
                	<?php 
		         if (count($cmsPages)>0){
		        ?>
		        <?php 
		        foreach ($cmsPages as $cmsRow){
		            if ($cmsRow['category'] == 'Sub' && $cmsRow['parent'] == '41'){
		        ?>
<!-- 		          <li><a href="pages/<?php echo $cmsRow['seourl'];?>"><?php echo $cmsRow['page_name'];?></a>.</li> -->
		        <?php 
		            }
		        }
		        ?>  
		        <?php 
		         }
		        ?>
                
                </ul>
                
                <ul class="footer_links2">
                
                	<?php 
		         if (count($cmsPages)>0){
		        ?>
		        <?php 
		        foreach ($cmsPages as $cmsRow){
		            if ($cmsRow['category'] == 'Main'){
		        ?>
		          <li><a href="pages/<?php echo $cmsRow['seourl'];?>"><?php echo $cmsRow['page_name'];?></a>.</li>
		        <?php 
		            }
		        }
		        ?>  
		        <?php 
		         }
		        ?>
                    <li><?php echo $footer?></li>
                    
                    <!--<li style="font-size: 12px;margin-left:5px;">Powered by <a style="font-size: 12px;" href="http://www.teamtweaks.com" target="_blank">Team Tweaks</a></li>-->
                
                </ul>
            
            </div>
        
        </div>
    
    </footer>
   
   
        
        
 	<!-- Footer_end -->

</li>
				
</body>
</html>