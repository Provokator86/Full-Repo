<div class="top_sction">
	<div class="menu">
		<ul>
			<li><a href="<?php echo base_url()?>" class="<?php echo ($this->menu_id == 1) ? 'current' : ''?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url().'search/restaurants'?>" class="<?php echo ($this->menu_id == 2) ? 'current' : ''?>"><span><?php echo $this->root_category[1]?></span></a></li>
			<li><a href="<?php echo base_url().'search/health'?>" class="<?php echo ($this->menu_id == 3) ? 'current' : ''?>"><span><?php echo $this->root_category[2]?></span></a></li>
			<li><a href="<?php echo base_url().'search/fun'?>" class="<?php echo ($this->menu_id == 4) ? 'current' : ''?>"><span><?php echo $this->root_category[3]?></span></a></li>
			<li><a href="<?php echo base_url().'search/shopping'?>" class="<?php echo ($this->menu_id == 5) ? 'current' : ''?>"><span> <?php echo $this->root_category[4]?></span></a></li>
			<li>
				<?php if($this->session->userdata('user_id') != '') { ?>
				<a href="<?php echo base_url().'party/add_party'?>" class="<?php echo ($this->menu_id == 6) ? 'current' : '';?>">
				<?php } else { ?>
				<a style="cursor: pointer;" onclick="tb_show('Login','<?=base_url()?>ajax_controller/ajax_show_login/plan_a_party?>?height=250&width=400');">
				<?php } ?>

				<span>Plan a party</span></a>
			</li>
<?php
// added by Arnab Chattopadhyay... [start]    
?>
            <li><a href="<?php echo base_url().'view_deals'?>" class="<?php echo ($this->menu_id == 9) ? 'current' : ''?>"><span>View Deals</span></a></li>
<?php
// added by Arnab Chattopadhyay... [end]    
?>            
			<li><a href="<?php echo base_url().'home/promote_your_business'?>" class="<?php echo ($this->menu_id == 8) ? 'current' : ''?>"><span>Promote your business</span></a></li>
		</ul>
		<div class="clear"></div>
	</div>
</div>