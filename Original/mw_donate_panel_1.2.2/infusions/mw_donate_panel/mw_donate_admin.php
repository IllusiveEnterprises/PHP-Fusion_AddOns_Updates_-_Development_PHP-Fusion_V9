<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_donate_admin.php
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
require_once "../../maincore.php";
require_once THEMES."templates/admin_header.php";

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

include INFUSIONS."mw_donate_panel/infusion_db.php";
include INFUSIONS."mw_donate_panel/includes/functions.php";

if (!checkrights("MWDP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

if (file_exists(INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."mw_donate_panel/locale/German.php";
}
	
if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "status";
}

$mwdp_set = dbarray(dbquery("SELECT * FROM ".MW_DP_SET." WHERE settings_id='1'" ));
$mwdp_list = dbquery("SELECT * FROM ".MW_DP_LIST." ORDER BY status_id DESC");

///Version
/*
if(function_exists('fsockopen')) {
	$mwversion = latest_mw_version();
	if($mwversion != $locale['mwdp_version']) {
		opentable('Update verf&uuml;gbar!');
		echo "<table cellpadding='0' cellspacing='0' class='center'>";
		echo "<tr>";
		echo "<td align=center><font color= #ff0000><b>Du hast Version ".$locale['mwdp_version']." installiert<br />";
		echo "Auf <a href='http://matze-web.de'>matze-web.de</a> ist die Version ".$mwversion." verf&uuml;gbar.<b></td>";
		echo "</font></tr></table>";
		closetable();
	}
}
*/
///Version ende


opentable($locale['mwdp_a001']);
	echo "<table cellpadding='0' cellspacing='0' class='tbl-border center' style='margin:0 auto; width:95%;'>";
	echo "
			<tr>
				<td width='33%' class='".($section == "status" ? "tbl1" : "tbl2")."' align='center'>".($section == "status" ? "<strong>".$locale['mwdp_a012']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=status'><strong>".$locale['mwdp_a012']."</strong></a>")."</td>
				<td width='33%' class='".($section == "settings" ? "tbl1" : "tbl2")."' align='center'>".($section == "settings" ? "<strong>".$locale['mwdp_a013']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=settings'><strong>".$locale['mwdp_a013']."</strong></a>")."</td>
				<td width='34%' class='tbl2' align='center'><a href='".INFUSIONS."mw_donate_panel/mw_donate_page.php'><strong>".$locale['mwdp_a014']."</strong></a></td>
			</tr>
			</table><br />";

switch ($section) {

	case "status":
		if (isset($_GET['deletestatus'])){
			$status_id = stripinput($_GET['status_id']);
				$result = dbquery("DELETE FROM ".MW_DP_LIST." WHERE status_id='".$status_id."'");
				redirect(FUSION_SELF.$aidlink."&section=status&delete=true");
		}else {
			if (isset($_GET['delete'])) {
				echo "<div id='close-message'><div class='admin-message'>".$locale['mwdp_a017']."</div></div>\n";
			}
		}

		echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:100%;'>";
		echo "
			<tr>
				<td class='tbl2' width='40px' style='font-weight:bold;'>".$locale['mwdp_a018']."</td>	
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a019']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a020']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a021']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a022']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a023']."</td>
				<td class='tbl2' width='50px' style='font-weight:bold;'>".$locale['mwdp_a024']."</td>				
			</tr>";

		if (dbrows($mwdp_list) != 0) {
			$i = 0;
			while ($status = dbarray($mwdp_list)) {
			if ($i%2 == 0) $class="tbl1"; else $class="tbl2";
				$user = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$status['user_id']."'")); 
				echo "<tr>";
				echo "<td class='".$class."' style='text-align:center;'>".$status['status_id']."</td>";
				echo "<td class='".$class."'>".$user."</td>";
				echo "<td class='".$class."'>".showdate("%d.%m.%Y %H:%M:%S", $status['time'])."</td>";
				echo "<td class='".$class."'>".$status['spende'].$locale['mwdp_curs']."</td>";
				echo "<td class='".$class."'>".f_status_methode()."</td>";
				echo "<td class='".$class."'>".f_status_pay()."</td>";
				echo "<td class='".$class."' style='text-align:center;'>".f_status_change_pay()."<a href='".FUSION_SELF.$aidlink."&section=status&deletestatus=true&status_id=".$status['status_id']."' onclick=\"return confirm('Wirklich l&ouml;schen?');\"><img src='".INFUSIONS."mw_donate_panel/images/delete.png' alt='".$locale['mwdp_del']."' title='".$locale['mwdp_del']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a></td>";
				echo "</tr>";
			$i++;
			}
		} else {
			echo "<tr><td class='tbl1' colspan='8'>".$locale['mwdp_a028']."</td></tr>";
		}
		echo "</table>";

		if (isset($_GET['acceptpay'])) {
			$status_id = stripinput($_GET['status_id']);
			if ($_GET['acceptpay'] == "true") {
				$result = dbquery("UPDATE ".MW_DP_LIST." SET status_spende='0' WHERE status_id='".$status_id."'");
				redirect(FUSION_SELF.$aidlink."&section=status");
			}else {
				$result = dbquery("UPDATE ".MW_DP_LIST." SET status_spende='1' WHERE status_id='".$status_id."'");
				redirect(FUSION_SELF.$aidlink."&section=status");
			}
		}
	break;

	case "settings":
		if (isset($_POST['settings_saved'])) {
			$bankdaten = stripinput($_POST['bankdaten']); 
			$bank_inh = stripinput($_POST['bank_inh']);
			$bank_ktn = stripinput($_POST['bank_ktn']);
			$bank_blz = stripinput($_POST['bank_blz']);
			$bank_bnk = stripinput($_POST['bank_bnk']);
			$bank_ibn = stripinput($_POST['bank_ibn']); 
			$bank_bic = stripinput($_POST['bank_bic']); 
			$paypal = stripinput($_POST['paypal']); 
			$pay_email = stripinput($_POST['pay_email']); 
			$points_display = stripinput($_POST['points_display']);
			$bank_erlaubniss = stripinput($_POST['bank_erlaubniss']);
	

			$result = dbquery("
				UPDATE ".MW_DP_SET." SET
				bankdaten='".$bankdaten."',
				bank_inh='".$bank_inh."',
				bank_ktn='".$bank_ktn."',
				bank_blz='".$bank_blz."',
				bank_bnk='".$bank_bnk."',
				bank_ibn='".$bank_ibn."',
				bank_bic='".$bank_bic."',
				paypal='".$paypal."',
				pay_email='".$pay_email."',
				points_display='".$points_display."',
				bank_erlaubniss='".$bank_erlaubniss."'
				WHERE settings_id='1'");
		
				redirect(FUSION_SELF.$aidlink."&section=settings&success=true");
		} else {
			if (isset($_GET['success'])) {
				echo "<div id='close-message'><div class='admin-message'>".$locale['mwdp_a011']."</div></div>\n";
			}
		}

		echo "&nbsp;<b>".$locale['mwdp_a015'].":</b><br /><hr>";
		echo "<form name='mwdp_form' method='post' action='".FUSION_SELF.$aidlink."&section=settings'>";
		echo "<table width='100%' align='center'>";
		echo "
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a008']."</td>
				<td><select name='bankdaten' id='bankdaten' class='textbox'>
					<option value='0'".($mwdp_set['bankdaten'] == 0 ? " selected" : "").">".$locale['mwdp_yes']."</option>
		 			<option value='1'".($mwdp_set['bankdaten'] == 1 ? " selected" : "").">".$locale['mwdp_no']."</option>
		 			</select>
		 		</td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a002']."</td>
				<td><input type='text' name='bank_inh' value='".$mwdp_set['bank_inh']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a003']."</td>
				<td><input type='text' name='bank_ktn' value='".$mwdp_set['bank_ktn']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a004']."</td>
				<td><input type='text' name='bank_blz' value='".$mwdp_set['bank_blz']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a005']."</td>
				<td><input type='text' name='bank_bnk' value='".$mwdp_set['bank_bnk']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a006']."</td>
				<td><input type='text' name='bank_ibn' value='".$mwdp_set['bank_ibn']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a007']."</td>
				<td><input type='text' name='bank_bic' value='".$mwdp_set['bank_bic']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			</table>
				<br />&nbsp;<b>".$locale['mwdp_a016'].":</b><br /><hr>
			<table width='100%' align='center'>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a009']."</td><td><select name='paypal' id='paypal' class='textbox'>
		 			<option value='0'".($mwdp_set['paypal'] == 0 ? " selected" : "").">".$locale['mwdp_yes']."</option>
		 			<option value='1'".($mwdp_set['paypal'] == 1 ? " selected" : "").">".$locale['mwdp_no']."</option>
		 			</select>
		 		</td>
			</tr>
			<tr>
				<td width='40%' valign='top'>".$locale['mwdp_a010']."</td>
				<td><input type='text' name='pay_email' value='".$mwdp_set['pay_email']."' maxlength='100' class='textbox' style='width:300px;' /></td>
			</tr>
			<tr>
				<td colspan='2' align='center'><input type='submit' class='button' name='settings_saved' value='".$locale['mwdp_save']."' /></td>
			</tr>
		</table>";
		//DEES
						echo "<br />&nbsp;<b>Sonstige einstellungen:</b><br /><hr>
			<table width='100%' align='center'>";
echo "<tr>\n";
echo "<td width = '30%' valign='top'>".$locale['mwdp_aa029']."<br /></td>
		<td><select name='points_display' id='points_display' class='textbox'>
		<option value='0'".($mwdp_set['points_display'] == 0 ? " selected" : "").">".$locale['mwdp_aa030']."</option>
		<option value='1'".($mwdp_set['points_display'] == 1 ? " selected" : "").">".$locale['mwdp_aa031']."</option>
		<option value='2'".($mwdp_set['points_display'] == 2 ? " selected" : "").">".$locale['mwdp_aa032']."</option>
		<option value='3'".($mwdp_set['points_display'] == 3 ? " selected" : "").">".$locale['mwdp_aa033']."</option>
		</select></td>\n";
echo "</tr>\n";
			echo "<tr>";
			echo "<td width = '30%' valign='top'>".$locale['mwdp_aa036']."<br /></td>
		<td><select name='bank_erlaubniss' id='bank_erlaubniss' class='textbox'>
		<option value='0'>".$locale['mwdp_aa034']."</option>";
		$result = dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS."");
			while ($bpgdata = dbarray($result))
				{
					echo "<option value='".$bpgdata['group_id']."' ".($mwdp_set['bank_erlaubniss']==$bpgdata['group_id'] ? "selected" : "").">".$bpgdata['group_name']."</option>";
				}
		echo"</select></td>\n";
		echo "</tr>
			<tr>
				<td colspan='2' align='center'><input type='submit' class='button' name='settings_saved' value='".$locale['mwdp_save']."' /></td>
			</tr>
		</table>";
		//DEEE
		echo "</form>";
	break;

}
closetable();
// Do not remove this line!
echo "".mw_Copyright()."<br />";
require_once THEMES."templates/footer.php";

?> 