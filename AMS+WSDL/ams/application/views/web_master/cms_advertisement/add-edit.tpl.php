<?php 

/***

File Name: cms_advertisement add-edit.tpl.php 
Created By: SWI Dev 
Created On: October 09, 2015 
Purpose: CURD for Cms Advertisement 

*/


?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type"text/javascript">
$(document).ready(function(){
    //Submitting the form//
    $("#frm_add_edit").submit(function(){
        var b_valid=true;
        var s_err='';
        var email_pattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
        $("#div_err").hide("slow");
		
        if($("#i_cms_id").val()=='')
        {
            markAsError($("#i_cms_id_chosen"),'Please select page');
            b_valid = false;
        }
        else
        {
            removeAsError('#i_cms_id_chosen');
        }
        //validating//
        if(!b_valid)
        {        
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
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    <label for="focusedInput">Page<span class="text-danger">*</span></label>
                                    <select name="i_cms_id" id="i_cms_id" class="form-control" data-rel="chosen">
                                        <option value="">Select</option>
                                        <?php //echo getOptionAllCmsPages($posted['i_cms_id']);?>
                                        <?php echo getOptionAllContentPages(0,'',$posted["i_cms_id"]);?>
                                    </select>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-5  col-md-offset-2"> 
                                <div class="form-group">
                                    <label for="focusedInput">Call To Action URL<span class="text-danger"></span></label>
                                    <input class="form-control" rel="s_url" id="s_url" name="s_url" value="<?php echo $posted["s_url"];?>" type="text" />
                                    <span class="text-danger"></span>
                                </div>
                               
                            </div>
                        </div>       
                        
                        <div class="row">                
                            <div class="col-md-5 ">
                                <div class="form-group">                                    
                                    <label for="focusedInput">Call To Action Image(201px X 279px)<span class="text-danger"></span></label>
                                    <input id="s_image" name="s_image" type="file" /><span class="text-danger"></span>
                                </div>   
                                
                                <?php if($posted['s_image'] != ''){?>
                                <div class="form-group">
                                    <img src="<?php echo base_url('uploaded/cta_image/thumb/'.$posted['s_image'])?>" alt="Logo" style="max-height: 100px; max-width: 150px;">
                                    <input rel="h_image" id="h_image" name="h_image" type="hidden" value="<?php echo $posted['s_image']; ?>"/>
                                </div>
                                <?php }?>
                            </div>
                            <div class="col-md-5  col-md-offset-2">  
                                <div class="form-group">
                                    <label for="focusedInput">Status<span class="text-danger"></span></label>  
                                    <select name="e_status" id="e_status" class="form-control" data-rel="chosen">
                                        <option value="Active" <?php echo $posted['e_status']=='Active'?"selected='selected'":"" ?>>Active</option>
                                        <option value="Inactive" <?php echo $posted['e_status']=='Inactive'?"selected='selected'":"" ?>>Inactive</option>
                                        
                                    </select>   
                                </div>                               
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