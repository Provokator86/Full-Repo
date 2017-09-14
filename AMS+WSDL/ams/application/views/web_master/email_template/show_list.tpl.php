<?php 

/***

File Name: email_template show_list.tpl.php 
Created By: SWI Dev 
Created On: June 08, 2015 
Purpose: CURD for Email Template 

*/


?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>


<div class="row">
    <div class="col-md-12">
        <div class="box box-info collapsed-box">
            <?php show_all_messages(); ?>
            <div class="box-header">
                <i class="fa fa-search"></i>
                <h3 class="box-title"><?php echo addslashes(t("Search"))?></h3>  
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
						<label class=""><?php echo addslashes(t("Subject"))?></label>
						<input type="text" name="s_subject" id="s_subject" value="<?php echo $s_subject?>" class="form-control" />
					</div>
                        </div>
                    </div>
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
