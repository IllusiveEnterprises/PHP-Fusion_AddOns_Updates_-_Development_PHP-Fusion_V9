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

if (defined("SCORESYSTEM")) {
	add_to_head("<link rel='stylesheet' href='".SCORESYSTEM."styles.css' type='text/css' media='screen' />\n");
	if (iMEMBER) {
		score_account();
		
		// Score für Gästebuch by basti2web.de
		if (file_exists(INFUSIONS."guest_book/guest_book.php") && FUSION_SELF == "guest_book.php") {
			if (isset($_POST['guest_submit'])) {
				if (isset($errorcap) && $errorcap == false && isset($errorspace) && $errorspace == false && isset($spambot) && $spambot == false && isset($sysflood) && $sysflood == false && isset($action) && $action == false) {
					score_positive("GBUCH");
				}
			}
		}
		
		// Score für alle Einsendungen (Links, News, Artikel, Foto)
		if (file_exists(BASEDIR."submit.php") && FUSION_SELF == "submit.php") {
			if (isset($_GET['stype']) && $_GET['stype'] == "l" && isset($_POST['submit_link'])) {
				if ($_POST['link_name'] != "" && $_POST['link_url'] != "" && $_POST['link_description'] != "") {
					score_positive("LINKS");
				}
			} elseif (isset($_GET['stype']) && $_GET['stype'] == "n" && isset($_POST['submit_news'])) {
				if ($_POST['news_subject'] != "" && $_POST['news_body'] != "") {
					score_positive("NEWS");
				}
			} elseif (isset($_GET['stype']) && $_GET['stype'] == "a" && isset($_POST['submit_article'])) {
				if ($_POST['article_subject'] != "" && $_POST['article_body'] != "") {
					score_positive("ARTIK");
				}
			} elseif (isset($_GET['stype']) && $_GET['stype'] == "p" && isset($_POST['submit_photo'])) {
				if (!$error) {
					score_positive("FOTOS");
				}
			}
		}
		
	}
}
?>