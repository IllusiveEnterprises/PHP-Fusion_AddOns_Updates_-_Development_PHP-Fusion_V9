<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2012 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_donate_panel.php
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
if (!defined("IN_FUSION")) { die("Access Denied"); }
if (iMEMBER) {

error_reporting(0);
//Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."mw_donate_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."mw_donate_panel/locale/German.php";
}
include INFUSIONS."mw_donate_panel/infusion_db.php";
$mwdp_set = dbarray(dbquery("SELECT * FROM ".MW_DP_SET." WHERE settings_id='1'"));

openside($locale['mwdp_p001']."<div style='float: right;'>".(iADMIN ? "<a href='".INFUSIONS."mw_donate_panel/mw_donate_admin.php".$aidlink."' title='Spenden Admin'>A</a>" : "<a href='http://www.deeone.de' target='_blank' title='&copy; 2011 by Matze-W &amp; &copy; 2017 by DeeoNe'>&copy;</a>")."</div>");
	echo "<center>";
	echo "<b>".$locale['mwdp_p002']."</b>";
	echo "<hr width='90%'>";
	echo "<form name='donatepanel' action='".INFUSIONS."mw_donate_panel/mw_donate_page.php' method='post'>\n";
	echo "".$locale['mwdp_p003']."&nbsp;<input type='text' name='donate' size='6' style='width: 50px;' class='textbox'>&nbsp;".$locale['mwdp_curs']."\n";
	echo "<br /><br><input input type='image' src='".INFUSIONS."mw_donate_panel/images/spendenbutton.gif' border='0' name='submit' alt='".$locale['mwdp_p001']."'></form>";
	echo "</center>";
//DEE		
	if($mwdp_set['points_display'] == "0") { }
	elseif (((iSUPERADMIN) && ($mwdp_set['points_display'] == "1")) || ((iADMIN) && ($mwdp_set['points_display'] == "2")) || ((iMEMBER) && ($mwdp_set['points_display'] == "3"))) {
		
		
			echo "<hr width='90%'>";
			echo"<table width='100%' border='0'>";		
			if(dbrows(dbquery("Select * FROM `".$db_prefix."mw_donate_list`"))>0){
				echo"<tr><td colspan='3' align='center'><b>Die neusten Spenden</b></td></tr>";
				$anzahl = dbrows(dbquery("Select * FROM `".$db_prefix."mw_donate_list`"));
				if($anzahl > 5){
					$min = ($anzahl - 5);
					$spenden = dbquery("SELECT * FROM `".$db_prefix."mw_donate_list` LIMIT ".$min.",".$anzahl." ");
				}
				else{
					$spenden = dbquery("select * FROM `".$db_prefix."mw_donate_list` WHERE `status_spende`='0'");
				}
				while($spendenSatz = dbarray($spenden)){
					$userd = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$spendenSatz['user_id']."'")); 
					echo"
					<tr>
					<td>".date("d.M. ",$spendenSatz['time'])."</td><td align='center'>".$userd."</td><td align='right'>".$spendenSatz['spende']." &euro;</td> 
					</tr>";
				}
			}
			echo"</table>";
		
	}	
//DEE


closeside();
}

?>