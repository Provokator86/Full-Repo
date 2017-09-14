<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
    <div id="content">
	<div id="div_err">
         <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); 
            //show_msg("error");  
            echo validation_errors();
            //pr($posted);
        ?>
     </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>Jobs </span> within Radar </h3>
            </div>
            <div class="clr"></div>
            <!--<h6>&quot; All current jobs within your radar &quot;</h6>-->
            <div class="clr"></div>
            <div id="account_container">
                <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
                            <div class="heading_box">
                                <div class="left">Total <?php echo $tot_job ?> Jobs found from your radar settings.</div>
                                
                            </div>
                            
                            <div class="clr"></div>
                            <div id="job_list"><?php echo $job_contents ?></div>
                            <div class="clr"></div>
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
                <?php
                    include_once(APPPATH."views/fe/common/tradesman_right_menu.tpl.php");
                ?>  
            </div>
            <div class="clr"></div>
        </div>
        <div class="clr"></div>
    </div>
    <div class="clr"></div>
</div>

