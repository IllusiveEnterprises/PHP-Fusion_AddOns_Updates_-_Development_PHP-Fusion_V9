<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright © 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| ScoreSystem for PHP-Fusion v7
| Author: Ralf Thieme
| Homepage: www.PHPFusion-SupportClub.de
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

if (defined("iMEMBER") && iMEMBER && defined("SCORESYSTEM")) {
	// FORUM
	if (FUSION_SELF == "post.php") {
		// NEW FORUM THREAD
		if (isset($_GET['action']) && $_GET['action'] == "newthread" && isset($_POST['postnewthread'])) {
			global $error, $thread_id;
			if ($error == 0) {
				if ($location == "postify.php?post=new&error=".$error."&forum_id=".$_GET['forum_id']."&thread_id=".$thread_id) {
					score_positive("FOTRD");
				}
			}
		}
		// NEW REPLY
		if (isset($_GET['action']) && $_GET['action'] == "reply" && isset($_POST['postreply'])) {
			global $error, $newpost_id;
			if ($error == 0) {
				if ($location == "postify.php?post=reply&error=".$error."&forum_id=".$_GET['forum_id']."&thread_id=".$_GET['thread_id']."&post_id=".$newpost_id) {
					score_positive("FOBEI");
				}
			}
		}
	}
	
	if (FUSION_SELF == "viewthread.php") {
		// QUICK REPLY
		if (isset($_POST['postquickreply'])) {
			if ($location != "viewthread.php?thread_id=".$_GET['thread_id']) {
				score_positive("FOBEI");
			}
		}
		// FORUM VOTE
		if (isset($_POST['cast_vote']) && (isset($_POST['poll_option']) && isnum($_POST['poll_option']))) {
			global $userdata;
			$result = dbquery("SELECT * FROM ".DB_FORUM_POLL_VOTERS." WHERE forum_vote_user_id='".$userdata['user_id']."' AND thread_id='".$_GET['thread_id']."'");
			if (!dbrows($result)) {
				score_positive("FOVOT");
			}
		}
	}
	// FORUM ENDE
	// MESSAGES
	if (FUSION_SELF == "messages.php") {
		if (isset($_POST['send_message']) && !isset($_POST['chk_sendtoall']) && isnum($_GET['msg_send'])) {
			score_positive("PNSEN");
		}
	}
	// MESSAGES ENDE

}
?>