<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_dice_to_win_panel.php
| Author: DeeoNe
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
include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_dice_to_win_panel/locale/German.php";
}

require_once INFUSIONS."D1_dice_to_win_panel/includes/functions.php";

if (!function_exists("d1dicetowinsec2")) {
} elseif (d1wintodiceSet("inf_name") == "" || d1wintodiceSet("inf_name") != md5("D1 Dice to win") || d1wintodiceSet("site_url") == "" || d1wintodiceSet("site_url") != md5("D1 Dice to win".$settings['siteurl'])) {
} else {

$dwuser = dbarray(dbquery("SELECT * FROM ".DB_D1DW_user." WHERE user_id='".$userdata['user_id']."'"));
$d1dwsettings = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));

$result5 = dbquery("SELECT * FROM ".DB_D1DW_log." WHERE user_id='".$userdata['user_id']."' AND time > '".time()."'");
$num_rows5 = mysql_num_rows($result5);

if ($d1dwsettings['dwin_gpreis'] == '1') {
$jack = $d1dwsettings['dwin_fpreis'];
} else {
$jack = $d1dwsettings['jack_pot'];
}

$dicewin = $jack;
$dicechance = $d1dwsettings['dwin_chance'];
$dicekosten = $d1dwsettings['dwin_kosten'];

if (iMEMBER) {
opensidex($locale['D1DW_panel_001']);




if ($d1dwsettings['dwin_gpreis'] == '1') {
echo "<center><b>".$locale['D1DW_panel_0014']." $jack ".$d1dwsettings['dwin_scores']."</b></center>";
} else {
echo "<center><b>".$locale['D1DW_panel_0015']." $jack ".$d1dwsettings['dwin_scores']."</b></center>";
}

if (($num_rows5 < $dicechance) || ($dwuser['user_id'] == '')) {
echo '<center>';
echo "<a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/1m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/2m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/3m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/4m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/5m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/6m.png'/></a><br>";
if (score_account_stand() < $dicekosten) {
echo '<font color="#FF0000"><b>'.$locale['D1DW_panel_002'].' '.$d1dwsettings['dwin_scores'].'</b><br>('.$locale['D1DW_panel_003'].' '.$wurfkosten.' '.$d1dwsettings['dwin_scores'].')</font>';
} else {
echo "<form name='dice_to' method='post' action='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php?wurf_dice' target='_top'><input type='submit' name='dice_to' value='".$locale['D1DW_panel_005']."' class='button' /></form>";
//echo '<a class="button" href="'.INFUSIONS.'D1_dice_to_win_panel/D1_dice_to_win.php"><strong>&nbsp'.$locale['D1DW_panel_005'].'&nbsp;</strong></a><br>';
echo '<font color="#FF0000">('.$locale['D1DW_panel_003'].' '.$dicekosten.' '.$d1dwsettings['dwin_scores'].')</font>';
}
echo '</b></center>';

echo "<hr>";
echo "<center><b>".$num_rows5."</b> ".$locale['D1DW_panel_006']." <b>$dicechance</b> ".$locale['D1DW_panel_007']."</center>";

} else {
echo '<center>';
echo "<a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/1m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/2m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/3m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/4m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/5m.png'/></a><a title='".$locale['D1DW_panel_008']."' href='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php'><img src='".INFUSIONS."D1_dice_to_win_panel/images/6m.png'/></a><br>";
echo '<b><font color="#FF0000">'.$locale['D1DW_panel_004'].'</font></b><br>';
echo '</center>';
}

if ($d1dwsettings['wurf_panel'] == '1') {
echo "<hr>";
echo "<b><center><u>".$locale['D1DW_panel_009']."</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_log." WHERE user_id='".$userdata['user_id']."' ORDER BY sonstiges DESC LIMIT 0,5");
if (dbrows($result4)) {
	while($dice_to_win = dbarray($result4)) {
	echo "<center>".$locale['D1DW_panel_0010']." <b>".date("d.m.",$dice_to_win['sonstiges'])."</b> ".$locale['D1DW_panel_0011']." <b>".$dice_to_win['zahl']."</b> ".$locale['D1DW_panel_0012']."</center>";
}
} else {
	echo "<center>".$locale['D1DW_panel_0013']."</center>";
}
}

closesidex();
}
}

?>