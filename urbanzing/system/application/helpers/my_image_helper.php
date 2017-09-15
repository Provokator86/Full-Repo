<?php
function getThumbName($image,$option='big') {
	return preg_replace('/^(.*)\.([^\.]*)$/', '$1-'.$option.'.$2', $image);
}

////
function getThumbNameOther($image,$option='big') {
	return preg_replace('/^(.*?)-117\.([^\.]*)$/', '$1-'. $option .'.$2', $image);
}
////

////
function getThumbNameVersion($image,$option='big') {
	return preg_replace('/^(.*?)-main\.([^\.]*)$/', '$1-'. $option .'.$2', $image);
}
////

 
function resizeImageRatio($img_path, $width, $height) {
	list($wid, $hei, $type, $attr)= getimagesize($img_path);
	$ratio = $wid / $hei;
	if($wid > $width) {
		$t_width = $width;
		$t_height = $width / $ratio;
		if($t_height > $height) {
			$t_height = $height;
			$t_width = $height * $ratio;
		}
	}
	else if($hei > $height) {
		$t_height = $height;
		$t_width = $height * $ratio;
		if($t_width > $width) {
			$t_width = $width;
			$t_hight = $width / $ratio;
		}
	}
	else {
		$t_width = $wid;
		$t_height = $hei;
	}
	return array( (int) ($t_width), (int) ($t_height));
}

function test_file($file) {
	if( file_exists($file) ) {
		if( is_file($file) )
			return true;
		else
			return false;
	}
	else 
		return false;
}

function correct_img_path($text) {
	return preg_replace('/(<img[^>]*?src=")(.*?)(tiny[^"^>]+?"[^>]*>)/', '$1$3', $text);
}

function createImageName($str) {
	return trim( preg_replace('/[^\da-zA-Z\-]+/', '-', $str), '-' );

	//return trim(preg_replace('/[,\.\s\(\)]+/', '-', $str),'-');
}


function getSmallerDimension($img_path, $width, $height, $no_force_resize = false) {
	list($wid, $hei, $type, $attr) = getimagesize($img_path);
	$ratio = $wid / $hei;
	
	if( $height < $width/$ratio ) {
		if($no_force_resize && $wid<=$width) {
			return 'small_image|width';
		}
		else {
			return 'width';
		}
	}
	else if( $width < $height * $ratio ) {
		if($no_force_resize && $hei<=$height) {
			return 'small_image|height';
		}
		else {
			return 'height';
		}
	}
	else {
		return 'auto';
	}
}

/* resizes the image within a rectangle
* @param array $config
* $config['source_image'] -> source image
* $config['thumb_marker'] -> thumb_marker
* $config['width'] -> resize width
* $config['height'] -> resize height
*/
function resize($config) {
	$ci = get_instance();
	$ci->load->library('image_lib');
	$arr['image_library'] = 'gd2';
	$arr['source_image'] = $config['source_image'];
	$arr['create_thumb'] = true;
	$arr['thumb_marker'] = $config['thumb_marker'];
	$arr['maintain_ratio'] = true;
	$arr['width'] = $config['width'];
	$arr['height'] = $config['height'];
	$ci->image_lib->initialize($arr);
	$ci->image_lib->resize();
	$ci->image_lib->clear();
}

/* resizes the image within a rectangle
* @param array $config
* $config['source_image'] -> source image
* $config['thumb_marker'] -> thumb_marker
* $config['width'] -> resize width
* $config['height'] -> resize height
* $config['within_rectangle'] -> true/false, default false, 
*			if true, $config['crop']=false, config['small_image_resize']='inside'/'no_resize'
*
* $config['crop'] -> true/false, default false, decides file will be croped as well
* 			or only used in the background of a div
* $config['crop_from'] -> 'start'/'middle'/'end', default start
* $config['small_image_resize'] -> 'inside'/'bigger'/'no_resize', default bigger
*/
function resize_exact($config) {
	$ci = get_instance();
	$ci->load->library('image_lib');
	$arr['image_library'] = 'gd2';
	$arr['source_image'] = $config['source_image'];
	$arr['create_thumb'] = true;
	$arr['thumb_marker'] = $config['thumb_marker'];
	$arr['maintain_ratio'] = true;

	$smaller_dimension = getSmallerDimension($config['source_image'], $config['width'], $config['height'], true);

	if( !isset($config['small_image_resize']) || !in_array($config['small_image_resize'], array('inside', 'bigger', 'no_resize')) ) {
		$config['small_image_resize'] = 'bigger';
	}

	if( isset($config['within_rectangle']) && $config['within_rectangle'] ) {

		$arr['width'] = $config['width'];
		$arr['height'] = $config['height'];
		$arr['maintain_ratio'] = true;

		if( $config['small_image_resize'] == 'no_resize' ) {
			list($wid_original, $hei_original) = getimagesize($config['source_image']);
			if( $wid_original < $config['width'] && $hei_original < $config['height'] ) {
				$arr['width'] = $wid_original;
				$arr['height'] = $hei_original;
			}
		}
		
		$ci->image_lib->initialize($arr);
		$ci->image_lib->resize();
		return;
	}

	if( strstr($smaller_dimension, 'small_image') ) {
		if( $config['small_image_resize'] == 'inside' ) {
			$arr['width'] = $config['width'];
			$arr['height'] = $config['height'];
			$arr['master_dim'] = 'auto';
		}
		else if( $config['small_image_resize'] == 'bigger' ) {
			$arr['width'] = $config['width'];
			$arr['height'] = $config['height'];
			$arr['master_dim'] = substr($smaller_dimension, 12);
		}
		else if( $config['small_image_resize'] == 'no_resize' ) {
			list($wid_original, $hei_original) = getimagesize($config['source_image']);
			$arr['width'] = $wid_original;
			$arr['height'] = $hei_original;
		}
	}
	else {
		$arr['width'] = $config['width'];
		$arr['height'] = $config['height'];
		$arr['master_dim'] = $smaller_dimension;
	}

// 	dump($config);
// 	dump($arr);

	$ci->image_lib->initialize($arr);
	$ci->image_lib->resize();

	if( isset($config['crop']) && $config['crop'] ) {

		/* small image with option $config['small_image_resize'] = 'inside' should not cropped;
		otherwise it will be padded with black background 
		*/
		if( !strstr($smaller_dimension, 'small_image') || $config['small_image_resize'] != 'inside' ) {
			$image_now = getThumbName($config['source_image'], substr($config['thumb_marker'], 1));
	
			$x_axis = 0;
			$y_axis = 0;
	
			if( isset($config['crop_from']) && $config['crop_from'] == 'start' ) {
				$x_axis = 0;
				$y_axis = 0;
			}
	
			if( isset($config['crop_from']) && $config['crop_from'] == 'middle' ) {
				list($wid, $hei) = getimagesize($image_now);
	
				if( $smaller_dimension == 'width' || substr($smaller_dimension, 12) == 'width' ) {
					$x_axis = 0;
					$y_axis = abs( ($hei - $config['height']) ) / 2;
				}
				else if( $smaller_dimension == 'height' || substr($smaller_dimension, 12) == 'height' ) {
					$x_axis = abs( ($wid - $config['width']) ) / 2;
					$y_axis = 0;
				}
	// 			else if( strstr($smaller_dimension, 'small_image') ) {
	// 				echo 'small';
	// 				$x_axis = 0;
	// 				$y_axis = 0;
	// 			}
			}
	
			if( isset($config['crop_from']) && $config['crop_from'] == 'end' ) {
				list($wid, $hei) = getimagesize($image_now);
	
				if($smaller_dimension == 'width' || substr($smaller_dimension, 12) == 'width' ) {
					$y_axis = abs( $hei - $config['height'] );
					$x_axis = 0;
				}
				if($smaller_dimension == 'height' || substr($smaller_dimension, 12) == 'height' ) {
					$y_axis = 0;
					$x_axis = abs( $wid - $config['width'] );
				}
			}
			
			//echo $config['source_image'];
			$arr['source_image'] = $image_now;
			$arr['create_thumb'] = false;
			$arr['thumb_marker'] = $config['thumb_marker'];
			$arr['maintain_ratio'] = FALSE;
			$arr['x_axis'] = $x_axis;
			$arr['y_axis'] = $y_axis;
			//$arr['width'] = $config['width'];
			//$arr['height'] = $config['height'];
			
			$ci->image_lib->initialize($arr);
			$ci->image_lib->crop();
		}
	}

	$ci->image_lib->clear();
}

function test_image($config) {
	$ci = get_instance();
	$ci->load->library('image_lib');
	$arr['image_library'] = 'gd2';
	$arr['source_image'] = $config['source_image'];
	$arr['maintain_ratio'] = TRUE;
	$arr['width'] = 250;
	$arr['height'] = 250;
	
	$ci->image_lib->initialize($arr);
	$ci->image_lib->resize();
	
	$arr['image_library'] = 'gd2';
	$arr['source_image'] = $config['source_image'];
	$arr['create_thumb'] = true;
	$arr['maintain_ratio'] = FALSE;
	$arr['width'] = 250;
	$arr['height'] = 250;
	
	$ci->image_lib->initialize($arr);
	$ci->image_lib->crop();
}





