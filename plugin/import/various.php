<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 31.10.2017
 * Time: 16:24
 */

function replaceStrInArray($search, $replace, $subjectArray){
	/**
	 * 1. encode the array with json_encode to an json string witch looks like this:
	 * 	[{"Kursname":"Mathematik 1","0":"Mathematik 1"},{"Kursname":"Mathematik 1","0":"Mathematik 1"}]
	 * 2. searches for the what is given in $search and replaces it with what is given in $replace
	 * 3.creates a new array with json_decode
	 * 	Important! set the second parameter to true to get an associative array
	 */
	return json_decode(str_replace($search,$replace,json_encode($subjectArray)),true);
}