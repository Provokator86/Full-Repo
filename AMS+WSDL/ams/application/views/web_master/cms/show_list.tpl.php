<script>var g_controller="<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>';// Controller Path </script>
<script src="<?php echo base_url()?>resource/web_master/js/custom_js/add_edit_view.js" type="text/javascript"></script>

<script type="text/javascript">
$(document).ready(function(){

    var g_controller="<?php echo $this->pathtoclass;?>"; //controller Path
     // Datepicker
    $('.datepicker').datepicker({
        format: 'mm/dd/yyyy',
        maxDate:0
    })
    $('.datepicker_mask').mask('99/99/9999');
    
    /////////Submitting the form//////                                            

    $("#btn_submit").click(function(){
       
        var formid=$(this).attr("search");	
        $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
        $("#frm_search_"+formid).submit(); 

    });                                              

    /////////Submitting the form//////

    ///////////Submitting the form2/////////

    $("#frm_search_2").submit(function(){

        var b_valid=true;
        var s_err="";

        $("#frm_search_2 #div_err_2").hide("slow"); 

        /////////validating//////

        if(!b_valid)
        {
            $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }    

        return b_valid;

    });    

    ///////////end Submitting the form2/////////

    ////////Submitting search all///

    $("#btn_srchall").click(function(){
     $("#frm_search_3").submit();
     
    });
    ////////end Submitting search all///      
    
    $("a[id^='publish_id_']").click(function(){
        var arr_arg,temp_id;
        temp_id = $(this).attr('id');
        arr_arg = temp_id.split('_');
        var s_status   = 'Published';
    
        $.ajax({
                type: "POST",
                async: false,
                url: g_controller+'ajax_change_status',
                data: "s_status="+s_status+"&h_id="+arr_arg[2],
                success: function(msg){           
                    if(msg == "ok")
                    {                       
                        var url=g_controller+'show_list?h_search=';
                        window.location.href = url;
                    }
                }
           });
    });     

});
</script>

<div class="row">
    <div class="col-md-12">
        <div class="box box-info collapsed-box">
            <div class="box-header">
                <i class="fa fa-search"></i>
                <h2 class="box-title"><?php echo addslashes(t("Search"))?></h2>
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>                                 
            </div>
            
    
            <div class="box-body">
                <?php show_all_messages(); ?>
                <form class="form-horizontal" id="frm_search_3" name="frm_search_3" method="get" action="<?php echo $search_action?>" >
                    <input type="hidden" id="h_search" name="h_search" value="" />    
                </form>
        
                <form class="" id="frm_search_2" name="frm_search_2" method="get" action="" >
                    <input type="hidden" id="h_search" name="h_search" value="advanced" />        
                    <div id="div_err_2"></div>        
                    <div class="row">
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class=""><?php echo addslashes(t("Title"))?></label>
                                <input type="text" name="s_title" id="s_title" value="<?php echo $s_title?>" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Published Date From</label>
                                <input type="text" name="dt_from" id="dt_from" value="<?php echo $dt_from?>" class="form-control datepicker" />
                            </div>
                        </div>
                        
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="">Published Date To</label>
                                <input type="text" name="dt_to" id="dt_to" value="<?php echo $dt_to?>" class="form-control datepicker" />
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



