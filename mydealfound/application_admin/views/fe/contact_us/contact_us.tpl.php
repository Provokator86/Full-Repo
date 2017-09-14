<script type="text/javascript">
$(document).ready(function(){
	$('#s_msg').keyup(function(e){
	   var character = 300;
	   var len = parseInt($('#s_msg').val().length);
	   var keyCode = e.which? e.which: e.keyCode;
	   if (keyCode == 8) {
		$('#wrd_count').html((character - len).toString());
		return true;
	   }
	   $('#wrd_count').html((character - len).toString());
	   return true;
	  });
})
</script>

 <div id="body_container">
 
            <div class="separator"></div>
            
        	<div class="f_body">
            <div class="success_massage" style="margin-left:20px">
 <?php $this->load->view('fe/common/message.tpl.php')?>
 <?php // echo validation_errors();?>
 </div>
            	<div class="clear">&nbsp;</div>
                
                <div class="contact_det">
                	<div class="contact_us">
                    	<h2>Contact<span>Us</span></h2>
                        <p>Feel free to contact us for your store's brand promotion, advertisement submission, partnership proposals, to report bugs and errors or just to say hello.</p>
                        <form action="<?php echo base_url().'contact'?>" method="post">
                        <p>Name:<span>*</span></p>
                        
                        <input type="text" name="txt_first_name" value="<?php echo $posted['txt_first_name']?>" >
                        <span class="error_massage" style="margin-top:5px"><?php echo form_error('txt_first_name'); ?></span>
                        <p>Email Address:<span>*</span></p>
                        <input type="text" name="txt_email_address" value="<?php echo $posted['txt_email_address']?>" >
                        <span class="error_massage"><?php echo form_error('txt_email_address'); ?></span>
                        <p>Message:<span>*</span></p>
                        <textarea name="txt_comments" id="s_msg" maxlength="300"><?php echo $posted['txt_comments']?></textarea>
                        <span id="wrd_count">300</span>/300
                         <span class="error_massage"><?php echo form_error('txt_comments'); ?></span>
						 <p><img id="captcha" src="<?php echo base_url()?>captcha" alt="captcha code"/></p>
                          <p><a href="javascript:void(0)" id="change_image">Not readable? Change text.</a></p>
                          <p>Captcha Code:<span>*</span></p>
						  <span class="error_massage"><?php echo form_error('txt_captcha'); ?></span>
                          <input type="text" name="txt_captcha" >
                          
						 
                        <input type="submit" value="Submit">
                        </form>
                    </div>
                    <div class="contact_add">
                    	<!--<p><span>For any other query/feedback,Mail us:</span>contact@CouponDeals.com</p>-->
                    	<p><span>To Create your store in CouponDeals, Mail us :</span>mystore@CouponDeals.com</p>
                        <p><span> To upload your coupons, Mail us</span>mycoupons@CouponDeals.com</p>
                        <p><span>For any other query/feedback,Mail us:</span>contact@CouponDeals.com</p>
						<p><span> If you own a blog, ask us to customize special vouchers for your visitors for free. Just drop us a mail with your blog url at:</span>bloggersclub@CouponDeals.com</p>
                        <div>
                       <iframe m width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Acumen+Consultancy+Services+Pvt+Ltd,+Kolkata,+West+Bengal&amp;aq=0&amp;oq=acumen&amp;sll=22.562025,88.364754&amp;sspn=0.165181,0.336113&amp;ie=UTF8&amp;hq=Acumen+Consultancy+Services+Pvt+Ltd,&amp;hnear=Kolkata,+West+Bengal&amp;ll=22.589961,88.403152&amp;spn=0.082558,0.168056&amp;t=m&amp;z=13&amp;iwloc=A&amp;cid=12594011290654734427&amp;output=embed"></iframe>
                        </div>
                    </div>
                     <div class="clear">&nbsp;</div>
                </div>
                <div class="clear">&nbsp;</div>
               
            </div>
            </div>
<script>
	$(document).ready(function(){
		$("#change_image").click(function(){
        $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
    });

		
		})
</script>