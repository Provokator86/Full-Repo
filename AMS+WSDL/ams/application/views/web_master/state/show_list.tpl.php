<?php 

/***

File Name: state show_list.tpl.php 
Created By: ACS Dev 
Created On: May 29, 2015 
Purpose: CURD for State 

*/


?>
<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function(){
        //$(".ajax").colorbox();
        
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
        
        $('input:radio, input:checkbox').on('ifChecked', function(event){
          alert(event.type + ' callback');
        });
    });
</script>

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
							        <label class=""><?php echo addslashes(t("Country"))?></label>
                                    <select name="i_country_id" id="i_country_id" class="form-control" data-rel="chosen">
                                    <option value="">Select Country</option>
                                    <?php echo makeOptionCountry('',$i_country_id) ?>
                                    </select>
						        </div>	
                            </div>		
                            
                            <div class="col-md-3">
                                <div class="form-group">
							        <label class=""><?php echo addslashes(t("State/Province"))?></label>
							        <input type="text" name="name" id="name" value="<?php echo $name?>" class="form-control" />
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
