<?php
/*********
* Author:Mrinmoy Mondal
* Date  : 19 Jan 2013
* Modified By: 
* Modified Date:
* Purpose:
*  View For book category Add & Edit
* @package General
* @subpackage book category
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/book_category/
*/
?>
<?php
    /////////Javascript For add edit //////////
?>
<script language="javascript">

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
	   //check_duplicate();
   }); 
});    
    
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
	var reg_address   = /^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)/;
	var website_add   = $("#s_url").val();
    $("#div_err").hide("slow"); 
	<?php if($mode=='add') {?>
    if($.trim($("#page_reference").val())=="") 
	{
		s_err +='Please select page name.<br />';
		b_valid=false;
	}
	<?php }?>
	if($.trim($("#s_title").val())=="") 
	{
		s_err +='Please provide banner title.<br />';
		b_valid=false;
	}
	if($.trim($("#s_url").val())=="") 
	{
		s_err +='Please provide url.<br />';
		b_valid=false;
	}
	if(website_add!="" && reg_address.test(website_add) == false)
	{
		s_err +='Please provide proper url.<br />';
		b_valid=false;
	}
	
	if($.trim($("#s_description").val())=="") 
	{
		s_err +='Please provide Description.<br />';
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
    
});    
</script>    
<?php
    ///////// End Javascript For add edit //////////
?>
<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<!--<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">-->
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo $posted["s_image"];?>"> 
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg();  
              echo validation_errors();
			/*  pr($posted);*/
            ?>
        </div>     
    
    <?php //pr($posted);?>
    <div class="left"><!--<input id="btn_save" name="btn_save" type="button" value="Save" title="Click here to save information." /> <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>--></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <?php // pr($posted);echo $mode;?>
    <div>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
          
        </tr>     
        
        <tr>
            
				<?php 
                if($mode==add)
                {
				?>
                <td>Page Name *:</td>
           		 <td>
					<select id="page_reference" name="page_reference">
					<option value="">Select</option>
					<?php  echo makeOptionPageType('', $posted["page_reference"])?>
					</select>
                  </td>
				<?php
                }
                else
                {
					?>
                <td>Page Name :</td>
           		 <td>
                 <?php
                	echo $posted['s_page_name'][0]['page_reference'];
                }
                ?>
            </td>
            <td>&nbsp;</td>
        </tr>
           
		<tr>
          <td>Banner Title *:</td>
          <td><input id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr> 
        <tr>
          <td>Banner Logo *:</td>
          <td><input id="s_image" name="s_image" value="<?php echo $posted["s_image"];?>" type="file" size="50" /> (Maximum width and height should be 300px*249px)</td>
       
          
        </tr> 
        <?php if($mode=='edit') { ?><tr><td></td><td><img src="<?php echo base_url().'uploaded/banner/thumb/thumb_'.$posted['s_image'];?>" /></td></tr><?php }?>
        <!--<tr>
          <td>Affiliation Marketing URL *:</td>
          <td><input id="s_brand_url" name="s_brand_url" value="<?php //echo $posted["s_brand_url"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>-->          
        <tr>
          <td>Banner Description *:</td>
          <td><textarea name="s_description" id="s_description" rows="4" cols="49"><?php echo $posted['s_description'];?></textarea></td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Banner URL *:</td>
          <td><!--<input id="s_url" name="s_url" value="<?php //echo $posted["s_url"];?>" type="text" size="50" />-->
          <textarea id="s_url" name="s_url" rows="4" cols="50"><?php echo $posted["s_url"];?></textarea>
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