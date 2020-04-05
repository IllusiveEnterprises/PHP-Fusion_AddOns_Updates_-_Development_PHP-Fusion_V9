<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
| Original Code: Sebastian "slaughter" Schüssler
| Homepage: http://basti2web.de
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
// CONFIG
define("THIS_VERSION", "1.1");
$url_h = "http://www.phpfusion-supportclub.de";
$url = "http://www.phpfusion-supportclub.de/version/scoresystem.txt";
// CONFIG ENDE
if (defined("SCORESYSTEM")) {
	function version() {
		global $url;
	
		$url_p = @parse_url($url);
		$host = $url_p['host'];
		$port = isset($url_p['port']) ? $url_p['port'] : 80;
		$fp = @fsockopen($url_p['host'], $port, $errno, $errstr, 5);
		if (!$fp) return false;
		@fputs($fp, 'GET '.$url_p['path'].' HTTP/1.1'.chr(10));
		@fputs($fp, 'HOST: '.$url_p['host'].chr(10));
		@fputs($fp, 'Connection: close'.chr(10).chr(10));
		$response = @fgets($fp, 1024);
		$content = @fread($fp,1024);
		$content = preg_replace("#(.*?)text/plain(.*?)$#is","$2",$content);
		@fclose ($fp);
		if (preg_match("#404#",$response)) return false;
		else return trim($content);
	}
	
	$ausgabe="";
	if (function_exists('fsockopen')) {
		$version_new = version();
		if ($version_new > THIS_VERSION) {
			$ausgabe .= "<table>\n<tr>\n<td><img src=\"images/version_old.gif\" /></td>\n<td>";
		  $ausgabe .= "<span style=\"font-weight: bold; color: red;\">".$locale['pfss_version2'].THIS_VERSION."</span><br />";
		  $ausgabe .= "<span style=\"font-weight: bold; color: #1bdc16;\">".$locale['pfss_version3'].$version_new."</span><br />";
		  $ausgabe .= "<span style=\"font-weight: bold; \">".$locale['pfss_version4']."</span><a href=\"".$url_h."\" target=\"_blank\" title=\"".$url_h."\"><span style=\"font-weight: bold; \">".$url_h."</span></a>";
		  $ausgabe .= "</td>\n</tr>\n</table>\n";
		} else {
			$ausgabe .= "<table>\n<tr>\n<td><img src=\"images/version.gif\" /></td>\n";
			$ausgabe .= "<td><span style=\"font-weight: bold; color: #1bdc16;\">".$locale['pfss_version1'];
			$ausgabe .= THIS_VERSION."</span></td>\n</tr>\n</table>\n";
		}
	} else {
		$ausgabe .= "<br />".$locale['pfss_version5']."<br />";
		$ausgabe .= $locale['pfss_version6']."<a href=\"".$url_h."\" target=\"_blank\" title=\"".$url_h."\"><span style=\"font-weight: bold; \">".$url_h."</span></a><br /><br />";
	}
	
	opentable($locale['pfss_open6']);
	echo $ausgabe;
	closetable();
}
?>