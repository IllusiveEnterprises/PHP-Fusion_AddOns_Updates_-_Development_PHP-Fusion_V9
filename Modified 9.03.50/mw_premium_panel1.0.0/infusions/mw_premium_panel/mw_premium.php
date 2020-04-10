<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_premium.php
| Version: 1.0.0
| Author: Matze-W
| Site: http://matze-web.de
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
include INFUSIONS."mw_premium_panel/infusion_db.php";
include INFUSIONS."mw_premium_panel/includes/functions.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_premium_panel/locale/German.php";
}

$mwscore = dbresult(dbquery("SELECT acc_score FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$userdata['user_id']."'"),0);
$mwpset = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM_SET.""));
$premiumsettings = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM." WHERE user_id=".$userdata['user_id'].""));

// Turn off all error reporting
//error_reporting(0);
//Report all PHP errors (see changelog)
error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);
if (isset($_POST['pack']) && isnum($_POST['pack'])){
	$pack=stripinput($_POST['pack']);
}else{
	$pack=dbresult(dbquery("SELECT pack_id FROM ".MW_PREMIUM_PACK." ORDER BY pack_time ASC LIMIT 1"),0);
}

if (isset($_POST['activate'])) {
	$packid = $_POST['id'];
	$packdata = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM_PACK." WHERE pack_id=".$packid." "));
	// Status und Zeit setzen
	if ((($premiumsettings['status'] == '0') || ($premiumsettings['status'] == '')) && score_account_stand() >= $packdata['pack_price']) {
		$result = dbquery("INSERT INTO ".MW_PREMIUM." SET
			user_id='".$userdata['user_id']."',
			status='1',
			time_on='".time()."',
			time_off='".(time() + $packdata['pack_time'])."'
			ON DUPLICATE KEY UPDATE
			status='1',
			time_off='".(time() + $packdata['pack_time'])."'");
		// Premiumgruppe
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$userdata['user_id']."'"),0);	
		if (!preg_match("(^\.{$mwpset['set_group']}|\.{$mwpset['set_group']}\.|\.{$mwpset['set_group']}$)", $user_groupsold)) {
			$user_groups = $user_groupsold.".".$mwpset['set_group'];
			$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$userdata['user_id']."'");
		}
		// Scores
		score_free("Premiumpaket f�r ".packtime($packid), "PREM", $packdata['pack_price'], 9999, "N", 0, 0);
		// Nachrichten
		$messagesettings = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM." WHERE user_id=".$userdata['user_id'].""));
		$message1 = "Vielen Dank f&uuml;r deinen Beitrag.<br />Du hast erfolgreich deinen Premium-Account<br />bis zum ".showdate("%d.%m.%Y %H:%M:%S", $messagesettings['time_off'])." aktiviert.";
		$message2 = "User ".$userdata['user_name']." hat einen Premium-Account<br />bis zum ".showdate("%d.%m.%Y %H:%M:%S", $messagesettings['time_off'])." aktiviert.";
		$usermessage = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$userdata['user_id']."','1','Premium-Account','".$message1."','y','0','".time()."','0')");
		$adminmessage = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('1','".$userdata['user_id']."','Premium-Account','".$message2."','y','0','".time()."','0')");
		redirect(FUSION_SELF."?premium=activate");
	}elseif (($premiumsettings['status'] == '1') && (score_account_stand() >= $packdata['pack_price'])) {
		// Status und Zeit setzen
		$result = dbquery("UPDATE ".MW_PREMIUM." SET
			user_id='".$userdata['user_id']."',
			status='1',
			time_on='".time()."',
			time_off=time_off+".$packdata['pack_time']."");
		// Premiumgruppe
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$userdata['user_id']."'"),0);	
		if (!preg_match("(^\.{$mwpset['set_group']}|\.{$mwpset['set_group']}\.|\.{$mwpset['set_group']}$)", $user_groupsold)) {
			$user_groups = $user_groupsold.".".$mwpset['set_group'];
			$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$userdata['user_id']."'");
		}
		// Scores
		score_free("Premiumpaket f�r ".packtime($packid), "PREM", $packdata['pack_price'], 9999, "N", 0, 0);
		// Nachrichten
		$messagesettings = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM." WHERE user_id=".$userdata['user_id'].""));
		$message1 = "Vielen Dank f&uuml;r deinen Beitrag.<br />Du hast erfolgreich deinen Premium-Account<br />bis zum ".showdate("%d.%m.%Y %H:%M:%S", $messagesettings['time_off'])." verl&auml;ngert.";
		$message2 = "User ".$userdata['user_name']." hat einen Premium-Account<br />bis zum ".showdate("%d.%m.%Y %H:%M:%S", $messagesettings['time_off'])." verl&auml;ngert.";
		$usermessage = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$userdata['user_id']."','1','Premium-Account','".$message1."','y','0','".time()."','0')");
		$adminmessage = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('1','".$userdata['user_id']."','Premium-Account','".$message2."','y','0','".time()."','0')");
		redirect(FUSION_SELF."?premium=extended");
	}
}
opentable("Premium-Mitgliedschaft");
echo "<fieldset>";
echo "<legend>".(($premiumsettings['status'] == '') || ($premiumsettings['status'] == '0') ? 'Premium-Account Aktivieren' : 'Premium-Account Verl&auml;ngern')."</legend>";
echo "<form method='POST' action='mw_premium.php'>";
echo "<table border='0' align='center' cellpadding='5' cellspacing='0'>";
echo "<tr><td align='center' colspan='3'><u>W&auml;hle deine Premiumlaufzeit:</u></td></tr>";
echo "<tr><th>Laufzeit</th><th>Kosten</th></tr>";
echo "<tr><td align='center'>";
$result = dbquery("SELECT * FROM ".MW_PREMIUM_PACK." ORDER BY pack_time ASC");
	$prelist = "";	
	while ($data = dbarray($result)) {		
		$prelist .= '<option value='.$data['pack_id'].' '.(($pack == $data['pack_id'])?'selected="selected"':'').'>'.packtime($data['pack_id']).'</option>\n';
	}		
echo "<select name='pack' onchange=\"submit();\">".$prelist."\n";
echo "</select></td></form>";
$packdata = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM_PACK." WHERE pack_id='".$pack."'"));
echo "<form name='premiumzeit' method='post' action='mw_premium.php' target='_top'>";
echo "<td align='center'><b><font size='4' color='#00FF00'>".$packdata['pack_price']." <img src='".INFUSIONS."mw_premium_panel/images/score.png' width='20px' height='20px'> </font></b></td>";
echo "</tr>";
echo "<tr><th colspan='3'><br><font size='3' color='".(score_account_stand() >= $packdata['pack_price'] ? "#00FF00" : "red")."'>Dein ".$score_settings['set_units']."stand: ".score_account_stand()." <img src='".INFUSIONS."mw_premium_panel/images/score.png' width='20px' height='20px'></font><br><br>";
if (score_account_stand() >=$packdata['pack_price']) {
	echo "<input type='hidden' value='".$packdata['pack_id']."' name='id'>";
	echo "<input type='submit' name='activate' value='".(($premiumsettings['status'] == '') || ($premiumsettings['status'] == '0') ? 'Premium-Account Aktivieren' : 'Premium-Account Verl&auml;ngern')."' class='button' />";
	echo "</form>";
} else {
	echo "<center><font color='red'>Zu wenig ".$score_settings['set_units']."!</font></center>";
	if (file_exists(INFUSIONS."mw_buy_points_panel/mw_buy_points.php")) {
	echo "<center><br /><a class='button' title='".$score_settings['set_units']." kaufen' href='".INFUSIONS."mw_buy_points_panel/mw_buy_points.php'><strong>".$score_settings['set_units']." kaufen</strong></a></center>";
	}
}
echo "</th></tr></table></fieldset>";
closetable();

require_once THEMES."templates/footer.php";
?>