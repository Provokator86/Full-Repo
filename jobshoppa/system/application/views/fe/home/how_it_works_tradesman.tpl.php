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
                <h3><span>Professional - </span>How it Works</h3>
            </div>
        <div id="help_box">
               <!-- <div class="heading_box">Search, Quote and Win jobs to get paid for the job - <span>for FREE!</span> </div>-->
                <?php foreach($info as $val) {?>
                <div class="text_box" style="border:none;">
                   <!--  <ul class="list02">
                        <li>Post your jobs online &amp; receive multiple quotes today</li>
                        <li>You could save up to 30%</li>
                        <li>Professional  are rated by other clients so you know what youâ€™re getting</li>
                    </ul>   -->
                     <?php echo $val["s_basic_content"] ?>  
                          
                </div>
                <div class="clr"></div>
                <?php /*?><div id="how_tab">
                    <div class="top">
                        <ul>   
                            <li><a href="javascript:void(0)" id="11" class="select"><span>Create a Profie</span></a></li>
                            <li><a href="javascript:void(0)" id="22"><span>Receive Job Requests</span></a></li>
                            <li><a href="javascript:void(0)" id="33"><span>Build a Reputation</span></a></li>
                        </ul>
                    </div>
                    <div class="mid" id="div11">
                        <!--<p>Fill up the online form to post a job. It takes just a few minutes. Just make sure that your job description is clear and detailed so that only those professionals capable of meeting your requirements quote for your job.</p>
                        <p>&nbsp;</p>
                        <p>Try to include the following information:</p>
                        <p>&nbsp;</p>
                        <ul class="list02">
                            <li>Anticipated start date</li>
                            <li>Dimensions (exact or approximate)</li>
                            <li>Any images such as photographs or plans</li>
                        </ul>
                        <p>&nbsp;</p> -->
                        <?php echo $val["s_search_job_content"] ?>   
                    </div>
                    <div class="mid" id="div22" style="display:none;">
                        <!--<p>Builders, plumbers, gardeners, roofers, cleaning services and a host of other contractors or handymen who are registered with us will quote for relevant jobs posted on our site. At Jobshoppa you are assured to find the best workman for yourself. Your description needs to be spot on however.Professionals will offer you competitive rates for their services, and you can thus be assured of the best bargain. The review system ensures the reliability of professionals.</p>-->
                        <?php echo $val["s_post_queries_content"] ?>    
                    </div>
                    <div class="mid" id="div33" style="display:none;">
                        <!-- <p>Having received quotes it’s time to pick the professional who can do the job best for you. Refer to the reviews of other users on contractors and handymen. Shortlist those with impressive reviews on them and interview them. During the interview find out if a workman or contractor understands your needs perfectly. Weigh pros and cons and go ahead with picking your man.</p>-->
                        <?php echo $val["s_quote_on_job_content"] ?>      
                    </div>
                    
                    <div class="bot">&nbsp;</div>
                </div><?php */?>                 
                <?php } ?>    
                <div class="clr"></div>
              
            </div>
        </div>
         <!-- /INNER CONTAINER02 --> 
    <div class="clr"></div>               
</div>
<!-- /CONTENT--> 
    <div class="clr"></div>  
</div>
 <!-- /CONTENT SECTION -->  
            