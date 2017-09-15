		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_GET_ADDRESS_OBJECT(address,name,description,img) 
		{
			var obj = new Object();
			obj.address=address;
			obj.name=name;
			obj.description=description;
			obj.img=img;
			obj.point=null;
			obj.found=false;
			
			obj.direction_required=false;
			var direction_hint='DIRECTION:';
			if(obj.address.toUpperCase().indexOf(direction_hint)==0)
			{
				obj.address=obj.address.substring(direction_hint.length);
				obj.direction_required=true;
			}
			return obj;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_INIT()
		{
			GMAP_LOAD_MAP_VIEW();
			if(!gmap_do_not_load_onload)
				GMAP_SET_MAP_ADDRESS(null);
		
			if(GMAP_IS_IE_BROWSER())		
				document.body.onunload=GUnload;
			else
				this.onunload=GUnload;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_INIT_TRIGGER_SET_ON_LOAD()
		{
			if(GMAP_IS_IE_BROWSER())
				document.body.onload=GMAP_INIT;
			else
				this.onload=GMAP_INIT;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function gmap_set_address(address)
		{
			GMAP_SET_MAP_ADDRESS(address);
		}
		var GMAP_SET_MAP_ADDRESS_timer=null;
		var GMAP_SET_MAP_ADDRESS_address=null;
		function GMAP_SET_MAP_ADDRESS(address,private) 
		{
			if(typeof private == 'undefined')private=false;
			
			if(GMAP_SET_MAP_ADDRESS_timer!=null)
			{
				try{if(!private)clearTimeout(GMAP_SET_MAP_ADDRESS_timer);}catch(e){alert(1)}
				GMAP_SET_MAP_ADDRESS_timer=null;
			}
			if((gmap_geocoder==null) || (gmap==null) || GMAP_FETCH_MAP_ADDRESS_POINT_onprocess)
			{
				GMAP_SET_MAP_ADDRESS_address=address;
				GMAP_SET_MAP_ADDRESS_timer=setTimeout("GMAP_SET_MAP_ADDRESS(GMAP_SET_MAP_ADDRESS_address,true)",100);
				return;
			}
			if(address!=null)
			{
				map_address = new Array();
				for(var i=0;i<address.length;i++)
				{
					map_address[map_address.length]=GMAP_GET_ADDRESS_OBJECT(address[i][0],address[i][1],address[i][2],[i][3]);
				} 
			}
			
			var time_stamp=GMAP_GET_TIME_STAMP();
			for(var i=0;i<map_address.length;i++)
			{
				map_address[i].time_stamp=time_stamp;
			}
			document.getElementById(gmap_id).style.visibility='hidden';
			GMAP_FETCH_MAP_ADDRESS_POINT();
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_LOAD_MAP_VIEW() 
		{
			if (GBrowserIsCompatible()) 
			{
				gmap = new GMap2(document.getElementById(gmap_id));
				
				if(gmap){}
				else return;
				
				GEvent.addListener	(	gmap, 
										'click', 
										function(overlay, latlng) 
										{
											if((overlay!=null) && (typeof overlay == 'object')) return;
											
											if(typeof gmap_click_event == 'function')
											{
												var ret = gmap_click_event(latlng.lat(),latlng.lng());
												if(ret)
												{
													var LatLngStr = "Lat = " + latlng.lat() + ", Long = " + latlng.lng();
													gmap.openInfoWindow(latlng, LatLngStr);
												}
											}
										}
									);
				
				
				gmap.enableScrollWheelZoom();
				
				//gmap.addControl(new GLargeMapControl());		// a large pan/zoom control used on Google Maps. Appears in the top left corner of the gmap. 
				//gmap.addControl(new GSmallMapControl());		// a smaller pan/zoom control used on Google Maps. Appears in the top left corner of the gmap. 
				//gmap.addControl(new GSmallZoomControl());		// a small zoom control (no panning controls) used in the small gmap blowup windows used to display driving directions steps on Google Maps. 
				//gmap.addControl(new GScaleControl());			// a gmap scale 
				//gmap.addControl(new GMapTypeControl());		// buttons that let the user toggle between gmap types (such as Map and Satellite) 
				//gmap.addControl(new GOverviewMapControl());	// a collapsible overview gmap in the corner of the screen 
				
				for(var i=0;i<gmap_controls.length;i++)
				{
					eval('gmap.addControl(new '+gmap_controls[i]+'());');
				}
				
				GMAP_DISPLAY_POINT_NOTHING_FOUND();
				
				gmap_geocoder = new GClientGeocoder();
				document.getElementById(gmap_id).style.background="";
				document.getElementById(gmap_id).style.backgroundColor="#ffffff";
				//document.getElementById(gmap_id).style.visibility='hidden';
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_DISPLAY_POINT_NOTHING_FOUND()
		{
			gmap.setCenter(new GLatLng(37.4419, -122.1419), 1);
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
