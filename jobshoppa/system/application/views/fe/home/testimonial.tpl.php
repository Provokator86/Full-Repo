<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	//include_once(APPPATH."views/fe/common/common_search.tpl.php");
	?>
<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
           
	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>

	  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>

<?php } else {?>

	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } ?>	

<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->

    <div id="content_section">
    <div id="content">
        <div id="inner_container02">
            <div class="title">
                <h3><span>Testimonial</span></h3>
            </div>
            <div class="content_box">
				<?php
						if($testimonial_list){
						$i=1;
							foreach($testimonial_list as $val)
							{
								//$class = ($i++%2) ? 'left_box02 white_box' : 'left_box02 sky_box';
				?>
                <div class="testimonial_box">
                    <p class="test_txt"><img src="images/fe/q-mark-top.gif" alt="" /> 
					<?php echo $val['s_desc_full']?><img src="images/fe/q-mark-bot.gif" alt="" /></p>
					<?php /*?><a href="<?php echo base_url().'home/testimonial_details/'.encrypt($val['id']);?>" class="blue_link left">Read more</a><?php */?>
                    <p class="orng_txt14">- <?php echo $val['s_person_name']?></p>
                    <p class="grey_txt12"><?php echo $val['fn_entry_date']?></p>
                </div>
               <?php } } else {
							echo 'No record found';
						} ?>
                <div class="clr"></div>
				
                <div class="paging_box">
                   <?php echo $pagination;?>
                </div>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>