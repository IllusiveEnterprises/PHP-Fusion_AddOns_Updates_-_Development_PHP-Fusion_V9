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

include INFUSIONS."mw_donate_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_donate_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['mwdp_title'];
$inf_description = $locale['mwdp_title'];
$inf_version = $locale['mwdp_version'];
$inf_developer = "Matze-W";
$inf_email = "Blacknightwulf@googlemail.com";
$inf_weburl = "http://matze-web.de";

$inf_folder = "mw_donate_panel"; // The folder in which the infusion resides.

// Delete any items not required below.
$inf_newtable[1] = MW_DP_SET." (
settings_id TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
bankdaten TINYINT(1) NOT NULL default '0',
bank_inh VARCHAR(50) NOT NULL,
bank_ktn VARCHAR(50) NOT NULL,
bank_blz VARCHAR(50) NOT NULL,
bank_bnk VARCHAR(50) NOT NULL,
bank_ibn VARCHAR(50) NOT NULL,
bank_bic VARCHAR(50) NOT NULL,
paypal TINYINT(1) NOT NULL default '0',
pay_email VARCHAR(50) NOT NULL,
points_display TINYINT(1) NOT NULL default '0',
bank_erlaubniss INT(3) NOT NULL default '0'
) ENGINE=MyISAM;";

$inf_newtable[2] = MW_DP_LIST." (
status_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id MEDIUMINT(8) UNSIGNED NOT NULL,
spende VARCHAR(10) NOT NULL DEFAULT '0',
methode TINYINT(1) UNSIGNED NOT NULL,
time INT(10) UNSIGNED NOT NULL default '0',
status_spende TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
txn_id VARCHAR(20) NOT NULL DEFAULT '0',
PRIMARY KEY (status_id)
) ENGINE=MyISAM;";


$inf_insertdbrow[1] = MW_DP_SET." SET settings_id='1', bankdaten='0', bank_inh='', bank_ktn='', bank_blz='', bank_bnk='', bank_ibn='', bank_bic='', paypal='0', pay_email='', points_display='0', bank_erlaubniss='0' ";
$inf_insertdbrow[2] = DB_PANELS." SET panel_name='".$locale['mwdp_title']."', panel_filename='".$inf_folder."', panel_side=1, panel_order='1', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

$inf_droptable[1] = MW_DP_SET;
//$inf_droptable[2] = MW_DP_LIST;

$inf_altertable[1] = MW_DP_SET." ADD points_display TINYINT(1) NOT NULL default '0' AFTER pay_email";
$inf_altertable[2] = MW_DP_SET." ADD bank_erlaubniss INT(3) NOT NULL default '0' ";

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[1] = array(
	"title" => $locale['mwdp_title'],
	"image" => "mw_donate_panel.png",
	"panel" => "mw_donate_admin.php",
	"rights" => "MWDP"
);
?>