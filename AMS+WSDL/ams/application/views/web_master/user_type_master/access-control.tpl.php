<?php
/*********
* Author: SWI DEV
* Date  : 01 June 2015
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Admin access control Edit
* @package General
* @subpackage country
* @link InfController.php 
* @link My_Controller.php
* @link views/admin/access_control/
*/
?>
<?php //Javascript For List View//?>
<script language="javascript">
$(document).ready(function(){
    var g_controller="<?php echo $pathtoclass;?>";//controller Path 
    $('[data-rel="chosen"]').chosen();
});   
</script>  

<div class="container-fluid">
	<div class="row">
        <div class="col-md-12">
            <?php show_all_messages();?>
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-unlock-alt"></i>
                    <h3 class="box-title"><?php echo $posted["txt_user_type"]?></h3>
                    <a class="btn btn-sm btn-warning pull-right" id="back" href="javascript:;" style="margin-left: 10px;">Back</a>
                    <a class="btn btn-sm btn-success pull-right" id="save" href="javascript:;">Save</a>
                </div>
            
                <?php 
                if(!empty($menu_action))
                {
                    foreach($menu_action as $key => $val)
                    {
                        if($val['first_label_id'] != 8 && $val['first_label_id'] != 11)
                            $menu[$val['first_label_id']][] = $val;
                    }
                ?>
                <form action="" method="post" name="frm_actions" id="frm_actions" role="form">
                <input type="hidden" name="user_type_id" value="<?php echo encrypt($user_type_id)?>">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <th>Menu List</th>
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
                                                    <input  type="checkbox" id="select_'.$val[$i]['first_label_id'].'_'.$val[$i]['second_label_id'].'" name="opt_actions['.$val[$i]['second_label_id'].'][]" value="'.$action_list[$j].'" '.$checked.'>
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
                    <a class="btn btn-sm btn-warning pull-left" id="back2" href="javascript:;" >Back</a>
                    
                </div>
                </form>
                <?php 
                }
                ?>
            </div>
        </div>
    </div><!-- row ends -->
</div><!-- content ends -->
<style type="text/css">
.main-footer{margin-left: 0px !important}
@media (min-width: 768px){
    .main-footer{margin-left: 0px !important;}
}
.table tr:first-child th {font-size: 14px;}
.table tr td:first-child > span {font-size: 15px;}
.light-font{font-weight: normal;}
</style>
<script type="text/javascript">
$(document).ready(function(){
    // Save
    $('#save, #save2').click(function(){
        $('#frm_actions').submit();
    });
    
    // Back 
    $('#back, #back2').bind('click', function(){
        window.location.href = '<?php echo $this->pathtoclass?>';
    });
});
</script>
