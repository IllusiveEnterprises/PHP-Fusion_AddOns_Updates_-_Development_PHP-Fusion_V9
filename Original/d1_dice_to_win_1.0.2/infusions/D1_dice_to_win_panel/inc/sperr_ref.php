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
$dwuser = dbarray(dbquery("SELECT * FROM ".DB_D1DW_user." WHERE user_id='".$userdata['user_id']."'"));
$d1dwsettings = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));
$reload_fix2 = $dwuser['sonstiges']+$d1dwsettings['dwin_reftime']+1;
$timer = $reload_fix2-time();

if ($reload_fix2 > time()) {
echo '<b><font color="#FF0000"><img align="absmiddle" src="'.INFUSIONS.'D1_dice_to_win_panel/images/stop.png"/> '.$locale["D1DW_sperref_001"].' ('.$timer.') - '.$locale["D1DW_sperref_002"].' <img align="absmiddle"  src="'.INFUSIONS.'D1_dice_to_win_panel/images/stop.png"/></font><br></b>';
} else {
echo '<b><font color="#00c000"><img align="absmiddle" src="'.INFUSIONS.'D1_dice_to_win_panel/images/ok.png"/> '.$locale["D1DW_sperref_003"].' - '.$locale["D1DW_sperref_004"].' <img align="absmiddle"  src="'.INFUSIONS.'D1_dice_to_win_panel/images/ok.png"/></font><br></b>';
}
?>