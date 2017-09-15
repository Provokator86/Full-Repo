<script type="text/javascript">
$(document).ready(function(){

/*** generate more field ***/
		var max_allow_open = 6;
		var cnt = 4;
		$("#blue_link").click(function(){
			var str = '';	
			str +='<p>Name <input type="text" id="name_arr_'+cnt+'"  name="name_arr[]" style="margin-right:20px; width:280px;" /> Email <input type="text"  name="email_arr[]" id="email_arr_'+cnt+'"  style=" width:280px;"/></p>';
			
			$("#parent_div").append(str);
			
			cnt++;
			
			if(cnt>=max_allow_open)
			{
				$("#blue_link").remove();
			}
		});
	/*** end generate field ***/
	
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
<?php /*?>	if($("#email_arr_1").val()=='' && $("#email_arr_2").val()=='' && $("#email_arr_3").val()=='')
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide one name and email'))?>.</strong></span></div>';
			b_valid=false;
	}<?php */?>
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
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide corresponding email'))?>.</strong></span></div>';
		}
		else if($("#name_arr_"+i).val()=='' && $("#email_arr_"+i).val()!='')
		{
			chk_val =0;
			b_valid=false;
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide corresponding name'))?>.</strong></span></div>';
		}
			//b_valid=false;
	}
	
	if(chk_val==0)
	{
		b_valid==false
		s_err ='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide one name and email for same pair'))?>.</strong></span></div>';
	
	}
	if(email_valid==false)
	{
		s_err ='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide proper email'))?>.</strong></span></div>';
	}
	
	/*for(var i=1;i<=cnt;i++)
	{
		 if($("#email_arr_"+i).val()=='')
		 {
		 	innt = true;
		 }
	}
	if (innt)
	{
		s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide at least one email'))?>.</strong></span></div>';
			//b_valid=false;
		b_valid = false;
	}*/
	
<?php /*?>	$("input[id^='email_arr_']").each(function(){	
		
		if($.trim($(this).val())!='' && reg.test($.trim($(this).val()))==false)
		{
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide proper email'))?>.</strong></span></div>';
			b_valid=false;
		}
			
	
	});<?php */?>
	
	
	/*$("input[name^='name_arr[]']").each(function(){
		if($.trim($(this).val())=='')
		{			
			
			s_err +='<div class="error"><span class="left"><strong><?php echo addslashes(t('Please provide name'))?>.</strong></span></div>';
			b_valid=false;
		}
	
	});*/
	
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

<div id="div_container">
      <div class="body_bg">
            <div class="banner">
                  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>
            </div>
			<?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
			
			
            <?php include_once(APPPATH.'views/fe/common/tradesman_left_menu.tpl.php'); ?>
            
            <div class="body_right">
                  <h1><img src="images/fe/general.png" alt="" /> <?php echo get_title_string(t('Recommend Us'))?></h1>
                        
						<form action="<?php echo base_url().'recommend/tradesman_recommend' ?>" method="post" name="recommend_frm" id="recommend_frm">
						<div class="shadow_big">
                              <div class="right_box_all_inner">
							  <div id="div_err">
									<?php
										show_msg("error");  
										echo validation_errors();
									?>
							</div>	
							
                                    <div class="brd"><?php echo t('We hope this platform will make life easier for you, we are pretty sure you would want the same for your family, friends and neighbours. Please Recommend us')?>!!</div>
                                    <p><?php echo t('Name')?> 
                                          <input type="text"  name="name_arr[]"  id="name_arr_1" style="margin-right:20px; width:280px;" />
                                          <?php echo t('Email')?> 
                                          <input type="text"  name="email_arr[]" id="email_arr_1" style=" width:280px;" />
                                    </p>
                                    <p><?php echo t('Name')?> 
                                          <input type="text"  name="name_arr[]"  id="name_arr_2" style="margin-right:20px; width:280px;" />
                                          <?php echo t('Email')?> 
                                          <input type="text"  name="email_arr[]" id="email_arr_2"  style=" width:280px;" />
                                    </p>
									<div id="parent_div">
                                    <p><?php echo t('Name')?> 
                                          <input type="text"  name="name_arr[]"  id="name_arr_3" style="margin-right:20px; width:280px;" />
                                          <?php echo t('Email')?> 
                                          <input type="text"  name="email_arr[]" id="email_arr_3"  style=" width:280px;" />
                                    </p>
									</div>
                                    <div class="right"><a href="javascript:void(0);" id="blue_link" class="blue_link"><?php echo t('Add more')?></a></div>
                                    <input name="submit"  class="button left" type="submit" value="<?php echo t('Recommend')?>" style="margin-left:42px;"/>
                                    <div class="spacer"></div>
                              </div>
                              
                        </div>
                        </form>
				  
				  
                  <h3 style="border:0px;"><?php echo t('Referral History')?></h3>
                   <h4 style="font-size:13px;"> <?php echo $i_total_comm_waiver.t(' referral joins')?> : <span>1<?php echo t(' commission waiver.')?></span> </h4> 
                   <h4 style="font-size:13px;"> <?php echo t('Total No. you have referred')?> :<span> <?php echo $i_total_referred; ?></span></h4>      
                   <h4 style="font-size:13px;"> <?php echo t('Total Join')?>  : <span><?php echo $i_total_join ?></span></h4> 
                   <h4 style="font-size:13px;"> <?php echo t('Commission Free Waiver Status')?>  :<span><?php echo $i_comm_free_waiver_status;?></span></h4>
                 
                  <h3 style="color:#666666;"><?php echo t('You have to bring in ').$i_remain_user.t(' more persons to join this site to get the  next exemption')?></h3>
                  <div class="shadow_big">
                              <div class="right_box_all_inner" style="padding:0px;">
                                    <div class="top_bg_banner">
                                          <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td width="10" valign="top"></td>
                                                      <td width="128"  valign="top" align="left"><?php echo t('Name')?></td>
                                                      <td width="227" valign="top" align="left"><?php echo t('Email')?></td>
                                                      <td width="177" valign="top" align="center"><?php echo t('Recommend Date')?></td>
                                                      <td width="171" valign="top" align="center"><?php echo t('Status')?> </td>
                                                
                                                </tr>
                                          </table>
                                    </div>
									
									<?php
									if($rec_list){
									$i=1;
										foreach($rec_list as $val)
										{
											$class = ($i++%2) ? 'white_box' : 'sky_box';
									?>
							  
                              <div class="<?php echo $class ?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                      <td width="127" valign="top"><?php echo $val['s_name'] ?></td>
                                                      <td width="227" valign="top" align="left"><a href="mailto:<?php echo $val['s_email'] ?>" class="blue_link"><?php echo $val['s_email'] ?></a></td>
                                                      <td width="179" valign="top" align="center"><?php echo $val['dt_recommend_on'] ?></td>
                                                      <td width="170" valign="top" align="center" class=""><?php echo $val['s_is_active'] ?></td>
                                                </tr>
                                          </table>
                              </div>
							  
							  <?php }
									 } else {
										echo '<div class="white_box" style="padding:5px;">'.t('No record found').'</div>';
									} ?>
                                    
								   
                                   
                              </div>
                        </div>
                  		<div class="page">
							<?php echo $pagination ?>
						</div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
      </div>
</div>