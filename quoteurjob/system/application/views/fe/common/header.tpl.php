
<div id="header_mid">
            <div class="logo"><a href="<?php echo base_url()?>"><img src="images/fe/logo.png" alt="" /></a></div>
            <div class="nav">
                  <ul>
                        <li><a href="<?php echo base_url()?>" <?php echo ($this->i_menu_id==1)?'class="current"': '' ?>><img src="images/fe/home.png" alt="" /><?php echo t('Home')?></a></li>
						<?php
						if(decrypt($loggedin['user_type_id'])!=2){
						?>
                        <li><a href="<?php echo base_url().'job/job_post'?>" <?php echo ($this->i_menu_id==2)?'class="current"': '' ?>><img src="images/fe/post.png" alt="" /><?php echo t('Post a Job')?></a></li>
                        <li><a href="<?php echo base_url().'find_tradesman'?>" <?php echo ($this->i_menu_id==3)?'class="current"':'' ?>><img src="images/fe/search01.png" alt="" /><?php echo t('Find Tradesmen')?></a></li>
						<?php
						}
						if(decrypt($loggedin['user_type_id'])!=1){
						?>
                        <li><a href="<?php echo base_url().'job/find_job'?>" <?php echo ($this->i_menu_id==4)?'class="current"':'' ?>><img src="images/fe/search.png" alt="" /><?php echo t('Find a Job')?></a></li>
						<?php }?>
                        <li><a href="<?php echo base_url().'home/help'?>" <?php echo ($this->i_menu_id==5)?'class="current"':'' ?>><img src="images/fe/help.png" alt="" /><?php echo t('Help')?></a></li>
                  </ul>
            </div>
            <div class="spacer"></div>
</div>