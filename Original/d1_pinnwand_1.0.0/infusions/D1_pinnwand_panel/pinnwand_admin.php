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
require_once("../../maincore.php");
require_once THEMES."templates/admin_header.php";

if (iSUPERADMIN) $tipinnwandyes = 1;
else if (checkRights("D1PW")) $tipinnwandyes = 1;
else $tipinnwandyes = 0;
if ($tipinnwandyes != 1 || $_GET['aid'] != iAUTH) header("Location: ../../index.php");


if (isset($_GET['page'])) $page = $_GET['page'];

if (file_exists(INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_admin_panel.php"))
	include INFUSIONS."D1_pinnwand_panel/locale/".LOCALESET."pinnwand_admin_panel.php";
else
 	include INFUSIONS."D1_pinnwand_panel/locale/German/pinnwand_admin_panel.php";

include ("pinnwand_includes.php");

define("pinnwandCOPY", "<div style='text-align:center; margin:5px;'>D1 Pinwannd 1.0.0 &copy; 2013 by <a href='http://www.deeone.de' target='_blank'>DeeoNe</a></div>");

opentable($locale['TIBLAP001']);
	$aid = $_GET['aid'];
	echo "<div style='text-align:center;'><a href='".INFUSIONS."D1_pinnwand_panel/pinnwand_admin.php?aid=$aid'>".$locale['TIBLAP011']."</a> - <a href='".INFUSIONS."D1_pinnwand_panel/pinnwand_admin.php?aid=$aid&amp;page=ztext'>".$locale['TIBLAP036']."</a> - <a href='".INFUSIONS."D1_pinnwand_panel/pinnwand_admin.php?aid=$aid&amp;page=settings'>".$locale['TIBLAP023']."</a></div>";
	echo "<hr />";
	/*echo "<div style='float:right; text-align:right;'>
		 <form name='uptcheck' method='post' action=''>
		 <input type='hidden' name='currentversion' value='".$d1_pinnwand_settings['version']."' />
		 <a href='javascript:document.uptcheck.submit();'>".$locale['TIBLAP018']."</a><br />
		 </form>";
	if (isset($_POST['currentversion'])) {
		$fp = @fopen("http://engine.redward.org/phpfv7/update/D1_pinnwand_panel/index.php", "r");
		$lversion = @fread($fp, 20);
		@fclose($fp);
		if ($fp) {
			echo $locale['TIBLAP019'].$d1_pinnwand_settings['version'];
			echo " - ".$locale['TIBLAP020'].$lversion."<br />";
			if ($d1_pinnwand_settings['version'] < $lversion) echo "<a href='http://engine.redward.org/phpfv7/download_1-1-D1_pinnwand_panel_1.50_beta.html'>".$locale['TIBLAP022']."</a>";
			else echo $locale['TIBLAP021'];
		} else {
			echo $locale['TIBLAP023'];
		}
		echo "<div style='clear:both;'></div>";
	}
	echo "</div>";*/
	echo $locale['TIBLAP003']."<br />".$locale['TIBLAP005']." $counter<br />";
closetable();



if (isset($page) && file_exists(INFUSIONS."D1_pinnwand_panel/admin/".$page.".php"))
	require_once(INFUSIONS."D1_pinnwand_panel/admin/".$page.".php");
else
	require_once(INFUSIONS."D1_pinnwand_panel/admin/overview.php");



// You may NOT remove the copyright (pinnwandCOPY)
echo pinnwandCOPY;
require_once THEMES."templates/footer.php";

?>