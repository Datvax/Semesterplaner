<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.12.2017
 * Time: 01:36
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
		if(!empty($_GET["tableID"])){
			echo "<p>Ihr erstellter Stundenplan hat die ID: <span style='font-weight: bold'>".$_GET["tableID"]."</span>. Sollten Sie diesen Stundenplan erneut
			aufrufen wollen, geben Sie diese ID in das entsprechnede Feld auf der <a href='timetable.php'>Stundenplan Seite</a> ein.</p>";
			echo (userTable("timetable",$weekDay,showUserTimetable("",$_GET["tableID"])));
		}else if(!empty($_POST["userID"])){
			echo (userTable("timetable",$weekDay,showUserTimetable($tempUserID)));
		}

		?>
		<a href="timetable.php">Stundenplan Editieren</a>
	</div>
</div>
<footer>
</footer>
</body>
</html>