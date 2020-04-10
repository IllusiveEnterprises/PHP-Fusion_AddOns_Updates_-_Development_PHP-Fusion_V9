<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (c) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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

$settings = fusion_get_settings();

include INFUSIONS."mw_premium_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_premium_panel/locale/German.php";
}

// Infusion general information
$inf_title = "MW Premium Panel";
$inf_description = "Premium-System";
$inf_version = "1.0.0";
$inf_developer = "Matze-W";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.DeeoNe.de";
$inf_image = "premium.png";

$inf_folder = "mw_premium_panel"; // The folder in which the infusion resides.

$inf_newtable[] = MW_PREMIUM." (
user_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
time_on INT(10) UNSIGNED NOT NULL DEFAULT '0',
time_off INT(10) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

$inf_newtable[] = MW_PREMIUM_SET." (
set_id TINYINT(1) UNSIGNED NOT NULL DEFAULT '0', 
set_group MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (set_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

$inf_newtable[] = MW_PREMIUM_PACK." (
pack_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT, 
pack_time INT(10) UNSIGNED NOT NULL DEFAULT '0',
pack_price INT(10) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (pack_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

$inf_insertdbrow[] = MW_PREMIUM_SET." (set_id, set_group) VALUES ('1', '0')";
$inf_insertdbrow[] = DB_PANELS." SET panel_name='', panel_filename='".$inf_folder."', panel_side=4, panel_order='2', panel_type='file', panel_access='0', panel_display='0', panel_status='1' ";

$inf_droptable[] = MW_PREMIUM;
$inf_droptable[] = MW_PREMIUM_SET;
$inf_droptable[] = MW_PREMIUM_PACK;

$inf_deldbrow[] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[] = array(
	"title" => "MW Premium",
    "image" => $inf_image,
    "page"     => 5,
	"panel" => "mw_premium_admin.php",
	"rights" => "MWP"
);
?>