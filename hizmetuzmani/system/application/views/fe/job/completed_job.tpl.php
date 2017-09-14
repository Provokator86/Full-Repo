<script>
$(document).ready(function(){
	$('#txt_postal_code').alphanumeric({});
});
</script>
<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
            <div class="body_left">
               <?php include_once(APPPATH.'views/fe/common/job_category_list.tpl.php'); ?>
				  
				  
            </div>
            <div class="body_right">
                  <h1><?php echo get_title_string(t('Completed Jobs'))?></h1>
                  <h4 class="left"><img src="images/fe/search.png" alt="" style="vertical-align:middle" /> <span><?php echo $tot_job?></span> <?php echo t('Job(s) found')?></h4>
                  <span class="right" style="color:#989898"><?php //echo t('You can find jobs easily specifing job type, category and location')?>.</span>
                  <div class="spacer"></div>
				  
				  <?php /*?><form name="frm_adv_src" id="frm_adv_src" action="<?php echo base_url().'job/find_job'?>" method="post">
                  <div class="grey_box02">
                        <div class="lable01" style="width:90px;"><?php echo t('Category')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="i_category_id" id="i_category_id" style="width:244px;">                     
							  <option value=""> <?php echo t('All')?></option>
                                    <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id", $posted['src_job_category_id']);?>
									
                              </select>
                             <!-- <script type="text/javascript">
                                $(document).ready(function(arg) {
                                    $("#i_category_id").msDropDown();
                                    $("#i_category_id").hide();
                                })
                            </script>-->
                        </div>
						
						
						
                        <div class="lable01" style="width:90px;"><?php echo t('Postal code')?></div>
                        <div class="fld01" style="width:240px;">
                              <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['src_job_postal_code']?>"  style="width:230px;" />
                        </div>						
						
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"><?php echo t('City')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_city_id" id="opt_city_id" style="width:244px;">
                                    <option value=""> <?php echo t('All')?></option>
									<?php echo makeOptionCity('', $posted['src_job_city_id'])?>
                              </select>
                              <!--<script type="text/javascript">
                                        $(document).ready(function(arg) {
                                            $("#opt_city_id").msDropDown();
                                            $("#opt_city_id").hide();
                                        })
                                    </script>-->
                        </div>
						
                        <div class="lable01" style="width:90px;"><?php echo t('Radius')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_radius" id="opt_radius" style="width:244px;">
									<option value=""><?php echo t('Select')?></option>
                                    <?php echo makeOptionRadiusOption('', $posted['src_job_radius'])?>                             
							  </select>							  
                              <!--<script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_radius").msDropDown();
									$("#opt_radius").hide();
								})
							</script>-->
                        </div>
						
						
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"><?php echo t('Job Type')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_status" id="opt_status" style="width:244px;">
							  		<option value=""> <?php echo t('All')?></option>
                                    <?php //echo makeOptionJobStatus(array("0","2"), $posted['src_job_status'])?>
									<?php echo makeOption($arr_find_job_status,$posted['src_job_status']);?>
                              </select>
                              <!--<script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_status").msDropDown();
									$("#opt_status").hide();
								})
							</script>-->
                        </div>
                        <div class="lable01" style="width:90px;"><?php echo t('Results / Page')?></div>
                        <div class="fld01" style="width:240px;">
                               <select name="opt_record" id="opt_record" style="width:244px;">
                                    <option value=""><?php echo t('Select')?></option>
                                    <?php echo makeOptionPaginationOption('',$posted['src_job_record']);?>
                              </select>
                              <!--<script type="text/javascript">
								$(document).ready(function(arg) {
									$("#opt_record").msDropDown();
									$("#opt_record").hide();
								})
							</script>-->
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"></div>
                        <div class="fld01" style="width:240px;">
								<input type="hidden" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_job_fulltext_src']?>" />
								<input type="hidden" name="txt_fulladd_src" id="txt_fulladd_src" value="<?php echo $posted['src_job_fulladd_src']?>" />
                              <input  class="button" type="Submit" value="<?php echo t('Search')?>" />
                        </div>
                        <div class="spacer"></div>
                  </div>
				  </form><?php */?>
				  <div id="job_list">
                  <?php echo $job_contents;?>
				  </div>
            </div>
            <div class="spacer"></div>
      </div>
</div>