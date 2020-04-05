<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
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
include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."MF-Premium-Scores_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}
$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));
$premiumsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$userdata['user_id'].""));



	if ($mfpssettings['prem_s_zeit']=="86400") {
	$prem_s = "1 Tag";
	} elseif ($mfpssettings['prem_s_zeit']=="172800") {
	$prem_s = "2 Tage";
	} elseif ($mfpssettings['prem_s_zeit']=="259200") {
	$prem_s = "3 Tage";
	} elseif ($mfpssettings['prem_s_zeit']=="345600") {
	$prem_s = "4 Tage";
	} elseif ($mfpssettings['prem_s_zeit']=="432000") {
	$prem_s = "5 Tage";
	} elseif ($mfpssettings['prem_s_zeit']=="518400") {
	$prem_s = "6 Tage";
	} elseif ($mfpssettings['prem_s_zeit']=="604800") {
	$prem_s = "7 Tage";				
	}

	if ($mfpssettings['prem_m_zeit']=="604800") {
	$prem_m = "7 Tage";
	} elseif ($mfpssettings['prem_m_zeit']=="1209600") {
	$prem_m = "14 Tage";
	} elseif ($mfpssettings['prem_m_zeit']=="1814400") {
	$prem_m = "21 Tage";
	} elseif ($mfpssettings['prem_m_zeit']=="2592000") {
	$prem_m = "30 Tage";
  }
  
  	if ($mfpssettings['prem_l_zeit']=="2592000") {
	$prem_l = "30 Tage";
	} elseif ($mfpssettings['prem_l_zeit']=="5184000") {
	$prem_l = "60 Tage";
	} elseif ($mfpssettings['prem_l_zeit']=="7776000") {
	$prem_l = "90 Tage";
	} elseif ($mfpssettings['prem_l_zeit']=="10368000") {
	$prem_l = "120 Tage";
  }
  
opentable("Premium-Mitgliedschaft<div style='float: right;'><a href='http://www.mf-community.net' target='_blank' title='&copy; 2011 Comet1986 & DeeoNe'><span class='small'>&copy;</span></a></div>");
echo '
<p style="text-align: center;"><strong>Premium Mitglied werden<br /><img style="margin: 5px;" title="Images: premium.png" src="images/premium.png" alt="Images: premium.png" width="32" height="32" /><br />W&auml;hle dein gew&uuml;nschtes Premium Paket:</strong></p>
<table border="0" cellspacing="1" cellpadding="5" align="center">
<thead> 
<tr class="tbl2">
<td style="text-align: center;"><strong>PREM - S</strong><br /></td>
<td style="text-align: center;"><strong>PREM - M</strong><br /></td>
<td style="text-align: center;"><strong>PREM - L</strong><br /></td>
</tr class="tbl2">
<tr class="tbl2">
<td style="text-align: center;"><strong>Premium '.$prem_s.'<br /></strong><font color="red">(kosten: '.$mfpssettings['prem_s_preis'].' Scores)</font></td>
<td style="text-align: center;"><strong>Premium '.$prem_m.'<br /></strong><font color="red">(kosten: '.$mfpssettings['prem_m_preis'].' Scores)</font></td>
<td style="text-align: center;"><strong>Premium '.$prem_l.'<br /></strong><font color="red">(kosten: '.$mfpssettings['prem_l_preis'].' Scores)</font></td>
</tr>
<tr class="tbl2">';
if (defined("SCORESYSTEM"))  {
if (score_account_stand() >=$mfpssettings['prem_s_preis']) {
echo '
<td style="text-align: center;"><form name="PREM_S" method="post" action="premS.php" target="_top"><input type="submit" name="PREM_S" value="Premium Aktivieren" class="button" /></form></td>
';
} else {
echo '<td style="text-align: center;"><strong><span style="color: #ff0000;">zu wenig Scores</span></strong></td>';
}
if (score_account_stand() >=$mfpssettings['prem_m_preis']) {
echo '
<td style="text-align: center;"><form name="PREM_M" method="post" action="premM.php" target="_top"><input type="submit" name="PREM_M" value="Premium Aktivieren" class="button" /></form></td>
';
} else {
echo '<td style="text-align: center;"><strong><span style="color: #ff0000;">zu wenig Scores</span></strong></td>';
}
if (score_account_stand() >=$mfpssettings['prem_l_preis']) {
echo '
<td style="text-align: center;"><form name="PREM_L" method="post" action="premL.php" target="_top"><input type="submit" name="PREM_L" value="Premium Aktivieren" class="button" /></form></td>
</tr>';
} else {
echo '<td style="text-align: center;"><strong><span style="color: #ff0000;">zu wenig Scores</span></strong></td>';
}
}
echo '
</thead>
</table>';

echo "<p style='text-align: center;'>Der Premium Account kann jederzeit verl&auml;ngert werden, mit einem Kauf eines weiteren Premium Pakets.</p>
<p style='text-align: center;'><u><strong>Als Premium hast du folgende Vorteile:</strong></u><br />".nl2br(parseubb($mfpssettings['prem_vorteil']))."<br /></p>
";

closetable();

require_once THEMES."templates/footer.php";
?>