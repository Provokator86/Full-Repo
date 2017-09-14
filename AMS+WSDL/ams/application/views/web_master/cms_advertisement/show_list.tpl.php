<?php 
/***
File Name: cms_advertisement show_list.tpl.php 
Created By: SWI Dev 
Created On: October 09, 2015 
Purpose: CURD for Cms Advertisement 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        maxDate:0
    })
    $('.datepicker_mask').mask('99/99/9999');
    
    //Admin change status by ajax//
    $("a[id^='stat_chnage_id_']").click(function(){
        var arr_arg,temp_id,temp_class;
        temp_class=$(this).attr('class');
        temp_id = $(this).attr('id');
        arr_arg = temp_id.split('_');
        var i_status   = (arr_arg[4]=="active")?"Active":"Inactive";
    
        $.ajax({
                type: "POST",
                async: false,
                url: g_controller+'ajax_change_status',
                data: "i_status="+i_status+"&h_id="+arr_arg[3]+"&class="+temp_class,
                success: function(msg){           
                    if(msg == "ok")
                    {
                       if(i_status=='Active')
                        {
                            $("span[id='status_row_id_"+arr_arg[3]+"']").text("Active") ;
                            $("span[id='status_row_id_"+arr_arg[3]+"']").addClass("label-success");
                            $("#"+temp_id).attr('id','stat_chnage_id_'+arr_arg[3]+'_inactive');
                            
                            var newId = 'stat_chnage_id_'+arr_arg[3]+'_inactive';
                            $("#"+newId).removeClass('glyphicon glyphicon-ban-circle');
                            $("#"+newId).addClass('glyphicon glyphicon-ok');
                            $("#"+newId).attr('data-toggle','tooltip');
                            $("#"+newId).attr('data-placement','bottom');
                            $("#"+newId).attr('data-original-title','Make Inactive');
                            window.location.reload();
                        }
                        else
                        {
                            $("span[id='status_row_id_"+arr_arg[3]+"']").text("Inactive");
                            $("span[id='status_row_id_"+arr_arg[3]+"']").removeClass("label-success");
                            $("span[id='status_row_id_"+arr_arg[3]+"']").addClass("label-warning");
                            $("#"+temp_id).attr('id','stat_chnage_id_'+arr_arg[3]+'_active');
                            
                            var newId = 'stat_chnage_id_'+arr_arg[3]+'_active';
                            
                            $("#"+newId).removeClass('glyphicon glyphicon-ok');
                            $("#"+newId).addClass('glyphicon glyphicon-ban-circle');
                            $("#"+newId).attr('data-toggle','tooltip');
                            $("#"+newId).attr('data-placement','bottom');
                            $("#"+newId).attr('data-original-title','Make Active');
                            window.location.reload();
                        }
                   }
                }
           });
    });
    //Admin change status by ajax//
    
})
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info collapsed-box">
            <div class="box-header">
                <i class="fa fa-search"></i>
                <h2 class="box-title"><?php echo addslashes(t("Search"))?></h2>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>                                 
            </div>

            <div class="box-body">
                <?php show_all_messages(); ?>
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="get" action="<?php echo $search_action?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                </form>
        
                <form class="" id="frm_search_2" name="frm_search_2" method="get" action="" >
                    <input type="hidden" id="h_search" name="h_search" value="advanced" />        
                    <div id="div_err_2"></div>        
                    <div class="row">  
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Created Date From</label>
                                <input type="text" name="dt_from" id="dt_from" value="<?php echo $dt_from?>" class="form-control datepicker" />
                            </div>
                        </div>                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Created Date To</label>
                                <input type="text" name="dt_to" id="dt_to" value="<?php echo $dt_to?>" class="form-control datepicker" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search"))?></button>                 
                        <button type="button" id="btn_srchall" name="btn_srchall" class="btn btn-warning"><?php echo addslashes(t("Show All"))?></button>
                    </div>
                </form>
            </div>   
                           
        </div>
        <?php echo $table_view;?><!-- content ends -->
    </div>
</div>
