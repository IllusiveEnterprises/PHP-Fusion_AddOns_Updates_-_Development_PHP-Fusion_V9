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



opentable($locale['TIBLAP023']);
$import = false;
$result = dbquery("SHOW TABLES LIKE '".DB_PREFIX."guestbook_entry'");
if (file_exists(INFUSIONS."guest_book/infusion_db.php")) {
if (dbrows($result)) {
	$import = true;
}
}


$result = dbquery("SHOW TABLES LIKE '".DB_PREFIX."ti_blog_system'");
if (file_exists(INFUSIONS."ti_blog_system/infusion.php")) {
if (dbrows($result)) {
	//include INFUSIONS."ti_blog_system/infusion.php";
	//include INFUSIONS."ti_blog_system/locale/German.php";
	if (isset($_GET['import_ti_blog'])) {
		$result = dbquery("SELECT * FROM ".DB_PREFIX."ti_blog_system");
		$i = 1;
		while ($data = dbarray($result)) {
			$result1 = dbquery("SELECT * FROM ".DB_D1PW." ORDER BY feed_id DESC LIMIT 1");
			if (dbrows($result1) != 0) { $data1 = dbarray($result1); $neworder = $data1['pinnwand_id'] + 1; } else { $neworder = 1; }

			$d1pw_id = $data['blog_id'];
			$d1pw_date = $data['blog_date'];
			$d1pw_writer = $data['blog_writer'];
			$d1pw_subject = $data['blog_subject'];
			$d1pw_text = $data['blog_text'];
			$d1pw_views = $data['blog_views'];
			$d1pw_ip = $data['blog_ip'];

			$result2 = dbquery("INSERT INTO ".DB_D1PW." SET
					pinnwand_id = '".$d1pw_id."',
					pinnwand_date = '".$d1pw_date."',
					pinnwand_writer = '".$d1pw_writer."',
					pinnwand_subject = '".$d1pw_subject."',
					pinnwand_text = '".$d1pw_text."',
					pinnwand_views = '".$d1pw_views."',
					pinnwand_ip = '".$d1pw_ip."'
					");
			$result3 = dbquery("DELETE FROM ".DB_PREFIX."ti_blog_system WHERE blog_id ='".$data['blog_id']."'");
			$i++;
		}
            	redirect(FUSION_SELF.$aidlink."&amp;page=settings");
	} else {
	if (isset($_GET['file_error'])) {
		echo "<div class='error'><br />ERROR<br /></div>";
	}
		$result = dbquery("SELECT * FROM ".DB_PREFIX."ti_blog_system");
		echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='70%'>
			<tr>
				<td class='tbl2' colspan='2' align='left' style='font-weight:bold;font-size:bigger;'>Posts Import vom TI Blog 2.0</td>
			</tr>";
		if (dbrows($result)) {
			$anzahl = dbcount("(blog_id)", "".DB_PREFIX."ti_blog_system");
			echo "<tr>
					<td class='tbl1' style='text-align:center;'>Gefundene eintr&auml;ge: ".$anzahl."</td><td class='tbl1' style='text-align:center;'><a href='".FUSION_SELF.$aidlink."&amp;page=settings&amp;import_ti_blog=true'>Import starten</a></td>
				</tr>
				<tr class='tbl2'>
					<td style='text-align:center;' colspan='2'>
						<span class='small' style='color: #ff0000;'>(Hinweis: Nach dem Import werden die importierten Daten aus der Ursprungstabelle gel&ouml;scht)</span>
					</td>
				</tr>";
		} else {
			echo "<tr>
					<td class='tbl1' colspan='2' style='text-align:center;'><b>keine Eintr&auml;ge</td>

				</tr>";
		}
	echo "</table>";
	}
} else {
	echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='70%'>
			<tr>
				<td class='tbl2' align='left' style='font-weight:bold;font-size:bigger;'>Posts Import vom TI Blog 2.0</td>
			</tr>
			<tr>
				<td class='tbl1' style='font-weight:bold;font-size:bigger;'><span style='color: #ff0000;'><center>- NICHT INSTALLIERT -<center></span></td>
			</tr>
	</table>";
}
} else {
	echo "<table class='tbl-border center' cellpadding='4' cellspacing='0' width='70%'>
			<tr>
				<td class='tbl2' align='left' style='font-weight:bold;font-size:bigger;'>Posts Import vom TI Blog 2.0</td>
			</tr>
			<tr>
				<td class='tbl1' style='font-weight:bold;font-size:bigger;'><span style='color: #ff0000;'><center>- NICHT VORHANDEN -<center></span></td>
			</tr>
	</table>";
}
closetable();
?>