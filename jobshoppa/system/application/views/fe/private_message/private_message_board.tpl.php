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
	include_once(APPPATH."views/fe/common/common_buyer_search.tpl.php");
	?>
<div id="content_section">
    <div id="content">
        <div id="inner_container02">
            <div class="title">
                 <h3><span>Private</span> Message Board</h3>
            </div>
            <div class="clr"></div>
           <!--<h6>&quot; Private Correspondance between you and professionals. &quot;</h6>-->
          <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:862px;">
                            <div class="heading_box">
                                <div class="left">Total No. of Messages :<?php echo $total_message ?></div>	
								<form name="seacrh_pmb" id="search_pmb" action="<?php echo base_url().'private_message/private_message_board'?>" method="post">							
									<div class="right"> Jobs :
										<select name="opd_job" id="opd_job" onchange="search_job()">                              
											  <option value="">Select</option>
											  <?php echo makeOptionJob(" i_buyer_user_id='".decrypt($user_id)."' And i_status!=0 And i_is_deleted!=1 ",$posted['src_job_id']) ?>
										</select>	
										
										<!--<input  class="button" type="submit" value="Search" style="margin-left:20px;" />-->
								   </div>
								</form>   
							  
                            </div>							 
							
                           <?php /*?> <div class="job_box">
                               <?php echo $pmb_list ?>
                            </div><?php */?>
							 <div id="job_list">
                               <?php echo $pmb_list ?>
                            </div>
                           
                            <div class="clr"></div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                 <?php
					include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php");
				?>
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>

<div class="cancel_box lightbox_all" style="display:none;">
<form name="ajax_frm_msg_del" id="ajax_frm_msg_del" action="<?php echo base_url().'private_message/delete_message'?>" method="post">
    <div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/close.png" alt="" /></a></div>
    <div class="top">&nbsp;</div>
    <div class="mid">
        <div class="title">
            <h3><span>Do you  want to</span> delete this message?</h3>
        </div>
        <div class="clr"></div>
        <br /> 
       
          <p style="text-align:center"> 
		  <input type="hidden" name="h_msg_id" id="h_msg_id" value="<?php echo $i_msg_id?>" />
		  <input name="msg_del" type="radio" value="1" checked="checked" /> Yes &nbsp; 
		  <input name="msg_del" type="radio" value="2" /> No
		  </p>
		  <br />	
           <p style="text-align:center"><input type="submit" name="btn_sub" id="btn_sub" value="Submit" /></p>
       
        <div class="clr"></div>
    </div>
    <div class="bot">&nbsp;</div>
</form>
</div>