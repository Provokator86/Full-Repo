<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 04 April 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  View For how it works for tradesman Add & Edit
* 
* @package Content Management
* @subpackage faq
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/how_it_works/
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

var g_controller="<?php echo $pathtoclass;?>";//controller Path 
var type        ="<?php echo $type?>";    
$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       $.blockUI({ message: 'Just a moment please...' });
       
       window.location.href=g_controller+((type=='')?"show_list":type+"_show_list");
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
    var $this = $("#opt_language");
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
                      $('<div id="err_msg" class="star_err1">Duplicate exists..Please select different language.</div>')
                      .insertAfter("#opt_language");
                      
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

	
	
	if((text = tinyMCE.get('txt_content1').getContent())=='') 
		{
			s_err +='Please provide basic content .<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_content2').getContent())=='') 
		{
			s_err +='Please provide post job content .<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_content3').getContent())=='') 
		{
			s_err +='Please provide qoute from tradesman .<br />';
			b_valid=false;
		}
	if((text = tinyMCE.get('txt_content4').getContent())=='') 
		{
			s_err +='Please provide hire best tradesman content .<br />';
			b_valid=false;
		}
	/*if((text = tinyMCE.get('txt_content5').getContent())=='') 
		{
			s_err +='Please provide leave feedback content .<br />';
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


//////////////////// AJAX CALL TO GET CONTENT/////////////////////////
    $("#opt_language").change(function(){
        var h_id    =   $("#h_id").val();
        $.ajax({
            type: "POST",
            async: false,
            url: g_controller+'ajax_fetch_contains',
            data: "s_lang_prefix="+$(this).val()+"&h_id="+h_id,
            success: function(ret){
                var ret_obj =   $.parseJSON(ret) ; // parse json using json2.js return object
                             
                tinyMCE.get("txt_content1").setContent(ret_obj.s_content1);               
                tinyMCE.get("txt_content2").setContent(ret_obj.s_content2);               
                tinyMCE.get("txt_content3").setContent(ret_obj.s_content3);               
                tinyMCE.get("txt_content4").setContent(ret_obj.s_content4);               
                //tinyMCE.get("txt_content5").setContent(ret_obj.txt_content5);               
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
      <table width="100%" border="0" cellspacing="0"  cellpadding="0">
        <tr>
          <th align="left" colspan="3"><h4><?php echo $heading;?></h4></th>          
        </tr>  
		
		<tr>
          <td>Language :</td>
          <td>
          <?php if($posted["h_mode"]=="edit")
          {  ?>
          <select name="opt_language" id="opt_language" >
            <?php 
                echo makeOptionLanguagePrefix($posted["opt_language"]) ; 
            ?> 
          </select>
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
			<td valign="top">Basic Content *:</td>
			<td>
			<textarea name="txt_content1" id="txt_content1"  cols="46" rows="4" style="width:550px;">
				<?php echo $posted["txt_content1"]; ?>
			</textarea>
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td valign="top">Search Job Content *:</td>
			<td>
			<textarea name="txt_content2" id="txt_content2"  cols="46" rows="4" style="width:550px;">
				<?php echo $posted["txt_content2"]; ?>
			</textarea>
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td valign="top">Post queries on job *:</td>
			<td>
			<textarea name="txt_content3" id="txt_content3"  cols="46" rows="4" style="width:550px;">
				<?php echo $posted["txt_content3"]; ?>
			</textarea>
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td valign="top">quote on job of your choice *:</td>
			<td>
			<textarea name="txt_content4" id="txt_content4"  cols="46" rows="4" style="width:550px;">
				<?php echo $posted["txt_content4"]; ?>
			</textarea>
			</td>
			<td>&nbsp;</td>
		</tr>
		<?php /*?><tr>
			<td valign="top">Leave Feedback Content *:</td>
			<td>
			<textarea name="txt_content5" id="txt_content5"  cols="46" rows="4" style="width:550px;">
				<?php echo $posted["txt_content5"]; ?>
			</textarea>
			</td>
			<td>&nbsp;</td>
		</tr>	<?php */?>
		
           
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