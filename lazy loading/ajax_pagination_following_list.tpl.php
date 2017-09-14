<?php if($following) { 
	
	foreach($following as $val)
		{
			$user_img = $val['s_profile_image']?'uploaded/user_profile/small_thumb/'.$val['s_profile_image']:"images/man.png";
?>
    <div class="person-list">
          <div class="user-img">
          <a href="<?php echo base_url().'profile/'.$val['i_user_id'] ?>"><img width="40" height="40" src="<?php echo $user_img ?>" alt="" /></a>
          </div>
          <a href="<?php echo base_url().'profile/'.$val['i_user_id'] ?>" class="user-name"><?php echo $val['s_username'] ?></a> 
    </div>

<?php	}

	}
 ?>
 
 <div class="pagination">
 	<?php echo $page_links ?>
 </div>