<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: functions.php
| Version: 1.0.0
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

if (!defined("IN_FUSION")) { die("Access Denied"); }


function f_status_pay() {
	global $status;
	if ($status['status_pay'] == "0") {
	$fstatus_pay = "<img src='".INFUSIONS."mw_buy_points_panel/images/check.png' alt='Punkte bezahlt' title='Punkte bezahlt' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a>";
	}else {
	$fstatus_pay = "<img src='".INFUSIONS."mw_buy_points_panel/images/cancel.png' alt='Punkte nicht bezahlt' title='Punkte nicht bezahlt' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a>";
	}
	return $fstatus_pay;
}

function f_status_poi() {
	global $status;
	if ($status['status_poi'] == "0") {
	$fstatus_poi = "<img src='".INFUSIONS."mw_buy_points_panel/images/check.png' alt='Punkte gutgeschrieben' title='Punkte gutgeschrieben' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a>";
	}else {
	$fstatus_poi = "<img src='".INFUSIONS."mw_buy_points_panel/images/cancel.png' alt='Punkte nicht gutgeschrieben' title='Punkte nicht gutgeschrieben' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a>";
	}
	return $fstatus_poi;
}

function f_status_methode() {
	global $status, $locale;
	if ($status['methode'] == 0) {
		return $locale['mwbp_a167'];
	}elseif ($status['methode'] == 1) {
		return $locale['mwbp_a168'];
	}elseif ($status['methode'] == 2) {
		return $locale['mwbp_a169'];
	}elseif ($status['methode'] == 3) {
		return $locale['mwbp_a177'];
	}elseif ($status['methode'] == 4) {
		return $locale['mwbp_a178'];
	}else {
		return $locale['mwbp_a169'];
	}
}

function f_status_change_pay() {
	global $status, $locale, $aidlink;
	if ($status['status_pay'] == "0") {
		//$fchange_pay = "<a href='".FUSION_SELF.$aidlink."&section=status&acceptpay=false&status_id=".$status['status_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/del.png' alt='accept' title='".$locale['mwbp_a164'].$locale['mwbp_a172']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a> |";
	}else {
		$fchange_pay = "<a href='".FUSION_SELF.$aidlink."&section=status&acceptpay=true&status_id=".$status['status_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/accept.png' alt='accept' title='".$locale['mwbp_a164'].$locale['mwbp_a170']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a> |";
	}
	return $fchange_pay;
}

function f_status_change_poi() {
	global $status, $locale, $aidlink;
	if ($status['status_poi'] == "0") {
		//$fchange_poi = "<a href='".FUSION_SELF.$aidlink."&section=status&acceptpoi=false&status_id=".$status['status_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/del.png' alt='accept' title='".$locale['mwbp_a165'].$locale['mwbp_a172']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a> |";
	}else {
		$fchange_poi = "<a href='".FUSION_SELF.$aidlink."&section=status&acceptpoi=true&status_id=".$status['status_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/accept.png' alt='accept' title='".$locale['mwbp_a165'].$locale['mwbp_a170']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a> |";
	}
	return $fchange_poi;
}

// Please do not remove copyright info
function mw_Copyright() {
	global $settings;
	if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
		include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
	} else {
		include INFUSIONS."mw_buy_points_panel/locale/German.php";
	}
	//Infusion title
	$title = $locale['mwbp_title'];
	//Gets Infusion version change 'your_panel' to the folder of the infusion
	$data_version = dbarray(dbquery("SELECT inf_version FROM ".DB_INFUSIONS." WHERE inf_folder = 'mw_buy_points_panel'"));
	$version = $data_version['inf_version'];
	//Copyright Output
	return $copyright = "<div class='small' align='right'><a href='http://www.deeone.de' target='_blank' title='".$title." v".$version." &copy; ".showdate("%Y",time())." by Matze-W &amp; DeeoNe'><span class='small'>&copy;</span></a></div>";
	// End copyright info
}

/*
function latest_mw_version() {
	$url = "http://matze-web.de/version/mw_buy_points_panel.txt";
	$url_p = @parse_url($url);
	$host = $url_p['host'];
	$port = isset($url_p['port']) ? $url_p['port'] : 80;

	$fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
	if(!$fp) return false;

	@fputs($fp, 'GET '.$url_p['path'].' HTTP/1.1'.chr(10));
	@fputs($fp, 'HOST: '.$url_p['host'].chr(10));
	@fputs($fp, 'Connection: close'.chr(10).chr(10));

	$response = @fgets($fp, 1024);
	$content = @fread($fp,1024);
	$content = preg_replace("#(.*?)text/plain(.*?)$#is","$2",$content);
	@fclose ($fp);
	$suchmuster = array();
	$suchmuster[0] = '/X-Pad: avoid browser bug/si';
	$suchmuster[1] = '/; charset=UTF-8/si';
	$content = preg_replace($suchmuster, "", $content);

	if(preg_match("#404#",$response)) return false;
	else return trim($content);
}
*/
?>