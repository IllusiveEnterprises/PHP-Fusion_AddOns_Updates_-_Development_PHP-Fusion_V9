<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2009 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: functions.php
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

include INFUSIONS."D1_pinnwand_panel/infusion_db.php";

function d1pinnwandSet($field) {
	$data = dbarray(dbquery("SELECT * FROM ".DB_D1PW_settings.""));
	$value = $data[$field];
	return $value;
}

function d1pinnwandsec() {
	global $settings, $aidlink;
	if (d1pinnwandSet("inf_name") == "" || d1pinnwandSet("inf_name") != md5("D1 Pinnwand") || d1pinnwandSet("site_url") == "" || d1pinnwandSet("site_url") != md5("D1 Pinnwand".$settings['siteurl'])) {
		redirect(INFUSIONS."D1_pinnwand_panel/D1_pinnwand_register.php".$aidlink);
	}
}

function d1pinnwandsec2() {
	global $settings, $aidlink;
	if (d1pinnwandSet("inf_name") == "" || d1pinnwandSet("inf_name") != md5("D1 Pinnwand") || d1pinnwandSet("site_url") == "" || d1pinnwandSet("site_url") != md5("D1 Pinnwand".$settings['siteurl'])) {
		redirect(BASEDIR."index.php");
	}
}

?>