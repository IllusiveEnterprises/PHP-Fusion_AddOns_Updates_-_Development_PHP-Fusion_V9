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
if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."types.php")) {
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."types.php";
} else {
 	include INFUSIONS."D1_pinnwand_panel/locale/German/types.php";
}
$type = $_GET['type'];
if (isset($_GET['id'])) $id = $_GET['id'];
if (!isset($type)) header("Location: D1_pinnwand.php");
opentable($lang['bs_tstart']);
if ($type == 'd') {
	$message = "".$lang['bs_tdelpinnwand']." <br /> ".$lang['bs_tlistpinnwands']." <a href='D1_pinnwand.php'>D1_pinnwand.php</a>";
} else if ($type == 'c') {
	$message = "".$lang['bs_tnewpinnwand']."<br /><br />".$lang['bs_tlistpinnwands']." <a href='D1_pinnwand.php'>D1_pinnwand.php</a>\n";
} else if ($type == 'e') {
	$message = "".$lang['bs_teditpinnwand']."<br /><br />".$lang['bs_tviewpinnwand']." <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&id=$id'>D1_pinnwand.php?page=pinnwand_id&id=$id</a>\n";
}
	echo "<div align='center'>".$message."</div>\n";
closetable();
?>