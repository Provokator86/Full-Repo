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
                  <h3><span>Help</span></h3>
            </div>
            <div id="help_box">
                <div class="title04">
                    <h5><span>Client</span> Questions</h5>
                </div>
                 <?php $cnt=1; 
                  foreach($category as $val)
                  {                                           
                  
                  ?>
                <div class="heading_box"><?php echo $val["s_category_name"];?></div>
            
                    <div class="text_box">
               
                
                    <ul class="accordion">
                     <?php 
                     foreach($val["ques_ans"] as $key=>$value){ 
                     ?>
                    <li> <a href="javascript:void(0)" rel="accordion<?php echo $cnt ?>"><?php echo $value["s_question"] ?></a>
                        <ul>
                            <li><?php echo $value["s_answer"] ?>  </li>
                            
                        </ul>
                    </li>
                    
                    <?php 
                         $cnt++;
                         } 
                    ?>
                </ul>
                
 
                     </div> 
            <?php }  ?>  
        </div>
        <!-- /help_box -->       
    </div>
         <!-- /INNER CONTAINER02 --> 
    <div class="clr"></div>               
</div>
<!-- /CONTENT--> 
    <div class="clr"></div>  
</div>
 <!-- /CONTENT SECTION -->         