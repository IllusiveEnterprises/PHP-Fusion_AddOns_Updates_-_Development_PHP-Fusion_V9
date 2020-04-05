<?php
/*----------------------------------------------------+
| D1 Pinnwand                           	
|-----------------------------------------------------|
| Author: DeeoNe
| Web: http://www.DeeoNe.de          	
| Email: deeone@online.de                  	
|-----------------------------------------------------|
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+----------------------------------------------------*/
if (!defined("IN_FUSION")) { header("Location: ".BASEDIR."index.php"); }
require_once INFUSIONS."D1_pinnwand_panel/includes/functions.php";
include INFUSIONS."D1_pinnwand_panel/infusion_db.php";

if (!checkrights("D1PW") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }


if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_admin_panel.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_admin_panel.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/pinnwand_admin_panel.php";
}

if (d1pinnwandSet("inf_name") == "" || d1pinnwandSet("inf_name") != md5("D1 Pinnwand") || d1pinnwandSet("site_url") == "" || d1pinnwandSet("site_url") != md5("D1 Pinnwand".$settings['siteurl'])) {
		redirect(INFUSIONS."D1_pinnwand_panel/D1_pinnwand_register.php".$aidlink);
    }

if (isset($_POST['save'])) {
	$pinnwand_limit = stripinput($_POST['pinnwand_limit']);
	$pinnwand_access = stripinput($_POST['pinnwand_access']);
	$pinnwand_scoresh = stripinput($_POST['pinnwand_scoresh']);
	$pinnwand_scores = stripinput($_POST['pinnwand_scores']);
	$pinnwand_pn = stripinput($_POST['pinnwand_pn']);
	$pinnwand_userlimit = stripinput($_POST['pinnwand_userlimit']);
	$result = dbquery("UPDATE ".$db_prefix."d1_pinnwand_system_settings SET	pinnwand_limit='$pinnwand_limit', pinnwand_access='$pinnwand_access', pinnwand_userlimit='$pinnwand_userlimit', pinnwand_scoresh='$pinnwand_scoresh', pinnwand_scores='$pinnwand_scores', pinnwand_pn='$pinnwand_pn'");
	if ($result) header("Location: ".FUSION_SELF."?aid=$aid");
}

$grouplist = "";
$r = dbquery("SELECT * FROM ".DB_USER_GROUPS." ORDER BY group_name ASC");
if (dbrows($r)) {
	$grouplist = "<optgroup label='".$locale['TIBLAP014']."'>";
	while ($d = dbarray($r)) {
		$grouplist .= "<option disabled value='".$d['group_id']."' ".($d1_pinnwand_settings['pinnwand_access'] == $d['group_id'] ? "selected='selected'" : "").">".$d['group_name']."</option>";
	}
	$grouplist .= "</optgroup>";
}

opentable($locale['TIBLAP007']);
	echo "<form action='' method='post' name='inputform' onsubmit='return ValidateForm(this);'>
			<table cellpadding='0' cellspacing='0' width='100%'><tr>
			<td width='150'>".$locale['TIBLAP033']."</td>
			<td><input type='text' name='pinnwand_limit' value='".$d1_pinnwand_settings['pinnwand_limit']."' class='textbox' style='width: 30px' /></td>
			</tr><tr>
			<td nowrap='nowrap'>".$locale['TIBLAP034']."</td>
			<td><input type='text' name='pinnwand_userlimit' value='".$d1_pinnwand_settings['pinnwand_userlimit']."' class='textbox' style='width: 30px' /></td>
			</tr><tr>
			<td nowrap='nowrap'>".$locale['TIBLAP012']."</td>
			<td>
				<select name='pinnwand_access' class='textbox'>
					<optgroup label='".$locale['TIBLAP013']."'>
					<option disabled value='0' ".($d1_pinnwand_settings['pinnwand_access'] == 0 ? "selected='selected'" : "").">".$locale['user0']."</option>
					<option disabled value='101' ".($d1_pinnwand_settings['pinnwand_access'] == 101 ? "selected='selected'" : "").">".$locale['user1']."</option> 
					<option disabled value='102' ".($d1_pinnwand_settings['pinnwand_access'] == 102 ? "selected='selected'" : "").">".$locale['user2']."</option>
					<option disabled value='103' ".($d1_pinnwand_settings['pinnwand_access'] == 103 ? "selected='selected'" : "").">".$locale['user3']."</option>
					</optgroup>
					$grouplist
					</select>
			</td>
			</tr><tr>
			<td nowrap='nowrap'>".$locale['TIBLAP030']."</td>
			<td>
				<select name='pinnwand_scores' class='textbox'>
					<option value='0' ".($d1_pinnwand_settings['pinnwand_scores'] == 0 ? "selected='selected'" : "").">".$locale['TIBLAP025']."</option>
					<option value='1' ".($d1_pinnwand_settings['pinnwand_scores'] == 1 ? "selected='selected'" : "").">".$locale['TIBLAP026']."</option>
					</select>
			</td>
			</tr><tr>
			<td nowrap='nowrap'>".$locale['TIBLAP031']."</td>
			<td><input type='text' name='pinnwand_scoresh' value='".$d1_pinnwand_settings['pinnwand_scoresh']."' class='textbox' style='width: 30px' /></td>
			</tr><tr>
			<td nowrap='nowrap'>".$locale['TIBLAP032']."</td>
			<td>
				<select name='pinnwand_pn' class='textbox'>
					<option value='0' ".($d1_pinnwand_settings['pinnwand_pn'] == 0 ? "selected='selected'" : "").">".$locale['TIBLAP025']."</option>
					<option value='1' ".($d1_pinnwand_settings['pinnwand_pn'] == 1 ? "selected='selected'" : "").">".$locale['TIBLAP026']."</option>
					</select>
			</td>
			</tr><tr>

				<td colspan='2'><input type='submit' style='margin-top:5px;' name='save' value='".$locale['TIBLAP009']."' class='button' /></td>
			</tr></table>
		</form>";
closetable();
//Deemod
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) {
	$_GET['rowstart'] = 0;
}

if (isset($_GET['action']) && $_GET['action'] == "deletegruesse") {
	$deletetime = time() - ($_POST['num_days'] * 86400);
	$result = dbquery("DELETE FROM ".DB_PREFIX."d1_pinnwand_system WHERE pinnwand_date < '".$deletetime."'");
	redirect(FUSION_SELF.$aidlink."");
}
opentable("Datenbank reinigen");
		echo "<center><table style='text-align:center'>";
if (dbrows($result)) {
	if ($_GET['rowstart'] == 0) {
		echo "<tr><td class='tbl1' colspan='2'>\n";
		echo "<form name='deleteform' method='post' action='".FUSION_SELF.$aidlink."&amp;action=deletegruesse'>\n";
		echo "L&ouml;sche alle pinnwands, die &auml;lter sind als: <select name='num_days' class='textbox' style='width:50px'>\n";
		echo "<option value='90'>90</option>\n";
		echo "<option value='60'>60</option>\n";
		echo "<option value='30'>30</option>\n";
		echo "<option value='20'>20</option>\n";
		echo "<option value='10'>10</option>\n";
		echo "</select> Tage<br /><br />\n";
		echo "<input type='submit' name='deletegruesse' value='l&ouml;schen' class='button' onclick=\"return confirm('Wirklich l&ouml;schen???');\" />\n";
		echo "</form>\n</td></tr>";
	}

} else {
	echo "<tr><td class='tbl1' style='text-align:center'><span>Keine pinnwands</span></td></tr>\n";
}
echo "</table></center>\n";

//Deemod
closetable();
if (function_exists("d1pinnwandsec")) {
	d1pinnwandsec();
} else {
	redirect(BASEDIR."index.php");
}

?>