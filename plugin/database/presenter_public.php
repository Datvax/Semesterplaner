<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.01.2018
 * Time: 16:46
 */
$presenterFile = true;


/**
 * joins the actual timetable with the list of classes to create a readable timetable
 * @param $ClassYear
 * @return mixed
 */
function getReadableTimetable($ClassYear) {
	include 'connect.php';
	$sqlClassNames = $conn->prepare("SELECT ".$ClassYear.".Kursname FROM ".$ClassYear." JOIN StundenplanMS ON ".$ClassYear.".KursID=StundenplanMS.KursID");
	$sqlClassNames->execute();
	$tempClassNames = $sqlClassNames->fetchAll();
	return $tempClassNames;
}

/**
 * gets all id's for the classes from the timetable
 * @param $timetable
 * @return mixed
 */
function getTimetableClassIDs($timetable){
	include 'connect.php';
	$sqlClassNames = $conn->prepare("SELECT `KursID` FROM ".$timetable);
	$sqlClassNames->execute();
	$tempClassNames = $sqlClassNames->fetchAll();
	return $tempClassNames;
}

/**
 * gets all id's for the classes from the timetable
 * @param $userSelector
 * @return mixed
 */
function getPersonalTimetable($userSelector){
	include 'connect.php';
	$sqlSetVariable = $conn->prepare("SET @userID = (SELECT `userID` FROM `auth_tokens` WHERE selector = ?);");
	$sqlSetVariable->execute(array($userSelector));
	$sqlTableIDs = $conn->prepare("SELECT `USER_PLAN_0` as '', `USER_PLAN_1` as '', `USER_PLAN_2` as '', `USER_PLAN_3` as '', `USER_PLAN_4` as '', `USER_PLAN_5` as '', `USER_PLAN_6` as '', `USER_PLAN_7` as '', `USER_PLAN_8` as '', `USER_PLAN_9` as '', `USER_PLAN_10` as '', `USER_PLAN_11` as '', `USER_PLAN_12` as '', `USER_PLAN_13` as '', `USER_PLAN_14` as '' FROM `MeinStundenplanLarge` WHERE USER_ID = @userID");
	$sqlTableIDs->execute();
	$tempTableIDs = $sqlTableIDs->fetch();
	return $tempTableIDs;
}

/**
 * @param $planID
 * @return mixed
 */
function checkForID($planID){
	include 'connect.php';
	$sqlCheckID = $conn->prepare("SELECT count(*) FROM `MeinStundenplanLarge` WHERE USER_PLAN_ID = ?");
	$sqlCheckID->execute(array($planID));
	$tempCheckID = $sqlCheckID->fetch();
	return $tempCheckID;
}

/**
 * @param array $tableIDs
 * @return mixed
 */
function getTimeIDs(array $tableIDs){
	$questionMarkAmount = join(",",array_fill(0,count($tableIDs),"?"));
	include 'connect.php';
	$sqlGetTimeIDs = $conn->prepare("SELECT `TIME_ID` as '' FROM `StundenplanMS` WHERE KursID IN ($questionMarkAmount)");
	$sqlGetTimeIDs->execute($tableIDs);
	$tempGetTimeIDs = $sqlGetTimeIDs->fetchAll();
	return $tempGetTimeIDs;
}

/**
 * @param string $userSelector
 * @return boolean
 */
function checkForUserTimetable($userSelector){
	include 'connect.php';
	$sqlCheckTimetable = $conn->prepare("SELECT EXISTS (SELECT * FROM `MeinStundenplanLarge` WHERE USER_ID = (SELECT `userID` FROM `auth_tokens` WHERE selector = ?))");
	$sqlCheckTimetable->execute(array($userSelector));
	$tempCheckTimetable = $sqlCheckTimetable->fetch();
	return $tempCheckTimetable;
}

/**
 * @param null $userSelector
 * @param null $uniqueAnonymousID
 * @return array
 */
function showUserTimetable($userSelector = null, $uniqueAnonymousID = null){
	include 'connect.php';
	if(!empty($userSelector)) {
		$sqlSetVariable = $conn->prepare("SET @userID = (SELECT `userID` FROM `auth_tokens` WHERE selector = ?);");
		$sqlSetVariable->execute(array($userSelector));
		$sqlGetTimetable = $conn->prepare("
		SELECT * FROM (SELECT KursMS16.Kursname, StundenplanMS.TAG_ID, StundenplanMS.UHRZEIT, KursMS16.KursID AS newKursID, KursMS16.Raum FROM `KursMS16` JOIN StundenplanMS ON KursMS16.KursID=StundenplanMS.KursID)
		as tempKursTable WHERE newKursID IN (
		(SELECT `USER_PLAN_0` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_1` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_2` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_3` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_4` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_5` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_6` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_7` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_8` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_9` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_10` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_11` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_12` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_13` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID),
		(SELECT `USER_PLAN_14` FROM `MeinStundenplanLarge` WHERE USER_ID = @userID)
		) ORDER BY UHRZEIT ASC, TAG_ID ASC;
		");
		$sqlGetTimetable->execute();
		$presentTimetable = $sqlGetTimetable->fetchAll();
		return $presentTimetable;
	}else if(!empty($uniqueAnonymousID)){
		$sqlSetVariable = $conn->prepare("SET @anonymousID = (SELECT `ANONYMOUS_ID` FROM `HAW_ANONYMOUS_TIMETABLE` WHERE `UNIQUE_ID` = ?);");
		$sqlSetVariable->execute(array($uniqueAnonymousID));
		$sqlGetTimetable = $conn->prepare("
		SELECT * FROM (SELECT KursMS16.Kursname, StundenplanMS.TAG_ID, StundenplanMS.UHRZEIT, KursMS16.KursID AS newKursID, KursMS16.Raum FROM `KursMS16` JOIN StundenplanMS ON KursMS16.KursID=StundenplanMS.KursID)
		as tempKursTable WHERE newKursID IN (
		(SELECT `USER_PLAN_0` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_1` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_2` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_3` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_4` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_5` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_6` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_7` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_8` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_9` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_10` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_11` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_12` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_13` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID),
		(SELECT `USER_PLAN_14` FROM `MeinStundenplanLarge` WHERE ANONYMOUS_ID = @anonymousID)
		) ORDER BY UHRZEIT ASC, TAG_ID ASC;
		");
		$sqlGetTimetable->execute();
		$presentTimetable = $sqlGetTimetable->fetchAll();
		return $presentTimetable;
	}else{
		return array(null);
	}
}

/**
 * @return mixed
 */
function tempGETTER(){
	include 'connect.php';
	$sqlCheckID = $conn->prepare("SELECT * FROM `KursMS16` WHERE KursID IN (SELECT `USER_PLAN_ARRAY` FROM `MeinStundenplan` WHERE USER_ID = 1)");
	$sqlCheckID->execute();
	$tempCheckID = $sqlCheckID->fetchAll();
	return $tempCheckID;
}