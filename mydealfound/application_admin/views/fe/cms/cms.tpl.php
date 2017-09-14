<div id="body_container">
    <div class="separator"></div>
        <div class="f_body">
        	<div class="clear">&nbsp;</div>
        		<?php $title=explode(" ",$info['s_title']);?>
                <div class="privacy_policy">
                	<h2><?php echo $title[0]?>&nbsp <span><?php echo $title[1]?></span> &nbsp<?php echo $title[2]?></h2>
                    <?php //pr($info);?>
                    <span>
                    <?php echo $info['s_description'];?>
                    </span>
                    
                </div>
        
        <div class="clear">&nbsp;</div>  
    </div>
</div>