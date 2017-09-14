<?php
$fb_app_id = $_SESSION['fb_app_id'];
?>
<script type="text/javascript">

// start document ready
jQuery(function($) {

$(document).ready(function() {
           
  
    $("#btn_manage_account").click(function(){
        
                     
            var b_valid =   true ;
            var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
            var email_address = $.trim($("#txt_email").val());
            
            if($.trim($("#txt_first_name").val())=="") //// For  name 
            {
               
                $("#txt_first_name").parent().next().next(".err").html('<strong>Please provide your first name.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_first_name").parent().next().next(".err").slideUp('slow').html('');
            }
            if($.trim($("#txt_last_name").val())=="")  
            {
                $("#txt_last_name").parent().next().next(".err").html('<strong>Please provide your last name.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_last_name").parent().next().next(".err").slideUp('slow').html('');
            }
            if(email_address=="") 
            {
                $("#txt_email").parent().next().next(".err").html('<strong>Please provide your email address.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else if(reg_email.test(email_address) == false)
            {
                $("#txt_email").parent().next().next(".err").html('<strong>Please provide a proper email address.</strong>').slideDown('slow');
                b_valid  =  false;
            }
            else
            {
                $("#txt_email").parent().next().next(".err").slideUp('slow').html('');
            }
            if($.trim($("#txt_phone_number").val())=="") //// For  name 
            {
               
            $("#txt_phone_number").parent().next().next(".err").html('<strong>Please provide phone number.</strong>').slideDown('slow');        
                b_valid  =  false;
            }
            else
            {
                $("#txt_phone_number").parent().next().next(".err").slideUp('slow').html('');
            }
            if($("#h_image").val()=="" && $("#FileField").val()=="")
            {
                $("#FileField").parent().next(".err").html('<strong>Please provide a profile image.</strong>').slideDown('slow');
                  b_valid  =  false;
                
            }
            else if($("#FileField").val()!="")
            {
                var file    =   $("#FileField").val() ;
                var ext     =   file.split('.').pop().toLowerCase();
                switch(ext)
                {
                    case 'jpg'  :
                    case 'jpeg' :
                    case 'png'  :
                    case 'gif'  :
                                
                                break;
                    default     :
                                 $("#FileField").parent().next(".err").html('<strong>Please provide image proper file format.</strong>').slideDown('slow'); 
                                 b_valid    =   false;
                                
                }
                
            }
          
            if(b_valid)
            {
                 $("#frm_manage_account").submit();
            }
        
    })  ;
    
    
    
      // If server side validation false occur 
        <?php if($posted)
        {
            ?>
            $(".err").show();
        <?php
        } 
            ?>
        
        var h_id    =   '<?php echo $posted['h_id']; ?>';    
        $(".remove").click(function(){
        var file_name   =   $("#h_image").val();   
            $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url+'account/ajax_delete_image',
                    data: "h_id="+h_id+"&file_name="+file_name,
                    success: function(msg){
                   if(msg=="ok") 
                   {
                        $(".remove").remove(); 
                        $("#h_image").val(''); 
                        $(".left-photo02 img").attr('src','uploaded/default/no_image.jpg');          
                   }

                }  // end success
            });  // end of ajax
            
            
        })  ;
        
    });
});


var verify_facebook_address = '';
function verify_facebook()
{
	verify_facebook_address = $.trim($('#txt_facebook_address').val());
	if(verify_facebook_address)
	{
						FB._initialized = false;
                        FB.init({appId: '<?=$fb_app_id?>', status: true, cookie: true, xfbml: true, oauth: true});
                
                        FB.login(function(response) {
                        
                            if (response.authResponse) {
                            
                                var access_token = response.authResponse.accessToken;
                                verify_facebook_complete(access_token);
                                
                            } else {
                            // user cancelled login
                            }
                        },{scope: 'email'});
	}
}

function verify_facebook_complete(access_token)
{
	if(verify_facebook_address)
	{
		$.ajax({
                type: "POST",
                url: base_url+'account/ajax_verify_facebook',
                data: "address="+escape(verify_facebook_address)+"&access_token="+escape(access_token),
				dataType: 'text',
                success: function(msg){
                   if(msg!='')
                   {                       
				   	  /*alert(msg);*/
					   if(msg*1==1)
					   {
					   		jAlert('Your facebbok account is verified, please save the information.','Verification Successful');
					   		$('#facebook_action_link').html('<b style="color:black;">Verified</b>');
					   }
                   }   
                }
            });
	}

}




function ajax_change_state_option(ajaxURL,item_id,cngDv)
{
    //alert('i m here');
    jQuery.noConflict();///$ can be used by other prototype which is not jquery
    jQuery(function($) {
        document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
        $.ajax({
                type: "POST",
                url: base_url+'ajax_common/'+ajaxURL,
                data: "country_id="+item_id,
                success: function(msg){
                   if(msg!='')
                   {
                       document.getElementById(cngDv).innerHTML = msg;
                       $("#opt_state").msDropDown();
                       $("#opt_state").hide();
                       $('#opt_state_msdd').css("background-image", "url(images/fe/select-box.png)");
                       $('#opt_state_msdd').css("background-repeat", "no-repeat");
                       $('#opt_state').css("width", "273px"); 
                       $('#opt_state_msdd').css("margin-top", "12px");
                       

                   }   
                }
            });
    });
}
</script>

<script type="text/javascript" src="http://platform.linkedin.com/in.js">
  // For acumencs
  //api_key: eg5mg32wzpt1
  //For tripezi
  api_key: mk9r4dldg9xe
  onLoad: onLinkedInLoad
  authorize: true
</script>
      

<script type="text/javascript">



	var verify_twitter_address = '';
        function verify_twitter() {
		
			verify_twitter_address = $.trim($('#txt_twitter_address').val());
            var screen_name =    verify_twitter_address.split('/').pop();
			if(verify_twitter_address)
			{
            	       window.open('<?php echo base_url().'connect_twitt/redirect/' ;?>'+screen_name,'Twitter varification','width=600,height=300');
					
			} // end if

        }
        
        
function twitter_address_verification_result(status)
{
    if(status==true)
    {
         var twitter_address = $.trim($('#txt_twitter_address').val());
          $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url+'account/ajax_verify_twitter',
                    data: "twitter_address="+twitter_address,
                    success: function(msg){
                   if(msg=="ok") 
                   {
                        jAlert('Your Twitter address verified successfully, Please click save button'); 
                        $('#twitter_action_link').html('<b style="color:black;">Verified</b>');         
                   }

                }  // end success
          });  // end of ajax
          
    }
    else
    {
         jAlert('Sorry! Your Twitter address failed to verified..');  
    }
}        
  



function onLinkedInLoad() {
   
      IN.Event.on(IN, "auth", onLinkedInAuth);  
   
  }
   
var linkedin_address_id    =  '' ;       
        
function verify_linkedin()
{
    //alert($('#linkedin_login_button a').length); 
     
    $('#linkedin_login_button a span:first').click();   
}

 var not_found_linkedin_address  = false ; 
function onLinkedInAuth()
{
     var linkedin_address    =   $("#txt_linkedin_address").val();
     IN.API.Profile(linkedin_address).result(displayProfiles);
       setTimeout(function(){
        if(not_found_linkedin_address==false)
        {
            jAlert('Sorry! Your Linkedin address failed to verified.'); 
            IN.User.logout();  // This function for logout the linkedin 
        }},20000);
}

function displayProfiles(profiles)
{
   not_found_linkedin_address  = true ;    
    if(profiles)
    {
         member = profiles.values[0];
         linkedin_address_id   =   member.id ;
         IN.API.Profile("me").result(displayProfilesMine);
    }
    else
    {
         jAlert('Sorry! Your Linkedin address failed to verified..'); 
    }
    
    
}

function displayProfilesMine(profiles)
{
     member = profiles.values[0];
     linkedin_address_mine_id   =   member.id ;
     
     IN.User.logout();  // This function for logout the linkedin
     
     if(linkedin_address_mine_id==linkedin_address_id)
     {
         var linkedin_address   =   $("#txt_linkedin_address").val(); 
          $.ajax({
                    type: "POST",
                    async: false,
                    url: base_url+'account/ajax_verify_linkedin',
                    data: "linkedin_address="+linkedin_address,
                    success: function(msg){
                   if(msg=="ok") 
                   {
                        jAlert('Your Linkedin address verified successfully, Please click save button'); 
                        $('#linkedin_action_link').html('<b style="color:black;">Verified</b>');         
                   }

                }  // end success
          });  // end of ajax

     }
     else
     {
         jAlert('Sorry! Your Linkedin address failed to verified.'); 
     }

}



</script>


<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="container-box">
<?php include_once(APPPATH."views/fe/common/message.tpl.php"); ?>
<?php //echo validation_errors(); ?>
	<?php include_once(APPPATH."views/fe/common/account_left_menu.tpl.php"); ?>
	<div class="right-part02">
	  <div class="text-container">
			<div class="inner-box03">
				  <div class="page-name02">Manage Account</div>
				  <div class="left-box02">
						<div class="left-photo02"><?php echo showThumbImageDefault('user_image',$posted["s_image"],'thumb',174,171); ?></div>
						<br class="spacer" />
                        <?php 
                        if($posted['s_image'])
                        {
                            ?>
                            <div class="remove"><a href="javascript:void(0);">Remove</a></div>
                        <?php
                        }
                            ?>
						
				  </div>
				  <div class="form-box02">
						<!--<p>Hi, I'm Acu acu and I'm new to Property space listing</p>-->
						<form action="" method="post" enctype="multipart/form-data" name="frm_manage_account" id="frm_manage_account">
						<div class="lable06">First Name</div>
						<div class="text-fell05">
							   <input name="txt_first_name" type="text" id="txt_first_name" value="<?php echo $posted["txt_first_name"] ; ?>" />
                              
						</div>
                         
						<div class="icon"><a href="javascript:void(0);"><img  src="images/fe/tick.png" alt="" /></a></div>
                        
                        <div class="err"><?php echo form_error('txt_first_name'); ?></div> 
						   
						<div class="spacer"></div>
						<div class="lable06">Last Name</div>
						<div class="text-fell05">
							  <input name="txt_last_name" type="text" id="txt_last_name" value="<?php echo $posted["txt_last_name"] ; ?>" />
						</div>
                        
						<div class="icon"><a href="javascript:void(0);"><img src="images/fe/tick.png" alt="" /></a></div>
                         <div class="err"><?php echo form_error('txt_last_name'); ?></div>   
						
						<div class="spacer"></div>
						<div class="lable06">Email</div>
						<div class="text-fell05">
							  <input name="txt_email" type="text" id="txt_email" value="<?php echo $posted["txt_email"] ; ?>"   />
						</div>
						 <div class="verified">
                            Verified
                            </div>
						 <div class="err"><?php echo form_error('txt_email'); ?></div>   
						<div class="spacer"></div>
						<div class="lable06">Phone Number</div>
						<div class="text-fell05">
							  <input name="txt_phone_number" id="txt_phone_number" type="text" value="<?php echo $posted["txt_phone_number"] ; ?>" />
						</div>
						
                        <?php if($posted['i_phone_verified']==1)
                        {
                            ?>
                             <div class="verified">
                            Verified
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="verified">
                            <em>Not Verified</em>
                            </div>
                        <?php
                            
                        } ?>
						                      
						<div class="err"><?php echo form_error('txt_phone_number'); ?></div>
						<br class="spacer" />   
						<span>(Verified phone number must for showcasing property in listing.)</span>
						<div class="spacer"></div>
						<div class="lable06">Facebook</div>
						<div class="text-fell05">
							  <input name="txt_facebook_address" id="txt_facebook_address" type="text" value="<?php echo $posted["txt_facebook_address"] ; ?>"/>
						</div>
						 <?php if($posted['i_facebook_verified']==1)
                        {
                            ?>
                             <div class="verified">
                            Verified
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                            <div class="icon" id="facebook_action_link">
                            <a href="javascript:verify_facebook();"><em>Verify</em></a>
                            </div>
                        <?php
                            
                        } ?>
						
						<div class="spacer"></div>
						<div class="lable06">Twitter</div>
						<div class="text-fell05">
							   <input name="txt_twitter_address" id="txt_twitter_address" type="text" value="<?php echo $posted["txt_twitter_address"] ; ?>"/>
						</div>
						 <?php if($posted['i_twitter_verified']==1)
                        	{
                            ?>
                             <div class="verified">
                            Verified
                            </div>
                        <?php
                        	}
                        else
                        {
                            ?>
                            <div class="icon" id="twitter_action_link">
                            <a href="javascript:verify_twitter();"><em>Verify</em></a>
                            </div>
                        <?php
                            
                        } ?>
						  
						<div class="spacer"></div>
						<div class="lable06">LinkedIn</div>
						<div class="text-fell05">
							   <input name="txt_linkedin_address" id="txt_linkedin_address" type="text" value="<?php echo $posted["txt_linkedin_address"] ; ?>"/>
						</div>
						 <?php if($posted['i_linkedin_verified']==1)
                        {
                            ?>
                           <div class="verified">
                            Verified
                            </div>
                        <?php
                        }
                        else
                        {
                            ?>
                           <div class="icon" id="linkedin_action_link">
                            <a href="javascript:verify_linkedin();"><em>Verify</em></a>
                            </div>
                        <?php
                            
                        } ?>
						<span id="linkedin_login_button" style="display: none;">
                        <script type="IN/Login"></script>
                        </span>  
						<div class="spacer"></div>
						<div class="lable06">Photo</div>
						<div id="FileUpload">
                        <input type="hidden" name="h_image" id="h_image" value="<?php echo $posted['h_image']; ?>" />
							  <input type="file" name="f_image"  size="84" id="BrowserHidden" onchange="getElementById('FileField').value = getElementById('BrowserHidden').value;" />
							  <div id="BrowserVisible">
									<input type="text" id="FileField" name="txt_image"  />
							  </div>
                              <div class="err"><?php echo form_error('txt_image'); ?></div>  
						</div>
                          
						<div class="spacer"></div>
                        
                        <div class="lable06">Country</div>
                        <div class="text-fell07" >
                              <select id="opt_country" name="opt_country" style="width:273px;" onchange='ajax_change_state_option("ajax_change_country",this.value,"parent_state");'>
                                    <option>Select Country</option>
                                    <?php echo makeOptionCountry('',$posted['opt_country']); ?>
                              </select>
                        </div>
                        <div class="err" id="err_opt_country"><?php echo form_error('country'); ?></div>
                        <div class="spacer"></div>
                        
                        <div class="lable06">State</div>
                        <div class="text-fell07" id="parent_state" >
                              <select id="opt_state" name="opt_state" style="width:273px;">
                                    <option>Select State</option>
                                    <?php 
                                    if($posted['opt_country'])
                                    {
                                        
                                     echo makeOptionState(" WHERE i_country_id=".decrypt($posted['opt_country']),$posted['opt_state']); 

                                    }
                                        ?>
                              </select>
                        </div>
                        <div class="err" id="err_opt_state"><?php echo form_error('opt_state'); ?></div>
                        <div class="spacer"></div>
                        <div class="lable06">City</div>
                        <div class="text-fell05">
                              <input name="txt_city" id="txt_city" type="text" value="<?php echo $posted["txt_city"] ; ?>" />
                        </div>
                        <script type="text/javascript">
                            $(document).ready(function(){
                                    $("#txt_city").autocomplete2('<?php echo base_url().'auto-suggest/city' ?>', 
                                        {
                                        width: 263,
                                        multiple: false,
                                        matchContains: true,
                                        mustMatch: false,
                                        formatItem: function(data, i, n, value) {
                                            return value ;
                                        },
                                        formatResult: formatResult,
                                        dpendentId:'opt_state'
                                    });
                                    
                                    function formatResult(row) {
                                        return row[0].replace(/(<.+?>)/gi, '');
                                    }
                                    
                                    $('input[type=text]').attr('autocomplete', 'off');
                                    $('form').attr('autocomplete', 'off');
                            });
                        </script>
                       
                        <div class="err"><?php echo form_error('txt_city'); ?></div> 
                        <div class="spacer"></div>
                        <div class="lable06">Address</div>
                        <div class="text-fell06">
                              <textarea name="ta_address" id="ta_address" cols="" rows=""><?php echo $posted["ta_address"] ; ?></textarea>
                        </div>
                        <div class="err"><?php echo form_error('ta_address'); ?></div> 
                        <div class="spacer"></div>
                        
                        
						<div class="lable06">About Me</div>
						<div class="text-fell06">
							  <textarea name="ta_about_me" id="ta_about_me" cols="" rows=""><?php echo $posted["ta_about_me"] ; ?></textarea>
						</div>
						<div class="err"><?php echo form_error('ta_about_me'); ?></div> 
						<div class="spacer"></div>
						
						<div class="lable06">Bank details or Paypal ID</div>
						<div class="text-fell06">
							  <textarea name="ta_paypal" id="ta_paypal" cols="" rows=""><?php echo $posted["ta_paypal"] ; ?></textarea>
						</div>
						<div class="err"><?php echo form_error('ta_paypal'); ?></div> 
						<br class="spacer" />
						<span>(This is optional only applicable if you are a property owner. Site will only do bank transfer for UK host and paypal for others.)</span>
						<div class="spacer"></div>
						
						<input class="button-blu float-left margintop" type="button" name="btn_manage_account" id="btn_manage_account" value="Edit Now" />
                        </form> 
						<div class="change-password"><a href="<?php echo base_url().'change-password' ?>">Change Password</a></div>
						
				  </div>
				  <div class="spacer">&nbsp;</div>
			</div>
	  </div>
	</div>
	<br class="spacer" />
</div>