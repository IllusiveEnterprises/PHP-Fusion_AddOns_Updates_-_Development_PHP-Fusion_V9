<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_buy_points_admin.php
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

include INFUSIONS."mw_buy_points_panel/infusion_db.php";
include INFUSIONS."mw_buy_points_panel/includes/functions.php";

if (!checkrights("MWBP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect(BASEDIR."index.php"); }

$mwbp_set = dbarray(dbquery("SELECT * FROM ".MW_BP_SET." WHERE settings_id='1'"));
$bank = dbarray(dbquery("SELECT * FROM ".MW_BP_BANK." WHERE bank_id='1'" ));

if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
} else {
	include INFUSIONS."mw_buy_points_panel/locale/German.php";
}

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "status";
}

///Version
/*
if(function_exists('fsockopen')) {
	$mwversion = latest_mw_version();
	if($mwversion != $locale['mwbp_version']) {
		opentable('Update verf&uuml;gbar!');
		echo "<table cellpadding='0' cellspacing='0' class='center'>";
		echo "<tr>";
		echo "<td align=center><font color= #ff0000><b>Du hast Version ".$locale['mwbp_version']." installiert<br />";
		echo "Auf <a href='http://matze-web.de'>matze-web.de</a> ist die Version ".$mwversion." verf&uuml;gbar.<b></td>";
		echo "</font></tr></table>";
		closetable();
	}
}
*/
///Version ende

opentable($locale['mwbp_a001']);
	echo "<table cellpadding='0' cellspacing='0' class='tbl-border center' style='margin:0 auto; width:95%;'>";
	echo "<tr>";
	echo "<td width='16%' class='".($section == "status" ? "tbl1" : "tbl2")."' align='center'>".($section == "status" ? "<strong>".$locale['mwbp_a005']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=status'><strong>".$locale['mwbp_a005']."</strong></a>")."</td>";	
	echo "<td width='16%' class='".($section == "settings" ? "tbl1" : "tbl2")."' align='center'>".($section == "settings" ? "<strong>".$locale['mwbp_a002']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=settings'><strong>".$locale['mwbp_a002']."</strong></a>")."</td>";
	echo "<td width='16%' class='".($section == "points" ? "tbl1" : "tbl2")."' align='center'>".($section == "points" ? "<strong>".$mwbp_set['points_name']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=points'><strong>".$mwbp_set['points_name']."</strong></a>")."</td>";	
	echo "<td width='16%' class='".($section == "bank" ? "tbl1" : "tbl2")."' align='center'>".($section == "bank" ? "<strong>".$locale['mwbp_a003']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=bank'><strong>".$locale['mwbp_a003']."</strong></a>")."</td>";	
	echo "<td width='16%' class='".($section == "pay" ? "tbl1" : "tbl2")."' align='center'>".($section == "pay" ? "<strong>".$locale['mwbp_a004']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=pay'><strong>".$locale['mwbp_a004']."</strong></a>")."</td>";
	echo "<td width='20%' class='tbl2' align='center'><a href='".INFUSIONS."mw_buy_points_panel/mw_buy_points.php'><strong>".$locale['mwbp_a006']."</strong></a></td>";
	echo "</tr></table>";
	
	switch ($section) {

	case "settings" :
	// Einstellungen
	include INFUSIONS."mw_buy_points_panel/admin/settings.php";
	break;

	case "points" :
	// Punkte kaufen
	include INFUSIONS."mw_buy_points_panel/admin/points.php";
	break;

	case "bank" :
	// Bankdaten
	include INFUSIONS."mw_buy_points_panel/admin/bank.php";
	break;

	case "pay" :
	// Bezahlsysteme
		if(isset($_GET['sub'])) {
			$sub = stripinput($_GET['sub']);
		} else {
			$sub = "paypal";
		}
	
	echo "<table cellpadding='0' cellspacing='0' class='tbl-border center' style='width:95%;'>";
	echo "<tr style='border-bottom:1px solid gray;'>

	<td width='25%' class='".($sub == "paypal" ? "tbl1" : "tbl2")."' align='center'>".($sub == "paypal" ? "<strong>".$locale['mwbp_a007']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=pay&sub=paypal'><strong>".$locale['mwbp_a007']."</strong></a>")."</td>
	<td width='25%' class='".($sub == "micropayment" ? "tbl1" : "tbl2")."' align='center'>".($sub == "micropayment" ? "<strong>".$locale['mwbp_a008']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=pay&sub=micropayment'><strong>".$locale['mwbp_a008']."</strong></a>")."</td>
	<td width='25%' class='".($sub == "3" ? "tbl1" : "tbl2")."' align='center'>".($sub == "3" ? "<strong>".$locale['mwbp_a009']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=pay&sub=3'><strong>".$locale['mwbp_a009']."</strong></a>")."</td>
	<td width='25%' class='".($sub == "4" ? "tbl1" : "tbl2")."' align='center'>".($sub == "4" ? "<strong>".$locale['mwbp_a010']."</strong>" : "<a href='".FUSION_SELF.$aidlink."&section=pay&sub=4'><strong>".$locale['mwbp_a010']."</strong></a>")."</td>
	</tr>
	</table><br />";

	switch ($sub) {
	case "paypal":
	// Paypal
	include	INFUSIONS."mw_buy_points_panel/admin/paypal.php";
	break;

	case "micropayment":
	// ?
	include	INFUSIONS."mw_buy_points_panel/admin/micropayment.php";
	break;

	case "3":
	// ?
	include INFUSIONS."mw_buy_points_panel/admin/3.php";
	break;

	case "4":
	// ?
	include	INFUSIONS."mw_buy_points_panel/admin/4.php";
	break;
	} // sub Ende

	break;
	
	case "status":
	include	INFUSIONS."mw_buy_points_panel/admin/status.php";
	break;
	} // section ENDE
		
closetable();
// Do not remove this line!
echo "".mw_Copyright()."<br />";
require_once THEMES."templates/footer.php";

?>