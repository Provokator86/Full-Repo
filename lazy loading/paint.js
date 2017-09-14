/*function mouseup_custom_callback(obj)
{
	// implemented in create_collage.tpl.php
}*/

function fontFamilyAdjustment(param)
{
	/*
	//never open this code
	if(param.fontFamily.indexOf('_bold_italic')>0)
	{
		param.fontFamily = param.fontFamily.split('_bold_italic')[0];
		param.fontWeight = 'bold';
		param.fontStyle = 'italic';
	}
	*/
	
	param = deep_clone(param);

	var fontFamily = (typeof param.fontFamily == 'undefined')?null:param.fontFamily; // paint_arial
	var fontWeight = (typeof param.fontWeight == 'undefined')?null:param.fontWeight; // bold
	//var textDecoration = (typeof param.textDecoration == 'undefined')?null:param.textDecoration; // underline
	var fontStyle = (typeof param.fontStyle == 'undefined')?null:param.fontStyle; // italic
	
	var suffix = '';
	if(fontWeight=='bold')
		suffix += '_bold';
	
	if(fontStyle=='italic')
		suffix += '_italic';
	
	fontFamily += suffix;
	
	param.fontFamily = fontFamily;
	param.fontWeight = 'normal';
	param.fontStyle = 'normal';
	
	//alert(param.fontFamily);
	
	return param;

}

function preload_img(url)
{
	if($('body img[src="'+url+'"]').length>0)
		return;
	var preload_img = $('<IMG style="display:none;">');
	preload_img.attr('src',url);
	$('body').append(preload_img);
}

function get_browser_dpi()
{
	var paint_dpi_obj = $('#paint_dpi_obj');
	
	if(paint_dpi_obj.length==0)
	{
		paint_dpi_obj = $('<DIV id="paint_dpi_obj" style="position:absolute; left:-100%; top: -100%; width:1in; height:1in;"></DIV>');
		$('body').append(paint_dpi_obj);
	}
	return paint_dpi_obj.width();
}
function get_php_dpi()
{
	return 96;
}
function get_dpi_percent()
{
	return Math.round(100*get_php_dpi()/get_browser_dpi());
}


function decode_json(json_str)
{
	var obj = null;
	json_str = json_str.replace(/\n/g," ").replace(/\r/g,"\\r"); // safty check // though redundant
	eval("obj = "+json_str+";");
	return obj;
}

////////////////////////////////////
function textEditableControlAutoAdjust(obj,span,textbox_parem,param)
{
			if(!param.editable)
				return;
	
			span.attr('contenteditable',true);
	
	
			span.bind('paste',function(){
				if(span.attr('contenteditable')==true || span.attr('contenteditable')=='true'){}
				else
					return;
				setTimeout(function(){
					obj.onChangeState();
					obj.obj_param.text = span.html();
					textbox_parem.text = span.html();
				
				},1000);
				
			});
	
			
	
			obj.keydown(function(){
				if(span.attr('contenteditable')==true || span.attr('contenteditable')=='true'){}
				else
					return;
				
				//span.css({minWidth:Math.round(obj.width()/2)+'px',minHeight:Math.round(obj.height()/2)+'px'}); // first key stroke ensure min dim
				span.css({
							minWidth:Math.round(parseInt(obj.obj_param.fontSize)*dpi_percent*0.01)+'px',
							minHeight:Math.round(parseInt(obj.obj_param.fontSize)*dpi_percent*0.01)+'px'}
				); // first key stroke ensure min dim
				
				obj[0].keydown_flag = true;
				
				if(typeof obj.keyDownTimer != "undefined" && obj.keyDownTimer!=null)
				{
					clearTimeout(obj.keyDownTimer);
					obj.keyDownTimer = null;
				}
				obj.keyDownTimer=setTimeout(function(){
					obj.keyDownTimer = null;
					obj.onChangeState();
					obj.obj_param.text = span.html();
					textbox_parem.text = span.html();
				},50);
				
			});
			
			disableSelection(span[0]);
			/*
			obj[0].mousedown_now = false;
			obj.mousedown(function(){
				obj[0].mousedown_now = true;
			});
			obj.mouseup(function(){
				obj[0].mousedown_now = false;
			});
			
			
			obj[0].check_edit_mousemove_timer = null;
			obj.mousemove(function(){
								   
				if(obj[0].mousedown_now && !(span.attr('contenteditable')==true || span.attr('contenteditable')=='true')){}
				else return;
				
				//disableSelection(span[0]);
				if(obj[0].check_edit_mousemove_timer!=null)
					clearTimeout(obj.check_edit_mousemove_timer);
				obj[0].check_edit_mousemove_timer = setTimeout(function(){
					obj[0].check_edit_mousemove_timer = null;
					//enableSelection(span[0]);
				},1000);
				
			});
			*/
			
			obj.click(function(){
				
				if(span.attr('contenteditable')==true || span.attr('contenteditable')=='true'){}
				else
					return;
				
				enableSelection(span[0]);
				obj[0].body_move_disabled = true;
				
				var text = $.trim(obj.convertToTextMode(span.html()));
				if(text=="")
					span.html('&nbsp;');
				setTimeout(function(){
					//span.click();
					span.focus();
				},100);
				
				/*
				if(span.width()<obj.width()/2)
				{
					var org_html = span.html();

					span.find('BR').remove();
					var html = $.trim(span.html());
					if(html=='')
					{
						span.html('...');
					}
					else
					{
						span.html(org_html);
					}					
				}
				*/

			});
			
			/*
			$(obj).dblclick(function(e){

					span.css({
								minWidth:Math.round(parseInt(obj.obj_param.fontSize)*dpi_percent*0.01)+'px',
								minHeight:Math.round(parseInt(obj.obj_param.fontSize)*dpi_percent*0.01)+'px'}
					); // enable ensure min dim

					paint.param.dragable = false;
					//span.attr('contenteditable',true);
					enableSelection(span[0]);
			});
			*/
			
			$(document).click(function(e){
				if(e.target==obj[0]  || is_child(obj,$(e.target))){}
				else
				{
					//paint.param.dragable = dragable;
					//span.attr('contenteditable',false);
					disableSelection(span[0]);
					obj[0].body_move_disabled = false;
					//setTimeout(function(){
						//obj.focus();
					//});
				}
			});

			/*
			obj.click(function(){
							   
				if(span.attr('contenteditable')==true || span.attr('contenteditable')=='true'){}
				else
					return;
							   
				//console.log(span.width()+'<'+obj.width()/2);
				if(span.width()<obj.width()/2)
				{
					var org_html = span.html();

					span.find('BR').remove();
					var html = $.trim(span.html());
					if(html=='')
					{
						span.html('...');
					}
					else
					{
						span.html(org_html);
					}					
				}
			});
			*/

			var paint;
			//var dragable;
			
			obj.cleanAllTagsOtherThanBrOnPaste = function()
			{
				//console.log(111);
				var child_tags = span.find(':not(BR)');
				if(child_tags.length>0)
				{
					//console.log(444);
					//child_tags.remove();
					//return;
					var str = span.html();
					str=str.replace(/<br>/gi, "\n");
					str=str.replace(/<br \/>/gi, "\n");
					str=str.replace(/<br\/>/gi, "\n");
					str=str.replace(/<p>/gi, "\n");
					str=str.replace(/<p .*>/gi, "\n");
					str=str.replace(/<\/p.*>/gi, "\n");
					//str=str.replace(/<a.*href="(.*?)".*>(.*?)<\/a>/gi, " $2 (Link->$1) ");
					str=str.replace(/<(?:.|\s)*?>/gi, "");
					//str=str.replace(/<.*?>/gi, "");
					
					str=str.replace(/</gi,"");
					str=str.replace(/>/gi,"");
					
					str = $.trim(str);
					str = str.replace(/\n/g,"<br>");
					span.html(str);
				}
				
				//var child_tags = span.find(':not(BR)');
				//child_tags.remove();
				
			}
			
			obj.convertToTextMode = function(html)
			{
				html = html.replace(/\n/g,'');
				html = html.replace(/\r/g,'');
				html = html.replace(/&nbsp;/g,' ');
				while(html.indexOf('  ')>-1)
				{
					html = html.replace("  ",' ');
				}
				html = html.replace(/<br>/gi,"\n");
				html = html.replace(/<br \/>/gi,"\n");
				html = html.replace(/<br\/>/gi,"\n");
				
				return html; // this is text with all BR tag converted to new line -> \n
			}
			
			obj.convertToHtmlMode = function(html)
			{
				html = html.replace(/\n/g,"<br>");
				return html; // this is text with all \n converted to BR tag
			}
			var dpi_percent; 
			obj.onChangeState = function()
			{
				//console.log(99999);
				obj.cleanAllTagsOtherThanBrOnPaste();
				
				if(typeof paint == "undefined")
				{
					obj.prev_html = '';
					obj.prev_span_width = span.width();
					obj.prev_span_height = span.height();
					
					paint = obj.paint;
					//dragable = paint.param.dragable;
					dpi_percent = get_dpi_percent();
					
					setInterval(function(){
							obj.monitorOverflow();
					},100);
				}
			}
	
			obj.monitorOverflowProcessingTimer = null;
			obj.monitorOverflowProcessing = function()
			{
				if(typeof textbox_parem.image_processing == "undefined")
					return;
				
				try{clearTimeout(obj.monitorOverflowProcessingTimer)}catch(e){}
				if(typeof obj[0].org_background == "undefined")
					obj[0].org_background = obj.css('background');
				obj.css({color:'transparent',background:'url("'+textbox_parem.image_processing+'") center center no-repeat transparent'});
				obj.monitorOverflowProcessingTimer = setTimeout(function(){
					obj.css({color:textbox_parem.color,background:obj[0].org_background});
				},1000);
			}
			
			obj.monitorOverflow = function()
			{
				//console.log(parseInt(textbox_parem.fontSize)+7);
				obj.obj_param.min_dim = parseInt(textbox_parem.fontSize)*2.5;
				obj.pdc_obj.obj_param.min_dim = parseInt(textbox_parem.fontSize)*2.5;
				
				if(typeof obj[0].body_move_disabled != "undefined" && obj[0].body_move_disabled == true)
					obj.css({cursor:'text'});
				//else
				//	obj.css({cursor:'default'});
			
				var padding = parseInt(textbox_parem.padding);

				
				var span_overflow_width = span.width()+padding*2 - Math.ceil(obj.obj_param.width);
				var span_overflow_height = span.height()+padding*2 - Math.ceil(obj.obj_param.height);

				if(	(typeof param.autoCropableOff =="undefined" || param.autoCropableOff == false)
					 &&
				   	(
				   		span_overflow_height>0 // - parseInt(textbox_parem.padding)*2 - parseInt(textbox_parem.border)/2
						|| span_overflow_width>0  //- parseInt(textbox_parem.padding)*2 - parseInt(textbox_parem.border)/2
					)
				)
				{
					if(typeof obj[0].keydown_flag == "undefined")
						obj[0].keydown_flag = false;
					
					if(!obj[0].keydown_flag)
						obj.monitorOverflowProcessing();
					obj[0].keydown_flag = false;
					
					var html = span.html();
					//console.log('before='+html);
					html = obj.convertToTextMode(html);
					//console.log('after removing br='+html);
					
					var sudden_length_diff = html.length - obj.prev_html.length;
					sudden_length_diff = Math.round(sudden_length_diff*0.30);
					//console.log(sudden_length_diff);
					if(sudden_length_diff<1)
						sudden_length_diff = 1;
					else if(sudden_length_diff>5)
						sudden_length_diff = 20;
					//var sudden_length_diff = 20;
				
				
					
					var chop_pos = getCaretPosition(span[0]);
					//alert(chop_pos);
					
					//if(chop_pos<=0)
						chop_pos = html.length-1;
					
					var before = html.substring(0,chop_pos);
					var after = html.substring(chop_pos,html.length-1);
					//console.log(before+','+after);
					//before = before.substring(0,before.length-2);
					//console.log(sudden_length_diff);
					//console.log('>'+before.length);
					if(before.length-sudden_length_diff>0)
						before = before.substring(0,before.length-sudden_length_diff);
					//console.log('>>'+before.length);
					
					html = before+after;
					
					//console.log('after choping='+html);
					html = obj.convertToHtmlMode(html);
					//console.log('after bringing back br='+html);
					span.html(html);
					//setTimeout(function(){
						//span[0].focus();
						setCaretPosition(span[0],chop_pos);
					//},100);
					//console.log(chop_pos);
					//i--;
					//i-=sudden_length_diff;
					//if(i<=0) break;
				}
				obj.prev_html = span.html();
				
				obj.obj_param.text = span.html();
				textbox_parem.text = span.html();
				
				var alert_open = false;
				var tmp_words = textbox_parem.text
									.replace(/\n/g,' ')
									.replace(/\r/g,' ')
									.replace(/\t/g,' ')
									.replace(/<br \/>/gi," ")
									.replace(/<br\/>/gi," ")
									.replace(/<br>/gi," ")
									.replace(/&nbsp;/gi," ")
									.split(' ');
				for(var jj=0;jj<tmp_words.length;jj++)
				{
					if(tmp_words[jj].length>45)
					{
						if(!alert_open)
						{
							alert_open = true;
							//setTimeout(function(){
								//alert('Max word length allowed is 20. Which has exceeded for the word '+tmp_words[jj]);
								obj.obj_param.text = obj.obj_param.text.replace(tmp_words[jj],tmp_words[jj].substring(0,45));
								textbox_parem.text = obj.obj_param.text;
								span.html(textbox_parem.text);
								obj.prev_html = span.html();
								setCaretPosition(span[0],0);
								alert_open = false;
							//},10);
						}
						break;
					}
				}
			}
	
}

/////////////////////////////////////


/*
function setCaretPosition(editableDiv,pos)
{
	var sel; 
		editableDiv.focus();
	if (document.selection) {
		sel = document.selection.createRange();
		sel.moveStart('character', pos);
		sel.select();
	}
	else {
		sel = window.getSelection();
		console.log(pos);
		sel.collapse(editableDiv.firstChild, pos);
	}
}
*/
/*
function setCaretPosition(editableDiv,pos)
{
	// has problem tested in else section.. if section not tested
	
	var el = editableDiv;
	var index = pos;
	
	if (el.createTextRange) 
	{
		var range = el.createTextRange();
		range.move("character", index);
		range.select();
	} else if (el.selectionStart != null) 
	{
		el.focus();
		el.setSelectionRange(index, index);
	}

}
*/
function setCaretPosition(editableDiv,pos){
		//console.log('pos='+pos);
		var node = editableDiv; // (typeof editableDiv == "string" || editableDiv instanceof String) ? document.getElementById(editableDiv) : editableDiv;
		if(!node){
			//console.log('return');
			return false;
		}else if(typeof node.createTextRange !="undefined"){
			//console.log('createTextRange');
			var textRange = node.createTextRange();
			textRange.collapse(true);
			//textRange.moveEnd(pos);
			//textRange.moveStart(pos);
			textRange.move('character', pos);
			textRange.select();
			return true;
		}else if(typeof node.setSelectionRange != "undefined"){
			//console.log('setSelectionRange');
			node.focus();
			node.setSelectionRange(pos,pos);
			return true;
		}
		else
		{
			var content = node;
			var char = pos;
			content.focus();
			if (typeof document.selection != "undefined") {
			  //console.log('selection');
			  var sel = document.selection.createRange();
			  sel.moveStart('character', char);
			  sel.select();
			}
			else if(typeof window.getSelection != "undefined") {
			  //console.log('getSelection');
			  /*
			  var sel = window.getSelection();
			  try{
				  	sel.collapse(content, char);
			  }catch(e){
				  sel.collapseToEnd();
			  }*/
			    var range = document.createRange();
				var sel = window.getSelection();
				//range.setStart(content.childNodes[0], char);
				
				// rather focus end of text
				if(content.childNodes.length>0)
					range.setStart(content.childNodes[content.childNodes.length-1], content.childNodes[content.childNodes.length-1].textContent.length);
				/*
				var char_traversed  =0;
				var char_traversed_till_prev_line = 0;
				for(var line = 0;line<content.childNodes.length;line++)
				{
					char_traversed+=content.childNodes[line].textContent.length;
					if(char_traversed>=char)
					{
						var t_pos = char-char_traversed_till_prev_line;
						//if(t_pos>content.childNodes[line].textContent.length)
						if(line>=content.childNodes.length-2)
							t_pos = content.childNodes[line].textContent.length-1;
						range.setStart(content.childNodes[line], t_pos);
					}
					char_traversed_till_prev_line = char_traversed;
				}
				*/
				range.collapse(true);
				sel.removeAllRanges();
				sel.addRange(range);
			}
		
		
		}
		return false;
}

function insertHtmlAtCursor(html) {
    var range, node;
    if (window.getSelection && window.getSelection().getRangeAt) {
        range = window.getSelection().getRangeAt(0);
        node = range.createContextualFragment(html);
        range.insertNode(node);
    } else if (document.selection && document.selection.createRange) {
        document.selection.createRange().pasteHTML(html);
    }
}

function getCaretPosition(editableDiv) 
{
	try{
		if(document.activeElement != editableDiv)
			return -1;
	}catch(e){}
	
	var org_html = editableDiv.innerHTML;
	var token = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	insertHtmlAtCursor(token);
	var pos  = editableDiv.innerHTML.indexOf(token);
	editableDiv.innerHTML = org_html;
	return pos;
}

/*
function getCaretPosition(editableDiv) {
    var caretPos = 0, containerEl = null, sel, range;
    if (window.getSelection) {
        sel = window.getSelection();
        if (sel.rangeCount) {
            range = sel.getRangeAt(0);
            if (range.commonAncestorContainer.parentNode == editableDiv) {
                caretPos = range.endOffset;
            }
        }
    } else if (document.selection && document.selection.createRange) {
        range = document.selection.createRange();
        if (range.parentElement() == editableDiv) {
            var tempEl = document.createElement("span");
            editableDiv.insertBefore(tempEl, editableDiv.firstChild);
            var tempRange = range.duplicate();
            tempRange.moveToElementText(tempEl);
            tempRange.setEndPoint("EndToEnd", range);
            caretPos = tempRange.text.length;
        }
    }
    return caretPos;
}
*/


function is_child($parent,$child)
{
	var found = false;
	$child.parents("*").each(function(){
		if($(this)[0]==$parent[0])
		{
			found = true;
			return;
		}
	});
	return found;
}

function lib_typeof(v)
{
	if(typeof v == "object")
	{
		if(typeof v.length != "undefined")
			return "array";
		else
			return "object";
	}
	else
		return typeof v;
}


function deep_extend(param,dflt)
{
	dflt=deep_clone(dflt);

	if(typeof param == "undefined" && typeof dflt == "undefined")
	{
		alert('Error in deep_extend: At least one parameter of this function should be valid.');
		return null;
	}
	else if(typeof param == "undefined")
		return dflt;
	else if(typeof dflt == "undefined")
		return param;
		
	if(param == null && dflt==null)
		return null;
	else if(param == null)
		return dflt;
	else if(dflt == null)
		return param;
	
	if(lib_typeof(param) != lib_typeof(dflt))
	{
		alert('Error in deep_extend: Type mismatch in function parameters.');			
		return null;
	}
	
	if(lib_typeof(param)=="object")
	{
		for(var prop in param)
		{
			if(typeof param[prop] == "object")
				dflt[prop]=deep_extend(param[prop],dflt[prop]);
			else
				dflt[prop]=param[prop];
		}
	}
	else if(lib_typeof(param)=="array")
	{
		var max_len = param.length>dflt.length?param.length:dflt.length;
		
		for(var i=0;i<max_len;i++)
		{
			if(i<param.length)
			{
				if(typeof param[i] == "object")
					dflt[i]=deep_extend(param[i],dflt[i]);
				else
					dflt[i]=param[i];	
			}
			else
			{
				//dflt[i]=dflt[i];	
			}
		}
	}
	else
	{
		dflt = param;
	}
	
	return dflt;
}

function deep_clone(v)
{
	if(typeof v == "undefined" || v == null)
		return null;
	
	var nv = null;
	
	if(lib_typeof(v)=="array")
	{
		nv  = Array();
		for(var i=0;i<v.length;i++)
		{
			nv[i]=deep_clone(v[i]);
		}
	}
	else if(lib_typeof(v)=="object")
	{
		nv = new Object();
		for(var prop in v)
		{
			nv[prop]=deep_clone(v[prop]);
		}
	}
	else
		nv = v;
	return nv;
}

function disableSelection(element) {
                if (typeof element.onselectstart != 'undefined') {
                    element.onselectstart = function() { return false; };
                } else if (typeof element.style.MozUserSelect != 'undefined') {
                    element.style.MozUserSelect = 'none';
                } else {
                    element.onmousedown = function() { return false; };
                }
}

function enableSelection(element) {
                if (typeof element.onselectstart != 'undefined') {
                    element.onselectstart = function() { return true; };
                } else if (typeof element.style.MozUserSelect != 'undefined') {
                    element.style.MozUserSelect = 'text'; // verify probable value for enabling it
                } else {
                    element.onmousedown = function() { return true; };
                }
}


/*
function get_absolute_position_x($obj)
{
	var x = $obj[0].offsetLeft;
	$obj.parents('*').each(function(){
		//if($(this).parent().length==1)
			x += $(this)[0].offsetLeft;
	});
	return x;
}
function get_absolute_position_y($obj)
{
	var y = $obj[0].offsetTop;
	var done = false;
	console.log(y+'=='+$obj[0].innerHTML);
	$obj.parents('*').each(function(){
		if(!done && $(this)[0]!=$('body')[0])
		{
			y += $(this)[0].offsetTop;
			console.log(y+'=='+$(this)[0].innerHTML);
		}
		else
			done = true;
	});
	return y;
}
*/
/*
function findPos(obj) {
 var obj2 = obj;
 var curtop = 0;
 var curleft = 0;
 if (document.getElementById || document.all) {
  do  {
   curleft += obj.offsetLeft-obj.scrollLeft;
   curtop += obj.offsetTop-obj.scrollTop;
   obj = obj.offsetParent;
   obj2 = obj2.parentNode;
   while (obj2!=obj) {
    curleft -= obj2.scrollLeft;
    curtop -= obj2.scrollTop;
    obj2 = obj2.parentNode;
   }
  } while (obj.offsetParent)
 } else if (document.layers) {
  curtop += obj.y;
  curleft += obj.x;
 }
 return [curleft,curtop];
}
*/
function getTopPos(inputObj)
{
	var ret = $(inputObj).offset().top;
	if($(inputObj).is(":visible"))
		return ret;
	
	//return findPos(inputObj)[1];
	/*
  var returnValue = inputObj.offsetTop - inputObj.scrollTop	+ inputObj.clientTop;
  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetTop - inputObj.scrollTop	+ inputObj.clientTop;
  return returnValue;
  */
  var returnValue = inputObj.offsetTop 	+ inputObj.clientTop;
  while((inputObj = inputObj.offsetParent) != null && ($(inputObj).css('position')!='absolute' || $(inputObj).css('position')!='relative') )
  	returnValue += inputObj.offsetTop 	+ inputObj.clientTop;
  
  
  
  return returnValue;
  
}

//$(document).click(function(e){alert(e.pageX+','+e.pageY)});

function getLeftPos(inputObj)
{
	var ret = $(inputObj).offset().left;
	if($(inputObj).is(":visible"))
		return ret;
	
	//return findPos(inputObj)[0];
	/*
  var returnValue = inputObj.offsetLeft - inputObj.scrollLeft 	+ inputObj.clientLeft;
  while((inputObj = inputObj.offsetParent) != null)returnValue += inputObj.offsetLeft - inputObj.scrollLeft	+ inputObj.clientLeft;
  return returnValue;
  	*/
	
	var returnValue = inputObj.offsetLeft  	+ inputObj.clientLeft;
  while((inputObj = inputObj.offsetParent) != null && ($(inputObj).css('position')!='absolute' || $(inputObj).css('position')!='relative') )
  	returnValue += inputObj.offsetLeft + inputObj.clientLeft;
  
  
  return returnValue;
}



if(typeof Paint == "undefined")
function Paint(param)
{

	var dflt = {
		id:'paint',
		left:'0',
		top:'0',
		width:'300',
		height:'300',
		border:'1px black solid',
		zIndex: 100000,
		backgroundColor:'#ffffff',
		position:'absolute',
		dragable : true,
		duringDragShowElementBeyondBorder: false,
		image_folder: 'paint/image/dotted_near/',
		images: {
			paint_drag_control_resize_diagonal_left_top: 'left_top.png',
			paint_drag_control_resize_diagonal_right_top: 'right_top.png',
			paint_drag_control_resize_diagonal_left_bottom: 'left_bottom.png',
			paint_drag_control_resize_diagonal_right_bottom: 'right_bottom.png',
			
			paint_drag_control_resize_vertical_top: 'vertical_top.png',
			paint_drag_control_resize_vertical_bottom: 'vertical_bottom.png',
			
			paint_drag_control_resize_horizontal_left: 'horizontal_left.png',
			paint_drag_control_resize_horizontal_right: 'horizontal_right.png',
			
			paint_drag_control_rotation: 'rotation.png',
			
			paint_drag_control_border_horizontal_top: 'horizontal_line_top.png',
			paint_drag_control_border_horizontal_bottom: 'horizontal_line_bottom.png',
			
			paint_drag_control_border_vertical_left: 'vertical_line_left.png',
			paint_drag_control_border_vertical_right: 'vertical_line_right.png'
		},
		pdc_dim:20,
		zoom: 100 // only affects pdc_dim and object that is zoomEnabled
	};

	param = deep_extend(param,dflt);

	param.pdc_dim = Math.round(param.pdc_dim * param.zoom /100);
	

	param.min_zIndex = param.zIndex+1;
	param.max_zIndex = param.zIndex;

	var self = 	$('<DIV class="paint_container" style="position:absolute;overflow:hidden;"></DIV>')
				.attr('id',param.id)
				.css({width:param.width+'px',height:param.height+'px',border:param.border,zIndex:param.zIndex,backgroundColor:param.backgroundColor,position:param.position,
						background:param.background
				});
	
	self.param = param;
	
	self[0].position_wrt_parent = function(){
		if(self.parent().length==1)
		{
			////////////////////////////
			// shadow box or absolute/relative container patch
			var leftAdjust = 0;
			var topAdjust = 0;
			
			self.parents('*').each(function(){
				var position = $(this).css('position');
				if(position == 'absolute' || position == 'relative')
				{
					leftAdjust = -getLeftPos($(this)[0]);
					topAdjust = -getTopPos($(this)[0]);
					return false;
				}
			});
			
			////////////////////////////
			
			
			
			var $parent = self.parent();
			//console.log(get_absolute_position_y($parent)+param.top*1);
			self.css({
						left:(getLeftPos($parent[0])+param.left*1+leftAdjust)+'px',
						top:(getTopPos($parent[0])+param.top*1+topAdjust)+'px'
					});
		}
	}
	/*
	setInterval(function(){
		if(self.css('position')=='absolute')
			self.position_wrt_parent();	
	},100);
	*/
	
	if(typeof Paint.prototype.position_wrt_parent == "undefined")
	{
		Paint.prototype.position_wrt_parent = true;
		setInterval(function(){
			$('.paint_container:visible').each(function(){
				try{
					if($(this).css('position')=='absolute')
						$(this)[0].position_wrt_parent();
				}catch(err){}
				
			});
		},100);
	}
	
	
	self.objArray = new Array();
	//self.addObj = function(obj,obj_param,cnt){
	self.addObj = function(obj,obj_param){
		
		obj.paint = self;
		
		var image_dflt = {
			min_dim:20,
			width:Math.ceil(param.width*0.33),
			height:Math.ceil(param.height*0.33),
			cx:Math.ceil(param.width*0.5),
			cy:Math.ceil(param.height*0.5),
			angle:0,
			dragable : true,
			overAllAspectRatio: false,
			diagonalAspectRatio: false,
			zoomEnabled: false,
			doNotPlaceOutside:false
		};
		obj_param = deep_extend(obj_param,image_dflt);
		
		obj.css({margin:'0px'});
		
		if(obj_param.zoomEnabled)
		{
			obj_param.width = Math.round(obj_param.width * param.zoom / 100);
			obj_param.height = Math.round(obj_param.height * param.zoom / 100);
			
			obj_param.min_dim = Math.round(obj_param.min_dim * param.zoom /100);
		}
		
			
	
		if(obj_param.min_dim<param.pdc_dim)
			obj_param.min_dim = param.pdc_dim;
			
		
		if(obj_param.overAllAspectRatio)
			obj_param.diagonalAspectRatio = true;
		
		if(typeof obj_param.zIndex == "undefined")
		{
			param.max_zIndex+=100;
			obj_param.zIndex = param.max_zIndex;
		}
		else
		{
			if(obj_param.zIndex>=param.max_zIndex)
				param.max_zIndex=obj_param.zIndex;
			else if(obj_param.zIndex < param.min_zIndex)
			{
				obj_param.zIndex+=param.min_zIndex;
				if(obj_param.zIndex>=param.max_zIndex)
					param.max_zIndex=obj_param.zIndex;
			}
		}
		
		obj_param.angle = obj_param.angle%360;

		if(obj.hasClass('paint_drag_control')){
			obj.obj_param = obj_param;
		}
		else
		{
			//obj.css({width:obj_param.width+'px',height:obj_param.height+'px'});
			var pdc_obj_html = 	'<table border="0" cellpadding="0" cellspacing="0" class="paint_drag_control">'+
								'<tr>'+
									'<td width="20px" height="20px" style="border-left:1px black solid;border-top:1px black solid;" class="paint_drag_control_resize_diagonal_left_top"></td>'+
									'<td align="center" vAlign="middle">'+
										//////////////////////////////////////
										'<table border="0" cellpadding="0" cellspacing="0" width="100%" height="20px">'+
											'<tr>'+
												'<td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_horizontal_top">&nbsp;</td>'+
												'<td width="20px" height="20px" align="center" vAlign="middle" style="">'+
													'<div style="width:20px;height:20px;overflow:visible;position:relative;top:0px;">'+
														'<div class="paint_drag_control_resize_vertical_top" style="position:absolute;top:0px;width:20px;height:20px;">'+
															'<span style="color:#000;font-size:12px;line-height:21px;padding-left:2px;">+</span>'+
														'</div>'+
														'<div class="paint_drag_control_rotation" style="position:absolute;top:-20px;width:20px;height:20px;">'+
															'<span style="color:#000;font-size:12px;line-height:21px;padding-left:2px;">O</span>'+
														'</div>'+
													'</div>'+
												'</td>'+
												'<td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_horizontal_top">&nbsp;</td>'+
											'</tr>'+
										'</table>'+
										/////////////////////////////////////
									'</td>'+
									'<td width="20px" height="20px" style="border-right:1px black solid;border-top:1px black solid;" class="paint_drag_control_resize_diagonal_right_top"></td>'+
								'</tr>'+
								'<tr>'+
									'<td align="center" vAlign="middle">'+
										//////////////////////////////////////
										'<table border="0" cellpadding="0" cellspacing="0"  style="width:100%;height:100%">'+
												'<tr><td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_vertical_left">&nbsp;</td></tr>'+
												'<tr><td width="20px" height="20px" align="center" vAlign="middle" class="paint_drag_control_resize_horizontal_left" style="color:#000;font-size:12px;line-height:1px;">+</td></tr>'+
												'<tr><td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_vertical_left">&nbsp;</td></tr>'+
										'</table>'+
										/////////////////////////////////////
									'</td>'+
									'<td class="paint_drag_control_container"></td>'+
									'<td align="center" vAlign="middle">'+
										//////////////////////////////////////
										'<table border="0" cellpadding="0" cellspacing="0" style="width:100%;height:100%">'+
												'<tr><td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_vertical_right">&nbsp;</td></tr>'+
												'<tr><td width="20px" height="20px" align="center" vAlign="middle" class="paint_drag_control_resize_horizontal_right" style="color:#000;font-size:12px;line-height:1px;">+</td></tr>'+
												'<tr><td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_vertical_right">&nbsp;</td></tr>'+
										'</table>'+
										/////////////////////////////////////
									'</td>'+
								'</tr>'+
								'<tr>'+
									'<td width="20px" height="20px" style="border-left:1px black solid;border-bottom:1px black solid;" class="paint_drag_control_resize_diagonal_left_bottom"></td>'+
									'<td align="center" vAlign="middle">'+
										//////////////////////////////////////
										'<table border="0" cellpadding="0" cellspacing="0" width="100%" height="20px">'+
											'<tr>'+
												'<td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_horizontal_bottom">&nbsp;</td>'+
												'<td width="20px" height="20px" align="center" vAlign="middle" class="paint_drag_control_resize_vertical_bottom" style="color:#000;font-size:12px;line-height:1px;">+</td>'+
												'<td style="font-size:1px;line-height:1px;" class="paint_drag_control_border_horizontal_bottom">&nbsp;</td>'+
											'</tr>'+
										'</table>'+
										/////////////////////////////////////
									'</td>'+
									'<td width="20px" height="20px" style="border-right:1px black solid;border-bottom:1px black solid;" class="paint_drag_control_resize_diagonal_right_bottom"></td>'+
								'</tr>'+
							'</table>';
			
			
			pdc_obj_html = pdc_obj_html.replace(/20px/gi,param.pdc_dim+'px');
			//console.log(pdc_obj_html);
			var pdc_obj = $(pdc_obj_html);
			
			if(typeof Paint.prototype.pdc_control_aligner == "undefined" )  /*&& param.dragable*/
			{
				Paint.prototype.pdc_control_aligner = true;
				//console.log(param.dragable);
				setInterval(function(){
					//var i=0;
					$('.paint_drag_control[resized="1"] .paint_drag_control_resize_horizontal_right, .paint_drag_control[resized="1"] .paint_drag_control_resize_horizontal_left').each(function(){
						//console.log(i++);
						try{
							$(this).parents('.paint_drag_control:first').attr('resized','0'); 
							var container_child = $($(this).parents('TABLE')[1]).find('.paint_drag_control_container [paint_drag_control_content="1"]');
							//console.log(container_child.height()+'+'+parseInt(container_child.css('paddingTop'))*2+'+'+parseInt(container_child.css('borderTopWidth'))*2);
							var height = container_child.height()+parseInt(container_child.css('paddingTop'))*2+parseInt(container_child.css('borderTopWidth'))*2;
							$($(this).parents('TABLE')[0]).css({height:height+'px'});
						}catch(err){}
					});
				},100);
			}
			
			
			
			
			
			if(typeof param.image_folder == "string" && param.dragable)
			{
				pdc_obj.find('TD, TR, DIV').css({padding:'0px',margin:'0px'});
				
				
				for(var class_src in param.images)
				{
					preload_img(param.image_folder + param.images[class_src]);
					var control_to_color = pdc_obj.find('.'+class_src);
					if(class_src.indexOf('_border')>-1)
					{
						if(class_src.indexOf('_horizontal')>-1)
							control_to_color.css({background:'url("'+param.image_folder + param.images[class_src] +'") repeat-x 0px 0px'});
						else
							control_to_color.css({background:'url("'+param.image_folder + param.images[class_src] +'") repeat-y 0px 0px'});
					}
					else
					{
						var img = $('<IMG style="width:'+param.pdc_dim+'px;height:'+param.pdc_dim+'px;border:0px transparent solid;" border="0">');
						img.attr('src', param.image_folder + param.images[class_src]);
						control_to_color.html('');
						control_to_color.append(img);
					}
					if(class_src.indexOf('_diagonal')>-1)
						control_to_color.css({border:'0px solid transparent'});
				}
			}
			
			
			try{
				pdc_obj[0].ondragstart = function() { return false; };
				//disableSelection(pdc_obj[0]);
			}catch(eee){}
			pdc_obj.find('TABLE, TABLE TD, TD[class!="paint_drag_control_container"], IMG').each(function(){
				try{
					$(this)[0].ondragstart = function() { return false; };
					disableSelection($(this)[0]);
				}catch(eee2){}
			});
			
			pdc_obj.find('TR, TD').css({padding:'0px',margin:'0px'});
			pdc_obj.css({padding:'0px',margin:'0px'});
			//console.log(cnt);
			//if(typeof cnt!="undefined")
			//	pdc_obj.find('.paint_drag_control_container').append('<span class="cnt_no">'+cnt+'</span>'); // added by mrinmoy to show the number
			obj.attr('paint_drag_control_content','1');
			pdc_obj.find('.paint_drag_control_container').append(obj);
			
			
			
			var pdc_obj_param = deep_clone(obj_param);
			pdc_obj_param.width+=param.pdc_dim*2+2;
			pdc_obj_param.height+=param.pdc_dim*2+2;
			
			obj_param.Dx = 0;
			obj_param.Dy = 0;
			pdc_obj_param.Dx = 0;
			pdc_obj_param.Dy = 0;
			
			
			obj.obj_param = obj_param;
			pdc_obj.obj_param = pdc_obj_param;
			pdc_obj.child_obj = obj;
			
			obj.pdc_obj = pdc_obj;
			
			self.addObj(pdc_obj,pdc_obj_param);
			
			obj.moveByAngle = function(delta_angle){
				pdc_obj.moveByAngle(delta_angle);
			}
			
			obj.setDisplay = function(){
				pdc_obj.setDisplay();
			}
			
			obj.addShadow = function(add){
				pdc_obj.addShadow(add);
			}
			
			obj.moveFront = function(){
				pdc_obj.moveFront();
			}
			obj.moveBack = function(){
				pdc_obj.moveBack();
			}
			
			obj.deleteThis = function(){
				pdc_obj.deleteThis();
			}
			
			////////////////////////////////////////////////////////
			
			var control = pdc_obj.find('[class*="paint_drag_control_r"], [class*="paint_drag_control_b"]');
			//pdc_obj.control = control;
			control.css({visibility:'hidden'});
			obj.selected = false;
			obj.obj_param.selected = false;
			pdc_obj.obj_param.selected = false;
			
			pdc_obj.mousedown(function(){
				//console.log(222);
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				if(!obj.selected)
				{
					obj.selected = true;
					obj.obj_param.selected = true;
					pdc_obj.obj_param.selected = true;
					control.css({visibility:'visible'});
					pdc_obj.attr('resized','1')
					
					if(param.duringDragShowElementBeyondBorder)
						self.css({overflow:'visible'});
					
					obj.setDisplay();
					obj.addShadow(false);
				}
			});
			
			//$(document).mouseup(function(e){
			$('.paint_container').mouseup(function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				if(e.target==obj[0]  || is_child(obj,$(e.target))){}
				//else
				else if($(e.target).attr('class')=='paint_container' || $(e.target).parents('[class="paint_container"]').length>0)
				{
					if(obj.selected)
					{
						obj.selected = false;
						obj.obj_param.selected = false;
						pdc_obj.obj_param.selected = false;
						control.css({visibility:'hidden'});
						
						if(param.duringDragShowElementBeyondBorder)
							self.css({overflow:'hidden'});
						
						obj.setDisplay();
					}
				}
			});
			
			
			
			
			
			pdc_obj.mouseover(function(){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				if(!obj.selected)
				{
					obj.addShadow(true);
				}
			});
			
			$(document).mousemove(function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				if(e.target==obj[0]  || is_child(obj,$(e.target))){}
				else
				{
					obj.addShadow(false);
				}
			});
			
			//////////////////////////////////////////////////
			var border_mobile = pdc_obj.find(
											 	'.paint_drag_control_border_horizontal_top, '+
												'.paint_drag_control_border_horizontal_bottom, '+
												'.paint_drag_control_border_vertical_left, '+
												'.paint_drag_control_border_vertical_right'
											 );
			border_mobile.each(function(){
				var this_border_mobile = this;
				this_border_mobile.move_enabled = false;
				
				$(this_border_mobile).bind('mousedown',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					this_border_mobile.move_enabled = true;
					this_border_mobile.pageX = e.pageX;
					this_border_mobile.pageY = e.pageY;
					//$(this_border_mobile).css({cursor:'move'});
				});
				//$(this_border_mobile).bind('mouseup',function(e){
				$(document).bind('mouseup',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					this_border_mobile.move_enabled = false;
					//$(this_border_mobile).css({cursor:'default'});
				});
				
				$(this_border_mobile).bind('mousemove',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					
					$(this_border_mobile).css({cursor:'move'});
					
					
				});
				
				$(document).bind('mousemove',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					
					
					if(this_border_mobile.move_enabled)
					{
						var deltax = - this_border_mobile.pageX + e.pageX;
						var deltay = - this_border_mobile.pageY + e.pageY;
						
						obj.obj_param.cx +=deltax;
						pdc_obj.obj_param.cx +=deltax;
						obj.obj_param.cy +=deltay;
						pdc_obj.obj_param.cy +=deltay;
						
						obj.setDisplay();
						
						this_border_mobile.pageX = e.pageX;
						this_border_mobile.pageY = e.pageY;
											
					}
				});
				
				
				
				
			});
			
			////////////////////////////////////////////////////////
			
			obj.move_enabled = false;
			obj.css({cursor:'default'});
			obj.bind('mousedown',function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				if(typeof obj[0].body_move_disabled == "undefined" || obj[0].body_move_disabled == false) {}
				else return;
				
				obj.move_enabled = true;
				obj.pageX = e.pageX;
				obj.pageY = e.pageY;
				obj.css({cursor:'move'});
			});
			self.bind('mouseup mouseout',function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				obj.move_enabled = false;
				obj.css({cursor:'default'});
			});
			obj.bind('mousemove',function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				if(obj.move_enabled)
				{
					var deltax = - obj.pageX + e.pageX;
					var deltay = - obj.pageY + e.pageY;
					
					obj.obj_param.cx +=deltax;
					pdc_obj.obj_param.cx +=deltax;
					obj.obj_param.cy +=deltay;
					pdc_obj.obj_param.cy +=deltay;
					
					obj.setDisplay();
					
					obj.pageX = e.pageX;
					obj.pageY = e.pageY;
										
				}
			});
			
			
			////////////////////////////////////////////////////////
			var dcr = pdc_obj.find('.paint_drag_control_rotation');
			//disableSelection(dcr[0]);
			dcr.enabled = false;
			dcr.css({cursor:'default'});
			dcr.bind('mousedown',function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				dcr.enabled = true;
				dcr.pageX = e.pageX;
				dcr.pageY = e.pageY;
				
			});
			self.bind('mouseup',function(e){
				//console.log('i am in mouseup');
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				dcr.enabled = false;
				dcr.css({cursor:'default'});
				
				// mouseup_custom_callback(pdc_obj);  modified by mrinmoy to call on add image option
			});
			self.bind('mousemove',function(e){
				if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
				
				dcr.css({cursor:'crosshair'});
				
				if(dcr.enabled)
				{
					var offsetX = getLeftPos(self[0]);
					var offsetY = getTopPos(self[0]);
					var delta_angle = 	((
										Math.atan2((e.pageY-obj_param.cy-offsetY),(e.pageX-obj_param.cx-offsetX))
										-
										Math.atan2((dcr.pageY-obj_param.cy-offsetY),(dcr.pageX-obj_param.cx-offsetX))
										)*180/Math.PI+720)%360;
					
					
					//console.log(delta_angle);
					obj.moveByAngle(delta_angle*1);
					dcr.pageX = e.pageX;
					dcr.pageY = e.pageY;
				}
			});
			//////////////////////////////////////////////////
			var resizer = pdc_obj.find(	'.paint_drag_control_resize_diagonal_left_top, '+
										'.paint_drag_control_resize_diagonal_right_top, '+
										'.paint_drag_control_resize_diagonal_left_bottom, '+
										'.paint_drag_control_resize_diagonal_right_bottom, '+
										'.paint_drag_control_resize_horizontal_left, '+
										'.paint_drag_control_resize_horizontal_right, '+
										'.paint_drag_control_resize_vertical_top, '+
										'.paint_drag_control_resize_vertical_bottom');
			//var this_obj = obj;
			resizer.each(function(){
				var this_resizer = this;
				//disableSelection(this_resizer);
				this_resizer.enabled = false;
				//$(this_resizer).css({cursor:'default'});
				$(this_resizer).bind('mousedown',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					this_resizer.enabled = true;
					this_resizer.pageX = e.pageX;
					this_resizer.pageY = e.pageY;


				});
				
				//self.bind('mouseup',function(e){
				$(document).bind('mouseup',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					this_resizer.enabled = false;
					//$(this_resizer).css({cursor:'default'});
				});
				self.bind('mousemove',function(e){
					if(!(param.dragable && pdc_obj.obj_param.dragable)) return;
					
					//////////////////////////////////////////

					var offsetX = getLeftPos(self[0]);
					var offsetY = getTopPos(self[0]);
					var angle = 	((
										Math.atan2((e.pageY-obj_param.cy-offsetY),(e.pageX-obj_param.cx-offsetX))
										)*180/Math.PI+720)%360;
					//this_resizer.angle_wrt_center = angle;
						if(180+22.5<=angle && angle<=270-22.5)
							$(this_resizer).css({cursor:'nw-resize'});
						else if(270+22.5<=angle && angle<=360-22.5)
							$(this_resizer).css({cursor:'ne-resize'});
						else if(90+22.5<=angle && angle<=180-22.5)
							$(this_resizer).css({cursor:'sw-resize'});
						else if(0+22.5<=angle && angle<=90-22.5)
							$(this_resizer).css({cursor:'se-resize'});
						else if(180-22.5<=angle && angle<=180+22.5)
							$(this_resizer).css({cursor:'w-resize'});
						else if(90-22.5<=angle && angle<=90+22.5)
							$(this_resizer).css({cursor:'s-resize'});
						
						
						else if(360-22.5<=angle || angle<=0+22.5)
							$(this_resizer).css({cursor:'e-resize'});
					
						else if(270+22.5<=angle || angle<=360-22.5)
							$(this_resizer).css({cursor:'n-resize'});
					
					//////////////////////////////////////////
					
					
					if(this_resizer.enabled /*&& typeof this_resizer.angle_wrt_center !="undefined"*/)
					{
						
							var resizer_class = $(this_resizer).attr('class');
						
							//var offsetX = getLeftPos(self[0]);
							//var offsetY = getTopPos(self[0]);
							//var deltax = -Math.abs(this_resizer.pageX-obj.obj_param.cx -obj.obj_param.Dx - offsetX) + Math.abs(e.pageX-obj.obj_param.cx -obj.obj_param.Dx - offsetX);
							//var deltay = -Math.abs(this_resizer.pageY-obj.obj_param.cy -obj.obj_param.Dy - offsetY) + Math.abs(e.pageY-obj.obj_param.cy -obj.obj_param.Dy - offsetY);
							
							var deltax = -this_resizer.pageX + e.pageX;
							var deltay = -this_resizer.pageY + e.pageY;
							var deltacx;
							var deltacy;
							
							if(pdc_obj.obj_param.overAllAspectRatio)
							{
								//console.log(111);
								switch(resizer_class)
								{
									case 'paint_drag_control_resize_horizontal_left':
										if(deltay*deltax<0)
											resizer_class = 'paint_drag_control_resize_diagonal_left_bottom';
										else
											resizer_class = 'paint_drag_control_resize_diagonal_left_top';
									break;
									
									case 'paint_drag_control_resize_horizontal_right':
										if(deltay*deltax>0)
											resizer_class = 'paint_drag_control_resize_diagonal_right_bottom';
										else
											resizer_class = 'paint_drag_control_resize_diagonal_right_top';
									break;
									
									case 'paint_drag_control_resize_vertical_top':
										if(deltay*deltax<0)
											resizer_class = 'paint_drag_control_resize_diagonal_right_top';
										else
											resizer_class = 'paint_drag_control_resize_diagonal_left_top';
									break;
									
									case 'paint_drag_control_resize_vertical_bottom':
										if(deltay*deltax>0)
											resizer_class = 'paint_drag_control_resize_diagonal_right_bottom';
										else
											resizer_class = 'paint_drag_control_resize_diagonal_left_bottom';
									break;
								}
							}
							
							if(pdc_obj.obj_param.diagonalAspectRatio)
							{
								//console.log(resizer_class);
								switch(resizer_class)
								{
									case 'paint_drag_control_resize_diagonal_left_top':
									case 'paint_drag_control_resize_diagonal_right_bottom':
										//console.log(deltax*deltay);
										if(deltax*deltay>0){
											var mean = (deltax+deltay)/2;
											deltax = mean*pdc_obj.obj_param.width/pdc_obj.obj_param.height;
											deltay = mean;
										}
										else
											return;
										//console.log('proceed');
									break;
									case 'paint_drag_control_resize_diagonal_right_top':
									case 'paint_drag_control_resize_diagonal_left_bottom':
										if(deltax*deltay<0){
											var mean = (Math.abs(deltax)+Math.abs(deltay))/2;
											deltax = (mean*pdc_obj.obj_param.width/pdc_obj.obj_param.height)
													 *deltax/Math.abs(deltax);
											deltay = mean*deltay/Math.abs(deltay);
										}
										else
											return;
									break;
								}
							}
							
							var rad = obj_param.angle* (Math.PI / 180);
							var reverse_rad = (360-obj_param.angle)* (Math.PI / 180);
							
							
							var deltax2 = deltax * Math.cos(rad) + deltay * Math.sin(rad);
							var deltay2 = -deltax * Math.sin(rad) + deltay * Math.cos(rad);
							
							//console.log(deltax+','+deltax2);
							
							//var deltacx = deltax*2;
							//var deltacy = deltay*2;
							
							deltax = deltax2;
							deltay = deltay2;
							
							//console.log(deltax);
							
							/*pdc_obj.obj_param.width = pdc_obj.width();
							pdc_obj.obj_param.height = pdc_obj.height();
							obj.obj_param.width = obj.width();
							obj.obj_param.height = obj.height();*/
							
							//if(deltax>0)
								deltax *=2;
							//if(deltay>0)
								deltay *=2;
							
							
							var deltax3 = deltax;
							var deltay3 = deltay;
							
							
							switch(resizer_class)
							{
								case 'paint_drag_control_resize_diagonal_left_top':

									deltax = -deltax;
									deltay = -deltay;
								break;
								case 'paint_drag_control_resize_diagonal_right_top':
									deltax = deltax;
									deltay = -deltay;
								break;
								case 'paint_drag_control_resize_diagonal_left_bottom':
									deltax = -deltax;
									deltay = deltay;
								break;
								case 'paint_drag_control_resize_diagonal_right_bottom':
									deltax = deltax;
									deltay = deltay;
								break;
								case 'paint_drag_control_resize_horizontal_left':
								
									deltax = -deltax;
									deltay = 0;
									deltay3 =0;
	
								break;
								case 'paint_drag_control_resize_horizontal_right':
								
									deltax = deltax;
									deltay = 0;
									deltay3 =0;
	
								break;
								case 'paint_drag_control_resize_vertical_top':
								
									deltax = 0;
									deltay = -deltay;
									deltax3 = 0;
									
								break;
								case 'paint_drag_control_resize_vertical_bottom':
								
									deltax = 0;
									deltay = deltay;
									deltax3 = 0;
									
								break;
							}
							
									if(
										   pdc_obj.obj_param.width+deltax<param.pdc_dim*2+2+param.pdc_dim || 
										   obj.obj_param.width+deltax<param.pdc_dim || 
										   pdc_obj.obj_param.height+deltay<param.pdc_dim*2+2+param.pdc_dim ||
										   obj.obj_param.height+deltay<param.pdc_dim
									   )
									{
										return;
									}
									
									if(
									   		obj.obj_param.width+deltax < obj_param.min_dim ||
											obj.obj_param.height+deltay<obj_param.min_dim
									  )
									{
										return;
									}
							
									pdc_obj.obj_param.width+=deltax;
									obj.obj_param.width+=deltax;
									pdc_obj.obj_param.height+=deltay;
									obj.obj_param.height+=deltay;
							
									deltacx = deltax3 * Math.cos(reverse_rad) + deltay3 * Math.sin(reverse_rad);
									deltacy = -deltax3 * Math.sin(reverse_rad) + deltay3 * Math.cos(reverse_rad);
									
							
									pdc_obj.obj_param.cx+=deltacx/2;
									obj.obj_param.cx+=deltacx/2;
									pdc_obj.obj_param.cy+=deltacy/2;
									obj.obj_param.cy+=deltacy/2;
							
							
							if(pdc_obj.obj_param.width<param.pdc_dim*2+2+param.pdc_dim)pdc_obj.obj_param.width=param.pdc_dim*2+2+param.pdc_dim;
							if(obj.obj_param.width<param.pdc_dim)obj.obj_param.width=param.pdc_dim;
							if(pdc_obj.obj_param.height<param.pdc_dim*2+2+param.pdc_dim)pdc_obj.obj_param.height=param.pdc_dim*2+2+param.pdc_dim;
							if(obj.obj_param.height<param.pdc_dim)obj.obj_param.height=param.pdc_dim;


							if(obj.obj_param.width<obj_param.min_dim)
							{
								obj.obj_param.width=obj.obj_param.min_dim;
								pdc_obj.obj_param.width = param.pdc_dim*2+2+obj.obj_param.min_dim;
							}
							if(obj.obj_param.height<obj.obj_param.min_dim)
							{
								obj.obj_param.height=obj.obj_param.min_dim;
								pdc_obj.obj_param.height = param.pdc_dim*2+2+obj.obj_param.min_dim;
							}


							obj.setDisplay();
							
							this_resizer.pageX = e.pageX;
							this_resizer.pageY = e.pageY;
							
							pdc_obj.attr('resized','1'); 
					}
				});
			});
			/////////////////////////////////////////////////
			return;
		}

		obj.stopPlacingOutSide = function()
		{
			if(typeof obj.obj_param_prev != "undefined")
			{
				
				var rad = obj.child_obj.obj_param.angle* (Math.PI / 180);
								
				var leftX = obj.child_obj.obj_param.cx - obj.child_obj.obj_param.width/2;
				var topY = obj.child_obj.obj_param.cy - obj.child_obj.obj_param.height/2;
								
				var rightX = obj.child_obj.obj_param.cx + obj.child_obj.obj_param.width/2;
				var bottomY = obj.child_obj.obj_param.cy + obj.child_obj.obj_param.height/2;

				var leftTopX = (leftX-obj.child_obj.obj_param.cx) * Math.cos(rad) + (topY-obj.child_obj.obj_param.cy) * Math.sin(rad) + obj.child_obj.obj_param.cx;
				var leftTopY = - (leftX-obj.child_obj.obj_param.cx) * Math.sin(rad) + (topY-obj.child_obj.obj_param.cy) * Math.cos(rad) + obj.child_obj.obj_param.cy;
				
				var rightTopX = (rightX-obj.child_obj.obj_param.cx) * Math.cos(rad) + (topY-obj.child_obj.obj_param.cy) * Math.sin(rad) + obj.child_obj.obj_param.cx;
				var rightTopY = - (rightX-obj.child_obj.obj_param.cx) * Math.sin(rad) + (topY-obj.child_obj.obj_param.cy) * Math.cos(rad) + obj.child_obj.obj_param.cy;
				
				var rightBottomX = (rightX-obj.child_obj.obj_param.cx) * Math.cos(rad) + (bottomY-obj.child_obj.obj_param.cy) * Math.sin(rad) + obj.child_obj.obj_param.cx;
				var rightBottomY = - (rightX-obj.child_obj.obj_param.cx) * Math.sin(rad) + (bottomY-obj.child_obj.obj_param.cy) * Math.cos(rad) + obj.child_obj.obj_param.cy;
				
				var leftBottomX = (leftX-obj.child_obj.obj_param.cx) * Math.cos(rad) + (bottomY-obj.child_obj.obj_param.cy) * Math.sin(rad) + obj.child_obj.obj_param.cx;
				var leftBottomY = - (leftX-obj.child_obj.obj_param.cx) * Math.sin(rad) + (bottomY-obj.child_obj.obj_param.cy) * Math.cos(rad) + obj.child_obj.obj_param.cy;
				
				
				
				
				if( 
				   	0<=leftTopX && leftTopX<=param.width &&
					0<=rightTopX && rightTopX<=param.width &&
					
					0<=leftBottomX && leftBottomX<=param.width &&
					0<=rightBottomX && rightBottomX<=param.width &&
					
					0<=leftTopY && leftTopY<=param.height &&
					0<=rightTopY && rightTopY<=param.height &&
					
					0<=leftBottomY && leftBottomY<=param.height &&
					0<=rightBottomY && rightBottomY<=param.height &&
					
					true
				   )
				{
				}
				else
				{
					for(var x in obj.obj_param)
						obj.obj_param[x] = obj.obj_param_prev[x];
					for(var x in obj.child_obj.obj_param)
						obj.child_obj.obj_param[x] = obj.child_obj.obj_param_prev[x];
				}
			}
			else
			{
				obj.obj_param_prev = {};
				obj.child_obj.obj_param_prev = {};
			}
			for(var x in obj.obj_param)
				obj.obj_param_prev[x] = obj.obj_param[x];
			for(var x in obj.child_obj.obj_param)
				obj.child_obj.obj_param_prev[x] = obj.child_obj.obj_param[x];
			
		}

		obj.setDisplay = function(do_not_call_displayComplete)
		{
					if(typeof do_not_call_displayComplete == "undefined")
						do_not_call_displayComplete = false;
			
					if(obj.obj_param.doNotPlaceOutside)
						obj.stopPlacingOutSide();
			
					// padding patch
					var adjust = 0;
					if(typeof obj.child_obj.obj_param.padding !="undefined")
					{
						adjust = 2*parseInt(obj.child_obj.obj_param.padding);
					}

					obj.child_obj.css({width:(obj.child_obj.obj_param.width-adjust)+'px',height:(obj.child_obj.obj_param.height-adjust)+'px',zIndex:obj.child_obj.obj_param.zIndex});
		
					var obj_param = obj.obj_param;
					var Dx = 0;
					var Dy = 0;
					var rad,degree;
			
					//if(obj_param.angle!=0)
					{
						rad = obj_param.angle* (Math.PI / 180);
						degree = obj_param.angle;
						if ($.browser.msie  && parseInt($.browser.version, 10) <9 )
						{
							var COS_THETA = Math.cos(rad);
							var SIN_THETA = Math.sin(rad);
							
							////////////////////////////////////////////
							/*
							http://www.wiliam.com.au/wiliam-blog/sydney-web-design-rotating-html-elements-by-an-arbitrary-amount-cross-browser
							*/
							var ew = obj_param.width, eh = obj_param.height;
							var x1 = -ew / 2,
								x2 =  ew / 2,
								x3 =  ew / 2,
								x4 = -ew / 2,
								y1 =  eh / 2,
								y2 =  eh / 2,
								y3 = -eh / 2,
								y4 = -eh / 2;
			
							var x11 =  x1 * COS_THETA + y1 * SIN_THETA,
								y11 = -x1 * SIN_THETA + y1 * COS_THETA,
								x21 =  x2 * COS_THETA + y2 * SIN_THETA,
								y21 = -x2 * SIN_THETA + y2 * COS_THETA,
								x31 =  x3 * COS_THETA + y3 * SIN_THETA,
								y31 = -x3 * SIN_THETA + y3 * COS_THETA,
								x41 =  x4 * COS_THETA + y4 * SIN_THETA,
								y41 = -x4 * SIN_THETA + y4 * COS_THETA;
			
							var x_min = Math.min(x11, x21, x31, x41) + ew / 2,
								x_max = Math.max(x11, x21, x31, x41) + ew / 2;
			
							var y_min = Math.min(y11, y21, y31, y41) + eh / 2;
								y_max = Math.max(y11, y21, y31, y41) + eh / 2;
								
							Dx = x_min;
							Dy = y_min;
							////////////////////////////////////////////
						
							//obj_param.cx = (obj_param.cx+Dx);
							//obj_param.cy = (obj_param.cy+Dy);
							obj_param.Dx = Dx;
							obj_param.Dy = Dy;
							
							obj.child_obj.obj_param.Dx = Dx;
							obj.child_obj.obj_param.Dy = Dy;
							
						}
						
					}
			
			
					obj_param.left = (obj_param.cx + Dx - obj_param.width/2);
					obj_param.top = (obj_param.cy + Dy - obj_param.height/2);
					obj.css({width:obj_param.width+'px',height:obj_param.height+'px',left:obj_param.left+'px',top:obj_param.top+'px',position:'absolute',zIndex:obj_param.zIndex});
					
					
					//if(obj_param.angle!=0)
					{
						if ($.browser.msie  && parseInt($.browser.version, 10) <9 )
						{
							obj.css({	'filter':"progid:DXImageTransform.Microsoft.Matrix(M11 = "+COS_THETA+", M12 = "+(-SIN_THETA)+", M21 = "+SIN_THETA+", M22 = "+COS_THETA+",	sizingMethod = 'auto expand')"});
							obj.css({	'-ms-filter':"progid:DXImageTransform.Microsoft.Matrix(M11 = "+COS_THETA+", M12 = "+(-SIN_THETA)+", M21 = "+SIN_THETA+", M22 = "+COS_THETA+",	SizingMethod  = 'auto expand')"});
						}
						else
						{
							obj.css({'transform': 'rotate('+degree+'deg)'});    
							obj.css({'-ms-transform': 'rotate('+degree+'deg)'});    /* IE 9 */
							obj.css({'-moz-transform': 'rotate('+degree+'deg)'});    /* Firefox */
							obj.css({'-webkit-transform': 'rotate('+degree+'deg)'}); /* Safari and Chrome */
							obj.css({'-o-transform': 'rotate('+degree+'deg)'});      /* Opera */
						}
					}
					
					if(typeof obj.child_obj.displayComplete =='function' && !do_not_call_displayComplete)
					{
						//console.log(obj.child_obj.obj_param);
						obj.child_obj.displayComplete(obj.child_obj.obj_param);
					}
			
		}
		
		obj.addShadow = function(add){
			var shadow,shadowIE;
			if(add)
			{
				shadow = '0px 0px 1px 1px rgba(0, 0, 190, .75)';
				shadowIE = 'progid:DXImageTransform.Microsoft.Glow(Color=#0000ff,Strength=1)';
			}
			else
			{
				shadow = '';
				shadowIE = '';
			}
				//console.log(obj.child_obj.length);
				if ($.browser.msie  && parseInt($.browser.version, 10) <9 )
				{
					obj.child_obj.css({	'filter':shadowIE});
					obj.child_obj.css({	'-ms-filter':shadowIE});
				}
				else
				{
					//console.log(111);
					obj.child_obj.css({'box-shadow': shadow});    
					obj.child_obj.css({'-ms-shadow': shadow});    /* IE 9 */
					obj.child_obj.css({'-moz-box-shadow': shadow});    /* Firefox */
					obj.child_obj.css({'-webkit-box-shadow': shadow}); /* Safari and Chrome */
					obj.child_obj.css({'-o-shadow': shadow});      /* Opera */
				}
			
		}

		obj.setDisplay();
		
		obj.moveByAngle = function(delta_angle){
			var obj_param = obj.obj_param;
			obj_param.angle+=delta_angle;
			obj_param.angle = obj_param.angle%360;
			
			obj.child_obj.obj_param.angle=obj_param.angle;
			
			obj.setDisplay();
		}
		
		obj.moveFront = function(){
			var obj_param = obj.obj_param;
			obj_param.zIndex+=101;
			
			obj.child_obj.obj_param.zIndex=obj_param.zIndex;
			self.reorderZindex();
			obj.setDisplay();
		}
		obj.moveBack = function(){
			var obj_param = obj.obj_param;
			obj_param.zIndex-=101;
			
			//if(obj_param.zIndex<obj_param.min_zIndex)
			//	obj_param.zIndex =obj_param.min_zIndex;
			if(obj_param.zIndex<param.min_zIndex)
				obj_param.zIndex =param.min_zIndex;
			
			obj.child_obj.obj_param.zIndex=obj_param.zIndex;
			self.reorderZindex();
			obj.setDisplay();
		}
		
		self.reorderZindex = function ()
		{
			//console.log(1111);
			/*
			var arr_pdc_obj = Array();
			console.log('a'+self.find('.paint_drag_control'));
			self.find('.paint_drag_control').each(function(){
				var this_pdc_obj = $(this);
				arr_pdc_obj.push(this_pdc_obj);
			});
			*/
			
			var arr_pdc_obj = self.objArray;
			
			if(arr_pdc_obj.length>0)
			{
				arr_pdc_obj.sort(function(a,b){
					//console.log(a);
					if(a.obj_param.zIndex<b.obj_param.zIndex)
						return -1;
					else if(a.obj_param.zIndex>b.obj_param.zIndex)
						return 1;
					else
						return 0;
				});
				param.min_zIndex = arr_pdc_obj[0].obj_param.zIndex;
				param.max_zIndex = 0;
				var cur_zIndex = param.min_zIndex+1;
				for(var i=0;i<arr_pdc_obj.length;i++)
				{
					arr_pdc_obj[i].obj_param.zIndex = cur_zIndex;
					arr_pdc_obj[i].child_obj.obj_param.zIndex = cur_zIndex;
					
					param.max_zIndex = arr_pdc_obj[i].obj_param.zIndex;
					console.log(cur_zIndex);
					cur_zIndex+=100;
					arr_pdc_obj[i].setDisplay(true);
				}
			}
		}
		
		obj.deleteThis = function(){
			obj.remove();
		}
		self.objArray.push(obj);	
		self.append(obj);
		
		
		/*
		if(!do_not_focus_on_add)
		{
			if(obj.parents('body').length>0)
			{
				setTimeout(function(){
				
				},3000);
				console.log(111);
				obj.trigger('mousedown');
			}
		}
		*/
		
		setTimeout(function(){
			if(typeof self.may_be_adding_object_manually !="undefined" && self.may_be_adding_object_manually)
			{
				self.may_be_adding_object_manually = false;
				//console.log('focus');
				if(obj.parents('body').length>0)
				{
					setTimeout(function(){
						obj.trigger('mousedown');
					},100);
					self.trigger('mouseup');
				}
			}
		},100);
		
		
	}

	$(document).live('mousedown',function(e){
		if($(e.target).parents('.paint_container').length==0)
		{
			//console.log('may be adding object manually');
			self.may_be_adding_object_manually = true;
		}
	});

	return self;
}
