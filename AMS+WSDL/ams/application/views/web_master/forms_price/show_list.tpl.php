<?php 
/***
File Name: forms_price show_list.tpl.php 
Created By: SWI Dev 
Created On: Jan 18, 2017
Purpose: CURD for manage_forms 
*/
?>
<!-- Noti -->
<!--
<link href="<?php echo r_path('js/plugins/noty/noty_theme_default.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo r_path('js/plugins/noty/jquery.noty.css')?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>resource/web_master/js/plugins/noty/jquery.noty.js" type="text/javascript"></script>
-->
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
	
	//Click reset//
	
	   $("#reset_forms_counter").click(function(e){
		   
	   		e.preventDefault();
			$("#error_massage").hide();
			$('#myModal_reset').modal('show');
			var temp_id = $(this).attr('value');
	        
			$('#btn_reset_yes').click(function(){
				$.ajax({
					type: "POST",
					async: false,
					url: g_controller+'ajax_reset_forms_counter',
					data: "temp_id="+temp_id,
					success: function(msg){
                        window.location.reload(true);
					   
					}
			   });
			});
	
	   });
	
	//end Click reset//

	
      
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
                                <label class=""><?php echo addslashes(t("Form Category"))?></label>
                                <input type="text" name="form_category" id="form_category" value="<?php echo $form_category?>" class="form-control" />
                            </div>
                        </div>   
                                                
                    </div>
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
    
<!-- Modal box -->
<div class="modal fade"  id="myModal_reset">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3 class="text-yellow"><?php echo addslashes(t("Confirmation"))?></h3>
        </div>
        <div class="modal-body">
            <p>Are you sure to reset the counter?</p>
        </div>
        <div class="modal-footer">
            <a href="javascript:" class="btn btn-success" id="btn_reset_yes"><?php echo addslashes(t("Yes"))?></a>
            <a href="javascript:" class="btn btn-danger" id="btn_reset_no" data-dismiss="modal"><?php echo addslashes(t("No"))?></a>
        </div>
	  </div>
	</div>
</div>
