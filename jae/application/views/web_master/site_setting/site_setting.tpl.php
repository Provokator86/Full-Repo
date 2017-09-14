<?php
/*********
* Author: SWI
* Date  : 11 sept 2017
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
		    markAsError($("#s_admin_email"),'Please provide email');
            b_valid=false;
        }  
        
	    if(records=="")
	    {
		    markAsError($("#i_records_per_page"),'Please provide number of records per page');
            b_valid=false;
	    }
	    else
	    {
		    if(noReg.test(records)==false)
		    {
			    markAsError($("#i_records_per_page"),'Please provide numeric value.');
        	    b_valid=false;
		    }
	    } 
        
	    if(_startNo=="")
	    {
		    markAsError($("#i_starting_batch_no"),'Please provide starting batch number');
            b_valid=false;
	    }
	    else
	    {
		    if(noReg.test(_startNo)==false)
		    {
			    markAsError($("#i_starting_batch_no"),'Please provide numeric batch number.');
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
                                        <label for="exampleInputEmail1" >Email</label>
                                        <input type="email" class="form-control" name="s_admin_email" id="s_admin_email" placeholder="Email" value="<?php echo $posted["s_admin_email"];?>">
                                        <span class="text-danger"></span>
                                     </div>
	                            </div>                                        
                                <div class="col-md-5 col-md-offset-2">  
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Records Per Page</label>
                                        <input type="text" class="form-control" id="i_records_per_page" name="i_records_per_page" placeholder="Records Per Page" value="<?php echo $posted["i_records_per_page"];?>">
                                        <span class="text-danger"></span>
                                    </div> 
                                </div>
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-5"> 
                                    <div class="form-group">
                                        <label>Footer Text</label>
                                        <textarea class="form-control" id="s_footer_text" name="s_footer_text" placeholder="Footer Text"><?php echo $posted["s_footer_text"];?></textarea>
                                        <span class="text-danger"></span>
                                    </div>                                    
                                </div>                                     
                                <div class="col-md-5 col-md-offset-2">
                                    <div class="form-group">
                                        <label>Starting Batch Number</label>
                                        <input type="text" class="form-control" name="i_starting_batch_no" id="i_starting_batch_no" placeholder="Starting Batch Number" value="<?php echo $posted["i_starting_batch_no"];?>">
                                        <span class="text-danger"></span>
                                     </div>
                                </div>
                            </div>
                                                  
							
                    </div>

                    <div class="box-footer">
                        <input type="button" id="btn_save" name="btn_save" class="btn btn-primary" value="Save Changes">
                    </div>
                </form>
        
        </div>
	</div>
</div>		




















