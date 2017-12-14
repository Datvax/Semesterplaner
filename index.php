<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.10.2017
 * Time: 15:13
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
<div id="main" style="height: 1000px">
	<?php echo sideHeader($validUser);?>
	<div id="leftContent"><?php if(!empty($sideURlsAndNames)){echo navbarSide($sideURlsAndNames);};?></div>
	<div id="rightContent">
		<div class="button--div--largeButton"><a href="timetable.php">Stundenplan</a></div>
		<div class="button--div--largeButton"><a href="map.php">Karten</a></div>
	</div>
</div>

<footer>
</footer>
</body>
</html>
