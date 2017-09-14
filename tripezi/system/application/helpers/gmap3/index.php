<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<script type="text/javascript" src="libgmap3/libgmap3.js"></script>
</head>

<body>

<table><tr><td>
<?

$LIB_GMAP_KEY = "AIzaSyAb9wmG1-VnHRJ-IDj4DTjFflSHsgfbadA";
$LIB_GMAP_SENSOR = true;

include "libgmap3/libgmap3.php";

$arr_param = array();
$arr_param['id'] = 'test_id';
$arr_param['width']='900px';
$arr_param['height']='500px';
$arr_param['map_type_id']='ROADMAP'; // 'ROADMAP', 'HYBRID'
$arr_param['map_type_control']=true; // true, false
$arr_param['zoom_control']='LARGE'; // 'SMALL', 'LARGE', ''

$arr_param['map_address']=array();
$arr_param['map_address'][]=array(	'address_or_latlng'=>	"500 Memorial Dr, Cambridge, MA 02139",
									'title'=>				"The International Trust",
									'link_or_html'=>		"For any enquiries please email us in the first instance.",
									'icon'=>				"no_imaged.php?number=19");
									
$arr_param['map_address'][]=array(	'address_or_latlng'=>	"4 Yawkey Way, Boston, MA 02215",
									'title'=>				"Campsite Hexham Racecourse Caravan",
									'link_or_html'=>		"Hexham Racecourse takes full advantage of a natural amphitheatre of sloping grass below the stands to provide superb viewing of the racecourse as well as the magnificent surrounding countryside.");

$arr_param['map_address'][]=array(	'address_or_latlng'=>	"204 Yawkey Way, Boston, MA 02215",
									'title'=>				"204 Campsite Hexham Racecourse Caravan",
									'link_or_html'=>		"http://www.google.com",
									'icon'=>				"icon/pin.png");

$arr_param['create_canvas_on_init']=true;
LIB_GMAP_INIT($arr_param);


?>
<script type="text/javascript">
function gmap_marker_clicked($link,$id,$add_ref_index)
{
	alert($link + ', ' + $id + ', ' + $add_ref_index);
	
	// make synchronous ajax call to fetch data from server and then - 
	//return {title:'',html:''};
}
function gmap_all_marker_loaded($id)
{
	LIB_GMAP_MARKER_SHOW_ALL_RESOLVED_IN_VIEW($id);
	LIB_GMAP_DIRECTION_ADD($id,0,'*');
}
function gmap_marker_address_resolved($lat,$lng,$id,$add_ref_index)
{
	//alert($lat + ', ' + $lng + ', ' + $id + ', ' + $add_ref_index);
}


function gmap_direction_clicked($add_ref_index,$marker_src_add_ref_index,$marker_dst_add_ref_index,$directions_description)
{
	//alert($add_ref_index + ', ' + $marker_src_add_ref_index + ', ' + $marker_dst_add_ref_index + ', ' + $directions_description);
	document.getElementById('directions_description').innerHTML = $directions_description;
}

</script>

</td>
<td id="directions_description">

</td></tr></table>


</body>
</html>
