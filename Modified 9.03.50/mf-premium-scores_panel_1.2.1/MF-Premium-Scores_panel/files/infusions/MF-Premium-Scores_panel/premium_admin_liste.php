<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: premium_wahl.php
| Author: Comet 1986 & DeeoNe
| Contact: http://www.mf-community.net
| Adapted to php-fusion-9 by Douwe Yntema
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

if (!checkrights("MFPS") || !defined("iAUTH")) { redirect("../index.php"); }

// Turn off all error reporting
error_reporting(0);
// Report all PHP errors (see changelog)
//error_reporting(E_ALL);
//error_reporting(E_ALL & ~E_NOTICE);

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}

include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php"; 
opentable($locale ['PALP_admin01']);
if(iADMIN) { 
	$result = dbquery("SELECT * FROM ".DB_mfp_scores." WHERE status='aktiv' ORDER BY bis DESC");
		echo "<table class='tbl-border center' cellspacing='1' cellpadding='1' width='40%'>";
		echo "<tr><td class='tbl2'><b><center>".$locale ['PALP_admin02']."</b></center></td>";
		echo "<td class='tbl2'><b><center>".$locale ['PALP_admin03']."</b></center></td></tr>";
		while($data = dbarray($result)) {
	$user = dbresult(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id='".$data['user_id']."'")); 
			echo "<tr><td class='tbl1'><center>".$user."</center></td>";
			echo "<td class='tbl1'><center>".strftime('%d.%m.%Y - %H:%M Uhr', $data['bis'])."</center></td></tr>";
		}
echo "</table>";

//Scoreajnzeige
echo "<br />";
				$result2 = dbquery("SELECT tr.*, tu.user_id, tu.user_name
				FROM ".DB_SCORE_TRANSFER." tr
				INNER JOIN ".DB_USERS." tu ON tr.tra_user_id=tu.user_id
				WHERE tr.tra_aktion='PREM-' ORDER BY tr.tra_id DESC LIMIT 0,20");
				if (dbrows($result2)) {
					echo "<center><table cellpadding='1' cellspacing='1' border='0' width='70%' class='tbl-border'>\n";
					echo "<tr class='tbl2'><td colspan=4><center><b>".$locale['PALP_admin04']."</b></center></td></tr>";
					while ($data = dbarray($result2)) {
						echo "<tr>\n";
						//echo "<td width='20%' class='tbl1'>".$data['tra_aktion']."-".$data['tra_user_id']."-".$data['tra_id']."</td>\n";
						echo "<td width='20%' class='tbl1'><a href='".BASEDIR."profile.php?lookup=".$data['user_id']."' target='_self' title='".$data['user_name']."'>".$data['user_name']."</a></td>\n";
						echo "<td width='20%' class='tbl1'>".$data['tra_titel']."</td>\n";
						echo "<td width='10%' align='right' class='".score_transfer_color($data['tra_typ'])."'>".$data['tra_score']."</td>\n";
						echo "<td width='20%' class='tbl1'>".showdate($settings['shortdate'], $data['tra_time'])."</td>\n";
						echo "</tr>\n";
					}
					echo "</table></center>\n";
				} else {
					echo "".$locale['PALP_admin05']."";
				}
//Scoreanzeige
}
closetable();
require_once THEMES."templates/footer.php";
?>