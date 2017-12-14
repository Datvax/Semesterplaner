<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.12.2017
 * Time: 01:59
 */
$weekDay = array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag");
//$semesterClasses = array("Mathematik 1 Übung", "Mathematik 1 Übung", "Medienrecht","","Mathematik 1","Team Studieneinstieg","","Informatik 1","Informatik 1 Labor","Programmieren 1","Media","Dramaturgie 1","","","","Mathematik 2 Ünung","Mathematik 2 Übung","","Mathematik 2","irgendwas");

$includeSwitch = array(1,1,1);
if(file_exists("plugin/config/includer.php")){include "plugin/config/includer.php";}






$tempUserID = 1;

$userTimetable = showUserTimetable($tempUserID);

$loginFieldMessage = "Loggen Sie sich mit ihrem Account hier ein.";
$loginBorder = '';
$showTable = false;
if(($_SERVER["REQUEST_METHOD"] == "POST") or ($_SERVER["REQUEST_METHOD"] == "GET")){
	if($_POST["sendLogin"]){
		$loginFeedback = newLogin($_SERVER["REQUEST_METHOD"],$_POST["userName"],$_POST["userPassword"],false,$cookieName);
		if($loginFeedback) {
			header("Refresh:0");
			exit;
		}else{
			$loginFieldMessage = "<span style='color: red'>Benutzer oder Password sind falsch!</span>";
			$loginBorder = 'style="outline: 1px solid red"';
		}
	}else if($_GET["sendAnonymous"]){
		if(!empty($_GET["anonymousID"])) {
			header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim(dirname($_SERVER['PHP_SELF']), '/\\') . "/user.php?tableID=".$_GET["anonymousID"]);
			exit;
		}else{
			header("Location: http://" . $_SERVER['HTTP_HOST'] . "" . rtrim($_SERVER['PHP_SELF'], '/\\') ."?missingField=true");
			exit;
		}
	}else if($_POST["sendNewAnonymous"]){
		$showTable = true;
	}else if($_POST["transmitHours"]){
		$tableIDs = $_POST["timetable--Checkbox--ID"];
		$uniqueAnonymousID = uniqid();
		$newAnonymousID = createAnonymousUser($uniqueAnonymousID);

		sendTimetableIDs(null,$newAnonymousID,$tableIDs);

		header("Location: http://".$_SERVER['HTTP_HOST']."".rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/user.php?tableID=".$uniqueAnonymousID);
		exit;
	}
}
if($_GET["missingField"]==true){
	$anonymousFieldMessage = "<span style='color: red'>Geben Sie eine ID ein, nach der Sie suchen wollen:</span>";
	$anonymousBorder = 'style="outline: 1px solid red"';
}else{
	$anonymousFieldMessage = "Stundenplan ID eingeben:";
	$anonymousBorder = '';
}
/*
 if (checkForID($newAnonymousID) == 0){
			sendTimetableIDs($newAnonymousID,$tableIDs);
			$uniqueAnonymousID .= "JA".$newAnonymousID;
		} else {
			updateTimetableIDs($newAnonymousID,$tableIDs);
			$uniqueAnonymousID .= "NEIN".$newAnonymousID;
		}
*/
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
		if($showTable == false) {
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
		}


			if ($showTable == true){
				echo '<form method="post">'.(SemesterTable("timetable",6,$weekDay, replaceStrInArray("Freistunde","",getReadableTimetable("KursMS16")),getTimetableClassIDs("StundenplanMS"))).'<input type="submit" name="transmitHours" value="send" class="button--send"></form>';
			}
			?>
		</form>
	</div>
</div>
<footer>
</footer>
</body>
</html>