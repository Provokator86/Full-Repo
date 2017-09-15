<?
	/*
	///////////////////////////////////////////////////////////////////////////
	PHP API
	----------------------
	Before you include this Google MAP set following PHP variables
	$map_address=array();
	$map_address[]=array("30.00, 111.00","http://www.google.com","My test location title here");  // lat, lng
	$map_address[]=array("Preidency College, Kolkata","My College Name","My college description here");
	$map_address[]=array("Baruipur","My College Name","My college description here","http://labs.google.com/ridefinder/images/mm_20_red.png");
	$map_address[]=array("DIRECTION:700 Memorial Dr, Cambridge, MA 02139","The National Trust","For any enquiries please email us in the first instance.");
	$map_address[]=array("500 Memorial Dr, Cambridge, MA 02139","The International Trust","For any enquiries please email us in the first instance.");
	$map_address[]=array("4 Yawkey Way, Boston, MA 02215","Campsite Hexham Racecourse Caravan","Hexham Racecourse takes full advantage of a natural amphitheatre of sloping grass below the stands to provide superb viewing of the racecourse as well as the magnificent surrounding countryside.");

		NOTE:	1st param				: Address OR "lat, lng";;; If address starts with 'DIRECTION:' then from this node direction will be plotted to all other nodes
				(2nd param, 3rd param)	: (http://link, tooltip title) OR (name of overlay that pops up on click, html description of overlay that pops up on click)
				4th param				: optional image icon url with optional size prefix as img_url////////given_width////////given_height
		
	
	$gmap_base_url="maps.google.com"; // [OPTIONAL]
	$gmap_key="ABQIAAAA78slLnB6PVBg6lcPb6r4nhQKDicoquDv5ksEBlo9ov0YpyICrhRVIaWHt3ZYCLOZJgKfw8nk-EAG8A";
	$gmap_width="800px";
	$gmap_height="400px";
	$gmap_controls=array('GLargeMapControl','GScaleControl','GMapTypeControl','GOverviewMapControl');
	//$gmap_do_not_load_onload=true; // set this to true if you do not want to load the map on page load but would like to activate it through this javascript call - gmap_set_address(null); or gmap_set_address(address);
	
	///////////////////////////////////////////////////////////////////////////
	Javascript API
	-----------------------
	After including this file you can use following API
	1. Following call will show gmap with new address
		var address = new Array();
		address[address.length]=new Array("New Delhi","My test Name","My text description here");
		address[address.length]=new Array("New York","My test Name","My text description here","http://labs.google.com/ridefinder/images/mm_20_red.png");
		gmap_set_address(address);

	
	2. If following function is defined will be called on click
		function gmap_click_event(lat,lng)
		{
			alert(lat+','+lng)
			return false; // return true; if you want popup
		}
	3. If following function is defined will be called on click
		function gmap_marker_click_event(url)
		{
			alert(url);
		}
	4. If following function is defined will be called on click
		function gmap_direction_click_event(html)
		{
			alert(html);
			return false; // return true; if you want popup
		}
	5. Use following function for garbage collection
		gmap_garbage_collector_purge(id_or_object);
		e.g.
		function gmap_direction_click_event(html)
		{
			gmap_garbage_collector_purge('my_direction_panel');
			document.getElementById('my_direction_panel').innerHTML=html;
			return false;
		}
	6. If following function is defined will be called on successful direction load
	   function gmap_direction_loaded(i,j,html)
	   {
	   		// here i is start address index
			//		j in end address index
			//alert(i+','+j+'='+html);
			gmap_garbage_collector_purge('my_direction_panel');
			document.getElementById('my_direction_panel').innerHTML=html;
	   }
		
	///////////////////////////////////////////////////////////////////////////
	*/
?>

<?
$gmap_id="gmap_465289345";
$gmap_controls_valid=array('GLargeMapControl','GSmallMapControl','GSmallZoomControl','GScaleControl','GMapTypeControl','GOverviewMapControl');
function GMAP_IS_IE_BROWSER()
{
	$useragent = $_SERVER['HTTP_USER_AGENT'];

	if (preg_match('|MSIE ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'IE';
	} elseif (preg_match( '|Opera ([0-9].[0-9]{1,2})|',$useragent,$matched)) {
		$browser_version=$matched[1];
		$browser = 'Opera';
	} elseif(preg_match('|Firefox/([0-9\.]+)|',$useragent,$matched)) {
			$browser_version=$matched[1];
			$browser = 'Firefox';
	} elseif(preg_match('|Safari/([0-9\.]+)|',$useragent,$matched)) {
			$browser_version=$matched[1];
			$browser = 'Safari';
	} else {
			// browser not recognized!
		$browser_version = 0;
		$browser= 'other';
	}
	
	//print "browser: $browser $browser_version";
	return ($browser == 'IE');
}

if(!is_array($map_address))$map_address=array();
else if(count($map_address) && !is_array($map_address[0]))$map_address=array($map_address);

foreach($map_address as $k=>$v)
{
	$map_address[$k][0]=addslashes($map_address[$k][0]);
	$map_address[$k][1]=addslashes(@$map_address[$k][1]);
	$map_address[$k][2]=addslashes(@$map_address[$k][2]);
	$map_address[$k][3]=addslashes(@$map_address[$k][3]);
}

if(!trim($gmap_base_url))
$gmap_base_url="maps.google.com";

$gmap_width=$gmap_width?$gmap_width:"265px";
$gmap_height=$gmap_height?$gmap_height:"129px";
if(!$gmap_controls)$gmap_controls=array();
foreach ($gmap_controls as $key => $gmap_control)
{
	if(!in_array($gmap_control,$gmap_controls_valid))
	unset($gmap_controls[$key]);
}

?>


<div style="padding:0px">
<div id="<?=$gmap_id?>" style="width: <?=$gmap_width?>; height: <?=$gmap_height?>; visibility:hidden;"></div>
<div id="<?=$gmap_id?>_panel" style="width: <?=$gmap_width?>; height: <?=$gmap_height?>; display:none;"></div>
<? /* if(!GMAP_IS_IE_BROWSER()) { ?>
<input type="text" id='to_focus_1111_gmap_<?=$gmap_id?>' readonly style="cursor:default;background:transparent;border:0px black solid;width:0px;height:0px;">
<? } */ ?>
</div>

<? if($gmap_key){ ?>
		<?
			include "codebase/libjchf/lib_js_css_hidden_folder.php";
		?>
		<script language="javascript" src="<?=$GLOBALS[Lib_libJsCssHiddenFolder_self_object]->getUrlToJsLink()?>"></script>
		<script src="http://<?=$gmap_base_url?>/maps?file=api&amp;v=2.x&amp;key=<?=$gmap_key?>" type="text/javascript"></script>
		<script type="text/javascript">
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var gmap_id='<?=$gmap_id?>';
		var gmap_width='<?=$gmap_width?>';
		var gmap_height='<?=$gmap_height?>';
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		var gmap = null;
		var gmap_geocoder = null;
		var map_address = GMAP_INIT_MAP_ADDRESS();
		var gmap_controls = GMAP_INIT_MAP_CONTROLS();
		var gmap_do_not_load_onload = GMAP_DO_NOT_LOAD_ONLOAD();
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		function GMAP_INIT_MAP_ADDRESS() 
		{
			var map_address = new Array();
			<? foreach($map_address as $k=>$v) { ?>
				map_address[map_address.length]= GMAP_GET_ADDRESS_OBJECT("<?=@$map_address[$k][0]?>","<?=@$map_address[$k][1]?>","<?=@$map_address[$k][2]?>","<?=@$map_address[$k][3]?>");
			<? } ?>
			return map_address;
		}
		function GMAP_INIT_MAP_CONTROLS() 
		{
			var gmap_controls = new Array();
			<? foreach($gmap_controls as $k=>$v) { ?>
				gmap_controls[gmap_controls.length]= "<?=$gmap_controls[$k]?>";
			<? } ?>
			return gmap_controls;
		}
		function GMAP_IS_IE_BROWSER()
		{
			return <?=(GMAP_IS_IE_BROWSER()?'true':'false')?>;
		}
		function GMAP_DO_NOT_LOAD_ONLOAD()
		{
			return <?=($gmap_do_not_load_onload?'true':'false')?>;
		}
		GMAP_INIT_TRIGGER_SET_ON_LOAD();
		</script>
<? } ?>