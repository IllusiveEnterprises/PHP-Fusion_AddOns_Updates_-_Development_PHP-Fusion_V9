<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: mw_premium_panel.php
| Version: 1.0.0
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
//include_once "../../maincore.php";
include INFUSIONS."mw_premium_panel/infusion_db.php";
// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include_once INFUSIONS."mw_premium_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include_once INFUSIONS."mw_premium_panel/locale/German.php";
}
$mwpset = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM_SET." WHERE set_id='1'"));
// Abgelaufenen Status setzen
$result = dbquery("SELECT * FROM ".MW_PREMIUM." WHERE time_off < ".time()." AND status='1'"); 
if (dbrows($result) != 0) {
	while ($data = dbarray($result)) {
		$result2 = dbquery("UPDATE ".MW_PREMIUM." SET status='0' WHERE user_id=".$data['user_id']."");
		$user_groupsold = dbresult(dbquery("SELECT user_groups FROM ".DB_USERS." WHERE user_id='".$data['user_id']."'"),0);	
		$user_groups = preg_replace(array("(^\.{$mwpset['set_group']}$)","(\.{$mwpset['set_group']}\.)","(\.{$mwpset['set_group']}$)"), array("",".",""), $user_groupsold);
		$result3 = dbquery("UPDATE ".DB_USERS." SET user_groups='".$user_groups."' WHERE user_id='".$data['user_id']."'");
	}
}
// Status Ende
$aktiv = dbarray(dbquery("SELECT * FROM ".MW_PREMIUM." WHERE user_id=".$userdata['user_id']."")); 
openside('Premium');
echo "<table width='100%' class='spacer' cellpadding='0' cellspacing='0'>";
if ($aktiv['status'] =='1') {
	echo "<tr><td align='center'><b>Du bist bis zum <br /><font color='#00FF00'><img style='vertical-align:middle;' alt='Datum' title='Datum' src=".INFUSIONS."mw_premium_panel/images/datum.png> ".showdate("%d.%m.%Y<br /><img style='vertical-align:middle;' ' alt='Uhrzeit' title='Uhrzeit' src=".INFUSIONS."mw_premium_panel/images/time.png> %H:%M:%S &nbsp;&nbsp;&nbsp;", $aktiv['time_off'])."</font><br />Premium Mitglied</b><br /><br /><a class='button' title='Verl&auml;ngern' href='".INFUSIONS."mw_premium_panel/mw_premium.php'>Premium verl&auml;ngern</a></td></tr>";
} elseif ($aktiv['status'] =='0') {
	echo "<tr><td align='center'><font color='red'><b>Dein Premium Account<br />ist abgelaufen</b></font><br /><br /><a class='button' title='Premium aktivieren' href='".INFUSIONS."mw_premium_panel/mw_premium.php'>Premium aktivieren</a></td></font></tr>";
} elseif ($aktiv['status'] =='') {
	echo "<tr><td align='center'><a href='".INFUSIONS."mw_premium_panel/mw_premium.php'><font color='#2992C0'><b>Jetzt Premium-Mitglied werden!</b></font></a></td></tr>";
}
echo"</table>";
closeside();
?>