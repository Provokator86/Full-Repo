<?php
/*********
* Author: Koushik Rout
* Date  : 16 Nov 2011
* Modified By: 
* Modified Date:
* 
* Purpose:
*  View For blog Add & Edit
* 
* @package Content Management
* @subpackage blog
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/blog/
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
    var $this = $("#txt_blog_title");
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
                      .insertAfter("#txt_blog_title");
                      
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

    
	 if($.trim($("#txt_blog_title").val())=="") 
    {
        s_err +='Please provide blog title.<br />';
        b_valid=false;
    }
	if((text = tinyMCE.get('txt_blog_description').getContent())=='') 
    {
        s_err +='Please provide description .<br />';
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
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
    <h2><?php echo $heading;?></h2>
        <div class="info_box">From here Admin can add or edit the Blog .</div>  
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
          <td>Title *:</td>
          <td><input id="txt_blog_title" name="txt_blog_title" value="<?php echo $posted["txt_blog_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td valign="top">Description *:</td>
          <td>
          <textarea name="txt_blog_description" id="txt_blog_description" cols="46" rows="4"><?php echo $posted["txt_blog_description"]; ?></textarea>
          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Blog Image :</td>
          <td>
          <?php 

                if(!empty($posted["txt_image_name"]))
                {
                    
                    echo showThumbImage('manage_blog',$posted["txt_image_name"],80,80).'<br><br>';
                    echo ' <input type="hidden" name="h_image_name" id="h_image_name" value="'.$posted["txt_image_name"].'" />';
                }
            
            ?>
          <input id="txt_image_name" name="txt_image_name"  type="file" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <!--<tr>
          <td>Photo *:</td>
          <td><input id="txt_user_type" name="txt_user_type" type="file" size="30" /></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>-->
        
         <?php /*?><tr>
            <td valign="top" > Upload Picture</td>
            <td>
           <div id="upload" style="cursor:pointer;<?php echo (!empty($posted['h_picture']))?'display:none;':''?>" >
           <span>Upload<span>
           </div>
           
                <div id="status" class="" ></div>
                <ul id="files" ></ul> 
                <div id="hdnflds" ></div>
                <?php echo (!empty($posted['h_picture']))?'<div id="prof_img"><div class="" ><img src="'.$this->showimgdir.'thumb/'.$posted['h_picture'].'" alt=""  /></div><div id="upload2" onclick="javascript:delpicmain(\''.$posted["h_picture"].'\',\''.$posted["h_id"].'\')"><span>Delete<span></div><div style="clear:both"></div></div>':''; ?>
             </td>
             <td>&nbsp;</td>
          <td>
		  <?php echo (isset($posted['h_picture']))?'<input type="hidden" name="h_prev_pic" id="h_prev_pic" value="'.$posted['h_picture'].'" />':'';?>
          </td>
          </tr><?php */?>
          
           
           
           
        <tr>
          <td>Active:</td>
          <td><input id="i_blog_is_active" name="i_blog_is_active" value="1" <?php if($posted["i_blog_is_active"]==2) echo ''; else echo 'checked="checked"';?>  type="checkbox" /></td>
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