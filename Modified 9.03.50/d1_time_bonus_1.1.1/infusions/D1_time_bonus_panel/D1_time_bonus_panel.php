<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: DeeoNe
| Homepage: www.DeeoNe.de
| Adapted to php-fusion-9 by Douwe Yntema
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
include INFUSIONS."D1_time_bonus_panel/infusion_db.php";

require_once INFUSIONS."D1_time_bonus_panel/includes/functions.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_time_bonus_panel/locale/".fusion_get_settings('locale').".php")) {
	// Load the locale file matching the current site locale setting.
    include INFUSIONS."D1_time_bonus_panel/locale/".fusion_get_settings('locale').".php";
} else {
	// Load the infusion's default locale file.
    include INFUSIONS."D1_time_bonus_panel/locale/German.php";
}

if (!function_exists("d1timebonussec2")) {
} elseif (d1timebonusSet("inf_name") == "" || d1timebonusSet("inf_name") != md5("D1 Time Bonus") || d1timebonusSet("site_url") == "" || d1timebonusSet("site_url") != md5("D1 Time Bonus".$settings['siteurl'])) {
} else {

if (iMEMBER) {

$d1gksettings = dbarray(dbquery("SELECT * FROM ".DB_d1_tbconf.""));
$tbusersettings = dbarray(dbquery("SELECT * FROM ".DB_d1_tbuser." WHERE user_id='".$userdata['user_id']."'"));
$tbtime = $d1gksettings['tb_intervall'];
$tbpunkte = $d1gksettings['tb_punkte'];
$tbscores = $d1gksettings['tb_scores'];
$nexttime = time()+60*$tbtime;
if ($tbusersettings['user_id'] == '') {
    $result = dbquery("INSERT INTO ".DB_d1_tbuser." (`user_id`, `user_name`, `time_von`, `time_bis`, `user_punkte`) VALUES ('".$userdata['user_id']."', '".$userdata['user_name']."', '".time()."', '".$nexttime."', '0');");
}


if ($d1gksettings['tb_panelart'] == "0") {

if ($tbusersettings['time_bis'] < time()) {
$punkteplus = $tbusersettings['user_punkte']+$tbpunkte;
$punkteplus3 = $tbusersettings['user_punkte3']+$tbpunkte;
$result = dbquery("UPDATE ".DB_d1_tbuser." SET user_name = '".$userdata['user_name']."', time_von = '".time()."', time_bis = '".$nexttime."', user_punkte = '".$punkteplus."', user_punkte3 = '".$punkteplus3."' WHERE user_id = '".$userdata['user_id']."' ");
score_free("Time Bonus", "D1TB", $tbscores, 100, "P", 0, 0);
}

openside("".$locale['D1TB_panel_001']."");

if ($tbusersettings['user_id'] == '') {
echo "<center><img border=0 src=".INFUSIONS."D1_time_bonus_panel/images/timemachine.png><br><b><div class=' small'>Time Bonus Aktiviert<div></b></center>";
} else {

echo"<table cellpadding='1' cellspacing='1' width='100%'>";
	echo "<tr><td class='tbl2' align='center' colspan='2'>".$locale['D1TB_panel_002']."<br><font color='blue'><b>".showdate("longdate", $tbusersettings['time_von'])."</b></font>";
echo "</td></tr>";
echo "<tr><td class='tbl2' align='center' colspan='2'>".$locale['D1TB_panel_003']."<br><font color='green'><b>".showdate("longdate", $tbusersettings['time_bis'])."</b></font>";
echo "</td></tr>";
echo "<tr><td class='tbl2' align='center'>".$locale['D1TB_panel_004']."<br><font color='grey'><b>".$tbusersettings['user_punkte3']."</b></strong></font>";
echo "</td>";
echo "<td class='tbl2' align='center'>".$locale['D1TB_panel_005']."<br><font color='yellow'><b>$tbscores ".$d1gksettings['tb_scoresname']."</b></strong></font>";
echo "</td></tr>";
echo "</table>";
echo "<center><a href='".INFUSIONS."D1_time_bonus_panel/D1_time_bonus_rank.php'><div class=' small'>".$locale['D1TB_panel_006']."</div></a></center>";


}

closeside();

} else { 
openside("".$locale['D1TB_panel_001']."");

if ($tbusersettings['user_id'] == '') {
echo "<center><img border=0 src=".INFUSIONS."D1_time_bonus_panel/images/timemachine.png><br><b><div class=' small'>Time Bonus Aktiviert<div></b></center>";
} else {

echo"<table cellpadding='1' cellspacing='1' width='100%'>";
echo "<tr><td class='tbl2' align='center' colspan='2'>";
$tbtimerest = $tbusersettings['time2_bis']-time();
echo "<script language='JavaScript' src='".INFUSIONS."D1_time_bonus_panel/includes/jstime.js'></script>";
echo "<center><div id='cID3'>  Init<script>countdown($tbtimerest,'cID3')</script></div></center>";
echo "</td></tr>";
//echo "<tr><td class='tbl2' align='center' colspan='2'>".$locale['D1TB_panel_002']."<br><font color='blue'><b>".showdate("longdate", $tbusersettings['time_von'])."</b></font>";
//echo "</td></tr>";
//echo "<tr><td class='tbl2' align='center' colspan='2'>".$locale['D1TB_panel_003']."<br><font color='green'><b>".showdate("longdate", $tbusersettings['time_bis'])."</b></font>";
//echo "</td></tr>";
echo "<tr><td class='tbl2' align='center'>".$locale['D1TB_panel_004']."<br><font color='grey'><b>".$tbusersettings['user_punkte2']."</b></strong></font>";
echo "</td>";
echo "<td class='tbl2' align='center'>".$locale['D1TB_panel_005']."<br><font color='yellow'><b>$tbscores ".$d1gksettings['tb_scoresname']."</b></strong></font>";
echo "</td></tr>";
echo "</table>";
echo "<center><a href='".INFUSIONS."D1_time_bonus_panel/D1_time_bonus_rank.php'><div class=' small'>".$locale['D1TB_panel_006']."</div></a></center>";

if ($d1gksettings['tb_zweiter'] == "1") { 
if ($tbusersettings['time_bis'] < time()) {
$punkteplus = $tbusersettings['user_punkte']+$tbpunkte;
$punkteplus3 = $tbusersettings['user_punkte3']+$tbpunkte;
$result = dbquery("UPDATE ".DB_d1_tbuser." SET user_name = '".$userdata['user_name']."', time_von = '".time()."', time_bis = '".$nexttime."', user_punkte = '".$punkteplus."', user_punkte3 = '".$punkteplus3."' WHERE user_id = '".$userdata['user_id']."' ");
//score_free("Time Bonus", "D1TB", $tbscores, 100, "P", 0, 0);
}
}

}

closeside();
}

}
}

?>