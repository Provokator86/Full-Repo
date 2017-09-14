<?php if($followers) { 
	
	foreach($followers as $val)
		{
			$user_img = $val['follower_profile_image']?'uploaded/user_profile/small_thumb/'.$val['follower_profile_image']:"images/man.png";
?>
    <div class="person-list">
          <div class="user-img">
          <a href="<?php echo base_url().'profile/'.$val['i_follower_user_id'] ?>"><img width="40" height="40" src="<?php echo $user_img ?>" alt="" /></a>
          </div>
          <a href="<?php echo base_url().'profile/'.$val['i_follower_user_id'] ?>" class="user-name"><?php echo $val['s_follower_username'] ?></a> 
    </div>

<?php	}

	}
 ?>
 
 <div class="pagination">
 	<?php echo $page_links ?>
 </div>