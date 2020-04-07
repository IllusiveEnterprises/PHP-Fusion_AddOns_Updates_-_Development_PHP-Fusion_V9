<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
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
include INFUSIONS."MF-Premium/infusion_db.php";


function get_zed_Guthaben($id) {
	if (defined("SCORESYSTEM")) {
		$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$id."' LIMIT 1");
		if (dbrows($acc_result)) {
			$acc_data = dbarray($acc_result);
			$acc_score = $acc_data['acc_score'];
			return $acc_score;
		} else {
			return "0";
		}
	} else {
		return "0";
	}
}
function get_mito_Guthaben($id) {
		$mito_result = dbquery("SELECT * FROM ".DB_mfp_premium." WHERE user='".$id."' LIMIT 1");
		if (dbrows($mito_result)) {
			$mito_data = dbarray($mito_result);
			$mito_score = $mito_data['mito'];
			return $mito_score;
		} else {
			return "0";
		}
}


$user_id=$userdata['user_id'];
$mfpsettings= dbarray(dbquery("SELECT * FROM ".DB_mfp_premium." WHERE user='$user_id'"));
$gruppe= dbarray(dbquery("SELECT * FROM ".DB_mfp_premium_conf.""));

	if ($mfpsettings['status']=="offen") {
	$font_color = "orange";
	} elseif ($mfpsettings['status']=="wait") {
	$font_color = "red";
	} elseif ($mfpsettings['status']=="active") {
	$font_color = "lime";
	}

//�berf�llige aktivierungen Deaktivieren
//PLATIN-ACCOUNT
//$aktiv = dbarray(dbquery("SELECT bis FROM ".DB_mfp_premium." WHERE user='$user_id'"));
$aktiv = dbarray(dbquery("SELECT * FROM ".DB_mfp_premium.""));
$ablauf=time();
//$ablauf=$aktiv['bis']-time();
if ($mfpsettings['bis'] < $ablauf) {
    $result = dbquery("UPDATE ".DB_mfp_premium." SET status='wait' WHERE bis < $ablauf");
    $result = dbquery("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$gruppe['premium_group']."", "", $userdata['user_groups'])."' WHERE  `user_id` = ".$user_id.";");
//mysql_query("UPDATE ".DB_mfp_premium." SET status='wait' WHERE bis < $ablauf");
}
//PLATIN-ACCOUNT Deaktiviert
$artikel_nr = strrev(time() - rand(0, 10000000));
$usersettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_premium." WHERE user='".$userdata['user_id']."'"));
//Premium
if ($usersettings['user'] =='') {
//mysql_query("INSERT INTO ".DB_mfp_premium_aktiv." (`user`, `inbox`, `outbox`, `archiv`) VALUES ('".$userdata['user_id']."', '5', '5', '5');");
    $result = dbquery("INSERT INTO ".DB_mfp_premium." (`user`, `status`, `seit`, `bis`, `code`) VALUES ('".$userdata['user_id']."', 'wait', '".time()."', '".time()."', '".$artikel_nr."-".$userdata['user_id']."');");
}
//Premium Ende
//�berf�llige aktivierungen Ende

	openside("Premium-Mitgliedschaft");
if ($mfpsettings['status'] =='active') {
echo"
<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
	echo "
		<tr><td align='center'>Du bist bis zum <br><font color='".$font_color."'><b>".showdate("longdate", $mfpsettings['bis'])."</b></font><br><a href='".INFUSIONS."MF-Premium/spezialmoney.php?&aktion=start'><img src='".INFUSIONS."MF-Premium_panel/images/001premium-mitglied.png'></a></td></font></tr></table>";
} elseif ($mfpsettings['status'] =='offen') {
echo"
<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
	echo "
		<tr><td align='center'>Du bist bis zum <br><font color='".$font_color."'><b>".showdate("longdate", $mfpsettings['bis'])."</b></font><br><a href='".INFUSIONS."MF-Premium/spezialmoney.php?&aktion=start'><img src='".INFUSIONS."MF-Premium_panel/images/001premium-mitglied.png'></a></td></font></tr></table>";
} elseif ($mfpsettings['status'] =='wait') {
echo"
<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
	echo "
		<tr><td align='center'>Du warst bis zum <br><font color='".$font_color."'><b>".showdate("longdate", $mfpsettings['bis'])."</b></font><br> Premium-Mitglied<br><a href='".INFUSIONS."MF-Premium/spezialmoney.php?&aktion=start'><img src='".INFUSIONS."MF-Premium_panel/images/001premium-mitglied.png'></a> </td></font></tr></table>";
} elseif ($mfpsettings['status'] =='') {
echo"
<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
  echo "
		<tr><td align='center'><a href='".INFUSIONS."MF-Premium/spezialmoney.php?&aktion=start'>Jetzt Premium-Mitglied werden! </a></td></tr><br></table>";
	}
	

	echo "
<table cellpadding='0' cellspacing='0' width='100%' border='0'>";
  echo "
		<tr><td align='left'><font color='orange'><b>".get_mito_Guthaben($userdata['user_id'])."</b></font> <img src='".INFUSIONS."MF-Premium_panel/images/mito.png' width='11px' height='11px'></td>
		<td align='right'><font color='red'><b>".get_zed_Guthaben($userdata['user_id'])."</b></font> <img src='".INFUSIONS."MF-Premium_panel/images/chips.png' width='11px' height='11px'></td></tr><br></table>";

	closeside();

?>