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
	
/*$("#dt_of_live_coupons").datepicker({
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
							
$("#dt_of_live_coupons").datepicker({
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
	
	$('#i_coupon').click(function() {
			
				$('#cp').css({display:''});
			
		});
		
		$('#i_deal').click(function() {
			//$('#s_summary').parent().next().html("").css({display:'none'});
			$('#cp').css({display:'none'});
			$("#i_coupon_code").val('');
			});
	
	<?php if($mode=='edit' && $posted["i_coupon_code"]!='' && $posted['i_coupon_type']==2) { ?>	
		
		$('#cp').css({display:''});
		//$("#i_coupon_code").val()="";
	
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
	
	if($.trim($("#i_type").val())=="") 
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
	
	if($.trim($("#s_title").val())=="") 
	{
		s_err +='Please provide title.<br />';
		b_valid=false;
	}
	
	if($('#i_coupon').attr('checked'))
	{
		if($.trim($("#i_coupon_code").val())=="") 
		{
			s_err +='Please provide coupon code.<br />';
			b_valid=false;
		}	
	}
	
	/*if($("input[name='i_coupon_type']:radio:checked").val()=="") 
	{
		s_err +='Please select coupon type.<br />';
		b_valid=false;
	}*/
	
	
			

	
	if($("input[name='i_coupon_type']:checked").length <= 0)
	{
		s_err +='Please select coupon type.<br />';
		b_valid=false;
	}
	
	if($.trim($("#dt_of_live_coupons").val())=="") 
	{
		s_err +='Please provide live date of the coupon<br />';
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
	}
	
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
<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo $posted["s_brand_logo"];?>"> 
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
          <td>Offer Type *:</td><?php // pr($posted);?>
          <td><select name="i_type" id="i_type" style="width:280px">
          <option value="" >Select</option>
         <!-- <option value="1"  <?php //if($posted['i_type']==1) echo 'selected="selected"'?>>Coupon</option>
          <option value="2"  <?php //if($posted['i_type']==2) echo 'selected="selected"'?>>Offer</option>
          <option value="3"  <?php //if($posted['i_type']==3) echo 'selected="selected"'?>>Store Offer</option>-->
          <?php echo makeOptionNoEncrypt($offer,$posted['i_type']);?>
          </select></td>
          <td>&nbsp;</td>
        </tr>
                 
		<tr>
          <td>Category*:</td><?php // pr($category); ?>
          <td><select name="i_cat_id" id="i_cat_id" style="width:280px">
          <option value="">Select</option>
		  <?php echo makeOptionNoEncrypt($category,$posted['i_cat_id']);?></select></td>
          <td>&nbsp;</td>
        </tr> 
        <tr>
          <td valign="top">Brand :</td>
<?php /*?> <td><select name="i_brand_id" id="i_brand_id" style="width:280px">
          <option value="">Select</option>
		  <?php echo makeOptionNoEncrypt($brand,$posted['i_brand_id']);?>
          </select></td>
<?php */?> 
		 <td>
          	<div class="brand-cat-listing-main">
            	<div class="check-container">
                	<div class="check-block check-business1">
                    	<?php if($brand) {  
							foreach($brand as $key=>$value)
								{
						?>
                        <label for="brand" class="brand-cat brand-cat-listing">
                    	<input name="chk_brand[]" type="checkbox" value="<?php echo $key; ?>" id="chk_brand_<?php echo $key; ?>" <?php echo (!empty($posted['chk_brand']) && in_array($key,$posted['chk_brand']) ? 'checked="checked"' : '')?>/><?php echo $value ?>
                        </label>
                        
                        <?php } } ?>
                       
                    </div>
                </div>
            </div>
          </td>
          <td>&nbsp;</td>
        </tr> 
        <tr>
          <td>Store*:</td>
          <td><select name="i_store_id" id="i_store_id" style="width:280px">
          <option value="">Select</option>
		  <?php echo makeOptionNoEncrypt($store,$posted['i_store_id']);?></select></td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Title *:</td>
          <td><input id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        
        
        <tr>
          <td>Coupon type *:</td>
          <td>Deal<input id="i_deal" name="i_coupon_type" value="1" type="radio" size="50" <?php if($posted['i_coupon_type']==1) {?> checked="checked" <?php } ?>/>
          Coupon<input id="i_coupon" name="i_coupon_type" value="2" type="radio" size="50" <?php if($posted['i_coupon_type']==2) {?> checked="checked" <?php } ?>/></td>
          <td>&nbsp;</td>
        </tr>
        
        <tr id="cp" style="display:none;">
          <td>Coupon code *:</td>
          <td><input id="i_coupon_code" name="i_coupon_code" type="text" size="50" value="<?php echo my_showtext($posted["i_coupon_code"]); ?>" /></td>
          <td>&nbsp;</td>
        </tr>
        
				<tr>
                    <td>Coupon live date * :</td>
                    <td><input id="dt_of_live_coupons" name="dt_of_live_coupons" class="date" type="text" value="<?php echo my_showtext($posted["dt_of_live_coupons"]); ?>" size="50" autocomplete="off" readonly="yes" /></td>
                    <td>&nbsp;</td>
				</tr>
				
				
				<tr>
                    <td>Expiry date * :</td>
                    <td><input id="dt_exp_date" name="dt_exp_date" class="date"  value="<?php echo my_showtext($posted["dt_exp_date"]); ?>" type="text" size="50" autocomplete="off" readonly="yes" /></td>
                    <td>&nbsp;</td>
				</tr>
        
        
        
        
        
        <?php /*?><tr>
						<td>Coupon live date * :</td>
						<td>
                        <?php
						
						
                        $hr = 23; $min = 59; $sec = 59;
						if($posted["dt_of_live_coupons"])
						{
							$live_date = new DateTime($posted["dt_of_live_coupons"]);
							$live_hr = $live_date->format('H');
							$live_min = $live_date->format('i');
							$live_sec = $live_date->format('s');
							$dt_of_live_coupons = $live_date->format('Y-m-d');
						}
						?>
                        <input id="dt_of_live_coupons" name="dt_of_live_coupons" class="date" type="text" value="<?php echo $dt_of_live_coupons; ?>" size="50" autocomplete="off" readonly="yes" />
                        <?php
						echo '<select name="live_date_hr" style="width:50px;">';
						for($i=0; $i<=$hr; $i++)
						{
							$tmp = strlen($i) > 1? $i : '0'.$i;
							$selected = $live_hr == $i ? 'selected="selected"' : '';
							echo '<option value="'.$tmp.'" '.$selected.'>'.$tmp.'</option>';
						}	
						echo '</select>';
						
						echo '<select name="live_date_min" style="width:50px;">';
						for($i=0; $i<=$min; $i++)
						{
							$tmp = strlen($i) > 1? $i : '0'.$i;
							$selected = $live_min == $i ? 'selected="selected"' : '';
							echo '<option value="'.$tmp.'" '.$selected.'>'.$tmp.'</option>';
						}	
						echo '</select>';
						
						echo '<select name="live_date_sec" style="width:50px;">';
						for($i=0; $i<=$sec; $i++)
						{
							$tmp = strlen($i) > 1? $i : '0'.$i;
							$selected = $live_sec == $i ? 'selected="selected"' : '';
							echo '<option value="'.$tmp.'" '.$selected.'>'.$tmp.'</option>';
						}	
						echo '</select>';
						
						?>
                        
                        </td>
						<td>&nbsp;</td>
				</tr>
				
				
				<tr>
						<td>Expiry date * :</td>
						<td>
                        
                        
                        <?php
						
						if($posted["dt_exp_date"])
						{
							$exp_date = new DateTime($posted["dt_exp_date"]);
							$exp_hr = $exp_date->format('H');
							$exp_min = $exp_date->format('i');
							$exp_sec = $exp_date->format('s');
							$dt_exp_date = $exp_date->format('Y-m-d');
						}
						?>
                        <input id="dt_exp_date" name="dt_exp_date" class="date"  value="<?php echo $dt_exp_date; ?>" type="text" size="50" autocomplete="off" readonly="yes" />
                        <?php
						echo '<select name="exp_date_hr" style="width:50px;">';
						for($i=0; $i<=$hr; $i++)
						{
							$tmp = strlen($i) > 1? $i : '0'.$i;
							$selected = $exp_hr == $i ? 'selected="selected"' : '';
							echo '<option value="'.$tmp.'" '.$selected.'>'.$tmp.'</option>';
						}	
						echo '</select>';
						
						echo '<select name="exp_date_min" style="width:50px;">';
						for($i=0; $i<=$min; $i++)
						{
							$tmp = strlen($i) > 1? $i : '0'.$i;
							$selected = $exp_min == $i ? 'selected="selected"' : '';
							echo '<option value="'.$tmp.'" '.$selected.'>'.$tmp.'</option>';
						}	
						echo '</select>';
						
						echo '<select name="exp_date_sec" style="width:50px;">';
						for($i=0; $i<=$sec; $i++)
						{
							$tmp = strlen($i) > 1? $i : '0'.$i;
							$selected = $exp_sec == $i ? 'selected="selected"' : '';
							echo '<option value="'.$tmp.'" '.$selected.'>'.$tmp.'</option>';
						}	
						echo '</select>';
						
						?>
                        
                        </td>
						<td>&nbsp;</td>
				</tr><?php */?>
         
        <tr>
          <td valign="top">Summary *:</td>
          <td><textarea name="s_summary" id="s_summary" rows="4" cols="46" class="mceEditor"><?php echo $posted['s_summary'];?></textarea></td>
          <td>&nbsp;</td>
        </tr>
        <!--<tr>
          <td>URL *:</td>
          <td><input id="s_url" name="s_url" value="<?php //echo $posted["s_url"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>--> 
        <tr>
          <td>URL *:</td>
          <td><textarea name="s_url" id="s_url" cols="50" rows="4"><?php echo $posted['s_url']?></textarea></td>
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
        
        <tr>
          <td>Meta title:</td>
          <td><input id="s_meta_title" name="s_meta_title" value="<?php echo $posted["s_meta_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td>Meta Description:</td>
          <td><textarea name="s_meta_description" id="s_meta_description" rows="4" cols="46" class="mceEditor"><?php echo $posted['s_meta_description'];?></textarea></td>
          <td>&nbsp;</td>
        </tr> 
        
        <tr>
          <td>Meta Keyword:</td>
          <td><input id="s_meta_keyword" name="s_meta_keyword" value="<?php echo $posted["s_meta_keyword"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        
        
        
        
        <?php if($mode=='edit' && $posted['i_is_expired']==1){?>
        <tr>
          <td>Expired:</td>
          <td> <input type="checkbox" name="i_is_expired"  id="i_is_expired" value="1" <?php if($posted['i_is_expired']==1) echo 'checked="checked"'?>/></td>
          <td>&nbsp;</td>
        </tr>
        
        <?php }?>
        
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