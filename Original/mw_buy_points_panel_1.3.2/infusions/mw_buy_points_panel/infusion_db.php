<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusions_db.php
| Version: 1.2.0
| Author: Matze-W & DeeoNe
| Site: http://www.DeeoNe.de
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

if (!defined("MW_BP_SET")) {
	define("MW_BP_SET", DB_PREFIX."mw_buy_points_settings");
}
if (!defined("MW_BP_BANK")) {
	define("MW_BP_BANK", DB_PREFIX."mw_buy_points_bank");
}
if (!defined("MW_BP_POINTS")) {
	define("MW_BP_POINTS", DB_PREFIX."mw_buy_points_points");
}
if (!defined("MW_BP_PAY")) {
	define("MW_BP_PAY", DB_PREFIX."mw_buy_points_pay");
}
if (!defined("MW_BP_STATUS")) {
	define("MW_BP_STATUS", DB_PREFIX."mw_buy_points_status");
}
?>