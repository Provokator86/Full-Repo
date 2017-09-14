<div id="header">
        <!-- logo -->
        <div id="logo"><a href="<?php echo base_url()?>"><img src="images/fe/logo.png" alt="" /></a><br />Your Marketplace for Local Services</div>
        <!-- /logo -->
        <!-- facebook like -->
        <div id="facebook_like">
		<div class="fb-like" data-send="true" data-width="320" data-show-faces="false"></div>
		
		<!--<img src="images/fe/f-like.png" alt="" width="70" height="24" /> 25 people like this		-->
		</div>
        <!-- /facebook like -->
        <!-- navigation -->
        <div id="navigation">
            <ul>
                <li><a href="<?php echo base_url()?>" class="<?php echo($this->i_menu_id==1)? 'select':''?>"><span><img src="images/fe/icon-01.png" alt="" />Home</span></a></li>
				<?php
				if(decrypt($loggedin['user_type_id'])!=2){
				?>
                <li><a href="<?php echo base_url().'job/job_post'?>" class="<?php echo($this->i_menu_id==2)? 'select':''?>"><span><img src="images/fe/icon-02.png" alt="" />Post a job</span></a></li>
				<?php
				}
				if(decrypt($loggedin['user_type_id'])!=1){
				?>
                <li><a href="<?php echo base_url().'job/find_job'?>" class="<?php echo($this->i_menu_id==3)? 'select':''?>"><span><img src="images/fe/icon-03.png" alt="" />Find a Job</span></a></li>
				<?php } 
				if(decrypt($loggedin['user_type_id'])!=2){
				?>
                <li><a href="<?php echo base_url().'find_tradesman'?>" class="<?php echo($this->i_menu_id==4)? 'select':''?>">				
				<span><img src="images/fe/icon-54.png" alt="" />Find a Professional</span></a></li>
				<?php } ?>
                <!--<li><a href="<?php echo base_url().'home/help'?>" class="<?php echo($this->i_menu_id==5)? 'select':''?>"><span><img src="images/fe/icon-04.png" alt="" />Help</span></a></li>-->
            </ul>
        </div>
        <!-- /navigation -->
        <div class="clr"></div>
    </div>