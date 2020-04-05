<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 20011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_job rewards_bewerbung.php
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

opentable("D1 Job Rewards Bewerbung");


echo '<center>';
echo "<h1>Bewerbung</h1>";

if(isset($_GET['sendbew'])){
	echo "Bewerbung wurde Abgesendet, sie werden in der n&auml;chsten Zeit eine Antwort zur Bewerbung von uns per Privat Nachricht bekommen";
} else {

if (isset($_GET['bew_send'])) {
$jobsearch = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$_GET['bew_send'].""));
if ($jobsearch['job_search'] == '0') { redirect(INFUSIONS."D1_job_rewards_panel/D1_job_rewards.php"); }

if ($jobsearch['job_intervall'] == "60") {
$jobinvtxt = "Minute (Testmodus)";
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

echo "<table class='tbl-border center' cellpadding='0' cellspacing='0' width='80%'><tr><td class='tbl2' style='text-align:center;'><center><b><span style='font-size: small;'>Bewerbung als: <u>".$jobsearch['job']."</u><br>Benutzergruppen Zuteilung: ".$bengrupp."<br>Verdienst Aktuell (pro $jobinvtxt): ".$jobsearch['scores']." <img title='Scores' style='vertical-align: middle;' src='".INFUSIONS."D1_job_rewards_panel/images/coins.png' /> <br> Bei: <u>".$settings['sitename']."</u></span></b><center></td><tr><td class='tbl1'>";
    //include_once INCLUDES."bbcode_include.php";
    echo "<form id='bew_sub2' name='bew_extra_form' action='".FUSION_SELF."' method='post'>";
	echo "<div style='float: right;'><img style='border:0;' style='float: right;' src='".($userdata['user_avatar'] ? IMAGES."avatars/".$userdata['user_avatar'] : IMAGES."avatars/noavatar50.png")."' height='50' width='50' alt='".$userdata['user_name']."' /></div>";
	echo "<input type='hidden' name='job_id' value='".$jobsearch['id']."' />\n";
    echo "<b>Name: </b><br />\n	<input type='text' class='textbox' name='bew_name' id='bew_name2' value='".$userdata['user_name']."' style='width:200px;' readonly /> <br />\n";
    echo "<b>Anschreiben:</b><br />\n<textarea name='bew_besch' id='bew_besch2' class='textbox' rows='6' style='width:98%;'></textarea>";
    //display_bbcodes("100%;", "bew_besch", "bew_extra_form", "a|b|big|i|color|bgcolor|smiley|img")."\n";
echo "</td></tr><tr><td class='tbl2' style='text-align:center;'>";
    echo "<input type='submit' class='button' name='bewerbung_send' value='Absenden' />";
    echo "</form>";
echo "</td></tr></table>";
}
echo '</center>';

}

if (isset($_POST['bewerbung_send'])) {
    $user = stripinput($userdata['user_id']);
    $job = stripinput($_POST['job_id']);
    $ansch = stripinput($_POST['bew_besch']);
    $time = time();
 $result = dbquery("INSERT INTO ".DB_D1JR_bewerbung." (user_id, job_id, text, time) VALUES ('$user', '$job', '$ansch', '$time')");

//-----ADMIN PN NOTIFICATION-----//
$jobpn = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$job.""));
$uwmessage = "".$userdata['user_name']." hat eine Job Bewerbung als <b>".$jobpn['job']."</b> abgegeben<br><br><b>Bewerbungstext:</b><br>".$ansch."";
$result = dbquery("INSERT INTO ".$db_prefix."messages (
message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder
) VALUES( '1', '".$userdata['user_id']."', 'Neue Job Bewerbung', '$uwmessage', 'y', '0', '".time()."', '0')");
//-----ADMIN PN NOTIFICATION-----//

redirect(INFUSIONS."D1_job_rewards_panel/D1_job_bewerbung.php?sendbew=ok");
}

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