<style type="text/css">
.success_massage{ color:green; float: left; font-weight: bold; margin-left: 5px; }
.error_massage{ color:red; }
</style>
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
				<div class="inr_contain">					
					<div class="referral_link">
						<div class="referral_link_left" style="width: auto;">Your referral link:</div>
						<div class="referral_link_right" style="float: left;">
							<?php /*?><input name="test" type="text" readonly="yes" value="<?php echo base_url().'?ref='.$ref_id.'' ?>" class="referral_link_right_input"><?php */?>
							<input name="test" type="text" readonly="yes" value="<?php echo $ref_id;?>" class="referral_link_right_input">
						</div>
						<div class="clear"></div>
					</div>	
				</div>
				
				
				<div class="fb">
					<a id="ref_fb" target="_blank"  href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($ref_id) ?>&t=<?php echo urlencode($ref_name) ?>" onclick="javascript:window.open(this.href, 'sharer', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600'); return false;">
	<img src="<?php echo base_url().'images/fbshare.jpg' ?>" alt=""/></a>
	
					<a id="ref_tw" href="http://twitter.com/home?status=<?php echo urlencode($ref_name) ?>+<?php echo urlencode($ref_id) ?>"  onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false;"><img src="<?php echo base_url().'images/twshare.jpg' ?>" alt=""/></a>
					
					<a id="ref_gp" href="https://plus.google.com/share?url=<?php echo urlencode($ref_id) ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600');return false"><img src="<?php echo base_url().'images/gpshare.jpg' ?>" alt=""/></a>			
				
				</div>
				
			
				<div class="account_box">
				<form action="<?= base_url() ?>user/invite" method="post" id="invite_form" class="invite_form">            
					<h1>Invite Friend</h1>
					<div id="err_flds" style="text-align:center; margin-bottom:20px;">
					<?php
					if($message!='')
					{
						if($message_type=='err')
							echo '<div class="error_massage">'.$message.'</div>';
						if($message_type=='succ')
							echo '<div class="success_massage">'.$message.'</div>';
					}
					?>
					</div>
					
					<!--<div class="in_clm">
						<div class="in_rw1">First Name:</div>
						<div class="in_rw2">
						<input name="fname[]" type="text" class="in_rw_input" >
						</div>	
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
	
					<div class="in_clm">
						<div class="in_rw1">Email Address:</div>
						<div class="in_rw2">
						<input name="email[]" type="text" class="in_rw_input" from-validation="required|email">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
					<div class="in_clm">
						<div class="in_rw1">&nbsp;</div>
						<div class="in_rw2">
							<input class="in_rw_submit5" name="Submit" type="submit" value="Submit" />
							</div>
					</div>
					<div class="clear"></div>-->
					<div class="clear"></div>
					<div class="label06">Name <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="name_arr[]" class="in_rw_input" id="name_arr_1" size="30" />
					</div>
					<div class="label06">Email <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="email_arr[]" class="in_rw_input" id="email_arr_1" size="30" />
					</div>
					<div class="clear"></div>
					
					<div class="label06">Name <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="name_arr[]" class="in_rw_input" id="name_arr_2" size="30" />
					</div>
					<div class="label06">Email <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="email_arr[]" class="in_rw_input" id="email_arr_2" size="30" />
					</div>
					<div class="clear"></div>
					
					<div class="label06">Name <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="name_arr[]" class="in_rw_input" id="name_arr_3" size="30" />
					</div>
					<div class="label06">Email <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="email_arr[]" class="in_rw_input" id="email_arr_3" size="30" />
					</div>
					<div class="clear"></div>
					
					<div class="label06">Name <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="name_arr[]" class="in_rw_input" id="name_arr_4" size="30" />
					</div>
					<div class="label06">Email <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="email_arr[]" class="in_rw_input" id="email_arr_4" size="30" />
					</div>
					<div class="clear"></div>
					
					<div class="label06">Name <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="name_arr[]" class="in_rw_input" id="name_arr_5" size="30" />
					</div>
					<div class="label06">Email <span class="red_star">*</span>:</div>
					<div class="field06">
						<input type="text" name="email_arr[]" class="in_rw_input" id="email_arr_5" size="30" />
					</div>
					<div class="clear"></div>
					
					<div class="clear"></div>
					<div class="field05" style="text-align:center;">
					<span class="field05" style="text-align:center;">
						<input class="in_rw_submit5"  name="submit" id="btn_invite" type="submit" value="Submit" />
						</span>
					</div>
					<div class="clear"></div>
					
				</form>
			</div>
			</div>
			<div class="clear"></div>
        </div>
        <div class="clear"></div>
    </div>	

    <?php /*?><div class="right_pan">
            <div class="clear"></div>
        <?php echo $this->load->view('elements/subscribe.tpl.php');?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
       	<?php //echo $this->load->view('elements/latest_deal.tpl.php');?>
        <?php echo $this->load->view('elements/forum.tpl.php');?>
        <?php echo $this->load->view('common/ad.tpl.php');?>
        <div class="clear"></div>
    </div><?php */?>	
    <div class="clear"></div>
</div>
<?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){

   $("#btn_invite").click(function(){
       $("#invite_form").submit();
   }); 
	///////////Submitting the form/////////
	$("#invite_form").submit(function(){	
		
		var b_valid=false;
		var chk_val=0;
		var email_valid=true;
		$("#err_flds").hide();
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
			$("#err_flds").html(s_err).show();
			b_valid = false;
		}
		//console.log(b_valid);
		
		return b_valid;
	}); 
	
	
});	

</script>