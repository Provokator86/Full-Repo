<?

////////////////////////////////////////////////////////////////////////
/***********************************************************************
How To Use lib Js Css Hidden Folder:
----------------------------------------------------------------
	1.	Create a folder e.g. codebase
	2.	Put all js/css file in that codebase folder
	3.	Create a .htaccess file for peventing access to codebase folder js and css file
	4.	Copy libjchf folder inside codebase folder
	5.	Include the file "codebase/libjchf/lib_js_css_hidden_folder.php"
		in your php page and place following calls to include js file
		
		<?
			include "codebase/libjchf/lib_js_css_hidden_folder.php";
		?>
		<script language="javascript" src="<?=$GLOBALS[Lib_libJsCssHiddenFolder_self_object]->getUrlToJsLink()?>"></script>
		<link href="<?=$GLOBALS[Lib_libJsCssHiddenFolder_self_object]->getUrlToCssLink()?>" rel="stylesheet" type="text/css" />
	
***********************************************************************/
////////////////////////////////////////////////////////////////////////

if($GLOBALS[Lib_libJsCssHiddenFolder_Class_IsDefined])
{
	$GLOBALS[Lib_libJsCssHiddenFolder_self_object]->FILE=__FILE__;
}

if(!$GLOBALS[Lib_libJsCssHiddenFolder_Class_IsDefined])
{
	$GLOBALS[Lib_libJsCssHiddenFolder_Class_IsDefined]=true;
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	class Lib_libJsCssHiddenFolder 
	{
		////////////////////////////////////////////////////////////////////////
		function getUrlToJsLink()
		{
			return $GLOBALS[Lib_libJsCssHiddenFolder_self_object]->getUrlToJsCssLink($type='js');
		}
		function getUrlToCssLink()
		{
			return $GLOBALS[Lib_libJsCssHiddenFolder_self_object]->getUrlToJsCssLink($type='css');
		}
		////////////////////////////////////////////////////////////////////////
		//////////////////////   PRIVATE METHODS BELOW   ///////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////////////
		var $FILE=__FILE__;
		function getUrlToJsCssLink($type)
		{
			$type=strtolower($type);
			if(!in_array($type,array('js','css'))) return '';
			
			// remove DOCUMENT_ROOT from this file path to find url_of_this_dir_with_respect_to_website_root
			$root_path=$_SERVER['DOCUMENT_ROOT'];
			$file_path=dirname(str_replace("\\","/",$GLOBALS[Lib_libJsCssHiddenFolder_self_object]->FILE));
			$rel_path=split($root_path,$file_path,2);
			$rel_path=$rel_path[1];
			
			$url_of_this_dir_with_respect_to_website_root=$rel_path;
			
			return "{$url_of_this_dir_with_respect_to_website_root}/lib{$type}.php";
			
		}
		////////////////////////////////////////////////////////////////////////
		function printJsCssHtml($type)
		{
			$type=strtolower($type);
			if(!in_array($type,array('js','css'))) return;
			
			$dependency=$GLOBALS[Lib_libJsCssHiddenFolder_self_object]->get_dependency($type);
			
			$ret_text="";
		
			if($GLOBALS[Lib_libJsCssHiddenFolder_self_object]->checkJsCssHtmlPhpAccess()) 
			{ 
				
				
				foreach($dependency as $file)
				{ 
					$file_content=file_get_contents($file);
					
					$ret_text.= $file_content;
					$ret_text.= "\n";
				}
			}
			
			echo $ret_text;
		}
		////////////////////////////////////////////////////////////////////////
		function get_dependency($type)
		{
			
			$dir=dirname($GLOBALS[Lib_libJsCssHiddenFolder_self_object]->FILE);
			$dir=str_replace("\\","/",$dir);
			$dir=dirname($dir); // move one levl up
			
			$this_dir_files=scandir($dir);
			
			foreach($this_dir_files as $k=>$file)
			{
				$ext=split("\.",$file);
				$ext=$ext[count($ext)-1];
				if(($file=='.')||($file=='..'))
					unset($this_dir_files[$k]);
				else if(strtolower($ext)!=$type)
					unset($this_dir_files[$k]);
				else
					$this_dir_files[$k]="$dir/".$this_dir_files[$k];
			}
			
			return $this_dir_files;
		}
		////////////////////////////////////////////////////////////////////////
		function checkJsCssHtmlPhpAccess()
		{
			if($_SERVER['HTTP_REFERER'] && $_SERVER['HTTP_USER_AGENT'])
			{
					$referer_host=$_SERVER['HTTP_REFERER'];
					$referer_host=split("//",$referer_host,2);
					$referer_host=$referer_host[1];
					$referer_host=split("/",$referer_host,2);
					$referer_host=$referer_host[0];
					$server=$_SERVER['HTTP_HOST'];
					if(strtolower($server)==strtolower($referer_host))
					{
						return true;
					}
			}
			return false;
		}
		////////////////////////////////////////////////////////////////////////
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	if(!function_exists('scandir'))
	{
		function scandir($directory) 
		{
			$files = array();
			$dh  = opendir($directory);
			if($dh)
			{
				while (false !== ($filename = readdir($dh))) 
				{
					$files[] = $filename;
				}
				closedir($dh);
			}
			if(!count($files))$files=false;
			return $files;
		}
	}
	//PHP 4.2.x Compatibility function
	if(!function_exists('file_get_contents')) 
	{
		function file_get_contents($filename, $incpath = false, $resource_context = null)
		{
			if (false === $fh = fopen($filename, 'rb', $incpath)) 
			{
				trigger_error('file_get_contents() failed to open stream: No such file or directory', E_USER_WARNING);
				return false;
			}
			
			clearstatcache();
			if ($fsize = @filesize($filename)) 
			{
				$data = fread($fh, $fsize);
			} else 
			{
				$data = '';
				while (!feof($fh)) 
				{
					$data .= fread($fh, 8192);
				}
			}
			
			fclose($fh);
			return $data;
		}
	}
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////	
}

?><?
					if(!isset($GLOBALS[Lib_libJsCssHiddenFolder_self_object]))
					$GLOBALS[Lib_libJsCssHiddenFolder_self_object] = new Lib_libJsCssHiddenFolder();
				?>