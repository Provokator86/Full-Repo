
		var GMAP_GET_LATLNG_RETURN="";
		function GMAP_GET_LATLNG(address,call_back,map_depth)
		{
				if(typeof call_back !='function') return;
		
				GMAP_GET_LATLNG_RETURN="";
				if(!map_depth)map_depth=15;
				gmap_geocoder.getLatLng(	address,
											function(point) 
											{
													if (!point) 
													{
															//alert(address + " not found");
															if(address.length>0)
															{
																address=address.split(', ');
																var new_address='';
																sep='';
																for(var i=1;i<address.length;i++)
																{
																	new_address+=sep+address[i];
																	sep=', ';
																}
																if(new_address!='')
																{
																	//alert(new_address)
																	if(map_depth>2)
																		map_depth-=2;
																	GMAP_GET_LATLNG(new_address,call_back,map_depth);
																}
																else
																{
																	call_back(GMAP_GET_LATLNG_RETURN=false);
																}
															}
													} 
													else 
													{
															var result = new Object();
															result.point=point;
															result.map_depth=map_depth;
															if(map_depth>10)
																result.found=true;
															else
																result.found=false;
															call_back(GMAP_GET_LATLNG_RETURN=result);
													}
											}
									);
		}
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
