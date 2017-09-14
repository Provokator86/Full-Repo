<script>
jQuery(document).ready(function() {
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
		//console.log($(".lightbox1_main"));
});

function send_msg(param)
{
	$('#opd_job').val(param);
	$('#frm_msg').submit();
}
</script>
<div id="banner_section">
    <?php
	include(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php');
	?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
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
                <h3><span>Active</span> Jobs</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; All jobs that you have posted and have been approved by admin are listed below &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;" id="job_list">
                          <?php echo $job_contents;?>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <?php include_once(APPPATH.'views/fe/common/buyer_left_menu.tpl.php'); ?>
            </div>
            <div class="clr"></div>
        </div>
		
		
        <div class="clr"></div>
</div>
</div>
