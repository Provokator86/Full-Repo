<?php
$fb_app_id = $_SESSION['fb_app_id'];
?>
<script src="https://connect.facebook.net/en_US/all.js"></script>
<script type="text/javascript"> 
/*FB.init({appId: '<?=$fb_app_id?>', status: true, cookie: true, xfbml: true, oauth: true});*/
FB.init({status: true, cookie: true, xfbml: true, oauth: true});
/*$(document).ready(function(){*/
//FB.XFBML.parse();
/*});    */

             
        
            function fblogincheck(){    
            
                        FB._initialized = false;
                        FB.init({appId: '<?=$fb_app_id?>', status: true, cookie: true, xfbml: true, oauth: true});
                
                        FB.login(function(response) {
                        
                            if (response.authResponse) {
                            
                                var access_token = response.authResponse.accessToken;
                                //var encoded = enc(access_token);                                
                                //$('#loading_fconnect').show();    
                                //document.getElementById('fconnect_button_a_id').onclick = function(){ };                    
                                <?php if(false) { ?>document.getElementById('loading_right_img').src='<?php echo base_url(); ?>images/front/loader.gif';<?php } ?>
                                //animated_period_fn();                                                    
                                window.location.href = '<?=base_url()?>'+'user/fconnect/'+access_token;
                                
                            } else {
                            // user cancelled login
                            }
                        },{scope: 'email'});
                    
            }
            
        
        function fblogoutcheck(){ 

            if(<?php echo (SITE_FOR_LIVE ?'true':'false'); ?>)
            {
                    FB._initialized = false;
                    FB.init({appId: '<?=$fb_app_id?>', status: true, cookie: true, xfbml: true, oauth: true});
                    
                    FB.getLoginStatus(function(response) {                                
                        if (response.status === 'connected') {                                                                    
                            FB.logout(function(response) {    
                            window.location.href = '<?=base_url()?>'+'user/logout';
                            });
                        }else { 
                        window.location.href = '<?=base_url()?>'+'user/logout';
                        }
                    });
                
            } 
            else
            {    
                window.location.href = '<?=base_url()?>'+'user/logout';
            }
                                        
        }        
        
            
            
</script>
