<?php 
/***
File Name: form_details show_list.tpl.php 
Created By: SWI Dev 
Created On: June 6, 2016 
Purpose: CURD for form_details 
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
    
    $("#btn_dwnld").click(function(){
		window.location.href = g_controller+'view_detail/1';
	});    
   
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
								<label for="focusedInput">Payer TIN</label>
								<input type="text" class="form-control" id="s_payer_tin" name="s_payer_tin" value="<?php echo $s_payer_tin;?>" />
                            </div>
                        </div>   
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Name</label>
                                <input type="text" name="s_first_payer_name_line" id="s_first_payer_name_line" value="<?php echo $s_first_payer_name_line?>" class="form-control" />
                            </div>
                        </div>                       
                        
                        <div class="col-md-3">                            
                        </div>
                    </div>
<!--
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Date From</label>
                                <input type="text" name="dt_from" id="dt_from" value="<?php echo $dt_from?>" class="form-control datepicker" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Date To</label>
                                <input type="text" name="dt_to" id="dt_to" value="<?php echo $dt_to?>" class="form-control datepicker" />
                            </div>
                        </div>
                    </div>
-->
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
