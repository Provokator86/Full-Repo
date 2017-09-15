<?php
function short_text($txt, $length) {
	if(mb_strlen($txt)>$length) 
	    return preg_replace('/(.*\.)[^\.]*$/', '$1', mb_substr($txt, 0, $length, 'utf-8')).'...';
	else
		return $txt;  
}
function textLimit($string, $length, $replacer = '...')
{
  if(mb_strlen($string,'utf-8') > $length)
  return (preg_match('/^(.*)\W.*$/', mb_substr($string, 0, $length, 'utf-8'), $matches) ? $matches[1] : mb_substr($string, 0, $length, 'utf-8')) . $replacer;
 
  return $string;
} 

function snippet($text,$length=64,$tail="...") {
    $text = trim($text);
    $txtl = mb_strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
} 

function my_substr($txt,$length) {
	if(mb_strlen($txt)>$length) {
		return mb_substr($txt, 0, $length).'...';
	}
	else
		return $txt;
}

function is_int_val($data) {
	if (is_int($data) === true)
		return true;

	elseif (is_string($data) === true && is_numeric($data) === true) {
		return (strpos($data, '.') === false);
	}
	return false;
}

function is_numeric_val($data) {
	return preg_match('/^[\d]*[\.]?[\d]*$/', $data);
}


function sprintf3($str, $vars, $char = '%%') {
	$tmp = array();
	foreach($vars as $k => $v) {
		$tmp[$char . $k . $char] = $v;
	}
	return str_replace(array_keys($tmp), array_values($tmp), $str);
}

function implode_with_quote($glue, $arr) { //like Array(21,suman,hello) converted to "'21', 'suman', 'hello'"
	$csv='';
	for($i=0; $i<count($arr); $i++) {
		$item = trim($arr[$i]);

		if($item!='') {
			if($i!=count($arr)-1)
				$csv .= "'".$item."'".$glue;
			else
				$csv .= "'".$item."'";
		}
	}
	return $csv;
}

function explode_trim($seperator, $str) {
	$arr = explode($seperator, $str);
	$new_arr = array();
	foreach($arr as $key=>$item) {
		$new_arr[$key] = $item;
	}

	return $new_arr;
}

function basic_array($arr) {
	$new_arr = array();
	foreach($arr as $item) {
		$new_arr = array_merge($new_arr, array_values($item));
	}
//print_r($new_arr);
	return array_unique($new_arr);
}

function basic_array_by_field($arr, $field) {
	$new_arr = array();
	foreach($arr as $item) {
		$new_arr[] = $item[$field];
	}

	return array_unique($new_arr);
}


function correct_csv($csv) {
	$csv = trim(preg_replace('/(,[\s]*)(?:[,\s]+)/', '$1', $csv), ',');
	$arr = explode(',', $csv);
	$correct_csv = implode(',', array_unique($arr));
	return $correct_csv;
}

function put_in_set($source, $list) {
	$new_array = array_unique($source);

	if( is_array($list) && count($list)>0 ) {
		$temp_arr = array_diff($list, $source);
		$new_array = array_merge($new_array, $temp_arr);
	}
	else if( ! is_array($list) && $list!='' ) {
		if( !in_array($list, $source) ) {
			$new_array[] = $list;
		}
	}
	else {
		return array_unique($source);
	}

	return $new_array;
}


function wrap_tags($start_wrapper, $end_wrapper, $tags) {
	$tags_arr = explode(',', $tags);

	$output = '';
	//echo '<pre>';
	$CI = get_instance();
	$CI->load->model('tag_master_model');

	foreach($tags_arr as $tag) {
		$tag = trim($tag);
		$tag_details = $CI->tag_master_model->get_by_tag(mysql_real_escape_string($tag));
		//echo '<br>start_wrapper:'.$start_wrapper;
		if( !isset($tag_details['id']) ) {
			continue;
		}

		$start = sprintf3($start_wrapper, array('tag_id'=>$tag_details['id']));
		
		//echo '<br>tag:'.$tag;
		$output .= $start.$tag.$end_wrapper.', ';
	}

	//echo '</pre>';
	return trim($output, ', ');
}

function wrap_skills($start_wrapper, $end_wrapper, $skills) {
	$skills_arr = explode(',', $skills);

	$output = '';
	//echo '<pre>';
	$CI = get_instance();
	$CI->load->model('skill_master_model');

	foreach($skills_arr as $skill) {
		$skill = trim($skill);
		$skill_details = $CI->skill_master_model->get_by_skill(mysql_real_escape_string($skill));

		if( !isset($skill_details['id']) ) {
			continue;
		}

		$start = sprintf3($start_wrapper, array('skill_id'=>$skill_details['id']));
		
		//echo '<br>skill:'.$skill;
		$output .= $start.$skill.$end_wrapper.', ';
	}

	//echo '</pre>';
	return trim($output, ', ');
}

function wrap_interests($start_wrapper, $end_wrapper, $interests) {
	$interests_arr = explode(',', $interests);

	$output = '';
	//echo '<pre>';
	$CI = get_instance();
	$CI->load->model('interest_master_model');

	foreach($interests_arr as $interest) {
		$interest = trim($interest);
		$interest_details = $CI->interest_master_model->get_by_interest(mysql_real_escape_string($interest));

		if( !isset($interest_details['id']) ) {
			continue;
		}

		$start = sprintf3($start_wrapper, array('interest_id'=>$interest_details['id']));
		
		//echo '<br>skill:'.$skill;
		$output .= $start.$interest.$end_wrapper.', ';
	}

	//echo '</pre>';
	return trim($output, ', ');
}

function count_csv($str) {
	if( trim($str)=='' ) {
		return 0;
	}
	$arr = explode(',', $str);
	return count($arr);
}

function br2nl($text) {
	//if($_SERVER['REMOTE_ADDR']!='58.68.53.242') {
		return preg_replace('/<br\\s*?\/??>/i', '', $text);
	//}
	//else {
	//	return 'aa';
	//}
}

function nl2br2($string) {
	$string = str_replace(array("\r\n", "\r", "\n"), "", $string);
	return $string;
}


function file_get_contents_utf8($fn) {
     $content = file_get_contents($fn);
     return mb_convert_encoding($content, 'UTF-8');
} 


function usortName($p1, $p2) {
	return strnatcmp($p1['name'], $p2['name']);
}


//// =========================================================
////                        Added by Suman [Start]
//// =========================================================

# function to count supports...
function CSV_support_count($supports)
{
    if( !empty ($supports) ) {
        $supportArr = explode(",", $supports);
        $support_count = count($supportArr);
    } else {
        $support_count = 0;
    }


    return $support_count;
}

//// =========================================================
////                        Added by Suman [End]
//// =========================================================



function escape_singlequotes($str) {
	$chars= array("'", "&#039;");
	foreach($chars as $char) {
		switch ($char) {
			case "'":
				$str = str_replace($char, "\'", $str);
				break;
			case "\"":
				$str = str_replace($char, "\\\"", $str);
				break;
			case "&#039;":
				$str = str_replace($char, "\&#039;", $str);
				break;
			case "&quot;":
				$str = str_replace($char, "\&quot;", $str);
				break;
		}
	}

	return $str;
}

function escape_doublequotes($str) {
	$chars= array("\"", "&quot;");
	foreach($chars as $char) {
		switch ($char) {
			case "'":
				$str = str_replace($char, "\'", $str);
				break;
			case "\"":
				$str = str_replace($char, "\\\"", $str);
				break;
			case "&#039;":
				$str = str_replace($char, "\&#039;", $str);
				break;
			case "&quot;":
				$str = str_replace($char, "\&quot;", $str);
				break;
		}
	}

	return $str;
}

/**
* @author Arnab Chattopadhyay
*/
function addStar($keyword)
{
    $keyword = str_replace('+', " ",$keyword);
    $keyword = str_replace('&', " ",$keyword);
    $keyword = str_replace(',', " ",$keyword);
    $keyword = str_replace('-', " ",$keyword);
    $keyword = str_replace(';', " ",$keyword);
    $keys = array();
    $keys = explode(' ', $keyword);
    $new_keyword = '';
    foreach($keys as $val)    
    {
        //$new_keyword .= $val.'* ';
        $new_keyword .= " +".$val."*";
    }
    $new_keyword = trim($new_keyword);
    return $new_keyword;
}




