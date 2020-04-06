<?php

include INFUSIONS."D1_coupon_panel/infusion_db.php";

function d1couponSet($field) {
	$data = dbarray(dbquery("SELECT * FROM ".DB_D1CP_conf.""));
	$value = $data[$field];
	return $value;
}

function d1couponsec() {
	global $settings, $aidlink;
	if (d1couponSet("inf_name") == "" || d1couponSet("inf_name") != md5("D1 Coupon") || d1couponSet("site_url") == "" || d1couponSet("site_url") != md5("D1 Coupon".$settings['siteurl'])) {
		redirect(INFUSIONS."D1_time_panel/D1_time_panel_register.php".$aidlink);
	}
}

function d1couponsec2() {
	global $settings, $aidlink;
	if (d1couponSet("inf_name") == "" || d1couponSet("inf_name") != md5("D1 Coupon") || d1couponSet("site_url") == "" || d1couponSet("site_url") != md5("D1 Coupon".$settings['siteurl'])) {
		redirect(BASEDIR."index.php");
	}
}

function d1cp_infusionscore_end() {
		global $settings, $locale;
		$copy = "<div align='right'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1CP_title']." v".$locale['D1CP_vers']." &copy; DeeoNe ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
		return $copy;
}

?>