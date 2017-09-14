<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                
                  <h2><?php echo addslashes(t('How it works'))?></h2>
                  <!--<h3>Find reliable local <strong>Tradesman - for FREE!</strong></h3>-->
				  <h3><?php echo $info[0]['s_content1']; ?></h3>
                  
                  <div class="spacer"></div>
                  <div id="div_container">
    <ul class="tab7">
      <li><a href="JavaScript:void(0);" title="post_a_Job" class="tab1 active1"><span><?php echo addslashes(t('Post a Job for free'))?> </span></a></li>
      <li>|</li>
      <li><a href="JavaScript:void(0);" title="get_quotes" class="tab1"><span> <?php echo addslashes(t('Get Quotes From Tradesman'))?></span></a></li>
      <li>|</li>
      <li><a href="JavaScript:void(0);" title="tradesman" class="tab1"><span> <?php echo addslashes(t('Hire the best Tradesman'))?></span></a></li>
      <li>|</li>
      <li><a href="JavaScript:void(0);" title="leave_feedback" class="tab1"><span> <?php echo addslashes(t('Leave Feedback'))?></span></a></li>
    </ul>
    <div class="spacer"></div>
    
    <div class="body_right_03_inner">
    
    <!--1st tab-->
      <div class="tsb_text02" id="post_a_Job" style="display:block;">
       <?php echo $info[0]['s_content2'] ?>
	  <div class="spacer"></div>
      </div>
     <!--1st tab-->  
     
     
      <!--2nd tab--> 
      <div class="tsb_text02" id="get_quotes" style="display:none;">
       <?php echo $info[0]['s_content3'] ?>
      </div>
      <!--2nd tab-->
      
      
      <!--3rd tab-->
      <div class="tsb_text02" id="tradesman" style="display:none;">
        <?php echo $info[0]['s_content4'] ?>
      </div>
      <!--3rd tab-->
      
      
      <!--4th tab-->
      <div class="tsb_text02" id="leave_feedback" style="display:none;">
       <?php echo $info[0]['s_content5'] ?>
      </div>
       <!--4th tab-->
      
      
    </div>
</div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>