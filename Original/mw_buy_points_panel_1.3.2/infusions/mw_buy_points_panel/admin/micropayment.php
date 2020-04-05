<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright ｩ 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: micropayment.php
| Version: 1.2.1
| Author: Matze-W
| Site: http://matze-web.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

if (isset($_POST['microaddon'])) {
	$micropayment = stripinput($_POST['micropayment_onoff']);
	$call2pay = stripinput($_POST['call2pay_onoff']);
	$ebank2pay = stripinput($_POST['ebank2pay_onoff']);
	$handy2pay = stripinput($_POST['handy2pay_onoff']);
	$micropayment_kunde = stripinput($_POST['micropayment_kunde']);
	$micropayment_access = stripinput($_POST['micropayment_access']);
	$micropayment_kurz = stripinput($_POST['micropayment_kurz']);
	$micropayment_projekt = stripinput($_POST['micropayment_projekt']);
	
	$result = dbquery("
	UPDATE ".MW_BP_PAY." SET
	pay_ben='".$micropayment_kunde."',
	pay_pass='".$micropayment_access."',
	pay_f1='".$micropayment_kurz."',
	pay_f2='".$micropayment_projekt."'
	WHERE pay_id='2'");
	
	$result2 = dbquery("
	UPDATE ".MW_BP_SET." SET
	micropayment='".$micropayment."',
	call2pay='".$call2pay."',
	ebank2pay='".$ebank2pay."',
	handy2pay='".$handy2pay."'
	WHERE settings_id='1'");
		
	redirect(FUSION_SELF.$aidlink."&section=pay&sub=micropayment");
	} else {
		if (isset($_GET['success'])) {
			echo "<div id='close-message'><div class='admin-message'>".$locale['mwbp_a020']."</div></div>\n";
		}
	}
$pay = dbarray(dbquery("SELECT * FROM ".MW_BP_PAY." WHERE pay_id='2'" )); 

echo "<br />";
echo "<form name='mwbp_form' method='post' action='".FUSION_SELF.$aidlink."&section=pay&sub=micropayment'>";
echo "<table width='60%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";			
echo "<tr><td class='tbl1' style='text-align:right;' width='40%'>Micropayment AN / AUS</td>";
echo "<td class='tbl1' style='text-align:left;'>";
echo "<select name='micropayment_onoff' id='micropayment_onoff'>
		<option value='1'".($mwbp_set['micropayment'] == 1 ? " selected" : "").">AN</option>
		<option value='0'".($mwbp_set['micropayment'] == 0 ? " selected" : "").">AUS</option>
		</select></td></tr>";
echo "<tr><td class='tbl1' style='text-align:right;' width='40%'>Call2Pay AN / AUS</td>";
echo "<td class='tbl1' style='text-align:left;'>";
echo "<select name='call2pay_onoff' id='call2pay_onoff'>
		<option value='1'".($mwbp_set['call2pay'] == 1 ? " selected" : "").">AN</option>
		<option value='0'".($mwbp_set['call2pay'] == 0 ? " selected" : "").">AUS</option>
		</select></td></tr>";
echo "<tr><td class='tbl1' style='text-align:right;' width='40%'>Ebank2Pay AN / AUS</td>";
echo "<td class='tbl1' style='text-align:left;'>";
echo "<select name='ebank2pay_onoff' id='ebank2pay_onoff'>
		<option value='1'".($mwbp_set['ebank2pay'] == 1 ? " selected" : "").">AN</option>
		<option value='0'".($mwbp_set['ebank2pay'] == 0 ? " selected" : "").">AUS</option>
		</select></td></tr>";
echo "<tr><td class='tbl1' style='text-align:right;' width='40%'>Handy2Pay AN / AUS</td>";
echo "<td class='tbl1' style='text-align:left;'>";
echo "<select name='handy2pay_onoff' id='handy2pay_onoff'>
		<option value='1'".($mwbp_set['handy2pay'] == 1 ? " selected" : "").">AN</option>
		<option value='0'".($mwbp_set['handy2pay'] == 0 ? " selected" : "").">AUS</option>
		</select></td></tr>";
echo "<tr><td class='tbl1' width='40%' style='text-align:right;'>Kundennummer</td>";
echo "<td class='tbl1' style='text-align:left;'><input style='width:168px;' class='textbox' type='text' value='".$pay['pay_ben']."' name='micropayment_kunde' /></td></tr>";		
echo "<tr><td class='tbl1' width='40%' style='text-align:right;'>Access-KEY</td>";
echo "<td class='tbl1' style='text-align:left;'><input style='width:168px;' class='textbox' type='text' value='".$pay['pay_pass']."' name='micropayment_access' /></td></tr>";
echo "<tr><td class='tbl1' width='40%' style='text-align:right;'>Projekt-K&uuml;rzel </td>";
echo "<td class='tbl1' style='text-align:left;'><input style='width:168px;' class='textbox' type='text' value='".$pay['pay_f1']."' name='micropayment_kurz' /></td></tr>";
echo "<tr><td class='tbl1' width='40%' style='text-align:right;'>Projekt-Name </td>";
echo "<td class='tbl1' style='text-align:left;'><input style='width:168px;' class='textbox' type='text' value='".$pay['pay_f2']."' name='micropayment_projekt' /></td></tr>";	
echo "<tr><td class='tbl2' style='text-align:center;' colspan='2'>";
echo "<input type='submit' name='microaddon' value='Speichern' class='button' />";
echo "</td></tr></table></form>";

				
?>