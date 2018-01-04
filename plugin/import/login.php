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
	if(isset($_POST['logoutButton']) and $_POST['logoutButton']){
		if(validateUser($cookieName)){
			deleteOldToken($_SESSION['userID']);
		}
		setcookie($cookieName, '', 0,'/',$_SERVER['HTTP_HOST'],true);
		session_unset();
		session_destroy();
		if($_GET["s"]==2 || $_GET["s"]==1){
			header("Refresh:0; url=http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\'));
			exit;
		}
		header("Refresh:0");
		exit;
	}
}