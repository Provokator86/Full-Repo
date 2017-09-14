
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
				
				<?php if($this->session->userdata('product_url_clicked')!=''){ ?>
				<div style="margin-bottom:15px;">Register/Login OR <a class="grab_txt" style="color:#F7681A;  font-weight:bold; cursor:pointer;" target="_blank" href="<?php echo $this->session->userdata('product_url_clicked')?$this->session->userdata('product_url_clicked'):"javascript:"; ?>">Click Here</a> to proceed without cashback</div><div class="clear"></div>
				<?php } ?>
				
				<div class="form_box">
					<div class="in_clm">
						<div class="in_rw1">Full Name: <span class="red_star">*</span></div>
						<div class="in_rw2">
						<input name="name" type="text" class="in_rw_input" from-validation="required">
						</div>	
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
	
					<div class="in_clm">
						<div class="in_rw1">Email Address: <span class="red_star">*</span></div>
						<div class="in_rw2">
						<input name="email" type="text" class="in_rw_input" from-validation="required|email|duplicate">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>

					<div class="in_clm">
						<div class="in_rw1">Password: <span class="red_star">*</span></div>
						<div class="in_rw2">
						<input name="password" autocomplete="off" type="password" class="in_rw_input" from-validation="required|password|alphanu">
						</div>
						<div class="clear"></div>
						
					</div>
					<div class="clear"></div>
					
					<div class="in_clm">
						<div class="in_rw1"></div>
						<div class="in_rw2" style="font-size:10px;">
						<!--[Note : Password must be with 6-20 Characters with one special characters and one letters and one number]-->
						[Note*: Password must be 6-20 Characters.]
						</div>
						<div class="clear"></div>
						
					</div>
					<div class="clear"></div>
	
					<div class="in_clm">
						<div class="in_rw1">Confirm Password: <span class="red_star">*</span></div>
						<div class="in_rw2">
						<input name="confirm" type="password" class="in_rw_input" from-validation="required|password|confirm">
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>

					<div class="clear"></div>
					<div class="in_rw1">Captcha: <span class="red_star">*</span></div>
					<div class="in_rw2">
						<?php /*?><div class="captchaContainer" style="float:left;width: 156px;height: 40px">
							<?= $captchaImage ?>
						</div>
						<img onclick="refresh_captcha()" style="cursor: pointer;float:left;padding-left: 10px" src="<?= base_url() ?>images/refresh.png" alt="refresh"/><?php */?>
						<div class="captchaContainer" style="float:left;width: 156px;height:60px; padding:0 0 10px 0;">
							<img src="<?php echo base_url().'captcha'?>" id="captcha" />
						</div>
						<img id="change_image" style="cursor: pointer;float:left;padding-left: 10px" src="<?= base_url() ?>images/refresh.png" alt="refresh"/>
						<input name="confirm"  type="text" class="in_rw_input captcha_txt" from-validation="required|captcha">
	
					</div>
					<div class="clear"></div>

					<div class="in_clm">
						
						<div class="in_rw2">
							<input class="termscond" id="termscond_txt" value="yes" name="agree" type="text" style="display:none"  from-validation="required"  />
						</div>
						<input style="margin: 0 13px 0 0; float:left;" class="terms_chk" name="" checked="checked" value="yes"  type="checkbox" />
						<div class="in_rw1 txt_terms_con" style="width:auto; margin:0px; padding-bottom:20px;"> Agree <a href="<?php echo base_url().'terms-condition' ?>" target="_blank">Terms & Conditions</a></div>
					</div>
	<div class="clear"></div>
					<div class="in_clm">
						<div class="in_rw1">&nbsp;</div>
						<div class="in_rw2">
							<input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_signup_reg_form()" value="Submit" />
							</div>
					</div>
					<div class="clear"></div>
            	</div>
				<div class="separator"><div>OR</div></div>
				<div class="facebook">
					<div>
						<a href="javascript:void(0);">
						<img onclick='facebook_connect_init()' src="<?= base_url() ?>images/social-icon3.png" height="37" alt="social" />					
						</a>
					</div>
					<h2>Why Join Us ?</h2>
					
					<ol>
					<li>Free to join and use</li>
					<li>Get Rs 50 joining bonus</li>
					<li>Save &amp; Earn at 1,000+ top brands</li>
					<li>Refer and Earn 10% for life</li>
					</ol>
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

 var base_url = '<?php echo base_url() ?>';
 
$(document).ready(function(){

  $("#change_image").click(function(){
        $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
    });
	
	$(".terms_chk").click(function(){
		if($(this).is(':checked')){		
			$('.termscond').attr('value',$(this).val());
		}else{		
			$('.termscond').attr('value','');
		}
	});
});


    function validate_signup_reg_form(){

        if(validate_form($('.signup_reg_form'),
        {

            beforeValidation : function(targetObject){
                $(targetObject).parent().prev().css('color','#333333');
            },

            onValidationError : function (targetObject){
				//alert($(targetObject));
				console.log(targetObject);
				//console.log(targetObject);
                $(targetObject).parent().prev().css('color','red');
				if(targetObject.hasClass('termscond'))
				{
					$(".txt_terms_con").css('color','red');
				}
				$('#err_flds').html("Please fill up all mandatory fields");
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

            //url: "captcha_check",
			url: base_url+"user/captcha_valid",

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
            url: base_url+"user/duplicate_check",
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