<link type="text/css" href="css/fe/docs.css" rel="stylesheet" media="all" />
<link type="text/css" href="css/fe/jquery.mcdropdown.min.css" rel="stylesheet" media="all" />
<script type="text/javascript" src="js/fe/jquery.mcdropdown.min.js"></script>
<script type="text/javascript" src="js/fe//jquery.bgiframe.js"></script>
<script type="text/javascript">
<!--//
// on DOM ready
$(document).ready(function (){	
	
	//$("#current_rev").html("v"+$.mcDropdown.version);
	$("#category").mcDropdown("#categorymenu");
	$("#categorymenu li ul li").click(function(){		
		
	});
});
//-->
</script>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <?php include_once(APPPATH."views/fe/common/test_category_list.tpl.php"); ?>
                  <div class="find_job">
                        <h5>Find Job</h5>
                        <div class="found_box"><img src="images/fe/search.png" alt="" /> <?php echo $tot_job?> Job(s) found</div>
                        <p class="required02">You can search jobs easily specifing job type, category and location</p>
                        <div class="spacer"></div>
						
						<form name="frm_adv_src" id="frm_adv_src" action="<?php echo base_url().'job/find-job'?>" method="post">
						
                        <div class="job_search_box">
                        
                       <!-- <div class="lable">Category</div>-->
                        <div class="textfell05">
							Select categoy<br/>
							<input type="text" name="category" id="category" value="" />
								<ul id="categorymenu" class="mcdropdown_menu">
								<?php $i= 1; foreach($category_arr as $key=>$val) {
									
								 ?>
									<li rel="<?php echo 'cat_'.$i ?>">
										<?php echo $key ?>
										<ul>
										<?php foreach($val as $k=>$v) { ?>
											<li rel="<?php echo 'sub_'.$k ?>">
												<?php echo $v ?>							
											</li>
											<?php }  ?>
										</ul>
									</li>	
								<?php $i++; } ?>					
								</ul>
                       
                        </div>   
						
						<div class="spacer"></div>						
                       <!-- <input class="small_button margintop0" id="btn_save" value="<?php echo addslashes(t('Search'))?>" type="button"/>-->
                        <div class="spacer"></div>
                        <div class="spacer"></div>                        
                        </div>						
						</form>                        
						<!-- job listing  -->
                        <div class="find_box02" id="job_list">						
                         	<?php echo $job_contents;?>							
                        </div>
					
                      <div class="spacer"></div>
					
                  </div>
                  
                  
                  <div class="spacer"></div>
                  
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
	  
	  
	  