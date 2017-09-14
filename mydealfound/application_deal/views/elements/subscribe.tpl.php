<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<script type="text/javascript">
$(document).ready(function(){
	$(".ribon").find('img').attr('src','<?php echo base_url().'images/free.png' ?>');
});

</script>

 <div class="clear"></div>

<div class="right_pan1 pading_13">
		<div class="ribon"><img src="<?php echo base_url()?>images/free.png"></div>
        <div class="mail_heading">   Sign up to <br />
             Mydealfound<br />
        </div>
        <div class="mail_subheading">Subscribe Now and get<br />
         Regular Offer<br />
        </div>

            <div class="mail_sign">
				<div class="signup_glow">
				<input id="email" class="sign_up_box" name="Enter your email" type="text" placeholder="Enter your email"></div>
				<div class="sign_up">
					<input class="sign_up" id="signup_btn" name="Submit" type="button" value="Submit">
				</div>
				<div class="clear"></div>
            </div> 

</div> 

 <div class="clear"></div>
 <script>
     $(document).ready(function(){
         $('#signup_btn').click(function(){
             var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
             if(emailRegex.test($.trim($('#email').val()))){
                 $.post('<?=  base_url()?>home/subscribe_newsletter', {email:$('#email').val()}, function(resData){
                     if(resData.status=='success'){
                        $('.mail_subheading').html('<span style="color:green">'+resData.message+'</span>');
                    } else {
                         $('.mail_subheading').html('<span style="color:red">'+resData.message+'</span>');
                     }
                     $('#email').val('');

                }, 'json');

             } else {
                 $('.mail_subheading').html('<span style="color:red">Invalid Email<br/>Enter a valid email</span>');
             }

              setTimeout(function(){
                     $('.mail_subheading').html('Subscribe Now and get<br />Regular Offer<br />');
                 }, 5000);
         });         

     });
 </script>