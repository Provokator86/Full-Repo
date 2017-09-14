 <script>
 
 
function show_active_tradesman(tradesman_id)
{
   // show_dialog('photo_zoom03');
    $.ajax({
                type: "POST",
                url: base_url+'find_tradesman/ajax_fetch_active_jobs',
                data: "tradesman_id="+tradesman_id,
                success: function(msg){
                   if(msg!='')
                   {
                      //alert(msg);
                       $("#job_listing").html(msg);
                       show_dialog('photo_zoom03');
                       
                   }   
                }
            });    
} 

 // Ajax call to populate province options
function call_ajax_get_province(ajaxURL,item_id,cngDv)
{
        document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
        $.ajax({
                type: "POST",
                url: base_url+'ajax_fe/'+ajaxURL,
                data: "city_id="+item_id,
                success: function(msg){
                   if(msg!='')
                   {
                       document.getElementById(cngDv).innerHTML = msg;
                       $("#opt_state").msDropDown();
                       $("#opt_state").hide();
                       $('#opt_state_msdd').css("background-image", "url(images/fe/select02.png)");
                       $('#opt_state_msdd').css("background-repeat", "no-repeat");
                       $('#opt_state_msdd').css("width", "249px");
                       $('#opt_state_msdd').css("margin-top", "0px");
                       $('#opt_state_msdd').css("padding", "0px");
                       $('#opt_state_msdd').css("height", "38px");
                       

                   }   
                }
            });    
}

function inviteTradesman()
{
      var i_invite  =   true ;
      $("input[name^=chk_jobs]:checked").each(function(){
          i_invite  =   false ;
      }); 
      if(i_invite)
      {
          $("#err_no_chk").text('<?php echo addslashes(t('Please select job')); ?>').slideDown(1000).delay(1000).fadeIn(1000);
      }
      else
      {
          $("#err_no_chk").hide();
          $("#frm_invite_req").submit();
          
      }
      
}
</script>

<script type="text/javascript">

$(document).ready(function(){
    
$('input[id^="btn_srch"]').each(function(i){
   $(this).click(function(){
   
       //$.blockUI({ message: 'Just a moment please...' });
       $("#tradesman_srch").submit();
       //check_duplicate();
   }); 
});  
    
///////////Submitting the form/////////
$("#tradesman_srch").submit(function(){
    var b_valid=true;
    var pattern = /^[a-zA-Z]+/;
    var s_err="";
    $("#div_err").hide(); 
    
    /////////validating//////
    if(!b_valid)
    {
        //$.unblockUI();  
        $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show();
    }
    return b_valid;
    });   
    

});    
</script>
 <?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>   
  <div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                        <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?> 
                              <h4><?php echo addslashes(t('Search')).'/'.addslashes(t('Invite Tradesman')); ?> </h4>
                              <h5><img src="images/fe/search.png" alt="" /><?php echo $tot_rows; ?> <?php echo addslashes(t('Tradesman found')); ?></h5>
                              <div class="filter_option_box">
                                   <h3><?php echo addslashes(t('Filter options'))?></h3>
                                    
                                  <!-- <select id="tradesman" name="tradesman" style="width:249px;"> <option>All Tradesman</option></select> <div class="lable">In</div>
                                   <script type="text/javascript">
                        $(document).ready(function() {
                          $("#tradesman").msDropDown();
                           $("#tradesman").hide();
                           $('#tradesman_msdd').css("background-image", "url(images/fe/select02.png)");
                           $('#tradesman_msdd').css("background-repeat", "no-repeat");
                           $('#tradesman_msdd').css("width", "249px");
                           $('#tradesman_msdd').css("margin-top", "0px");
                           $('#tradesman_msdd').css("padding", "0px");
                            $('#tradesman_msdd').css("height", "38px");
                             $('#tradesman_msdd').css("margin-right", "10px");
                        });
                    
                    </script>  -->
                    <form name="tradesman_srch" id="tradesman_srch" action="" method="post">   
                    <div class="lable"><?php echo addslashes(t('Category'))?></div>
                <div class="textfell05">
                <select id="category" name="category" style=" width:249px;">
                <option value=""> <?php echo addslashes(t('All'))?></option>
                     <?php echo makeOptionCategory(" c.i_status=1 ", $posted['src_tradesman_category_id']);?>
                </select>
                <script type="text/javascript">
                $(document).ready(function() {
                  $("#category").msDropDown();
                   $("#category").hide();
                   $('#category_msdd').css("background-image", "url(images/fe/select02.png)");
                   $('#category_msdd').css("background-repeat", "no-repeat");
                   $('#category_msdd').css("width", "249px");
                   $('#category_msdd').css("margin-top", "0px");
                   $('#category_msdd').css("padding", "0px");
                    $('#category_msdd').css("height", "38px");
                     $('#category_msdd').css("margin-right", "10px");
                });
            
            </script>
                </div>
                              
                            <div class="lable"><?php echo addslashes(t('City'))?> </div>
                <div class="textfell05">
                <select id="opt_city" name="opt_city" style=" width:249px;" onchange='call_ajax_get_province("ajax_change_province_option_auto_complete",this.value,"parent_state");'>
                <option value=""><?php echo addslashes(t('Select City'))?></option>
                <?php echo makeOptionCity('',$posted['src_tradesman_city_id']); ?>
                </select>
                <script type="text/javascript">
                $(document).ready(function() {
                  $("#opt_city").msDropDown();
                   $("#opt_city").hide();
                   $('#opt_city_msdd').css("background-image", "url(images/fe/select02.png)");
                   $('#opt_city_msdd').css("background-repeat", "no-repeat");
                   $('#opt_city_msdd').css("width", "249px");
                   $('#opt_city_msdd').css("margin-top", "0px");
                   $('#opt_city_msdd').css("padding", "0px");
                   $('#opt_city_msdd').css("height", "38px");
                });
            
            </script>
                </div>
                <div class="spacer"></div>
                <div class="margin05"></div>
                
                  <div class="lable"><?php echo addslashes(t('Keywords'))?> </div>
                <div class="textfell06">
                <input name="txt_keyword" id="txt_keyword" value="<?php echo $posted['src_tradesman_keyword'] ?>" type="text" />
                </div>

                   <div class="lable"><?php echo addslashes(t('Province'))?></div>
                <div class="textfell05">
                
                <div id="parent_state">
                    <select id="opt_state" name="opt_state" style=" width:249px;">
                    <option value=""><?php echo addslashes(t('Select Province')) ?></option>
                    <?php echo makeOptionProvince(' i_city_id ="'.(opt_city.val).'" ',$posted['src_tradesman_city_id']); ?>
                    </select>
                </div>
              <script type="text/javascript">
                $(document).ready(function() {
                  $("#opt_state").msDropDown();
                   $("#opt_state").hide();
                   $('#opt_state_msdd').css("background-image", "url(images/fe/select02.png)");
                   $('#opt_state_msdd').css("background-repeat", "no-repeat");
                   $('#opt_state_msdd').css("width", "249px");
                   $('#opt_state_msdd').css("margin-top", "0px");
                   $('#opt_state_msdd').css("padding", "0px");
                   $('#opt_state_msdd').css("height", "38px");
                   $('#opt_state_msdd').css("margin-right", "20px");
                  
                });
            
            </script>
                </div>
                              
                              <div class="spacer"></div>
                              
                              <input class="small_button" id="btn_srch" type="button" value="<?php echo addslashes(t('Search'))?>" />
                              </div>
                              </form>
                              <div class="spacer"></div>
                              
                             <!-- <div class="find_tradesman_box">
                             <div class="left_photo"><img class="photo" alt="" src="images/fe/man-photo.png" />
                              <div class="verified_icon"><img alt="" src="images/fe/tick.png" /></div>
                             
                             </div>
                            
                            
                             
                             <div class="right_content width02">
                                   <div class="member_box">
                                   <div class="membername"><a href="tradesman_profile.html">Steav Williams </a> <br /> <em>Adana</em></div>
                                   <div class="invite">
                                   <div class="div01 noboder">
                                   <a href="javascript:void(0);" onclick="show_dialog('photo_zoom03')">Invite</a> |<a href="tradesman_profile.html"> View Profile</a>
                                   </div>
<div class="spacer"></div>                                
<em>Member since 11-09-2011</em>                                  
                                   </div>
                                   <div class=" spacer"></div>
                                  
                                   </div>
                                   <div class=" spacer"></div>
                                   
                                   
                                   <div class="trades">
                                   <h3>Main Skills &amp; Trades:</h3>
                                   <p>Bathroom Fitter, Plumber, Restoration &amp; Refurb Specialist</p>
                                  
                                   </div>
                                   
                                   <div class="won_job">1 jobs won <br /> <img alt="" src="images/fe/blue-star.png" /><img alt="" src="images/fe/blue-star.png" /><img alt="" src="images/fe/blue-star.png" /><img alt="" src="images/fe/blue-star.png" /><img alt="" src="images/fe/blue-star.png" /></div>
                                   <div class="spacer"></div>
                                    
                                 
                                   
                                   <div class="main_faq main_faq02">
                                                      <div class="faq_heading faq_heading02"><p>1 Feedback reviews, <span>100% positive</span></p></div>
                                                      <div class="faq_contant" style="display: none;">
                                                           <div class="feed_back width03">
                                         <div class="left_feedback"><h5><img alt="" src="images/fe/dot1.png" />i am satisfied</h5>
                                         <h6><img alt="" src="images/fe/Positive.png" />Positive feedback</h6>
                                         </div>
                                         <div class="right_feedback">
                                         <h6>Louise Albone<br /><span>11-09-2011</span></h6>
                                         <img alt="" src="images/fe/blue-star.png" /> <img alt="" src="images/fe/blue-star.png" /> <img alt="" src="images/fe/blue-star.png" /> <img alt="" src="images/fe/blue-star.png" /> <img alt="" src="images/fe/blue-star.png" />
                                         </div>
                                         <div class="spacer"></div>
                                   </div>
                                                      </div>
                                                </div>
                                   
                                   
                                   
                             </div>
                             <div class="spacer"></div>
                       </div> -->
                       
                     
                     <!--  <div class=" spacer"></div>
                        <div class="page">
                  <ul>
                  <li><a href="javascript:void(0);" class="select">1</a></li>
                   <li><a href="javascript:void(0);">2</a></li>
                    <li><a href="javascript:void(0);">3</a></li>
                     <li><a href="javascript:void(0);">4</a></li>
                      <li><a href="javascript:void(0);">5</a></li>
                      <li><a href="javascript:void(0);"> > </a></li>
                  </ul>
                  </div> -->
                  
                  <div id="trades_list">
                        <?php echo $tradesman_list ; ?>
                  </div>
                  
                  
                  <div class=" spacer"></div>
                              
                        </div>
                        <?php include_once(APPPATH."views/fe/common/buyer_left_menu.tpl.php"); ?>   
                        <div class="spacer"></div>
                  </div>
                  <div class="spacer"></div>
            </div>
            <div class="spacer"></div>
            <div class="bottom_part"></div>
      </div>

      
<!--Invite lightbox-->
<div class="lightbox03 photo_zoom03"> 
<div class="close"><a href="javascript:void(0)" onclick="hide_dialog()"><img src="images/fe/Close.png" alt="" /></a></div>
<h3><?php echo addslashes(t('Invite Tradesman')); ?></h3>
<p><?php echo addslashes(t('List of Active jobs for which you want to invite the Tradesman')); ?></p>

<form action="<?php echo base_url().'buyer/invite-tradesman' ?>" method="post" name="frm_invite_req" id="frm_invite_req">

<div class="error_massage" style="display: none;" id="err_no_chk"></div>
<div id="job_listing"></div>

</form>
</div>
<!--Invite lightbox-->