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
                <h3><span>Jobs</span> Frozen</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; Congratulations, your clients have chosen you as the winning bidder, Please accept the job offer to win the bid &quot;</h6>-->
            <!--<p>From here you can view those jobs awarded to you by Clients. The Clients have selected you as the winning bidder but you havent accepted the job offer yet. Please accept the job offer to win the auction.</p>-->
			<p>Below you will find jobs awarded to you by clients. Once you accept a job, you will be prompted to pay a small
commission in order to get the clients contact details.</p>
            <p>&nbsp;</p>
          <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;">
                            <div class="heading_box">
                                <div class="left">Frozen Jobs : <?=$i_frozen_jobs?> </div>                                
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