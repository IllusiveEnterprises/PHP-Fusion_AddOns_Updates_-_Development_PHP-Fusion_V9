<?php
include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";
//$mfpsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores_conf.""));
$userpnsettings = dbarray(dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id='".$userdata['user_id']."'"));

//Nachrichten Betreff
$active_user = "Premium-Account verlaengert";
$active_admin = "".$userdata['user_name']." verlaengert Premium-Account";
$wait_user = "Premium-Account aktiviert";
$wait_admin = "".$userdata['user_name']." aktiviert Premium-Account";
$gif_user = "Gratis Premium-Account";
//Nachrichten Betreff Ende

$nachricht_2 = "Hallo ".$userdata['user_name'].",

Vielen dank, dass du deinen Premium-Account verl&auml;ngert hast.
Wir W&uuml;nschen dir weiterhin Viel Spa&szlig; in unserer Community.

Dein Premium-Account l&auml;uft jetzt bis zum: <b>".showdate("longdate", $userpnsettings['bis'])."</b>

Liebe Gr&uuml;&szlig;e, dein ".$settings['sitename']." Team!";

$nachricht_3 = "<b>".$userdata['user_name']."</b> hat soeben sein Premium-Account bis zum <b>".showdate("longdate", $userpnsettings['bis'])."</b> verl&auml;ngert.";

$nachricht_4 = "Hallo ".$userdata['user_name'].",

Vielen dank, dass du dich f&uuml;r einen Premium-Account entschieden hast.
Absofort kannst du die Premium Vorteile nutzen.


Wir W&uuml;nschen dir weiterhin Viel Spa&szlig; in unserer Community.

Dein Premium-Account l&auml;uft jetzt bis zum: <b>".showdate("longdate", $userpnsettings['bis'])."</b>

Liebe Gr&uuml;&szlig;e, dein ".$settings['sitename']." Team!";

$nachricht_5 = "<b>".$userdata['user_name']."</b> hat soeben einen Premium-Account bis zum <b>".showdate("longdate", $userpnsettings['bis'])."</b> aktiviert.";


$nachricht_10 = "Die Community schenkt dir heute einen Gratis Platin-Account.
Bis zum ablauf dieser zeit kannst du unsere Premium Vorteile nutzen.

Liebe Gr&uuml;&szlig;e, dein ".$settings['sitename']." Team!";

?>