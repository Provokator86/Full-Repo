<!DOCTYPE html>
<html>
    <head>
        <?php require_once(APPPATH.'views/'.ADMIN_DIR.'/header.tpl.php')?>
        <style type="text/css">
            <!--
			.alert{padding: 7px;}
			.content-wrapper{ margin-left:0px !important;}
			.skin-blue .main-header .logo{background: #ccc;margin: 0 auto; float: none;}
			.login-box{margin: 0 auto; float: none; margin-top: 5%}
			.main-header{background: #ccc;}
			.main-footer{margin-left:0px !important; text-align: center;}
			span.rem-me {margin-left: 3px;}
            @media (min-width: 768px){                
			.sidebar-mini.sidebar-collapse .content-wrapper{ margin-left:0px !important;}
			.login-box{width:45%;}
            }
            -->
        </style>
        
        <script type="text/javascript">
        $(document).ready(function(){
            $('input[name="txt_user_name"]').focus();
        });
        </script>
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
                                        show_all_messages("error");
                                    else
                                        echo show_success_info(get_message('login_greet'));
                                    ?>

                                    <?php
                                    $current_url =  str_replace('=','',base64_encode(base_url().substr(uri_string(),1)));
                                    if(isset($_COOKIE['acs_login_username']) && isset($_COOKIE['acs_login_password']))
                                    {    
                                        $user_name = $_COOKIE['acs_login_username'];
                                        $password = $_COOKIE['acs_login_password'];
                                        $checked = 'checked="checked"';
                                    }
                                    else
                                        $checked = $password = $user_name = "";
                                    ?>
                                    <form role="form" method="post" action="">
                                        <div class="form-group">
                                            <input name="txt_user_name" type="text" value="<?php echo $user_name; ?>" class="form-control" placeholder="Username" autocomplete="off" >
                                        </div>
                                        <div class="form-group">
                                            <input id="txt_password" name="txt_password" type="password" value="<?php echo $password?>" class="form-control" placeholder="Password" autocomplete="off">
                                        </div>
                                        <div class="row-fluid">
                                            <div class="col-md-6 no-padding">
                                                <label>
                                                    <input type="checkbox" name="chk_remember" id="remember" <?php echo $checked?>/><span class="rem-me">Remember Me</span>
                                                </label>
                                            </div>
                                            <div class="col-md-4 no-padding">                                                
                                                    <label><!--<a class="pull-right" href="<?php echo admin_base_url()?>home/forgot_password"><span class="rem-me">Forgot Password</span></a>-->&nbsp;</label>
                                            </div>
                                            <div class="col-md-2 no-padding">
                                                <button type="submit" class="btn btn-primary pull-right">Submit</button>
                                            </div>
                                        </div>
                                        <?php /* ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="chk_remember" id="remember" <?php echo $checked?>/><span class="rem-me">Remember Me</span>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                        <?php */?>
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
