//// 1st, fetching the selected div...

$(function(){
	
	var displayed_div = '#offer_ajax, #food_ajax_list, #product_ajax, #srch_list, #travel_ajax';
	var nav_selector = 'div#page-nav-index';
	
	/*var top = getTopPos($("#infscr-loading")[0]);
	var viewport_height = $(window).height();
	var scroll_pos = $(window).scrollTop();
	console.log(top+'==>'+viewport_height+'==>'+scroll_pos);
	var offset_to_check = top + loading_container.height();				
	if(offset_to_check<viewport_height+scroll_pos)
	{
		console.log(22222);
	}*/
	//// setting up the infinite-scroll part...
	$(displayed_div).infinitescroll({
		
		navSelector  : nav_selector,            
					   // selector for the paged navigation (it will be hidden)
		nextSelector : nav_selector +" a:first",    
					   // selector for the NEXT link (to page 2)
		itemSelector : "div.product_box",
					   // selector for all items you'll retrieve
		//debug		 : true,
		loading      : {
							finishedMsg: "End",
							img: base_url +'images/scrolling_content_loader.gif',
							msgText: "Loading"
					   }
		},function(arrayOfNewElems) {
			
			//// scroll-to-top...
			$().UItoTop({ easingType: 'easeOutQuart' });
			
	});
	
	
	//// scroll-to-top...
	$().UItoTop({ easingType: 'easeOutQuart' });
	
	
	
	
});



/// function definition for infinite-scroller...
function infinite_scroll_init() {
	
	var displayed_div = '#offer_ajax, #food_ajax_list, #product_ajax, #srch_list, #travel_ajax';
	var nav_selector = 'div#page-nav-index';
	
	
	//// setting up the infinite-scroll part...
	$(displayed_div).infinitescroll({
		
		navSelector  : nav_selector,            
					   // selector for the paged navigation (it will be hidden)
		nextSelector : nav_selector +" a:first",    
					   // selector for the NEXT link (to page 2)
		itemSelector : "div.product_box",
					   // selector for all items you'll retrieve
		loading      : {
							finishedMsg: "End",
							img: base_url +'images/scrolling_content_loader.gif',
							msgText: "Loading"
					   }
		},function(arrayOfNewElems) {
			
			//// scroll-to-top...
			$().UItoTop({ easingType: 'easeOutQuart' });
			
	});
}

/*function getTopPos(inputObj)
{
	var keep_top_offset = null;
	var ret = $(inputObj).offset().top;
	if($(inputObj).is(":visible"))
		return ret;
	
  var returnValue = inputObj.offsetTop 	+ inputObj.clientTop;
  while((inputObj = inputObj.offsetParent) != null && ($(inputObj).css('position')!='absolute' || $(inputObj).css('position')!='relative') )
  	returnValue += inputObj.offsetTop 	+ inputObj.clientTop;
  
  if( returnValue==0 )
  	returnValue = keep_top_offset;
  
  return returnValue;
  
}*/