<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
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
require_once THEMES."templates/admin_header.php";

if ((!checkrights("PFSS") && !checkrights("PFSB") && !checkrights("PFST") && !checkrights("PFSO")) || !defined("iAUTH") || $_GET['aid'] != iAUTH || !defined("SCORESYSTEM")) { redirect(BASEDIR."index.php"); }
if (isset($_GET['new']) && isset($_GET['edit'])) { redirect(FUSION_SELF.$aidlink); }

opentable($locale['pfss_open7']);
echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
if (checkrights("PFSS")) {
	echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "main" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "main" ? $locale['pfss_scsy18'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=main'>".$locale['pfss_scsy18']."</a>")."</td>\n";
	echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "score" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "score" ? $locale['pfss_units'].$locale['pfss_scsy19'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=score'>".$locale['pfss_units'].$locale['pfss_scsy19']."</a>")."</td>\n";
	echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "statistik" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "statistik" ? $locale['pfss_scsy20'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=statistik'>".$locale['pfss_scsy20']."</a>")."</td>\n";
	echo "</tr>\n<tr>\n";
	if (isset($_GET['site']) && $_GET['site'] == "main") {
		echo "<td width='32%' class='".(!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == "1" ? "tbl1" : "tbl2")."' align='center'>".(!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == "1" ? $locale['pfss_admin51'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=main&amp;page=1'>".$locale['pfss_admin51']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['page']) && $_GET['page'] == "2" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['page']) && $_GET['page'] == "2" ? $locale['pfss_admin52'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=main&amp;page=2'>".$locale['pfss_admin52']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['page']) && $_GET['page'] == "3" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['page']) && $_GET['page'] == "3" ? $locale['pfss_admin53'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=main&amp;page=3'>".$locale['pfss_admin53']."</a>")."</td>\n";
		echo "</tr>\n<tr>\n";
	}
	if (isset($_GET['site']) && $_GET['site'] == "score") {
		echo "<td width='32%' class='".(!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == "1" ? "tbl1" : "tbl2")."' align='center'>".(!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == "1" ? $locale['pfss_admin54'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=score&amp;page=1'>".$locale['pfss_admin54']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['page']) && $_GET['page'] == "2" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['page']) && $_GET['page'] == "2" ? $locale['pfss_admin55'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=score&amp;page=2'>".$locale['pfss_admin55']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['page']) && $_GET['page'] == "3" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['page']) && $_GET['page'] == "3" ? $locale['pfss_admin56'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=score&amp;page=3'>".$locale['pfss_admin56']."</a>")."</td>\n";
		echo "</tr>\n<tr>\n";
	}
	if (isset($_GET['site']) && $_GET['site'] == "statistik") {
		echo "<td width='32%' class='".(!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == "1" ? "tbl1" : "tbl2")."' align='center'>".(!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == "1" ? $locale['pfss_admin48'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=statistik&amp;page=1'>".$locale['pfss_admin48']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['page']) && $_GET['page'] == "2" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['page']) && $_GET['page'] == "2" ? $locale['pfss_admin49'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=statistik&amp;page=2'>".$locale['pfss_admin49']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['page']) && $_GET['page'] == "3" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['page']) && $_GET['page'] == "3" ? $locale['pfss_admin50'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=statistik&amp;page=3'>".$locale['pfss_admin50']."</a>")."</td>\n";
		echo "</tr>\n<tr>\n";
	}
}
if (checkrights("PFSS") || checkrights("PFSB")) { echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "ban" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "ban" ? $locale['pfss_scsy21'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=ban'>".$locale['pfss_scsy21']."</a>")."</td>\n"; }
if (checkrights("PFSS") || checkrights("PFST")) { echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "admin" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "admin" ? $locale['pfss_scsy22'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=admin'>".$locale['pfss_scsy22']."</a>")."</td>\n"; }
if (checkrights("PFSS") || checkrights("PFSO")) { echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "open" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "open" ? $locale['pfss_scsy23'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=open'>".$locale['pfss_scsy23']."</a>")." (".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='O'").")</td>\n"; }
if (checkrights("PFSS") && file_exists(SCORESYSTEM."lizenz.php")) {
	echo "</tr>\n<tr>\n";
	echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "lizenz" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "lizenz" ? $locale['pfss_scsy37'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=lizenz'>".$locale['pfss_scsy37']."</a>")."</td>\n";
	if (defined("SCORE_ADDONS")) {
		echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "addons" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "addons" ? $locale['pfss_scsy24'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=addons'>".$locale['pfss_scsy24']."</a>")."</td>\n";
		echo "<td width='32%' class='".(isset($_GET['site']) && $_GET['site'] == "addonpage" ? "tbl1" : "tbl2")."' align='center'>".(isset($_GET['site']) && $_GET['site'] == "addonpage" ? $locale['pfss_scsy38'] : "<a href='".FUSION_SELF.$aidlink."&amp;site=addonpage'>".$locale['pfss_scsy38']."</a>")."</td>\n";
	} else {
		echo "<td width='64%' class='tbl2' colspan='2'>&nbsp;</td>";
	}
}
echo "</tr>\n</table>\n";
closetable();
if (isset($_GET['site']) && $_GET['site'] == "main" && checkrights("PFSS")) {
	if (!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == 1) {
		opentable($locale['pfss_open8']);
		echo "<div align='center'><img src='".SCORESYSTEM."images/scoresystem.gif' alt='ScoreSystem' border='0' /><br />\n";
		echo $locale['pfss_admin74']."<br /></div>\n";
	} elseif (isset($_GET['page']) && $_GET['page'] == 2) {
		if (isset($_POST['save_main'])) {
			$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : "";
			$units = isset($_POST['units']) ? stripinput($_POST['units']) : "";
			//if (md5(md5($admin_password)) == $userdata['user_admin_password'] && $units != "") {
			if (check_admin_pass($admin_password) && $units != "") {
				$result = dbquery("UPDATE ".DB_SCORE_SETTINGS." SET 
				set_delete='".(isset($_POST['delete']) && isnum($_POST['delete']) ? $_POST['delete'] : 0)."', 
				set_panel='".(isset($_POST['panel']) && isnum($_POST['panel']) ? $_POST['panel'] : 5)."', 
				set_user_transfer='".(isset($_POST['user_transfer']) && isnum($_POST['user_transfer']) ? $_POST['user_transfer'] : 0)."', 
				set_user_tra_sco='".(isset($_POST['user_tra_sco']) && isnum($_POST['user_tra_sco']) ? $_POST['user_tra_sco'] : 0)."', 
				set_units='".$units."', 
				set_sco_power='".(isset($_POST['sco_power']) && isnum($_POST['sco_power']) ? $_POST['sco_power'] : 0)."', 
				set_top_user='".(isset($_POST['top_user']) && isnum($_POST['top_user']) ? $_POST['top_user'] : 0)."',
				set_data='".(isset($_POST['data']) && isnum($_POST['data']) ? $_POST['data'] : 0)."' WHERE set_id='1'");
				redirect(FUSION_SELF.$aidlink."&site=main&page=2&main=0");
			} else {
				redirect(FUSION_SELF.$aidlink."&site=main&page=2&main=1");
			}
		}
		if (isset($_GET['main']) && $_GET['main'] == 0) {
			echo "<div class='admin-message'>".$locale['pfss_error4']."</div>\n";
		} elseif (isset($_GET['main']) && $_GET['main'] == 1) {
			echo "<div class='admin-message'>".$locale['pfss_error5']."</div>\n";
		}
		opentable($locale['pfss_open8']);
		echo "<form name='main' method='post' action='".FUSION_SELF.$aidlink."&amp;site=main&amp;page=2'>\n";
		echo "<table cellpadding='1' cellspacing='1' width='100%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl2'colspan='2'>".$locale['pfss_scsy25']."</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin1']."</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='delete' class='textbox' style='width:200px;'>\n";
		echo "<option value='0'".($score_settings['set_delete'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin2']."</option>\n";
		echo "<option value='7'".($score_settings['set_delete'] == 7 ? " selected='selected'" : "").">7".$locale['pfss_scsyu4']."</option>\n";
		echo "<option value='14'".($score_settings['set_delete'] == 14 ? " selected='selected'" : "").">14".$locale['pfss_scsyu4']."</option>\n";
		echo "<option value='30'".($score_settings['set_delete'] == 30 ? " selected='selected'" : "").">30".$locale['pfss_scsyu4']."</option>\n";
		echo "<option value='60'".($score_settings['set_delete'] == 60 ? " selected='selected'" : "").">60".$locale['pfss_scsyu4']."</option>\n";
		echo "<option value='90'".($score_settings['set_delete'] == 90 ? " selected='selected'" : "").">90".$locale['pfss_scsyu4']."</option>\n";
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin3']."</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='user_transfer' class='textbox' style='width:200px;'>\n";
		echo "<option value='0'".($score_settings['set_user_transfer'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin2']."</option>\n";
		echo "<option value='1'".($score_settings['set_user_transfer'] == 1 ? " selected='selected'" : "").">".$locale['pfss_admin4']."</option>\n";
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin5']."</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='user_tra_sco' class='textbox' style='width:200px;'>\n";
		echo "<option value='0'".($score_settings['set_user_tra_sco'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin2']."</option>\n";
		echo "<option value='1'".($score_settings['set_user_tra_sco'] == 1 ? " selected='selected'" : "").">1 ".$locale['pfss_units']."</option>\n";
		echo "<option value='2'".($score_settings['set_user_tra_sco'] == 2 ? " selected='selected'" : "").">2 ".$locale['pfss_units']."</option>\n";
		echo "<option value='5'".($score_settings['set_user_tra_sco'] == 5 ? " selected='selected'" : "").">5 ".$locale['pfss_units']."</option>\n";
		echo "<option value='10'".($score_settings['set_user_tra_sco'] == 10 ? " selected='selected'" : "").">10 ".$locale['pfss_units']."</option>\n";
		echo "<option value='15'".($score_settings['set_user_tra_sco'] == 15 ? " selected='selected'" : "").">15 ".$locale['pfss_units']."</option>\n";
		echo "<option value='20'".($score_settings['set_user_tra_sco'] == 20 ? " selected='selected'" : "").">20 ".$locale['pfss_units']."</option>\n";
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin6']."</td>\n";
		echo "<td class='tbl2' wight='50%'><input type='text' name='units' class='textbox' style='width:193px;' value='".$score_settings['set_units']."' /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin43']."</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='sco_power' class='textbox' style='width:200px;'>\n";
		echo "<option value='0'".($score_settings['set_sco_power'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin44']."</option>\n";
		echo "<option value='1'".($score_settings['set_sco_power'] == 1 ? " selected='selected'" : "").">".$locale['pfss_admin45']."</option>\n";
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin7']."</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='panel' class='textbox' style='width:200px;'>\n";
		echo "<option value='5'".($score_settings['set_panel'] == 5 ? " selected='selected'" : "").">5</option>\n";
		echo "<option value='10'".($score_settings['set_panel'] == 10 ? " selected='selected'" : "").">10</option>\n";
		echo "<option value='15'".($score_settings['set_panel'] == 15 ? " selected='selected'" : "").">15</option>\n";
		echo "<option value='20'".($score_settings['set_panel'] == 20 ? " selected='selected'" : "").">20</option>\n";
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin46']."</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='top_user' class='textbox' style='width:200px;'>\n";
		echo "<option value='0'".($score_settings['set_top_user'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin47']."</option>\n";
		$result = dbquery("SELECT user_id, user_name, user_level	FROM ".DB_USERS."	WHERE user_status='0' ORDER BY user_level DESC");
		if (dbrows($result)) {
			while ($data = dbarray($result)) {
				echo "<option value='".$data['user_id']."'".($score_settings['set_top_user'] == $data['user_id'] ? " selected='selected'" : "").">".$data['user_name']."</option>\n";
			}
		}
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_admin57'].":</td>\n";
		echo "<td class='tbl2' wight='50%'><select name='data' class='textbox' style='width:200px;'>\n";
		echo "<option value='0'".($score_settings['set_data'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin2']."</option>\n";
		echo "<option value='1'".($score_settings['set_data'] == 1 ? " selected='selected'" : "").">".$locale['pfss_admin4']."</option>\n";
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_scsy26']."</td>\n";
		echo "<td class='tbl2' wight='50%'><input type='password' name='admin_password' class='textbox' style='width:193px;' /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td colspan='2' align='center' class='tbl1'><input type='submit' name='save_main' class='button' value='".$locale['pfss_scsy27']."' /></td>\n";
		echo "</tr>\n</table>\n</form>\n";
	} elseif (isset($_GET['page']) && $_GET['page'] == 3) {
		if (isset($_POST['save_reset'])) {
			$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : "";
			//if (md5(md5($admin_password)) == $userdata['user_admin_password']) {
			if (check_admin_pass($admin_password)) {
				$result = dbquery("TRUNCATE TABLE ".DB_SCORE_ACCOUNT."");
				$result2 = dbquery("TRUNCATE TABLE ".DB_SCORE_TRANSFER."");
				redirect(FUSION_SELF.$aidlink."&site=main&page=3&reset=0");
			} else {
				redirect(FUSION_SELF.$aidlink."&site=main&page=3&reset=1");
			}
		}
		if (isset($_GET['reset']) && $_GET['reset'] == 0) {
			echo "<div class='admin-message'>".$locale['pfss_error6']."</div>\n";
		} elseif (isset($_GET['reset']) && $_GET['reset'] == 1) {
			echo "<div class='admin-message'>".$locale['pfss_error7']."</div>\n";
		}
		opentable($locale['pfss_open8']);
		echo "<form name='reset' method='post' action='".FUSION_SELF.$aidlink."&amp;site=main&amp;page=3'>\n";
		echo "<table cellpadding='1' cellspacing='1' width='100%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td colspan='2' class='tbl2'>".$locale['pfss_admin8']."</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td colspan='2' align='center' class='tbl1' style='color: #FF0000;'>".$locale['pfss_admin9']."<br /><br /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl2' wight='50%'>".$locale['pfss_scsy26']."</td>\n";
		echo "<td class='tbl2' wight='50%'><input type='password' name='admin_password' class='textbox' style='width:200px;' /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td colspan='2' align='center' class='tbl1'><input type='submit' name='save_reset' class='button' value='".$locale['pfss_scsy28']."' /></td>\n";
		echo "</tr>\n</table>\n</form>\n";
	} else {
		redirect(FUSION_SELF.$aidlink."&amp;site=main");
	}
} elseif (isset($_GET['site']) && $_GET['site'] == "score" && checkrights("PFSS")) {
	if (!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == 1) {
		if (isset($_GET['new']) || (isset($_GET['edit']) && isnum($_GET['edit']))) {
			if (isset($_POST['save'])) {
				$error = 0;
				$aktion = (isset($_POST['aktion']) ? stripinput($_POST['aktion']) : "");
				$title = (isset($_POST['title']) ? stripinput($_POST['title']) : "");
				$score = (isset($_POST['score']) && isnum($_POST['score']) ? $_POST['score'] : "");
				$max = (isset($_POST['max']) && isnum($_POST['max']) ? $_POST['max'] : "0");
				$status = (isset($_POST['status']) && $_POST['status'] == "y" ? 1 : 0);
				$power = (isset($_POST['power']) && isnum($_POST['power']) ? $_POST['power'] : "0");
				if ($aktion != "" && $aktion != "ADMIN" && $aktion != "TRANS" && $title != "" && $score != "") {
					if (isset($_GET['new'])) {
						$aktion_brows = dbrows(dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$aktion."'"));
						if ($aktion_brows == 0) {
							$result = dbquery("INSERT INTO ".DB_SCORE_SCORE." (sco_aktion, sco_titel, sco_score, sco_max, sco_status, sco_power) VALUES('".$aktion."', '".$title."', '".$score."', '".$max."', '".$status."', '".$power."')");
							$error = 0;
						} else {
							$error = 3;
						}
					} elseif (isset($_GET['edit'])) {
						$result = dbquery("UPDATE ".DB_SCORE_SCORE." SET sco_titel='".$title."', sco_score='".$score."', sco_max='".$max."', sco_status='".$status."', sco_power='".$power."' WHERE sco_id='".$_GET['edit']."'");
						$error = 0;
					} else {
						$error = 2;
					}
				} else {
					$error = 1;
				}
				redirect(FUSION_SELF.$aidlink."&site=score&amp;page=1&error=".$error);
			}
			if (isset($_GET['edit'])) {
				opentable($locale['pfss_open9']);
				$result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_id='".$_GET['edit']."'");
				if (dbrows($result)) {
					$data = dbarray($result);
				} else {
					redirect(FUSION_SELF.$aidlink."&site=score");
				}
				echo "<form name='score' method='post' action='".FUSION_SELF.$aidlink."&amp;site=score&amp;page=1&amp;edit=".$_GET['edit']."'>\n";
			} else {
				opentable($locale['pfss_open10']);
				echo "<form name='score' method='post' action='".FUSION_SELF.$aidlink."&amp;site=score&amp;page=1&amp;new'>\n";
			}
			echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
			echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy12'].$locale['pfss_dpoint']."</td>\n";
			echo "<td class='tbl2' width='50%'><input type='text' name='aktion' class='textbox' maxlength='5' style='width:200px;'".(isset($_GET['edit']) ? " value='".$data['sco_aktion']."' readonly='readonly'" : "")." /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy6'].$locale['pfss_dpoint']."</td>\n";
			echo "<td class='tbl2' width='50%'><input type='text' name='title' class='textbox' style='width:200px;'".(isset($_GET['edit']) ? " value='".$data['sco_titel']."'" : "")." /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl1' width='50%'>".$locale['pfss_units'].$locale['pfss_dpoint']."</td>\n";
			echo "<td class='tbl2' width='50%'><input type='text' name='score' class='textbox' maxlength='9' style='width:200px;'".(isset($_GET['edit']) ? " value='".$data['sco_score']."'" : "")." /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy13'].$locale['pfss_dpoint']."</td>\n";
			echo "<td class='tbl2'><input type='text' name='max' class='textbox' maxlength='6' style='width:200px;'".(isset($_GET['edit']) ? " value='".$data['sco_max']."'" : "")." /></td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy14'].$locale['pfss_dpoint']."</td>\n";
			echo "<td class='tbl2'><input type='checkbox' name='status' value='y'".(isset($_GET['edit']) && $data['sco_status'] == 1 ? " checked='checked'" : "")." />".$locale['pfss_admin10']."</td>\n";
			echo "</tr>\n<tr>\n";
			echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy15'].$locale['pfss_dpoint']."</td>\n";
			echo "<td class='tbl2' width='50%'><select name='power' class='textbox' style='width:200px;'>\n";
			echo "<option value='0'".(isset($_GET['edit']) && $data['sco_power'] == 0 ? " selected='selected'" : "").">".$locale['pfss_admin2']."</option>\n";
			echo "<option value='1'".(isset($_GET['edit']) && $data['sco_power'] == 1 ? " selected='selected'" : "").">".$locale['pfss_admin4']."</option>\n";
			echo "</select>\n</td>\n</tr>\n<tr>\n";
			echo "<td class='tbl1' colspan='2' align='center'><input type='submit' name='save' class='textbox' value='".$locale['pfss_scsy27']."' /></td>\n";
			echo "</tr>\n</table>\n</form>\n";
			closetable();
		}
		if (isset($_GET['error']) && $_GET['error'] == 0) {
			echo "<div class='admin-message'>".$locale['pfss_error8']."</div>\n";
		} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
			echo "<div class='admin-message'>".$locale['pfss_error2']."</div>\n";
		} elseif (isset($_GET['error']) && $_GET['error'] == 2) {
			echo "<div class='admin-message'>".$locale['pfss_error9']."</div>\n";
		} elseif (isset($_GET['error']) && $_GET['error'] == 3) {
			echo "<div class='admin-message'>".$locale['pfss_error10']."</div>\n";
		}
		opentable($locale['pfss_open11']);
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl1' width='10%'>".$locale['pfss_scsy12']."</td>\n";
		echo "<td class='tbl1' width='36%'>".$locale['pfss_scsy6']."</td>\n";
		echo "<td class='tbl1' width='10%' align='right'>".$locale['pfss_units']."</td>\n";
		echo "<td class='tbl1' width='10%' align='right'>".$locale['pfss_scsy13']."</td>\n";
		echo "<td class='tbl1' width='10%' align='right'>".$locale['pfss_scsy14']."</td>\n";
		echo "<td class='tbl1' width='10%' align='right'>".$locale['pfss_scsy15']."</td>\n";
		echo "<td class='tbl1' width='10%' align='right'>&nbsp;</td>\n";
		echo "</tr>\n";
		$result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." ORDER BY sco_titel");
		if (dbrows($result)) {
			while($score = dbarray($result)) {
				echo "<tr>\n";
				echo "<td class='tbl2'>".$score['sco_aktion']."</td>\n";
				echo "<td class='tbl2'>".$score['sco_titel']."</td>\n";
				echo "<td class='tbl2' align='right'>".$score['sco_score']."</td>\n";
				echo "<td class='tbl2' align='right'>".($score['sco_status'] == 1 ? "<img src='".SCORESYSTEM."images/uncheck.png' />" : $score['sco_max'])."</td>\n";
				echo "<td class='tbl2' align='right'><img src='".SCORESYSTEM."images/".($score['sco_status'] == 1 ? "check.png" : "uncheck.png")."' /></td>\n";
				echo "<td class='tbl2' align='right'><img src='".SCORESYSTEM."images/".($score['sco_power'] == 1 ? "check.png" : "uncheck.png")."' /></td>\n";
				echo "<td class='tbl2' align='right'><a href='".FUSION_SELF.$aidlink."&amp;site=score&amp;edit=".$score['sco_id']."'>".$locale['pfss_scsy29']."</a></td>\n";
				echo "</tr>\n";
			}
		} else {
			echo "<tr>\n<td colspan='7'>".$locale['pfss_scsy16']."</td>\n</tr>\n";
		}
		echo "<tr>\n<td colspan='6' class='tbl1'>&nbsp;</td>\n<td class='tbl2' align='right'><a href='".FUSION_SELF.$aidlink."&amp;site=score&amp;new'>".$locale['pfss_scsy30']."</a></td>\n</tr>\n";
		echo "</table>\n<br />\n";
	} elseif (isset($_GET['page']) && $_GET['page'] == 2) {
		opentable("Score Code");
		echo "<form name='score' method='get' action='".FUSION_SELF."'>\n";
		echo "<input type='hidden' name='aid' value='".iAUTH."' />\n";
		echo "<input type='hidden' name='site' value='score' />\n";
		echo "<input type='hidden' name='page' value='2' />\n";
		echo "<div align='center' class='tbl2'>\n";
		echo $locale['pfss_admin73'];
		echo "<br /><select name='code' class='textbox' style='width:200px;' onchange='this.form.submit()'><option value='0'>".$locale['pfss_admin72']."</option>\n";
		$code_result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." ORDER BY sco_titel");
		while ($code_data = dbarray($code_result)) {
			echo "<option value='".$code_data['sco_aktion']."'".(isset($_GET['code']) && $_GET['code'] == $code_data['sco_aktion'] ? " selected='selected'" : "").">".$code_data['sco_titel']."</option>\n";
		}
		echo "</select>\n</div>\n</form>\n";
		if (isset($_GET['code']) && 1 < strlen($_GET['code']) && 6 > strlen($_GET['code'])) {
			$_GET['code'] = stripinput($_GET['code']);
			$result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$_GET['code']."'");
			if (dbrows($result)) {
				$data = dbarray($result);
				add_to_head("<script type='text/javascript' src='".SCORESYSTEM."score_jquery.js'></script>");
				echo "<br />";
				echo "<div class='tbl2 score_head' style='margin-bottom:1px' title='Menue'>".$locale['pfss_admin66']."</div>\n";
				echo "<div class='tbl1 score_body' style='margin-bottom:3px'>\n";
				echo $locale['pfss_admin58']."score_positive(\"".$_GET['code']."\");";
				echo "</div>\n<br />\n";
				echo "<div class='tbl2 score_head' style='margin-bottom:1px' title='Menue'>".$locale['pfss_admin67']."</div>\n";
				echo "<div class='tbl1 score_body' style='margin-bottom:3px'>\n";
				echo $locale['pfss_admin59']."score_negative(\"".$_GET['code']."\");";
				echo "</div>\n<br />\n";
				echo "<div class='tbl2 score_head' title='Menue'>".$locale['pfss_admin68']."</div>\n";
				echo "<div class='tbl1 score_body'>\n";
				echo $locale['pfss_admin60']."score_positive_open(\"".$_GET['code']."\");";
				echo "</div>\n<br />\n";
				echo "<div class='tbl2 score_head' title='Menue'>".$locale['pfss_admin69']."</div>\n";
				echo "<div class='tbl1 score_body'>\n";
				echo $locale['pfss_admin61']."score_negative_open(\"".$_GET['code']."\");";
				echo "</div>\n<br />\n";
				echo "<div class='tbl2 score_head' title='Menue'>".$locale['pfss_admin70']."</div>\n";
				echo "<div class='tbl1 score_body'>\n";
				echo $locale['pfss_admin62']."score_free(\"".$data['sco_titel']."\", \"".$_GET['code']."\", ".$data['sco_score'].", ".$data['sco_max'].", \"P\", ".$data['sco_status'].", 0);";
				echo "</div>\n<br />\n";
				echo "<div class='tbl2 score_head' title='Menue'>".$locale['pfss_admin71']."</div>\n";
				echo "<div class='tbl1 score_body'>\n";
				echo $locale['pfss_admin63'];
				echo "if(score_positive(\"".$_GET['code']."\")) {<br />\n";
				echo "&nbsp;&nbsp;echo \"".$locale['pfss_admin64']."\";<br />\n";
				echo "} else {<br />\n";
				echo "&nbsp;&nbsp;echo \"".$locale['pfss_admin65']."\";<br />\n";
				echo "}<br />\n";
				echo "</div>\n<br />\n";
			}
		}
	} elseif (isset($_GET['page']) && $_GET['page'] == 3) {
		redirect(FUSION_SELF.$aidlink."&amp;site=score");
	} else {
		redirect(FUSION_SELF.$aidlink."&amp;site=score");
	}
} elseif (isset($_GET['site']) && $_GET['site'] == "statistik" && checkrights("PFSS")) {
	if (!isset($_GET['page']) || isset($_GET['page']) && $_GET['page'] == 1) {
		opentable($locale['pfss_open13']);
		echo "<table cellpadding='0' cellspacing='0' width='96%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl1' colspan='2'><b><u>".$locale['pfss_admin14']."</u></b>".($score_settings['set_delete'] ? "*" : "")."</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' width='50%'>".$locale['pfss_admin15']."<a onClick='javascript:toggle2(1)' style='cursor:pointer'>(".$locale['pfss_scsy34'].")</a></td>\n";
		echo "<td class='tbl2' width='50%' align='right'>".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='P'")." (".score_transfer_positiv("1")." ".$locale['pfss_units'].")</td>\n";
		echo "</tr>\n";
		echo "<tr id='toggle2_1' style='display:none'>\n";
		echo "<td class='tbl1' colspan='2' width='100%'>\n";
		$result2 = dbquery("SELECT tr.*, tu.user_id, tu.user_name
		FROM ".DB_SCORE_TRANSFER." tr
		INNER JOIN ".DB_USERS." tu ON tr.tra_user_id=tu.user_id
		WHERE tr.tra_typ='P' ORDER BY tr.tra_id DESC LIMIT 0,20");
		if (dbrows($result2)) {
			echo "<table cellpadding='0' cellspacing='0' border='1' width='100%' class='tbl-border'>\n";
			while ($data = dbarray($result2)) {
				echo "<tr>\n";
				echo "<td width='20%' class='tbl1'>".$data['tra_aktion']."-".$data['tra_user_id']."-".$data['tra_id']."</td>\n";
				echo "<td width='20%' class='tbl1'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
				echo "<td width='20%' class='tbl1'>".$data['tra_titel']."</td>\n";
				echo "<td width='20%' align='right' class='".score_transfer_color($data['tra_typ'])."'>".$data['tra_score']."</td>\n";
				echo "<td width='20%' class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		} else {
			echo $locale['pfss_admin13'];
		}
		echo "</td>\n</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl1'>".$locale['pfss_admin16']."<a onClick='javascript:toggle2(2)' style='cursor:pointer'>(".$locale['pfss_scsy34'].")</a></td>\n";
		echo "<td class='tbl2' align='right'>".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='N'")." (".score_transfer_negativ("1")." ".$locale['pfss_units'].")</td>\n";
		echo "</tr>\n";
		echo "<tr id='toggle2_2' style='display:none'>\n";
		echo "<td class='tbl1' colspan='2' width='100%'>\n";
		$result2 = dbquery("SELECT tr.*, tu.user_id, tu.user_name
		FROM ".DB_SCORE_TRANSFER." tr
		INNER JOIN ".DB_USERS." tu ON tr.tra_user_id=tu.user_id
		WHERE tr.tra_typ='N' ORDER BY tr.tra_id DESC LIMIT 0,20");
		if (dbrows($result2)) {
			echo "<table cellpadding='0' cellspacing='0' border='1' width='100%' class='tbl-border'>\n";
			while ($data = dbarray($result2)) {
				echo "<tr>\n";
				echo "<td width='20%' class='tbl1'>".$data['tra_aktion']."-".$data['tra_user_id']."-".$data['tra_id']."</td>\n";
				echo "<td width='20%' class='tbl1'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
				echo "<td width='20%' class='tbl1'>".$data['tra_titel']."</td>\n";
				echo "<td width='20%' align='right' class='".score_transfer_color($data['tra_typ'])."'>".$data['tra_score']."</td>\n";
				echo "<td width='20%' class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		} else {
			echo $locale['pfss_admin13'];
		}
		echo "</td>\n</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl1'>".$locale['pfss_admin17']."<a onClick='javascript:toggle2(3)' style='cursor:pointer'>(".$locale['pfss_scsy34'].")</a></td>\n";
		echo "<td class='tbl2' align='right'>".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='O'")." (".$locale['pfss_admin18'].dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='O' AND tra_status='3'").$locale['pfss_admin19'].dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='O' AND tra_status='4'").$locale['pfss_admin20'].") (".score_transfer_open("1")." ".$locale['pfss_units'].")</td>\n";
		echo "</tr>\n";
		echo "<tr id='toggle2_3' style='display:none'>\n";
		echo "<td class='tbl1' colspan='2' width='100%'>\n";
		$result2 = dbquery("SELECT tr.*, tu.user_id, tu.user_name
		FROM ".DB_SCORE_TRANSFER." tr
		INNER JOIN ".DB_USERS." tu ON tr.tra_user_id=tu.user_id
		WHERE tr.tra_typ='O' ORDER BY tr.tra_id DESC LIMIT 0,20");
		if (dbrows($result2)) {
			echo "<table cellpadding='0' cellspacing='0' border='1' width='100%' class='tbl-border'>\n";
			while ($data = dbarray($result2)) {
				echo "<tr>\n";
				echo "<td width='20%' class='tbl1'>".$data['tra_aktion']."-".$data['tra_user_id']."-".$data['tra_id']."</td>\n";
				echo "<td width='20%' class='tbl1'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
				echo "<td width='20%' class='tbl1'>".$data['tra_titel']."</td>\n";
				echo "<td width='20%' align='right' class='".score_transfer_color($data['tra_typ'])."'>".$data['tra_score']."</td>\n";
				echo "<td width='20%' class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
				echo "</tr>\n";
			}
			echo "</table>\n";
		} else {
			echo $locale['pfss_admin13'];
		}
		echo "</td>\n</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl1' colspan='2'><b><u>".$locale['pfss_admin21']."</u></b>".($score_settings['set_delete'] ? "*" : "")."</td>\n";
		echo "</tr>\n";
		$result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." ORDER BY sco_titel");
		if (dbrows($result)) {
			while ($score = dbarray($result)) {
				echo "<tr>\n";
				echo "<td class='tbl1'>".$score['sco_titel']." <a onClick='javascript:toggle(".$score['sco_id'].")' style='cursor:pointer'>(".$locale['pfss_scsy34'].")</a></td>\n";
				echo "<td class='tbl2' align='right'>".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_aktion='".$score['sco_aktion']."'")."</td>\n";
				echo "</tr>\n";
				echo "<tr id='toggle_".$score['sco_id']."' style='display:none'>\n";
				echo "<td class='tbl1' colspan='2' width='100%'>\n";
				$result2 = dbquery("SELECT tr.*, tu.user_id, tu.user_name
				FROM ".DB_SCORE_TRANSFER." tr
				INNER JOIN ".DB_USERS." tu ON tr.tra_user_id=tu.user_id
				WHERE tr.tra_aktion='".$score['sco_aktion']."' ORDER BY tr.tra_id DESC LIMIT 0,20");
				if (dbrows($result2)) {
					echo "<table cellpadding='0' cellspacing='0' border='1' width='100%' class='tbl-border'>\n";
					while ($data = dbarray($result2)) {
						echo "<tr>\n";
						echo "<td width='20%' class='tbl1'>".$data['tra_aktion']."-".$data['tra_user_id']."-".$data['tra_id']."</td>\n";
						echo "<td width='20%' class='tbl1'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
						echo "<td width='20%' class='tbl1'>".$data['tra_titel']."</td>\n";
						echo "<td width='20%' align='right' class='".score_transfer_color($data['tra_typ'])."'>".$data['tra_score']."</td>\n";
						echo "<td width='20%' class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
						echo "</tr>\n";
					}
					echo "</table>\n";
				} else {
					echo "".$locale['pfss_admin13']."";
				}
				echo "</td>\n</tr>\n";
			}
		} else {
			echo "<tr>\n<td class='tbl1' colspan='2'>".$locale['pfss_admin13']."</td>\n</tr>\n";
		}
		echo "<tr>\n";
		echo "<td class='tbl1' colspan='2'><b><u>".$locale['pfss_admin22']."</u></b></td>\n";
		echo "</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl1'>".$locale['pfss_admin23']."<a onClick='javascript:toggle2(4)' style='cursor:pointer'>(".$locale['pfss_scsy34'].")</a></td>\n";
		echo "<td class='tbl2' align='right'>".(dbcount("(user_id)", DB_USERS) - dbcount("(acc_user_id)", DB_SCORE_ACCOUNT))."</td>\n";
		echo "</tr>\n";
		echo "<tr id='toggle2_4' style='display:none'>\n";
		echo "<td class='tbl1' colspan='2' width='100%'>\n";
		$result2 = dbquery("SELECT au.user_id, au.user_name, ac.*
		FROM ".DB_USERS." au
		LEFT JOIN ".DB_SCORE_ACCOUNT." ac ON au.user_id=ac.acc_user_id
		WHERE ac.acc_user_id IS NULL ORDER BY au.user_name LIMIT 0,50");
		if (dbrows($result2)) {
			$i=1;
			while ($data = dbarray($result2)) {
				if (1 < $i) { echo ", "; }
				echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a>";
				$i++;
			}
		} else {
			echo $locale['pfss_admin13'];
		}
		echo "</td>\n</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl1'>".$locale['pfss_admin24']."<a onClick='javascript:toggle2(5)' style='cursor:pointer'>(".$locale['pfss_scsy34'].")</a></td>\n";
		echo "<td class='tbl2' align='right'>".dbcount("(acc_user_id)", DB_SCORE_ACCOUNT, "acc_score='0'")."</td>\n";
		echo "</tr>\n";
		echo "<tr id='toggle2_5' style='display:none'>\n";
		echo "<td class='tbl1' colspan='2' width='100%'>\n";
		$result2 = dbquery("SELECT ac.*, au.user_id, au.user_name
		FROM ".DB_SCORE_ACCOUNT." ac
		INNER JOIN ".DB_USERS." au ON ac.acc_user_id=au.user_id
		WHERE ac.acc_score='0' ORDER BY au.user_name");
		if (dbrows($result2)) {
			$i=1;
			while ($data = dbarray($result2)) {
				if (1 < $i) { echo ", "; }
				echo "<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a>";
				$i++;
			}
		} else {
			echo $locale['pfss_admin13'];
		}
		echo "</td>\n</tr>\n";
		echo "<tr>\n";
		echo "<td class='tbl1'>".$locale['pfss_admin25']."</td>\n";
		echo "<td class='tbl2' align='right'>".dbcount("(acc_user_id)", DB_SCORE_ACCOUNT, "acc_score>'0'")."</td>\n";
		echo "</tr>\n";
		if ($score_settings['set_delete']) {
			echo "<tr>\n";
			echo "<td class='tbl1'><b><u>".$locale['pfss_admin26']."</u></b></td>\n";
			echo "<td class='tbl1'>".$locale['pfss_admin27'].$score_settings['set_delete'].$locale['pfss_scsyu4']."</td>\n";
			echo "</tr>\n";
		}
		echo "</table>\n";
		echo "<script type='text/javascript'>
		function toggle(id) {
		  tr = 'toggle_'+id;
		  val = document.getElementById(tr).style.display;
		  if (val == 'none') {
		    document.getElementById(tr).style.display = '';
		  } else {
		    document.getElementById(tr).style.display = 'none';
		  }
		}
		function toggle2(id) {
		  tr = 'toggle2_'+id;
		  val = document.getElementById(tr).style.display;
		  if (val == 'none') {
		    document.getElementById(tr).style.display = '';
		  } else {
		    document.getElementById(tr).style.display = 'none';
		  }
		}
		</script>";
	} elseif (isset($_GET['page']) && $_GET['page'] == 2) {
		if (isset($_GET['t1']) && isset($_GET['t2']) && isset($_GET['t3'])) {
			$_POST['t1'] = stripinput($_GET['t1']);
			$_POST['t2'] = (isnum($_GET['t2']) ? $_GET['t2'] : "0");
			$_POST['t3'] = (isnum($_GET['t3']) ? $_GET['t3'] : "0");
			if ($_POST['t1'] != "" && strlen($_GET['t1']) < 6 && $_GET['t2'] != 0 && $_GET['t3'] != 0) {
				$save = true;
			} else {
				$_POST['t1'] = "";
				$_POST['t2'] = "";
				$_POST['t3'] = "";
				$save = false;
			}
		} else {
			$save = false;
		}
		if (isset($_GET['error']) && $_GET['error'] == 0) {
			echo "<div class='admin-message'>".$locale['pfss_admin75']."</div>\n";
		} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
			echo "<div class='admin-message'>".$locale['pfss_admin75']."</div>\n";
		}
		opentable($locale['pfss_open12']);
		echo "<form name='statistik' method='post' action='".FUSION_SELF.$aidlink."&amp;site=statistik&amp;page=2'>\n";
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl2' width='50%'>".$locale['pfss_admin11']."</td>\n";
		echo "<td class='tbl2' width='50%'><input type='text' name='t1' class='textbox' style='width:50px;' maxlength='5' value='".(isset($_POST['t1']) ? $_POST['t1'] : "")."'".(isset($_POST['save']) || $save ? " readonly='readonly'" : "")." /> - <input type='text' name='t2' class='textbox' style='width:50px;' value='".(isset($_POST['t2']) ? $_POST['t2'] : "")."'".(isset($_POST['save']) || $save ? " readonly='readonly'" : "")." /> - <input type='text' name='t3' class='textbox' style='width:50px;' value='".(isset($_POST['t3']) ? $_POST['t3'] : "")."'".(isset($_POST['save']) || $save ? " readonly='readonly'" : "")." /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' colspan='2' align='center'><input type='submit' name='back' class='textbox' value='".$locale['pfss_scsy31']."' /> <input type='submit' name='save' class='textbox' value='".(isset($_POST['save']) || $save ? $locale['pfss_scsy32'] : $locale['pfss_scsy33'])."' /></td>\n";
		echo "</tr>\n";
		if (isset($_POST['save']) || $save) {
			$result = dbquery("SELECT ta.*, tu.user_id, tu.user_name
			FROM ".DB_SCORE_TRANSFER." ta
			INNER JOIN ".DB_USERS." tu ON ta.tra_user_id=tu.user_id
			WHERE ta.tra_aktion='".stripinput($_POST['t1'])."' AND ta.tra_user_id='".(isnum($_POST['t2']) ? $_POST['t2'] : "0")."' AND ta.tra_id='".(isnum($_POST['t3']) ? $_POST['t3'] : "0")."' LIMIT 1");
			if (dbrows($result)) {
				$data = dbarray($result);
				echo "<tr>\n<td class='tbl2' colspan='2' align='center'>\n";
				echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
				echo "<td class='tbl2' width='10%'>".$locale['pfss_scsy9']."</td>\n";
				echo "<td class='tbl2' width='50%'>".$locale['pfss_scsy6']."</td>\n";
				echo "<td class='tbl2' width='10%'>".$locale['pfss_units']."</td>\n";
				echo "<td class='tbl2' width='30%'>Datum</td>\n";
				echo "</tr>\n<tr>\n";
				echo "<td class='tbl2' width='10%'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
				echo "<td class='tbl2' width='50%'>".$data['tra_titel']."</td>\n";
				echo "<td class='".score_transfer_color($data['tra_typ'])."' align='right' width='10%'>".$data['tra_score']."</td>\n";
				echo "<td class='tbl2' width='30%'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
				echo "</tr>\n<tr>\n";
				echo "<td class='tbl2' colspan='2'>".$locale['pfss_admin12']."</td>\n";
				echo "<td class='tbl2' colspan='2'><input type='hidden' name='id' class='textbox' value='".$_POST['t3']."' /><input type='password' name='admin_password' class='textbox' style='width:193px;' /></td>\n";
				echo "</tr>\n</table>\n</td>\n</tr>\n";
				$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : "";
				//if (md5(md5($admin_password)) == $userdata['user_admin_password'] && isset($_POST['id']) && isnum($_POST['id'])) {
				if (check_admin_pass($admin_password) && isset($_POST['id']) && isnum($_POST['id'])) {
					if (score_admin_open_false($_POST['id'])) {
						redirect(FUSION_SELF.$aidlink."&site=statistik&page=2&error=0");
					} else {
						redirect(FUSION_SELF.$aidlink."&site=statistik&page=2&error=1");
					}					
				}
			} else {
				echo "<tr>\n<td class='tbl2' colspan='2' align='center'>".$locale['pfss_admin13']."</td>\n</tr>\n";
			}
		}
		echo "</table>\n</form>\n";
	} elseif (isset($_GET['page']) && $_GET['page'] == 3) {
		opentable($locale['pfss_open19']);
		echo "<form name='score' method='get' action='".FUSION_SELF."'>\n";
		echo "<input type='hidden' name='aid' value='".iAUTH."' />\n";
		echo "<input type='hidden' name='site' value='statistik' />\n";
		echo "<input type='hidden' name='page' value='3' />\n";
		echo "<table cellpadding='1' cellspacing='1' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl2' align='center'><select name='id' class='textbox' style='width:208px;' onChange='this.form.submit()'><option value='0'>Bitte w&auml;hlen</option>\n";
		$user_result = dbquery("SELECT user_id, user_name, user_level FROM ".DB_USERS." ORDER BY user_level DESC, user_name");
		while ($user_data = dbarray($user_result)) {
			echo "<option value='".$user_data['user_id']."'".(isset($_GET['id']) && $_GET['id'] == $user_data['user_id'] ? " selected='selected'" : "").">".$user_data['user_name']."</option>\n";
		}
		echo "</select>\n</td>\n</tr>\n</table>\n</form>\n";
		if (isset($_GET['id']) && isnum($_GET['id']) && $_GET['id'] != 0) {
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
			
			echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
			echo "<td class='tbl2' width='10%'>".$locale['pfss_scsy5']."</td>";
			echo "<td class='tbl2' width='50%'>".$locale['pfss_scsy6']."</td>";
			echo "<td class='tbl2' width='10%'>".$locale['pfss_units']."</td>";
			echo "<td class='tbl2' width='30%'>".$locale['pfss_scsy7']."</td>";
			echo "</tr>\n";
			$result = dbquery("SELECT * FROM ".DB_SCORE_TRANSFER." WHERE ".$transfer." tra_user_id='".$_GET['id']."' AND tra_status!='5' ORDER BY tra_id DESC LIMIT ".$_GET['rowstart'].",".$_GET['limit']."");
			$row = dbrows(dbquery("SELECT * FROM ".DB_SCORE_TRANSFER." WHERE ".$transfer."tra_user_id='".$_GET['id']."'"));
			if (dbrows($result)) {
				while ($data = dbarray($result)) {
					echo "<tr>\n";
					echo "<td class='tbl1'>
					<a href='".FUSION_SELF.$aidlink."&amp;site=statistik&amp;page=2&amp;t1=".$data['tra_aktion']."&amp;t2=".$_GET['id']."&amp;t3=".$data['tra_id']."' target='_self'>".$data['tra_aktion']."-".$_GET['id']."-".$data['tra_id']."</a></td>\n";
					echo "<td class='tbl1'>".$data['tra_titel']."</td>\n";
					echo "<td class='".score_transfer_color($data['tra_typ'])."' align='right'>".$data['tra_score']."</td>\n";
					echo "<td class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
					echo "</tr>\n";
				}
				if ($row > $_GET['limit']) { echo "<tr>\n<td colspan='4' align='center' class='tbl1'>".makepagenav($_GET['rowstart'],$_GET['limit'],$row,3, FUSION_SELF.$aidlink."&amp;site=statistik&amp;page=3&amp;id=".$_GET['id']."&amp;limit=".$_GET['limit'].(isset($_GET['transfer']) ? "&amp;transfer=".$_GET['transfer'] : "")."&amp;")."</td></tr>\n"; }
			} else {
				echo "<tr>\n<td colspan='4' class='tbl1'>".$locale['pfss_scsy8']."</td></tr>\n";
			}
			echo "<tr>\n<td colspan='2' class='tbl2'>";
			echo "<form method='get' action='".FUSION_SELF."'>\n";
			echo "<input type='hidden' name='aid' value='".iAUTH."' />\n";
			echo "<input type='hidden' name='site' value='statistik' />\n";
			echo "<input type='hidden' name='page' value='3' />\n";
			echo "<input type='hidden' name='id' value='".$_GET['id']."' />\n";
			echo "<input type='hidden' name='rowstart' value='".$_GET['rowstart']."' />\n";
			if (isset($_GET['transfer'])) { echo "<input type='hidden' name='transfer' value='".$_GET['transfer']."' />\n"; }
			echo $locale['pfss_scsyu8']."<select name='limit' class='textbox' onChange='this.form.submit()'>\n";
			echo "<option".($_GET['limit'] == 5 ? " selected='selected'" : "").">5</option>\n";
			echo "<option".($_GET['limit'] == 10 ? " selected='selected'" : "").">10</option>\n";
			echo "<option".($_GET['limit'] == 25 ? " selected='selected'" : "").">25</option>\n";
			echo "<option".($_GET['limit'] == 50 ? " selected='selected'" : "").">50</option>\n";
			echo "<option".($_GET['limit'] == 100 ? " selected='selected'" : "").">100</option>\n</select>\n";
			echo "</form></td><td colspan='2' class='tbl2'><form method='get' action='".FUSION_SELF."'>\n";
			echo "<input type='hidden' name='aid' value='".iAUTH."' />\n";
			echo "<input type='hidden' name='site' value='statistik' />\n";
			echo "<input type='hidden' name='page' value='3' />\n";
			echo "<input type='hidden' name='id' value='".$_GET['id']."' />\n";
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
		}
	} else {
		redirect(FUSION_SELF.$aidlink."&amp;site=statistik");
	}
} elseif (isset($_GET['site']) && $_GET['site'] == "ban" && (checkrights("PFSS") || checkrights("PFSB"))) {
	if (isset($_GET['delete']) && isnum($_GET['delete'])) {
		$result = dbquery("DELETE FROM ".DB_SCORE_BAN." WHERE ban_id='".$_GET['delete']."'");
		redirect(FUSION_SELF.$aidlink."&site=ban");
	} elseif (isset($_GET['new'])) {
		if (isset($_POST['save'])) {
			$admin_password = isset($_POST['admin_password']) ? $_POST['admin_password'] : "";
			$user = (isset($_POST['user']) && isnum($_POST['user']) ? $_POST['user'] : "");
			if (isset($_POST['aktuell']) && $_POST['aktuell'] == "y") {
				$start_time = time();
			} elseif ($_POST['start_day']!="--" && $_POST['start_mon']!="--" && $_POST['start_year']!="----") {
				$start_time = mktime(0,0,0,$_POST['start_mon'],$_POST['start_day'],$_POST['start_year']);
			} else {
				$start_time = time();
			}
			if (isset($_POST['unlimited']) && $_POST['unlimited'] == "y") {
				$stop_time = "0";
			} elseif ($_POST['stop_day']!="--" && $_POST['stop_mon']!="--" && $_POST['stop_year']!="----") {
				$stop_time = mktime(0,0,0,$_POST['stopt_mon'],$_POST['stop_day'],$_POST['stop_year']);
			} else {
				$stop_time = "0";
			}
			$text = (isset($_POST['text']) ? stripinput($_POST['text']) : "");
			//if (md5(md5($admin_password)) == $userdata['user_admin_password'] && $user != "" && $text != "") {
			if ( check_admin_pass($admin_password) && $user != "" && $text != "" ) {
				$result = dbquery("INSERT INTO ".DB_SCORE_BAN." (ban_user_id, ban_time_start, ban_time_stop, ban_text, ban_admin_id) VALUES('".$user."', '".$start_time."', '".$stop_time."', '".$text."', '".$userdata['user_id']."')");
				$error=0;
			} else {
				$error=1;
			}
			redirect(FUSION_SELF.$aidlink."&site=ban&error=".$error);
		}
		opentable($locale['pfss_open14']);
		echo "<form name='ban' method='post' action='".FUSION_SELF.$aidlink."&amp;site=ban&amp;new'>\n";
		echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
		echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy9'].$locale['pfss_dpoint']."</td>\n";
		echo "<td class='tbl2' width='50%'><select name='user' class='textbox' style='width:200px;'>\n";
		$user_result = dbquery("SELECT user_id, user_name, user_level FROM ".DB_USERS." ORDER BY user_level DESC");
		while ($user_data = dbarray($user_result)) {
			echo "<option value='".$user_data['user_id']."'".(isset($_GET['edit']) && $data['ban_user_id'] == $user_data['user_id'] ? " selected='selected'" : "").">".$user_data['user_name']."</option>\n";
		}
		echo "</select>\n</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' width='50%'>".$locale['pfss_admin28']."</td>\n";
		echo "<td class='tbl2' width='50%'><select name='start_day' class='textbox'>\n<option>--</option>\n";
		for ($i=1;$i<=31;$i++) echo "<option>".$i."</option>\n";
		echo "</select> <select name='start_mon' class='textbox'>\n<option>--</option>\n";
		for ($i=1;$i<=12;$i++) echo "<option>".$i."</option>\n";
		echo "</select> <select name='start_year' class='textbox'>\n<option>----</option>\n";
		for ($i=date("Y");$i<=(date("Y")+10);$i++) echo "<option>".$i."</option>\n";
		echo "</select>".$locale['pfss_admin30']."<input type='checkbox' name='aktuell' value='y' />".$locale['pfss_admin31']."</td>\n</tr>\n<tr>\n";
		echo "<td class='tbl1' width='50%'>".$locale['pfss_admin29']."</td>\n";
		echo "<td class='tbl2' width='50%'><select name='stop_day' class='textbox'>\n<option>--</option>\n";
		for ($i=1;$i<=31;$i++) echo "<option>".$i."</option>\n";
		echo "</select> <select name='stop_mon' class='textbox'>\n<option>--</option>\n";
		for ($i=1;$i<=12;$i++) echo "<option>".$i."</option>\n";
		echo "</select> <select name='stop_year' class='textbox'>\n<option>----</option>\n";
		for ($i=date("Y");$i<=(date("Y")+10);$i++) echo "<option>".$i."</option>\n";
		echo "</select>".$locale['pfss_admin30']."<input type='checkbox' name='unlimited' value='y' />".$locale['pfss_admin32']."</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' width='50%' valign='top'>".$locale['pfss_admin33']."</td>\n";
		echo "<td class='tbl2'><textarea name='text' rows='5' class='textbox' style='width:98%'></textarea></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' wight='50%'>".$locale['pfss_scsy26']."</td>\n";
		echo "<td class='tbl2' wight='50%'><input type='password' name='admin_password' class='textbox' style='width:193px;' /></td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td class='tbl1' colspan='2' align='center'><input type='submit' name='save' class='button' value='".$locale['pfss_scsy27']."' /></td>\n";
		echo "</tr>\n</table>\n</form>\n";
		closetable();
	}
	if (isset($_GET['error']) && $_GET['error'] == 0) {
		echo "<div class='admin-message'>".$locale['pfss_error11']."</div>\n";
	} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
		echo "<div class='admin-message'>".$locale['pfss_error7']."</div>\n";
	}
	$result = dbquery("SELECT ba.*, bu.user_id, bu.user_name, bv.user_id as user_admin_id, bv.user_name as user_admin_name
	FROM ".DB_SCORE_BAN." ba
	INNER JOIN ".DB_USERS." bu ON ba.ban_user_id=bu.user_id
	INNER JOIN ".DB_USERS." bv ON ba.ban_admin_id=bv.user_id
	ORDER BY ba.ban_time_start, ba.ban_time_stop, bu.user_name
	");
	opentable($locale['pfss_open15']);
	echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
	echo "<td class='tbl1' width='15%'>".$locale['pfss_admin34']."</td>\n";
	echo "<td class='tbl1' width='10%'>".$locale['pfss_admin35']."</td>\n";
	echo "<td class='tbl1' width='10%'>".$locale['pfss_admin36']."</td>\n";
	echo "<td class='tbl1' width='30%'>".$locale['pfss_admin37']."</td>\n";
	echo "<td class='tbl1' width='15%'>".$locale['pfss_admin38']."</td>\n";
	echo "<td class='tbl1' width='16%'>&nbsp;</td>\n";
	echo "</tr>\n";
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
			echo "<tr>\n";
			echo "<td class='tbl2'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
			echo "<td class='tbl2'>".showdate($settings['shortdate'], $data['ban_time_start'])."</td>\n";
			echo "<td class='tbl2'>".($data['ban_time_stop'] == 0 ? "Unbegrenzt" : showdate($settings['shortdate'], $data['ban_time_stop']))."</td>\n";
			echo "<td class='tbl2'>".$data['ban_text']."</td>\n";
			echo "<td class='tbl2'><a href='".BASEDIR."profile.php?lookup=".$data['user_admin_id']."' target='_self' title='".$data['user_admin_name']."'>".$data['user_admin_name']."</a></td>\n";
			echo "<td class='tbl2'><a href='".FUSION_SELF.$aidlink."&amp;site=ban&amp;delete=".$data['ban_id']."'>Aufl&ouml;sen</a></td>\n";
			echo "</tr>\n";
		}
		echo "<tr>\n<td class='tbl1' colspan='5' align='center'>&nbsp;</td>\n<td class='tbl2'><a href='".FUSION_SELF.$aidlink."&amp;site=ban&amp;new'>".$locale['pfss_scsy30']."</a></td>\n</tr>\n";
	} else {
		echo "<tr>\n<td class='tbl1' colspan='5' align='center'>".$locale['pfss_admin39']."</td>\n<td class='tbl2'><a href='".FUSION_SELF.$aidlink."&amp;site=ban&amp;new'>".$locale['pfss_scsy30']."</a></td>\n</tr>\n";
	}
	echo "</table>\n";
} elseif (isset($_GET['site']) && $_GET['site'] == "admin" && (checkrights("PFSS") || checkrights("PFST"))) {
	if (isset($_POST['save'])) {
		$title = (isset($_POST['title']) ? stripinput($_POST['title']) : "");
		$score = (isset($_POST['score']) && isnum($_POST['score']) ? $_POST['score'] : "");
		if ($title != "" && $score != "") {
			if (score_admin($_POST['user'], $title, $score, $_POST['typ'])) {
				$error=0;
			} else {
				$error=2;
			}
		} else {
			$error=1;
		}
		redirect(FUSION_SELF.$aidlink."&amp;site=admin&amp;error=".$error);
	}
	if (isset($_GET['error']) && $_GET['error'] == 0) {
		echo "<div class='admin-message'>".$locale['pfss_error1']."</div>";
	} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
		echo "<div class='admin-message'>".$locale['pfss_error2']."</div>";
	} elseif (isset($_GET['error']) && $_GET['error'] == 2) {
		echo "<div class='admin-message'>".$locale['pfss_error3']."</div>";
	}
	opentable($locale['pfss_open16']);
	echo "<form name='score' method='post' action='".FUSION_SELF.$aidlink."&amp;site=admin'>\n";
	echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n<tr>\n";
	echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy9'].$locale['pfss_dpoint']."</td>\n";
	echo "<td class='tbl2' width='50%'><select name='user' class='textbox' style='width:208px;'>";
	$user_result = dbquery("SELECT user_id, user_name, user_level FROM ".DB_USERS." ORDER BY user_level DESC, user_name");
	while ($user_data = dbarray($user_result)) {
		echo "<option value='".$user_data['user_id']."'".(isset($_GET['edit']) && $data['ban_user_id'] == $user_data['user_id'] ? " selected='selected'" : "").">".$user_data['user_name']."</option>\n";
	}
	echo "</select>\n</td>\n</tr>\n<tr>\n";
	echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy6'].$locale['pfss_dpoint']."</td>\n";
	echo "<td class='tbl2' width='50%'><input type='text' name='title' class='textbox' style='width:200px;'".(isset($_GET['edit']) ? " value='".$data['sco_titel']."'" : "")." /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' width='50%'>".$locale['pfss_units'].$locale['pfss_dpoint']."</td>\n";
	echo "<td class='tbl2' width='50%'><input type='text' name='score' class='textbox' maxlength='9' style='width:200px;'".(isset($_GET['edit']) ? " value='".$data['sco_score']."'" : "")." /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy35']."</td>\n";
	echo "<td class='tbl2' width='50%'><select name='typ' class='textbox' style='width:208px;'>\n";
	echo "<option value='P'>".$locale['pfss_scsyu11']."</option>\n";
	echo "<option value='N'>".$locale['pfss_scsyu12']."</option>\n";
	echo "</select>\n</td>\n</tr>\n<tr>\n";
	echo "<td class='tbl1' colspan='2' align='center'><input type='submit' name='save' class='button' value='".$locale['pfss_scsy27']."' /></td>\n";
	echo "</tr>\n</table>\n</form>\n";
} elseif (isset($_GET['site']) && $_GET['site'] == "open" && (checkrights("PFSS") || checkrights("PFSO"))) {
	if (isset($_GET['true']) && isnum($_GET['true'])) {
		if (score_admin_open_true($_GET['true'])) {
			redirect(FUSION_SELF.$aidlink."&site=open&error=0");
		} else {
			redirect(FUSION_SELF.$aidlink."&site=open&error=1");
		}
	} elseif (isset($_GET['false']) && isnum($_GET['false'])) {
		if (score_admin_open_false($_GET['false'])) {
			redirect(FUSION_SELF.$aidlink."&site=open&error=0");
		} else {
			redirect(FUSION_SELF.$aidlink."&site=open&error=1");
		}
	}
	if (isset($_GET['error']) && $_GET['error'] == 0) {
		echo "<div class='admin-message'>".$locale['pfss_error1']."</div>";
	} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
		echo "<div class='admin-message'>".$locale['pfss_error3']."</div>";
	}
	opentable($locale['pfss_open17']);
	echo "<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n";
	echo "<tr>\n<td class='tbl1' colspan='4'>".$locale['pfss_admin40']."(".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='O' AND tra_status='3'").")</td>\n</tr>\n";
	$result = dbquery("SELECT st.*, su.user_id, su.user_name 
	FROM ".DB_SCORE_TRANSFER." st
	INNER JOIN ".DB_USERS." su ON st.tra_user_id=su.user_id
	WHERE tra_typ='O' AND tra_status='3' ORDER BY tra_time");
	if (dbrows($result)) {
		echo "<tr>\n";
		echo "<td class='tbl1' width='20%'>".$locale['pfss_admin34']."</td>\n";
		echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy6']."</td>\n";
		echo "<td class='tbl1' width='10%'>".$locale['pfss_units']."</td>\n";
		echo "<td class='tbl1' width='20%'>&nbsp;</td>\n";
		echo "</tr>\n";
		while($data = dbarray($result)) {
			echo "<tr>\n";
			echo "<td class='tbl1'>".$data['user_name']."</td>\n";
			echo "<td class='tbl1'>".$data['tra_titel']."</td>\n";
			echo "<td class='tbl1'>".$data['tra_score']."</td>\n";
			echo "<td class='tbl1'><a href='".FUSION_SELF.$aidlink."&amp;site=open&amp;true=".$data['tra_id']."'>".$locale['pfss_admin41']."</a> | <a href='".FUSION_SELF.$aidlink."&amp;site=open&amp;false=".$data['tra_id']."'>".$locale['pfss_admin42']."</a></td>\n";
			echo "</tr>\n";
		}
	} else {
		echo "<tr>\n<td class='tbl1' colspan='4'>".$locale['pfss_admin13']."</td>\n</tr>\n";
	}
	echo "</table>\n<table cellpadding='1' cellspacing='1' width='96%' class='tbl-border' align='center'>\n";
	echo "<tr>\n<td class='tbl1' colspan='4'>".$locale['pfss_admin42']."(".dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_typ='O' AND tra_status='4'").")</td>\n</tr>\n";
	$result = dbquery("SELECT st.*, su.user_id, su.user_name 
	FROM ".DB_SCORE_TRANSFER." st
	INNER JOIN ".DB_USERS." su ON st.tra_user_id=su.user_id
	WHERE tra_typ='O' AND tra_status='4' ORDER BY tra_time");
	if (dbrows($result)) {
		echo "<tr>\n";
		echo "<td class='tbl1' width='20%'>".$locale['pfss_admin34']."</td>\n";
		echo "<td class='tbl1' width='50%'>".$locale['pfss_scsy6']."</td>\n";
		echo "<td class='tbl1' width='10%'>".$locale['pfss_units']."</td>\n";
		echo "<td class='tbl1' width='20%'>&nbsp;</td>\n";
		echo "</tr>\n";
		while($data = dbarray($result)) {
			echo "<tr>";
			echo "<td class='tbl1'>".$data['user_name']."</td>";
			echo "<td class='tbl1'>".$data['tra_titel']."</td>";
			echo "<td class='tbl1'>".$data['tra_score']."</td>";
			echo "<td class='tbl1'><a href='".FUSION_SELF.$aidlink."&amp;site=open&amp;true=".$data['tra_id']."'>".$locale['pfss_admin41']."</a> | <a href='".FUSION_SELF.$aidlink."&amp;site=open&amp;false=".$data['tra_id']."'>".$locale['pfss_admin42']."</a></td>";
			echo "</tr>\n";
		}
	} else {
		echo "<tr>\n<td class='tbl1' colspan='4'>".$locale['pfss_admin13']."</td>\n</tr>\n";
	}
	echo "</table>\n";
} elseif (isset($_GET['site']) && ($_GET['site'] == "lizenz" || $_GET['site'] == "addons" || $_GET['site'] == "addonpage") && checkrights("PFSS") && file_exists(SCORESYSTEM."lizenz.php")) {
	if ($_GET['site'] == "lizenz") {
		if (file_exists(SCORESYSTEM."lizenz.php")) {
			score_lizenz();
		} else {
			redirect(FUSION_SELF.$aidlink."&site=main");
		}
	} elseif ($_GET['site'] == "addons" && defined("SCORE_ADDONS")) {
		if (function_exists("score_addons")) {
			score_addons();
		} else {
			redirect(FUSION_SELF.$aidlink."&site=main");
		}
	} elseif ($_GET['site'] == "addonpage" && defined("SCORE_ADDONS")) {
		if (function_exists("score_addons")) {
			score_addonpage();
		} else {
			redirect(FUSION_SELF.$aidlink."&site=main");
		}
	} else {
		redirect(FUSION_SELF.$aidlink."&site=main");
	}
} else {
	if (checkrights("PFSS")) {
		redirect(FUSION_SELF.$aidlink."&site=main");
	} elseif (checkrights("PFSB")) {
		redirect(FUSION_SELF.$aidlink."&site=ban");
	} elseif (checkrights("PFST")) {
		redirect(FUSION_SELF.$aidlink."&site=admin");
	} elseif (checkrights("PFSO")) {
		redirect(FUSION_SELF.$aidlink."&site=open");
	} else {
		redirect(BASEDIR."index.php");
	}
}
echo SCORE_ADMIN;
closetable();
require_once SCORESYSTEM."version_check.php";

require_once THEMES."templates/footer.php";
?>