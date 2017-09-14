<script type="text/javascript">
// start document ready
jQuery(function($) {
$(document).ready(function() {
    
        // Change cpatcha image
        $("#change_image").click(function(){
            $("#captcha").attr('src','<?php echo base_url().'captcha'?>/index/'+Math.random());
        });
		
		
		/******** validation for text box of phone number to allow only numeric *******/
    
		$(".numeric_valid").keydown(function(e){
				if(e.keyCode==8 || e.keyCode==9 || e.keyCode==46)
				{
					return true; 
				}    
				if($(this).val().length>9) // check for more than 10 digit
				{
					return false;
				}             
				 return (e.keyCode>=48 && e.keyCode<=57 || e.keyCode>=96 && e.keyCode<=105) //Only 0-9 digits are allowed
	
		})  ;
     /******** validation for text box to allow only numeric *******/
		
        
        /******** Create account start *********/
        
        $("#btn_contact").click(function(){
            
            var b_valid =   true ;
            var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email_address = $.trim($("#txt_email").val());
			 var phone_number = /^(\d){10}$/;
            
            if($.trim($("#txt_name").val())=="") //// For  name 
            {
                $("#txt_name").next(".err").html('<strong>Please provide your name.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_name").next(".err").slideUp('slow').text('');
            }
			
           
            if(email_address=="") //// For  name 
            {
                $("#txt_email").next(".err").html('<strong>Please provide your email address.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else if(reg_email.test(email_address) == false)
            {
                $("#txt_email").next(".err").html('<strong>Please provide a proper email address.</strong>').slideDown('slow');
                b_valid  =  false;
            }
            else
            {
                $("#txt_email").next(".err").slideUp('slow').text('');
            }
			
			if($.trim($("#txt_phone").val())=="") //// For  name 
            {
                $("#txt_phone").next(".err").html('<strong>Please provide phone number.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
			else if(phone_number.test($("#txt_phone").val())==false)
			{
			 	$("#txt_phone").next(".err").html('<strong>Please provide 10 digits numeric number.</strong>').slideDown('slow');
                b_valid  =  false;
			}
            else
            {
                $("#txt_phone").next(".err").slideUp('slow').text('');
            }
			
			if($.trim($("#ta_message").val())=="") //// For  name 
            {
                $("#ta_message").next(".err").html('<strong>Please provide message.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#ta_message").next(".err").slideUp('slow').text('');
            }
           
            if($.trim($("#txt_captcha").val())=="") 
            {
                $("#txt_captcha").next(".err").html('<strong>Please provide  security code.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_captcha").next(".err").slideUp('slow').text('');
            }
            
            if(b_valid)
            {
                $("#frm_contact").submit(); 
            }
            
            
        })  ;
        
        /******** Create account end *********/
        
        // If server side validation false occur 
        <?php if($posted)
        {
            ?>
            $(".err").show();
        <?php
        } 
            ?>
        
    });
});
</script>
  <?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
  <div class="container-box">
  <div class="contact-left-box">
   <form action="<?php echo base_url().'contact-us' ?>" method="post" enctype="text" name="frm_contact" id="frm_contact" >
  
  <div class="lable01">Name</div>
  <div class="text-fell-bg">
  <input name="txt_name" id="txt_name" value="<?php echo $posted["txt_name"] ; ?>" type="text" />
   <div class="err"><?php echo form_error('txt_name') ?></div> 
  </div>
  
  
  <div class="lable01">Email</div>
  <div class="text-fell-bg">
  <input name="txt_email" id="txt_email" value="<?php echo $posted["txt_email"] ; ?>" type="text" />
  <div class="err"><?php echo form_error('txt_email') ?></div> 
  </div>
  
  
  
  <div class="lable01">Phone</div>
  <div class="text-fell-bg">
  <input name="txt_phone" id="txt_phone" class="numeric_valid" value="<?php echo $posted["txt_phone"] ; ?>" type="text" />
  <div class="err"><?php echo form_error('txt_phone') ?></div> 
  </div>
  
  
  
  
  <div class="lable01">Message</div>
	<div class="textarea-bg">
	<textarea name="ta_message" id="ta_message" cols="" rows=""><?php echo $posted["ta_message"] ; ?></textarea>
	<div class="err"><?php echo form_error('ta_message') ?></div> 
	</div>
  <!--<img src="images/fe/capcha03.png" alt="capcha03" />-->
  <div>
	<img src="<?php echo base_url().'captcha'?>" id="captcha" style="float: left;" />
 <a href="javascript:void(0);" id="change_image" style="padding : 2px;" >
	<img src="images/fe/ajax-refresh-icon.gif" alt="Change Text" title="Change Text" /></a>
	</div>
   <div class="spacer"></div> 
   <div class="text-fell-bg">
   <input name="txt_captcha" type="text" id="txt_captcha" />
    <div class="err"><?php echo form_error('txt_captcha') ?></div> 
   </div>
   
   <input type="button" value="Submit" class="button-blu" id="btn_contact" />
  
  
  </form>
  </div>
  <div class="contact-right-box">
  <p>28 Pusey Street  City: Bighton<br />
County: Derbyshire Post_code: NR9 9BW</p>
<div class="map"><iframe width="410" height="368" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.in/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=28+Pusey+Street++&amp;aq=&amp;sll=21.125498,81.914063&amp;sspn=31.703831,39.506836&amp;ie=UTF8&amp;hq=&amp;hnear=28+Pusey+St,+Oxford+OX1,+United+Kingdom&amp;t=m&amp;z=14&amp;ll=51.756531,-1.261466&amp;output=embed"></iframe></div>
  
  </div>
  <br class="spacer" />
  
  </div>
 
  <div class="spacer">&nbsp;</div>
  <!--about-->