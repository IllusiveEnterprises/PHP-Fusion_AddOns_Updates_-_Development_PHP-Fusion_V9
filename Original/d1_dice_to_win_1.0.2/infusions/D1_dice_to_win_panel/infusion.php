<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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

include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_dice_to_win_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['D1DW_title'];
$inf_description = $locale['D1DW_desc'];
$inf_version = $locale['D1DW_vers'];
$inf_developer = "DeeoNe";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.deeone.de";

$inf_panel = "D1_dice_to_win";
$inf_folder = "D1_dice_to_win_panel"; // The folder in which the infusion resides.

// Delete any items not required below.
$inf_newtable[1] = DB_D1DW_conf." (
conf TINYINT(1) NOT NULL default '0',
dwin_scores VARCHAR(20) DEFAULT '' NOT NULL,
dwin_kosten INT(4) UNSIGNED NOT NULL default '0',
inf_name VARCHAR(100) NOT NULL DEFAULT '',
site_url VARCHAR(100) NOT NULL DEFAULT '',
jack_pot INT(10) UNSIGNED NOT NULL default '5',
wurf_panel TINYINT(1) UNSIGNED NOT NULL default '1',
dwin_chance INT(10) UNSIGNED NOT NULL default '20',
dwin_jstart INT(10) UNSIGNED NOT NULL default '5',
dwin_gpreis INT(10) UNSIGNED NOT NULL default '0',
dwin_fpreis INT(10) UNSIGNED NOT NULL default '200',
dwin_wzahl INT(10) UNSIGNED NOT NULL default '1',
dwin_gstatus TINYINT(1) UNSIGNED NOT NULL default '1',
lucky_number INT(10) UNSIGNED NOT NULL default '1',
lucky_win INT(10) UNSIGNED NOT NULL default '20',
chat_stat TINYINT(1) UNSIGNED NOT NULL default '1',
datab_stat TINYINT(1) UNSIGNED NOT NULL default '1',
dwin_multi INT(10) UNSIGNED NOT NULL default '1',
dwin_chatanz INT(10) UNSIGNED NOT NULL default '5',
dwin_wurfanz INT(10) UNSIGNED NOT NULL default '10',
dwin_reftime INT(10) UNSIGNED NOT NULL default '10',
ref_dice INT(10) UNSIGNED NOT NULL default '10',
ref_chat INT(10) UNSIGNED NOT NULL default '15',
PRIMARY KEY  (conf)
) ENGINE=MyISAM;";

$inf_newtable[2] = DB_D1DW_user." (
user_id VARCHAR(50) DEFAULT '' NOT NULL,
user_name VARCHAR(200) DEFAULT '' NOT NULL,
time VARCHAR(200) DEFAULT '' NOT NULL,
zahl VARCHAR(500) DEFAULT '' NOT NULL,
sonstiges VARCHAR(200) DEFAULT '' NOT NULL,
text VARCHAR(200) DEFAULT '' NOT NULL,
wurfel1 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel2 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel3 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel4 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel5 TINYINT(1) UNSIGNED NOT NULL default '0',
PRIMARY KEY  (user_id)
) ENGINE=MyISAM;";

// Delete any items not required below.
$inf_newtable[3] = DB_D1DW_log." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id VARCHAR(50) DEFAULT '' NOT NULL,
user_name VARCHAR(200) DEFAULT '' NOT NULL,
time VARCHAR(200) DEFAULT '' NOT NULL,
zahl VARCHAR(500) DEFAULT '' NOT NULL,
sonstiges VARCHAR(200) DEFAULT '' NOT NULL,
text VARCHAR(200) DEFAULT '' NOT NULL,
wurfel1 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel2 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel3 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel4 TINYINT(1) UNSIGNED NOT NULL default '0',
wurfel5 TINYINT(1) UNSIGNED NOT NULL default '0',
PRIMARY KEY (id)
) ENGINE=MyISAM;";

// Delete any items not required below.
$inf_newtable[4] = DB_D1DW_chat." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id VARCHAR(50) DEFAULT '' NOT NULL,
user_name VARCHAR(200) DEFAULT '' NOT NULL,
timer VARCHAR(200) DEFAULT '' NOT NULL,
time VARCHAR(200) DEFAULT '' NOT NULL,
text VARCHAR(66) DEFAULT '' NOT NULL,
sonstiges VARCHAR(200) DEFAULT '' NOT NULL,
PRIMARY KEY (id)
) ENGINE=MyISAM;";

$inf_insertdbrow[1] = DB_D1DW_conf." SET conf = '1', dwin_scores = 'Scores', dwin_kosten = '5', inf_name = '', site_url = '', jack_pot = '5', wurf_panel = '1', dwin_chance = '20', dwin_jstart = '5', dwin_gpreis = '0', dwin_fpreis = '200', dwin_wzahl = '1', dwin_gstatus = '1', lucky_number = '1', lucky_win = '20', chat_stat = '1', datab_stat = '1', dwin_multi = '1', dwin_chatanz = '5', dwin_wurfanz = '10', dwin_reftime = '10' , ref_dice = '10', ref_chat = '15' ";
$inf_insertdbrow[2] = DB_PANELS." SET panel_name='".$inf_panel."', panel_filename='".$inf_folder."', panel_side=4, panel_order='5', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

$inf_altertable[1] = DB_D1DW_conf." ADD lucky_number INT(10) UNSIGNED NOT NULL default '1'";
$inf_altertable[2] = DB_D1DW_conf." ADD lucky_win INT(10) UNSIGNED NOT NULL default '20'";
$inf_altertable[3] = DB_D1DW_conf." ADD chat_stat TINYINT(1) UNSIGNED NOT NULL default '1'";
$inf_altertable[4] = DB_D1DW_conf." ADD datab_stat TINYINT(1) UNSIGNED NOT NULL default '0'";
$inf_altertable[5] = DB_D1DW_conf." ADD dwin_multi INT(10) UNSIGNED NOT NULL default '1'";
$inf_altertable[6] = DB_D1DW_conf." ADD dwin_chatanz INT(10) UNSIGNED NOT NULL default '5'";
$inf_altertable[7] = DB_D1DW_conf." ADD dwin_wurfanz INT(10) UNSIGNED NOT NULL default '10'";
$inf_altertable[8] = DB_D1DW_conf." ADD dwin_reftime INT(10) UNSIGNED NOT NULL default '10'";
$inf_altertable[9] = DB_D1DW_conf." ADD ref_dice INT(10) UNSIGNED NOT NULL default '10'";
$inf_altertable[10] = DB_D1DW_conf." ADD ref_chat INT(10) UNSIGNED NOT NULL default '15'";

$inf_droptable[1] = DB_D1DW_conf;
$inf_droptable[2] = DB_D1DW_user;
$inf_droptable[3] = DB_D1DW_log;
$inf_droptable[4] = DB_D1DW_chat;

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[1] = array(
	"title" => "D1 Dice to win",
	"image" => "dicetowin.png",
	"panel" => "D1_dice_to_win_admin.php",
	"rights" => "D1DW"
);

$inf_sitelink[1] = array(
	"title" => "Dice to win",
	"url" => "D1_dice_to_win.php",
	"visibility" => "101"
);
?>