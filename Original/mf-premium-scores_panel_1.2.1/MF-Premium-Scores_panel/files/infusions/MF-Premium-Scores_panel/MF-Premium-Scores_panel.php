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
//include_once "../../maincore.php";
include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";
// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include_once INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include_once INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}
$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));
$premiumsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$userdata['user_id'].""));
$aktiv = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id='".$userdata['user_id']."'"));
$ablauf=time();

//if ($premiumsettings['status'] =='offen') {
//} else {
if ($aktiv['bis'] < $ablauf) {
mysql_query("UPDATE ".DB_mfp_scores." SET status='inaktiv' WHERE bis < $ablauf");
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($userdata['user_id']).";");
}
//}
	if ($aktiv['status']=="offen") {
	$font_color = "orange";
	} elseif ($aktiv['status']=="aktiv") {
	$font_color = "green";
	} elseif ($aktiv['status']=="inaktiv") {
	$font_color = "red";
	} 

openside("Premium-Mitgliedschaft<div style='float: right;'><a href='http://www.mf-community.net' target='_blank' title='".$locale['MFPS_title']." ".$locale['MFPS_version']." &copy; 2011 Comet1986 & DeeoNe'><span class='small'>&copy;</span></a></div>");


if ($aktiv['status'] =='offen') {
echo"<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
	echo "<tr><td align='center'>Du bist Premium bis: <br><font color='".$font_color."'><b>".showdate("longdate", $aktiv['bis'])."</b></font><br><br><a class='button' href='".INFUSIONS."MF-Premium-Scores_panel/premium_wahl.php'><strong>&nbsp; Premium verl&auml;ngern &nbsp;</strong></a></td></font></tr></table>";
} elseif ($aktiv['status'] =='aktiv') {
echo"<table cellpadding='0' cellspacing='0' width='100%' border='0'>";

// Premium Grafik S
if ($mfpssettings['prem_grafik'] =='1') {
	echo "<tr><td align='center'>Du bist Premium bis: <br><font color='".$font_color."'><b>".showdate("longdate", $aktiv['bis'])."</b></font><br><img src='".INFUSIONS."MF-Premium-Scores_panel/images/PremiumMitglied2.png' style='border:0;' /><br><a class='button' href='".INFUSIONS."MF-Premium-Scores_panel/premium_wahl.php'><strong>&nbsp; Premium verl&auml;ngern &nbsp;</strong></a></td></tr></table>";
} else {
	echo "<tr><td align='center'>Du bist Premium bis: <br><font color='".$font_color."'><b>".showdate("longdate", $aktiv['bis'])."</b></font></td></tr><tr><td align='center' style='padding-top: 5px'><a class='button' href='".INFUSIONS."MF-Premium-Scores_panel/premium_wahl.php'><strong>&nbsp; Premium verl&auml;ngern &nbsp;</strong></a></td></tr></table>";
}
//Premium Grafik E

} elseif ($aktiv['status'] =='inaktiv') {
echo"<table cellpadding='0' cellspacing='0' width='100%' border='0'>";

// Premium Grafik S
if ($mfpssettings['prem_grafik'] =='1') {
	echo "<tr><td align='center'>Du warst Premium bis: <br><font color='".$font_color."'><b>".showdate("longdate", $aktiv['bis'])."</b></font><br><img src='".INFUSIONS."MF-Premium-Scores_panel/images/Mitglied.png' style='border:0;' /><br><a class='button' href='".INFUSIONS."MF-Premium-Scores_panel/premium_wahl.php'><strong>&nbsp; Premium aktivieren &nbsp;</strong></a></td></tr></table>";
} else {
	echo "<tr><td align='center'>Du warst Premium bis: <br><font color='".$font_color."'><b>".showdate("longdate", $aktiv['bis'])."</b></font></td></tr><tr><td align='center' style='padding-top: 5px'><a class='button' href='".INFUSIONS."MF-Premium-Scores_panel/premium_wahl.php'><strong>&nbsp; Premium aktivieren &nbsp;</strong></a></td></tr></table>";
}
//Premium Grafik E

} elseif ($aktiv['status'] =='') {
echo"
<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
  echo "<tr><td align='center'><a href='".INFUSIONS."MF-Premium-Scores_panel/premium_wahl.php'>Jetzt Premium-Mitglied werden! </a></td></tr></table>";
	}

closeside();

?>