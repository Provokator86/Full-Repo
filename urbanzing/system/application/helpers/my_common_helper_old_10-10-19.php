<?php
//for MLM
function getSQLLimit($toshow=10,$page=0)
{
    $start=0;
    $sql='';
    if(isset($page) && $page>0)
    {
        $start = ($page-1)*$toshow;
    }
    if($toshow!=-1)
        $sql = " limit $start, $toshow";
    return $sql;
}

function makeOption($value = array(),$id = '')
{
    $option = '';
    if($value)
    {
        if($id=='')
            $id =-1;
        foreach ($value as $key=>$txt)
        {
            $select = '';
            if($key == $id)
                $select = " selected ";
            $option     .="<option $select value='$key'>$txt</option>";
        }
    }
    return $option;
}

function paggingInitialization($obj,$dataArr=array())
{
    $obj->load->library('pagination');

    $config['base_url'] = $dataArr['base_url'];
    $config['total_rows'] = $dataArr['total_row'];
    $config['per_page'] = $dataArr['per_page'];
    $config['uri_segment'] = $dataArr['uri_segment'];
    $config['next_link'] = $dataArr['next_link'];
    $config['prev_link'] = $dataArr['prev_link'];
    $obj->pagination->initialize($config);
}

function add_date($date='',$time='86400',$return='')
{
	if($date)
	{
		if(is_numeric($date))
			$date	= $date + $time;
		else 
			$date	= strtotime($date)+$time; 
	}
	else
		$date	= time()+$time;
		
		if($return)
		  return $date;
		else
		  return date('Y-m-d',$date);
}

function get_rendom_code($string='',$characters=8)
{
	if(!$string || $string=='')
		$string='1234567890abcdfghijkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ1234567890';
    $code = '';
    $i = 0;
    while ($i < $characters)
    {
    	$code .= substr($string, mt_rand(0, strlen($string)-1), 1);
        $i++;
   	}
    return $code;
}

function Lib_add_arg_to_url($url,$arg)
{
	if($arg)
    {
    	$url=split("#",$url,2);
        $url_hash=@$url[1];
        $url=$url[0];
        $arg=split("#",$arg,2);
        $arg_hash=@$arg[1];
        $arg=$arg[0];
        $url_arg=split("\?",$url,2);
        $ret_url=$url_arg[0];
        $url_arg=(isset($url_arg[1]))?$url_arg[1]:'';

		if($url_arg)
        	$url_arg=split('&',$url_arg);
        else
        	$url_arg=array();

        $arg=split('&',$arg);
        $ret_url_arg=array();
        for($i=0;$i<count($url_arg);$i++)
        {
        	$url_arg[$i]=split('=',$url_arg[$i],2);
            $ret_url_arg[$url_arg[$i][0]]=@$url_arg[$i][1];
       	}

        for($i=0;$i<count($arg);$i++)
        {
        	$arg[$i]=split('=',$arg[$i],2);
            $ret_url_arg[$arg[$i][0]]=@$arg[$i][1];
        }

        $sep='?';
        foreach($ret_url_arg as $k => $v)
        {
        	$ret_url.=$sep."$k=$v";
            $sep='&';
        }

        $url=$ret_url;
    }

    if($arg_hash)
    	$url="{$url}#$arg_hash";

   	return $url;
}

function WD($str, $tag='' )
{
    global $CI;
    $CI->load->model('language_model');
    $CI->load->model('site_settings_model');
    $CI->language_model->Lib_WD_Default_Lang_id=$CI->site_settings_model->get_site_settings('default_language');
    if(($CI->language_model->Lib_WD_STRLEN($str)>($CI->language_model->Lib_WD_MAX_WORD_LEN-1)) ||(strlen($tag)>(9999-1)))
	return $str; // can not be handled
    if($CI->language_model->Lib_WD_DEBUG)
    	$CI->language_model->Lib_WD_INSERT_WORD($str,$tag);
    if($tag=='P' || $tag=='p')
    	return stripslashes($CI->language_model->Lib_WD_GET_TRANS_WORD($str,$tag));
    else
    	return strip_tags($CI->language_model->Lib_WD_GET_TRANS_WORD($str,$tag));
}

	function sendGIF()
    {
        // open the file in a binary mode
        $name = BASEPATH."../images/front/company_logo.png";
//        echo $this->public_path;
        //Open and read in binary
        $fp = fopen($name, 'rb');

        // send the right headers
        header("Pragma: no-cache");
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type: image/gif");
        header("Content-Length: " . filesize($name));

        // dump the picture and stop the script
        fpassthru($fp);
    }
######################################### following functions created by iman #####################################

function upload_file($obj, $arr , $filename)
{
	$obj->load->library('upload');
	$obj->upload->initialize($arr);
	
	
	/*$config['upload_path'] = $arr['upload_path'];
	$config['file_name'] = $arr['file_name'];
	$config['allowed_types'] = $arr['allowed_types'];
	$config['max_size']	= $arr['max_size'];
	$config['max_width']  = $arr['max_width'];
	$config['max_height']  = $arr['max_height'];	
	
	$obj->load->library('upload', $config);*/
	$upload = $obj->upload->do_upload($filename);
//	$obj->upload->clear();
	$retArr='';
    if($upload)
		$retArr=$obj->upload->data();
	else
		$retArr=$obj->upload->display_errors('','|');
	return $retArr;
}

function create_thumb($obj, $arr)
{
	$obj->load->library('image_lib');
	$obj->image_lib->initialize($arr);
	$return = $obj->image_lib->resize();
	$obj->image_lib->clear();
	return 	$return;
}

function getExtension($filename)
{
	preg_match('/(^.*)\.([^\.]*)$/', $filename, $matches);
	return $matches;
}

function get_date_hr($sec){
	$days = floor($sec/86400);
	$remind = (int)($sec%86400);
	$hr = (int)($remind/3600);
	if($hr<0 || $days<0)
		return '--';
	return  $days." d ".$hr." hr";
	
}

function dbOut($str)
{
     return stripslashes($str);
}

function vacant_node_html($p_code)
{
    $html   = '<img src="'.base_url().'images/admin/icon_4.png" alt="" />';
    return $html;
}
?>