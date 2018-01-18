<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.01.2018
 * Time: 16:46
 */
$checkFile = true;



/*
 * Tools to handle the access token
 */

/**
 * Function to check users identity
 * @param $selector
 * @return mixed
 */
function userCheck($selector){
	include 'connect.php';

	//Sends the selector to get the row
	$sqlRememberMe = $conn->prepare('SELECT `selector`, `hashedValidator`, `userID`, `expires` FROM `auth_tokens` WHERE selector = ?');
	$sqlRememberMe->execute(array($selector));
	$rememberMe = $sqlRememberMe->fetch();
	return $rememberMe;
}

/**
 * Function to handle RememberMe request
 * @param string $selector
 * @param string $hashedValidator
 * @param integer $userID
 */
function rememberMe($selector, $hashedValidator, $userID){
	include 'connect.php';

	//Sends the token and the selector:validator pair to the DB
	$sqlRememberMe = $conn->prepare('INSERT INTO `auth_tokens`(`selector`, `hashedValidator`, `userID`, `expires`) VALUES (?,?,?,DATE_ADD(NOW(), INTERVAL 1 YEAR ))');
	$sqlRememberMe->execute(array($selector, $hashedValidator, $userID));
}

/**
 * Function to delete old tokens
 * @param integer $userID
 */
function deleteOldToken($userID){
	include 'connect.php';

	//Delets old tokens to prevent having multiple tokens open
	$sqlDeleteOldToken = $conn->prepare('DELETE FROM `auth_tokens` WHERE userID = ?');
	$sqlDeleteOldToken->execute(array($userID));
}



/*
 * Tools to handle the session cookie
 */

/**
 * Function to validate user
 * @param string $cookieName
 * @return bool
 */
function validateUser($cookieName = "defaultSessionName"){
	if(isset($_COOKIE[$cookieName])) {
		if ($_COOKIE[$cookieName] != null) {

			//Extract selector and validator
			$cookiePart = explode('-', $_COOKIE[$cookieName]);

			//Gets user from database
			$userToken = userCheck($cookiePart[0]);

			//Compares user with database
			if ($cookiePart[1] != null && $userToken[1] != null) {
				if (hash_equals($userToken[1], hash('sha256', $cookiePart[1]))) {

					//Creates new session cookie
					session_id($cookiePart[0] . '-' . $cookiePart[1] . '-' . $cookiePart[2]);
					session_name($cookieName);
					session_set_cookie_params($cookiePart[2], '/', $_SERVER['HTTP_HOST'], true);
					session_start();
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	}else{
		return false;
	}
}

/**
 * Function gives the selector from the cookie
 * @param string $cookieName
 * @return string
 */
function getUserSelector($cookieName = "defaultSessionName"){
	if($_COOKIE[$cookieName] != null) {

		//Extract selector and validator
		$cookiePart = explode('-', $_COOKIE[$cookieName]);
		return $cookiePart[0];
	} else {
		return "";
	}
}
/**
 * Function to start a new Session
 * @param string $selector
 * @param string $hashValidator
 * @param integer $expirationTime
 * @param string $cookieName
 */
function sessionStart($selector, $hashValidator, $expirationTime, $cookieName = "defaultSessionName") {

	//Do not allow to use too old session ID
	if (!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180) {
		session_destroy();
	}
	session_id($selector.'-'.$hashValidator.'-'.$expirationTime);
	session_name($cookieName);
	session_set_cookie_params($expirationTime,'/',$_SERVER['HTTP_HOST'],true);
	session_start();
}



/*
 * Tools to check session status and validation
 */

/**
 * Function to check the session status
 * @return bool
 */
function sessionStatus() {

	//Checks the session status
	if (function_exists('session_status')){

		//Returns false if there is no session
		return PHP_SESSION_ACTIVE == session_status();
	}else{

		//Returns false when there is no session ID
		return session_id() === '' ? FALSE : TRUE;
	}
}
function sessionValidCheck($session_id)
{
	return preg_match('/^[-,a-zA-Z0-9]{1,128}$/', $session_id);
}



/*
 * Tools for new login requests
 */

/**
 * Function to get a specific user from the Database
 * @param string $userName
 * @return array
 */
function getUserIDAndPassword($userName){
	include 'connect.php';

	//Gets a user from the UserTable
	$sqlUserIDAndPassword = $conn->prepare('SELECT `USER_ID`, `USER_PASSWORD` FROM '.$hawUserTable.' WHERE USER_NAME=?');
	$sqlUserIDAndPassword->execute(array($userName));
	$userIDAndPassword = $sqlUserIDAndPassword->fetch();
	return $userIDAndPassword;
}

/**
 * Function to handle login request
 * @param string $methodRequest
 * @param string $loginName
 * @param string $loginPassword
 * @param bool $rememberMe
 * @param string $cookieName
 * @param string $sessionUserID
 * @return bool
 */
function newLogin($methodRequest, $loginName, $loginPassword, $rememberMe = false, $cookieName = "defaultSessionName", $sessionUserID = "userID"){
	if ($methodRequest == "POST") {
		if (!empty($loginName) && !empty($loginPassword)) {

			//Compare password from database($userIDAndPassword) with entered password
			$userIDAndPassword = getUserIDANDPassword($loginName);
			if (password_verify($loginPassword, $userIDAndPassword[1])) {

				//Create identify token
				$selector = uniqid();
				$hashValidator =  bin2hex(random_bytes(64));

				//delete possible old tokens
				deleteOldToken($userIDAndPassword[0]);

				//send token to database
				rememberMe($selector,hash('sha256', $hashValidator),$userIDAndPassword[0]);

				//set token in cookie
				if($rememberMe){

					//Start new session
					sessionStart($selector, $hashValidator,(86400 * 31),$cookieName);
				}else{

					//Start new session
					sessionStart($selector, $hashValidator, null,$cookieName);
				}

				//Store user id in session
				return true;
			} else {

				//Error if username or password does not match with anything from the database
				return false;
			}
		} else {

			//Error if user has not filled in every field
			return false;
		}
	}
	return false;
}

//function getUserData(){
//	include 'connect.php';
//	/**Sends the selector to get the row**/
//	$sqlUserData = $conn->prepare('SELECT `UserName`, `EMail` FROM `GWTC_USER` WHERE ID = ?');
//	$sqlUserData->execute(array($_SESSION['userID']));
//	$userData = $sqlUserData->fetch();
//	return $userData;
//}

