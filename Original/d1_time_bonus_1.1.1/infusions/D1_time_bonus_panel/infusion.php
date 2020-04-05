<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
| CVS Version: 1.00
| Author: DeeoNe
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

include INFUSIONS."D1_time_bonus_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_time_bonus_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_time_bonus_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_time_bonus_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['D1TB_title'];
$inf_description = $locale['D1TB_desc'];
$inf_version = $locale['D1TB_version'];
$inf_developer = "DeeoNe";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.deeone.de";

$inf_folder = "D1_time_bonus_panel"; // The folder in which the infusion resides.

// Delete any items not required below.

$inf_newtable[1] = DB_d1_tbconf." (
conf TINYINT(1) NOT NULL default '0',
tb_scores VARCHAR(200) DEFAULT '' NOT NULL,
tb_scoresname VARCHAR(200) DEFAULT '' NOT NULL,
tb_time VARCHAR(200) DEFAULT '' NOT NULL,
tb_punkte VARCHAR(200) DEFAULT '' NOT NULL,
tb_intervall VARCHAR(200) DEFAULT '' NOT NULL,
inf_name VARCHAR(100) NOT NULL DEFAULT '',
site_url VARCHAR(100) NOT NULL DEFAULT '',
tb_panelart TINYINT(1) NOT NULL default '0',
tb_punkte_list VARCHAR(20) DEFAULT '' NOT NULL,
tb_zweiter TINYINT(1) NOT NULL default '0',
tb_scores2 VARCHAR(200) DEFAULT '' NOT NULL,
tb_scores2on TINYINT(1) NOT NULL default '0',

PRIMARY KEY  (conf)
) ENGINE=MyISAM;";

$inf_newtable[2] = DB_d1_tbuser." (
user_id INT(10) NOT NULL,
user_name VARCHAR(200) DEFAULT '' NOT NULL,
time_von INT(10) NOT NULL,
time_bis INT(10) NOT NULL,
user_punkte INT(10) NOT NULL,
user_punkte2 INT(10) NOT NULL,
user_punkte3 INT(10) NOT NULL,
time2_von INT(10) NOT NULL,
time2_bis INT(10) NOT NULL,
PRIMARY KEY  (user_id)
) ENGINE=MyISAM;";


$inf_insertdbrow[1] = DB_d1_tbconf." SET conf='1', tb_scores='10', tb_scoresname='Scores', tb_time='60', tb_punkte='1', tb_intervall='60', inf_name = '', site_url = '', tb_panelart = '0', tb_punkte_list = 'user_punkte', tb_zweiter = '0', tb_scores2='5', tb_scores2on='0' ";
$inf_insertdbrow[2] = DB_PANELS." SET panel_name='".$locale['D1TB_title']."', panel_filename='".$inf_folder."', panel_side='4', panel_order='2', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

$inf_droptable[1] = DB_d1_tbconf;
//$inf_droptable[2] = DB_d1_tbuser;

$inf_altertable[1] = DB_d1_tbconf." ADD tb_panelart TINYINT(1) NOT NULL default '0'";
$inf_altertable[2] = DB_d1_tbuser." ADD user_punkte2 INT(10) NOT NULL";
$inf_altertable[3] = DB_d1_tbuser." ADD user_punkte3 INT(10) NOT NULL";
$inf_altertable[4] = DB_d1_tbconf." ADD tb_punkte_list VARCHAR(20) NOT NULL default 'user_punkte'";
$inf_altertable[5] = DB_d1_tbconf." ADD tb_zweiter TINYINT(1) NOT NULL default '0'";
$inf_altertable[6] = DB_d1_tbuser." ADD time2_von INT(10) NOT NULL";
$inf_altertable[7] = DB_d1_tbuser." ADD time2_bis INT(10) NOT NULL";
$inf_altertable[8] = DB_d1_tbconf." ADD tb_scores2  VARCHAR(20) NOT NULL default '5'";
$inf_altertable[9] = DB_d1_tbconf." ADD tb_scores2on TINYINT(1) NOT NULL default '0'";

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";


$inf_adminpanel[1] = array(
	"title" => $locale['D1TB_title'],
	"image" => "timebonus.png",
	"panel" => "admin.php",
	"rights" => "D1TB"
);

$inf_sitelink[1] = array(
	"title" => $locale['D1TB_title'],
	"url" => "D1_time_bonus_rank.php",
	"visibility" => "101" // 0 - Guest / 101 - Member / 102 - Admin / 103 - Super Admin.
);

?>