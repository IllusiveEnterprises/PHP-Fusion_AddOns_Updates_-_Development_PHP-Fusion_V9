<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright ｩ 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: points.php
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

$result = dbquery("SELECT * FROM ".MW_BP_POINTS." ORDER BY points_id");
echo "<br />";
echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:400px;'>";
echo "<tr>
	<td class='tbl1' colspan='8' style='font-weight:bold;font-size:bigger;text-align:left;'>".$locale['mwbp_a040'].$mwbp_set['points_name']."</td>
	</tr><tr>
	<td class='tbl2' width='2%' style='font-weight:bold;'>".$locale['mwbp_a041']."</td>
	<td class='tbl2' width='39%' style='font-weight:bold;'>".$mwbp_set['points_name']."</td>
	<td class='tbl2' width='39%' style='font-weight:bold;'>".$locale['mwbp_a042']."</td>
	<td class='tbl2' width='20%' style='font-weight:bold;'>".$locale['mwbp_a043']."</td>
	</tr>
	";

if (dbrows($result) != 0) {
	$i = 0;
	while ($points = dbarray($result)) {
	if ($i%2 == 0) $class="tbl1"; else $class="tbl2";
		echo "<tr>";
		echo "<td class='".$class."' style='text-align:center;'>".$points['points_id']."</td>";
		echo "<td class='".$class."'>".$points['points_anz']."</td>";
		echo "<td class='".$class."'>".$points['points_pre'].$locale['mwbp-curs']."</td>";
		echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&section=points&editpoints=true&points_id=".$points['points_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/edit.png' alt='Edit' title='".$locale['mwbp_a044']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a> |
		<a href='".FUSION_SELF.$aidlink."&section=points&deletepoints=true&points_id=".$points['points_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/delete.png' alt='delete' title='".$locale['mwbp_a045']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a></td>";
		echo "</tr>";
	$i++;
	}
} else {
echo "<tr><td class='tbl1' colspan='8'>".$locale['mwbp_a046'].$mwbp_set['points_name'].$locale['mwbp_a046a']."</td></tr>";
}
echo "<tr><td class='tbl2' colspan='8' style='font-weight:bold;font-size:bigger;text-align:left;'><a href='".FUSION_SELF.$aidlink."&section=points&newpoints=true'>".$locale['mwbp_a046'].$mwbp_set['points_name'].$locale['mwbp_a046a']."</a></td></tr>";
echo "</table>";

if (isset($_GET['newpoints'])) {
	if (isset($_POST['points_saved'])) {
		if($_POST['points_anz'] != "") {
		$points_anz = stripinput($_POST['points_anz']);
		$points_pre_alt = stripinput($_POST['points_pre']);
		$points_pre_mit = strtr($points_pre_alt, ',', '.');		
		$points_pre_neu	= number_format($points_pre_mit, 2, '.', '');

		$result = dbquery("
		INSERT INTO ".MW_BP_POINTS." SET
		points_anz='".$points_anz."',
		points_pre='".$points_pre_neu."'
		");
		redirect(FUSION_SELF.$aidlink."&section=points");
		}
	} else {
	echo "<br /><form name='newpointsform' method='post' action='".FUSION_SELF.$aidlink."&section=points&newpoints=true' onreset=\"location.href='".FUSION_SELF.$aidlink."&section=points'\">
		<table cellpadding='0' cellspacing='1' class='tbl-border center' style='width:50%;'>
		<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;font-size:bigger;text-align:left;'>".$locale['mwbp_a046'].$mwbp_set['points_name'].$locale['mwbp_a046a'].":</td>
		</tr>
		<tr>
		<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='points_anz'>".$locale['mwbp_a047'].$mwbp_set['points_name'].":</label></td>
		<td class='tbl1' style='vertical-align:top;'><input type='text' class='textbox' name='points_anz' style='width:300px;border:1px solid #c0c0c0;' /></td>
		</tr><tr>
		<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='points_pre'>".$locale['mwbp_a048'].$mwbp_set['points_name'].":</label></td>
		<td class='tbl1' style='vertical-align:top;'><input type='text' class='textbox' name='points_pre' style='width:300px;border:1px solid #c0c0c0;' /></td>
		</tr>
		<tr>
		<td class='tbl2' style='vertical-align:top;text-align:center;' colspan='2'><input type='submit' name='points_saved' value='".$locale['mwbp_save']."' class='button' />&nbsp;<input type='reset' value='".$locale['mwbp_a049']."' class='button' /></td>
		</tr>
		</table>
		</form>";
	}
}

if (isset($_GET['editpoints'])) {
	$pdata_id = stripinput($_GET['points_id']);
	$pdata = dbarray(dbquery("SELECT * FROM ".MW_BP_POINTS." WHERE points_id='".$pdata_id."'"));

	if (isset($_POST['edit_points_saved'])) {
		$pdata_anz = stripinput($_POST['points_anz']);		
		$pdata_pre_alt = stripinput($_POST['points_pre']);
		$pdata_pre_mit = strtr($pdata_pre_alt, ',', '.');		
		$pdata_pre_neu	= number_format($pdata_pre_mit, 2, '.', '');


		$result = dbquery("
		UPDATE ".MW_BP_POINTS." SET
		points_anz='".$pdata_anz."',
		points_pre='".$pdata_pre_neu."'
		WHERE points_id='".$pdata_id."'
		");
		redirect(FUSION_SELF.$aidlink."&section=points");
		
	} else {
	echo "<br /><form name='editpointsform' method='post' action='".FUSION_SELF.$aidlink."&section=points&editpoints=true&points_id=".$pdata_id."' onreset=\"location.href='".FUSION_SELF.$aidlink."&section=points'\">
		<table cellpadding='0' cellspacing='1' class='tbl-border center' style='width:50%;'>
		<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;font-size:bigger;text-align:left;'>".$locale['mwbp_a050'].":</td>
		</tr>
		<tr>
		<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='points_anz'>".$locale['mwbp_a047'].$mwbp_set['points_name'].":</label></td>
		<td class='tbl1' style='vertical-align:top;'><input type='text' class='textbox' name='points_anz' value='".$pdata['points_anz']."' width:300px;border:1px solid #c0c0c0;' /></td>
		</tr>
		<tr>
		<td class='tbl2' style='vertical-align:top;text-align:right;'><label for='points_pre'>".$locale['mwbp_a048'].$mwbp_set['points_name'].":</label></td>
		<td class='tbl1' style='vertical-align:top;'><input type='text' class='textbox' name='points_pre' value='".$pdata['points_pre']."' width:300px;border:1px solid #c0c0c0;' /></td>
		</tr>
		<tr>
		<td class='tbl2' style='vertical-align:top;text-align:center;' colspan='2'><input type='submit' name='edit_points_saved' value='".$locale['mwbp_save']."' class='button' />&nbsp;<input type='reset' value='".$locale['mwbp_a049']."' class='button' /></td>
		</tr>
		</table>
		</form>";
	}
}

if (isset($_GET['deletepoints'])){
	$points_id = stripinput($_GET['points_id']);
	$result = dbquery("DELETE FROM ".MW_BP_POINTS." WHERE points_id='".$points_id."'");
	redirect(FUSION_SELF.$aidlink."&section=points");
}
?>