<?php
/*********
* Author: Jagannath Samanta
* Date  : 18 June 2011
* Modified By: Mrinmoy Mondal
* Modified Date: 12 Sep 2011
* 
* Purpose:
* View For event Add & Edit Testimonial
* 
* @package Content Management
* @subpackage testimonial
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/testimonial/
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
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
	   //check_duplicate(); 
   }); 
});    
    
//////////Checking Duplicate/////////
/*function check_duplicate(){
    var $this = tinyMCE.get('txt_content').getContent();
    $("#txt_content").next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this,
				"lang_id":$("#opt_language").val()
				
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $("#txt_content").focus();
                      $('<div id="err_msg" class="star_err1" style="color:#F00">Duplicate Description Exists.</div>')
                      .insertAfter("#txt_below_slab");
                      
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
    

}*/
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
	var pattern = /^\+?[0-9]*\.?[0-9]+$/;
    var s_err="";
    $("#div_err").hide("slow"); 

	 if($.trim($("#txt_below_slab").val())=="") 
		{
			s_err +='Please Provide Commission %(1-100).<br />';
			b_valid=false;
		}
	else if(!pattern.test($("#txt_below_slab").val()))	
		{
			s_err +='Please Provide Correct Commission %(1-100).<br />';
			b_valid=false;
		}		
		
    if($.trim($("#txt_upper_slab").val())=="") 
		{
			s_err +='Please Provide Commission %(Greater than 100).<br />';
			b_valid=false;
		}	
	else if(!pattern.test($("#txt_upper_slab").val()))	
		{
			s_err +='Please Provide Correct Commission %(Greater than 100).<br />';
			b_valid=false;
		}
	if(! $("input[name=i_is_active]:checkbox").is(":checkbox:checked"))
	{
		s_err +='Please activate this commission values.<br />';
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

//$(#div_err).click(function(){$(this).hide();});


    
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
	<div class="info_box">From here Admin can set the commission slab to be paid as commission.</div>
	<div class="clr"></div>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
			/*  pr($posted);*/
            ?>
        </div>     
    	<div id="div_err"><?php show_msg(); ?></div>  
    
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>          
        </tr>  
		      
		<tr>
          <td>Commission % (1-100) *:</td>
          <td><input id="txt_below_slab" name="txt_below_slab" value="<?php echo $posted["txt_below_slab"];?>" type="text" size="30" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td> Commission %(Greater than 100) *:</td>
          <td><input id="txt_upper_slab" name="txt_upper_slab" value="<?php echo $posted["txt_upper_slab"];?>" type="text" size="30" /></td>
          <td>&nbsp;</td>
        </tr> 
		
        <tr>
          <td>Active:</td>
          <td><input id="i_is_active" name="i_is_active" value="1" <?php if($posted["i_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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