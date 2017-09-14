<div class="div01 noboder">
    <div class="find_box02">
          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                <tbody>
                      <tr>
                        <th align="left" valign="middle"><?php echo addslashes(t('Job Details'))?> </th>                
                        <th align="center" valign="middle"><?php echo addslashes(t('Option'))?></th>
                    </tr>
                      <?php if($job_list) { 
                                $i = 1;
                      
                            foreach($job_list as $val)
                                {
                                 $job_url    =   make_my_url($val['s_title']).'/'.encrypt($val['id']) ;  
                                $class = ($i%2 == 0)?'class="bgcolor"':'';
                       ?>
                      <tr>
                        <td valign="middle" align="left" class="leftboder" width="80%">
                        <h5><a href="<?php echo base_url().'job-details/'.$job_url ;  ?>" target="_blank"><?php echo $val['s_title'];?></a></h5>
                              <?php echo string_part($val['s_description'],200);?>
                              <div class="spacer"></div>
                              <ul>
                                    <li><?php echo addslashes(t('Category'))?>: <span><?php echo $val['s_category_name'];?><br/></span></li>
                                    
                                    <li><?php echo addslashes(t('Completion Date'))?> <span><?php echo $val['dt_completed_date'];?></span> </li>
                                    <li>|</li>
                                    <li><?php echo addslashes(t('Buyer'))?> <span><a href="javascript:void(0);" > <?php echo $val['s_buyer_name'] ?></a></span></li>
                              </ul></td>
                        <td valign="middle" align="center" >
                        <a href="<?php echo base_url().'job-details/'.$job_url ; ?>" target="_blank"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'"  title="view"/></a> 
                      <!--  <a href="javascript:void(0);"  onclick="show_feedback('<?php echo encrypt($val['id']) ;?>');"><img src="images/fe/feedback.png" alt="" onmouseover="this.src='images/fe/feedback-hover.png'" onmouseout="this.src='images/fe/feedback.png'" onclick="this.src='images/fe/feedback.png'" title="feedback" /></a> 
                        <a href="javascript:void(0);" onclick="show_history('<?php echo encrypt($val['id']) ;?>');"><img src="images/fe/history.png" alt="" onmouseover="this.src='images/fe/history-hover.png'" onmouseout="this.src='images/fe/history.png'" onclick="this.src='images/fe/history.png'"  title="history" /></a> -->
                        </td>
                      </tr>                                                      
                      <?php $i++; } } 
                          else { 
                      ?>
                      <tr>
                          <td class="leftboder">
                            <p><?php echo addslashes(t('No item found')) ?></p>
                          </td>
                          <td align="left" valign="middle"></td>
                        
                      </tr>
                     <?php } ?>
                      
                </tbody>
          </table>
    </div>
</div>

  <div class="spacer"></div>
  <div class="page">
    <?php echo $page_links; ?>
  </div>