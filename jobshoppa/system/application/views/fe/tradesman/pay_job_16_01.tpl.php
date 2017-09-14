<script type="text/javascript" language="javascript" >  
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){
    
    
///////////Submitting the form/////////
$("#form_buyer_reg").submit(function(){  

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
    else
		$('#reg_buton').attr('disabled','disabled');  
    return b_valid;
}); 


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
    <?php
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
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
                <h3><span>Payment </span></h3>
            </div>
            <div class="clr"></div>
            <h6>&quot; Please take a moment and fill the form out below. &quot;</h6>
            <div class="clr"></div>
<div id="account_container">
	<div class="account_left_panel">
		<div class="round_container">
			<div class="top">&nbsp;</div>
			<div class="mid" style="min-height:918px;">
				<p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
				<div class="clr"></div> 
				<div class="label01" style="width:400px; text-align:right;"><strong>Amount to be paid <?php echo $amt_to_paid?> £</strong> </div>
				<div class="clr"></div> 

				<div id="form_box01" style="padding-top:15px;">
				<form id="form_buyer_reg" action="" method="post" enctype="multipart/form-data" >				
				<div class="label01">Credit Card No<span class="red_txt">*</span> :</div>
                <div class="field01">
                <div id="parent_zip"> 
                    <input type="text" name="txt_credit_card_number" id="txt_credit_card_number" value="<?php echo $posted["txt_credit_card_number"] ?>" size="48"/>
                    </div>
                </div>				
				<div class="label01">Credit Card Type<span class="red_txt">*</span> :</div>
                <div class="field01">
                <div id="parent_zip"> 
                    <select name="opd_card_type" id="opd_card_type">
					<option value="Visa">Visa</option>
					<option value="MasterCard">MasterCard</option>
					<option value="Discover">Discover</option>
					<option value="Amex">Amex</option>
					</select>
                    </div>
                </div>					
				<div class="label01">Expiration Date <span class="red_txt">*</span> :</div>
                <div class="field01">
                <div id="parent_zip"> 
				<select name="opd_exp_month" id="opd_exp_month" style="width:100px;">
                    <?php
					for($i=1;$i<=12;$i++)
					{
					?>
					<option value="<?php echo $i;?>" <?php echo ($i==date("m")) ? 'selected' :''?>><?php echo $i;?></option> 
					<?php } ?>
				</select> Month
				<select name="opd_exp_year" id="opd_exp_year" style="width:100px;">
                    <?php
					$cur_date = date("Y");
					$max_exp_date = $cur_date + 5;
					for($i=$cur_date;$i<=$max_exp_date;$i++)
					{
					?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option> 
					<?php } ?>
				</select> Year	
                    </div>
                </div>				
				<div class="label01">Card Verification No<span class="red_txt">*</span> :</div>
                <div class="field01">
                <div id="parent_zip"> 
                    <input type="text" name="txt_card_verification_no" id="txt_card_verification_no" value="<?php echo $posted["txt_card_verification_no"] ?>" size="48"/>
                    </div>
                </div>				
							
				
                <div class="label01"></div>
                <div class="field01">
                    <input type="submit" name="submit" id="reg_buton" value="Submit" />
                </div>
                </form>
</div>
				<!-- END OF FORMBOX-->
			</div>
			<div class="bot">&nbsp;</div>
		</div>
	</div>
   <?php include_once(APPPATH.'views/fe/common/tradesman_right_menu.tpl.php'); ?> 
</div>
            <div class="clr"></div>
        </div>         
        
        <div class="clr"></div>
</div>
</div>      
	