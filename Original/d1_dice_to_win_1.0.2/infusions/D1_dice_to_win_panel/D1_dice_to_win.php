<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 20011 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: D1_dice_to_win.php
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
include INFUSIONS."D1_dice_to_win_panel/infusion_db.php";

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_dice_to_win_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_dice_to_win_panel/locale/German.php";
}

require_once INFUSIONS."D1_dice_to_win_panel/includes/functions.php";

if (d1wintodiceSet("inf_name") == "" || d1wintodiceSet("inf_name") != md5("D1 Dice to win") || d1wintodiceSet("site_url") == "" || d1wintodiceSet("site_url") != md5("D1 Dice to win".$settings['siteurl'])) {
	redirect(BASEDIR."index.php");
}

$dwuser = dbarray(dbquery("SELECT * FROM ".DB_D1DW_user." WHERE user_id='".$userdata['user_id']."'"));
$dwlog = dbarray(dbquery("SELECT * FROM ".DB_D1DW_log." WHERE user_id='".$userdata['user_id']."'"));
$d1dwsettings = dbarray(dbquery("SELECT * FROM ".DB_D1DW_conf.""));

$result5 = dbquery("SELECT * FROM ".DB_D1DW_log." WHERE user_id='".$userdata['user_id']."' AND time > '".time()."'");
$num_rows5 = mysql_num_rows($result5);

if ($d1dwsettings['dwin_wzahl'] == '1') {
$zufalls_dice1zahl = mt_rand(1, 6);
$zufalls_dice2zahl = "0";
$zufalls_dice3zahl = "0";
$zufalls_dice4zahl = "0";
$zufalls_dice5zahl = "0";
}
if ($d1dwsettings['dwin_wzahl'] == '2') {
$zufalls_dice1zahl = mt_rand(1, 6);
$zufalls_dice2zahl = mt_rand(1, 6);
$zufalls_dice3zahl = "0";
$zufalls_dice4zahl = "0";
$zufalls_dice5zahl = "0";
}
if ($d1dwsettings['dwin_wzahl'] == '3') {
$zufalls_dice1zahl = mt_rand(1, 6);
$zufalls_dice2zahl = mt_rand(1, 6);
$zufalls_dice3zahl = mt_rand(1, 6);
$zufalls_dice4zahl = "0";
$zufalls_dice5zahl = "0";
}
if ($d1dwsettings['dwin_wzahl'] == '4') {
$zufalls_dice1zahl = mt_rand(1, 6);
$zufalls_dice2zahl = mt_rand(1, 6);
$zufalls_dice3zahl = mt_rand(1, 6);
$zufalls_dice4zahl = mt_rand(1, 6);
$zufalls_dice5zahl = "0";
}
if ($d1dwsettings['dwin_wzahl'] == '5') {
$zufalls_dice1zahl = mt_rand(1, 6);
$zufalls_dice2zahl = mt_rand(1, 6);
$zufalls_dice3zahl = mt_rand(1, 6);
$zufalls_dice4zahl = mt_rand(1, 6);
$zufalls_dice5zahl = mt_rand(1, 6);
}
$sechser_multi = $d1dwsettings['dwin_wzahl']*6;

$zufalls_dicezahl = $zufalls_dice1zahl+$zufalls_dice2zahl+$zufalls_dice3zahl+$zufalls_dice4zahl+$zufalls_dice5zahl;
$wurfkosten = $d1dwsettings['dwin_kosten'];
$wurfkosten_multi = $d1dwsettings['dwin_kosten']*$d1dwsettings['dwin_multi'];
if ($d1dwsettings['dwin_gpreis'] == '1') {
$jack = $d1dwsettings['dwin_fpreis'];
} else {
$jack = $d1dwsettings['jack_pot'];
}
$jackpot = $jack+$wurfkosten_multi;
$dicewin = $jack;
$dicewinlog = $jack+$wurfkosten_multi;
$dicechance = $d1dwsettings['dwin_chance'];
$timetime = time()+1;
$reload_fix = $dwuser['sonstiges']+$d1dwsettings['dwin_reftime'];
$reload_fix2 = $dwuser['sonstiges']+$d1dwsettings['dwin_reftime']+1;
$wurf_wurf = $dwuser['sonstiges']+1;
$timer = $reload_fix-time();
$lucky_number = $d1dwsettings['lucky_number'];
$lucky_win = $d1dwsettings['lucky_win'];
$dbtextluckyn = "".$locale['D1DW_seite_031']." ".$lucky_win." ".$d1dwsettings['dwin_scores']."";
if ($d1dwsettings['dwin_gpreis'] == '1') {
$dbtextjack = "".$locale['D1DW_seite_007']." ".$dicewin." ".$d1dwsettings['dwin_scores']."";
$dbtextnjack = "";
} else {
$dbtextjack = "".$locale['D1DW_seite_008']." ".$dicewin." ".$d1dwsettings['dwin_scores']."";
$dbtextnjack = "- ".$locale['D1DW_seite_009']." ".$dicewinlog." ".$d1dwsettings['dwin_scores']."";
}

if(iMEMBER) {
if ($d1dwsettings['dwin_gstatus'] == '1') {
opentable($locale['D1DW_seite_001']);

echo "<center>";
echo "<h1><u>D1 Dice to win</u></h1>";
echo "<img src='".INFUSIONS."D1_dice_to_win_panel/images/1.png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/2.png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/3.png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/4.png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/5.png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/6.png'/><br>";
echo "".$locale['D1DW_seite_010']." <b>".$sechser_multi."</b> ".$locale['D1DW_seite_011']." <b>".$d1dwsettings['dwin_wzahl']."</b> ".$locale['D1DW_seite_012'].".<br>";

if ($d1dwsettings['lucky_number'] == "0") {
echo "<b>".$locale['D1DW_seite_032']."</b><br>";
} else {
echo "<b>".$locale['D1DW_seite_033']." $lucky_number = $lucky_win ".$d1dwsettings['dwin_scores']."</b><br>";
}
if ($d1dwsettings['dwin_gpreis'] == '0') {
echo "".$locale['D1DW_seite_034']." <b>x".$d1dwsettings['dwin_multi']."</b> - ".$locale['D1DW_seite_035']." <b>$wurfkosten_multi ".$d1dwsettings['dwin_scores']."</b> ".$locale['D1DW_seite_036']."<br>";
}

if ($d1dwsettings['dwin_gpreis'] == '1') {
echo "<h2>".$locale['D1DW_seite_013']." $jack ".$d1dwsettings['dwin_scores']."</h2>";
} else {
echo "<h2>".$locale['D1DW_seite_014']." $jack ".$d1dwsettings['dwin_scores']."</h2>";
}

echo "</center>";

if ($num_rows5 >= $dicechance) {
if (isset($_GET['wurf_dice'])) {
redirect(INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php");
}

echo '<center>';
echo '<b><font color="#FF0000">'.$locale['D1DW_seite_005'].' '.$dwuser['zahl'].'</font><br>';
echo "<center><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel1'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel2'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel3'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel4'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel5'].".png'/></center>";
echo '</b>';
echo '<b><font color="#FF0000">'.$locale['D1DW_seite_002'].'</font><br>';
echo '</b></center>';
} elseif (score_account_stand() < $wurfkosten) {
echo '<center><b>';
echo '<font color="#FF0000">'.$locale['D1DW_seite_003'].' '.$d1dwsettings['dwin_scores'].'</b><br>('.$locale['D1DW_seite_004'].' '.$wurfkosten.' '.$d1dwsettings['dwin_scores'].')</font>';
echo '</b></center>';
} elseif ($num_rows5 != $dicechance) {
echo '<center>';
if ($wurf_wurf < time()) {
echo '<b><font color="#c0c000">'.$locale['D1DW_seite_005'].' '.$dwuser['zahl'].'</font></b><br>';
echo "<center><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel1'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel2'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel3'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel4'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel5'].".png'/></center>";


} else {
echo '<b><font color="#00c000">'.$locale['D1DW_seite_006'].' '.$dwuser['zahl'].'</font><br>';
echo "<center><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel1'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel2'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel3'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel4'].".png'/><img src='".INFUSIONS."D1_dice_to_win_panel/images/".$dwuser['wurfel5'].".png'/></center>";
echo '</b>';
}



echo '<table class="tbl-border center" cellpadding="3" cellspacing="0" width="400px" style="margin-top:10px;"><tr class="tbl2"><td><center>';
echo '<span style="color: #FF0000;"><b>'.$locale["D1DW_seite_015"].'</b>';

//ALT_S
/*
echo '<div id="sperr_refresh">';
if ($reload_fix > time()) {
echo '<b><font color="#FF0000"><img align="absmiddle" src="'.INFUSIONS.'D1_dice_to_win_panel/images/stop.png"/> '.$locale["D1DW_seite_016"].' ('.$timer.') - '.$locale["D1DW_seite_017"].' <img align="absmiddle"  src="'.INFUSIONS.'D1_dice_to_win_panel/images/stop.png"/></font><br></b>';
} else {
echo '<b><font color="#00c000"><img align="absmiddle" src="'.INFUSIONS.'D1_dice_to_win_panel/images/ok.png"/> '.$locale["D1DW_seite_018"].' <img align="absmiddle"  src="'.INFUSIONS.'D1_dice_to_win_panel/images/ok.png"/></font><br></b>';
}
echo "</div>";
*/
//ALT_E

//NEU_S
echo "<script language='JavaScript' src='".INFUSIONS."D1_dice_to_win_panel/includes/d1dtw1time.js'></script>";
echo "<center><div id='cID2'>  Init<script>countdownd1dtw($timer,'cID2'); </script></div></center>";
//NEU_E

echo '<b>'.$d1dwsettings["dwin_reftime"].' '.$locale["D1DW_seite_019"].'</b></span>';
echo '</center></td></tr></table>';
//echo "<br><form name='dice_to' method='post' action='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php?wurf_dice' target='_top'><div id='cID2'>  Init<script>countdownd1dtw2($timer,'cID2'); </script></div></form>";
echo "<br><form name='dice_to' method='post' action='".INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php?wurf_dice' target='_top'><input type='submit' name='dice_to' value='".$locale['D1DW_panel_005']."' class='button' /></form>";
echo '<span class="small" style="color: #FF0000;">('.$locale['D1DW_panel_003'].' '.$wurfkosten.' '.$d1dwsettings['dwin_scores'].')</span>';
echo '</center>';
} 

if (isset($_GET['wurf_dice'])) {
if ($reload_fix < time()) {
if (score_account_stand() < $wurfkosten) {
redirect(INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php");
} else {
if ($num_rows5 != $dicechance) {
if ($dwuser['user_id'] == '') {
mysql_query("INSERT INTO ".DB_D1DW_user." (`user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '".$zufalls_dice1zahl."', '".$zufalls_dice2zahl."', '".$zufalls_dice3zahl."', '".$zufalls_dice4zahl."', '".$zufalls_dice5zahl."');");

//6log no user
If ($zufalls_dicezahl == $sechser_multi) {
mysql_query("INSERT INTO ".DB_D1DW_log." (`id`, `user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `text`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('', '".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '$dbtextjack', '$zufalls_dice1zahl', '$zufalls_dice2zahl', '$zufalls_dice3zahl', '$zufalls_dice4zahl', '$zufalls_dice5zahl');");
} elseif ($zufalls_dicezahl == $lucky_number) {
mysql_query("INSERT INTO ".DB_D1DW_log." (`id`, `user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `text`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('', '".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '$dbtextluckyn', '$zufalls_dice1zahl', '$zufalls_dice2zahl', '$zufalls_dice3zahl', '$zufalls_dice4zahl', '$zufalls_dice5zahl');");
} else {
mysql_query("INSERT INTO ".DB_D1DW_log." (`id`, `user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `text`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('', '".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '$dbtextnjack', '$zufalls_dice1zahl', '$zufalls_dice2zahl', '$zufalls_dice3zahl', '$zufalls_dice4zahl', '$zufalls_dice5zahl');");
}
///////////////
score_free("DiceCost", "DiCo", "".$wurfkosten."", 999, "N", 0, 0);
mysql_query("UPDATE ".DB_D1DW_conf." SET jack_pot = '$jackpot' WHERE conf = '1' ");

} else {
mysql_query("UPDATE ".DB_D1DW_user." SET time = '".mktime(24,00,0)."', zahl = '$zufalls_dicezahl', sonstiges = '".time()."', wurfel1 = '".$zufalls_dice1zahl."', wurfel2 = '".$zufalls_dice2zahl."', wurfel3 = '".$zufalls_dice3zahl."', wurfel4 = '".$zufalls_dice4zahl."', wurfel5 = '".$zufalls_dice5zahl."' WHERE user_id = '".$userdata['user_id']."' ");

//6loguser
If ($zufalls_dicezahl == $sechser_multi) {
mysql_query("INSERT INTO ".DB_D1DW_log." (`id`, `user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `text`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('', '".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '$dbtextjack', '$zufalls_dice1zahl', '$zufalls_dice2zahl', '$zufalls_dice3zahl', '$zufalls_dice4zahl', '$zufalls_dice5zahl');");
} elseif ($zufalls_dicezahl == $lucky_number) {
mysql_query("INSERT INTO ".DB_D1DW_log." (`id`, `user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `text`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('', '".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '$dbtextluckyn', '$zufalls_dice1zahl', '$zufalls_dice2zahl', '$zufalls_dice3zahl', '$zufalls_dice4zahl', '$zufalls_dice5zahl');");
} else {
mysql_query("INSERT INTO ".DB_D1DW_log." (`id`, `user_id`, `user_name`, `time`, `zahl`, `sonstiges`, `text`, `wurfel1`, `wurfel2`, `wurfel3`, `wurfel4`, `wurfel5`) VALUES ('', '".$userdata['user_id']."', '".$userdata['user_name']."', '".mktime(24,00,0)."', '".$zufalls_dicezahl."', '".time()."', '$dbtextnjack', '$zufalls_dice1zahl', '$zufalls_dice2zahl', '$zufalls_dice3zahl', '$zufalls_dice4zahl', '$zufalls_dice5zahl');");
}
//////////

score_free("DiceCost", "DiCo", "".$wurfkosten."", 999, "N", 0, 0);
mysql_query("UPDATE ".DB_D1DW_conf." SET jack_pot = '$jackpot' WHERE conf = '1' ");
}

//Luckynumber
If ($zufalls_dicezahl == $lucky_number) {
score_free("DiceLucky", "DiLu", "".$lucky_win."", 999, "P", 0, 0);
}
//Luckynumber

If ($zufalls_dicezahl == $sechser_multi) {
score_free("DiceWin", "DiWi", "".$dicewin."", 999, "P", 0, 0);
mysql_query("UPDATE ".DB_D1DW_conf." SET jack_pot = '".$d1dwsettings['dwin_jstart']."' WHERE conf = '1' ");
}
redirect(INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php");
}
} 
} else {
redirect(INFUSIONS."D1_dice_to_win_panel/D1_dice_to_win.php");
}
}
echo "<hr><center><b>".$num_rows5."</b> ".$locale['D1DW_seite_020']." <b>$dicechance</b> ".$locale['D1DW_seite_021']."</center>";
echo "<hr>";
echo '<div id="dice_refresh">';
echo "<b><center><u>".$locale['D1DW_seite_037']." ".$d1dwsettings['dwin_wurfanz']." ".$locale['D1DW_seite_038']."</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_log." ORDER BY sonstiges DESC LIMIT 0,".$d1dwsettings['dwin_wurfanz']."");
if (dbrows($result4)) {
	while($dice_to_win = dbarray($result4)) {

	if ($dice_to_win['zahl'] == $sechser_multi) {
	$font_dcolor = "#808000";
	} elseif ($dice_to_win['zahl'] == $lucky_number) {
	$font_dcolor = "#008000";
	} else {
	$font_dcolor = "";
	}

	echo "<center>".date("d.m.Y H:i:s",$dice_to_win['sonstiges'])." - <span style='color: ".$font_dcolor.";'><b>".$dice_to_win['user_name']."</b> ".$locale['D1DW_seite_023']." <b>".$dice_to_win['zahl']."</b> ".$dice_to_win['text']."</span></center>";
}
} else {
	echo "<center>".$locale['D1DW_seite_024']."</center>";
}
echo "<b><center><span class='small'>".$locale['D1DW_seite_025']." ".date("d.m.Y H:i:s",time())."</span></center></b>";
echo "</div>";

//gamechat
if ($d1dwsettings['chat_stat'] == "1") {
// Textlänge einstellen:
$chat_max_length = 65;
//

echo "<hr>";
echo '<div id="chat_refresh">';
echo "<b><center><u>".$locale['D1DW_seite_037']." ".$d1dwsettings['dwin_chatanz']." ".$locale['D1DW_seite_039']."</u></center></b>";
$result4 = dbquery("SELECT * FROM ".DB_D1DW_chat." ORDER BY time DESC LIMIT 0,".$d1dwsettings['dwin_chatanz']."");
if (dbrows($result4)) {
	while($dice_chatss = dbarray($result4)) {

	if ($dice_chatss['user_id'] == $userdata['user_id']) {
	$font_dcolor = "#0080c0";
	} else {
	$font_dcolor = "";
	}

	echo "[".date("d.m.Y H:i:s",$dice_chatss['time'])."] <span style='color: ".$font_dcolor.";'><b>".$dice_chatss['user_name']."</b>: ".$dice_chatss['text']."</span><br>";
}
} else {
	echo "<center>".$locale['D1DW_seite_040']."</center>";
}
echo "<center><b><span class='small'>".$locale['D1DW_seite_025']." ".date("d.m.Y H:i:s",time())."</span></center></b>";
echo '</div>';

echo "<hr>";

echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='500px'>
		<tr>
			<td class='tbl1' colspan='2' style='text-align:center;'>";
echo '<form name="message" action="" autocomplete="off" id="chat_ssend">';
echo'<center><b>Chat Nachricht senden:</b>';
	echo "<div id='charsLeftchat'>(".sprintf($locale['D1DW_seite_028'], $chat_max_length).")</div>";
echo "<input type='hidden' name='d1dtw_user_id' id='d1dtw_user_id' value='".$userdata['user_id']."' />";
echo "<input type='hidden' name='d1dtw_user_name' id='d1dtw_user_name' value='".$userdata['user_name']."' />";
echo "<input type='hidden' name='d1dtw_timer' id='d1dtw_timer' value='".mktime(24,00,0)."' />";
echo "<input type='hidden' name='d1dtw_time' id='d1dtw_time' value='".time()."' />";
//echo "<textarea name='text' id='chat_text' class='textbox' style='width:450px' maxlength='".$chat_max_length."' rows='1' cols='65''></textarea><br />\n";
echo'<input type="text" name="text" id="chat_text" class="textbox" style="width:450px" maxlength="'.$chat_max_length.'"><br>';
echo '<input type="submit" name="chat_send" id="chat_send"  class="button" value="Senden"></form></center>';
			echo "</td>
		</tr></table>";
}
//gamechat

echo "<div align='right'><a href='http://www.deeone.de' target='_blank' title='".$locale['D1DW_title']." v".$locale['D1DW_vers']." &copy; DeeoNe ".showdate("%Y",time())."'><span class='small'>&copy;</span></a></div>";
closetable();
} else {
opentable($locale['D1DW_seite_001']);
echo '<center><b><font color="#c00000"><img align="absmiddle" src="'.INFUSIONS.'D1_dice_to_win_panel/images/stop.png"/> '.$locale["D1DW_seite_026"].' <img align="absmiddle"  src="'.INFUSIONS.'D1_dice_to_win_panel/images/stop.png"/></font><br></b></center>';
closetable();
}
} else {
opentable($locale['D1DW_seite_001']);
echo "".$locale['D1DW_seite_027']."";
closetable();
}

if (function_exists("d1dicetowinsec2")) {
	d1dicetowinsec2();
} else {
	redirect(BASEDIR."index.php");
}

require_once THEMES."templates/footer.php";

echo "<script type='text/javascript'>
	$(document).ready(function(){
	$('#chat_text').keyup(function(){
		var max = parseInt($(this).attr('maxlength'));
		if($(this).val().length > max){
			$(this).val($(this).val().substr(0, $(this).attr('maxlength')));
		}

		$('#charsLeftchat').html('<span style=\'color:#0080c0;\'>".$locale['D1DW_seite_029']." ' + (max - $(this).val().length) + ' ".$locale['D1DW_seite_030']."</span>');
	});
	});
</script>";
$dicer = $d1dwsettings['ref_dice']*1000;
$chatr = $d1dwsettings['ref_chat']*1000;

 echo "<script>
 $(document).ready(function() {

   var auto_refresh = setInterval( function() { $('#dice_refresh').load('/infusions/D1_dice_to_win_panel/inc/dice_ref.php'); }, ".$dicer.");

});
</script>";

//ALT_S
/*
echo "<script>
 $(document).ready(function() {

   var auto_refresh = setInterval( function() { $('#sperr_refresh').load('/infusions/D1_dice_to_win_panel/inc/sperr_ref.php'); }, 1000);

});
</script>";
*/
//ALT_E

echo "<script>
 $(document).ready(function() {

   var auto_refresh = setInterval( function() { $('#chat_refresh').load('/infusions/D1_dice_to_win_panel/inc/chat_ref.php'); }, ".$chatr.");

});
</script>";
?>
<script type='text/javascript'>
$(function(){
$('#chat_send').submit(function() {
    if($('#chat_text').val() == '') {
        alert('Bitte Chat Nachricht eingeben!');
        $('#text').focus();
        return false;
    }
});
});
</script>
<script type='text/javascript'>
$(document).ready(function(){
	$('.optionen').hide();
	//If user submits the form
	$("#chat_send").click(function(){
		var clienttext = $("#chat_text").val();
		var clientid = $("#d1dtw_user_id").val();
		var clientname = $("#d1dtw_user_name").val();
		var clienttimer = $("#d1dtw_user_timer").val();
		var clienttime = $("#d1dtw_user_time").val();
		$.post("post.php", {text: clienttext, d1dtw_user_id:clientid, d1dtw_user_name:clientname, d1dtw_user_timer:clienttimer, d1dtw_user_time:clienttime});
		$("#chat_text").attr("value", "");
		$("#chat_text").focus();
		return false;
	});
});
</script>