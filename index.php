<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2017
 * Time: 15:13
 */
if(file_exists("plugin/navigation/navbar_side.php")){include "plugin/navigation/navbar_side.php";}
if(file_exists("plugin/header/header.php")){include "plugin/header/header.php";}

if(file_exists("plugin/import/timetable.php")){include "plugin/import/timetable.php";}
if(file_exists("plugin/import/various.php")){include "plugin/import/various.php";}
if(file_exists("plugin/database/presenter.php")){include "plugin/database/presenter.php";}
if(file_exists("plugin/database/transmitter.php")){include "plugin/database/transmitter.php";}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "plugin/import/head.php" ?>
	<title>Semesterplaner</title>
</head>
<body>
<div id="main" style="height: 1000px">
	<?php echo sideHeader();?>
	<div id="leftContent"><?php echo navbarSide($sideURlsAndNames);?></div>
	<div id="rightContent">
		<div class="button--div--largeButton"><a href="timetable.php">Stundenplan</a></div>
		<div class="button--div--largeButton"><a href="map.php">Karten</a></div>
	</div>
</div>

<footer>
</footer>
</body>
</html>
