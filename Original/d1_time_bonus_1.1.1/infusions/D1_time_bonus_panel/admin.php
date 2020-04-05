<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_time_bonus_panel_admin.php
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
require_once THEMES."templates/admin_header.php";

include INFUSIONS."D1_time_bonus_panel/infusion_db.php";

if (!checkrights("D1TB") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_time_bonus_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_time_bonus_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_time_bonus_panel/locale/German.php";
}

require_once INFUSIONS."D1_time_bonus_panel/includes/functions.php";

if (d1timebonusSet("inf_name") == "" || d1timebonusSet("inf_name") != md5("D1 Time Bonus") || d1timebonusSet("site_url") == "" || d1timebonusSet("site_url") != md5("D1 Time Bonus".$settings['siteurl'])) {
	redirect(INFUSIONS."D1_time_bonus_panel/D1_time_bonus_register.php".$aidlink);
}

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "d1tbsettings";
}

$d1tbsettings = dbarray(dbquery("SELECT * FROM ".DB_d1_tbconf.""));

echo "<table align='center' cellpadding='0' cellspacing='0' width='100%' margin-bottom='5px'>";
echo "<tr>

<td width='50%' class='".($section == "d1tbsettings" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1tbsettings" ? "<strong>".$locale['D1TB_admin_003']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1tbsettings'><strong>Einstellungen</strong></a>")."</span></td>

</tr>
</table><br>";


//////////////////////////////

opentable($locale['D1TB_admin_002']);

switch ($section) {
case "d1tbsettings" :

if(isset($_POST['tbsettings'])) {
	$tb_scores = stripinput($_POST['tb_scores']);
	$tb_scoresname = stripinput($_POST['tb_scoresname']);
	$tb_punkte = stripinput($_POST['tb_punkte']);
	$tb_intervall = stripinput($_POST['tb_intervall']);
	$tb_panelart = stripinput($_POST['tb_panelart']);
	$tb_punkte_list = stripinput($_POST['tb_punkte_list']);
	$tb_zweiter = stripinput($_POST['tb_zweiter']);
	$result = dbquery("UPDATE ".DB_d1_tbconf." SET
		tb_scores='".$tb_scores."',
		tb_scoresname='".$tb_scoresname."',
		tb_punkte='".$tb_punkte."',
		tb_intervall='".$tb_intervall."',
		tb_panelart='".$tb_panelart."',
		tb_punkte_list='".$tb_punkte_list."',
		tb_zweiter='".$tb_zweiter."'
		WHERE conf='1'");
		redirect(FUSION_SELF.$aidlink."&section=d1tbsettings&success=true");
//PANELS
} elseif (isset($_POST['panel_save'])) {
	$panel_side = stripinput($_POST['panel_side']);
	$panel_status = stripinput($_POST['panel_status']);
	$result = dbquery("UPDATE ".DB_PANELS." SET
				panel_side = '".$panel_side."',
				panel_status = '".$panel_status."'
				WHERE panel_filename = 'D1_time_bonus_panel'
				");
				redirect(FUSION_SELF.$aidlink."&section=d1tbsettings&panelsuccess=true");

//PANELE

} else {
	if (isset($_GET['success'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1TB_scc1']."</div>";
	}
//PANELS
	if (isset($_GET['panelsuccess'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1TB_scc2']."</div>";
	}
}
//PANELE

if(isset($_GET["delete_zp"])) {
mysql_query("UPDATE ".DB_d1_tbuser." SET user_punkte2='0'");
echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'>Alle Klickpunkte gel&ouml;scht</div>";
}
if(isset($_GET["delete_kp"])) {
mysql_query("UPDATE ".DB_d1_tbuser." SET user_punkte3='0'");
echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'>Alle Zeitpunkte gel&ouml;scht</div>";
}

//PANELS
/////////////////////////////
//PANELS
	$panel = dbarray(dbquery("SELECT * FROM ".DB_PANELS." WHERE panel_filename='D1_time_bonus_panel'"));
	echo "<br /><form name='panel_settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1tbsettings'>";
	echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='65%'>
		<tr>
			<td class='tbl2' colspan='2' style='font-weight:bold; text-align:center; font-size:bigger;'>".$locale['D1TB_admin_022']."</td>
		</tr>
		<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1TB_admin_023']."</td>
			<td>
				<select name='panel_side' class='textbox' style='width:100px;'>
					<option value='1'".($panel['panel_side'] == 1 ? " selected" : "").">".$locale['D1TB_admin_018']."</option>
					<option value='4'".($panel['panel_side'] == 4 ? " selected" : "").">".$locale['D1TB_admin_019']."</option>
					<option value='2'".($panel['panel_side'] == 2 ? " selected" : "").">".$locale['D1TB_admin_020']."</option>
					<option value='3'".($panel['panel_side'] == 3 ? " selected" : "").">".$locale['D1TB_admin_021']."</option>
				</select>
			</td>
		</tr>";
            echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1TB_admin_026']."</td>
			<td>
				<select name='panel_status' class='textbox' style='width:100px;'>
					<option value='0'".($panel['panel_status'] == 0 ? " selected" : "").">".$locale['D1TB_admin_024']."</option>
					<option value='1'".($panel['panel_status'] == 1 ? " selected" : "").">".$locale['D1TB_admin_025']."</option>
				</select>
			</td>
			</tr>";
	echo "<tr class='tbl2' style='color:#000;font-weight:bold;font-size:bigger;'>
			<td align='center' colspan='2'>
				<input type='submit' class='button' name='panel_save' value='".$locale['D1TB_admin_013']."' />
			</td>
		</tr>";
	echo "</table>
		</form>";
echo "<br />";
//PANELE
/////////////////////////////
echo "<form name='settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1tbsettings'>";
echo "<table width='65%' class='tbl-border' cellpadding='4' cellspacing='0' align='center'>";
echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1TB_admin_002']."</td>
	</tr>";
	
		if (defined("SCORESYSTEM")) {
			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1TB_admin_005']."</td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1tbsettings['tb_scoresname']."' name='tb_scoresname' /></td>
			</tr>";
		} else {
	echo "
	<tr>
		<td class='tbl1' align='center' colspan='2'>".$locale['D1TB_admin_004']."
	</td>
	</tr>";
		}


			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1TB_admin_006']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1tbsettings['tb_scores']."' name='tb_scores' /> ".$d1tbsettings['tb_scoresname']."</td>
			</tr>";

			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1TB_admin_007']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1tbsettings['tb_intervall']."' name='tb_intervall' /> ".$locale['D1TB_admin_017']."</td>
			</tr>";

			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1TB_admin_014']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1tbsettings['tb_punkte']."' name='tb_punkte' /></td>
			</tr>";
            echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1TB_admin_030']."</td>
			<td>
				<select name='tb_panelart' class='textbox' style='width:110px;'>
					<option value='0'".($d1tbsettings['tb_panelart'] == 0 ? " selected" : "").">".$locale['D1TB_admin_031']."</option>
					<option value='1'".($d1tbsettings['tb_panelart'] == 1 ? " selected" : "").">".$locale['D1TB_admin_032']."</option>
				</select>
			</td>
			</tr>";

            echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1TB_admin_033']."</td>
			<td>
				<select name='tb_punkte_list' class='textbox' style='width:160px;'>
					<option value='user_punkte'".($d1tbsettings['tb_punkte_list'] == 'user_punkte' ? " selected" : "").">".$locale['D1TB_admin_034']."</option>
					<option value='user_punkte2'".($d1tbsettings['tb_punkte_list'] == 'user_punkte2' ? " selected" : "").">".$locale['D1TB_admin_035']."</option>
					<option value='user_punkte3'".($d1tbsettings['tb_punkte_list'] == 'user_punkte3' ? " selected" : "").">".$locale['D1TB_admin_036']."</option>
				</select>
			</td>
			</tr>";
 echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1TB_admin_037']."</td>
			<td>
				<select name='tb_zweiter' class='textbox' style='width:100px;'>
					<option value='0'".($d1tbsettings['tb_zweiter'] == 0 ? " selected" : "").">".$locale['D1TB_admin_024']."</option>
					<option value='1'".($d1tbsettings['tb_zweiter'] == 1 ? " selected" : "").">".$locale['D1TB_admin_025']."</option>
				</select>
			</td>
			</tr>";

	echo "
	<tr>
		<td class='tbl2' style='text-align:center;' colspan='2'>
		<input type='submit' name='tbsettings' value='".$locale['D1TB_admin_013']."' class='button' />
	</td>
	</tr>
	</table>
	</form>";

//NEW_S
echo "<br><table width='65%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>Punkte Resetter</td>
	</tr>";	
echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form action="'.FUSION_SELF.$aidlink.'&amp;section=d1tbsettings&delete_zp" method="post">';
echo"<center>".$locale['D1TB_admin_040']." <input type='submit' name='delete_zp'  class='button' value='OK' onclick=\"return confirm('Alle Zeit Punkte wirklich l&ouml;schen ???');\"></center></form>";
			echo "</td>
		</tr>";
	echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form action="'.FUSION_SELF.$aidlink.'&amp;section=d1tbsettings&delete_kp" method="post">';
echo"<center>".$locale['D1TB_admin_041']." <input type='submit' name='delete_kp'  class='button' value='OK' onclick=\"return confirm('Alle Kick Punkte wirklich l&ouml;schen ???');\"></center></form>";
			echo "</td>
		</tr>"; 
	echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1TB_admin_038']."</td>
	</tr>";	
echo "</table>";


//NEW_E

} //CASE Close

echo "<br clear='all' /><div style='text-align: right;'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1TB_title']." ".$locale['D1TB_version']." &copy; 2012 DeeoNe'><span class='small'>&copy; DeeoNe</span></a></div>";
closetable();
if (function_exists("d1timebonussec")) {
	d1timebonussec();
} else {
	redirect(BASEDIR."index.php");
}
require_once THEMES."templates/footer.php";
?>
<script type="text/javascript">
	$(document).ready(function(){
	$('.success').fadeOut(10000);
	$('.error').fadeOut(10000);
	});
</script>