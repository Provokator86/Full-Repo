<?php
$this->load->view('site/templates/header',$this->data);
?>
<link rel="stylesheet" media="all" type="text/css" href="css/site/<?php echo SITE_COMMON_DEFINE ?>setting.css">
<!-- Section_start -->
<div class="lang-en no-subnav wider winOS">
<!-- Section_start -->
<div id="container-wrapper">
	<div class="container set_area">
		<?php if($flash_data != '') { ?>
		<div class="errorContainer" id="<?php echo $flash_data_type;?>">
			<script>setTimeout("hideErrDiv('<?php echo $flash_data_type;?>')", 3000);</script>
			<p><span><?php echo $flash_data;?></span></p>
		</div>
		<?php } ?>
        

        <div id="content">
		<h2 class="ptit">Add Product Image</h2>
		<form method="post" action="<?php echo base_url().'site/product/add_product_image_process'?>" enctype="multipart/form-data">
		<div class="section password">
			<fieldset class="frm">
				<label>Image Alt Tag</label>
				<input type="text" name="alt_tag" id="alt_tag"/>
				<label>Image Title</label>
				<input type="text" name="title" id="title"/>
				<label>Product Name</label>
				<input type="text" name="pname" id="pname"/>
				<label>Category</label>
				<input type="text" placeholder="Ex: Mens, Womens" name="cat" id="cat"/>
				<input type="hidden" name="img_link" id="img_link" value="./"/>
				<label>Image (size 600x600 pixels)</label>
				<input type="file" name="file_name" id="file_name"/>
			</fieldset>
		</div>
		<div class="btn-area">
			<button id="save_password" class="btn-save">Submit</button>
			<span style="display:none" class="checking"><i class="ic-loading"></i></span>
		</div>
		</form>		
	</div>

	<div id="sidebar">
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_account') != '') { echo stripslashes($this->lang->line('referrals_account')); } else echo "ACCOUNT"; ?></dt>
				<dd><a href="settings" class="current"><i class="ic-user"></i> <?php if($this->lang->line('referrals_profile') != '') { echo stripslashes($this->lang->line('referrals_profile')); } else echo "Profile"; ?></a></dd>
	            <dd><a href="settings/preferences"><i class="ic-pre"></i> <?php if($this->lang->line('referrals_preference') != '') { echo stripslashes($this->lang->line('referrals_preference')); } else echo "Preferences"; ?></a></dd>
				<dd><a href="settings/password"><i class="ic-pw"></i> <?php if($this->lang->line('signup_password') != '') { echo stripslashes($this->lang->line('signup_password')); } else echo "Password"; ?></a></dd>
				<dd><a href="settings/notifications"><i class="ic-noti"></i> <?php if($this->lang->line('referrals_notification') != '') { echo stripslashes($this->lang->line('referrals_notification')); } else echo "Notifications"; ?></a></dd>
			</dl>
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_shop') != '') { echo stripslashes($this->lang->line('referrals_shop')); } else echo "SHOP"; ?></dt>
	            <dd><a href="purchases"><i class="ic-pur"></i> <?php if($this->lang->line('referrals_purchase') != '') { echo stripslashes($this->lang->line('referrals_purchase')); } else echo "Purchases"; ?></a></dd>
<!-- 	            <dd><a href="fancyybox/manage"><i class="ic-sub"></i> <?php if($this->lang->line('referrals_subscribe') != '') { echo stripslashes($this->lang->line('referrals_subscribe')); } else echo "Subscriptions"; ?></a></dd>
 -->	            <dd><a href="settings/shipping"><i class="ic-ship"></i> <?php if($this->lang->line('referrals_shipping') != '') { echo stripslashes($this->lang->line('referrals_shipping')); } else echo "Shipping"; ?></a></dd>
	        </dl>
			<dl class="set_menu">
				<dt><?php if($this->lang->line('referrals_sharing') != '') { echo stripslashes($this->lang->line('referrals_sharing')); } else echo "SHARING"; ?></dt>
<!-- 	            <dd><a href="credits"><i class="ic-credit"></i> Credits</a></dd>
	   -->          <dd><a href="referrals/0"><i class="ic-refer"></i> <?php if($this->lang->line('referrals_common') != '') { echo stripslashes($this->lang->line('referrals_common')); } else echo "Referrals"; ?></a></dd>
	        </dl>
		</div>

	</div>
	<!-- / container -->
</div>
</div>


<!-- Section_start -->
<script type="text/javascript" src="js/site/<?php echo SITE_COMMON_DEFINE ?>address_helper.js"></script>
<script type="text/javascript" src="js/site/jquery.validate.js"></script>
<script>

	$("#shippingEditForm").validate();
	$("#shippingAddForm").validate();

	jQuery(function($) {
		var $select = $('.gift-recommend select.select-round');
		$select.selectBox();
		$select.each(function(){
			var $this = $(this);
			if($this.css('display') != 'none') $this.css('visibility', 'visible');
		});
	});
</script>
<?php 
$this->load->view('site/templates/footer',$this->data);
?>
