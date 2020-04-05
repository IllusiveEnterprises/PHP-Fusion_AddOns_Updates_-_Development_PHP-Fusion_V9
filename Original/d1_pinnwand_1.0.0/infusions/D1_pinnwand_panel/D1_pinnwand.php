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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_pinnwand_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_pinnwand_panel/locale/German.php";
}

if (isset($_GET['page'])) $page = $_GET['page'];
define("pinnwandCOPY", "<div style='text-align:center; margin:5px;'>D1 Pinnwand ".$locale['D1PW_vers']." &copy;2013 by <a href='http://www.deeone.de' target='_blank'>DeeoNe</a></div>");
if (isset($page) && !preg_match("/^[_0-9a-z]+$/i", $page));
if (file_exists(BASEDIR."pinnwand_convertcomments.php")) {
	opentable("Warning");
	echo 'Warning: pinnwand_convertcomments.php detected, please delete it immediately.';
	closetable();
}
if (isset($page) && file_exists(INFUSIONS."D1_pinnwand_panel/".$page.".php")) {
require_once(INFUSIONS."D1_pinnwand_panel/".$page.".php");
} else {
require_once(INFUSIONS."D1_pinnwand_panel/pinnwandlist.php");
redirect ("".INFUSIONS."D1_pinnwand_panel/D1_pinnwand_wall.php");
}
// You may NOT remove the copyright (pinnwandCOPY)
echo pinnwandCOPY;

	require_once THEMES."templates/footer.php";

?>