
<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="product_section">
		
        <div class="input_fiela_box">
			<div class="switch">
				<span class="signin">New to Mydealfound? <a href="<?php echo base_url().'user/signup' ?>">Create new account</a></span>
			</div>
		
            <form action="<?= base_url() ?>user/login" method="post" class="signin_form" onsubmit="return false;">            
                <h1>Login</h1>
				<div id="err_flds" style="text-align:center; color:#FF0000; padding-bottom:5px;"></div>
				
				<?php if($this->session->userdata('product_url_clicked')!=''){ ?>
				<div style="margin-bottom:15px;">Register/Login OR <a class="grab_txt" style="color:#F7681A;  font-weight:bold; cursor:pointer;" target="_blank" href="<?php echo $this->session->userdata('product_url_clicked')?$this->session->userdata('product_url_clicked'):"javascript:"; ?>">Click Here</a> to proceed without cashback</div><div class="clear"></div>
				<?php } ?>
				
				
				<div class="form_box">
					
	
					<div class="in_clm">
						<div class="in_rw1">Email Address: <span class="red_star">*</span></div>
						<div class="in_rw2">
						<input name="email" type="text" class="in_rw_input" from-validation="required|email">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>

					<div class="in_clm">
						<div class="in_rw1">Password: <span class="red_star">*</span></div>
						<div class="in_rw2">
						<input name="password" type="password" class="in_rw_input" from-validation="required|password">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
	
					<div class="in_clm">
						<div class="in_rw1">&nbsp;</div>
						<div class="in_rw2">
							<input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_signin_form()" value="Submit" />
							<div class="link"><a target="_blank" href="<?php echo base_url().'user/forget_password';?>">Forgot Your Password?</a></div>
						</div>
					</div>
					<div class="clear"></div>
            	</div>
				<div class="separator"><div>OR</div></div>
				<div class="facebook">
					<div >
						<a href="javascript:void(0);">
						<img onclick='facebook_connect_init()' src="<?= base_url() ?>images/social-icon3.png" height="37" alt="social" />					
						</a>
					</div>
				</div>
				
				
				
				
			</form>
			<div class="clear"></div>
        </div>
        <div class="clear"></div>
        
        <div class="clear"></div>
    </div>	

    <div class="right_pan">
        <div class="clear"></div>

        <? $this->load->view('elements/subscribe.tpl.php'); ?>
        <? $this->load->view('elements/facebook_like_box.tpl.php'); ?>
        <?php /*?><? $this->load->view('elements/latest_deal.tpl.php'); ?>
        <? $this->load->view('elements/forum.tpl.php'); ?><?php */?>
        <? $this->load->view('common/ad.tpl.php'); ?>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<? $this->load->view('common/social_box.tpl.php'); ?>
<div class="clear"></div>
<script>

    function validate_signin_form(){

        if(validate_form($('.signin_form'),
        {

            beforeValidation : function(targetObject){
                $(targetObject).parent().prev().css('color','#333333');
            },

            onValidationError : function (targetObject){
				//alert($(targetObject));
                $(targetObject).parent().prev().css('color','red');
				$('#err_flds').html("Please fill up red labeled fields");
            },

            //captchaValidator :function (targetObject){return validate_captcha(targetObject);},
            //duplicateValidator :function (targetObject){return duplicate_check(targetObject);}               

        })){
            ajax_signin_form_submit($('.signin_form'));
        }
    }    

    function ajax_signin_form_submit(targetForm){
		 
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
           
		   $('#err_flds').html('');
            if(respData.status =='success'){
				
                window.location = '<?= base_url() ?>user/profile';

            } else {                
					
				//window.location = '<?= base_url() ?>user/login';
				$('#err_flds').html(respData.message);
            }

        }, 'json');

    }


</script>
