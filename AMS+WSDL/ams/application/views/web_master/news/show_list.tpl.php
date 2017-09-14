<?php 
/***
File Name: news show_list.tpl.php 
Created By: SWI Dev 
Created On: September 28, 2015 
Purpose: CURD for News 
*/
?>
<!-- Noti -->
<link href="<?php echo r_path('js/plugins/noty/noty_theme_default.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo r_path('js/plugins/noty/jquery.noty.css')?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>resource/web_master/js/plugins/noty/jquery.noty.js" type="text/javascript"></script>
<!-- End -->
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        maxDate:0
    })
    $('.datepicker_mask').mask('99/99/9999');
    
    /*----  For changing sorting order[start] ---------------------*/
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
     /*----  For changing sorting order[end] ---------------------*/  
});
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
                                <label class=""><?php echo addslashes(t("Title"))?></label>
                                <input type="text" name="s_title" id="s_title" value="<?php echo $s_title?>" class="form-control" />
                            </div>
                        </div>   
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?php echo addslashes(t("Author"))?></label>
                                <input type="text" name="s_author" id="s_author" value="<?php echo $s_author?>" class="form-control" />
                            </div>
                        </div>                       
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?php echo addslashes(t("Description"))?></label>
                                <input type="text" name="s_description" id="s_description" value="<?php echo $s_description?>" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Published Date From</label>
                                <input type="text" name="dt_from" id="dt_from" value="<?php echo $dt_from?>" class="form-control datepicker" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Published Date To</label>
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
