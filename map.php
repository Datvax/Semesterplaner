<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.12.2017
 * Time: 00:46
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
	<img src="map/Gebaeude_A_-_0_blue.png" class="map--campusMap" usemap="Gebaeude_A_-_0_blue_map" />
	<map name="Gebaeude_A_-_0_blue_map">
		<area shape="rect" coords="364,429,448,471" alt="Raum E39" target="E39"  nohref="nohref" />
		<area shape="rect" coords="490,429,571,471" alt="Raum E48" target="E48"  nohref="nohref" />
	</map>
	</div>
</div>
<footer>
</footer>
</body>
</html>