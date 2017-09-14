function enable_lazy_loading_in_ajax_pagination(pageination_main_container_id,loading_container_id)
	{
		var main_container = $('#'+pageination_main_container_id);
		var loading_container = $('#'+loading_container_id);
		
		
		$(document).ready(function(){

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
					enable_lazy_loading_load_next_page();
				}
			});
			tmp_function();
		});


		function enable_lazy_loading_load_next_page()
		{
			
			var next_link_to_click = main_container
										.find('.pagination ul li a[class*="active"]').parent().next()
										.find('a');
			
			
			if(next_link_to_click.length==1) // next page is already loaded with pagination
			{ 
			} 
			else if($.trim(main_container.html())=='') // next page is already loaded without pagination
			{
				loading_container.hide();
				return;	
			} 
			else // next page not loaded yet
			{
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