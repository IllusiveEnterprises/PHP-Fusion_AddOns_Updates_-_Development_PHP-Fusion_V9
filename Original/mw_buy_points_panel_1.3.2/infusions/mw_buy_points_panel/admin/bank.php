<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright ｩ 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: bank.php
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
	$bank_inh = stripinput($_POST['bank_inh']);
	$bank_ktn = stripinput($_POST['bank_ktn']);
	$bank_blz = stripinput($_POST['bank_blz']);
	$bank_bnk = stripinput($_POST['bank_bnk']);
	$bank_ibn = stripinput($_POST['bank_ibn']);
	$bank_bic = stripinput($_POST['bank_bic']);
	
	$result = dbquery("
	UPDATE ".MW_BP_BANK." SET
	bank_inh='".$bank_inh."',
	bank_ktn='".$bank_ktn."',
	bank_blz='".$bank_blz."',
	bank_bnk='".$bank_bnk."',
	bank_ibn='".$bank_ibn."',
	bank_bic='".$bank_bic."'
	WHERE bank_id='1'");	
	

	redirect(FUSION_SELF.$aidlink."&section=bank&success=true");
	} else {
		if (isset($_GET['success'])) {
			echo "<div id='close-message'><div class='admin-message'>".$locale['mwbp_a060']."</div></div>\n";			
		}
	}
echo "<br />";
echo "<form name='mwbp_form' method='post' action='".FUSION_SELF.$aidlink."&section=bank'>";
echo "<table width='80%' align='center'>\n";
echo "<tr>\n";
echo "<td valign='top'>".$locale['mwbp_a061']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='bank_inh' value='".$bank['bank_inh']."' maxlength='100' class='textbox' style='width:500px;' /></td>\n";
echo "</tr>\n";
echo "<td valign='top'>".$locale['mwbp_a062']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='bank_ktn' value='".$bank['bank_ktn']."' maxlength='100' class='textbox' style='width:500px;' /></td>\n";
echo "</tr>\n";
echo "<td valign='top'>".$locale['mwbp_a063']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='bank_blz' value='".$bank['bank_blz']."' maxlength='100' class='textbox' style='width:500px;' /></td>\n";
echo "</tr>\n";
echo "<td valign='top'>".$locale['mwbp_a064']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='bank_bnk' value='".$bank['bank_bnk']."' maxlength='100' class='textbox' style='width:500px;' /></td>\n";
echo "</tr>\n";
echo "<td valign='top'>".$locale['mwbp_a065']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='bank_ibn' value='".$bank['bank_ibn']."' maxlength='100' class='textbox' style='width:500px;' /></td>\n";
echo "</tr>\n";
echo "<td valign='top'>".$locale['mwbp_a066']."<br /><span class='small2'><em></em></span></td><td><input type='text' name='bank_bic' value='".$bank['bank_bic']."' maxlength='100' class='textbox' style='width:500px;' /></td>\n";
echo "</tr>\n";
echo "<tr>\n";
echo "<td colspan='2' align='center'><input type='submit' class='button' name='settings_saved' value='".$locale['mwbp_save']."' />";
echo "</td></tr>\n";
echo "</table>\n";
echo "</form>\n";
?>