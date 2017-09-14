<?php
/*
* Head css and js file 
*/  
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<title>###SITE_NAME_UFC###</title>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<base href="<?php echo base_url(); ?>" />
<!-- Bootstrap 3.3.4 -->
<link href="<?php echo r_path('css/bootstrap.min.css')?>" rel="stylesheet" type="text/css">
<!-- Font Awesome Icons -->
<link href="<?php echo r_path('css/font-awesome.min.css')?>" rel="stylesheet" type="text/css">
<!-- Ionicons -->
<link href="<?php echo r_path('css/ionicons.min.css')?>" rel="stylesheet" type="text/css">
<!-- jvectormap -->
<link href="<?php echo r_path('css/jquery-jvectormap-1.2.2.css')?>" rel="stylesheet" type="text/css">
<!-- Theme style -->
<link href="<?php echo r_path('css/AdminLTE.min.css')?>" rel="stylesheet" type="text/css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link href="<?php echo r_path('css/_all-skins.min.css')?>" rel="stylesheet" type="text/css">
<!-- jQuery UI css -->
<link href="<?php echo r_path('js/jquery-ui/jquery-ui.min.css')?>" rel="stylesheet" type="text/css">

<?php /* Custome CSS Plugins ::: commented below as right now no need?>
<!-- colorbox -->
<link href="<?php echo r_path('js/plugins/colorbox/colorbox.css')?>" rel="stylesheet" type="text/css">
<!-- chosen -->
<link href="<?php echo r_path('js/plugins/chosen/chosen.min.css')?>" rel="stylesheet" type="text/css">
<!-- checkbox/radio/style -->
<link href="<?php echo r_path('css/iCheck/flat/blue.css')?>" rel="stylesheet" type="text/css">
<?php  End */ ?>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="<?php echo r_path('js/ie/html5shiv.min.js')?>"></script>
    <script src="<?php echo r_path('js/ie/.min.js')?>"></script>
<![endif]-->
<style type="text/css">.jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;z-index: 10000;}.jqsfield { color: white;font: 18px arial, san serif;text-align: left;}</style>
<!-- The fav icon -->
<link rel="icon" href="<?php echo base_url('resource/favicon.png')?>" type="image/png" />
<link rel="shortcut icon" href="<?php echo base_url('resource/favicon.ico')?>" type="img/x-icon" />
<!-- Custom style -->
<link href="<?php echo r_path('css/custom.css')?>" rel="stylesheet" type="text/css">
<!-- external javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo r_path('js/jQuery-2.1.4.min.js')?>"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="<?php echo r_path('js/bootstrap.min.js')?>" type="text/javascript"></script>
<!-- jQuery UI 1.11.1 -->
<script src="<?php echo r_path('js/jquery-ui/jquery-ui.min.js')?>" type="text/javascript"></script>
<!-- FastClick -->
<!--<script src="<?php echo r_path('js/fastclick.min.js')?>"></script>-->
<!-- AdminLTE App -->
<script src="<?php echo r_path('js/AdminLTE/app.min.js')?>" type="text/javascript"></script>


<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php echo r_path('js/AdminLTE/dashboard2.js')?>" type="text/javascript"></script-->

<!-- AdminLTE for demo purposes// commented below as right now no need -->
<!--<script src="<?php echo r_path('js/demo.js')?>" type="text/javascript"></script> 
<script src="<?php echo base_url()?>resource/web_master/js/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>  -->

<?php /* Custome javascript of Dev Team and plugins used */?> 
<!-- block ui -->
<script src="<?php echo base_url()?>resource/web_master/js/plugins/blockui/jquery.blockUI.js" type="text/javascript"></script>
<!-- colorbox -->
<?php /* commented below as right now no need ?>

<script src="<?php echo r_path('js/plugins/colorbox/jquery.colorbox-min.js')?>" type="text/javascript"></script>
<script src="<?php echo r_path('js/plugins/chosen/chosen.jquery.min.js')?>" type="text/javascript"></script>
<script src="<?php echo r_path('js/jquery.maskedinput.min.js')?>" type="text/javascript"></script>
<script src="<?php echo r_path('js/bootstrap3-typeahead.min.js')?>" type="text/javascript"></script>
<script src="<?php echo r_path('js/plugins/iCheck/icheck.min.js')?>" type="text/javascript"></script>
<script src="<?php echo r_path('js/custom_js/add_more.js')?>" type="text/javascript"></script> 
* * <?php */ ?>
<script src="<?php echo r_path('js/custom_js/swi.custom.js')?>" type="text/javascript"></script>
<!--<script src="<?php echo r_path('js/jquery.numberformatter-1.2.4.js')?>" type="text/javascript"></script>-->

<?php /* End */ ?>
<script type="text/javascript">
var g_controller = "<?php echo $pathtoclass;?>", search_action = '<?php echo $search_action;?>'; // Controller Path
var base_url = '<?php echo base_url(); ?>', focus_element = '';
</script>
<script src="<?php echo r_path('js/custom_js/add_edit_view.js')?>" type="text/javascript"></script> 
<!-- JS FOR SORTING ORDER BELOW -->
<script type="text/javascript" language="javascript" src="<?php echo base_url()?>resource/web_master/js/jquery.tablednd_0_5.js"></script> 
<!-- JS FOR SORTING ORDER -->
<script type="text/javascript">
	<!--
$(document).ready(function(){

    //$('.sidebar-toggle').click();    
    //CKEDITOR.config.title = false; // to remove the hover title on textarea box
            
    // Call the chosen dd
    /*$('[data-rel="chosen"],[rel="chosen"]').chosen({
        width:"100%",
        search_contains: true
    });*/
    
    // iCheck initialisation
    /*$("input:checkbox, input:radio").not('[data-no-uniform="true"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
    });*/
    /*$("input:checkbox").not('[data-no-uniform="true"]').iCheck({
        checkboxClass: 'icheckbox_flat-blue',
        radioClass: 'iradio_flat-blue',
    });*/
    
});
-->
</script>
