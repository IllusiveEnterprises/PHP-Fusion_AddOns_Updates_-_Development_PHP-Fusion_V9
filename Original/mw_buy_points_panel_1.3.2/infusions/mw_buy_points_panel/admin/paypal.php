<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright ｩ 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: paypal.php
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
	$pay_ben = stripinput($_POST['pay_ben']);
	$pay_aktiv = stripinput($_POST['pay_aktiv']);
	
	$result = dbquery("
	UPDATE ".MW_BP_PAY." SET
	pay_ben='".$pay_ben."'
	WHERE pay_id='1'");
	
	$result2 = dbquery("
	UPDATE ".MW_BP_SET." SET
	paypal='".$pay_aktiv."'
	WHERE settings_id='1'");

	

	redirect(FUSION_SELF.$aidlink."&section=pay&sub=paypal&success=true");
} else {
	if (isset($_GET['success'])) {
		echo "<div id='close-message'><div class='admin-message'>".$locale['mwbp_a080']."</div></div>\n";
	}
}

$pay = dbarray(dbquery("SELECT * FROM ".MW_BP_PAY." WHERE pay_id='1'" )); 

echo "<form name='mwbp_form' method='post' action='".FUSION_SELF.$aidlink."&section=pay&sub=paypal'>";
echo "<table width='80%' align='center'>\n";
echo "<tr>\n";
echo "<td width = '30%' valign='top'>".$locale['mwbp_a081']."<br /><span class='small2'><em></em></span></td><td><select name='pay_aktiv' id='pay_aktiv' class='textbox'>
		<option value='0'".($mwbp_set['paypal'] == 0 ? " selected" : "").">".$locale['mwbp_a082']."</option>
		<option value='1'".($mwbp_set['paypal'] == 1 ? " selected" : "").">".$locale['mwbp_a083']."</option>
		</select></td>\n";
echo "</tr>\n";
echo "<td width='30%' valign='top'>".$locale['mwbp_a084']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='pay_ben' value='".$pay['pay_ben']."' maxlength='100' class='textbox' style='width:300px;' /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan='2' align='center'><input type='submit' class='button' name='settings_saved' value='".$locale['mwbp_save']."' />";
echo "</td></tr>\n";
echo "</table>\n";
echo "</form>\n";
?>

