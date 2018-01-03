<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.12.2017
 * Time: 01:59
 */

/**
 * include all files
 */
$includeSwitch = array(1,1,1);
if(file_exists("plugin/config/includer.php")){include "plugin/config/includer.php";}



/**
 * Check if user is logged in
 */
if($validUser){
	$currentUserSelector = getUserSelector($cookieName);
	if(checkForUserTimetable($currentUserSelector)){
		if( ($_GET["s"] != 1) and ($_GET["s"] != 2) ) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') . "?s=2");
			exit;
		}
	}else{
		$currentUserSelector = null;
	}
}

/**
 * Prepare a Message which can be manipulated in the next section
 */
$loginFieldMessage = "Loggen Sie sich mit ihrem Account hier ein.";
$loginBorder = '';

/**
 * Separates the side in three parts:
 *	- First Part: Fresh User
 *	- Second Part: Create a new timetable
 *	- third Part: show customised timetable
 */

/**
 * Part 1
 */
if(($_GET["s"] == null) or ($_GET["s"] == 0) or ($_GET["s"] > 2)){
	if(($_SERVER["REQUEST_METHOD"] == "POST") or ($_SERVER["REQUEST_METHOD"] == "GET")) {
		if ($_POST["sendLogin"]) {
			$loginFeedback = newLogin($_SERVER["REQUEST_METHOD"], $_POST["userName"], $_POST["userPassword"], false, $cookieName, $sessionUserID);
			if ($loginFeedback) {
				header("Refresh:0");
				exit;
			} else {
				$loginFieldMessage = "<span style='color: red'>Benutzer oder Password sind falsch!</span>";
				$loginBorder = 'style="outline: 1px solid red"';
			}
		} else if ($_GET["sendAnonymous"]) {
			if (!empty($_GET["anonymousID"])) {
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') . "?s=2&tableID=" . $_GET["anonymousID"]);
				exit;
			} else {
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') . "?missingField=true");
				exit;
			}
		} else if ($_POST["sendNewAnonymous"]) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') . "?s=1");
			exit;
		}
	}
}
/**
 * Part 2
 */
if($_GET["s"] == 1) {
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		if ($_POST["transmitHours"]) {
			$tableIDs = $_POST["timetable--Checkbox--ID"];
			if($validUser){
				if(!checkForUserTimetable(getUserSelector($cookieName))[0]){
					sendTimetableIDs(getUserSelector($cookieName),null,$tableIDs);
				}else{
					updateTimetableIDs(getUserSelector($cookieName),$tableIDs);
				}
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') . "?s=2");
				exit;
			}else{
				$uniqueAnonymousID = uniqid();
				$newAnonymousID = createAnonymousUser($uniqueAnonymousID);
				sendTimetableIDs(null, $newAnonymousID, $tableIDs);
				header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') . "?s=2&tableID=".$uniqueAnonymousID);
				exit;
			}
		}
	}
}
/**
 * Part 3
 */
if($_GET["s"] == 2){

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "plugin/import/head.php" ?>
	<title>Semesterplaner</title>
</head>
<body>
<div id="main">
	<?php echo sideHeader($validUser);?>
	<div id="leftContent"><?php if(!empty($sideURlsAndNames)){echo navbarSide($sideURlsAndNames);};?></div>
	<div id="rightContent">
		<?php
		/**
		 * Separates the page again in the three parts from above
		 */
		if(($_GET["s"] == null) or ($_GET["s"] == 0) or ($_GET["s"] > 2)) {
			if($_GET["missingField"]==true){
				$anonymousFieldMessage = "<span style='color: red'>Geben Sie eine ID ein, nach der Sie suchen wollen:</span>";
				$anonymousBorder = 'style="outline: 1px solid red"';
			}else{
				$anonymousFieldMessage = "Stundenplan ID eingeben:";
				$anonymousBorder = '';
			}
			echo '
		<div class="form--login">
			<p>'.$loginFieldMessage.'</p>
			<form method="post">
				<label for="userNameInput">Benutzername: </label>
				<input type="text" name="userName" id="userNameInput" class="input--text" placeholder="A-Kennung" '.$loginBorder.'>
				<label for="userPasswordInput">Password</label>
				<input type="password" name="userPassword" class="input--text" id="userPasswordInput" placeholder="Password" '.$loginBorder.'>
				<input type="submit" name="sendLogin" value="Login" class="input--button">
			</form>
		</div>
		<div class="form--anonymous">
			<form method="get">
				<label for="anonymousID">'.$anonymousFieldMessage.'</label>
				<input type="text" name="anonymousID" id="anonymousID" class="input--text" placeholder="Stundenplan ID" '.$anonymousBorder.'>
				<input type="submit" name="sendAnonymous" value="Suchen" class="input--button">
			</form>
			<br>
			<form method="post">
				<p>Einen neuen anonymen Stundenplan erstellen.</p>
				<input type="submit" name="sendNewAnonymous" value="Neuer Plan" class="input--button">
			</form>
		</div>';
		}else if($_GET["s"] == 1){
			/**
			 * Calls the timetable creator
			 */
			echo '<form method="post">'.(SemesterTable("timetable",6,$weekDay, replaceStrInArray("Freistunde","",getReadableTimetable("KursMS16")),getTimetableClassIDs("StundenplanMS"),$currentUserSelector)).'<input type="submit" name="transmitHours" value="Erstellen" class="input--button"> <a href="timetable.php?s=2" class="button--a--smallButton">Abbrechen</a></form>';
		}else if($_GET["s"] == 2){
			/**
			 * Calls the created timetable
			 */
			if(!empty($_GET["tableID"])){
				echo "<p>Ihr erstellter Stundenplan hat die ID: <span style='font-weight: bold'>".$_GET["tableID"]."</span>. Sollten Sie diesen Stundenplan erneut
			aufrufen wollen, geben Sie diese ID in das entsprechnede Feld auf der <a href='timetable.php'>Stundenplan Seite</a> ein.</p>";
				echo (userTable("timetable",$weekDay,showUserTimetable("",$_GET["tableID"])));
			}else if(!empty($currentUserSelector)){
				echo (userTable("timetable",$weekDay,showUserTimetable($currentUserSelector)));
				echo '<a href="timetable.php?s=1" class="button--a--smallButton">Stundenplan Editieren</a>';
			}else {
				echo(userTable("timetable", $weekDay, showUserTimetable()));
			}
		}
		?>
		</form>
	</div>
</div>
<footer>
</footer>
</body>
</html>