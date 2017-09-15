<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 9 Sep 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For zipcode Add & Edit
* 
* @package Content Management
* @subpackage zipcode
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/zipcode/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>

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
      // $("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_zip_code");
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
                      .insertAfter("#txt_zip_code");
                      
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
    var s_err="";
	var zip_pattern = /^[ABCEGHJ-NPRSTVXY]{1}[0-9]{1}[ABCEGHJ-NPRSTV-Z]{1}[ ]?[0-9]{1}[ABCEGHJ-NPRSTV-Z]{1}[0-9]{1}$/;
	var lat_pattern = /^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}/;
	var long_pattern = /^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}/;
	var city_type_pattern = /[A-Z]{1}/;
    $("#div_err").hide("slow"); 

    
	 if($.trim($("#txt_zip_code").val())=="") 
		{
			s_err +='Please provide postal code.<br />';
			b_valid=false;
		}
		
	else if(!zip_pattern.test($("#txt_zip_code").val()))	
	{
		s_err +='Please provide proper postal code.<br />';
			b_valid=false;
	}
		
	if($.trim($("#opt_state_id").val())=="") 
		{
			s_err +='Please select state.<br />';
			b_valid=false;
		}
    if($.trim($("#opt_city_id").val())=="") 
		{
			s_err +='Please select city.<br />';
			b_valid=false;
		}
		
	if($.trim($("#txt_city_type").val())=="") 
		{
			s_err +='Please provide city type.<br />';
			b_valid=false;
		}
		
	else if(!city_type_pattern.test($("#txt_city_type").val()))	
	{
		s_err +='Please provide correct city type.<br />';
		b_valid=false;
	}	
		
 	if($.trim($("#txt_latitude").val())=="") 
		{
			s_err +='Please provide latitude.<br />';
			b_valid=false;
		}
		
	else if(!lat_pattern.test($("#txt_latitude").val()))	
	{
		s_err +='Please provide correct latitude in decimal values.<br />';
		b_valid=false;
	}
	
	if($.trim($("#txt_longitude").val())=="") 
		{
			s_err +='Please provide longitude.<br />';
			b_valid=false;
		}
	
	else if(!long_pattern.test($("#txt_longitude").val()))	
	{
		s_err +='Please provide correct longitude in decimal values.<br />';
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
    
})}); 



// Ajax call to populate city options
function call_ajax_get_city(ajaxURL,item_id,cngDv)
{
	jQuery.noConflict();///$ can be used by other prototype which is not jquery
	jQuery(function($) {
		document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
		$.ajax({
				type: "POST",
				url: base_url+'home/'+ajaxURL,
				data: "state_id="+item_id,
				success: function(msg){
				   if(msg!='')
				   {
					   document.getElementById(cngDv).innerHTML = msg;
					   //$("#opt_city").msDropDown();
					  // call_ajax_get_zipcode("ajax_change_zipcode_option",0,0,"parent_zip"); // to repopulate zip options

				   }   
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
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
          
        </tr>        
		<tr>
          <td>Postal Code *:</td>
          <td><input id="txt_zip_code" name="txt_zip_code" value="<?php echo $posted["txt_zip_code"];?>" type="text" size="50" />
		  <br/>[Example: A2G 3C7]</td>
          
		  <td>&nbsp;</td>
        </tr>
		
		<tr>
			<td>Select State *:</td>
			<td>
				<select name="opt_state_id" id="opt_state_id" >
						<option value="">Select State </option>
						<?php  echo makeOptionState('i_parent_id=0', $posted["opt_state_id"])?>
						
				</select>
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>Select City *:</td>
			<td>
				
				<select name="opt_city_id" id="opt_city_id">
						<option value="">Select City </option>
						<?php  echo makeOptionCity('i_parent_id=0', $posted["opt_city_id"])?>
				</select>
				
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>City Type *:</td>
			<td><input id="txt_city_type" name="txt_city_type" value="<?php echo $posted["txt_city_type"];?>" type="text" size="20" />
			<br/>[Like: A to Z any letter]
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
          <td>Latitude *:</td>
          <td><input id="txt_latitude" name="txt_latitude" value="<?php echo $posted["txt_latitude"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Longitude *:</td>
          <td><input id="txt_longitude" name="txt_longitude" value="<?php echo $posted["txt_longitude"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>     
           
           
        <tr>
          <td>Active:</td>
          <td><input id="i_zip_is_active" name="i_zip_is_active" value="1" <?php if($posted["i_zip_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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