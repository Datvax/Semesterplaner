<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.01.2018
 * Time: 16:46
 */
function getRoomInfo($roomID = null){

	include 'connect.php';
	$sqlRooms = $conn->prepare("SELECT * FROM HAW_ROOM WHERE ROOM_NAME = ?");
	$sqlRooms->execute(array($roomID));

	$roomTable = "<table id='roomTable'>
		<tr>
		<th>Raumname</th>
		<th>Gebäude</th>
		<th>Etage</th>
		<th>Kapazität</th>
		<th>PC-Raum</th>
		<th>PC Anzahl</th>
		<th>Beamer</th>
		<th>Besonderheit</th>
		</tr>";
	while($row = $sqlRooms->fetch(PDO::FETCH_ASSOC)) {
		$roomTable .= "<tr>";
		$roomTable .= "<td>" . $row['ROOM_NAME'] . "</td>";
		$roomTable .= "<td>" . $row['BUILDING'] . "</td>";
		$roomTable .= "<td>" . $row['LEVEL'] . "</td>";
		$roomTable .= "<td>" . $row['CAPACITY'] . "</td>";
		$roomTable .= "<td>" . $row['PC_ROOM'] . "</td>";
		$roomTable .= "<td>" . $row['PC_COUNT'] . "</td>";
		$roomTable .= "<td>" . $row['PROJECTOR'] . "</td>";
		$roomTable .= "<td>" . $row['PARTICULARITY'] . "</td>";
		$roomTable .= "</tr>";
	}
	$roomTable .= "</table>";
	return $roomTable;
}