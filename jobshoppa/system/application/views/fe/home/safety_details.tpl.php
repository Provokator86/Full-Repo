<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
	//include_once(APPPATH."views/fe/common/common_search.tpl.php");
	?>
<?php if(decrypt($loggedin['user_type_id'])==2){ ?>
           
	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } else if(decrypt($loggedin['user_type_id'])==1) { ?>

	  <?php include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); ?>

<?php } else {?>

	  <?php include_once(APPPATH.'views/fe/common/common_search.tpl.php'); ?>

<?php } ?>	

<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
    <div id="content">
        <div id="inner_container02">
            <div class="title">
                <h3><span>Safety</span> </h3>
            </div>
				<?php
					if($safety_details)
					{
						foreach($safety_details as $val)
						{
					?>
            <div class="content_box">
                <p><?php echo $val['s_full_description']?></p>
                <p>&nbsp;</p>
            </div>
			<?php } } ?>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>