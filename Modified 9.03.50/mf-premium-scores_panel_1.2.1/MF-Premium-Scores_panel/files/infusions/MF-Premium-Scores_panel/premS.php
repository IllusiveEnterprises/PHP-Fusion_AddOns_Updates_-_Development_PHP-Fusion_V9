<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScorePremium for PHP-Fusion v7
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

if (!defined("IN_FUSION") || !iMEMBER) { header("Location: ../../index.php"); exit; }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}
$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));
$premiumsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$userdata['user_id'].""));
// Turn off all error reporting
//error_reporting(0);
//Report all PHP errors (see changelog)
error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);


opentable($locale['MFPS_done_001']);
//if(isset($_POST['PREM_S'])) {
//AKTIVIERUNG PREMIUM
if(SCORESYSTEM && iMEMBER) {
if(score_account_stand() >=$mfpssettings['prem_s_preis']) { 
if($premiumsettings['status'] =='aktiv') {
$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$userdata['user_id']."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $mfpssettings['prem_s_zeit'])."'
		ON DUPLICATE KEY UPDATE
		user_id='".$userdata['user_id']."',
		status='aktiv',
		bis=bis+".$mfpssettings['prem_s_zeit']."");
include("./msg.php");
$result = dbquery("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_user`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '".$userdata['user_id']."', '".$userdata['user_id']."', '1', '".$active_user."', '".$nachricht_2."', 'y', '0', '".time()."', '0');");
//PN AN ADMIN
$result = dbquery("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_user`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '1', '1', '".$userdata['user_id']."', '".$active_admin."', '".$nachricht_3."', 'y', '0', '".time()."', '0');");

score_free("PREM-S gekauft", "PREM-S", $mfpssettings['prem_s_preis'], 9999, "N", 0, 0);
$user_id = $userdata['user_id'];
$result = dbquery("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".$user_id.";");
/*} elseif ($premiumsettings['status'] =='offen') {
$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$userdata['user_id']."',
		status='offen',
		seit='".time()."',
		bis='".(time() + $mfpssettings['prem_s_zeit'])."'
		ON DUPLICATE KEY UPDATE
		user_id='".$userdata['user_id']."',
		status='offen',
		bis=bis+".$mfpssettings['prem_s_zeit']."");
score_free("PREM-S gekauft", "PREM-S", $mfpssettings['prem_s_preis'], 9999, "N", 0, 0);
$user_id = $userdata['user_id'];
$result = dbquery("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");
*/} elseif ($premiumsettings['status'] =='inaktiv') {
$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$userdata['user_id']."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $mfpssettings['prem_s_zeit'])."'
		ON DUPLICATE KEY UPDATE
		user_id='".$userdata['user_id']."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $mfpssettings['prem_s_zeit'])."'");

include("./msg.php");
$result = dbquery("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_user`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '".$userdata['user_id']."','".$userdata['user_id']."', '1', '".$wait_user."', '".$nachricht_4."', 'y', '0', '".time()."', '0');");
//PN AN ADMIN
$result = dbquery("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_user`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '1', '1', '".$userdata['user_id']."', '".$wait_admin."', '".$nachricht_5."', 'y', '0', '".time()."', '0');");

score_free("PREM-S gekauft", "PREM-S", $mfpssettings['prem_s_preis'], 9999, "N", 0, 0);
$user_id = $userdata['user_id'];
$result = dbquery("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".$user_id.";");
} elseif ($premiumsettings['status'] =='') {
$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$userdata['user_id']."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $mfpssettings['prem_s_zeit'])."'
		ON DUPLICATE KEY UPDATE
		user_id='".$userdata['user_id']."',
		status='aktiv',
		bis='".(time() + $mfpssettings['prem_s_zeit'])."'");

include("./msg.php");
$result = dbquery("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_user`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '".$userdata['user_id']."','".$userdata['user_id']."', '1', '".$wait_user."', '".$nachricht_4."', 'y', '0', '".time()."', '0');");
//PN AN ADMIN
$result = dbquery("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_user`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '1', '1', '".$userdata['user_id']."', '".$wait_admin."', '".$nachricht_5."', 'y', '0', '".time()."', '0');");

score_free("PREM-S gekauft", "PREM-S", $mfpssettings['prem_s_preis'], 9999, "N", 0, 0);
$user_id = $userdata['user_id'];
$result = dbquery("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".$user_id.";");
}

//score_free("PREM-S gekauft", "PREM-S", $mfpssettings['prem_s_preis'], 9999, "N", 0, 0);

if ($premiumsettings['status'] =='offen') {
echo "<center><span style='color: orange;'><b>".$locale['MFP_admin_024h']."</b></span></center><br><br><a href=premium_wahl.php>".$locale['MFPS_done_007']."</a>";
} else {
echo "<center><span style='color: green;'><b>".$locale['MFPS_done_002']."</b></span></center><br><br><a href=premium_wahl.php>".$locale['MFPS_done_007']."</a>";
}
} else { echo "<center><span style='color: red;'><b>".$locale['MFP_admin_024i']."</b><br />(".$locale['MFP_admin_024j'].$mfpssettings['prem_s_preis'].$locale['MFP_admin_024k'].")</span></center><br><br><a href=premium_wahl.php>".$locale['MFP_admin_024l']."</a>"; }
}
closetable();

require_once THEMES."templates/footer.php";
?>