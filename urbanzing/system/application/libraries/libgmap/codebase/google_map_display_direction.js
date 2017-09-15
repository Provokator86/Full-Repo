		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_DISPLAY_ALL_DIRECTION()
		{
			GMAP_DISPLAY_DIRECTION_direction = new Array();
			for(var i=0;i<map_address.length;i++)
			{
				for(var j=i+1;j<map_address.length;j++)
					GMAP_DISPLAY_DIRECTION(i,j);
			}
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var GMAP_DISPLAY_DIRECTION_direction = new Array();
		function GMAP_DISPLAY_DIRECTION(i,j)
		{
			if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
			
			GMAP_DISPLAY_DIRECTION_direction[i][j].polyline=null;
			var panel = document.getElementById(gmap_id+'_panel');
			var directions = new GDirections(null,panel);
			
			GEvent.addListener	(	directions,
									"load", 
									function() 
									{
										//alert('load');
										if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
										var polyline = directions.getPolyline();
										polyline.setStrokeStyle({color:GMAP_DISPLAY_DIRECTION_COLOR(i,j)});
										gmap.addOverlay(polyline);
										GMAP_DISPLAY_DIRECTION_direction[i][j].polyline=polyline;
										var polyline_steps=new Array();
										if(directions.getNumRoutes()>0)
										{
											var route=directions.getRoute(0);
											var count_step=route.getNumSteps();
											for(var step=0;step<count_step;step++)
											polyline_steps[polyline_steps.length]=route.getStep(step);
										}
										GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps=polyline_steps;
									}
								); 
			GEvent.addListener	(	directions,
									"addoverlay", 
									function() 
									{
										if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
										if(GMAP_DISPLAY_DIRECTION_direction[i][j].polyline!=null)
										{
											var html=panel.innerHTML;
											panel.innerHTML="";
											//alert(panel.innerHTML);
											//alert(html)
											
											var cap_type=(html.indexOf('<TR ')>-1)&&(html.indexOf('<DIV ')>-1)&&(html.indexOf('<TD ')>-1);
											var org_regx=cap_type?'<TR ':'<tr ';
											var org_replace_prefix=cap_type?'<tr ':'<TR ';
											
											var org_replace=org_replace_prefix+' ZZZZZZZZZZ ';
											eval("html=html.replace(/"+org_regx+"/,org_replace);"); // skiping first tr
											
											var polyline_steps = GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps;
											var count_step=polyline_steps.length;
											for(var step=0;step<count_step;step++)
											{
												try{
													//var si=step+1;
													/*
													// href="javascript:void(0)" jscontent="($index + 1)">5<
													// href="javascript:void(0)" jscontent="($index + 1)" onclick="alert(5)">5<
													var org='href="javascript:void(0)" jscontent="($index + 1)">'+si+'<';
													var org_replace='href="javascript:void(0)" jscontent="($index + 1)" onclick="GMAP_DISPLAY_DIRECTION_STEP_BLOWUP('+i+','+j+','+step+')">'+si+'<';
													var org_regx='href="javascript:void\\(0\\)" jscontent="\\(\\$index \\+ 1\\)">'+si+'<';
													eval("html=html.replace(/"+org_regx+"/,org_replace);");
													//html=html.replace(/jscontent="\(\$index \+ 1\)">1</,'jscontent="($index + 1)" onclick="alert(1)">1<');
													*/
													
													/*
													// >5</a>.</td><td
													// onclick="alert(5)">5</a>.</td><td
													var org='>'+si+'<';
													var org_replace=' onclick="GMAP_DISPLAY_DIRECTION_STEP_BLOWUP('+i+','+j+','+step+')">'+si+'<';
													var org_regx='>'+si+'<';
													eval("html=html.replace(/"+org_regx+"/,org_replace);");
													//html=html.replace(/jscontent="\(\$index \+ 1\)">1</,'jscontent="($index + 1)" onclick="alert(1)">1<');
													*/
		
													var org_replace=org_replace_prefix+' onclick="gmap_display_direction_step_blowup('+i+','+j+','+step+')" id="gmap_display_direction_step_blowup_list_'+i+'_'+j+'_'+step+'" ';
													eval("html=html.replace(/"+org_regx+"/,org_replace);"); // replacing each tr to TR with index.
													
												}catch(e){}
											}
											//alert(html)
											GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_html=html;
											GMAP_DISPLAY_DIRECTION_ATTACH_ONCLICK_EVENT(i,j);
										}
									}
								); 
			
			GEvent.addListener	(	directions,
									"error", 
									function() 
									{
										//alert('error');
										if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
										//alert('error:'+i+' '+j+' '+directions.getStatus())
										if(GMAP_DISPLAY_DIRECTION_direction[i][j].error_count){}
										else GMAP_DISPLAY_DIRECTION_direction[i][j].error_count=0;
										if(GMAP_DISPLAY_DIRECTION_direction[i][j].error_count<2)
										{
											GMAP_DISPLAY_DIRECTION_direction[i][j].error_count++;
											GMAP_DISPLAY_DIRECTION(i,j);
										}
									}
								); 
			
			//alert(map_address[i].address+" to "+map_address[j].address)
			directions.load(
								map_address[i].address+" to "+map_address[j].address,
								directions_options = {preserveViewport:true,getSteps:true,getPolyline:true}
							);
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_DISPLAY_DIRECTION_ATTACH_ONCLICK_EVENT(i,j)
		{
			if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
			
			//alert(map_address[i].org_i+','+map_address[j].org_i);
			if(typeof gmap_direction_loaded == 'function')
			{
				gmap_direction_loaded(map_address[i].org_i,map_address[j].org_i,GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_html);
			}
			
			if(typeof gmap_direction_click_event != 'function') return;
			
			GEvent.addListener	(	GMAP_DISPLAY_DIRECTION_direction[i][j].polyline,
									"click", 
									function(latlng) 
									{
										var html = GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_html;
										var ret = gmap_direction_click_event(html);
										
										if(ret)
										{
											var width=gmap_width;
											var height=gmap_height;
											
											width=width.toLowerCase().split('px');width=width[0];width=Math.round(width*2/3)+'px';
											height=height.toLowerCase().split('px');height=height[0];height=Math.round(height*1/2)+'px';
											var title=map_address[i].name+" to "+map_address[j].name;
											var id='GMAP_DISPLAY_DIRECTION_ATTACH_ONCLICK_EVENT_'+gmap_id;
											html='<span id="'+id+'">'+'<b>'+title+'</b><div style="text-align:left;padding:5px;overflow:auto;width:'+width+';height:'+height+';>'+html+'</div><span>';
											
											html=html.replace(/gmap_display_direction_step_blowup_list_/g,'gmap_display_direction_step_blowup_list_ZZskipZZ_');
											//alert(html)											
											gmap.openInfoWindowHtml(latlng, html,{onCloseFn:function(){GMAP_GARBAGE_COLLECTOR_PURGE(id)}});
										}
									}
								); 
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_DISPLAY_DIRECTION_VALID(i,j)
		{
			if(!GMAP_VALID_MAPADDR_INDICES(i,j))return;
			
			if(map_address[i].direction_required || map_address[j].direction_required){}
			else return false;
		
			if(typeof GMAP_DISPLAY_DIRECTION_direction[i] != 'object') GMAP_DISPLAY_DIRECTION_direction[i] = new Array();
			if(typeof GMAP_DISPLAY_DIRECTION_direction[i][j] != 'object') GMAP_DISPLAY_DIRECTION_direction[i][j] = new Object();
			
			
			if(GMAP_VALID_MAPADDR_INDICES(i,j) && (typeof GMAP_DISPLAY_DIRECTION_direction[i][j].time_stamp == 'undefined'))GMAP_DISPLAY_DIRECTION_direction[i][j].time_stamp=map_address[i].time_stamp;
			else if(!GMAP_VALID_MAPADDR_INDICES(i,j) || (GMAP_DISPLAY_DIRECTION_direction[i][j].time_stamp!=map_address[i].time_stamp)) false;
			
			return true;
		}
		function GMAP_VALID_MAPADDR_INDICES(i,j)
		{
			return (i<map_address.length)&&(j<map_address.length);
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_DISPLAY_DIRECTION_COLOR(i,j)
		{
			var colors = new Array(14)
			colors[0]="0"; colors[1]="1"; colors[2]="2"; colors[3]="3"; colors[4]="4";
			colors[5]="5"; colors[5]="6"; colors[6]="7"; colors[7]="8"; colors[8]="9";
			colors[9]="a"; colors[10]="b"; colors[11]="c"; colors[12]="d"; colors[13]="e";
			colors[14]="f"
			
			var digit = new Array();
			var color="#0000";
			for (i=0;i<2;i++)
			{
				digit[i]=colors[Math.round(Math.random()*14)];
				color = color+digit[i]
			}
			return color;
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////

