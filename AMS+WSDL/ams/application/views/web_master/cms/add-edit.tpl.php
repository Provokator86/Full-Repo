<?php
/*********
* Author: Acumen CS
* Date  : 06 Feb 2014
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin user Add & Edit
* @package General
* @subpackage admin_user
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/manage_admin_user/
*/
?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>

<!--<script type="text/javascript" src="<?php echo r_path('js/tinymce/jscripts/tiny_mce/tiny_mce.js')?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo r_path('js/tinymce/load_tiny_mce.js')?>"></script>-->

<script language="javascript">
$(document).ready(function(){

    var g_controller="<?php echo $pathtoclass;?>"; //controller Path 

    $("#btn_add_record").click(function(){
        var url=g_controller+'add_information/';
        window.location.href=url;
        
     });
         
    $('#btn_cancel').click(function(i){
	     window.location.href=g_controller; 
    });   


    $('#btn_save').click(function(){
       //check_duplicate();
       $("#frm_add_edit").submit();
    }); 

        
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err="";
        $("#div_err").hide("slow");
        var content = CKEDITOR.instances['s_description'].getData();
	    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	    if($("#s_title").val()=="") 
        {
		    markAsError($("#s_title"),'Please provide title');
            b_valid=false;
        }
        if(content=='')
        {
            $("#err_s_description").html('Please provide content').show();
            b_valid = false;
        }
        else
        {
            $("#err_s_description").html('').hide();
        }
        if($("#s_url").val()=="") 
        {
            markAsError($("#s_url"),'Please provide url');
            b_valid=false;
        }
        
        if($("#s_meta_title").val()=="") 
        {
            markAsError($("#s_url"),'Please provide Meta title');
            b_valid=false;
        }  
	    /*if($("#s_description").val()==""){}*/	
        //validating//
        if(!b_valid)
        {        
            $("#div_err").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }
        
        return b_valid;
    });    
    //end Submitting the form//  	
    
    $("#s_title").blur(function(){
        var txt = $(this).val();
        var exurl = $.trim($("#s_url").val());
        if(txt && exurl=='')
        {            
            $.ajax({    
                type: "POST",    
                url: g_controller+'ajax_get_url_from_title/',    
                data: 'txt='+escape(txt),
                dataType: "json",
                async:'false',
                success: function(data) {
                    //console.log(data.urls);
                    $("#s_url").val(data.urls)
                }
            });           
        }
        
    });

	/*$('#txt_like_keyword, #txt_dislike_keyword').on("keyup", function(e) {
		this.value = this.value.replace(/[^a-zA-Z\,]/g, '');
	});*/

	var markAsError	=	function(selector,msg){
		//$(selector).next('.help-inline').html(msg);	
        $(selector).parents('.controls').find('.help-inline').html(msg);
		$(selector).parents('.control-group').addClass("error");
		
		$(selector).on('focus',function(){
			removeAsError($(this));
		});
	}
	
	var removeAsError	=	function(selector){
		//$(selector).next('.help-inline').html('');	
        $(selector).parents('.controls').find('.help-inline').html('');
		$(selector).parents('.control-group').removeClass("error");
	} 
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
                            <div class="col-md-5 ">
                                <div class="form-group">
                                <label for="focusedInput">Title<span class="text-danger">*</span></label>
                                    <input class="form-control" rel="s_title" id="s_title" name="s_title" value="<?php echo $posted["s_title"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-5  col-md-offset-2"> 
                                <div class="form-group">
                                    <?php //if($mode=='add'){ ?>
                                    <label for="focusedInput">Parent<span class="text-danger">*</span></label>
                                        <select name="i_parent_id" id="i_parent_id" class="form-control" data-rel="chosen">
                                            <option>Root</option>
                                            <?php //echo getOptionPages(0,'',$posted["i_id"],$posted["i_parent_id"]);?>
                                            <?php echo getOptionRootPages(0,'',$posted["i_id"],$posted["i_parent_id"]);?>
                                        </select>   
                                    <span class="text-danger" id="err_i_parent_id"></span>
                                    <?php // } else{ ?>
                                    <!--<label for="focusedInput">Page<span class="text-danger"></span></label>
                                    <p><?php echo _cms_master($posted['i_cms_master_id']) ?></p>
                                    <input type="hidden" name="i_cms_master_id" value="<?php echo $posted['i_cms_master_id'];?>">-->
                                    <?php //} ?>
                                </div>   
                               
                            </div>
                        </div>
                        
                        <div class="row">                
                            <div class="col-md-5 ">
                                <div class="form-group">
                                <label for="focusedInput">Summary</label>
                                    <textarea class="form-control" name="s_summary" id="s_summary" rel="s_summary" ><?php echo $posted["s_summary"]?></textarea>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-5  col-md-offset-2">  
                                <div class="form-group">
                                <label for="focusedInput">URL<span class="text-danger">*</span><span title="i.e. Type about-us for <?php echo base_url('about-us') ?>">&nbsp;<i class="fa fa-question-circle text-primary"></i></span></label>
                                    <input class="form-control" rel="s_url" id="s_url" name="s_url" value="<?php echo $posted["s_url"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>  
                               
                            </div>
                        </div>
                        
                        <div class="row">                
                            <div class="col-md-12 ">                   
                                <!--<div class="form-group">-->
                                    <label for="focusedInput">Description<span class="text-danger">*</span></label>
                                    
                                    <textarea name="s_description" id="s_description" rel="s_description" class="ckeditor" rows="8" cols="80" ><?php echo $posted["s_description"]?></textarea>
                                    <span class="text-danger" id="err_s_description"></span>
                                <!--</div>-->
                            </div>
                        </div>
                        
                        <div class="clearfix" style="margin-top: 20px;"></div>
                        <div class="row">                
                            <div class="col-md-5 "> 
                                <div class="form-group">
                                <label for="focusedInput">Meta Title<span class="text-danger">*</span><span title="The SEO title defaults to what is generated based on this sites title for this content.">&nbsp;<i class="fa fa-question-circle text-primary"></i></span></label>
                                    <input class="form-control" rel="s_meta_title" id="s_meta_title" name="s_meta_title" value="<?php echo $posted["s_meta_title"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>  
                            </div>
                            <div class="col-md-5  col-md-offset-2">  
                                <div class="form-group">
                                <label for="focusedInput">Meta Keywords<span title="Here you can provide keywords with comma seperator like franchises, business opportunity, business for sale, business brokers etc.">&nbsp;<i class="fa fa-question-circle text-primary"></i></span></label>
                                    <textarea class="form-control" name="s_meta_keyword" id="s_meta_keyword" rel="s_meta_keyword" ><?php echo $posted["s_meta_keyword"]?></textarea>
                                    <span class="text-danger"></span>
                                </div>  
                            </div>
                        </div>                        
                        
                        <div class="row">                
                            <div class="col-md-5 "> 
                                <div class="form-group">
                                <label for="focusedInput">Meta Description</label>
                                    <textarea class="form-control" name="s_meta_description" id="s_meta_description" rel="s_meta_description" ><?php echo $posted["s_meta_description"]?></textarea>
                                    <span class="text-danger"></span>
                                </div>                              
                            </div>
                            <div class="col-md-5  col-md-offset-2">  
                                <div class="form-group">
                                <label for="focusedInput">301 Redirect<span title="The URL that this page should redirect to.">&nbsp;<i class="fa fa-question-circle text-primary"></i></span></label>
                                    <input class="form-control" rel="s_redirect_url" id="s_redirect_url" name="s_redirect_url" value="<?php echo $posted["s_redirect_url"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>  
                            </div>
                        </div>
                        
                        <div class="row">                
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Status</label>
                                        <select name="e_status" id="e_status" class="form-control" data-rel="chosen">
                                            <option value="Draft" <?php echo $posted['e_status']=='Draft'?"selected='selected'":"" ?>>Draft</option>
                                            <option value="Published" <?php echo $posted['e_status']=='Published'?"selected='selected'":"" ?>>Published</option>
                                            <option value="Inactive" <?php echo $posted['e_status']=='Inactive'?"selected='selected'":"" ?>>Inactive</option>
                                        </select>   
                                    <span class="text-danger" id="err_i_parent_id"></span>
                                    
                                </div>    
                            </div>
                            <div class="col-md-5  col-md-offset-2">                                  
                               <!-- <div class="form-group">
                                    <label for="focusedInput">Additional Sub Pages</label>
                                        <select name="s_additional_page" id="s_additional_page" class="form-control" data-rel="chosen">
                                            <option value="">Select Page</option>
                                            <?php echo makeOptionCmsAdditionalPages($posted['s_additional_page']) ?>
                                        </select>   
                                    <span class="text-danger" id="err_i_parent_id"></span>
                                    
                                </div>-->
                            </div>
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
