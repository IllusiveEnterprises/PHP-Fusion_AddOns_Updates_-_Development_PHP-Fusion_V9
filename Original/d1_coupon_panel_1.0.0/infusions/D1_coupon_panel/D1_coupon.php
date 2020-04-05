<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 20011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_coupons.php
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
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
include INFUSIONS."D1_coupon_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_coupon_panel/locale/German.php";
}

require_once INFUSIONS."D1_coupon_panel/includes/functions.php";

if (d1couponSet("inf_name") == "" || d1couponSet("inf_name") != md5("D1 Coupon") || d1couponSet("site_url") == "" || d1couponSet("site_url") != md5("D1 Coupon".$settings['siteurl'])) {
	redirect(BASEDIR."index.php");
}

$cpuser = dbarray(dbquery("SELECT * FROM ".DB_D1CP_user." WHERE user_id='".$userdata['user_id']."'"));
$d1cpsettings = dbarray(dbquery("SELECT * FROM ".DB_D1CP_conf.""));

if(iMEMBER) {
opentable($locale['D1CP_seite_001']);

if(isset($_POST["coupon_send"])) {
$d1cpcoupons = dbarray(dbquery("SELECT * FROM ".DB_D1CP." WHERE coupon='".$_POST["coupon"]."'"));
$d1cpusers = dbarray(dbquery("SELECT * FROM ".DB_D1CP_user." WHERE coupon = '".$_POST["coupon"]."' AND user_id = '".$userdata["user_id"]."'"));

if ($d1cpcoupons) {
if ($d1cpcoupons["timestart"] < time()) {
if (time() < $d1cpcoupons["timeend"]) {
if (!$d1cpusers) {

///////////////////OK
if ($d1cpcoupons["sonstiges"] == '1') {
echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_002']."</center></td></tr></table></center><br></div>";
echo "<div class='success2' style='color:yellow;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ffff00; border-width: 1px; border-style: dashed; background-color: #555500;' width='500px' align='center'><tr><td><center><img title='Scores' style='vertical-align: middle;' src='".INFUSIONS."D1_coupon_panel/images/scores.png'/> ".$locale['D1CP_seite_003']." <b>".$d1cpcoupons['scores']." ".$d1cpsettings['coupon_scores']."</b> ".$locale['D1CP_seite_004']." <img title='Scores' style='vertical-align: middle;' src='".INFUSIONS."D1_coupon_panel/images/scores.png'/></center></td></tr></table></center><br></div>";
$result = dbquery("INSERT INTO ".DB_D1CP_user." (user_id, user_name, scores, time, coupon, sonstiges) VALUES ('".$userdata["user_id"]."', '".$userdata["user_name"]."', '".$d1cpcoupons["scores"]."', '".time()."', '".$_POST["coupon"]."', '".$d1cpcoupons["sonstiges"]."')");
score_free("".$_POST["coupon"]."", "D1CP", "".$d1cpcoupons["scores"]."", 99, "P", 0, 0);
}

if ($d1cpcoupons["sonstiges"] == '2') {
echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_005']."</center></td></tr></table></center><br></div>";
echo "<div class='success2' style='color:yellow;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ffff00; border-width: 1px; border-style: dashed; background-color: #555500;' width='500px' align='center'><tr><td><center><img title='Premium' style='vertical-align: middle;' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/> ".$locale['D1CP_seite_006']." <b>".$d1cpcoupons["scores"]." ".$locale['D1CP_seite_007']."</b> ".$locale['D1CP_seite_008']." <img title='Premium' style='vertical-align: middle;' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/></center></td></tr></table></center><br></div>";
$result = dbquery("INSERT INTO ".DB_D1CP_user." (user_id, user_name, scores, time, coupon, sonstiges) VALUES ('".$userdata["user_id"]."', '".$userdata["user_name"]."', '".$d1cpcoupons["scores"]."', '".time()."', '".$_POST["coupon"]."', '".$d1cpcoupons["sonstiges"]."')");
//
$premiumsettings = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."mfp_scores WHERE user_id=".$userdata['user_id'].""));
$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."mfp_scores_conf"));
$cpend = $d1cpcoupons["scores"] * 3600;
if (($premiumsettings['status'] =='inaktiv') || ($premiumsettings['status'] =='')) {
$result = dbquery("INSERT INTO ".DB_PREFIX."mfp_scores SET user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis='".(time() + $cpend)."' ON DUPLICATE KEY UPDATE user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis='".(time() + $cpend)."'");
$usercp_id = $userdata['user_id'];
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($usercp_id).";");
}
if ($premiumsettings['status'] =='aktiv') {
$result = dbquery("INSERT INTO ".DB_PREFIX."mfp_scores SET user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis='".(time() + $cpend)."' ON DUPLICATE KEY UPDATE user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis=bis+".$cpend."");
$usercp_id = $userdata['user_id'];
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($usercp_id).";");
}
//
}

if ($d1cpcoupons["sonstiges"] == '3') {
echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_009']."</center></td></tr></table></center><br></div>";
echo "<div class='success2' style='color:yellow;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ffff00; border-width: 1px; border-style: dashed; background-color: #555500;' width='500px' align='center'><tr><td><center><img style='vertical-align: middle;' title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/> ".$locale['D1CP_seite_010']." <b>".$d1cpcoupons["scores"]." ".$locale['D1CP_seite_011']."</b> ".$locale['D1CP_seite_012']." <img title='Premium' style='vertical-align: middle;' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/></center></td></tr></table></center><br></div>";
$result = dbquery("INSERT INTO ".DB_D1CP_user." (user_id, user_name, scores, time, coupon, sonstiges) VALUES ('".$userdata["user_id"]."', '".$userdata["user_name"]."', '".$d1cpcoupons["scores"]."', '".time()."', '".$_POST["coupon"]."', '".$d1cpcoupons["sonstiges"]."')");
//
$premiumsettings = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."mfp_scores WHERE user_id=".$userdata['user_id'].""));
$mfpssettings = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."mfp_scores_conf"));
$cpend = $d1cpcoupons["scores"] * 86400;
if (($premiumsettings['status'] =='inaktiv') || ($premiumsettings['status'] =='')) {
$result = dbquery("INSERT INTO ".DB_PREFIX."mfp_scores SET user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis='".(time() + $cpend)."' ON DUPLICATE KEY UPDATE user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis='".(time() + $cpend)."'");
$usercp_id = $userdata['user_id'];
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($usercp_id).";");
}
if (($premiumsettings['status'] =='aktiv') || ($premiumsettings['status'] =='')) {
$result = dbquery("INSERT INTO ".DB_PREFIX."mfp_scores SET user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis='".(time() + $cpend)."' ON DUPLICATE KEY UPDATE user_id='".$userdata['user_id']."', status='aktiv', seit='".time()."', bis=bis+".$cpend."");
$usercp_id = $userdata['user_id'];
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$mfpssettings['prem_gruppe']."", "", $userdata['user_groups']).".".$mfpssettings['prem_gruppe']."' WHERE  `user_id` = ".mysql_real_escape_string($usercp_id).";");
}
//
}
//////////////////OK

} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_013']."</center></td></tr></table></center><br></div>";
}
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_014']."</center></td></tr></table></center><br></div>";
if ($d1cpsettings["coupon_errinfo"] == '1') {
echo "<div class='success2' style='color:orange;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ffa500; border-width: 1px; border-style: dashed; background-color: #593a00;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_015']." ".date("d.m.Y H:i",$d1cpcoupons['timestart'])." ".$locale['D1CP_seite_016']." ".date("d.m.Y H:i",$d1cpcoupons['timeend'])."</center></td></tr></table></center><br></div>";
}
}
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_017']."</center></td></tr></table></center><br></div>";
if ($d1cpsettings["coupon_errinfo"] == '1') {
echo "<div class='success2' style='color:orange;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ffa500; border-width: 1px; border-style: dashed; background-color: #593a00;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_018']." ".date("d.m.Y H:i",$d1cpcoupons['timestart'])." ".$locale['D1CP_seite_019']." ".date("d.m.Y H:i",$d1cpcoupons['timeend'])."</center></td></tr></table></center><br></div>";
}
}
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_seite_020']."</center></td></tr></table></center><br></div>";
}
}

echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='500px'>
<tr>
<td class='tbl2' colspan='2' style='font-weight:bold; text-align:center;'>
<center><span style='font-size: small;'>".$locale['D1CP_seite_021']."</span></center>
</td>
</tr>
<tr>
<td class='tbl1' colspan='2' style='font-weight:bold; text-align:center;'>
<center><img src='".INFUSIONS."D1_coupon_panel/images/Barcode.png'/></center>
</td>
</tr>";

echo '<form id="form_coupon" action="'.FUSION_SELF.'" method="post">';
		echo "<tr>
			<td class='tbl2' colspan='2' style='font-weight:bold; text-align:center; font-size:bigger;'>";

echo'<center><b>'.$locale['D1CP_seite_022'].'</b><br><input type="text" id="coupon" name="coupon" class="textbox" style="width:150px" autocomplete="off" onKeyUp="javascript:this.value=this.value.toUpperCase()" maxlength="15"><br><input type="submit" name="coupon_send"  class="button" value="'.$locale['D1CP_seite_023'].'"></center></form>';
			echo "</td>
		</tr></table>";
echo "<br>";
///////////////////////////////////////////////////
$result1 = dbquery("SELECT * FROM ".DB_D1CP_user." WHERE user_id = '".$userdata["user_id"]."'"); 
$num_rows1 = mysql_num_rows($result1);

$cpresult = dbquery("SELECT * FROM ".DB_D1CP_user." WHERE user_id = '".$userdata["user_id"]."' ORDER BY time DESC LIMIT 0,10");

echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='500px'>";
echo "<tr>";
echo "<td class='tbl2' colspan='6' style='text-align:center;'>";
echo "<center><b>".$locale['D1CP_seite_024']."</b></center>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='tbl2' style='text-align:center;width:5%;'>".$locale['D1CP_seite_025']."</td>";
echo "<td class='tbl2' style='text-align:center;width:10%;'>".$locale['D1CP_seite_026']."</td>";
echo "<td class='tbl2' style='text-align:center;width:10%;'>".$locale['D1CP_seite_027']."</td>";
echo "<td class='tbl2' style='text-align:center;width:10%;'>".$locale['D1CP_seite_028']."</td>";
echo "<td class='tbl2' style='text-align:center;width:10%;'>".$locale['D1CP_seite_029']."</td>";
echo "<td class='tbl2' style='text-align:center;width:20%;'>".$locale['D1CP_seite_030']."</td>";
echo "</tr>";	
if (dbrows($cpresult)) {
while ($coupuser = dbarray($cpresult)) 
	{

if ($coupuser['sonstiges'] == "1") {
	$typelook = "".$d1cpsettings['coupon_scores']."";
	$imagelook = "<img title='Scores' src='".INFUSIONS."D1_coupon_panel/images/scores.png'/>";
} elseif ($coupuser['sonstiges'] == "2") {
	$typelook = "Stunden";
	$imagelook = "<img title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/>";
} elseif ($coupuser['sonstiges'] == "3") {
	$typelook = "Tage";
	$imagelook = "<img title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/>";
} else {
	$typelook = "ERROR";
	$imagelook = "<img title='Fehler' src='".INFUSIONS."D1_coupon_panel/images/error.png'/>";
}

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['id']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['coupon']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['scores']."</td>";
echo "<td class='tbl1' style='text-align:center;'>$typelook</td>";
echo "<td class='tbl1' style='text-align:center;'>$imagelook</td>";
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i:s",$coupuser['time'])."</td>";
echo "</tr>";
	}
}
echo "<tr>";
echo "<td class='tbl2' colspan='6' style='text-align:center;'>";
echo "<center><b>--- ".$locale['D1CP_seite_031']." ".$num_rows1." ".$locale['D1CP_seite_032']." ---</b></center>";
echo "</td>";
echo "</tr>";
echo "</table>";

///////////////////////////////////////////////////

echo d1cp_infusionscore_end();
closetable();
} else {
opentable($locale['D1CP_seite_001']);
echo "".$locale['D1CP_seite_033']."";
closetable();
}

if (function_exists("d1couponsec2")) {
	d1couponsec2();
} else {
	redirect(BASEDIR."index.php");
}

echo "<script type='text/javascript'>
$(function() {
$('#form_coupon').submit(function() {
    if ($('#coupon').val() == '') {
        alert('".$locale['D1CP_seite_034']."');
        $('#coupon').focus();
        return false;
    }
});
});
</script>";

require_once THEMES."templates/footer.php";
?>
<script type="text/javascript">
	$(document).ready(function(){
	$('.success').fadeOut(10000);
	$('.success2').fadeOut(15000);
	$('.error').fadeOut(10000);
	});
</script>