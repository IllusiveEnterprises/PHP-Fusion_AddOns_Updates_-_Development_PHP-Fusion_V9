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

$d1dwsettings = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));

echo "<b><center><u>".$locale['D1DW_seite_037']." ".$d1dwsettings['dwin_chatanz']." ".$locale['D1DW_seite_039']."</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_chat." ORDER BY time DESC LIMIT 0,".$d1dwsettings['dwin_chatanz']."");
if (dbrows($result4)) {
	while($dice_chatss = dbarray($result4)) {

	if ($dice_chatss['user_id'] == $userdata['user_id']) {
	$font_dcolor = "#0080c0";
	} else {
	$font_dcolor = "";
	}

	echo "[".date("d.m.Y H:i:s",$dice_chatss['time'])."] <span style='color: ".$font_dcolor.";'><b>".$dice_chatss['user_name']."</b>: ".$dice_chatss['text']."</span><br>";
}
} else {
	echo "<center>".$locale['D1DW_seite_040']."</center>";
}
echo "<center><b><span class='small'>".$locale['D1DW_seite_025']." ".date("d.m.Y H:i:s",time())."</span></center></b>";
?>