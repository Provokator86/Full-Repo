<?php
$this->load->view('site/templates/header');
?>
<style type="text/css">
.submenu{
	float: left;
	width: 25%;
	line-height: 2;
	height: 100%;
	padding-top: 10px;
}
.submenu li{
	text-align: right;
	padding-right: 20px;
	font-size: 17px;
	white-space: nowrap;
	overflow: hidden;
	text-overflow: ellipsis;
}
.submenu li.current{
	background: url('images/chevron-overlay.png') no-repeat right;
	font-weight: bold;
}
</style>
    <!-- Section_start -->
    <div id="mid-panel">
        <div class="wrapper">
            <div class="about-container">            
                <div class="about-content-container">
                    <?php 
                    $sub_page_arr = array();
                    foreach ($cmsPages as $cmsRow){
    	                if ($pageDetails->row()->category == 'Main'){
    		                if ($cmsRow['parent'] == $pageDetails->row()->id){
    			                array_push($sub_page_arr, $cmsRow['id']);
    		                }
    	                }else {
    		                if ($cmsRow['parent'] == $pageDetails->row()->parent){
    			                array_push($sub_page_arr, $cmsRow['id']);
    		                }
    	                }
                    }
                    if (count($sub_page_arr)>0){
                    ?>
                    
                    <ul class="submenu">
                    <?php 
                    if ($pageDetails->row()->category == 'Main'){
                    ?>
    	                <li class="current"><a href="pages/<?php echo $pageDetails->row()->seourl;?>"><?php echo $pageDetails->row()->page_name;?></a></li>
                    <?php 
                    }else {
    	                foreach ($cmsPages as $cmsRow){
    		                if ($cmsRow['id'] == $pageDetails->row()->parent){
                    ?>
    	                <li><a href="pages/<?php echo $cmsRow['seourl'];?>"><?php echo $cmsRow['page_name'];?></a></li>
                    <?php 
    			                break;
    		                }
    	                }
                    }
                    foreach ($cmsPages as $cmsRow){
    	                if (in_array($cmsRow['id'], $sub_page_arr)){
                    ?>	
    	                <li <?php if ($this->uri->segment(2)==$cmsRow['seourl']){?>class="current"<?php }?>><a href="pages/<?php echo $cmsRow['seourl'];?>"><?php echo $cmsRow['page_name'];?></a></li>
                    <?php 
    	                }
                    }
                    ?>	
                    </ul>
                    <?php 
                    }
                    ?>
                    <div class="about-content-section" <?php if (count($sub_page_arr)>0){?>style="float: left;width: 72%;padding-left: 15px;"<?php }?>>
    	                <h1><?php echo $pageDetails->row()->page_title;?></h1>
    	                <?php 
            	                if ($pageDetails->num_rows()>0){
            		                echo $pageDetails->row()->description;
            	                }
    	                ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <!-- Section_end -->
<?php
$this->load->view('site/templates/footer');
?>
