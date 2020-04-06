<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_coupon_panel.php
| Author: DeeoNe
| Adapted to php-fusion V9 by Douwe Yntema
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
include INFUSIONS."D1_coupon_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_coupon_panel/locale/".fusion_get_settings('locale').".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_coupon_panel/locale/".fusion_get_settings('locale').".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_coupon_panel/locale/German.php";
}

require_once INFUSIONS."D1_coupon_panel/includes/functions.php";

if (!function_exists("d1couponsec2")) {
} elseif (d1couponSet("inf_name") == "" || d1couponSet("inf_name") != md5("D1 Coupon") || d1couponSet("site_url") == "" || d1couponSet("site_url") != md5("D1 Coupon".$settings['siteurl'])) {
} else {

if (iMEMBER) {
opensidex($locale['D1CP_panel_001']);
echo '<center>';

echo "<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td style='font-weight:bold; text-align:center;'>
<center><a alt='Coupons' title='Coupons' href='".INFUSIONS."D1_coupon_panel/D1_coupon.php'><img src='".INFUSIONS."D1_coupon_panel/images/Barcodep.png'/></a></center>
</td>
</tr>";

	echo '<form id="form_couponp" method="post" action="'.INFUSIONS.'D1_coupon_panel/D1_coupon.php" target="_top">';
	echo "<tr><td style='font-weight:bold; text-align:center;'>";
	echo'<center><b>'.$locale['D1CP_panel_002'].'</b><br><input type="text" id="couponp" name="coupon" class="textbox" style="width:150px" autocomplete="off" onKeyUp="javascript:this.value=this.value.toUpperCase()" maxlength="15"><br><input type="submit" name="coupon_send"  class="button" value="'.$locale['D1CP_panel_003'].'"></center></form>';
	echo "</td></tr></table>";

echo '</center>';
closesidex();
}
}

echo "<script type='text/javascript'>
$(function() {
$('#form_couponp').submit(function() {
    if ($('#couponp').val() == '') {
        alert('".$locale['D1CP_panel_004']."');
        $('#couponp').focus();
        return false;
    }
});
});
</script>";

?>