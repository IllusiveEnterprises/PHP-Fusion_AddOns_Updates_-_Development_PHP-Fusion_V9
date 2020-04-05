<?php

include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";

function d1wintodiceSet($field) {
	$data = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));
	$value = $data[$field];
	return $value;
}

function d1dicetowinsec() {
	global $settings, $aidlink;
	if (d1wintodiceSet("inf_name") == "" || d1wintodiceSet("inf_name") != md5("D1 Dice to win") || d1wintodiceSet("site_url") == "" || d1wintodiceSet("site_url") != md5("D1 Dice to win".$settings['siteurl'])) {
		redirect(INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win_register.php".$aidlink);
	}
}

function d1dicetowinsec2() {
	global $settings, $aidlink;
	if (d1wintodiceSet("inf_name") == "" || d1wintodiceSet("inf_name") != md5("D1 Dice to win") || d1wintodiceSet("site_url") == "" || d1wintodiceSet("site_url") != md5("D1 Dice to win".$settings['siteurl'])) {
		redirect(BASEDIR."index.php");
	}
}

?>