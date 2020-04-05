<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_premium_admin.php
| Version: 1.0.0
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
require_once THEMES."templates/admin_header.php";

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

if (!checkrights("MWP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect(BASEDIR."index.php"); }

include INFUSIONS."mw_premium_panel/infusion_db.php";
include INFUSIONS."mw_premium_panel/includes/functions.php";

if (file_exists(INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."mw_premium_panel/locale/German.php";
}
$mwpset = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM_SET.""));
// Abgelaufenen Status setzen
$result = dbquery("SELECT * FROM ".MW_PREMIUM." WHERE time_off < ".time()." AND status='1'"); 
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		$result2 = dbquery("UPDATE ".MW_PREMIUM." SET status='0' WHERE user_id=".$data['user_id']."");
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$data['user_id']."'"),0);	
		$user_groups = preg_replace(array("(^\.{$mwpset['set_group']}$)","(\.{$mwpset['set_group']}\.)","(\.{$mwpset['set_group']}$)"), array("",".",""), $user_groupsold);
		$result3 = dbquery("UPDATE ".DB_USERS." SET user_groups='".$user_groups."' WHERE user_id='".$data['user_id']."'");
	}
}
// Status Ende

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "status";
}
/*
///Version
if(function_exists('fsockopen')) {
	$mwversion = latest_mw_version();
	if($mwversion != "1.0.0") {
		opentable('Update verf&uuml;gbar!');
		echo "<table cellpadding='0' cellspacing='0' class='center'>";
		echo "<tr>";
		echo "<td align=center><font color= #ff0000><b>Du hast Version 1.0.0 installiert<br />";
		echo "Auf <a href='http://matze-web.de'>matze-web.de</a> ist die Version ".$mwversion." verf&uuml;gbar.<b></td>";
		echo "</font></tr></table>";
		closetable();
	}
}
///Version ende
*/
opentable($locale['mwbp_a001']);
	echo "<table cellpadding='0' cellspacing='0' class='tbl-border center' style='margin:0 auto; width:100%;'>";
	echo "<tr>";
	echo "<td width='25%' class='".($section == "status" ? "tbl1" : "tbl2")."' align='center'>".($section == "status" ? "<strong>Premium Mitglieder</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=status'><strong>Premium Mitglieder</strong></a>")."</td>";	
	echo "<td width='25%' class='".($section == "settings" ? "tbl1" : "tbl2")."' align='center'>".($section == "settings" ? "<strong>Einstellungen</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=settings'><strong>Einstellungen</strong></a>")."</td>";
	echo "<td width='25%' class='".($section == "pack" ? "tbl1" : "tbl2")."' align='center'>".($section == "pack" ? "<strong>Premium Pakete</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=pack'><strong>Premium Pakete</strong></a>")."</td>";	
	echo "<td width='25%' class='tbl2' align='center'><a href='".INFUSIONS."mw_premium_panel/mw_premium.php'><strong>Zur Infusion</strong></a></td>";
	echo "</tr></table><br />";
	
switch ($section) {

	case "status" :
	// Premium Mitglieder
	if (isset($_POST['premium_saved'])) {
	$userid = stripinput($_POST['user_id']);
	$pwert = stripinput($_POST['pwert']);
	$premium_time = stripinput($_POST['premium_time']);
	$ptime = stripinput($_POST['ptime']);
	$endtime = $ptime*$premium_time;
	$pwert == '+' ? $endoff = time()+$endtime : $endoff = time()-$endtime;	
	$result = dbquery("INSERT INTO ".MW_PREMIUM." SET
		user_id='".$userid."',
		status='0',
		time_on='".time()."',
		time_off='".$endoff."'
		ON DUPLICATE KEY UPDATE
		time_off=time_off".$pwert.$endtime."");
		redirect(FUSION_SELF.$aidlink."&section=status");
	
	}elseif (isset($_GET['userstatus_active']) && isnum($_GET['userstatus_active'])){
		$actid = stripinput($_GET['userstatus_active']);
		$result = dbquery("UPDATE ".MW_PREMIUM." SET status='1' WHERE user_id='".$actid."'");
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$actid."'"),0);	
		if (!preg_match("(^\.{$mwpset['set_group']}|\.{$mwpset['set_group']}\.|\.{$mwpset['set_group']}$)", $user_groupsold)) {
			$user_groups = $user_groupsold.".".$mwpset['set_group'];
			$result2 = dbquery("UPDATE ".DB_USERS." SET user_groups='$user_groups' WHERE user_id='".$actid."'");
		}
		redirect(FUSION_SELF.$aidlink."&section=status");

	}elseif (isset($_GET['userstatus_inactive']) && isnum($_GET['userstatus_inactive'])){
		$iactid = stripinput($_GET['userstatus_inactive']);		
		$result = dbquery("UPDATE ".MW_PREMIUM." SET status='0' WHERE user_id='".$iactid."'");
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$iactid."'"),0);	
		$user_groups = preg_replace(array("(^\.{$mwpset['set_group']}$)","(\.{$mwpset['set_group']}\.)","(\.{$mwpset['set_group']}$)"), array("",".",""), $user_groupsold);
		$result3 = dbquery("UPDATE ".DB_USERS." SET user_groups='".$user_groups."' WHERE user_id='".$iactid."'");
		redirect(FUSION_SELF.$aidlink."&section=status");

	}elseif (isset($_GET['userstatus_delete']) && isnum($_GET['userstatus_delete'])){
		$delid = stripinput($_GET['userstatus_delete']);
		$result = dbquery("DELETE FROM ".MW_PREMIUM." WHERE user_id='".$delid."'");
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$delid."'"),0);	
		$user_groups = preg_replace(array("(^\.{$mwpset['set_group']}$)","(\.{$mwpset['set_group']}\.)","(\.{$mwpset['set_group']}$)"), array("",".",""), $user_groupsold);
		$result3 = dbquery("UPDATE ".DB_USERS." SET user_groups='".$user_groups."' WHERE user_id='".$delid."'");
		redirect(FUSION_SELF.$aidlink."&section=status");
	}
	// Premium Zeit addieren oder subtrahieren
	echo "<form name='premium_saved' method='post' action='".FUSION_SELF.$aidlink."&section=status'>";
	echo "<table width='60%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "<tr><td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>Premium Zeit</td></tr>";
	echo "<tr><td class='tbl1' align='center''>";
	$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." ORDER BY user_name ASC");
	$userlist = "";	
	while ($data = dbarray($result)) {
		$userlist .= "<option value='".$data['user_id']."'>".$data['user_name']."</option>\n";
		$usersettings = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM." WHERE user_id=".$data['user_id'].""));	
	}		
	echo "<select name='user_id' id='user_id' style='margin-right:5px;'>".$userlist."</select>";		
	echo "<select name='pwert' id='pwert' style='margin-right:5px;'>
		<option value='+'>Plus</option>
		<option value='-'>Minus</option>
		</select>";
	echo "<input type='text' class='textbox' name='premium_time' style='width:50px;border:1px solid #c0c0c0;margin-right:5px;' />";
	echo "<select name='ptime' id='ptime' style='margin-right:5px;'>
		<option value='0'>---</option>
		<option value='60'>Minuten</option>
		<option value='3600'>Stunden</option>
		<option value='86400'>Tage</option>
		<option value='604800'>Wochen</option>
		<option value='2592000'>Monate</option>
		<option value='31536000'>Jahre</option>
		</select>";
	echo "<input type='submit' name='premium_saved' value='Speichern' class='button' />";
	echo "</td></tr></table></form>";
	echo "<br />";
	// Premium Mitglieder Liste
	echo "<table width='100%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "<tr><td class='tbl2' colspan='9' style='font-weight:bold;text-align:center;'>Premium-Mitglieder</td></tr>";
	echo "<tr><td class='tbl1' style='font-weight:bold;text-align:center;'>Mitglied</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>Status</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>von</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>bis</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$score_settings['set_units']."</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>Aktivieren</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>Deaktivieren</td>";
	echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>L&ouml;schen</td></tr>";
	$result = dbquery("SELECT tbl.*, tu.* FROM ".MW_PREMIUM." as tbl INNER JOIN ".DB_USERS." as tu ON (tbl.user_id = tu.user_id ) ORDER BY time_off DESC");
	if (dbrows($result)) {
		$i = 0;
		while ($data = dbarray($result)){
			$class = (($i % 2) ? 'tbl1' : 'tbl2');
			if ($data['status']=="0") {
				$mwstatus = "Inaktiv";
				$font_color = "Red";
			} else {
				$mwstatus = "Aktiv";
				$font_color = "lime";
			}
			$mwscore = dbresult(dbquery("SELECT acc_score FROM ".DB_SCORE_ACCOUNT." WHERE acc_user_id='".$data['user_id']."'"),0);
			echo "<tr><td class='".$class."' style='text-align:center;'><font color=".$font_color.">".$data['user_name']."</font></td>";
			echo "<td class='".$class."' style='text-align:center;'><font color=".$font_color.">".$mwstatus."</font></td>";
			echo "<td class='".$class."' style='text-align:center;'><b><font color=".$font_color.">".showdate("%d.%m.%Y %H:%M:%S", $data['time_on'])."</b></font></td>";
			echo "<td class='".$class."' style='text-align:center;'><b><font color=".$font_color.">".showdate("%d.%m.%Y %H:%M:%S", $data['time_off'])."</b></font></td>";
			echo "<td class='".$class."' style='text-align:center;'><b><font color=".$font_color.">".$mwscore."</b></font></td>";
			echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=status&userstatus_active=".$data['user_id']."'><img src='images/activ.png' style='width:16px;height:16px;border:0;' /></a></td>";
			echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=status&userstatus_inactive=".$data['user_id']."'><img src='images/pause.png' style='width:16px;height:16px;border:0;' /></a></td>";
			echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=status&userstatus_delete=".$data['user_id']."'><img src='images/delekt.png' style='width:16px;height:16px;border:0;' /></a></td></tr>";
			$i++;
		}
	} else {
		echo "<tr><td class='tbl2' colspan='9' style='font-weight:bold;text-align:center;'>Keine Premium Mitglieder vorhanden</td></tr>";
	}
	echo "</table>";
	// Premium Mitglieder Ende
	break;

	case "settings" :
	// Einstellungen
	if(isset($_POST['save']) && isnum($_POST['premium_group'])) {
		$premium_group = stripinput($_POST['premium_group']);
		$result = dbquery("UPDATE ".MW_PREMIUM_SET." SET
			set_group='".$premium_group."'
			WHERE set_id='1'");
		redirect(FUSION_SELF.$aidlink."&section=settings");
		}
	echo "<form name='mwpsettings' method='post' action='".FUSION_SELF.$aidlink."&section=settings'>";
	echo "<table width='60%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "<tr><td class='tbl2' colspan='2' style='font-weight:bold;text-align:left;'>Premium Gruppe w&auml;hlen</td></tr>";
	echo "<tr>";
	echo "<td class='tbl1' style='text-align:right;' width='40%'>Premium Gruppe</td>";
	echo "<td class='tbl1' style='text-align:left;'>";
	echo "<select name='premium_group'>";
	echo "<option value='0'>Bitte ausw&auml;hlen</option>";
	$result = dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS."");
	while ($gdata = dbarray($result)) {
		echo "<option value='".$gdata['group_id']."' ".($mwpset['set_group']==$gdata['group_id'] ? "selected" : "").">".$gdata['group_name']."</option>";
	}
	echo "</select></td></tr>";
	echo "<tr><td class='tbl2' style='text-align:center;' colspan='2'><input type='submit' name='save' value='Speichern' class='button' />";
	echo "</td></tr></table></form>";
	break;

	case "pack" :
	// Premium Packete
	$result = dbquery("SELECT * FROM ".MW_PREMIUM_PACK." ORDER BY pack_time");
	echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:400px;'>";
	echo "<tr><td class='tbl1' colspan='4' style='font-weight:bold;font-size:bigger;text-align:center;'>Premium Pakete</td></tr>";
	echo "<tr><td class='tbl2' width='39%' style='font-weight:bold;'>Premium Zeit</td>";
	echo "<td class='tbl2' width='39%' style='font-weight:bold;'>Premium Kosten</td>";
	echo "<td class='tbl2' width='20%' style='font-weight:bold;'>Optionen</td></tr>";
	if (dbrows($result) != 0) {
		$i = 0;
		while ($pack = dbarray($result)) {
			if ($i%2 == 0) $class="tbl1"; else $class="tbl2";
			echo "<tr>";
			echo "<td class='".$class."'>".packtime($pack['pack_id'])."</td>";
			echo "<td class='".$class."'>".$pack['pack_price']." ".$score_settings['set_units']."</td>";
			//echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=pack&editpack=true&pack_id=".$pack['pack_id']."'><img src='".INFUSIONS."mw_premium_panel/images/edit.png' alt='Edit' title='Bearbeiten' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a>";
			echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=pack&deletepack=true&pack_id=".$pack['pack_id']."'><img src='".INFUSIONS."mw_premium_panel/images/delete.png' alt='delete' title='Lšschen' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a>";
			echo "</td></tr>";
			$i++;
		}
	} else {
		echo "<tr><td class='tbl1' colspan='8'>Keine Packete vorhanden</td></tr>";
	}
	echo "<tr><td class='tbl2' colspan='8' style='font-weight:bold;font-size:bigger;text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=pack&newpack=true' class='button'>Neues Premium Paket anlegen</a></td></tr>";
	echo "</table>";

	if (isset($_GET['newpack'])) {
		if (isset($_POST['pack_saved'])) {
			if($_POST['pack_time'] != "") {
			$pack_time = stripinput($_POST['pack_time']);
			$maltime = stripinput($_POST['maltime']);
			$endtime = $pack_time*$maltime;
			$pack_price = stripinput($_POST['pack_price']);
			$result = dbquery("
				INSERT INTO ".MW_PREMIUM_PACK." SET
				pack_time='".$endtime."',
				pack_price='".$pack_price."'
				");
			redirect(FUSION_SELF.$aidlink."&section=pack");
			}
		} else {
			echo "<br /><form name='newpackform' method='post' action='".FUSION_SELF.$aidlink."&section=pack&newpack=true' onreset=\"location.href='".FUSION_SELF.$aidlink."&section=pack'\">
			<table cellpadding='0' cellspacing='1' class='center' style='width:50%;'>
			<tr>
			<td class='tbl1' colspan='2' style='font-weight:bold;font-size:bigger;text-align:left;'>Neues Premium Paket anlegen:</td>
			</tr>
			<tr>
			<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='pack_time'>Premium Zeit:</label></td>
			<td class='tbl2' style='vertical-align:top;'><input type='text' class='textbox' name='pack_time' style='width:80px;border:1px solid #c0c0c0;' />  
			<select name='maltime' id='maltime'>
			<option value='60'>Minuten</option>
			<option value='3600'>Stunden</option>
			<option value='86400'>Tage</option>
			<option value='604800'>Wochen</option>
			<option value='2592000'>Monate</option>
			<option value='31536000'>Jahre</option>		
			</select></td>
			</tr><tr>
			<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='pack_price'>Premium Kosten:</label></td>
			<td class='tbl2' style='vertical-align:top;'><input type='text' class='textbox' name='pack_price' style='width:80px;border:1px solid #c0c0c0;' />  ".$score_settings['set_units']."</td>
			</tr>
			<tr>
			<td class='tbl2' style='vertical-align:top;text-align:center;' colspan='2'><input type='submit' name='pack_saved' value='Speichern' class='button' />&nbsp;<input type='reset' value='Reset' class='button' /></td>
			</tr>
			</table>
			</form>";
		}
	}
	// Packet editieren
/*	if (isset($_GET['editpack'])) {
		$pack_id = stripinput($_GET['pack_id']);
		$pdata = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM_PACK." WHERE pack_id='".$pack_id."'"));
		// Editiertes Speichern
		if (isset($_POST['edit_pack_saved'])) {
			$pack_time = stripinput($_POST['pack_time']);
			$maltime = stripinput($_POST['maltime']);
			$endtime = $pack_time*$maltime;
			$pack_price = stripinput($_POST['pack_price']);
			$result = dbquery("
				UPDATE ".MW_PREMIUM_PACK." SET
				pack_time='".$endtime."',
				pack_price='".$pack_price."'
				WHERE pack_id='".$pack_id."'
				");
			redirect(FUSION_SELF.$aidlink."&section=pack");
		
		} else {
			echo "<br /><form name='editpackform' method='post' action='".FUSION_SELF.$aidlink."&section=pack&editpack=true&pack_id=".$pack_id."' onreset=\"location.href='".FUSION_SELF.$aidlink."&section=pack'\">
			<table cellpadding='0' cellspacing='1' class='center' style='width:50%;'>
			<tr>
			<td class='tbl1' colspan='2' style='font-weight:bold;font-size:bigger;text-align:left;'>Premium Paket bearbeiten:</td>
			</tr>
			<tr>
			<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='pack_time'>Premium Zeit:</label></td>
			<td class='tbl2' style='vertical-align:top;'><input type='text' class='textbox' name='pack_time' value='".$pdata['pack_time']."' width:80px;border:1px solid #c0c0c0;' />
			<select name='maltime' id='maltime'>
			<option value='60'>Minuten</option>
			<option value='3600'>Stunden</option>
			<option value='86400'>Tage</option>
			<option value='604800'>Wochen</option>
			<option value='2592000'>Monate</option>
			<option value='31536000'>Jahre</option>		
			</select></td>
			</tr>
			<tr>
			<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='pack_price'>Premium Kosten:</label></td>
			<td class='tbl2' style='vertical-align:top;'><input type='text' class='textbox' name='pack_price' value='".$pdata['pack_price']."' width:80px;border:1px solid #c0c0c0;' />  ".$score_settings['set_units']."</td>
			</tr>
			<tr>
			<td class='tbl2' style='vertical-align:top;text-align:center;' colspan='2'><input type='submit' name='edit_pack_saved' value='Speichern' class='button' />&nbsp;<input type='reset' value='Reset' class='button' /></td>
			</tr>
			</table>
			</form>";
		}
	}*/
	// Packet loeschen
	if (isset($_GET['deletepack'])){
		$pack_id = stripinput($_GET['pack_id']);
		$result = dbquery("DELETE FROM ".MW_PREMIUM_PACK." WHERE pack_id='".$pack_id."'");
		redirect(FUSION_SELF.$aidlink."&section=pack");
	}
	break;
}
closetable();
// Do not remove this line!
echo "".mw_Copyright()."<br />";
require_once THEMES."templates/footer.php";
?>