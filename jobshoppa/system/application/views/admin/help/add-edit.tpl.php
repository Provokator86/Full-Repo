<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 17 Sep 2011
* Modified By: Jagannath Samanta 
* Modified Date: 28 June 2011
* 
* Purpose:
*  View For help Add & Edit
* 
* @package Content Management
* @subpackage help
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/help/
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
       $("#frm_add_edit").submit();
	   //check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_help_question");
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
                      .insertAfter("#txt_help_question");
                      
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
    $("#div_err").hide("slow"); 

    
	

		
	if($.trim($("#opt_cat").val())=="") 
		{
			s_err +='Please provide category.<br />';
			b_valid=false;
		}	
	 if($.trim($("#txt_help_question").val())=="") 
		{
			s_err +='Please provide question.<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_help_answer').getContent())=='') 
		{
			s_err +='Please provide answer .<br />';
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


// AJAX CALL TO GET CONTENT

function ajax_call_get_content(ajaxURL,category_id,s_question)
{
	jQuery.noConflict();
	jQuery(function($){
		$.ajax({
				
				type:"POST",
				url:g_controller+ajaxURL,
				data: "cat_id="+category_id+"&s_question="+s_question,
				dataType:"json",
				success: function(msg){		
				
					if(msg!=null)
					{						
						tinyMCE.get("txt_help_answer").setContent(msg.s_answer);
					}
					else
					{					
						tinyMCE.get("txt_help_answer").setContent('');
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
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <div class="info_box">From here Admin can add or edit the help questions and answers .</div>
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
          <th align="left" colspan="3"><h4><?php echo $heading;?></h4></th>          
        </tr>  
		
		
		<tr>
          <td width="29%">Category *:</td>
          <td width="50%">
		  <select id="opt_cat" name="opt_cat" onchange='ajax_call_get_content("ajax_get_content",this.value,txt_help_question.value);' >
		  	<option value="">Select</option>
			<?php echo makeOptionCategory('s_category_type="'.help.'" AND c.i_status=1 ',$posted["opt_cat"]); ?>
		  </select>
		  </td>
          <td width="21%">&nbsp;</td>
        </tr>
		     
		<tr>
          <td>Question *:</td>
          <td><input id="txt_help_question" name="txt_help_question" value="<?php echo $posted["txt_help_question"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
        <tr>
          <td valign="top">Answer *:</td>
          <td>
          <textarea name="txt_help_answer" id="txt_help_answer" cols="46" rows="4"><?php echo $posted["txt_help_answer"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
           
        <tr style="display:none;">
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