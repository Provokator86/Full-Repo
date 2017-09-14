 <script type="text/javascript"> 
 $(document).ready(function() {
                           $("#opt_job").msDropDown();
                           $("#opt_job").hide();
                           $('#opt_job_msdd').css("background-image", "url(images/fe/big-select.png)");
                           $('#opt_job_msdd').css("background-repeat", "no-repeat");
                           $('#opt_job_msdd').css("width", "350px");
                           $('#opt_job_msdd').css("margin-top", "0px");
                           $('#opt_job_msdd').css("padding", "0px");
                           $('#opt_job_msdd').css("height", "38px");
                            
                            
                           $("#opt_user").msDropDown();
                           $("#opt_user").hide();
                           $('#opt_user_msdd').css("background-image", "url(images/fe/select.png)");
                           $('#opt_user_msdd').css("background-repeat", "no-repeat");
                           $('#opt_user_msdd').css("width", "269px");
                           $('#opt_user_msdd').css("margin-top", "0px");
                           $('#opt_user_msdd').css("padding", "0px");
                           $('#opt_user_msdd').css("height", "38px");
                           
                           
                           $("#opt_job_child").find('a').click(function(){
                                    var job_id      =   $("#opt_job").val();
                                    var user_id     =   $("#opt_user").val();
                                    call_ajax(job_id,user_id) ;      
                           })  ;
                           
                           
                           $("#opt_user_child").find('a').click(function(){
                                    var job_id      =   $("#opt_job").val();
                                    var user_id     =   $("#opt_user").val();
                                    call_ajax(job_id,user_id) ;       
                           })  ;
                           
                           $("#btn_show_all").click(function(){
                                    var job_id      =   '';
                                    var user_id     =   '';
                                    call_ajax(job_id,user_id) ; 
                               
                           })  ;
                           
                           $("#show_all").click(function(){
                               
                                call_ajax('','') ; 
                                $('#opt_user_titletext').text('<?php echo addslashes(t('Select Buyer')) ;?>');
                                $('#opt_job_titletext').text('<?php echo addslashes(t('Select Job')) ;?>');
                               
                           });
                           
                           
                           var call_ajax    =   function(job_id,user_id)
                           {
                                    
                                    
                                    $.ajax({
                                    type: "POST",
                                    url: base_url+'tradesman/ajax_pagination_pmb',
                                    data: "job_id="+job_id+"&user_id="+user_id,
                                    success: function(msg){
                                       if(msg!='error')
                                       {
                                           $("#pmb_list").html(msg)

                                       }   
                                    }
                                });
                           }
                           
                        }); 

 </script>
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                              <h4><?php echo addslashes(t('My Private Message Board')); ?></h4>
                              <div class="filter_option_box">
                                    <h3><?php echo addslashes(t('Filter')); ?></h3>
                                    
                                    <div class="lable03"><?php echo addslashes(t('Job title')); ?> </div>
                                   <select id="opt_job" name="opt_job" style="width:350px;">
                                     <option value=""><?php echo addslashes(t('Select Job')); ?></option> 
                                   <?php echo makeOption($arr_jobs); ?>
                                    </select>
                                   
                                    
                                    <div class="spacer"></div>
                                    <div class="lable03"><?php echo addslashes(t('Users')); ?></div>
                                    <select id="opt_user" name="opt_user" style="width:269px;">
                                     <option value=""><?php echo addslashes(t('Select Buyer')); ?></option>
                                      <?php echo makeOption($arr_users); ?> 
                                    </select>

                                  
									 <div class="textfell02"> 
								   <a href="javascript:void(0);" id="show_all" style="margin-left:20px;"><?php echo addslashes(t('Show All')); ?>
								   </a>
								   </div>
									<div class="spacer"></div>
                                  
                              </div>

                                          <div id="pmb_list">
                                          <?php echo $pmb_list ;?>
                                          </div>

                              <div class="spacer"></div>
                              
                              <div class="icon_bar">
                              <ul>
                            
                              <li><img src="images/fe/view.png" alt="" /> <?php echo addslashes(t('View')) ; ?></li>
                               <li>|</li>
                            
                              <li class="last"><img src="images/fe/new.png" alt="" /><?php echo addslashes(t('New')); ?></li>
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