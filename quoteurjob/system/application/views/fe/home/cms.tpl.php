<div class="body_bg">
			<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
          <?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>
		  <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>
            </div>
			<?php } else {?>
			<div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php } ?>
			
            <div class="static_content" id="static_cms_content">
                 
                        <h1><?php echo $pre ?> <span><?php echo $next ?> </span></h1>						
  			
						<?php if($info){ foreach($info as $val) { ?>
						<div><?php echo $val['s_full_description'] ?></div>
						<?php }} ?>
					
            </div>
        
      </div>