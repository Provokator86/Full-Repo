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


<style type="text/css">

       

        .placeholder {
            outline: 1px dashed #4183C4;
            /*-webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            border-radius: 3px;
            margin: -1px;*/
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
            background: #776553;
            
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#ededed',GradientType=0 );
        }

        .sortable li.mjs-nestedSortable-branch div {
            background: #776553;

        }

        .sortable li.mjs-nestedSortable-leaf div {
            background: #776553;

        }

        li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
            border-color: #999;
            background: #fafafa;
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
    
<script>

var g_controller="<?php echo $pathtoclass;?>"; //controller Path 
$(document).ready(function(){




$('#menu_parent_id').live('change',function(){
   window.location.href = g_controller+'assign_pages/'+$(this).val(); 
});

$('.btn_assign_cms').live('click',function(){
   var form_data = $('#assign_form_cms').serialize(); 
   
   open_dialog();
    $.ajax({    
        type: "POST",    
        url: g_controller+'ajax_assign_pages/',    
        data: 'menu_id='+$('#h_id').val()+'&'+form_data,
        dataType: "json",
        success: function(data) {
            //console.log(data);
             close_dialog(); 
            $('#assign_form_cms').trigger("reset");
            $( "div#assigned_pages" ).html(data.content);
           
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

$('#sortable input, #sortable select').live('click.sortable mousedown.sortable',function(ev){
    ev.target.focus();
  

  })
  
$('.ui-icon').live('click',function(){   
    $(this).next('.sortable_content').toggle();    
})  

$('.menu_cancle').live('click',function(){
    
    $(this).parents('.sortable_content').hide();
    
});


$('.show_content').live('click',function(){   
   
    var up = $(this).attr('rel');
    var con = '#c_'+up;
    $(this).parents('li#list_'+up).find(con).toggle();    
    
});

$('.menu_delete').live('click',function(){
        var _this= $(this);        
            if(confirm('Are You Sure To Remove This Menu Item?')){
                
            open_dialog();
            
                $.ajax({    
                    type: "POST",    
                    url: g_controller+'ajax_delete_pages/',    
                    //data: 'i_id='+$(_this).parents('.ui-state-default').find('input[name="i_id[]"]').val(),
                    data: 'i_id='+$(_this).parents('li[id=^list_]').find('input[name="i_id[]"]').val(),
                    dataType: "json",
                    success: function(data) {             
                        close_dialog();             
                        if(data.ret == '1'){                             
                            //$(_this).parents('.ui-state-default').remove();
                            //$(_this).parents('li[id=^list_]').remove();
                            $(_this).closest('li').remove();               
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
   
$('#btn_cancel').live('click',function(){
	 window.location.href=g_controller; 
});    


$('.btn_save_cms').live('click',function(){
    var form_data = $('#save_form_cms').serialize(); 
   
   open_dialog();
    $.ajax({    
        type: "POST",    
        url: g_controller+'ajax_save_pages/',    
        data: 'menu_id='+$('#h_id').val()+'&'+form_data,
        dataType: "json",
        success: function(data) {
            
            close_dialog();    
          console.log();
            $( "ol.sortable" ).html(data.content);
            
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

        $('ol.sortable').nestedSortable({
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
<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; /*height: 18px;*/ }
  #sortable li span { position: absolute; margin-left: -1.3em; }
  
  
  
  .ltcustom .ui-accordion-header {
  line-height: 30px;
  padding-left: 5px;
}

.ltcustom {
  float: left;
  width: 350px;
}

.rtcustom {
  float: right;
  width: 700px;
}

.ltcustom .ui-icon {
  float: right !important;
  margin-top: 8px !important;
  position : static !important;
}

.ltcustom .ui-state-active {
    background: none repeat scroll 0 0 #776553 !important;
    color: #FFFFFF !important; 
}

.rtcustom_header {
  background: none repeat scroll 0 0 #776553;
  min-height: 32px;
}

.rtcustom_header_lt {
  float: left;
  width: 200px;
  padding: 2px;
}

.rtcustom_header_rt {
  float: right;
  text-align: right;
  width: 300px;
  padding: 2px;
}

.rtcustom_content {
  padding: 5px;
}

.sortable_content {
  background: none repeat scroll 0 0 #b09c79;
  min-height: 200px;
  padding: 10px;
  font-size: 13px;
  display: none;
}

.sortable_content_left {
  float: left;
  width: 200px;
  border: 0 !important;
}

.sortable_content_right {
  float: left;
  border: 0 !important; 
}
.clr {
    clear: both;
     border: 0 !important; 
}
.sortable_content a {
    text-decoration: underline !important;
}
.sortable_content a:hover {
    text-decoration: none !important;
}
</style>

<?php
    if(!empty($posted)) extract($posted);    
?>
<div id="content" class="span10">
			<!-- content starts -->
		
			<?php echo admin_breadcrumb($BREADCRUMB); ?>
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header well" data-original-title>
						<h2><i class="icon-edit"></i> <?php echo $title;?></h2>
						<div class="box-icon">
                            <a href="#" class="btn btn-round" id="btn_add_record"><i class="icon-plus"></i></a>							
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
                    
                    <div class="box-content">	
                   
                  
						
                        <input type="hidden" id="h_id" name="h_id" value="<?php echo $posted["h_id"];?>"> 
						  
                          
                          <div class="form-actions">
                              Select A Menu : <select name="menu_parent_id" id="menu_parent_id">                                  
                                    <?php echo getOptionMenu( $posted["h_id"] );?>
                                    </select>
                              
                            </div>
                            
                          <div class="formBox">  
                          
                              <div class="projectLt ltcustom">
                                    
                                    <form id="assign_form_cms">
                                    <!-- -->
                                    
                                    <div id="accordion">
                                        <h3>Pages</h3>
                                        <div>
                                        <?php echo getCheckPages();?>
                                        <p> <button type="button" name="btn_assign_cms" class="btn btn-primary btn_assign_cms"><?php echo  addslashes(custom_lang_display("Add to Menu"))?></button></p>
                                        </div>
                                        <h3>Links</h3>
                                        <div>
                                        <div class="formfield clearfix">                                   
                                            <?php echo custom_lang('URL', 'URL');?>
                                            <input type="text" id="link_url" name="link_url" value="http://">
                                            <span class="help-inline"></span>
                                        </div> 
                                        <div class="formfield clearfix">                                   
                                            <?php echo custom_lang('link_text', 'link_text');?>
                                            <input type="text" id="link_text" name="link_text" value="">
                                            <span class="help-inline"></span>
                                        </div>
                                        <p><button type="button" name="btn_assign_cms" class="btn btn-primary btn_assign_cms"><?php echo  addslashes(custom_lang_display("Add to Menu"))?></button></p> 
                                        </div>
                                        
                                      
                                        
                                        
                                    </div>
                                    
                                    <!-- -->
                                    </form> 
                                    
                                   
                              </div>
                              
                              <div class="projectRt rtcustom ui-widget-content">
                                    
                                    
                                    <form id="save_form_cms">
                                    
                                    <div class="formfield clearfix">    
                                    
                                     <div class="rtcustom_header">
                                        <div class="rtcustom_header_lt"><h3><?php echo custom_lang_display('menu_name');?> : <?php echo $s_name;?></h3></div>
                                        <div class="rtcustom_header_rt"><button type="button" name="btn_save_cms_1" class="btn btn-primary btn_save_cms"><?php echo  addslashes(custom_lang_display("Save Menu"))?></div>
                                    </div>                               
                                                                        
                                    </div> 
                                    
                                    <div style="clear:both"></div>
                                     
                                    <div class="rtcustom_content"> 
                                    <h3><?php echo custom_lang_display('Menu Structure');?></h3>
                                    
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
                                    
                                    <p></p>
                                    <div style="clear:both"></div>
                                    <div class="rtcustom_header">
                                        <div class="rtcustom_header_lt"><h3><?php echo custom_lang_display('menu_name');?> : <?php echo $s_name;?></h3></div>
                                        <div class="rtcustom_header_rt"><button type="button" name="btn_save_cms_2" class="btn btn-primary btn_save_cms"><?php echo  addslashes(custom_lang_display("Save Menu"))?></div>
                                    </div>                               
                                                                        
                                     
                                    </form> 
                                    
                                
                              </div>
                              
                          </div>           							
                          
                          
                          <div class="clear"></div>
                            <div class="control-group">  
							  <label class="control-label" for="focusedInput"><?php //echo addslashes(custom_lang_display("CMS"))?></label>
								<div class="controls">
								  
								  <span class="help-inline"></span> 	
                                </div>
							</div> 
                           
                           
                            
							<div class="form-actions">
							  <button type="button" id="btn_save" name="btn_save" class="btn btn-primary"><?php echo  addslashes(custom_lang_display("Save changes"))?></button>
							  <button type="button" id="btn_cancel" name="btn_cancel" class="btn"><?php echo  addslashes(custom_lang_display("Cancel"))?></button>
							</div>
						  
						

					</div>
					
				</div><!--/span-->

			</div><!--/row-->		

<!-- content ends -->
</div>