<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 3 June 2015
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin site setting Edit
* @package General
* @subpackage site setting
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/site_setting/
*/
?>
<style type="text/css">
.checkbox label, .radio label{
    padding-left: 0 !important;
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
        
    ///////////Submitting the form/////////
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err="";
        $("#div_err").hide("slow"); 
	    var noReg		= /^\d+$/;
        var records		= $.trim($("#i_records_per_page").val());
        var _startNo	= $.trim($("#i_starting_batch_no").val());
       
	    
	    var reg_website = /^http?:\/\/(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
	    
	    if($.trim($("#s_admin_email").val())=="") 
        {
		    markAsError($("#s_admin_email"),'<?php echo addslashes(t("Please provide email"))?>');
            b_valid=false;
        }  
        
	    if(records=="")
	    {
		    markAsError($("#i_records_per_page"),'<?php echo addslashes(t("Please provide number of records per page"))?>');
            b_valid=false;
	    }
	    else
	    {
		    if(noReg.test(records)==false)
		    {
			    markAsError($("#i_records_per_page"),'<?php echo addslashes(t("Please provide numeric value."))?>');
        	    b_valid=false;
		    }
	    } 
        
	    if(_startNo=="")
	    {
		    markAsError($("#i_starting_batch_no"),'<?php echo addslashes(t("Please provide starting batch number"))?>');
            b_valid=false;
	    }
	    else
	    {
		    if(noReg.test(_startNo)==false)
		    {
			    markAsError($("#i_starting_batch_no"),'<?php echo addslashes(t("Please provide numeric batch number."))?>');
        	    b_valid=false;
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
<?php

?>
<div class="row">			
    <div class="col-md-12">
        <div class="box box-info">    
        <?php show_all_messages(); ?>          
            <div class="box-header">
                <i class="fa fa-edit"></i>
                <h3 class="box-title"><?php echo $heading;?></h3>
            </div><!-- /.box-header -->

                   
                <form role="form" id="frm_add_edit" name="frm_add_edit" action="" method="post" autocomplete="off">
                <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                    <div class="box-body">   
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1" ><?php echo addslashes(t("Email"))?></label>
                                        <input type="email" class="form-control" name="s_admin_email" id="s_admin_email" placeholder="Email" value="<?php echo $posted["s_admin_email"];?>">
                                        <span class="text-danger"></span>
                                     </div>
	                            </div>                                        
                                <div class="col-md-5 col-md-offset-2">  
                                    <div class="form-group">
                                        <label for="exampleInputPassword1"><?php echo addslashes(t("Records Per Page"))?></label>
                                        <input type="text" class="form-control" id="i_records_per_page" name="i_records_per_page" placeholder="Records Per Page" value="<?php echo $posted["i_records_per_page"];?>">
                                        <span class="text-danger"></span>
                                    </div> 
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label><?php echo addslashes(t("Footer Text"))?></label>
                                        <textarea class="form-control" id="s_footer_text" name="s_footer_text" placeholder="Footer Text"><?php echo $posted["s_footer_text"];?></textarea>
                                        <span class="text-danger"></span>
                                    </div>                                    
                                </div>                                     
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="form-group">
                                        <label><?php echo addslashes(t("Starting Batch Number"))?></label>
                                        <input type="text" class="form-control" name="i_starting_batch_no" id="i_starting_batch_no" placeholder="Starting Batch Number" value="<?php echo $posted["i_starting_batch_no"];?>">
                                        <span class="text-danger"></span>
                                     </div>
                                </div>
                            </div>
                                                  
							
                            <div class="box box-waring" style="margin-bottom: 15px;">
                                <div class="box-header">
                                    <i class="fa fa-adjust"></i>
                                    <h3 class="box-title">Transmitter Record (T)</h3>
                                </div>
                                <div class="box-body">                       
                            
                                    <div class="row">
                                        <div class="col-md-5">											
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Transmitter's TIN</label>
													<input type="text" class="form-control" id="s_tin" name="s_tin" value="<?php echo $posted["s_tin"];?>">
													<span class="text-danger"></span>
													</div>  
												</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Transmitter Control Code (TCC)</label>
													<input type="text" class="form-control" id="s_tcc" name="s_tcc" value="<?php echo $posted["s_tcc"];?>">
													<span class="text-danger"></span>
												</div>                           
											</div>
                                        </div>                                     
                                        <div class="col-md-5 col-md-offset-2"> 										
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Transmitter Name</label>
													<input type="text" class="form-control" id="s_tm_name" name="s_tm_name" value="<?php echo $posted["s_tm_name"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Transmitter Name (Continuation)</label>
													<input type="text" class="form-control" id="s_tm_name_cont" name="s_tm_name_cont" value="<?php echo $posted["s_tm_name_cont"];?>">
													<span class="text-danger"></span>
												</div>                          
											</div>        
                                        </div>
                                    </div>                         
                            
                                    <div class="row">
                                        <div class="col-md-5">											
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Company Name</label>
													<input type="text" class="form-control" id="s_company_name" name="s_company_name" value="<?php echo $posted["s_company_name"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Company Name (Continuation)</label>
													<input type="text" class="form-control" id="s_company_name_cont" name="s_company_name_cont" value="<?php echo $posted["s_company_name_cont"];?>">
													<span class="text-danger"></span>
												</div>                         
											</div>
                                        </div>                                     
                                        <div class="col-md-5 col-md-offset-2"> 										
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Company Mailing Address</label>
													<input type="text" class="form-control" id="s_company_address" name="s_company_address" value="<?php echo $posted["s_company_address"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Company City</label>
													<input type="text" class="form-control" id="s_company_city" name="s_company_city" value="<?php echo $posted["s_company_city"];?>">
													<span class="text-danger"></span>
												</div>                           
											</div>        
                                        </div>
                                    </div>  
                                      
                                    <div class="row">
                                        <div class="col-md-5">											
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Company State</label>
													<input type="text" class="form-control" id="s_company_state" name="s_company_state" value="<?php echo $posted["s_company_state"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Company ZIP Code</label>
													<input type="text" class="form-control" id="s_company_zip" name="s_company_zip" value="<?php echo $posted["s_company_zip"];?>">
													<span class="text-danger"></span>
												</div>                          
											</div>
                                        </div>                                     
                                        <div class="col-md-5 col-md-offset-2"> 										
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Contact Name</label>
													<input type="text" class="form-control" id="s_contact_name" name="s_contact_name" value="<?php echo $posted["s_contact_name"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Contact Telephone Number &amp; Extension</label>
													<input type="text" class="form-control" id="s_contact_number" name="s_contact_number" value="<?php echo $posted["s_contact_number"];?>">
													<span class="text-danger"></span>
												</div>                           
											</div>        
                                        </div>
                                    </div> 
                                      
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Contact Email Address</label>
                                                <input type="text" class="form-control" id="s_contact_email" name="s_contact_email" value="<?php echo $posted["s_contact_email"];?>">
                                                <span class="text-danger"></span>
                                            </div>
                                        </div>                                     
                                        <div class="col-md-5 col-md-offset-2">          
                                        </div>
                                    </div>   
                                    
                                    <div class="row">
                                        <div class="col-md-5">											
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Vendor Name</label>
													<input type="text" class="form-control" id="s_vendor_name" name="s_vendor_name" value="<?php echo $posted["s_vendor_name"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Vendor Mailing Address</label>
													<input type="text" class="form-control" id="s_vendor_address" name="s_vendor_address" value="<?php echo $posted["s_vendor_address"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
                                        </div>                                     
                                        <div class="col-md-5 col-md-offset-2"> 										
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Vendor City</label>
													<input type="text" class="form-control" id="s_vendor_city" name="s_vendor_city" value="<?php echo $posted["s_vendor_city"];?>">
													<span class="text-danger"></span>
												</div>                           
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Vendor State</label>
													<input type="text" class="form-control" id="s_vendor_state" name="s_vendor_state" value="<?php echo $posted["s_vendor_state"];?>">
													<span class="text-danger"></span>
												</div> 
											</div>        
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                        <div class="col-md-5">											
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Vendor ZIP Code</label>
													<input type="text" class="form-control" id="s_vendor_zip" name="s_vendor_zip" value="<?php echo $posted["s_vendor_zip"];?>">
													<span class="text-danger"></span>
												</div>                            
											</div>
											<div class="col-md-6 no-padding-right">
												<div class="form-group">
													<label>Vendor Contact Name</label>
													<input type="text" class="form-control" id="s_vendor_contact_name" name="s_vendor_contact_name" value="<?php echo $posted["s_vendor_contact_name"];?>">
													<span class="text-danger"></span>
												</div>
											</div>
                                        </div>                                     
                                        <div class="col-md-5 col-md-offset-2"> 										
											<div class="col-md-6 no-padding-left">
												<div class="form-group">
													<label>Contact Telephone Number &amp; Extension</label>
													<input type="text" class="form-control" id="s_vendor_contact_number" name="s_vendor_contact_number" value="<?php echo $posted["s_vendor_contact_number"];?>">
													<span class="text-danger"></span>
												</div>                          
											</div>
											<div class="col-md-6 no-padding-right">
											</div>        
                                        </div>
                                    </div> 
                                    
                                     
                                </div>
                            </div>
                            
                    </div>

                    <div class="box-footer">
                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="<?php echo addslashes(t("Save Changes"))?>">
                    </div>
                </form>
        
        </div>
	</div>
</div>		




















