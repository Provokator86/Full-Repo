<?php
$this->load->view('site/templates/header');
?>
<style type="text/css" media="screen">


#edit-details {
    color: #FF3333;
    font-size: 11px;
}
.option-area select.option {
    border: 1px solid #D1D3D9;
    border-radius: 3px 3px 3px 3px;
    box-shadow: 1px 1px 1px #EEEEEE;
    height: 22px;
    margin: 5px 0 12px;
}
a.selectBox.option {
    margin: 5px 0 10px;
    padding: 3px 0;
}
a.selectBox.option .selectBox-label {
    font: inherit !important;
    padding-left: 10px;

}
form label.error{
	color:red;
}
.button{
	width: 95px;
	overflow: visible;
	margin: 0;
	padding: 8px 8px 10px 7px;
	border: 0;
	border-radius: 4px;
	font-weight: bold;
	font-size: 15px;
	line-height: 22px;
	text-align: center;
	color: #fff;
	background: #588cc7;
}
.button:hover{
	background: #3e73b7;
}
</style>
 <!-- Section_start -->
  <div id="container-wrapper">
	<div class="container ">
		 <div class="main_box">
	<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
            <div class="profile-list">            
                
                <div class="page-header padding_all15 margin_all0">
                            <h2> <?php if($this->lang->line('product_edit') != '') { echo stripslashes($this->lang->line('product_edit')); } else echo "Edit Product"; ?></h2>
             	
 <h2 style="text-align:left;" class="padding_bottom15">	</h2>		 
            </div>
                <div class="box-content">
                
                <div class="main2">
                    <form accept-charset="utf-8" method="post" action="site/product/sell_it/1" id="sellerProdEdit1">
                        <div class="person-lists bs-docs-example">
                            <ul class="tabs1" id="myTab">
                                    <li class="active"><a data-toggle="tab" <?php if ($editmode != '0'){?>href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit"<?php }?>><?php if($this->lang->line('product_details') != '') { echo stripslashes($this->lang->line('product_details')); } else echo "Details"; ?></a></li>
                                    <li class=""><a data-toggle="tab" <?php if ($editmode == '0'){?>onclick="return saveDetails('categories')"<?php }else {?> href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit/categories"<?php }?>><?php if($this->lang->line('product_categories') != '') { echo stripslashes($this->lang->line('product_categories')); } else echo "Categories"; ?></a></li>
                                    <li><a data-toggle="tab" <?php if ($editmode == '0'){?>onclick="return saveDetails('list')"<?php }else {?> href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit/list"<?php }?>><?php if($this->lang->line('display_lists') != '') { echo stripslashes($this->lang->line('display_lists')); } else echo "List"; ?></a></li>
                                    <li><a data-toggle="tab" <?php if ($editmode == '0'){?>onclick="return saveDetails('images')"<?php }else {?> href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit/images"<?php }?>><?php if($this->lang->line('product_images') != '') { echo stripslashes($this->lang->line('product_images')); } else echo "Images"; ?></a></li>
                                    <li><a data-toggle="tab" <?php if ($editmode == '0'){?>onclick="return saveDetails('attribute')"<?php }else {?> href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit/attribute"<?php }?>><?php if($this->lang->line('header_attr') != '') { echo stripslashes($this->lang->line('header_attr')); } else echo "Attribute"; ?></a></li>
                                    <li><a data-toggle="tab" <?php if ($editmode == '0'){?>onclick="return saveDetails('seo')"<?php }else {?> href="things/<?php echo $productDetails->row()->seller_product_id;?>/edit/seo"<?php }?>><?php if($this->lang->line('product_seo') != '') { echo stripslashes($this->lang->line('product_seo')); } else echo "SEO"; ?></a></li>
                                </ul>
                                <script>
                                function saveDetails(mode){
                                    $('#nextMode').val(mode);
									$('#editDetailsSub').trigger('click');
                                }
                                </script>
                                <input type="hidden" name="nextMode" id="nextMode" value=""/>
                            <div class="tab-content border_right width_100 pull-left" id="myTabContent"> 
                                <div id="product_info" class="tab-pane active">
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('header_name') != '') { echo stripslashes($this->lang->line('header_name')); } else echo "Name"; ?><span style="color:red;"> *</span></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input required" placeholder="<?php if($this->lang->line('header_name') != '') { echo stripslashes($this->lang->line('header_name')); } else echo "Name"; ?>" value="<?php echo $productDetails->row()->product_name;?>" name="product_name">                                        </div>
                                    </div>
                                    <div class="form_fields">
                                            <label><?php if($this->lang->line('header_description') != '') { echo stripslashes($this->lang->line('header_description')); } else echo "Description"; ?><span style="color:red;"> *</span></label>
                                            <div style="height:128px;" class="form_fieldsgroup validation-input">
                                            <textarea class="global-input required" placeholder="<?php if($this->lang->line('header_description') != '') { echo stripslashes($this->lang->line('header_description')); } else echo "Description"; ?>" id="description" rows="10" cols="40" name="description"><?php if ($productDetails->row()->description == ''){echo $productDetails->row()->excerpt;}else {echo $productDetails->row()->description;}?></textarea>                                            </div>
                                        </div>
										
                                    <div class="form_fields">
                                            <label><?php if($this->lang->line('product_excerpt') != '') { echo stripslashes($this->lang->line('product_excerpt')); } else echo "Excerpt"; ?></label>
                                            <div class="form_fieldsgroup">
                                            <textarea class="global-input" placeholder="<?php if($this->lang->line('product_excerpt') != '') { echo stripslashes($this->lang->line('product_excerpt')); } else echo "Excerpt"; ?>" rows="5" cols="40" name="excerpt"><?php echo $productDetails->row()->excerpt;?></textarea>                                            </div>
                                        </div>
										
                                    <div class="form_fields">
                                            <label><?php if($this->lang->line('shipping_policies') != '') { echo stripslashes($this->lang->line('shipping_policies')); } else echo "Shipping & Policies"; ?></label>
                                            <div class="form_fieldsgroup">
                                            <textarea class="global-input" placeholder="<?php if($this->lang->line('shipping_policies') != '') { echo stripslashes($this->lang->line('shipping_policies')); } else echo "Shipping & Policies"; ?>" rows="5" cols="40" name="shipping_policies"><?php echo $productDetails->row()->shipping_policies;?></textarea>                                            </div>
                                        </div>
										
                                    <div class="form_fields">
                                            <label><?php if($this->lang->line('xchange_policy') != '') { echo stripslashes($this->lang->line('xchange_policy')); } else echo "Exchange Policy"; ?></label>
                                            <div class="form_fieldsgroup">
                                            <textarea class="global-input" placeholder="<?php if($this->lang->line('xchange_policy') != '') { echo stripslashes($this->lang->line('xchange_policy')); } else echo "Exchange Policy"; ?>" rows="5" cols="40" name="xchange_policy"><?php echo $productDetails->row()->xchange_policy;?></textarea>                                            </div>
                                        </div>
                                    
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('product_quantity') != '') { echo stripslashes($this->lang->line('product_quantity')); } else echo "Quantity"; ?><span style="color:red;"> *</span></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input required number" placeholder="<?php if($this->lang->line('product_quantity') != '') { echo stripslashes($this->lang->line('product_quantity')); } else echo "Quantity"; ?>" value="<?php if ($editmode == '1'){echo $productDetails->row()->quantity;}?>" name="quantity">                                        </div>
                                    </div>
<!-- 									 <div class="form_fields">
                                        <label><?php if($this->lang->line('product_ship_imd') != '') { echo stripslashes($this->lang->line('product_ship_imd')); } else echo "Shipping Immediately"; ?></label>
                                        <div class="form_fieldsgroup validation-input">
                                        	<input type="radio" name="ship_immediate" <?php if ($editmode == '1'){if($productDetails->row()->ship_immediate == 'true'){echo 'checked="checked"';}}?> value="true"/><?php if($this->lang->line('prference_yes') != '') { echo stripslashes($this->lang->line('prference_yes')); } else echo "Yes"; ?>&nbsp;&nbsp;&nbsp;
                                        	<input type="radio" name="ship_immediate" <?php if ($editmode == '1'){if($productDetails->row()->ship_immediate == 'false'){echo 'checked="checked"';}}else{echo 'checked="checked"';}?> value="false"/><?php if($this->lang->line('prference_no') != '') { echo stripslashes($this->lang->line('prference_no')); } else echo "No"; ?>&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </div>
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('product_ship_cost') != '') { echo stripslashes($this->lang->line('product_ship_cost')); } else echo "Shipping Cost"; ?></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input " placeholder="<?php if($this->lang->line('product_ship_cost') != '') { echo stripslashes($this->lang->line('product_ship_cost')); } else echo "Shipping Cost"; ?>" value="<?php if ($editmode == '1'){echo $productDetails->row()->shipping_cost;}?>" name="shipping_cost">                                        </div>
                                    </div>
                                    
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('checkout_tax') != '') { echo stripslashes($this->lang->line('checkout_tax')); } else echo "Tax"; ?></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input " placeholder="<?php if($this->lang->line('checkout_tax') != '') { echo stripslashes($this->lang->line('checkout_tax')); } else echo "Tax"; ?>" value="<?php if ($editmode == '1'){echo $productDetails->row()->tax_cost;}?>" name="tax_cost">                                        </div>
                                    </div>
                                    
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('product_sku') != '') { echo stripslashes($this->lang->line('product_sku')); } else echo "SKU"; ?></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input " placeholder="<?php if($this->lang->line('product_sku') != '') { echo stripslashes($this->lang->line('product_sku')); } else echo "SKU"; ?>" value="<?php if ($editmode == '1'){echo $productDetails->row()->sku;}?>" name="sku">                                        </div>
                                    </div>
                                    
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('product_weight') != '') { echo stripslashes($this->lang->line('product_weight')); } else echo "Weight"; ?></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input " placeholder="<?php if($this->lang->line('product_weight') != '') { echo stripslashes($this->lang->line('product_weight')); } else echo "Weight"; ?>" value="<?php if ($editmode == '1'){echo $productDetails->row()->weight;}?>" name="weight">                                        </div>
                                    </div>
 -->                                    
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('giftcard_price') != '') { echo stripslashes($this->lang->line('giftcard_price')); } else echo "Price"; ?><span style="color:red;"> *</span></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input required number" placeholder="<?php if($this->lang->line('giftcard_price') != '') { echo stripslashes($this->lang->line('giftcard_price')); } else echo "Price"; ?>" value="<?php echo $productDetails->row()->price;?>" name="price">                                        </div>
                                    </div>
                                    
                                    <div class="form_fields">
                                        <label><?php if($this->lang->line('product_sale_price') != '') { echo stripslashes($this->lang->line('product_sale_price')); } else echo "Sale Price"; ?><span style="color:red;"> *</span></label>
                                        <div class="form_fieldsgroup validation-input">
                                            <input type="text" class="global-input required number" placeholder="<?php if($this->lang->line('product_sale_price') != '') { echo stripslashes($this->lang->line('product_sale_price')); } else echo "Sale Price"; ?>" value="<?php if ($editmode == '1'){echo $productDetails->row()->sale_price;}else {echo $productDetails->row()->price;}?>" name="sale_price">                                        </div>
                                    </div>
                                    <input type="hidden" name="PID" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
                                    <div class="form_fields">
                                            <label></label>
                                            <div class="form_fieldsgroup">
                                            <input type="submit" id="editDetailsSub" value="<?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?>" class="button"/>
                                                                                  </div>
                                        </div>
                                    
                                                                        
                                </div>
                                
                                
                            </div>
                        </div>
                        
                    </form>
                    
                    </div>
                </div>
            </div>
        		
    
</div>
</div>
<h2 style="text-align:left;" class="padding_bottom15">	</h2>	
</div>
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script>
	$("#sellerProdEdit1").validate();
</script>
<?php
$this->load->view('site/templates/footer');
?>