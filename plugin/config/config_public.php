<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.01.2018
 * Time: 16:51
 */

/*
 * here are the configurations for:
 */

/*
 * login for the database (not working)
 */
$databaseLoginPath = "connect.php";
/*
 * for the navigation
 */
$sideURlsAndNames = array(
	array("index","Home"),
	array("map","Karte"),
	array("timetable","Stundenplan")
);
/*
 * for the accountant
 */
$cookieName = "semseterplaner"; //Use this variable when asked for cookie name
$sessionUserID = "userID";	//Names the user id variable in the session
/*
 * for the timetables
 */
$weekDay = array("Montag","Dienstag","Mittwoch","Donnerstag","Freitag");