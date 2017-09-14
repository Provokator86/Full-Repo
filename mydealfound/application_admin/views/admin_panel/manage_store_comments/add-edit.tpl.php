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
<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script>
<script language="javascript">

$(document).ready(function(){
	
/*$("#dt_of_live_stores").datepicker({
							minDate:0,
							dateFormat: "yy-mm-dd",
							changeYear: true,
							changeMonth:true,
							onSelect: function (dateText, inst) 
							{
								$('#dt_exp_date').datepicker("option", 'minDate', new Date(dateText));
							}
									});
									
$("#dt_exp_date").datepicker({
								minDate:0,
								dateFormat: "yy-mm-dd"
		
		
							});*/
							
$("#dt_of_live_stores").datepicker({
			minDate:0,
			dateFormat: "yy-mm-dd",
			changeYear: true,
			changeMonth:true,
			onSelect: function (dateText, inst) {
			$('#dt_exp_date').datepicker("option", 'minDate', new Date(dateText));
												}
		});
$("#dt_exp_date").datepicker({
								minDate:0,
								changeYear: true,
								changeMonth:true,
								dateFormat: "yy-mm-dd"
									});
	
	$('#i_store').click(function() {
			
				$('#cp').css({display:''});
			
		});
		
		$('#i_deal').click(function() {
			//$('#s_summary').parent().next().html("").css({display:'none'});
			$('#cp').css({display:'none'});
			$("#i_store_code").val('');
			});
	
	<?php if($mode=='edit' && $posted["i_store_code"]!='' && $posted['i_store_type']==2) { ?>	
		
		$('#cp').css({display:''});
		//$("#i_store_code").val()="";
	
	<?php } ?>	
	
	
	

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
    
//////////Checking Duplicate/////////
/*function check_duplicate(){
    var $this = $("#s_category");
    $this.next().remove("#err_msg");  
	$(".star_err1").remove();
	$(".star_succ1").remove();
	
    if($this.val()!="")
    {
        $.blockUI({ message: 'Checking duplicates.Just a moment please...' });
        $.post(g_controller+"ajax_checkduplicate",
               {"h_id":$("#h_id").val(),
                "h_duplicate_value":$this.val(),
                },
                function(data)
                {
                  if(data!="valid")////invalid 
                  {
                      $this.focus();
                      $('<div id="err_msg" class="star_err1">Duplicate exists.</div>')
                      .insertAfter("#s_category");
                      
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
  */  
    
///////////Submitting the form/////////
$("#frm_add_edit").submit(function(){
    var b_valid=true;
    var s_err="";
	var reg_address   = /^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)/;
    $("#div_err").hide("slow"); 
    var website_add   = $("#s_url").val();
	
	/*if($.trim($("#i_type").val())=="") 
	{
		s_err +='Please provide Offer type.<br />';
		b_valid=false;
	}
	
	if($("#i_cat_id").val()=="") 
	{
		s_err +='Please select category.<br />';
		b_valid=false;
	}
	
	if($("#i_store_id").val()=="") 
	{
		s_err +='Please select store.<br />';
		b_valid=false;
	}
	
	if($.trim($("#s_store_title").val())=="") 
	{
		s_err +='Please provide title.<br />';
		b_valid=false;
	}
	
	if($('#i_store').attr('checked'))
	{
		if($.trim($("#i_store_code").val())=="") 
		{
			s_err +='Please provide store code.<br />';
			b_valid=false;
		}	
	}*/
	
	/*if($("input[name='i_store_type']:radio:checked").val()=="") 
	{
		s_err +='Please select store type.<br />';
		b_valid=false;
	}*/
	
	
			
/*
	
	if($("input[name='i_store_type']:checked").length <= 0)
	{
		s_err +='Please select store type.<br />';
		b_valid=false;
	}
	
	if($.trim($("#dt_of_live_stores").val())=="") 
	{
		s_err +='Please provide live date of the store<br />';
		b_valid=false;
	}
	
	if($.trim($("#dt_exp_date").val())=="") 
	{
		s_err +='Please provide Expiry date<br />';
		b_valid=false;
	}
	
	var s_summary = tinyMCE.get('s_summary').getContent();
	if(s_summary == "")
	{
		s_err +='Please provide summary.<br />';
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
	}*/
	
	/*---------------------*/
	
	
	/*if($("input[name='chk_brand[]']:checked").length <= 0)
	{
		s_err +='Please select brand.<br />';
		b_valid=false;
	}*/
	/*---------------------*/
	/*if($.trim($("#i_is_active").val())=="") 
	{
		s_err +='Please select status.<br />';
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
    
	
});    
</script>    
<?php
    ///////// End Javascript For add edit //////////
?>
<div id="right_panel">
<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
<input type="hidden" name="store_type_exp" value="<?php if($posted["dt_exp_date"]<now()) { echo "expired"; } ?>">
<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo $posted["s_brand_logo"];?>"> 
<input id="i_store_id" name="i_store_id" value="<?php echo $posted["i_store_id"];?>" type="hidden" size="50" />
    <h2><?php echo $heading;?></h2>
    <p>&nbsp;</p>
        <div id="div_err">
            <?php
              show_msg("error");  
              echo validation_errors();
			// pr($posted);
            ?>
        </div>     
    
    <?php //pr($posted);?>
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
          <td>Store Name:</td>
          <td><?php echo $posted['store_name'];?></td>
          <td>&nbsp;</td>
        </tr>
                 
		<tr>
          <?php /*<td>commented by:</td><?php // pr($category); ?>
          <td><input id="s_commented_by" name="s_commented_by" value="<?php echo $posted["s_commented_by"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
           * 
           */?>
        </tr>
		
		<tr>
          <td>Email:</td><?php // pr($category); ?>
          <td><input id="s_commented_by_email" name="s_commented_by_email" value="<?php echo $posted["s_commented_by_email"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr> 
         
        <tr>
          <td>Comment:</td>
          <td><textarea name="s_comments" id="s_comments" cols="50" rows="4"><?php echo $posted["s_comments"];?></textarea></td>
          <td>&nbsp;</td>
        </tr>
		
		
		
        
				
		<tr>
          <td>Status:</td>
          <td><select name="i_is_active" id="i_is_active" style="width:280px">
          <option value="1" <?php if($posted['i_is_active']=='1') echo 'selected="selected"'?>>Active</option>
          <option value="0" <?php if($posted['i_is_active']=='0') echo 'selected="selected"'?>>Inactive</option>
          
          
          </select></td>
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