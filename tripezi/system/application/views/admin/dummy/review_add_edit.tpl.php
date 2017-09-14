<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 30 March 2012
* Modified By: Mrinmoy Mondal
* Modified Date: 
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


<script language="javascript">
jQuery.noConflict();///$ can be used by other prototype which is not jquery
jQuery(function($) {
$(document).ready(function(){

     
var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    
$('input[id^="btn_cancel"]').each(function(i){
  /* $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller+"show_list";
   });   */
});      
    
$('input[id^="btn_save"]').each(function(i){
  /* $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_add_edit").submit();
       //check_duplicate(); 
   }); */
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = tinyMCE.get('txt_content').getContent();
    
    $("#txt_content").next().remove("#err_msg");  
    $(".star_err1").remove();
    $(".star_succ1").remove();
    
    if($this!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this
                
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $("#txt_content").focus();
                      $('<div id="err_msg" class="star_err1" style="color:#F00">Duplicate Description Exists.</div>')
                      .insertAfter("#txt_content");
                      
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
$("#frm_add_edit").bind('submit', function(){

    var b_valid=true;
    //var emailReg = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    var s_err="";
    $("#div_err").hide("slow"); 
//alert('ok');
     if($.trim($("#txt_person_name").val())=="") 
        {
            s_err +='Please provide person name.<br />';
            b_valid=false;
        }
     /*if($.trim($("#txt_content").val())=="") 
        {
            s_err +='Please provide person name.<br />';
            b_valid=false;
        }*/
        if((text = tinyMCE.get('txt_content').getContent())=='') 
        {
            s_err +='Please provide description .';
            b_valid=false;
        }
    
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
    }
    //alert(b_valid);
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
<form id="frm_add_edit" name="frm_add_edit" method="post" action="<?php echo $action_url;?>" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
    <div class="info_box">From here Admin can edit reviews .</div>
    <div class="clr"></div>
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
          <td>Rating *:</td>
          <td><input id="txt_person_name" name="txt_person_name" value="<?php echo $posted["txt_person_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Comment *:</td>
          <td>
          <textarea name="txt_content" id="txt_content" cols="100" rows="20"><?php echo $posted["txt_content"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr> 
		<tr>
          <td valign="top">Image *:</td>
          <td>
          <input type="file" />
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