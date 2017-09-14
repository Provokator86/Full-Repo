<script type="text/javascript">
$(document).ready(function(){
	$("input[name='deal_date_start']").datepicker({
			minDate:0,
			dateFormat: "yy-mm-dd",
			changeYear: true,
			changeMonth:true,
			onSelect: function (dateText, inst) {
			$('#deal_date_end').datepicker("option", 'minDate', new Date(dateText));
											}

		});

	$("input[name='deal_date_end']").datepicker({
									minDate:0,
									changeYear: true,
									changeMonth:true,
									dateFormat: "yy-mm-dd"
								});
								
	$("#btn_submit").click(function(){
	
		var b_valid = true;
		var reg = /^[1-9]\d*(\.\d+)?$/; 
		var deal_price = $("#deal_price").val();
		var deal_price_list = $("#deal_list_price").val();
		var deal_discount = $("#deal_discount").val();
		
		if(deal_price!="" && (reg.test(deal_price)==false))
		{
			b_valid = false;
			$("#deal_price_err").text('Provide proper value.');
		}
		else		
		{
			$("#deal_price_err").text('');
		}
		if(deal_price_list!="" && (reg.test(deal_price_list)==false))
		{
			b_valid = false;
			$("#deal_price_list_err").text('Provide proper value.');
		}
		else		
		{
			$("#deal_price_list_err").text('');
		}
		if(deal_discount!="" && (reg.test(deal_discount)==false))
		{
			b_valid = false;
			$("#deal_discount_err").text('Provide proper value.');
		}
		else		
		{
			$("#deal_discount_err").text('');
		}
		
		if(b_valid)
		{
			$("#post_deal_frm").submit();
		}
		return b_valid;
	});
								
							
});

</script>
<div class="clear"></div>
<div class="top_add_de"><img src="<?= base_url(); ?>images/ad_top.jpg"></div>
<div class="clear"></div>
<div class="content">
    <div class="product_section">
        <div class="input_fiela_box">
            <form name="post_deal_frm" id="post_deal_frm" action="<?= base_url() ?>home/submit_a_deal" method="post" class="signup_form" >
                <h1>Submit a Deal</h1>                
                <?php $this->load->view('common/message.tpl.php')?>

				<div id="err_flds" style="text-align:center; color:#FF0000; padding-bottom:5px;"></div>		
				<div class="clear"></div>		
				<div class="in_clm">
                    <div class="in_rw1">Store :</div>
                    <div class="in_rw2">
                    	<select name="deal_store" id="deal_store" style="width:250px; height:30px; padding:5px; margin-bottom:10px;">
							<option value="">Select</option>
							<?php echo makeOptionStores($posted["deal_store"]); ?>
						</select>
					</div>
                        <span class="error_massage" style="margin-top:5px"><?php echo form_error('deal_store'); ?></span>           
                    <div class="clear"></div>                                        
                </div>                
                <div class="clear"></div>

                <div class="in_clm">
                    <div class="in_rw1">Deal Url *:</div>
                    <div class="in_rw2">
                    	<input name="deal_url" type="text" class="in_rw_input" value="<?php echo $posted['deal_url']?>" ></div>
                        <span class="error_massage" style="margin-top:5px"><?php echo form_error('deal_url'); ?></span>           
                    <div class="clear"></div>                                        
                </div>                
                <div class="clear"></div>
                
                <div class="in_clm">
                    <div class="in_rw1">Coupon Code:</div>
                    <div class="in_rw2">                    	
						<input name="deal_code" type="text" class="in_rw_input" value="<?php echo $posted['deal_code']?>" ></div>
                        <span class="error_massage" style="margin-top:5px"><?php echo form_error('deal_code'); ?></span>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
				
				<div class="in_clm">
                    <div class="in_rw1">Email *:</div>
                    <div class="in_rw2">                    	
						<input name="deal_email" type="text" class="in_rw_input" value="<?php echo $posted['deal_email']?>" ></div>
                        <span class="error_massage" style="margin-top:5px"><?php echo form_error('deal_email'); ?></span>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
				
				<div class="in_clm">
                    <div class="in_rw1">Description *:</div>
                    <div class="in_rw2">
                    	<textarea name="deal_description" rows="5" cols="28"><?php echo $posted['deal_description']?></textarea>
                        </div>
                        <span class="error_massage" style="margin-top:5px"><?php echo form_error('deal_description'); ?></span>
                    <div class="clear"></div>
                </div>                
                <div class="clear"></div>
				
				<div class="in_clm">
                    <div class="in_rw1">Start Date:</div>
                    <div class="in_rw2">
                    	<input name="deal_date_start" id="deal_date_start" type="text" readonly="readonly" class="in_rw_input" value="<?php echo $posted['deal_date_start']?>" >					
						</div>                       
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
				
				<div class="in_clm">
                    <div class="in_rw1">End Date:</div>
                    <div class="in_rw2">
                    	<input name="deal_date_end" id="deal_date_end" type="text" readonly="readonly" class="in_rw_input" value="<?php echo $posted['deal_date_end']?>" >					</div>                       
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                
                <div class="in_clm">
                    <div class="in_rw1">Selling Price:</div>
                    <div class="in_rw2">
                    	<input name="deal_price" id="deal_price" type="text" class="in_rw_input" value="<?php echo $posted['deal_price']?>" ></div>
                        <span class="error_massage" id="deal_price_err" style="margin-top:5px"><?php echo form_error('deal_price'); ?></span>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
				
				<div class="in_clm">
                    <div class="in_rw1">List Price:</div>
                    <div class="in_rw2">
                    	<input name="deal_list_price" id="deal_list_price" type="text" class="in_rw_input" value="<?php echo $posted['deal_list_price']?>" ></div>
                        <span class="error_massage" id="deal_price_list_err" style="margin-top:5px"><?php echo form_error('deal_list_price'); ?></span>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
				
				<div class="in_clm">
                    <div class="in_rw1">Discount:</div>
                    <div class="in_rw2">
                    	<input name="deal_discount" id="deal_discount" type="text" class="in_rw_input" value="<?php echo $posted['deal_discount']?>" >
					</div>
                        <span class="error_massage" id="deal_discount_err" style="margin-top:5px"><?php echo form_error('deal_discount'); ?></span>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                           
                
                <div class="in_rw1">Captcha:</div>
                <div class="in_rw2">
                    <div class="captchaContainer" style="float:left;width: 156px;height: 40px">
                       <img id="captcha" src="<?php echo base_url()?>captcha" alt="captcha code"/>
                    </div>

                    <img onclick="refresh_captcha()" style="cursor: pointer;float:left;padding-left: 10px" src="<?= base_url() ?>images/refresh.png" alt="refresh"/>
                    <input name="txt_captcha"  type="text" class="in_rw_input captcha_txt">
                     <span class="error_massage"><?php echo form_error('txt_captcha'); ?></span>
                   	
                </div>
				<div class="clear"></div>               
                
                <div class="in_clm">
                    <div class="in_rw1">&nbsp;</div>
                    <div class="in_rw2">
                       <input class="in_rw_submit5" name="btn_submit" id="btn_submit" type="button" value="Submit" />
                    </div>
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

        /*$.post('refresh_captcha', {data:'refresh'}, function(respData){

            $('.captchaContainer').html(respData);

        }, 'html');*/
		$("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());

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