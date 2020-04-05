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
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!defined("DB_D1PW")) {
	define("DB_D1PW", DB_PREFIX."d1_pinnwand_system");
}
if (!defined("DB_D1PW_settings")) {
	define("DB_D1PW_settings", DB_PREFIX."d1_pinnwand_system_settings");
}
if (!defined("DB_D1PW_votes")) {
	define("DB_D1PW_votes", DB_PREFIX."d1_pinnwand_votes");
}
if (!defined("DB_D1PW_comments")) {
	define("DB_D1PW_comments", DB_PREFIX."d1_pinnwand_comments");
}
?>