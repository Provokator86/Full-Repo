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

			<?php /*?><div id="container22">	
				<div class="tab_container22">   
					 <div id="tab4" class="tab_content22"> <?php */?>
						<div class="account_box box_acnt" >
							<form action="<?=  base_url()?>user/update_personal_info" method="post" class="details_form" onsubmit="return false;">
									<h1>Personal Information</h1>
									<div class="in_clm">
											<div class="in_rw1">Full Name:</div>
											<div class="in_rw2"><input name="name" value="<?=$user_meta['s_name']?>" type="text" class="in_rw_input" from-validation="required"></div>
											<div class="clear"></div>
									</div>
									<div class="clear"></div>
									
									<div class="in_clm">
											<div class="in_rw1">Email Address:</div>
											<div class="in_rw2"><input readonly="readonly" name="email" value="<?=$user_meta['s_email']?>" type="text" class="in_rw_input" from-validation="required|email"></div>
											<div class="clear"></div>
									</div>
									<div class="clear"></div>
									<?php /*?><div class="in_clm">
											<div class="in_rw1">Password:</div>
											<div class="in_rw2"><input name="password"  type="password" class="in_rw_input" from-validation="required|password"></div>
											<div class="clear"></div>
									</div>
									<div class="clear"></div>

									<div class="in_clm">
											<div class="in_rw1">Confirm Password:</div>
											<div class="in_rw2"><input name="confirm" type="password" class="in_rw_input" from-validation="required|password|confirm"></div>
											<div class="clear"></div>
									</div>
									<div class="clear"></div><?php */?>

									<div class="in_clm">
											<div class="in_rw1">&nbsp;</div>
											<div class="in_rw2">
												<input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_user_detail_form()" value="Submit" />
											</div>
									</div>
									<div class="clear"></div>
						   </form>

						</div>
                        <div class="clear"></div>
					<?php /*?> </div><!-- #tab4 -->	
				 </div> <!-- .tab_container --> 
				</div>	<?php */?>		

			</div>
			<div class="clear"></div>
        </div>

        <div class="clear"></div>
        <?php //echo $this->load->view('common/social_box.tpl.php');?>
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
    </div>	<?php */?>
    <div class="clear"></div>
</div>
<?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>

<script type="text/javascript">
$(document).ready(function() {

});
</script>
<script>
    /* for from validation */
  function validate_user_detail_form(){
        if(validate_form($('.details_form'),
        {
            beforeValidation : function(targetObject){
              $(targetObject).parent().prev().css('color','#333333');
            },
            onValidationError : function (targetObject){
                $(targetObject).parent().prev().css('color','red');
            }
        })){
         ajax_user_detail_form_submit($('.details_form'));
        }
    }

    function ajax_user_detail_form_submit(targetForm){
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
            //console.log($(targetForm).attr('action'));
            if(respData.status =='success'){
                window.location = '<?=  base_url()?>user/details';
            } else {
            }
        }, 'json');

    }

</script>