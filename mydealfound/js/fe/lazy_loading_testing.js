var keep_top_offset = null;
var timeout;
var processing=false;

function enable_lazy_loading_in_ajax_pagination(pageination_main_container_id,loading_container_id)
	{
		var main_container = $('#'+pageination_main_container_id);
		var loading_container = $('#'+loading_container_id);
		var nxtPageCalled = false;
		
		
		
		//$(document).ready(function(){
			
			keep_top_offset = getTopPos(loading_container[0]);

			if(main_container.find('.pagination li').length==0)
			{
					loading_container.hide();
					return;
			}
			
			setInterval(function(){
				main_container.find('.pagination').hide();
			},100);
			
			var dom = $(window);
			
			var tmp_function;
			dom.scroll(tmp_function = function(){
				//console.log($(document).scrollTop());
				//alert(dom.scrollTop());
				
				var top = getTopPos(loading_container[0]);
				var viewport_height = $(window).height();
				var scroll_pos = dom.scrollTop();
				
				var offset_to_check = top + loading_container.height();
				
				if(offset_to_check<viewport_height+scroll_pos)
				{	
					//console.log(111);
					var newTop = $(window).scrollTop()+300;
					//showBusyScreen();
					timeout = setTimeout(function(){
							if (!processing)
							{
								processing=true;
								enable_lazy_loading_load_next_page(nxtPageCalled);
							}
						}, 2000
					);
					
					//enable_lazy_loading_load_next_page(nxtPageCalled);
					/*loading_container.css({position:'absolute',top:newTop+'px'}).show(500, function(){
						
								
						enable_lazy_loading_load_next_page(nxtPageCalled);
						
					/*loading_container.hide();
					});*/
					
				}
			});
			tmp_function();
		//});


		function enable_lazy_loading_load_next_page(nxtPageCalled)
		{
			/*if(nxtPageCalled)
				return false;*/
			
			processing=false;
			hideBusyScreen();
			
			var next_link_to_click = main_container
										.find('.pagination ul li a[class*="select"]').parent().next()
										.find('a');
			
			//console.log(next_link_to_click.length)
			if(next_link_to_click.length==1) // next page is already loaded with pagination
			{ 
				//loading_container.html('<img src="'+ base_url +'images/ajax-loader.gif"/>');
				//showBusyScreen();
			} 
			else if($.trim(main_container.html())=='') // next page is already loaded without pagination
			{
				//loading_container.hide();
				return;	
			} 
			else // next page not loaded yet
			{
				loading_container.hide();
				return;
			}
			
			main_container.removeAttr('id');
			
			var new_main_container = $('<div></div>');
			new_main_container.attr('id',pageination_main_container_id);
			
			//new_main_container.css({border:'1px black solid'});
			main_container.after(new_main_container);
			
			//console.log(main_container.find('.pagination ul li a[class*="active"]').next().find('a').length);
			next_link_to_click.click();
			
			main_container.find('.pagination').hide();
			main_container = new_main_container;
		}

	}
	
function getTopPos(inputObj)
{
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