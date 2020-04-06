<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_coupon_panel_admin.php
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
require_once "../../maincore.php";
require_once THEMES."templates/admin_header.php";

include INFUSIONS."D1_coupon_panel/infusion_db.php";

if (!checkrights("D1CP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once INFUSIONS."D1_coupon_panel/includes/functions.php";

if (d1couponSet("inf_name") == "" || d1couponSet("inf_name") != md5("D1 Coupon") || d1couponSet("site_url") == "" || d1couponSet("site_url") != md5("D1 Coupon".$settings['siteurl'])) {
	redirect(INFUSIONS."D1_coupon_panel/D1_coupon_register.php".$aidlink);
}

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_coupon_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_coupon_panel/locale/German.php";
}

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "d1cpsettings";
}

$d1cpsettings = dbarray(dbquery("SELECT * FROM ".DB_D1CP_conf.""));

opentable($locale['D1CP_admin_001']);

echo "<table class='tbl-border center' cellpadding='0' cellspacing='1' width='100%'>";
echo "<tr>
        <td width='33%' class='".($section == "d1cpsettings" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1cpsettings" ? "<strong>".$locale['D1CP_admin_002']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1cpsettings'><strong>".$locale['D1CP_admin_002']."</strong></a>")."</span></td>
        <td width='33%' class='".($section == "d1cpadd" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1cpadd" ? "<strong>".$locale['D1CP_admin_003']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1cpadd'><strong>".$locale['D1CP_admin_003']."</strong></a>")."</span></td>
	<td width='33%' class='".($section == "d1cplog" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1cplog" ? "<strong>".$locale['D1CP_admin_004']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1cplog'><strong>".$locale['D1CP_admin_004']."</strong></a>")."</span></td>
</tr><tr><td class='tbl' colspan='3'>
";
echo "<br>";

//////////////////////////////

switch ($section) {
case "d1cpsettings" :

if(isset($_POST['gksettings'])) {
	$coupon_scores = stripinput($_POST['coupon_scores']);
	$coupon_errinfo = stripinput($_POST['coupon_errinfo']);
	$result = dbquery("UPDATE ".DB_D1CP_conf." SET
		coupon_scores='".$coupon_scores."',
		coupon_errinfo='".$coupon_errinfo."'
		WHERE conf='1'");
		redirect(FUSION_SELF.$aidlink."&section=d1cpsettings&success=true");
//PANELS
} elseif (isset($_POST['panel_save'])) {
	$panel_side = stripinput($_POST['panel_side']);
	$panel_status = stripinput($_POST['panel_status']);
	$result = dbquery("UPDATE ".DB_PANELS." SET
				panel_side = '".$panel_side."',
				panel_status = '".$panel_status."'
				WHERE panel_filename = 'D1_coupon_panel'
				");
				redirect(FUSION_SELF.$aidlink."&section=d1cpsettings&panelsuccess=true");

//PANELE

} else {
	if (isset($_GET['success'])) {
		echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1CP_scc1']."</center></td></tr></table></center><br></div>";
	}
//PANELS
	if (isset($_GET['panelsuccess'])) {
		echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1CP_scc2']."</center></td></tr></table></center><br></div>";
	}
}
//PANELE

//PANELS
/////////////////////////////
//PANELS
	$panel = dbarray(dbquery("SELECT * FROM ".DB_PANELS." WHERE panel_filename='D1_coupon_panel'"));
	echo "<form name='panel_settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1cpsettings'>";
	echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='75%'>
		<tr>
			<td class='tbl2' colspan='2' style='font-weight:bold; text-align:center; font-size:bigger;'>".$locale['D1CP_admin_018']."</td>
		</tr>
		<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1CP_admin_005']."</td>
			<td>
				<select name='panel_side' class='textbox' style='width:100px;'>
					<option value='1'".($panel['panel_side'] == 1 ? " selected" : "").">".$locale['D1CP_admin_006']."</option>
					<option value='4'".($panel['panel_side'] == 4 ? " selected" : "").">".$locale['D1CP_admin_007']."</option>
					<option value='2'".($panel['panel_side'] == 2 ? " selected" : "").">".$locale['D1CP_admin_008']."</option>
					<option value='3'".($panel['panel_side'] == 3 ? " selected" : "").">".$locale['D1CP_admin_009']."</option>
				</select>
			</td>
		</tr>";
            echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1CP_admin_010']."</td>
			<td>
				<select name='panel_status' class='textbox' style='width:100px;'>
					<option value='0'".($panel['panel_status'] == 0 ? " selected" : "").">".$locale['D1CP_admin_011']."</option>
					<option value='1'".($panel['panel_status'] == 1 ? " selected" : "").">".$locale['D1CP_admin_012']."</option>
				</select>
			</td>
			</tr>";
	echo "<tr class='tbl2' style='color:#000;font-weight:bold;font-size:bigger;'>
			<td align='center' colspan='2'>
				<input type='submit' class='button' name='panel_save' value='".$locale['D1CP_admin_013']."' />
			</td>
		</tr>";
	echo "</table>
		</form>";
//PANELE
/////////////////////////////


echo "<form name='settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1cpsettings'>";
echo "<br><table width='75%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";
echo "
	<tr>
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1CP_admin_014']."</td>
	</tr>";
	
		if (defined("SCORESYSTEM")) {
			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1CP_admin_015']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1cpsettings['coupon_scores']."' name='coupon_scores' /></td>
			</tr>";
		} else {
	echo "
	<tr>
		<td class='tbl1' align='center' colspan='2'>".$locale['D1CP_admin_016']."
	</td>
	</tr>";
		}


						echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1CP_admin_017']." </td>
							<td class='tbl1' style='text-align:left;'>
				<select name='coupon_errinfo' class='textbox' style='width:100px;'>
					<option value='0'".($d1cpsettings['coupon_errinfo'] == 0 ? " selected" : "").">".$locale['D1CP_admin_011']."</option>
					<option value='1'".($d1cpsettings['coupon_errinfo'] == 1 ? " selected" : "").">".$locale['D1CP_admin_012']."</option>
				</select>
			</td>
			</tr>";

	echo "
	<tr>
		<td class='tbl2' style='text-align:center;' colspan='2'>
		<input type='submit' name='gksettings' value='".$locale['D1CP_admin_013']."' class='button' />
	</td>
	</tr>
	</table>
	</form>";

} //CASE Close

switch ($section) {
case "d1cpadd" :

if (isset($_POST['coupon'])) {
$coupon_post = stripinput($_POST['coupon']);
} else {
$coupon_post = "";
}

$d1cpusersa = dbarray(dbquery("SELECT * FROM ".DB_D1CP_user." WHERE coupon = '".$coupon_post."'"));
$d1cpcouponsa = dbarray(dbquery("SELECT * FROM ".DB_D1CP." WHERE coupon='".$coupon_post."'"));

if(isset($_POST["coupon_send"])) {

if (!$d1cpcouponsa) {
if (!$d1cpusersa) {
$timestart = ($_POST['timestart'] != "" ? strtotime($_POST['timestart']) : "0");
$timeend = ($_POST['timeend'] != "" ? strtotime($_POST['timeend']) : "9999999999");
$result = dbquery("INSERT INTO ".DB_D1CP." (coupon, timestart, timeend, scores, sonstiges) VALUES ('".$coupon_post."', '".$timestart."', '".$timeend."', '".$_POST["scores"]."', '".$_POST["sonstiges"]."')");
echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1CP_admin_019']."</center></td></tr></table></center><br></div>";
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_admin_020']." <b>".$coupon_post."</b> ".$locale['D1CP_admin_021']."</center></td></tr></table></center><br></div>";
}
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_admin_022']." <b>".$coupon_post."</b> ".$locale['D1CP_admin_023']."</center></td></tr></table></center><br></div>";
}

}

if(isset($_GET["delete"])) {
$del = $_GET["delete"];
$result1 = dbquery("DELETE FROM ".DB_D1CP." WHERE id = '$del'");
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1CP_admin_024']."</center></td></tr></table></center><br></div>";
}

echo '<form id="d1cpadd" action="'.FUSION_SELF.$aidlink.'&amp;section=d1cpadd" method="post">';
echo "<table width='85%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;'>";
echo ''.$locale['D1CP_admin_025'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo ''.$locale['D1CP_admin_026'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo ''.$locale['D1CP_admin_027'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo ''.$locale['D1CP_admin_028'].'';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="coupon" name="coupon" class="textbox" style="width:150px" onKeyUp="javascript:this.value=this.value.toUpperCase()" maxlength="15">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="coupon_start" name="timestart" class="textbox" style="width:130px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="coupon_ende" name="timeend" class="textbox" style="width:130px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="coupon_anzahl" name="scores" class="textbox" style="width:50px">';
echo "	<select name='sonstiges' class='textbox' style='width:80px;'>";
echo "	<optgroup label='ScoreSystem'>";
if (file_exists(INFUSIONS."scoresystem_panel/scoresystem_main_include.php")) {
echo "	<option value='1'>".$d1cpsettings['coupon_scores']."</option>";
} else {
echo "	<option disabled='disabled' value='1'>".$locale['D1CP_admin_030a']."</option>";
}
echo "	<optgroup label='PremiumSystem'>";
if (file_exists(INFUSIONS."MF-Premium-Scores_panel/infusion.php")) {
echo "	<option value='2'>".$locale['D1CP_admin_029']."</option>";
echo "	<option value='3'>".$locale['D1CP_admin_030']."</option>";
} else {
echo "	<option disabled='disabled' value='2'>".$locale['D1CP_admin_029']."</option>";
echo "	<option disabled='disabled' value='3'>".$locale['D1CP_admin_030']."</option>";
}
echo "	</select>";
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo ''.$locale['D1CP_admin_031'].'';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo ''.$locale['D1CP_admin_032'].'';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo ''.$locale['D1CP_admin_033'].'';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo ''.$locale['D1CP_admin_034'].'';
echo "</td>";
echo "</tr>";

echo "<tr><td class='tbl2' colspan ='5' style='text-align:center;'>";
echo '<input type="submit" name="coupon_send"  class="button" value="'.$locale['D1CP_admin_035'] .'"></form>';
			echo "</td></tr></table>";
echo "<br>";

$a_result = dbquery("SELECT * FROM ".DB_D1CP.""); 
$num_rows1 = dbrows($a_result);

$abfrage = "SELECT * FROM ".DB_D1CP."";
$ergebnis = dbquery($abfrage);

echo "<table class='tbl-border center' cellpadding='0' cellspacing='0' width='85%'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo ''.$locale['D1CP_admin_036'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo ''.$locale['D1CP_admin_037'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo ''.$locale['D1CP_admin_038'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo ''.$locale['D1CP_admin_039'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo ''.$locale['D1CP_admin_040'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo ''.$locale['D1CP_admin_041'].'';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo '';
echo "</td>";
echo "</tr>";


      while ($acp = dbarray($a_result)) {

if ($acp['sonstiges'] == "1") {
	$typeadd = "".$d1cpsettings['coupon_scores']."";
	$imageadd = "<img title='Scores' src='".INFUSIONS."D1_coupon_panel/images/scores.png'/>";
} elseif ($acp['sonstiges'] == "2") {
	$typeadd = "".$locale['D1CP_admin_042']."";
	$imageadd = "<img title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/>";
} elseif ($acp['sonstiges'] == "3") {
	$typeadd = "".$locale['D1CP_admin_043']."";
	$imageadd = "<img title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/>";
} else {
	$typeadd = "ERROR";
	$imageadd = "<img title='Fehler' src='".INFUSIONS."D1_coupon_panel/images/error.png'/>";
}

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>".$acp['coupon']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i",$acp['timestart'])."</td>";
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i",$acp['timeend'])."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$acp['scores']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$typeadd."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$imageadd."</td>";
echo "<td class='tbl1' style='text-align:center;'><a alt='banner' title='banner' href='".INFUSIONS."D1_coupon_panel/D1_coupon_bild.php".$aidlink."&amp;coupon=".$acp['coupon']."' target='_blank'><img style='vertical-align: middle;' border='0' title='banner' src='images/banner.png'></a> | <a alt='".$locale['D1CP_admin_030d']."' href='".FUSION_SELF.$aidlink."&amp;section=d1cpadd&delete=".$acp['id']."' onclick=\"return confirm('".$locale['D1CP_admin_030b']." -".$acp['coupon']."- ".$locale['D1CP_admin_030c']."');\"><img style='vertical-align: middle;' border='0' title='".$locale['D1CP_admin_030d']."' src='images/delete.png'></a></td>";
echo "</tr>";
	}
echo "<tr>";
echo "<td class='tbl2' colspan='7' style='text-align:center;'>";
echo "<center><b>--- ".$locale['D1CP_admin_044']." ".$num_rows1." ".$locale['D1CP_admin_045']." ---</b></center>";
echo "</td>";
echo "</table>";
}

switch ($section) {
case "d1cplog" :
///
$result1 = dbquery("SELECT * FROM ".DB_D1CP_user.""); 
$num_rows1 = dbrows($result1);

$cpresult = dbquery("SELECT * FROM ".DB_D1CP_user." ORDER BY time DESC LIMIT 0,50");
echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='85%'>";
echo "<tr>";
echo "<td class='tbl2' colspan='7' style='text-align:center;'>";
echo "<center><b>".$locale['D1CP_admin_046']."</b></center>";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='tbl2' style='text-align:center;width:5%;'>".$locale['D1CP_admin_047']."</td>";
echo "<td class='tbl2' style='text-align:center;width:15%;'>".$locale['D1CP_admin_048']."</td>";
echo "<td class='tbl2' style='text-align:center;width:10%;'>".$locale['D1CP_admin_049']."</td>";
echo "<td class='tbl2' style='text-align:center;width:15%;'>".$locale['D1CP_admin_050']."</td>";
echo "<td class='tbl2' style='text-align:center;width:15%;'>".$locale['D1CP_admin_051']."</td>";
echo "<td class='tbl2' style='text-align:center;width:10%;'>".$locale['D1CP_admin_052']."</td>";
echo "<td class='tbl2' style='text-align:center;width:20%;'>".$locale['D1CP_admin_053']."</td>";
echo "</tr>";
if (dbrows($cpresult)) {
	while ($coupuser = dbarray($cpresult)) 
	{

if ($coupuser['sonstiges'] == "1") {
	$typelog = "".$d1cpsettings['coupon_scores']."";
	$imagelog = "<img title='Scores' src='".INFUSIONS."D1_coupon_panel/images/scores.png'/>";
} elseif ($coupuser['sonstiges'] == "2") {
	$typelog = "".$locale['D1CP_admin_042']."";
	$imagelog = "<img title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/>";
} elseif ($coupuser['sonstiges'] == "3") {
	$typelog = "".$locale['D1CP_admin_042']."";
	$imagelog = "<img title='Premium' src='".INFUSIONS."D1_coupon_panel/images/premium.png'/>";
} else {
	$typelog = "ERROR";
	$imagelog = "<img title='Fehler' src='".INFUSIONS."D1_coupon_panel/images/error.png'/>";
}

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['id']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['user_name']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['coupon']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$coupuser['scores']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$typelog."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$imagelog."</td>";
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i:s",$coupuser['time'])."</td>";
echo "</tr>";
	}
}
echo "<tr>";
echo "<td class='tbl2' colspan='7' style='text-align:center;'>";
echo "<center><b>--- ".$locale['D1CP_admin_054']." ".$num_rows1." ".$locale['D1CP_admin_055']." ---</b></center>";
echo "</td>";
echo "</tr>";
echo "</table>";

}

echo d1cp_infusionscore_end();

echo "</td></tr></table>";
closetable();

if (function_exists("d1couponsec")) {
	d1couponsec();
} else {
	redirect(BASEDIR."index.php");
}
echo "<script type='text/javascript'>
$(function() {
$('#d1cpadd').submit(function() {
    if ($('#coupon').val() == '') {
        alert('".$locale['D1CP_admin_056']."');
        $('#coupon').focus();
        return false;
    }
    if ($('#coupon_start').val() == '') {
        alert('".$locale['D1CP_admin_057']."');
        $('#coupon').focus();
        return false;
    }
    if ($('#coupon_ende').val() == '') {
        alert('".$locale['D1CP_admin_058']."');
        $('#coupon').focus();
        return false;
    }
    if ($('#coupon_anzahl').val() == '') {
        alert('".$locale['D1CP_admin_059']."');
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
	$('.success').fadeOut(5000);
	$('.error').fadeOut(10000);
	});
</script>