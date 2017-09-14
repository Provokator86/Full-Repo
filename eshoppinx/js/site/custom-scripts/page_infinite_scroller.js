//// 1st, fetching the selected div...

$(function(){
	
    //var displayed_div = '#offer_ajax, #food_ajax_list, #product_ajax, #srch_list, #travel_ajax';
	var displayed_div = '#product_ajax';
	var nav_selector = 'div#page-nav-index:last';
    //var nav_row_selector = 'div.product_box:last';
	var nav_row_selector = 'div.product_box:last';
    //console.log($(nav_selector).html());
    
    /*var top = getTopPos($("#infscr-loading")[0]);
    var viewport_height = $(window).height();
    var scroll_pos = $(window).scrollTop();
    console.log(top+'==>'+viewport_height+'==>'+scroll_pos);
    //var offset_to_check = top + $("#product_ajax").height();     
    var offset_to_check = top + 600;     
    console.log(offset_to_check);           
    if(offset_to_check<viewport_height+scroll_pos)
    {
        console.log(22222);
    
    }*/
    $(window).scroll(function(){
        //console.log($(window).scrollTop()+'=='+$(document).height()+'======'+$(window).height());
        /*var toppp = parseInt($(window).scrollTop());
        var _minus = parseInt($(document).height()) - 1*parseInt($(window).height());       
        if(toppp*1 == 1*_minus)
        { 
        }*/
        
         if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100)
         {             
         }
        
    });
    
     //// setting up the infinite-scroll part...
        $(displayed_div).infinitescroll({
            navRowSelector : nav_row_selector,
            navSelector  : nav_selector,            
                           // selector for the paged navigation (it will be hidden)
            nextSelector : nav_selector +" a:first",    
                           // selector for the NEXT link (to page 2)
            //itemSelector : "div.product_box",
            itemSelector : "div.product_box",
                           // selector for all items you'll retrieve
            debug         : false,
            loading      : {
                                finishedMsg: "End",
                                img: base_url +'images/scrolling_content_loader.gif',
                                msgText: "Loading"
                           }
            },function(arrayOfNewElems) {
                
                //// For HOVER [BEGIN]
                    _call_hover_Product();
                //// For HOVER [END]
                
                //// scroll-to-top...
                //$().UItoTop({ easingType: 'easeOutQuart' });
                
        });
        
        //// scroll-to-top...
        //$().UItoTop({ easingType: 'easeOutQuart' });
	
	
});



/// function definition for infinite-scroller...
function infinite_scroll_init() {
	//console.log($('#page-nav-index').html());
    //var displayed_div = '#offer_ajax, #food_ajax_list, #product_ajax, #srch_list, #travel_ajax';
	var displayed_div = '#product_ajax';
	var nav_selector = 'div#page-nav-index';
    //var nav_row_selector = 'div.product_box:last';
	var nav_row_selector = 'div.product_box:last';
	
	
	//// setting up the infinite-scroll part...
	$(displayed_div).infinitescroll({
		
		navRowSelector : nav_row_selector,
		navSelector  : nav_selector,            
					   // selector for the paged navigation (it will be hidden)
		nextSelector : nav_selector +" a:first",    
					   // selector for the NEXT link (to page 2)
        //itemSelector : "div.product_box",
		itemSelector : "div.product_box",
					   // selector for all items you'll retrieve
		loading      : {
							finishedMsg: "End",
							img: base_url +'images/scrolling_content_loader.gif',
							msgText: "Loading"
					   }
		},function(arrayOfNewElems) {
			
			//// For HOVER [BEGIN]
				_call_hover_Product();
			//// For HOVER [END]
			//// scroll-to-top...
			//$().UItoTop({ easingType: 'easeOutQuart' });
			
	});
}

function getTopPos(inputObj)
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
  
}


//// =========== NEW - FOR PRODUCT HOVER EFFECT [BEGIN] ===========

	function _call_hover_Product() {
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
	}
	
//// =========== NEW - FOR PRODUCT HOVER EFFECT [END] ===========