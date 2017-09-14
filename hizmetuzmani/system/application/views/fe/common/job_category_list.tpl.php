<div class="category_left_box">
	<h5><?php echo addslashes(t('Jobs by Category'))?></h5>
		<ul>
			<?php if(count($category_list)>0) { 
					foreach($category_list as $val)
						{
                             $make_url   =   make_my_url($val['s_category_name']).'/'.encrypt($val['id']) ;
			 ?>
			  <li> <a href="<?php echo base_url().'job/find-job/'.$make_url ; ?>"><?php echo $val['s_category_name'] ?></a></li>
			 
			 <?php } } ?>
		</ul>
	<?php /*?><input class="small_button" value="<?php echo addslashes(t('All Category Jobs'))?>" type="button" /><?php */?>
</div>