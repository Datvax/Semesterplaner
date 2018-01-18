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
<html lang="de">
<head>
	<?php include "plugin/import/head.php" ?>
	<title>Semesterplaner</title>
	<script>
		console.log("script loaded");

		function showRoomInfo(str) {
			if (str == "") {
				document.getElementById("roomInfoBox").innerHTML = "";
				return;
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5 (I really hope no one is using this)
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						document.getElementById("roomInfoBox").innerHTML = this.responseText;
					}
				};
				xmlhttp.open("POST","plugin/import/room.php",true);
				xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				xmlhttp.send("q="+str);
			}
		}
	</script>
</head>
<body>
<div id="main">
	<?php echo sideHeader($validUser);?>
	<div id="leftContent"><?php if(!empty($sideURlsAndNames)){echo navbarSide($sideURlsAndNames);}; ?></div>
	<div id="rightContent">
	<img src="map/Gebaeude_A_-_0_blue.png" class="map--campusMap" usemap="Gebaeude_A_-_0_blue_map" />
	<map name="Gebaeude_A_-_0_blue_map">
		<area shape="rect" coords="364,429,448,471" alt="E39"/>
		<area shape="rect" coords="490,429,571,471" alt="E48"/>
		<area shape="rect" coords="400,323,440,404" alt="E46"/>
		<area shape="rect" coords="497,322,539,404" alt="E42"/>
		<area shape="rect" coords="732,299,779,370" alt="E59"/>
		<area shape="rect" coords="732,194,780,277" alt="E62"/>
		<area shape="rect" coords="671,178,708,287" alt="E63"/>
		<area shape="rect" coords="731,118,780,190" alt="E64"/>
	</map>
		<div id="roomInfoBox"><br><span style="display: block; width: 100%; text-align: center">Klicken Sie auf die Räume für mehr Informationen</span></div>
	</div>
</div>
<?php
if(isset($_GET["r"]) and $_GET["r"] != ""){
	echo ("
		<script>
			$(document).ready(function(){
				showRoomInfo('". $_GET["r"] ."');
			});
		</script>
	");
}
?>
<script>
	$(document).ready(function(){
		$("area").click(function(event){
			var elemtID = event.target.alt;
			console.log(elemtID);
			showRoomInfo(elemtID);
		});
	});
</script>
<footer>
</footer>
</body>
</html>