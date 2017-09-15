		var GMAP_FETCH_MAP_ADDRESS_POINT_i=-1;
		var GMAP_FETCH_MAP_ADDRESS_POINT_onprocess=false;
		function GMAP_FETCH_MAP_ADDRESS_POINT() 
		{
			GMAP_FETCH_MAP_ADDRESS_POINT_onprocess=true;
			GMAP_FETCH_MAP_ADDRESS_POINT_i=-1;
			for(var i=0;i<map_address.length;i++)
			{
				if(map_address[i].point==null)
				{
					GMAP_FETCH_MAP_ADDRESS_POINT_i=i;
					GMAP_GET_LATLNG(map_address[i].address,GMAP_FETCH_MAP_ADDRESS_POINT_DONE);
					break;
				}
			}
			
			if(map_address.length==0)
				GMAP_DISPLAY_POINT(); 
		}
		function GMAP_FETCH_MAP_ADDRESS_POINT_DONE(ret)
		{
			var i=GMAP_FETCH_MAP_ADDRESS_POINT_i;
			GMAP_FETCH_MAP_ADDRESS_POINT_i=-1;
			
			if(!ret)
			{
				if(map_address[i].tried_count){}
				else map_address[i].tried_count=0;
				if(map_address[i].tried_count<1) // set max tried_count for location here
				{	
					map_address[i].point=null;
					map_address[i].tried_count++;
				}
				else
					map_address[i].point=false;
				map_address[i].map_depth=1;
				map_address[i].found=false;
			}
			else
			{
				//alert(map_address[i].name+'='+ret.point.lat()+','+ret.point.lng())
				map_address[i].point=ret.point;
				map_address[i].map_depth=ret.map_depth;
				map_address[i].found=ret.found;
			}
			if(i<map_address.length-1)
				GMAP_FETCH_MAP_ADDRESS_POINT();
			else
				GMAP_DISPLAY_POINT();				
		}
