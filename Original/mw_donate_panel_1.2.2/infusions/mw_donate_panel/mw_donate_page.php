<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_donate_page.php
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
require_once THEMES."templates/header.php";

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!iMEMBER) redirect(BASEDIR."index.php");


// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_donate_panel/locale/German.php";
}

include INFUSIONS."mw_donate_panel/infusion_db.php";
include_once INFUSIONS."mw_donate_panel/includes/functions.php";

$mwdp_set = dbarray(dbquery("SELECT * FROM ".MW_DP_SET." WHERE settings_id='1'"));

if(isset($_GET['aktion']))
{
$aktion = stripinput($_GET['aktion']);
} else {
$aktion = "main";
}

switch ($aktion) {

case "spend":
	opentable($locale['mwdp_p001']);
		echo "<center>";
		echo "<b>".$locale['mwdp_p002']."</b>";
		echo "<hr width='250px'>";
		echo "<form name='donatepanel' action='".INFUSIONS."mw_donate_panel/mw_donate_page.php' method='post'>\n";
		echo "".$locale['mwdp_p003']."&nbsp;<input type='text' name='donate' size='6' style='width: 50px;' class='textbox'>&nbsp;".$locale['mwdp_curs']."\n";
		echo "<br /><br><input input type='image' src='".INFUSIONS."mw_donate_panel/images/spendenbutton.gif' border='0' name='submit' alt='".$locale['mwdp_p001']."'></form></br>";
		echo "</center>";
	closetable();
break;

case "main":
	if(isset($_POST['donate']) && ($_POST['donate'] != '') && ($_POST['donate'] != '0')){
		$donate_alt = stripinput($_POST['donate']);
		$donate_mit = strtr($donate_alt, ',', '.');		
		$donate_neu	= number_format($donate_mit, 2, '.', '');
		}else {
			redirect(FUSION_SELF."?aktion=spend");
		}
		opentable($locale['mwdp_s001']);
		echo "<center><b>".$locale['mwdp_s003']."&nbsp;".$donate_neu."&nbsp;&#8364;</b><br /><hr width='250px'></center><br>";
		echo "<table cellpadding='0' cellspacing='0' class='tbl-border center' style='width:50%;'>";
		echo "
			<tr>
				<td class='tbl2' width='50%' style='font-weight:bold;'><center>".$locale['mwdp_s002']."</center></td>
			</tr>
			</table>
			<table cellpadding='0' cellspacing='0' class='tbl-border center' style='width:50%;'>
			<tr>";
			if ($mwdp_set['bankdaten'] == 0) {
			if (checkgroup($mwdp_set['bank_erlaubniss'])) {
				echo "<td class='tbl1' width='300px' style='font-weight:bold;'><a href='".FUSION_SELF."?aktion=bankdaten&donate=".$donate_neu."'><center><img border='0' src='".INFUSIONS."mw_donate_panel/images/uberweisung.png'><br><span class='small'>Bankdaten anfordern</span></center></td>";
				} else {
				echo "<td class='tbl1' width='300px' style='font-weight:bold;'><a href='".FUSION_SELF."?aktion=bankerlaubniss'><center><img border='0' src='".INFUSIONS."mw_donate_panel/images/uberweisungno.png'><br><span class='small'>Bankdaten anfordern</span></center></td>";
				}
				//echo "<td class='tbl1' width='50%' style='font-weight:bold;'><a href='".FUSION_SELF."?aktion=bankdaten&donate=".$donate_neu."'><center><img border='0' src='".INFUSIONS."mw_donate_panel/images/uberweisung.png'><br>Bankdaten anfordern</center></td>";
			}
			if ($mwdp_set['paypal'] == 0) {
				echo "<td class='tbl1' width='50%' style='font-weight:bold;'>";
				echo "<center>";
				//echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' target='_blank' method='post'>";
				echo "<form action='https://www.paypal.com/cgi-bin/webscr' target='_blank' method='post'>";
				echo "<input type='hidden' name='amount' value='".$donate_neu."'>";
				echo "<input type='hidden' name='currency_code' value='".$locale['mwdp_cur']."'>";
				echo "<input type='hidden' name='cmd' value='_donations'>";
				echo "<input type='hidden' name='lc' value='de'>";
				echo "<input type='hidden' name='no_note' value='0'>";
				echo "<input type='hidden' name='no_shipping' value='1'>";
				echo "<input type='hidden' name='notify_url' value='".$settings["siteurl"]."infusions/mw_donate_panel/payment.php'>";
				echo "<input type='hidden' name='business' value='".$mwdp_set['pay_email']."'>";
				echo "<input type='hidden' name='item_name' value='".$locale['mwdp_a021']."'>";
				echo "<input type='hidden' value='".$userdata['user_id']."' name='on0'>";
				echo "<input type='hidden' value=' ".$userdata['user_name']." 'name='os0'>";
				//echo "<input type='hidden' value='".$settings["siteurl"]."".INFUSIONS."mw_donate_panel/mw_donate_page.php?aktion=return' name='return'>";
				//echo "<input type='hidden' value='".$settings["siteurl"]."".INFUSIONS."mw_donate_panel/mw_donate_page.php?aktion=cancel_return' name='cancel_return'>";
				echo "<input input type='image' src='".INFUSIONS."mw_donate_panel/images/pp_sicher_zahlen.png' border='0' name='submit' alt='PayPal-Bezahlmethoden-Logo'></form></br>";
				echo "</center>";	
				echo "</td>";
			}
			echo "</tr></table>";
	closetable();
	
	//DEE
opentable ("Deine Spenden");
$mwdp_list = dbquery("SELECT * FROM ".MW_DP_LIST." WHERE user_id = '".$userdata['user_id']."' ORDER BY time DESC");
$result = dbquery("SELECT * FROM ".MW_DP_LIST." WHERE user_id = '".$userdata['user_id']."' ORDER BY time DESC");
//echo "<br />";

		echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:100%;'>";
		echo "
			<tr>
				<td class='tbl2' width='40px' style='font-weight:bold;'>".$locale['mwdp_a018']."</td>	
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a019']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a020']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a021']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a022']."</td>
				<td class='tbl2' style='font-weight:bold;'>".$locale['mwdp_a023']."</td>
				
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
				//echo "<td class='".$class."' style='text-align:center;'>".f_status_change_pay()." |<a href='".FUSION_SELF.$aidlink."&section=status&deletestatus=true&status_id=".$status['status_id']."'><img src='".INFUSIONS."mw_donate_panel/images/delete.png' alt='".$locale['mwdp_del']."' title='".$locale['mwdp_del']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a></td>";
				echo "</tr>";
			$i++;
			}
		} else {
			echo "<tr><td class='tbl1' colspan='8'>".$locale['mwdp_a028']."</td></tr>";
		}
		echo "</table>";

closetable ();
//DEE
	
break;

case "bankdaten":
	if (isset($_GET['send'])) {
		opentable($locale['mwdp_s010']);
			echo "".$locale['mwdp_s011']."";
		closetable();
	}else{
	//if (checkgroup($mwdp_set['bank_erlaubniss'])) {
		if ($mwdp_set['bankdaten'] == 0) {
		$donate = stripinput($_GET['donate']);
		$db_set = dbarray(dbquery("SELECT * FROM ".MW_DP_SET.""));
		$bank = "".$locale['mwdp_s005'].$donate.$locale['mwdp_cur'].$locale['mwdp_s006']."
				".$locale['mwdp_s004']."\n\n
				".$locale['mwdp_a002']."&nbsp;".$db_set['bank_inh']."
				".$locale['mwdp_a003']."&nbsp;".$db_set['bank_ktn']."
				".$locale['mwdp_a004']."&nbsp;".$db_set['bank_blz']."
				".$locale['mwdp_a005']."&nbsp;".$db_set['bank_bnk']."
				".$locale['mwdp_a006']."&nbsp;".$db_set['bank_ibn']."
				".$locale['mwdp_a007']."&nbsp;".$db_set['bank_bic']."";
		$result = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$userdata['user_id']."','1','".$locale['mwdp_s007']."','".$bank."','y','0','".time()."','0')");
		$result2 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('1','".$userdata['user_id']."','".$locale['mwdp_s008']."','".$userdata['user_name'].$locale['mwdp_s009']."','y','0','".time()."','0')");
		$result3 = dbquery("INSERT INTO ".MW_DP_LIST." (user_id, spende, methode, time, status_spende, txn_id) VALUES('".$userdata['user_id']."','".$donate."','0','".time()."','1','0')");
		redirect(FUSION_SELF."?aktion=bankdaten&send=true");
		}else redirect(BASEDIR."index.php");
	}	
	//}
break;

//DEE
case "bankerlaubniss":
	if ($mwdp_set['bankdaten'] == 0) {
	opentable("Bankdaten anforderung erlaubniss");
echo '
<p style="text-align: center;"><span style="color: #ff0000;"><strong>Sie sind momentan nicht befugt Bankdaten anzufordern!</strong></span></p>
<p style="text-align: center;">Um Bankdaten anzufordern m&uuml;ssen Sie mir "DeeoNe" eine PN mit einem Grund der Anforderung, sowie was Sie machen m&ouml;chten wie Scores kaufen oder Spenden angeben.</p>
<p style="text-align: center;"><center><form name="bank_erlaubniss" method="post" action="'.BASEDIR.'messages.php?msg_send=1" target="_top"><input type="submit" name="bank_erlaubniss" value="Erlaubnis einholen" class="button" /></form></center></p>
<p style="text-align: center;">Wenn Sie mir die PN mit seri&ouml;sem Grund geschickt haben, werden sie von uns in die Gruppe der Bankdaten gesetzt und brauchen sich dann nicht erneut mehr eine Erlaubnis einholen, wenn der n&auml;chste Punkt eingehalten wird:</p>
<p style="text-align: center;">Sie haben nach der Erlaubnis Annahme eine Woche Zeit, die gew&uuml;nschte Action zu machen und das Geld zu &Uuml;berweisen, geschieht dies nicht werden Sie wieder aus der Gruppe genommen</p>
<p style="text-align: center;"><span style="color: #ff9900;"><strong>und Zahlen eine Strafe von 200 Scores.</strong></span></p>
<p style="text-align: center;">Um diese Strafe zu umgehen reicht es eine R&uuml;ckmeldung <strong>innerhalb der einen Woche</strong> zu geben, warum die Zahlung nicht gemacht wurde.</p>
<p style="text-align: center;">Diese Ma&szlig;nahme wurde gemacht um meine Kontodaten zu sch&uuml;tzen und durch Test Anforderungen hinterlegten Buchungen nicht dauernd zu Stornieren und hinterher zu Fragen.</p>
<p style="text-align: center;">Mit PayPal m&uuml;ssen Sie nicht diese Schritte machen, dort k&ouml;nnen sie direkt Zahlen und die gew&uuml;nschte Action wird in wenigen Minuten erfolgen.</p>
';
	closetable();
	}else redirect(BASEDIR."index.php");
break;
//DEE

case "return":
	opentable();
	echo "<center>".$locale['mwdp_s012']."</center>";
	closetable();
break;
	
case "cancel_return":
	opentable();
	echo "<center>".$locale['mwdp_s013']."</center>";
	closetable();
break;

default:
	redirect(BASEDIR."index.php");
break;
}
echo "".mw_Copyright()."<br />";	
require_once THEMES."templates/footer.php";
?>