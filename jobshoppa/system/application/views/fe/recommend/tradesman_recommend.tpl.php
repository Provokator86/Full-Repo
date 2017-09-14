<script type="text/javascript">
$(document).ready(function(){

//$('input[id^="btn_recommend"]').each(function(i){
   $("#btn_recommend").click(function(){
       $("#recommend_frm").submit();
   }); 
//});   
	
	///////////Submitting the form/////////
$("#recommend_frm").submit(function(){	

    var b_valid=false;
	var chk_val=0;
	var email_valid=true;
	$("#div_err").hide();
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var i =1;
	
	var cnt = ($("input[name^='email_arr']")).length;
	//alert(cnt);
	var innt = false;
	//alert(cnt);

	for(i=1;i<=cnt;i++)
	{
		
		if($("#name_arr_"+i).val()!='' && $("#email_arr_"+i).val()!='')
		{
			if( reg.test($.trim($("#email_arr_"+i).val()))==false)
			{
				email_valid=false;
			}
			chk_val =1;
			b_valid=true;
			
		}
		else if($("#name_arr_"+i).val()!='' && $("#email_arr_"+i).val()=='')
		{
			chk_val =0;
			b_valid=false;
			s_err +='<div class="error_massage"><strong>Please provide corresponding email.</strong></div>';
		}
		else if($("#name_arr_"+i).val()=='' && $("#email_arr_"+i).val()!='')
		{
			chk_val =0;
			b_valid=false;
			s_err +='<div class="error_massage"><strong>Please provide corresponding name.</strong></div>';
		}
			//b_valid=false;
	}
	
	if(chk_val==0)
	{
		b_valid==false
		s_err ='<div class="error_massage"><strong>Please provide one name and email for same pair.</strong></div>';
	
	}
	if(email_valid==false)
	{
		s_err ='<div class="error_massage"><strong>Please provide proper email.</strong></div>';
	}
	
	
	 if(!b_valid || !email_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
		b_valid = false;
    }
    
    return b_valid;
}); 
	
	
	
});	

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
                <h3><span>Recommend</span> Us</h3>
            </div>
            <div class="clr"></div>
            <h6>We cant thank you enough for recommending us! Please check our referral program in the FAQ sections for more information.</h6>
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:878px;">
                            <div style="background-color:#d3f6fb; border:1px solid #00a0b9;">
                                <form action="<?php echo base_url().'recommend/tradesman_recommend' ?>" method="post" name="recommend_frm" id="recommend_frm">
                                <div id="form_box01">
                                    <div class="label06">Name :</div>
                                    <div class="field06">
                                        <input type="text" name="name_arr[]" id="name_arr_1" size="30" />
                                    </div>
                                    <div class="label06">Email :</div>
                                    <div class="field06">
                                        <input type="text" name="email_arr[]" id="email_arr_1" size="30" />
                                    </div>
                                    <div class="clr"></div>
                                    <div class="label06">Name :</div>
                                    <div class="field06">
                                        <input type="text" name="name_arr[]" id="name_arr_2" size="30" />
                                    </div>
                                    <div class="label06">Email :</div>
                                    <div class="field06">
                                        <input type="text" name="email_arr[]" id="email_arr_2" size="30" />
                                    </div>
                                    <div class="clr"></div>
                                    <div class="label06">Name :</div>
                                    <div class="field06">
                                        <input type="text" name="name_arr[]" id="name_arr_3" size="30" />
                                    </div>
                                    <div class="label06">Email :</div>
                                    <div class="field06">
                                        <input type="text" name="email_arr[]" id="email_arr_3" size="30" />
                                    </div>
                                    <div class="clr"></div>
                                    <div class="field05" style="text-align:center;"><span class="field05" style="text-align:center;">
                                        <input name="submit" id="btn_recommend" type="submit" value="Recommend" />
                                        </span></div>
                                    <div class="clr"></div>
                                </div>
							</form>
                                <div class="clr"></div>
                            </div>
                            <div class="clr" style="padding-bottom:15px;"></div>
                            <div class="heading_box"> Referral History</div>
                            <div class="job_box">
                                <p class="big_txt14"><strong>Waiver Benefit :</strong></p>
                                <p><span class="blue_txt"><?php echo $i_total_comm_waiver;?> Professional(s) joined :</span>1 Exemption</p>
                                <p><span class="blue_txt">Professional Referrals :</span> <?php echo $i_total_referred; ?></p>
                                <p><span class="blue_txt">Professionals Joined :</span> <?php echo $i_total_join ?></p>
                                <p><span class="blue_txt">Waiver Status :</span> <?php echo $i_comm_free_waiver_status;?></p>
                                <!--<p>Your have to bring in <?php //echo $i_remain_user; ?> more persons to join this site to get the next exemption</p> -->
                            </div>
							
							<?php
									if($rec_list){
									$i=1;
										foreach($rec_list as $val)
										{
											
							?>
                            <div class="job_box">
                                <p class="grey_txt12">Recommended on : <?php echo $val['dt_recommend_on'] ?></p>
                                <p><span class="blue_txt">Name :</span> <?php echo $val['s_name'] ?></p>
                                <p><span class="blue_txt">Email :</span> <a href="mailto:<?php echo $val['s_email'] ?>"><?php echo $val['s_email'] ?></a></p>
                                <p>&nbsp;</p>
                                <div class="blue_box02">
                                    <div class="b_top">&nbsp;</div>
                                    <div class="b_mid">
                                        <h2><?php echo $val['s_is_active'] ?></h2>
                                    </div>
                                    <div class="b_bot">&nbsp;</div>
                                </div>
                            </div>   
							<?php } 
								}else {
										echo '<div class="job_box">No record found</div>';
									} 
									
							 ?> 
                            
                            <div class="clr"></div>
                            <div class="paging_box" style="padding:5px 0;">
                                <?php echo $pagination ?>
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