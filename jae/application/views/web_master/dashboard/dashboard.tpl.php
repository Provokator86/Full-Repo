<script type="text/javascript">
<!--
var g_controller="<?php echo $pathtoclass;?>";
$(document).ready(function(e) {	
        //blockUI();
      
    
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
							if(msg.status == 'success')
							{
								$("#myModal_qa_set").modal("hide");
								window.location.href = msg.red_link ;
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
	
	// download pdf  
	$('[id^="dwnld_pdf_"]').click(function(event){
		event.preventDefault();
		var $this = $(this), pId = $this.attr('data-id');
		if(parseInt(pId) > 0)
		{
			blockUI('Please wait for a while...');
			
			$.ajax({
				url: base_url+'web_master/manage_examination/nap_download_zip_qaset',
				data: 'pId='+pId,
				type: 'post',
				dataType: 'json',
				success: function(res){
					unblockUI();
					if(res.status == 'success')
					{
						window.open(res.file_path,'Question Set', 'width=800, height=600');
					}
					else
					{
						alert('No pdf created for this examination.');
					}
				}
			});
		} 
		
	});
        
	
});
-->
</script>


<div class="row">
    <div class="col-md-12">
			
        <div class="box box-info">
            <?php show_all_messages(); ?>
            <div class="box-header">
                <i class="fa fa-dashboard"></i>
                <h3 class="box-title">Welcome <?php echo $admin_details['s_first_name'].' '.$admin_details['s_last_name'];?></h3>  
            </div>
			
			
			<div class="box-body">
				<div class="row">
					
					<div class="col-md-3">
						<div class="color_box blue-box">
							<div class="color_box_lt">
								<i class="fa fa-book" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo !empty($exam) ? count($exam) :0; ?></span>
								<em>Total Exams</em>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="color_box light-blue-box">
							<div class="color_box_lt">
								<i class="fa fa-question" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo ($total_questions) ? $total_questions :0; ?></span>
								<em>Total Questions</em>
							</div>
						</div>
					</div>		
								
                    <div class="col-md-6">
						<div class="shadow_back">
							<label style="font-size: 16px;">Active Examinations</label>
							<table border="0" cellpadding="2" cellspacing="2" width="100%" class="table table-bordered">	
								<tr>
									<th width="60%" align="center">Name</th>
									<th width="20%" align="center">Total Questions</th>
									<th width="20%" style="text-align: left;">Actions</th>
								</tr>    
								<?php 
								if(!empty($exam)){
									foreach($exam as $key => $val){
										$show_zip_icon = ($val['s_set1'] || $val['s_set2'] || $val['s_set3'] || $val['s_set4'] || $val['s_set5'] || $val['s_set6'] ) ? TRUE : FALSE;
								?>                        
								<tr>
									<td><?php echo $val['s_name']; ?></td>
									<td align="center"><?php echo _total_question($val['i_id']); ?></td>
									<td align="left">
										<a id="create_set_<?php echo $key ?>" data-id="<?php echo $val['i_id']?>" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Create Questions" class="glyphicon glyphicon-plus-sign big-icon" data-original-title="Create Questions"></a>&nbsp;
										<?php if($show_zip_icon) { ?> 
										<a id="dwnld_pdf_<?php echo $key ?>" data-id="<?php echo $val['i_id']?>" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Download Archive" class="fa fa-file-archive-o big-icon" data-original-title="Download Archive"></a>
										<?php } ?>
									</td>
								</tr> 
								<?php }
								} else {
								?>                       
								<tr>
									<td>N/A</td>
									<td align="right">-</td>
								</tr>  
								
								<?php } ?>                     
							</table>
						</div>
                    </div>
                    			
					
					<!--<div class="col-md-3">
						<div class="color_box green-box">
							<div class="color_box_lt">
								<i class="fa fa-check" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo $tt?$tt :0; ?></span>
								<em>Answer</em>
							</div>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="color_box light-green-box">
							<div class="color_box_lt">
								<i class="fa fa-download" aria-hidden="true"></i>
							</div>
							
							<div class="color_box_rt">
								<span><?php echo $tt ? $tt : 0; ?></span>
								<em>Set</em>
							</div>
						</div>
					</div>-->
					
					
				</div>
			</div>
			<!-- END OF BOXES -->
            
        <?php echo $table_view;?><!-- content ends -->
		</div>
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
