<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 23.11.2017
 * Time: 07:56
 */

/**entrance file**/




/**presenter file**/

/**joins the actual timetable with the list of classes to create a readable timetable**/
function getReadableTimetable($ClassYear) {

	$sqlClassNames = $conn->prepare("SELECT ".$ClassYear.".Kursname FROM ".$ClassYear." JOIN StundenplanMS ON ".$ClassYear.".KursID=StundenplanMS.KursID");
	$sqlClassNames->execute();
	$tempClassNames = $sqlClassNames->fetchAll();
	return $tempClassNames;
}
/**gets all id's for the classes from the timetable**/
function getTimetableClassIDs($timetable){

	$sqlClassNames = $conn->prepare("SELECT `KursID` FROM ".$timetable);
	$sqlClassNames->execute();
	$tempClassNames = $sqlClassNames->fetchAll();
	return $tempClassNames;
}
/**gets all id's for the classes from the timetable**/
function getPersonalTimetable(){

	$sqlClassNames = $conn->prepare("SELECT * FROM `KursMS16` WHERE KursID IN (2,3,4)");
	$sqlClassNames->execute();
	$tempClassNames = $sqlClassNames->fetchAll();
	return $tempClassNames;
}

function checkForID($userID){

	$sqlCheckID = $conn->prepare("SELECT count(*) FROM `MeinStundenplan` WHERE USER_PLAN_ID = ?");
	$sqlCheckID->execute(array($userID));
	$tempCheckID = $sqlCheckID->fetch();
	return $tempCheckID;
}

function showUserTimetable($userID){

	$sqlGetTimetable = $conn->prepare("
	SELECT * FROM (SELECT KursMS16.Kursname, StundenplanMS.TAG_ID, StundenplanMS.UHRZEIT, KursMS16.KursID AS newKursID FROM `KursMS16` JOIN StundenplanMS ON KursMS16.KursID=StundenplanMS.KursID)
	as tempKursTable WHERE newKursID IN (
	(SELECT `USER_PLAN_0` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_1` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_2` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_3` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_4` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_5` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_6` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_7` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_8` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_9` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_10` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_11` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_12` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_13` FROM `MeinStundenplanLarge` WHERE USER_ID = 1),
	(SELECT `USER_PLAN_14` FROM `MeinStundenplanLarge` WHERE USER_ID = 1)
	) ORDER BY UHRZEIT ASC, TAG_ID ASC;
	");
	$sqlGetTimetable->execute();
	$presentTimetable = $sqlGetTimetable->fetchAll();
	return $presentTimetable;
}


function tempGETTER(){

	$sqlCheckID = $conn->prepare("SELECT * FROM `KursMS16` WHERE KursID IN (SELECT `USER_PLAN_ARRAY` FROM `MeinStundenplan` WHERE USER_ID = 1)");
	$sqlCheckID->execute();
	$tempCheckID = $sqlCheckID->fetchAll();
	return $tempCheckID;
}
