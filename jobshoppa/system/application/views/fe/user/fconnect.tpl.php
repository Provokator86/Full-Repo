<script type="text/javascript" language="javascript" >  
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
    
///////////Submitting the form/////////
/*$("#form_buyer_reg").submit(function(){  

//alert(12423435);

    var b_valid=true;
    var s_err="";
   
    if($.trim($("#txt_credit_card_number").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide credit card number</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#opd_card_type").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please select card type</strong></div>';
        b_valid=false;
    }
    
    if($.trim($("#txt_card_verification_no").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide card verification no</strong></div>';
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
*/

///////////end Submitting the form///////// 
    /*$('#btn_reg').click(function(){
        $("#form_buyer_reg").submit();
    }); */

});
});





  
</script>



<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>

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
            <!--<div class="title">
                <h3><span>Welcome to Jobshoppa,</span> </h3>
            </div>-->
            <div class="clr"></div>
            <div id="fconnect_box" class="fconnect_box">
               <!--  <p style="text-align:right;"><span class="red_txt">*</span> Required field</p>
               <p class="big_txt15">Registration is <span style="color:#f68e29;">FREE</span></p>-->
                <p>&nbsp;</p>
                <div class="mid">
				<div class="box01">How do you like to choose to use Jobshoppa</div>
				<div class="box02">
					<div class="link_box05"><a href="<?php echo base_url()?>user/registration/TWlOaFkzVT0">Professional Registration</a></div>
					<div class="link_box06"><a href="<?php echo base_url()?>user/registration/TVNOaFkzVT0">Client Registration</a></div>
				</div>
			</div>
                <div class="clr"></div>
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
</div>
<?php  //End of content_section ?>