<?php
include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";
//$mfpsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));
$userpnsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id='".$userdata['user_id']."'"));

//Nachrichten Betreff
$active_user = "Premium account extended";
$active_admin = "".$userdata['user_name']." renews premium account";
$wait_user = "Premium account activated";
$wait_admin = "".$userdata['user_name']." activates premium account";
$gif_user = "Free premium account";
//Nachrichten Betreff Ende

$nachricht_2 = "Hello ".$userdata['user_name'].",

Thank you for renewing your premium account.
We wish you a lot of fun in our community.

Your premium account now runs until: <b>".showdate("longdate", $userpnsettings['bis'])."</b>

Dear greetings, yours ".$settings['sitename']." Team!";

$nachricht_3 = "<b>".$userdata['user_name']."</b> just got his premium account until <b>".showdate("longdate", $userpnsettings['bis'])."</b> extended.";

$nachricht_4 = "Hello ".$userdata['user_name'].",

Thank you for choosing a premium account.
You can now benefit from the premium benefits.


We wish you a lot of fun in our community.

Your premium account now runs until:<b>".showdate("longdate", $userpnsettings['bis'])."</b>

Dear greetings, yours ".$settings['sitename']." Team!";

$nachricht_5 = "<b>".$userdata['user_name']."</b> just got his premium account until <b>".showdate("longdate", $userpnsettings['bis'])."</b> activated.";


$nachricht_10 = "The community gives you a free platinum account today.
Until the end of this time, you can take advantage of our premium benefits.

Dear greetings, yours ".$settings['sitename']." Team!";

?>