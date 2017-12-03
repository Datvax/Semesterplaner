<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2017
 * Time: 15:13
 */

$weekDay = array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag");
//$semesterClasses = array("Mathematik 1 Übung", "Mathematik 1 Übung", "Medienrecht","","Mathematik 1","Team Studieneinstieg","","Informatik 1","Informatik 1 Labor","Programmieren 1","Media","Dramaturgie 1","","","","Mathematik 2 Ünung","Mathematik 2 Übung","","Mathematik 2","irgendwas");

if(file_exists("plugin/import/timetable.php")){include "plugin/import/timetable.php";}
if(file_exists("plugin/import/various.php")){include "plugin/import/various.php";}
if(file_exists("plugin/database/presenter.php")){include "plugin/database/presenter.php";}
if(file_exists("plugin/database/transmitter.php")){include "plugin/database/transmitter.php";}


$tempUserID = 1;

$userTimetable = showUserTimetable($tempUserID);



if($_SERVER["REQUEST_METHOD"] == "POST"){
	$tableIDs = $_POST["timetable--Checkbox--ID"];
	if (checkForID($tempUserID) == 0){
		sendTimetableIDs($tempUserID,$tableIDs);
	} else {
		updateTimetableIDs($tempUserID,$tableIDs);
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "plugin/import/head.php" ?>
	<title>Semesterplaner</title>
</head>
<body>
<div id="navigation" >
	<?php include "plugin/navigation/navbar.php"; ?>
</div>
<div id="main">
	<form method="post">
	<?php
		echo (SemesterTable("timetable",6,$weekDay, replaceStrInArray("Freistunde","",getReadableTimetable("KursMS16")),getTimetableClassIDs("StundenplanMS")));
	?>
		<input type="submit" value="send" class="button--send">
		<br>
		<br>
		<br>
		Stundenplan:
		<?php
		$userTimetableData = showUserTimetable($tempUserID);
			echo userTable("timetable",$weekDay,$userTimetableData);
		?>
	</form>
</div>
<footer>
</footer>
</body>
</html>
