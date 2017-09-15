		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function gmap_garbage_collector_purge(id_or_object) 
		{
			GMAP_GARBAGE_COLLECTOR_PURGE(id_or_object);
		}
		function GMAP_GARBAGE_COLLECTOR_PURGE(d) //Garbage Collection
		{
			try{
				if(typeof d =='string')d=document.getElementById(d);
				if(d==null) return;
				
				var a = d.attributes, i, l, n;
				if (a) {
					l = a.length;
					for (i = 0; i < l; i += 1) {
						n = a[i].name;
						if (typeof d[n] === 'function') {
							d[n] = null;
						}
					}
				}
				a = d.childNodes;
				if (a) {
					l = a.length;
					for (i = 0; i < l; i += 1) {
						garbage_collector_purge(d.childNodes[i]);
					}
				}
			}catch(e){}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_IS_URL(str)
		{
			str=str.toLowerCase();
			return (str.indexOf('http://')==0)||(str.indexOf('https://')==0);
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		/*
		function GMAP_CALCULATE_DISTANCE(lat1,lng1,lat2,lng2)
		{
			//returns the distance in kilometers
			distance = (3958*3.1415926*Math.sqrt((lat2-lat1)*(lat2-lat1) + Math.cos(lat2/57.29578)*Math.cos(lat1/57.29578)*(lng2-lng1)*(lng2-lng1))/180);
			return distance;
		}
		*/
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_GET_TIME_STAMP() 
		{
			var obj= new Date();
			var msec=obj.getMilliseconds();
			var sec=obj.getSeconds();
			var min=obj.getMinutes();
			msec=min*60*1000+sec*1000+msec;
			return msec;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
