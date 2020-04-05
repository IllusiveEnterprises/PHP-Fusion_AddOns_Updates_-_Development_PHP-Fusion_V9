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
if (!defined("IN_FUSION")) { die("Access Denied"); }

$zufzahl = rand(1,5); // Die 5 steht f&uuml;r Anzahl der Zufallstexte, dies Anpassen, wenn mehr hinzugef&uuml;gt werden.
$wmdgtext[1] = "Was machst du gerade, ".$userdata['user_name']."?";
$wmdgtext[2] = "Wie geht es dir, ".$userdata['user_name']."?";
$wmdgtext[3] = "Hast du was vor, ".$userdata['user_name']."?";
$wmdgtext[4] = "M&ouml;chtest du was teilen, ".$userdata['user_name']."?";
$wmdgtext[5] = "Hast du schon was geplant, ".$userdata['user_name']."?";

?>
