<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 19.10.2017
 * Time: 19:05
 */

function SemesterTable($tableClass, $semesterCount,array $weekdays,array $semesterClasses = null){
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
	/**end of table head**/
	/**and**/
	/**start table body**/
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
				<td>
					".$weekdays[$runChell]."
				</td>
		";
		for($runLara = 1; $runLara <= $semesterCount; $runLara++){
			$newSemesterTable .= "
				<td class='timetable--hours'>
					<div class='timetable--hour--1'>
						<input type='checkbox' value='".$semesterClasses[$hourCounter + $dayCounter][0]."' id='checkbox--timetable--".($hourCounter + $dayCounter)."' class='checkbox--timetable'>
						<label class='label--timetable' for='checkbox--timetable--".($hourCounter + $dayCounter)."'>".$semesterClasses[$hourCounter + $dayCounter][0]."</label>
					</div>
					<div class='timetable--hour--2'>
						<input type='checkbox' value='".$semesterClasses[$hourCounter + $dayCounter +1][0]."' id='checkbox--timetable--".($hourCounter + $dayCounter +1)."' class='checkbox--timetable'>
						<label class='label--timetable' for='checkbox--timetable--".($hourCounter + $dayCounter +1)."'>".$semesterClasses[$hourCounter  + $dayCounter +1][0]."</label>
					</div>
					<div class='timetable--hour--3'>
						<input type='checkbox' value='".$semesterClasses[$hourCounter + $dayCounter +2][0]."' id='checkbox--timetable--".($hourCounter + $dayCounter +2)."' class='checkbox--timetable'>
						<label class='label--timetable' for='checkbox--timetable--".($hourCounter + $dayCounter +2)."'>".$semesterClasses[$hourCounter  + $dayCounter +2][0]."</label>
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