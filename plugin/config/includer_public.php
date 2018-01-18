<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 18.01.2018
 * Time: 16:52
 */

/*
 * This file includes everything.
 * The Variable $includeSwitch controls what is being included.
 * Be aware of the order since some files need functions from
 * other files first.
 */

/*
 * Include essentials
 */
if($includeSwitch[0] == 1) {
	if (file_exists("config.php")) {
		include "config.php";
	};
	if (file_exists("plugin/navigation/navbar_side.php")) {
		include "plugin/navigation/navbar_side.php";
	}
	if (file_exists("plugin/header/header.php")) {
		include "plugin/header/header.php";
	}
}
/*
 * include database related essentials
 */
if($includeSwitch[1] == 1){
	if (file_exists("plugin/database/accountant.php")) {
		include "plugin/database/accountant.php";
	}
	if (file_exists("plugin/import/login.php")) {
		include "plugin/import/login.php";
	}
}
/*
 * include timetable related files
 */
if($includeSwitch[2] == 1) {
	if (file_exists("plugin/import/timetable.php")) {
		include "plugin/import/timetable.php";
	}
	if (file_exists("plugin/import/various.php")) {
		include "plugin/import/various.php";
	}
	if (file_exists("plugin/database/presenter.php")) {
		include "plugin/database/presenter.php";
	}
	if (file_exists("plugin/database/transmitter.php")) {
		include "plugin/database/transmitter.php";
	}
}
