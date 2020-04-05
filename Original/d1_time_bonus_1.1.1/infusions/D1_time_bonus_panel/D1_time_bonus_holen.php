<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: DeeoNe
| Homepage: www.DeeoNe.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."D1_time_bonus_panel/infusion_db.php";

if (!defined("IN_FUSION")) { die("Access Denied"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_time_bonus_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include_once INFUSIONS."D1_time_bonus_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include_once INFUSIONS."D1_time_bonus_panel/locale/German.php";
}

require_once INFUSIONS."D1_time_bonus_panel/includes/functions.php";

if (!function_exists("d1timebonussec2")) {
} elseif (d1timebonusSet("inf_name") == "" || d1timebonusSet("inf_name") != md5("D1 Time Bonus") || d1timebonusSet("site_url") == "" || d1timebonusSet("site_url") != md5("D1 Time Bonus".$settings['siteurl'])) {
} else {

if (iMEMBER) {

$d1gksettings = dbarray(dbquery("SELECT * FROM ".DB_d1_tbconf.""));
$tbusersettings = dbarray(dbquery("SELECT * FROM ".DB_d1_tbuser." WHERE user_id='".$userdata['user_id']."'"));
$tbtime2 = $d1gksettings['tb_intervall'];
$tbpunkte = $d1gksettings['tb_punkte'];
$tbscores = $d1gksettings['tb_scores'];
$nexttime2 = time()+60*$tbtime2;
$tbtimer2 = 60*$tbtime2;
/*if ($tbusersettings['user_id'] == '') {
mysql_query("INSERT INTO ".DB_d1_tbuser." (`user_id`, `user_name`, `time2_von`, `time2_bis`, `user_punkte`) VALUES ('".$userdata['user_id']."', '".$userdata['user_name']."', '".time()."', '".$nexttime2."', '0');");
}*/

    if (isset($_POST['btholen'])) {
	if ($tbusersettings['time2_bis'] < time()) {
	$punkteplus = $tbusersettings['user_punkte']+$tbpunkte;
	$punkteplus2 = $tbusersettings['user_punkte2']+$tbpunkte;
	mysql_query("UPDATE ".DB_d1_tbuser." SET user_name = '".$userdata['user_name']."', time2_von = '".time()."', time2_bis = '".$nexttime2."', user_punkte = '".$punkteplus."', user_punkte2 = '".$punkteplus2."' WHERE user_id = '".$userdata['user_id']."' ");
	score_free("Time Bonus", "D1TB", $tbscores, 100, "P", 0, 0);
	 redirect(FUSION_SELF."");	
	} else {
	 redirect(FUSION_SELF."");	
	}
    }

opentable("".$locale['D1TB_panel_001']."");

echo"<table align='center' cellpadding='1' cellspacing='1' width='50%'>";

$ifrest = $tbtimer2-2;
if ($ifrest < $tbtimerest) {
echo "<tr><td class='tbl2' align='center' colspan='2'>";
echo "Dir wurden <b>$tbscores ".$d1gksettings['tb_scoresname']."</b> gutgeschrieben!<br>";
echo "</td></tr>";
}

echo "<tr><td class='tbl2' align='center' colspan='2'>";
echo "Dein n&auml;chsten ".$d1gksettings['tb_scoresname']." Bonus erh&auml;lst du in:<br>";
$tbtimerest = $tbusersettings['time2_bis']-time();
echo "<script language='JavaScript' src='".INFUSIONS."D1_time_bonus_panel/includes/jstime.js'></script>";
echo "<center><div id='cID2'>  Init<script>countdown($tbtimerest,'cID2');</script></div></center>";
echo "</td></tr>";
//echo "<tr><td class='tbl2' align='center' colspan='2'>".$locale['D1TB_panel_002']."<br><font color='blue'><b>".showdate("longdate", $tbusersettings['time2_von'])."</b></font>";
//echo "</td></tr>";
//echo "<tr><td class='tbl2' align='center' colspan='2'>".$locale['D1TB_panel_003']."<br><font color='green'><b>".showdate("longdate", $tbusersettings['time2_bis'])."</b></font>";
//echo "</td></tr>";
echo "<tr><td class='tbl2' align='center'>".$locale['D1TB_panel_004']." (Zeit Punkte | Klick Punkte | Ewige Punkte)<br><font color='grey'><b>".$tbusersettings['user_punkte3']." | ".$tbusersettings['user_punkte2']." | ".$tbusersettings['user_punkte']."</b></strong></font>";
//echo "</td>";
//echo "<td class='tbl2' align='center'>".$locale['D1TB_panel_005']."<br><font color='yellow'><b>$tbscores ".$d1gksettings['tb_scoresname']."</b></strong></font>";
echo "</td></tr>";
echo "</table>";
echo "<center><a href='".$_SERVER['HTTP_REFERER']  ."'>&lt;-- zur&uuml;ck zur vorherigen Seite</a></center>";
//echo "<center><a href='".INFUSIONS."D1_time_bonus_panel/D1_time_bonus_rank.php'><div class=' small'>".$locale['D1TB_panel_006']."</div></a></center>";


}

echo "<div align='right'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1TB_title']." ".$locale['D1TB_version']." &copy; 2013 DeeoNe'><small>&copy; DeeoNe</small></a></div>";
closetable();

}

require_once THEMES."templates/footer.php";
?>