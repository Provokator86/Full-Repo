<div class="clear"></div>

<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>

<div class="clear"></div>

<div class="content">

    <div class="product_section">

        <div class="input_fiela_box">

            <form action="<?= base_url() ?>user/signup" method="post" class="signup_form" onsubmit="return false;">

                <h1>Sign Up</h1>

				<div id="err_flds" style="text-align:center; color:#FF0000; padding-bottom:5px;"></div>

                <div class="in_clm">

                    <div class="in_rw1">Deal URL *</div>

                    <div class="in_rw2"><input name="name" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>

                <div class="in_clm">
                    <div class="in_rw1">Title</div>
                    <div class="in_rw2"><input name="title" type="text" class="in_rw_input" ></div>
                    <div class="clear"></div>
                </div>

                <div class="clear"></div>

                <div class="in_clm">

                    <div class="in_rw1">Topic *</div>

                    <div class="in_rw2"><input name="topic" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>

                <div class="in_clm">

                    <div class="in_rw1">Discount *</div>

                    <div class="in_rw2"><input name="discount" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>
				
				
				   <div class="in_clm">

                    <div class="in_rw1">Code</div>

                    <div class="in_rw2"><input name="discount" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>

				<div class="in_clm">

                    <div class="in_rw1">Email *</div>

                    <div class="in_rw2"><input name="discount" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>
				<div class="in_clm">

                    <div class="in_rw1">Tags</div>

                    <div class="in_rw2"><input name="tags" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>
				<div class="in_clm">

                    <div class="in_rw1">Applies To</div>

                    <div class="in_rw2"><input name="applies to" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

                <div class="clear"></div>
				<div class="in_clm">

                    <div class="in_rw1">Instructions</div>

                    <div class="in_rw2"><input name="instructions" type="text" class="in_rw_input" ></div>

                    <div class="clear"></div>

                </div>

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

                        <input class="in_rw_submit" name="Submit" type="submit" onclick="validate_signup_form()" value="Submit" /></div>

                </div>

                <div class="clear"></div>

            </form>

        </div>

        <div class="clear"></div>

        <? $this->load->view('common/social_box.tpl.php'); ?>



        <div class="clear"></div>

    </div>	

    <div class="right_pan">

        <div class="clear"></div>



        <? $this->load->view('elements/subscribe.tpl.php'); ?>

        <? $this->load->view('elements/facebook_like_box.tpl.php'); ?>

        <? $this->load->view('elements/latest_deal.tpl.php'); ?>

        <? $this->load->view('elements/forum.tpl.php'); ?>

        <? $this->load->view('common/ad.tpl.php'); ?>

        <div class="clear"></div>



    </div>



    <div class="clear"></div>

</div>

<div class="clear"></div>

<script>

    function validate_signup_form(){

        if(validate_form($('.signup_form'),
        {

            beforeValidation : function(targetObject){

                $(targetObject).parent().prev().css('color','#333333');
            },

            onValidationError : function (targetObject){
                $(targetObject).parent().prev().css('color','red');
				$('#err_flds').html("Please fill up red labeled fields");
            },

            captchaValidator :function (targetObject){return validate_captcha(targetObject);},

            duplicateValidator :function (targetObject){return duplicate_check(targetObject);}               

        })){
            ajax_signup_form_submit($('.signup_form'));
        }
    }    

    function ajax_signup_form_submit(targetForm){

        $.post($(targetForm).attr('action'), $(targetForm).serialize(), function(respData){

            //console.log($(targetForm).attr('action'));

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

            console.log(respData);

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