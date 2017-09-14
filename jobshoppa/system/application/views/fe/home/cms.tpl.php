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
        <div id="inner_container02" class="static_page">
            <div class="title">
                <h3><span><?php echo $pre ?> </span><?php echo $next ?> </h3>
            </div>
            <div class="content_box">
                 <?php 
				 	//pr($info);exit;
				 		if($info)
				 		{ 
							foreach($info as $val) 
							{ 
				 ?>
                        <p><?php echo $val['s_full_description'] ?></p>
                <?php 		}
				  		} 
				?>
            </div>
			<!--<div class="content_box">
                <p>Founded in 2010, Jobshoppa is a unique online marketplace for the residents of the United States of America. Homeowners and consumers can find the right professional and contractor here. Professional can secure contracts easily and regularly at Jobshoppa as well.</p>
                <p>&nbsp;</p>
                <p>Homeowners and consumers can post requirements for professional or handymen for free. Professional and handymen can register with the site for free, and quote for jobs posted on the site.</p>
                <p>&nbsp;</p>
                <p>&nbsp;</p>
            </div>-->
			
             <!-- /CONTENT BOX --> 
        </div>
         <!-- /INNER CONTAINER02 --> 
    <div class="clr"></div>               
</div>
<!-- /CONTENT--> 
    <div class="clr"></div>  
</div>
 <!-- /CONTENT SECTION -->  
      