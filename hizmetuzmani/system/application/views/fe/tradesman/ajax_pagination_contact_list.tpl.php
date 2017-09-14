                              <div class="div01 noboder">
                                    <div class="find_box02">
                                          <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                <tbody>
                                                      <tr>
                                                            <th   align="left" valign="middle"><?php echo addslashes(t('Buyer Name'));?>  </th>
                                                            <th   align="left" valign="middle"><?php echo addslashes(t('Contact Details'));?> </th>
                                                            
                                                      </tr>
                                                      <?php 
                                                          if(!empty($info_contact))
                                                          {
                                                              foreach($info_contact as $val)
                                                              {
                                                          ?>
                                                      <tr class="bgcolor">
                                                            <td valign="middle" align="left" class="leftboder"><?php echo $val['s_username']?></td>
                                                            <td valign="middle" align="center" >
                                                            
                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mail_box">
                                                                        <tr>
                                                                              <td align="left" valign="top"><img src="images/fe/mail.png" alt="" /></td>
                                                                              <td align="left" valign="top"><a href="mailto:<?php echo $val['s_email']; ?>"><?php echo $val['s_email']; ?></a></td>
                                                                        </tr>
                                                                        <tr>
                                                                              <td align="left" valign="top"><img src="images/fe/phone.png" alt="" width="20" height="20" /></td>
                                                                              <td align="left" valign="top"><?php echo $val['s_contact_no'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                              <td align="left" valign="top"><img src="images/fe/address.png" alt="" /></td>
                                                                              <td align="left" valign="top"><?php echo $val['s_address'] ; ?></td>
                                                                        </tr>
                                                            </table></td>
                                                               
                                                      </tr>
                                                       <?php
                      
                                                          }
                                                      }
                                                      else
                                                      {
                                                      ?>
                                                       <tr>
                                                            <td colspan="4"><?php echo addslashes(t('No item found')) ; ?></td>
                                                      </tr>
                                                      
                                                      <?php    
                                                      }
                                                      ?>                                                      
                                                        
                                                      
                                                      
                                                      
                                                      
                                                </tbody>
                                          </table>
                                    </div>
                              </div>
                              <div class="spacer"></div>
                              <div class="page">
                                    <?php echo $page_links ?>
                              </div>
