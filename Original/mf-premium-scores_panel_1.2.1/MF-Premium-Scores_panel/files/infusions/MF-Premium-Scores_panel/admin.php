<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: new_infusion_admin.php
| CVS Version: 1.00
| Author: INSERT NAME HERE
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
require_once THEMES."templates/admin_header.php";

include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

if (!checkrights("MFPS") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}

opentable($locale['MFPS_admin1']);

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "premium";
}

$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));


echo "<table align='center' cellpadding='0' cellspacing='0' width='100%' margin-bottom='5px'>";
echo "<tr>

<td width='25%' class='".($section == "premium" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "premium" ? "<strong>".$locale['MFPS_001']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=premium'><strong>".$locale['MFPS_001']."</strong></a>")."</span></td>
<td width='25%' class='".($section == "premiumuser" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "premiumuser" ? "<strong>".$locale['MFPS_002']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=premiumuser'><strong>".$locale['MFPS_002']."</strong></a>")."</span></td>

</tr>
</table><br>";

if(isset($_POST['premium'])) {
	$prem_s_zeit = stripinput($_POST['prem_s_zeit']);
	$prem_m_zeit = stripinput($_POST['prem_m_zeit']);
	$prem_l_zeit = stripinput($_POST['prem_l_zeit']);
	$prem_s_preis = stripinput($_POST['prem_s_preis']);
	$prem_m_preis = stripinput($_POST['prem_m_preis']);
	$prem_l_preis = stripinput($_POST['prem_l_preis']);
	$prem_gruppe = stripinput($_POST['prem_gruppe']);
	$prem_vorteil = stripinput($_POST['prem_vorteil']);
	$prem_grafik = stripinput($_POST['prem_grafik']);
	$result = dbquery("UPDATE ".DB_mfp_scores_conf." SET
		prem_s_zeit='".$prem_s_zeit."',
		prem_m_zeit='".$prem_m_zeit."',
		prem_l_zeit='".$prem_l_zeit."',
		prem_s_preis='".$prem_s_preis."',
		prem_m_preis='".$prem_m_preis."',
		prem_l_preis='".$prem_l_preis."',
		prem_gruppe='".$prem_gruppe."',
		prem_vorteil='".$prem_vorteil."',
		prem_grafik='".$prem_grafik."'
		WHERE conf='1'");
		redirect(FUSION_SELF.$aidlink."&section=premium&success1=true");

} else {
	if (isset($_GET['success1'])) {
		echo "<div class='success1' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFPS_admin_scc1']."<br /></div>";
	}
} 

if(isset($_POST['premium_saved'])) {
	$user_id = stripinput($_POST['user_id']);
	$tage = stripinput($_POST['tage']);
	$tagewert = stripinput($_POST['tagewert']);
	//$artikel_nr = strrev(time() - rand(0, 10000000));
	$usersettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$user_id.""));

	include("./msg.php");
	mysql_query("INSERT INTO ".DB_MESSAGES." (`message_id`, `message_to`, `message_from`, `message_subject`, `message_message`, `message_smileys`, `message_read`, `message_datestamp`, `message_folder`) VALUES (NULL, '".$user_id."', '1', '".$gif_user."', '".$nachricht_10."', 'y', '0', '".time()."', '0');");


if ($usersettings['status'] =='aktiv') {
	$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$user_id."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $tage)."'
		ON DUPLICATE KEY UPDATE
		user_id='".$user_id."',
		status='aktiv',
		bis=bis$tagewert$tage");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumsuccess=true");
} elseif ($usersettings['status'] =='offen') {
	$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$user_id."',
		status='offen',
		seit='".time()."',
		bis='".(time() + $tage)."'
		ON DUPLICATE KEY UPDATE
		user_id='".$user_id."',
		bis=bis$tagewert$tage");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumsuccess=true");
} elseif ($usersettings['status'] =='inaktiv') {
	$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$user_id."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $tage)."'
		ON DUPLICATE KEY UPDATE
		user_id='".$user_id."',
		seit='".time()."',
		status='aktiv',
		bis='".(time() + $tage)."'");
$group = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id.""));
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $group['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumsuccess=true");
} elseif ($usersettings['status'] =='') {
	$result = dbquery("INSERT INTO ".DB_mfp_scores." SET
		user_id='".$user_id."',
		status='aktiv',
		seit='".time()."',
		bis='".(time() + $tage)."'
		ON DUPLICATE KEY UPDATE
		user_id='".$user_id."',
		seit='".time()."',
		bis=bis$tagewert$tage");
$group = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id.""));
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $group['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumsuccess=true");
}		
		


} elseif(isset($_GET['premium_aktiv'])) {
	$user_id = stripinput($_GET['premium_aktiv']);
	$result = dbquery("UPDATE ".DB_mfp_scores." SET status='aktiv' WHERE user_id='".$user_id."'");
	$group = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id.""));
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $group['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");

		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumaktivsuccess=true");
} elseif(isset($_GET['premium_offen'])) {
	$user_id = stripinput($_GET['premium_offen']);
	$result = dbquery("UPDATE ".DB_mfp_scores." SET status='offen' WHERE user_id='".$user_id."'");
	$group = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id.""));
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $group['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumoffensuccess=true");
} elseif(isset($_GET['premium_wait'])) {
	$user_id = stripinput($_GET['premium_wait']);
	$result = dbquery("UPDATE ".DB_mfp_scores." SET status='inaktiv' WHERE user_id='".$user_id."'");
	$result = dbquery("UPDATE ".DB_mfp_scores." SET bis='".time()."' WHERE user_id='".$user_id."'");
	$group = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id.""));
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $group['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumwaitsuccess=true");
} elseif(isset($_GET['premium_delete'])) {
	$user_id = stripinput($_GET['premium_delete']);
	$result = dbquery("DELETE FROM ".DB_mfp_scores." WHERE user_id='".$user_id."'");
	$group = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$user_id.""));
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $group['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($user_id).";");
		redirect(FUSION_SELF.$aidlink."&section=premiumuser&premiumdeletesuccess=true");
} else {
	if (isset($_GET['success'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc1']."<br /></div>";
	}
	if (isset($_GET['premiumsuccess'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc2']."<br /></div>";
	}
	if (isset($_GET['premiumdelsuccess'])) {
		echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc3']."<br /></div>";
	}
	if (isset($_GET['premiumaktivsuccess'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc4']."<br /></div>";
	}
	if (isset($_GET['premiumoffensuccess'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc5']."<br /></div>";
	}
	if (isset($_GET['premiumwaitsuccess'])) {
		echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc6']."<br /></div>";
	}
	if (isset($_GET['premiumdeletesuccess'])) {
		echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'><br />".$locale['MFR_admin_scc7']."<br /></div>";
	}
}

switch ($section) {
case "premium" :
echo "<form name='premium' method='post' action='".FUSION_SELF.$aidlink."&section=premium'>";
echo "<table width='60%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";

echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:left;'>".$locale['MFPS_001']."</td>
	</tr>";

echo "
	<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['MFPS_admin_001']." </td>
				
<td class='tbl1' style='text-align:left;'>
		<select name='prem_gruppe' id='prem_gruppe' class='textbox'>
		<option value='0'>Bitte ausw&auml;hlen</option>";
		$result = dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS."");
			while ($gdata = dbarray($result))
				{
					echo "<option value='".$gdata['group_id']."' ".($mfpssettings['prem_gruppe']==$gdata['group_id'] ? "selected" : "").">".$gdata['group_name']."</option>";
				}
			echo "
		</select>
	</td>
			</tr>";
echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:left;'>".$locale['MFPS_admin_002']."</td>
	</tr>";	
	echo "
	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_003']."</td>
		<td class='tbl1' style='text-align:left;'>
		<select name='prem_s_zeit' id='prem_s_zeit' class='textbox'>
		<option value='86400'".($mfpssettings['prem_s_zeit'] == 86400 ? " selected" : "").">1 Tag</option>
		<option value='172800'".($mfpssettings['prem_s_zeit'] == 172800 ? " selected" : "").">2 Tage</option>
		<option value='259200'".($mfpssettings['prem_s_zeit'] == 259200 ? " selected" : "").">3 Tage</option>
		<option value='345600'".($mfpssettings['prem_s_zeit'] == 345600 ? " selected" : "").">4 Tage</option>
		<option value='432000'".($mfpssettings['prem_s_zeit'] == 432000 ? " selected" : "").">5 Tage</option>
		<option value='518400'".($mfpssettings['prem_s_zeit'] == 518400 ? " selected" : "").">6 Tage</option>
		<option value='604800'".($mfpssettings['prem_s_zeit'] == 604800 ? " selected" : "").">7 Tage</option>
		</select>
	</td>
	</tr>";
	echo "
	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_004']."</td>
    <td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$mfpssettings['prem_s_preis']."' name='prem_s_preis' />
	</td>
	</tr>";
		echo "
	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_005']."</td>
		<td class='tbl1' style='text-align:left;'>
		<select name='prem_m_zeit' id='prem_m_zeit' class='textbox'>
		<option value='604800'".($mfpssettings['prem_m_zeit'] == 604800 ? " selected" : "").">7 Tage</option>
		<option value='1209600'".($mfpssettings['prem_m_zeit'] == 1209600 ? " selected" : "").">14 Tage</option>
		<option value='1814400'".($mfpssettings['prem_m_zeit'] == 1814400 ? " selected" : "").">21 Tage</option>
		<option value='2592000'".($mfpssettings['prem_m_zeit'] == 2592000 ? " selected" : "").">30 Tage</option>
		</select>
	</td>
	</tr>";
	echo "
	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_006']."</td>
    <td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$mfpssettings['prem_m_preis']."' name='prem_m_preis' />
	</td>
	</tr>";
			echo "
	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_007']."</td>
		<td class='tbl1' style='text-align:left;'>
		<select name='prem_l_zeit' id='prem_l_zeit' class='textbox'>
		<option value='2592000'".($mfpssettings['prem_l_zeit'] == 2592000 ? " selected" : "").">30 Tage</option>
		<option value='5184000'".($mfpssettings['prem_l_zeit'] == 5184000 ? " selected" : "").">60 Tage</option>
		<option value='7776000'".($mfpssettings['prem_l_zeit'] == 7776000 ? " selected" : "").">90 Tage</option>
		<option value='10368000'".($mfpssettings['prem_l_zeit'] == 10368000 ? " selected" : "").">120 Tage</option>		
		</select>
	</td>
	</tr>";
	echo "
	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_008']."</td>
    <td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$mfpssettings['prem_l_preis']."' name='prem_l_preis' />
	</td>
	</tr>";
echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:left;'>".$locale['MFPS_admin_011']."</td>
	</tr>";

echo "
			
			<tr>
			<td class='tbl1' style='text-align:right;' width='40%'>".$locale['MFPS_admin_012']." </td>
			<td class='tbl1' style='text-align:left;'>
				<select name='prem_grafik' class='textbox' style='width:100px;'>
					<option value='0'".($mfpssettings['prem_grafik'] == 0 ? " selected" : "").">".$locale['MFPS_admin_014']."</option>
					<option value='1'".($mfpssettings['prem_grafik'] == 1 ? " selected" : "").">".$locale['MFPS_admin_013']."</option>
				</select>
			</td>
			</tr>";

echo "
			<tr>
				<td class='tbl1' width='30%' valign='top' style='text-align:right;'>".$locale['MFPS_admin_010']." </td>
				<td class='tbl1' style='text-align:left;'><textarea name='prem_vorteil' cols='95' rows='15' class='textbox' style='width:98%'>".stripslashes($mfpssettings['prem_vorteil'])."</textarea></td>
			</tr>";


echo "
	<tr>
		<td class='tbl2' style='text-align:center;' colspan='2'>
		<input type='submit' name='premium' value='".$locale['MFPS_scc1']."' class='button' />
	</td>
	</tr>
	</table>
	</form>";

}

switch ($section) {
case "premiumuser" :
echo "<form name='premium_saved' method='post' action='".FUSION_SELF.$aidlink."&section=premiumsuccess'>";
echo "<table width='60%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:left;'>".$locale['MFPS_002']."</td>
	</tr>
		<tr>
			<td class='tbl1' width='40%' style='text-align:right;'>".$locale['MFP_admin_011'].":</td>
			<td class='tbl1' style='text-align:left;'>";
			$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." ORDER BY user_id ASC");
			$userlist = "";
			while ($data = dbarray($result)) {
			$userlist .= "<option value='".$data['user_id']."'>".$data['user_name']."</option>\n";
			
$usersettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$data['user_id'].""));	
}		
echo "

					<select name='user_id' id='user_id' class='textbox'>".$userlist."</select>
			</td>
			</tr>		

	<tr>
		<td class='tbl1' style='text-align:right;' width='40%'>Premiumtage:</td>
		<td class='tbl1' style='text-align:left;'>
		<select name='tagewert' id='tagewert' class='textbox'>
		<option value='+'>Plus</option>
		<option value='-'>Minus</option>
		</select>
		<select name='tage' id='tage' class='textbox'>
		<option value='0'".($usersettings['bis'] == 0 ? " selected" : "").">---</option>
		<option value='".(3600*24)."'".($usersettings['bis'] == 86400 ? " selected" : "").">24 Stunden</option>
		<option value='".(86400*3)."'".($usersettings['bis'] == 259200 ? " selected" : "").">3 Tage</option>
		<option value='".(86400*5)."'".($usersettings['bis'] == 432000 ? " selected" : "").">5 Tage</option>
		<option value='".(86400*7)."'".($usersettings['bis'] == 604800 ? " selected" : "").">7 Tage</option>
		<option value='".(604800*2)."'".($usersettings['bis'] == 1209600 ? " selected" : "").">2 Wochen (14T)</option>
		<option value='".(604800*3)."'".($usersettings['bis'] == 1814400 ? " selected" : "").">3 Wochen (21T)</option>
		<option value='".(604800*4)."'".($usersettings['bis'] == 2419200 ? " selected" : "").">4 Wochen (28T)</option>
		<option value='".(2419200*3)."'".($usersettings['bis'] == 7257600 ? " selected" : "").">3 Monate (84T)</option>
		<option value='".(2419200*6)."'".($usersettings['bis'] == 14515200 ? " selected" : "").">6 Monate (168T)</option>
		<option value='".(2419200*12)."'".($usersettings['bis'] == 29030400 ? " selected" : "").">12 Monate (336T)</option>
		</select>
	</td>
	</tr>";
	
	echo "
		<tr>
			<td class='tbl2' style='text-align:center;' colspan='2'>
				<input type='submit' name='premium_saved' value='".$locale['MFR_scc1']."' class='button' />
			</td>
		</tr>
	</table>
	</form>";



echo "<br />";
echo "<table width='100%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>
	<tr>
		<td class='tbl2' colspan='9' style='font-weight:bold;text-align:left;'>".$locale['MFP_admin_012']."</td>
	</tr>";
	echo "<tr>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_013']."</td>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_014']."</td>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_015']."</td>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_016']."</td>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_020']."</td>";
		//echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_021']."</td>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_022']."</td>";
		echo "<td class='tbl1' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_024']."</td>";
	echo "</tr>";

$result = dbquery("
SELECT tbl.*, tu.* FROM ".DB_mfp_scores." as tbl 
INNER JOIN ".DB_USERS." as tu 
ON (tbl.user_id = tu.user_id )
ORDER BY bis DESC");
if (dbrows($result)) {
	$i = 0;
	while ($data = dbarray($result)){
		$class = (($i % 2) ? 'tbl1' : 'tbl2');
	if ($data['status']=="offen") {
	$font_color = "orange";
	} elseif ($data['status']=="inaktiv") {
	$font_color = "red";
	} elseif ($data['status']=="aktiv") {
	$font_color = "green";
	}
	
			echo "<tr>";
				echo "<td class='".$class."' style='text-align:center;'><font color=".$font_color.">".$data['user_name']."</font></td>";
				echo "<td class='".$class."' style='text-align:center;'><font color=".$font_color.">".$data['status']."</font></td>";
				echo "<td class='".$class."' style='text-align:center;'><b><font color=".$font_color.">".showdate("%d.%m.%Y %H:%M:%S", $data['seit'])."</b></font></td>";
				echo "<td class='".$class."' style='text-align:center;'><b><font color=".$font_color.">".showdate("%d.%m.%Y %H:%M:%S", $data['bis'])."</b></font></td>";
				echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=mfpsettings&premium_aktiv=".$data['user_id']."'><img src='images/active.png' style='border:0;'/></a></td>";
				//echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=mfpsettings&premium_offen=".$data['user_id']."'><img src='images/offen.gif' style='border:0;'/></a></td>";
				echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=mfpsettings&premium_wait=".$data['user_id']."'><img src='images/deactive.png' style='border:0;'/></a></td>";
				echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=mfpsettings&premium_delete=".$data['user_id']."'><img src='images/delete.png' style='border:0;' /></a></td>";
			echo "</tr>";
		$i++;
	}
} else {
	echo "<tr><td class='tbl2' colspan='9' style='font-weight:bold;text-align:center;'>".$locale['MFP_admin_019']."</td></tr>";
}
	echo "
	</table>";
}

echo "<br><center><a href=".INFUSIONS."MF-Premium-Scores_panel/premium_admin_liste.php>".$locale['MFPS_admin_009']."</a></center>";
closetable();


require_once THEMES."templates/footer.php";
?>
<script type="text/javascript">
	$(document).ready(function(){
	$('.success').fadeOut(10000);
	$('.success1').fadeOut(10000);
	});
</script>