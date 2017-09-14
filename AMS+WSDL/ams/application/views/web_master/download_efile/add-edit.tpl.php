<?php
/*********
* Author: SWI
* Date  : 22 June 2016
* Modified By: 
* Modified Date:
* Purpose:
* Controller For Download eFile
* @package Content Management
* @subpackage Download_efile
* 
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/Download_efile/
*/
?>
<!-- BOOTSTRAP MULTISELECT JS & CSS -->
<script src="<?php echo base_url()?>resource/web_master/js/bootstrap-multiselect.js" type="text/javascript"></script>
<link href="<?php echo base_url()?>resource/web_master/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css">
<!-- BOOTSTRAP MULTISELECT JS & CSS -->
<style type="text/css">
.checkbox label, .radio label{
    padding-left: 0 !important;
}
button.multiselect.dropdown-toggle.btn.btn-default{        
        min-width: 200px;
        padding: 8px;
        background-color: #fff !important;
        text-align: left;
        max-width: 200px;
    }
    .caret{
        float: right;
        margin-top: 7px;
    }
    ul.multiselect-container.dropdown-menu{
        min-width: 200px;
        max-height:300px;
        overflow-y:scroll;
    }
    span.multiselect-selected-text{
        white-space: normal;
    }

</style>

<script language="javascript">

$(document).ready(function(){
	
	$(document).on("keyup", '.num_val', function(){
		this.value = this.value.replace(/[^0-9]/g,'');  
		//this.value = this.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
	});

    var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
        
    $('#btn_cancel').click(function(i){
	     window.location.href=g_controller; 
    });   

    $('.btn-close').click(function(i){
	     window.location.href=g_controller; 
    });

    $('#btn_save').click(function(){
       //check_duplicate();
       $("#frm_add_edit").submit();
    });    
    
    // multiselect option dropdown
    $('#s_batch_id').multiselect({
            includeSelectAllOption: true,
            disableIfEmpty: true
    });
    
    // submitting the form
    
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err="";
        $("#div_err").hide("slow"); 
	    
	   var batchid = $("#s_batch_id").val() || '';
	    
	    if(batchid=='')
		{			
			$("#err_s_batch_id").html('Select Batch');
            b_valid = false;
		}
		else
		{
			$("#err_s_batch_id").html('');
		}	
	    
        /////////validating//////
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
        
        return b_valid;
    });    
    
        
    ///////////Submitting the form/////////
   /*  $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err="";
        $("#div_err").hide("slow"); 
	    
	   var fromid = $("#i_form_id").val() || '';
	   var payer = $("#i_payer_id").val() || '';
	   var payee = $("#i_payee_id").val() || '';
	    
	    if(fromid=='')
		{			
			$("#err_i_form_id").html('Select form');
            b_valid = false;
		}
		else
		{
			$("#err_i_form_id").html('');
		}	
		
		if(payer=='')
		{
			//markAsError($("#i_payer_id"),'<?php echo addslashes(t("Please provide payer TIN"))?>');
			$("#err_i_payer_id").html('Select payer');
            b_valid = false;             
		}
		else
		{
			$("#err_i_payer_id").html('');
		}
		
		if(fromid!='' && payer!='')
		{
			if(payee=='')
			{
				$("#err_i_payee_id").html('Select payee');
				b_valid = false;             
			}
			else
			{
				$("#err_i_payee_id").html('');
			}
		}
		
	    
        /////////validating//////
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
        
        return b_valid;
    });    
    ///////////end Submitting the form/////////  
    
    
   $('#i_form_id').multiselect({
            includeSelectAllOption: true,
            disableIfEmpty: true
    });
    
    $('#i_payer_id').multiselect({
            includeSelectAllOption: true,
            disableIfEmpty: true
    });
	
	
	$('#i_payee_id').multiselect({
            includeSelectAllOption: true,
            disableIfEmpty: true
    });        
    
    $( "#i_payer_id" ).change(function() {
        var payerID = $("#i_payer_id").val() || '';
        var formsID = $("#i_form_id").val() || '';
        
		if(payerID)
		{
			$.ajax({
				type: 'POST',
				url: base_url+'web_master/download_efile/ajax_get_all_payee_AJAX',
				data: {payerID:payerID,formsID:formsID}
			}).done(function(msg){
				if(msg!='')
				{
					//$("#i_payee_id").parent().find('.text-danger').html('');
					//$("#i_payee_id").html(msg).trigger("liszt:updated").trigger('chosen:updated');
					$("#i_payee_id").parent().find('.text-danger').html('');
					$("#i_payee_id").html(msg).multiselect('rebuild');
				}
			});
		}		
		else
		{
			$('#i_payee_id').parent().find('.text-danger').html('');
			//$("#i_payee_id").html('').trigger("liszt:updated").trigger('chosen:updated');
			$("#i_payee_id").html('').multiselect('rebuild');
		}
    });*/
    	
    
}); 
// END document.ready

var markAsError	=	function(selector,msg){
    $(selector).next('.text-danger').show();    
	$(selector).next('.text-danger').html(msg);	
	$(selector).parents('.control-group').addClass("error");
	
	$(selector).on('focus',function(){
		removeAsError($(this));
	});
}

var removeAsError	=	function(selector){
	$(selector).next('.text-danger').html('');	
	$(selector).parents('.control-group').removeClass("error");
} 
  
</script>


<div class="row">			
    <div class="col-md-12">
        <div class="box box-info">    
        <?php show_all_messages(); echo validation_errors();?>
                      
            <div class="box-header">
                <i class="fa fa-edit"></i>
                <h3 class="box-title"><?php echo $heading;?></h3>
            </div><!-- /.box-header -->

                   
                <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" >
                <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                <input type="hidden" id="h_set" name="h_set" value="1"> 
                    <div class="box-body">   
                            
						<div class="row">
							<div class="col-md-5">
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="exampleInputEmail2" ><?php echo addslashes(t("Batch Number"))?><span class="text-danger">*</span></label>
										<select id="s_batch_id" name="s_batch_id[]" class="form-control" multiple="multiple" data-placement="top" >
											<!--<option value="">Select Forms</option>-->
											<?php echo makeOptionBatchMaster($posted["s_batch_id"]) ?>
										</select>
										<span class="text-danger" id="err_i_form_id"></span>
									 </div>
								</div>
							</div>                                        
							<div class="col-md-5 col-md-offset-2"> 
							</div>
						</div>  
                            
                    </div>

                    <div class="box-footer">
                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Download"))?>">
                    </div>
                </form>
        
        </div>
	</div>
</div>	

<!-- OLD CODE BACKUP BELOW 27 September, 2016 -->
<?php /* old code  ?>	
<div class="row">			
    <div class="col-md-12">
        <div class="box box-info">    
        <?php show_all_messages(); echo validation_errors();?>
                      
            <div class="box-header">
                <i class="fa fa-edit"></i>
                <h3 class="box-title"><?php echo $heading;?></h3>
            </div><!-- /.box-header -->

                   
                <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" >
                <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                <input type="hidden" id="h_set" name="h_set" value="1"> 
                    <div class="box-body">   
                            
						<div class="row">
							<div class="col-md-5">
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="exampleInputEmail1" ><?php echo addslashes(t("Forms"))?><span class="text-danger">*</span></label>
										<select id="i_form_id" name="i_form_id[]" class="form-control" multiple="multiple" data-placement="top" >
											<!--<option value="">Select Forms</option>-->
											<?php //echo makeOptionFormsMasterWtTitle($posted["i_form_id"]) ?>
											<?php echo makeOptionFormsMaster($posted["i_form_id"]) ?>
										</select>
										<span class="text-danger" id="err_i_form_id"></span>
									 </div>
								</div>
							</div>                                        
							<div class="col-md-5 col-md-offset-2"> 
								
                                <div class="col-md-6">	
									<div class="form-group">
										<label for="exampleInputEmail1" ><?php echo addslashes(t("Payer"))?><span class="text-danger">*</span></label>
										<select id="i_payer_id" name="i_payer_id[]" class="form-control" multiple="multiple" data-placement="top" >
											<!--<option value="">Select Payer</option>-->
											<?php echo makeOptionPayer($posted["i_payer_id"]) ?>
										</select>
										<span class="text-danger" id="err_i_payer_id"></span>
									 </div>
								</div>
                                <div class="col-md-6">	
									<div class="form-group">
										<label style="display: block;"><?php echo addslashes(t("Payee"))?></label>
										<select id="i_payee_id" name="i_payee_id[]" class="form-control" multiple="multiple" data-placement="top" >

											<!--<option value="">Select Payee</option>-->

											<?php
											if($posted["i_payer_id"])
											{
											echo makeOptionPayee(" i_payer_id= '".$posted["i_payer_id"]."' ", $posted["i_payer_id"]);
											}
											?>
										</select>
										<span class="text-danger" id="err_i_payee_id"></span>
									 </div>
								</div>
							
								
							</div>
						</div>  
                            
                    </div>

                    <div class="box-footer">
                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Download"))?>">
                    </div>
                </form>
        
        </div>
	</div>
</div>	
<?php */ ?>




















