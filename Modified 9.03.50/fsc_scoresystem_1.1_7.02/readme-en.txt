--------------------------------------
[INFUSION] fsc_scoresystem V1.1(v7)
For PHP Fusion Version 9
--------------------------------------

-------------
0. Introduction
-------------

Score System for PHP-Fusion V9
*Adminpassword fixt for PHP-Fusion 7.02
*Readme for PHP-Fusion 7.02

---------------------------------------
1. Installation
---------------------------------------

Before installing, please make a full backup of your site and database.

Let's start.

1. Upload the contents of the "php_files" folder to your web space or server.

2. Now install the ScoreSystem in the admin menu. (Administration => System Admin =>
   Infusions)

3. Open die maincore.php

3.1 Search for (around line 32):

require_once __DIR__.'/includes/core_resources_include.php';

insert underneath:

// Install ScoreSystem power by PHPFusion-SupportClub.de ///////////////
require_once INFUSIONS."scoresystem_panel/scoresystem_main_include.php";
require_once INFUSIONS."scoresystem_panel/scoresystem_redirect_include.php";
////////////////////////////////////////////////////////////////////////


3.2 Save and upload.

3.3 Open footer_includes.php and add the code:

// Install ScoreSystem power by PHPFusion-SupportClub.de /////////////////
require_once INFUSIONS."scoresystem_panel/scoresystem_footer_include.php";
//////////////////////////////////////////////////////////////////////////

3.4  Save and upload

3.5 Now we come to the real thing, the setuser is empty in 7.02.xx.

Here is the solution:

Open maincore.php and search for (around line 180):

unset($auth, $_POST['user_name'], $_POST['user_pass']);

insert underneath:

score_positive("LOGIN");

The entire login section should then look like this:


/**
 * Login / Logout / Revalidate
 */
if (isset($_POST['login']) && isset($_POST['user_name']) && isset($_POST['user_pass'])) {
    if (\defender::safe()) {
        $auth = new Authenticate($_POST['user_name'], $_POST['user_pass'], (isset($_POST['remember_me']) ? TRUE : FALSE));
        $userdata = $auth->getUserData();
        unset($auth, $_POST['user_name'], $_POST['user_pass']);
        score_positive("LOGIN");
        redirect(FUSION_REQUEST);
    }
} else if (isset($_GET['logout']) && $_GET['logout'] == "yes") {
    $userdata = Authenticate::logOut();
    $request = clean_request('', ['logout'], FALSE);
    redirect($request);
} else {
    $userdata = Authenticate::validateAuthUser();
}

Save and upload


3.6 Continue with the Shoutbox:

Open the shoutbox.inc and search for (around line 128):

if (!flood_control("shout_datestamp", DB_SHOUTBOX, "shout_name='".$this->data['shout_name']."'")) {
     if (\defender::safe()) {
          dbquery_insert(DB_SHOUTBOX, $this->data, empty($this->data['shout_id']) ? "save" : "update");


insert underneath:

score_positive("SHBOX");

Save and upload


3.7 Open file download.php and search for (around line 48):

if (isset($_GET['file_id']) && isnum($_GET['file_id'])) {
    $res = 0;
    $data = dbarray(dbquery("SELECT download_url, download_file, download_cat, download_visibility FROM ".DB_DOWNLOADS." WHERE download_id='".intval($_GET['file_id'])."'"));
    if (checkgroup($data['download_visibility'])) {
        $result = dbquery("UPDATE ".DB_DOWNLOADS." SET download_count=download_count+1 WHERE download_id='".intval($_GET['file_id'])."'");

        if (!empty($data['download_file']) && file_exists(DOWNLOADS.'files/'.$data['download_file'])) {
            $res = 1;
            require_once INCLUDES."class.httpdownload.php";
            ob_end_clean();
            $object = new \PHPFusion\httpdownload;
            $object->set_byfile(DOWNLOADS.'files/'.$data['download_file']);
            $object->use_resume = TRUE;
            $object->download();
            exit;
        } else if (!empty($data['download_url'])) {
            $res = 1;
            $url_prefix = (!strstr($data['download_url'], "http://") && !strstr($data['download_url'], "https://") ? "http://" : '');
            redirect($url_prefix.$data['download_url']);
        }
    }
    if ($res == 0) {
        redirect(DOWNLOADS."downloads.php");
    }
}


Replace with :


// download the file
if (isset($_GET['file_id']) && isnum($_GET['file_id'])) {
    $res = 0;
    if (score_negative("DOWNL")) {
        $data = dbarray(dbquery("SELECT download_url, download_file, download_cat, download_visibility FROM ".DB_DOWNLOADS." WHERE download_id='".intval($_GET['file_id'])."'"));
        if (checkgroup($data['download_visibility'])) {
            $result = dbquery("UPDATE " . DB_DOWNLOADS . " SET download_count=download_count+1 WHERE download_id='" . intval($_GET['file_id']) . "'");

            if (!empty($data['download_file']) && file_exists(DOWNLOADS . 'files/' . $data['download_file'])) {
                $res = 1;
                require_once INCLUDES . "class.httpdownload.php";
                ob_end_clean();
                $object = new \PHPFusion\httpdownload;
                $object->set_byfile(DOWNLOADS . 'files/' . $data['download_file']);
                $object->use_resume = TRUE;
                $object->download();
                exit;
            } else if (!empty($data['download_url'])) {
                $res = 1;
                $url_prefix = (!strstr($data['download_url'], "http://") && !strstr($data['download_url'], "https://") ? "http://" : '');
                redirect($url_prefix . $data['download_url']);
         }
      }
    } else {
   if ($res == 0) { redirect("downloads.php"); }
    }
}


Save and upload


for PHP-Fusion 9.03.50:
3.8 Open file /includes/dynamics/includes/form_text.php and search for (around line 111):
   $valid_types = [
        'text', 'number', 'password', 'email', 'url', 'color', 'date', 'datetime', 'datetime-local', 'month', 'range', 'search', 'tel', 'time', 'week',
    ];


replace with:
   $valid_types = [
        'text', 'number', 'password', 'email', 'url', 'color', 'date', 'datetime', 'datetime-local', 'month', 'range', 'search', 'tel', 'time', 'week', 'hidden',
    ];


search for (arond line 162):
    switch ($options['type']) {
        case "number":
            $input_type = "number";
            $min = ((!empty($options['number_min']) || $options['number_min'] === "0") && isnum($options['number_min']) ? "min='".$options['number_min']."' " : '');
            $max = ((!empty($options['number_max']) || $options['number_max'] === "0") && isnum($options['number_max']) ? "max='".$options['number_max']."' " : '');
            // $step = "step='".str_replace(",", ".", $options['number_step'])."' ";
            $step = "step='any' ";
            break;
        case "text":
            $input_type = "text";
            break;
        case "password":
            $input_type = "password";


replace with:

    switch ($options['type']) {
        case "number":
            $input_type = "number";
            $min = ((!empty($options['number_min']) || $options['number_min'] === "0") && isnum($options['number_min']) ? "min='".$options['number_min']."' " : '');
            $max = ((!empty($options['number_max']) || $options['number_max'] === "0") && isnum($options['number_max']) ? "max='".$options['number_max']."' " : '');
            // $step = "step='".str_replace(",", ".", $options['number_step'])."' ";
            $step = "step='any' ";
            break;
        case "text":
            $input_type = "text";
            break;
        case "hidden":
            $input_type = "hidden";
            break;
        case "password":
            $input_type = "password";

Save and upload

Wish you a lot of fun with it.

