<?php
/*
* File name: customize_user_access.tpl.php
* Author: SWI DEV
* Date  : 03 June 2015
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin access control Edit 
*/   
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-unlock-alt"></i>
                    <h3 class="box-title"><?php echo $heading.' for <span class="text text-green">'.$user_info[0]["s_first_name"].' '.$user_info[0]["s_last_name"].'</span>'?></h3>
                    <a class="btn btn-sm btn-warning pull-right" id="back" href="javascript:;" style="margin-left: 10px;">Back</a>
                    <a class="btn btn-sm btn-success pull-right" id="restore" href="javascript:;">Restore to Default</a>
                </div>
            </div>
            <?php show_all_messages();?>
            <!-- Content loop -->
            <?php 
            if(!empty($menu_action))
            {
                foreach($menu_action as $key => $val)
                    $menu[$val['first_label_id']][] = $val;

                // Start generate access form
                echo '<form action="" role="form" method="post" name="frm_actions">
                        <input type="hidden" name="user_id" value="'.encrypt($user_id).'">';
                foreach($menu as $key => $val)
                {
                    if($val[0]['first_label_id'] == 8 && $user_details['i_user_type'] > 1)
                    {
                        break;
                    }
                ?>
                    <div class="box box-info">
                        <div class="box-header">
                            <i class="fa fa-th"></i>
                            <h3 class="box-title"><?php echo $val[0]['first_label_menu']?></h3>
                        </div>
                        
                        <input type="hidden" name="h_first_label_menu_id[]" value="<?php echo $val[0]['first_label_id'] ?>">
                        <input type="hidden" name="access_type" value="<?php echo $user_info[0]["e_access_type"]?>">
                        <div class="box-body">
                            <div class="row">
                                <?php 
                                // Inner section start
                                for($i = 0; $i < count($val); $i++)
                                {
                                    if($i != 0 && $i % 3 == 0) echo '</div><div class="row">';
                                ?>
                                    <div class="col-md-4">
                                        <div class="box box-warning">
                                            <div class="box-header">
                                                <i class="fa fa-gears"></i>
                                                <h3 class="box-title"><?php echo $val[$i]['second_label_menu']; ?></h3>
                                            </div>
                                            <div class="box-body">
                                                <input type="hidden" name="first_label_menu_id[<?php echo $val[$i]['second_label_id']?>][]" value="<?php echo $val[0]['first_label_id'] ?>" />
                                                <input type="hidden" value="<?php echo $val[$i]['second_label_id']; ?>" name="h_action_permit[]" >
                                                <select id="select<?php echo '_'.$val[$i]['first_label_id'].'_'.$val[$i]['second_label_id']; ?>" name="opt_actions[<?php echo $val[$i]['second_label_id']; ?>][]" multiple data-rel="chosen" class="form-control">
                                                <?php 
                                                $arr_action = explode('||',$val[$i]['s_action_permit']);
                                                $selected_action = explode('##', $val[$i]['actions']);
                                                if(!empty($arr_action))
                                                {
                                                    foreach($arr_action as $key_1=>$value_1)
                                                    {    
                                                        $selected = '';
                                                        if(in_array($value_1, $selected_action))
                                                            $selected = "selected='selected'";
                                                        echo "<option ".$selected." value = '".$value_1."'>".$value_1."</option>";
                                                    }
                                                }
                                                ?>
                                              </select>
                                            </div>
                                        </div> 
                                    </div>
                                <?php
                                }
                                // Inner section start 
                                ?>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" name="submit-form" class="btn btn-primary"><?php echo t('Save Changes')?></button>
                            <button class="btn btn-warning" name="cancel"><?php echo t('Cancel')?></button>
                        </div>
                    </div>
                <?php 
                }
                echo '</form>';
                // End menu foreach
            } // End of if
            ?>
            <!-- End -->
        </div>
    </div>            
</div>
<div class="modal fade" id="myModal_delete" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">        
            <button type="button" class="close" data-dismiss="modal">x</button>
            <h3 class="text-yellow"><?php echo t('Confirmation')?></h3>
        </div>
        <div class="modal-body">
            <p><?php echo get_message('restore_confirm')?></p>
        </div>
        <div class="modal-footer">
            <a href="javascript:;" class="btn btn-success" id="btn_delete_yes">Yes</a>
            <a href="javascript:;" class="btn btn-danger" id="btn_delete_no" data-dismiss="modal">No</a>
        </div>
      </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('[name^="submit-form"]').click(function(){
        $('[name="frm_actions"]]').submit();
    });
    
    // Back 
    $('#back').bind('click', function(){
        window.location.href = '<?php echo $this->pathtoclass?>';
    });
    
    // Cancel
    $('[name^="cancel"]').bind('click', function(e){
        e.preventDefault();
        window.location.href = '<?php echo $this->pathtoclass?>';
    });
    
    // Restore
    $("#restore").click(function(e){
        e.preventDefault();
        $("#error_massage").hide();
        $('#myModal_delete').modal('show');
        var temp_id = $(this).attr('value');

        $('#btn_delete_yes').click(function(){
            window.location.href = '<?php echo $this->pathtoclass.'nap_restore_to_default/'.encrypt($user_id)?>';
        });
    });
});
</script>