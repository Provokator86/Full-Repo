<?php 

/***

File Name: country view_detail.tpl.php 
Created By: ACS Dev 
Created On: May 29, 2015 
Purpose: CURD for Country 

*/


?>

<div id="content" class="" style="max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;">
   <div class="container-fluid">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class="row">
      
			<label class="col-md-4"><?php echo addslashes(t('name'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['name']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('FIPS104'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['FIPS104']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('ISO2'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['ISO2']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('ISO3'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['ISO3']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('ISON'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['ISON']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Internet'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Internet']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Capital'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Capital']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('MapReference'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['MapReference']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('NationalitySingular'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['NationalitySingular']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('NationalityPlural'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['NationalityPlural']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Currency'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Currency']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('CurrencyCode'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['CurrencyCode']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Population'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Population']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Title'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Title']; ?></p></div>
			<div class="clearfix"></div>
			<label class="col-md-4"><?php echo addslashes(t('Comment'));?> : </label>
			<div class="col-md-8"><p><?php echo $info[0]['Comment']; ?></p></div>
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
