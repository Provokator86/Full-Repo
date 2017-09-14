<!DOCTYPE html>
<html>
    <head>
        <?php require_once(APPPATH.'views/'.ADMIN_DIR.'/header.tpl.php')?>
    </head>
    
    <body class="skin-blue sidebar-mini sidebar-collapse">
        <div class="wrapper">
            <!-- Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo admin_base_url()?>" class="logo">
                <img src="<?php echo r_path('img/logo.png');//echo r_path('img/logo.png')?>" alt="###SITE_NAME_LINK###" />
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="javascript:;" class="sidebar-toggle custom-font" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    </a>
                    
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <?php $total_pending_business = ($pending_business_list+$pending_me_list+$pending_fr_list+$pending_cre_list)?>
                        <ul class="nav navbar-nav">
                                           

                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:;"> 
                                <!--<img alt="User Image" class="user-image" src="<?php echo $admin_avatar;?>">-->
                                <span class="hidden-xs"><?php echo $admin_details['s_first_name'].' '.$admin_details['s_last_name'];?></span></a>

                                <!--<ul class="dropdown-menu" style="box-shadow:#ccc -2px 3px 10px !important">-->
                                <ul class="dropdown-menu">
                                    <!-- User image -->

                                    <li class="user-header">                            
										
                                        <p>
                                            <?php echo $admin_details['s_first_name'].' '.$admin_details['s_last_name'];?>
                                            
                                            <small>Member since <?php echo date('M, Y', strtotime($admin_details['dt_created_on'])) ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                       
                                        <div class="pull-left" style="margin-left:6%;">
                                            <a class="btn btn-primary btn-flat" href="<?php echo admin_base_url().'dashboard'?>"><?php echo t('Dashboard')?></a>
                                        </div>

                                        <div class="pull-right" style="margin-right: 6%;">
                                            <a class="btn btn-primary btn-flat" href="<?php echo admin_base_url().'home/logout'?>">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            
                            <?php /*?>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a class="fa fa-gears" data-toggle="control-sidebar" href="javascript:;" style="font-style: italic"></a>
                            </li>
                            <?php */?>
                        </ul>                   
                    </div>
                </nav>
            </header>
            <!-- End Header -->
            
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar" style="height: auto;">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <!--<div class="pull-left image">
                            <img alt="User Image" class="user-image" src="<?php echo $admin_avatar;?>">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $admin_details['s_first_name'];?></p>
                            <a href="<?php echo admin_base_url().'my_account'?>"><i class="fa fa-circle text-success"></i>
                            <?php echo t('Online')?></a>
                        </div>-->
                    </div>
                    <!-- sidebar menu: : style can be found in sidebar.less -->

                    <ul class="sidebar-menu">
                        <?php
                        if($admin_details['e_access_type'] === 'customize' && intval($admin_details['i_id']) > 0)
                            create_custome_left_menus($admin_details); 
                        else
                            create_left_menus(); 
                        ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 916px;">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                   <!-- Breadcrumb  -->
                    <?php echo admin_breadcrumb($BREADCRUMB); ?>
                    
                    <h1><?php echo $title;?></h1>
                </section>
                
                <!-- Main content -->
                <section class="content">
                    <?php echo $content;?>
                </section>
                
            </div>
            <!-- /.content-wrapper -->
             <?php 
            /* Footer information */ 
            require_once(APPPATH.'views/'.ADMIN_DIR.'/footer.tpl.php');
            /* End */?>
        </div>
        <script type="text/javascript" language="javascript">
        function showConfirmation(msg,refId,extraData){
            jQuery(function($){
                var modalObj = $("#confirm_box") ;
                modalObj.find('.modal-body p').html(msg);
                modalObj.modal('show');

                $("#modal_cancel").on('click',function(event){
                    $('#modal_yes').off();
                    callbackEventCancel(modalObj,refId);
                });

                $("#modal_yes").on('click',function(event){
                    $('#modal_cancel').off();
                    callbackEventYes(modalObj,refId,extraData);
                });
            });
        }

        var callbackEventCancel    =    function(modalObj,refId){
            // callbackevent can be use
            $(modalObj).modal('hide');
            
        }

        $(document).ready(function(){
            $('ul.treeview-menu li a').bind('click', function(e){
                e.stopPropagation();
                var  _this=$(this),href=_this.attr('href'),pid=_this.attr('data-parent-id'),cid=_this.attr('data-id');
                jQuery.ajax({
                      url: '<?php echo admin_base_url()?>'+'home/ajax_menu_track/',
                      type: 'POST',
                      data: 'parent_id='+pid+'&child_id='+cid,
                      context: 'body',
                      success: function(msg) {
                            return true;
                            //window.location.href = href;
                      }
                });
                return true;
            });
            var h = $('.fht-thead').height();
            $('#acs_admin_table').css({marginTop: '-'+h+'px !important'});
            
            
            $('.sidebar-toggle').click(function(){
                $(this).toggleClass('wider-sidebar-toggle');
                $('.logo').toggleClass('logo-toggle');
            });
        });
        </script>
    </body>
</html>
