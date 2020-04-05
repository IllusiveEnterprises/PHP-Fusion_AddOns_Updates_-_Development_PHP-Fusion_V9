<?php
/*----------------------------------------------------+
| D1 Pinnwand                           	
|-----------------------------------------------------|
| Author: DeeoNe
| Web: http://www.DeeoNe.de          	
| Email: deeone@online.de                  	
|-----------------------------------------------------|
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+----------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

// Infusion Information
$inf_title = "D1 Pinnwand";
$inf_description = "FB Pinnwand from DeeoNe";
$inf_version = "1.0.0";
$inf_developer = "DeeoNe";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.deeone.de";

$inf_folder = "D1_pinnwand_panel";
$inf_panel = "D1_pinnwand";

$inf_newtable[1] = DB_PREFIX."d1_pinnwand_system (
  pinnwand_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  pinnwand_date int(11) NOT NULL default '0',
  pinnwand_writer smallint(5) NOT NULL default '0',
  pinnwand_subject varchar(200) NOT NULL default '',
  pinnwand_text text NOT NULL default '',
  pinnwand_views int(11) UNSIGNED NOT NULL default '0',
  pinnwand_ip varchar(20) NOT NULL default '0.0.0.0',
  PRIMARY KEY  (pinnwand_id)
) ENGINE=MYISAM;";

$inf_newtable[2] = DB_PREFIX."d1_pinnwand_system_settings (
  id smallint(6) NOT NULL auto_increment,
  pinnwand_limit int(11) NOT NULL default '10',
  pinnwand_access varchar(30) NOT NULL default '0',
  pinnwand_userlimit int(10) UNSIGNED NOT NULL default '5',
  pinnwand_scoresh int(10) NOT NULL default '10',
  pinnwand_scores int(1) NOT NULL default '1',
  pinnwand_pn int(1) NOT NULL default '1',
  pinnwand_like int(1) NOT NULL default '1',
  pinnwand_import int(1) NOT NULL default '0',
  pinnwand_sonst1 int(1) NOT NULL default '1',
  pinnwand_sonst2 int(1) NOT NULL default '0',
  inf_name VARCHAR(100) NOT NULL DEFAULT '',
  site_url VARCHAR(100) NOT NULL DEFAULT '',
  version varchar(10) NOT NULL default '".$inf_version."',
  PRIMARY KEY (id)
) ENGINE=MYISAM;";

$inf_newtable[3] = DB_PREFIX."d1_pinnwand_votes (
  vote_id int(10) unsigned NOT NULL auto_increment,
  vote_item_id mediumint(8) unsigned NOT NULL default '0',
  vote_type char(2) NOT NULL,
  vote_like tinyint(1) unsigned NOT NULL default '1',
  vote_user_id mediumint(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (vote_id)
) ENGINE=MYISAM;";    

$inf_newtable[4] = DB_PREFIX."d1_pinnwand_comments (
  comment_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  comment_item_id MEDIUMINT(8) UNSIGNED NOT NULL DEFAULT '0',
  comment_type CHAR(2) NOT NULL DEFAULT '',
  comment_name VARCHAR(50) NOT NULL DEFAULT '',
  comment_message TEXT NOT NULL,
  comment_datestamp INT(10) UNSIGNED NOT NULL DEFAULT '0',
  comment_ip VARCHAR(45) NOT NULL DEFAULT '',
  comment_ip_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '4',
  comment_hidden TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (comment_id)
) ENGINE=MYISAM;";  

$inf_insertdbrow[1] = DB_PREFIX."d1_pinnwand_system_settings VALUES ('1', '20', '0', '10', '10', '1', '1', '1', '0', '1', '0', '', '', '".$inf_version."')";
$inf_insertdbrow[2] = DB_PANELS." SET panel_name='".$inf_panel."', panel_filename='".$inf_folder."', panel_side='3', panel_order='1', panel_type='file', panel_access='100', panel_display='0', panel_status='1' ";

if (isset($_POST['infuse']) && isset($_POST['infusion']) && $_POST['infusion']=='D1_pinnwand_panel') {
	$updt_tipinnwand = dbquery("UPDATE ".DB_PREFIX."d1_pinnwand_system_settings SET version='$inf_version'");
} else if (isset($_GET['defuse'])) {
	$getResult = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."infusions WHERE inf_id='".$_GET['defuse']."'"));
	if ($getResult['inf_folder'] == "d1_pinnwand_system")
		$removeComments = dbquery("DELETE FROM ".DB_PREFIX."comments WHERE comment_type='BS'");
}

$inf_altertable[1] = DB_PREFIX."d1_pinnwand_system ADD pinnwand_ip varchar(20) NOT NULL default '0.0.0.0'";
$inf_altertable[2] = DB_PREFIX."d1_pinnwand_system_settings CHANGE version version varchar(10) default '$inf_version'";

$inf_droptable[1] = DB_PREFIX."d1_pinnwand_system";
$inf_droptable[2] = DB_PREFIX."d1_pinnwand_system_settings";
$inf_droptable[3] = DB_PREFIX."d1_pinnwand_votes";
$inf_droptable[4] = DB_PREFIX."d1_pinnwand_comments";

$inf_deldbrow[1] = DB_PANELS." WHERE panel_filename='".$inf_folder."'";

$inf_adminpanel[1] = array(
	"title" => "D1 Pinnwand",
	"image" => "pinwall.png",
	"panel" => "pinnwand_admin.php",
	"rights" => "D1PW"
);

$inf_sitelink[1] = array(
	"title" => "Pinnwand",
	"url" => "D1_pinnwand_wall.php",
	"visibility" => "100"
);

?>