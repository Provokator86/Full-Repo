<div class="div01 noboder">
    <div class="find_box02">
<table width="100%" cellspacing="0" cellpadding="0" border="0">
        <tbody>
              <tr>
                    <th   align="left" valign="middle"><?php echo addslashes(t('Message')) ;?> </th>
                    <th  align="center" valign="middle" class="margin00"><?php echo addslashes(t('Date')) ;?></th>
                    <th  align="center" valign="middle" class="margin00" ><?php echo addslashes(t('Action')) ;?> </th>
              </tr>
              <?php 
               if(!empty($pmb_list)) {
						foreach($pmb_list as $val)
						{
                             $job_url    =   make_my_url($val['s_job_title']).'/'.encrypt($val['job_id']) ;
				 ?>
              
              <tr <?php echo ($val['i_new_message']>0)?'style="background: #FFF2E6"':''; ?>>
                    <td valign="middle" align="left" class="leftboder">
                    <div class="left_div"><?php echo showThumbImageDefault('user_profile',$val['s_image'],'no_image.jpg',80,72,'photo') ; ?><?php echo $val['s_username'] ; ?></div>
                    <h5><a href="<?php echo base_url().'job-details/'.$job_url; ?>" target="_blank"><?php echo $val['s_job_title'] ;?></a></h5>
                    
                          <a href="<?php echo base_url().'tradesman/private-message-details/'.encrypt($val['id']).'/all' ;?>"><?php echo string_part($val['s_content'],30) ;?></a><br/><br/>
                          <span><?php echo addslashes(t('All Comments')); ?>(<?php echo $val['i_cnt_msg']; ?>)  </span> 
                                                                                   </td>
                    <td valign="middle" align="center" ><?php echo $val['dt_created_on']; ?></td>
                    
                    <td valign="middle" align="center" class="width19"> 
                    <a href="<?php echo base_url().'tradesman/private-message-details/'.encrypt($val['id']).'/all' ;?>"><img src="images/fe/view.png" alt="" onmouseover="this.src='images/fe/view-hover.png'" onmouseout="this.src='images/fe/view.png'" onclick="this.src='images/fe/view.png'" title="view" /></a>
                  
                     <?php /*($val['i_new_message']>0)
                                    {
                                    ?>
                    <a href="<?php echo base_url().'tradesman/private-message-details/'.encrypt($val['id']).'/new' ;?>"><img src="images/fe/new.png" alt="" onmouseover="this.src='images/fe/new-hover.png'" onmouseout="this.src='images/fe/new.png'" onclick="this.src='images/fe/new.png'" title="new" /></a>
                     <?php 
                                    }
                                    */ ?>
                     <!--<a href="javascript:void(0);" onclick="show_dialog('photo_zoom02')"><img src="images/fe/delete.png" alt="" onmouseover="this.src='images/fe/delete-hover.png'" onmouseout="this.src='images/fe/delete.png'" title="delete" /></a>  -->
                     </td>
              </tr>
              <?php }
			  }  else { 
                  ?>
                  <tr>
                      <td class="leftboder">
                        <p><?php echo addslashes(t('No item found')) ?></p>
                      </td>
                      <td >&nbsp;
                        
                      </td>
                      <td >&nbsp;
                        
                      </td>
                      
                      
                  </tr>
                 <?php } ?>
              
             
        </tbody>
  </table>
  </div>
  </div>
  <div class="spacer"></div>
  <div class="page">
        <?php echo $page_links ?>
   </div>