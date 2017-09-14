<style type="text/css">
.error_massage{ color:red; font-size:16px; font-weight:bold;}
.success_massage{ color:green; font-size:16px; font-weight:bold;}
</style>
<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="product_section">
		
        <div class="input_fiela_box">          
			<h1><?php echo $title; ?></h1>
			<?php
			if($message!='')
			{
				if($message_type=='err')
					echo '<div class="error_massage">'.$message.'</div>';
				if($message_type=='succ')
					echo '<div class="success_massage">'.$message.'</div>';
			}
			?>
			
			<div class="clear"></div>
        </div>
        <div class="clear"></div>
        
        <div class="clear"></div>
    </div>	

    <div class="right_pan">
        <div class="clear"></div>

        <?php echo $this->load->view('elements/subscribe.tpl.php'); ?>
        <?php //echo $this->load->view('elements/facebook_like_box.tpl.php'); ?>
        <?php //echo $this->load->view('elements/latest_deal.tpl.php'); ?>
        <?php //echo $this->load->view('elements/forum.tpl.php'); ?>
        <?php //echo $this->load->view('common/ad.tpl.php'); ?>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<? $this->load->view('common/social_box.tpl.php'); ?>
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
				
                window.location = '<?= base_url() ?>user/profile';

            } else {                
					
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