<script>
jQuery(document).ready(function() {
		$(".lightbox1_main").fancybox({
			'titlePosition'		: 'inside',
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'showCloseButton'	: true
		});
		//console.log($(".lightbox1_main"));
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
                <h3><span>Verify </span> Your Profile</h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; Please take a moment and fill the form out below. &quot;</h6>-->
            <div class="clr"></div>
<div id="account_container">
	<div class="account_left_panel">
		<div class="round_container">
			<div class="top">&nbsp;</div>
			<div class="mid" style="min-height:918px;">
				
<div class="text_box">
				 <div class="upgrade_box">
                  <table width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="12%"><img src="images/fe/email.png" alt="" /></td>
                      <td width="88%" rowspan="2" align="left" valign="top"><h1>Email address</h1>
                        Email Address already verified </td>
                    </tr>
                  </table>
                </div>
				
				<div class="upgrade_box">
                	<table width="100%" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="12%"><img src="images/fe/facebook.png" alt="" /></td>
						<td width="88%" rowspan="2" align="left" valign="top"><h1><a href="<?php echo base_url().'tradesman/verify_facebook'?>" class="lightbox1_main" >Link your Facebook account</a></h1>
						 Prove to your customers your say who you are by linking your Facebook account.</td>
					  </tr>  
					</table>
                </div>
				<div class="upgrade_box"><table width="100%" cellspacing="0" cellpadding="0">
					<table width="100%" cellspacing="0" cellpadding="0">
					  <tr>
						<td width="12%"><img src="images/fe/phone.png" alt="" /></td>
						<td width="88%" rowspan="2" align="left" valign="top"><h1><a href="<?php echo base_url().'tradesman/verify_phone'?>" class="lightbox1_main" >Verify your Phone Number</a></h1>
						  Verify your phone number to increase trust with your customers.</td>
					  </tr>
					  
					</table>
				</div>
				
                  <div class="upgrade_box">
					  <table width="100%" cellspacing="0" cellpadding="0">
						<tr>
						  <td width="12%"><img src="images/fe/Credentials.png" alt="" /></td>
						  <td width="88%" rowspan="2" align="left" valign="top"><h1>
						  <a href="<?php echo base_url().'tradesman/verify_credentials'?>" class="lightbox1_main" >Credentials verify</a> </h1>
							Credentials - 100% verify</td>
						</tr>
					  </table>
                </div>
                
                
                
                
                
                
               
                    
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
	