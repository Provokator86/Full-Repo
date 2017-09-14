/* 
 * common general javascript
 */

$(document).ready(function() {
						   
			
jQuery('.search_panel .boxes h3').append('<em class="toggle"></em>');
jQuery('.search_panel .boxes h3').on("click", function(){
if (jQuery(this).find('em').attr('class') == 'toggle opened') { jQuery(this).find('em').removeClass('opened').parents('.search_panel .boxes').find('.boxes_content, .category_content').slideToggle(); }
else {
jQuery(this).find('em').addClass('opened').parents('.search_panel .boxes').find('.boxes_content, .category_content').slideToggle();
}
});



jQuery('.account_panel .boxes h3').append('<em class="toggle"></em>');
jQuery('.account_panel .boxes h3').on("click", function(){
if (jQuery(this).find('em').attr('class') == 'toggle opened') { jQuery(this).find('em').removeClass('opened').parents('.account_panel .boxes').find('.boxes_content').slideToggle(); }
else {
jQuery(this).find('em').addClass('opened').parents('.account_panel .boxes').find('.boxes_content').slideToggle();
}
});
		   
	
	/*------------for top login--------------*/
	$(".topnav").accordion({
		accordion:false,
		speed: 500,
		closedSign: '',
		openedSign: ''
	});
	
	/*******  for drop down  ******/
	 $("#fev_select").msDropDown();//(engineSize)=select tab ID;
	 //$("#fev_select").hide();
	 $('#fev_select_msdd').css("width", "181px");
	 $('#fev_select_child').css("width", "484px");
	 $('#fev_select_child').css("top", "0px");
	 $('#fev_select_titletext span:first-child').html('Select Location');


	/*******  for nav sub menu  ******/
  $("div.categories_button").mouseenter(function(){
  	  $("#categorylist").show();   
      $("#categories").addClass('select_cat'); 
	  $('#manu_bg_trans').fadeIn();
	  
    }).mouseleave(function(){
       $("#categorylist").hide('fast');    
      $("#categories").removeClass('select_cat');
	  $('#manu_bg_trans').fadeOut();   
    });
	$("div.categories_button2").mouseenter(function(){
      $("#categorylist2").show();   
      $("#categories2").addClass('select_cat');
	   $('#manu_bg_trans').fadeIn(); 
	  
    }).mouseleave(function(){
          
	  $("#categorylist2").hide('fast');    
      $("#categories2").removeClass('select_cat');  
	  $('#manu_bg_trans').fadeOut();    
    });


/*******  for bx slider  ******/
$("#bx-pager").bxSlider({
		    slideWidth: 180,
		    minSlides: 3,
		    maxSlides: 4,
		    moveSlides: 3,
		    slideMargin: 10,
			pager: false
  		});
		
$(".tabslider-pager").bxSlider({
		    slideWidth: 137,
		    minSlides: 4,
		    maxSlides: 4,
		    moveSlides: 4,
		    slideMargin: 10,
			pager: false
});
		
$("#most_poplar").bxSlider({
		    slideWidth: 200,
		    minSlides: 1,
		    maxSlides: 1,
		    moveSlides: 1,
		    slideMargin: 10,
			pager: false
  		});
                
/***bx slider**/
                
/*------------all_cat_collaps_expand--------------*/
		
		$('.form-item_group a').click(function(){
			$('.form-item_group a').removeClass('select');
			$('.fil_sub_cat').slideUp();
			if($(this).next('.fil_sub_cat').hasClass("selected")){
				$(this).next('.fil_sub_cat').slideUp().removeClass("selected");
				$(this).removeClass("select");
			}
			else
			{
				$(this).next('.fil_sub_cat').slideDown().addClass("selected");
				$(this).addClass("select");
			}	
		});
		
		
		var selectedIndex	=	-1 ;
		
		$(".cat_box").click(function(){
			$('.filter_categories').slideUp();
			var tabIndex	=	$(this).attr('index');
			
			if(tabIndex==selectedIndex)
			{
				selectedIndex	=	-1 ;
				return;
			}
			else
			{
				selectedIndex	=	tabIndex ;
				$('.filter_categories').filter(':eq('+tabIndex+')').slideDown();
			}		
		});
		
		
		$('.close_btn').click(function(){
			selectedIndex	=	-1 ;
			$(this).parent().slideUp();
		});
		
		
		/* For all Check box */
		/*$(".chk_all").click(function(){
			var ckeckedStatus	=	$(this).is(':checked');
			
			var parentObj	=	$(this).parent().parent().parent() ;
			
			$(parentObj).find("input[type=checkbox]").each(function(i,obj){
				
				if(ckeckedStatus){
					$(obj).prop('checked','checked');
				}
				else{
					$(obj).prop('checked','');
				}
			});
			
		
		});*/
		
		$(".chk_all").click(function(){
									 
			$(".chk_all").prop('checked','checked');	
			
			$('input[type="checkbox"]:not(.chk_all)').prop('checked','');
			
			$('#store_checked_list ul').html('');
            $('#store_checked_list ul').append('<li>'+'All Store'+'</li>');
			
			$('#category_checked_list ul').html('');
            $('#category_checked_list ul').append('<li>'+'All Store'+'</li>');
									 
		});
		
		
  
  
  /*******  for fancy box  ******/
	$('.fancybox').fancybox({
		//autoDimensions: true,
		height: 100,
		width: 650,
		padding:15
	});
        
	/*******  for tab  ******/
	$(".tab_content").hide();
	$(".tab_content:first").show(); 

	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active");
		$(this).addClass("active");
		$(".tab_content").hide();
		var activeTab = $(this).attr("rel"); 
		$("#"+activeTab).fadeIn(); 
	});
	
       $("#tabsholder").tytabs({
                            tabinit:"2",
                            fadespeed:"fast"
                            });
                            
	$("#tabsholder2").tytabs({
                                prefixtabs:"tabz",
                                prefixcontent:"contentz",
                                classcontent:"tabscontent",
                                tabinit:"3",
                                catchget:"tab2",
                                fadespeed:"normal"
                                });
/*--
	jQuery('#mycarousel2').jcarousel();-*/
   <!--$("#price_slider").slider({ from: 0, to:30000, step: 5000, dimension: '', scale: ['0', '5000','10000', '15000','20000','25000','30000+'], limits: false , skin:'round'});-->
   
   $('.back_to_top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
});

function show_rate()
{
	$('#modal').show();
}

function hide_modal()
{
	$('#modal').hide();
}

/**
 *@name validate_form
 *@description  all in one from validation
 * user can use it by putting attribute from-validation="required|email|.."
 *@param object targetForm target form
 *@param object settings callbacks
 *@ the callbacks are
 *@ function beforeValidation 
 *@ function onValidationSuccess 
 *@ function onValidationError 
 *@type bool true|false on full validated or error
 *
 */
 function validate_form(targetForm,settings){
	 
        formInputs =  $(targetForm).find('input,textarea,hidden');
        passWords  = {};
        var isValid = true;
        $(formInputs).each(function(){
            beforeValidation($(this));
            fromvalidation = '';
            fromvalidation =   $(this).attr('from-validation');
            if(typeof fromvalidation != "undefined") {
                validationArray = fromvalidation.split('|');
				
                //console.log($.inArray('required', validationArray));
                if($.inArray('required', validationArray)!=-1){
                    if(!required_validation($(this))){
                        onValidationError($(this));
                        isValid = false; 
                    }
                }

               if($.inArray('password', validationArray)!=-1){
				   
					   if($.inArray('confirm', validationArray)!=-1){
							passWords[1] = $(this);
						   if(!confirm_password_validation(passWords)){
								onValidationError($(this));
								isValid = false;
							}
						} else {
							 passWords[0] = $(this);
						}
                   
               }
               if($.inArray('email', validationArray)!=-1){
                    if(!email_validation($(this))){
                        onValidationError($(this));
                        isValid = false;
                    }
               }
			   
			   /*if($.inArray('url', validationArray)!=-1){
				        if(!validateURL($(this))){
                        onValidationError($(this));
                        isValid = false;
                    }
               }*/
			   
			   if($.inArray('less_price', validationArray)!=-1){
                    if(!decimal_validation($(this))){
                        onValidationError($(this));
                        isValid = false;
                    }
               }
               
               if($.inArray('captcha', validationArray)!=-1){
                    if(!captcha_validation($(this))){
                        onValidationError($(this));
                        isValid = false;
                    }
               }
               
               if($.inArray('duplicate', validationArray)!=-1){
                    if(!duplicate_validation($(this))){
                        onValidationError($(this));
                        isValid = false;
                    }
               }
			   
			   if($.inArray('alphanu', validationArray)!=-1){
				   
                    if(!passwordValidation($(this))){
						
                        onValidationError($(this));
                        isValid = false;
                    }
               }
            }
        });
		
		/* PASSWORD VALIDATION */
		function passwordValidation(targetObject)
		{
			var pass = $.trim($(targetObject).val());
			
			if(pass.length <6 || pass.length >20) return false;
			//if(/[0-9]{1,}/.test(pass) == false)  return false;
			//if(/[a-zA-Z]{1,}/.test(pass) == false)  return false;
			//if(/[!@#$*]{1,}/.test(pass) == false)  return false;			
			return true;
		}
		
		
        /**
         *CONFIRM PASSWORD FIELD VALIDATION
         **/
        function confirm_password_validation(targetObjects){
            //console.log(targetObjects);
            if( $(targetObjects[0]).val()==$(targetObjects[1]).val() ){
                return true;
            } else {
                return false;
            }
        }
        /**
         *REQUIRED FIELD VALIDATION
         **/
        function required_validation(targetObject){
			
            if($.trim($(targetObject).val())==''){
                return false;
            } else {
                return true;
            }
        }
        
        /**
         *Captcha VALIDATION
         **/
        function captcha_validation(targetObject){
            if($.trim($(targetObject).val())==''){
                return false;
            } else {
                if(typeof settings.captchaValidator =='function'){
                    return settings.captchaValidator(targetObject);
                }
                return false;
            }
        }
         /**
         *Duplicate VALIDATION
         **/
        function duplicate_validation(targetObject){
            if($.trim($(targetObject).val())==''){
                return false;
            } else {
                if(typeof settings.duplicateValidator =='function'){
                    return settings.duplicateValidator(targetObject);
                }
                return false;
            }
        }
        /**
         *EMAIL VALIDATION
         **/
        function email_validation(targetObject){
             //var emailRegex = new RegExp(/^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i);
			 var emailRegex = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
             if(emailRegex.test($.trim($(targetObject).val()))){
                 return true;
             } else {
                 return false;
             }
        }
		
		/**
         *DECIMAL VALIDATION
         **/
        function decimal_validation(targetObject){
             var decRegex = new RegExp(/^(\d*\.?\d*)$/i);
             if(decRegex.test($.trim($(targetObject).val()))){
                 return true;
             } else {
                 return false;
             }
        }
		
		/*function validateURL(targetObject) {
			  var urlregex = new RegExp(/^(http)(s?)\:\/\/((www\.)+[a-zA-Z0-9\-\.\?\,\'\/\\\+&amp;=:%\$#_]*)?/);
			  if(urlregex.test($.trim($(targetObject).val()))){
                 return true;
             } else {
                 return false;
             }
		}*/
		
		
		
           /**a default AFTER VALIDATION ERROR function **/
        function onValidationError(targetObject){
            if(typeof settings.onValidationError =='function'){
               settings.onValidationError(targetObject);
            }
        }
        /**a default PREVALIDATE function **/
        function beforeValidation(targetObject){
           if(typeof settings.beforeValidation =='function'){
                settings.beforeValidation(targetObject);
            }
        }
        
        if(isValid){
            function onValidationSuccess(){
                if(typeof settings.onValidationSuccess =='function'){
                    settings.onValidationSuccess();
                }
            }
        }
        
        return isValid;
}
wrapperCover = function(){

}


// ============================================

var dialog_loading = null;

//// function to show/hide busy-screen [Start]
function showBusyScreen()
{
	if(!dialog_loading) dialog_loading = null;
	dialog_loading = new ModalDialog ("#loading_dialog");
	
	dialog_loading.show(5000);
}

function hideBusyScreen()
{
	//if(dialog_loading) dialog_loading.hide();
	setTimeout(function() {
		if(dialog_loading) dialog_loading.hide();
	  }, 1000);
}
//// function to show/hide busy-screen [End]

