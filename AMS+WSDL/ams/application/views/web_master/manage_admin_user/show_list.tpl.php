<!-- Noti -->
<link href="<?php echo r_path('js/plugins/noty/noty_theme_default.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo r_path('js/plugins/noty/jquery.noty.css')?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>resource/web_master/js/plugins/noty/jquery.noty.js" type="text/javascript"></script>
<!-- End -->
<script type="text/javascript">
$(document).ready(function(){
    var g_controller="<?php echo $this->pathtoclass;?>"; //controller Path

    //Submitting the form//                                            
    $("#btn_submit").click(function(){
        var formid=$(this).attr("search");	
        $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
        $("#frm_search_"+formid).submit(); 
    });                                              
    //Submitting the form//

    //Submitting the form2//
    $("#frm_search_2").submit(function(){
        var b_valid = true, s_err="";
        $("#frm_search_2 #div_err_2").hide("slow"); 
        //validating//
        if(!b_valid)
            $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        return b_valid;
    });    
    //end Submitting the form2//

    //Submitting search all//
    $("#btn_srchall").click(function(){
        $("#frm_search_3").submit();
    });
    //end Submitting search all//  
    
    $('.ajax').colorbox({maxWidth:'95%', maxHeight:'95%'});   
    
    /*----  For changing sorting order[start] ---------------------*/
    /*
        $('.box table').attr('id','tableSort');
        $("#tableSort").tableDnD({
            onDrop: function(table, row) {            
                //var sortIdArr = $.tableDnD.serialize();
                var sortIdArr    =    $('#tableSort').tableDnDSerialize();
                //console.log(sortIdArr);
                $.ajax({
                   type: "POST",
                   url: g_controller + 'ajax_change_order/',
                   data:  sortIdArr,
                   success: function(msg)    
                   {
                        $.noty.closeAll()
                        noty({"text":'<?php echo get_message('save_success')?>', "layout":"bottomRight","type":'success'});
                   }
                });
            }
        });
        
    */
     /*----  For changing sorting order[end] ---------------------*/  
     
     
    $("a[id^='front_img_id_']").click(function(){
        var arr_arg,temp_id,temp_class;
        temp_class=$(this).attr('class');
        temp_id = $(this).attr('id');
        arr_arg = temp_id.split('_');
        var i_status   = (arr_arg[4]=="active")?1:0;
    
        $.ajax({
                type: "POST",
                async: false,
                url: g_controller+'ajax_change_display_status',
                data: "i_status="+i_status+"&h_id="+arr_arg[3]+"&class="+temp_class,
                success: function(msg){           
                    if(msg == "ok")
                    {
                       if(i_status)
                        {
                            $("span[id='display_row_id_"+arr_arg[3]+"']").text("<?php echo addslashes(t('Display in Frontend')) ?>") ;
                            $("span[id='display_row_id_"+arr_arg[3]+"']").addClass("label-success");
                            $("#"+temp_id).attr('id','front_img_id_'+arr_arg[3]+'_inactive');
                            
                            var newId = 'front_img_id_'+arr_arg[3]+'_inactive';
                            $("#"+newId).removeClass('glyphicon glyphicon-eye-close');
                            $("#"+newId).addClass('glyphicon glyphicon-eye-open');
                            $("#"+newId).attr('data-toggle','tooltip');
                            $("#"+newId).attr('data-placement','bottom');
                            $("#"+newId).attr('data-original-title','Remove Display Frontend');
                            $("#"+newId).attr('title','Remove Display Frontend');
                        }
                        else
                        {
                            $("span[id='display_row_id_"+arr_arg[3]+"']").text("<?php echo addslashes(t('No Display in Frontend')) ?>");
                            $("span[id='display_row_id_"+arr_arg[3]+"']").removeClass("label-success");
                            $("span[id='display_row_id_"+arr_arg[3]+"']").addClass("label-warning");
                            $("#"+temp_id).attr('id','front_img_id_'+arr_arg[3]+'_active');
                            
                            var newId = 'front_img_id_'+arr_arg[3]+'_active';
                            
                            $("#"+newId).removeClass('glyphicon glyphicon-eye-open');
                            $("#"+newId).addClass('glyphicon glyphicon-eye-close');
                            $("#"+newId).attr('data-toggle','tooltip');
                            $("#"+newId).attr('data-placement','bottom');
                            $("#"+newId).attr('data-original-title','Display Frontend');
                            $("#"+newId).attr('title','Display Frontend');
                        }
                   }
                }
           });
    });
     
});
</script>
<style type="text/css">
a.cnt_link:hover{ text-decoration: underline !important;}
</style>
<div class="row">
    <div class="col-md-12">
        <?php show_all_messages(); ?>
        <div class="box box-info collapsed-box">
			<div class="box-header" data-original-title>
                <i class="fa fa-search"></i>
				<h2 class="box-title"><?php echo addslashes(t("Search"))?></h2>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
			</div>
            <div class="box-body">
                <form id="frm_search_2" name="frm_search_2" method="get" action="" >
                <input type="hidden" id="h_search" name="h_search" value="advanced" /> 
                <input type="hidden" name="alphabate_pagination" id="alphabate_pagination" value="<?php echo $alphabate_pagination?>"/>               
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("User Name"))?></label>

                        <input type="text" name="s_user_name" id="s_user_name" value="<?php echo $s_user_name?>" class="form-control" />
                    </div>
                </div>   
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("User Email"))?></label>

                        <input type="text" name="s_user_email" id="s_user_email" value="<?php echo $s_user_email?>" class="form-control" />
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label><?php echo addslashes(t("User Role"))?></label>
                        <select class="form-control" name="role_id" data-rel="chosen" data-placeholder="Select Role">
                            <option value="">Select Role</option>
                            <?php echo makeOption($user_type, $role_id)?>
                        </select>
                    </div>
                </div> 
                
                </form> 
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="get" action="<?php echo $search_action ?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                 </form> 
            </div>
            <div class="box-footer">
                <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>

                <button type="button" id="btn_srchall" name="btn_srchall" class="btn btn-warning"><?php echo addslashes(t("Show All"))?></button>
            </div>
        </div>
       <?php  echo $table_view;?>
        <!-- content ends -->
    </div>
</div>
