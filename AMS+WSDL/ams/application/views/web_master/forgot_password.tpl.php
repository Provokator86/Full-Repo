<!DOCTYPE html>
<html>
    <head>
        <?php require_once(APPPATH.'views/'.ADMIN_DIR.'/header.tpl.php')?>
        <style type="text/css">
            .alert{padding: 7px;}
            .content-wrapper{ margin-left:0px !important;}
            .skin-blue .main-header .logo{background: #3c8dbc;margin: 0 auto; float: none;}
            .login-box{margin: 0 auto; float: none; margin-top: 5%}
            .main-header{background: #3c8dbc;}
            .main-footer{margin-left:0px !important; text-align: center;}
            @media (min-width: 768px){
                .sidebar-mini.sidebar-collapse .content-wrapper{ margin-left:0px !important;}
                .login-box{width:45%;}
            }
            /*.icheckbox_flat-blue{left:-20px;}*/
            span.rem-me {margin-left: 3px;}
        </style>
    </head>
    
    <body class="skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="<?php echo admin_base_url()?>" class="logo">
                <img src="<?php echo r_path('img/logo.png');//echo r_path('img/logo.png')?>" alt="###SITE_NAME_LINK###" />
                </a>
            </header>
            <!-- End Header -->
            
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 450px;">
                <section class="content">
                    <div class="col-md-8 login-box">
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <div class="login_wrapper">
                                    <?php
                                    if(!empty($posted))
                                        show_all_messages();
                                    else
                                        echo show_success_info(get_message('forgot_greet'));
                                    ?>

                                    <?php
                                    $current_url =  str_replace('=','',base64_encode(base_url().substr(uri_string(),1)));
                                    
                                    ?>
                                    <form role="form" method="post" action="">
                                        <div class="form-group">
                                            <input name="s_email" type="text" value="<?php echo $s_email; ?>" class="form-control" placeholder="Email" autocomplete="off" >
                                        </div>
                                        
                                        <div class="row-fluid">
                                            <div class="col-md-6 no-padding">
                                                <label><a href="<?php echo admin_base_url()?>home"><span class="rem-me">Login</span></a></label>
                                            </div>
                                            <div class="col-md-6 no-padding">
                                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        
                                    </form>
                                </div>   
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
