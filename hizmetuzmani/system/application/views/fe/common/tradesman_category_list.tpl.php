 <div class="category_left_box">
	<h5><?php echo addslashes(t('Tradesman by Category'))?></h5>
	<ul>
		  <?php if(count($category_list)>0) { 
					foreach($category_list as $val)
						{
                            
			 ?>
			  <li> <a href="<?php echo base_url().'find-tradesman/'.encrypt($val['id']) ?>"><?php echo $val['s_category_name'] ?></a></li>
			 
			 <?php } } ?>	 
	</ul>
	<?php /*?><input class="small_button" value="<?php echo addslashes(t('All Tradesman'))?>" type="button" /><?php */?>
</div>