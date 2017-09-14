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
.add-2 form label.error{
	color:red;
}

</style>



 <!-- Section_start -->
<div id="container-wrapper">
<div class="main2">
 <div class="main_box">
	<div class="container ">
		<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
		<div id="content" style="float:left; width:100%;">
			<section class="add-2">
				<h1>Edit details</h1>
<?php 
		$img = 'dummyProductImage.jpg';
		$imgArr = explode(',', $productDetails->row()->image);
		if (count($imgArr)>0){
			foreach ($imgArr as $imgRow){
				if ($imgRow != ''){
					$img = $pimg = $imgRow;
					break;
				}
			}
		}
?>
				<form id="userProdEdit" action="site/product/edit_user_product_process" method="post" enctype="multipart/form-data" onsubmit="return validateProduct();">
					<fieldset class="pic_preview">
						<img alt="" style="max-height:200px;max-width:200px" src="images/product/<?php echo $img;?>">
						<input type="hidden" name="productID" value="<?php echo $productDetails->row()->seller_product_id;?>"/>
						<p><?php if($this->lang->line('product_diff_photo') != '') { echo stripslashes($this->lang->line('product_diff_photo')); } else echo "Use a different photo?"; ?></p>
						<br class="hidden">
						<input type="file" name="uploadphoto" id="uploadphoto">
						<input type="submit" name="submit" uid="<?php echo $loginCheck;?>" tid="<?php echo $productDetails->row()->seller_product_id;?>" class="upload" value="<?php if($this->lang->line('header_upload') != '') { echo stripslashes($this->lang->line('header_upload')); } else echo "Upload"; ?>">
					</fieldset>
					<!-- / pic_preview -->

					<fieldset class="add-form">
						<ul>
							<li>
								<label for="fancy-title" ><?php if($this->lang->line('product_added_by') != '') { echo stripslashes($this->lang->line('product_added_by')); } else echo "Added by"; ?> <a href="user/<?php echo $userDetails->row()->user_name;?>"><?php echo $userDetails->row()->full_name;?></a></label>
								
							</li>
							<li style="float:left">
								<label for="fancy-title" style="float:left"><?php if($this->lang->line('header_title') != '') { echo stripslashes($this->lang->line('header_title')); } else echo "Title"; ?> <em><?php if($this->lang->line('product_what_photo') != '') { echo stripslashes($this->lang->line('product_what_photo')); } else echo "What's the thing in the photo?"; ?></em></label>
								<input type="text" value="<?php echo $productDetails->row()->product_name;?>" class="text required" name="product_name" id="fancy-title">
							</li>
							<li style="float:left">
								<label for="fancy-web-link" style="float:left"><?php if($this->lang->line('header_weblink') != '') { echo stripslashes($this->lang->line('header_weblink')); } else echo "Web link"; ?> <em><?php if($this->lang->line('product_where_find') != '') { echo stripslashes($this->lang->line('product_where_find')); } else echo "Where can you buy it or find out more?"; ?></em></label>

								<input type="text" value="<?php echo $productDetails->row()->web_link;?>" class="text required" name="web_link" id="fancy-web-link">
							</li>
							<li style="float:left">
								<label for="fancy-comment" style="float:left"><?php if($this->lang->line('header_comment') != '') { echo stripslashes($this->lang->line('header_comment')); } else echo "Comment"; ?> <em><?php if($this->lang->line('product_share_thoughy') != '') { echo stripslashes($this->lang->line('product_share_thoughy')); } else echo "Share your thoughts!"; ?></em></label>
								<textarea class="text" rows="5" cols="30" name="excerpt" id="fancy-comment"><?php echo $productDetails->row()->excerpt;?></textarea>

							</li>
							<li style="float:left">
								<label for="price" style="float:left"><?php if($this->lang->line('header_price') != '') { echo stripslashes($this->lang->line('header_price')); } else echo "Price"; ?> </label>

								<input type="text" value="<?php echo $productDetails->row()->price;?>" class="text required" name="price" id="price">
							</li>
							<li style="float:left;width:100%;">
								<label><?php if($this->lang->line('lg_affiliate_code') != '') { echo stripslashes($this->lang->line('lg_affiliate_code')); } else echo "Affiliate Code"; ?></label>
	                            <input type="text" class="text" placeholder="<?php if($this->lang->line('lg_example') != '') { echo stripslashes($this->lang->line('lg_example')); } else echo "Example"; ?>: aid=xxx" id="edit_affiliate_code" name="affiliate_code" style="" value="<?php echo str_replace('"', "'", $productDetails->row()->affiliate_code);?>">
	                            <span style="color: #92959C;display: block;font-size: 12px;line-height: 18px;padding: 0px 0 3px;"><?php if($this->lang->line('lg_note_affiliate') != '') { echo stripslashes($this->lang->line('lg_note_affiliate')); } else echo "Note: need to enter the affiliate id and your attribute type"; ?></span>
	                            
								<label><?php if($this->lang->line('lg_affiliate_script') != '') { echo stripslashes($this->lang->line('lg_affiliate_script')); } else echo "Affiliate Script"; ?></label>
	                            <textarea class="text" placeholder="<?php if($this->lang->line('lg_example') != '') { echo stripslashes($this->lang->line('lg_example')); } else echo "Example"; ?>: <script>xxx</script>" id="edit_affiliate_script" name="affiliate_script" style="border: 1px solid #BBBBBB;border-radius: 3px;padding: 7px;"><?php echo str_replace('"', "'", $productDetails->row()->affiliate_script);?></textarea>
							</li>
							<li style="float:left">
								<label for="fancy-category" style="float:left"><?php if($this->lang->line('header_category') != '') { echo stripslashes($this->lang->line('header_category')); } else echo "Category"; ?> <em><?php if($this->lang->line('product_how_should') != '') { echo stripslashes($this->lang->line('product_how_should')); } else echo "How should it be filed?"; ?></em></label>
								<select name="category_id" id="fancy-category">
									<option selected="" value=""><?php if($this->lang->line('product_put_cate') != '') { echo stripslashes($this->lang->line('product_put_cate')); } else echo "Put in category"; ?>...</option>
									<?php foreach ($mainCategories->result() as $catRow){?>
									<option <?php if ($catRow->id == $productDetails->row()->category_id){echo 'selected="selected"';}?> value="<?php echo $catRow->id;?>"><?php echo $catRow->cat_name;?></option>
									<?php }?>
									
								</select>
							</li>
						</ul>
						<input type="submit" name="submit" uid="<?php echo $loginCheck;?>" tid="<?php echo $productDetails->row()->seller_product_id;?>" class="button done" value="<?php if($this->lang->line('header_save') != '') { echo stripslashes($this->lang->line('header_save')); } else echo "Save"; ?>" />
					</fieldset>
					<!-- / pic_preview -->
				</form>

			</section>
			<!-- / add-2 -->

				
		</div>
</div>
</div>
</div>
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script>
	$("#userProdEdit").validate();
</script>
<?php
$this->load->view('site/templates/footer');
?>