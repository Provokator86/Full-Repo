<script type="text/javascript">
jQuery(function($) {
$(document).ready(function(){

$("#btn_blog_srch").click(function(){

var blog_title = $("#search03").val();

	$.ajax({
				type: "POST",
				async: false,
				url: base_url+'home/ajax_search_blog_name',
				data: "txt_title="+blog_title,
				success: function(msg){
					if(msg)
					{
						 $("#blog_list").html(msg);
					}
				}
			})   // end post ajax


});

});
});

</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
	<!-- right panel -->
	<div class="search-details-right">
		<div class="small-search-bg">
			<div class="lable02">
				<input name="search03" type="text" id="search03" />
			</div>
			
			<input class="small-search-button" type="button" value="" id="btn_blog_srch" />
		</div>
	</div>
	<!-- right panel -->
	<!-- left panel -->
	 <div class="search-details-left bg">
	 	 <!-- blogs list -->
		 <div id="blog_list">
		 	<?php echo $blog_list; ?>
		 </div>
	 	 <!-- blogs list -->
		 
	 <div class="spacer">&nbsp;</div>
	 
	 </div>
	<br class="spacer" />
</div>