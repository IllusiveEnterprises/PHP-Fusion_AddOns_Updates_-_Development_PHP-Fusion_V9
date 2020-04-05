<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: dice_ref.php
| Author: DeeoNe
| Contact: http://www.deeone.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../../maincore.php";

if (!defined("IN_FUSION")) { die("Access Denied"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_dice_to_win_panel/locale/German.php";
}

// Folgendes soll das Cachen verhindern
header("Expires: Sat, 05 Nov 2005 00:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");


include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";
$dwlog = dbarray(dbquery("SELECT * FROM ".DB_D1DW_log." WHERE user_id='".$userdata['user_id']."'"));
$d1dwsettings = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));

$sechser_multi = $d1dwsettings['dwin_wzahl']*6;
$lucky_number = $d1dwsettings['lucky_number'];

echo "<b><center><u>Letzte ".$d1dwsettings['dwin_wurfanz']." W&uuml;rfe</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_log." ORDER BY sonstiges DESC LIMIT 0,".$d1dwsettings['dwin_wurfanz']."");
if (dbrows($result4)) {
	while($dice_to_win = dbarray($result4)) {

	if ($dice_to_win['zahl'] == $sechser_multi) {
	$font_dcolor = "#808000";
	} elseif ($dice_to_win['zahl'] == $lucky_number) {
	$font_dcolor = "#008000";
	} else {
	$font_dcolor = "";
	}

	echo "<center>".date("d.m.Y H:i:s",$dice_to_win['sonstiges'])." - <span style='color: ".$font_dcolor.";'><b>".$dice_to_win['user_name']."</b> ".$locale['D1DW_seite_023']." <b>".$dice_to_win['zahl']."</b> ".$dice_to_win['text']."</span></center>";
}
} else {
	echo "<center>".$locale['D1DW_diceref_003']."</center>";
}
echo "<b><center><span class='small'>".$locale['D1DW_diceref_004']." ".date("d.m.Y H:i:s",time())."</span></center></b>";
?>