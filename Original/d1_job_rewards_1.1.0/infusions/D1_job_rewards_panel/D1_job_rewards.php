<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 20011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_job rewards.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."D1_job_rewards_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_job_rewards_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_job_rewards_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_job_rewards_panel/locale/German.php";
}

require_once INFUSIONS."D1_job_rewards_panel/includes/functions.php";

if (d1jobrewardsSet("inf_name") == "" || d1jobrewardsSet("inf_name") != md5("D1 Job Rewards") || d1jobrewardsSet("site_url") == "" || d1jobrewardsSet("site_url") != md5("D1 Job Rewards".$settings['siteurl'])) {
	redirect(BASEDIR."index.php");
}
$d1jrsettings = dbarray(dbquery("SELECT * FROM ".DB_D1JR_conf.""));

opentable("D1 Job Rewards");


echo '<center>';

echo "<h1>Verdienst:</h1>";
$jrsresult = dbquery("SELECT * FROM ".DB_D1JR_jobs." ORDER BY id");


echo "<center><table align='center' width='550px'>";	
echo "<tr>";
echo "<td class='tbl2' style='text-align:center;' width='100%'>";

echo "<center><table align='center' width='540px'>";	
echo "<tr>";
echo "<td class='tbl2' style='text-align:center;' width='25%'>";
echo '<b>Job</b>';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo '<b>Verdienst</b>';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='15%'>";
echo '<b>Zeit</b>';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo '<b>Info</b>';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='40%'>";
echo '<b>Bewerben</b>';
echo "</td>";
echo "</tr>";
	if (dbrows($jrsresult)) {
$i = 1;
while ($jrrs = dbarray($jrsresult)) {
$jobsusers = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jrrs['id'].""));
		
if ($jrrs['job_intervall'] == "60") {
$jobinvtxt = "Minute (Testmodus)";
} elseif ($jrrs['job_intervall'] == "3600") { 
$jobinvtxt = "Stunde";
} elseif ($jrrs['job_intervall'] == "86400") { 
$jobinvtxt = "Tag";
} elseif ($jrrs['job_intervall'] == "604800") { 
$jobinvtxt = "Woche";
} elseif ($jrrs['job_intervall'] == "2592000") { 
$jobinvtxt = "Monat";
} else {
$jobinvtxt = "ERROR";
}

		echo "<tr>\n";
		echo "<td class='tbl1' align='center'>".$jrrs['job']."</td>\n";
		echo "<td class='tbl1' align='center'>".$jrrs['scores']." <img title='Scores' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/coins.png' /></td>\n";
		echo "<td class='tbl1' align='center'>pro ".$jobinvtxt." </td>\n";
		echo "<td class='tbl1' align='center' ><a title='Job Beschreibung' href='".INFUSIONS."D1_job_rewards_panel/D1_job_beschreibung.php?bew_info=".$jrrs['id']."'><img title='Job Beschreibung' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/info.png' /></a></td>\n";
		if ($jrrs['job_search'] == '1') {
			$jobdup = dbarray(dbquery("SELECT * FROM ".DB_D1JR_bewerbung." WHERE job_id=".$jrrs['id']." AND user_id=".$userdata['user_id'].""));
			$jobdup2 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jrrs['id']." AND user_id=".$userdata['user_id'].""));
			if ($jobdup) {
			echo "<td class='tbl1' align='right' ><b>Bereits BEWORBEN</b> <img title='Geschlossen' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/bew_close.png' /></td>\n";
			} elseif ($jobdup2) {
			echo "<td class='tbl1' align='right' ><b>Bereits ANGENOMMEN</b> <img title='Geschlossen' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/bew_close.png' /></td>\n";
			} else {
		echo "<td class='tbl1' align='right' ><b><a title='Zum Bewerben klicken' href='".INFUSIONS."D1_job_rewards_panel/D1_job_bewerbung.php?bew_send=".$jrrs['id']."'>Bewerben m&ouml;glich</b> <img title='Bewerben' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/bew.png' /></a></td>\n";
			}
		} else  {
		echo "<td class='tbl1' align='right' ><b>Bewerbung GESCHLOSSEN</b> <img title='Geschlossen' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/bew_close.png' /></td>\n";
		}
		echo "</tr>\n";

$i++;
}
echo "</center>";
} else {
echo "<center>".$locale['D1UW_panel_005']."</center>";
}
echo '</table></center>';

echo "</td>";
echo "</tr>";
echo '</table></center>';


echo '<center>';
echo "<h1>Team:</h1>";
$jrsresult = dbquery("SELECT * FROM ".DB_D1JR_jobs." ORDER BY id");
	if (dbrows($jrsresult)) {

$i = 1;
while ($jrrs = dbarray($jrsresult)) {
$jobsusers = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jrrs['id'].""));
		
echo "<center><table  align='center' width='100%'>";
		echo "<tr>\n";
		echo "<td class='tbl2' align='center' style='white-space:nowrap'><big><b>".$jrrs['job']."</b></big></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl2' align='center' style='white-space:nowrap'>";
$userssresult = dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jrrs['id']." ORDER BY id");
if (dbrows($userssresult)) {
$i = 1;
while ($jrus = dbarray($userssresult)) {
$usersss = dbarray(dbquery("SELECT user_name, user_avatar, user_level, user_lastvisit FROM ".DB_USERS." WHERE user_id=".$jrus['user_id'].""));

echo "<center><table align='center' width='100%'>";
		echo "<tr>\n";
		echo "<td class='tbl2' align='center' style='white-space:nowrap' width='100px'><img style='border:0;' src='".($usersss['user_avatar'] ? IMAGES."avatars/".$usersss['user_avatar'] : IMAGES."avatars/noavatar50.png")."' height='48' width='48' alt='".$usersss['user_name']."' /></td>\n";
		echo "<td class='tbl2' align='center' style='white-space:nowrap'>";
		////
		echo "<center><table align='center' width='100%'>";
		echo "<tr><td class='tbl1' align='center' style='white-space:nowrap' width='50%'><b>Benutzername: </b>".$usersss['user_name']."</td>\n";
		//echo "<td class='tbl1' align='center' style='white-space:nowrap'><b>User-Level: </b>".getuserlevel($usersss['user_level'])."</td><tr>\n";
		echo "<td class='tbl1' align='center' style='white-space:nowrap'><b>Zuletzt Online: </b>".showdate("%d.%m.%y %H:%M:%S", $usersss['user_lastvisit'])."</td><tr>\n";
		echo "<tr><td class='tbl1' align='center' style='white-space:nowrap'><a href='".BASEDIR."profile.php?lookup=".$jrus['user_id']."'>Profil ansehen</a></td>\n";
		echo "<td class='tbl1' align='center' style='white-space:nowrap'><a href='".BASEDIR."messages.php?msg_send=".$jrus['user_id']."'>Privatnachricht schreiben</td></tr>\n";
echo "</table></center>";
		////
		echo "</td>\n";
		echo "</tr>\n";
echo "</table></center>";

}
$i++;
} else {
echo "<center>".$locale['D1JR_panel_005']."</center>";
}
		echo "</td>\n";
		echo "</tr>\n";
echo "</table><br></center>";
$i++;
}

	//echo "</table></center>";
} else {
echo "<center>".$locale['D1JR_panel_006']."</center>";
}

echo '</center>';

///////////////////////////////////////////////////

echo d1jr_infusionscore_end();
closetable();

if (function_exists("d1jobrewardssec2")) {
	d1jobrewardssec2();
} else {
	redirect(BASEDIR."index.php");
}
require_once THEMES."templates/footer.php";
?>