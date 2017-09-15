<script type="text/javascript">
	$(document).ready(function(){
	$("input[id^='txt_quote_']").numeric({});
	 
});
	function quote_edit(elem)
	{
		$("span[id^='sp_save_']").hide();
		$("span[id^='sp_edit_']").show();
		$("input[id^='txt_quote_']").addClass('disable_css');
		$("input[id^='txt_quote_']").attr("disabled","disabled");
		$("#txt_quote_"+elem).removeAttr("disabled");
		$("#txt_quote_"+elem).removeClass('disable_css');
		$("#txt_quote_"+elem).addClass('enable_css');
		$("#sp_edit_"+elem).hide();
		$("#sp_save_"+elem).show();
	}

	function quote_save(elem,jobs_id,quote_id)
	{
		var b_valid = true;
		
		if($.trim($("#txt_quote_"+elem).val())=='')
			b_valid = false;
		
		if(b_valid)
		{
			$.ajax({
				type: "POST",
			    url: base_url + "tradesman/do_quote_update",
			   data: {
			   			s_job_id:jobs_id,
						d_quote_amt:$("#txt_quote_"+elem).val(),
						s_quote_id:quote_id
			   		},
			   dataType: 'JSON',
			   success: function(res){
			 //  	$.fancybox.blockUI();
				 if(res.flag)
				 {
				 	
					$('#div_err1').html('<div class="success"><span class="left">'+res.msg+'</span><div>').show();
					//window.location.reload();
					$("span[id^='sp_save_']").hide();
					$("span[id^='sp_edit_']").show();
					$("input[id^='txt_quote_']").addClass('disable_css');
					$("input[id^='txt_quote_']").attr("disabled","disabled");
				 }
				 else
				 {
				 	$('#div_err1').html('<div class="error"><span class="left">'+res.msg+'</span><div>').show();;
				 }
			   }

			});
		}
		else
		{
			$('#div_err1').html('<div class="error"><span class="left"><?php echo addslashes(t('Quote amount can not be left blank.'))?></span><div>');
		}
	}
</script>
<div class="shadow_big" >
				<div id="div_err1">
				</div>
                        <div class="right_box_all_inner" style="padding:0px;">
                              <div class="top_bg_banner">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="6"></td>
                                                <td valign="top" width="406" align="left"><?php echo t('Job Details')?> </td>
                                                <td valign="top" width="116" align="center"><?php echo t('Location')?> </td>
                                              
                                                <td valign="top" width="120" align="center"><?php echo t('Quoted Price')?></td>
                                                <td valign="top" width="65" align="center"><?php echo t('Option')?> </td>
                                          </tr>
                                    </table>
                              </div>
							  <?php
							  if($job_list)
							  {
							  //pr($job_list);
							  	$i=1;
									foreach($job_list as $val)
									{
									//pr($val,1);
							  ?>
                              <div class="<?=($i++%2)?'white_box':'sky_box'?>">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                                <td valign="top" width="402"><h5><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>" class="blue_link"><?=$val['job_details']['s_title']?></a></h5>
                                                      <p><?php echo substr_details($val['job_details']['s_description'])?></p>
                                                      <p><?php echo t('Category')?>: <span class="light_grey_txt"><?=$val['job_details']['s_category']?></span> &nbsp; | &nbsp; <?php echo t('Expiry Date')?> <span class="light_grey_txt"><?=$val['job_details']['dt_expire_date']?></span> &nbsp; | &nbsp; <?php echo t('Budget')?> : <span class="light_grey_txt"><?=$val['job_details']['s_budget_price']?></span> </p>
                                                    
                                                </td>
                                                <td valign="top" width="117" align="center"><?=$val['job_details']['s_state']?>, <?=$val['job_details']['s_city']?>,<br><?=$val['job_details']['s_postal_code']?></td>  
                                                <td valign="top" width="120" align="center">
												<?=$default_currency?>
												<?php if($val['i_job_status']==1 && $val['i_status']==1){ ?>
												<input name="txt_quote_<?=$i?>" id="txt_quote_<?=$i?>" type="text" disabled="disabled" value="<?=$val['d_quote']?>" class="disable_css"  /> 
												<span id="sp_edit_<?=$i?>">
                                                 <a href="javascript:void(0);" 
												 onclick="javascript:quote_edit(<?=$i?>)">
												 	<img src="images/fe/edit.png" 
													alt="<?php echo t('Edit')?>" title="<?php echo t('Edit')?>"/>
												 </a>
												 </span>
												 <span id="sp_save_<?=$i?>" style="display:none">
												  <a href="javascript:void(0);" 
												  onclick="javascript:quote_save(<?=$i?>,'<?=encrypt($val['i_job_id'])?>','<?=encrypt($val['id'])?>')">
												 <img src="images/fe/save.png" alt="<?php echo t('Save')?>" title="<?php echo t('Save')?>" />
												 </a>
												 </span>
												 <?php 
												 	}
													else
													{
														echo $val['d_quote'];
													}
												 ?>
												 </td>
                                                <td valign="top"  width="64" align="center"><a href="<?=base_url().'job/job_details/'.encrypt($val['i_job_id'])?>"><img src="images/fe/view.png" alt="<?php echo t('View');?>" title="<?php echo t('View');?>" /></a>  &nbsp;
												<?php /*?><a href="javascript:void(0);" onclick="send_msg('<?php echo encrypt($val['i_job_id']);?>')"><?php */?>
												<a href="javascript:void(0);" onclick="window.location.href='<?php echo base_url().'private_message/private_msg_land/'.encrypt($val['i_job_id'])?>'"><img src="images/fe/pmb.png" alt="<?php echo t('My Private Message Board');?>" title="<?php echo t('My Private Message Board');?>"/></a> </td>
                                          </tr>
                                    </table>
                              </div>
                              <?php 
							  		}
							  } else echo ' <div class="white_box" style="padding:5px;">'.t('No Record Found').'</div>';?>  
                    
                              
                        </div>
                  </div>
                  <div class="page"> 
				  <?php echo $page_links;?>
				  </div>