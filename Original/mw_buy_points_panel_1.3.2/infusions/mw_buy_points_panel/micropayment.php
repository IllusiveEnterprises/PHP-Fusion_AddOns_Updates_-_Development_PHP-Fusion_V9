<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: micropayment.php
| Version: 1.2.1
| Author: Matze-W
| Site: http://matze-web.de
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
include INFUSIONS."mw_buy_points_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_buy_points_panel/locale/German.php";
}

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

$system=stripinput($_GET['system']);
$function=stripinput($_GET['function']);
$userid=stripinput($_GET['userid']);
$eurocent=stripinput($_GET['eurocent']);
$werbung=stripinput($_GET['werbung']);
$auth=stripinput($_GET['auth']);
$country=stripinput($_GET['country']);
$waehrung=stripinput($_GET['waehrung']);
$id=stripinput($_GET['id']);
$time_insert=time();

$poi = dbarray(dbquery("SELECT * FROM ".MW_BP_POINTS." WHERE points_id ='".$id."'"));
$user = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$userid."'")); 

switch($function){
	case'billing':
		switch($system){
			case'call2pay':
				$result = dbquery("INSERT INTO ".MW_BP_STATUS." (user_id, points_anz, points_pre, methode, time, status_pay, status_poi, txn_id) VALUES ('".$userid."','".$poi['points_anz']."', '".$poi['points_pre']."', '2', '".time()."', '0', '1','".$auth."')");
				$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('1','1','".$locale['mwbp_a169']."','".$locale['mwbp_a221'].$user.$locale['mwbp_a222']."','y','0','".time()."','0')");				
			break;
			case'ebank2pay':
				$result = dbquery("INSERT INTO ".MW_BP_STATUS." (user_id, points_anz, points_pre, methode, time, status_pay, status_poi, txn_id) VALUES ('".$userid."','".$poi['points_anz']."', '".$poi['points_pre']."', '3', '".time()."', '0', '1','".$auth."')");
				$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('1','1','".$locale['mwbp_a177']."','".$locale['mwbp_a221'].$user.$locale['mwbp_a222']."','y','0','".time()."','0')");				
			break;
			case'handy2pay':
				$result = dbquery("INSERT INTO ".MW_BP_STATUS." (user_id, points_anz, points_pre, methode, time, status_pay, status_poi, txn_id) VALUES ('".$userid."','".$poi['points_anz']."', '".$poi['points_pre']."', '4', '".time()."', '0', '1','".$auth."')");
				$result1 = dbquery("INSERT INTO ".$db_prefix."messages (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('1','1','".$locale['mwbp_a178']."','".$locale['mwbp_a221'].$user.$locale['mwbp_a222']."','y','0','".time()."','0')");				
			break;
		}
	break;
	case'storno':
	
	break;
	case'backpay':
	
	break;
}
// 2. Response preparieren ------------------------------------------------------------------

$trenner 	= "\n";
$status		= 'ok';
$url		= $settings["siteurl"]."infusions/mw_buy_points_panel/mw_buy_points.php?aktion=return";
$target		= '_top';
$forward	= 1;
$response = $trenner;
$response.= 'status=' . $status;
$response.= $trenner;
$response.= 'url=' . $url;
$response.= $trenner;
$response.= 'target=' . $target;
$response.= $trenner;
$response.= 'forward=' . $forward;
echo $response;
?>