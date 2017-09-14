<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 04 July 2012
* Modified By: 
* Modified Date:
* Purpose:
*  View For user Add & Edit
* @package Users
* @subpackage user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/city/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<!--<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>-->
<link href="css/fe/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/fe/jquery.autocomplete.js"></script>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       //$("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_email");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate exists.</div>')
                      .insertAfter("#txt_email");
                      
                  }
                  else
                  {   
                      $("#frm_add_edit").submit();                 
                  }
                });
    }
    else
    {
         $("#frm_add_edit").submit();  
    }
    

}
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid		  = true;
	var email_pattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	var site_pattern  = /^(http)(s?)\:\/\/((www\.)+[a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;=:%\$#_]*)?/;
	var phone_number  = /^(\d){10}$/;
    var s_err		  = "";
    $("#div_err").hide("slow"); 
	
	if($.trim($("#txt_first_name").val())=="")
	{
		s_err +='Please provide first name.<br />';
		b_valid=false;
	}
	if($.trim($("#txt_last_name").val())=="")
	{
		s_err +='Please provide last name.<br />';
		b_valid=false;
	}
	
	var EmailAddress = $.trim($("#txt_email").val());
	if(EmailAddress=="") 
	{
		s_err +='Please provide email.<br />';
		b_valid=false;
	}
	else if(!email_pattern.test(EmailAddress))
	{
		s_err +='Please provide proper email.<br />';
		b_valid=false;
	}
	
	if($.trim($("#txt_phone").val())=="")
	{
		s_err +='Please provide phone number.<br />';
		b_valid=false;
	}
	else if(phone_number.test($("#txt_phone").val())==false)
	{
		s_err +='Please provide 10 digits phone number.<br />';
		b_valid=false;
	}
	
	if($.trim($("#ta_about").val())=="")
	{
		s_err +='Please provide about user.<br />';
		b_valid=false;
	}
	
    
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////    


$("#opt_country").change(function(){
     var country_id =   $(this).val();  
     $("#opt_state").hide().prev("span").show();
     
     $.ajax({
                type: "POST",
                url: base_url+'ajax_common/ajax_change_state_option',
                data: "country_id="+country_id,
                success: function(msg){
                   if(msg!='')
                   {
                        $("#opt_state").prev("span").hide();
                        $("#opt_state").show();
                        $("#opt_state").html(msg);
                   }   
                }
            });
})  ;


$("#opt_state").change(function(){
     var state_id =   $(this).val();  
     $("#opt_city").hide().prev("span").show();
     
     $.ajax({
                type: "POST",
                url: base_url+'ajax_common/ajax_change_city_option',
                data: "state_id="+state_id,
                success: function(msg){
                   if(msg!='')
                   {
                        $("#opt_city").prev("span").hide();
                        $("#opt_city").show();
                        $("#opt_city").html(msg);
                   }   
                }
            });
})  ;
    
})});    

function delete_image(file_name,user_id)
{
	jQuery.noConflict();///$ can be used by other prototype which is not jquery
	jQuery(function($){	
		 $.ajax({
					type: "POST",
					async: false,
					url: base_url+'admin/user/ajax_delete_image',
					data: "h_id="+user_id+"&image_name="+file_name,
					success: function(msg){
				   if(msg=="ok") 
				   {			
				    $("#main_image").remove();	
					$("a[id^='delete_link']").remove();		
					$("input[id^='h_image']").remove();			   				   
					$('#div_err').addClass('success_massage').html('image deleted successfully.').show(500).delay(1000).hide(500);   
				   }
				   else
				   {
					$('#div_err').addClass('error_massage').html('image can not be deleted.').show(500).delay(1000).hide(500);  
				   }

				}  // end success
			});  // end of ajax
	});
}



</script>    
 
<?php
  /////////end Javascript For List View//////////  
  /****
<div class="success_massage"><span>SUCCESS!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
<div class="error_massage"><span>ERROR!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
<div class="warning_massage"><span>Warning!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
<div class="info_massage"><span>Information!</span>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</div>
  */
  
  
?> 

<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
			/*  pr($posted);*/
            ?>
        </div>     
    
    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>          
        </tr>  
        
      
              
        <tr>
          <td>First Name *:</td>
          <td><input id="txt_first_name" name="txt_first_name" value="<?php echo $posted["txt_first_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
          <td>Last Name *:</td>
          <td><input id="txt_last_name" name="txt_last_name" value="<?php echo $posted["txt_last_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
         <tr>
          <td>Email *:</td>
          <td><input id="txt_email" name="txt_email" value="<?php echo $posted["txt_email"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Phone *:</td>
          <td><input id="txt_phone" name="txt_phone" value="<?php echo $posted["txt_phone"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Facebook :</td>
          <td><input id="txt_facebook" name="txt_facebook" value="<?php echo $posted["txt_facebook"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Twitter :</td>
          <td><input id="txt_twitter" name="txt_twitter" value="<?php echo $posted["txt_twitter"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Linkedin :</td>
          <td><input id="txt_linkedin" name="txt_linkedin" value="<?php echo $posted["txt_linkedin"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">Image :</td>
          <td>
		  <!--<img src="images/admin/user_acc_thumb.jpg" /><a href="javascript:void(0);">Delete image</a>-->
		  <?php  
			if(!empty($posted["f_image"]))
			{
				
				$tmp_file	=	getFilenameWithoutExtension($posted["f_image"]);
				$user_id = decrypt($posted['h_id']);
				echo '<img src="'.base_url().'uploaded/user/min/'.$tmp_file.'_min.jpg'.'" id="main_image"  border="0" />';
				echo '<input type="hidden" name="h_image" id="h_image" value="'.$posted["f_image"].'" />';
			/*echo '<a id="delete_image_id_'.$posted["h_id"].'_'.$tmp_file.'" href="javascript:void(0);">Delete image</a><br/>';*/
				echo '<a id="delete_link" onclick="delete_image(\''.$tmp_file.'\',\''.$user_id.'\');" href="javascript:void(0);">Delete image</a><br/>';
			}
			
			?>
		  <input id="f_image" name="f_image" value="<?php echo $posted["f_image"];?>" type="file" size="30" />	  
		  
		  </td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td>Country *:</td>
          <td> 
          <select name="opt_country" id="opt_country" style="width: 200px;" >
                <option value="">Select Country</option>
                <?php echo makeOptionCountry('',$posted['opt_country']); ?>
            </select>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>State *:</td>
          <td> 
           <select name="opt_state" id="opt_state" style="width: 200px;">
                <option value="">Select State</option>
                <?php if($posted['opt_country']){
                       echo makeOptionState(' WHERE i_country_id='.decrypt($posted['opt_country']).' ',$posted['opt_state']) ;
                    
                } ?>
            </select>
          </td>
          <td>&nbsp;</td>
        </tr>
          <tr>
              <td>City *:</td>
              <td> 
                    <input name="txt_city" id="txt_city" type="text" value="<?php echo $posted["txt_city"] ; ?>" size="50" />
              </td>
              <td>&nbsp;</td>
        </tr>
          <script type="text/javascript">
          jQuery(function($) {
                            $(document).ready(function(){
                                    $("#txt_city").autocomplete('<?php echo base_url().'auto-suggest/city' ?>', 
                                        {
                                        width: 300,
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
          });
                        </script>
          
        <tr>
          <td valign="top">Address *:</td>
          <td>
          <textarea name="ta_address" id="ta_address" cols="47" rows="8"><?php echo $posted["ta_address"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr> 
        <tr>
          <td valign="top">About User *:</td>
          <td>
          <textarea name="ta_about" id="ta_about" cols="47" rows="8"><?php echo $posted["ta_about"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td valign="top">Paypal/Bank Details *:</td>
          <td>
          <textarea name="ta_paypal_details" id="ta_paypal_details" cols="47" rows="8"><?php echo $posted["ta_paypal_details"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr> 
        
      

      </table>
      </div>
    <? /***** end Modify Section *******/?>      
    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
    
</form>
</div>