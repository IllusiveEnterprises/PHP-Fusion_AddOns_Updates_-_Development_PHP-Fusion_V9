<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_job_rewards_panel_admin.php
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
require_once THEMES."templates/admin_header.php";

include INFUSIONS."D1_job_rewards_panel/infusion_db.php";

if (!checkrights("D1JR") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

require_once INFUSIONS."D1_job_rewards_panel/includes/functions.php";

if (d1jobrewardsSet("inf_name") == "" || d1jobrewardsSet("inf_name") != md5("D1 Job Rewards") || d1jobrewardsSet("site_url") == "" || d1jobrewardsSet("site_url") != md5("D1 Job Rewards".$settings['siteurl'])) {
	redirect(INFUSIONS."D1_job_rewards_panel/D1_job_rewards_register.php".$aidlink);
}

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_job_rewards_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_job_rewards_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_job_rewards_panel/locale/German.php";
}

if(isset($_GET['section']))
{
$section = stripinput($_GET['section']);
} else {
$section = "d1cpsettings";
}

$d1cpsettings = dbarray(dbquery("SELECT * FROM ".DB_D1JR_conf.""));

opentable($locale['D1JR_admin_001']);

$a_result = dbquery("SELECT * FROM ".DB_D1JR_bewerbung.""); 
$num_rows1 = mysql_num_rows($a_result);

echo "<table class='tbl-border center' cellpadding='0' cellspacing='1' width='100%'>";
echo "<tr>
        <td width='25%' class='".($section == "d1cpsettings" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1cpsettings" ? "<strong>".$locale['D1JR_admin_002']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1cpsettings'><strong>".$locale['D1JR_admin_002']."</strong></a>")."</span></td>
        <td width='25%' class='".($section == "d1jraddu" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1jraddu" ? "<strong>".$locale['D1JR_admin_003']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1jraddu'><strong>".$locale['D1JR_admin_003']."</strong></a>")."</span></td>
	<td width='25%' class='".($section == "d1jraddj" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1jraddj" ? "<strong>".$locale['D1JR_admin_004']."</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1jraddj'><strong>".$locale['D1JR_admin_004']."</strong></a>")."</span></td>
	<td width='25%' class='".($section == "d1jrubew" ? "tbl1" : "tbl2")."' align='center'><span class='small' style='color:green;'>".($section == "d1jrubew" ? "<strong>".$locale['D1JR_admin_065']." ($num_rows1)</strong>" : "<a class='small' href='".FUSION_SELF.$aidlink."&section=d1jrubew'><strong>".$locale['D1JR_admin_065']." ($num_rows1)</strong></a>")."</span></td>
</tr><tr><td class='tbl' colspan='4'>
";
echo "<br>";

//////////////////////////////

switch ($section) {
case "d1cpsettings" :

if(isset($_POST['gksettings'])) {
	$scores_name = stripinput($_POST['scores_name']);
	$result = dbquery("UPDATE ".DB_D1JR_conf." SET
		scores_name='".$scores_name."'
		WHERE conf='1'");
		redirect(FUSION_SELF.$aidlink."&section=d1cpsettings&success=true");
//PANELS
} elseif (isset($_POST['panel_save'])) {
	$panel_side = stripinput($_POST['panel_side']);
	$panel_status = stripinput($_POST['panel_status']);
	$result = dbquery("UPDATE ".DB_PANELS." SET
				panel_side = '".$panel_side."',
				panel_status = '".$panel_status."'
				WHERE panel_filename = 'D1_job_rewards_panel'
				");
				redirect(FUSION_SELF.$aidlink."&section=d1cpsettings&panelsuccess=true");

//PANELE

} else {
	if (isset($_GET['success'])) {
		echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_scc1']."</center></td></tr></table></center><br></div>";
	}
//PANELS
	if (isset($_GET['panelsuccess'])) {
		echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_scc2']."</center></td></tr></table></center><br></div>";
	}
}
//PANELE

//PANELS
/////////////////////////////
//PANELS
	$panel = dbarray(dbquery("SELECT * FROM ".DB_PANELS." WHERE panel_filename='D1_job_rewards_panel'"));
	echo "<form name='panel_settings' method='post' action='".FUSION_SELF.$aidlink."&amp;section=d1cpsettings'>";
	echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='75%'>
		<tr>
			<td class='tbl2' colspan='2' style='font-weight:bold; text-align:center; font-size:bigger;'>".$locale['D1JR_admin_018']."</td>
		</tr>
		<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1JR_admin_005']."</td>
			<td>
				<select name='panel_side' class='textbox' style='width:100px;'>
					<option value='1'".($panel['panel_side'] == 1 ? " selected" : "").">".$locale['D1JR_admin_006']."</option>
					<option value='4'".($panel['panel_side'] == 4 ? " selected" : "").">".$locale['D1JR_admin_007']."</option>
					<option value='2'".($panel['panel_side'] == 2 ? " selected" : "").">".$locale['D1JR_admin_008']."</option>
					<option value='3'".($panel['panel_side'] == 3 ? " selected" : "").">".$locale['D1JR_admin_009']."</option>
				</select>
			</td>
		</tr>";
            echo "
			
			<tr class='tbl1'>
			<td align='right' width='50%'>".$locale['D1JR_admin_010']."</td>
			<td>
				<select name='panel_status' class='textbox' style='width:100px;'>
					<option value='0'".($panel['panel_status'] == 0 ? " selected" : "").">".$locale['D1JR_admin_011']."</option>
					<option value='1'".($panel['panel_status'] == 1 ? " selected" : "").">".$locale['D1JR_admin_012']."</option>
				</select>
			</td>
			</tr>";
	echo "<tr class='tbl2' style='color:#000;font-weight:bold;font-size:bigger;'>
			<td align='center' colspan='2'>
				<input type='submit' class='button' name='panel_save' value='".$locale['D1JR_admin_013']."' />
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
		<td class='tbl2' colspan='2' style='font-weight:bold;text-align:center;'>".$locale['D1JR_admin_014']."</td>
	</tr>";
	
		if (defined("SCORESYSTEM")) {
			echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1JR_admin_015']." </td>
				<td class='tbl1' style='text-align:left;'><input class='textbox' type='text' value='".$d1cpsettings['scores_name']."' name='scores_name' /></td>
			</tr>";
		} else {
	echo "
	<tr>
		<td class='tbl1' align='center' colspan='2'>".$locale['D1JR_admin_016']."
	</td>
	</tr>";
		}

/*
						echo "
			<tr>
				<td class='tbl1' width='40%' style='text-align:right;'>".$locale['D1JR_admin_017']." </td>
							<td class='tbl1' style='text-align:left;'>
				<select name='job_intervall' class='textbox' style='width:150px;'>
					<option value='60'".($d1cpsettings['job_intervall'] == 60 ? " selected" : "").">Min&uuml;tlich (Test Modus)</option>
					<option value='86400'".($d1cpsettings['job_intervall'] == 86400 ? " selected" : "").">T&auml;glich</option>
					<option value='604800'".($d1cpsettings['job_intervall'] == 604800 ? " selected" : "").">W&ouml;chentlich</option>
					<option value='2592000'".($d1cpsettings['job_intervall'] == 2592000 ? " selected" : "").">Monatlich</option>
				</select>
			</td>
			</tr>";
*/

	echo "
	<tr>
		<td class='tbl2' style='text-align:center;' colspan='2'>
		<input type='submit' name='gksettings' value='".$locale['D1JR_admin_013']."' class='button' />
	</td>
	</tr>
	</table>
	</form>";

} //CASE Close

switch ($section) {
case "d1jraddu" :

if (isset($_POST['job'])) {
$job_post = stripinput($_POST['job']);
} else {
$job_post = "";
}

if(isset($_POST["job_send"])) {

$jobdup = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE user_id=".$_POST["user_id"]." AND job_id=".$_POST["job"].""));
if ($jobdup) { $dupl = "0"; } else { $dupl = "1"; }

if ($job_post != '0') {
if ($dupl == '1') {

$d1jrconf = dbarray(dbquery("SELECT * FROM ".DB_D1JR_conf.""));
$timestampJR = time();
$timesnext = $timestampJR + $d1jrconf['job_intervall'];
$result = dbquery("INSERT INTO ".DB_D1JR_user." (user_id, job_id, time_von, time_bis) VALUES ('".$_POST["user_id"]."', '".$_POST["job"]."', '".$timestampJR."', '".$timesnext."') ");

$groupss1 = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$_POST["user_id"].""));
$jobsss1 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$_POST["job"].""));

if ($jobsss1['job_group'] != '0') {
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss1['job_group']."", "", $groupss1['user_groups']).".".$jobsss1['job_group']."' WHERE  `user_id` = ".mysql_real_escape_string($_POST["user_id"]).";");
}

echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_060']."</center></td></tr></table></center><br></div>";
echo "$jobdup";
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_077']."</center></td></tr></table></center><br></div>";
}
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_061']."</center></td></tr></table></center><br></div>";
}

}

if(isset($_POST["editjob_send"])) {

$u_idid = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE id='".$_GET['u_id']."'"));

$usersss22 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE id=".$_GET['u_id'].""));
$groupss22 = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$usersss22["user_id"].""));
$jobsss22 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$usersss22["job_id"].""));

$jobdup = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE user_id=".$usersss22["user_id"]." AND job_id=".$_POST["job"].""));
if ($jobdup) { $dupl = "0"; } else { $dupl = "1"; }
if ($dupl == '1') {

$result = dbquery("UPDATE ".DB_D1JR_user." SET

	job_id = '".$_POST["job"]."'
	WHERE id = '".$u_idid['id']."'");
	//redirect(FUSION_SELF.$aidlink."&status=reset");


$usersss2 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE id=".$_GET['u_id'].""));
$groupss2 = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$usersss2["user_id"].""));
$jobsss2 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$_POST["job"].""));


//////////////////////////////////////////////////////////////////
	$resultss2 = dbquery("SELECT tu.*, tj.* FROM ".DB_D1JR_user." tu INNER JOIN ".DB_D1JR_jobs." tj ON tu.job_id=tj.id WHERE tu.user_id='".$usersss2["user_id"]."' AND tj.job_group='".$jobsss2['job_group']."'");
	if (dbrows($resultss2)) {
	$jobsz = 0;
	while ($lizenz = dbarray($resultss2)) {
   	$jobsz++;
	}
	}
//////////////////////////////////////////////////////////////////

if ($jobsss2['job_group'] != '0') {
if ($jobsz == '1') {
echo"1-$jobsz";
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss2['job_group']."", "", $groupss2['user_groups']).".".$jobsss2['job_group']."' WHERE  `user_id` = ".mysql_real_escape_string($usersss2["user_id"]).";");
//mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22['job_group']."", "", $groupss22['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($usersss22["user_id"]).";");
} elseif ($jobsz == '2') {
//mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22['job_group']."", "", $groupss22['user_groups']).".".$jobsss2['job_group']."' WHERE  `user_id` = ".mysql_real_escape_string($usersss2["user_id"]).";");
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22['job_group']."", "", $groupss22['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($usersss22["user_id"]).";");
echo"4-$jobsz";
} else {
echo"2-$jobsz";
//mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22['job_group']."", "", $groupss22['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($usersss22["user_id"]).";");
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22['job_group']."", "", $groupss22['user_groups']).".".$jobsss2['job_group']."' WHERE  `user_id` = ".mysql_real_escape_string($usersss2["user_id"]).";");
}
} else {

if ($jobsz == '2') {
echo"3-$jobsz";
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22['job_group']."", "", $groupss22['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($usersss22["user_id"]).";");
}
}


echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_074']."</center></td></tr></table></center><br></div>";
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_077']."</center></td></tr></table></center><br></div>";
}
}
if(isset($_GET["delete"])) {
$del = $_GET["delete"];

$usersss3 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE id=".$del.""));
$groupss3 = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$usersss3["user_id"].""));
$jobsss3 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$usersss3["job_id"].""));


//////////////////////////////////////////////////////////////////
	$resultss3 = dbquery("SELECT tu.*, tj.* FROM ".DB_D1JR_user." tu INNER JOIN ".DB_D1JR_jobs." tj ON tu.job_id=tj.id WHERE tu.user_id='".$usersss3["user_id"]."' AND tj.job_group='".$jobsss3['job_group']."'");
	if (dbrows($resultss3)) {
	$jobsz = 0;
	while ($lizenz = dbarray($resultss3)) {
   	$jobsz++;
	}
	}
//////////////////////////////////////////////////////////////////

if ($jobsss3['job_group'] != '0') {
if ($jobsz == '1') {
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss3['job_group']."", "", $groupss3['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($usersss3["user_id"]).";");
}
}

$result1 = dbquery("DELETE FROM ".DB_D1JR_user." WHERE id = '$del'");

echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_062']."</center></td></tr></table></center><br></div>";
}


//EDIT
if(isset($_GET["edit"])) {
echo '<form id="d1jraddu" action="'.FUSION_SELF.$aidlink.'&amp;section=d1jraddu&amp;u_id='.$_GET['edit'].'" method="post">';
echo "<table width='50%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'User';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Job';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>";

$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." ORDER BY user_name ASC");
			$userlist = "";
			while ($data = dbarray($result)) {

			$user_editer = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE id='".$_GET['edit']."'"));
			$uuid = $data['user_id'];
			$userlist .= "<option value='$uuid'".($user_editer['user_id'] == $uuid ? " selected" : "").">".$data['user_name']."</option>\n";
			
}		
echo "<select disabled name='user_id' id='user_id' class='textbox'>".$userlist."</select>";

//echo '<input type="text" id="job" name="job" class="textbox" style="width:130px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
		echo "<select name='job' id='job' class='textbox'>";
		echo "<option value='0'>Bitte ausw&auml;hlen</option>";
		$result = dbquery("SELECT * FROM ".DB_D1JR_jobs." ORDER BY job ASC");
			while ($jobsdata = dbarray($result))
				{	
					$user_editer2 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE id='".$_GET['edit']."'"));
					$user_editer3 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id='".$jobsdata['id']."'"));
					//echo "<option value='".$user_editer2['job_id']."'>".$jobsdata['job']."</option>";
					$jjid = $jobsdata['id'];
					echo "<option value='$jjid '".($user_editer2['job_id'] == $jjid  ? " selected" : "").">".$user_editer3['job']."</option>";
					
				}
			echo "</select>";
//echo '<input type="text" id="job" name="job" class="textbox" style="width:130px">';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Mitgliedsname';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Job';
echo "</td>";
echo "</tr>";

echo "<tr><td class='tbl2' colspan ='2' style='text-align:center;'>";
echo '<input type="submit" name="editjob_send"  class="button" value="'.$locale['D1JR_admin_072'] .'"></form>';
			echo "</td></tr></table>";
//EDIT
} else {
//ADD
echo '<form id="d1jraddu" action="'.FUSION_SELF.$aidlink.'&amp;section=d1jraddu" method="post">';
echo "<table width='60%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'User';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Job';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>";
$result = dbquery("SELECT user_id, user_name FROM ".DB_USERS." ORDER BY user_name ASC");
			$userlist = "";
			while ($data = dbarray($result)) {
			$userlist .= "<option value='".$data['user_id']."'>".$data['user_name']."</option>\n";
			
//$usersettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id=".$data['user_id'].""));	
}		
echo "<select name='user_id' id='user_id' class='textbox'>".$userlist."</select>";
//echo '<input type="text" id="job" name="job" class="textbox" style="width:130px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
		echo "<select name='job' id='job' class='textbox'>";
		echo "<option value='0'>Bitte ausw&auml;hlen</option>";
		$result = dbquery("SELECT * FROM ".DB_D1JR_jobs." ORDER BY job ASC");
			while ($jobsdata = dbarray($result))
				{
					echo "<option value='".$jobsdata['id']."'>".$jobsdata['job']."</option>";
				}
			echo "</select>";
//echo '<input type="text" id="job" name="job" class="textbox" style="width:130px">';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Mitgliedsname';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Job';
echo "</td>";
echo "</tr>";

echo "<tr><td class='tbl2' colspan ='2' style='text-align:center;'>";
echo '<input type="submit" name="job_send"  class="button" value="'.$locale['D1JR_admin_035'] .'"></form>';
			echo "</td></tr></table>";
//ADD
}
echo "<br>";

$a_result = dbquery("SELECT * FROM ".DB_D1JR_user." ORDER BY job_id ASC"); 
$num_rows1 = mysql_num_rows($a_result);

$abfrage = "SELECT * FROM ".DB_D1JR_user."";
$ergebnis = mysql_query($abfrage);

echo "<table class='tbl-border center' cellpadding='0' cellspacing='0' width='75%'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo 'ID';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo 'User';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Job';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Time Check';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Time Next';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo 'Scores';
echo "</td>";
//echo "<td class='tbl2' style='text-align:center;' width='20%'>";
//echo '';
//echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo '';
echo "</td>";
echo "</tr>";


      while ($ajru = dbarray($a_result)) {

$userss = dbarray(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id=".$ajru['user_id'].""));
$jobss = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$ajru['job_id'].""));
echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>".$ajru['id']."</td>";
echo "<td class='tbl1' style='text-align:center;'><a href='".BASEDIR."profile.php?lookup=".$ajru['user_id']."'>".$userss['user_name']."</a></td>";
echo "<td class='tbl1' style='text-align:center;'>".$jobss['job']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i:s",$ajru['time_von'])."</td>";
$timebis = $ajru['time_von']+$jobss['job_intervall'];
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i:s",$timebis)."</td>";
//echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i:s",$ajru['time_bis'])."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$jobss['scores']."</td>";
//echo "<td class='tbl1' style='text-align:center;'><a alt='bearbeiten' title='bearbeiten' href='".FUSION_SELF.$aidlink."&amp;section=d1jraddu&edit=".$ajru['id']."' \"><img style='vertical-align: middle;' border='0' title='bearbeiten' src='images/edit.png'></a></td>";
echo "<td class='tbl1' style='text-align:center;'><a alt='l&ouml;schen' title='l&ouml;schen' href='".FUSION_SELF.$aidlink."&amp;section=d1jraddu&delete=".$ajru['id']."' onclick=\"return confirm('".$userss['user_name']." aus ".$jobss['job']." - wirklich l&ouml;schen ???');\"><img style='vertical-align: middle;' border='0' title='l&ouml;schen' src='images/delete.png'></a></td>";
echo "</tr>";
	}
echo "<tr>";
echo "<td class='tbl2' colspan='7' style='text-align:center;'>";
echo "<center><b>--- ".$locale['D1JR_admin_044']." ".$num_rows1." ".$locale['D1JR_admin_045']." ---</b></center>";
echo "</td>";
echo "</table>";
}

switch ($section) {
case "d1jraddj" :
///
if (isset($_POST['job'])) {
$job_post = stripinput($_POST['job']);
} else {
$job_post = "";
}

$d1jrjobs = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE job = '".$job_post."'"));

if(isset($_POST["job_send"])) {

if (!$d1jrjobs) {
$result = dbquery("INSERT INTO ".DB_D1JR_jobs." (job, scores, job_search, job_besch, job_group, job_intervall) VALUES ('".$_POST["job"]."', '".$_POST["scores"]."', '".$_POST["job_search"]."', '".$_POST["job_besch"]."', '".$_POST["job_group"]."', '".$_POST["job_intervall"]."')");
echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_019']."</center></td></tr></table></center><br></div>";
} else {
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_023']."</center></td></tr></table></center><br></div>";
}
}

///

if(isset($_POST["editjob_send"])) {

$job_idid = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id='".$_GET['job_id']."'"));

$result = dbquery("UPDATE ".DB_D1JR_jobs." SET
	job = '".$_POST["job"]."',
	scores = '".$_POST["scores"]."',
	job_search = '".$_POST["job_search"]."',
	job_besch = '".$_POST["job_besch"]."',
	job_group = '".$_POST["job_group"]."',
	job_intervall = '".$_POST["job_intervall"]."'
	WHERE id = '".$job_idid['id']."'");
	//redirect(FUSION_SELF.$aidlink."&status=reset");

echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_073']."</center></td></tr></table></center><br></div>";

}

if(isset($_GET["delete"])) {
$del = $_GET["delete"];
$result1 = dbquery("DELETE FROM ".DB_D1JR_jobs." WHERE id = '$del'");
$result13 = dbquery("DELETE FROM ".DB_D1JR_bewerbung." WHERE job_id = '$del'");
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_024']."</center></td></tr></table></center><br></div>";
}

if(isset($_GET["deleteall"])) {
$delall = $_GET["deleteall"];

$jobsss22a = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$delall.""));
$usersss22a = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jobsss22a["id"].""));
$groupss22a = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$usersss22a["user_id"].""));

if ($delall != '0') {

	$result22a = dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jobsss22a["id"]."");
	while ($delalldata = dbarray($result22a)) {
	$jobsss22ab = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$delall.""));
	$usersss22ab = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jobsss22a["id"].""));
	$groupss22ab = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$delalldata["user_id"].""));

//////////////////////////////////////////////////////////////////
	$resultss3 = dbquery("SELECT tu.*, tj.* FROM ".DB_D1JR_user." tu INNER JOIN ".DB_D1JR_jobs." tj ON tu.job_id=tj.id WHERE tu.user_id='".$usersss22ab["user_id"]."' AND tj.job_group='".$jobsss22ab['job_group']."'");
	if (dbrows($resultss3)) {
	$jobsz = 0;
	while ($lizenz = dbarray($resultss3)) {
   	$jobsz++;
	}
	}
//////////////////////////////////////////////////////////////////
if ($jobsz == '1') {
	mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22ab['job_group']."", "", $groupss22ab['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($delalldata["user_id"]).";");
}
	}
}

$result12 = dbquery("DELETE FROM ".DB_D1JR_user." WHERE job_id = '$delall'");
$result13 = dbquery("DELETE FROM ".DB_D1JR_bewerbung." WHERE job_id = '$delall'");
$result11 = dbquery("DELETE FROM ".DB_D1JR_jobs." WHERE id = '$delall'");
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_025']."</center></td></tr></table></center><br></div>";
}

if(isset($_GET["cleanall"])) {
$delall = $_GET["cleanall"];

$jobsss22a = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$delall.""));
$usersss22a = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jobsss22a["id"].""));
$groupss22a = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$usersss22a["user_id"].""));

if ($delall != '0') {

	$result22a = dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jobsss22a["id"]."");
	while ($delalldata = dbarray($result22a)) {
	$jobsss22ab = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$delall.""));
	$usersss22ab = dbarray(dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id=".$jobsss22a["id"].""));
	$groupss22ab = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$delalldata["user_id"].""));

//////////////////////////////////////////////////////////////////
	$resultss3 = dbquery("SELECT tu.*, tj.* FROM ".DB_D1JR_user." tu INNER JOIN ".DB_D1JR_jobs." tj ON tu.job_id=tj.id WHERE tu.user_id='".$usersss22ab["user_id"]."' AND tj.job_group='".$jobsss22ab['job_group']."'");
	if (dbrows($resultss3)) {
	$jobsz = 0;
	while ($lizenz = dbarray($resultss3)) {
   	$jobsz++;
	}
	}
//////////////////////////////////////////////////////////////////
if ($jobsz == '1') {
	mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss22ab['job_group']."", "", $groupss22ab['user_groups'])."' WHERE  `user_id` = ".mysql_real_escape_string($delalldata["user_id"]).";");
}
	}
}

$result12 = dbquery("DELETE FROM ".DB_D1JR_user." WHERE job_id = '$delall'");
//$result13 = dbquery("DELETE FROM ".DB_D1JR_bewerbung." WHERE job_id = '$delall'");
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_026']."</center></td></tr></table></center><br></div>";
}

if(isset($_GET["edit"])) {

//EDIT
    include_once INCLUDES."bbcode_include.php";
$job_editer = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id='".$_GET['edit']."'"));
echo '<form name="d1jraddj" id="d1jraddj" action="'.FUSION_SELF.$aidlink.'&amp;section=d1jraddj&amp;job_id='.$_GET['edit'].'" method="post">';
echo "<table width='75%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Job';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Scores';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Zeit';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Benutzergruppe';
echo "</td>";
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Bewerben';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="job" name="job" value="'.$job_editer['job'].'" class="textbox" style="width:130px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="scores" name="scores" class="textbox" value="'.$job_editer['scores'].'" style="width:50px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
echo "
				<select name='job_intervall' class='textbox' style='width:130px;'>
					<option value='60'".($job_editer['job_intervall'] == 60 ? " selected" : "").">Min&uuml;dlich (Test Modus)</option>
					<option value='3600'".($job_editer['job_intervall'] == 3600 ? " selected" : "").">St&uuml;ndlich</option>
					<option value='86400'".($job_editer['job_intervall'] == 86400 ? " selected" : "").">T&auml;glich</option>
					<option value='604800'".($job_editer['job_intervall'] == 604800 ? " selected" : "").">W&ouml;chentlich</option>
					<option value='2592000'".($job_editer['job_intervall'] == 2592000 ? " selected" : "").">Monatlich</option>
				</select>
";
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";

	$u2_result = dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id='".$_GET['edit']."'"); 
	$num_rowsu2 = mysql_num_rows($u2_result);
	if ($num_rowsu2 == '0') {
	echo"<select name='job_group' id='job_group' class='textbox'>";
	} else {
	echo '<input type="hidden" id="job_group" name="job_group" value="'.$job_editer['job_group'].'">';
	echo"<select name='job_group' id='job_group' class='textbox' disabled='disabled' style='color:red'>";
	}
		echo"<option value='0'>keine Benutzergruppe</option>";
		$result = dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS."");
			while ($gdata = dbarray($result))
				{
					echo "<option value='".$gdata['group_id']."' ".($job_editer['job_group']==$gdata['group_id'] ? "selected" : "").">".$gdata['group_name']."</option>";
				}
		echo"</select>";
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";

echo "	<select name='job_search' class='textbox' style='width:100px;'>
	<option value='0'".($job_editer['job_search'] == 0 ? " selected" : "").">".$locale['D1JR_admin_071']."</option>
	<option value='1'".($job_editer['job_search'] == 1 ? " selected" : "").">".$locale['D1JR_admin_070']."</option>
	</select>";

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Job Name';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Verg&uuml;tung';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Zeit der Verg&uuml;tung';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
	if ($num_rowsu2 == '0') {
	echo 'Benutzergruppe beitreten?';
	} else {
	echo '<span style="color: #ff0000;">Es darf kein User im Job sein!</span>';
	}
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Bewerbung Status';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl2' colspan='5' style='text-align:center;'>";
echo "Stellenbeschreibung";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='tbl1' colspan='5' style='text-align:center;'>";
echo "<textarea name='job_besch' id='job_besch2' class='textbox' rows='6' style='width:98%;'>".$job_editer['job_besch']."</textarea>";
echo "".display_bbcodes("100%", "job_besch", "d1jraddj", "a|b|big|i|color|bgcolor|smiley|img|url")."\n";
echo "</td>";
echo "</tr>";

echo "<tr><td class='tbl2' colspan ='5' style='text-align:center;'>";
echo '<input type="submit" name="editjob_send"  class="button" value="'.$locale['D1JR_admin_072'] .'"></form>';
			echo "</td></tr></table>";
//EDIT
} else {

//ADD
    include_once INCLUDES."bbcode_include.php";
echo '<form name="d1jraddj" id="d1jraddj" action="'.FUSION_SELF.$aidlink.'&amp;section=d1jraddj" method="post">';
echo "<table width='75%' class='tbl-border' cellpadding='0' cellspacing='0' align='center'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Job';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Scores';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Zeit';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Benutzergruppe';
echo "</td>";
echo "</td>";
echo "<td class='tbl2' style='text-align:center;'>";
echo 'Bewerben';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="job" name="job" class="textbox" style="width:130px">';
echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";
echo '<input type="text" id="scores" name="scores" class="textbox" style="width:50px">';
echo "</td>";

echo "<td class='tbl1' style='text-align:center;'>";
echo "
				<select name='job_intervall' class='textbox' style='width:130px;'>
					<option value='60'>Min&uuml;dlich (Test Modus)</option>
					<option value='3600'>St&uuml;ndlich</option>
					<option value='86400'>T&auml;glich</option>
					<option value='604800'>W&ouml;chentlich</option>
					<option value='2592000'>Monatlich</option>
				</select>
";
echo "</td>";

echo "<td class='tbl1' style='text-align:center;'>";

echo"<select name='job_group' id='job_group' class='textbox'>";
		echo"<option value='0'>keine Benutzergruppe</option>";
		$result = dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS."");
			while ($gdata = dbarray($result))
				{
					echo "<option value='".$gdata['group_id']."' >".$gdata['group_name']."</option>";
				}
		echo"</select>";

echo "</td>";
echo "<td class='tbl1' style='text-align:center;'>";

$job_searchern = "0";
echo "	<select name='job_search' class='textbox' style='width:100px;'>
	<option value='0'".($job_searchern == 0 ? " selected" : "").">".$locale['D1JR_admin_071']."</option>
	<option value='1'".($job_searchern == 1 ? " selected" : "").">".$locale['D1JR_admin_070']."</option>
	</select>";

echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Job Name';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Verg&uuml;tung';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Zeit der Verg&uuml;tung';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Benutzergruppe beitreten?';
echo "</td>";
echo "<td class='tbl1' style='text-align:center; font-size:x-small;'>";
echo 'Bewerbung Status';
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl2' colspan='5' style='text-align:center;'>";
echo "Stellenbeschreibung";
echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='tbl1' colspan='5' style='text-align:center;'>";
echo "<textarea name='job_besch' id='job_besch2' class='textbox' rows='6' style='width:98%;'></textarea>";
echo "".display_bbcodes("100%", "job_besch", "d1jraddj", "a|b|big|i|color|bgcolor|smiley|img|url")."\n";
echo "</td>";
echo "</tr>";

echo "<tr><td class='tbl2' colspan ='5' style='text-align:center;'>";
echo '<input type="submit" name="job_send"  class="button" value="'.$locale['D1JR_admin_035'] .'"></form>';
			echo "</td></tr></table>";

}
//ADD
echo "<br>";

$b_result = dbquery("SELECT * FROM ".DB_D1JR_jobs.""); 
$num_rows1 = mysql_num_rows($b_result);

$abfrage = "SELECT * FROM ".DB_D1JR_jobs."";
$ergebnis = mysql_query($abfrage);

echo "<table class='tbl-border center' cellpadding='0' cellspacing='0' width='75%'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo 'ID';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='30%'>";
echo 'Job';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo 'Scores';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='10%'>";
echo 'Zeit';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='30%'>";
echo 'Benutzergruppe';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo 'User';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo 'Bewerbung';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo '';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo '';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='5%'>";
echo '';
echo "</td>";
echo "</tr>";


      while ($ajrj = dbarray($b_result)) {

$d1groupname = dbarray(dbquery("SELECT group_id,group_name FROM ".DB_USER_GROUPS." WHERE group_id = '".$ajrj['job_group']."'"));


echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'>".$ajrj['id']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$ajrj['job']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$ajrj['scores']."</td>";

if ($ajrj['job_intervall'] == '60') { $ajrjtimer = "Min&uuml;dlich"; }
elseif ($ajrj['job_intervall'] == '3600') { $ajrjtimer = "St&uuml;ndlich"; }
elseif ($ajrj['job_intervall'] == '86400') { $ajrjtimer = "T&auml;glich"; }
elseif ($ajrj['job_intervall'] == '604800') { $ajrjtimer = "W&ouml;chentlich"; }
elseif ($ajrj['job_intervall'] == '2592000') { $ajrjtimer = "Monatlich"; }
else { $ajrjtimer = "N/A"; }
echo "<td class='tbl1' style='text-align:center;'>".$ajrjtimer."</td>";
if ($ajrj['job_group'] == "0") {
echo "<td class='tbl1' style='text-align:center;'>Keine</td>";
} else {
echo "<td class='tbl1' style='text-align:center;'>".$d1groupname['group_name']."</td>";
}

$u_result = dbquery("SELECT * FROM ".DB_D1JR_user." WHERE job_id='".$ajrj['id']."'"); 
$num_rowsu = mysql_num_rows($u_result);
echo "<td class='tbl1' style='text-align:center;'><b>".($num_rowsu)."</b></td>";

$job_searcher = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id='".$ajrj['id']."'"));
if ($job_searcher['job_search'] == '1') {
echo "<td class='tbl1' style='text-align:center;'><img style='vertical-align: middle;' border='0' title='offen' src='images/open.png'></a></td>";
} else {
echo "<td class='tbl1' style='text-align:center;'><img style='vertical-align: middle;' border='0' title='geschlossen' src='images/lock.png'></a></td>";
}
echo "<td class='tbl1' style='text-align:center;'><a alt='bearbeiten' title='bearbeiten' href='".FUSION_SELF.$aidlink."&amp;section=d1jraddj&edit=".$ajrj['id']."' \"><img style='vertical-align: middle;' border='0' title='bearbeiten' src='images/edit.png'></a></td>";

if ($num_rowsu == '0') {
echo "<td class='tbl1' style='text-align:center;'><img style='vertical-align: middle;' border='0' title='keine Mitglieder' src='images/cleang.png'></a></td>";
} else {
echo "<td class='tbl1' style='text-align:center;'><a alt='bereinigen' title='bereinige' href='".FUSION_SELF.$aidlink."&amp;section=d1jraddj&cleanall=".$ajrj['id']."' onclick=\"return confirm('Alle Mitglieder aus ".$ajrj['job']." wirklich l&ouml;schen ???');\"><img style='vertical-align: middle;' border='0' title='bereinige' src='images/clean.png'></a></td>";
}

if ($num_rowsu == '0') {
echo "<td class='tbl1' style='text-align:center;'><a alt='l&ouml;schen' title='l&ouml;schen' href='".FUSION_SELF.$aidlink."&amp;section=d1jraddj&delete=".$ajrj['id']."' onclick=\"return confirm('job -".$ajrj['job']."- wirklich l&ouml;schen ???');\"><img style='vertical-align: middle;' border='0' title='l&ouml;schen' src='images/delete.png'></a></td>";
} else {
echo "<td class='tbl1' style='text-align:center;'><a alt='l&ouml;schen' title='l&ouml;schen' href='".FUSION_SELF.$aidlink."&amp;section=d1jraddj&deleteall=".$ajrj['id']."' onclick=\"return confirm('job -".$ajrj['job']."- und alle Mitglieder daraus wirklich l&ouml;schen ???');\"><img style='vertical-align: middle;' border='0' title='l&ouml;schen' src='images/delete.png'></a></td>";
}
echo "</tr>";
	}

echo "<tr>";
echo "<td class='tbl2' colspan='10' style='text-align:center;'>";
echo "<center><b>--- ".$locale['D1JR_admin_063']." ".$num_rows1." ".$locale['D1JR_admin_064']." ---</b></center>";
echo "</td>";
echo "</table>";

}

switch ($section) {
case "d1jrubew" :

if(isset($_GET["access"])) {
$acc = $_GET["access"];
//-----USER PN NOTIFICATION-----//
$acce = dbarray(dbquery("SELECT * FROM ".DB_D1JR_bewerbung." WHERE id=".$_GET['access'].""));
$accesse = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$acce['job_id'].""));
$uwmessage = "Ihre Bewerbung als -".$accesse['job']."- wurde vom Admin ANGENOMMEN";
$result = dbquery("INSERT INTO ".$db_prefix."messages (
message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder
) VALUES( '".$acce['user_id']."', '".$userdata['user_id']."', 'Antwort zur Bewerbung', '$uwmessage', 'y', '0', '".time()."', '0')");
//-----USER PN NOTIFICATION-----//

$userid = $acce['user_id'];
$jobid = $acce['job_id'];
$d1jrconf1 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_conf.""));
$timev = time();
$timeb = $timev + $d1jrconf1['job_intervall'];

$result = dbquery("INSERT INTO ".DB_D1JR_user." (user_id, job_id, time_von, time_bis) VALUES ('".$userid."', '".$jobid."', '".$timev."', '".$timeb."')");

$groupss4 = dbarray(dbquery("SELECT * FROM ".DB_USERS." WHERE user_id=".$userid.""));
$jobsss4 = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$jobid.""));


if ($jobsss4['job_group'] != '0') {
mysql_query("UPDATE ".DB_USERS." SET  `user_groups` =  '".str_replace(".".$jobsss4['job_group']."", "", $groupss4['user_groups']).".".$jobsss4['job_group']."' WHERE  `user_id` = ".mysql_real_escape_string($userid).";");
}

$result1 = dbquery("DELETE FROM ".DB_D1JR_bewerbung." WHERE id = '$acc'");
echo "<div class='success' style='color:lime;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #00ff00; border-width: 1px; border-style: dashed; background-color: #005500;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_073']."</center></td></tr></table></center><br></div>";
}

if(isset($_GET["delete"])) {
$del = $_GET["delete"];
//-----USER PN NOTIFICATION-----//
$dele = dbarray(dbquery("SELECT * FROM ".DB_D1JR_bewerbung." WHERE id=".$_GET['delete'].""));
$jobdele = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$dele['job_id'].""));
$uwmessage = "Ihre Bewerbung als -".$jobdele['job']."- wurde vom Admin abgelehnt";
$result = dbquery("INSERT INTO ".$db_prefix."messages (
message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder
) VALUES( '".$dele['user_id']."', '".$userdata['user_id']."', 'Antwort zur Bewerbung', '$uwmessage', 'y', '0', '".time()."', '0')");
//-----USER PN NOTIFICATION-----//
$result1 = dbquery("DELETE FROM ".DB_D1JR_bewerbung." WHERE id = '$del'");
echo "<div class='error' style='color:red;font-weight:bold;text-align:center;font-size: 12px;'><center><table style='border-color: #ff0000; border-width: 1px; border-style: dashed; background-color: #550000;' width='500px' align='center'><tr><td><center>".$locale['D1JR_admin_075']."</center></td></tr></table></center><br></div>";
}

$a_result = dbquery("SELECT * FROM ".DB_D1JR_bewerbung." ORDER BY time ASC"); 
$num_rows1 = mysql_num_rows($a_result);

$abfrage = "SELECT * FROM ".DB_D1JR_bewerbung." ORDER BY time ASC";
$ergebnis = mysql_query($abfrage);



      while ($ajru = dbarray($a_result)) {

echo "<table class='tbl-border center' cellpadding='0' cellspacing='0' width='85%'>";

echo "<tr>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'User';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Job';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Verdienst';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Zeit';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Annehmen';
echo "</td>";
echo "<td class='tbl2' style='text-align:center;' width='20%'>";
echo 'Ablehnen';
echo "</td>";
echo "</tr>";

$userss = dbarray(dbquery("SELECT user_name FROM ".DB_USERS." WHERE user_id=".$ajru['user_id'].""));
$jobss = dbarray(dbquery("SELECT * FROM ".DB_D1JR_jobs." WHERE id=".$ajru['job_id'].""));
echo "<tr>";
echo "<td class='tbl1' style='text-align:center;'><a href='".BASEDIR."profile.php?lookup=".$ajru['user_id']."'>".$userss['user_name']."</a></td>";
echo "<td class='tbl1' style='text-align:center;'>".$jobss['job']."</td>";
echo "<td class='tbl1' style='text-align:center;'>".$jobss['scores']." Scores</td>";
echo "<td class='tbl1' style='text-align:center;'>".date("d.m.Y H:i:s",$ajru['time'])."</td>";
echo "<td class='tbl1' style='text-align:center;'><a alt='Annehmen' title='Annehmen' href='".FUSION_SELF.$aidlink."&amp;section=d1jrubew&access=".$ajru['id']."'  onclick=\"return confirm('User: ".$userss['user_name']." - wirklich Annehmen???');\"><img style='vertical-align: middle;' border='0' title='bearbeiten' src='images/uaceppt.png'></a></td>";
echo "<td class='tbl1' style='text-align:center;'><a alt='Ablehnen' title='Ablehnen' href='".FUSION_SELF.$aidlink."&amp;section=d1jrubew&delete=".$ajru['id']."' onclick=\"return confirm('".$userss['user_name']." - wirklich Ablehnen???');\"><img style='vertical-align: middle;' border='0' title='l&ouml;schen' src='images/noaceppt.png'></a></td>";
echo "</tr>";

echo "<tr>";
echo "<td class='tbl2' colspan='6' style='text-align:left;'>";
echo "<b>Bewerbungstext:</b> ".$ajru['text']."";
echo "</td>";
echo "</table><br>";
	}


}

echo d1jr_infusionscore_end();

echo "</td></tr></table>";
closetable();

if (function_exists("d1jobrewardssec")) {
	d1jobrewardssec();
} else {
	redirect(BASEDIR."index.php");
}

echo "<script type='text/javascript'>
$(function() {
$('#d1jraddj').submit(function() {
    if ($('#job').val() == '') {
        alert('Bitte gebe einen Job Namen ein!');
        $('#job').focus();
        return false;
    }
    if ($('#scores').val() == '') {
        alert('Bitte gebe die Scores h\u00f6he ein');
        $('#scores').focus();
        return false;
    }
    if ($('#job_besch2').val() == '') {
        alert('Job beschreibung ist leer!');
        $('#job_besch2').focus();
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