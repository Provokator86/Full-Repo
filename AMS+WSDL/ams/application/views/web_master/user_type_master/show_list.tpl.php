<script type="text/javascript">
$(document).ready(function(){
    var g_controller="<?php echo $this->pathtoclass;?>"; //controller Path

    //Submitting the form//                                            
    $("#btn_submit").click(function(){
        var formid=$(this).attr("search");	
        $("#frm_search_"+formid).attr("action","<?php echo $search_action;?>");
        $("#frm_search_"+formid).submit(); 
    });                                              
    //Submitting the form//

    //Submitting the form2//
    $("#frm_search_2").submit(function(){
        var b_valid=true;
        var s_err="";
        $("#frm_search_2 #div_err_2").hide("slow"); 
        //validating//
        if(!b_valid)
        {
            $("#frm_search_2 #div_err_2").html('<div id="err_msg" class="error_massage">'+s_err+'</div>').show("slow");
        }    
        return b_valid;
    });    
    //end Submitting the form2//

    //Submitting search all//
    $("#btn_srchall").click(function(){
        $("#frm_search_3").submit();
    });
    //end Submitting search all//       
});
</script>

<div class="row">
    <div class="col-md-12">	
            <div class="box box-info collapsed-box">    
             <?php show_all_messages();?>
                <div class="box-header">
                    <i class="fa fa-search"></i>
                    <h3 class="box-title"><?php echo addslashes(t("Search"))?></h3>  
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                    </div>           
                </div>
            
                <div class="box-body">
                    <form class="form-horizontal"  id="frm_search_3" name="frm_search_3" method="post" action="<?php echo $search_action ?>" >
                        <input type="hidden" id="h_search" name="h_search" value="" />    
                    </form>
            
                    <form class="form-horizontal" id="frm_search_2" name="frm_search_2" method="post" action="" >
                        <input type="hidden" id="h_search" name="h_search" value="advanced" />  
                        <div id="div_err_2"></div>                      
                        <div class="col-md-12 no-padding">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label><?php echo addslashes(t("User Type")) ?></label>
                                    <input type="text" id="txt_user_type" name="txt_user_type" class="form-control" value="<?php echo $txt_user_type;?>"/>
                                </div>
                            </div>                            
                        </div>
                        
                        <div class="col-md-12 no-padding">
                            <button type="button" search="2" id="btn_submit" name="btn_submit" class="btn btn-primary"><?php echo addslashes(t("Search")) ?></button>
                            <button type="button" id="btn_srchall" name="btn_srchall" class="btn btn-warning"><?php echo addslashes(t("Show All")) ?></button>
                        </div>
                        
                    </form>
                </div>
                
            </div>
        <?php echo $table_view;?>
    </div>
</div>

