<?php 
	if($blog_list) { $i = 1;		
		
		foreach($blog_list as $value)
			{
				$class = ($total_rows==$i)?"class='blog-box last-box'":"class='blog-box'";
				
 ?>
	<div <?php echo $class ?>>	
			  <div class="blog-headline"><a href="<?php echo base_url().'blog-comments/'.encrypt($value["id"]) ?>"><?php echo $value['s_title'] ?></a> </div>
			 <div class="date">
			 <ul>
			 <li><em><?php echo $value['dt_fe_created_on'] ?></em></li>
			 <li>|</li>
			 <li><em>Author: admin </em></li>
			  <li>|</li>
			 <li> <img src="images/fe/comments.png" alt="" /> <em><?php echo $value['i_comments'] ?> Comments</em></li>
			  <li>|</li>
			 </ul>
			 </div>
			 <br class="spacer" />
			 <!--<div class="left-photo">
			 <img src="images/fe/blog-property.png" alt="blog-property" />
			 </div>-->
			 <div class="text-box-right">
			 	<?php echo $value['s_description'] ?>
				<p><span><a href="<?php echo base_url().'blog-comments/'.encrypt($value["id"]) ?>">more...</a></span></p>
			
			<!-- <p>It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing. <br /><span><a href="blog-comment.html">more...</a></span></p>-->
			 </div>
			 
			<div class="spacer">&nbsp;</div>
	</div>

<?php $i++; } } else { ?>
<p>No blog found.</p>
<?php } ?>

<!--<div class="blog-box last-box">-->		 
 <div class="page-number">
 	<?php echo $page_links; ?>
</div>