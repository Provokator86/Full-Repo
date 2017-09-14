$(document).ready(function(){
	$('.checkboxCon input:checked').parent().css('background-position','-114px -260px');
	$("#selectallseeker").click(function () {
          $('.caseSeeker').attr('checked', this.checked);
          if(this.checked){
        	  $(this).parent().addClass('checked');
        	  $('.checkboxCon').css('background-position','-114px -260px');
          }else{
        	  $(this).parent().removeClass('checked');
        	  $('.checkboxCon').css('background-position','-38px -260px');
          }
    });
	
	
 
    // if all checkbox are selected, check the selectall checkbox
    // and viceversa
    $(".caseSeeker").click(function(){
 
        if($(".caseSeeker").length == $(".caseSeeker:checked").length) {
            $("#selectallseeker").attr("checked", "checked");
            $("#selectallseeker").parent().addClass("checked");
        } else {
            $("#selectallseeker").removeAttr("checked");
            $("#selectallseeker").parent().removeClass("checked");
        }
 
    });
    
    $('.checkboxCon input').click(function(){
    	if(this.checked){
      	  $(this).parent().css('background-position','-114px -260px');
        }else{
      	  $(this).parent().css('background-position','-38px -260px');
        }
    });
	
	$(".popup-signup-ajax").click(function()
   {
	   // alert(baseURL);return false;
	   $.ajax(
		{
			type: 'POST',
			url: baseURL+'googlelogin/index.php',
			data:{},
			success: function(data) 
			{
				// location.reload();
				// alert('sss');
				// $("#popupCheckId").val('1');
				$("#popup_container").css("display","block");
			}
			
		});
   });
	
	/**
	 * Menu notifications hover
	 * 
	 */
	$('.gnb-notification').mouseenter(function(){
		if($(this).hasClass('cntLoading'))return;
		$(this).addClass('cntLoading');
		$('.feed-notification').show();
		$('.feed-notification').find('ul').remove();
// $(this).find('.loading').show();
		$.ajax({
			type:'post',
			url	: baseURL+'site/notify/getlatest',
			dataType: 'json',
			success: function(json){
				if(json.status_code == 1){
// $('.feed-notification').find('.loading').after(json.content);
					$('.feed-notification').html(json.content);
					$('.moreFeed').show();
				}else if(json.status_code == 2){
// $('.feed-notification').find('.loading').after(json.content);
					$('.feed-notification').html(json.content);
					$('.moreFeed').hide();
				}
			},
			complete:function(){
// $('.gnb-notification').find('.loading').hide();
				$('.gnb-notification').removeClass('cntLoading');
			}
		});
	}).mouseleave(function(){
		$('.feed-notification').hide();
	});
	// $('.save strong,.save span').click(function(){return false;});
	$('.save').unbind("click").bind("click",function(event){
		$('.save_cur').removeClass('save_cur');
		if(!$(this).hasClass('sign_box')){
			var pid = $(this).data('pid');
			if($(this).hasClass('saving'))return;
			$(this).addClass('saving');
			$(this).addClass('save_cur');
			$('#inline_example19 .select-list-inner ul').html('Loading...');
			$('#inline_example19 .select-list-inner ul').attr('tid',pid);
			$('#inline_example19 .save_done').data('pid',pid);
			$.ajax({
				type:'POST',
				url:baseURL+'site/user/add_list_when_fancyy',
				data:{tid:pid},
				dataType:'json',
				success:function(response){
					if(response.status_code == 1){
// $('#inline_example19 .select-list').text(response.firstCatName);
						$('#inline_example19 .select-list-inner ul').html(response.listCnt);
// if(response.wanted == 1){
// $('.btn-want').addClass('wanted').find('b').text('Wanted');
// }
					}
				}
			});
			var save_url = baseURL+'site/user/add_fancy_item';
			$.ajax({
				type:'POST',
				url:save_url,
				data:{tid:pid},
				dataType:'json',
				success:function(response){
						$('#inline_example19 .save_done').data('total_saves',response.likes);
				}
			});
			$(".save").colorbox({inline:true, href:"#inline_example19"});
			$('#colorbox').show();
			$(this).removeClass('saving');
		}
	});
	
	$('#inline_example19 .select-list-inner ul')
	.delegate('input[type=checkbox]', 'change', function(){
		var $li = $(this).closest('li'), params, url;

		params = {
			tid : $('#inline_example19 .select-list-inner ul').attr('tid'),
			list_ids : ''+this.getAttribute('id')
		};
		if(this.checked){
			url = baseURL+'site/user/add_item_to_lists';
			$li.addClass('selected');
		} else {
			url = baseURL+'site/user/remove_item_from_lists';
			$li.removeClass('selected');
		}

		$.ajax({
			type : 'post',
			url  : url,
			data : params,
			dataType : 'json',
			success  : function(response){
				if(response.status_code != 1) return;
			}
		});
	});
	$('#inline_example19 .create_list_sub').click(function(){
		var el, i, c, form = this, params = {};
		if(form.sending) return;
		form.sending = true;
		params.list_name = $(form).prev().val();
		if(!params.list_name){ 
			form.sending = false;
			return;
		}
		if(typeof params.category_id != 'undefined' && params.category_id == '0') delete params.category_id;
		
		params.tid = $('#inline_example19 .select-list-inner ul').attr('tid');
		
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/create_list',
			data : params,
			dataType : 'json',
			success  : function(response){
				if(response.status_code != 1) {
					alert(response.message);
					return;
				}

				$(form).prev().val('').end();

				var loid, lid = response.list_id,$chk = $('#inline_example19 .select-list-inner ul').find('input#'+lid), $ul, $li;
				if(!$chk.length){
					$ul = $('#inline_example19 .select-list-inner ul');
					$li = $('<li style="#fff6a0" class="selected"><label for="'+lid+'"><input type="checkbox" checked="checked" name="'+lid+'" id="'+lid+'">'+params.list_name+'</label></li>').prependTo($ul).animate({backgroundColor:'#fff'}, 500);
					$ul.animate({scrollTop:0},200);
					$chk = $li.find(':checkbox');
				}else{
					$chk.attr('checked','checked').closest('li').addClass('selected');
				}
					
			},
			complete : function(){
				form.sending = false;
			}
		});
	});
	$('.save_done').unbind('click').bind('click',function(){
		var cmt = $(this).prev().prev().val();
		var total_saves = $(this).data('total_saves');
		if(cmt != ''){
			var product_id = $(this).data('pid');
			var dataString = '&comments=' + cmt + '&cproduct_id=' + product_id;
			$.ajax({
				type: "POST",
				url: baseURL+'site/order/insert_product_comment',
				data: dataString,
				cache: false,
				dataType:'json',
				success: function(json){
					$('.save_done').prev().text('');
				}
			});
		}
		$('.save_cur').find('span').text(total_saves+' saves');
		$("#cboxOverlay,#colorbox").hide();
		$('.save_cur').parent().prev().append('<div class="saved_box" style="position:absolute;text-align: center;top:10px;right:10px;background-color:#D800C7;color:#fff;padding:8px;"><strong style="font-size: 18px;">Saved!</strong><br/>'+total_saves+' saves</div>');
		setTimeout(function(){
			$('.saved_box').remove();
		},3000);
	});

	$(".tag_box").click(function(){
		$('.tag_cur').removeClass('tag_cur');
		var pid = $(this).data('pid');
		$('#inline_example18 .tag_done').data('pid',pid);
		var tag_prid = $(this).attr('id');
		$('#product_tag_id').val(tag_prid);
		$(this).addClass('tag_cur');
		$('#colorbox').show();
	});
	
	$('.tag_done').unbind('click').bind('click',function(){
		var cmt = $('#searchid').val();
		if(cmt == '')return;
		var product_id = $(this).data('pid');
		var dataString = '&comments=' + cmt + '&cproduct_id=' + product_id;
		$.ajax({
			type: "POST",
			url: baseURL+'site/order/insert_tag_comment',
			data: dataString,
			cache: false,
			dataType:'json',
			success: function(json){
				$('.tag_done').prev().html('');
			}
		});
		$("#cboxOverlay,#colorbox").hide();
		$('.tag_cur').parent().prev().append('<div class="tagged_box" style="position:absolute;text-align: center;top:10px;left:10px;background-color:#D800C7;color:#fff;padding:8px;"><strong style="font-size: 18px;">Tagged!</strong></div>');
		setTimeout(function(){
			$('.tagged_box').remove();
		},3000);
	});
	
	$(".tag_box,.box_post,.example9,.example10,.example16,.example25").click(function(){
		$('.div_email1,.div_email,.div_username,.div_password').text('').hide();
		$('#colorbox').show();
	});
	$(".close_box,.stories-product-selector-done").click(function(){$('#cboxOverlay,#colorbox').hide();});
	
	var sending = false;
	$('#notibar-email-confirm a:not([href])').click(function(event){
		var $this = $(this).attr('href', '#');
		event.preventDefault();

		if(sending) return;
		sending = true;
		var oldHtm = $this.parent();
		oldHtm.css('opacity','0').css('opacity','1').html('Processing...');
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/send_email_confirmation',
			data : {resend : true},
			dataType: 'json',
			success : function(response){
				if (typeof response.status_code == 'undefined') return;
				if (response.status_code == 1) {
// $this.parent().css('opacity','0').css('opacity','1').html(gettext('Success!
// You should receive a new confirmation email soon.'));
					oldHtm.css('opacity','0').css('opacity','1').html('Success! You should receive a new confirmation email soon.');
				} else if (response.status_code == 0) {
					if(response.message) alert(response.message);
				}
			},
			complete : function(){
				sending = false;
			}
		});
	});
	
});


function checkBoxValidationAdmin(req,AdmEmail) {	
	
	var tot=0;
	var chkVal = 'on';
	var frm = $('#display_form input');
	for (var i = 0; i < frm.length; i++){
		if(frm[i].type=='checkbox') {
			if(frm[i].checked) {
				tot=1;
				if(frm[i].value != 'on'){
					chkVal = frm[i].value;
				}
			}
		}
	}
	if(tot == 0) {
			alert("Please Select the CheckBox");
			return false;
	}else if(chkVal == 'on') {
			alert("No records found ");
			return false;  
	
	} else {
		confirm_global_status(req,AdmEmail);
	} 
		
}
function checkBoxWithSelectValidationAdmin(req,AdmEmail) {	
	var templat = $('#mail_contents').val();
	if(templat==''){
		alert("Please select the mail template");
		return false;
	}
	var tot=0;
	var chkVal = 'on';
	var frm = $('#display_form input');
	for (var i = 0; i < frm.length; i++){
		if(frm[i].type=='checkbox') {
			if(frm[i].checked) {
				tot=1;
				if(frm[i].value != 'on'){
					chkVal = frm[i].value;
				}
			}
		}
	}
	if(tot == 0) {
			alert("Please Select the CheckBox");
			return false;
	}else if(chkVal == 'on') {
			alert("No records found ");
			return false;  
	
	} else {
		confirm_global_status(req,AdmEmail);
	} 
		
}
function SelectValidationAdmin(req,AdmEmail) {	
	var templat = $('#mail_contents').val();
	if(templat==''){
		alert("Please select the mail template");
		return false;
	}
	
	confirm_global_status(req,AdmEmail);
	 
		
}
function confirm_global_status(req,AdmEmail){
 	$.confirm({
 		'title'		: 'Confirmation',
 		'message'	: 'Whether you want to continue this action?',
 		'buttons'	: {
 			'Yes'	: {
 				'class'	: 'yes',
 				'action': function(){
					bulk_logs_action(req,AdmEmail);
 					// $('#statusMode').val(req);
 					// $('#display_form').submit();
 				}
 			},
 			'No'	: {
 				'class'	: 'no',
 				'action': function(){
 					return false;
 				}	// Nothing to do in this case. You can as well omit the
					// action property.
 			}
 		}
 	});
 }
 
// Bulk Active, Inactive, Delete Logs created by siva
function bulk_logs_action(req,AdmEmail){
	
	
	var perms=prompt("For Security Purpose, Please Enter Email Id");
	if(perms==''){
			alert("Please Enter The Email ID");
			return false;
	}else if(perms==null){	
			return false;
	}else{ 
		if(perms==AdmEmail){
				$('#statusMode').val(req);
				$('#SubAdminEmail').val(AdmEmail);				
		 		$('#display_form').submit();
		}else{
				alert("Please Enter The Correct Email ID");
				return false;	
		}
	}

	
	
}

 
// confirm status change
function confirm_status(path){
 	$.confirm({
 		'title'		: 'Confirmation',
 		'message'	: 'You are about to change the status of this record ! Continue?',
 		'buttons'	: {
 			'Yes'	: {
 				'class'	: 'yes',
 				'action': function(){
 					window.location = BaseURL+path;
 				}
 			},
 			'No'	: {
 				'class'	: 'no',
 				'action': function(){
 					return false;
 				}	// Nothing to do in this case. You can as well omit the
					// action property.
 			}
 		}
 	});
 }			
// confirm mode change
function confirm_mode(path){
	$.confirm({
		'title'		: 'Confirmation',
		'message'	: 'You are about to change the display mode of this record ! Continue?',
		'buttons'	: {
			'Yes'	: {
				'class'	: 'yes',
				'action': function(){
					window.location = BaseURL+path;
				}
			},
			'No'	: {
				'class'	: 'no',
				'action': function(){
					return false;
				}	// Nothing to do in this case. You can as well omit the
					// action property.
			}
		}
	});
}			
function confirm_delete(path){
 	$.confirm({
 		'title'		: 'Delete Confirmation',
 		'message'	: 'You are about to delete this record. <br />It cannot be restored at a later time! Continue?',
 		'buttons'	: {
 			'Yes'	: {
 				'class'	: 'yes',
 				'action': function(){
 					window.location = BaseURL+path;
 				}
 			},
 			'No'	: {
 				'class'	: 'no',
 				'action': function(){
 					return false;
 				}	// Nothing to do in this case. You can as well omit the
					// action property.
 			}
 		}
 	});
 }	
 
 
// Category Add Function By Siva
function checkBoxCategory() {	
	
	var tot=0;
	var chkVal = 'on';
	var frm = $('#display_form input');
	for (var i = 0; i < frm.length; i++){
		if(frm[i].type=='checkbox') {
			if(frm[i].checked) {
				tot=1;
				chkVal = frm[i].value;
			}
		}
	}
		if(tot == 0) {
				alert("Please Select the CheckBox");
				return false;
		}else if(tot > 1){
				alert("Please Select only one CheckBox at a time");
				return false;
		}else if(chkVal == 'on') {
				alert("No records found ");
				return false;  
		
		} else {
			confirm_category_checkbox(chkVal);
		} 
		
}

// Category Checkbox Confirmation
function confirm_category_checkbox(chkVal){
 	$.confirm({
 		'title'		: 'Confirmation',
 		'message'	: 'Whether you want to continue this action?',
 		'buttons'	: {
 			'Yes'	: {
 				'class'	: 'yes',
 				'action': function(){
					$('#checkboxID').val(chkVal);
 					$('#display_form').submit();
 				}
 			},
 			'No'	: {
 				'class'	: 'no',
 				'action': function(){
 					return false;
 				}	// Nothing to do in this case. You can as well omit the
					// action property.
 			}
 		}
 	});
 }

/**
 * 
 * Change the seller request status
 * 
 * @param val ->
 *            status
 * @param sid ->
 *            seller request id
 */
function changeSellerStatus(sid,uid){
	val = $('#seller_status_'+sid).val();
	if(val != '' && sid != ''){
		$.ajax(
	    {
	        type: 'POST',
	        url: 'admin/seller/change_seller_request',
	        data: {"id": sid,'status': val,'user_id': uid},
	        dataType: 'json',
	        success: function(json)
	        {
	            alert(json);
	        }
	    });
	}
}

function disableGiftCards(path,mail){
	$.confirm({
 		'title'		: 'Confirmation',
 		'message'	: 'You are about to change the mode of giftcards ! Continue?',
 		'buttons'	: {
 			'Yes'	: {
 				'class'	: 'yes',
 				'action': function(){
 					var perms=prompt("For Security Purpose, Please Enter Email Id");
 					if(perms==''){
 							alert("Please Enter The Email ID");
 							return false;
 					}else if(perms==null){	
 							return false;
 					}else{ 
 						if(perms==mail){
 							window.location = BaseURL+path;
 						}else{
 								alert("Please Enter The Correct Email ID");
 								return false;	
 						}
 					}
 				}
 			},
 			'No'	: {
 				'class'	: 'no',
 				'action': function(){
 					return false;
 				}	// Nothing to do in this case. You can as well omit the
					// action property.
 			}
 		}
 	});
}

function editPictureProducts(val,imgId){

	var id = 'img_'+val;
	var sPath = window.location.pathname;
	var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
	$.ajax(
		    {
		        type: 'POST',
		        url: BaseURL+'admin/product/editPictureProducts',
		        data: {"id": id,'cpage': sPage,'position': val,'imgId':imgId},
		        dataType: 'json',
		        success: function(response)
		        {
		        	if(response == 'No') {
						alert("You can't delete all the images");
						return false;
					  } else {
							  $('#img_'+val).remove();
					  }
		        }
		    });
}

function editPictureProductsUser(val,imgId){
	
	var id = 'img_'+val;
	var sPath = window.location.pathname;
	var sPage = sPath.substring(sPath.lastIndexOf('/') + 1);
	$.ajax(
			{
				type: 'POST',
				url: BaseURL+'site/product/editPictureProducts',
				data: {"id": id,'cpage': sPage,'position': val,'imgId':imgId},
				dataType: 'json',
				success: function(response)
				{
					if(response == 'No') {
						alert("You can't delete all the images");
						return false;
					} else {
						$('#img_'+val).remove();
					}
				}
			});
}

function quickSignup(){
	var dlg_signin = $.dialog('signin-overlay'),
    	dlg_register = $.dialog('register');
	var email = $('#signin-email').val();
	$.ajax({
        type: 'POST',
        url: baseURL+'site/user/quickSignup',
        data: {"email": email},
        dataType: 'json',
        success: function(response)
        {
        	if(response.success == '0') {
				alert(response.msg);
				return false;
			 } else {
			 	$('.quickSignup2 .username').val(response.user_name);
			 	$('.quickSignup2 .url b').text(response.user_name);
			 	$('.quickSignup2 .email').val(response.email);
			 	$('.quickSignup2 .fullname').val(response.full_name);
                dlg_register.open();
			 }
        }
    });
}
function quickSignup2(){
	var username = $('.quickSignup2 .username').val();
	var email = $('.quickSignup2 .email').val();
	var password = $('.quickSignup2 .user_password').val();
	var fullname = $('.quickSignup2 .fullname').val();
	$.ajax({
        type: 'POST',
        url: baseURL+'site/user/quickSignupUpdate',
        data: {"username":username,"email": email,"password":password,"fullname":fullname},
        dataType: 'json',
        success: function(response)
        {
        	if(response.success == '0') {
				alert(response.msg);
				return false;
			 } else {
				 location.href = baseURL+'send-confirm-mail';
			 }
        }
    });
}
function signup_user(evt){
	if($(evt).hasClass('wait'))return;
	$(evt).addClass('wait');
	var $submit = $(evt).find('button.sign');
	var sub_txt = $submit.text();
	$submit.text('Wait...');
	var fullname = $('.fullname').val();
	var username = $('.username').val();
	var email = $('.signup_email').val();
	var pwd = $('.password').val();
	
	var api_id = $('#api_id').val();
	var thumbnail = $('#thumbnail').val();
	
	
	if(fullname==''){
		alert('Full name required');
	}else if(username==''){
		alert('User name required');
	}else if(email==''){
		alert('Email required');
	}else if(pwd==''){
		alert('Password required');
	}else if(pwd.length < 6){
		alert('Password must be minimum of 6 characters');
	}else {
		var brand = 'no';
		if($('.brandSt').is(':checked')){
			brand = 'yes';
		}
		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/registerUser',
	        data: {"fullname":fullname,"username":username,"email": email,"pwd":pwd,"brand":brand,"api_id":api_id,"thumbnail":thumbnail},
	        dataType: 'json',
	        success: function(response)
	        {
	        	if(response.success == '0') {
					alert(response.msg);
					$(evt).removeClass('wait');
					$submit.text(sub_txt);
					return false;
				 } else {
					 location.href = baseURL+'send-confirm-mail';
				 }
	        }
	    });
	}
	$(evt).removeClass('wait');
	$submit.text(sub_txt);
	return false;
}
function register_user(evt){
	var $form = $(evt),
		submit = $form.find('input[type=submit]'),
		emailDiv = $form.find('input#email'),
		unameDiv = $form.find('input#username'),
		pwdDiv = $form.find('input#password');
	if($form.hasClass('processing'))return false;
	submit.val('Wait...');
	$form.addClass('processing');
	var email = emailDiv.val();
	var username = unameDiv.val();
	var pwd = pwdDiv.val();
	if(email == ''){
		$('.div_email').text('Email required').show();
		submit.val('Start Shopping');
		// alert('Email required');
		emailDiv.focus();
		$form.removeClass('processing');
		return false;
	}else if(!(/^[\w\+\-\.]{2,64}@([\w-]+\.)+[a-z]{2,3}$/i.test(email))){
		$('.div_email').text('Invalid Email').show();
		submit.val('Start Shopping');
		// alert('Invalid Email');
		emailDiv.focus();
		$form.removeClass('processing');
		return false;
	}else if(username == ''){
		$('.div_email').hide();
		$('.div_username').text('Username required').show()
		submit.val('Start Shopping');;
		// alert('Username required');
		unameDiv.focus();
		$form.removeClass('processing');
		return false;
	}else if(pwd == ''){
		$('.div_email,.div_username').hide();
		$('.div_password').text('Password required').show();
		submit.val('Start Shopping');
		// alert('Password required');
		pwdDiv.focus();
		$form.removeClass('processing');
		return false;
	}else{
		submit.val('Wait...');
		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/registerUser',
	        data: {"username":username,"email": email,"pwd":pwd},
	        dataType: 'json',
	        success: function(response)
	        {
	        	if(response.success == '0') {
					// alert(response.msg);
					$('.div_email1').text(response.msg).show();
					submit.val('Start Shopping');
					return false;
				 } else {
					 $('#inline_example7 .popup_mobile_detail').html(response.products);
					 $(".example12").trigger('click');
				 }
	        },
	        complete: function(){
	        	$form.removeClass('processing');
	        	submit.val('Start Shopping');
	    		return false;
	        }
	    });
		
	}
	return false;
}

function register_user1(){
	var username = $('#popusername').val();
	var email = $('#popemail').val();
	var pwd = $('#poppassword').val();
	var $submit = $('#popemail').parent().find('input[type=submit]');
	var $form = $('#popemail').parent();
	if($form.hasClass('processing'))return false;
	$submit.val('Wait...');
	$form.addClass('processing');
	if(email == ''){
		$('.div_email1').text('Email required').show();
		$submit.val('Start Shopping');
		// alert('Email required');
		$('#popemail').focus();
		$form.removeClass('processing');
		return false;
	}else if(!(/^[\w\+\-\.]{2,64}@([\w-]+\.)+[a-z]{2,3}$/i.test(email))){
		$('.div_email1').text('Invalid Email').show();
		$submit.val('Start Shopping');
		// alert('Invalid Email');
		$('#popemail').focus();
		$form.removeClass('processing');
		return false;
	}else if(username == ''){
		$('.div_email1').text('Username required').show()
		$submit.val('Start Shopping');;
		// alert('Username required');
		$('#popusername').focus();
		$form.removeClass('processing');
		return false;
	}else if(pwd == ''){
		$('.div_email1').text('Password required').show();
		$submit.val('Start Shopping');
		// alert('Password required');
		$('#poppassword').focus();
		$form.removeClass('processing');
		return false;
	}else{
		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/registerUser',
	        data: {"username":username,"email": email,"pwd":pwd},
	        dataType: 'json',
	        success: function(response)
	        {
	        	if(response.success == '0') {
					// alert(response.msg);
					$('.div_email1').text(response.msg).show();
					return false;
				 } else {
					 $('#inline_example7 .popup_mobile_detail').html(response.products);
					 $(".example12").trigger('click');
				 }
	        },
	        complete: function(){
	        	$submit.val('Start Shopping');
	        	$form.removeClass('processing');
	    		return false;
	        }
	    });
	}

	return false;
}
function signin_popup(){
	var email = $('#semail').val();
	var pwd = $('#spassword').val();

		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/login_user_popup',
	        data: {"email": email,"pwd":pwd},
	        dataType: 'json',
	        success: function(response)
	        {
	        	if(response.success == '0') {
					// alert(response.msg);
					$('.div_email1').text(response.msg).show();
					return false;
				 } else {
					$(document).ready(function(){
						// show the modal box
						// alert(response.msg);
					});
					location.reload();
// location.href = baseURL+'myfeed';
				 }
	        }
	    });
	return false;
}
function hideErrDiv(arg) {
	 $("#"+arg).hide("slow");
}
function resendConfirmation(mail){
	if(mail != ''){
		$('.confirm-email').html('<span>Sending...</span>');
		$.ajax({
	        type: 'POST',
	        url: baseURL+'site/user/resend_confirm_mail',
	        data: {"mail": mail},
	        dataType: 'json',
	        success: function(response){
	        	if(response.success == '0') {
					alert(response.msg);
					return false;
				 } else {
					 $('.confirm-email').html('<font color="green">Confirmation Mail Sent Successfully</font>');
				 }
	        }
	    });
	}
}
function profileUpdate(){
	// $('#save_account').disable();
	var full_name=$('.setting_fullname').val();
	var web_url=$('.setting_website').val();
	var location=$('.setting_location').val();
	var twitter=$('.setting_twitter').val();
	var facebook=$('.setting_facebook').val();
	var google=$('.setting_google').val();
	var b_year=$('.birthday_year').val();
	var b_month=$('.birthday_month').val();
	var b_day=$('.birthday_day').val();
	var setting_bio=$('.setting_bio').val();
	var email=$('.setting_email').val();
	var age=$('.setting_age').val();
	var gender=$('.setting_gender:checked').val();
	$.ajax({
		type: 'POST',
		url: baseURL+'site/user_settings/update_profile',
		data: {"full_name":full_name,"web_url":web_url,"location":location,"twitter":twitter,"facebook":facebook,"google":google,"b_year":b_year,"b_month":b_month,"b_day":b_day,"about":setting_bio,"email":email,"age":age,"gender":gender},
		dataType: 'json',
		success: function(response){
			if(response.success == '0'){
				alert(response.msg);
				$('#save_account').removeAttr('disabled');
				return false;
			}else{
				window.location.href = baseURL+'settings';
			}
		}
	});
	return false;
}
function updateUserPhoto(){
	// $('#save_profile_image').disable();
	if($('.uploadavatar').val()==''){
		alert('Choose a image to upload');
		$('#save_profile_image').removeAttr('disabled');
		return false;
	}else{
		$('#profile_settings_form').removeAttr('onSubmit');
		$('#profile_settings_form').submit();
	}
}
function deleteUserPhoto(){
	// $('#delete_profile_image').disable();
	var res = window.confirm('Are you sure?');
	if(res){
		$.ajax({
			type:'POST',
			url:baseURL+'site/user_settings/delete_user_photo',
			dataType:'json',
			success:function(response){
				if(response.success == '0'){
					alert(response.msg);
					$('#delete_profile_image').removeAttr('disabled');
					return false;
				}else{
					window.location.href = baseURL+'settings';
				}
			}
		});
	}else{
		$('#delete_profile_image').removeAttr('disabled');
		return false;
	}
}
function deactivateUser(){
	$('#close_account').disable();
	var res = window.confirm('Are you sure?');
	if(res){
		$.ajax({
			url:baseURL+'site/user_settings/delete_user_account',
			success:function(response){
				window.location.href = baseURL;
			}
		});
	}else{
		$('#close_account').removeAttr('disabled');
	}
}

function delete_gift(val,gid) {
	
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/cart/ajaxDelete',
		data:{'curval':val,'cart':'gift'},
		success:function(response){
			var arr = response.split('|');
			$('#gift_cards_amount').val(arr[0]);
			$('#item_total').html(arr[0]);
			$('#total_item').html(arr[0]);
			$('#Shop_id_count').html(arr[1]);	
			$('#Shop_MiniId_count').html(arr[1]+' items');				
			$('#giftId_'+gid).hide();
			$('#GiftMindivId_'+gid).hide();
			if(arr[0] == 0){
				$('#GiftCartTable').hide();
				if(arr[1]==0){
					$('#EmptyCart').show();
				}
			}
		}
	});
}	


function delete_subscribe(val,sid) {
	
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/cart/ajaxDelete',
		data:{'curval':val,'cart':'subscribe'},
		success:function(response){
			var arr = response.split('|');
			$('#subcrib_amount').val(arr[0]);
			$('#subcrib_ship_amount').val(arr[1]);
			$('#subcribt_tax_amount').val(arr[2]);
			$('#subcrib_total_amount').val(arr[3]);			
			$('#SubCartAmt').html(arr[0]);
			$('#SubCartSAmt').html(arr[1]);
			$('#SubCartTAmt').html(arr[2]);
			$('#SubCartGAmt').html(arr[3]);			
			$('#Shop_id_count').html(arr[4]);
			$('#Shop_MiniId_count').html(arr[4]+' items');			
			$('#SubscribId_'+sid).hide();
			$('#SubcribtMinidivId_'+sid).hide();
			
			
			if(arr[0] == 0){
				$('#SubscribeCartTable').hide();
				if(arr[4]==0){
					$('#EmptyCart').show();
				}
			}
		}
	});
}	


function delete_cart(val,cid) {
		$.ajax({
			type: 'POST',   
			url:baseURL+'site/cart/ajaxDelete',
			data:{'curval':val,'cart':'cart'},
			success:function(response){
				
			// alert(response);
			var arr = response.split('|');
			$('#cart_amount').val(arr[0]);
			$('#cart_ship_amount').val(arr[1]);
			$('#cart_tax_amount').val(arr[2]);
			$('#cart_total_amount').val(arr[3]);			
			$('#CartAmt').html(arr[0]);
			$('#CartSAmt').html(arr[1]);
			$('#CartTAmt').html(arr[2]);
			$('#CartGAmt').html(arr[3]);			
			$('#Shop_id_count').html(arr[4]);
			$('#Shop_MiniId_count').html(arr[4]+' items');			
			$('#cartdivId_'+cid).hide();
			$('#cartMindivId_'+cid).hide();
			
			if(arr[0] == 0){
				$('#CartTable').hide();
				if(arr[4]==0){
					$('#EmptyCart').show();
				}
			}
			}
		});
}	


function update_cart(val,cid) {
	
	var qty  = $('#quantity'+cid).val();
	var mqty = $('#quantity'+cid).data('mqty');
	if(qty-qty != 0 || qty == '' || qty == '0'){
		alert('Invalid quantity');
		return false;
	}
	if(qty>mqty){
		$('#quantity'+cid).val(mqty);
		qty = mqty;
		alert('Maximum stock available for this product is '+mqty);
	}
		$.ajax({
			type: 'POST',   
			url:baseURL+'site/cart/ajaxUpdate',
			data:{'updval':val,'qty':qty},
			success:function(response){
				// alert(response);
				var arr = response.split('|');
				$('#cart_amount').val(arr[1]);
				$('#cart_ship_amount').val(arr[2]);
				$('#cart_tax_amount').val(arr[3]);
				$('#cart_total_amount').val(arr[4]);			
				$('#IndTotalVal'+cid).html(arr[0]);				
				$('#CartAmt').html(arr[1]);
				$('#CartAmtDup').html(arr[1]);
				$('#CartSAmt').html(arr[2]);
				$('#CartTAmt').html(arr[3]);
				$('#CartGAmt').html(arr[4]);			
				$('#Shop_id_count').html(arr[5]);
				$('#Shop_MiniId_count').html(arr[5]+' items');	
			
			}
		});
}	

function CartChangeAddress(IDval){
	
	var amt = $('#cart_amount').val();	
	var disamt = $('#discount_Amt').val();	
	
	
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/cart/ajaxChangeAddress',
		data:{'add_id':IDval,'amt':amt,'disamt':disamt},
		success:function(response){
			
			if(response !='0'){
				
				var arr = response.split('|');
				$('#cart_ship_amount').val(arr[0]);
				$('#cart_tax_amount').val(arr[1]);
				$('#cart_tax_Value').val(arr[2]);
				$('#cart_total_amount').val(arr[3]);
				$('#CartSAmt').html(arr[0]);
				$('#CartTAmt').html(arr[1]);
				$('#carTamt').html(arr[2]);
				$('#CartGAmt').html(arr[3]);
				
				$('#Ship_address_val').val(IDval);
				$('#Chg_Add_Val').html(arr[4]);
			}else{
			
				return false;	
			}
		}
	});
}


function SubscribeChangeAddress(IDval){
	
	var amt = $('#subcrib_amount').val();	
	
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/cart/ajaxSubscribeAddress',
		data:{'add_id':IDval,'amt':amt},
		success:function(response){
			if(response !='0'){
				// alert(response);
				var arr = response.split('|');
				$('#subcrib_ship_amount').val(arr[0]);
				$('#subcrib_tax_amount').val(arr[1]);
				$('#subcrib_total_amount').val(arr[3]);
				$('#SubCartSAmt').html(arr[0]);
				$('#SubCartTAmt').html(arr[1]);
				$('#SubTamt').html(arr[2]);
				$('#SubCartGAmt').html(arr[3]);
				$('#SubShip_address_val').val(IDval);
				$('#SubChg_Add_Val').html(arr[4]);
			}else{
				return false;	
			}
		}
	});
}

function shipping_Subcribe_address_delete(){
	var DelId = $('#SubShip_address_val').val();
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/cart/ajaxDeleteAddress',
		data:{'del_ID':DelId},
		success:function(response){
			if(response ==0){
				location.reload();
			}else{
				$('#Ship_Sub_err').html('Default Address can not be deleted.');
				setTimeout("hideErrDiv('Ship_Sub_err')", 3000);
				return false;	
			}
		}
	});
}

function shipping_cart_address_delete(){
	var DelId = $('#Ship_address_val').val();

	$.ajax({
		type: 'POST',   
		url:baseURL+'site/cart/ajaxDeleteAddress',
		data:{'del_ID':DelId},
		success:function(response){
			if(response ==0){
				alert('Shipping Address deleted successfully.');
				location.reload();
			}else{
				$('#Ship_err').html('Default Address can not be deleted.');
				setTimeout("hideErrDiv('Ship_err')", 3000);
				return false;	
			}
		}
	});
}



function ajax_add_cart_old(){
	var login = $('.add_to_cart').attr('require_login');
	if(login){ require_login(); return;}
	var quantity=$('.quantity').val();
	var mqty = $('.quantity').data('mqty');
	if(quantity == '0' || quantity == ''){
		alert('Invalid quantity');
		return false;
	}
	if(quantity>mqty){
		alert('Maximum stock of this product is '+mqty);
		$('.quantity').val(mqty);
		return false;
	}
	var product_id=$('#product_id').val();
	var sell_id=$('#sell_id').val();
	var price=$('#price').val();
	var product_shipping_cost=$('#product_shipping_cost').val();
	var product_tax_cost=$('#product_tax_cost').val();
	var cate_id=$('#cateory_id').val();		
	var attribute_values=$('#attribute_values').val();

	
	// alert(product_id+''+sell_id+''+price+''+product_shipping_cost+''+product_tax_cost+''+attribute_values);
	$.ajax({
		type: 'POST',
		url: baseURL+'site/cart/cartadd',
		data: {'mqty':mqty,'quantity':quantity, 'product_id':product_id, 'sell_id':sell_id, 'cate_id':cate_id, 'price':price, 'product_shipping_cost':product_shipping_cost, 'product_tax_cost':product_tax_cost, 'attribute_values':attribute_values},
		success: function(response){
			// alert(response);
			if(response =='login'){
				alert("Login required");
				window.location.href= baseURL;	
			}else{
				$('#MiniCartViewDisp').html(response);
				$('#cart_popup').show().delay('2000').fadeOut();
				window.location.href= baseURL+"cart";	
			}

		}
	});
	return false;
	
	
}

function ajax_add_cart(AttrCountVal){
	$('#QtyErr').html('');
	var login = $('.add_to_cart').attr('require_login');
	if(login){ require_login(); return;}
	var quantity=$('#quantity').val();
	var mqty = $('#quantity').data('mqty');
	if(quantity == '0' || quantity == '' || (quantity-quantity)!=0){
		$('#QtyErr').html('Invalid quantity');
		return false;
	}
	if(quantity>mqty){
//		alert('Maximum stock of this product is '+mqty);
		$('#QtyErr').html('Maximum stock of this product is '+mqty);
		$('.quantity').val(mqty);
		return false;
	}
	if(AttrCountVal > 0){
		$('#AttrErr').html(' ');
		var AttrVal=$('#attr_name_id').val();	
		if(AttrVal == 0){
			$('#AttrErr').html('Please Choose the Option');
			return false;
		}
	}
	
	
	
	//alert(AttrVal); return false;
	var product_id=$('#product_id').val();
	var sell_id=$('#sell_id').val();
	var price=$('#price').val();
	var product_shipping_cost=$('#product_shipping_cost').val();
	var product_tax_cost=$('#product_tax_cost').val();
	var cate_id=$('#cateory_id').val();		
	var attribute_values=$('#attr_name_id').val();

	
	//alert(product_id+''+sell_id+''+price+''+product_shipping_cost+''+product_tax_cost+''+attribute_values);
	$.ajax({
		type: 'POST',
		url: baseURL+'site/cart/cartadd',
		data: {'mqty':mqty,'quantity':quantity, 'product_id':product_id, 'sell_id':sell_id, 'cate_id':cate_id, 'price':price, 'product_shipping_cost':product_shipping_cost, 'product_tax_cost':product_tax_cost, 'attribute_values':attribute_values},
		success: function(response){
			//alert(response);
			var arr = response.split('|');
			if(arr[0] =='login'){
				window.location.href= baseURL+"login";	
			}else if(arr[0] == 'Error'){
				$('#ADDCartErr').html('Maximum Quantity: '+mqty+'. Already in your cart: '+arr[1]+'.');
			}else{
				$('#MiniCartViewDisp').html(arr[1]);
				//$('#cart_popup').show().delay('2000').fadeOut();
				$('#cart_popup').css('visibility','visible');
				setTimeout(function(){
					$('#cart_popup').css('visibility','hidden');
				},2000);
			}

		}
	});
	return false;
	
	
}

function ajax_add_cart_subcribe(){
	var login = $('#subscribe').attr('require_login');
	if(login){ require_login(); return;}
	
	var user_id=$('#user_id').val();
	var quantity=1;
	var fancybox_id=$('#fancybox_id').val();
	var price=$('#price').val();
	var fancy_shipping_cost=$('#shipping_cost').val();
	var fancy_tax_cost=$('#tax').val();
	var category_id=$('#category_id').val();		
	var name=$('#name').val();		
	var seourl=$('#seourl').val();		
	var image=$('#image').val();			

	$.ajax({
		type: 'POST',
		url: baseURL+'site/fancybox/cartsubscribe',
		data: {'name':name, 'quantity':quantity, 'user_id':user_id, 'fancybox_id':fancybox_id, 'price':price, 'fancy_ship_cost':fancy_shipping_cost, 'category_id':category_id, 'fancy_tax_cost':fancy_tax_cost, 'seourl':seourl, 'image':image},
		success: function(response){
			// alert(response);
			if(response =='login'){
				window.location.href= baseURL+"login";	
			}else{
				$('#MiniCartViewDisp').html(response);
				$('#cart_popup').show().delay('3000').fadeOut();
			}

		}
	});
	return false;
}



function ajax_add_gift_card(){

	var login = $('.create-gift-card').attr('require_login');
	if(login){ require_login(); return;}
	
	$('#GiftErr').html();
					   
	var price = $('#price_value').val();
	var rec_name = $('#recipient_name').val();
	var rec_mail = $('#recipient_mail').val();
	var descp = $('#description').val();
	var sen_name = $('#sender_name').val();
	var sen_mail = $('#sender_mail').val();
	if(price ==''){
		$('#GiftErr').html('Please Select the Price Value');
		return false;		
	}
	if(rec_name ==''){
		$('#GiftErr').html('Please Enter the Receiver Name');
		return false;		
	}
	if(rec_mail ==''){
		$('#GiftErr').html('Please Enter the Receiver Email');		
		return false;		
	}else{
		if( !validateEmail(rec_mail)) { 
				$('#GiftErr').html('Please Enter Valid Email Address');		
				return false;
		}
	}
	if(descp =='' ){
		$('#GiftErr').html('Please  Enter the Description');		
		return false;
	}

		$.ajax({
			type: 'POST',
			url: baseURL+'site/giftcard/insertEditGiftcard',	
			data: {'price_value':price, 'recipient_name':rec_name, 'recipient_mail':rec_mail, 'description':descp, 'sender_name':sen_name, 'sender_mail':sen_mail },
			success: function(response){
				if(response =='login'){
					window.location.href= baseURL+"login";	
				}else{
					$('#MiniCartViewDisp').html(response);
					$('#cart_popup').show();
				}
			}
		});
		
	return false;
	
}






function change_user_password(){
	$('#save_password').disable();
	var pwd = $('#pass').val();
	var cfmpwd = $('#confirmpass').val();
	if(pwd == ''){
		alert('Enter new password');
		$('#save_password').removeAttr('disabled');
		$('#pass').focus();
		return false;
	}else if(pwd.length < 6){
		alert('Password must be minimum of 6 characters');
		$('#save_password').removeAttr('disabled');
		$('#pass').focus();
		return false;
	}else if(cfmpwd == ''){
		alert('Confirm password required');
		$('#save_password').removeAttr('disabled');
		$('#confirmpass').focus();
		return false;
	}else if(pwd != cfmpwd){
		alert('Passwords doesnot match');
		$('#save_password').removeAttr('disabled');
		$('#confirmpass').focus();
		return false;
	}else{
		return true;
	}
}

function shipping_address_cart(){

	$(".add_addr").colorbox({width:"600px", inline:true, href:"#addshippingaddress"});
	// setTimeout(function(){dlg_address.$obj.find(':text:first').focus()},10);
}

// Coupon code Used

function checkCode() {
	
	$('#CouponErr').html('');
	$('#CouponErr').show();
	
	var cartValue = $('#cart_amount').val();
	if(cartValue > 0){
	
	var code = $('#is_coupon').val();
	var amount = $('#cart_total_amount').val();
	var shipamount = $('#cart_ship_amount').val();
	var taxamount = $('#cart_tax_amount').val();
	
		if(code != '') {

			$.ajax({
			type: 'POST',
			url: baseURL+'site/cart/checkCode',
			data: {'code':code, 'amount':amount, 'shipamount':shipamount},
			success: function(response){
// alert(response);
				var resarr = response.split('|');
				if(response == 1) {
					$('#CouponErr').html('Entered code is invalid');
					return false;
				} else if(response == 2) {
					$('#CouponErr').html('Code is already used');
					return false;
				}else if(response == 3) {
					$('#CouponErr').html('Please add more items in the cart and enter the coupon code');
					return false;
				} else if(response == 4) {
					$('#CouponErr').html('Entered Coupon code is not valid for this product');
					return false;
				} else if(response == 5) {
					$('#CouponErr').html('Entered Coupon code is expired');
					return false;
				} else if(response == 6) {
					$('#CouponErr').html('Entered code is Not Valid');
					return false;
				} else if(response == 7) {
					$('#CouponErr').html('Please add more items quantity in the particular category or product, for using this coupon code');
					return false;
				} else if(response == 8) {
					$('#CouponErr').html('Entered Gift code is expired');
					return false;	
				} else if(resarr[0] == 'Success') {
						
					$.ajax({
					type: 'POST',
					url: baseURL+'site/cart/checkCodeSuccess',
					data: {'code':code, 'amount':amount, 'shipamount':shipamount},
					success: function(response){
// alert(response);
						var arr = response.split('|');
						
						$('#cart_amount').val(arr[0]);
						$('#cart_ship_amount').val(arr[1]);
						$('#cart_tax_amount').val(arr[2]);
						$('#cart_total_amount').val(arr[3]);
						$('#discount_Amt').val(arr[4]);						
						$('#CartAmt').html(arr[0]);
						$('#CartSAmt').html(arr[1]);
						$('#CartTAmt').html(arr[2]);
						$('#CartGAmt').html(arr[3]);	
						$('#disAmtVal').html(arr[4]);
						$('#disAmtValDiv').show();
						$('#CouponCode').val(code);
						$('#Coupon_id').val(resarr[1]);
						$('#couponType').val(resarr[2]);
						var j=6;
						for (var i=0;i<arr[5];i++)	{ 
						// alert(arr[j]);
							$('#IndTotalVal'+i).html(arr[j]);
							 j++;
						}
						
						$("#CheckCodeButton").val('Remove');
						$("#is_coupon").attr('readonly','readonly');
						// $("#CheckCodeButton").removeAttr("onclick");
						document.getElementById("CheckCodeButton").setAttribute("onclick", "javascript:checkRemove();");
						
					}
					});
				} 
			}
		});
		} else {
			$('#CouponErr').html('Enter Valid Code');
		}
	} else {
		$('#CouponErr').html('Please add items in cart and enter the coupon code');
		
	}
	setTimeout("hideErrDiv('CouponErr')", 3000);
}

function checkRemove(){
	
	$('#CouponErr').html('');
	$('#CouponErr').show();
	
	var code = $('#is_coupon').val();
	// alert(code);
	$.ajax({
			type: 'POST',
			url: baseURL+'site/cart/checkCodeRemove',
			data: {'code':code},
			success: function(response){
			// alert(response);
				
						var arr = response.split('|');
						
						$('#cart_amount').val(arr[0]);
						$('#cart_ship_amount').val(arr[1]);
						$('#cart_tax_amount').val(arr[2]);
						$('#cart_total_amount').val(arr[3]);
						$('#discount_Amt').val(arr[4]);						
						$('#CartAmt').html(arr[0]);
						$('#CartSAmt').html(arr[1]);
						$('#CartTAmt').html(arr[2]);
						$('#CartGAmt').html(arr[3]);	
						$('#disAmtVal').html(arr[4]);
						$('#disAmtValDiv').show();
						$('#CouponCode').val(code);
						$('#Coupon_id').val(0);
						$('#couponType').val('');
						var j=6;
						for (var i=0;i<arr[5];i++)	{ 
						// alert(arr[j]);
							$('#IndTotalVal'+i).html(arr[j]);
							 j++;
						}
						
						$('#is_coupon').val('');
						$('#disAmtValDiv').hide();

						$("#is_coupon").removeAttr('readonly');
						$("#CheckCodeButton").val('Apply');
						document.getElementById("CheckCodeButton").setAttribute("onclick", "javascript:checkCode();");
						
					
			
			}
		});
	
	
}


function paypal(){
	$('#PaypalPay').show();
	$('#CreditCardPay').hide();	
	$('#otherPay').hide();
	$("#dep1").attr("class","depth1 current");
	$("#dep2").attr("class","depth2");	
	$("#dep1 a").attr("class","current");
	$("#dep2 a").attr("class","");	
}

function creditcard(){
	
	$('#CreditCardPay').show();	
	$('#PaypalPay').hide();
	$('#otherPay').hide();
	
	$("#dep1").attr("class","depth1");
	$("#dep2").attr("class","depth2 current");	
	$("#dep1 a").attr("class","");
	$("#dep2 a").attr("class","current");	
	
}

function othermethods(){
	
	$('#otherPay').show();	
	$('#PaypalPay').hide();
	$('#CreditCardPay').hide();	
	
	$("#dep1").attr("class","depth1");
	$("#dep2").attr("class","depth2");
	$("#dep3").attr("class","depth3 current");	
	$("#dep1 a").attr("class","");
	$("#dep2 a").attr("class","");
	$("#dep3 a").attr("class","current");	
	
}

function loadListValues(e){
	var lid =  $(e).val();
	var listValue = $(e).parent().next().find('select');
	if(lid == ''){
		listValue.html('<option value="">--Select--</option>');
	}else{
		listValue.hide();
		$(e).parent().next().append('<span class="loading">Loading...</span>');
		$.ajax({
			type:'POST',
			url:BaseURL+'admin/product/loadListValues',
			data:{lid:lid},
			dataType:'json',
			success:function(json){
				listValue.next().remove();
				listValue.html(json.listCnt).show();
			}
		});
	}
}

function loadListValuesUser(e){
	var lid =  $(e).val();
	var listValue = $(e).parent().next().find('select');
	if(lid == ''){
		listValue.html('<option value="">--Select--</option>');
	}else{
		listValue.hide();
		$(e).parent().next().append('<span class="loading">Loading...</span>');
		$.ajax({
			type:'POST',
			url:BaseURL+'site/product/loadListValues',
			data:{lid:lid},
			dataType:'json',
			success:function(json){
				listValue.next().remove();
				listValue.html(json.listCnt).show();
			}
		});
	}
}

function changeListValues(e,lvID){
	var lid =  $(e).val();
	var listValue = $(e).parent().next().find('select');
	if(lid == ''){
		listValue.html('<option value="">--Select--</option>');
	}else{
		listValue.hide();
		$(e).parent().next().append('<span class="loading">Loading...</span>');
		$.ajax({
			type:'POST',
			url:BaseURL+'admin/product/loadListValues',
			data:{lid:lid,lvID:lvID},
			dataType:'json',
			success:function(json){
				listValue.next().remove();
				listValue.html(json.listCnt).show();
			},
			complete:function(){
				listValue.next().remove();
				listValue.show();
			}
		});
	}
}

function changeListValuesUser(e,lvID){
	var lid =  $(e).val();
	var listValue = $(e).parent().next().find('select');
	if(lid == ''){
		listValue.html('<option value="">--Select--</option>');
	}else{
		listValue.hide();
		$(e).parent().next().append('<span class="loading">Loading...</span>');
		$.ajax({
			type:'POST',
			url:BaseURL+'site/product/loadListValues',
			data:{lid:lid,lvID:lvID},
			dataType:'json',
			success:function(json){
				listValue.next().remove();
				listValue.html(json.listCnt).show();
			},
			complete:function(){
				listValue.next().remove();
				listValue.show();
			}
		});
	}
}


// confirm status change
function confirm_status_dashboard(path){
 	$.confirm({
 		'title'		: 'Confirmation',
 		'message'	: 'You are about to change the status of this record ! Continue?',
 		'buttons'	: {
 			'Yes'	: {
 				'class'	: 'yes',
 				'action': function(){
 					window.location = BaseURL+'admin/dashboard/admin_dashboard';
 				}
 			},
 			'No'	: {
 				'class'	: 'no',
 				'action': function(){
 					return false;
 				}	// Nothing to do in this case. You can as well omit the
					// action property.
 			}
 		}
 	});
 }			
 
 
function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  if( !emailReg.test( $email ) ) {
    return false;
  } else {
    return true;
  }
}

function changeShipStatus(value,dealCode,seller){
	$('.status_loading_'+dealCode).prev().hide();
	$('.status_loading_'+dealCode).show();
	$.ajax({
		type:'post',
		url:baseURL+'site/user/change_order_status',
		data:{'value':value,'dealCode':dealCode,'seller':seller},
		dataType:'json',
		success:function(json){
			if(json.status_code == 1){
// alert('Shipping status changed successfully');
			}
		},
		fail:function(data){
			alert(data);
		},
		complete:function(){
			$('.status_loading_'+dealCode).hide();
			$('.status_loading_'+dealCode).prev().show();
		}
	});
}

function changeCatPos(evt,catID){
	var pos = $(evt).prev().val();
	if((pos-pos) != 0){
		alert('Invalid position');
		return;
	}else{
		$(evt).hide();
		$(evt).next().show();
		$.ajax({
			type:'post',
			url:baseURL+'admin/category/changePosition',
			data:{'catID':catID,'pos':pos},
			complete:function(){
				$(evt).next().hide();
				$(evt).show().text('Done').delay(800).text('Update');
			}
		});
	}
}

function changeCmsPos(evt,catID){
	var pos = $(evt).prev().val();
	if((pos-pos) != 0){
		alert('Invalid position');
		return;
	}else{
		$(evt).hide();
		$(evt).next().show();
		$.ajax({
			type:'post',
			url:baseURL+'admin/cms/changePosition',
			data:{'catID':catID,'pos':pos},
			complete:function(){
				$(evt).next().hide();
				$(evt).show().text('Done').delay(800).text('Update');
			}
		});
	}
}

function approveCmt(evt){
	if($(evt).hasClass('approving'))return;
	$(evt).addClass('approving');
	$(evt).text('Approving...');
	var cfm = window.confirm('Are you sure to approve this comment ?\n This action cannot be undone.');
	if(cfm){
		var cid = $(evt).data('cid');
		var tid = $(evt).data('tid');
		var uid = $(evt).data('uid');
		$.ajax({
			type:'post',
			url:baseURL+'site/product/approve_comment',
			data:{'cid':cid,'tid':tid,'uid':uid},
			dataType:'json',
			success:function(json){
				if(json.status_code == '1'){
					$(evt).parent().remove();
				}else{
					$(evt).removeClass('approving');
					$(evt).text('Approve');
				}
			}
		});
	}else{
		$(evt).removeClass('approving');
		$(evt).text('Approve');
	}
}

function approveStoryCmt(evt){
	if($(evt).hasClass('approving'))return;
	$(evt).addClass('approving');
	$(evt).text('Approving...');
	var cfm = window.confirm('Are you sure to approve this comment ?\n This action cannot be undone.');
	if(cfm){
		var cid = $(evt).data('cid');
		var tid = $(evt).data('tid');
		var uid = $(evt).data('uid');
		$.ajax({
			type:'post',
			url:baseURL+'site/product/approve_story_comment',
			data:{'cid':cid,'tid':tid,'uid':uid},
			dataType:'json',
			success:function(json){
				if(json.status_code == '1'){
					$(evt).parent().remove();
				}else{
					$(evt).removeClass('approving');
					$(evt).text('Approve');
				}
			}
		});
	}else{
		$(evt).removeClass('approving');
		$(evt).text('Approve');
	}
}

function deleteCmt(evt){
	if($(evt).hasClass('deleting'))return;
	$(evt).addClass('deleting');
	$(evt).text('Deleting...');
	var cfm = window.confirm('Are you sure to delete this comment ?\n This action cannot be undone.');
	if(cfm){
		var cid = $(evt).data('cid');
		$.ajax({
			type:'post',
			url:baseURL+'site/product/delete_comment',
			data:{'cid':cid},
			dataType:'json',
			success:function(json){
				if(json.status_code == '1'){
					$(evt).parent().parent().remove();
				}else{
					$(evt).removeClass('deleting');
					$(evt).text('Delete');
				}
			}
		});
	}else{
		$(evt).removeClass('deleting');
		$(evt).text('Delete');
	}
}

function editCmt(evt){
	if($(evt).hasClass('editing'))return;
	$(evt).addClass('editing');
	$(evt).text('Editing...');
	var cid = $(evt).data('cid');
	$.ajax({
		type:'post',
		url:baseURL+'site/product/edit_comment_load',
		data:{'cid':cid},
		dataType:'json',
		success:function(json){
			if(json.status_code == '1'){
				if(json.comment_details){
					$('#edit_cmt_cnt').val(json.comment_details.comments);
					$('#comment_id').val(json.comment_details.id);
					$('#comment_type').val('product');
					$(evt).colorbox({width:"320px",inline:true,href:"#edit_comment_con"}).trigger('click');
				}
			}else{
				if(json.msg){
					alert(json.msg);
				}else{
					alert('Something went wrong');
				}
			}
		},
		complete:function(){
			$(evt).removeClass('editing');
			$(evt).text('Edit');
		}
	});
}

function editStoryCmt(evt){
	if($(evt).hasClass('editing'))return;
	$(evt).addClass('editing');
	$(evt).text('Editing...');
	var cid = $(evt).data('cid');
	$.ajax({
		type:'post',
		url:baseURL+'site/product/edit_story_comment_load',
		data:{'cid':cid},
		dataType:'json',
		success:function(json){
			if(json.status_code == '1'){
				if(json.comment_details){
					$('#edit_cmt_cnt').val(json.comment_details.comments);
					$('#comment_id').val(json.comment_details.id);
					$('#comment_type').val('story');
					$(evt).colorbox({width:"320px",inline:true,href:"#edit_comment_con"}).trigger('click');
				}
			}else{
				if(json.msg){
					alert(json.msg);
				}else{
					alert('Something went wrong');
				}
			}
		},
		complete:function(){
			$(evt).removeClass('editing');
			$(evt).text('Edit');
		}
	});
}

function update_comment(evt){
	if($(evt).hasClass('updating'))return;
	$(evt).addClass('updating');
	$(evt).val('Updating...');
	var cmt = $(evt).parent().find('#edit_cmt_cnt').val();
	var cid = $(evt).parent().find('#comment_id').val();
	var ctype = $(evt).parent().find('#comment_type').val();
	if(cmt==''){
		alert('Your comment is empty');
		$(evt).removeClass('updating');
		$(evt).val('Submit');
	}else{
		$.ajax({
			type: 'post',
			url: baseURL+'site/product/update_comment',
			data: {'cmt':cmt,'cid':cid,'ctype':ctype},
			dataType: 'json',
			success: function(json){
				if(json.status_code == 1){
					$('.cmt_cnt_'+cid).text(cmt);
					$('#cboxClose').trigger('click');
				}else{
					if(json.msg){
						alert(json.msg);
					}else{
						alert('Something went wrong');
					}
				}
			},
			complete: function(){
				$(evt).removeClass('updating');
				$(evt).val('Submit');
			}
		});
	}
	return false;
}

function deleteStoriesCmt(evt){
	if($(evt).hasClass('deleting'))return;
	$(evt).addClass('deleting');
	$(evt).text('Deleting...');
	var cfm = window.confirm('Are you sure to delete this comment ?\n This action cannot be undone.');
	if(cfm){
		var cid = $(evt).data('cid');
		$.ajax({
			type:'post',
			url:baseURL+'site/stories/delete_comment',
			data:{'cid':cid},
			dataType:'json',
			success:function(json){
				if(json.status_code == '1'){
					$(evt).parent().parent().remove();
				}else{
					$(evt).removeClass('deleting');
					$(evt).text('Delete');
				}
			}
		});
	}else{
		$(evt).removeClass('deleting');
		$(evt).text('Delete');
	}
}

function post_order_comment(pid,utype,uid,dealcode){
	if($('.order_comment_'+pid).hasClass('posting'))return;
	$('.order_comment_'+pid).addClass('posting');
	var $form = $('.order_comment_'+pid).parent();
	if(uid==''){
		alert('Login required');
		$('.order_comment_'+pid).removeClass('posting');
	}else{
		if($('.order_comment_'+pid).val() == ''){
			alert('Your comment is empty');
			$('.order_comment_'+pid).removeClass('posting');
		}else{
			$form.find('img').show();
			$form.find('input').hide();
			$.ajax({
				type:'post',
				url:baseURL+'site/user/post_order_comment',
				data:{'product_id':pid,'comment_from':utype,'commentor_id':uid,'deal_code':dealcode,'comment':$('.order_comment_'+pid).val()},
				complete:function(){
					$form.find('img').hide();
					$form.find('input').show();
					window.location.reload();
				}
			});
		}
	}
}

function post_order_comment_admin(pid,dealcode){
	if($('.order_comment_'+pid).hasClass('posting'))return;
	$('.order_comment_'+pid).addClass('posting');
	var $form = $('.order_comment_'+pid).parent();
	if($('.order_comment_'+pid).val() == ''){
		alert('Your comment is empty');
		$('.order_comment_'+pid).removeClass('posting');
	}else{
		$form.find('img').show();
		$form.find('input').hide();
		$.ajax({
			type:'post',
			url:baseURL+'admin/order/post_order_comment',
			data:{'product_id':pid,'comment_from':'admin','commentor_id':'1','deal_code':dealcode,'comment':$('.order_comment_'+pid).val()},
			complete:function(){
				$form.find('img').hide();
				$form.find('input').show();
				window.location.reload();
			}
		});
	}
}

function changeReceivedStatus(evt,rid){
	$(evt).hide();
	$(evt).next().show();
	$.ajax({
		type:'post',
		url:baseURL+'site/user/change_received_status',
		data:{'rid':rid,'status':$(evt).val()},
		complete:function(){
			$(evt).show();
			$(evt).next().hide();
		}
	});
}

function update_refund(evt,uid){
	if($(evt).hasClass('updating'))return;
	$(evt).addClass('updating').text('Updating..');
	var amt = $(evt).prev().val();
	if(amt == '' || (amt-amt != 0)){
		alert('Enter valid amount');
		$(evt).removeClass('updating').text('Update');
		return false;
	}else{
		$.ajax({
			type:'post',
			url:baseURL+'admin/seller/update_refund',
			data:{'amt':amt,'uid':uid},
			complete:function(){
				window.location.reload();
			}
		});
	}
}

function load_onboard_stores(){
	$.ajax({
		type:'post',
		url:baseURL+'site/landing/load_onboard_stores',
		dataType:'html',
		success:function(data){
			$('#inline_example8 .popup_mobile_detail').html(data);
		}
	});
	$(".prod_cat_select").removeAttr('onclick');
	$('.example13').trigger('click');
	return false;
}

function onboard_store_follow(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var count = $('.onboard_peoples_next').data('fcount'),
		cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/add_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn').addClass('following_btn').text('Following');
					if(count == 0){
						$('.store_follow_check1').attr('checked','checked');
					}else if(count == 1){
						$('.store_follow_check2').attr('checked','checked');
					}else if(count == 2){
						$('.store_follow_check3').attr('checked','checked');
						$('.onboard_peoples_next').show();
					}
					count++;
					$('.onboard_peoples_next').data('fcount',count);
				}
			}
		});
	}
}


function load_onboard_peoples(){
	$.ajax({
		type:'post',
		url:baseURL+'site/landing/load_onboard_peoples',
		dataType:'html',
		success:function(data){
			$('#inline_example9 .popup_mobile_detail').html(data);
		}
	});
	$(".onboard_peoples_next").removeAttr('onclick');
	$('.example14').trigger('click');
	return false;
}

function onboard_user_follow(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var count = $('.onboard_final').data('fcount'),
		cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/add_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn').addClass('following_btn').text('Following');
					if(count == 0){
						$('.user_follow_check1').attr('checked','checked');
					}else if(count == 1){
						$('.user_follow_check2').attr('checked','checked');
					}else if(count == 2){
						$('.user_follow_check3').attr('checked','checked');
						$('.onboard_final').show();
					}
					count++;
					$('.onboard_final').data('fcount',count);
				}
			}
		});
	}
}
function UserDetailsDelete(aid,defval){


			if(defval=='1') return alert('You cannot remove your default address.');
			if(!confirm('Do you really want to remove this shipping address?')) return;
			$.ajax({
				type : 'post',
				url  : baseURL+'site/user_settings/remove_shipping_addr',
				data : {id:aid},
				dataType : 'json',
				success  : function(json){
					if(json.status_code === 1){
						$('#address'+aid).hide();
						// $row.fadeOut('fast', function(){$row.remove()});
						
					} else if (json.status_code === 0){
						if(json.message) alert(json.message);
					}
				}
			});
}

function EditShippingAddress(shipval){
// alert(shipval);
/*
 * var partsOfStr = shipval.split(','); alert(partsOfStr[2]);
 */
			

			
			$.ajax({
				type:'POST',
				url:baseURL+'site/user_settings/get_shipping',
				data:{'shipID':shipval},
				dataType:'json',
				success:function(response){
					
					if(response.primary == 'Yes'){
						
						$('.make_this_primary_addr').attr('checked','checked');
					}
					$('.full_name').val(response.full_name);
					$('.nick_name').val(response.nick_name);
					$('.address1').val(response.address1);
					$('.address2').val(response.address2);
					$('.city').val(response.city);
					$('.state').val(response.state);
					$('.country').val(response.country);
					$('.postal_code').val(response.postal_code);
					$('.phone').val(response.phone);
					$('.ship_id').val(shipval);
				}
			});
			$(".edit_addr").colorbox({width:"600px", inline:true, href:"#editshippingaddress"});
// dlg_address1.$obj.trigger('reset').data('address_id',$row.attr('aid')).find('.ltit').text(gettext('Edit
// Shipping Address')).end().find('.ltxt dt').html(gettext('<b>Edit your current
// shipping address</b><small>Fancy ships worldwide with global delivery
// services.</small>'));
			/*
			 * dlg_address1.open(shipval);
			 * 
			 * setTimeout(function(){dlg_address1.$obj.find(':text:first').focus()},10);
			 *  // set current values var $form =
			 * dlg_address1.$obj.find('form'), fields =
			 * 'nickname,fullname,address1,address2,city,country,state,phone,zip'.split(','),i,c;
			 * for(i=0,c=fields.length; i < c; i++){
			 * if($row.attr('a'+fields[i])) {
			 * $form.find('[name="'+fields[i]+'"]').val($row.attr('a'+fields[i]));
			 * if(fields[i] == 'country')
			 * $form.find('[name="country"]').trigger('change'); } }
			 * if($row.attr('aisdefault') === 'true')
			 * $form.find('input:checkbox[name="set_default"]').prop('checked',true);
			 */
			
}

/******************** JAN 2015 FOLLOW BRAND NEW CODE ******************/
function follow_brand(evt){
    
    if($(evt).hasClass('loading'))return;
    $(evt).addClass('loading').text(lg_wait);
    var cid = $(evt).data('uid');
    if($(evt).hasClass('follow_btn')){
        $.ajax({
            type : 'post',
            url  : baseURL+'site/brand/add_follow',
            data : {brand_id : cid},
            dataType : 'json',
            success : function(response){
                if(response.status_code == 1){
                    $(evt).removeClass('follow_btn').addClass('following_btn').text(lg_following);
                }
            }
        });
    }else if($(evt).hasClass('following_btn')){
        $.ajax({
            type : 'post',
            url  : baseURL+'site/brand/delete_follow',
            data : {brand_id : cid},
            dataType : 'json',
            success : function(response){
                if(response.status_code == 1){
                    $(evt).removeClass('following_btn').addClass('follow_btn').text(lg_follow);
                }
            }
        });
    }
    $(evt).removeClass('loading');
}
/******************** JAN 2015 FOLLOW BRAND NEW CODE ******************/


function follow_store(evt){
	
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text(lg_wait);
	var cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/store/add_follow',
			data : {store_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn').addClass('following_btn').text(lg_following);
				}
			}
		});
	}else if($(evt).hasClass('following_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/store/delete_follow',
			data : {store_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('following_btn').addClass('follow_btn').text(lg_follow);
				}
			}
		});
	}
	$(evt).removeClass('loading');
}
function follow_store1(evt){
	
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text(lg_wait);
	var cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn2')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/store/add_follow',
			data : {store_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn2').addClass('following_btn2').text(lg_following);
				}
			}
		});
	}else if($(evt).hasClass('following_btn2')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/store/delete_follow',
			data : {store_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('following_btn2').addClass('follow_btn2').text(lg_follow);
				}
			}
		});
	}
	$(evt).removeClass('loading');
}
function store_follow(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/add_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn').addClass('following_btn').text('Following');
				}
			}
		});
	}else if($(evt).hasClass('following_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/delete_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('following_btn').addClass('follow_btn').text('Follow');
				}
			}
		});
	}
	$(evt).removeClass('loading');
}


function tag_follow(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var tid = $(evt).data('tid');
	if($(evt).hasClass('tag_follow_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/tags/tag_follow',
			data : {tid : tid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('tag_follow_btn').addClass('tag_following_btn').text('Following');
				}
			}
		});
	}else if($(evt).hasClass('tag_following_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/tags/tag_unfollow',
			data : {tid : tid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('tag_following_btn').addClass('tag_follow_btn').text('Follow');
				}
			}
		});
	}
	$(evt).removeClass('loading');
	return false;
}

function store_follow1(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn1')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/add_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn1').addClass('following_btn1').text('Following');
				}
			}
		});
	}else if($(evt).hasClass('following_btn1')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/delete_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('following_btn1').addClass('follow_btn1').text('Follow');
				}
			}
		});
	}
	$(evt).removeClass('loading');
}

function store_follow2(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn2')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/add_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn2').addClass('following_btn2').text('Following');
				}
			}
		});
	}else if($(evt).hasClass('following_btn2')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/delete_follow',
			data : {user_id : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('following_btn2').addClass('follow_btn2').text('Follow');
				}
			}
		});
	}
	$(evt).removeClass('loading');
}

function list_follow(evt){
	if($(evt).hasClass('loading'))return;
	$(evt).addClass('loading').text('Wait...');
	var cid = $(evt).data('uid');
	if($(evt).hasClass('follow_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/follow_list',
			data : {lid : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('follow_btn').addClass('following_btn').text('Following');
				}
			}
		});
	}else if($(evt).hasClass('following_btn')){
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/unfollow_list',
			data : {lid : cid},
			dataType : 'json',
			success : function(response){
				if(response.status_code == 1){
					$(evt).removeClass('following_btn').addClass('follow_btn').text('Follow');
				}
			}
		});
	}
	$(evt).removeClass('loading');
}

function sell_click(event){
	var $this = $(event), ntid = $this.attr('ntid');

	location.href='sales/create?ntid='+ ntid;
}

function IsEmail(email) {
	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	return regex.test(email);
}

function ContactSeller(){

	$('#div_question').html('');
	$('#div_name').html('');
	$('#div_emailaddress').html('');	
	$('#div_phoneNumber').html('');

var question = $('.contact_frm #question').val();
var name = $('.contact_frm #name.fullname').val();
var email = $('.contact_frm #emailaddress').val();
var phone = $('.contact_frm #phoneNumber').val();
var selleremail = $('.contact_frm #selleremail').val();
var sellerid = $('.contact_frm #sellerid').val();	
var product_id = $('.contact_frm #productId').val();

if(question ==''){
	$('#div_question').html('This field is required');
	return false;
}else if(name ==''){
	$('#div_name').html('This field is required');
	return false;		
}else if(email ==''){
	$('#div_emailaddress').html('This field is required');
	return false;		
}else if( !IsEmail(email)) { 
	$('#div_emailaddress').html('Please Enter Valid Email Address');		
	return false;
/*
 * }else if(phone ==''){ $('#div_phoneNumber').html('This field is required');
 * return false;
 */		
}else{
	$('#div_question').html('');
	$('#div_name').html('');
	$('#div_emailaddress').html('');	
	$('#div_phoneNumber').html('');

	$('#loadingImgContact').show();
	
	
	$.ajax({
	type: 'POST',   
	 url: baseURL+'site/product/contactform',
	data:{"question":question,"name": name,"email":email,"phone":phone,"selleremail":selleremail,"sellerid":sellerid,"product_id":product_id},
		success:function(response){
			// alert(response);
			if(response == 'Success'){
				$('#loadingImgContact').hide();
				location.reload();	
			}
		}
	});
	
}
}

/*function product_report(){
	
var name = $('.contact_frm #name').val();	
//alert(name);
var sellerid = $('.contact_frm #sellerid').val();
//alert(sellerid);	
var product_id = $('.contact_frm #productid').val();
//alert(product_id);
	
$.ajax({
	type: 'POST',   
	url: baseURL+'site/product/product_report',
	data:{"name": name,"sellerid":sellerid,"product_id":product_id},
		success:function(response){
			// alert(response);
			if(response == 'Success'){
				$('#loadingImgContact').hide();
				location.reload();	
			}
		}
	});
}*/

function product_report(){
		
//var name = $('.contact_frm #name').val();	

if($('.contact_frm #name1').val()!='')
{
	var name = $('.contact_frm #name1').val();	
} else if($('.contact_frm #name2').val()!=''){ 
	var name = $('.contact_frm #name2').val();	
} else { 
	var name = $('.contact_frm #name3').val();	
}

var val = $('input:radio[name=name]:checked').val();
//alert(val);
//var name = $('.contact_frm #name').val();
var sellerid = $('.contact_frm #sellerid').val();
var product_id = $('.contact_frm #productid').val();

if(($("#name1:checked").length == 0) && ($("#name2:checked").length == 0) && ($("#name3:checked").length == 0)) {

//if ($("#name:checked").length == 0){
//$('#div_name').slideDown().html('<span id="error">Please choose your report</span>');
alert("Please choose your report");
return false;
}
else {	
//$('#loadingImgContact').show();
$.ajax({
	type: 'POST',   
	url: baseURL+'site/product/product_report',
	data:{"name": val,"sellerid":sellerid,"product_id":product_id},
		success:function(response){
			//alert(response);
			if(response == 'Success'){
				$('#loadingImgContact').hide();
				location.reload();	
			}
		}
	});
}
}

function delete_story(evt) {
	if($(evt).hasClass('deleting')) return;
	$(evt).addClass('deleting').text(lg_deleting);
	var sid = $(evt).data('sid');
	var is_cfm = confirm(lg_r_u_sure);
	if(is_cfm){
		$.ajax({
			type: 'post',
			url: baseURL+'site/stories/delete_story',
			data:{'sid':sid},
			dataType:'json',
			success: function(json){
				if(json && json.status_code && json.status_code==1){
					$('.story_con_'+sid).remove();
				}else {
					if(json && json.msg){
						alert(json.msg);
					}else {
						alert(lg_som_went_wrong);
					}
				}
			},
			complete: function(){
				$(evt).removeClass('deleting').text(lg_delete);
			}
		});
	}else {
		$(evt).removeClass('deleting').text(lg_delete);
	}
	return false;
}

function del_save(pid,evt){
	if($(evt).hasClass('deleting')) return false;
	$(evt).addClass('deleting');
	if(confirm('Are you sure?')){
		$.ajax({
			type:'post',
			url:baseURL+'site/user/del_save',
			data:{'pid':pid},
			dataType:'json',
			success:function(json){
				if(json.status_code == 1){
					$('.prod_con_'+pid).remove();
				}else{
					alert(json.msg);
				}
			},
			complete:function(){
				$(evt).removeClass('deleting');
			}
		});
	}else{
		$(evt).removeClass('deleting');
	}
}
function ajaxEditproductAttribute(attId,attname,attprice,pid){
	
	//alert(attname+''+attval+''+attId);
	
	$('#loadingImg_'+attId).html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>');
	
	$.ajax({
		type: 'POST',   
		url:baseURL+'admin/product/ajaxProductAttributeUpdate',
		data:{'attId':attId,'attname':attname,'attprice':attprice,'pid':pid},
		success:function(response){
			//alert(response);
			$('#loadingImg_'+attId).html('');
		}
	});
	
}
function ajaxChangeproductAttribute(attId,attname,attprice,pid){
	
	$('#loadingImg_'+attId).html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>');
	
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/product/ajaxProductAttributeUpdate',
		data:{'attId':attId,'attname':attname,'attprice':attprice,'pid':pid},
		success:function(response){
			//alert(response);
			$('#loadingImg_'+attId).html('');
		}
	});
	
}

function ajaxCartAttributeChange(attId,prdId){
	
	$('#loadingImg_'+prdId).html('<span class="loading"><img src="images/indicator.gif" alt="Loading..."></span>');
	$('#AttrErr').html('');
	$.ajax({
		type: 'POST',   
		url:baseURL+'site/product/ajaxProductDetailAttributeUpdate',
		data:{'prdId':prdId,'attId':attId},
		success:function(response){
			//alert(response);
			var arr = response.split('|');
			
			$('#attribute_values').val(arr[0]);
			$('#price').val(arr[1]);
			$('#SalePrice').html(lg_currency_symbol+arr[1]);
			$('#loadingImg_'+prdId).html('');
		}
	});
	
}

function after_ajax_load(){
	$('.boxgrid.captionfull').hover(function(){
		$(".cover", this).stop().animate({top:'0px'},{queue:false,duration:750});
		 $(".cover", this).css({ 'display': 'block' });
	}, function() {
		$(".cover", this).stop().animate({top:'283px'},{queue:false,duration:750});
	});
	$('.save').unbind("click").bind("click",function(event){
		$('.save_cur').removeClass('save_cur');
		if(!$(this).hasClass('sign_box')){
			var pid = $(this).data('pid');
			if($(this).hasClass('saving'))return;
			$(this).addClass('saving');
			$(this).addClass('save_cur');
			$('#inline_example19 .select-list-inner ul').html('Loading...');
			$('#inline_example19 .select-list-inner ul').attr('tid',pid);
			$('#inline_example19 .save_done').data('pid',pid);
			$.ajax({
				type:'POST',
				url:baseURL+'site/user/add_list_when_fancyy',
				data:{tid:pid},
				dataType:'json',
				success:function(response){
					if(response.status_code == 1){
// $('#inline_example19 .select-list').text(response.firstCatName);
						$('#inline_example19 .select-list-inner ul').html(response.listCnt);
// if(response.wanted == 1){
// $('.btn-want').addClass('wanted').find('b').text('Wanted');
// }
					}
				}
			});
			var save_url = baseURL+'site/user/add_fancy_item';
			$.ajax({
				type:'POST',
				url:save_url,
				data:{tid:pid},
				dataType:'json',
				success:function(response){
						$('#inline_example19 .save_done').data('total_saves',response.likes);
				}
			});
			$(".save").colorbox({inline:true, href:"#inline_example19"});
			$('#colorbox').show();
			$(this).removeClass('saving');
		}
	});
	
	$('#inline_example19 .select-list-inner ul')
	.delegate('input[type=checkbox]', 'change', function(){
		var $li = $(this).closest('li'), params, url;

		params = {
			tid : $('#inline_example19 .select-list-inner ul').attr('tid'),
			list_ids : ''+this.getAttribute('id')
		};
		if(this.checked){
			url = baseURL+'site/user/add_item_to_lists';
			$li.addClass('selected');
		} else {
			url = baseURL+'site/user/remove_item_from_lists';
			$li.removeClass('selected');
		}

		$.ajax({
			type : 'post',
			url  : url,
			data : params,
			dataType : 'json',
			success  : function(response){
				if(response.status_code != 1) return;
			}
		});
	});
	$('#inline_example19 .create_list_sub').click(function(){
		var el, i, c, form = this, params = {};
		if(form.sending) return;
		form.sending = true;
		params.list_name = $(form).prev().val();
		if(!params.list_name){ 
			form.sending = false;
			return;
		}
		if(typeof params.category_id != 'undefined' && params.category_id == '0') delete params.category_id;
		
		params.tid = $('#inline_example19 .select-list-inner ul').attr('tid');
		
		$.ajax({
			type : 'post',
			url  : baseURL+'site/user/create_list',
			data : params,
			dataType : 'json',
			success  : function(response){
				if(response.status_code != 1) {
					alert(response.message);
					return;
				}

				$(form).prev().val('').end();

				var loid, lid = response.list_id,$chk = $('#inline_example19 .select-list-inner ul').find('input#'+lid), $ul, $li;
				if(!$chk.length){
					$ul = $('#inline_example19 .select-list-inner ul');
					$li = $('<li style="#fff6a0" class="selected"><label for="'+lid+'"><input type="checkbox" checked="checked" name="'+lid+'" id="'+lid+'">'+params.list_name+'</label></li>').prependTo($ul).animate({backgroundColor:'#fff'}, 500);
					$ul.animate({scrollTop:0},200);
					$chk = $li.find(':checkbox');
				}else{
					$chk.attr('checked','checked').closest('li').addClass('selected');
				}
					
			},
			complete : function(){
				form.sending = false;
			}
		});
	});
	$('.save_done').unbind('click').bind('click',function(){
		var cmt = $(this).prev().prev().val();
		var total_saves = $(this).data('total_saves');
		if(cmt != ''){
			var product_id = $(this).data('pid');
			var dataString = '&comments=' + cmt + '&cproduct_id=' + product_id;
			$.ajax({
				type: "POST",
				url: baseURL+'site/order/insert_product_comment',
				data: dataString,
				cache: false,
				dataType:'json',
				success: function(json){
					$('.save_done').prev().text('');
				}
			});
		}
		$('.save_cur').find('span').text(total_saves+' saves');
		$("#cboxOverlay,#colorbox").hide();
		$('.save_cur').parent().parent().prev().append('<div class="saved_box" style="position:absolute;text-align: center;top:10px;right:10px;background-color:#D800C7;color:#fff;padding:8px;"><strong style="font-size: 18px;">Saved!</strong><br/>'+total_saves+' saves</div>');
		setTimeout(function(){
			$('.saved_box').remove();
		},3000);
	});

	$(".tag_box").click(function(){
		$('.tag_cur').removeClass('tag_cur');
		var pid = $(this).data('pid');
		$('#inline_example18 .tag_done').data('pid',pid);
		$(this).addClass('tag_cur');
		$('#colorbox').show();
	});
	
	$('.tag_done').unbind('click').bind('click',function(){
		var cmt = $(this).prev().val();
		if(cmt == '')return;
		var product_id = $(this).data('pid');
		var dataString = '&comments=' + cmt + '&cproduct_id=' + product_id;
		$.ajax({
			type: "POST",
			url: baseURL+'site/order/insert_tag_comment',
			data: dataString,
			cache: false,
			dataType:'json',
			success: function(json){
				$('.tag_done').prev().html('');
			}
		});
		$("#cboxOverlay,#colorbox").hide();
		$('.tag_cur').parent().parent().prev().append('<div class="tagged_box" style="position:absolute;text-align: center;top:10px;left:10px;background-color:#D800C7;color:#fff;padding:8px;"><strong style="font-size: 18px;">Tagged!</strong></div>');
		setTimeout(function(){
			$('.tagged_box').remove();
		},3000);
	});
	
	$(".tag_box,.box_post,.example9,.example10,.example16,.example25").click(function(){
		$('.div_email1,.div_email,.div_username,.div_password').text('').hide();
		$('#colorbox').show();
	});
	$(".close_box,.stories-product-selector-done").click(function(){$('#cboxOverlay,#colorbox').hide();});
	
	var boxpostwindowsize = $(window).width();

	$(".cboxClose1").click(function(){
		$("#cboxOverlay,#colorbox").hide();
		});

		
		
		if (boxpostwindowsize > 559) {
			
			$(".box_post").colorbox({width:"460px", inline:true, href:"#inline_example10"});
			$(".example25").colorbox({width:"540px", height:"450px", inline:true, href:"#inline_example20"});
			$(".example15").colorbox({width:"560px", height:"450px", inline:true, href:"#inline_example10"});
			$(".example20").colorbox({width:"560px", inline:true, href:"#inline_example15"});
			$(".example21").colorbox({width:"560px", inline:true, href:"#inline_example16"});
			$(".example22").colorbox({width:"560px", inline:true, href:"#inline_example17"});
			$(".tag_box").colorbox({width:"560px", inline:true, href:"#inline_example18"});
			$(".example23").colorbox({width:"560px", inline:true, href:"#inline_example18"});
// <!--$(".example24").colorbox({width:"560px", height:"450px", inline:true,
// href:"#inline_example19"});-->
// $(".save_box").colorbox({width:"560px", height:"450px", inline:true,
// href:"#inline_example19"});
			$(".example17").colorbox({width:"560px", inline:true, href:"#inline_example12"});
			$(".example18").colorbox({width:"560px", inline:true, href:"#inline_example13"});
			$(".sign_box").colorbox({width:"560px",height:"700px", inline:true, href:"#inline_example4"});
			$(".log_box").colorbox({width:"560px", inline:true, href:"#inline_example5"});
			$(".example19").colorbox({width:"510px", inline:true, href:"#inline_example14"});
		} else {
			$(".box_post").colorbox({width:"320px", inline:true, href:"#inline_example10"});
			$(".example25").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example20"});
			$(".example15").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example10"});
			$(".example20").colorbox({width:"320px", inline:true, href:"#inline_example15"});
			$(".example21").colorbox({width:"320px", inline:true, href:"#inline_example16"});
			$(".example22").colorbox({width:"320px", inline:true, href:"#inline_example17"});
			$(".tag_box").colorbox({width:"320px", inline:true, href:"#inline_example18"});
			$(".example23").colorbox({width:"320px", inline:true, href:"#inline_example18"});
// <!--$(".example24").colorbox({width:"320px", height:"450px", inline:true,
// href:"#inline_example19"});-->
			$(".save_box").colorbox({width:"320px", height:"450px", inline:true, href:"#inline_example19"});
			$(".example17").colorbox({width:"320px", inline:true, href:"#inline_example12"});
			$(".example18").colorbox({width:"320px", inline:true, href:"#inline_example13"});
			$(".sign_box").colorbox({width:"320px",height:"450px", inline:true, href:"#inline_example4"});
			$(".log_box").colorbox({width:"320px", inline:true, href:"#inline_example5"});
			$(".example19").colorbox({width:"320px", inline:true, href:"#inline_example14"});
			
		}
		

		
		
		$(".example16").colorbox({width:"1140px", inline:true, href:"#inline_example11"});
		
		

// <!--$(".example11").colorbox({width:"900px", inline:true,
// href:"#inline_example6"});-->

		

	
	// Example of preserving a JavaScript event for inline calls.
		$("#onLoad").click(function(){ 
			$('#onLoad').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
		$('.example16').click(function(){
			$('#inline_example11 .popup_page').html('<div class="cnt_load"><img src="images/ajax-loader.gif"/></div>');
			var pid = $(this).data('pid');
			var pname = $(this).text();
			var purl = baseURL+$(this).attr('href');
			$.ajax({
				type:'get',
				url:baseURL+'site/product/get_product_popup',
				data:{'pid':pid},
				dataType:'html',
				success:function(data){
					window.history.pushState({"html":data,"pageTitle":pname},"", purl);
					$('#inline_example11 .popup_page').html(data);
				}
			});
		});
}