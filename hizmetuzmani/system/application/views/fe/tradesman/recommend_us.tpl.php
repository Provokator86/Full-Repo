<script type="text/javascript">
// start document ready
$(document).ready(function() {
    var cnt_recommend   =   3;
    $("#add_more").click(function(){
       
        cnt_recommend++;
        $('<div class="lable"><?php echo addslashes(t('Name')); ?></div><div class="textfell"><input name="txt_name[]" id="txt_name_'+cnt_recommend+'" type="text" /></div><div class="lable"><?php echo addslashes(t('Email')); ?></div><div class="textfell"><input name="txt_email[]" id="txt_email_'+cnt_recommend+'" type="text" /></div><div class="err" id="err_recommend_'+cnt_recommend+'"></div> <div class="spacer"></div> ').insertBefore('#add_before');
        
        if(cnt_recommend==5)
        {
            $("#add_more").remove();    
        }
        
    })  ;
    
    $("#btn_recommend").click(function(){
          var b_valid   =   true ;
          var reg_email     = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/; 
          var email_address =   '';
        for(var i=1;i<=cnt_recommend;i++)
        {
            if($("#txt_name_"+i).val()!='')
            {
               
                email_address   =   $.trim($("#txt_email_"+i).val()) ;
                if(email_address=='')
                {
                    $("#err_recommend_"+i).html('<?php echo addslashes(t('please provide an email address')); ?>').slideDown(1000);
                    b_valid =   false ;
                }
                else if(reg_email.test(email_address) == false)
                {
                    $("#err_recommend_"+i).html('<?php echo addslashes(t('please provide a proper email address')); ?>').slideDown(1000);
                    b_valid =   false ;
                }
                else
                {
                    $("#err_recommend_"+i).html('').slideUp(1000);
                
                }
            }

        }
        if(b_valid==true)
        {
           
            $("#frm_recomend").submit();
        }
        
    })  ;
    
});
</script>
 <?php include_once(APPPATH."views/fe/common/breadcrumb.tpl.php"); ?>     
<div class="job_categories">
            <div class="top_part"></div>
            <div class="midd_part height02">
                  <div class="username_box">
                        <div class="right_box03">
                        <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>    
                              <h4><?php echo addslashes(t('Recommend Us')); ?></h4>
                              <div class="div01">
                                    <p><?php echo addslashes(t('We hope this platform will make life easier for you')).','.addslashes(t('we are pretty sure you would want the same for your family')).','.addslashes(t('friends and neighbours')).addslashes(t('Please Recommend us')).'!' ; ?></p>
                                    <div class="spacer"></div>
                              </div>
                              <div class="filter_option_box">
                                <form action="" method="post" name="frm_recomend" id="frm_recomend" >
                                    <div class="lable"><?php echo addslashes(t('Name')); ?></div>
                                    <div class="textfell">
                                          <input name="txt_name[]" id="txt_name_1" type="text" value="" />
                                    </div>
                                    <div class="lable"><?php echo addslashes(t('Email')); ?></div>
                                    <div class="textfell">
                                          <input name="txt_email[]" id="txt_email_1" type="text" value="" />
                                    </div>
 
                                    <div class="err" id="err_recommend_1"></div>  
                                    <div class="spacer"></div>
                                    
                                    
                                     <div class="lable"><?php echo addslashes(t('Name')); ?></div>
                                    <div class="textfell">
                                          <input name="txt_name[]" id="txt_name_2" type type="text" value="" />
                                    </div>
                                    <div class="lable"><?php echo addslashes(t('Email')); ?></div>
                                    <div class="textfell">
                                          <input name="txt_email[]" id="txt_email_2" type="text" value="" />
                                    </div>
                                    <div class="err" id="err_recommend_2"></div> 
                                    <div class="spacer"></div>
                                    
                                     <div class="lable"><?php echo addslashes(t('Name')); ?></div>
                                    <div class="textfell">
                                          <input name="txt_name[]" id="txt_name_3" type type="text" value="" />
                                    </div>
                                    <div class="lable"><?php echo addslashes(t('Email')); ?></div>
                                    <div class="textfell">
                                          <input name="txt_email[]" id="txt_email_3" type="text" value="" />
                                    </div>
                                    <div class="err" id="err_recommend_3"></div> 
                                    <div class="spacer"></div>
                                   
                                    <div class="lable" id="add_before"></div>
                                    <input type="button" value="<?php echo addslashes(t('Recommend')); ?>" id="btn_recommend" name="btn_recommend" class="small_button flote05" />
                                   
                                    <h6><a href="javascript:void(0);" id="add_more"><?php echo addslashes(t('Add more')); ?></a></h6>
                                    <div class="spacer"></div>
                                    </form>
                              </div>
                              <h4><?php echo addslashes(t('Referral History')); ?></h4>

                                          <div id="recommend_list" >
                                                  <?php echo $recommend_list ; ?>
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
