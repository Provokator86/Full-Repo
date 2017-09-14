<?php
/*********
* Author: ACS
* Date  : 04 June 2014
* Modified By: 
* Modified Date:
* Purpose:
* Controller For manage travel category
* @package Travel
* @subpackage Manage Category
* @link InfController.php 
* @link My_Controller.php
* @link model/food_dining_model.php
* @link views/admin/food_dining_store/
*/
?>

<?php    /////////Javascript For add edit ///////// ?>

<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script>
<script language="javascript">

$(document).ready(function(){


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

	

	/*$('#i_coupon').click(function() {	
		$('#cp').css({display:''});			
	
	});
	
	$('#i_deal').click(function() {
		//$('#s_summary').parent().next().html("").css({display:'none'});
		$('#cp').css({display:'none'});
		$("#i_coupon_code").val('');
	});*/


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


///////////Submitting the form/////////

	$("#frm_add_edit").submit(function(){
		var b_valid=true;
		var s_err="";
		var reg_digit = /^[0-9]$/;
		var reg_address   = /^(http:\/\/|https:\/\/|ftp:\/\/|www.){1}([0-9A-Za-z]+\.)/;
		$("#div_err").hide("slow"); 
		var website_add   = $("#s_url").val();
		var PriceReg = /^\d*\.?\d*$/;
		var d_discount   = $("#d_discount").val();	
		var d_list_price   = $("#d_list_price").val();
		var d_selling_price   = $("#d_selling_price").val();
		var d_shipping   = $("#d_shipping").val();
	
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
	
		if($.trim($("#dt_of_live_coupons").val())=="") 
		{
			s_err +='Please provide live date of the coupon<br />';
			b_valid=false;
		}
		if($.trim($("#dt_exp_date").val())=="") 
		{
			s_err +='Please provide Expiry date<br />';
			b_valid=false;
		}*/
		/*if($.trim($("#s_discount_txt").val())=="") 
		{
			s_err +='Please provide offer text<br />';
			b_valid=false;
		}*/
		//if(d_discount!="" && reg_digit.test(d_discount) == false)
		/*if(d_discount!="" && isNaN(d_discount) == true)
		{
			s_err +='Please provide offer percentage in numeric only.<br />';
			b_valid=false;
		}*/
		
		/*if(d_list_price!="" && PriceReg.test(d_list_price)==false)
		{
			s_err +='Please provide list price.<br />';
			b_valid=false;
		}
		if(d_selling_price!="" && PriceReg.test(d_selling_price)==false)
		{
			s_err +='Please provide selling price.<br />';
			b_valid=false;
		}
		if(d_shipping!="" && PriceReg.test(d_shipping)==false)
		{
			s_err +='Please provide shipping charge.<br />';
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
<input type="hidden" name="coupon_type_exp" value="<?php if($posted["dt_exp_date"]<now()) { echo "expired"; } ?>">
<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo $posted["s_brand_logo"];?>"> 
<input type="hidden"  name="i_coupon_type" value="<?php echo $i_coupon_type?>"/>

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
          <td>Offer Type :</td><?php // pr($posted);?>
          <td><select name="i_type" id="i_type" style="width:280px">
          <option value="" >Select</option>
          <?php echo makeOptionNoEncrypt($offer,$posted['i_type']);?>
          </select></td>
          <td>&nbsp;</td>
        </tr> 
		
		<?php /*?><tr>
          <td>Offer Location :</td>
          <td>
              <select name="i_location_id" id="i_location_id" style="width:280px">
                <option value="" >Any Location</option>
                <?php foreach ($location as $value) {?>
                    <option value="<?php echo $value['i_id']?>"  <?php if(@$posted['i_location_id']==$value['i_id']) echo 'selected="selected"'?>><?php echo $value['s_name']?></option>                

                <?php } ?>
          </select>
          </td>
          <td>&nbsp;</td>
        </tr><?php */?>

		<tr>
          <td>Category :</td><?php // pr($category); ?>
          <td>
		  <select name="i_cat_id" id="i_cat_id" style="width:280px">
          <option value="">Select</option>
		  <?php //echo makeOptionNoEncrypt($category,$posted['i_cat_id']);?>
		  <?php echo get_travel_cat_result('', '', '', '1', encrypt($posted["i_cat_id"]),-1);?>
		  </select></td>
          <td>&nbsp;</td>
        </tr> 
		
		<tr>
          <td>Bank Offer :</td><?php // pr($posted);?>
          <td><select name="i_bank_offer" id="i_bank_offer" style="width:280px">
          <option value="" >Select</option>
          <?php echo makeOptionBankOffer($posted['i_bank_offer']);?>
          </select></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr id="cp">
          <td>Offer code :</td>
          <td><input id="i_coupon_code" name="i_coupon_code" type="text" size="50" value="<?php echo my_showtext($posted["i_coupon_code"]); ?>" /></td>
          <td>&nbsp;</td>
        </tr>

        <?php /*?><tr>
          <td valign="top">Brand :</td>
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
        </tr><?php */?> 

        <tr>
          <td>Store :</td>
          <td><select name="i_store_id" id="i_store_id" style="width:280px">
          <option value="">Select</option>
		  <?php echo makeOptionNoEncrypt($store,$posted['i_store_id']);?></select></td>
          <td>&nbsp;</td>
        </tr>

        <tr>
          <td>Title :</td>
          <td><input id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>        

      <?php /*?>  <tr id="cp" style="display:none;">
          <td>Coupon code *:</td>
          <td><input id="i_coupon_code" name="i_coupon_code" type="text" size="50" value="<?php echo my_showtext($posted["i_coupon_code"]); ?>" /></td>
          <td>&nbsp;</td>
        </tr><?php */?>

		<tr>
			<td>Coupon live date  :</td>
			<td>
			<input id="dt_of_live_coupons" name="dt_of_live_coupons" class="date" type="text" value="<?php echo $posted["dt_of_live_coupons"]?my_showtext($posted["dt_of_live_coupons"]):""; ?>" size="50" autocomplete="off" readonly="yes" />
			</td>
			<td>&nbsp;</td>
		</tr>
				

		<tr>
			<td>Expiry date  :</td>
			<td><input id="dt_exp_date" name="dt_exp_date" class="date"  value="<?php echo $posted["dt_exp_date"]?my_showtext($posted["dt_exp_date"]):""; ?>" type="text" size="50" autocomplete="off" readonly="yes" /></td>
			<td>&nbsp;</td>
		</tr>    
		
		<tr>
			<td>List Price  :</td>
			<td><input id="d_list_price" name="d_list_price" class="date"  value="<?php echo $posted["d_list_price"]?my_showtext($posted["d_list_price"]):""; ?>" type="text" size="50" /></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>Selling Price  :</td>
			<td><input id="d_selling_price" name="d_selling_price" class="date"  value="<?php echo $posted["d_selling_price"]?my_showtext($posted["d_selling_price"]):""; ?>" type="text" size="50" /></td>
			<td>&nbsp;</td>
		</tr>
		
		<?php /*?><tr>
			<td>Shipping Charge  :</td>
			<td><input id="d_shipping" name="d_shipping" value="<?php echo my_showtext($posted["d_shipping"]); ?>" type="text" size="50" /></td>
			<td>&nbsp;</td>
		</tr><?php */?>
		
		<tr>
			<td>Offer Text  :</td>
			<td><input id="s_discount_txt" name="s_discount_txt" value="<?php echo my_showtext($posted["s_discount_txt"]); ?>" type="text" size="50" /></td>
			<td>&nbsp;</td>
		</tr>  
		
		<tr>
			<td>Discount  :</td>
			<td><input id="d_discount" name="d_discount" value="<?php echo my_showtext($posted["d_discount"]); ?>" type="text" size="50" /><br />[Give only percentage value like 20, 40 etc.]</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td>Cashback Offer  :</td>
			<td><input id="i_cashback" name="i_cashback" value="<?php echo my_showtext($posted["i_cashback"]); ?>" type="text" size="50" /><?php /*?><br />[Give only percentage value like 2,4, 10 etc.]<?php */?></td>
			<td>&nbsp;</td>
		</tr> 
		
		
		
		<?php /*?><tr>
			<td>Offer Percentage  :</td>
			<td><input id="d_discount" name="d_discount" class="date"  value="<?php echo $posted["d_discount"]?my_showtext($posted["d_discount"]):""; ?>" type="text" size="50" /></td>
			<td>&nbsp;</td>
		</tr><?php */?>      

        <tr>
          <td valign="top">Summary :</td>
          <td><textarea name="s_summary" id="s_summary" rows="4" cols="46" class="mceEditor"><?php echo $posted['s_summary'];?></textarea></td>
          <td>&nbsp;</td>
        </tr>
		
		<tr>
          <td valign="top">How to get this deal :</td>
          <td><textarea name="s_terms" id="s_terms" rows="4" cols="46" class="mceEditor"><?php echo $posted['s_terms'];?></textarea></td>
          <td>&nbsp;</td>
        </tr>


        <tr>
          <td>URL :</td>
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

       <?php /*?> <tr>
          <td>Meta title:</td>
          <td>
		  <input id="s_meta_title" name="s_meta_title" value="<?php echo $posted["s_meta_title"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>


        <tr>
          <td>Meta Description:</td>
          <td><textarea name="s_meta_description" id="s_meta_description" rows="4" cols="46" class=""><?php echo $posted['s_meta_description'];?></textarea></td>
          <td>&nbsp;</td>
        </tr>         

        <tr>
          <td>Meta Keyword:</td>
          <td><input id="s_meta_keyword" name="s_meta_keyword" value="<?php echo $posted["s_meta_keyword"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>   <?php */?> 
		
		<tr>
          <td>Picture:</td>
          <td>
              <div id="deal_image" style="height:140px;width:140px; ">
                  <img width='140' height='140' id="s_image_pic" style=" cursor: pointer;" src="<?php echo base_url().'uploaded/deal/'.($posted["s_image_url"]?$posted["s_image_url"]:'no-image.png')?>"/>
              </div>
               &nbsp;<br/>
              <input id="s_image_url" name="s_image_url" value="<?php echo isset($posted["s_image_url"])?$posted["s_image_url"]:'no-image.png';?>" type="text" readonly="readonly" size="50" />
              <input type="file" name="s_image_url">
          </td>
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