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

include INFUSIONS."D1_job_rewards_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_job_rewards_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_job_rewards_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_job_rewards_panel/locale/German.php";
}

// Infusion general information
$inf_title = $locale['D1JR_title'];
$inf_description = $locale['D1JR_desc'];
$inf_version = $locale['D1JR_vers'];
$inf_developer = "DeeoNe";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.deeone.de";

$inf_panel = "D1 Job Rewards";
$inf_folder = "D1_job_rewards_panel"; // The folder in which the infusion resides.

// Delete any items not required below.
$inf_newtable[1] = DB_D1JR_conf." (
conf TINYINT(1) NOT NULL default '1',
scores_name VARCHAR(20) DEFAULT 'Scores' NOT NULL,
job_intervall INT(10) NOT NULL default '604800',
inf_name VARCHAR(100) NOT NULL DEFAULT '',
site_url VARCHAR(100) NOT NULL DEFAULT '',
PRIMARY KEY  (conf)
) ENGINE=MyISAM;";

// Delete any items not required below.
$inf_newtable[2] = DB_D1JR_jobs." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
job VARCHAR(100) NOT NULL DEFAULT '',
scores INT(10) NOT NULL default '0',
job_search INT(10) NOT NULL default '0',
sonstiges VARCHAR(100) NOT NULL DEFAULT '',
intervall INT(10) NOT NULL default '0',
job_intervall INT(10) NOT NULL default '604800',
job_besch VARCHAR(10000) DEFAULT '' NOT NULL,
job_group INT(10) NOT NULL default '0',
PRIMARY KEY (id)
) ENGINE=MyISAM;";

$inf_newtable[3] = DB_D1JR_user." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id INT(10) NOT NULL,
job_id INT(10) NOT NULL,
user_sonstiges VARCHAR(100) DEFAULT '' NOT NULL,
text VARCHAR(10000) DEFAULT '' NOT NULL,
time_von INT(10) NOT NULL,
time_bis INT(10) NOT NULL,
PRIMARY KEY  (id)
) ENGINE=MyISAM;";

$inf_newtable[4] = DB_D1JR_bewerbung." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id INT(10) NOT NULL,
job_id INT(10) NOT NULL,
user_sonstiges VARCHAR(100) DEFAULT '' NOT NULL,
text VARCHAR(10000) DEFAULT '' NOT NULL,
time INT(10) NOT NULL,
PRIMARY KEY  (id)
) ENGINE=MyISAM;";

$inf_insertdbrow[1] = DB_D1JR_conf." SET conf = '1', scores_name = 'Scores', job_intervall = '604800', inf_name = '', site_url = '' ";
$inf_insertdbrow[2] = DB_PANELS." SET panel_name='".$inf_panel."', panel_filename='".$inf_folder."', panel_side=4, panel_order='3', panel_type='file', panel_access='101', panel_display='0', panel_status='1' ";

$inf_altertable[1] = DB_D1JR_jobs." ADD job_group INT(10) NOT NULL default '0'";

$inf_droptable[1] = DB_D1JR_conf;
$inf_droptable[2] = DB_D1JR_jobs;
$inf_droptable[3] = DB_D1JR_user;
$inf_droptable[4] = DB_D1JR_bewerbung;

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[1] = array(
	"title" => "".$locale['D1JR_admin']."",
	"image" => "d1jobrewards.png",
	"panel" => "D1_job_rewards_admin.php",
	"rights" => "D1JR"
);

$inf_sitelink[1] = array(
	"title" => "".$locale['D1JR_link']."",
	"url" => "D1_job_rewards.php",
	"visibility" => "101"
);
?>