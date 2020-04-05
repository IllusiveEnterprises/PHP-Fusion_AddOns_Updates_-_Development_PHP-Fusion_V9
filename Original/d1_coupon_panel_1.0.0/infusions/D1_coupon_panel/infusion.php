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

include INFUSIONS."D1_coupon_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_coupon_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['D1CP_title'];
$inf_description = $locale['D1CP_desc'];
$inf_version = $locale['D1CP_vers'];
$inf_developer = "DeeoNe";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.deeone.de";

$inf_panel = "D1 Coupon";
$inf_folder = "D1_coupon_panel"; // The folder in which the infusion resides.

// Delete any items not required below.
$inf_newtable[1] = DB_D1CP_conf." (
conf TINYINT(1) NOT NULL default '0',
coupon_scores VARCHAR(20) DEFAULT '' NOT NULL,
coupon_errinfo TINYINT(1) NOT NULL default '1',
inf_name VARCHAR(100) NOT NULL DEFAULT '',
site_url VARCHAR(100) NOT NULL DEFAULT '',
PRIMARY KEY  (conf)
) ENGINE=MyISAM;";


// Delete any items not required below.
$inf_newtable[2] = DB_D1CP." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
coupon VARCHAR(100) NOT NULL DEFAULT '',
timestart INT(10) NOT NULL default '0',
timeend INT(10) NOT NULL default '0',
scores INT(10) NOT NULL default '0',
sonstiges VARCHAR(100) NOT NULL DEFAULT '',
PRIMARY KEY (id)
) ENGINE=MyISAM;";

$inf_newtable[3] = DB_D1CP_user." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id VARCHAR(50) DEFAULT '' NOT NULL,
user_name VARCHAR(200) DEFAULT '' NOT NULL,
time VARCHAR(200) DEFAULT '' NOT NULL,
coupon VARCHAR(500) DEFAULT '' NOT NULL,
scores INT(10) NOT NULL default '0',
sonstiges VARCHAR(200) DEFAULT '' NOT NULL,
PRIMARY KEY  (id)
) ENGINE=MyISAM;";

$inf_insertdbrow[1] = DB_D1CP_conf." SET conf = '1', coupon_scores = 'Scores', coupon_errinfo = '1', inf_name = '', site_url = '' ";
$inf_insertdbrow[2] = DB_PANELS." SET panel_name='".$inf_panel."', panel_filename='".$inf_folder."', panel_side=4, panel_order='5', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

//$inf_insertdbrow[3] = DB_D1CP." (id, coupon, timestart, timeend, scores) VALUES('1', 'TEST2012', '1340193333', '1341193333', '10')";

$inf_droptable[1] = DB_D1CP_conf;
//$inf_droptable[2] = DB_D1CP;
//$inf_droptable[3] = DB_D1CP_user;

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[1] = array(
	"title" => "".$locale['D1CP_admin']."",
	"image" => "d1coupon.png",
	"panel" => "D1_coupon_admin.php",
	"rights" => "D1CP"
);

$inf_sitelink[1] = array(
	"title" => "".$locale['D1CP_link']."",
	"url" => "D1_coupon.php",
	"visibility" => "101"
);
?>