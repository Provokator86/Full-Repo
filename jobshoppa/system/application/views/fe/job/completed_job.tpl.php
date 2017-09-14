<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH."views/fe/common/common_search.tpl.php");
	?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
	//include_once(APPPATH."views/fe/common/message.tpl.php");
	?>
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Completed </span> Jobs</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>You can find jobs easily by specifying job category</h6>-->
			
            <p>&nbsp;</p>
			
			<?php /*?><form name="frm_adv_src" id="frm_adv_src" action="<?php echo base_url().'job/find_job'?>" method="post">
            <div class="search_job_02">
                <div class="label02">Category :</div>
                <div class="field01">
                    <select name="i_category_id" id="i_category_id">                     
					  <option value="">All</option>
							<?php echo makeOptionCategory(" s_category_type='job' AND i_status=1", $posted['src_job_category_id']);?>
							
					  </select>
                </div>
                <div class="label02">City : </div>
                <div class="field01">
				  <select name="opt_city_id" id="opt_city_id">
						<option value="">All</option>
						<?php echo makeOptionCity('', $posted['src_job_city_id'])?>
				  </select>
                    
                </div>
                <div class="clr"></div>
                <div class="label02">Postal Code : </div>
                <div class="field01">
                    <input type="text"  name="txt_postal_code" id="txt_postal_code" value="<?php echo $posted['src_job_postal_code']?>" />
                </div>
                <div class="label02">Radius : </div>
                <div class="field01">
                   <select name="opt_radius" id="opt_radius">
						<option value="">Select</option>
						<?php echo makeOptionRadiusOption('', $posted['src_job_radius'])?>                             
				  </select>	
                </div>
                <div class="clr"></div>
                <div class="label02">Job Type : </div>
                <div class="field01">
                    <select name="opt_status" id="opt_status">
						<option value="">All</option>
						<?php //echo makeOptionJobStatus(array("0","2"), $posted['src_job_status'])?>
						<?php echo makeOption($arr_find_job_status,$posted['src_job_status']);?>
				  </select>
                </div>
                <div class="label02">Results / Page: </div>
                <div class="field01">
                    <select name="opt_record" id="opt_record">
							<option value="">Select</option>
							<?php echo makeOptionPaginationOption('',$posted['src_job_record']);?>
					  </select>
                </div>
                <div class="clr"></div>
                <div class="search_button">
				<input type="hidden" name="txt_fulltext_src" id="txt_fulltext_src" value="<?php echo $posted['src_job_fulltext_src']?>" />
				<input type="hidden" name="txt_fulladd_src" id="txt_fulladd_src" value="<?php echo $posted['src_job_fulladd_src']?>" />
                <input type="submit" value="Search" />
                </div>
                <div class="clr"></div>
            </div>
			</form><?php */?>
			
            <div class="search_job_result">
                <div class="result_box">
                    <div class="top">&nbsp;</div>
                    <div class="mid"  id="job_list">
                       
                        <?php echo $job_contents;?>
                        
                        
                       
                        <div class="clr"></div>
                    </div>
                    <div class="bot">&nbsp;</div>
                </div>
            </div>
        </div>
		
		
        <div class="clr"></div>
</div>
</div>
