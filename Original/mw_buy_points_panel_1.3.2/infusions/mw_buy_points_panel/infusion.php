<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: infusion.php
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

include INFUSIONS."mw_buy_points_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_buy_points_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['mwbp_title'];
$inf_description = $locale['mwbp_title'];
$inf_version = $locale['mwbp_version'];
$inf_developer = "Matze-W";
$inf_email = "Blacknightwulf@googlemail.com";
$inf_weburl = "http://matze-web.de";

$inf_folder = "mw_buy_points_panel"; // The folder in which the infusion resides.

// Delete any items not required below.
$inf_newtable[1] = MW_BP_SET." (
settings_id TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
bankdaten TINYINT(1) NOT NULL default '0',
paypal TINYINT(1) NOT NULL default '0',
points_name VARCHAR(20) NOT NULL,
points_display TINYINT(1) NOT NULL default '0',
bank_erlaubniss INT(3) NOT NULL default '0',
micropayment TINYINT(1) NOT NULL default '0',
call2pay TINYINT(1) NOT NULL default '0',
ebank2pay TINYINT(1) NOT NULL default '0',
handy2pay TINYINT(1) NOT NULL default '0'
) ENGINE=MyISAM;";

$inf_newtable[2] = MW_BP_BANK." (
bank_id TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
bank_inh VARCHAR(50) NOT NULL,
bank_ktn VARCHAR(50) NOT NULL,
bank_blz VARCHAR(50) NOT NULL,
bank_bnk VARCHAR(50) NOT NULL,
bank_ibn VARCHAR(50) NOT NULL,
bank_bic VARCHAR(50) NOT NULL
) ENGINE=MyISAM;";

$inf_newtable[3] = MW_BP_PAY." (
pay_id TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
pay_name VARCHAR(50) NOT NULL,
pay_ben VARCHAR(50) NOT NULL,
pay_pass VARCHAR(50) NOT NULL,
pay_f1 VARCHAR(50) NOT NULL,
pay_f2 VARCHAR(50) NOT NULL
) ENGINE=MyISAM;";

$inf_newtable[4] = MW_BP_POINTS." (
points_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
points_anz VARCHAR(10) NOT NULL,
points_pre VARCHAR(10) NOT NULL,
PRIMARY KEY (points_id)
) ENGINE=MyISAM;";

$inf_newtable[5] = MW_BP_STATUS." (
status_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id MEDIUMINT(8) UNSIGNED NOT NULL,
points_anz VARCHAR(10) NOT NULL DEFAULT '0',
points_pre VARCHAR(10) NOT NULL DEFAULT '0',
methode TINYINT(1) UNSIGNED NOT NULL,
time INT(10) UNSIGNED NOT NULL default '0',
status_pay TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
status_poi TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
txn_id VARCHAR(20) NOT NULL DEFAULT '0',
PRIMARY KEY (status_id)
) ENGINE=MyISAM;";


$inf_insertdbrow[1] = MW_BP_SET." SET settings_id='1', bankdaten='1', paypal='1', points_name='Scores', points_display='0', bank_erlaubniss='0' ";
$inf_insertdbrow[2] = MW_BP_BANK." SET bank_id='1', bank_inh='', bank_ktn='', bank_blz='', bank_bnk='', bank_ibn='', bank_bic='' ";
$inf_insertdbrow[3] = MW_BP_PAY." SET pay_id='1', pay_name='Paypal', pay_ben='', pay_pass='' ";
$inf_insertdbrow[4] = MW_BP_PAY." SET pay_id='2', pay_name='Micropayment', pay_ben='', pay_pass='', pay_f1='', pay_f2='' ";
$inf_insertdbrow[5] = DB_PANELS." SET panel_name='".$locale['mwbp_title']."', panel_filename='".$inf_folder."', panel_side=4, panel_order='3', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

$inf_altertable[1] = MW_BP_SET." ADD points_display TINYINT(1) NOT NULL default '0' AFTER points_name";
$inf_altertable[2] = MW_BP_SET." ADD bank_erlaubniss INT(3) NOT NULL default '0' ";
$inf_altertable[3] = MW_BP_SET." ADD micropayment INT(3) NOT NULL default '0' ";
$inf_altertable[4] = MW_BP_SET." ADD call2pay INT(3) NOT NULL default '0' ";
$inf_altertable[5] = MW_BP_SET." ADD ebank2pay INT(3) NOT NULL default '0' ";
$inf_altertable[6] = MW_BP_SET." ADD handy2pay INT(3) NOT NULL default '0' ";
$inf_altertable[7] = MW_BP_SET." ADD pay_f1 VARCHAR(50) NOT NULL AFTER pay_pass";
$inf_altertable[8] = MW_BP_SET." ADD pay_f2 VARCHAR(50) NOT NULL ";

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_droptable[1] = MW_BP_SET;
$inf_droptable[2] = MW_BP_PAY;
$inf_droptable[3] = MW_BP_POINTS;
//$inf_droptable[4] = MW_BP_BANK;
//$inf_droptable[5] = MW_BP_STATUS;


$inf_adminpanel[1] = array(
	"title" => $locale['mwbp_title'],
	"image" => "mw_buy_points_panel.png",
	"panel" => "mw_buy_points_admin.php",
	"rights" => "MWBP"
);
?>