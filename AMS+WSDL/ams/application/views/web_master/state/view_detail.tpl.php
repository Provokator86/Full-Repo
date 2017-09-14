<?php 

/***

File Name: state view_detail.tpl.php 
Created By: ACS Dev 
Created On: May 29, 2015 
Purpose: CURD for State 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('i_country_id'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_country_id']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('name'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['name']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Code'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Code']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('ADM1Code'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['ADM1Code']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_status'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_status']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('i_is_deleted'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['i_is_deleted']; ?></p></div>
			<div class="clearfix"></div>
      </div>
   </div>
</div>
