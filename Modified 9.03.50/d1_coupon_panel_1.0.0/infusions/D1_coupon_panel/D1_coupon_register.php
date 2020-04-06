<?php
require_once "../../maincore.php";
require_once THEMES."templates/admin_header.php";
if (!defined("IN_FUSION")) { die("Access Denied"); }
include INFUSIONS."D1_coupon_panel/infusion_db.php";
require_once INFUSIONS."D1_coupon_panel/includes/functions.php";

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

if (!checkrights("D1CP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_coupon_panel/locale/German.php";
}

add_to_head("
<style type='text/css'>
<!--
.missing_field {
	border: 1px solid red !important;
	//background-color : #ee5e5e; !important;
}

.keyfield {
	background-color : #29c45f; !important;
	color: dimgray !important;
	padding:1?4px;
}
-->
</style>
");

if (isset($_POST['save_reg'])) {
	if ($_POST['inf_name'] == "") {
		redirect(FUSION_SELF.$aidlink."&amp;error=missing_field");
	} elseif ($_POST['site_url'] == "") {
		redirect(FUSION_SELF.$aidlink."&amp;error=missing_field");
	}
	$inf_name = stripinput($_POST['inf_name']);
	$site_url = stripinput($_POST['site_url']);
	$result = dbquery("UPDATE ".DB_D1CP_conf." SET
		inf_name ='".$inf_name."',
		site_url = '".$site_url."'
		WHERE conf = '1'");
	redirect(INFUSIONS."D1_coupon_panel/D1_coupon_admin.php".$aidlink);
} else {

$error = (isset($_GET['error']) && $_GET['error'] == "missing_field" ? " missing_field" : "");

opentable($locale['reg01']);

$result5 = dbquery("SHOW TABLES LIKE '".DB_PREFIX."d1_coupon_config'");
if (!dbrows($result5)) {
echo "<div style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>Datenbank Tabellen sind nicht vorhanden !!!</center></td></tr></table></center><br></div>";
}

echo "
<center>
<table width='600px'><tr><td style='font-weight:text-align:center;' width='15%'>
<center><img src=\"".BASEDIR."infusions/D1_coupon_panel/images/reg.png\" border=\"0\" style=\"vertical-align:middle;\"></center>
</td>
<td style='font-weight:text-align:center;' width='70%'>
<center><span style='font-size: large;'><strong>".$locale['reg10']."</strong></span></center>
</td>
<td style='font-weight:text-align:center;' width='12%'>
<center><img src=\"".BASEDIR."infusions/D1_coupon_panel/images/reg2.png\" border=\"0\" style=\"vertical-align:middle;\"></center>
</td>
</tr></table></center>";
echo "<form name='D1-Fbchat_register_form' action='".FUSION_SELF.$aidlink."' method='post' autocomplete='off'>";
echo "<table cellpadding='3' cellspacing='1' width='600px' class='tbl-border center'>
		<tr>
			<td class='tbl2' style='font-weight:bold;font-size:big;text-align:left;' colspan='3'>
				".sprintf($locale['reg02'], $userdata['user_name'])."
			</td>
		</tr>
		<tr>
			<td class='tbl1' style='font-weight:bold;text-align:right;width:10%;white-space:nowrap;'>
				".$locale['reg03']." 1. 
			</td>
			<td class='tbl1' style='font-weight:bold;text-align:left;width:20%;white-space:nowrap;'>
				".$locale['reg04']."
			</td>
			<td class='tbl1' style='text-align:left;'>
				<input type='text' class='textbox' style='width:250px;' value='".$settings['siteurl']."' readonly onMouseOver = \"this.focus()\" onFocus = \"this.select()\" />
			</td>
		</tr>
		<tr>
			<td class='tbl1' style='font-weight:bold;text-align:right;width:10%;white-space:nowrap;'>
				".$locale['reg03']." 2. 
			</td>
			<td class='tbl1' style='font-weight:bold;text-align:left;white-space:nowrap;'>
				".$locale['reg05']."
			</td>
			<td class='tbl1' style='text-align:left;'>
				<a href='http://www.deeone.de/infusions/register_system/MZ_register.php?infid=12&amp;rurl=".$settings['site_host']."' target='_blank'>".$locale['reg06']."</a>
			</td>
		</tr>
		</tr>

				<input type='hidden' class='textbox".$error."' name='inf_name' style='width:250px;' value='".md5("D1 Coupon")."' />

		<tr>
		<tr>
			<td class='tbl1' style='font-weight:bold;text-align:right;width:10%;white-space:nowrap;'>
				".$locale['reg03']." 3. 
			</td>
			<td class='tbl1' style='font-weight:bold;text-align:left;white-space:nowrap;'>
				".$locale['reg08']."
			</td>
			<td class='tbl1 keyfield' style='text-align:left;'>
				<input type='text' class='textbox".$error."' name='site_url' style='width:250px;' />
			</td>
		</tr>
		<tr>
			<td class='tbl1' style='text-align:center;' colspan='3'>
				".$locale['reg11']."
			</td>
		</tr>
		<tr>
			<td class='tbl2' style='text-align:center;' colspan='3'>
				<input type='submit' class='button' name='save_reg' value='".$locale['reg09']."' />
			</td>
		</tr>";
		
	echo "
	</table>
	</form>";

closetable();
}

require_once THEMES."templates/footer.php";
?>