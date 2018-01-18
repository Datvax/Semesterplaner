<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.01.2018
 * Time: 16:47
 */

/**
 * @param string $userSelector
 * @param string $anonymousID
 * @param array $timetableID
 * @return array
 */
function sendTimetableIDs($userSelector = null, $anonymousID = null, array $timetableID){
	include 'connect.php';
	if(!empty($userSelector)){
		$sqlSetVariable = $conn->prepare("SET @userIDCreateTable = (SELECT `userID` FROM `auth_tokens` WHERE selector = ?);");
		$sqlSetVariable->execute(array($userSelector));
	}else{
		$sqlSetVariable = $conn->prepare("SET @userIDCreateTable = NULL;");
		$sqlSetVariable->execute(array($userSelector));
	}
	$sqlUserPlanInserter = $conn->prepare("
	INSERT INTO `MeinStundenplanLarge`(
	`USER_ID`,
	`ANONYMOUS_ID`,
	`USER_PLAN_0`,
	`USER_PLAN_1`,
	`USER_PLAN_2`,
	`USER_PLAN_3`,
	`USER_PLAN_4`,
	`USER_PLAN_5`,
	`USER_PLAN_6`,
	`USER_PLAN_7`,
	`USER_PLAN_8`,
	`USER_PLAN_9`,
	`USER_PLAN_10`,
	`USER_PLAN_11`,
	`USER_PLAN_12`,
	`USER_PLAN_13`,
	`USER_PLAN_14`)
	VALUES
	(@userIDCreateTable,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
	");
	$sqlUserPlanInserter->execute(array($anonymousID,$timetableID[0],$timetableID[1],$timetableID[2],$timetableID[3],$timetableID[4],$timetableID[5],$timetableID[6],$timetableID[7],$timetableID[8],$timetableID[9],$timetableID[10],$timetableID[11],$timetableID[12],$timetableID[13],$timetableID[14]));

	//Returns the newly created ID
	return $conn->lastInsertId();
}

/**
 * @param string $userSelector
 * @param array $timetableID
 * @return integer
 */
function updateTimetableIDs($userSelector = null, array $timetableID = null){
	include 'connect.php';
	if(!empty($userSelector)){
		$sqlSetVariable = $conn->prepare("SET @userIDUpdateTable = (SELECT `userID` FROM `auth_tokens` WHERE selector = ?);");
		$sqlSetVariable->execute(array($userSelector));
		$sqlUserPlanInserter = $conn->prepare("
		UPDATE `MeinStundenplanLarge`
		SET
		`USER_PLAN_0`=?,
		`USER_PLAN_1`=?,
		`USER_PLAN_2`=?,
		`USER_PLAN_3`=?,
		`USER_PLAN_4`=?,
		`USER_PLAN_5`=?,
		`USER_PLAN_6`=?,
		`USER_PLAN_7`=?,
		`USER_PLAN_8`=?,
		`USER_PLAN_9`=?,
		`USER_PLAN_10`=?,
		`USER_PLAN_11`=?,
		`USER_PLAN_12`=?,
		`USER_PLAN_13`=?,
		`USER_PLAN_14`=?
		WHERE `USER_ID` = @userIDUpdateTable"
		);
		$sqlUserPlanInserter->execute(array($timetableID[0],$timetableID[1],$timetableID[2],$timetableID[3],$timetableID[4],$timetableID[5],$timetableID[6],$timetableID[7],$timetableID[8],$timetableID[9],$timetableID[10],$timetableID[11],$timetableID[12],$timetableID[13],$timetableID[14]));

		//Returns the newly created ID
		return $conn->lastInsertId();
	}else{
		return false;
	}
}

/**
 * @param string $uniqueID
 * @return integer
 */
function createAnonymousUser($uniqueID){
	include 'connect.php';
	$sqlAnonymousUser = $conn->prepare("INSERT INTO `HAW_ANONYMOUS_TIMETABLE`(`UNIQUE_ID`) VALUES (?)");
	$sqlAnonymousUser->execute(array($uniqueID));

	//Returns the newly created ID
	return $conn->lastInsertId();
}