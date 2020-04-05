<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
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

if (!defined("DB_SCORE_ACCOUNT")) {
	define("DB_SCORE_ACCOUNT", DB_PREFIX."score_account");
}

if (!defined("DB_SCORE_TRANSFER")) {
	define("DB_SCORE_TRANSFER", DB_PREFIX."score_transfer");
}

if (!defined("DB_SCORE_BAN")) {
	define("DB_SCORE_BAN", DB_PREFIX."score_ban");
}

if (!defined("DB_SCORE_SCORE")) {
	define("DB_SCORE_SCORE", DB_PREFIX."score_score");
}

if (!defined("DB_SCORE_SETTINGS")) {
	define("DB_SCORE_SETTINGS", DB_PREFIX."score_settings");
}
?>