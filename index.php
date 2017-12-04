<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2017
 * Time: 15:13
 */

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
<div id="navigation" >
	<?php include "plugin/navigation/navbar.php"; ?>
</div>
<div id="main">
	<div id="leftContent">Hier kommt die Navigation hin</div>
	<div id="rightContent">
		<div class="button--div--largeButton"><a href="user.php">Stundenplan</a></div>
		<div class="button--div--largeButton"><a href="map.php">Karten</a></div>
	</div>
</div>

<footer>
</footer>
</body>
</html>
