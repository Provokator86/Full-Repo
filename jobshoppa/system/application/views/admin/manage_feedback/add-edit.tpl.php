<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For feedback Add & Edit
* 
* @package Content Management
* @subpackage feedback
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/feedback/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<!--<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>-->

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
      $("#frm_add_edit").submit();
	  // check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
/*function check_duplicate(){
    var $this = $("#txt_news_title");
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
                      $('<div id="err_msg" class="star_err1">Duplicate title exists.</div>')
                      .insertAfter("#txt_news_title");
                      
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
    

}*/
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
    $("#div_err").hide("slow"); 

    if($.trim($("#s_comments").val())=="") 
    {
        s_err +='Please provide comments.<br />';
        b_valid=false;
    }
		
	<?php
	if($posted['i_status']==2)
	{
	?>
	if($.trim($("#s_terminate_reason").val())=="") 
    {
        s_err +='Please provide terminate reason.<br />';
        b_valid=false;
    }
	<?php } ?>
	
	if($("input[@name='i_positive']:checked","#frm_add_edit").val()==1)
		{
			if($("#opt_rate option:selected").val()<=2)
			{
				
				s_err +='Rating must be given above 2';				
				b_valid=false;
			}
		}
	else 	
		{
			if($("#opt_rate option:selected").val()>2)
				{
					s_err +='Rating must be given below 3';					
					b_valid=false;
				}
		}	
	
	/*if((text = tinyMCE.get('s_comments').getContent())=='') 
    {
        s_err +='Please provide comments .<br />';
        b_valid=false;
    }*/
    
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

function chk_rate(arg)
{
	if(arg)
	{
		var myOptions = {
			1 : 1,
			2 : 2
		};
	}
	else
	{
		var myOptions = {
			3 : 3,
			4 : 4,
			5 : 5
		};
	}	
	
	jQuery('#opt_rate').empty();
	jQuery.each(myOptions, function(val, text) {
		jQuery('#opt_rate').append(
			jQuery('<option></option>').val(val).html(text)
		);
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
          <th colspan="3" align="left"><h4><?php echo $heading;?></h4></th>
        </tr>        
		<tr>
          <td width="27%">Job Title:</td>
          <td width="62%"><?php echo $posted["s_job_title"];?></td>
          <td width="11%">&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Comments *:</td>
          <td>
          <textarea name="s_comments" style="width:600px;" id="s_comments" cols="100" rows="20"><?php echo $posted["s_comments"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
		<?php
		if($posted['i_status']==2)
		{
		?>		
		<tr>
          <td valign="top">Terminate Reason *:</td>
          <td>
          <textarea name="s_terminate_reason" style="width:600px;" id="s_terminate_reason" cols="100" rows="20"><?php echo $posted["s_terminate_reason"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
		<?php } ?>
		<tr>
          <td>Rating:</td>
          <td>
		  <select style="width:50px;" name="opt_rate" id="opt_rate">
		  <?php echo makeRating($arr_rating,$posted["opt_rate"]); ?>		  
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr>
       
          
       <?php /*?> <tr>
          <td>Status:</td>
          <td>
		  <select name="i_status" id="i_status">
		  <option value="0">Rejected</option>
		  <option value="1">Approved</option>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr><?php */?>
		
		 <tr>
          <td>Type :</td>
          <td  valign="middle">
		  <input type="radio" name="i_positive" id="i_positive" value="0" onclick="chk_rate(1)" <?php if($posted["i_positive"]==0) echo 'checked="checked"';?>/> Negative 
		  <input type="radio" name="i_positive" id="i_positive" value="1" onclick="chk_rate(0)" <?php if($posted["i_positive"]==1) echo 'checked="checked"';?>/> Positive
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