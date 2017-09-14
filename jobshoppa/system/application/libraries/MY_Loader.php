<?php
///// Custom Loader class from extending Base Loadder Clas
//Purpose : Display Tepmale AHints

class MY_Loader extends CI_Loader {
	function My_Loader()
	{
	 parent::CI_Loader();
	}

 
 function view($view, $vars = array(), $return = FALSE)
	{
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));

	}
 
 function _ci_load($_ci_data)
	{
		// Set the default data variables
		foreach (array('_ci_view', '_ci_vars', '_ci_path', '_ci_return') as $_ci_val)
		{
			$$_ci_val = ( ! isset($_ci_data[$_ci_val])) ? FALSE : $_ci_data[$_ci_val];
		}

		// Set the path to the requested file
		if ($_ci_path == '')
		{
			$_ci_ext = pathinfo($_ci_view, PATHINFO_EXTENSION);
			$_ci_file = ($_ci_ext == '') ? $_ci_view.EXT : $_ci_view;
			$_ci_path = $this->_ci_view_path.$_ci_file;
		}
		else
		{
			$_ci_x = explode('/', $_ci_path);
			$_ci_file = end($_ci_x);
		}
		
		if ( ! file_exists($_ci_path))
		{
			show_error('Unable to load the requested file: '.$_ci_file);
		}
	
		// This allows anything loaded using $this->load (views, files, etc.)
		// to become accessible from within the Controller and Model functions.
		// Only needed when running PHP 5
		
		if ($this->_ci_is_instance())
		{
			$_ci_CI =& get_instance();
			foreach (get_object_vars($_ci_CI) as $_ci_key => $_ci_var)
			{
				if ( ! isset($this->$_ci_key))
				{
					$this->$_ci_key =& $_ci_CI->$_ci_key;
				}
			}
	
		}

		/*
		 * Extract and cache variables
		 *
		 * You can either set variables using the dedicated $this->load_vars()
		 * function or via the second parameter of this function. We'll merge
		 * the two types and cache them so that views that are embedded within
		 * other views can have access to these variables.
		 */	
		if (is_array($_ci_vars))
		{
			$this->_ci_cached_vars = array_merge($this->_ci_cached_vars, $_ci_vars);
		}
		extract($this->_ci_cached_vars);
				
		/*
		 * Buffer the output
		 *
		 * We buffer the output for two reasons:
		 * 1. Speed. You get a significant speed boost.
		 * 2. So that the final rendered template can be
		 * post-processed by the output class.  Why do we
		 * need post processing?  For one thing, in order to
		 * show the elapsed page load time.  Unless we
		 * can intercept the content right before it's sent to
		 * the browser and then stop the timer it won't be accurate.
		 */
		ob_start();						
		if($this->config->item('template_hints')){//Print Template Hints
			echo '<div><br /></div><span style="background:#FF0000;color:#FFFFFF;border:1px solid black;padding:2px 4px 2px 4px;font-size:11px;">'.$_ci_path.'</span><div style="border:1px dotted #FF0000;padding:4px;">';	
		}
		// If the PHP installation does not support short tags we'll
		// do a little string replacement, changing the short tags
		// to standard PHP echo statements.
		
		if ((bool) @ini_get('short_open_tag') === FALSE AND config_item('rewrite_short_tags') == TRUE)
		{
			echo eval('?>'.preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($_ci_path))));
		}
		else		
		{
			
			include($_ci_path); // include() vs include_once() allows for multiple views with the same name
					 
		}

		if($this->config->item('template_hints')){//End Print Template Hints
		 echo '<span style="color:white;">End OF '.$_ci_path.'</span></dv>';		
		 }
		// Return the file data if requested
		if ($_ci_return === TRUE)
		{		
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}

		/*
		 * Flush the buffer... or buff the flusher?
		 *
		 * In order to permit views to be nested within
		 * other views, we need to flush the content back out whenever
		 * we are beyond the first level of output buffering so that
		 * it can be seen and included properly by the first included
		 * template and any subsequent ones. Oy!
		 *
		 */	
		 
		if (ob_get_level() > $this->_ci_ob_level + 1)
		{
			ob_end_flush();
		}
		else
		{
			// PHP 4 requires that we use a global
			global $OUT;
			$OUT->append_output(ob_get_contents());
			
			@ob_end_clean();
			
		}
	}

	// --------------------------------------------------------------------
}	
?>

