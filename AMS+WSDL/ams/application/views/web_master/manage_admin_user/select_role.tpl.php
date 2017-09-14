<style type="text/css">
    .padding{font-size: 14px; padding: 8px 0;}
    .link{border-bottom: 1px solid #eee; color: #000; display: block; font-size: 15px; padding: 15px;}
    .link:hover{background: #fafafa;}
    .margin-top{margin-top:12px;}
    .width{min-width: 300px;}
</style>
<div class="col-md-12 margin-top width">
    <div class="box box-success">
        <div class="box-header with-border">
            <i class="fa fa-unlock"></i>
            <h2 class="box-title"><?php echo t('Select Role to Customize')?></h2>
        </div>
        <div class="box-body with-border no-padding">
            <?php 
            //pr($role_info);
            if(count($role_info) > 0)
            {
                for($i = 0; $i< count($role_info); $i++)
                {
                    $text = $role_info[$i]['s_user_type'];
                    if($role_info[$i]['i_role_id'] == 10)
                        $text .= ' <i class="fa fa-chevron-right"></i> '.$role_info[$i]['i_office_number'].'-'.$role_info[$i]['s_franchise_name'];
                    else if($role_info[$i]['region'] != '')
                        $text .= ' <i class="fa fa-chevron-right"></i> '.$role_info[$i]['i_region_number'].'-'.$role_info[$i]['region'];
            ?>
                <div>
                    <a href="<?php echo admin_base_url().'manage_admin_user/customize_user_access/'.encrypt($role_info[0]['i_user_id']).'/'.encrypt($role_info[$i]['i_role_id'])?>" class="col-md-12 no-pagging link"><?php echo $text?></a>
                </div>
            <?php 
                }
            } else {
                echo '<div><a href="javascript:;" style="text-align:center;" class="col-md-12 no-pagging link text-red">Sorry no role has assigned to you.</a></div>';
            }?>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->