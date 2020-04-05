<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (c) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_scoresystem_include.php
| Author: Ralf Thieme
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

if ($profile_method == "input") {

} elseif ($profile_method == "display") {
	if (function_exists('score_account_stand')) {
		echo "<tr>\n";
		echo "<td width='1%' class='tbl1' style='white-space:nowrap'>".$locale['uf_score_1']."</td>\n";
		echo "<td align='right' class='tbl1'>".score_account_stand($user_data['user_id'])."</td>\n";
		echo "</tr>\n";
	}
} elseif ($profile_method == "validate_insert") {

} elseif ($profile_method == "validate_update") {

}
?>
