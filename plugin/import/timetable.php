<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 19.10.2017
 * Time: 19:05
 */

function SemesterTable($tableClass, $semesterCount,array $weekdays,array $semesterClasses = null, array $semesterClasseID){
	/**make sure that there are enough ID's for every span in the table**/
	if(count($semesterClasseID) <= (15*$semesterCount)){
		for($runCat = count($semesterClasseID); $runCat < (15*$semesterCount); $runCat++){
			$semesterClasseID[$runCat][0]="1";
			//array_push($semesterClasseID,"1");
		}
	}
	/**table head**/
	$newSemesterTable = "
	<table class='".$tableClass."'>
		<thead>
			<tr>
				<th>
					Tag
				</th>
	";
	for($runChell = 1; $runChell <= $semesterCount; $runChell++){
		$newSemesterTable .= "
				<th>
					".$runChell.". Semester
				</th>
	";
	}
	/**
	 * end of table head
	 * and
	 * start table body
	 */
	$newSemesterTable .= "
			</tr>
		</thead>
		<tbody>
	";
	$hourCounter = 0;
	for($runChell = 0; $runChell <= 4; $runChell++) {
		$dayCounter = 0;
		$newSemesterTable .= "
			<tr>
				<td class='timetable--weekdays'>
					".$weekdays[$runChell]."
				</td>
		";
		for($runLara = 1; $runLara <= $semesterCount; $runLara++){
			/**
			 * input:
			 * 	type: checkbox
			 * 	name: the names have these [] to use them as an array
			 * 	value: ID of the class that is shown in the Label
			 * 	id: 'checkbox--timetable--[counter of the table]
			 * label:
			 * 	class: just for css purposes
			 * 	for: relates to the id of the checkbox
			 * Note that the checkbox is hidden but works the same as a usual checkbox
			 */
			$newSemesterTable .= "
				<td class='timetable--hours'>
					<div class='timetable--hour--1'>";
					if(($semesterClasseID[$hourCounter + $dayCounter][0])>1){
						$newSemesterTable .= "
						<input type='checkbox' name='timetable--Checkbox--ID[]' value='".$semesterClasseID[$hourCounter + $dayCounter][0]."' id='checkbox--timetable--".($hourCounter + $dayCounter)."' class='checkbox--timetable'>
						<label class='label--timetable' for='checkbox--timetable--".($hourCounter + $dayCounter)."'>".$semesterClasses[$hourCounter + $dayCounter][0]."</label>";
					}
					$newSemesterTable .= "</div>
					<div class='timetable--hour--2'>";
					if(($semesterClasseID[$hourCounter + $dayCounter +1][0])>1){
						$newSemesterTable .= "
						<input type='checkbox' name='timetable--Checkbox--ID[]' value='".$semesterClasseID[$hourCounter + $dayCounter +1][0]."' id='checkbox--timetable--".($hourCounter + $dayCounter +1)."' class='checkbox--timetable'>
						<label class='label--timetable' for='checkbox--timetable--".($hourCounter + $dayCounter +1)."'>".$semesterClasses[$hourCounter  + $dayCounter +1][0]."</label>";
					}
					$newSemesterTable .= "</div>
					<div class='timetable--hour--3'>";
					if(($semesterClasseID[$hourCounter + $dayCounter +2][0])>1){
						$newSemesterTable .= "
						<input type='checkbox' name='timetable--Checkbox--ID[]' value='".$semesterClasseID[$hourCounter + $dayCounter +2][0]."' id='checkbox--timetable--".($hourCounter + $dayCounter +2)."' class='checkbox--timetable'>
						<label class='label--timetable' for='checkbox--timetable--".($hourCounter + $dayCounter +2)."'>".$semesterClasses[$hourCounter  + $dayCounter +2][0]."</label>";
					}
					$newSemesterTable .= "
					</div>
				</td>
			";
			/**amount of divs per day times 5**/
			$dayCounter = $dayCounter + 15;
		}
		/**amount of divs per day**/
		$hourCounter = $hourCounter + 3;
		$newSemesterTable .= "
			</tr>
		";
	}
	/**end of table body**/
	$newSemesterTable .= "
		</tbody>
	</table>
	";
	return $newSemesterTable;
}


function userTable($tableClass ,array $weekdays,array $userTableData){
	/**replaces every "Freistunde" with an empty string**/
	include_once "various.php";
	$userTableData = replaceStrInArray("Freistunde","",$userTableData);

	/**create table head**/
	$newUserTable = "
	<table class='".$tableClass."'>
		<thead>
			<tr>
				<th>
					Uhrzeit
				</th>
	";
	for($runChell = 0; $runChell < count($weekdays); $runChell++){
		$newUserTable .= "
				<th>
					".$weekdays[$runChell]."
				</th>
	";
	}
	/**
	 * end of table head
	 * and
	 * start table body
	 */
	$newUserTable .= "
			</tr>
		</thead>
		<tbody>
	";
	$timeCounter = 0;
	/**Timestamps that will be shown in the timetable**/
	$semesterTime = [strtotime("08:30:00"), strtotime("13:00:00"), strtotime("17:00:00") ];
	/**Loops through the times with an offset of 30 min (1800 Unix timestamp)**/
	for($runChell = strtotime("00:00:00"); $runChell <= strtotime("23:59:59"); $runChell = $runChell + 1800) {
		$dayCounter = 1;
		/**Creates the times on the left of the table**/
		if($runChell == $semesterTime[0] || $runChell == $semesterTime[1] || $runChell == $semesterTime[2]){
			$newUserTable .= "
			<tr>
				<td class='timetable--time'>
					" .gmdate("H:i", $runChell)."
				</td>
			";
		}
		/**triggers at specific times**/
		if($runChell == strtotime("08:30:00")||$runChell == strtotime("13:00:00")||$runChell == strtotime("17:00:00")) {
			for ($runLara = 1; $runLara <= count($weekdays); $runLara++) {
				if($userTableData[$timeCounter][1]==$dayCounter){
					$writeClass = $userTableData[$timeCounter][0];
					if(strtotime($userTableData[$timeCounter][2]) == strtotime($userTableData[$timeCounter + 1][2])){
						$timeCounter++;
					}
				}else{
					$writeClass = null;
				}
				$newUserTable .= "
				<td class='timetable--hours'>
					<div class='timetable--hour--1'>
						" . $writeClass . "
					</div>
				</td>
				";
				$dayCounter++;
			}
			$timeCounter++;
		}
		$newUserTable .= "
			</tr>
		";
	}
	/**end of table body**/
	$newUserTable .= "
		</tbody>
	</table>
	";
	return $newUserTable;
}