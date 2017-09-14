<?php
class database
{
	public	$link;
	
	function __construct($link,$database)
	{
		$this->link	=	$link;
		if (!$this->link) {
    		die('Could not connect: ' . mysql_error());
		}
		mysql_select_db($database,$this->link);
	} 
	
	function get_query($sql)
	{
		return mysql_query($sql,$this->link);
	}
	/*function get_user_name_by_id($user_id)
	{
	
	}*/

	
	function __destruct()
	{
		mysql_close($this->link);
	}
}




?>