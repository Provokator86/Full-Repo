
		function GMAP_DISPLAY_DIRECTION_STEP_SHOW_PANORAMA_CONTROL(i,j,step)
		{
			if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return;
			try{
				var polyline_steps=GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps;
				if((typeof polyline_steps[step].panorama_view_available != 'undefined')&&(polyline_steps[step].panorama_view_available == true))
				{
					var id='gmap_show_map_panorama_control_'+i+'_'+j+'_'+step;
					var obj=document.getElementById(id);
					if(obj!=null)
					{
						obj.style.visibility='visible';
					}
				}
			}catch(e){}
		}
		function GMAP_DISPLAY_DIRECTION_STEP_CHECK_PANORAMA_VIEW(i,j,step)
		{
			if(!GMAP_DISPLAY_DIRECTION_VALID(i,j))return false;
			
			try{
				var polyline_steps=GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps;
				
				if(polyline_steps.length<1) return false;
				
				/*
				if(step){}
				else
				{
					var count_step=polyline_steps.length;
					for(var step=0;step<count_step;step++)
					{
						GMAP_DISPLAY_DIRECTION_STEP_CHECK_PANORAMA_VIEW(i,j,step);
					}
					return ;
				}
				
				alert(i+','+j+','+step)
				*/
				if((step<0) || (step>(polyline_steps.length-1))) return false;
				if(typeof polyline_steps[step].panorama_view_available == 'undefined')
				{
					// using google GStep Object To Store Our Data
					polyline_steps[step].panorama_view_available=false;
					var latlng = polyline_steps[step].getLatLng();
					var strt_vu_client = new GStreetviewClient();
					strt_vu_client.getNearestPanoramaLatLng(latlng,  
															function(nearst_latlng)
															{
																//alert(latlng.lng())
																if (nearst_latlng != null)
																{
																	//if((nearst_latlng.lat()==latlng.lat())&&(nearst_latlng.lng()==latlng.lng()))
																	//{
																		GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps[step].panorama_view_available=true;
																		GMAP_DISPLAY_DIRECTION_STEP_SHOW_PANORAMA_CONTROL(i,j,step);
																	//}
																	//else
																	//{
																	//	alert((nearst_latlng.lat()-latlng.lat())+','+(nearst_latlng.lng()-latlng.lng()))
																	//}
																	//alert(GMAP_DISPLAY_DIRECTION_direction[i][j].polyline_steps[step].panorama_view_available)
																} 
															}
					);
				}
				
				
			}catch(e){}
			return polyline_steps[step].panorama_view_available;
		}
