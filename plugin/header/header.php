<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.12.2017
 * Time: 19:34
 */

function sideHeader(){
	$sideHeader = '
	<ul id="serviceNav">
		<li><a>Login</a></li>
		<li><a href="impressum.php">Impressum</a></li>
	</ul>

	<div id="actualHeader">
		<a href="http://haw-hamburg.de/">
			<img src="templates/pictures/logo-haw-2017.png" id="headerLogo">
		</a>
		<div id="randomHeaderImage">
			<img src="templates/pictures/header_img_01.png">
			<img src="templates/pictures/header_img_02.png">
			<img src="templates/pictures/header_img_03.png">
		</div>
	</div>
	';
	return $sideHeader;
}