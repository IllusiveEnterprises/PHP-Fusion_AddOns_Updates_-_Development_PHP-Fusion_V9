<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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

$settings = fusion_get_settings();

include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['MFPS_title'];
$inf_description = $locale['MFPS_desc'];
$inf_version = $locale['MFPS_version'];
$inf_developer = "Comet1986 & DeeoNe";
$inf_email = "mf-community@hotmail.de";
$inf_weburl = "http://mf-community.net";
$inf_image = "premium.png";

$inf_folder = "MF-Premium-Scores_panel"; // The folder in which the infusion resides.

// Delete any items not required below.


$inf_newtable[] = DB_mfp_scores." (
user_id VARCHAR(50) DEFAULT '' NOT NULL,
status VARCHAR(200) DEFAULT '' NOT NULL,
seit VARCHAR(200) DEFAULT '' NOT NULL,
bis VARCHAR(200) DEFAULT '' NOT NULL,
PRIMARY KEY  (user_id)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";

$inf_newtable[] = DB_mfp_scores_conf." (
conf VARCHAR(50) DEFAULT '' NOT NULL,
prem_s_zeit VARCHAR(200) DEFAULT '' NOT NULL,
prem_m_zeit VARCHAR(200) DEFAULT '' NOT NULL,
prem_l_zeit VARCHAR(200) DEFAULT '' NOT NULL,
prem_s_preis VARCHAR(200) DEFAULT '' NOT NULL,
prem_m_preis VARCHAR(200) DEFAULT '' NOT NULL,
prem_l_preis VARCHAR(200) DEFAULT '' NOT NULL,
prem_gruppe VARCHAR(200) DEFAULT '' NOT NULL,
prem_vorteil TEXT NOT NULL,
prem_grafik TINYINT(1) NOT NULL default '1',
PRIMARY KEY  (conf)
) ENGINE=MyISAM DEFAULT CHARSET=UTF8 COLLATE=utf8_unicode_ci";


$inf_insertdbrow[] = DB_mfp_scores_conf." (conf, prem_s_zeit, prem_m_zeit, prem_l_zeit, prem_s_preis, prem_m_preis, prem_l_preis, prem_gruppe, prem_vorteil, prem_grafik) VALUES ('1', '86400', '604800', '2592000', '200', '1000', '3000', '1', '', '1')";


$inf_droptable[] = DB_mfp_scores;
$inf_droptable[] = DB_mfp_scores_conf;

/*$inf_altertable[] = DB_mfp_scores_conf." ADD prem_vorteil TEXT NOT NULL AFTER prem_gruppe";
$inf_altertable[] = DB_mfp_scores_conf." ADD prem_grafik TINYINT(1) NOT NULL default '1' AFTER prem_vorteil";
*/
$inf_adminpanel[] = array(
	"title" => $locale['MFPS_admin1'],
	"image" => $inf_image ,
	"panel" => "admin.php",
    "page"     => 5,
	"rights" => "MFPS"
);

$inf_sitelink[] = array(
	"title" => $locale['MFPS_link2'],
	"url" => "premium_admin_liste.php",
	"visibility" => "-102" // 0 - Guest / -101 - Member / -102 - Admin / -103 - Super Admin.
);

?>