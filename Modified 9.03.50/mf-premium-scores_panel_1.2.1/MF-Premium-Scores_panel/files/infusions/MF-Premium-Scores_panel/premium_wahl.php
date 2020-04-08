<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
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
require_once THEMES."templates/header.php";
include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/locale/".fusion_get_settings('locale').".php")) {
    // Load the locale file matching the current site locale setting.
    include INFUSIONS."MF-Premium-Scores_panel/locale/".fusion_get_settings('locale').".php";
} else {
    // Load the infusion's default locale file.
    include INFUSIONS."MF-Premium-Scores_panel/locale/German.php";
}

$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));
$premiumsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$userdata['user_id'].""));



	if ($mfpssettings['prem_s_zeit']=="86400") {
	$prem_s = "1 ".$locale['MFP_admin_025g'];
	} elseif ($mfpssettings['prem_s_zeit']=="172800") {
	$prem_s = "2 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_s_zeit']=="259200") {
	$prem_s = "3 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_s_zeit']=="345600") {
	$prem_s = "4 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_s_zeit']=="432000") {
	$prem_s = "5 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_s_zeit']=="518400") {
	$prem_s = "6 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_s_zeit']=="604800") {
	$prem_s = "7 ".$locale['MFP_admin_025a'];
	}

	if ($mfpssettings['prem_m_zeit']=="604800") {
	$prem_m = "7 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_m_zeit']=="1209600") {
	$prem_m = "14 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_m_zeit']=="1814400") {
	$prem_m = "21 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_m_zeit']=="2592000") {
	$prem_m = "30 ".$locale['MFP_admin_025a'];
  }
  
  	if ($mfpssettings['prem_l_zeit']=="2592000") {
	$prem_l = "30 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_l_zeit']=="5184000") {
	$prem_l = "60 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_l_zeit']=="7776000") {
	$prem_l = "90 ".$locale['MFP_admin_025a'];
	} elseif ($mfpssettings['prem_l_zeit']=="10368000") {
	$prem_l = "120 ".$locale['MFP_admin_025a'];
  }
  
opentable($locale['MFPS_panel_007']."<div style='float: right;'><a href='http://www.mf-community.net' target='_blank' title='&copy; 2011 Comet1986 & DeeoNe'><span class='small'>&copy;</span></a></div>");
echo "
<p style= 'text-align: center;'><strong>".$locale['MFPS_panel_009']."<br /><img style='margin: 5px;' title='Images: premium.png' src='images/premium.png' alt='Images: premium.png' width='32' height='32' /><br />".$locale['MFPS_panel_010']."</strong></p>
<table border='0' cellspacing='1' cellpadding='5' align='center'>
<thead> 
<tr class='tbl2'>
<td style='text-align: center;'><strong>".$locale['MFPS_panel_011']."</strong><br /></td>
<td style='text-align: center;'><strong>".$locale['MFPS_panel_012']."</strong><br /></td>
<td style='text-align: center;'><strong>".$locale['MFPS_panel_013']."</strong><br /></td>
</tr class='tbl2'>
<tr class='tbl2'>
<td style='text-align: center;'><strong>".$locale['MFPS_panel_014'].$prem_s."<br /></strong><font color='red'>(".$locale['MFPS_panel_015'].$mfpssettings['prem_s_preis'].$locale['MFPS_panel_016'].")</font></td>
<td style='text-align: center;'><strong>".$locale['MFPS_panel_014'].$prem_m."<br /></strong><font color='red'>(".$locale['MFPS_panel_015'].$mfpssettings['prem_m_preis'].$locale['MFPS_panel_016'].")</font></td>
<td style='text-align: center;'><strong>".$locale['MFPS_panel_014'].$prem_l."<br /></strong><font color='red'>(".$locale['MFPS_panel_015'].$mfpssettings['prem_l_preis'].$locale['MFPS_panel_016'].")</font></td>
</tr>
<tr class='tbl2'>";
if (defined("SCORESYSTEM"))  {
if (score_account_stand() >=$mfpssettings['prem_s_preis']) {
echo "
<td style='text-align: center;'><form name='PREM_S' method='post' action='premS.php' target='_top'><input type='submit' name='PREM_S' value='".$locale['MFPS_panel_008']."' class='button' /></form></td>
";
} else {
echo "<td style='text-align: center;'><strong><span style='color: #ff0000;'>".$locale['MFPS_panel_017']."</span></strong></td>";
}
if (score_account_stand() >=$mfpssettings['prem_m_preis']) {
echo "
<td style='text-align: center;'><form name='PREM_M' method='post' action='premM.php' target='_top'><input type='submit' name='PREM_M' value='".$locale['MFPS_panel_008']."' class='button' /></form></td>
";
} else {
echo "<td style='text-align: center;'><strong><span style='color: #ff0000;'>".$locale['MFPS_panel_017']."</span></strong></td>";
}
if (score_account_stand() >=$mfpssettings['prem_l_preis']) {
echo "
<td style='text-align: center;'><form name='PREM_L' method='post' action='premL.php' target='_top'><input type='submit' name='PREM_L' value='".$locale['MFPS_panel_008']."' class='button' /></form></td>
</tr>";
} else {
echo "<td style='text-align: center;'><strong><span style='color: #ff0000;'>".$locale['MFPS_panel_017']."</span></strong></td>";
}
}
echo "
</thead>
</table>";

echo "<p style='text-align: center;'>".$locale['MFPS_panel_018']."</p>
<p style='text-align: center;'><u><strong>".$locale['MFPS_panel_019']."</strong></u><br />".nl2br(parseubb($mfpssettings['prem_vorteil']))."<br /></p>
";

closetable();

require_once THEMES."templates/footer.php";
?>