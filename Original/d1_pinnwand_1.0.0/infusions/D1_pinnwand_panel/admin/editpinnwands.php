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

if (isset($_GET['rowstart'])) $rowstart = $_GET['rowstart']; 
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;
$pinnwandgas = $d1_pinnwand_settings['pinnwand_userlimit']*2;
opentable($locale['TIBLAP061']);
$result = dbquery("SELECT * FROM ".$db_prefix."d1_pinnwand_system bs
LEFT JOIN ".DB_PREFIX."users bu ON bs.pinnwand_writer=bu.user_id
ORDER BY pinnwand_id DESC LIMIT $rowstart,$pinnwandgas");
	if (dbrows($result)) {
		while ($data = dbarray($result)) {
			echo "[<a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&amp;id=".$data['pinnwand_id']."&amp;page=editpinnwand'>".$locale['TIBLAP060']."</a>] "; 
			if ($data['user_name'])
				echo "<a href='".BASEDIR."profile.php?lookup=".$data['pinnwand_writer']."'>".$data['user_name']."</a>";
			else
				echo $locale['TIBLAP017']; 
			echo " (".($data['pinnwand_ip'] ? $data['pinnwand_ip'] : "0.0.0.0").") - ";
			
			echo " (".showdate("shortdate", $data['pinnwand_date']).") <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&amp;id=".$data['pinnwand_id']."'>".trimlink($data['pinnwand_text'], 40)."</a><br>"; 
		}
	} else
		echo $locale['TIBLAP062'];

if ($counter > $pinnwandgas)
	echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$pinnwandgas,$counter,3,FUSION_SELF."?aid=$aid&amp;page=editpinnwands&amp;")."</div>";
closetable();
?>