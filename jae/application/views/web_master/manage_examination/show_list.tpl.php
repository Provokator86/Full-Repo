<?php 
/***
File Name: examination show_list.tpl.php 
Created By: SWI Dev 
Created On: Sept 11, 2017
Purpose: CURD for Examination 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
<!--
 $(document).ready(function(){
        
        $('[id^="change_status_"]').click(function(event){
            event.preventDefault();
            var $this = $(this), pId = $this.attr('data-id'), status = $this.attr('status');
            $.ajax({
                url: g_controller+'ajax_change_status',
                data: 'pId='+pId+'&status='+status,
                type: 'post',
                dataType: 'json',
                success: function(res){
                    $this.parent().prev().html(res.status_html);
                    $this.removeClass('glyphicon-unchecked glyphicon-check').addClass(res.status_class);
                    $this.attr('status', res.status);
                }
            });
        });
        
        
        // generate pdf set
        $('[id^="generate_set_"]').click(function(event){
            event.preventDefault();
            var $this = $(this), pId = $this.attr('data-id');
             
            if(parseInt(pId) > 0)
            {
				//blockUI('Please wait for a while...');
				blockDownload();
				
				$.ajax({
					url: g_controller+'nap_generate_full_qaset',
					data: 'pId='+pId,
					type: 'post',
					dataType: 'json',
					success: function(res){
						//unblockUI();
						unblockDownload();
						//console.log(res.status+'=='+res.file_path);
						if(res.status == 'success')
						{
							//window.open(res.file_path,'Question Set', 'width=800, height=600');
							window.location.reload();
						}
						else
						{
							alert('No question exist for this examination.');
						}
					}
				});
			} 
            
        });
        
        
        // download pdf master 
        $('[id^="master_dwnld_pdf_"]').click(function(event){
            event.preventDefault();
            var $this = $(this), pId = $this.attr('data-id'), _set = $(this).attr('data-rel');
             
            if(parseInt(pId) > 0)
            {
				blockUI('Please wait for a while...');
				
				$.ajax({
					url: g_controller+'nap_download_master_qaset',
					data: 'pId='+pId+'&set='+_set,
					type: 'post',
					dataType: 'json',
					success: function(res){
						unblockUI();
						//console.log(res.status+'=='+res.file_path);
						if(res.status == 'success')
						{
							window.open(res.file_path,'Question Set', 'width=800, height=600');
						}
						else
						{
							alert('No question exist for this examination.');
						}
					}
				});
			} 
            
        });
        
        
        // download pdf  
        $('[id^="dwnld_pdf_"]').click(function(event){
            event.preventDefault();
            var $this = $(this), pId = $this.attr('data-id'), _set = $(this).attr('data-rel');
             
            if(parseInt(pId) > 0)
            {
				blockUI('Please wait for a while...');
				
				$.ajax({
					url: g_controller+'nap_download_qaset',
					data: 'pId='+pId+'&set='+_set,
					type: 'post',
					dataType: 'json',
					success: function(res){
						unblockUI();
						//console.log(res.status+'=='+res.file_path);
						if(res.status == 'success')
						{
							window.open(res.file_path,'Question Set', 'width=800, height=600');
						}
						else
						{
							alert('No question exist for this examination.');
						}
					}
				});
			} 
            
        });
        
        
		//Click create question//
		$("a[id^='create_set_']").each(function(i){	
		   $(this).click(function(e){
				e.preventDefault();
				$("#error_msg_qa_set").hide();
				$("#i_number").val('');
				$("#myModal_qa_set").modal("show");
				var exam_id = $(this).attr('data-id');
				$('#btn_set_yes').off('click');
				$('#btn_set_yes').click(function(){
					blockUI();
					var i_number = $("#i_number").val();
					var noReg		= /^\d+$/;       
					
					if (i_number && noReg.test(i_number))
					{
						$.ajax({
							type: "POST",
							async: false,
							dataType: 'json',
							url: g_controller+'ajax_set_number_of_qa/',
							data: "exam_id="+exam_id+"&i_number="+i_number,
							success: function(msg){
								unblockUI();
								console.log(msg.status+'==>'+msg.red_link);
								if(msg.status == 'success')
								{
									$("#myModal_qa_set").modal("hide");
									window.location.href = msg.red_link ;
								}
								else if(msg.status =='pass_qa')
								{
									$("#myModal_qa_set").modal("hide");
									window.location.href = msg.red_link ;
								}
								else if(msg.status =='no_qa')
								{
									//$("#myModal_qa_set").modal("hide");
									$("#error_msg_qa_set").text('Please provide at least a number.').show();
								}
								else
								{
									$("#error_msg_qa_set").text('Please provide the correct numbers').show();
								}
							 
							}
					   }); // end AJAX
				   }
				   else if(noReg.test(i_number) == false)
				   {
					   unblockUI();
					   $("#error_msg_qa_set").text('Please provide the numeric values only').show();
					   return false;
				   }
				   else
				   {
					   unblockUI();
					   $("#error_msg_qa_set").text('Please provide the numbers').show();
					   return false;
				   }
				   
				}); // CLICK ON YES END
		
		   });
		   
		});
		//end Click  create question//

 });
 -->
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info collapsed-box">
            <?php show_all_messages(); ?>
            <div class="box-header">
                <i class="fa fa-search"></i>
                <h3 class="box-title">Search</h3>    
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>                    
            </div>

            <div class="box-body">
                
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                </form>
        
                <form class="" id="frm_search_2" name="frm_search_2" method="post" action="" >
                    <input type="hidden" id="h_search" name="h_search" value="advanced" />        
                    <div id="div_err_2"></div>        
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
						<label class="">Name</label>
						<input type="text" name="s_name" id="s_name" value="<?php echo $s_name?>" class="form-control" />
					</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary">Search</button>                 
                        <button type="button" id="btn_srchall" name="btn_srchall" class="btn btn-warning">Show All</button>
                    </div>
                </form>
            </div>   
        </div>

        <?php echo $table_view;?><!-- content ends -->
    </div>
</div>

<!-- QUESTION SET BOX -->
<div class="modal fade"  id="myModal_qa_set">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3 class="text-yellow">Confirmation</h3>
        </div>
        <div class="modal-body">
			<div class="col-md-12">				
				<div class="row">                
					<div class="col-md-8">
						<div class="form-group">
						<label for="focusedInput">Number of questions you want to create<span class="text-danger">*</span></label>
							<input class="form-control only_numeric" id="i_number" name="i_number" value="" type="text" />
							<span class="text-danger" id="error_msg_qa_set"></span>
						</div>
					</div>
				</div>
			</div>
            
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-success" id="btn_set_yes">Yes</a>
            <a href="javascript:void(0);" class="btn btn-danger" id="btn_set_no" data-dismiss="modal">No</a>
        </div>
	  </div>
	</div>
</div>
