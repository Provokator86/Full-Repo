<?php 

/***

File Name: category view_detail.tpl.php 
Created By: ACS Dev 
Created On: June 02, 2015 
Purpose: CURD for Category 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('s_category'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['s_category']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_parent_id'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_parent_id']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_status'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_status']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('e_deleted'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['e_deleted']; ?></p></div>
			<div class="clearfix"></div>
      </div>
   </div>
</div>
