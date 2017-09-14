  <div class="div01 noboder">
        <div class="find_box02">
   <table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
              <tr>
                    <th  align="left" valign="middle">Name</th>
                    <th align="left" valign="middle">Email</th>
                    <th align="center" valign="middle" class="margin00">Recommend Date</th>
                    <th  align="center" valign="middle" class="margin00">Status </th>
              </tr>
              <?php 
              if(!empty($info_recommend))
              {
                  foreach($info_recommend as $val)
                  {
              ?>
               <tr>
                    <td valign="middle" align="left" class="leftboder"><?php echo $val['s_name'] ; ?></td>
                    <td align="left" valign="middle"><a href="<?php echo $val['s_email'] ; ?>"><?php echo $val['s_email'] ; ?></a></td>
                    <td valign="middle" align="center"><?php echo $val['dt_recommend_on'] ; ?></td>
                    <td align="center" valign="middle"><?php echo $val['s_is_active'] ; ?></td>
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
