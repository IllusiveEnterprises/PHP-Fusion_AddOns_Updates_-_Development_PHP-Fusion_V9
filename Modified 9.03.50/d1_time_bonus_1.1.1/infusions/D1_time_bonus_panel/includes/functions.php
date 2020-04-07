<?php

include INFUSIONS."D1_time_bonus_panel/infusion_db.php";

function d1timebonusSet($field) {
	$data = dbarray(dbquery("SELECT * FROM ".DB_d1_tbconf.""));
	$value = $data[$field];
	return $value;
}

function d1timebonussec() {
	global $settings, $aidlink;
	if (d1timebonusSet("inf_name") == "" || d1timebonusSet("inf_name") != md5("D1 Time Bonus") || d1timebonusSet("site_url") == "" || d1timebonusSet("site_url") != md5("D1 Time Bonus".$settings['siteurl'])) {
		redirect(INFUSIONS."D1_time_bonus_panel/D1_time_bonus_panel_register.php".$aidlink);
	}
}

function d1timebonussec2() {
	global $settings, $aidlink;
	if (d1timebonusSet("inf_name") == "" || d1timebonusSet("inf_name") != md5("D1 Time Bonus") || d1timebonusSet("site_url") == "" || d1timebonusSet("site_url") != md5("D1 Time Bonus".$settings['siteurl'])) {
		redirect(BASEDIR."index.php");
	}
}

?>