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
                <h3><span>My Personal</span> Message Board</h3>
            </div>
            <div class="clr"></div>
            <h6>&quot; Private Correspondance between you and your clients &quot;</h6>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:916px;">
                            <div class="heading_box">
                                <div class="left">Total No. of Messages :18</div>
								<form name="seacrh_pmb" id="search_pmb" action="<?php echo base_url().'private_message/private_message_board'?>" method="post">							
                                <div class="right">
                                	Jobs:
                                    <select name="opd_job" id="opd_job" onchange="search_job()>                              
										  <option value="">Select</option>
										  <?php echo makeOptionJob(" i_status!=0 ",$posted['src_job_id']) ?>
									</select>
                                    </div>
								</form>	
                            </div>
                            <?php
								if($pmb_list){
								$i=1;
									foreach($pmb_list as $val)
									{
										
								?>
                            <div class="job_box">
                                <div class="left_content_box">
                                	<p><a href="<?php echo base_url().'private_message/tradesman_private_message_details/'.encrypt($val['id']) ?>"><?php echo $val['s_content'] ?></a> </p>
                                    <p><span class="blue_txt">Author :</span> <?php echo $val['s_tradesman_name'] ?></p>
                                    <p class="grey_txt12">Posted on : <?php echo $val['dt_reply_on']?></p>
                                    <p class="blue_txt18"><?php echo $val['s_job_title'] ?></p>
                                    <p>&nbsp;</p>
                                </div>
                                <div class="right_content_box">
                                    <div class="top_c">&nbsp;</div>
                                    <div class="mid_c">
                                        <ul>
                                            <li ><a href="<?php echo base_url().'private_message/tradesman_private_message_details/'.encrypt($val['id']) ?>"><img src="images/fe/icon-29.png" alt="" /> View Message </a></li>
                                            <li class="last"><a href="<?php echo base_url().'job/job_details/'.encrypt($val['job_id']) ?>"><img src="images/fe/icon-29.png" alt="" /> View Jobs </a></li>
                                            <!--<li class="last"><a href="javascript:void(0);"  onclick="return show_dialog('cancel_box')"><img src="images/fe/delete.png" alt="" /> Delete Message</a> </li>-->
                                      </ul>
                                    </div>
                                    <div class="bot_c">&nbsp;</div>
                                </div>
                            </div>
                            
                            <?php } 
								}else {
										echo '<div class="job_box " style="padding:5px;">No record found</div>';
									} 
							?>
                            
                            
                            <div class="clr"></div>
                            <div class="paging_box" style="padding:5px 0;">
							<?php echo $pagination;?>
                               <!-- <ul>                                    
                                    <li><a href="javascript:void(0)" class="select">1</a></li>
                                    <li><a href="javascript:void(0)">2</a></li>
                                    <li><a href="javascript:void(0)">3</a></li>
                                    <li><a href="javascript:void(0)">4</a></li>
                                    <li><a href="javascript:void(0)">5</a></li>
                                    <li><span><a href="javascript:void(0)"><img src="../images/next.png" alt="" /></a></span></li>
                                </ul>-->
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