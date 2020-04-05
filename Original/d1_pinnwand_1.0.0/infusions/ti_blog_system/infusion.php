<?php
/*----------------------------------------------+
| TI BLOG SYSTEM                                |
|-----------------------------------------------|
| File version: 1.50b                           |
|-----------------------------------------------|
| Author: Martin Mårtensson (Marwelln/Elactos)  |
| Web: http://www.team-impact.nu                |
| Email: Marwelln@gmail.com                     |
|-----------------------------------------------|
| Released under the AGPL license               |
| Please refer to the included agpl.txt for     |
| more information                              |
+----------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

// Infusion Information
$inf_title = "TI - Blog System";
$inf_description = "Blog System for PHP-Fusion";
$inf_version = "2.0";
$inf_developer = "Marwelln - MOD DeeoNe";
$inf_email = "deeone@online.de";
$inf_weburl = "http://www.deeone.de";

$inf_folder = "ti_blog_system";

$inf_newtable[1] = DB_PREFIX."ti_blog_system (
  blog_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  blog_date int(11) NOT NULL default '0',
  blog_writer smallint(5) NOT NULL default '0',
  blog_subject varchar(200) NOT NULL default '',
  blog_text text NOT NULL default '',
  blog_views int(11) UNSIGNED NOT NULL default '0',
  blog_ip varchar(20) NOT NULL default '0.0.0.0',
  PRIMARY KEY  (blog_id)
) TYPE=MyISAM;";

$inf_newtable[2] = DB_PREFIX."ti_blog_system_settings (
  id smallint(6) NOT NULL auto_increment,
  blog_limit int(11) NOT NULL default '20',
  blog_access varchar(30) NOT NULL default '101',
  blog_userlimit int(10) UNSIGNED NOT NULL default '10',
  version varchar(10) NOT NULL default '$inf_version',
  PRIMARY KEY (id)
) TYPE=MyISAM;";

$inf_insertdbrow[1] = DB_PREFIX."ti_blog_system_settings VALUES ('1', '20', '101', '10', '".$inf_version."')";

/*
if (isset($_POST['infuse']) && isset($_POST['infusion']) && $_POST['infusion']=='ti_blog_system') {
	$updt_tiblog = dbquery("UPDATE ".DB_PREFIX."ti_blog_system_settings SET version='$inf_version'");
} else if (isset($_GET['defuse'])) {
	$getResult = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."infusions WHERE inf_id='".$_GET['defuse']."'"));
	if ($getResult['inf_folder'] == "ti_blog_system")
		$removeComments = dbquery("DELETE FROM ".DB_PREFIX."comments WHERE comment_type='BS'");
}
*/

$inf_altertable[1] = DB_PREFIX."ti_blog_system ADD blog_ip varchar(20) NOT NULL default '0.0.0.0'";
$inf_altertable[2] = DB_PREFIX."ti_blog_system_settings CHANGE version version varchar(10) default '$inf_version'";

$inf_droptable[1] = DB_PREFIX."ti_blog_system";
$inf_droptable[2] = DB_PREFIX."ti_blog_system_settings";

$inf_adminpanel[1] = array(
	"title" => "TI Blog System",
	"image" => "news.gif",
	"panel" => "blog_admin.php",
	"rights" => "BS"
);

$inf_sitelink[1] = array(
	"title" => "Blog System",
	"url" => "../../blog.php",
	"visibility" => "101"
);

?>