<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
| CVS Version: 1.00
| Adapted to php-fusion-9 by Douwe Yntema
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

if (!defined("DB_D1CP")) {
	define("DB_D1CP", DB_PREFIX."d1_coupon");
}
if (!defined("DB_D1CP_conf")) {
	define("DB_D1CP_conf", DB_PREFIX."d1_coupon_config");
}
if (!defined("DB_D1CP_user")) {
	define("DB_D1CP_user", DB_PREFIX."d1_coupon_user");
}
?>