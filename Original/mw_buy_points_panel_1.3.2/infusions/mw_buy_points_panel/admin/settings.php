<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright ? 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: settings.php
| Version: 1.2.0
| Author: Matze-W & DeeoNe
| Site: http://www.DeeoNe.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

if (isset($_POST['settings_saved'])) {
	$bankdaten = stripinput($_POST['bankdaten']);
	$points_name = stripinput($_POST['points_name']);
	$points_display = stripinput($_POST['points_display']);
	$bank_erlaubniss = stripinput($_POST['bank_erlaubniss']);
	
	$result = dbquery("
	UPDATE ".MW_BP_SET." SET
	bankdaten='".$bankdaten."',
	points_name='".$points_name."',
	points_display='".$points_display."',
	bank_erlaubniss='".$bank_erlaubniss."'
	WHERE settings_id='1'");
		
	redirect(FUSION_SELF.$aidlink."&section=settings&success=true");
	} else {
		if (isset($_GET['success'])) {
			echo "<div id='close-message'><div class='admin-message'>".$locale['mwbp_a020']."</div></div>\n";
		}
	}
echo "<br />";
echo "<form name='mwbp_form' method='post' action='".FUSION_SELF.$aidlink."&section=settings'>";
echo "<table width='80%' align='center'>\n";
echo "<tr>\n";
echo "<td valign='top'>".$locale['mwbp_a025']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='points_name' value='".$mwbp_set['points_name']."' maxlength='100' class='textbox' style='width:200px;' /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width = '30%' valign='top'>".$locale['mwbp_a026']."<br /><span class='small2'><em></em></span></td><td><select name='bankdaten' id='bankdaten' class='textbox'>
		<option value='0'".($mwbp_set['bankdaten'] == 0 ? " selected" : "").">".$locale['mwbp_a027']."</option>
		<option value='1'".($mwbp_set['bankdaten'] == 1 ? " selected" : "").">".$locale['mwbp_a028']."</option>
		</select></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td width = '30%' valign='top'>".$locale['mwbp_a029']."<br /></td>
		<td><select name='points_display' id='points_display' class='textbox'>
		<option value='0'".($mwbp_set['points_display'] == 0 ? " selected" : "").">".$locale['mwbp_a030']."</option>
		<option value='1'".($mwbp_set['points_display'] == 1 ? " selected" : "").">".$locale['mwbp_a031']."</option>
		<option value='2'".($mwbp_set['points_display'] == 2 ? " selected" : "").">".$locale['mwbp_a032']."</option>
		<option value='3'".($mwbp_set['points_display'] == 3 ? " selected" : "").">".$locale['mwbp_a033']."</option>
		</select></td>\n";
echo "</tr>\n";
/*
echo "<td width = '30%' valign='top'>".$locale['mwbp_a035']."<br /><span class='small2'><em></em></span></td><td><select name='bank_schutz' id='bank_schutz' class='textbox'>
		<option value='0'".($mwbp_set['bank_schutz'] == 0 ? " selected" : "").">".$locale['mwbp_a027']."</option>
		<option value='1'".($mwbp_set['bank_schutz'] == 1 ? " selected" : "").">".$locale['mwbp_a028']."</option>
		</select></td>\n";
echo "</tr>\n";
*/
echo "<tr>\n";
echo "<td width = '30%' valign='top'>".$locale['mwbp_a036']."<br /></td>
		<td><select name='bank_erlaubniss' id='bank_erlaubniss' class='textbox'>
		<option value='0'>".$locale['mwbp_a034']."</option>";
		$result = dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS."");
			while ($bpgdata = dbarray($result))
				{
					echo "<option value='".$bpgdata['group_id']."' ".($mwbp_set['bank_erlaubniss']==$bpgdata['group_id'] ? "selected" : "").">".$bpgdata['group_name']."</option>";
				}
		echo"</select></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan='2' align='center'><input type='submit' class='button' name='settings_saved' value='".$locale['mwbp_save']."' />";
echo "</td></tr>\n";
echo "</table>\n";
echo "</form>\n";
?>