<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 21 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For user Add & Edit
* 
* @package Content Management
* @subpackage user
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/user/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>
<script>
var g_controller="<?php echo $pathtoclass;?>";//controller Path 
</script>
<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){


    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
      // $("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#s_email");
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
                      $('<div id="err_msg" class="star_err1">Duplicate email exists.</div>')
                      .insertAfter("#s_email");
                      
                  }
                  else
                  {
                     // $('<div id="err_msg" class="star_succ1">You can choose this year.</div>')
                    //  .insertAfter("#txt_milestones_year");     
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
    var b_valid=true;
	//var lat_long_pattern = /^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}/;
	var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#s_username").val())=="") 
		{
			s_err +='Please provide username.<br />';
			b_valid=false;
		}
	 if($.trim($("#s_name").val())=="") 
		{
			s_err +='Please provide name.<br />';
			b_valid=false;
		}
	
	/*EMAIL FOR BUYERS*/
	var adminEmailaddressVal = $.trim($("#s_email").val());
	if(adminEmailaddressVal=="") 
	{
		s_err +='Please provide email.<br />';
		b_valid=false;
	}
	
	else if(!emailReg.test(adminEmailaddressVal)) 
	{
		s_err +='Please provide proper email.<br />';
		b_valid=false;
	}
	 
	if($.trim($("#s_contact_no").val())=="") 
		{
			s_err +='Please provide contact no.<br />';
			b_valid=false;
		}
	/*else if(isNaN($.trim($("#s_contact_no").val())))
	{
		s_err +='contact number will be numeric value.<br />';
        b_valid=false;
	}*/	
	if($.trim($("#opt_state").val())=="select") 
		{
			s_err +='Please select a province.<br />';
			b_valid=false;
		}
	if($.trim($("#opt_city").val())=="select") 
		{
			s_err +='Please select a city.<br />';
			b_valid=false;
		}
	if($.trim($("#opt_zip").val())=="select") 
		{
			s_err +='Please select a postal code.<br />';
			b_valid=false;
		}			
		
	/*if($.trim($("#opt_role").val())=="") 
		{
			s_err +='Please select a role.<br />';
			b_valid=false;
		}	*/						
		
	
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    
    return b_valid;
});    
///////////end Submitting the form/////////    
    
})});    



// Ajax call to populate city options
function call_ajax_get_city(ajaxURL,item_id,cngDv)
{
	jQuery.noConflict();///$ can be used by other prototype which is not jquery
	jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: g_controller+ajaxURL,
				data: "state_id="+item_id,
				success: function(msg){
				   if(msg!='')
					   document.getElementById(cngDv).innerHTML = msg;
				}
			});
	});	
}

function call_ajax_get_zipcode(ajaxURL,item_id,state_id,cngDv)
{
	jQuery.noConflict();///$ can be used by other prototype which is not jquery
	jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: g_controller+ajaxURL,
				data: "city_id="+item_id+"&state_id="+state_id,
				success: function(msg){
				   if(msg!='')
					   document.getElementById(cngDv).innerHTML = msg;
				}
			});
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
<form id="frm_add_edit" name="frm_add_edit" method="post" action="">
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
          <th width="30%" colspan="3" align="left"><h4><?php echo $heading;?></h4></th>          
        </tr> 
		       
		<tr>
          <td>Username *:</td>
          <td><input id="s_username" name="s_username" value="<?php echo $posted["s_username"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Name *:</td>
          <td><input id="s_name" name="s_name" value="<?php echo $posted["s_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Email *:</td>
          <td><input id="s_email" name="s_email" value="<?php echo $posted["s_email"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Skype Id :</td>
          <td><input id="s_skype_id" name="s_skype_id" value="<?php echo $posted["s_skype_id"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>MSN Id :</td>
          <td><input id="s_msn_id" name="s_msn_id" value="<?php echo $posted["s_msn_id"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Yahoo Id :</td>
          <td><input id="s_yahoo_id" name="s_yahoo_id" value="<?php echo $posted["s_yahoo_id"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Contact No *:</td>
          <td><input id="s_contact_no" name="s_contact_no" value="<?php echo $posted["s_contact_no"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Province *:</td>
          <td>
		  <select id="opt_state" name="opt_state" onchange='call_ajax_get_city("ajax_change_city_option",this.value,"parent_city");'>
		  	<option>select</option>
			<?php echo makeOptionState('',$posted['opt_state']) ?>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>City *:</td>
          <td>
		  <div id="parent_city">
			  <select id="opt_city" name="opt_city" >
				<option>select</option>
				<?php echo makeOptionCity(' state_id="'.$posted['opt_state'].'" ',$posted['opt_city']) ?>
			  </select>
		  </div>
		  </td>
          <td>&nbsp;</td>
        </tr>
		<tr>
          <td>Postal Code *:</td>
          <td>
		  <div id="parent_zip">
		  <select id="opt_zip" name="opt_zip">
		  	<option>select</option>
			<?php echo makeOptionZip(' state_id="'.$posted['opt_state'].'" AND city_id="'.decrypt($posted['opt_city']).'" ',$posted['opt_zip']) ?>
		  </select>
		  </div>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
        
         <tr>
          <td>Verified:</td>
          <td><input id="i_verified" name="i_verified" value="1" <?php if($posted["i_verified"]==0) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
          <td>&nbsp;</td>
        </tr>
           
        <tr style="display:none;">
          <td>Active:</td>
          <td><input id="i_is_active" name="i_is_active" value="1" <?php if($posted["i_is_active"]==0) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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