<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion_db.php
| Version: 1.0.0
| Author: Matze-W
| Site: http://matze-web.de
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

if (!defined("MW_PREMIUM")) {
	define("MW_PREMIUM", DB_PREFIX."mw_premium");
}
if (!defined("MW_PREMIUM_SET")) {
	define("MW_PREMIUM_SET", DB_PREFIX."mw_premium_set");
}
if (!defined("MW_PREMIUM_PACK")) {
	define("MW_PREMIUM_PACK", DB_PREFIX."mw_premium_pack");
}

?>