<?
/*

In header include libgmap3/libgmap3.js

Before you include the define
$LIB_GMAP_KEY = "AIzaSyAb9wmG1-VnHRJ-IDj4DTjFflSHsgfbadA";
$LIB_GMAP_SENSOR = true;

After you include this file call LIB_GMAP_INIT() as follows

$arr_param = array();
$arr_param['id'] = "test_id";
$arr_param['width']="900px";
$arr_param['height']="500px";
$arr_param['create_canvas_on_init']=true;
LIB_GMAP_INIT($arr_param);

*/

$LIB_GMAP_CANVAS_ID_PREFIX="gmap3_canvas_";


$LIB_GMAP_INIT_CALLED_ONCE = false;
function LIB_GMAP_INIT($arr_param)
{
	global 
		$LIB_GMAP_INIT_CALLED_ONCE,
		$LIB_GMAP_KEY,
		$LIB_GMAP_SENSOR
	;

	if(!$LIB_GMAP_KEY)
	{
		echo '$LIB_GMAP_KEY not defined';
		return;
	}
	
	$LIB_GMAP_SENSOR=(($LIB_GMAP_SENSOR === TRUE) || (strtolower($LIB_GMAP_SENSOR) === "true"))?"true":"false";
	
	if(!$LIB_GMAP_INIT_CALLED_ONCE)
	{
		?>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=<?=$LIB_GMAP_KEY?>&sensor=<?=$LIB_GMAP_SENSOR?>"></script>
		<?
	}
	$LIB_GMAP_INIT_CALLED_ONCE =true;
	
	
	$id = $arr_param['id'];
	$canvas_id = LIB_GMAP_GET_CANVAS_ID($id);
	$width = $arr_param['width'];
	$height = $arr_param['height'];
	$map_type_id=$arr_param['map_type_id'];
	$map_type_control = $arr_param['map_type_control'];
	$zoom_control = $arr_param['zoom_control'];
	$map_address = $arr_param['map_address'];
	$create_canvas_on_init=$arr_param['create_canvas_on_init'];
	
	$map_type_control=(($map_type_control === TRUE) || (strtolower($map_type_control) === "true"))?'true':'false';
	$create_canvas_on_init=(($create_canvas_on_init === TRUE) || (strtolower($create_canvas_on_init) === "true"))
	?>
	<? if($create_canvas_on_init) { ?>
	<div id="<?=$canvas_id?>" style="width:<?=$width?>; height:<?=$height?>"></div>
	<script type="text/javascript">
		LIB_GMAP_LOAD_CANVAS("<?=$id?>","<?=$map_type_id?>",<?=$map_type_control?>,"<?=$zoom_control?>");
		var arr_marker = <?=json_encode($map_address)?>;
		LIB_GMAP_MARKER_ADD_ARR("<?=$id?>",arr_marker);
		//alert('<?php echo $arr_param['icon']; ?>');
	</script>
	<? } ?>
	<?

}

function LIB_GMAP_GET_CANVAS_ID($id)
{
	global $LIB_GMAP_CANVAS_ID_PREFIX;
	return "gmap3_canvas_".$id;
}
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


?>
<script type="text/javascript">
function LIB_GMAP_GET_CANVAS_ID(id)
{
	return "<?=$LIB_GMAP_CANVAS_ID_PREFIX?>"+id;
}
function GMAP_IS_IE_BROWSER()
{
	return <?=(GMAP_IS_IE_BROWSER()?'true':'false')?>;
}

var GMAP_DOC_LOADED = false;
function GMAP_ON_DOC_LOAD()
{
	GMAP_DOC_LOADED = true;
}
if(GMAP_IS_IE_BROWSER())
	document.body.onload=GMAP_ON_DOC_LOAD;
else
	this.onload=GMAP_ON_DOC_LOAD;
</script>
<?

?>