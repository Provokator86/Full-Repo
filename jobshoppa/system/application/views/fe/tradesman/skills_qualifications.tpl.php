<script type="text/javascript">
$(document).ready(function(){
     
$("input[name='txt_time']").datepicker({dateFormat: 'yy-M-dd',
                                               changeYear: true,
											   yearRange: "-100:+0",
                                               changeMonth:true,
											    minDate: 0,												
												beforeShow: function(input, inst) {$('#ui-datepicker-div div').show()}
                                              });//DOB    


$('#ui-datepicker-div').hide();  

var g_controller="<?php echo $pathtoclass;?>";//controller Path 

$('input[id^="btn_cancel"]').each(function(i){
   $(this).click(function(){
       //$.blockUI({ message: 'Just a moment please...' });
       window.location.href=g_controller;
   }); 
});      
    
$('input[id^="btn_save"]').each(function(i){
   $(this).click(function(){
      //$.blockUI({ message: 'Just a moment please...' });
       $("#frm_edit_profile").submit();
       //check_duplicate();
   }); 
});    

/*** generate category dropdown ***/
        var max_allow_open = 3
        
        var cnt = parseInt(<?php echo ($posted[cnt_opt_cat])?$posted[cnt_opt_cat]:1 ?>);  
        
              $("#red_link").click(function(){
                 

            var sel_cat=$("#category_div_"+cnt).html();

            $("#category_div_"+cnt).after('<div id="category_div_'+(cnt+1)+'" style="padding: 5px;"></div>');
            
            $("#category_div_"+(cnt+1)).append(sel_cat)  ;
            $("#category_div_"+(cnt+1)+" select").val('')  ;   
            cnt++;
            if(cnt>=max_allow_open)
            
            {
                $("#red_link").remove();
            }
        });
            
            

    /*** end generate category ***/
    
    
///////////Submitting the form/////////
$("#frm_edit_skill").submit(function(){    
    var b_valid=true;
    var s_err="";
    if($.trim($("#txt_skills").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please add your skills.</strong></div>';
        b_valid=false;
    }
    if($.trim($("#txt_qualification").val())=="") 
    {
        s_err +='<div class="error_massage"><strong>Please provide qualifications, or any type of experience
.</strong></div>';
        b_valid=false;
    }

    /////////validating//////
    if(!b_valid)
    {
       // $.unblockUI();  
        $("#div_err").html(s_err).show("slow");
    }
    
    return b_valid;
}); 


///////////end Submitting the form///////// 
    /*$('#btn_reg').click(function(){
        $("#form_buyer_reg").submit();
    }); */

});


</script>

      
<div id="banner_section">
    <?php
    include_once(APPPATH."views/fe/common/header_top.tpl.php");
    ?>
</div>
<!-- /BANNER SECTION -->
<!-- SERVICES SECTION -->
    <?php
    include_once(APPPATH."views/fe/common/common_search.tpl.php");
    ?>
<!-- /SERVICES SECTION -->
<!-- CONTENT SECTION -->
<div id="content_section">
<div id="content">
    <?php
    //include_once(APPPATH."views/fe/common/message.tpl.php");
    ?>
     <div id="div_err">
             <?php include_once(APPPATH.'views/fe/common/message.tpl.php'); ?>   
                     <?php
                        //show_msg("error");  
                        echo validation_errors();
                        //pr($posted);
                    ?>
             </div>
        <div id="inner_container02">
            <div class="title">
                <h3><span>My Skills </span> &amp; Qualifications</h3>
            </div>
            <div class="clr"></div>
            <h6>&nbsp;</h6>
            <div class="clr"></div>
            <div id="account_container">
            <div class="account_left_panel">
                    <div class="round_container">
                        <div class="top">&nbsp;</div>
                        <div class="mid" style="min-height:918px;">
                            <p style="text-align:right; padding-right:10px;"><span class="red_txt">*</span> Required field</p>
                            <div id="form_box01">
                            <form name="frm_edit_skill" id="frm_edit_skill" method="post" action="" >
                                <div class="label03">Skills <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <input name="txt_skills" id="txt_skills" value="<?php echo $posted["txt_skills"] ?>" type="text" size="48" /> 
                                </div>
                                <div class="clr"></div>
                                <div class="label03">Qualifications <span class="red_txt">*</span> :</div>
                                <div class="field03">
                                    <textarea cols="60" rows="10" name="txt_qualification" id="txt_qualification"><?php echo $posted["txt_qualification"] ?></textarea>
                                </div>
                                <div class="clr"></div>
                                <div class="label03">&nbsp;</div>
                                <div class="field03">
                                    <input type="submit" value="Save" />
                                    <input type="reset" value="Cancel" />
                                </div>
                                <div class="clr"></div>
                                </form>
                            </div>
                            
                        </div>
                        <div class="bot">&nbsp;</div>
                    </div>
                </div>
            <?php include_once(APPPATH.'views/fe/common/tradesman_right_menu.tpl.php'); ?> 
            </div>
            <div class="clr"></div>
        </div>         
        
        <div class="clr"></div>
</div>
</div>      
    