<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: payment.php
| Version: 1.2.0
| Author: Matze-W & DeeoNe
| Site: http://www.DeeoNe.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

include '../../maincore.php';

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_donate_panel/locale/German.php";
}

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header  = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

  	//If testing on Sandbox use:
	//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);


if (!$fp) {
	// HTTP ERROR
} else {
	fputs ($fp, $header . $req);
	while (!feof($fp)) {
		$res = fgets ($fp, 1024);
		if($_POST['option_name1'] != ""){
		//if (strcmp ($res, "VERIFIED") == 0) {
			$check = dbrows(dbquery("SELECT txn_id FROM ".$db_prefix."mw_donate_settings WHERE txn_id='".stripinput($_POST['txn_id'])."'"));
			if ($check == 0){
				$result = dbquery("INSERT INTO ".$db_prefix."mw_donate_list (user_id, spende, methode, time, status_spende, txn_id) VALUES ('".stripinput($_POST['option_name1'])."','".stripinput($_POST['mc_gross'])."', '1', '".time()."', '0', '".stripinput($_POST['txn_id'])."')");
				$result2 = dbquery("INSERT INTO ".$db_prefix."messages (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('1','".stripinput($_POST['option_name1'])."','".$locale['mwdp_s014']."','".$locale['mwdp_s015'].stripinput($_POST['option_selection1']).$locale['mwdp_s016']."','y','0','".time()."','0')");
			}
		//} else if (strcmp ($res, "INVALID") == 0) {
	  	//}
		} else {
		echo "GET _POST FEHLER: Keine PayPal Daten vorhanden!<br>";
		}
	}
fclose ($fp);
}
?>