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

include INFUSIONS."scoresystem_panel/infusion_db.php";
if (file_exists(INFUSIONS."scoresystem_panel/locale/".LOCALESET."index.php")) {
	include INFUSIONS."scoresystem_panel/locale/".LOCALESET."index.php";
} else {
	include INFUSIONS."scoresystem_panel/locale/German/index.php";
}

$inf_title = $locale['pfss_title'];
$inf_description = $locale['pfss_desc'];
$inf_version = "1.1";
$inf_developer = "PHPFusion-SupportClub.de";
$inf_email = "info@phpfusion-supportclub.de";
$inf_weburl = "http://www.phpfusion-supportclub.de";
$inf_folder = "scoresystem_panel";

$inf_newtable[1] = DB_SCORE_ACCOUNT." (
acc_user_id				MEDIUMINT(8) NOT NULL,
acc_score					MEDIUMINT(8) NOT NULL DEFAULT '0',
PRIMARY KEY  (acc_user_id)
) ENGINE=MyISAM;";

$inf_newtable[2] = DB_SCORE_TRANSFER." (
tra_id						MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
tra_user_id				MEDIUMINT(8) NOT NULL DEFAULT '0',
tra_titel					TEXT NOT NULL,
tra_typ						CHAR(1) NOT NULL DEFAULT 'O',
tra_aktion				VARCHAR(5) NOT NULL DEFAULT '-',
tra_score					INT(9) NOT NULL DEFAULT '0',
tra_status				TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
tra_time					INT(10) NOT NULL DEFAULT '0',
PRIMARY KEY  (tra_id)
) ENGINE=MyISAM;";

$inf_newtable[3] = DB_SCORE_BAN." (
ban_id						MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
ban_user_id				MEDIUMINT(8) NOT NULL DEFAULT '0',
ban_time_start		INT(10) NOT NULL DEFAULT '0',
ban_time_stop			INT(10) NOT NULL DEFAULT '0',
ban_text					TEXT NOT NULL,
ban_admin_id			MEDIUMINT(8) NOT NULL DEFAULT '0',
PRIMARY KEY (ban_id)
) ENGINE=MyISAM;";

$inf_newtable[4] = DB_SCORE_SCORE." (
sco_id						MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
sco_aktion				VARCHAR(5) NOT NULL DEFAULT '-',
sco_titel					TEXT NOT NULL,
sco_score					INT(9) NOT NULL DEFAULT '0',
sco_max						INT(6) NOT NULL DEFAULT '5',
sco_status				TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
sco_power					TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (sco_id)
) ENGINE=MyISAM;";

$inf_newtable[5] = DB_SCORE_SETTINGS." (
set_id						SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
set_delete				TINYINT(4) UNSIGNED NOT NULL DEFAULT '0',
set_panel					TINYINT(4) UNSIGNED NOT NULL DEFAULT '5',
set_user_transfer	TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
set_user_tra_sco	INT(9) NOT NULL DEFAULT '5',
set_units					TEXT NOT NULL,
set_user_chance		TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
set_sco_power			TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
set_top_user			MEDIUMINT(8) NOT NULL DEFAULT '0',
set_data					TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
set_tceoxdte			TEXT NOT NULL,
set_tdeaxtte			INT(10) UNSIGNED NOT NULL DEFAULT '0',
PRIMARY KEY (set_id)
) ENGINE=MyISAM;";

$inf_insertdbrow[1] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('1', 'GBUCH', '".$locale['pfss_install1']."', '2', '1', '1', '1')";
$inf_insertdbrow[2] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('2', 'ARTIK', '".$locale['pfss_install2']."', '2', '5', '0', '1')";
$inf_insertdbrow[3] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('3', 'NEWS', '".$locale['pfss_install3']."', '2', '5', '0', '1')";
$inf_insertdbrow[4] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('4', 'FOVOT', '".$locale['pfss_install4']."', '2', '2', '0', '1')";
$inf_insertdbrow[5] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('5', 'FOBEI', '".$locale['pfss_install5']."', '2', '5', '0', '1')";
$inf_insertdbrow[6] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('6', 'FOTRD', '".$locale['pfss_install6']."', '5', '3', '0', '1')";
$inf_insertdbrow[7] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('7', 'SHBOX', '".$locale['pfss_install7']."', '2', '5', '0', '1')";
$inf_insertdbrow[8] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('8', 'GAMEK', '".$locale['pfss_install8']."', '5', '5', '0', '1')";
$inf_insertdbrow[9] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('9', 'GAMEG', '".$locale['pfss_install9']."', '5', '5', '0', '1')";
$inf_insertdbrow[10] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('10', 'GAMEH', '".$locale['pfss_install10']."', '10', '5', '0', '1')";
$inf_insertdbrow[11] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('11', 'FOTOS', '".$locale['pfss_install11']."', '2', '5', '0', '1')";
$inf_insertdbrow[12] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('12', 'LINKS', '".$locale['pfss_install12']."', '2', '5', '0', '1')";
$inf_insertdbrow[13] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('13', 'PNSEN', '".$locale['pfss_install13']."', '1', '2', '0', '1')";
$inf_insertdbrow[14] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('14', 'DOWNL', '".$locale['pfss_install14']."', '10', '5', '0', '1')";
$inf_insertdbrow[15] = DB_SCORE_SCORE." (sco_id, sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('15', 'LOGIN', '".$locale['pfss_install15']."', '1', '3', '0', '1')";
$inf_insertdbrow[16] = DB_SCORE_SETTINGS." (set_id, set_delete, set_panel, set_user_transfer, set_user_tra_sco, set_units, set_user_chance, set_sco_power, set_top_user) VALUES('1', '0', '5', '0', '5', '".$locale['pfss_install16']."', '0', '0', '0')";

$inf_altertable[1] = DB_SCORE_SETTINGS." ADD set_sco_power TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER set_user_chance";
$inf_altertable[2] = DB_SCORE_SETTINGS." ADD set_top_user MEDIUMINT(8) NOT NULL DEFAULT '0' AFTER set_sco_power";
$inf_altertable[3] = DB_SCORE_SETTINGS." ADD set_data TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER set_top_user";

$inf_droptable[1] = DB_SCORE_ACCOUNT;
$inf_droptable[2] = DB_SCORE_TRANSFER;
$inf_droptable[3] = DB_SCORE_BAN;
$inf_droptable[4] = DB_SCORE_SCORE;
$inf_droptable[5] = DB_SCORE_SETTINGS;

$inf_adminpanel[1] = array(
	"title" => $locale['pfss_install_admin1'],
	"image" => "infusion_scoresystem.gif",
	"panel" => "scoresystem_admin.php",
	"rights" => "PFSS"
);

$inf_adminpanel[2] = array(
	"title" => $locale['pfss_install_admin2'],
	"image" => "infusion_scoresystem.gif",
	"panel" => "scoresystem_admin.php",
	"rights" => "PFSB"
);

$inf_adminpanel[3] = array(
	"title" => $locale['pfss_install_admin3'],
	"image" => "infusion_scoresystem.gif",
	"panel" => "scoresystem_admin.php",
	"rights" => "PFST"
);

$inf_adminpanel[4] = array(
	"title" => $locale['pfss_install_admin4'],
	"image" => "infusion_scoresystem.gif",
	"panel" => "scoresystem_admin.php",
	"rights" => "PFSO"
);
?>