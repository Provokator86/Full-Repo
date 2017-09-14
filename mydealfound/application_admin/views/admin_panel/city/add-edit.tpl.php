<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 18 Jan 2013
* Modified By: 
* Modified Date:
* Purpose:
*  View For city Add & Edit
* @package General
* @subpackage city
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/city/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>

<script type="text/javascript" language="javascript">

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
    var $this = $("#txt_city");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	var i_country_id   	=   $("#opt_country").val();
	var i_state_id   	=   $("#opt_state").val();
	
    if($this.val()!="" && i_country_id!='' && i_state_id!='')
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val(),
				"i_country_id":i_country_id,
				"i_state_id":i_state_id
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate exists.</div>')
                      .insertAfter("#txt_city");
                      
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
    var b_valid=true;
	var pattern = /^[a-zA-Z]+/;
    var s_err="";
    $("#div_err").hide("slow"); 

    
	if($.trim($("#opt_country").val())=="") 
		{
			s_err +='Please select country name.<br />';
			b_valid=false;
		}
	if($.trim($("#opt_state").val())=="") 
		{
			s_err +='Please select state name.<br />';
			b_valid=false;
		}	
	 if($.trim($("#txt_city").val())=="") 
		{
			s_err +='Please provide city name.<br />';
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


    
});    



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
          <td>Country name *:</td>
          <td>
		  	<select name="opt_country" id="opt_country" style="width:280px;" >
				<option value="">Select Country</option>
				<?php echo makeOptionCountry('',$posted['opt_country']) ?>
			</select>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>State name *:</td>
          <td>
		  <span style="display: none;"> <img src="images/admin/loading.gif" alt="loading"></span>
		  	<select name="opt_state" id="opt_state" style="width:280px;">
				<option value="">Select State</option>
                <?php if($posted['opt_state']){
                       echo makeOptionState(' WHERE i_country_id='.decrypt($posted['opt_country']).' ',$posted['opt_state']) ;
                    
                } ?>
				<?php // echo makeOptionState('',$posted['opt_state']) ?>
			</select>
		  </div>	
		  </td>
          <td>&nbsp;</td>
        </tr>
		      
		<tr>
          <td>City Name *:</td>
          <td><input id="txt_city" name="txt_city" value="<?php echo $posted["txt_city"];?>" type="text" size="50" /></td>
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