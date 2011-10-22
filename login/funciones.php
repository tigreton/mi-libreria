<?php
/**
 * Cleans a string for input into a MySQL Database.
 * Gets rid of unwanted characters/SQL injection etc.
 * 
 * @return string
 */
function clean($str)
{
	// Only remove slashes if it's already been slashed by PHP
	if(get_magic_quotes_gpc())
	{
		$str = stripslashes($str);
	}
	// Let MySQL remove nasty characters.
	$str = mysql_real_escape_string($str);
		
	return $str;
}
?>