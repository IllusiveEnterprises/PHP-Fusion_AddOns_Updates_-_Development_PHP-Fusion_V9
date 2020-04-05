<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_dice_to_win_panel_admin.php
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

include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";

if (!checkrights("D1DW") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once INFUSIONS."D1_dice_to_win_panel/includes/functions.php";

if (d1wintodiceSet("inf_name") == "" || d1wintodiceSet("inf_name") != md5("D1 Dice to win") || d1wintodiceSet("site_url") == "" || d1wintodiceSet("site_url") != md5("D1 Dice to win".$settings['siteurl'])) {
	redirect(INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win_register.php".$aidlink);
}

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_dice_to_win_panel/locale/German.php";
}

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "d1dwsettings";
}

$d1dwsettings = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));

echo "<table align='center' cellpadding='0' cellspacing='0' width='100%' margin-bottom='5px'>";
echo "<tr>

<td width='25%' class='".($section == "d1dwsettings" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1dwsettings" ? "<strong>".$locale['D1DW_admin_005']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1dwsettings'><strong>".$locale['D1DW_admin_005']."</strong></a>")."</span></td>
<td width='25%' class='".($section == "d1dwlogs" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1dwlogs" ? "<strong>".$locale['D1DW_admin_006']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1dwlogs'><strong>".$locale['D1DW_admin_006']."</strong></a>")."</span></td>

</tr>
</table><br>";


//////////////////////////////

opentable($locale['D1DW_admin_002']);

switch ($section) {
case "d1dwsettings" :

if(isset($_POST['dwsettings'])) {
	$dwin_scores = stripinput($_POST['dwin_scores']);
	$dwin_kosten = stripinput($_POST['dwin_kosten']);
	$wurf_panel = stripinput($_POST['wurf_panel']);
	$dwin_chance = stripinput($_POST['dwin_chance']);
	$dwin_jstart = stripinput($_POST['dwin_jstart']);
	$dwin_gpreis = stripinput($_POST['dwin_gpreis']);
	$dwin_fpreis = stripinput($_POST['dwin_fpreis']);
	$dwin_wzahl = stripinput($_POST['dwin_wzahl']);
	$dwin_gstatus = stripinput($_POST['dwin_gstatus']);
	$lucky_number = stripinput($_POST['lucky_number']);
	$lucky_win = stripinput($_POST['lucky_win']);
	$chat_stat = stripinput($_POST['chat_stat']);
	$dwin_multi = stripinput($_POST['dwin_multi']);
	$dwin_chatanz = stripinput($_POST['dwin_chatanz']);
	$dwin_wurfanz = stripinput($_POST['dwin_wurfanz']);
	$dwin_reftime = stripinput($_POST['dwin_reftime']);
	$ref_dice = stripinput($_POST['ref_dice']);
	$ref_chat = stripinput($_POST['ref_chat']);
	$result = dbquery("UPDATE ".DB_D1DW_conf." SET
		dwin_scores='".$dwin_scores."',
		dwin_kosten='".$dwin_kosten."',
		wurf_panel='".$wurf_panel."',
		dwin_chance='".$dwin_chance."',
		dwin_jstart='".$dwin_jstart."',
		dwin_gpreis='".$dwin_gpreis."',
		dwin_fpreis='".$dwin_fpreis."',
		dwin_wzahl='".$dwin_wzahl."',
		dwin_gstatus='".$dwin_gstatus."',
		lucky_number='".$lucky_number."',
		lucky_win='".$lucky_win."',
		chat_stat='".$chat_stat."',
		dwin_multi='".$dwin_multi."',
		dwin_chatanz='".$dwin_chatanz."',
		dwin_wurfanz='".$dwin_wurfanz."',
		dwin_reftime='".$dwin_reftime."',
		ref_dice='".$ref_dice."',
		ref_chat='".$ref_chat."'
		WHERE conf='1'");
		redirect(FUSION_SELF.$aidlink."&section=d1dwsettings&success=true");
/////////
} elseif(isset($_POST['dwsettings_jack'])) {
	$jack_pot = stripinput($_POST['jack_pot']);
	$result = dbquery("UPDATE ".DB_D1DW_conf." SET
		jack_pot='".$jack_pot."'
		WHERE conf='1'");
		redirect(FUSION_SELF.$aidlink."&section=d1dwsettings&success_jack=true");

} elseif(isset($_POST['dwupdate'])) {
mysql_query("CREATE TABLE ".DB_D1DW_chat." (
id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
user_id VARCHAR(50) DEFAULT '' NOT NULL,
user_name VARCHAR(200) DEFAULT '' NOT NULL,
timer VARCHAR(200) DEFAULT '' NOT NULL,
time VARCHAR(200) DEFAULT '' NOT NULL,
text VARCHAR(66) DEFAULT '' NOT NULL,
sonstiges VARCHAR(200) DEFAULT '' NOT NULL,
PRIMARY KEY (id)
) ENGINE=MyISAM;");

$result = dbquery("UPDATE ".DB_D1DW_conf." SET datab_stat='1' WHERE conf='1'");
redirect(FUSION_SELF.$aidlink."&section=d1dwsettings&success_update=true");


//PANELS
} elseif (isset($_POST['panel_save'])) {
	$panel_side = stripinput($_POST['panel_side']);
	$panel_status = stripinput($_POST['panel_status']);
	$result = dbquery("UPDATE ".DB_PANELS." SET
				panel_side = '".$panel_side."',
				panel_status = '".$panel_status."'
				WHERE panel_filename = 'D1_dice_to_win_panel'
				");
				redirect(FUSION_SELF.$aidlink."&section=d1dwsettings&panelsuccess=true");

//PANELE

} else {
	if (isset($_GET['success'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1DW_scc1']."</div>";
	}
	if (isset($_GET['success_jack'])) {
		echo "<div class='success' style='color:blue;font-weight:bold;text-align:center;font-size: 16px;'>Neuer Jackpot gesetzt</div>";
	}
	if (isset($_GET['success_update'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'>Datenbank Update erfolgreich</div>";
	}
//PANELS
	if (isset($_GET['panelsuccess'])) {
		echo "<div class='success' style='color:green;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1DW_scc2']."</div>";
	}
}
//PANELE



if ($d1dwsettings['datab_stat'] == "0") {
echo '<center><table style="border-style:solid; border-color:#FF0000; background-color: #550000; border-collapse:collapse" border="1" frame="border" cellpadding="5"><tr><td>';
echo "<center><span style='color: #ffffff;'>Durch das UPDATE von 1.0.0 auf 1.0.1 ist noch ein manuelles Update der Datenbank n&ouml;tig!</span>";
echo "<form name='dwupdate' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1dwsettings' target='_top'><input type='submit' name='dwupdate' value='UPDATEN' class='button' /></form></center>";
echo '</td></tr></table></center>';
}
//PANELS
/////////////////////////////
//PANELS
	$panel = dbarray(dbquery("SELECT * FROM ".DB_PANELS." WHERE panel_filename='D1_dice_to_win_panel'"));
	echo "<br /><form name='panel_settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1dwsettings'>";
	echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='65%'>
		<tr>
			<td class='tbl2' colspan='2' style='font-weight:bold; text-align:center; font-size:bigger;'>".$locale['D1DW_admin_022']."</td>
		</tr>
		<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1DW_admin_023']."</td>
			<td>
				<select name='panel_side' class='textbox' style='width:100px;'>
					<option value='1'".($panel['panel_side'] == 1 ? " selected" : "").">".$locale['D1DW_admin_018']."</option>
					<option value='4'".($panel['panel_side'] == 4 ? " selected" : "").">".$locale['D1DW_admin_019']."</option>
					<option value='2'".($panel['panel_side'] == 2 ? " selected" : "").">".$locale['D1DW_admin_020']."</option>
					<option value='3'".($panel['panel_side'] == 3 ? " selected" : "").">".$locale['D1DW_admin_021']."</option>
				</select>
			</td>
		</tr>";
            echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1DW_admin_026']."</td>
			<td>
				<select name='panel_status' class='textbox' style='width:100px;'>
					<option value='0'".($panel['panel_status'] == 0 ? " selected" : "").">".$locale['D1DW_admin_024']."</option>
					<option value='1'".($panel['panel_status'] == 1 ? " selected" : "").">".$locale['D1DW_admin_025']."</option>
				</select>
			</td>
			</tr>";
	echo "<tr class='tbl2' style='color:#000;font-weight:bold;font-size:bigger;'>
			<td align='center' colspan='2'>
				<input type='submit' class='button' name='panel_save' value='".$locale['D1DW_admin_013']."' />
			</td>
		</tr>";
	echo "</table>
		</form>";
echo "<br />";
//PANELE
/////////////////////////////
echo "<form name='settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1dwsettings'>";
echo "<table width='65%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1DW_admin_002']."</td>
	</tr>";
			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'><b>".$locale['D1DW_admin_027']."</b></td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_gstatus' class='textbox' style='width:100px;'>
					<option value='0'".($d1dwsettings['dwin_gstatus'] == 0 ? " selected" : "").">".$locale['D1DW_admin_024']."</option>
					<option value='1'".($d1dwsettings['dwin_gstatus'] == 1 ? " selected" : "").">".$locale['D1DW_admin_025']."</option>
				</select>
				</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_028']."</td>
				<td class='tbl1' style='text-align:left;'>
				<select name='wurf_panel' class='textbox' style='width:100px;'>
					<option value='0'".($d1dwsettings['wurf_panel'] == 0 ? " selected" : "").">".$locale['D1DW_admin_024']."</option>
					<option value='1'".($d1dwsettings['wurf_panel'] == 1 ? " selected" : "").">".$locale['D1DW_admin_025']."</option>
				</select>
				</td>
			</tr>";
	
		if (defined("SCORESYSTEM")) {
			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_029']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['dwin_scores']."' name='dwin_scores' /></td>
			</tr>";
		} else {
	echo "
	<tr>
		<td class='tbl1' align='center' colspan='2'>".$locale['D1DW_admin_004']."
	</td>
	</tr>";
		}


			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_030']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['dwin_kosten']."' name='dwin_kosten' /> ".$d1dwsettings['dwin_scores']."</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_031']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['dwin_chance']."' name='dwin_chance' /> mal</td>
			</tr>";
			echo "<tr>
				<td class='tbl1' width='40%' colspan='2'><hr></td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_032']."</td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_gpreis' class='textbox' style='width:100px;'>
					<option value='0'".($d1dwsettings['dwin_gpreis'] == 0 ? " selected" : "").">".$locale['D1DW_admin_033']."</option>
					<option value='1'".($d1dwsettings['dwin_gpreis'] == 1 ? " selected" : "").">".$locale['D1DW_admin_034']."</option>
				</select>
				</td>
			</tr>";


			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_035']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['jack_pot']."' name='jack_pot' /> <input type='submit' name='dwsettings_jack' value='setzen' class='button' /> ".$d1dwsettings['dwin_scores']." <b>".$locale['D1DW_admin_056']."</b>
		
			</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_036']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['dwin_jstart']."' name='dwin_jstart' /> ".$d1dwsettings['dwin_scores']." <b>".$locale['D1DW_admin_056']."</b></td>
			</tr>";
			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_055']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_multi' class='textbox'>";
       				 for ($i = 1; $i <= 5; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['dwin_multi'] ? " selected" : "").">".$i."x</option>\n";
				echo "</select> <b>(Jackpot)</b>
				</td>
			</tr>";
			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_037']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['dwin_fpreis']."' name='dwin_fpreis' /> ".$d1dwsettings['dwin_scores']." <b>".$locale['D1DW_admin_057']."</b></td>
			</tr>";
			echo "<tr>
				<td class='tbl1' width='40%' colspan='2'><hr></td>
			</tr>";


			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_038']."</td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_wzahl' class='textbox'>";
       				 for ($i = 1; $i <= 5; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['dwin_wzahl'] ? " selected" : "").">".$i." ".$locale['D1DW_admin_058']."</option>\n";
				echo "</select>
				</td>
			</tr>";

			$gzahl_rech = $d1dwsettings['dwin_wzahl']*6;
			$gzahl_norm = $d1dwsettings['dwin_wzahl'];

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_059']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='lucky_number' class='textbox'>";
				echo "<option value='0'".($d1dwsettings['lucky_number'] == 0 ? " selected" : "").">".$locale['D1DW_admin_060']."</option>";
       				 for ($i = $gzahl_norm; $i <= $gzahl_rech; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['lucky_number'] ? " selected" : "").">".$i."</option>\n";
				echo "</select>
				</td>
			</tr>";

	
			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_061']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1dwsettings['lucky_win']."' name='lucky_win' /> ".$d1dwsettings['dwin_scores']."</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_062']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='chat_stat' class='textbox' style='width:100px;'>
					<option value='0'".($d1dwsettings['chat_stat'] == 0 ? " selected" : "").">".$locale['D1DW_admin_024']."</option>
					<option value='1'".($d1dwsettings['chat_stat'] == 1 ? " selected" : "").">".$locale['D1DW_admin_025']."</option>
				</select>
				</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_063']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_reftime' class='textbox'>";
       				 for ($i = 5; $i <= 10; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['dwin_reftime'] ? " selected" : "").">".$i."</option>\n";
				echo "</select>
				</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' colspan='2'><hr></td>
			</tr>";


			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_065']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_wurfanz' class='textbox'>";
       				 for ($i = 1; $i <= 20; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['dwin_wurfanz'] ? " selected" : "").">".$i."</option>\n";
				echo "</select>
				</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_073']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='ref_dice' class='textbox'>";
       				 for ($i = 1; $i <= 60; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['ref_dice'] ? " selected" : "").">".$i."</option>\n";
				echo "</select> Sekunden
				</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_064']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='dwin_chatanz' class='textbox'>";
       				 for ($i = 1; $i <= 20; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['dwin_chatanz'] ? " selected" : "").">".$i."</option>\n";
				echo "</select>
				</td>
			</tr>";

			echo "<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1DW_admin_074']." </td>
				<td class='tbl1' style='text-align:left;'>
				<select name='ref_chat' class='textbox'>";
       				 for ($i = 1; $i <= 60; $i++) echo "<option value='".$i."'".($i == $d1dwsettings['ref_chat'] ? " selected" : "").">".$i."</option>\n";
				echo "</select> Sekunden
				</td>
			</tr>";

	echo "
	<tr>
		<td class='tbl2' style='text-align:center;' colspan='2'>
		<input type='submit' name='dwsettings' value='".$locale['D1DW_admin_013']."' class='button' />
	</td>
	</tr>
	</table>
	</form>";


} //CASE Close

switch ($section) {
case "d1dwlogs" :

//////////////////////
if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) {
	$_GET['rowstart'] = 0;
}

if(isset($_GET["delete_alogs"])) {
$result1 = dbquery("TRUNCATE TABLE ".DB_D1DW_log."");
echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1DW_admin_044']."</div>";
}
if(isset($_GET["delete_tlogs"])) {
$ttime = time();
$result2 = dbquery("DELETE FROM ".DB_D1DW_log." WHERE time < $ttime");
echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1DW_admin_045']."</div>";
}
/////
if(isset($_GET["delete_achat"])) {
$result1 = dbquery("TRUNCATE TABLE ".DB_D1DW_chat."");
echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1DW_admin_044']."</div>";
}
if(isset($_GET["delete_tchat"])) {
$ttime = time();
$result2 = dbquery("DELETE FROM ".DB_D1DW_chat." WHERE timer < $ttime");
echo "<div class='success' style='color:red;font-weight:bold;text-align:center;font-size: 16px;'>".$locale['D1DW_admin_045']."</div>";
}
/////////////////////

echo "<table width='65%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1DW_admin_046']."</td>
	</tr>";	

echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo "<b><center><u>".$locale['D1DW_admin_047']."</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_log." ORDER BY sonstiges DESC LIMIT 0,30");
$sechser_multi = $d1dwsettings['dwin_wzahl']*6;
$lucky_number = $d1dwsettings['lucky_number'];
if (dbrows($result4)) {
	while($dice_to_win = dbarray($result4)) {

	if ($dice_to_win['zahl'] == $sechser_multi) {
	$font_dcolor = "#808000";
	} elseif ($dice_to_win['zahl'] == $lucky_number) {
	$font_dcolor = "#008000";
	} else {
	$font_dcolor = "";
	}

	echo "<center>".date("d.m.Y H:i:s",$dice_to_win['sonstiges'])." - <span style='color: ".$font_dcolor.";'><b>".$dice_to_win['user_name']."</b> ".$locale['D1DW_admin_048']." <b>".$dice_to_win['zahl']."</b> ".$dice_to_win['text']."</span></center>";
}
} else {
	echo "<center>".$locale['D1DW_admin_049']."</center>";
}
echo "<b><center><span class='small'>".$locale['D1DW_admin_050']." ".date("d.m.Y H:i:s",time())."</span></center></b>";

			echo "</td>
		</tr></table>";

echo "<table width='65%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>Logs Verwaltung</td>
	</tr>";	
echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form action="'.FUSION_SELF.$aidlink.'&amp;section=d1dwlogs&delete_tlogs" method="post">';
echo"<center>".$locale['D1DW_admin_051']." <input type='submit' name='delete_tlogs'  class='button' value='OK' onclick=\"return confirm('Alle alten Logs wirklich l&ouml;schen ???');\"> ".$locale['D1DW_admin_052']."</center></form>";
			echo "</td>
		</tr>";
	echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form action="'.FUSION_SELF.$aidlink.'&amp;section=d1dwlogs&delete_alogs" method="post">';
echo"<center>".$locale['D1DW_admin_053']." <input type='submit' name='delete_alogs'  class='button' value='OK' onclick=\"return confirm('Alle Logs wirklich l&ouml;schen ???');\"> ".$locale['D1DW_admin_054']."</center></form>";
			echo "</td>
		</tr>"; 
echo "</table>";
//
echo "<br>";
echo "<table width='65%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1DW_admin_072']."</td>
	</tr>";	

echo"<tr>
			<td class='tbl1' colspan='2'>";
echo "<b><center><u>".$locale['D1DW_admin_067']."</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_chat." ORDER BY time DESC LIMIT 0,15");
if (dbrows($result4)) {
	while($dice_chatss = dbarray($result4)) {

	if ($dice_chatss['user_id'] == $userdata['user_id']) {
	$font_dcolor = "#0080c0";
	} else {
	$font_dcolor = "";
	}

	echo "[".date("d.m.Y H:i:s",$dice_chatss['time'])."] <span style='color: ".$font_dcolor.";'><b>".$dice_chatss['user_name']."</b>: ".$dice_chatss['text']."</span><br>";
}
} else {
	echo "<center>".$locale['D1DW_admin_066']."</center>";
}
echo "<center><b><span class='small'>".$locale['D1DW_seite_025']." ".date("d.m.Y H:i:s",time())."</span></center></b>";

			echo "</td>
		</tr></table>";

echo "<table width='65%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
	echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>Logs Verwaltung</td>
	</tr>";	
echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form action="'.FUSION_SELF.$aidlink.'&amp;section=d1dwlogs&delete_tchat" method="post">';
echo"<center>".$locale['D1DW_admin_068']." <input type='submit' name='delete_tchat'  class='button' value='OK' onclick=\"return confirm('Alle alten Nachrichten wirklich l&ouml;schen ???');\"> ".$locale['D1DW_admin_069']."</center></form>";
			echo "</td>
		</tr>";
	echo"<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form action="'.FUSION_SELF.$aidlink.'&amp;section=d1dwlogs&delete_achat" method="post">';
echo"<center>".$locale['D1DW_admin_070']." <input type='submit' name='delete_achat'  class='button' value='OK' onclick=\"return confirm('Alle Nachrichten wirklich l&ouml;schen ???');\"> ".$locale['D1DW_admin_071']."</center></form>";
			echo "</td>
		</tr>"; 
echo "</table>";

}

echo "<br clear='all' /><div style='text-align: right;'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1DW_title']." v".$locale['D1DW_vers']." &copy; DeeoNe ".showdate("%Y",time())."'><span class='small'>&copy; DeeoNe</span></a></div>";
closetable();
if (function_exists("d1dicetowinsec")) {
	d1dicetowinsec();
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