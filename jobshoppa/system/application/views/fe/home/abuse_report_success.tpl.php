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
                <h3><span>Abuse</span> Report</h3>
            </div>
             <p>Thank you,<span> your report send successfully. You will get reply soon</span></p>
            <!--/INNER CONTAINER02-->
        </div>
        
        <div class="clr"></div>
    </div>
</div>
<?php  //End of content_section ?>       