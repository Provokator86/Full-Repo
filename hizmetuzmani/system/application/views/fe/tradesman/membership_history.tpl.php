<?php
/*********
* Author: Koushik
* Date  : 13 May 2012
* Modified By: 
* Modified Date: 
* 
* View for list of membership history.
*/  
?>
<?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                        <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>
                        <div id="div_err">
                    
                        </div>    
                              <h4><?php echo addslashes(t('Membership History')) ; ?></h4>
                              <div class="div01 noboder">
                                    <div class="find_box02">
                                          
                                                      <div id="membership_history">
                                                      <?php echo $membership_history;?>
                                                      </div>

                                                
                                    </div>
                              </div>
                              <div class="spacer"></div>
                             
                               <div class="page">
                                    <?php echo $page_links ?>
                               </div>
                              
                              <div class="spacer"></div>
                              
                              <div class="icon_bar">
                              <ul>
                              <li><img src="images/fe/edit.png" alt="" /> Edit</li>
                              <li>|</li>
                              <li><img src="images/fe/view.png" alt="" /> View</li>
                               <li>|</li>
                              <li><img src="images/fe/history.png" alt="" />History</li>
                               <li>|</li>
                              <li><img src="images/fe/delete.png" alt="" />Delete</li>
                              <li>|</li>
                              <li><img src="images/fe/feedback.png" alt="" />Feedback</li>
                              <li>|</li>
                              <li><img src="images/fe/mass.png" alt="" />Messages</li>
                              <li>|</li>
                              <li class="last"><img src="images/fe/new.png" alt="" />New</li>
                              </ul>
                               <div class="spacer"></div>
                              </div>
                               <div class="spacer"></div>
                              
                        </div>
                        <?php include_once(APPPATH."views/fe/common/tradesman_left_menu.tpl.php"); ?>
                        <div class="spacer"></div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>
