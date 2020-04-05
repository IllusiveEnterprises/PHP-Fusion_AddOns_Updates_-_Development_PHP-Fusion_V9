<?php
/*----------------------------------------------------+
| D1 Pinnwand                           	
|-----------------------------------------------------|
| Author: DeeoNe
| Web: http://www.DeeoNe.de          	
| Email: deeone@online.de                  	
|-----------------------------------------------------|
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+----------------------------------------------------*/
include LOCALE.LOCALESET."search.php";
if (!defined("IN_FUSION")) {fallback(BASEDIR."index.php");}

if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."search.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."search.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/search.php";
}

if (isset($_GET['rowstart'])) $rowstart = $_GET['rowstart'];
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

if (file_exists(INFUSIONS."D1_pinnwand_panel/pinnwand_includes.php")) {
	include INFUSIONS."D1_pinnwand_panel/pinnwand_includes.php";
	d1_pinnwand_searchpinnwands();
} else {
	opentable("Error");
	echo 'Failed loading requested file (pinnwand_include.php)! Please check your files.';
	closetable();
}
?>