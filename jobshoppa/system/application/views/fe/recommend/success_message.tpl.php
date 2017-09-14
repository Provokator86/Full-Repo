<div id="banner_section">
    <?php
	include_once(APPPATH."views/fe/common/header_top.tpl.php");
	?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
<?php 
if(decrypt($loggedin['user_type_id'])==2)
	{ 
	include_once(APPPATH."views/fe/common/common_search.tpl.php");
	} 
else if(decrypt($loggedin['user_type_id'])==1) 
{ 
	include_once(APPPATH.'views/fe/common/common_buyer_search.tpl.php'); 
} 
else 
{ 
include_once(APPPATH.'views/fe/common/common_search.tpl.php'); 
} 
?>	
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
    <div id="content">
        <div id="inner_container02">
            <div class="title">
                <h3><span>Thanks </span> for recommending us.</h3>
            </div>
            <div class="content_box">
                <p>An email has been sent to referred individual. </p>
            </div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>