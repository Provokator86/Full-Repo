<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
//jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
 

    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#test_form").submit();
   }); 
});    


///////////Submitting the form/////////
$("#test_form").submit(function(){
    var b_valid=true;
    var s_err="";
    //$("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_content").val())=="") 
		{
		   s_err +='<div class="error_massage"><strong>Please provide a testimonial.</strong></div>';
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

})
//});
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
            <div class="title">
                <h3><span>Your</span> Testimonial(s)</h3>
            </div>
            <div class="clr"></div>
           <!-- <h6>&quot; Please drop a line about our services, we sincerely hope you have had a wonderful experience &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
						<form name="test_form" id="test_form" action="<?php echo base_url().'tradesman/testimonial/'?>" method="post">
                            <div id="form_box01">
                                <div class="label03">Testimonial :</div>
                                <div class="field03">
                                    <textarea name="txt_content" id="txt_content" cols="" rows="20"></textarea>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field01">
                                    <input type="submit" id="btn_save" value="Submit" />
                                </div>
                                <div class="clr"></div>
                            </div>
							
                            <div class="clr"></div>
                            <div class="title">
                <h5><span>Previous</span> Testimonial(s)</h5>
            </div>
            <div class="clr"></div>
							<?php
							if($testimonial_list){
							$i=1;
								foreach($testimonial_list as $val)
								{
											
							?>
                            <div class="testimonial_box">
                                <p class="test_txt"><img src="images/fe/q-mark-top.gif" alt="" /> <?php echo $val['s_full_content']?> ... <img src="images/fe/q-mark-bot.gif" alt="" /></p>
                                <p class="orng_txt14">- <?php echo $val['s_person_name']?></p>
                                <p class="grey_txt12"><?php echo $val['fn_entry_date'] ?></p>
                            </div>
							<?php } } 
								else {
										echo '<div class="testimonial_box" style="padding:0px;">No record found</div>';
									} 
							 ?>
                            <div class="clr"></div>
                           
							
                            <div class="paging_box">
								<?php echo $pagination;?>
							</div>
							
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
    <div class="clr"></div>
</div>