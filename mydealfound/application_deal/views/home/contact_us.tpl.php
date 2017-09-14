<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="content_box">
        <div class="input_fiela_box">
			<?php echo $info[0]['en_s_description'] ?>
            <form action="<?= base_url() ?>home/contact_us" method="post" class="contact_form" onsubmit="return false;">            
                <h1>Contact Us</h1>
				<div id="err_flds" style="text-align:center; color:#FF0000; padding-bottom:5px;"></div>
                <div class="in_clm">
                    <div class="in_rw1">Your Name *:</div>
                    <div class="in_rw2">
					<input name="name" type="text" class="in_rw_input" from-validation="required">
					</div>	
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <div class="in_clm">
                    <div class="in_rw1">Your Email *:</div>
                    <div class="in_rw2">
					<input name="email" type="text" class="in_rw_input" from-validation="required|email">
					</div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <div class="in_clm">
                    <div class="in_rw1">Subject *:</div>
                    <div class="in_rw2">
					<input name="subject" type="text" class="in_rw_input" from-validation="required">
					</div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <div class="in_clm">
                    <div class="in_rw1">Message *:</div>
                    <div class="in_rw2">
						<!--<input name="message" type="text" class="in_rw_input" from-validation="required">-->
						<textarea name="message" class="in_rw_textarea" from-validation="required"></textarea>
					</div>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>

                <div class="in_clm">
                    <div class="in_rw1">&nbsp;</div>
                    <div class="in_rw2">
                       <input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_contact_form()" value="Submit" />
					</div>
                </div>
                <div class="clear"></div>
            </form>
        </div>
        <div class="clear"></div>
        <? $this->load->view('common/social_box.tpl.php'); ?>
        <div class="clear"></div>
    </div>	

    <?php /*?><div class="right_pan">
        <div class="clear"></div>

        <? $this->load->view('elements/subscribe.tpl.php'); ?>
        <? $this->load->view('elements/facebook_like_box.tpl.php'); ?>
        <?php //echo $this->load->view('elements/latest_deal.tpl.php'); ?>
        <? $this->load->view('elements/forum.tpl.php'); ?>
        <? $this->load->view('common/ad.tpl.php'); ?>
        <div class="clear"></div>
    </div><?php */?>
    <div class="clear"></div>
</div>
<div class="clear"></div>

<script type="text/javascript">

    function validate_contact_form(){

        if(validate_form($('.contact_form'),
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
            ajax_contact_submit($('.contact_form'));
        }
    }    

    function ajax_contact_submit(targetForm){
		 
        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){
           console.log(respData);
            if(respData.status =='success'){				
				window.location = '<?php echo base_url() ?>user/message';

            } else {   
				window.location = '<?php echo base_url() ?>user/message';
            }

        }, 'json');

    }
</script>