<?
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 20011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_dice_to_win.php
| Author: DeeoNe
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
include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_dice_to_win_panel/locale/German.php";
}

require_once INFUSIONS."D1_dice_to_win_panel/includes/functions.php";

if($_POST['text'] != ""){
	$chat_text = stripinput($_POST['text']);
	$d1dtw_user_id = stripinput($_POST['d1dtw_user_id']);
	$d1dtw_user_name = stripinput($_POST['d1dtw_user_name']);

	$result = dbquery("INSERT INTO ".DB_D1DW_chat." (`id`, `user_id`, `user_name`, `timer` , `time` , `text`) VALUES ('', '".$d1dtw_user_id."', '".$d1dtw_user_name."', '".mktime(24,00,0)."', '".time()."', '$chat_text')");
}
?>