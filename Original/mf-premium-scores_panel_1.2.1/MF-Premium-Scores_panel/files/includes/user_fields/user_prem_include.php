<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_prem_include.php
| Author: DeeoNe
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

include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

if ($profile_method == "input") {
} elseif ($profile_method == "display") {
		echo "<tr>\n";
		echo "<td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['uf_prem']."</td>\n";
		echo "<td align='right' class='tbl1'>";
//prem
$aktiv = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id='".$user_data['user_id']."'"));
if ($aktiv['status'] =='aktiv') {
echo "<img style='vertical-align: middle;' src='".IMAGES."prem.png' alt='Premium' title='Premium' /> bis <b>".showdate("longdate", $aktiv['bis'])."</b>";
} else {
echo "".$locale['uf_prem_002']."";
}
//prem


		echo "</td>\n</tr>\n";
}
?>