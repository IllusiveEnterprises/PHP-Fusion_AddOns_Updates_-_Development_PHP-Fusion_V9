<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_time_bonus_rank.php
| Author: DeeoNe
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

if (!defined("IN_FUSION")) { die("Access Denied"); }

include INFUSIONS."D1_time_bonus_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_time_bonus_panel/locale/".fusion_get_settings('locale').".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_time_bonus_panel/locale/".fusion_get_settings('locale').".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_time_bonus_panel/locale/German.php";
}

require_once INFUSIONS."D1_time_bonus_panel/includes/functions.php";
$d1tbsettings = dbarray(dbquery("SELECT * FROM ".DB_d1_tbconf.""));

if (d1timebonusSet("inf_name") == "" || d1timebonusSet("inf_name") != md5("D1 Time Bonus") || d1timebonusSet("site_url") == "" || d1timebonusSet("site_url") != md5("D1 Time Bonus".$settings['siteurl'])) {
	redirect(BASEDIR."index.php");
}


$items_per_page = 10;

if (!isset($_GET['rowstart']) || !isnum($_GET['rowstart'])) {
	$_GET['rowstart'] = 0;
}

$rows = dbcount("(user_punkte)", DB_d1_tbuser);

$topler = $_GET['rowstart']+10;


opentable($locale['D1TB_side_001']);

//$tbusers = dbarray(dbquery("SELECT * FROM ".DB_d1_tbuser." WHERE user_id='".$userdata['user_id']."'"));

echo "<center><b><big><u>".$locale['D1TB_side_002']." $topler ".$locale['D1TB_side_003']."</u></big></b><br><img border=0 src=".INFUSIONS."D1_time_bonus_panel/images/trophy.png></center>";

$result = dbquery("SELECT * FROM ".DB_d1_tbuser." ORDER BY ".$d1tbsettings['tb_punkte_list']." DESC LIMIT ".$_GET['rowstart'].",".$items_per_page."");
$i = $_GET['rowstart'];
	echo "<table class='tbl-border center' cellspacing='1' cellpadding='1' width='50%'>";
	echo "<tr><td class='tbl2' width='5%'><b><center>".$locale['D1TB_side_004']."</b></center></td>";
	echo "<td class='tbl2' width='65%'><b><center>".$locale['D1TB_side_005']."</b></center></td>";
		echo "<td class='tbl2' width='10%'><center><b>".$locale['D1TB_side_008']."</b></center></td>";
		echo "<td class='tbl2' width='10%'><center><b>".$locale['D1TB_side_007']."</b></center></td>";
		echo "<td class='tbl2' width='10%'><center><b>".$locale['D1TB_side_006']."</b></center></td></tr>";
	while($tbusers = dbarray($result)) {
			$i++;
			if ($i == 1) {
				$tbplace = "<img src='".INFUSIONS."D1_time_bonus_panel/images/gold.png' alt='1.' />";
			} elseif ($i == 2) {
				$tbplace = "<img src='".INFUSIONS."D1_time_bonus_panel/images/silber.png' alt='2.' />";
			} elseif ($i == 3) {
				$tbplace = "<img src='".INFUSIONS."D1_time_bonus_panel/images/bronze.png' alt='3.' />";
			} else {
				$tbplace = $i.".";
			}
			echo "<tr><td class='tbl1'><center>".$tbplace."</center></td>";

	if ($d1tbsettings['tb_punkte_list'] == "user_punkte2") { $tb2 = "tbl2"; } else { $tb2 = "tbl1"; }
	if ($d1tbsettings['tb_punkte_list'] == "user_punkte3") { $tb3 = "tbl2"; } else { $tb3 = "tbl1"; }
	if ($d1tbsettings['tb_punkte_list'] == "user_punkte") { $tb0 = "tbl2"; } else { $tb0 = "tbl1"; }

			echo "<td class='tbl1'><center>".$tbusers['user_name']."</center></td>";
			echo "<td class='".$tb3."'><center>".$tbusers['user_punkte3']."</center></td>";
			echo "<td class='".$tb2."'><center>".$tbusers['user_punkte2']."</center></td>";
			echo "<td class='".$tb0."'><center>".$tbusers['user_punkte']."</center></td></tr>";
		}
		if ($rows > $items_per_page) {
			echo "<tr><td class='tbl2' style='text-align:center;' colspan='5'>".makepagenav($_GET['rowstart'], $items_per_page, $rows, 3)."</td></tr>";
		}
echo "</table>";


echo "<div align='right'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1TB_title']." ".$locale['D1TB_version']." &copy; 2013 DeeoNe'><small>&copy; DeeoNe</small></a></div>";
closetable();
if (function_exists("d1timebonussec2")) {
	d1timebonussec2();
} else {	
redirect(BASEDIR."index.php");
}
	
require_once THEMES."templates/footer.php";
?>