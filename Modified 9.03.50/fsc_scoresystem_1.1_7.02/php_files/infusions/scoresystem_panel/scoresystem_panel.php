<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
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
if (!defined("IN_FUSION")) { die("Access Denied"); }

if (file_exists(INFUSIONS."scoresystem_panel/locale/".$settings['locale'].".php")) {
    // Load the locale file matching the current site locale setting.
    include INFUSIONS."scoresystem_panel/locale/".$settings['locale'].".php";
} else {
    // Load the infusion's default locale file.
    include INFUSIONS."scoresystem_panel/locale/German.php";
}

if (defined("SCORESYSTEM")) {
	openside($locale['pfss_open0']);
	if (iMEMBER) {
		if (!score_ban($userdata['user_id'])) {
			echo "<div align='center' class='".score_account_color()."'>".$locale['pfss_panel1'].score_account_stand()."<br />\n";
		} else {
			echo "<div align='center' class='".score_account_color()."'>".$locale['pfss_scsy36']."<br />\n";
		}
		echo "<a href='".SCORESYSTEM."scoresystem.php' target='_self' title='".$locale['pfss_panel2']."'>".$locale['pfss_panel2']."</a></div><hr class='side-hr' />\n";
	}
	$result = dbquery("SELECT ac.*, au.user_id, au.user_name
		FROM ".DB_SCORE_ACCOUNT." ac
		INNER JOIN ".DB_USERS." au ON ac.acc_user_id=au.user_id
		WHERE au.user_status='0' ".($score_settings['set_top_user'] ? "AND ac.acc_user_id!='".$score_settings['set_top_user']."' " : "")."ORDER BY ac.acc_score DESC LIMIT 0,".$score_settings['set_panel']."");
	if (dbrows($result)) {
		$i=1;
		echo "<table cellpadding='1' cellspacing='1' width='98%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl2' width='10%'>".$locale['pfss_scsy17']."</td>\n";
		echo "<td class='tbl2' width='60%'>".$locale['pfss_scsy9']."</td>\n";
		echo "<td class='tbl2' width='30%'>".$locale['pfss_units']."</td>\n";
		echo "</tr>\n";
		while ($data = dbarray($result)) {
			if ($i == 1) {
				$place = "<img src='".SCORESYSTEM."images/gold.gif' alt='1.' />";
			} elseif ($i == 2) {
				$place = "<img src='".SCORESYSTEM."images/silber.gif' alt='2.' />";
			} elseif ($i == 3) {
				$place = "<img src='".SCORESYSTEM."images/bronze.gif' alt='3.' />";
			} else {
				$place = $i.".";
			}
			echo "<tr>\n";
			echo "<td class='tbl2' width='10%'>".$place."</td>\n";
			echo "<td class='tbl2'>".(!iMEMBER && $score_settings['set_data'] ? trimlink($data['user_name'], 15) : "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".trimlink($data['user_name'], 15)."</a>")."</td>\n";
			echo "<td class='tbl2'>".$data['acc_score']."</td>\n";
			echo "</tr>\n";
			$i++;
		}
		echo "</table>\n";
	} else {
		echo $locale['pfss_panel3']."\n";
	}
	echo SCORE_PANEL;
	if (iMEMBER) {
		echo "<script type='text/javascript'>
		document.getElementById('scoresystem').href = '".SCORESYSTEM."scoresystem_member.php';
		document.getElementById('scoresystem').firstChild.nodeValue = '".$locale['pfss_panel4']."';
		document.getElementById('scoresystem').target = '_self';
		</script>";
	}
	closeside();
}
?>