<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_buy_points_panel.php
| Author: Matze-W & DeeoNe & DeeoNe
| Site: http://www.deeone.de
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/
if (!defined("IN_FUSION")) { die("Access Denied"); }

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);
if (iMEMBER) {
// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_buy_points_panel/locale/German.php";
}


include INFUSIONS."mw_buy_points_panel/infusion_db.php";
$mwbp_set = dbarray(dbquery("SELECT * FROM ".MW_BP_SET." WHERE settings_id='1'"));

//openside($mwbp_set['points_name'].$locale['mwbp_a231']."<div style='float: right;'><a href='http://www.deeone.de' target='_blank' title='&copy; 2011 by Matze-W &amp; &copy; 2012 by DeeoNe'>&copy;</a></div>");
openside($mwbp_set['points_name'].$locale['mwbp_a231']."<div style='float: right;'>".(iADMIN ? "<a href='".INFUSIONS."mw_buy_points_panel/mw_buy_points_admin.php".$aidlink."' title='Scores kauf Admin'>A</a>" : "<a href='http://www.deeone.de' target='_blank' title='&copy; 2011 by Matze-W &amp; &copy; 2012 by DeeoNe'>&copy;</a>")."</div>");
	echo "<center><table cellpadding='0' cellspacing='0'>";
	echo "<tr>";
	echo "<td><img title='payscore' src='".INFUSIONS."mw_buy_points_panel/images/payscore.png' alt='payscore' /></td>";
	echo "</tr></table>";
	echo "<table cellpadding='0' cellspacing='0'><tr>";
	//echo "<td><a class='button' title='".$mwbp_set['points_name'].$locale['mwbp_a231']."' href='".INFUSIONS."mw_buy_points_panel/mw_buy_points.php'><strong>&nbsp; ".$mwbp_set['points_name'].$locale['mwbp_a231']." &nbsp;</strong></a></td>";
	echo "<td><form name='buy_points' method='post' action='".INFUSIONS."mw_buy_points_panel/mw_buy_points.php' target='_top'><input type='submit' name='buy_points' value='Scores kaufen' class='button' /></form></td>";
	echo "</tr></table></center>";

//DEE

	if($mwbp_set['points_display'] == "0") { }
	elseif (((iSUPERADMIN) && ($mwbp_set['points_display'] == "1")) || ((iADMIN) && ($mwbp_set['points_display'] == "2")) || ((iMEMBER) && ($mwbp_set['points_display'] == "3"))) {
		
			//echo "<hr width='90%'>";
			echo "<span class='small'>";
			echo"<table width='100%' border='0'>";		
			if(dbrows(dbquery("Select * FROM `".$db_prefix."mw_buy_points_status` WHERE `status_pay`='0'"))>0){
				echo"<tr><td colspan='3' align='center'><b>Aktuelle Scorek&auml;ufe</b></td></tr>";
				$anzahl = dbrows(dbquery("Select * FROM `".$db_prefix."mw_buy_points_status` WHERE `status_pay`='0'"));
				if($anzahl > 5){
					$min = ($anzahl - 5);
					$kauf = dbquery("SELECT * FROM `".$db_prefix."mw_buy_points_status`  WHERE `status_pay`='0' LIMIT ".$min.",".$anzahl." ");
				}
				else{
					$kauf = dbquery("select * FROM `".$db_prefix."mw_buy_points_status` WHERE `status_pay`='0'");
				}
				while($kaufSatz = dbarray($kauf)){
					$userd = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$kaufSatz['user_id']."'")); 
					echo"
					<tr>
					<td>".date("d.M. ",$kaufSatz['time'])."</td><td align='center'>".$userd."</td><td align='right'>".$kaufSatz['points_pre']." &euro;</td> 
					</tr>";
				}
			}
			echo"</table>";
			echo "</span>";
	}

//DEE

closeside();


	include INFUSIONS."mw_buy_points_panel/infusion_db.php";

	if (file_exists(INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php")) {
		include INFUSIONS."mw_buy_points_panel/locale/".$settings['locale'].".php";
	} else {
		include INFUSIONS."mw_buy_points_panel/locale/German.php";
	}

	$result = dbquery("SELECT * FROM ".MW_BP_STATUS." WHERE user_id='".$userdata['user_id']."' AND status_pay='0' AND status_poi='1'");

	if (dbrows($result) != 0) {
		$mwbp_status = dbarray($result);	
		$mwbp_set = dbarray(dbquery("SELECT * FROM ".MW_BP_SET." WHERE settings_id='1'"));
		$anzahl= (int) $mwbp_status['points_anz'];
		$userid= (int) $mwbp_status['user_id'];
		score_free("Punkte Gutschrift","GUTS",$anzahl,20,"P",0,$userid);
		//score_free("Aktion Gutschrift","AKGU",$anzahl,20,"P",0,$userid);	
		$result2 = dbquery("UPDATE ".MW_BP_STATUS." SET status_poi='0' WHERE status_id='".$mwbp_status['status_id']."'");
		$result3 = dbquery("INSERT INTO ".DB_MESSAGES." (message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder) VALUES ('".$mwbp_status['user_id']."','1','".$mwbp_set['points_name'].$locale['mwbp_a174']."','".$locale['mwbp_a175'].$mwbp_status['points_anz']." ".$mwbp_set['points_name'].$locale['mwbp_a176']."','y','0','".time()."','0')");
	}
}
?>