<style type="text/css">
.input_fiela_box .switch {text-align:center;color: #697071;font: bold 12px arial;padding: 15px 0 10px;}
.input_fiela_box .switch > span {cursor: pointer;}
.input_fiela_box .switch a {color: #44869B;font-style: normal;font-weight: bold;}
.input_fiela_box .signin_form{width:98%;}
.input_fiela_box .facebook{width:25%; float:left;}
.input_fiela_box .form_box{float:right; margin-right:40px;}

.input_fiela_box .separator {border-left: 1px dotted #D6D6D6;display: inline-block;height: 165px;margin:4px 12px 0 30px;vertical-align: top;width: 0; }
.input_fiela_box .separator > div{    background: none repeat scroll 0 0 #FFFFFF; border: 1px solid #ADAEAF;  border-radius: 50%;
font-family: Arial,sans-serif;  height: 26px; line-height: 26px; margin-left: -13px;  width: 26px; text-align:center;}

.input_fiela_box form.signin_form .link{color:#44869B;cursor:pointer;font-family:Arial,sans-serif;font-size:11px;margin-top:16px;}
.link a{ color:#44869B !important;;}
</style>
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
				
				
				<div class="facebook">
					<div >
						<a href="javascript:void(0);">
						<img onclick='facebook_connect_init()' src="<?= base_url() ?>images/social-icon3.png" height="37" alt="social" />					
						</a>
					</div>
				</div>
				
				<div class="separator"><div>OR</div></div>
				
				
				<div class="form_box">
					
	
					<div class="in_clm">
						<div class="in_rw1">Email Address:</div>
						<div class="in_rw2">
						<input name="email" type="text" class="in_rw_input" from-validation="required|email">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>

					<div class="in_clm">
						<div class="in_rw1">Password:</div>
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
							<div class="link"><a href="<?php echo base_url().'user/forget_password';?>">Forgot password?</a></div>
						</div>
					</div>
					<div class="clear"></div>
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
