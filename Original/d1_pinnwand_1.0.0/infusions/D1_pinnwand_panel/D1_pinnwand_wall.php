<?php
/*----------------------------------------------------+
| D1 Pinnwand                           	
|-----------------------------------------------------|
| Author: DeeoNe
| Web: http://www.DeeoNe.de          	
| Email: deeone@online.de                  	
|-----------------------------------------------------|
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+----------------------------------------------------*/
require_once "../../maincore.php";
require_once THEMES."templates/header.php";
require_once INFUSIONS."D1_pinnwand_panel/includes/functions.php";
include_once INFUSIONS."sun_vote_addon/includes/sun_vote_include.php";

if (!defined("IN_FUSION")) { header("Location:../../index.php"); exit; }
if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_panel.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_panel.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/pinnwand_panel.php";
}

// Check if locale file is available matching the current site locale setting.
if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".$settings['locale'].".php")) {
	// Load the locale file matching the current site locale setting.
	include INFUSIONS."D1_pinnwand_panel/locale/".$settings['locale'].".php";
} else {
	// Load the infusion's default locale file.
	include INFUSIONS."D1_pinnwand_panel/locale/German.php";
}

	$d1pwss = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system_settings"));

if (d1pinnwandSet("inf_name") == "" || d1pinnwandSet("inf_name") != md5("D1 Pinnwand") || d1pinnwandSet("site_url") == "" || d1pinnwandSet("site_url") != md5("D1 Pinnwand".$settings['siteurl'])) {
		redirect(BASEDIR."index.php");
    }

include_once INCLUDES."bbcode_include.php";
// In pixels
$height = "50";
$width = "50";
// Until the subject should trim - Bigger sidepanels might want a higher value
$trim = "20"; 
// Limit
$limit = "".$d1pwss['pinnwand_limit']."";

define("pinnwandCOPY", "<div style='text-align:center; margin:5px;'>D1 Pinnwand ".$locale['D1PW_vers']." &copy;2013 by <a href='http://www.deeone.de' target='_blank'>DeeoNe</a></div>");

opentable("Pinnwand");
if ((iMEMBER) || ($d1pwss['pinnwand_access'] == '0')) {

if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."createpinnwand.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."createpinnwand.php";
	//include BASEDIR."locale/".LOCALESET."register.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/createpinnwand.php";
}
if (file_exists(INFUSIONS."D1_pinnwand_panel/pinnwand_includes.php")) {
	include INFUSIONS."D1_pinnwand_panel/pinnwand_includes.php";
	d1_pinnwand_createpinnwand();
} else {
	opentable("Error");
	echo 'Failed loading requested file (pinnwand_include.php)! Please check your files.';
	closetable();
}
include INFUSIONS."D1_pinnwand_panel/includes/comments_include.php";
$result = dbquery("SELECT * FROM ".$db_prefix."d1_pinnwand_system bs
LEFT JOIN ".DB_PREFIX."users bu ON bs.pinnwand_writer=bu.user_id
ORDER BY pinnwand_id DESC LIMIT 0,$limit");
	while ($data = dbarray($result)) {
	echo "<a id='postx".$data['pinnwand_id']."' name='postx'></a>";
echo "<center><table cellpadding='0' cellspacing='1' width='99%' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td valign='top' width='50px' >";
	echo "<div style='float:left; margin-right:3px; margin-bottom:3px;'>";
	echo "<a href='".BASEDIR."profile.php?lookup=".$data['pinnwand_writer']."' title='".($data['user_name'] ? $data['user_name'] : $locale['TIBLBP002'])."'><img style='border:0;' src='".($data['user_avatar'] ? IMAGES."avatars/".$data['user_avatar'] : INFUSIONS."D1_pinnwand_panel/images/noavatar.gif")."' height='$height' width='$width' alt='".$data['user_name']."' /></a>
		  </div>";
echo "</td><td>";
echo "<center><table cellpadding='0' cellspacing='1' width='95%' class='center tbl' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td>";
		  	echo "<big>&raquo; <a href='".BASEDIR."profile.php?lookup=".$data['pinnwand_writer']."' title='".$data['pinnwand_subject']."'>".trimlink($data['pinnwand_subject'], $trim)."</a></big>";
			//echo " - ".showdate("longdate", $data['pinnwand_date']); 
echo "<br style='clear:both;' />";

			echo parsesmileys(parseubb(nl2br($data['pinnwand_text']))); 
echo "</td></tr></table></center>";
echo "<br style='clear:both;' />";

if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwanduser.php") && file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwanduser.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwanduser.php";
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwandlist.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/pinnwanduser.php";
 	include INFUSIONS."D1_pinnwand_panel/locale/German/pinnwandlist.php";
}

if (file_exists(INFUSIONS."sun_vote_addon/infusion_db.php")) {
$result12 = dbquery("SHOW TABLES LIKE '".DB_PREFIX."sun_vote'");
if (dbrows($result12)) {
$sunvotedbcheck = "OK";
}
}


echo "<a id='commis".$data['pinnwand_id']."' name='commis'></a>";
echo "<center><table cellpadding='0' cellspacing='1' width='95%' class='center tbl1' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td width='33%'>";


if (isset($sunvotedbcheck)) {
$item_id = $data['pinnwand_id'];
$type = "KB";
$text = "das";
$votes = getVotes($item_id, $type, $text);
//echo $votes;
echo '<div align="left" rel-text="das" rel-style="3" rel-type="KB" id="'.$item_id.'" class="voteMe clearfix"></div>';
} else {
//if (iADMIN) {echo "<span style='color:red'>SuN Vote Addon installieren";}
}

$cmts = dbcount("(comment_id)", $prfx."comments", "comment_type='BS' AND comment_item_id='".$data['pinnwand_id']."'");

echo "</td><td width='33%'>";
	if (iMEMBER && $userdata['user_id'] == $data['pinnwand_writer'] || iSUPERADMIN) {
		echo "<div align='middle'>&nbsp;<a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=editpinnwand&amp;id=".$data['pinnwand_id']."'><img style='vertical-align: middle;' src='".INFUSIONS."D1_pinnwand_panel/images/cedit.png' /> Post bearbeiten</a></a>";
	} else { 
		echo "&nbsp;";
	}
//echo '<div align="middle">&nbsp;<a href="infusions/D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&amp;id='.$data['pinnwand_id'].'#comment_message"><img style="vertical-align: middle;" src="'.INFUSIONS.'D1_pinnwand_panel/images/commentr.png" />Kommentieren</a></div>';

echo "</td><td width='33%'>";
echo "<div align='right'><img style='vertical-align: middle;' src='".INFUSIONS."D1_pinnwand_panel/images/leer.png' /> ".showdate("longdate", $data['pinnwand_date'])."</div>"; 
echo "</td></tr></table></center>";

if (isset($sunvotedbcheck)) {
	$result11 = dbquery("SELECT * FROM ".DB_VOTES." WHERE vote_item_id='".$data['pinnwand_id']."' AND vote_type ='KB' ");
	$like_numb = mysql_num_rows($result11);
if ($like_numb > '0') {
if ($like_numb == '1') {
$worttoll = "findet das toll";
} else {
$worttoll = "finden das toll";
}
echo "<center><table cellpadding='0' cellspacing='1' width='95%' class='center tbl1' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td>";
echo '<div align="left"><img title ="Gefallen '.$like_numb.'" style="vertical-align: middle;" src="'.INFUSIONS.'D1_pinnwand_panel/images/toll.png" />';
echo '&nbsp;';
	$result_vote = dbquery("SELECT vote_user_id, vote_item_id FROM ".DB_VOTES."
	WHERE vote_item_id='".$data['pinnwand_id']."' AND vote_type ='KB' ");
	if (dbrows($result_vote)) {
	$aa = 1;
	while ($data_vote = dbarray($result_vote)) {
	$d1pwusername = dbarray(dbquery("SELECT user_id, user_name FROM ".DB_USERS." WHERE user_id='".$data_vote['vote_user_id']."'"));
	$sep = ($aa == 1 ? "" : ", ");
		$urluservote = "<a href='".BASEDIR."profile.php?lookup=".$data_vote['vote_user_id']."'>".$d1pwusername['user_name']."</a>";
		echo $sep.($urluservote);
	$aa++;
	}}
echo "&nbsp$worttoll</div>";
echo "</td></tr></table></center>";
}
} 

if ($cmts > '4') {
echo "<center><table cellpadding='0' cellspacing='1' width='95%' class='center tbl1' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td>";
echo '<div align="left"><img style="vertical-align: middle;" src="'.INFUSIONS.'D1_pinnwand_panel/images/comments.png" />  <a href="'.INFUSIONS.'D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&amp;id='.$data['pinnwand_id'].'#comments">Alle Kommentare Ansehen</a> ('.$cmts.')</div>';
echo "</td></tr></table></center>";
}

echo "<center><table cellpadding='0' cellspacing='1' width='95%' class='center tbl1' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td>";
	showcomments("BS",$prfx."d1_pinnwand_system","pinnwand_id",$data['pinnwand_id'].",D1_pinnwand.php?page=pinnwand_id&amp;id=".$data['pinnwand_id']);
echo "</td></tr></table></center>";

echo "<center><table cellpadding='0' cellspacing='1' width='95%' class='center tbl2' style='margin: 1px 0 1px 0; padding: 2px;'><tr><td width='70px'>";
				if ((iMEMBER) && ($userdata['user_avatar'] && file_exists(IMAGES."avatars/".$userdata['user_avatar']) && $userdata['user_status']!=6 && $userdata['user_status']!=5)) {
					echo"&nbsp;&nbsp;<img style='vertical-align: middle;' src='".IMAGES."avatars/".$userdata['user_avatar']."' width='50' height='50' />&nbsp;";
				} else {
					echo"&nbsp;&nbsp;<img style='vertical-align: middle;' src='".IMAGES."avatars/noavatar50.png' width='50' height='50' />&nbsp;";
				}
echo "</td><td>";
echo '<div align="left">';
///////////////////////////////////////////
$item_idx = $data['pinnwand_id'];

		if (iMEMBER) {
			echo "<form id='commi2' name='commentx' method='post' action='".FUSION_SELF."#postx".$data['pinnwand_id']."'>\n";
			echo "<div align='center' class='tbl'>\n";
			echo "<input type='hidden' name='comment_iid' value='$item_idx'/>\n";
			echo "<textarea name='comment_messagex' id='comminame' cols='80' rows='1' class='textbox' style='width:360px'></textarea><br />\n";
			echo "<input type='submit' name='post_commentx' value='Kommentieren' class='button' onClick='history.back()'/>\n";
			echo "</div>\n</form>\n";
		} else {
			echo $locale['c105']."\n";
		}
if (isset($_POST['post_commentx'])) {
    $userid = $userdata['user_id'];
    $comment_messagex = stripinput($_POST['comment_messagex']);
    $comment_iid = stripinput($_POST['comment_iid']);
if ($comment_messagex != "") {
					require_once INCLUDES."flood_include.php";
					if (!flood_control("comment_datestamp", DB_COMMENTS, "comment_ip='".USER_IP."'")) {
						$result = dbquery("INSERT INTO ".DB_COMMENTS." (comment_item_id, comment_type, comment_name, comment_message, comment_datestamp, comment_ip, comment_hidden) VALUES ('$comment_iid', 'BS', '$userid', '$comment_messagex', '".time()."', '".USER_IP."', '0')");
	$d1pwbid1 = dbarray(dbquery("SELECT pinnwand_writer FROM ".DB_PREFIX."d1_pinnwand_system WHERE pinnwand_id='$comment_iid'"));
	if (($d1pwss['pinnwand_pn'] == '1') && ($d1pwbid1['pinnwand_writer'] != $userdata['user_id'])) {
	//-----USERS PN NOTIFICATION-----//
	$commessage = "".$userdata['user_name']." hat diesen Pinnwand eintrag kommentiert --> [url=".$settings['siteurl']."infusions/D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&id=$comment_iid]gehe zu Post[/url]<br><br>[b][u]Vorschau:[/u][/b]<br>$comment_messagex";
	$result = dbquery("INSERT INTO ".DB_MESSAGES." (
	message_to, message_from, message_subject, message_message, message_smileys, message_read, message_datestamp, message_folder
	) VALUES( '".$d1pwbid1['pinnwand_writer']."', '1', 'Ein Post wurde Kommentiert', '$commessage', 'y', '0', '".time()."', '0')");
	//-----USERS PN NOTIFICATION-----//
	}
					}
}

    redirect(FUSION_SELF);
}
///////////////////////////////////////////
echo '</div>';
echo "</td></tr></table></center>";
echo "</td></tr></table></center>";
echo "<hr>";
	} 
echo "<center><a class='button' href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand_archiv.php' title='Was machst du gerade Archiv'>&middot; Alle Posts Anzeigen ($counter) &middot;</a></center>";
	} else {
	echo "<center><b>--- Pinnwand Beitr&auml;ge nur f&uuml;r Mitglieder sichtbar! ---</b></center>";
	}

closetable();

if (iMEMBER) {
echo "<script type='text/javascript'>
function ValidateForm(frm) {
	if (frm.pinnwand_subject.value==\"\") {
		alert('".$needsubject."');
		return false;
	}
	if (frm.pinnwand_text.value==\"\") {
		alert('".$needcontent."');
		return false;
	}
}
</script>\n";
}
echo pinnwandCOPY;

if (function_exists("d1pinnwandsec2")) {
	d1pinnwandsec2();
} else {
	redirect(BASEDIR."index.php");
}
require_once THEMES."templates/footer.php";
?>