<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 14.12.2017
 * Time: 20:47
 */

/**
 * Check if user is already logged in
 */
$validUser = false;
if(validateUser($cookieName)){
	$validUser = true;
}
/**
 * Handles the logout request
 */
if($_SERVER["REQUEST_METHOD"] == "POST"){
	if($_POST['logoutButton']){
		if(validateUser($cookieName)){
			deleteOldToken($_SESSION['userID']);
		}
		setcookie($cookieName, '', 0,'/',$_SERVER['HTTP_HOST'],true);
		session_unset();
		session_destroy();
		header("Refresh:0");
		exit;
	}
}