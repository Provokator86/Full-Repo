<script>
$(document).ready(function(){
	
	
///////////Submitting the form/////////
$("#detail_form").submit(function(){	
    var b_valid=true;
    var s_err="";
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    var address = $.trim($("#txt_email").val());
	
	if($.trim($("#txt_name").val())=="") 
	{
		s_err +='<div class="error_massage"><strong>Please provide name.</strong></div>';
		b_valid=false;
	}
	if(address== '')  
	{
		s_err +='<div class="error_massage"><strong>Please provide email.</strong></div>';
		b_valid=false;
	}
	else if(reg.test(address) == false) 
	{
		s_err +='<div class="error_massage"><strong>Please provide valid email.</strong></div>';
		b_valid=false;
	}	
	
	if($.trim($("#txt_subject").val())== '') 
	{
		s_err +='<div class="error_massage"><strong>Please provide subject.</strong></div>';
		b_valid=false;
	} 
	if($.trim($("#txt_msg").val())== '')   
	{
		s_err +='<div class="error_massage"><strong>Please provide message.</strong></div>';
		b_valid=false;
	}
     if($.trim($("#recaptcha_response_field").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide security code</strong></div>';
        b_valid=false;
    }	
	
    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
	/*$('#btn_reg').click(function(){
		$("#form_buyer_reg").submit();
	}); */

});
</script>

<script type="text/javascript">
    var RecaptchaOptions = {
        theme : 'custom'
    };
</script>

<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    //include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
           
	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>

	  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>

<?php } else {?>

	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } ?>	

<!-- /SERVICES SECTION -->



<!-- CONTENT SECTION -->



<div id="content_section"> 
 <div id="content">                
             <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Contact</span> Us</h3>
            </div>
            <div class="content_box">
               <!-- <h4>Please take a moment and fill the form below to contact us:</h4>-->
                <p style="text-align:right; margin-right:430px;"><span class="red_txt">*</span> Required field</p>
                <div id="form_box01">
                <form id="detail_form" action="" method="post">
                    <div class="label01">Name <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text" name="txt_name" id="txt_name" value="<?php echo $_POST["txt_name"] ?>" size="48"/>
                    </div>
                    <div class="clr"></div>
                    <div class="label01">User Name :</div>
                    <div class="field01">
                        <input type="text"  name="txt_username" id="txt_username" value="<?php echo $_POST["txt_username"] ?>" size="48" /> 
                        <em> ( if you are a member of this site )</em></div>
                    <div class="clr"></div>
                    <div class="label01">Email Address <span class="red_txt">*</span> :</div>
                    <div class="field01">
                         <input type="text" name="txt_email" id="txt_email" value="<?php echo $_POST["txt_email"] ?>" size="50"/>
                    </div>
                    <div class="clr"></div>
                    <div class="label01">Subject <span class="red_txt">*</span> :</div>
                    <div class="field01">
                        <input type="text"  name="txt_subject" id="txt_subject" value="<?php echo $_POST["txt_subject"] ?>" size="50" />
                    </div>
                    <div class="clr"></div>
                    <div class="label01">Message <span class="red_txt">*</span> :</div>
                    <div class="field01">
					<textarea  name="txt_msg" id="txt_msg"  cols="" rows="6" ><?php echo $_POST["txt_msg"] ?></textarea>
                                          
                    </div>
                    <div class="clr"></div>
                    <div class="label01">Word Verification <span class="red_txt">*</span> :</div>
                    <div class="field02">Type the characters you see in the picture below.</div>
                    <div class="clr"></div>
                    <div class="label01">&nbsp;</div>
                    <div class="field01">
                        <div id="recaptcha_container">
                                        
                    <input type="text" id="recaptcha_response_field" name="recaptcha_response_field" class="text" />  
                    <div id="recaptcha_image" style="margin-top:5px;float:left; margin-right:5px;  border:1px solid #D1D1D1;">  </div> 
					<img src="images/fe/reload.png" alt="Reload captcha" onclick="Recaptcha.reload();"  style=" float:left;cursor:pointer; margin-top:25px;"/>
                    <!--<p>Choose captcha format: <a href="javascript:Recaptcha.switch_type('image');">Image</a> or <a href="javascript:Recaptcha.switch_type('audio');">Audio</a> </p>-->
                     
                    
                    </div><div class="clr"></div>
                        Letters are not case-sensitive </div>
                        <script type="text/javascript" src="http://api.recaptcha.net/challenge?k=6LfC88gSAAAAAO2J7lo91pEgVje83SWy29brEsml">
                </script>
                    <div class="clr"></div>
                    <div class="label01">&nbsp;</div>
                    <div class="field01">
                        <input type="submit" value="Submit" />
                    </div>
                    </form>
                    <div class="clr"></div>
                </div>
                <!--/form_box01-->
            </div>
        </div>
        <!-- INNER CONTAINER02-->
        </div>
        
        <div class="clr"></div>
    </div>
</div>
<?php  //End of content_section ?>       


