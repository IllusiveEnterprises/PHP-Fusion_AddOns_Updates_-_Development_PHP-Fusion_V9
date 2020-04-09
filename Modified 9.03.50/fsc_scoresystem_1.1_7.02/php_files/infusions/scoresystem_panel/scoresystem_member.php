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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";

if (!iMEMBER || !defined("SCORESYSTEM")) { redirect(BASEDIR."index.php"); }

opentable($locale['pfss_open0']);
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) $_GET['rowstart'] = 0;
if (isset($_GET['sortby']) && preg_check("/^[0-9A-Z]$/", $_GET['sortby'])) { 
	$user_name = ($_GET['sortby'] == "all" ? "" : " AND au.user_name LIKE '".stripinput($_GET['sortby'])."%'");
	$list_link = "sortby=".stripinput($_GET['sortby']);
} else {
	$user_name = "";
	$list_link = "sortby=all";
	$_GET['sortby'] = "all";
}
$result = dbquery("SELECT ac.*, au.*
	FROM ".DB_SCORE_ACCOUNT." ac
	INNER JOIN ".DB_USERS." au ON ac.acc_user_id=au.user_id
	WHERE au.user_status='0' ".($score_settings['set_top_user'] ? "AND ac.acc_user_id!='".$score_settings['set_top_user']."' " : "").$user_name);
$rows = dbrows($result);
if ($rows) {
	$result = dbquery("SELECT ac.*, au.*
		FROM ".DB_SCORE_ACCOUNT." ac
		INNER JOIN ".DB_USERS." au ON ac.acc_user_id=au.user_id
		WHERE au.user_status='0' ".($score_settings['set_top_user'] ? "AND ac.acc_user_id!='".$score_settings['set_top_user']."' " : "").$user_name." ORDER BY ac.acc_score DESC LIMIT ".$_GET['rowstart'].",20");
	$i = $_GET['rowstart'];
	echo "<table cellpadding='0' cellspacing='1' width='450' class='tbl-border center'>\n<tr>\n";
	echo "<td align='center' width='1%' class='tbl1'><strong>".$locale['pfss_member1']."</strong></td>\n";
	echo "<td class='tbl1'><strong>".$locale['pfss_member2']."</strong></td>\n";
	echo "<td align='center' width='1%' class='tbl1' style='white-space:nowrap'><strong>".$locale['pfss_member3']."</strong></td>\n";
	echo "<td align='center' width='1%' class='tbl1' style='white-space:nowrap'><strong>".$locale['pfss_member4']."</strong></td>\n";
	echo "</tr>\n";
	while ($data = dbarray($result)) {
		$i++; $color = ($i % 2 == 0 ? "tbl1" : "tbl2");
		if ($i == 1) {
			$place = "<img src='".SCORESYSTEM."images/gold.gif' alt='1.' />";
		} elseif ($i == 2) {
			$place = "<img src='".SCORESYSTEM."images/silber.gif' alt='2.' />";
		} elseif ($i == 3) {
			$place = "<img src='".SCORESYSTEM."images/bronze.gif' alt='3.' />";
		} else {
			$place = $i.".";
		}
		echo "<tr>\n<td class='".$color."' align='center'>".$place."</a></td>\n";
		echo "<td class='".$color."'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'>".$data['user_name']."</a></td>\n";
		echo "<td align='center' width='1%' class='".$color."' style='white-space:nowrap'>".getuserlevel($data['user_level'])."</td>\n";
		echo "<td align='center' width='1%' class='".$color."' style='white-space:nowrap'>".$data['acc_score']."</td>\n</tr>\n";
	}
	echo "</table>\n";
} else {
	echo "<div style='text-align:center'><br />".($_GET['sortby'] == "all" ? "" : $locale['pfss_member5'].$_GET['sortby']).".<br /><br />\n</div>\n";
}
$alphanum = array(
	"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R",
	"S","T","U","V","W","X","Y","Z","0","1","2","3","4","5","6","7","8","9"
);
echo "<table cellpadding='0' cellspacing='1' class='tbl-border center' style='margin-top:10px;'>\n<tr>\n";
echo "<td rowspan='2' class='tbl2'><a href='".FUSION_SELF."?sortby=all'>".$locale['pfss_member6']."</a></td>";
for ($i=0;$i < 36;$i++) {
	echo "<td align='center' class='tbl1'><div class='small'><a href='".FUSION_SELF."?sortby=".$alphanum[$i]."'>".$alphanum[$i]."</a></div></td>";
	echo ($i==17 ? "<td rowspan='2' class='tbl2'><a href='".FUSION_SELF."?sortby=all'>".$locale['pfss_member6']."</a></td>\n</tr>\n<tr>\n" : "\n");
}
echo "</tr>\n</table>\n";
echo SCORE;
closetable();
if ($rows > 20) { echo "<div align='center' style='margin-top:5px;'>\n".makepagenav($_GET['rowstart'],20,$rows,3,FUSION_SELF."?".$list_link."&amp;")."\n</div>\n"; }

require_once THEMES."templates/footer.php";
?>