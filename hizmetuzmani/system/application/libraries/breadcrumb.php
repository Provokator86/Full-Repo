<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Breadcrumb Class
 *
 * This class manages the breadcrumb object
 *
 * @package		Breadcrumb
 * @author 		Jagannath Samanta

 */
class Breadcrumb {
	
	/**
	 * Breadcrumbs stack
	 *
     */
	private $breadcrumbs 	= array();
	
	/**
	 * Options
	 *
	 */
	private $divider 		= '&nbsp;&raquo;&nbsp;';
	private $tag_open 		= '<div id="breadcrumb">';
	private $tag_close 		= '</div>';
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}
		
		log_message('debug', "Breadcrumb Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	private function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (in_array($key, array('divider', 'tag_open', 'tag_close')) AND isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Append crumb to stack
	 *
	 * @access	public
	 * @param	string $title
	 * @param	string $href
	 * @return	void
	 */		
	function append_crumb($title, $href)
	{
		// no title or href provided
		if (!$title OR !$href) return;
		
		// add to end
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Prepend crumb to stack
	 *
	 * @access	public
	 * @param	string $title
	 * @param	string $href
	 * @return	void
	 */		
	function prepend_crumb($title, $href)
	{
		// no title or href provided
		if (!$title OR !$href) return;
		
		// add to start
		array_unshift($this->breadcrumbs, array('title' => $title, 'href' => $href));
	}
	
	// --------------------------------------------------------------------

	/**
	 * Generate breadcrumb
	 *
	 * @access	public
	 * @return	string
	 */		
	function output()
	{
		// breadcrumb found
		if ($this->breadcrumbs) {
		
			// set output variable
			$output = $this->tag_open;
			
			// add html to output
			foreach ($this->breadcrumbs as $key => $crumb) {
				
				// if last element
				/*if (end(array_keys($this->breadcrumbs)) == $key) {
					$output .= '<span>' . $crumb['title'] . '</span>';
					
				// else add link and divider
				} else {
					$output .= '<a href="' . $crumb['href'] . '">' . $crumb['title'] . '</a> &nbsp;';
				}*/
				$output .= '<a href="' . $crumb['href'] . '">' . $crumb['title'] . '</a>';
				// add divider
				$output .= $this->divider;
			}
			
			// return html
			return $output . $this->tag_close . PHP_EOL;
		}
		
		// return blank string
		return '';
	}

}
// END Breadcrumb Class

/* End of file Breadcrumb.php */
/* Location: ./application/libraries/Breadcrumb.php */