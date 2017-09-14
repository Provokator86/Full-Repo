// JavaScript Document

fastAnimation = 250,
easingMethod = 'easeOutQuint',

$(document).ready(function(){
		
	// Home page sliding Effect
	$('.article-square').hover(function() {
			$(this).children('.cover').stop().animate({ width: '126px' }, fastAnimation, easingMethod);
			if ($(this).css('text-align') == 'left') {
				$(this).children('img').stop().animate({ left: '30px' }, fastAnimation, easingMethod);
			} else {
				$(this).children('img').stop().animate({ left: '-30px' }, fastAnimation, easingMethod);
			}
		}, function() {
			$(this).children('.cover').stop().animate({ width: '110px' }, fastAnimation, easingMethod);
			if ($(this).css('text-align') == 'left') {
				$(this).children('img').stop().animate({ left: '0px' }, fastAnimation, easingMethod);
			} else {
				$(this).children('img').stop().animate({ left: '0' }, fastAnimation, easingMethod);
			}
	});
	
		
	var count=$("#mid-panel .article-square").length;
	
	if($(window).width()>1024){
	for(i=0;i<count;i+=5){
	
	$("#mid-panel .article-square").slice(i,i+5).wrapAll("<div class='row'></div>");
	}
	
	$(".row").each(function(){
		$(this).append("<div class='clear'/>");
	});
	}
	
	else if($(window).width() >950 && $(window).width() <1000){
	for(i=0;i<count;i+=4){
	
	$("#mid-panel .article-square").slice(i,i+4).wrapAll("<div class='row'></div>");
	}
	
	$(".row").each(function(){
		$(this).append("<div class='clear'/>");
		
	});
	}
	
	else if($(window).width() <=800){
	 
		$("#owl-demo").attr("class","owl-carousel");
	 
		$("#owl-demo").owlCarousel({
		navigation:true,
		pagination:false,
		items : 10, //10 items above 1000px browser width
		itemsDesktop : [1000,5], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,3], // betweem 900px and 601px
		itemsTablet: [767,2], //2 items between 600 and 0
		itemsTabletSmall:[639,1],
		itemsMobile : [319,1] // itemsMobile disabled - inherit from itemsTablet option
		});
	}
	
	
	$(".chck-all-price").click(function(){
		if($(this).is(":checked"))
		{
			$(".chck-child-price").prop("checked",true);
			$(".text-chk-price").html("Deselect All");
		}else
		{
			$(".chck-child-price").prop("checked",false);
			$(".text-chk-price").html("Select All");
		}
	});
	$(".chck-all-discount").click(function(){
		if($(this).is(":checked"))
		{
			$(".chck-child-discount").prop("checked",true);
			$(".text-chk-discount").html("Deselect All");
		}else
		{
			$(".chck-child-discount").prop("checked",false);
			$(".text-chk-discount").html("Select All");
		}
	});
	$(".chck-all-store").click(function(){
		if($(this).is(":checked"))
		{
			$(".chck-child-store").prop("checked",true);
			$(".text-chk-store").html("Deselect All");
		}else
		{
			$(".chck-child-store").prop("checked",false);
			$(".text-chk-store").html("Select All");
		}
	});
	$(".chck-all-brand").click(function(){
		if($(this).is(":checked"))
		{
			$(".chck-child-brand").prop("checked",true);
			$(".text-chk-brand").html("Deselect All");
		}else
		{
			$(".chck-child-brand").prop("checked",false);
			$(".text-chk-brand").html("Select All");
		}
	});
		
			
	$('.navigation1').meanmenu();
	
    
	/*$('ul.tabs li').click(function(){
		var index = $(this).index();
		$('ul.tabs li').removeClass('active');
		$(this).addClass('active');
		$('.panes').hide();
		$('.panes').eq(index).show();
		return false;
	});*/
	
	//$(".fancybox").fancybox();
	
	
	
	
	
	
	

});

