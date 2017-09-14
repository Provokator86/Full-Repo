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
                    	<h2>Feedback<span>Form</span></h2>
                        <p> <?php echo $text_in_feedback_page;?>
</p>
                        <form action="<?php echo base_url().'contact/feedback'?>" method="post">
                        <p>Name:<span>*</span></p>
                        
                        	<input type="text" name="s_name" >
                            <span class="error_massage"><?php echo form_error('s_name'); ?></span>
                            <p>Email Address:<span>*</span></p>
                            <input type="text" name="s_email">
                            <span class="error_massage"><?php echo form_error('s_email'); ?></span>
                            <p>Message:<span>*</span></p>
                            <textarea name="s_msg" id="s_msg" maxlength="300"></textarea>
                            <span id="wrd_count">300</span>/300
                            <span class="error_massage"><?php echo form_error('s_msg'); ?></span>
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                    <div class="contact_add">
                    	<p><span>Email:</span>contact@coupondesh.com</p>
                    	<!--<p><span>Address:</span>123 Lorem Ipsum, Lorem-123456</p>
                        <p><span>Email:</span>contact@coupondesh.com</p>
                        <p><span>Contact:</span> 1234567890</p>-->
                        <div style="margin-top:158px">
                       <iframe width="425" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Acumen+Consultancy+Services+Pvt+Ltd,+Kolkata,+West+Bengal&amp;aq=0&amp;oq=acumen&amp;sll=22.562025,88.364754&amp;sspn=0.165181,0.336113&amp;ie=UTF8&amp;hq=Acumen+Consultancy+Services+Pvt+Ltd,&amp;hnear=Kolkata,+West+Bengal&amp;ll=22.589961,88.403152&amp;spn=0.082558,0.168056&amp;t=m&amp;z=13&amp;iwloc=A&amp;cid=12594011290654734427&amp;output=embed"></iframe>
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div> 
                </div>
                
              <div class="clear">&nbsp;</div>  
            </div>
            </div>