<?php if($blog_comments) {
		$i =1;
		foreach($blog_comments as $value)
		{
			$class = ($i%2==0)?"class='comment-box hover-bg'":"class='comment-box'";
			
 ?>
	<div <?php echo $class ?>>
		 <p><?php echo $value["s_comment"] ?></p>
		 <div class="date"><em><a href="<?php echo base_url().'profile/'.encrypt($value["i_user_id"]) ?>" style="color:#0099CC;"><?php echo $value["s_first_name"] ?></a> : <?php echo $value["dt_fe_created_on"] ?></em></div>
	</div>

<?php  $i++; } } else { ?>	 
<p>No comments found.</p>
<?php } ?>

<div class="page-number">
 	<?php echo $page_links; ?>
</div>
		 
	