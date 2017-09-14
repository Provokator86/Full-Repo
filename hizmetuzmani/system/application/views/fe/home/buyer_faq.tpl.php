<?php
/*********
* Author:Koushik Rout
* Date  : 25 April 2012
* Modified By: Jagannath Samanta 
* Modified Date: 28 June 2011
* 
* Purpose:
*  View For buyer faq front end
* 
* @subpackage faq
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/fe/home/buyer_faq/
*/
?>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                
                  <h2>FAQ</h2>
                  <?php
                  // $arr_cat fetch from database.php category array
                  foreach($arr_cat as $key=>$value)
                  { 
                   echo '<h4>'.$value.'</h4>'; 
                      
                      if(!empty($faq_list))
                      {
                          foreach($faq_list as $val)
                          {
                              if($val['i_faq_cat']==$key)
                              { ?>
                                    <div class="main_faq">
                                        <div class="faq_heading"><?php echo $val['s_question']; ?></div>
                              
                                        <div class="faq_contant">
                                            <p><?php echo $val['s_answer']; ?></p>
                                        </div>
                        
                                    </div>
                                  
                                  
                            <?php
                              }
                          }
                      }
                      
                  }
                ?>

                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>