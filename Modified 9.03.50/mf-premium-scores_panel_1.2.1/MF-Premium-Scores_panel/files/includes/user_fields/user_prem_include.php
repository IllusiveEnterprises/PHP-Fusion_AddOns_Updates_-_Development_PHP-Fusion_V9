<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2010 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_prem_include.php
| Author: DeeoNe
 Adapted to php-fusion-9 by Douwe Yntema
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

include INFUSIONS."MF-Premium-Scores_panel/infusion_db.php";

if ($profile_method == "input") {

    defined('IN_FUSION') || exit;


    } else if ($profile_method == "display") {
    //prem
     $result =  (dbquery("SELECT * FROM ".DB_mfp_scores." WHERE user_id='".$user_data['user_id']."'"));
     $aktiv = dbarray ($result);
     if ($aktiv['status'] =='aktiv') {
        $icon = "<img src='".IMAGES."prem.png' title='Premium' alt='Premium'/>";
         $field_value =  $locale['uf_prem_004']."<b>".showdate("longdate", $aktiv['bis'])."</b>";
     } else {
         $icon = "";
         $field_value = $locale['uf_prem_002'];
     }

        $user_fields = [
            'icon'  => $icon,
            'title' => $locale['uf_prem'],
            'value' => $field_value ?: ''
        ];
}




?>