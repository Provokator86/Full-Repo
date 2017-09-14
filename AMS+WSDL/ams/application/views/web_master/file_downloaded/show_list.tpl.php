<?php 
/***
File Name: manage_forms show_list.tpl.php 
Created By: SWI Dev 
Created On: June 16, 2016 
Purpose: CURD for manage_forms 
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
	
	
// Change status
$(document).on('click', '.change_batch_status', function(e){
	var batch_id = $(this).attr('data-id'), _this = $(this);
	
	if(parseInt(batch_id))
	{
		$.ajax({
			url: g_controller+'ajax_fetch_batch_current_status',
			data:{batch_id:batch_id},
			type: 'post',
			dataType: 'json',
			success: function(response){
				
				unblockUI();
                if(response.status == 'success')
                {
					$('#status_change_comment').val('');
                    $('#status_dd').html('<label>Select Status</label><br>'+response.html); // Paste html status dd
                    $('#batch_status').chosen({width:'210px'}); // Call chosen
                    
                    // Show modal
                    e.preventDefault();
                    $('#my_modal_change_status').modal('show');
                    $('#btn_change_status').unbind('click').bind('click', function(){
						blockUI();
						var status = $('#batch_status').val(), comment = $('#status_change_comment').val(), st_text = $('#batch_status option:selected').text();
						$.ajax({
                            url: g_controller+'ajax_batch_change_status',
                            data:{batch_id:batch_id,status:status,comment:comment},
                            type: 'post',
                            dataType: 'json',
                            success: function(response){
								$('#my_modal_change_status').modal('hide');
								//console.log(response);
								unblockUI();
								if(response.status == 'success'){
                                    // Notify user
                                    $.noty.closeAll()
                                    noty({"text":response.msg,"layout":"bottomRight","type":response.status});
                                } else {
                                    // Notify user
                                    $.noty.closeAll()
                                    noty({"text":response.msg,"layout":"bottomRight","type":response.status,timeout: false});
                                }
							}
						});
					});
				}
			}
		});
	}
	//blockUI();
});
	
	
// download
$(document).on('click', '.dwn_ascii', function(e){
	var file_id = $(this).attr('data-id'), _this = $(this);
	
	if(parseInt(file_id))
	{
		$("#file_id").val(file_id);
		$("#frm_search_4").submit();
		/*$.ajax({
			url: g_controller+'ajax_get_downloaded',
			data:{file_id:file_id},
			type: 'post',
			dataType: 'json',
			success: function(response){
				//unblockUI();
				console.log(response);
				
			}
		});*/
	}
	//blockUI();
});

// View Details
$(document).on('click', '.file_view_detail', function(e){
	var batch_id = $(this).attr('data-id'), _this = $(this);
	
	if(parseInt(batch_id))
	{
		$.ajax({
			url: g_controller+'ajax_fetch_file_detail',
			data:{batch_id:batch_id},
			type: 'post',
			dataType: 'json',
			success: function(response){
				unblockUI();
                if(response.status == 'success')
                {
                    $('#modal_html').html(response.html); 
                    // Show modal
                    e.preventDefault();
                    $('#my_modal_detail').modal('show');
				}
			}
		});
	}
	//blockUI();
});
	
$(document).ready(function(){
	$('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        maxDate:0
    })
    $('.datepicker_mask').mask('99/99/9999');
    
    //$(".ajax").colorbox();

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
                <form class="form-horizontal" id="frm_search_4" name="frm_search_4" method="post" action="<?php echo $this->pathtoclass.'ajax_get_downloaded'?>" >
                    <input type="hidden" id="file_id" name="file_id" value="" />    
                </form>
                
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="get" action="<?php echo $search_action?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                </form>
        
                <form class="" id="frm_search_2" name="frm_search_2" method="get" action="" >
                    <input type="hidden" id="h_search" name="h_search" value="advanced" />        
                    <div id="div_err_2"></div>        
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?php echo addslashes(t("Batch Number"))?></label>
                                <input type="text" name="s_batch_id" id="s_batch_id" value="<?php echo $s_batch_id?>" class="form-control" />
                            </div>
                        </div>   
                        
                        <!--<div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?php echo addslashes(t("Status"))?></label>                                
                                <select class="form-control" name="i_status" id="i_status" data-rel="chosen">
									<option value="">Select</option>
									<?php echo makeOptionBatchStatus($i_status) ?>
                                </select>
                            </div>
                        </div>-->   
                                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Downloaded Date From</label>
                                <input type="text" name="dt_from" id="dt_from" value="<?php echo $dt_from?>" class="form-control datepicker" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Downloaded Date To</label>
                                <input type="text" name="dt_to" id="dt_to" value="<?php echo $dt_to?>" class="form-control datepicker" />
                            </div>
                        </div>
                                
                    </div>
                    <!--<div class="row">
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
                    </div>-->
                    
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

<!-- BATCH STATUS MODAL STARTS -->
<div class="modal fade" id="my_modal_change_status">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <h3 class="text-yellow"><?php echo t('Change Status')?></h3>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group" id="status_dd">
                        <label>Select Status</label>
                        <select name="batch_status" id="batch_status">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comment</label>
                        <textarea cols="45" rows="3" class="form-control" name="status_change_comment" id="status_change_comment"></textarea>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn_change_status">Change Status</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
        
    </div>
</div>

<!-- BATCH STATUS MODAL END -->

<!-- DETAIL MODAL STARTS -->
<div class="modal fade" id="my_modal_detail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <h3 class="text-yellow">View Details</h3>
            </div>
            <div class="modal-body">
                <div class="col-md-12" id="modal_html">
                    <div class="form-group">
                        <label>File Name</label>
                        <span id="file_name"></span>
                    </div>
                    <div class="form-group">
                        <label>Batch Numbers</label>
                        <span id="batch_numbers"></span>
                    </div>
                    <div class="form-group">
                        <label>Date Downloaded</label>
                        <span id="date_dwnld"></span>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>            
        </div>
        
    </div>
</div>
<!-- DETAIL MODAL END -->

