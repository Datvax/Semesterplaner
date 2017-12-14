<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 04.12.2017
 * Time: 00:46
 */

$includeSwitch = array(1,1,0);
if(file_exists("plugin/config/includer.php")){include "plugin/config/includer.php";}


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
	<div id="leftContent"><?php if(!empty($sideURlsAndNames)){echo navbarSide($sideURlsAndNames);}; ?></div>
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