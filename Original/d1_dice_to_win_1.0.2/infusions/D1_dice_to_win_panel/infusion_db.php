<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
| CVS Version: 1.00
| Author: INSERT NAME HERE
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (!defined("DB_D1DW")) {
	define("DB_D1DW", DB_PREFIX."d1_dicetowin");
}
if (!defined("DB_D1DW_conf")) {
	define("DB_D1DW_conf", DB_PREFIX."d1_dicetowin_config");
}
if (!defined("DB_D1DW_user")) {
	define("DB_D1DW_user", DB_PREFIX."d1_dicetowin_user");
}
if (!defined("DB_D1DW_log")) {
	define("DB_D1DW_log", DB_PREFIX."d1_dicetowin_log");
}
if (!defined("DB_D1DW_chat")) {
	define("DB_D1DW_chat", DB_PREFIX."d1_dicetowin_chat");
}
?>