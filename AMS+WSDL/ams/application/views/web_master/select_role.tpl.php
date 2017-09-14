<!DOCTYPE html>
<html>
    <head>
        <?php require_once(APPPATH.'views/'.ADMIN_DIR.'/header.tpl.php')?>
        <style type="text/css">
            .alert{padding: 7px;}
            .content-wrapper{ margin-left:0px !important;}
            .skin-blue .main-header .logo{background: #3c8dbc;margin: 0 auto; float: none;}
            .login-box{margin: 0 auto; float: none; margin-top: 3%}
            .main-header{background: #3c8dbc;}
            .main-footer{margin-left:0px !important; text-align: center;}
            @media (min-width: 768px){
                .sidebar-mini.sidebar-collapse .content-wrapper{ margin-left:0px !important;}
                .login-box{width:70%;}
            }
            .padding{font-size: 14px; padding: 8px 0;}
            .link{border-bottom: 1px solid #eee; color: #000; display: block; font-size: 15px; padding: 15px;}
            .link:hover{background: #fafafa;}
        </style>
    </head>
    
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo admin_base_url()?>" class="logo">
                <img src="<?php echo r_path('img/logo.jpg')?>" alt="###SITE_NAME_LINK###" />
                </a>
            </header>
            <!-- End Header -->
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 450px;">
                <section class="content">
                    <div class="col-md-10 login-box">
                        <?php
                        if(!empty($posted))
                            show_all_messages("error");
                        else
                            echo show_success_info('Welcome '.$login_data['user_fullname'].', please select role to continue.', 'success');
                        ?>
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <i class="fa fa-unlock"></i>
                                <h2 class="box-title"><?php echo t('Select Role')?></h2>
                                <a class="btn btn-primary pull-right" href="<?php echo admin_base_url().'home/logout'?>"><?php echo t('Log Out')?></a>
                            </div>
                            <div class="box-body with-border no-padding">
                                <?php 
                                //pr($role_info);
                                if(count($role_info) > 0)
                                {
                                    for($i = 0; $i< count($role_info); $i++)
                                    {
                                        $text = $role_info[$i]['s_user_type'];
                                        if($role_info[$i]['i_role_id'] == 8)
                                            $text .= ' <i class="fa fa-chevron-right"></i> '.$role_info[$i]['i_office_number'].'-'.$role_info[$i]['s_franchise_name'];
                                        else if($role_info[$i]['region'] != '')
                                            $text .= ' <i class="fa fa-chevron-right"></i> '.$role_info[$i]['i_region_number'].'-'.$role_info[$i]['region'];
                                ?>
                                    <div>
                                        <a href="<?php echo admin_base_url().'home/nap_set_role/'.encrypt($role_info[$i]['i_role_id']).'/'.encrypt($role_info[$i]['region_id']).'/'.encrypt($role_info[$i]['franchise_id'])?>" class="col-md-12 no-pagging link"><?php echo $text?></a>
                                    </div>
                                <?php 
                                    }
                                ?>
                                    <div>
                                        <a href="<?php echo admin_base_url().'home/nap_unset_role'?>" class="col-md-12 no-pagging link text-red">Unset Selected Role</a>
                                    </div>
                                <?php 
                                } else {
                                    echo '<div><a href="javascript:;" style="text-align:center;" class="col-md-12 no-pagging link text-red">Sorry no role has assigned to you.</a></div>';
                                }?>
                            </div>
                        </div>
                    </div>
                </section><!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <?php 
            /* Footer information */ 
            require_once(APPPATH.'views/'.ADMIN_DIR.'/footer.tpl.php');
            /* End */?>
        </div>
    </body>
</html>
