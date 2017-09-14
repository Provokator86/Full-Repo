 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=<?php echo MAP_KEY;?>"
      type="text/javascript"></script>

<script type="text/javascript">

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        //var center = new GLatLng(48.89364, 2.33739);
        var lat_ = '<?php echo $posted['location_latttude']?>';
        var lng_ = '<?php echo $posted['location_longitude']?>';
        if(lat_ != '' || lng_ != '')
        {
            var center = new GLatLng(lat_,    lng_);
            map.setCenter(center, 14);
        }
        else
        {
            var center = new GLatLng(23.63450,    -102.55278); // For Mex
            map.setCenter(center, 5);
        }
        //var center = new GLatLng(22.57265, 88.36389 ); // For Kolkata
        
        //map.setCenter(center, 14);
        geocoder = new GClientGeocoder();
        var marker = new GMarker(center, {draggable: true});  
        map.addOverlay(marker);
        document.getElementById("lat").value = center.lat().toFixed(5);
        document.getElementById("lng").value = center.lng().toFixed(5);
        document.getElementById("location_on_map").value = center.lat().toFixed(5)+', '+center.lng().toFixed(5);
        
        GEvent.addListener(marker, "dragend", function() {
            var point = marker.getPoint();
            map.panTo(point);
            document.getElementById("lat").value = point.lat().toFixed(5);
            document.getElementById("lng").value = point.lng().toFixed(5);
        
        });


        GEvent.addListener(map, "moveend", function() {
            map.clearOverlays();
            var center = map.getCenter();
            var marker = new GMarker(center, {draggable: true});
            map.addOverlay(marker);
            document.getElementById("lat").value = center.lat().toFixed(5);
            document.getElementById("lng").value = center.lng().toFixed(5);
            
            GEvent.addListener(marker, "dragend", function() {
                var point =marker.getPoint();
                map.panTo(point);
                document.getElementById("lat").value = point.lat().toFixed(5);
                document.getElementById("lng").value = point.lng().toFixed(5);
                document.getElementById("location_on_map").value = point.lat().toFixed(5)+', '+point.lng().toFixed(5);
            });
        
        });

      }
    }

    function showAddress(address) {
        var map = new GMap2(document.getElementById("map"));
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        if (geocoder) {
            geocoder.getLatLng(
            address,
            function(point) {
                if (!point) {
                    alert(address + " not found");
                } else {
                    document.getElementById("lat").value = point.lat().toFixed(5);
                    document.getElementById("lng").value = point.lng().toFixed(5);
                    document.getElementById("location_on_map").value = point.lat().toFixed(5)+', '+point.lng().toFixed(5);
                    map.clearOverlays()
                    map.setCenter(point, 14);
                    var marker = new GMarker(point, {draggable: true});  
                    map.addOverlay(marker);
                    
                    GEvent.addListener(marker, "dragend", function() {
                        var pt = marker.getPoint();
                        map.panTo(pt);
                        document.getElementById("lat").value = pt.lat().toFixed(5);
                        document.getElementById("lng").value = pt.lng().toFixed(5);
                    });
                    
                    
                    GEvent.addListener(map, "moveend", function() {
                        map.clearOverlays();
                        var center = map.getCenter();
                        var marker = new GMarker(center, {draggable: true});
                        map.addOverlay(marker);
                        document.getElementById("lat").value = center.lat().toFixed(5);
                        document.getElementById("lng").value = center.lng().toFixed(5);
                        document.getElementById("location_on_map").value = center.lat().toFixed(5)+', '+center.lng().toFixed(5);
                        GEvent.addListener(marker, "dragend", function() {
                            var pt = marker.getPoint();
                            map.panTo(pt);
                            document.getElementById("lat").value = pt.lat().toFixed(5);
                            document.getElementById("lng").value = pt.lng().toFixed(5);
                            document.getElementById("location_on_map").value = point.lat().toFixed(5)+', '+point.lng().toFixed(5);
                        });
                    
                    });
                }
            });
        }
    }
    
   $(document).ready(function(){
       
       $('#locate').click(function(){
        var zip_id         = $.trim($('#txt_zip').val());
        var city_id     = $.trim($('#txt_city').val());
        var state_id     = $.trim($("#txt_state").val());
        var country     = $.trim($("#txt_country").val());
        var address     = $.trim($("#txt_address").val());
        
        if(zip_id !='' && city_id !='')
        {
            data_str = 'zip_id='+zip_id+'&city_id='+city_id;
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url()?>common_helper_controller/get_details_address/',
                data: data_str,
                dataType:'HTML',
                success: function(data) {
                    if(data !='failed')
                    {
                        full_address = address !='' ? address+', ' : '';
                        full_address += data; //+' '+country;
                        showAddress(full_address);
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $("#location_list_pagination").html('<?php echo addslashes(t("Timeout contacting server"))?>..');
                }
            });
        }
        else
        {
            $("#div_err").html('<div id="err_msg" class="error_massage"><?php echo addslashes(t(" Please enter all the address completly first."))?></div>').show("slow");
        }
        
    });
    
   }); 
    

</script>

    