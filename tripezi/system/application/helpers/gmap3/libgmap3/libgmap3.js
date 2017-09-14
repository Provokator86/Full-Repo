
function LIB_GMAP_INIT_JS(container_id,id,width,height,map_type_id,map_type_control,zoom_control)
{            
	if(document.getElementById(LIB_GMAP_GET_CANVAS_ID(id)) ==null)
	{           
		var canvas_id=LIB_GMAP_GET_CANVAS_ID(id);
		var container = document.getElementById(container_id);
		var canvas = document.createElement('DIV');
		canvas.id=canvas_id;
		canvas.style.width=width;
		canvas.style.height=height;
		container.appendChild(canvas);
		LIB_GMAP_LOAD_CANVAS(id,map_type_id,map_type_control,zoom_control);
	}
}

function LIB_GMAP_DESTRUCT_JS(container_id,id)
{
	if(typeof document.getElementById(LIB_GMAP_GET_CANVAS_ID(id)) != 'object')
	{
		LIB_GMAP_MARKER_DEL_ALL(id);
		
		for(var i=0;i<LIB_GMAP_WRAPPER_ARR.length;i++)
		{
			var gmap_wrapper = LIB_GMAP_WRAPPER_ARR[i];
			if(gmap_wrapper && (gmap_wrapper.id==id) && gmap_wrapper.canvas_exist())
				LIB_GMAP_WRAPPER_ARR[i] = null;
		}
			
		var canvas_id=LIB_GMAP_GET_CANVAS_ID(id);
		var container = document.getElementById(container_id);
		var canvas = document.getElementById(canvas_id);
		container.removeChild(canvas);
		
	}
}

function LIB_GMAP_MARKER_ADD_ARR(id,arr_marker)
{
	if(typeof LIB_GMAP_MARKER_ADD_ARR_PROCESSING == 'undefined' || !LIB_GMAP_MARKER_ADD_ARR_PROCESSING){}
	else return -1;
	
	LIB_GMAP_MARKER_ADD_ARR_PROCESSING = true;
	
	var add_ref_index_arr = new Array();
	for(var i=0;i<arr_marker.length;i++)
	{
		var marker = arr_marker[i];
		if( (typeof marker.opt_img !='undefined') && (typeof marker.opt_img_width !='undefined') && (typeof marker.opt_img_height !='undefined') )
			LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length] = new LIB_GMAP_MARKER(id,marker.address_or_latlng,marker.title,marker.link_or_html,marker.opt_img,marker.opt_img_width,marker.opt_img_height,marker.icon);
		else if( (typeof marker.opt_img !='undefined') )
			LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length] = new LIB_GMAP_MARKER(id,marker.address_or_latlng,marker.title,marker.link_or_html,marker.opt_img,'','',marker.icon);
		else 
			LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length] = new LIB_GMAP_MARKER(id,marker.address_or_latlng,marker.title,marker.link_or_html,'','','',marker.icon);
		
		LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length-1].add_ref_index = LIB_GMAP_MARKER_ARR.length -1;
		
		add_ref_index_arr[add_ref_index_arr.length] = LIB_GMAP_MARKER_ARR.length -1;
	}
	
	LIB_GMAP_MARKER_RESOLVE_ALL_AND_SHOW_ON_MAP(id);
	
	LIB_GMAP_MARKER_ADD_ARR_PROCESSING=false;
	return add_ref_index_arr;
}

function LIB_GMAP_MARKER_ADD(id,address_or_latlng,title,link_or_html,opt_img,opt_img_width,opt_img_height)
{
	if(typeof LIB_GMAP_MARKER_ADD_PROCESSING == 'undefined' || !LIB_GMAP_MARKER_ADD_PROCESSING){}
	else return -1;
	
	LIB_GMAP_MARKER_ADD_PROCESSING = true;
	
	if( (typeof opt_img !='undefined') && (typeof opt_img_width !='undefined') && (typeof opt_img_height !='undefined') )
		LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length] = new LIB_GMAP_MARKER(id,address_or_latlng,title,link_or_html,opt_img,opt_img_width,opt_img_height);
	else if( (typeof opt_img !='undefined') )
		LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length] = new LIB_GMAP_MARKER(id,address_or_latlng,title,link_or_html,opt_img);
	else 
		LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length] = new LIB_GMAP_MARKER(id,address_or_latlng,title,link_or_html);
	
	LIB_GMAP_MARKER_ARR[LIB_GMAP_MARKER_ARR.length-1].add_ref_index = LIB_GMAP_MARKER_ARR.length -1;
	
	var add_ref_index = LIB_GMAP_MARKER_ARR.length -1;
	LIB_GMAP_MARKER_ARR[add_ref_index].resolve_latlng_and_show_marker_on_map();
	
	LIB_GMAP_MARKER_ADD_PROCESSING=false;
	return add_ref_index;
}

function LIB_GMAP_MARKER_DEL(add_ref_index)
{
	if(LIB_GMAP_MARKER_ARR[add_ref_index] != null)
	{
		LIB_GMAP_MARKER_ARR[add_ref_index].remove_marker_from_map();
		LIB_GMAP_MARKER_ARR[add_ref_index] = null;
	}
}

function LIB_GMAP_MARKER_DEL_ALL(id)
{
	for(var i=0;i<LIB_GMAP_MARKER_ARR.length;i++)
	{
		if(LIB_GMAP_MARKER_ARR[i] !=null && LIB_GMAP_MARKER_ARR[i].id==id)
			LIB_GMAP_MARKER_DEL(i);
	}
	
}

function LIB_GMAP_MARKER_SHOW_ALL_RESOLVED_IN_VIEW(id)
{
	var lat_lng_bounds = null;
	for(var i=0;i<LIB_GMAP_MARKER_ARR.length;i++)
	{
		var gmap_marker = LIB_GMAP_MARKER_ARR[i];
		if(gmap_marker!=null && (gmap_marker.id == id) && gmap_marker.latlng_resolved)
		{
			var lat_lng = new google.maps.LatLng(gmap_marker.lat,gmap_marker.lng);
			if(lat_lng_bounds == null)
				lat_lng_bounds = new google.maps.LatLngBounds(lat_lng,lat_lng);
			else
				lat_lng_bounds.extend(lat_lng);
		}
	}
	if(lat_lng_bounds != null)
	{
		var gmap_wrapper = LIB_GMAP_WRAPPER_GET(id)

		if(gmap_wrapper){}
		else return;
		
		gmap_wrapper.gmap.fitBounds(lat_lng_bounds);
	}
}

function LIB_GMAP_DIRECTION_ADD(id,src_add_ref_index,dst_add_ref_index)
{
	
	//alert(id + ', ' + src_add_ref_index + ', ' + dst_add_ref_index)
	
	var gmap_marker_src = LIB_GMAP_MARKER_ARR[src_add_ref_index];
	if( (gmap_marker_src == null) || (gmap_marker_src.lat == null) || (gmap_marker_src.lng == null) )
		return -1;
	
	if(dst_add_ref_index=='*')
	{
		var add_ref_index_arr = new Array();
		for(var i=0;i<LIB_GMAP_MARKER_ARR.length;i++)
		{
			if(i!=src_add_ref_index)
			{
				add_ref_index_arr[add_ref_index_arr.length]=LIB_GMAP_DIRECTION_ADD(id,src_add_ref_index,i);
			}
		}
	
		return add_ref_index_arr;
	}
	
	var gmap_marker_dst = LIB_GMAP_MARKER_ARR[dst_add_ref_index];
	if( (gmap_marker_dst == null) || (gmap_marker_dst.lat == null) || (gmap_marker_dst.lng == null) )
		return -1;
	
	for(var i=0;i<LIB_GMAP_DIRECTION_ARR.length;i++)
	{
		var tmp = LIB_GMAP_DIRECTION_ARR[i];
		if( (tmp.gmap_marker_src == gmap_marker_src) && (tmp.gmap_marker_dst == gmap_marker_dst) )
			return -1;
		else if( (tmp.gmap_marker_src == gmap_marker_dst) && (tmp.gmap_marker_dst == gmap_marker_src) )
			return -1;
	}
	
	//alert(id + ', ' + src_add_ref_index + ', ' + dst_add_ref_index)
	
	LIB_GMAP_DIRECTION_ARR[LIB_GMAP_DIRECTION_ARR.length]= new LIB_GMAP_DIRECTION(id,gmap_marker_src,gmap_marker_dst);
	
	LIB_GMAP_DIRECTION_ARR[LIB_GMAP_DIRECTION_ARR.length-1].add_ref_index = LIB_GMAP_DIRECTION_ARR.length -1;
	
	LIB_GMAP_DIRECTION_ARR[LIB_GMAP_DIRECTION_ARR.length-1].resolve_and_show_route_on_map();
	
	var add_ref_index = LIB_GMAP_DIRECTION_ARR.length -1;
	return add_ref_index;
}

function LIB_GMAP_DIRECTION_DEL(add_ref_index)
{
	if(LIB_GMAP_DIRECTION_ARR[add_ref_index] != null)
	{
		LIB_GMAP_DIRECTION_ARR[add_ref_index].remove_route_from_map();
		LIB_GMAP_DIRECTION_ARR[add_ref_index] = null;
	}
}

function LIB_GMAP_DIRECTION_DEL_ALL(id)
{
	for(var i=0;i<LIB_GMAP_DIRECTION_ARR.length;i++)
	{
		if(LIB_GMAP_DIRECTION_ARR[i].id==id)
			LIB_GMAP_DIRECTION_DEL(i);
	}
	
}


//////////////////////////////////////////////////////////
// PRIVATE METHOD BELOW
//////////////////////////////////////////////////////////

var LIB_GMAP_WRAPPER_ARR = new Array();
var LIB_GMAP_MARKER_ARR = new Array();
var LIB_GMAP_DIRECTION_ARR = new Array();
function LIB_GMAP_LOAD_CANVAS(id,map_type_id,map_type_control,zoom_control)
{
	if(!GMAP_DOC_LOADED)
	{
		map_type_control=map_type_control?'true':'false';
		setTimeout('LIB_GMAP_LOAD_CANVAS("'+id+'","'+map_type_id+'",'+map_type_control+',"'+zoom_control+'");',50);
	}
	else
	{
		for(var i=0;i<LIB_GMAP_WRAPPER_ARR.length;i++)
		{
			var gmap_wrapper = LIB_GMAP_WRAPPER_ARR[i];
			if(gmap_wrapper && gmap_wrapper.id==id)
				return;
		}
		
		LIB_GMAP_WRAPPER_ARR[LIB_GMAP_WRAPPER_ARR.length]=new LIB_GMAP_WRAPPER(id,map_type_id,map_type_control,zoom_control);
		LIB_GMAP_MARKER_RESOLVE_ALL_AND_SHOW_ON_MAP(id);
	}
}

function LIB_GMAP_WRAPPER_GET(id)
{
	for(var i=0;i<LIB_GMAP_WRAPPER_ARR.length;i++)
	{
		var gmap_wrapper = LIB_GMAP_WRAPPER_ARR[i];
		if(gmap_wrapper && (gmap_wrapper.id==id) && gmap_wrapper.canvas_exist())
			return gmap_wrapper;
	}
	return null;
}

function LIB_GMAP_WRAPPER(id,map_type_id,map_type_control,zoom_control) // constructor
{
	this.id=id;
	this.canvas_id=LIB_GMAP_GET_CANVAS_ID(id);
	
	var gmap_options =	{
							center: new google.maps.LatLng(-34.397, 150.644),
							zoom: 2,
							mapTypeId: eval('google.maps.MapTypeId.'+map_type_id),
							mapTypeControl: map_type_control,
							mapTypeControlOptions:	{
														mapTypeIds: google.maps.MapTypeId.ROADMAP|google.maps.MapTypeId.HYBRID,
														position: google.maps.ControlPosition.TOP_RIGHT,
														style:	google.maps.MapTypeControlStyle.DROPDOWN_MENU
													},
							scaleControl: false,
							rotateControl: false,
							streetViewControl: false,
							panControl: false,
							zoomControl: (zoom_control=='')?false:true,
							zoomControlOptions:	{
													position: google.maps.ControlPosition.TOP_LEFT,
													style: (zoom_control=='LARGE')?google.maps.ZoomControlStyle.LARGE:google.maps.ZoomControlStyle.SMALL
												}
						};
	this.gmap = new google.maps.Map(document.getElementById(this.canvas_id),gmap_options);
	this.infowindow = new google.maps.InfoWindow({content: ''});
	this.canvas_exist = function(){
		return typeof document.getElementById(this.canvas_id) == 'object';
	}
}


function LIB_GMAP_MARKER_RESOLVE_ALL_AND_SHOW_ON_MAP(id)
{
	for(var i=0;i<LIB_GMAP_MARKER_ARR.length;i++)
	{
		var gmap_marker = LIB_GMAP_MARKER_ARR[i];
		if(gmap_marker!=null && (gmap_marker.id == id) && !gmap_marker.latlng_resolved)
		{
			gmap_marker.resolve_latlng();
			setTimeout('LIB_GMAP_MARKER_RESOLVE_ALL_AND_SHOW_ON_MAP("'+id+'")',10);
			return;
		}
		else if(gmap_marker!=null && (gmap_marker.id == id) && gmap_marker.latlng_resolved)
		{
			gmap_marker.show_marker_on_map();
		}
	}
	
	if(typeof gmap_all_marker_loaded == 'function')
	{
		gmap_all_marker_loaded(id);
	}
	
}


function LIB_GMAP_MARKER(id,address_or_latlng,title,link_or_html,opt_img,opt_img_width,opt_img_height,icon) // constructor
{
	this.id=id;
	this.canvas_id=LIB_GMAP_GET_CANVAS_ID(id);
	
	var tmp = address_or_latlng.split(',');
	if((tmp.length==2) && GMAP_ISNUM(GMAP_TRIM_ALL(tmp[0])) && GMAP_ISNUM(GMAP_TRIM_ALL(tmp[1])))
	{
		this.address = address_or_latlng;
		this.lat = GMAP_TRIM_ALL(tmp[0]);
		this.lng = GMAP_TRIM_ALL(tmp[1]);		
		this.latlng_resolved = true;
	}
	else
	{
		this.address = address_or_latlng;
		this.lat = null;
		this.lng = null;
		this.latlng_resolved = false;
	}
	
	this.title = title;
	if((link_or_html.indexOf('http://')==0)||(link_or_html.indexOf('https://')==0))
	{
		this.link = link_or_html;
		this.html = null;
	}
	else
	{
		this.link = null;
		this.html = link_or_html;
	}
	
	if(typeof opt_img != 'undefined')
		this.img = opt_img;
	else
		this.img = null;
	
	if((typeof opt_img_width != 'undefined')&&(typeof opt_img_height != 'undefined'))
	{
		this.img_width = opt_img_width.split('px')[0]*1;
		this.img_height = opt_img_height.split('px')[0]*1;
	}
	else
	{
		this.img_width = null;
		this.img_height = null;
	}
	
	this.latlng_resolving =false;
	this.resolve_latlng = function ()
	{
		if(!this.latlng_resolved && !this.latlng_resolving)
		{
			this.latlng_resolving = true;
			var gcoder=new google.maps.Geocoder();
			var $this = this;
			gcoder.geocode({address:this.address}, function (result,status){
				if(status == google.maps.GeocoderStatus.OK)
				{
					$this.lat = result[0].geometry.location.lat();
					$this.lng = result[0].geometry.location.lng();
					if(typeof gmap_marker_address_resolved == 'function')
					{
						gmap_marker_address_resolved($this.lat,$this.lng,$this.id,$this.add_ref_index);
					}
				}
				$this.latlng_resolved = true;
				$this.latlng_resolving =false;
			});
			
		}
	}

	this.resolve_latlng_and_show_marker_on_map = function ()
	{
		if(!this.latlng_resolved)
		{
			var gcoder=new google.maps.Geocoder();
			var $this = this;
			gcoder.geocode({address:this.address}, function (result,status){
				if(status == google.maps.GeocoderStatus.OK)
				{
					$this.lat = result.geometry.location.lat();
					$this.lng = result.geometry.location.lng();

					if(typeof gmap_marker_address_resolved == 'function')
					{
						gmap_marker_address_resolved($this.lat,$this.lng,$this.id,$this.add_ref_index);
					}
				}
				$this.latlng_resolved = true;
				$this.show_marker_on_map();
			});
		}
		else
		{
			this.show_marker_on_map();
		}
	}

	this.marker = null;
	this.show_marker_on_map = function ()
	{
		if(!this.latlng_resolved || (this.lat==null) || (!this.lng==null)) return;
		if(this.marker) return;
		
		var gmap_wrapper = LIB_GMAP_WRAPPER_GET(this.id)

		if(gmap_wrapper){}
		else return;
		if(typeof icon!='undefined')
		{
			
			var icon_arr	=	icon.split('////////');
			var size		=	null;
			if(icon_arr[0]!='')
				var icon_url	=	icon_arr[0];
			if(icon_arr.length==2&&icon_arr[1]!='')
			{
				var icon_size	=	icon_arr[1].split(',');
				size		=	new google.maps.Size(icon_size[0],icon_size[1]);
			}
			icon	=	new google.maps.MarkerImage(icon_url, null, null, null, size);
			this.marker = new google.maps.Marker({
												position: new google.maps.LatLng(this.lat,this.lng), 
												map: gmap_wrapper.gmap,
												title: this.title,
												icon: icon
											});
		}
		else
		{
				this.marker = new google.maps.Marker({
												position: new google.maps.LatLng(this.lat,this.lng), 
												map: gmap_wrapper.gmap,
												title: this.title
											});
		}
		/*
		this.marker = new google.maps.Marker({
												position: new google.maps.LatLng(this.lat,this.lng), 
												map: gmap_wrapper.gmap,
												title: this.title,
												icon: icon
											});
		*/
		var $this = this;
		google.maps.event.addListener(this.marker, 'click', function() {
			if($this.html!=null)
			{
				var title = $this.title;
				var html = $this.html;
				
				if(typeof gmap_marker_clicked == 'function')
				{
					var ret = gmap_marker_clicked(null,$this.id,$this.add_ref_index);
					if((typeof ret == 'object') && (typeof ret.title != 'undefined') && (typeof ret.html != 'undefined') )
					{
						title = ret.title;
						html = ret.html;
					}
				}
				var content_string = '<table border=0 cellpadding=0 cellspacing=0><tr><td align=center style="font-weight:bold;">'+title+'</td></tr><tr><td>'+html+'</td></tr></table>';
				gmap_wrapper.infowindow.setContent(content_string);
				gmap_wrapper.infowindow.open(gmap_wrapper.gmap,$this.marker);
				
			}
			else if($this.link!=null)
			{
				if(typeof gmap_marker_clicked == 'function')
				{
					gmap_marker_clicked($this.link,$this.id,$this.add_ref_index);
				}
			}
		});
		
		
	}

	this.remove_marker_from_map = function ()
	{
		if(this.marker)
		{
			
			//var gmap_wrapper = LIB_GMAP_WRAPPER_GET(this.id);
			//gmap_wrapper.gmap.setZoom(gmap_wrapper.gmap.getZoom()-1);
			//this.marker.setMap(gmap_wrapper.gmap);
			//google.maps.event.clearListeners(this.marker,'click');
			//alert(this.marker.getIcon().url)
			//var icon =  google.maps.MarkerImage(this.marker.getIcon().url,new google.maps.Size(50,50));// this.marker.getIcon();
			
			//var icon = this.marker.getIcon();
			//icon.size.height=5;
			//this.marker.setIcon(icon);
			this.marker.setMap(null);
			
			this.marker = null;
		}
	}
	
	
}

function LIB_GMAP_DIRECTION(id,gmap_marker_src,gmap_marker_dst) // constructor
{
	this.id = id;
	
	this.gmap_marker_src=gmap_marker_src;
	this.gmap_marker_dst=gmap_marker_dst;
	
	
	this.latlng_src = new google.maps.LatLng(gmap_marker_src.lat,gmap_marker_src.lng);
	this.latlng_dst = new google.maps.LatLng(gmap_marker_dst.lat,gmap_marker_dst.lng);
	
	this.route_resolved = false;
	
	this.directions_display = null;
	this.directions_description = '';
	this.route_resolving = false;
	this.resolve_and_show_route_on_map = function()
	{
		if(!this.route_resolved && !this.route_resolving)
		{
			this.route_resolving = true;
			
			var gmap_wrapper = LIB_GMAP_WRAPPER_GET(this.id)
	
			if(gmap_wrapper){}
			else return;
			
			//this.directions_display = new google.maps.DirectionsRenderer({suppressMarkers:true});
			this.directions_display = new google.maps.Polyline({strokeColor:'#0000ff'});
			this.directions_display.setMap(gmap_wrapper.gmap);
			
			var directions_service = new google.maps.DirectionsService();
			var request =	{
								origin:this.latlng_src,
								destination:this.latlng_dst,
								travelMode: google.maps.TravelMode.DRIVING
							};
			var $this = this;
			directions_service.route(request, function(result, status) {
				if (status == google.maps.DirectionsStatus.OK)
				{
					if($this.directions_display!=null)
					{
						//$this.directions_display.setDirections(result);
						$this.directions_display.setPath(result.routes[0].overview_path);
						
						$this.directions_description += '<b>From:</b> '+$this.gmap_marker_src.address+'<br />\n';
						$this.directions_description += '<b>Start Point:</b> '+result.routes[0].legs[0].start_address+'<br /><br />\n';
						
						for(var i=0;i<result.routes[0].legs[0].steps.length;i++)
						{
							$this.directions_description += '<b>'+(i+1)+'.</b> '+result.routes[0].legs[0].steps[i].instructions + ' [ ' + result.routes[0].legs[0].steps[i].distance.text + ' ] ' +'<br /><br />\n';
						}
						
						$this.directions_description += '<b>End Point:</b> '+result.routes[0].legs[0].end_address+'<br />\n';
						$this.directions_description += '<b>To:</b> '+$this.gmap_marker_dst.address+'<br />\n';
						
					}
				}
				$this.route_resolved = true;
				$this.route_resolving = false;
			});
			
			google.maps.event.addListener(this.directions_display, 'click', function() {
				//alert($this.directions_description)
				if(typeof gmap_direction_clicked == 'function')
				{
					gmap_direction_clicked($this.add_ref_index,$this.gmap_marker_src.add_ref_index,$this.gmap_marker_dst.add_ref_index,$this.directions_description);
				}
			});
			
			
		}
	}
	this.remove_route_from_map = function()
	{
		this.directions_display.setMap(null);
		this.directions_display = null;
	}
}

function GMAP_IS_ARRAY(variable)
{
	return typeof(variable)=='object'&&(variable instanceof Array);
}
function GMAP_TRIM_ALL(sString) 
{
	if(sString.length>0)
	{
		while (sString.substring(0,1) == ' ')
		{
			sString = sString.substring(1, sString.length);
		}
		while (sString.substring(sString.length-1, sString.length) == ' ')
		{
			sString = sString.substring(0,sString.length-1);
		}
	}
	return sString;
}

function GMAP_ISNUM(v)
{
	if((v=='') || isNaN(v))
		return false;
	else
		return true;
}


