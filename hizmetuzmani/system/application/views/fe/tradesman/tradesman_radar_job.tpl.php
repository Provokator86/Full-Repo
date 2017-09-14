<script type="text/javascript">
function show_all()
{
	$("#frm_sh_all").submit();
}

</script>
<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
            <div class="body_right">
                  <h1><img src="images//fe/job.png" alt="" /><?php echo get_title_string(t('Radar Jobs'));?>  <span>(<?php echo $tot_job;//echo $i_total_radar_job?>)</span></h1>
                  <h4><img src="images/fe/search.png" alt="" style="vertical-align:middle" /> <span><?php echo $tot_job?></span> <?php echo t('jobs found from your radar settings')?></h4>
				  <div class="grey_box02" style="padding-bottom:25px;">
                        <h3 class="left" style="border:0px; margin-bottom:0px;"><?php echo t('Radar Settings Details');?> </h3>
                        <div class="right"><a href="<?php echo base_url().'tradesman/job_radar/'?>" class="blue_link_line"><img src="images/fe/edit.png" alt="<?php echo t('Edit');?>"  title="<?php echo t('Edit');?>" /><strong>  <?php echo t('Edit radar settings');?></strong></a></div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:140px;"><?php echo t('Radius');?> </div>
                        <div class="fld011"><?php echo $posted['opt_radius']?> <?php echo t('mile(s)');?> </div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:140px;"><?php echo t('Postal Code');?></div>
                        <div class="fld011"><?php echo $posted['txt_postal_code'];?></div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:140px;"><?php echo t('Category');?> </div>
                        <div class="fld011"><?php echo $s_cat_name;?></div>
                        <div class="spacer"></div>
                                               
                       
                  </div>
                  <?php /*?><div class="grey_box02" >
				  		<form action="" method="post" >
                        <h3 style="border:0px;"><?php echo t('Filter option')?></h3>
                        <div class="lable01" style="width:90px;"><?php echo t('Radius')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_radius" id="opt_radius" style="width:244px;">
									<option value=""><?php echo t('Radius')?></option>
                                    <?php echo makeOptionRadiusOption('',encrypt($posted['opt_radius']))?>                             
							  </select>	
                              <script type="text/javascript">
							$(document).ready(function(arg) {
								$("#opt_radius").msDropDown();
								$("#opt_radius").hide();
							})
						</script>
                        </div>
                        <div class="lable01" style="width:90px;"><?php echo t('Postal Code')?></div>
                        <div class="fld01" style="width:240px;">
                             <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['txt_postal_code']?>"  style="width:230px;" />
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"><?php echo t('Category')?></div>
                        <div class="fld01" style="width:240px;">
                              <select name="opt_category_id" id="opt_category_id" style="width:244px;">                     
							  <option value=""> <?php echo t('All')?></option>
                                    <?php echo makeOptionCategory(" c.s_category_type='job' AND c.i_status=1 AND cc.i_lang_id =$i_lang_id", encrypt($posted['i_category_id']));?>
                              </select>
                             
                        </div>
                        <div class="spacer"></div>
                        <div class="lable01" style="width:90px;"></div>
                        <div class="fld01" style="width:300px;">
							  <input  class="button" type="Submit" value="<?php echo t('Search')?>" />
                              &nbsp;
							  <input  class="button" id="" onclick="javascript:show_all();" type="button" value="<?php echo t('Show All')?>"/>
                        </div>
						</form>
                        <div class="spacer"></div>
                  </div><?php */?>
                  <div id="job_list">
                  <?php echo $job_contents;?>
				  </div>
            <div class="spacer"></div>
      </div>
</div>
<form id="frm_sh_all" name="frm_sh_all" method="post" action="">
<input type="hidden" name="opt_radius" id="opt_radius" value="" />
<input type="hidden" name="opt_category_id" id="opt_category_id" value="" />
<input type="hidden" name="txt_postal_code" id="txt_postal_code" value="" />
<input type="submit" style="visibility:hidden;" />
</form>
