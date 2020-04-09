--------------------------------------
[INFUSION] fsc_scoresystem V1.1(v7)
Für PHP Fusion Version 7.02.XX
--------------------------------------

-------------
0. Einleitung
-------------

Score System für PHP-Fusion v7.02.xx
*Adminpassword gefixt für PHP-Fusion 7.02
*Readme für PHP-Fusion 7.02

---------------------------------------
1. Installation
---------------------------------------

Vor der Installation macht ihr bitte ein komplettes Backup eurer Seite sowie Datenbank.

Fangen wir mal an.

1. Lade das den Inhalt des Ordners "php_files" auf deinen Webspace bzw. Server hoch.

2. Installiere nun das ScoreSystem im Adminmenü. (Administration => System Admin =>
Infusions)

3. Öffne die maincore.php

3.1 Nun suche nach:

// Load the Global language file
include LOCALE.LOCALESET."global.php";


darunter einfügen:

// Install ScoreSystem power by PHPFusion-SupportClub.de ///////////////
require_once INFUSIONS."scoresystem_panel/scoresystem_main_include.php";
////////////////////////////////////////////////////////////////////////


3.2 Nun suche nach:

function redirect($location, $script = false) {


darunter einfügen:

// Install ScoreSystem power by PHPFusion-SupportClub.de ///////////////////
require_once INFUSIONS."scoresystem_panel/scoresystem_redirect_include.php";
////////////////////////////////////////////////////////////////////////////


3.3 Speichern und hochladen.

3.4 Öffne die footer_includes.php und füge den Code hinzu:

// Install ScoreSystem power by PHPFusion-SupportClub.de /////////////////
require_once INFUSIONS."scoresystem_panel/scoresystem_footer_include.php";
//////////////////////////////////////////////////////////////////////////


3.5 Speichern und hochladen.


3.6 Nun kommen wir aber zum eigentlichen, die setuser ist in der 7.02.xx leer, wohin mit der Funktion ?

Hier ist die Lösung:

Öffne die maincore.php und suche nach:

unset($auth, $_POST['user_name'], $_POST['user_pass']);


darunter einfügen:

score_positive("LOGIN");


Der gesamte Loginabschnitt sollte dann so aussehen:


// Log in user
if (isset($_POST['login']) && isset($_POST['user_name']) && isset($_POST['user_pass'])) {
   $auth = new Authenticate($_POST['user_name'], $_POST['user_pass'], (isset($_POST['remember_me']) ? true : false));
   $userdata = $auth->getUserData();
   unset($auth, $_POST['user_name'], $_POST['user_pass']);
   score_positive("LOGIN");
} elseif (isset($_GET['logout']) && $_GET['logout'] == "yes") {
   $userdata = Authenticate::logOut();
   redirect(BASEDIR."index.php");
} else {
   $userdata = Authenticate::validateAuthUser();
}




Speichern und hochladen.


3.7 Weiter mit der Shoutbox:

Öffne die shoutbox_panel.php und suche nach :


 if (!flood_control("shout_datestamp", DB_SHOUTBOX, "shout_ip='".USER_IP."'")) {
            $result = dbquery("INSERT INTO ".DB_SHOUTBOX." (shout_name, shout_message, shout_datestamp, shout_ip, shout_ip_type, shout_hidden) VALUES ('$shout_name', '$shout_message', '".time()."', '".USER_IP."', '".USER_IP_TYPE."', '0')")



darunter einfügen:

score_positive("SHBOX");


Speichern und hochladen.


3.8 Öffne die shoutbox_archiv.php und suche nach :


if ((iADMIN && checkrights("S")) || (iMEMBER && dbcount("(shout_id)", DB_SHOUTBOX, "shout_id='".$_GET['shout_id']."' AND shout_name='".$userdata['user_id']."'"))) {
            if ($shout_message) {
               $result = dbquery("UPDATE ".DB_SHOUTBOX." SET shout_message='$shout_message' WHERE shout_id='".$_GET['shout_id']."'".(iADMIN ? "" : " AND shout_name='".$userdata['user_id']."'"));




darunter einfügen:

score_positive("SHBOX");


Speichern und hochladen


3.9 Öffne die download.php und suche nach:


// download the file
if (isset($_GET['file_id']) && isnum($_GET['file_id'])) {
   $download_id = stripinput($_GET['file_id']);
   $res = 0;
   if ($data = dbarray(dbquery("SELECT download_url, download_file, download_cat FROM ".DB_DOWNLOADS." WHERE download_id='".$download_id."'"))) {
      $cdata = dbarray(dbquery("SELECT download_cat_access FROM ".DB_DOWNLOAD_CATS." WHERE download_cat_id='".$data['download_cat']."'"));
      if (checkgroup($cdata['download_cat_access'])) {
         $result = dbquery("UPDATE ".DB_DOWNLOADS." SET download_count=download_count+1 WHERE download_id='".$download_id."'");
         if (!empty($data['download_file']) && file_exists(DOWNLOADS.$data['download_file'])) {
            $res = 1;
            require_once INCLUDES."class.httpdownload.php";
            ob_end_clean();
            $object = new httpdownload;
            $object->set_byfile(DOWNLOADS.$data['download_file']);
            $object->use_resume = true;
            $object->download();
            exit;
         } elseif (!empty($data['download_url'])) {
            $res = 1;
            redirect($data['download_url']);
         }
      }
   }
   if ($res == 0) { redirect("downloads.php"); }
}





Ersetze dies mit :


// download the file
if (isset($_GET['file_id']) && isnum($_GET['file_id'])) {
   $download_id = stripinput($_GET['file_id']);
   $res = 0;
   if (score_negative("DOWNL")) {
   if ($data = dbarray(dbquery("SELECT download_url, download_file, download_cat FROM ".DB_DOWNLOADS." WHERE download_id='".$download_id."'"))) {
      $cdata = dbarray(dbquery("SELECT download_cat_access FROM ".DB_DOWNLOAD_CATS." WHERE download_cat_id='".$data['download_cat']."'"));
      if (checkgroup($cdata['download_cat_access'])) {
         $result = dbquery("UPDATE ".DB_DOWNLOADS." SET download_count=download_count+1 WHERE download_id='".$download_id."'");
         if (!empty($data['download_file']) && file_exists(DOWNLOADS.$data['download_file'])) {
            $res = 1;
            require_once INCLUDES."class.httpdownload.php";
            ob_end_clean();
            $object = new httpdownload;
            $object->set_byfile(DOWNLOADS.$data['download_file']);
            $object->use_resume = true;
            $object->download();
            exit;
         
         } elseif (!empty($data['download_url'])) {
            $res = 1;
            redirect($data['download_url']);
            
         }
      }
   }
    } else {
   if ($res == 0) { redirect("downloads.php"); }
    }
}




Speichern und hochladen.

Wünsche euch viel spass damit.

