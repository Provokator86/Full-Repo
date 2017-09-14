<div class="photo_album">
<?php  if($images)
		  {
			foreach($images as $val)
			{	 
			$src_img = $val['s_image']?base_url().'uploaded/album/thumb/thumb_'.$val['s_image']:""; 
			$photo_id = (strlen($val['id'])>1)?$val['id']:"0".$val['id'];
  ?>
	  <div class="photo">
	  <a href="javascript:void(0);" onclick="show_dialog('photo_zoom<?php echo $photo_id ?>')">
	  <img src="<?php echo $src_img ?>" alt="" height="75" width="100" />	  
	  </a>
	  	<div class="close_img" onclick="delete_album_image('<?php echo encrypt($val['id']); ?>');" id="img_<?php echo encrypt($val['id']); ?>"><img src="images/fe/close_small.png" /></div>
			<h5><?php echo $val['fn_entry_date'] ?> <br/>
		    <span><?php echo $val['s_title'] ?></span></h5>
	  </div>
<?php } } ?>	  
	  
	  <div class="spacer"></div>
</div>

<div class="spacer"></div>

	<div class="page">
	 <?php echo $page_links; ?>
  </div>
<div class="spacer"></div>
<!-- lightbox -->
<?php if($images)
		  {
			foreach($images as $val)
			{	
			$src_img = $val['s_image']?base_url().'uploaded/album/'.$val['s_image']:""; 
			$photo_id = (strlen($val['id'])>1)?$val['id']:"0".$val['id'];
  ?>
<div class="lightbox02 photo_zoom<?php echo $photo_id ?>">
      <div class="close"><a href="javascript:void()" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
      
      <div class="photo_big"><img src="<?php echo $src_img ?>" alt="<?php echo $val['s_title'] ?>" width="250" height="235" /></div>
	  <div class="spacer"></div>
</div>
<?php } } ?>	
