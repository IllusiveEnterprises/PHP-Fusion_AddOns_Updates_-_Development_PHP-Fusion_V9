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

if (!iMEMBER) { redirect(BASEDIR."index.php"); }

if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) { $_GET['rowstart']=0; }
if (!isset($_GET['limit']) || !isnum($_GET['limit']) || $_GET['limit'] == 0) { $_GET['limit']=25; }
if (isset($_GET['transfer']) && $_GET['transfer'] == "P") {
	$transfer = "tra_typ='P' AND ";
} elseif (isset($_GET['transfer']) && $_GET['transfer'] == "N") {
	$transfer = "tra_typ='N' AND ";
} elseif (isset($_GET['transfer']) && $_GET['transfer'] == "OP") {
	$transfer = "tra_typ='O' AND tra_status='3' AND ";
} elseif (isset($_GET['transfer']) && $_GET['transfer'] == "ON") {
	$transfer = "tra_typ='O' AND tra_status='4' AND ";
} else {
	$transfer = "";
}

if (!score_ban($userdata['user_id'])) {
	opentable($locale['pfss_open1']);
	$i=5;
	if ($score_settings['set_user_transfer'] == 0) { $i=$i-1; }
	if (!file_exists(SCORESYSTEM."lizenz.php")) { $i=$i-1; }
	$width = (100 / $i);
	echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
	echo "<td width='".$width."%' class='".(!isset($_GET['site']) || isset($_GET['site']) && $_GET['site'] == "main" ? "tbl1" : "tbl2")."' align='center'>".(!isset($_GET['site']) || isset($_GET['site']) && $_GET['site'] == "main" ? $locale['pfss_scsy1'] : "<a href='".FUSION_SELF."?site=main'>".$locale['pfss_scsy1']."</a>")."</td>\n";
	echo "<td width='".$width."%' class='".(isset($_GET['site']) && $_GET['site'] == "transfer" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "transfer" ? $locale['pfss_scsy2'] : "<a href='".FUSION_SELF."?site=transfer'>".$locale['pfss_scsy2']."</a>")."</td>\n";
	if ($score_settings['set_user_transfer']) { echo "<td width='".$width."%' class='".(isset($_GET['site']) && $_GET['site'] == "utransfer" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "utransfer" ? $locale['pfss_scsy3'] : "<a href='".FUSION_SELF."?site=utransfer'>".$locale['pfss_scsy3']."</a>")."</td>\n"; }
	echo "<td width='".$width."%' class='".(isset($_GET['site']) && $_GET['site'] == "score" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "score" ? $locale['pfss_scsy4'] : "<a href='".FUSION_SELF."?site=score'>".$locale['pfss_scsy4']."</a>")."</td>\n";
	if (file_exists(SCORESYSTEM."lizenz.php")) {
		echo "<td width='".$width."%' class='".(isset($_GET['site']) && $_GET['site'] == "addons" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "addons" ? $locale['pfss_scsy39'] : "<a href='".FUSION_SELF."?site=addons'>".$locale['pfss_scsy39']."</a>")."</td>\n";
	}
	echo "</tr>\n</table>\n";
	closetable();
	if (!isset($_GET['site']) || isset($_GET['site']) && $_GET['site'] == "main") {
		opentable($locale['pfss_open2']);
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n";
		echo "<tr>\n<td class='tbl1'>".$locale['pfss_scsyu1']."</td><td class='".score_account_color()."' align='right'>".score_account_stand()."</td>\n</tr>\n";
		echo "<tr>\n<td class='tbl2' colspan='2'><b>".$locale['pfss_scsyu2']."</b>".($score_settings['set_delete'] ? " (".$locale['pfss_scsyu3'].$score_settings['set_delete'].$locale['pfss_scsyu4'].")" : "")."</td></tr>\n";
		echo "<tr>\n<td class='tbl1'>".$locale['pfss_scsyu5']."</td><td class='".score_transfer_color("P")."' align='right'>".score_transfer_positiv()."</td>\n</tr>\n";
		echo "<tr>\n<td class='tbl1'>".$locale['pfss_scsyu6']."</td><td class='".score_transfer_color("N")."' align='right'>".score_transfer_negativ()."</td>\n</tr>\n";
		echo "<tr>\n<td class='tbl1'>".$locale['pfss_scsyu7']."</td><td class='".score_transfer_color("O")."' align='right'>".score_transfer_open()."</td>\n</tr>\n";
		echo "</table>\n";
	} elseif (isset($_GET['site']) && $_GET['site'] == "transfer") {
		opentable($locale['pfss_open3']);
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl2' width='10%'>".$locale['pfss_scsy5']."</td>";
		echo "<td class='tbl2' width='50%'>".$locale['pfss_scsy6']."</td>";
		echo "<td class='tbl2' width='10%'>".$locale['pfss_units']."</td>";
		echo "<td class='tbl2' width='30%'>".$locale['pfss_scsy7']."</td>";
		echo "</tr>\n";
		$result = dbquery("SELECT * FROM ".DB_SCORE_TRANSFER." WHERE ".$transfer." tra_user_id='".$userdata['user_id']."' AND tra_status!='5' ORDER BY tra_id DESC LIMIT ".$_GET['rowstart'].",".$_GET['limit']."");
		$row = dbrows(dbquery("SELECT * FROM ".DB_SCORE_TRANSFER." WHERE ".$transfer."tra_user_id='".$userdata['user_id']."'"));
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				echo "<tr>\n";
				echo "<td class='tbl1'>".$data['tra_aktion']."-".$userdata['user_id']."-".$data['tra_id']."</td>\n";
				echo "<td class='tbl1'>".$data['tra_titel']."</td>\n";
				echo "<td class='".score_transfer_color($data['tra_typ'])."' align='right'>".$data['tra_score']."</td>\n";
				echo "<td class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
				echo "</tr>\n";
			}
			if ($row > $_GET['limit']) { echo "<tr>\n<td colspan='4' align='center' class='tbl1'>".makepagenav($_GET['rowstart'],$_GET['limit'],$row,3, FUSION_SELF."?site=transfer&amp;limit=".$_GET['limit'].(isset($_GET['transfer']) ? "&amp;transfer=".$_GET['transfer'] : "")."&amp;")."</td></tr>\n"; }
		} else {
			echo "<tr>\n<td colspan='4' class='tbl1'>".$locale['pfss_scsy8']."</td></tr>\n";
		}
		echo "<tr>\n<td colspan='2' class='tbl2'>";
		echo "<form name='limit' method='get' action='".FUSION_SELF."'>\n";
		echo "<input type='hidden' name='site' value='transfer' />\n";
		echo "<input type='hidden' name='rowstart' value='".$_GET['rowstart']."' />\n";
		if (isset($_GET['transfer'])) { echo "<input type='hidden' name='transfer' value='".$_GET['transfer']."' />\n"; }
		echo $locale['pfss_scsyu8']."<select name='limit' class='textbox' onChange='this.form.submit()'>\n";
		echo "<option".($_GET['limit'] == 5 ? " selected='selected'" : "").">5</option>\n";
		echo "<option".($_GET['limit'] == 10 ? " selected='selected'" : "").">10</option>\n";
		echo "<option".($_GET['limit'] == 25 ? " selected='selected'" : "").">25</option>\n";
		echo "<option".($_GET['limit'] == 50 ? " selected='selected'" : "").">50</option>\n";
		echo "<option".($_GET['limit'] == 100 ? " selected='selected'" : "").">100</option>\n</select>\n";
		echo "</form></td><td colspan='2' class='tbl2'><form name='transfer' method='get' action='".FUSION_SELF."'>\n";
		echo "<input type='hidden' name='site' value='transfer' />";
		echo "<input type='hidden' name='rowstart' value='".$_GET['rowstart']."' />";
		echo "<input type='hidden' name='limit' value='".$_GET['limit']."' />";
		echo $locale['pfss_scsyu9']."<select name='transfer' class='textbox' onChange='this.form.submit()'>\n";
		echo "<option value=''".(!isset($_GET['transfer']) ? " selected='selected'" : "").">".$locale['pfss_scsyu10']."</option>\n";
		echo "<option value='P'".(isset($_GET['transfer']) && $_GET['transfer'] == "P" ? " selected='selected'" : "").">".$locale['pfss_scsyu11']."</option>\n";
		echo "<option value='N'".(isset($_GET['transfer']) && $_GET['transfer'] == "N" ? " selected='selected'" : "").">".$locale['pfss_scsyu12']."</option>\n";
		echo "<option value='OP'".(isset($_GET['transfer']) && $_GET['transfer'] == "OP" ? " selected='selected'" : "").">".$locale['pfss_scsyu13']."</option>\n";
		echo "<option value='ON'".(isset($_GET['transfer']) && $_GET['transfer'] == "ON" ? " selected='selected'" : "").">".$locale['pfss_scsyu14']."</option>\n</select>\n";
		echo "</form></td></tr>\n";
		echo "</table>\n";
	} elseif (isset($_GET['site']) && $_GET['site'] == "utransfer" && $score_settings['set_user_transfer']) {
		if (isset($_POST['save'])) {
			$user = (isset($_POST['user']) && isnum($_POST['user']) ? $_POST['user'] : "");
			$score = (isset($_POST['score']) && isnum($_POST['score']) ? $_POST['score'] : "");
			$title = (isset($_POST['title']) ? stripinput($_POST['title']) : "");
			if ($userdata['user_id'] != $user && $user != "" && $score != "" && $title != "") {
				if (score_transfer($userdata['user_id'], $user, $score, $title)) { $error=0; } else { $error=2; }
			} else { $error=1; }
			redirect(FUSION_SELF."?site=utransfer&error=".$error);
		}
		if (isset($_GET['error']) && $_GET['error'] == 0) {
			echo "<div class='admin-message'>".$locale['pfss_error1']."</div>";
		} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
			echo "<div class='admin-message'>".$locale['pfss_error2']."</div>";
		} elseif (isset($_GET['error']) && $_GET['error'] == 2) {
			echo "<div class='admin-message'>".$locale['pfss_error3']."</div>";
		}
		opentable($locale['pfss_open4']);
		echo "<form name='utransfer' method='post' action='".FUSION_SELF."?site=utransfer'>\n";
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>
		<tr>
		<td class='tbl1' width='50%'>".$locale['pfss_scsy9'].$locale['pfss_dpoint']."</td>
		<td class='tbl2' width='50%'><select name='user' class='textbox' style='width:202px;'>";
		$user_result = dbquery("SELECT user_id, user_name, user_level FROM ".DB_USERS." WHERE user_id!='".$userdata['user_id']."' ORDER BY user_level DESC");
		while ($user_data = dbarray($user_result)) {
			echo "<option value='".$user_data['user_id']."'>".$user_data['user_name']."</option>\n";
		}
		echo "</select></td>
		</tr>
		<tr>
		<td class='tbl1' width='50%'>".$locale['pfss_scsy6'].$locale['pfss_dpoint']."</td>
		<td class='tbl2' width='50%'><input type='text' name='title' class='textbox' style='width:200px;' /></td>
		</tr>
		<tr>
		<td class='tbl1' width='50%'>".$locale['pfss_units'].$locale['pfss_dpoint']."</td>
		<td class='tbl2' width='50%'><input type='text' name='score' class='textbox' maxlength='9' style='width:200px;' /></td>
		</tr>
		<tr>
		<td class='tbl1' colspan='2' align='center'><input type='submit' name='save' class='textbox' value='".$locale['pfss_scsy10']."' /></td>
		</tr>
		</table></form>";
	} elseif (isset($_GET['site']) && $_GET['site'] == "score") {
		opentable($locale['pfss_open5']);
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>
		<tr>
		<td class='tbl1' width='10%'>".$locale['pfss_scsy12']."</td>
		<td class='tbl1' width='36%'>".$locale['pfss_scsy6']."</td>
		<td class='tbl1' width='10%' align='right'>".$locale['pfss_units']."</td>
		<td class='tbl1' width='10%' align='right'>".$locale['pfss_scsy13']."</td>
		<td class='tbl1' width='10%' align='right'>".$locale['pfss_scsy14']."</td>
		<td class='tbl1' width='10%' align='right'>".$locale['pfss_scsy15']."</td>
		</tr>";
		$result = dbquery("SELECT * FROM ".DB_SCORE_SCORE.($score_settings['set_sco_power'] ? " WHERE sco_power='1'" : "")." ORDER BY sco_titel");
		if (dbrows($result)) {
			while($score = dbarray($result)) {
				echo "<tr>
				<td class='tbl2'>".$score['sco_aktion']."</td>
				<td class='tbl2'>".$score['sco_titel']."</td>
				<td class='tbl2' align='right'>".$score['sco_score']."</td>
				<td class='tbl2' align='right'>".($score['sco_status'] == 1 ? "<img src='".SCORESYSTEM."images/uncheck.png' />" : $score['sco_max'])."</td>
				<td class='tbl2' align='right'><img src='".SCORESYSTEM."images/".($score['sco_status'] == 1 ? "check.png" : "uncheck.png")."' /></td>
				<td class='tbl2' align='right'><img src='".SCORESYSTEM."images/".($score['sco_power'] == 1 ? "check.png" : "uncheck.png")."' /></td>
				</tr>";
			}
		} else {
			echo "<tr><td colspan='6'>".$locale['pfss_scsy16']."</td></tr>";
		}
		echo "</table>";
	} elseif (isset($_GET['site']) && $_GET['site'] == "addons" && file_exists(SCORESYSTEM."lizenz.php")) {
		score_userpage();
	} else {
		redirect(FUSION_SELF);
	}
} else {
	opentable($locale['pfss_open2']);
	echo "<div align='center'>".$locale['pfss_scsy11']."</div>";
}
echo SCORE;
closetable();

require_once THEMES."templates/footer.php";
?>