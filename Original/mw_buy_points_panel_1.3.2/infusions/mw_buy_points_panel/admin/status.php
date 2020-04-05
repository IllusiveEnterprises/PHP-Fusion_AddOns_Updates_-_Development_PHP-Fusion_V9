<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright ｩ 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: status.php
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

$result = dbquery("SELECT * FROM ".MW_BP_STATUS." ORDER BY time DESC");
echo "<br />";

if (isset($_GET['deletestatus'])){
	$status_id = stripinput($_GET['status_id']);
	$check = dbarray(dbquery("SELECT status_pay, status_poi FROM ".MW_BP_STATUS." WHERE status_id='".$status_id."'"));
	//if($check['status_pay'] == "0" && $check['status_poi'] == "0") {
		$result = dbquery("DELETE FROM ".MW_BP_STATUS." WHERE status_id='".$status_id."'");
		redirect(FUSION_SELF.$aidlink."&section=status");
	//}else{
	//echo "<div id='close-message'><div class='admin-message'>".$locale['mwbp_a173']."</div></div>\n";
	//}
}

echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:100%;'>";
echo "<tr>
	<td class='tbl2' width='2%' style='font-weight:bold;'>".$locale['mwbp_a166']."</td>	
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a160']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a161']."</td>
	<td class='tbl2' style='font-weight:bold;'>Punkte</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a162']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a163']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a164']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a165']."</td>
	<td class='tbl2' style='font-weight:bold;'>Optionen</td>
	</tr>
	";

if (dbrows($result) != 0) {
	$i = 0;
	while ($status = dbarray($result)) {
	if ($i%2 == 0) $class="tbl1"; else $class="tbl2";
		$user = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$status['user_id']."'")); 
		echo "<tr>";
		echo "<td class='".$class."' style='text-align:center;'>".$status['status_id']."</td>";
		echo "<td class='".$class."'>".showdate("%d.%m.%Y %H:%M:%S", $status['time'])."</td>";
		echo "<td class='".$class."'>".$user."</td>";
		echo "<td class='".$class."'>".$status['points_anz']."</td>";
		echo "<td class='".$class."'>".$status['points_pre'].$locale['mwbp-curs']."</td>";
		echo "<td class='".$class."'>".f_status_methode()."</td>";
		echo "<td class='".$class."'>".f_status_pay()."</td>";
		echo "<td class='".$class."'>".f_status_poi()."</td>";
		echo "<td class='".$class."' style='text-align:center;'>".f_status_change_pay()."".f_status_change_poi()."<a href='".FUSION_SELF.$aidlink."&section=status&deletestatus=true&status_id=".$status['status_id']."' onclick=\"return confirm('Wirklich l&ouml;schen?');\"><img src='".INFUSIONS."mw_buy_points_panel/images/delete.png' alt='delete' title='".$locale['mwbp_del']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a></td>";
		echo "</tr>";
	$i++;
	}
} else {
echo "<tr><td class='tbl1' colspan='9'>".$locale['mwbp_a171']."</td></tr>";
}

$result2 = dbquery("SELECT sum(points_pre) as summe FROM ".MW_BP_STATUS.""); 
while ($row = dbarray($result2)) {
$buy_summe = $row['summe'];
}
$result3 = dbquery("SELECT sum(points_anz) as summe FROM ".MW_BP_STATUS.""); 
while ($row3 = dbarray($result3)) {
$point_summe = $row3['summe'];
}
echo "<tr><td class='tbl2' colspan='9'><center><b>".number_format($point_summe, 0, ",", ".")." Scores --- ".number_format($buy_summe, 2, ",", ".")." &euro;</b></center></td></tr>"; 

echo "</table>";

if (isset($_GET['acceptpay'])) {
	$status_id = stripinput($_GET['status_id']);
	if ($_GET['acceptpay'] == "true") {
		$result = dbquery("UPDATE ".MW_BP_STATUS." SET status_pay='0' WHERE status_id='".$status_id."'");
		redirect(FUSION_SELF.$aidlink."&section=status");
	}else {
		$result = dbquery("UPDATE ".MW_BP_STATUS." SET status_pay='1' WHERE status_id='".$status_id."'");
		redirect(FUSION_SELF.$aidlink."&section=status");
	}
}

if (isset($_GET['acceptpoi'])) {
	$status_id = stripinput($_GET['status_id']);
	if ($_GET['acceptpoi'] == "true") {
		$abfrage = dbarray(dbquery("SELECT * FROM ".MW_BP_STATUS." WHERE status_id='".$status_id."'"));
		$result2 = dbquery("UPDATE ".MW_BP_STATUS." SET status_poi='0' WHERE status_id='".$status_id."'");
		$result3 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('".$abfrage['user_id']."','1','".$mwbp_set['points_name'].$locale['mwbp_a174']."','".$locale['mwbp_a175'].$abfrage['points_anz']." ".$mwbp_set['points_name'].$locale['mwbp_a176']."','y','0','".time()."','0')");
		$anzahl= (int) $abfrage['points_anz'];
		$userid= (int) $abfrage['user_id'];
		score_free("Punkte Gutschrift","GUTS",$anzahl,20,"P",0,$userid);	
		redirect(FUSION_SELF.$aidlink."&section=status");
	}else {
		$result = dbquery("UPDATE ".MW_BP_STATUS." SET status_poi='1' WHERE status_id='".$status_id."'");
		redirect(FUSION_SELF.$aidlink."&section=status");
	}
}
?>