<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
	<script type="text/javascript" src="<?=base_url()?>/js/jquery-latest.js"></script>

    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=<?=$google_map_api_key?>" type="text/javascript"></script>
  </head>
  <body>

			<div id="map" style="width: 400px; height: 246px"></div>
<script>

	  /*  function createMarker(point,html) {
        var marker = new GMarker(point);
        GEvent.addListener(marker, "click", function() {
          marker.openInfoWindowHtml(html);
        });
        return marker;
      }

      // Display the map, with some controls and set the initial location
      var map = new GMap2(document.getElementById("map"));
      map.addControl(new GLargeMapControl());
      map.addControl(new GMapTypeControl());
     // map.setCenter(new GLatLng(43.907787,-79.359741),8);
      map.setCenter(new GLatLng(43.65654,-79.90138),8);


      // Set up three markers with info windows

      var point = new GLatLng(43.65654,-79.90138);
      var marker = createMarker(point,'<div style="width:240px">Some stuff to display in the First Info Window. With a <a href="http://www.econym.demon.co.uk">Link<\/a> to my home page<\/div>')
      map.addOverlay(marker);
	  */


showMap('<?=$address?>,<?=$zipcode?>,<?=$city?>',14,'<?=$item_text_info?>');

var map = null;
var geocoder = null;

function initializeMap() {
  if (GBrowserIsCompatible()) {
 	geocoder = new GClientGeocoder();
	
  }
}

function showMap(address, zoom_level, info_txt) {
  initializeMap();

  if (geocoder) {
 geocoder.getLatLng(
   address,
   function(point) {
  if (!point) {
                          //alert(address + " not found");
     var errHTML = '<div class="gmap_err">Not a valid address.</div>';
     $('#map').html(errHTML);
  } else {

     if (GBrowserIsCompatible()) {
    map = new GMap2(document.getElementById("map"));
     }

     // customizing map-marker...
/*     var Icon = new GIcon();
     Icon.image = "images/golf.png";
     Icon.iconSize = new GSize(32, 37);
     Icon.iconAnchor = new GPoint(32, 37);
     Icon.infoWindowAnchor = new GPoint(32, 0);*/


     map.setCenter(point, zoom_level);
	 map.setUIToDefault();
     var marker = new GMarker(point);
     map.addOverlay(marker);

     var htmlTxt = '<div class="map_info">'+ info_txt +'</div>';
                          marker.openInfoWindowHtml(htmlTxt);
     marker.openInfoWindowHtml(htmlTxt);
	
     // onclick event...
     GEvent.addListener(marker, "click", function() {
      marker.openInfoWindowHtml(htmlTxt);
     });

  }
   }
 );
  }
}

/*	   	   $('#map div:first div:first').css('top','100px');
       $('#map div:first div:first').css('left','125px');*/







	</script>

  </body>

</html>
	