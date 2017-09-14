<script type="text/javascript">
$(document).ready(function() {
	$("#category li").click(function() {
	$("#category li a").removeClass('select_list');
	$(this).children('a').addClass('select_list');
	});
	
	$("#citylist li").click(function() {
	$("#citylist li a").removeClass('select_list');
	$(this).children('a').addClass('select_list');
	});
	
	/* click on post job button*/
	$("#btn_post_free").click(function() { 
		var arr_id;
		var src_cat_id ='';
		var src_city_id ='';
	 	$("a.select_list").each(function() {
		arr_id = $(this).parent().attr('id').split('_');
		if(arr_id[0]=='category')
		{
			 src_cat_id = arr_id[1];
		}
		else if(arr_id[0]=='city')
		{
			src_city_id = arr_id[1];
		}
	});
	
		if(src_cat_id=='' && src_city_id=='')
		{
		alert('<?php echo addslashes(t('please select something'))?>');
		}
		else
		{
			$("#h_cat").val(src_cat_id);
			$("#h_city").val(src_city_id);
			$("#frm_job_srch").submit();
		}
	
	});
	/* end click on post job button*/
	
});
</script>
<style>
.select_list{ background-color:#999999;}
ul li a:hover{ background-color:#CCCCCC}

</style>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
	<div class="top_part"></div>
	<div class="midd_part height02">
		  <div class="spacer"></div>
		  <h2><?php echo addslashes(t('Select the appropriate category for')) ?> - <?php echo $txt_service ?> </h2>
		  
		<div class="content_box">
		<div>	
			<ul id="category" style="margin-left:100px;">
			
			<?php if(count($service_category)>0) { echo '<span style="color:#0070C0;">'.addslashes(t('Category')).'</span>';
					foreach($service_category as $val)
						{
			 ?>
			  <li style="line-height:25px;" id="category_<?php echo encrypt($val['id']) ?>">
			  <a href="javascript:void(0);" style="text-decoration:none;"><?php echo $val['s_category_name'] ?></a>
			  </li>
				 
				 <?php } } else { ?>
				 <li style="line-height:25px;">
				 <?php echo addslashes(t('No match found for')).' - '.$txt_service ?>
			  	 </li>
			  <?php } ?>
			</ul>	
			<ul id="citylist" style="margin-left:100px;">
			
			<?php if(count($service_city)>0) { echo '<span style="color:#0070C0;">'.addslashes(t('City')).'</span>';
					foreach($service_city as $val)
						{
			 ?>
			  <li style="line-height:25px;" id="city_<?php echo encrypt($val['id']) ?>">
			  <a href="javascript:void(0);" style="text-decoration:none;"><?php echo $val['city'] ?></a>
			  </li>
				 
				 <?php } } ?>
			</ul>
		</div>
		<div class="spacer"></div>
			<div style="float:left; margin-left:100px;">
			<input type="button" class="login_button02" id="btn_post_free" value="<?php echo addslashes(t("Post Job"))?>" />
			</div>
		</div>
		
		  
	</div>
	<div class="spacer"></div>
	<div class="bottom_part"></div>
</div>
<form name="frm_job_srch" id="frm_job_srch" action="<?php echo base_url().'job/job-post' ?>" method="post">
<input type="hidden" name="h_cat" id="h_cat" value="" />
<input type="hidden" name="h_city" id="h_city" value="" />
</form>