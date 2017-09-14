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
            <div class="box box-info ">
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
                {
                    if($val['first_label_id'] != 8 && $val['first_label_id'] != 11)
                        $menu[$val['first_label_id']][] = $val;
                }
            ?>
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-gear"></i>
                    <h3 class="box-title">Set Action Control</h3>
                    <a class="btn btn-sm btn-warning pull-right" id="back2" href="javascript:;" style="margin-left: 10px;">Back</a>
                    <a class="btn btn-sm btn-success pull-right" id="save" href="javascript:;" >Save</a>
                </div>
                <form action="" role="form" method="post" id="frm_actions" name="frm_actions">
                <input type="hidden" name="user_id" value="<?php echo encrypt($user_id)?>">
                <input type="hidden" name="role_id" value="<?php echo encrypt($role_id)?>">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <th >Menu List</th>
                                <?php 
                                    for($i = 0; $i <count($action_list); $i++)
                                        echo '<th class="center">'.$action_list[$i].'</th>';
                                ?>
                            </tr>
                            <?php 
                            foreach($menu as $key => $val)
                            {
                                echo '<tr>
                                        <td colspan="'.(count($action_list)+1).'">
                                            <span class="text-orange">'.$val[0]['first_label_menu'].'</span>
                                            <input type="hidden" name="h_first_label_menu_id[]" value="'.$val[0]['first_label_id'].'">
                                            <input type="hidden" name="access_type" value="'.$user_info[0]["e_access_type"].'">
                                        </td>
                                    </tr>';
                                for($i = 0; $i < count($val); $i++)
                                {
                                    echo '<tr>
                                            <th><span class="light-font">'.$val[$i]['second_label_menu'].'</span>
                                            <input type="hidden" name="first_label_menu_id['.$val[$i]['second_label_id'].'][]" value="'.$val[0]['first_label_id'].'" />
                                            <input type="hidden" value="'.$val[$i]['second_label_id'].'" name="h_action_permit[]">
                                            </th>';
                                    for($j = 0; $j <count($action_list); $j++)
                                    {
                                        $selected_action = explode('##', $val[$i]['actions']);
                                        $checked = in_array($action_list[$j], $selected_action) ? 'checked="checked"' : '';
                                        
                                        $arr_action = explode('||',$val[$i]['s_action_permit']);
                                        //$disabled = in_array($action_list[$j], $arr_action) ? '' : 'disabled="disabled"';
                                        if(in_array($action_list[$j], $arr_action))
                                        {
                                            echo '<th class="center" title="'.$action_list[$j].'">
                                                    <input type="checkbox" id="select_'.$val[$i]['first_label_id'].'_'.$val[$i]['second_label_id'].'" name="opt_actions['.$val[$i]['second_label_id'].'][]" value="'.$action_list[$j].'" '.$checked.'>
                                                  </th>';
                                        }
                                        else
                                        {
                                            echo '<th class="center">&nbsp;</th>';
                                        }
                                    }
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                   
                    <a class="btn btn-sm btn-success pull-left" id="save2" href="javascript:;" style="margin-right: 10px;">Save</a>
                    <a class="btn btn-sm btn-warning pull-left" id="back3" href="javascript:;">Back</a>
                </div>
                </form>
            </div>
            <?php 
            }
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
<style type="text/css">
.table tr:first-child th {font-size: 14px;}
.table tr td:first-child > span {font-size: 15px;}
.light-font{font-weight: normal;}
</style>
<script type="text/javascript">
$(document).ready(function(){
    /*$('[name^="submit-form"]').click(function(){
        $('[name="frm_actions"]').submit();
    });*/
    
    // Save
    $('#save, #save2').click(function(){
        $('#frm_actions').submit();
    });
    
    // Back 
    $('#back, #back2, #back3').bind('click', function(){
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
            window.location.href = '<?php echo $this->pathtoclass.'nap_restore_to_default/'.encrypt($user_id).'/'.encrypt($role_id)?>';
        });
    });
});
</script>