<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_job_rewards_panel.php
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

if (!function_exists("d1jobrewardssec2")) {
} elseif (d1jobrewardsSet("inf_name") == "" || d1jobrewardsSet("inf_name") != md5("D1 Job Rewards") || d1jobrewardsSet("site_url") == "" || d1jobrewardsSet("site_url") != md5("D1 Job Rewards".$settings['siteurl'])) {
} else {

if ((checkrights("D1JR")) && (iADMIN)) {
$a_result = dbquery("SELECT * FROM ".DB_D1JR_bewerbung.""); 
$num_rows1 = mysql_num_rows($a_result);
if ($num_rows1 != '0') {
openside("D1 Job Rewards - Admin");
echo "<a href='".INFUSIONS."D1_job_rewards_panel/D1_job_rewards_admin.php".$aidlink."&section=d1jrubew' title='Admin'>Offene Job Bewerbungen ($num_rows1)</a>";
closeside();
}
}

if (iMEMBER) {

$jrresult = dbquery("SELECT * FROM ".DB_D1JR_user." WHERE user_id='".$userdata['user_id']."' ORDER BY id ASC");
	if (dbrows($jrresult)) {
opensidex("D1 Job Rewards");
echo '<center>';

$i = 1;
while ($jrr = dbarray($jrresult)) {
$jobsss = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$jrr['job_id'].""));

$d1jrconf = dbarray(dbquery("SELECT * FROM ".DB_D1JR_conf.""));
$timestampJR = time();
$timesnext = $timestampJR + $jobsss['job_intervall'];
$timebis = $jrr['time_von'] + $jobsss['job_intervall'];
		
echo "<center><table  align='center' width='100%'>";
		echo "<tr>\n";
		echo "<td class='tbl2' style='white-space:nowrap'>".$jobsss['job']."</td>\n";
		echo "<td class='tbl2' style='white-space:nowrap' align='right' width='5%'>".$jobsss['scores']." <img title='Scores' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/coins.png' /></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td align='center' class='tbl2' colspan='2'><img title='Time Next' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/timenext.png' /> 
		".date("d.m.Y H:i:s",$timebis)."</td>\n";
		echo "</tr>\n";
echo "</table></center>";
$i++;

if ($timestampJR > $timebis) {

mysql_query("UPDATE ".DB_D1JR_user." SET time_von = '".$timestampJR."', time_bis = '".$timesnext."' WHERE id = '".$jrr['id']."' ");
score_free("Job Rewards ".$jrr['id']."", "D1JR", $jobsss['scores'], 1000, "P", 0, 0);

echo "<img title='Pay' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/Money.png' />";
}
}

	//echo "</table></center>";
echo '</center>';
closesidex();
} else {

}

}
}

?>