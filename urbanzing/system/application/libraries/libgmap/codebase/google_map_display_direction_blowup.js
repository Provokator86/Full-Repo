
		function gmap_display_direction_step_blowup(i,j,step,show_map_blowup,show_map_panorama)
		{
			if(show_map_blowup){}
			else show_map_blowup=false;
			
			if(show_map_panorama){}
			else show_map_panorama=false;
			
			GMAP_DISPLAY_DIRECTION_STEP_BLOWUP(i,j,step,show_map_blowup,show_map_panorama);
		}		

		var GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_prev_id=null;
		var GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_user_call_on_process=false;
		function GMAP_DISPLAY_DIRECTION_STEP_BLOWUP(i,j,step,show_map_blowup,show_map_panorama)
		{
			//alert(i+','+j+','+step)
			
			if(show_map_blowup){}
			else show_map_blowup=false;
			
			if(show_map_panorama){}
			else show_map_panorama=false;
			
			if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
			
			GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_user_call_on_process=true;

			try{
				
				var id='gmap_display_direction_step_blowup_list_'+i+'_'+j+'_'+step;
				var prev_id=GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_prev_id;
				GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_prev_id=id;
				//alert('id='+id)
				var obj=document.getElementById(id);
				var prev_obj=(prev_id==null)?null:document.getElementById(prev_id);
				try{if(prev_obj!=null) prev_obj.style.background='#ffffff';}catch(e){}
				obj.style.background='#eeeeee';	
			}catch(e){}


			try{
				var polyline_steps=GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps;
				if((step>=0)&&(step<polyline_steps.length))
				{
					if(!GMAP_DISPLAY_DIRECTION_STEP_CHECK_PANORAMA_VIEW(i,j,step))
					{
						if(show_map_panorama)
						{
							GMAP_DISPLAY_DIRECTION_STEP_BLOWUP(i,j,step);
							return;
						}
					}
					
					if(show_map_panorama)
					{
						// if has opened panorama view fetch prev and next panorama_view_available status
						GMAP_DISPLAY_DIRECTION_STEP_CHECK_PANORAMA_VIEW(i,j,step-1);
						GMAP_DISPLAY_DIRECTION_STEP_CHECK_PANORAMA_VIEW(i,j,step+1);
					}
					
					var html = '<b>'+(step+1)+'.</b> '+polyline_steps[step].getDescriptionHtml();
					var latlng = polyline_steps[step].getLatLng();
					var html_prev_step="";
					var html_step_sep='';
					var html_next_step="";
					var show_map_panorama_text=show_map_panorama?'true':'false';
					if(step>0)
						html_prev_step='<a href="javascript:void(0)" onclick="GMAP_DISPLAY_DIRECTION_STEP_BLOWUP('+i+','+j+','+(step-1)+',false,'+show_map_panorama_text+')" style="color:blue;">Prev Step</a>';
					else
						html_prev_step='<span style="color:silver;">Prev Step</span>';
					if(step<polyline_steps.length-1)
						html_next_step='<a href="javascript:void(0)" onclick="GMAP_DISPLAY_DIRECTION_STEP_BLOWUP('+i+','+j+','+(step+1)+',false,'+show_map_panorama_text+')" style="color:blue;">Next Step</a>';
					else
						html_next_step='<span style="color:silver;">Next Step</span>';
					if((html_prev_step!="") && (html_next_step!=""))
						html_step_sep=' - ';
					
					var html_step = html_prev_step+html_step_sep+html_next_step;
					if(html_step!="")
					{
						html='Jump to: '+html_step+'<br>'+html;
					}

					if(!show_map_blowup)
					{
						
						if(!show_map_panorama)
						{
							html+='<br>'+'<a href="javascript:void(0)" onclick="GMAP_DISPLAY_DIRECTION_STEP_BLOWUP('+i+','+j+','+step+',true)" style="color:blue;">Zoom Map</a>';
							html+='<span id="gmap_show_map_panorama_control_'+i+'_'+j+'_'+step+'" style="visibility:hidden;">';
							html+='&nbsp;&nbsp;'+'<a href="javascript:void(0)" onclick="GMAP_DISPLAY_DIRECTION_STEP_BLOWUP('+i+','+j+','+step+',false,true)" style="color:blue;">Street Panorama View</a>';
							html+='</span>';
						}
						else
						{
							var width=gmap_width;
							var height=gmap_height;
											
							width=width.toLowerCase().split('px');width=width[0];width=Math.round(width*2/3)+'px';
							height=height.toLowerCase().split('px');height=height[0];height=Math.round(height*1/2)+'px';
							html+='<br><div id="'+gmap_id+'_panorama_'+i+'_'+j+'_'+step+'" style="width:'+width+'; height:'+height+';"></div>';
						}
					}

					
					if(show_map_blowup)
					{
						var on_close_fn=function(){
											if(!GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_user_call_on_process)
											GMAP_DISPLAY_DIRECTION_STEP_BLOWUP(i,j,step);
										}
						gmap.showMapBlowup(latlng,{onCloseFn:on_close_fn});
					}
					else
					{
						if(show_map_panorama)
						{
							var on_open_fn=function(){
												
													var panorama = document.getElementById(gmap_id+'_panorama_'+i+'_'+j+'_'+step);
													
													if(panorama && (panorama!=null))
													{
														var myPano = new GStreetviewPanorama(panorama);
														
														GEvent.addListener(myPano, "error", 
																			function (errorCode) {
																			  if (errorCode == (FLASH_UNAVAILABLE=603)) {
																				alert("Error: Flash doesn't appear to be supported by your browser");
																				return;
																			  }
																			  else if (errorCode == (NO_NEARBY_PANO=600)) {
																				//alert("Street Panorama View not available");
																				panorama.innerHTML="Street panorama view not available";
																				return;
																			  }
																			}
														);  
														myPano.setLocationAndPOV(latlng);
													}
											}
							var id='GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_'+gmap_id;
							html='<span id="'+id+'">'+html+'<span>';
							
							var on_close_fn=function(){
											GMAP_GARBAGE_COLLECTOR_PURGE(id);
											if(!GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_user_call_on_process)
											GMAP_DISPLAY_DIRECTION_STEP_BLOWUP(i,j,step);
										}
							gmap.openInfoWindowHtml(latlng, html,{onOpenFn:on_open_fn,onCloseFn:on_close_fn});
						}
						else
						{
							var id='GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_'+gmap_id;
							html='<span id="'+id+'">'+html+'<span>';
							gmap.openInfoWindowHtml(latlng, html,{onCloseFn:function(){GMAP_GARBAGE_COLLECTOR_PURGE(id)}});
							GMAP_DISPLAY_DIRECTION_STEP_SHOW_PANORAMA_CONTROL(i,j,step);
						}
					}
				}
			}catch(e){}
			
			GMAP_DISPLAY_DIRECTION_STEP_BLOWUP_user_call_on_process=false;
		}
