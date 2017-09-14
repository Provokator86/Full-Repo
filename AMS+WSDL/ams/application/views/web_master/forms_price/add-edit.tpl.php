<?php 
/***
File Name: forms_price add-edit.tpl.php 
Created By: SWI Dev 
Created On: Jan 18, 2017
Purpose: CURD for manage_forms 
* 
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';</script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo r_path('js/custom_js/add_more.js')?>"></script>

<script type="text/javascript">
	
// Allow only numeric value
$(document).on("keyup", '.num_val', function(){
    this.value = this.value.replace(/[^0-9\-]/g,'');  
    //this.value = this.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
});
// Allow decimal values only
$(document).on("keypress", '.dbl_val', function(){
      if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
        ((event.which < 48 || event.which > 57) &&
          (event.which != 0 && event.which != 8))) {
        event.preventDefault();
      }
      
});


$(document).off('click', 'a.remove_price_range');

$(document).on('click', 'a.remove_price_range', function(){
    var self = $(this), _parent = $(this).parent().parent(), rel = $(this).attr('rel');
    if($('a.remove_price_range[rel="'+rel+'"]').length > 1)
        _parent.remove(); // Remove this
    else // Reset this field
    {
        _parent.find('img').remove();
        _parent.find('input').val('');
        _parent.find('input[type="checkbox"]').removeAttr('checked');
    }
    
    // Delete the data from database    
    var id = $(this).attr('bus_id'); // new on 19 Jan, 2017
    
    if(id) // Continue
    {
        /*$.ajax({
            type: 'POST',
            url: picture_upload_path+'ajax_file_delete',
            data: {id:id,s_folder_number:s_folder_number},
            dataType : 'json',  
            success: function(response){
                // Notify user
                $.noty.closeAll()
                noty({"text":response.msg,"layout":"bottomRight","type":response.status});
            }
        });*/
    }
});

	
$(document).ready(function(){    
	
	// Add more pricxe range callback
    if(add_more_after_add_callback)
    {
        add_more_after_add_callback = function(_this)
        {
            _this.find('input').show().val('');
            
		}
	}	
	
        
    $("#frm_add_edit").submit(function(){		
        //return false; // for now		
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
		var form_price       = $.trim($("#d_form_price").val());
		//var priceReg = /((\d+)((\.\d{1,2})?))$/;
		var priceReg = /^[0-9]\d*(\.\d+)?$/;
        //var content = CKEDITOR.instances['s_description'].getData();
        
		if($("#form_category").val()==''){
			$("#err_form_category").html('Please select category');
			b_valid = false;
		}   
		else{
			$("#err_form_category").html('');
		}		
        if(!b_valid) {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
    
        return b_valid;
    });

});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
             <?php show_all_messages(); echo validation_errors();?>
                        
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title"><?php echo $heading;?></h3>
                </div>
                <!-- /.box-header -->
            
                <!-- form start -->
                
                <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off"  enctype="multipart/form-data">
                    <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>">
                    <div class="box-body">
                        <div class="row">                
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="focusedInput">Forms Category<span class="text-danger">*</span></label>
                                    <?php if($mode=='add'){ ?>
                                    <select name="form_category" id="form_category" class="form-control" data-rel="chosen">
										<option value="">Select</option>
										<option value="1099" <?php if($posted['form_category']=='1099'){ ?> selected="selected" <?php } ?> >1099</option>
										<option value="W2" <?php if($posted['form_category']=='W2'){ ?> selected="selected" <?php } ?>  >W2</option>
										<option value="941" <?php if($posted['form_category']=='941'){ ?> selected="selected" <?php } ?>  >941</option>
                                    </select>
                                    <span class="text-danger" id="err_form_category"></span>
                                    <?php } else { ?>
									<br><span style="font-weight:bold;"><?php echo $posted['form_category'];?></span>
									<input type="hidden" name="form_category" value="<?php echo $posted['form_category']; ?>" >
									<?php } ?>
                                </div>
                            </div>
                                                      
                        </div> 
                        
                        <!--<div class="row" id="div_next_add"> 
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="focusedInput">Start<span class="text-danger"></span></label><br/>
                                    <input class="form-control" id="start" name="start" value="1" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>                              
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="focusedInput">End<span class="text-danger"></span></label><br/>
                                    <input class="form-control" id="end" name="end" value="50" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>                              
                            <div class="col-md-3 ">
                                <div class="form-group">
                                    <label for="focusedInput">Price<span class="text-danger">*</span></label><br/>
                                    <input class="form-control" id="price" name="price" value="0.75" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>                       
						</div>
						
						<div class="col-md-3 ">
							<div class="form-group">
								<label for="focusedInput"><span class="text-danger"></span></label><br/>
								<a class="add_more" style="color:red;" href="javascript:void(0);">Click Here to Add More</a>
							</div>
						</div>  -->
						
						<?php 
						$i = 0; 
						do
						{
						?>
						<div class="row add-more-container" id="add_more_price_range_<?php echo $i?>>" style="padding-bottom: 10px;">
							
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    <label for="focusedInput">Start<span class="text-danger"></span></label><br/>
                                    <input class="form-control num_val" name="i_start[]" value="<?php echo $form_prices[$i]['i_start']?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>                              
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    <label for="focusedInput">End<span class="text-danger"></span></label><br/>
                                    <input class="form-control num_val"  name="i_end[]" value="<?php echo $form_prices[$i]['i_end']?$form_prices[$i]['i_end']:"";?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>                              
                            <div class="col-md-2 ">
                                <div class="form-group">
                                    <label for="focusedInput">Price<span class="text-danger"></span></label><br/>
                                    <input class="form-control dbl_val" name="d_price[]" value="<?php echo $form_prices[$i]['d_price']!='0.00'?$form_prices[$i]['d_price']:""?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>                              
                            
							<div class="col-md-2">
								<a style="display: inline-block; margin-top: 10px;" bus_id="<?php echo $form_prices[$i]['i_id']?>" rel="add_more_price_range_" id="" class="remove_price_range" href="javascript:;" title="Remove"><i class="glyphicon glyphicon-remove text-red"></i></a>
							</div>
							
						</div>
						
						<?php 
						$i++;
						} while($i<count($form_prices));
						?>
						<div class="row-fluid">
							<a class="add_more_link" onclick="addmore('add_more_price_range_');" rel="add_more_price_range_" style="margin-top:0px; display:inline-block;" href="javascript:;"><i class="glyphicon glyphicon-plus"></i> Add More</a>
						</div>
						
						
                        
                    </div>
                    
                    
                    
                    <div class="box-footer">
                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save changes"))?>">
                        <input type="button" id="btn_cancel" name="btn_cancel" class="btn" value="<?php echo addslashes(t("Cancel"))?>">
                    </div>
                </form>
            </div>
        </div>
    </div><!--/row-->
</div><!-- content ends -->
