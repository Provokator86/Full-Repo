<div class="feedback">
    <div class="feedback_head">
        <div class="feedback_strip">
            <div class="feedback_text"></div>
        </div>
    </div>
    <div class="feedback_body" style="display: none">
        <div class="feedback_inner_body" >
            <div class="feedback_form">
                <form class="feedback_form_elemnt" action="" method="post" onsubmit="return false">
                    <div class="clear"></div>
                    <label for="name"> Name<span class="required">*</span></label>
                    <input type="text" name="name" from-validation="required" class="feedback_name">
                    <div class="clear"></div>
                    <label for="email"> Email<span class="required">*</span></label>
                    <input type="text" name="email" from-validation="required|email" class="feedback_email">
                    <div class="clear"></div>
                    <label for="category"> Choose A Category</label>
                    <select name="category"  class="feedback_category">
                        <option value="suggestion" selected="selected">I have a suggestion</option>														
                        <option value="confused">I am confused about</option>
                        <option value="error" >Something doesn't work</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="clear"></div>
                    <label for="message"> Message<span class="required">*</span></label>
                    <textarea name="message" from-validation="required" class="feedback_msg"></textarea>
                     <div class="clear"></div>
                    <input type="submit" class="feedback_submit_btn" value="Send Feedback">
                    <input type="reset" class="feedback_reset_btn" value="Clear">
                     <div class="clear"></div>
                </form>
            </div>
            <div class="feedback_msg_div" style="display: none">
                <span><img src="<?=base_url()?>images/ajax-loader.gif"></span>
            </div>
            <div class="feedback_footer"><img src="<?=  base_url()?>images/logo_deal.png" alt="logo"></div>
        </div>
    </div>
</div>
<script>

     $(document).ready(function(){
        $('.feedback_head').click(function(){
            $('.feedback_body').toggle('slow');
        });
        $('.feedback_submit_btn').click(function(){
            
        if(validate_form($('.feedback_form_elemnt'),
            {
                beforeValidation : function(targetObject){
                  $(targetObject).prev().css('color','#333333');
                },
                onValidationError : function (targetObject){
                    $(targetObject).prev().css('color','red');
                }
            })
        ){
            var frm_data = $('.feedback_form_elemnt').serialize();
            console.log(frm_data);
            $('.feedback_msg_div span').html(' <img src="<?=base_url()?>images/ajax-loader.gif">');
            $('.feedback_msg_div,.feedback_form').toggle();
            $.post('home/feedback', frm_data, function(responseData){
                console.log(responseData);
                setTimeout(function(){
                    $('.feedback_msg_div,.feedback_form').toggle();
                },5000);
                 $('.feedback_msg_div span').addClass(responseData.status);
                 $('.feedback_msg_div span').html(responseData.message);
                 $('.feedback_reset_btn').click();
            }, 'json');
        }
            
        });
     });
     
</script>