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

    

 $( "#fileUploader" ).dialog({ 

        autoOpen: false,

        height: 480,

        width: 640,

        modal:true,

        resizable: false

    });	

    $( ".refress_btn" ).click();

    $( "#tabs" ).tabs();

   

    $( ".refress_btn" ).button().click(function( event ) {

        event.preventDefault();

          //$('.fileGallery').html('');

        $.post('<?php echo base_url()?>admin_panel/manage_deals/show_uploaded_files',function(returnData){

             $('.fileGallery').html('');

            console.log(returnData);

            $.each(returnData,function(imgKey,imgValue){

                $('.fileGallery').append('<img class="image_files" onclick="choose_image(\''+imgValue+'\')"  src="<?php echo base_url().'uploaded/deal/'?>'+imgValue+'">');

            });

            

        },'json')

    });

   

});    

function choose_image(paramObj){

   // alert(paramObj);

    $('.s_image_pic_preview').attr('src','<?php echo base_url()?>uploaded/deal/'+paramObj);

    $('#s_image_pic').attr('src','<?php echo base_url()?>uploaded/deal/'+paramObj);

    $('#s_image_url').attr('value',paramObj);

    $( "#tabs" ).tabs( "select", 0 );

    

}

</script>  

<style>

    .ui-dialog{

        position: fixed!important;

        font-size: medium;

    }

    #deal_image{

        border-radius: 4px;

        border: #000 groove thin;

        width: 140px;

        height: 140px;

        padding: 5px;

    }

    #deal_image img{

        max-width: 100%;

        max-height: 100%;

    }

    .image_files{

        border-radius: 4px;

        border: #000 groove thin;

        cursor: pointer;

        max-width: 70px;

        padding: 10px;

        margin: 16px;

    }

    #tabs-1{

        max-height: 321px;

        max-width:540px; 

        

    }

    .fileGallery{

        overflow: auto;

        height: 300px;

        overflow-y: scroll;

    }

    .s_image_pic_preview{

        max-height: inherit;

        max-width: inherit;

    }

</style>

<?php

    ///////// End Javascript For add edit //////////

?>

<div id="right_panel">

<form id="frm_add_edit" name="frm_add_edit" method="post" action="" enctype="multipart/form-data">

<input type="hidden" id="h_mode" name="h_mode" value="<?php echo isset($posted["h_mode"])?$posted["h_mode"]:'';?>">

<input type="hidden" id="h_id" name="h_id" value="<?php echo isset($posted["h_id"])?$posted["h_id"]:'';?>">

<input type="hidden" name="coupon_type_exp" value="<?php if(isset($posted["dt_exp_date"]) && (strtotime($posted["dt_exp_date"]) > time()) ) { echo "expiredx"; } ?>">

<input type="hidden" id="h_s_brand_logo" name="h_s_brand_logo" value="<?php echo isset($posted["s_brand_logo"])?$posted["s_brand_logo"]:'';?>"> 

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

         <!-- <option value="1"  <?php //if($posted['i_type']==1) echo 'selected="selected"'?>>Coupon</option>

          <option value="2"  <?php //if($posted['i_type']==2) echo 'selected="selected"'?>>Offer</option>

          <option value="3"  <?php //if($posted['i_type']==3) echo 'selected="selected"'?>>Store Offer</option>-->

          <?php echo makeOptionNoEncrypt($offer,isset($posted['i_type'])?$posted['i_type']:'');?>

          </select></td>

          <td>&nbsp;</td>

        </tr>

        <tr>

          <td>Deal Location :</td><?php // pr($posted);?>

          <td>

              <select name="i_location_id" id="i_location_id" style="width:280px">

                <option value="0" >Any Location</option>

                

                <?php foreach ($location as $value) {?>

                    <option value="<?php echo $value['i_id']?>"  <?php if(@$posted['i_location_id']==$value['i_id']) echo 'selected="selected"'?>><?php echo $value['s_name']?></option>                

                <?php } ?>

          </select>

          </td>

          <td>&nbsp;</td>

        </tr>

                 

		<tr>

          <td>Category:</td><?php // pr($category); ?>

          <td><select name="i_cat_id" id="i_cat_id" style="width:280px">

          <option value="">Select</option>

		  <?php echo makeOptionNoEncrypt($category,$posted['i_cat_id']);?></select></td>

          <td>&nbsp;</td>

        </tr> 
		
		<tr>
          <td>Affiliates :</td>
          <td>
		  <select name="i_affiliates_id" id="i_affiliates_id" style="width:280px">
		  <option value="">Select</option>
		  <?php echo makeOptionAffiliates($posted['i_affiliates_id']);?>
		  </select>
		  </td>
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

                    	<?php if($brand) 
							  {  
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

          <td>Store:</td>

          <td><select name="i_store_id" id="i_store_id" style="width:280px">

          <option value="">Select</option>

		  <?php echo makeOptionNoEncrypt($store,$posted['i_store_id']);?></select></td>

          <td>&nbsp;</td>

        </tr>        

        <tr>
          <td>Title :</td>
          <td><input id="s_title" name="s_title" value="<?php echo isset($posted["s_title"])?$posted["s_title"]:'';?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
            <td>Deal live date  :</td>
            <td><input id="dt_of_live_coupons" name="dt_of_live_coupons" class="date" type="text" value="<?php echo my_showtext(isset($posted["dt_of_live_coupons"])?$posted["dt_of_live_coupons"]:''); ?>" size="50" autocomplete="off" readonly="yes" /></td>
            <td>&nbsp;</td>
    	</tr>
        <tr>
            <td>Expiry date  :</td>
            <td><input id="dt_exp_date" name="dt_exp_date" class="date"  value="<?php echo my_showtext(@$posted["dt_exp_date"]); ?>" type="text" size="50" autocomplete="off" readonly="yes" /></td>

            <td>&nbsp;</td>
		</tr>
        <tr>
          <td valign="top">Summary :</td>
          <td><textarea name="s_summary" id="s_summary" rows="4" cols="46" class="mceEditor"><?php echo @$posted['s_summary'];?></textarea></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Video Code *:</td>
          <td><textarea id="s_video" name="s_video" cols="50" rows="4" /><?php echo @$posted['s_video']?></textarea></td>
          <td>&nbsp;</td>
        </tr> 

        <tr>
          <td>URL :</td>
          <td><textarea name="s_url" id="s_url" cols="50" rows="4"><?php echo @$posted['s_url']?></textarea></td>
          <td>&nbsp;</td>
        </tr>                 

        <tr>
          <td>Status:</td>
          <td><select name="i_is_active" id="i_is_active" style="width:280px">
          <option value="1" <?php if(@$posted['i_is_active']=='1') echo 'selected="selected"'?>>Active</option>
          <option value="0" <?php if(@$posted['i_is_active']=='0') echo 'selected="selected"'?>>Inactive</option>
          </select></td>
          <td>&nbsp;</td>
        </tr>

        

        <tr>

          <td>Meta title:</td>

          <td><input id="s_meta_title" name="s_meta_title" value="<?php echo @$posted["s_meta_title"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>

        

        <tr>

          <td>Meta Description:</td>

          <td><textarea name="s_meta_description" id="s_meta_description" rows="4" cols="46" class=""><?php echo @$posted['s_meta_description'];?></textarea></td>

          <td>&nbsp;</td>

        </tr> 

        

        <tr>

          <td>Meta Keyword:</td>

          <td><input id="s_meta_keyword" name="s_meta_keyword" value="<?php echo @$posted["s_meta_keyword"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>

        

        <tr>

          <td>Selling Price:</td>

          <td><input id="d_selling_price" name="d_selling_price" value="<?php echo @$posted["d_selling_price"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>

        

        <tr>

          <td>Discount Percent:</td>

          <td><input id="d_discount" name="d_discount" value="<?php echo @$posted["d_discount"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>
        
        <tr>
          <td>Discount In Text:</td>
          <td><input id="s_discount_txt" name="s_discount_txt" value="<?php echo @$posted["s_discount_txt"];?>" type="text" size="50" /></td>
          <td>&nbsp;</td>
        </tr>        

        <tr>

          <td>List Price:</td>

          <td><input id="d_list_price" name="d_list_price" value="<?php echo @$posted["d_list_price"];?>" type="text" size="50" /></td>

          <td>&nbsp;</td>

        </tr>

        

        <tr>

          <td>Deal Picture:</td>

          <td>

              <div id="deal_image" style="height:140px;width:140px; ">

                  <?php /*?><img id="s_image_pic" onclickx="$('#fileUploader').dialog('open')" style="cursor: pointer;" src="<?php echo base_url().'uploaded/deal/'.(isset($posted["s_image_url"])?$posted["s_image_url"]:'no-image.png')?>"/><?php */?>
				  <img id="s_image_pic" onclickx="$('#fileUploader').dialog('open')" style="cursor: pointer;" src="<?php echo $posted["s_image_url"]?$posted["s_image_url"]:'no-image.png';?>"/>

              </div>

               &nbsp;<br/>

              <input id="s_image_url" name="s_image_url" value="<?php echo isset($posted["s_image_url"])?$posted["s_image_url"]:'no-image.png';?>" type="text" readonly="readonly" size="50" />

              <input type="file" name="s_image_url">

          </td>

          <td>&nbsp;</td>

        </tr>

        

        <?php if($mode=='edit' && (isset($posted['i_is_expired'])?$posted['i_is_expired']:'')==1){?>

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

<div id="fileUploader" title="Deal Offer Image">

    <div>

        <div id="tabs">

            <ul>

                <li class="current-image"><a href="#tabs-1">Current Image</a></li>

                <li class="choose-from"><a href="#tabs-2">Choose From List</a></li>

                <li class="upload-new"><a href="#tabs-3">Upload A New One</a></li>

            </ul>

            <div id="tabs-1">

                <img class="s_image_pic_preview"  onclick="$('#fileUploader').dialog('open')" style="cursor: pointer" src="<?php echo base_url().'uploaded/deal/'.(isset($posted["s_image_url"])?$posted["s_image_url"]:'no-image.png')?>"/>

            </div>

            <div id="tabs-2">

                <button class="refress_btn" style="cursor: pointer">Refresh List</button>

                <div class="fileGallery">

                    <?php foreach($uploadedFiles as $uploadedFile):?>

                    <img class="image_files" onclick="choose_image('<?php echo $uploadedFile?>')"  src="<?php echo base_url().'uploaded/deal/'.$uploadedFile?>">

                    <?php endforeach;?>

                </div>

            </div>

            <div id="tabs-3">

                <form id="fileupload" action="" method="POST" enctype="multipart/form-data">

                    <!-- Redirect browsers with JavaScript disabled to the origin page -->

                    <noscript><input type="hidden" name="redirect" value="http://blueimp.github.io/jQuery-File-Upload/"></noscript>

                    <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->

                    <div class="fileupload-buttonbar">

                        <div class="fileupload-buttons">

                            <!-- The fileinput-button span is used to style the file input field as button -->

                            <span class="fileinput-button">

                                <span>Add files...</span>

                                <input type="file" name="files[]" multiple>

                            </span>

                            <button type="submit" class="start">Start upload</button>

                            <button type="reset" class="cancel">Cancel upload</button>

                            <button type="button" class="delete">Delete</button>

                            <input type="checkbox" class="toggle">

                            <!-- The loading indicator is shown during file processing -->

                            <span class="fileupload-loading"></span>

                        </div>

                        <!-- The global progress information -->

                        <div class="fileupload-progress fade" style="display:none">

                            <!-- The global progress bar -->

                            <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>

                            <!-- The extended global progress information -->

                            <div class="progress-extended">&nbsp;</div>

                        </div>

                    </div>

                    <!-- The table listing the files available for upload/download -->

                    <table role="presentation"><tbody class="files"></tbody></table>

                </form>



                

            </div>

        </div>

    </div>

</div>    

</div>

