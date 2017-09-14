<?php
$current_url =  str_replace('=','',base64_encode(base_url().substr(uri_string(),1)));
?>
<script>
var g_controller = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript" src="js/jquery.form.js"></script>   
<script language="javascript">
//jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){ 
    
     /************ START OF SENDING MESSAGE BY AJAX FORM **********/
        var options = {

                success:    function(ret_) {
                   if(ret_=='ok')
                   {
                        window.location.reload();
                  }
                }
        }
        
         $('form#frm_currency').ajaxForm(options); 

    $(".ddChild a[id^=opt_currency_]").click(function(){ 
        //alert($("#opt_currency").html());
        //var h_id    =   $(this).val();

		    $('#frm_currency').submit();
      /*  $.ajax({
            type: "POST",
            async: false,
            url: g_controller+'home/change_currency/',
            data: "url="+url_str+"&currency_id="+h_id,
            success: function(msg){
				if(msg=='ok')
				{
              	window.location.reload();
				}
               
            }
       } );  */
    })  ; 

})
});

</script>
<?php include_once(APPPATH."views/fe/common/facebook_js.php"); ?> 
<!--top bar-->
<div class="top-bar">
            <div class="wrapper">
                  <div class="container-box">
                         <input class="list-button" type="button" value="List your Place" onclick="window.location.href='<?php echo base_url().'list-your-place' ?>'" />
                        <div class="textfell">
                        <form action="<?php echo base_url().'home/change_currency' ; ?>" method="post" id="frm_currency" name="frm_currency">
                              <select name="opt_currency" id="opt_currency" style="width:50px;">
                                  <?php echo makeOptionCurrency('',encrypt($i_currency_id)); ?>
                                
                              </select>
                        </form>
                        </div>
						<?php if(empty($loggedin)) { ?>
                        <ul>
                              <li><a <?php //echo ($this->i_footer_menu==7)?'class="select"': '' ?> href="<?php echo base_url().'contact-us' ?>">Contact us</a></li>
                              <li>|</li>
                              <li><a <?php //echo ($this->i_footer_menu==9)?'class="select"': '' ?> href="<?php echo base_url().'user/registration' ?>">Register</a></li>
                              <li>|</li>
                              <li><a <?php //echo ($this->i_footer_menu==10)?'class="select"': '' ?> href="<?php echo base_url().'user/login' ?>">Login</a></li>
                        </ul>
						<?php } else {  ?> 
						<ul>
                              <li><?php echo showThumbImageDefault('user_image',$loggedin["user_image"],'min',35,35); ?>Hello <a href="<?php echo base_url().'dashboard' ?>" > <?php echo ucfirst($loggedin["user_first_name"])." ".ucfirst($loggedin["user_last_name"]) ; ?> </a></li>
                              <li>|</li>
                              <li><a <?php //echo ($this->i_footer_menu==7)?'class="select"': '' ?> href="<?php echo base_url().'contact-us' ?>">Contact us</a></li>
                              <li>|</li>
                              <li><?php /* <a href="<?php echo base_url().'user/logout'?>">Sign Out</a> <?php */ ?><a href="javascript:fblogoutcheck();">Sign Out</a></li>
                        </ul>
						<?php } ?> 
						
                  </div>
            </div>
      </div>
<!--top bar-->