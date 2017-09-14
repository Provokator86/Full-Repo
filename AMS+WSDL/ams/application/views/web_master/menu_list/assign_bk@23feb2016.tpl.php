<?php
/*********
* Author: SW
* Date  : 
* Modified By: 
* Modified Date: 
* Purpose:
*  View For Assigning Pages To Menu
* @package General*
* @link My_Controller.php
* @link views/menu_list/assign_pages/
*/
?>
<?php /*?>
<link href="resource/navigation/css/jquery-ui-1.8.21.custom.css" rel="stylesheet">
<link href='resource/navigation/css/fullcalendar.css' rel='stylesheet'>
<link href='resource/navigation/css/fullcalendar.print.css' rel='stylesheet'  media='print'>
<link href='resource/navigation/css/chosen.css' rel='stylesheet'>
<link href='resource/navigation/css/uniform.default.css' rel='stylesheet'>
<link href='resource/navigation/css/colorbox.css' rel='stylesheet'>
<link href='resource/navigation/css/jquery.cleditor.css' rel='stylesheet'>
<link href='resource/navigation/css/jquery.noty.css' rel='stylesheet'>
<link href='resource/navigation/css/noty_theme_default.css' rel='stylesheet'>
<link href='resource/navigation/css/elfinder.min.css' rel='stylesheet'>
<link href='resource/navigation/css/elfinder.theme.css' rel='stylesheet'>
<link href='resource/navigation/css/jquery.iphone.toggle.css' rel='stylesheet'>
<link href='resource/navigation/css/opa-icons.css' rel='stylesheet'>
<link href='resource/navigation/css/uploadify.css' rel='stylesheet'>    
    <!-- Acumen project oriented CSS  -->
<link href="resource/navigation/css/acu.css" rel="stylesheet">        
<link href="resource/navigation/css/project.css" rel="stylesheet">
<link href="resource/navigation/css/sbc.css" rel="stylesheet">
<link href="resource/navigation/css/common.css" rel="stylesheet">
<?php */?>
<?php /*?>
<!--<script src="resource/navigation/js/jquery-1.7.2.min.js"></script>-->
<script src="resource/navigation/js/jquery.jeditable.mini.js"></script>
<!-- jQuery UI -->
<!--<script src="resource/navigation/js/jquery-ui.js"></script>-->
<script src="resource/navigation/js/jquery-ui-timepicker-addon.js"></script> 
<script src="resource/navigation/js/bootstrap.min.js"></script>
<script src="resource/navigation/js/jquery.cookie.js"></script>
<!-- calander plugin -->
<script src='resource/navigation/js/fullcalendar.min.js'></script>
<!-- data table plugin -->
<script src='resource/navigation/js/jquery.dataTables.min.js'></script>
<script src="resource/navigation/js/jquery.multiFieldExtender.js"></script>
<!-- checkbox, radio, and file input styler -->
<script src="resource/navigation/js/jquery.uniform.min.js"></script>
<!-- plugin for gallery image view -->
<script src="resource/navigation/js/jquery.colorbox.min.js"></script>
<!-- rich text editor library -->
<script src="resource/navigation/js/jquery.cleditor.min.js"></script>
<!-- notification plugin -->
<script src="resource/navigation/js/jquery.noty.js"></script>
<!-- file manager library -->
<script src="resource/navigation/js/jquery.elfinder.min.js"></script>
<!-- star rating plugin -->
<script src="resource/navigation/js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="resource/navigation/js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="resource/navigation/js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="resource/navigation/js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<!--<script src="resource/navigation/js/jquery.history.js"></script>

<script src="resource/navigation/js/jquery.blockUI.min.js"></script>
<script src="resource/navigation/js/jqueryFileDownloader.js"></script>-->

<!--<script src="resource/navigation/js/sbc.js"></script>
<script src="resource/navigation/js/common.js"></script>
<script src="resource/navigation/js/jquery.chosen.min.js"></script>-->
<!-- application script for Charisma demo -->
<!--<script src="resource/navigation/js/charisma.js"></script>-->
<?php */?>
<script type="text/javascript" src="resource/web_master/js/jquery.mjs.nestedSortable.js"></script>
<link href="<?php echo r_path('js/plugins/noty/noty_theme_default.css')?>" rel="stylesheet" type="text/css">
<link href="<?php echo r_path('js/plugins/noty/jquery.noty.css')?>" rel="stylesheet" type="text/css">
<script src="<?php echo base_url()?>resource/web_master/js/plugins/noty/jquery.noty.js" type="text/javascript"></script>
<!--
<style type="text/css">

.placeholder {
    outline: 1px dashed #4183C4;
    /*-webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    margin: -1px;*/
}
.formfield{
    margin: 5px 0;
}

.mjs-nestedSortable-error {
    background: #fbe3e4;
    border-color: transparent;
}

ol {
    margin: 0;
    padding: 0;
    padding-left: 30px;
}

ol.sortable, ol.sortable ol {
    margin: 0 0 0 25px;
    padding: 0;
    list-style-type: none;
}

ol.sortable {
    margin: 4em 0;
}

.sortable li {
    margin: 5px 0 0 0;
    padding: 0;
}

.sortable li div  {
    border: 1px solid #d4d4d4;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
    border-color: #D4D4D4 #D4D4D4 #BCBCBC;
    padding: 6px;
    margin: 0;
    cursor: move;
    background: #fff;
}

/*.sortable li.mjs-nestedSortable-branch div {
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

}

.sortable li.mjs-nestedSortable-leaf div {
    background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
    background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

}*/

li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
    border-color: #999;
    background: #fafafa;
}

.disclose {
    cursor: pointer;
    width: 10px;
    display: none;
}

.sortable li.mjs-nestedSortable-collapsed > ol {
    display: none;
}

.sortable li.mjs-nestedSortable-branch > div > .disclose {
    display: inline-block;
}

.sortable li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
    content: '+ ';
}

.sortable li.mjs-nestedSortable-expanded > div > .disclose > span:before {
    content: '- ';
}
</style>
-->
<script type="text/javascript">

var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
$(document).ready(function(){


$('#menu_parent_id').on('change',function(){
   window.location.href = g_controller+'assign_pages/'+$(this).val(); 
});

$('.btn_assign_cms').on('click',function(){
   var form_data = $('#assign_form_cms').serialize(); 
   
   //open_dialog();
   blockUI();
   $.ajax({    
        type: "POST",    
        url: g_controller+'ajax_assign_pages/',    
        data: 'menu_id='+$('#h_id').val()+'&'+form_data,
        dataType: "json",
        success: function(data) {
            //console.log(data);
             //close_dialog();
             
             unblockUI(); 
            $('#assign_form_cms').trigger("reset");
            $( "div#assigned_pages" ).html(data.content);
            window.location.reload();
            //alert(data.content);   
            //$('input[type="checkbox"]').attr('checked',false);
            //$('#assign_form_cms').trigger("reset");
          /*  $('input[type="checkbox"]').prop('checked', false);
            
            $('input[type="checkbox"]').each(function(){
                $(this).prop('checked', false);
                $(this).addClass('ddd');
            })*/
            
            //$( "div#assigned_pages" ).html(data.content);
            
        }
    });        
})

$( "#sortable" ).sortable({
      placeholder: "ui-state-highlight",
      start: function( event, ui ) {
          console.log(event);
          console.log(ui);
      },    
      update: function( event, ui ) {
                    
                    var ids = ''; 
                   
                    jQuery("ul#sortable li").each(function(e){
                        id = jQuery(this).attr("itemid");
                        //ids.push(id);
                        ids +=id+'-';
                        
                    });
                    
                    //console.log(ids);
                    //JSON.stringify(postData)
                    
                    
                    //Pop up here
                    
                    open_dialog();
                        
                    jQuery.ajax({
                        type: "POST",
                        url: g_controller+'ajax_sort_pages/'+$('#h_id').val(),  
                        data: 'menu_id='+$('#i_parent_id').val()+"&data="+escape(ids)+"&sort_pages=1",
                        success: function(response) {    
                        //jQuery('.ajax_loading').hide();
                        close_dialog();    
                        },
                        error: function(xhr, textStatus, errorThrown) {
                        console.log(textStatus+' '+xhr.status+': '+errorThrown);            
                        }  
                    });
                    
                }     
                
});

$( "#sortable" ).disableSelection();

$('#sortable input, #sortable select').on('click.sortable mousedown.sortable',function(ev){
    ev.target.focus();
})
  
$('.ui-icon').on('click',function(){   
    $(this).next('.sortable_content').toggle();    
})  

$('.menu_cancle').on('click',function(){
    
    $(this).parents('.sortable_content').hide();
    var obj = $(this).parents('.sortable_content').parent().find('.ui-sortable-handle').children('.show_content');
    if(obj.html() == '&nbsp;<i class="fa fa-plus">&nbsp;</i>')
        obj.html('&nbsp;<i class="fa fa-minus">&nbsp;</i>');
    else
        obj.html('&nbsp;<i class="fa fa-plus">&nbsp;</i>');
    
});

$('.show_content').on('click',function(){   
   
    var up = $(this).attr('rel');
    var con = '#c_'+up;
    $(this).parents('li#list_'+up).find(con).toggle('blind', '', 500);    
    if($(this).html() == '&nbsp;<i class="fa fa-plus">&nbsp;</i>')
        $(this).html('&nbsp;<i class="fa fa-minus">&nbsp;</i>');
    else
        $(this).html('&nbsp;<i class="fa fa-plus">&nbsp;</i>');
});

$('.menu_delete').on('click',function(){
        var _this= $(this);      
        //console.log($(_this).parents('li').find('input[name="i_id[]"]').val()); 
            if(confirm('Are You Sure To Remove This Menu Item?')){
            //console.log($(_this).parents('li').find('input[name="i_id[]"]').val());
            //console.log($(_this).parent().parent().parent().parent().parent().find('input[name="i_id[]"]').val());
            var pkId =  $(_this).parent().parent().parent().parent().parent().find('input[name="i_id[]"]').val(); 
            //console.log(pkId);
            open_dialog();
            
                $.ajax({    
                    type: "POST",    
                    url: g_controller+'ajax_delete_pages/',    
                    //data: 'i_id='+$(_this).parents('li[id=^list_]').find('input[name="i_id[]"]').val(),
                    data: 'i_id='+pkId,
                    dataType: "json",
                    success: function(data) {             
                        close_dialog();             
                        if(data.ret == '1'){                             
                            //$(_this).parents('.ui-state-default').remove();
                            //$(_this).parents('li[id=^list_]').remove();
                            $(_this).closest('li').remove();  
                            window.location.reload(); 
                                        
                        }
                    }
                }); 
    
            }
    
});  

$( "#accordion" ).accordion({
      collapsible: true,
      heightStyle: "content",
     
});

$( "#accordion" ).accordion( "option", "active", 2 );   
   
$('#btn_cancel').on('click',function(){
	 window.location.href=g_controller; 
});    


$('.btn_save_cms').on('click',function(){
    var form_data = $('#save_form_cms').serialize(); 
   
   //open_dialog();
   blockUI();
    $.ajax({    
        type: "POST",    
        url: g_controller+'ajax_save_pages/',    
        data: 'menu_id='+$('#h_id').val()+'&'+form_data,
        dataType: "json",
        success: function(data) {
            //close_dialog();    
            //unblockUI();
            $( "ol.sortable" ).html(data.content);
            window.location.reload();
        }
    });
    
});   

}); 

  
var pop_up = jQuery("<div></div>");   
function open_dialog(){   
   
   
    pop_up.html('Loading...').dialog({

        title:"Please wait......", 
        width:400, 
        height:50,
        modal:true,
        position: "center", 
        draggable: false,                    
        create: function (event, ui) {
        //jQuery(".ui-widget-header").hide();
        jQuery(".ui-dialog-titlebar").hide();
        }

    }); 
}

function close_dialog(){      
    
    pop_up.dialog('close');    
  
} 

$(document).ready(function(){

    $('ol.sortable__').nestedSortable({
        forcePlaceholderSize: true,
        handle: 'div',
        helper: 'clone',
        items: 'li',
        opacity: .6,
        placeholder: 'placeholder',
        revert: 250,
        tabSize: 25,
        tolerance: 'pointer',
        toleranceElement: '> div',
        maxLevels: 10,

        isTree: true,
        expandOnHover: 700,
        startCollapsed: true,
        
        update: function(t){
            /*arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            arraied = dump(arraied); 
            serialized = $('ol.sortable').nestedSortable('serialize');*/
            
            arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            arraied = dump(arraied);
            
            $.ajax({
                  //url : 'http://192.168.88.34/baby_face/nestedSortable-master/nestedSortable-master/a.php',
                  url: g_controller+'ajax_sort_level_pages/',
                  data : 'test='+arraied+'&menu_id='+$('#h_id').val(),
                  type : 'post',
                  success : function(response){
                      
                     console.log(response); 
                      
                  }
                
            })
            
            
        }
    });

    $('.disclose').on('click', function() {
        $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
    })

    $('#serialize').click(function(){
        serialized = $('ol.sortable').nestedSortable('serialize');
        $('#serializeOutput').text(serialized+'\n\n');
    })

    $('#toHierarchy').click(function(e){
        hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
        hiered = dump(hiered);
        (typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
        $('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
    })

    $('#toArray').click(function(e){
        arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
        arraied = dump(arraied);
        (typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
        $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
    })

});

/*$(document).on('click', '.disclose', function() {
    $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
});*/

function dump(arr,level) {
    var dumped_text = "";
    if(!level) level = 0;

    //The padding given at the beginning of the line.
    var level_padding = "";
    for(var j=0;j<level+1;j++) level_padding += "";

    if(typeof(arr) == 'object') { //Array/Hashes/Objects
        for(var item in arr) {
            var value = arr[item];

            if(typeof(value) == 'object') { //If it is an array,
                //if(item=='parent_id' || item=='item_id') {add =  ' => "0"';}
                //else {add =  '\'~';}
                if(item=='parent_id' || item=='item_id') {add =  '=>0';}
                else {add =  '~';}
                
                //dumped_text += level_padding + "'" + item  + add +" \n";
                dumped_text +=  add;
                dumped_text += dump(value,level+1);
            } else {
                if(item=='parent_id' || item=='item_id')
                //dumped_text += level_padding + "'" + item + "' => \"" + value + " ',\"\n";
                dumped_text +=   "=>" + value;
            }
        }
    } else { //Strings/Chars/Numbers etc.
        dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
    }
    return dumped_text;
}

</script>
<style type="text/css">
    #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
    #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; /*height: 18px;*/ }
    #sortable li span { position: absolute; margin-left: -1.3em; }

    .ui-widget-content{background: #ffffff;}
    .ltcustom .ui-accordion-header {line-height: 30px; padding-left: 5px;}
    .ltcustom {float: left; width: 350px;}

    .rtcustom {float: right;  width: 700px;}
    .ltcustom .ui-icon {float: right !important; margin-top: 8px !important; position : static !important;}
    .ltcustom .ui-state-active {/* background: none repeat scroll 0 0 #776553 !important;*/ color: #FFFFFF !important;}
    .rtcustom_header {/*background: none repeat scroll 0 0 #776553;*/ min-height: 32px;}
    .rtcustom_header_lt {float: left; width: 200px; padding: 2px;}
    .rtcustom_header_rt {float: right; text-align: right; width: 300px; padding: 2px;}
    .rtcustom_content { padding: 5px;}
    #assigned_pages{ min-height: 550px;}
    .sortable_content {background: none repeat scroll 0 0 #ffffff; 
    /*min-height: 200px; */min-height: 50px;
    padding: 10px; font-size: 13px; display:none;}
    .sortable_content_left {float: left; width: 200px; border: 0 !important;}
    .sortable_content_right {float: left; border: 0 !important;}
    .clr { clear: both; border: 0 !important;}
    .sortable_content a {text-decoration: underline !important;}
    .sortable_content a:hover {text-decoration: none !important;}
    .placeholder {outline: 1px dashed #4183C4;}
    .mjs-nestedSortable-error { background: #fbe3e4; border-color: transparent;}
    #tree {width: 550px; margin: 0;}
    ol:first-child{padding-left: 0 !important;}
    ol {max-width: 100%; padding-left: 25px;}
    ol.sortable,ol.sortable ol {list-style-type: none;}
    .sortable li div {border: 1px solid #d4d4d4; -webkit-border-radius: 3px; -moz-border-radius: 3px; border-radius: 3px;   cursor: move; border-color: #D4D4D4 #D4D4D4 #BCBCBC; margin: 0; padding: 3px;}
    li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div { border-color: #999;}
    .disclose, .expandEditor {cursor: pointer; width: 20px; display: none;}
    .sortable li.mjs-nestedSortable-collapsed > ol {display: none;}
    .sortable li.mjs-nestedSortable-branch > div > .disclose {display: inline-block;}
    .sortable span.ui-icon {display: inline-block; margin: 0; padding: 0;}
    .menuDiv {background: #EBEBEB;}
    .menuEdit {background: #FFF;}
    .itemTitle {vertical-align: middle; cursor: pointer;}
    .deleteMenu {float: right; cursor: pointer;}
    .ui-sortable-handle{margin-bottom: 5px !important;}
    .col-md-12, .col-md-12>div {border: none !important;}    
    .formfield{ margin: 5px 0; }
</style>

<?php
    if(!empty($posted)) extract($posted);    
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
             <?php show_all_messages(); echo validation_errors();?>
             <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-edit"></i>
                    <h3 class="box-title"><?php echo $heading;?></h3>
                </div>
                <div class="box-body">
                    <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
                    
                    <div class="col-md-4 no-padding-left">
                        <div class="form-group">
                            <label>Select A Menu :</label>  
                            <select name="menu_parent_id" id="menu_parent_id" class="form-control">
                                <?php echo getOptionMenu( $posted["h_id"] );?>
                            </select>
                        </div>
                        <div class="projectLt">
                                <form id="assign_form_cms">
                                <!-- -->
                                <div id="accordion">
                                    <h3>Pages</h3>
                                    <div>
                                    <?php 
                                    $page_html = getCheckPages();
                                    echo $page_html;
                                    if($page_html!=''){
                                    ?>
                                    <p><button type="button" name="btn_assign_cms" class="btn btn-primary btn_assign_cms"><?php echo  addslashes("Add to Menu")?></button></p>
                                    <?php } else{
                                        echo '<p>No more page found.</p>';
                                    } ?>
                                    </div>
                                    
                                    <!--<h3>Links</h3>
                                    <div>
                                    <div class="formfield clearfix">                                   
                                        <?php //echo custom_lang('URL', 'URL');?>
                                        <input type="text" id="link_url" name="link_url" value="http://">
                                        <span class="help-inline"></span>
                                    </div> 
                                    <div class="formfield clearfix">                                   
                                        <?php //echo custom_lang('link_text', 'link_text');?>
                                        <input type="text" id="link_text" name="link_text" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                    <p><button type="button" name="btn_assign_cms" class="btn btn-primary btn_assign_cms"><?php echo  addslashes("Add to Menu")?></button></p> 
                                    </div>-->                                    
                                    
                                </div>
                                <!-- -->
                                </form> 
                          </div>
                    </div>  
                    <div class="col-md-8">
                        <label>&nbsp;</label>
                        <div class="projectRt ui-widget-content">
                                <form id="save_form_cms">
                                <div class="formfield clearfix">    
                                     <div class="rtcustom_header">
                                        <div class="rtcustom_header_lt"><h3><?php echo 'Menu Name';?> : <?php echo $s_name;?></h3></div>
                                        <div class="rtcustom_header_rt"><button type="button" name="btn_save_cms_1" class="btn btn-primary btn_save_cms"><?php echo  addslashes("Save Menu")?></div>
                                    </div>                               
                                </div> 
                                <div style="clear:both"></div>
                                <div class="rtcustom_content"> 
                                    <h3><?php echo 'Menu Structure';?></h3>
                                    <div class="formfield clearfix">
                                    Drag each item into the order you prefer. Click the arrow on the left of the item to reveal additional configuration options.
                                    </div>
                                
                                    <div id="assigned_pages">
                                        <?php
                                        if(!empty($content)){
                                        ?>
                                        <!--<ul id="sortable"> 
                                            <?php echo $content;?>
                                        </ul>-->
                                        <?php echo $content;?>
                                        <?php
                                        }
                                        ?> 
                                    </div>
                                </div>
                                
                                <div class="formfield clearfix">    
                                     <div class="rtcustom_header">
                                        <div class="rtcustom_header_rt"><button type="button" name="btn_save_cms_2" class="btn btn-primary btn_save_cms pull-right"><?php echo  addslashes("Save Menu")?></div>
                                    </div>                               
                                </div> 
                                <div style="clear:both"></div>
                                                            
                                </form> 
                                <div style="clear:both"></div>
                                
                          </div>
                    </div>                    
                      
                    <div class="clearfix"></div>
                    <div class="control-group">  
                          <label class="control-label" for="focusedInput"><?php //echo addslashes("CMS")?></label>
                            <div class="controls">
                              <span class="help-inline"></span>     
                            </div>
                        </div> 
                       
                    <div class="form-group">
                         <!-- <button type="button" id="btn_save" name="btn_save" class="btn btn-primary"><?php echo  addslashes("Save changes")?></button>-->
                          <button type="button" id="btn_cancel" name="btn_cancel" class="btn"><?php echo  addslashes("Cancel")?></button>
                    </div>
                </div>
             </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var ns = $('ol.sortable').nestedSortable({
            forcePlaceholderSize: true,
            handle: 'div',
            helper:    'clone',
            items: 'li',
            opacity: .6,
            placeholder: 'placeholder',
            revert: 250,
            tabSize: 25,
            tolerance: 'pointer',
            toleranceElement: '> div',
            maxLevels: 10,
            isTree: true,
            expandOnHover: 700,
            startCollapsed: false,
            change: function(){
                /*arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
                console.log(arraied);
                arraied = dump(arraied);
                console.log(arraied);*/
            },
            update: function(){
                serialized = $('ol.sortable').nestedSortable('serialize');
                $.ajax({
                  url: g_controller+'ajax_sort_level_pages/',
                  data : serialized+'&menu_id='+$('#h_id').val(),
                  type : 'post',
                  dataType: 'json',
                  success : function(response){
                     // Notify user
                        $.noty.closeAll()
                        noty({"text":response.msg,"layout":"bottomRight","type":response.status});
                  }
                });
            }
        });
        
        /*$('.expandEditor').attr('title','Click to show/hide item editor');
        $('.disclose').attr('title','Click to show/hide children');
        $('.deleteMenu').attr('title', 'Click to delete item.');
    
        $('.disclose').on('click', function() {
            $(this).closest('li').toggleClass('mjs-nestedSortable-collapsed').toggleClass('mjs-nestedSortable-expanded');
            $(this).toggleClass('ui-icon-plusthick').toggleClass('ui-icon-minusthick');
        });
        
        $('.expandEditor, .itemTitle').click(function(){
            var id = $(this).attr('data-id');
            $('#menuEdit'+id).toggle();
            $(this).toggleClass('ui-icon-triangle-1-n').toggleClass('ui-icon-triangle-1-s');
        });
        
        $('.deleteMenu').click(function(){
            var id = $(this).attr('data-id');
            $('#menuItem_'+id).remove();
        });
            
        $('#serialize').click(function(){
            serialized = $('ol.sortable').nestedSortable('serialize');
            $('#serializeOutput').text(serialized+'\n\n');
        })

        $('#toHierarchy').click(function(e){
            hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
            hiered = dump(hiered);
            (typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
            $('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
        })

        $('#toArray').click(function(e){
            arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
            arraied = dump(arraied);
            (typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
            $('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
        });*/
    });            

    function dump(arr,level) {
        var dumped_text = "";
        if(!level) level = 0;

        //The padding given at the beginning of the line.
        var level_padding = "";
        for(var j=0;j<level+1;j++) level_padding += "    ";

        if(typeof(arr) == 'object') { //Array/Hashes/Objects
            for(var item in arr) {
                var value = arr[item];

                if(typeof(value) == 'object') { //If it is an array,
                    dumped_text += level_padding + "'" + item + "' ...\n";
                    dumped_text += dump(value,level+1);
                } else {
                    dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
                }
            }
        } else { //Strings/Chars/Numbers etc.
            dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
        }
        return dumped_text;
    }
</script>
