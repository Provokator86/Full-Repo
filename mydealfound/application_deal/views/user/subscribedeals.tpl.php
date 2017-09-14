<?php /*?><style type="text/css">
#container22 ul.tabs li{ width:auto;}
ul.tabs li{ font-size:16px;}
ul.tabs li.active{  font-size:16px;}
</style><?php */?>
<div class="clear"></div>
<div class="top_add_de"><img src="<?=base_url();?>images/ad_top.jpg"></div>
<div class="clear"></div>

<div class="content">
    <div class="account_section">
        <div class="pro">
            <div class="account_left">
				<!--<div class="pro_left_heading">My Account</div>-->
			<?php echo $this->load->view('elements/left_account_block_tpl.php');?>

			</div>

			<div class="account_right">

			<?php /*?><div id="container22">	
				<div id="tab1" class="tab_content22"><?php */?> 
					<div class="tb_hding account_box">
						<div id="deal_list"><?php echo $display_subs_listing?></div>    
					</div>
				 <?php /*?></div>		
			</div><?php */?>			

			</div>
			<div class="clear"></div>
        </div>

        <div class="clear"></div>
        <?php //echo $this->load->view('common/social_box.tpl.php');?>
        <div class="clear"></div>
    </div>	

   <?php /*?> <div class="right_pan">
            <div class="clear"></div>
        <?php echo $this->load->view('elements/subscribe.tpl.php');?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
       	<?php //echo $this->load->view('elements/latest_deal.tpl.php');?>
        <?php echo $this->load->view('elements/forum.tpl.php');?>
        <?php echo $this->load->view('common/ad.tpl.php');?>
        <div class="clear"></div>
    </div>	<?php */?>
    <div class="clear"></div>
</div>
<?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {

	<?php /*?>$(".tab_content22").hide();
	$(".tab_content22:first").show(); 

	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content22").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});<?php */?>

});
</script>