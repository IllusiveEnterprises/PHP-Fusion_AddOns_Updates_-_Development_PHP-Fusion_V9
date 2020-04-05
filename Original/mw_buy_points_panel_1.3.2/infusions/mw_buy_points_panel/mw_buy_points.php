<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_buy_points.php
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

if (score_ban($userdata['user_id'])) { redirect(BASEDIR."index.php"); }

if (!defined("IN_FUSION")) { die("Access Denied"); }
if (!iMEMBER) redirect(BASEDIR."index.php");
include INFUSIONS."mw_buy_points_panel/infusion_db.php";
include_once INFUSIONS."mw_buy_points_panel/includes/functions.php";

$mwbp_set = dbarray(dbquery("SELECT * FROM ".MW_BP_SET." WHERE settings_id='1'"));

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_buy_points_panel/locale/German.php";
}

if(isset($_GET['aktion']))
{
$aktion = stripinput($_GET['aktion']);
} else {
$aktion = "main";
}
switch ($aktion) {

case "main":
	opentable($mwbp_set['points_name'].$locale['mwbp_a180']);

	$result = dbquery("SELECT * FROM ".MW_BP_POINTS." ORDER BY points_id");
	echo "<br />";
	echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:400px;'>";
	echo "<tr>
	<td class='tbl1' colspan='8' style='font-weight:bold;font-size:bigger;text-align:left;'>".$locale['mwbp_a181'].$mwbp_set['points_name'].$locale['mwbp_a181a']."</td>
	</tr><tr>
	<td class='tbl2' width='39%' style='font-weight:bold;'>".$locale['mwbp_a182']."</td>
	<td class='tbl2' width='39%' style='font-weight:bold;'>".$mwbp_set['points_name']."</td>
	<td class='tbl2' width='20%' style='font-weight:bold;'>".$locale['mwbp_a183']."</td>
	</tr>
	";

	if (dbrows($result) != 0) {
		$i = 0;
		while ($points = dbarray($result)) {
		if ($i%2 == 0) $class="tbl1"; else $class="tbl2";
		echo "<tr>";
		echo "<td class='".$class."'>".$points['points_pre'].$locale['mwbp-curs']."</td>";
		echo "<td class='".$class."'>".$points['points_anz']."</td>";
		echo "<td class='".$class."' style='text-align:center;'><a href='".FUSION_SELF."?aktion=buy&points_id=".$points['points_id']."'><img src='".INFUSIONS."mw_buy_points_panel/images/dollar.png' alt='Buy' title='".$locale['mwbp_a183']."' style='width:16px; height:16px; vertical-align:middle;' border='0' /></a></td>";
		echo "</tr>";
		$i++;
		}
	} else {
	echo "<tr><td class='tbl1' colspan='8'>".$locale['mwbp_a185']."</td></tr>";
	}
	echo "</table>";

echo "<br><span style='color: #ff6600;'><center><b>Eine Auszahlung von Scores in Geld ist nicht m&ouml;glich!</b></center></span>";

	closetable();

//DEE
opentable ("Deine Scores k&auml;ufe");
$result = dbquery("SELECT * FROM ".MW_BP_STATUS." WHERE user_id = '".$userdata['user_id']."' ORDER BY time DESC");
//echo "<br />";

echo "<table cellpadding='1' cellspacing='1' class='tbl-border center' style='width:100%;'>";
echo "<tr>
		
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a160']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a161']."</td>
	<td class='tbl2' style='font-weight:bold;'>Punkte</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a162']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a163']."</td>
	<td class='tbl2' style='font-weight:bold;'>".$locale['mwbp_a164']."</td>
	<td class='tbl2' style='font-weight:bold;'>Punkte-<br>gutschrift</td>
	
	</tr>
	";

if (dbrows($result) != 0) {
	$i = 0;
	while ($status = dbarray($result)) {
	if ($i%2 == 0) $class="tbl1"; else $class="tbl2";
		$user = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$status['user_id']."'")); 
		echo "<tr>";
		echo "<td class='".$class."'>".showdate("%d.%m.%Y %H:%M:%S", $status['time'])."</td>";
		echo "<td class='".$class."'>".$user."</td>";
		echo "<td class='".$class."'>".$status['points_anz']."</td>";
		echo "<td class='".$class."'>".$status['points_pre'].$locale['mwbp-curs']."</td>";
		echo "<td class='".$class."'>".f_status_methode()."</td>";
		echo "<td class='".$class."'>".f_status_pay()."</td>";
		echo "<td class='".$class."'>".f_status_poi()."</td>";
		echo "</td>";
		echo "</tr>";
	$i++;
	}
} else {
echo "<tr><td class='tbl1' colspan='8'>".$locale['mwbp_a171']."</td></tr>";
}
echo "</table>";

closetable ();
//DEE

break;

case "buy":
	opentable("".$locale['mwbp_a186']."");
	$points_buy = $_GET['points_id'];
	$paypal = dbresult(dbquery("SELECT pay_ben FROM ".MW_BP_PAY." WHERE pay_id='1'"));
	$poi = dbarray(dbquery("SELECT points_pre, points_anz FROM ".MW_BP_POINTS." WHERE points_id ='".stripinput($_GET['points_id'])."'"));
	$micropay = dbarray(dbquery("SELECT * FROM ".MW_BP_PAY." WHERE pay_id='2' "));
	$microamount = $poi['points_pre']*100;
	echo "<center><b>".$locale['mwbp_a206'].$poi['points_anz']."&nbsp;".$mwbp_set['points_name'].$locale['mwbp_a207'].$poi['points_pre']."&nbsp;".$locale['mwbp-curs'].$locale['mwbp_a208']."</b><br /><hr width='300px'></center><br>";
	echo "<table cellpadding='0' cellspacing='0' class='tbl-border center' style='width:50%;'>";
	echo "<tr>";
	echo "<td class='tbl2' width='50%' style='font-weight:bold;'><center>".$locale['mwbp_a186']."</center></td>";
	echo "</tr></table><br>";
	
	if ($mwbp_set['bankdaten'] == 1) {
		echo "<fieldset name='Pay1'>";
		echo "<legend><b>Bankdaten</b></legend>";
		echo "<table cellpadding='0' cellspacing='0' class='tbl-border center'>";
		//echo "<table cellpadding='0' cellspacing='0' class='center'>";
		echo "<tr>";
		
		if (checkgroup($mwbp_set['bank_erlaubniss'])) {
		echo "<td class='tbl1' width='300px' style='font-weight:bold;'><a href='".FUSION_SELF."?aktion=bankdaten&points_id=".$points_buy."'><center><img border='0' src='".INFUSIONS."mw_buy_points_panel/images/uberweisung.png'><br>Bankdaten anfordern</center></td>";
		} else {
		echo "<td class='tbl1' width='300px' style='font-weight:bold;'><a href='".FUSION_SELF."?aktion=bankerlaubniss'><center><img border='0' src='".INFUSIONS."mw_buy_points_panel/images/uberweisungno.png'><br><span class='small'>Bankdaten anfordern</span></center></td>";
		}		

		//echo "<td class='tbl1' width='300px' style='font-weight:bold;'><a href='".FUSION_SELF."?aktion=bankdaten&points_id=".$points_buy."'><center><img border='0' src='".INFUSIONS."mw_buy_points_panel/images/uberweisung.png'><br>Bankdaten anfordern</center></td>";
		echo "</tr></table></fieldset>";
	}
	if ($mwbp_set['paypal'] == 1) {
		echo "<fieldset name='Pay2'>";
		echo "<legend><b>Paypal</b></legend>";
		echo "<table cellpadding='0' cellspacing='0' class='tbl-border center'>";
		//echo "<table cellpadding='0' cellspacing='0' class='center'>";
		echo "<tr>";
		echo "<td class='tbl1' width='300px' style='font-weight:bold;'>";
		echo "<center>";
		//echo "<form action='https://www.sandbox.paypal.com/cgi-bin/webscr' target='_blank' method='post'>\n";
		echo "<form action='https://www.paypal.com/cgi-bin/webscr' target='_blank' method='post'>\n";
		echo "<input type='hidden' name='amount' value='".$poi['points_pre']."'>\n";
		echo "<input type='hidden' name='currency_code' value='".$locale['mwbp-cur']."'>\n";
		echo "<input type='hidden' name='cmd' value='_xclick'>\n";
		echo "<input type='hidden' name='lc' value='de'>\n";
		echo "<input type='hidden' name='no_note' value='0'>\n";
		echo "<input type='hidden' name='no_shipping' value='1'>\n";
		echo "<input type='hidden' name='notify_url' value='".$settings["siteurl"]."infusions/mw_buy_points_panel/payment.php'>\n";
		echo "<input type='hidden' name='business' value='".$paypal."'>\n";
		echo "<input type='hidden' name='item_name' value='".$poi['points_anz']." ".$mwbp_set['points_name']."'>\n";
		echo "<input type='hidden' value='".$userdata['user_id']."' name='on0'>\n";
		echo "<input type='hidden' value=' ".$userdata['user_name']." 'name='os0'>\n";
		echo "<input type='hidden' value='".$mwbp_set['points_name']."' name='on1'>\n";
		echo "<input type='hidden' value=' ".$poi['points_anz']." 'name='os1'>\n";
		//echo "<input type='hidden' value='".$settings["siteurl"]."".INFUSIONS."mw_buy_points_panel/mw_buy_points.php?aktion=return' name='return'>\n";
		//echo "<input type='hidden' value='".$settings["siteurl"]."".INFUSIONS."mw_buy_points_panel/mw_buy_points.php?aktion=cancel_return' name='cancel_return'>\n";
		echo "<input input type='image' src='".INFUSIONS."mw_buy_points_panel/images/pp_sicher_zahlen.png' border='0' name='submit' alt='PayPal-Bezahlmethoden-Logo'></form>";
		echo "</center>";	
		echo "</td></tr></table></fieldset>";
	}
	if ($mwbp_set['micropayment'] == 1) {
		if ($mwbp_set['call2pay'] == 1 && $microamount >= 5 && $microamount <= 500) { //3000
			echo "<fieldset name='Pay3'>";
			echo "<legend><b>Call2Pay</b></legend>";
			echo "<table cellpadding='0' cellspacing='0' class='tbl-border center'>";
			$sealedParams = "project=".$micropay['pay_f1']."&title=".$settings["sitename"]."&amount=".$microamount."&userid=".$userdata['user_id']."&system=call2pay&id=".stripinput($_GET['points_id'])."";
  			$unsealedParams = "&account=".$micropay['pay_ben']."&bgcolor=000000";
 			$accessKey = $micropay['pay_pass'];
 			$seal = md5($sealedParams . $accessKey);     
 			$url ='https://billing.micropayment.de/call2pay/event/?'.$sealedParams .'&seal='.$seal.$unsealedParams;
			echo "<tr><td class='tbl1' width='300px' style='font-weight:bold;'><center><a href='".$url."' target='_top' onclick='return popup(this.href);'><img src='http://www.micropayment.de/resources/?what=img&group=c2p&show=type-h.3' style='border:0px; height:38px; width:126px'></a></center></td>";
			echo "</tr></table></fieldset>";
		}
		if ($mwbp_set['handy2pay'] == 1 && $microamount >= 49 && $microamount <= 500) { //499
			echo "<fieldset name='Pay4'>";
			echo "<legend><b>Handy2Pay</b></legend>";
			echo "<table cellpadding='0' cellspacing='0' class='tbl-border center'>";
			$sealedParams = "project=".$micropay['pay_f1']."&title=".$settings["sitename"]."&amount=".$microamount."&userid=".$userdata['user_id']."&system=handy2pay&id=".stripinput($_GET['points_id'])."";
  			$unsealedParams = "&account=".$micropay['pay_ben']."&bgcolor=000000";
 			$accessKey = $micropay['pay_pass'];
 			$seal = md5($sealedParams . $accessKey);     
 			$url ='https://billing.micropayment.de/handypay/event/?'.$sealedParams .'&seal='.$seal.$unsealedParams;
			echo "<tr><td class='tbl1' width='300px' style='font-weight:bold;'><center><a href='".$url."' target='_top' onclick='return popup(this.href);'><img src='http://www.micropayment.de/resources/?what=img&group=hp&show=type-h.3' style='border:0px; height:38px; width:126px'></a></center></td>";
			echo "</tr></table></fieldset>";
		}
		if ($mwbp_set['ebank2pay'] == 1 && $microamount >= 49 && $microamount <= 50000) { //50000
			echo "<fieldset name='Pay5'>";
			echo "<legend><b>ebank2pay</b></legend>";
			echo "<table cellpadding='0' cellspacing='0' class='tbl-border center'>";
			$sealedParams = "project=".$micropay['pay_f1']."&title=".$settings["sitename"]."&amount=".$microamount."&userid=".$userdata['user_id']."&system=ebank2pay&id=".stripinput($_GET['points_id'])."";
  			$unsealedParams = "&account=".$micropay['pay_ben']."&bgcolor=000000";
 			$accessKey = $micropay['pay_pass'];
 			$seal = md5($sealedParams . $accessKey);     
 			$url ='https://billing.micropayment.de/ebank2pay/event/?'.$sealedParams .'&seal='.$seal.$unsealedParams;
			echo "<tr><td class='tbl1' width='300px' style='font-weight:bold;'><center><a href='".$url."' target='_blank' onclick='return ebank2pay(this.href,'scrollbars=yes');'><img src='http://www.micropayment.de/resources/?what=img&group=eb2p&show=type-h.3' style='border:0px; height:38px; width:181px'></a></center></td>";
			echo "</tr></table></fieldset>";
		}
	}
echo "<br><span style='color: #ff6600;'><center>PayPal &amp; *2Pay Zahlungen werden Automatisch in wenigen Minuten gut geschrieben.<br>Die Bank &Uuml;berweisung kann ein paar Tage in anspruch nehmen bis zur Scores auszahlung!<br>Wenn die Scores gutgeschrieben wurden,  werden Sie per PN Benachrichtigt.</center></span>";
	closetable();
break;


case "bankdaten":
if (checkgroup($mwbp_set['bank_erlaubniss'])) {
	if ($mwbp_set['bankdaten'] == 1) {
	$pointsid = stripinput($_GET['points_id']);
	$dbbank = dbarray(dbquery("SELECT * FROM ".MW_BP_BANK.""));
	$dbstat = dbarray(dbquery("SELECT * FROM ".MW_BP_POINTS." WHERE points_id ='".$pointsid."'"));
	$bank = "".$locale['mwbp_a188'].$dbstat['points_pre'].$locale['mwbp-curs2'].$locale['mwbp_a189']."
			".$locale['mwbp_a190']."\n\n
			".$locale['mwbp_a191']."&nbsp;".$dbbank['bank_inh']."
			".$locale['mwbp_a192']."&nbsp;".$dbbank['bank_ktn']."
			".$locale['mwbp_a193']."&nbsp;".$dbbank['bank_blz']."
			".$locale['mwbp_a194']."&nbsp;".$dbbank['bank_bnk']."
			".$locale['mwbp_a195']."&nbsp;".$dbbank['bank_ibn']."
			".$locale['mwbp_a196']."&nbsp;".$dbbank['bank_bic']."";
	$result = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$userdata['user_id']."','1','".$locale['mwbp_a197']."','".$bank."','y','0','".time()."','0')");
	$result2 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('1','".$userdata['user_id']."','".$locale['mwbp_a198']."','".$userdata['user_name'].$locale['mwbp_a199']."','y','0','".time()."','0')");
	$result3 = dbquery("INSERT INTO ".MW_BP_STATUS." (user_id, points_anz, points_pre, methode, time, status_pay, status_poi, txn_id) VALUES('".$userdata['user_id']."','".$dbstat['points_anz']."','".$dbstat['points_pre']."','0','".time()."','1','1','0')");
	opentable("".$locale['mwbp_a200']."");
	echo "".$locale['mwbp_a201']."";
	closetable();
	}else redirect(BASEDIR."index.php");
}
break;

case "complete":

	if (!$fp) {
		// HTTP ERROR
	} else {
		fputs ($fp, $header . $req);
		while (!feof($fp)) {
			$res = fgets ($fp, 1024);
			if (strcmp ($res, "VERIFIED") == 0) {
				$check = dbresult(dbquery("SELECT txn_id FROM ".MW_BP_STATUS." WHERE txn_id='".stripinput($_POST['txn_id'])."'"));
				if (!$check) {
					$mes = "".$locale['mwbp_a202']."
					".$_POST['option_name1']."
					".$_POST['option_selection1']."
					".$_POST['payment_date']."
					".$_POST['mc_gross']."
					".$_POST['mc_currency']."
					".$_POST['item_name']."
					".$_POST['payment_status']."";
					$result = dbresult(dbquery("SELECT user_id FROM ".DB_USERS." WHERE user_name='".stripinput($_POST['option_selection1'])."'"));
					$result1 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('1','".$result."','".$locale['mwbp_a204']."','".$mes."','y','0','".time()."','0')");
					$result2 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES('".$result."','1','".$locale['mwbp_a204']."','".$locale['mwbp_a203'].$mwbp_set['points_name'].$locale['mwbp_a203a']."','y','0','".time()."','0')");
					$result3 = dbquery("INSERT INTO ".MW_BP_STATUS." (user_id, points_anz, points_pre, methode, time, status_pay, status_poi, txn_id) VALUES('".$result."','".stripinput($_POST['option_selection2'])."', '".stripinput($_POST['mc_gross'])."', '1', '".time()."', '0', '1','".stripinput($_POST['txn_id'])."')");
					opentable();
					echo "<center>".$locale['mwbp_a203'].$mwbp_set['points_name'].$locale['mwbp_a203a']."</center>";
					closetable();
				}else {
					redirect(BASEDIR."index.php");
				}
				//opentable("$res");
				//echo"<center>".$locale['mwbp_a203'].$mwbp_set['points_name'].$locale['mwbp_a203a']."</center>";
				//echo "";
				//foreach($_POST as $key => $value){
				//	echo $key." = ". $value."<br>";
				//}
				//closetable();
			} else if (strcmp ($res, "INVALID") == 0) {
				redirect(BASEDIR."index.php");
				//opentable("$res");
				//echo "The response from IPN was: <b>" .$res ."</b>";
				//closetable();
	  		}
		}
	fclose ($fp);
	}
break;

//DEE
case "bankerlaubniss":
	if ($mwbp_set['bankdaten'] == 1) {
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
	opentable("Zahlung erfolgt");
	echo "<center>".$locale['mwbp_a203'].$mwbp_set['points_name'].$locale['mwbp_a203a']."</center>";
	closetable();
break;
	
case "cancel_return":
	opentable();
	echo "<center>".$locale['mwbp_a205']."</center>";
	closetable();
break;

default:
	redirect(BASEDIR."index.php");
break;
}
echo '<script type="text/javascript">function popup (url) {fenster = window.open(url, "Popupfenster", "width=620,height=420,locationbar=no,resizable=no,");fenster.focus();return false;}</script>';
echo '<script type="text/javascript">function ebank2pay (url) {fenster = window.open(url, "Popupfenster", "width=620,height=580,locationbar=no,resizable=no,");fenster.focus();return false;}</script>';
echo "".mw_Copyright()."<br />";	
require_once THEMES."templates/footer.php";

?>