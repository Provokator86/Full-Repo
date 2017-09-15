function like_review_ajax(url,trgtId)
{
	
	if(document.getElementById('like_review_ajax'))
		document.getElementById('like_review_ajax').innerHTML='<img src="'+base_url+'images/front/ajax-loader.gif" alt=""/>';
	$.ajax({
		type: "POST",
		url: url,
		data: '',
		success: function(msg){
			if(msg!=''){
				document.getElementById('a_like_review_'+trgtId).innerHTML = msg;
				if(document.getElementById('like_review_ajax'))
					document.getElementById('like_review_ajax').innerHTML = '';
				var m_type   = msg.substring(0,1);
				if(m_type=='D')
					document.getElementById('img_like_review_'+trgtId).src = base_url+'images/front/not_like_btn.png';
				else
					document.getElementById('img_like_review_'+trgtId).src = base_url+'images/front/like_btn.png';
                   
			}
		}
	});
}

function autoload_ajax_no_jsn(ajaxURL,trgtId,data)
{
	if(document.getElementById('restaurants_ajax_auto_load'))
		document.getElementById('restaurants_ajax_auto_load').innerHTML='<img src="'+base_url+'images/front/ajax-loader.gif" alt=""/>';

	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: data,
		success: function(msg){
			if(msg!=''){
				//alert('okkk');
				window.location.reload();
/*				document.getElementById(trgtId).innerHTML = msg;
				if(document.getElementById('restaurants_ajax_auto_load'))
					document.getElementById('restaurants_ajax_auto_load').innerHTML='';
*/			}
			
		}
	});
}


function autoload_ajax_search(ajaxURL, trgtId, jsn, cngKey, cngVlaue)
{
	if(document.getElementById('restaurants_ajax_auto_load'))
		document.getElementById('restaurants_ajax_auto_load').innerHTML = '<img src="' + base_url + 'images/front/ajax-loader.gif" alt=""/>';
    
	var tmp = eval(jsn);
	var p_var = '';
	for(x in tmp)
	{
		if(x == cngKey)
			p_var += cngKey + '=' + cngVlaue + '&';
		else
			p_var += x + '=' + tmp[x] + '&';
	}
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var,
		success: function(msg){
			if(msg != ''){
				$("#" + trgtId).html(msg);
				
				if(document.getElementById('restaurants_ajax_auto_load'))
					document.getElementById('restaurants_ajax_auto_load').innerHTML = '';
				ddimgtooltip.init("*[rel^=imgtip]");
			}
		}
	});
}

function autoload_ajax(ajaxURL, trgtId, jsn, cngKey, cngVlaue)
{
	if(document.getElementById('restaurants_ajax_auto_load'))
		document.getElementById('restaurants_ajax_auto_load').innerHTML = '<img src="' + base_url + 'images/front/ajax-loader.gif" alt=""/>';

	var tmp = eval(jsn);
	var p_var = '';
	for(x in tmp)
	{
		if(x == cngKey)
			p_var += cngKey + '=' + cngVlaue + '&';
		else
			p_var += x + '=' + tmp[x] + '&';
	}
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var,
		success: function(msg){
			if(msg != ''){
				$("#" + trgtId).html(msg);
				if(document.getElementById('restaurants_ajax_auto_load'))
					document.getElementById('restaurants_ajax_auto_load').innerHTML = '';
			}
		}
	});
}



function get_ajax_option_common(ajaxURL, id, cngDv)
{
	
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: 'id=' + id,
		success: function(msg){
			if(msg != '')
				document.getElementById(cngDv).innerHTML = msg;
		}
	});
}

function call_ajax_status_change(ajaxURL,jsn,cngDv)
{
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	var tmp = eval(jsn);
	var p_var='';
	for(x in tmp)
		p_var += x+'='+tmp[x]+'&';

	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var,
		success: function(msg){
			if(msg!='')
				document.getElementById(cngDv).innerHTML = msg;
		}
	});
}

function generate_user_code(ajaxURL)
{
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: '',
		success: function(msg){
			if(msg!='')
				$('#user_code').val(msg);
		}
	});
}

function call_ajax_ck_field_duplicate_submit(ajaxURL,obj,frm)
{
	var p_var='';
	for(x in obj)
		p_var += x+'='+obj[x]+'&';
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var,
		success: function(msg){
			if(msg!='')
				alert( msg );
			else
				frm.submit();
		}
	});
}

function ck_check_username_ajax()
{
	var username    = document.getElementById('username').value;
	var p_var='username='+username;
	$.ajax({
		type: "POST",
		url: base_url+"user/add_user_check",
		data: p_var,
		success: function(msg){
			if(msg!='' || username=='')
				document.getElementById('ckUsername').innerHTML  = '<span style="color:#B10E00;"><img src="'+base_url+'images/admin/disable.gif"/>  Duplicate User Id</span>';
			else
				document.getElementById('ckUsername').innerHTML  = '<span style="color:#B10E00;"><img src="'+base_url+'images/admin/icon_success.png"/>  User Id Available</span>';
		}
	});
}

function ShowContentToolTip(url)
{
	if(url.length < 1)
		return;
	var dd = document.getElementById('toottipDiv');
	AssignPosition(dd);
	dd.style.display = "block";
	dd.innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	$.ajax({
		type: "POST",
		url: url,
		data: '',
		success: function(msg){
			if(msg!='')
				dd.innerHTML=msg;
		}
	});
        
}

function HideContentToolTip()
{
	document.getElementById('toottipDiv').style.display = "none";
}





/*     added by Iman    */
function call_ajax_status_change_UiBlock(ajaxURL,jsn,cngDv)
{
	// document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	var tmp = eval(jsn);
	var p_var='';
	for(x in tmp)
		p_var += x+'='+tmp[x]+'&';

	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var,
		success: function(msg){
			if(msg!=''){
				msg = msg.split('|');
				if(msg[0]=='succ')
					document.getElementById(cngDv).innerHTML = msg[1];
				else
					UiBlock(msg[1]);
			}
		}
	});
}

function UiBlock(msg)
{
	$.blockUI({
		message: msg,
		css: {
			border: 'none',
			padding: '15px',
			backgroundColor: '#000000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: '1',
			color: '#ffffff'
		},
		overlayCSS: {
			backgroundColor: '#000000'
		}
	});
	setTimeout($.unblockUI, 2000);
}

function call_ajax_status_change_featured(ajaxURL,jsn,cngDv,val)
{
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	var tmp = eval(jsn);
	var p_var='';
	for(x in tmp)
		p_var += x+'='+tmp[x]+'&';

	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var+'featured='+val,
		success: function(msg){
			if(msg!='')
				document.getElementById(cngDv).innerHTML = msg;
		}
	});
}


function get_ajax_delete_picture(ajaxURL, id, cngDv)
{
	
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: 'id=' + id,
		success: function(msg){
			if(msg != '')
				alert(msg);
		}
	});
}


function call_ajax_combo_change(ajaxURL,item_id,cngDv,front)
{
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: "item_id="+item_id,
		success: function(msg){
			if(msg!='')
				document.getElementById(cngDv).innerHTML = msg;
		}
	});
}



function call_region_ajax_helper(val,url,name_pass,div_id,front,width){
	var arr = new Array();
	var tempArr = new Array();
	tempArr['curDir'] = front;
	arr['curDir'] = front;
	tempArr['width'] = width;
	arr['width'] = width;	
	if(name_pass == 'city'){
		arr['city'] = val;
		tempArr['city'] = -1;
		tmpJsnArr = array2json(tempArr);
		call_ajax_status_change(front+'location_ajax/get_ajax_region',tmpJsnArr,'region_combo',front);	
		call_ajax_status_change(front+'location_ajax/get_ajax_zip',tmpJsnArr,'zip_combo',front);
	}	
	else if(name_pass == 'area')	{
		city_name = document.getElementById('city').value;
		arr['city'] = city_name;
		arr['area']  =val
		tempArr['city'] = -1;	
		//tempArr['area'] = -1;
		//tempArr['region'] = -1;
		tmpJsnArr = array2json(tempArr);
		call_ajax_status_change(front+'location_ajax/get_ajax_zip',tmpJsnArr,'zip_combo',front);						
	}
	else if(name_pass == 'region'){
		city_name = document.getElementById('city').value;
		area_name = document.getElementById('area').value;
		arr['city'] = city_name;
		arr['area']  = area_name;
		arr['region'] = val;
	}
	
	jsnArr = array2json(arr);
	call_ajax_status_change(front+'location_ajax/'+url,jsnArr,div_id,front);
}

function call_ajax_del_image(ajaxURL,val,cngDv,aval_no)
{
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	post_val = 'id='+val;
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: post_val,
		success: function(msg){
			if(msg!=''){
				msg = msg.split('|');
				document.getElementById(cngDv).innerHTML = msg[0];
				if(msg[1]!=0) {
					document.getElementById('showFileUpload').style.display = '';
				}
				if(aval_no)
					document.getElementById(aval_no).value = msg[1];
			}
		}
	});
}


function show_light_box(item_type,item_id,message,url,jScript)
{
	$.ajax({
		type: "POST",
		url: base_url+'lightbox_ajax',
		data: "item_type="+item_type+"&item_id="+item_id,
		success: function(msg){
			document.getElementById('show_all_lightbox').innerHTML=msg;
			dialog_success = new ModalDialog ("#success_dialog");
			dialog_success.show();
			if(jScript && jScript!='')
				eval(jScript);
		}
	});
}




function get_ajax_option_party(ajaxURL,id,name,cngDv)
{
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: 'id='+id+'&name='+name,
		success: function(msg){
			if(msg!='')
				document.getElementById(cngDv).innerHTML = msg;
		}
	});
}










/*  Iman */

function call_ajax_business_status_change(ajaxURL,jsn,cngDv)
{
	document.getElementById(cngDv).innerHTML='<img src="'+base_url+'images/admin/loading.gif" alt=""/>';
	var tmp = eval(jsn);
	var p_var='';
	for(x in tmp)
		p_var += x+'='+tmp[x]+'&';

	$.ajax({
		type: "POST",
		url: ajaxURL,
		data: p_var,
		success: function(msg){
			if(msg!='')
			{
				msg = msg.split('|');
				document.getElementById(cngDv).innerHTML = msg[0];
				call_ajax_claim_div(msg[1]);
			}
		}
	});
}

function call_ajax_claim_div(id)
{
	$('#claim_div_'+id).html('<img src="'+base_url+'images/admin/loading.gif" alt=""/>');
	$.ajax({
		type: "POST",
		url: base_url+'admin/business/ajax_claim_link',
		data: 'business_id='+id,
		success: function(msg){
			if(msg!='')
				$('#claim_div_'+id).html(msg);
		}
	});
	
}

function business_search_remove_session(id,type)
{
		$.ajax({
		type: "POST",
		url: base_url+'search/business_search_remove_session',
		data: 'id='+id+'&type='+type,
		success: function(msg){
			//alert(msg);
			if(msg!=''){
				window.location.reload();
			}
		}
	});
}

	
	function business_search_remove_session(id,type)
	{
	  $.ajax({
	  type: "POST",
	  url: base_url+'search/business_search_remove_session',
	  data: 'id='+id+'&type='+type,
	  success: function(msg){
	   //alert(msg);
	   if(msg!=''){
		window.location.reload();
	   }
	  }
	 });
	}