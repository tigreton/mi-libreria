<?php
/**
 * makeSecure.php
 * 
 * This file is included at the top of any page you wish to make secure with a login.
 *
 * Access will be granted only if they are logged in, else returned to login page.
 * 
 * Usage:	require('makeSecure.php');
 * 
 */

session_start();
require('LoginSystem.class.php');
error_reporting(E_ALL & ~E_NOTICE);  
$loginSys = new LoginSystem();

//Si tiene cookie, le crea la sesión.
$loginSys->loginUserCookie($_COOKIE['user_login']);

/**
 * if not logged in goto login form, otherwise we can view our page
 */
if(!$loginSys->isLoggedIn())
{
	
	header("Location: login.php");
	exit;
}
?>