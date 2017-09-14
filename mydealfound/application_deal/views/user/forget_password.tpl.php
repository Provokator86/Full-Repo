<div class="clear"></div>
<div class="top_add_de"><img src="<?=base_url();?>images/ad_top.jpg"></div>
<div class="clear"></div>

<div class="content">
    <div class="product_section">
        <div class="input_fiela_box">
            <form action="<?=  base_url()?>user/forget_password" method="post" class="forget_password_form" onsubmit="return false;">				

				<h1>Forgot Password</h1>				

				<div class="in_clm">
					<div class="in_rw1">Email Address:</div>
					<div class="in_rw2"><input name="email" type="text" class="in_rw_input" from-validation="required|email"></div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>

				<div class="clear"></div>
                                <div class="in_rw1">Captcha:</div>
                                <div class="in_rw2">
                                   <?php /*?><div class="captchaContainer" style="float:left;width: 156px;height: 40px">
                                        <?=$captchaImage?>
                                   </div>
                                        <img onclick="refresh_captcha()" style="cursor: pointer;float:left;padding-left: 10px" src="<?=  base_url()?>images/refresh.png" alt="refresh"/><?php */?>
										
									<div class="captchaContainer" style="float:left;width: 156px;height:60px; padding:0 0 10px 0;">
										<img src="<?php echo base_url().'captcha'?>" id="captcha" />
									</div>
									<img id="change_image" style="cursor: pointer;float:left;padding-left: 10px" src="<?= base_url() ?>images/refresh.png" alt="refresh"/>

                                   <input name="confirm"  type="text" class="in_rw_input captcha_txt" from-validation="required|captcha">

                                </div>
                                <div class="clear"></div>
                                

				<div class="in_clm">
					<div class="in_rw1">&nbsp;</div>
					<div class="in_rw2">
                                            <input class="in_rw_submit5" name="Submit" type="submit" onclick="validate_signup_form()" value="Submit" /></div>

				</div>

				<div class="clear"></div>

           </form>

        </div>

        <div class="clear"></div>

        

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
<?php echo $this->load->view('common/social_box.tpl.php');?>


</div>

<div class="clear"></div>

<script>
 var base_url = '<?php echo base_url() ?>';
 
$(document).ready(function(){

  $("#change_image").click(function(){
        $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
    });
});
  function validate_signup_form(){
            if(validate_form($('.forget_password_form'),
            {
                beforeValidation : function(targetObject){
                  $(targetObject).parent().prev().css('color','#333333');
                },
                onValidationError : function (targetObject){
                    $(targetObject).parent().prev().css('color','red');
                },
                captchaValidator :function (){return validate_captcha();}

            })){

             ajax_signup_form_submit($('.forget_password_form'));

            }

    }

    

    function ajax_signup_form_submit(targetForm){

        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){

            //console.log($(targetForm).attr('action'));

            if(respData.status =='success'){
                 $(targetForm).prepend('<span class="display_msg" style="position:relative;left:151px;color:green">'+respData.message+'</span>');
                setTimeout(function(){
                    $('.display_msg').hide('slow');
                }, 5000);               

            } else {

                $(targetForm).prepend('<span class="display_msg" style="position:relative;left:151px;color:red">'+respData.message+'</span>');
                setTimeout(function(){
                    $('.display_msg').hide('slow');
                }, 5000);
            }

        }, 'json');

    }

    function validate_captcha(){

        var success=false;

        $.ajax({
          type: "POST",
          async: false,
          //url: "captcha_check",
		  url: base_url+"user/captcha_valid",
          dataType:'json',
          data: { captcha: $('.captcha_txt').val()}
        })

      .done(function( respData ) {
          console.log(respData);
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

</script>