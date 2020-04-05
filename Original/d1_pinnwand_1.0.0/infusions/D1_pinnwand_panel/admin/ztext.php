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
if (!defined("IN_FUSION")) { header("Location: ".BASEDIR."index.php"); }

if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_admin_panel.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_admin_panel.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/pinnwand_admin_panel.php";
}

	include INFUSIONS."D1_pinnwand_panel/infusion_db.php";



opentable($locale['TIBLAP036']);
echo "<b><font color='#FF0000'>Zum &auml;ndern bitte Folgenden Datei bearbeiten und/oder erweitern:<br>FUSIONROOT/infusions/D1_pinnwand_panel/includes/pinnwand_zufallstext.php</b></font>";
echo "<hr>";
$datei = file("".INFUSIONS."D1_pinnwand_panel/includes/pinnwand_zufallstext.php");


foreach($datei AS $meine_datei)
   {
   echo $meine_datei."<br>";
   }
closetable();
?>