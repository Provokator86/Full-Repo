<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
	<div class="content_box">
		<h1><?php echo $info[0]['en_s_title']; ?></h1>	
		<?php echo $info[0]['en_s_description'];  ?>	  
		<div class="clear"></div>
	</div>
</div>
 <? $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function(){});
</script>