<div class="page-content">
    <h2><img src="images/fe/following.png" alt="" /> Following</h2>
    
    <div id="following_list">
    	<?php echo $following_list; ?>
    </div>
    
    <div class="clear"></div>
    <span id="loading_container">
    	<div class="loader">&nbsp;</div>
    </span>
    
</div>
<script type="text/javascript">
    ///////	
	enable_lazy_loading_in_ajax_pagination('following_list','loading_container');
</script>