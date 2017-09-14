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
                
                  <h2><?php echo addslashes(t('Help'))?></h2>
                  <?php
                  // $arr_cat fetch from database.php category array
                  foreach($arr_cat as $key=>$value)
                  { 
                   echo '<h4>'.$value.'</h4>'; 
                      
                      if(!empty($help_list))
                      {
                          foreach($help_list as $val)
                          {
                              if($val['i_help_cat']==$key)
                              { ?>
                                    <div class="main_faq">
                                        <div class="faq_heading"><?php echo $val['s_question']; ?></div>
                              
                                        <div class="faq_contant">
                                            <p><?php echo $val['s_answer_full']; ?></p>
                                        </div>
                        
                                    </div>
                                  
                                  
                            <?php
                              }
                          }
                      }
                      
                  }
                ?>
                
                  <div class="spacer"></div>
                  <p>&nbsp;</p>
            </div>
            <!--End of div midd_part height02-->
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
<!--End of div job_categories-->
