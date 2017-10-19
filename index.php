<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2017
 * Time: 15:13
 */

$weekDay = array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag");
$semesterClasses = array("Mathematik 1 Übung", "Mathematik 1 Übung", "Medienrecht","","Mathematik 1","Team Studieneinstieg","","Informatik 1","Informatik 1 Labor","Programmieren 1","Media","Dramaturgie 1","","","","Mathematik 2 Ünung","Mathematik 2 Übung","","Mathematik 2","irgendwas");

include "plugin/import/timetable.php";

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
	<?php
		echo (SemesterTable("timetable",6,$weekDay, $semesterClasses));
	?>
</div>
<footer>
</footer>
</body>
</html>
