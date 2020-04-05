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
if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!defined("SCORESYSTEM")) {
	define("SCORESYSTEM", INFUSIONS."scoresystem_panel/");
}
include_once SCORESYSTEM."infusion_db.php";
$score_time = time();
$score_time_on = mktime(0,0,0,date("m"),date("d"),date("Y"));
$score_time_off = mktime(23,59,59,date("m"),date("d"),date("Y"));
$score_result = dbquery("SELECT * FROM ".DB_SCORE_SETTINGS);
if (dbrows($score_result)) { // Laden der Haupteinstellungen und lösche alte Transfers bei Aktivierung
	$score_settings = dbarray($score_result);
	if ($score_settings['set_delete']) {
		$delete_time = $score_time - ($score_settings['set_delete']*24*60*60);
		$delete_result = dbquery("DELETE FROM ".DB_SCORE_TRANSFER." WHERE tra_status='0' AND tra_time<='".$delete_time."'");
		$delete_result2 = dbquery("UPDATE ".DB_SCORE_TRANSFER." SET tra_status='5' WHERE tra_status='1' AND tra_time<='".$delete_time."'");
	}
} else {
	$score_settings = "";
}
if (file_exists(SCORESYSTEM."lizenz.php")) {
	@include_once SCORESYSTEM."lizenz.php";
} else {
	define("SCORE", base64_decode("PGRpdiBhbGlnbj0ncmlnaHQnPjxhIGhyZWY9J2h0dHA6Ly93d3cuUEhQRnVzaW9uLVN1cHBvcnRDbHViLmRlJyB0YXJnZXQ9J19ibGFuaycgdGl0bGU9J1Njb3Jlc3lzdGVtJz5TY29yZXN5c3RlbSAmY29weTs8L2E+PC9kaXY+"));
	define("SCORE_PANEL", base64_decode("PGRpdiBhbGlnbj0ncmlnaHQnPjxhIGlkPSdzY29yZXN5c3RlbScgaHJlZj0naHR0cDovL3d3dy5QSFBGdXNpb24tU3VwcG9ydENsdWIuZGUnIHRhcmdldD0nX2JsYW5rJyB0aXRsZT0nU2NvcmVzeXN0ZW0nPlNjb3Jlc3lzdGVtICZjb3B5OzwvYT48L2Rpdj4="));
	define("SCORE_ADMIN", base64_decode("PGRpdiBhbGlnbj0ncmlnaHQnPjxhIGhyZWY9J2h0dHA6Ly93d3cuUEhQRnVzaW9uLVN1cHBvcnRDbHViLmRlJyB0YXJnZXQ9J19ibGFuaycgdGl0bGU9J1Njb3Jlc3lzdGVtJz5TY29yZXN5c3RlbSAmY29weTs8L2E+PC9kaXY+"));
}
if (file_exists(SCORESYSTEM."locale/".LOCALESET."index.php")) {
	include SCORESYSTEM."locale/".LOCALESET."index.php";
} else {
	include SCORESYSTEM."locale/German/index.php";
}

// USER MANAGEMENT START
function score_ban($user) {
	global $score_time;
	if (isnum($user)) {
		$result = dbquery("SELECT * FROM ".DB_SCORE_BAN." WHERE ban_user_id='".$user."' AND ((ban_time_start<='".$score_time."' AND ban_time_stop>='".$score_time."') OR (ban_time_start<='".$score_time."' AND ban_time_stop='0'))");
		if (dbrows($result) || $user == 0 || !iMEMBER) {
			return true; // Konto Gesperrt oder Gast
		} else {
			return false; // Konto Frei und Member
		}
	} else {
		return true; // Keine User ID
	}
}

function score_account() {
	global $userdata;
	$result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$userdata['user_id']."' LIMIT 1");
	if (!dbrows($result)) {
		$result = dbquery("INSERT INTO ".DB_SCORE_ACCOUNT." (acc_user_id, acc_score) VALUES ('".$userdata['user_id']."','0')");
	}
}

function score_account_stand($user=0) {
	global $userdata;
	if (isnum($user) && $user != 0) { // Variable $user prüfen
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user)) { // Kontostatus abfragen
		$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
		if (dbrows($acc_result)) {
			$acc_data = dbarray($acc_result);
			return $acc_data['acc_score']; // Aktueller Kontostand
		} else {
			return 0; // Keine Daten vorhanden
		}
	} else {
		return false; // Konto Gesperrt
	}
}

function score_account_color($user=0) {
	global $userdata;
	if (isnum($user) && $user != 0) { // Variable $user prüfen
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user)) {
		if (score_account_stand($score_user) > 0) {
			return "score_positiv"; // Color Positiv
		} elseif (score_account_stand($score_user) < 0) {
			return "score_negativ"; // Color Negativ
		} elseif (score_account_stand($score_user) == 0) {
			return "score_positiv"; // Color Positiv
		} else {
			return false; // Fehler oder Kontogesperrt
		}
	} else {
		return "score_ban";
	}
}

function score_transfer_color($typ) {
	if ($typ == "P") {
		return "score_tra_p"; // Color Positiv
	} elseif ($typ == "N") {
		return "score_tra_n"; // Color Negativ
	} elseif ($typ == "O") {
		return "score_tra_o"; // Color Open
	} elseif ($typ == "S") {
		return "score_tra_s"; // Color Storno
	} else {
		return false; // Fehler
	}
}

function score_transfer_positiv($status=0) {
	global $userdata;
	if (iMEMBER) {
		$result = dbquery("SELECT SUM(tra_score) as summe FROM ".DB_SCORE_TRANSFER." WHERE ".($status == 0 ? "tra_user_id='".$userdata['user_id']."' AND " : "")."tra_typ='P'");
		list($summe) = mysql_fetch_array($result);
		if ($summe == "") { $summe = 0; }
		return $summe;
	} else {
		return false;
	}
}

function score_transfer_negativ($status=0) {
	global $userdata;
	if (iMEMBER) {
		$result = dbquery("SELECT SUM(tra_score) as summe FROM ".DB_SCORE_TRANSFER." WHERE ".($status == 0 ? "tra_user_id='".$userdata['user_id']."' AND " : "")."tra_typ='N'");
		list($summe) = mysql_fetch_array($result);
		if ($summe == "") { $summe = 0; }
		return $summe;
	} else {
		return false;
	}
}

function score_transfer_open($status=0) {
	global $userdata;
	if (iMEMBER) {
		$result1 = dbquery("SELECT SUM(tra_score) as summe FROM ".DB_SCORE_TRANSFER." WHERE ".($status == 0 ? "tra_user_id='".$userdata['user_id']."' AND " : "")."tra_typ='O' AND tra_status='3'");
		$result2 = dbquery("SELECT SUM(tra_score) as summe FROM ".DB_SCORE_TRANSFER." WHERE ".($status == 0 ? "tra_user_id='".$userdata['user_id']."' AND " : "")."tra_status='4'");
		list($summe_p) = mysql_fetch_array($result1);
		list($summe_n) = mysql_fetch_array($result2);
		if ($summe_p == "") { $summe_p = 0; }
		if ($summe_n == "") { $summe_n = 0; }
		return ($summe_p - $summe_n);
	} else {
		return false;
	}
}

// USER MANAGEMENT STOP
// ADMIN FUNCTION START
function score_admin($user, $titel, $score, $typ="P") {
	global $score_time;
	if (isnum($user) && isnum($score)) { // Sicherheitsabfrage
		$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$user."' LIMIT 1");
		if (dbrows($acc_result)) { // Account vorhanden oder nicht
			$acc_data = dbarray($acc_result);
			if ($typ == "P") {
				$new_score = $acc_data['acc_score'] + $score;
			} elseif ($typ == "N") {
				$new_score = $acc_data['acc_score'] - $score;
			} else {
				return false;
			}
			$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$user."'");
		} else {
			if ($typ == "P") {
				$new_score = $score;
			} elseif ($typ == "N") {
				$new_score = 0 - $score;
			} else {
				return false;
			}
			$acc_result2 = dbquery("INSERT INTO ".DB_SCORE_ACCOUNT." (acc_user_id, acc_score) VALUES ('".$user."','".$new_score."')");
		}
		$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$user."', '".stripinput($titel)."', '".$typ."', 'ADMIN', '".$score."', '0', '".$score_time."')");
		return true;
	} else {
		return false; // User und Score sind keine Zahlen
	}
}

function score_admin_open_true($id) {
	if (isnum($id)) {
		$tra_result = dbquery("SELECT * FROM ".DB_SCORE_TRANSFER." WHERE tra_id='".$id."'");
		if (dbrows($tra_result)) { 
			$tra_data = dbarray($tra_result);
			if ($tra_data['tra_status'] == 3) {
				$tra_result2 = dbquery("UPDATE ".DB_SCORE_TRANSFER." SET tra_typ='P', tra_status='0' WHERE tra_id='".$id."'");
				return true;
			} elseif ($tra_data['tra_status'] == 4) {
				$tra_result2 = dbquery("UPDATE ".DB_SCORE_TRANSFER." SET tra_typ='N', tra_status='0' WHERE tra_id='".$id."'");
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_admin_open_false($id) {
	if (isnum($id)) {
		$tra_result = dbquery("SELECT * FROM ".DB_SCORE_TRANSFER." WHERE tra_id='".$id."'");
		if (dbrows($tra_result)) { // Transfer Daten abfragen
			$tra_data = dbarray($tra_result);
			if ($tra_data['tra_status'] == 3 || $tra_data['tra_typ'] == "P") {
				$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=acc_score-".$tra_data['tra_score']." WHERE acc_user_id='".$tra_data['tra_user_id']."'");
				$tra_result2 = dbquery("DELETE FROM ".DB_SCORE_TRANSFER." WHERE tra_id='".$id."'");
				return true;
			} elseif ($tra_data['tra_status'] == 4 || $tra_data['tra_typ'] == "N") {
				$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=acc_score+".$tra_data['tra_score']." WHERE acc_user_id='".$tra_data['tra_user_id']."'");
				$tra_result2 = dbquery("DELETE FROM ".DB_SCORE_TRANSFER." WHERE tra_id='".$id."'");
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}
// ADMIN FUNCTION STOP
// MAIN FUNCTION START
function score_positive($aktion, $user=0) {
	global $userdata, $score_time, $score_time_on, $score_time_off;
	if (isnum($user) && $user != 0) {
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user)) {
		$aktion = stripinput($aktion);
		$sco_result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$aktion."' LIMIT 1");
		if (dbrows($sco_result)) {
			$score_data = dbarray($sco_result);
			$titel = $score_data['sco_titel']; $score = $score_data['sco_score']; $max = ($score_data['sco_status'] ? 1 : $score_data['sco_max']);
			$only = ($score_data['sco_status'] ? "" : " AND tra_time>='".$score_time_on."' AND tra_time<='".$score_time_off."'");
			$status = dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_user_id='".$score_user."' AND tra_aktion='".$aktion."'".$only."");
			if ($max > $status) {
				$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
				if (dbrows($acc_result)) {
					$acc_data = dbarray($acc_result);
					$new_score = $acc_data['acc_score'] + $score;
					$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$score_user."'");
				} else {
					$new_score = $score;
					$acc_result2 = dbquery("INSERT INTO ".DB_SCORE_ACCOUNT." (acc_user_id, acc_score) VALUES ('".$score_user."','".$new_score."')");
				}
				$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$score_user."', '".$titel."', 'P', '".$aktion."', '".$score."', '".$score_data['sco_status']."', '".$score_time."')");
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_negative($aktion, $user=0) {
	global $userdata, $score_time, $score_time_on, $score_time_off;
	if (isnum($user) && $user != 0) {
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user)) {
		$aktion = stripinput($aktion);
		$sco_result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$aktion."' LIMIT 1");
		if (dbrows($sco_result)) {
			$score_data = dbarray($sco_result);
			$titel = $score_data['sco_titel']; $score = $score_data['sco_score']; $max = ($score_data['sco_status'] ? 1 : $score_data['sco_max']);
			$only = ($score_data['sco_status'] ? "" : " AND tra_time>='".$score_time_on."' AND tra_time<='".$score_time_off."'");
			$status = dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_user_id='".$score_user."' AND tra_aktion='".$aktion."'".$only."");
			if ($max > $status) {
				$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
				if (dbrows($acc_result)) {
					$acc_data = dbarray($acc_result);
					if ($acc_data['acc_score'] >= $score) {
						$new_score = $acc_data['acc_score'] - $score;
						$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$score_user."'");
						$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$score_user."', '".$titel."', 'N', '".$aktion."', '".$score."', '".$score_data['sco_status']."', '".$score_time."')");
						return true;
					} else {
						return false;
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_positive_open($aktion, $user=0) {
	global $userdata, $score_time;
	if (isnum($user) && $user != 0) {
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user)) {
		$aktion = stripinput($aktion);
		$sco_result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$aktion."' LIMIT 1");
		if (dbrows($sco_result)) {
			$score_data = dbarray($sco_result);
			$titel = $score_data['sco_titel']; $score = $score_data['sco_score'];
			$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
			if (dbrows($acc_result)) {
				$acc_data = dbarray($acc_result);
				$new_score = $acc_data['acc_score'] + $score;
				$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$score_user."'");
			} else {
				$new_score = $score;
				$acc_result2 = dbquery("INSERT INTO ".DB_SCORE_ACCOUNT." (acc_user_id, acc_score) VALUES ('".$score_user."','".$new_score."')");
			}
			$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$score_user."', '".$titel."', 'O', '".$aktion."', '".$score."', '3', '".$score_time."')");
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_negative_open($aktion, $user=0) {
	global $userdata, $score_time;
	if (isnum($user) && $user != 0) {
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user)) {
		$aktion = stripinput($aktion);
		$sco_result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$aktion."' LIMIT 1");
		if (dbrows($sco_result)) {
			$score_data = dbarray($sco_result);
			$titel = $score_data['sco_titel']; $score = $score_data['sco_score'];
			$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
			if (dbrows($acc_result)) {
				$acc_data = dbarray($acc_result);
				if ($acc_data['acc_score'] >= $score) {
					$new_score = $acc_data['acc_score'] - $score;
					$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$score_user."'");
					$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$score_user."', '".$titel."', 'O', '".$aktion."', '".$score."', '4', '".$score_time."')");
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_storno($aktion, $user=0) {
	global $userdata, $score_time, $locale;
	if (isnum($user) && $user != 0) {
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if ($score_user != 0) {
		$aktion = stripinput($aktion);
		$sco_result = dbquery("SELECT * FROM ".DB_SCORE_SCORE." WHERE sco_aktion='".$aktion."' LIMIT 1");
		if (dbrows($sco_result)) {
			$score_data = dbarray($sco_result);
			$titel = $score_data['sco_titel']; $score = $score_data['sco_score'];
			$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
			if (dbrows($acc_result)) {
				$acc_data = dbarray($acc_result);
				$new_score = $acc_data['acc_score'] - $score;
				$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$score_user."'");
			} else {
				$new_score = 0 - $score;
				$acc_result2 = dbquery("INSERT INTO ".DB_SCORE_ACCOUNT." (acc_user_id, acc_score) VALUES ('".$score_user."','".$new_score."')");
			}
			$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$score_user."', '".$locale['pfss_main1'].$titel."', 'S', '".$aktion."', '".$score."', '0', '".$score_time."')");
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_transfer($user1, $user2, $score, $title) {
	global $score_time, $score_settings, $locale;
	if ($score_settings['set_user_transfer'] && isnum($user1) && isnum($user2) && isnum($score) && !score_ban($user1) && !score_ban($user2)) {
		if (score_account_stand($user1) >= ($score + $score_settings['set_user_tra_sco'])) {
			$new_score = score_account_stand($user1) - $score;
			$acc_result = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$user1."'");
			$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$user1."', '".$locale['pfss_main2'].stripinput($title)."', 'N', 'TRANS', '".$score."', '0', '".$score_time."')");
			$new_score2 = score_account_stand($user2) + $score;
			$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score2." WHERE acc_user_id='".$user2."'");
			$tra_result2 = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$user2."', '".$locale['pfss_main2'].stripinput($title)."', 'P', 'TRANS', '".$score."', '0', '".$score_time."')");
			if ($score_settings['set_user_tra_sco']) {
				$new_score3 = score_account_stand($user1) - $score_settings['set_user_tra_sco'];
				$acc_result3 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score3." WHERE acc_user_id='".$user1."'");
				$tra_result3 = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$user1."', '".$locale['pfss_main2'].$locale['pfss_units']."', 'N', 'TRANS', '".$score_settings['set_user_tra_sco']."', '0', '".$score_time."')");
			}
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function score_free($titel, $aktion, $score, $maxi=5, $typ="P", $status=0, $user=0) {
	global $userdata, $score_time, $score_time_on, $score_time_off;
	if (isnum($user) && $user != 0) {
		$score_user = $user;
	} else {
		$score_user = $userdata['user_id'];
	}
	if (!score_ban($score_user) && isnum($score) && isnum($status) && isnum($maxi)) {
		$titel = stripinput($titel);
		$aktion = stripinput($aktion);
		$max = ($status ? 1 : $maxi);
		$only = ($status ? "" : " AND tra_time>='".$score_time_on."' AND tra_time<='".$score_time_off."'");
		$status_max = dbcount("(tra_id)", DB_SCORE_TRANSFER, "tra_user_id='".$score_user."' AND tra_aktion='".$aktion."'".$only."");
		if ($max > $status_max) {
			$acc_result = dbquery("SELECT * FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$score_user."' LIMIT 1");
			if (dbrows($acc_result)) {
				$acc_data = dbarray($acc_result);
				if ($typ == "P") {
					$new_score = $acc_data['acc_score'] + $score; $new_typ = $typ; $new_status = $status;
				} elseif ($typ == "N") {
					if ($acc_data['acc_score'] >= $score) {
						$new_score = $acc_data['acc_score'] - $score; $new_typ = $typ; $new_status = $status;
					} else {
						return false;
					}
				} elseif ($typ == "OP") {
					$new_score = $acc_data['acc_score'] + $score; $new_typ = "O"; $new_status = "3";
				} elseif ($typ == "ON") {
					if ($acc_data['acc_score'] >= $score) {
						$new_score = $acc_data['acc_score'] - $score; $new_typ = "O"; $new_status = "4";
					} else {
						return false;
					}
				} elseif ($typ == "S") {
					$new_score = $acc_data['acc_score'] - $score; $new_typ = $typ; $new_status = $status;
				} else {
					return false;
				}
				$acc_result2 = dbquery("UPDATE ".DB_SCORE_ACCOUNT." SET acc_score=".$new_score." WHERE acc_user_id='".$score_user."'");
			} else {
				if ($typ == "P") {
					$new_score = $score; $new_typ = $typ; $new_status = $status;
				} elseif ($typ == "N") {
					return false;
				} elseif ($typ == "OP") {
					$new_score = $score; $new_typ = "O"; $new_status = "3";
				} elseif ($typ == "ON") {
					return false;
				} elseif ($typ == "S") {
					$new_score = 0 - $score; $new_typ = $typ; $new_status = $status;
				} else {
					return false;
				}
				$acc_result2 = dbquery("INSERT INTO ".DB_SCORE_ACCOUNT." (acc_user_id, acc_score) VALUES ('".$score_user."','".$new_score."')");
			}
			$tra_result = dbquery("INSERT INTO ".DB_SCORE_TRANSFER." (tra_user_id, tra_titel, tra_typ, tra_aktion, tra_score, tra_status, tra_time) VALUES ('".$score_user."', '".$titel."', '".$new_typ."', '".$aktion."', '".$score."', '".$new_status."', '".$score_time."')");
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}
// MAIN FUNCTION STOP
?>