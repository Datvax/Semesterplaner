<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.12.2017
 * Time: 01:59
 */
$weekDay = array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag");
//$semesterClasses = array("Mathematik 1 Übung", "Mathematik 1 Übung", "Medienrecht","","Mathematik 1","Team Studieneinstieg","","Informatik 1","Informatik 1 Labor","Programmieren 1","Media","Dramaturgie 1","","","","Mathematik 2 Ünung","Mathematik 2 Übung","","Mathematik 2","irgendwas");

if(file_exists("plugin/navigation/navbar_side.php")){include "plugin/navigation/navbar_side.php";}
if(file_exists("plugin/header/header.php")){include "plugin/header/header.php";}

if(file_exists("plugin/import/timetable.php")){include "plugin/import/timetable.php";}
if(file_exists("plugin/import/various.php")){include "plugin/import/various.php";}
if(file_exists("plugin/database/presenter.php")){include "plugin/database/presenter.php";}
if(file_exists("plugin/database/transmitter.php")){include "plugin/database/transmitter.php";}


$tempUserID = 1;

$userTimetable = showUserTimetable($tempUserID);


$showTable = false;
if(($_SERVER["REQUEST_METHOD"] == "POST") or ($_SERVER["REQUEST_METHOD"] == "GET")){
	if($_POST["sendLogin"]){
		header("Location: http://".$_SERVER['HTTP_HOST']."".rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/user.php");
		exit;
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
}else{
	$anonymousFieldMessage = "Stundenplan ID eingeben:";
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
	<?php echo sideHeader();?>
	<div id="leftContent"><?php echo navbarSide($sideURlsAndNames);?></div>
	<div id="rightContent">
		<?php
		if($showTable == false) {
			echo '
		<div class="form--login">
			<p>Loggen Sie sich mit ihrem Account hier ein.</p>
			<form method="post">
				<label for="userNameInput">Benutzername: </label>
				<input type="text" name="userName" id="userNameInput" class="input--text" placeholder="A-Kennung">
				<label for="userPasswordInput">Password</label>
				<input type="password" name="userPassword" class="input--text" id="userPasswordInput" placeholder="Password">
				<input type="submit" name="sendLogin" value="Login" class="input--button">
			</form>
		</div>
		<div class="form--anonymous">
			<form method="get">
				<label for="anonymousID">'.$anonymousFieldMessage.'</label>
				<input type="text" name="anonymousID" id="anonymousID" class="input--text" placeholder="Stundenplan ID">
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