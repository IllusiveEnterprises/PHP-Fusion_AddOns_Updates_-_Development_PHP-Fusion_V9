<?php

include INFUSIONS."D1_job_rewards_panel/infusion_db.php";

function d1jobrewardsSet($field) {
	$data = dbarray(dbquery("SELECT * FROM ".DB_D1JR_conf.""));
	$value = $data[$field];
	return $value;
}

function d1jobrewardssec() {
	global $settings, $aidlink;
	if (d1jobrewardsSet("inf_name") == "" || d1jobrewardsSet("inf_name") != md5("D1 Job Rewards") || d1jobrewardsSet("site_url") == "" || d1jobrewardsSet("site_url") != md5("D1 Job Rewards".$settings['siteurl'])) {
		redirect(INFUSIONS."D1_time_panel/D1_time_panel_register.php".$aidlink);
	}
}

function d1jobrewardssec2() {
	global $settings, $aidlink;
	if (d1jobrewardsSet("inf_name") == "" || d1jobrewardsSet("inf_name") != md5("D1 Job Rewards") || d1jobrewardsSet("site_url") == "" || d1jobrewardsSet("site_url") != md5("D1 Job Rewards".$settings['siteurl'])) {
		redirect(BASEDIR."index.php");
	}
}

function d1jr_infusionscore_end() {
		global $settings, $locale;
		$copy = "<div align='right'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1JR_title']." v".$locale['D1JR_vers']." &copy; DeeoNe ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
		return $copy;
}

function d1jr_infusionscore_end2() {
		global $settings, $locale;
		$copy = "<div align='right'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1JR_title']." v".$locale['D1JR_vers']." &copy; DeeoNe ".showdate("%Y",time())."'><span class='small'>&copy; DeeoNe</span></a></div>";
		return $copy;
}

?>