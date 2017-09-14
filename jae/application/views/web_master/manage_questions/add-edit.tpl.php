<?php 
/***
File Name: manage_questions add-edit.tpl.php 
Created By: SWI Dev 
Created On: Sept 11, 2017
Purpose: CURD for manage_questions
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type"text/javascript">
$(document).ready(function(){
	
	$("#btn_cancel_ex").click(function(){
		window.location.href = base_url+'web_master/manage_examination/show_list';
	});
	
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
        
		if($("#s_question_0").val()=='')
		{
			markAsError($("#s_question_0"),'Please provide at least one question');
			b_valid = false;
		}
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
    });

	// delete questions answer
	$(".fa-trash").each(function(){
		$(this).click(function(){
			var _this = $(this);
			var _id = $(this).attr('data-id');
			//e.preventDefault();
			$("#error_massage").hide();
			$('#myModal_qa_delete').modal('show');
			$('#btn_qa_yes').click(function(){
				$('#myModal_qa_delete').modal('hide');
				if($(".fa-trash").length > 1)
				{
					_this.parent().remove();
				}
				else
					alert('You can not delete this');
			});
		});
	});
	
});
</script>

<div class="row">
<div class="col-md-12">
	<div class="box box-info">
		<?php show_all_messages(); echo validation_errors();?>
		<div class="box-header">
			<i class="fa fa-edit"></i>
			<h3 class="box-title"><?php echo $heading;?></h3>
		</div>
		<!-- form start -->
		<form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off"  enctype="multipart/form-data">
		<input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
		<input type="hidden" id="h_exam_id" name="h_exam_id" value="<?php echo $sess_exam_id;?>">
		
			 <div class="box-body">
				 
				<?php 
				if($mode=='add') {
					// already exist data
					for($k=0; $k <count($qa_set); $k++)
					{
				?>	
				<div class="main_div">					
					
				<a tabindex=-1 style="position:absolute; right:300px; color:#ff0000;" data-id="<?php echo $qa_set[$k]['i_id']?>" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Delete Question" class="fa fa-trash" data-original-title="Delete Question"></a> 
				
				<div class="row">   
					<div class="col-md-8">
						<div class="form-group">
						<label for="focusedInput">Question <?php echo $k+1; ?></label>							
							<textarea rows="2"class="form-control" id="s_question_<?php echo $k; ?>" name="s_question[]" ><?php echo $qa_set[$k]["s_question"];?></textarea>							
							
							<span class="text-danger"></span>
							
						</div>
					</div>	                    
				</div>           
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">A: </label>
							<input class="form-control" id="s_option1_<?php echo $k; ?>" name="s_option1[]" value="<?php echo $qa_set[$k]["s_option1"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">B: </label>
							<input class="form-control" id="s_option2_<?php echo $k; ?>" name="s_option2[]" value="<?php echo $qa_set[$k]["s_option2"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>       
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">C: </label>
							<input class="form-control" id="s_option3_<?php echo $k; ?>" name="s_option3[]" value="<?php echo $qa_set[$k]["s_option3"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">D: </label>
							<input class="form-control" id="s_option4_<?php echo $k; ?>" name="s_option4[]" value="<?php echo $qa_set[$k]["s_option4"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>
				
				</div>			          
				<?php
					}
				// new entry form here
				for($i=0; $i < $number_set ; $i++) { 
					$inc = $k+$i+1;					
				?>      
				<div class="main_div">  				
					
				<a tabindex=-1 style="position:absolute; right:300px; color:#ff0000;" data-id="" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Delete Question" class="fa fa-trash" data-original-title="Delete Question"></a> 
				   
					 
				<div class="row">   
					<div class="col-md-8">
						<div class="form-group">
						<label for="focusedInput">Question <?php echo $inc; ?></label>
							<!--<input class="form-control" id="s_question_<?php echo $inc; ?>" name="s_question[]" value="<?php echo $posted["s_question"][$inc];?>" type="text" />-->
							<textarea rows="2"class="form-control" id="s_question_<?php echo $inc; ?>" name="s_question[]" ><?php echo $posted[$inc]["s_question"];?></textarea>
							<span class="text-danger"></span>
						</div>
					</div>	                    
				</div>           
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">A: </label>
							<input class="form-control" id="s_option1_<?php echo $inc; ?>" name="s_option1[]" value="<?php echo $posted["s_option1"][$inc];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">B: </label>
							<input class="form-control" id="s_option2_<?php echo $inc; ?>" name="s_option2[]" value="<?php echo $posted["s_option2"][$inc];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>       
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">C: </label>
							<input class="form-control" id="s_option3_<?php echo $inc; ?>" name="s_option3[]" value="<?php echo $posted["s_option3"][$inc];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">D: </label>
							<input class="form-control" id="s_option4_<?php echo $inc; ?>" name="s_option4[]" value="<?php echo $posted["s_option4"][$inc];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>
				
				</div>
				<?php } 
				} // end if 
				
				else if( $mode=='edit'){
					for($i=0; $i < $number_set ; $i++) { 
				?>     
				<div class="main_div">  				
					
				<a tabindex=-1 style="position:absolute; right:300px; color:#ff0000;" data-id="<?php echo $posted[$i]['i_id']?>" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Delete Question" class="fa fa-trash" data-original-title="Delete Question"></a> 
				
					        
				<div class="row">   
					<div class="col-md-8">
						<div class="form-group">
						<label for="focusedInput">Question <?php echo $i+1; ?></label>
							<!--<input class="form-control" id="s_question_<?php echo $i; ?>" name="s_question[]" value="<?php echo $posted[$i]["s_question"];?>" type="text" />-->
							<textarea rows="2"class="form-control" id="s_question_<?php echo $i; ?>" name="s_question[]" ><?php echo $posted[$i]["s_question"];?></textarea>
							<span class="text-danger"></span>
						</div>
					</div>	                    
				</div>           
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">A: </label>
							<input class="form-control" id="s_option1_<?php echo $i; ?>" name="s_option1[]" value="<?php echo $posted[$i]["s_option1"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">B: </label>
							<input class="form-control" id="s_option2_<?php echo $i; ?>" name="s_option2[]" value="<?php echo $posted[$i]["s_option2"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>       
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">C: </label>
							<input class="form-control" id="s_option3_<?php echo $i; ?>" name="s_option3[]" value="<?php echo $posted[$i]["s_option3"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">D: </label>
							<input class="form-control" id="s_option4_<?php echo $i; ?>" name="s_option4[]" value="<?php echo $posted[$i]["s_option4"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>
				
				</div>
				<?php } 
				if(! $number_set ) { 
						$i = 0;
				?> 					
					   
				<div class="main_div">  				
					
				<a tabindex=-1 style="position:absolute; right:300px; color:#ff0000;" data-id="<?php echo $posted[$i]['i_id']?>" href="javascript:void(0);" data-toggle="tooltip" data-placement="bottom" title="Delete Question" class="fa fa-trash" data-original-title="Delete Question"></a> 
				
					        
				<div class="row">   
					<div class="col-md-8">
						<div class="form-group">
						<label for="focusedInput">Question <?php echo $i+1; ?></label>
							<!--<input class="form-control" id="s_question_<?php echo $i; ?>" name="s_question[]" value="<?php echo $posted[$i]["s_question"];?>" type="text" />-->
							<textarea rows="2"class="form-control" id="s_question_<?php echo $i; ?>" name="s_question[]" ><?php echo $posted[$i]["s_question"];?></textarea>
							<span class="text-danger"></span>
						</div>
					</div>	                    
				</div>           
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">A: </label>
							<input class="form-control" id="s_option1_<?php echo $i; ?>" name="s_option1[]" value="<?php echo $posted[$i]["s_option1"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">B: </label>
							<input class="form-control" id="s_option2_<?php echo $i; ?>" name="s_option2[]" value="<?php echo $posted[$i]["s_option2"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>       
				
				<div class="row">   
					<div class="col-md-1">
						<div class="form-group">		                    
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">C: </label>
							<input class="form-control" id="s_option3_<?php echo $i; ?>" name="s_option3[]" value="<?php echo $posted[$i]["s_option3"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	  
					<div class="col-md-3">
						<div class="form-group">
						<label for="focusedInput">D: </label>
							<input class="form-control" id="s_option4_<?php echo $i; ?>" name="s_option4[]" value="<?php echo $posted[$i]["s_option4"];?>" type="text" />
							<span class="text-danger"></span>
						</div>
					</div>	                       
				</div>
				
				</div>
				
				<?php } } ?>
			 </div>
				
			 <div class="box-footer">
				<input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="Save Changes">
				<input type="button" id="btn_cancel_ex" name="btn_cancel" class="btn" value="Cancel">
			</div>
		</form>
	</div>
</div>
</div><!--/row-->


<div class="modal fade"  id="myModal_qa_delete">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3 class="text-yellow">Confirmation</h3>
        </div>
        <div class="modal-body">
            <p><?php echo get_message("confirmation")?>?</p>
        </div>
        <div class="modal-footer">
            <a href="javascript:void(0);" class="btn btn-success" id="btn_qa_yes">Yes</a>
            <a href="javascript:void(0);" class="btn btn-danger" id="btn_qa_no" data-dismiss="modal">No</a>
        </div>
	  </div>
	</div>
</div>
