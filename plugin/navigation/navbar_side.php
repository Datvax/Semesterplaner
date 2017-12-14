<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 13.12.2017
 * Time: 16:28
 */

function navbarSide(array $sideURlsAndNames){
	/**Creates a variable that will be returned**/
	if(!empty($sideURlsAndNames)){
		$navbar = '
    	<div id="navbar--side--container">
    	    <ul id="navbar--side">';
		/**
		 * Goes through the given array and sets the URLs and Names
		 * Be careful:
		 * The given array has to have three dimensions, it should look
		 * something like this:
		 *
		 *  $sideURlsAndNames = array(
		 *								["Filename_One","Name_One"],
		 *								["Filename_Two","Name_Two"],
		 *								["Filename_Three","Name_Three"]);
		 **/
		for($runTracer = 0; $runTracer < count($sideURlsAndNames); $runTracer++){
			if(compareURLtoCurrentURL($sideURlsAndNames[$runTracer][0])){
				$navbar .='<li class="navbar--side--point navbar--cur">'.$sideURlsAndNames[$runTracer][1].'';
			}else{
				$navbar .='<li class="navbar--side--point"><a class="navLink" href="/project/HAW/Semesterplan/'.$sideURlsAndNames[$runTracer][0].'.php">'.$sideURlsAndNames[$runTracer][1].'</a>';
			}
			$navbar .='</li>';
		}
		$navbar .='
			</ul>
    	</div>';
	}else{
		$navbar = "";
	}
	return $navbar;
}

/**Additional functions, not exactly necessary**/
function getCurrentURL(){
	return $_SERVER['HTTP_HOST']."".rtrim($_SERVER['PHP_SELF'], '/\\');
}
function compareURLtoCurrentURL($sideName){
	if(($_SERVER['HTTP_HOST']."".rtrim(dirname($_SERVER['PHP_SELF']), '/\\')."/".$sideName.".php") == ($_SERVER['HTTP_HOST']."".rtrim($_SERVER['PHP_SELF'], '/\\'))){
		return true;
	}
	else{
		return false;
	}
}