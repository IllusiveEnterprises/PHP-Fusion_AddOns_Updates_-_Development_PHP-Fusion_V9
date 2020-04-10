<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: functions.php
| Version: 1.0.0
| Author: Matze-W
| Site: http://matze-web.de
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

function packtime($id) {
	global $locale;
	$result = dbquery("SELECT * FROM ".MW_PREMIUM_PACK." WHERE pack_id='".$id."'");
	if (dbrows($result)) {
		$data = dbarray($result);
			$pack_time = $data['pack_time'];
			$iJ=sprintf("%2d",floor($pack_time/31536000));
			$iMo=sprintf("%2d",floor($pack_time/2592000));
			$iW=sprintf("%2d",floor($pack_time/604800));
			$iD=sprintf("%2d",floor($pack_time/(60*60*24)));
			$iH=sprintf("%2d",floor((($pack_time%604800)%86400)/3600));
			$iM=sprintf("%2d",floor(((($pack_time%604800)%86400)%3600)/60));
			if ($iJ > 0){
				if ($iJ == 1) {
					$Text = "Jahr";
				} else {
					$Text = "Jahre";
				}
				$packtime="".$iJ." ".$Text."";
			} elseif ($iMo > 0){
				if ($iMo == 1) {
					$Text = "Monat";
				} else {
					$Text = "Monate";
				}
				$packtime="".$iMo." ".$Text."";
			} elseif ($iW > 0){
				if ($iW == 1) {
					$Text = "Woche";
				} else {
					$Text = "Wochen";
				}
				$packtime="".$iW." ".$Text."";
			} elseif ($iD > 0){
				if ($iD == 1) {
					$Text = "Tag";
				} else {
					$Text = "Tage";
				}
				$packtime="".$iD." ".$Text."";
			} elseif ($iH > 0){
				if ($iH == 1) {
					$Text = "Stunde";
				} else {
					$Text = "Stunden";
				}
				$packtime="".$iH." ".$Text."";
			}else{
				if ($iM == 1) {
					$Text = "Minute";
				} else {
					$Text = "Minuten";
				}
				$packtime="".$iM." ".$Text."";
			}
		return $packtime;
	}
}

// Please do not remove copyright info
function mw_Copyright() {
	global $settings;
	if (file_exists(INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php")) {
		include INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php";
	} else {
		include INFUSIONS."mw_premium_panel/locale/German.php";
	}
	//Infusion title
	$title = $locale['MWP_title'];
	//Gets Infusion version change 'your_panel' to the folder of the infusion
	$data_version = dbarray(dbquery("SELECT inf_version FROM ".DB_INFUSIONS." WHERE inf_folder = 'mw_premium_panel'"));
	$version = $data_version['inf_version'];
	//Copyright Output
	return $copyright = "<br /><div class='small' align='right'><a href='http://www.DeeoNe.de' target='_blank' title='".$title." v".$version." &copy; ".showdate("%Y",time())." by Matze-W'><span class='small'>&copy;</span></a></div>";
	// End copyright info
}

function latest_mw_version() {
	$url = "http://matze-web.de/version/mw_premium_panel.txt";
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
?>