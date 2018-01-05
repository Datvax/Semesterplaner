<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 05.01.2018
 * Time: 17:27
 */
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
$includeSwitch = array(0,0,0,1);
if (file_exists("../database/ajax.php")) {
	include "../database/ajax.php";
}

if(isset($_POST['q'])) {
	echo getRoomInfo($_POST['q']);
}
?>
</body>
</html>