<script>
$(document).ready(function(){

	$('#btn_sub').click(function(){
		$('#frm_category').submit();
	});
	
}); 
</script>
<div class="banner_for_all">
                        <ul class="top_bar">
                              <li><a href="<?php echo base_url()?>"><img src="images/fe/home1.png" alt="" /> <?php echo t('Home')?></a></li>
							  <?php
							  if($breadcrumb)
							  {
							  	$total  = count($breadcrumb);
								$x=1;
							  	foreach($breadcrumb as $key=>$val){
							  ?>
                              	<li> &raquo;</li>
								<?php
									if($x==$total)
            						{
								?>
                              		<li><?php echo $key;?></li>
								<?php
									}else{
								?>									
									<li><a href="<?php echo $val;?>"><?php echo $key;?></a></li>
							  <?php
							  		}
									$x++;	
							  	}
							  }
							  ?>	
                        </ul>
						<form name="frm_category" id="frm_category" method="post" action="<?php echo base_url().'job/find_job'?>">                        <div class="search">
                              <div class="lable03"><?php echo t('What Job Do You Need')?>?</div>
                              <div class="fld03">
                                    <input type="text"  name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_job_fulltext_src']?>" />
                              </div>
                        
                              <div class="fld03" style="width:80px;">
                                    <input  class="button03" type="button" id="btn_sub" onclick="javacript:void(0);"/>
                              </div>
                              <div class="spacer"></div>
                              
                        </div>
						</form>
                  </div>