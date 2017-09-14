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
                <h3><span>Private</span> Message Board</h3>
            </div>
            <div class="clr"></div>
           <!-- <h6>&quot; Private Correspondance between you and your clients &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:916px;">
                            <div class="heading_box">
                                <div class="left">Total No. of Messages :<?php echo $total_message; ?></div>
								<form name="seacrh_pmb" id="search_pmb" action="<?php echo base_url().'private_message/tradesman_private_message_board'?>" method="post">							
                                <div class="right">
                                	Jobs:
                                    <select name="opd_job" id="opd_job" onchange="search_job()">                              
										  <option value="">Select</option>
										  <?php //echo makeOptionJob(" i_status!=0 ",$posted['src_job_id']) ?>
										  <?php echo makeOptionJobForProfessional(" j.i_status!=0 And p.i_tradesman_id = ".decrypt($user_id)."  ",$posted['src_job_id']) ?>
									</select>
                                 </div>
								</form>	
                            </div>
							
                             <div id="job_list">
                               <?php echo $pmb_list ?>
                            </div>
							
                            <div class="clr"></div>
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