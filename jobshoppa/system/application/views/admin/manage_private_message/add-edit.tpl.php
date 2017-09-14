<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 22 Sept 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For private message Add & Edit
* 
* @package Content Management
* @subpackage manage_private_message
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_private_message/
*/

?>
 <?php
    /////////Javascript For List View//////////
?>
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<!--<script language="javascript" type="text/javascript" src="js/tinymce/tinymce_load.js"></script>-->
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
       window.location.href=g_controller+"job_message";
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
    

}*/
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
	
    var s_err="";
    $("#div_err").hide("slow"); 
	/*
	if((text = tinyMCE.get('s_content').getContent())=='') 
    {
        s_err +='Please Provide Comments .<br />';
        b_valid=false;
    }	*/
	 if($.trim($("#s_content").val())=="") 
		{
			s_err +='Please provide message.<br />';
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
		       
		<?php /*?><tr>
          <td>Title :</td>
          <td><?php echo $posted["s_job_title"];?></td>
          <td>&nbsp;</td>
        </tr><?php */?>
		
		<tr>
          <td valign="top">Message *:</td>
          <td>
		  <textarea name="s_content" id="s_content" cols="100" rows="20"><?php echo $posted["s_content"]; ?></textarea>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		
		<tr>
          <td>Status *:</td>
          <td>
		  <select id="i_status" name="i_status">
		  <?php echo makeOption($arr_status,$posted['i_status']) ?>
		  </select>
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