<style type="text/css">
.input_fiela_box .switch {text-align:center;color: #697071;font: bold 12px arial;padding: 15px 0 10px;}
.input_fiela_box .switch > span {cursor: pointer;}
.input_fiela_box .switch a {color: #44869B;font-style: normal;font-weight: bold;}
.input_fiela_box .signup_reg_form{width:98%;}
.input_fiela_box .facebook{width:25%; float:left;}
.input_fiela_box .form_box{float:right;}

.input_fiela_box .separator {border-left: 1px dotted #D6D6D6;display: inline-block;height: 365px;margin:4px 12px 0 30px;vertical-align: top;width: 0; }
.input_fiela_box .separator > div{    background: none repeat scroll 0 0 #FFFFFF; border: 1px solid #ADAEAF;  border-radius: 50%;
font-family: Arial,sans-serif;  height: 26px; line-height: 26px; margin-left: -13px;  width: 26px; text-align:center;}
</style>
<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="product_section">
		
        <div class="input_fiela_box">
			<div class="switch">
				<span class="signin">Already have an account? <a href="<?php echo base_url().'user/login' ?>">Login</a></span>
			</div>
		
            <form action="<?= base_url() ?>user/signup" method="post" class="signup_reg_form" onsubmit="return false;">            
                <h1>Sign Up</h1>
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
						<div class="in_rw1">Full Name:</div>
						<div class="in_rw2">
						<input name="name" type="text" class="in_rw_input" from-validation="required">
						</div>	
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
	
					<div class="in_clm">
						<div class="in_rw1">Email Address:</div>
						<div class="in_rw2">
						<input name="email" type="text" class="in_rw_input" from-validation="required|email|duplicate">
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
						<div class="in_rw1">Confirm Password:</div>
						<div class="in_rw2">
						<input name="confirm" type="password" class="in_rw_input" from-validation="required|password|confirm">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>

					<div class="clear"></div>
					<div class="in_rw1">Captcha:</div>
					<div class="in_rw2">
						<div class="captchaContainer" style="float:left;width: 156px;height: 40px">
							<?= $captchaImage ?>
						</div>
						<img onclick="refresh_captcha()" style="cursor: pointer;float:left;padding-left: 10px" src="<?= base_url() ?>images/refresh.png" alt="refresh"/>
						<input name="confirm"  type="text" class="in_rw_input captcha_txt" from-validation="required|captcha">
	
					</div>
					<div class="clear"></div>

					<div class="in_clm">
						<div class="in_rw1"> Agree Terms & Conditions</div>
						<div class="in_rw2">
							<input class="termscond" name="agree" type="text" style="display:none"  from-validation="required"  />
						</div>
						<input style="margin: 13px" class="" name="" value="yes" onchange="if($(this).is(':checked')){$('.termscond').val($(this).val())}else{$('.termscond').val('')}" type="checkbox" />
	
					</div>
	
					<div class="in_clm">
						<div class="in_rw1">&nbsp;</div>
						<div class="in_rw2">
							<input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_signup_reg_form()" value="Submit" />
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

    function validate_signup_reg_form(){

        if(validate_form($('.signup_reg_form'),
        {

            beforeValidation : function(targetObject){
                $(targetObject).parent().prev().css('color','#333333');
            },

            onValidationError : function (targetObject){
				//alert($(targetObject));
                $(targetObject).parent().prev().css('color','red');
				$('#err_flds').html("Please fill up red labeled fields");
            },

            captchaValidator :function (targetObject){return validate_captcha(targetObject);},
            duplicateValidator :function (targetObject){return duplicate_check(targetObject);}               

        })){
            ajax_signup_form_reg_submit($('.signup_reg_form'));
        }
    }    

    function ajax_signup_form_reg_submit(targetForm){
		 
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
           
            if(respData.status =='success'){
				
                //window.location = '<?= base_url() ?>user/profile';
				window.location = '<?= base_url() ?>user/message';

            } else {                
					
				window.location = '<?= base_url() ?>user/message';
            }

        }, 'json');

    }

    function validate_captcha(targetObject){

        var success=false;

        $.ajax({

            type: "POST",

            async: false,

            url: "captcha_check",

            dataType:'json',

            data: { captcha: $(targetObject).val()}

        })

        .done(function( respData ) {

            //console.log(respData);

            if(respData.status=='success')

                success =  true;

            else

                success =  false;

        });

        return success;

        // return false;

    }

    function refresh_captcha(){

        $.post('refresh_captcha', {data:'refresh'}, function(respData){

            $('.captchaContainer').html(respData);

        }, 'html');

    }

    function duplicate_check(targetObject){

        var success=false;

        $.ajax({

            type: "POST",

            async: false,

            url: "duplicate_check",

            dataType:'json',

            data: { duplicate: $(targetObject).val()}

        })

        .done(function( respData ) {

            //console.log(respData);

            if(respData.status=='success')

                success =  true;

            else{

                alert(respData.message);

                success =  false;

            }

            

        });

        return success;

        // return false;

    }

</script>