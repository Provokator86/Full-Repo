<?php 

/***

File Name: cms view_detail.tpl.php 
Created By: SWI Dev 
Created On: September 23, 2015 
Purpose: CURD for Cms 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('i_cms_master_id'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_cms_master_id']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_user_id'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_user_id']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_title'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_title']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_content'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_content']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('s_url'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_url']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('dt_add'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['dt_add']; ?></p></div>
			<div class="clearfix"></div>
      </div>
   </div>
</div>
