<div class="page-content">
    <h2><img src="images/fe/following.png" alt="" /> Followers</h2>
    
    <div id="followers_list">
    	<?php echo $followers_list; ?>
    </div>
    
    <div class="clear"></div>
    <span id="loading_container_followers_list">
    	<div class="loader">&nbsp;</div>
    </span>
    
</div>
<script type="text/javascript">
    ///////	
	enable_lazy_loading_in_ajax_pagination('followers_list','loading_container_followers_list');
</script>