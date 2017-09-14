//// 1st, fetching the selected div...

$(function(){
	
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