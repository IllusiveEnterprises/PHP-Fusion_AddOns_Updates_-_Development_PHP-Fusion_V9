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

if (!defined("DB_D1JR_conf")) {
	define("DB_D1JR_conf", DB_PREFIX."d1_job_rewards_config");
}
if (!defined("DB_D1JR_jobs")) {
	define("DB_D1JR_jobs", DB_PREFIX."d1_job_rewards_jobs");
}
if (!defined("DB_D1JR_user")) {
	define("DB_D1JR_user", DB_PREFIX."d1_job_rewards_user");
}
if (!defined("DB_D1JR_bewerbung")) {
	define("DB_D1JR_bewerbung", DB_PREFIX."d1_job_rewards_bewerbung");
}
?>