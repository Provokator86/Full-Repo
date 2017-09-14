<script>
function send_msg(param)
{
	//alert(param);
	$("#frm_msg_tra input[name=opd_job]").val(param)
	//$('#frm_msg_tra:input').val(param);
	$('#frm_msg_tra').submit();
}
jQuery(document).ready(function() {
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
		//console.log($(".lightbox1_main"));
});
</script>

<script language="javascript">
function search_job()
{
	//var job_id = job_id;
	$("#search_pmb").submit();
}
</script>
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
                <h3><span>Completed </span> jobs</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; Jobs that have been mutually agreed as completed &quot;</h6>-->
          <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;">
                            <div class="heading_box">
                                <div class="left">Total Jobs : <?=$i_completed_jobs?> </div>                                
                            </div>
							
							<div id="job_list">
							
							<?php echo $job_contents;?>
							</div>
							
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <?php
					include_once(APPPATH."views/fe/common/tradesman_right_menu.tpl.php");
				?>			
				
            </div>
            <div class="clr"></div>
        </div>		
		
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>