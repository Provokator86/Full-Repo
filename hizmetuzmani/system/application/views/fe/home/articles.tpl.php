<?php
 /*********
* Author:Koushik Rout
* Date  : 25 April 2012
* Modified By: Jagannath Samanta 
* Modified Date: 28 June 2011
* 
* Purpose:
*  View For help front end
* 
* @subpackage help
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/fe/home/help/
*/ 
?>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<!--Strat of div job_categories-->
<div class="job_categories">
            <div class="top_part"></div>
            <!--Strat of div midd_part height02-->
            <div class="midd_part height02">
                
                  <h2><?php echo addslashes(t('Articles'))?></h2>
                  
				  <div id="article_list">
				  <?php echo $article_list ?>
				  </div>
                
                  <div class="spacer"></div>
                  <p>&nbsp;</p>
            </div>
            <!--End of div midd_part height02-->
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
<!--End of div job_categories-->
