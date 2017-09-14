<?php
  /*********
* Author: Koushik rout
* Date  : 29 March 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Add & Edit tpl  For Category 
* 
* @package General
* @subpackage Category
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/category_model.php
* @link controler/admin/category.php
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
       //$("#frm_add_edit").submit();
	   check_duplicate();
   }); 
});    
    
//////////Checking Duplicate/////////
function check_duplicate(){
    var $this = $("#txt_category_name");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();

    if($this.val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val(),
                "h_lang_prefix": $("#opt_language").val()
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate exists.</div>')
                      .insertAfter("#txt_category_name");
                      
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
    var s_err="";
    $("#div_err").hide('slow'); 

    //alert($("#opt_type_id").val());
	
	 if($.trim($("#txt_category_name").val())=="") 
		{
			s_err +='Please provide category name.<br />';
			b_valid=false;
		}     
   
	
    /////////validating//////
    if(!b_valid)
    {
        $.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show('slow');
    }
    
    return b_valid;
}); 
///////////end Submitting the form///////// 


//////////////////// AJAX CALL TO GET CONTENT/////////////////////////
    $("#opt_language").change(function(){
        var h_id    =   $("#h_id").val();
        $.ajax({
            type: "POST",
            async: false,
            url: g_controller+'ajax_fetch_contains',
            data: "s_lang_prefix="+$(this).val()+"&h_id="+h_id,
            success: function(msg){   
                $("#txt_category_name").val(msg);               
            }
       } ); 
    })  ; 
/////////////////// END OF AJAX CALL TO GET CONTENT/////////////////////////  
    
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
	<div class="info_box">From here Admin can add or edit the Category.</div>
	<div class="clr"></div>
    <p>&nbsp;</p>
        <div id="div_err" >
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
          <th width="30%" align="left" colspan="3"><h4><?php echo $heading;?></h4></th>          
        </tr>  
		   
         <tr>
          <td>Language *:</td>
          <td>
          <?php if($posted["h_mode"]=="edit")
          {  ?>
          <select name="opt_language" id="opt_language" >
          <!--<option value="">select language</option>-->
            <?php 
                echo makeOptionLanguagePrefix($posted["opt_language"]) ;  
            ?>
          </select>
          <?php }
          else
          { ?>
                <input type="hidden" id="opt_language" value="<?php echo $s_lang_prefix; ?>"/>
                <input type="text" readonly="readonly" size="24" value="<?php echo $s_language; ?>" />
          <?php }?>
          </td>
          <td>&nbsp;</td>
        </tr>
		     
		<tr>
          <td>Category Name *:</td>
          <td><input id="txt_category_name" name="txt_category_name" value="<?php echo $posted["txt_category_name"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td>Category Icon:</td>
          <td>
		  <?php  
			if(!empty($posted["f_icon"]))
			{
				echo '<img src="'.base_url().'uploaded/category/thumb/thumb_'.$posted["f_icon"].'"  border="0" /><br><br>';
				echo '<input type="hidden" name="h_icon" id="h_icon" value="'.$posted["f_icon"].'" />';
			}
			
			?>
		  <input id="f_icon" name="f_icon" type="file" size="30" />
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