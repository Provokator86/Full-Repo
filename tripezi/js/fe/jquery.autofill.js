/*
* Auto-Fill Plugin
* Written by Joe Sak 
* Website: http://www.joesak.com/
* Article: http://www.joesak.com/2008/11/19/a-jquery-function-to-auto-fill-input-fields-and-clear-them-on-click/
* GitHub: http://github.com/joemsak/jQuery-AutoFill
*/
(function($){
	$.fn.autofill=function(options){
		var defaults={
			value:'First Name',
			prePopulate:'',
			defaultTextColor:"#666",
			activeTextColor:"#333"};
			
			
			var options=$.extend(defaults,options);
			return this.each(function(){
				var obj=$(this);
				var pfield = (obj.attr('type')=='password');
				var p_obj = false;
				if(pfield){
					obj.hide();
					obj.after('<input type="text" id="'+this.id+'_autofill" class="'+$(this).attr('class')+'" />');
					p_obj = obj;
					obj = obj.next();
				} 
				 if(document.activeElement != obj[0]) {
					 obj.css({color:options.defaultTextColor})
						.val(options.value);					
				 }
				 obj.each(function() {
					 $(this.form).submit(function() {
					   if (obj.val() == options.value) {
						   obj.val(options.prePopulate);
						 }
				   });
				 });
				 obj.focus(function(){
						if(obj.val()==options.value){
							if(pfield) {
								obj.hide();
								p_obj.show()
								.focus()
							}
							obj.val(options.prePopulate)
							.css({color:options.activeTextColor});
						}
					})
					.blur(function(){
						if(obj.val()==options.prePopulate || obj.val() == ''){
							obj.css({color:options.defaultTextColor})
							.val(options.value);
						}
					});
					if(p_obj && p_obj.length > 0){
						p_obj.blur(function(){
							if(p_obj.val()==""){
								p_obj.hide();
								obj.show()
								.css({color:options.defaultTextColor})
								.val(options.value);
							}
						});
					}
				});
			};
		})(jQuery);


$(document).ready(function(){
		$('#inputField01').autofill({value: 'mm/dd/yyyy'});
		$('#inputField02').autofill({value: 'mm/dd/yyyy'});
		$('#search').autofill({value: 'City, State, Country'});
		$('#first-name').autofill({value: 'First name'});
		$('#last-name').autofill({value: 'Last name'});
		$('#email').autofill({value: 'Email'});
		$('#password').autofill({value: '******'});
		$('#capcha').autofill({value: ''});
		$('#enteraddress').autofill({value: 'Enter Your Email Address'});
		$('#search02').autofill({value: 'City, State, Country'});
		$('#search03').autofill({value: 'Search'});
		$('#name02').autofill({value: 'Name'}); 
		$('#comment').autofill({value: 'Comment'}); 
		$('#bathroom').autofill({value: '1'}); 
		$('#guest').autofill({value: '2'}); 
		$('#price').autofill({value: '68'});
		$('#rate').autofill({value: '909'});
		$('#fee').autofill({value: '25'});
		$('#weekly').autofill({value: '239'});
		$('#additional').autofill({value: '18'});
		$('#zipcode').autofill({value: '236598'});
	});