<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 17 Mar 2014
* Modified By: 
* Modified Date:
* Purpose:
*  controller For OMGP Product Manage
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_product.php
* @link views/admin/manage_product/
*/
?>
<?php
    /////////Javascript For add edit //////////
?>

<!--<script type="text/javascript" src="js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce_load_specific.js"></script>-->

<script language="javascript">

$(document).ready(function(){
	var g_controller="<?php echo $pathtoclass;?>";//controller Path 
	
	
	$("#i_store_id").change(function(){
		var StoreId = $(this).val();
		if(parseInt(StoreId)>0)
		{
			$.ajax({
					url:g_controller+"ajax_fetch_store_detail",
					data:"StoreId="+StoreId,
					type:'post',
					dataType:'json',
					success:function(data){
						//console.log(data);
						$("#h_import_type").val(data.import_type);
						$("#file_path").val('');
					}
			
			});
		}
	});
		
	
	$('input[id^="btn_cancel"]').each(function(i){
	   $(this).click(function(){
		   //$.blockUI({ message: 'Just a moment please...' });
		   //window.location.href=g_controller+"show_list";
		   window.location.href=g_controller+"add_information";
	   }); 
	});      
	
		
	
	$('input[id^="btn_save"]').each(function(i){
	   $(this).click(function(){
		   //$.blockUI({ message: 'Just a moment please...' });
		  $("#frm_add_edit").submit();
	   }); 
	
	});    
	
	   
	
	///////////Submitting the form/////////
	
	$("#frm_add_edit").submit(function(){
	
		var b_valid=true;
		var s_err="";
		$("#div_err").hide("slow");  
		
		if($("#i_store_id").val()=="") 
		{
			s_err +='Please select store.<br />';
			b_valid=false;
		}		
		if($.trim($("#file_path").val())=="") 
		{
			s_err +='Please provide full file path.<br />';
			b_valid=false;
		}
		/////////validating//////
		if(!b_valid)
		{
			//$.unblockUI();  
			$("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
		}
		return b_valid;
	
	});    
	
	///////////end Submitting the form///////// 
	
	
	
	$('input[id^="btn_add_cat"]').each(function(i){
	   $(this).click(function(){
		   //$.blockUI({ message: 'Just a moment please...' });
		  $("#frm_add_cat").submit();
	   }); 
	
	}); 
	
	///////////Submitting the form/////////
	
	$("#frm_add_cat").submit(function(){
	
		var b_valid=true;
		var s_err="";
		$("#div_err").hide("slow");  
		
		
		<?php /*?>if($.trim($("#s_url").val())=="") 
		{
			s_err +='Please provide url.<br />';
			b_valid=false;
		}<?php */?>
		/////////validating//////
		if(!b_valid)
		{
			//$.unblockUI();  
			$("#div_err_cat").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
		}
		return b_valid;
	
	});    
	
	///////////end Submitting the form///////// 
	
	$("#btn_proceed").click(function(){
		var catId = $("#i_parent_id").val();
		var storeId = $("#h_store_id").val();
		var catStr = $("#h_category_string").val();
		if(catId!="")
		{
			var t =$("#frm_add_edit");
			$.ajax({
					url:g_controller+"ajax_category_store_map",
					data:"catId="+catId+"&catStr="+escape(catStr)+"&storeId="+storeId,
					context: t,//document.body,
					type:'post',
					dataType:'json',
					success:function(data){
						if(data.msg=="valid")////invalid 
						 {
							t.submit();  
						 }
					}
			
			});
		}
		else
		{
			alert('Select a category under which you want to keep this product');
		}
	});
	
	$("#btn_skip").click(function(){
		var storeId = $("#h_store_id").val();
		var catStr = $("#h_category_string").val();
		if(catStr!="" && storeId!='')
		{
			var t =$("#frm_add_edit");
			$.ajax({
					url:g_controller+"ajax_category_store_skip",
					data:"catStr="+escape(catStr)+"&storeId="+storeId,
					context: t,//document.body,
					type:'post',
					dataType:'json',
					success:function(data){
						if(data.msg=="valid")////invalid 
						 {
							t.submit();  
						 }
					}
			
			});
		}
		else
		{
			alert('You can not skip this category.');
		}
	});
	
});    

</script>    

<?php

    ///////// End Javascript For add edit //////////

?>

<div id="right_panel">

<?php if($this->session->userdata('h_import_type')!='' ){
					$posted['h_import_type'] = $this->session->userdata('h_import_type');
			}
?>

<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">
<input type="hidden" id="h_mode" name="h_mode" value="<?php echo $posted["h_mode"];?>">
<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
<input type="hidden"  name="i_coupon_type" value="<?php echo $i_coupon_type?>"/>
<input type="hidden"  name="h_import_type" id="h_import_type" value="<?php echo $posted["h_import_type"]?$posted["h_import_type"]:"csv";?>"/>
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
		<?php if($this->session->userdata('sess_store_id')!='' ){
					$i_store_id = $this->session->userdata('sess_store_id');
					$posted['file_path'] = $this->session->userdata('sess_file_path');
			}
		 ?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="30%" align="left"><h4><?php echo $heading;?></h4></th>
          <th width="60%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
        </tr>
		
		<tr>
          <td valign="top">Store *:</td>
          <td>
		  <select name="i_store_id" id="i_store_id" style="width:180px;">
		  	<option value="">Select</option>
			<?php echo makeOptionNoEncrypt($store,$i_store_id);?>
		  </select>
		  </td>
          <td>&nbsp;</td>
        </tr> 
		
		<tr id="csv_file_tr">
          <td valign="top">Full Path *:</td>
          <td>
		  		<textarea name="file_path" id="file_path" rows="4" cols="40" ><?php echo $posted['file_path'] ?></textarea>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		

      </table>

      </div>

    <? /***** end Modify Section *******/?>     

    </div>
    <div class="left">
    <input id="btn_save" name="btn_save" type="button" value="Crawl" title="Click here to save information." /> 
    <input id="btn_cancel" name="btn_cancel" type="button" value="Cancel" title="Click here to cancel saving information and return to previous page."/>
    </div>
</form>

<?php if($this->session->userdata('category_not_found')!='') { ?>
<form id="frm_add_cat" name="frm_add_cat" method="post" action="<?php echo base_url().'admin_panel/manage_product/add_new_category' ?>" enctype="multipart/form-data">
<input type="hidden" id="h_category_string" name="h_category_string" value="<?php echo $this->session->userdata('category_not_found');?>">
<input type="hidden"  name="h_store_id" id="h_store_id" value="<?php echo $this->session->userdata('sess_store_id');?>"/>
<?php /*?><h2><?php echo $heading;?></h2><?php */?>
    <p>&nbsp;</p>
        <div id="div_err_cat">
            <?php
              show_msg("error"); 
              echo validation_errors();
			  //pr($posted);
            ?>
        </div>  

    <?php //pr($posted);?>

    <div class="left"></div>
    <div class="add_edit">
    <? /*****Modify Section Starts*******/?>
    <div>
	<h4><?php echo $this->session->userdata('category_not_found'); ?> </h3>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <th width="23%" align="left"><h4><?php echo 'Category Add'?> </h4><br/> ( If you does not select any root category then it will be treated as root category)</th>
          <th width="67%" align="left">&nbsp;</th>
          <th width="10%">&nbsp;</th>
        </tr>
		
		<tr id="file_stop" >
          <td valign="top">Root Category :</td>
          <td>
		 	<select id="i_parent_id" name="i_parent_id" style="max-width:260px;">
				<option value="">All Categories</option>
				<?php echo get_cat_result('', '', '', '1', encrypt($posted["i_parent_id"]));?>
			</select>
			
			&nbsp;<input id="btn_proceed" name="btn_proceed" type="button" value="Proceed to crawl under this category" title="Click " />	&nbsp;<input id="btn_skip" name="btn_skip" type="button" value="Skip this category" title="Click " />
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		<tr id="file_stop" >
          <td valign="top">Category Name :</td>
          <td>
		 	<input type="text" name="s_category" id="s_category" value="<?php echo $posted["s_category"] ?>" style="width:200px;"/>
		  </td>
          <td>&nbsp;</td>
        </tr>
		
		
	
      </table>

      </div>

    <? /***** end Modify Section *******/?>     

    </div>
    <div class="left">
    <input id="btn_add_cat" name="btn_add_cat" type="button" value="Save" title="Click here to save information." /> 
    </div>
</form>

<?php } ?>

</div>