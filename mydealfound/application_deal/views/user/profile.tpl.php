<style type="text/css">
#container22 ul.tabs li{ width:auto;}
ul.tabs li{ font-size:16px;}
ul.tabs li.active{  font-size:16px;}
</style>
<div class="clear"></div>
<div class="top_add_de"><img src="<?=base_url();?>images/ad_top.jpg"></div>
<div class="clear"></div>

<div class="content">
    <div class="product_section">
        <div class="pro">
            <div class="pro_left">
				<!--<div class="pro_left_heading">My Account</div>-->
			<?php echo $this->load->view('elements/left_account_block_tpl.php');?>

			</div>

			<div class="pro_right">
			
			<div id="container22">
				<?php /*?><ul class="tabs"> 
					<li class="active" rel="tab1">Favourite Deals</li>
					<li rel="tab2">My Subscribed Deals</li>
					<li rel="tab3">Tracked</li>
					<li rel="tab4">Settings</li>
				</ul><?php */?>

				<div class="tab_container22"> 	
					<div class="input_fiela_box box_acnt" >			
				 		<p>Welcome ! <?php echo $user_meta["s_name"] ?></p>
						
						<div class="ac_sub_heading">My Activity</div>
					<? foreach ($earningData as $earningKey => $earningMeta): ?>
			
						<div class="earning" style="border-bottom:none;">
							<div class="earning_left"><?= $earningKey ?></div>
							<div class="earning_right" style="font-size:12px;"><?= $earningMeta ?></div>
							<div class="clear"></div>
						</div>
					<? endforeach; ?>
						
					</div>
					
		
				</div> <!-- .tab_container --> 				

			</div>

			<?php /*?><div id="container22">
				  	<ul class="tabs"> 
						<li class="active" rel="tab1">Favourite Deals</li>
						<li rel="tab2">My Subscribed Deals</li>
						<li rel="tab3">Tracked</li>
						<li rel="tab4">Settings</li>
					</ul>

				<div class="tab_container22"> 
					 <div id="tab1" class="tab_content22"> 
						<div class="tb_hding">
							<div id="deal_list"><?=$display_favour_listing?></div>    
						</div>
					 </div><!-- #tab1 -->

					 <div id="tab2" class="tab_content22"> 
                         <div id="deal_list"><?=$display_subs_listing?></div> 
					 </div><!-- #tab2 -->

					 <div id="tab3" class="tab_content22"> 
						 <div id="deal_list"><?=$display_tracked_listing?></div>  
					 </div><!-- #tab3 -->                                         

					 <div id="tab4" class="tab_content22"> 
						 <div class="input_fiela_box">
							<form action="<?=  base_url()?>user/update_details" method="post" class="signup_form" onsubmit="return false;">
									<h1>Edit Information</h1>
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
									<div class="in_clm">
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
									<div class="clear"></div>

									<div class="in_clm">
											<div class="in_rw1">&nbsp;</div>
											<div class="in_rw2">
												<input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_user_info_form()" value="Submit" />
											</div>
									</div>
									<div class="clear"></div>
						   </form>

						</div>
                        <div class="clear"></div>
					 </div><!-- #tab4 --> 					 

				 </div> <!-- .tab_container --> 				

				</div><?php */?>			

			</div>
			<div class="clear"></div>
        </div>

        <div class="clear"></div>
        <?php //echo $this->load->view('common/social_box.tpl.php');?>
        <div class="clear"></div>
    </div>	

    <div class="right_pan">
            <div class="clear"></div>

        <?php echo $this->load->view('elements/subscribe.tpl.php');?>
        <?php echo $this->load->view('elements/facebook_like_box.tpl.php');?>
       	<?php //echo $this->load->view('elements/latest_deal.tpl.php');?>
        <?php //echo $this->load->view('elements/forum.tpl.php');?>
        <?php echo $this->load->view('common/ad.tpl.php');?>
        <div class="clear"></div>
    </div>	
    <div class="clear"></div>
</div>
 <?php echo $this->load->view('common/social_box.tpl.php');?>
<div class="clear"></div>

<!---------------  for tab --------------->
<script type="text/javascript">
$(document).ready(function() {

	$(".tab_content22").hide();
	$(".tab_content22:first").show(); 

	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content22").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});

});
</script>
<script>
    /* for from validation */
  function validate_user_info_form(){
        if(validate_form($('.signup_form'),
        {
            beforeValidation : function(targetObject){
              $(targetObject).parent().prev().css('color','#333333');
            },
            onValidationError : function (targetObject){
                $(targetObject).parent().prev().css('color','red');
            }
        })){
         ajax_user_info_form_submit($('.signup_form'));
        }
    }

    function ajax_user_info_form_submit(targetForm){
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
            //console.log($(targetForm).attr('action'));
            if(respData.status =='success'){
                window.location = '<?=  base_url()?>user/profile';
            } else {
            }
        }, 'json');

    }

</script>