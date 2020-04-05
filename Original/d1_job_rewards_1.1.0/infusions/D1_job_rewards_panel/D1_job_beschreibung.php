<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 20011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_job rewards_beschreibung.php
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

if (!iMEMBER) { redirect("../../index.php"); }

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

opentable("D1 Job Rewards Stellenbeschreibung");


echo '<center>';
echo "<h1>Stellenbeschreibung</h1>";

if (isset($_GET['bew_info'])) {
$jobsearch = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$_GET['bew_info'].""));

if ($jobsearch['job_intervall'] == "60") {
$jobinvtxt = "Minute";
} elseif ($jobsearch['job_intervall'] == "3600") { 
$jobinvtxt = "Stunde";
} elseif ($jobsearch['job_intervall'] == "86400") { 
$jobinvtxt = "Tag";
} elseif ($jobsearch['job_intervall'] == "604800") { 
$jobinvtxt = "Woche";
} elseif ($jobsearch['job_intervall'] == "2592000") { 
$jobinvtxt = "Monat";
} else {
$jobinvtxt = "ERROR";
}

$d1groupname = dbarray(dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS." WHERE group_id = '".$jobsearch['job_group']."'"));
if ($jobsearch['job_group'] == "0") {
$bengrupp = "Keine";
} else {
$bengrupp = $d1groupname['group_name'];
}

echo "<table class='tbl-border center' cellpadding='0' cellspacing='0' width='80%'><tr><td class='tbl2' style='text-align:center;'><center><b><span style='font-size: small;'>Stelle als: <u>".$jobsearch['job']."</u><br>Benutzergruppen Zuteilung: ".$bengrupp."<br>Verdienst Aktuell (pro $jobinvtxt): ".$jobsearch['scores']." <img title='Scores' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/coins.png' /> <br> Bei: <u>".$settings['sitename']."</u></span></b><center></td><tr><td class='tbl1'>";
    echo "<form id='bew_sub2' name='bew_extra_form' action='".FUSION_SELF."' method='post'>";
	//echo "<div style='float: right;'><img style='border:0;' style='float: right;' src='".($userdata['user_avatar'] ? IMAGES."avatars/".$userdata['user_avatar'] : IMAGES."avatars/noavatar50.png")."' height='50' width='50' alt='".$userdata['user_name']."' /></div>";
	echo "<input type='hidden' name='job_id' value='".$jobsearch['id']."' />\n";
    echo "<b>Stellenbeschreibung:</b><br /><br />\n";
	echo " ".nl2br(parseubb(parsesmileys($jobsearch['job_besch'], "a|b|big|i|color|bgcolor|smiley|img|url")))."";
 
	echo "</td></tr><tr><td class='tbl2' style='text-align:center;'>";
	echo "<a class='button' title='zur&uuml;ck' href='".INFUSIONS."D1_job_rewards_panel/D1_job_rewards.php'>zur&uuml;ck</b><a/>";
    echo "</form>";
echo "</td></tr></table>";
}
echo '</center>';

echo d1jr_infusionscore_end();
closetable();

if (function_exists("d1jobrewardssec2")) {
	d1jobrewardssec2();
} else {
	redirect(BASEDIR."index.php");
}
require_once THEMES."templates/footer.php";
?>
<script type="text/javascript">
$(function() {
$('#bew_sub2').submit(function() {

    if ($('#bew_besch2').val() == '') {
        alert('Anschreiben LEER');
        $('#bew_besch2').focus();
        return false;
    }

});
});
</script>