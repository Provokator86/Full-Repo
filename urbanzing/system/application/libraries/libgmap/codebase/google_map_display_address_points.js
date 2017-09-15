		function GMAP_REMOVE_NON_DISPLAY_POINT()
		{
			var tmp_map_address= new Array();
			for(var i=0;i<map_address.length;i++)
			{
				if((map_address[i].point!=null)&&(map_address[i].point!=false)&&(map_address[i].found==true))
				{
					map_address[i].org_i=i;
					tmp_map_address[tmp_map_address.length]=map_address[i];
				}
			}
			map_address=tmp_map_address;
		}
		function GMAP_DISPLAY_POINT()
		{
			
			GMAP_REMOVE_NON_DISPLAY_POINT();		
			gmap.clearOverlays();
			
			if(map_address.length==0)
				GMAP_DISPLAY_POINT_NOTHING_FOUND();
			else
			{
				var blueIcon = GMAP_GET_MARKER_ICON();
				var mean_lat=0;
				var mean_lng=0;
				var min_lat=1000000000;
				var min_lng=1000000000;
				var max_lat=-1000000000;
				var max_lng=-1000000000;
				var min_map_depth=15;
				for(var i=0;i<map_address.length;i++)
				{
					//alert(map_address[i].address+' '+map_address[i].name+' '+map_address[i].description+' '+map_address[i].point+' '+map_address[i].map_depth+' '+map_address[i].found);
					var icon=(map_address[i].img!='')?GMAP_GET_MARKER_ICON(map_address[i].img):blueIcon;
					var marker_option = new Object();
					marker_option.icon=icon;

					if(GMAP_IS_URL(map_address[i].name))
					{
						marker_option.title=map_address[i].description;
					}
					
					var marker = new GMarker(map_address[i].point,marker_option);
					gmap.addOverlay(marker);
					
					if(GMAP_IS_URL(map_address[i].name))
					{
						GMAP_ATTACH_MARKER_CLICK_EVENT(marker,i);
					}
					else
					{
						if((map_address[i].name!=''))// && (map_address[i].description!=''))
						{
							
							var html='<B>'+map_address[i].name+'</B><BR>'+map_address[i].description;
							var id='GMAP_DISPLAY_POINT_'+gmap_id+'_index_'+i;
							html='<span id="'+id+'">'+html+'<span>';
							marker.bindInfoWindowHtml(html,{onCloseFn:function(){GMAP_GARBAGE_COLLECTOR_PURGE(id)}}); // close function does not work with bindInfoWindowHtml
							//marker.bindInfoWindowHtml(html);
						}
						else
						{
							marker.openInfoWindowHtml(map_address[i].address);
						}
					}
					map_address[i].marker=marker;
					var lat=map_address[i].point.lat()*1;
					var lng=map_address[i].point.lng()*1;
					var map_depth=map_address[i].map_depth;
					
					mean_lat+=lat;
					mean_lng+=lng;
					
					if(min_lat>lat)min_lat=lat;
					if(min_lng>lng)min_lng=lng;
					
					
					if(max_lat<lat)max_lat=lat;
					if(max_lng<lng)max_lng=lng;
					
					if(min_map_depth>map_depth)min_map_depth=map_depth;
				}
				mean_lat=mean_lat/map_address.length;
				mean_lng=mean_lng/map_address.length;
				
				var mid_lat=(max_lat+min_lat)/2;
				var mid_lng=(max_lng+min_lng)/2;
				var adjust_percent=0/100;
				var adjust_lat=(max_lat-min_lat)*adjust_percent;
				var adjust_lng=(max_lng-min_lng)*adjust_percent;
				
				var sw= new GLatLng(min_lat-adjust_lat,min_lng-adjust_lng);
				var ne= new GLatLng(max_lat+adjust_lat,max_lng+adjust_lng);
				
				
				var bounds= new GLatLngBounds(sw,  ne);
				var zoom=gmap.getBoundsZoomLevel(bounds);
				gmap.setCenter(new GLatLng(mid_lat,mid_lng), zoom);
				
				GMAP_DISPLAY_ALL_DIRECTION();
			}
			GMAP_FETCH_MAP_ADDRESS_POINT_onprocess=false;
			document.getElementById(gmap_id).style.visibility='visible';
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_ATTACH_MARKER_CLICK_EVENT(marker,i)
		{
			GEvent.addListener	(	marker, 
									'click', 
									function(overlay, latlng) 
									{
										if((overlay==null) || (typeof overlay != 'object')) return;
										
										if(typeof gmap_marker_click_event == 'function')
										{
											//alert(map_address[i].name)
											gmap_marker_click_event(map_address[i].name);
											//url=map_address[i].name:
											//When executing an event listener, it is often advantageous to have both private and persistent data attached 
											//to an object. JavaScript does not support "private" instance data, but it does support closures which allows 
											//inner functions to access outer variables. Closures are useful within event listeners to access variables not 
											//normally attached to the objects on which events occur.
										}
									}
								);

		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_GET_MARKER_ICON(url)
		{
			var default_icon=false;
			if(!url || url=='')
			{
				url="http://www.google.com/intl/en_us/mapfiles/ms/micons/blue-dot.png";
				default_icon=true;
			}
			var icon = new GIcon(G_DEFAULT_ICON);
			if(!default_icon)
				icon.shadowSize = new GSize(0, 0);


			var size_marker="////////";
			var given_width=0;
			var given_height=0;
			if(url.indexOf(size_marker)>-1)
			{
				url=url.split(size_marker);
				given_width=url[1];
				given_height=url[2];
				url=url[0];
			}
		
			icon.image = url;
			
			var newImg = new Image();
			newImg.src = url;
			var width = newImg.width;
			var height = newImg.height;

			if((given_width>0)||(given_height>0))
			{
				if((given_width>0)&&(given_height>0))
				{
					width = given_width;
					height = given_height;				
				}
				else 
				{
					if(given_width>0)
						var ratio=given_width/width;
					else
						var ratio=given_height/height;
					width=Math.round(width*ratio);
					height=Math.round(height*ratio);
				}
			}
			else
			{
								
				if(width>100)
				{
					var map_width=gmap_width;
					map_width=map_width.toLowerCase().split('px');map_width=map_width[0];
					
					var ratio=(32)/width;
					width=Math.round(width*ratio);
					height=Math.round(height*ratio);
				}
			}

			icon.iconSize = new GSize(width, height);
			
			return icon;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
