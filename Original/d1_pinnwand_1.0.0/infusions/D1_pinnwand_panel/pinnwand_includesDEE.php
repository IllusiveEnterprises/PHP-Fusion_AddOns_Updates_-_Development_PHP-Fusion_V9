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
$d1_pinnwand_settings = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system_settings"));
if ($settings['version'] >= 7) {
	$counter = dbcount("(pinnwand_id)", DB_PREFIX."d1_pinnwand_system");
	$prfx = DB_PREFIX;
} else {
	$counter = dbcount("(pinnwand_id)", "d1_pinnwand_system");
	$prfx = "";
}

// Gets amount of pinnwands
function d1_pinnwand_return_pinnwands() {
global $rowstart, $locale, $counter, $d1_pinnwand_settings, $prfx, $settings;
$result = dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system ORDER BY pinnwand_id DESC LIMIT $rowstart,".$d1_pinnwand_settings['pinnwand_limit']);
	if (dbrows($result)) {
		$res = "";
		while ($data = dbarray($result)) {
		$author = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."users WHERE user_id='".$data['pinnwand_writer']."'"));
		$res .= ($author['user_name'] ? "<a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwanduser&amp;id=".$data['pinnwand_writer']."'>".$author['user_name']." </a>" : "<a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwanduser&amp;id=".$data['pinnwand_writer']."'>".$locale['TIBLBL009']." </a>");
		$res .= " (".showdate("shortdate", $data['pinnwand_date']).") "; 
		$res .= "<a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&amp;id=".$data['pinnwand_id']."'>".trimlink($data['pinnwand_text'], 60)."</a>";
		$res .= "<br />";
		}
	} else {
		$res = $locale['TIBLBL001'];
	}
	print ($res);
	if ($counter > $d1_pinnwand_settings['pinnwand_limit']) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$d1_pinnwand_settings['pinnwand_limit'],$counter,3)."</div>";
}

// Inputform
function d1_pinnwand_inputform($type) {
global $locale, $userdata, $pinnwand_text, $pinnwand_subject, $prfx, $settings;
?>
	<form name='inputform' method='post' action='' onSubmit='return ValidateForm(this);'>
    <table cellpadding='0' cellspacing='1' width='90%' class='center tbl-border'><tr>
    <input type='hidden' name='pinnwand_writer' value='<?php echo $userdata['user_id']; ?>' class='textbox' />
    <input type='hidden' name='pinnwand_subject' value='<?php echo $userdata['user_name']; ?>' class='textbox' />	
    	<td class='tbl2'><?php echo ($type == "c" ? $locale['TIBLCB005'] : $locale['TIBLEB005']); ?></td>
</tr>
<tr>
    	<td class='tbl1' style='text-align:center;'>
		<?php echo ($settings['version'] >= 7 ? display_bbcodes("100%", "pinnwand_text", "inputform", "smiley|b|i|u|color|img|url|youtube|clipfish|myvideo|blink|marquee") : d1_pinnwand_bbcodes()); ?>
        </td>
    </tr>
<tr>
        <td class='tbl1'><center><textarea name='pinnwand_text' class='textbox' cols='80' rows='2'><?php echo $pinnwand_text; ?></textarea></center></td>
    </tr>
    <?php 
		echo ($type == 'e' ? "<tr>
    	<td class='tbl2'>".$locale['TIBLEB009'].": <input type='checkbox' name='delete' value='1' /></td>
		
		</tr>" : "");
	?>
	</table>
    <div style="text-align:center; margin-top:5px;">
    <?php
		if (iGUEST && $type == 'c') {
		echo make_Captcha()."<br />
		<input type='text' name='captcha_code' class='textbox' style='width:100px' /><br /><br />";
		}
	?>
        <input type='submit' name='preview' value='<?php echo ($type == "c" ? $locale['TIBLCB011'] : $locale['TIBLEB011']); ?>' class='button' />
        <input type='submit' name='<?php echo ($type == "c" ? "save" : "edit"); ?>' value='<?php echo ($type == "c" ? $locale['TIBLCB006'] : $locale['TIBLEB006']); ?>' class='button' />
	</div>
	</form> 
<?php
}

// Posts new pinnwands
function d1_pinnwand_newpinnwand() {
global $pinnwand_write, $pinnwand_subject, $pinnwand_text, $locale, $prfx, $settings;
	$date_now = time();
	if (isset($_POST['save'])) {
		if (iGUEST && !check_captcha($_POST['captcha_encode'], $_POST['captcha_code']))
			$fail = 1;
		else
			$fail = 0;
		$pinnwand_writer = stripinput($_POST['pinnwand_writer']);
		$pinnwand_subject = stripinput($_POST['pinnwand_subject']);
		$pinnwand_text = stripinput($_POST['pinnwand_text']);
		if ($fail == 0) {
		$result = dbquery("INSERT INTO ".DB_PREFIX."d1_pinnwand_system (pinnwand_writer, pinnwand_subject, pinnwand_text, pinnwand_date, pinnwand_ip) VALUES ('$pinnwand_writer', '$pinnwand_subject', '$pinnwand_text', '$date_now', '".USER_IP."')");
		score_positive("SHBOX");
		redirect(FUSION_SELF);
		} else {
			opentable($locale['410']);
				echo $locale['410'];
			closetable();
		}
	} else if (isset($_POST['preview'])) {
		$pinnwand_writer = stripinput($_POST['pinnwand_writer']);
		$pinnwand_subject = stripinput($_POST['pinnwand_subject']);
		$pinnwand_text = stripinput($_POST['pinnwand_text']);	
		//opentable($pinnwand_subject);
		echo parsesmileys(parseubb(nl2br($pinnwand_text)));
		echo "<hr>";
		//closetable();
	}
}

// Renders D1_pinnwand.php
function d1_pinnwand_pinnwandlist() {
global $locale, $counter, $userdata, $aidlink, $d1_pinnwand_settings, $prfx, $settings;
opentable($locale['TIBLBL002']);
	?>
<div>
    	<div style="float:right;">
        <?php 
		$accarr = array("0", "101", "102", "103");
		if (iMEMBER && !in_array($d1_pinnwand_settings['pinnwand_access'], $accarr)) {
			$expl = explode(".", $userdata['user_groups']);
			$check = in_array($d1_pinnwand_settings['pinnwand_access'], $expl);
		} else {
			 $check = $userdata['user_level'] >= $d1_pinnwand_settings['pinnwand_access'];
		}
		
			if ($check) 
				echo "".$locale['TIBLBL004']." <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=createpinnwand'>".$locale['TIBLBL005']."</a> ";
			if (iADMIN && checkRights("D1PW") || iSUPERADMIN) 
				echo "&nbsp;&nbsp;&nbsp; <a href='".INFUSIONS."D1_pinnwand_panel/pinnwand_admin.php$aidlink'>".$locale['TIBLBL008']."</a>";
		?>
        </div>
    	<?php echo $locale['TIBLBL003']." ".$counter; ?>
<hr />
    </div>
    <div style="padding:5px 0 5px 0;">
    	<?php d1_pinnwand_return_pinnwands(); ?>
    </div>
    <hr />
    &raquo; <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=search'><?php echo $locale['TIBLBL010']; ?></a>
    <?php
closetable();
}

// Renders createpinnwand.php
function d1_pinnwand_createpinnwand() {
global $locale, $userdata, $d1_pinnwand_settings, $pinnwand_write, $pinnwand_subject, $pinnwand_text, $prfx, $settings;
	if($userdata['user_level'] >= $d1_pinnwand_settings['pinnwand_access']) {
	d1_pinnwand_newpinnwand();
	//opentable($locale['TIBLCB007']);
	d1_pinnwand_inputform("c");
	echo "<hr>";
	//closetable();
	} else {
	//opentable($locale['TIBLCB008']);
	//	echo "".$locale['TIBLCB009']."<br /><br />&raquo; <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php'>".$locale['TIBLCB010']."</a>";
	//closetable();
	}
}

// Renders pinnwand_id.php
function d1_pinnwand_pinnwandid($id) {
global $locale, $userdata, $prfx, $settings;
$tipinnwand = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system bs 
LEFT JOIN ".DB_PREFIX."users bu ON bs.pinnwand_writer=bu.user_id WHERE pinnwand_id='$id'"));
if (!$tipinnwand['pinnwand_id']) header("Location: D1_pinnwand.php");
$tinewview = dbquery("UPDATE ".DB_PREFIX."d1_pinnwand_system SET pinnwand_views=pinnwand_views+1 WHERE pinnwand_id='$id'");
	opentable($tipinnwand['pinnwand_subject']);
	?>
    <div>
    	<div style="float:right;">
		<?php 
		echo $locale['100bs_biviews']." ".$tipinnwand['pinnwand_views']." - ".$locale['TIBLBI001'].""; 
		if ($tipinnwand['user_name']) 
			echo " <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwanduser&amp;id=".$tipinnwand['pinnwand_writer']."'>".$tipinnwand['user_name']."</a>"; 
		else 
			echo " ".$locale['TIBLBI006']."";
		echo " - ".showdate("longdate", $tipinnwand['pinnwand_date']); 
		?>
	</div>
    <?php
	if (iMEMBER && $userdata['user_id'] == $tipinnwand['pinnwand_writer'] || iSUPERADMIN)
		echo "".$locale['TIBLBI003']." <a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=editpinnwand&amp;id=".$tipinnwand['pinnwand_id']."'>".$locale['TIBLBI002']."</a>";
	else 
		echo "&nbsp;";
	?>
    <hr />
    <?php
	if ($tipinnwand['user_avatar']) {
		echo "<div id='bild' align='right' style='margin:5px; width:100px; float:right;'>
		<a href='".BASEDIR."profile.php?lookup=".$tipinnwand['pinnwand_writer']."'><img src='images/avatars/".$tipinnwand['user_avatar']."' /></a>
		<center><a href='".BASEDIR."profile.php?lookup=".$tipinnwand['pinnwand_writer']."'>".$tipinnwand['user_name']."</a></center></div>";
	}
	echo parsesmileys(parseubb(nl2br($tipinnwand['pinnwand_text'])));
	?>
		<div style='clear:both;'></div>
    </div>
    <?php
	closetable();
	include INCLUDES."comments_include.php";
	showcomments("BS",$prfx."d1_pinnwand_system","pinnwand_id",$_GET['id'],FUSION_SELF."?page=pinnwand_id&id=".$_GET['id']);
}

// Renders pinnwanduser.php
function d1_pinnwand_pinnwanduser($id) {
global $d1_pinnwand_settings, $locale, $userdata, $prfx, $settings;
if (isset($_GET['rowstart'])) $rowstart = $_GET['rowstart']; 
if (!isset($rowstart) || !isNum($rowstart)) $rowstart = 0;

	$pinnwandgas = $d1_pinnwand_settings['pinnwand_userlimit'];
	$rows = dbcount("(pinnwand_id)", $prfx."d1_pinnwand_system", "pinnwand_writer='$id'");
	$result = dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system bs 
	LEFT JOIN ".DB_PREFIX."users bu ON bs.pinnwand_writer=bu.user_id 
	WHERE pinnwand_writer='$id' ORDER BY pinnwand_date DESC LIMIT $rowstart,$pinnwandgas");
	if (dbrows($result)) {
	$i = 0;
		while ($data = dbarray($result)) {
		$i++;
		if ($i == 1) {
			if ($settings['version'] >= 7) add_to_title(" - ".$locale['TIBLBU002']." ".($data['user_name'] ? $data['user_name'] : $locale['TIBLBU003']));
			opentable(($data['pinnwand_writer'] == 0 ? $locale['TIBLBU003'] : $data['user_name']));
			echo "<div style='float:right;'><a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=createpinnwand'>".(iMEMBER && isset($_GET['id']) && $userdata['user_id'] == $_GET['id'] ? $locale['TIBLBL005'] : "")."</a></div>";
			echo $locale['TIBLBU002']."<br />";
			$result2 = dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system bs
			LEFT JOIN ".DB_PREFIX."users bu ON bs.pinnwand_writer=bu.user_id 
			WHERE pinnwand_writer='$id' ORDER BY pinnwand_date DESC LIMIT $rowstart,$pinnwandgas");
			while ($data2 = dbarray($result2)) {
			$cmts = dbcount("(comment_id)", $prfx."comments", "comment_type='BS' AND comment_item_id='".$data2['pinnwand_id']."'");
				echo '<div style="float:right;">'.date("M, d -y H:i", $data2['pinnwand_date']).'</div>';
				echo "&nbsp;<a href='#pinnwand".$data2['pinnwand_id']."'>".trimlink($data2['pinnwand_text'], 70)."</a> ($cmts)<br />";
			}
			echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$pinnwandgas,$rows,3,FUSION_SELF."?page=pinnwanduser&amp;id=$id&amp;")."</div>";
			closetable();
		}
		$cmts = dbcount("(comment_id)", $prfx."comments", "comment_type='BS' AND comment_item_id='".$data['pinnwand_id']."'");
			echo "<a name='pinnwand".$data['pinnwand_id']."'></a>";
			opentable($data['pinnwand_subject']);
			echo parsesmileys(parseubb(nl2br($data['pinnwand_text'])));
			echo '<div align="right"><a href="infusions/D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&amp;id='.$data['pinnwand_id'].'">'.$locale['TIBLBU004'].'</a> ('.$cmts.')</div>';
			closetable();
			echo '<br />';
		}
		if ($rows > $pinnwandgas) {
		opentable("");
		echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,$pinnwandgas,$rows,3,FUSION_SELF."?page=pinnwanduser&amp;id=$id&amp;")."</div>";
		closetable();
		}
	} else {
		if ($settings['version'] >= 7) add_to_title(" - ".$locale['TIBLBU002']." ".$locale['TIBLBU003']);
		opentable($locale['TIBLBU001']);
		echo $locale['TIBLBU001'];
		closetable();
	}
}

// Edit pinnwands
function d1_pinnwand_editpinnwand($id) {
global $locale, $pinnwand_text, $pinnwand_subject, $prfx, $settings;
	if (isset($_POST['edit'])) {
		$pinnwand_subject = stripinput($_POST['pinnwand_subject']);
		$pinnwand_text = stripinput($_POST['pinnwand_text']);
		if ($_POST['delete'] == 1) {
			$result = dbquery("DELETE FROM ".DB_PREFIX."d1_pinnwand_system WHERE pinnwand_id='$id'");
			header("Location: D1_pinnwand.php?page=types&type=d");
		} else {
			$result = dbquery("UPDATE ".DB_PREFIX."d1_pinnwand_system SET pinnwand_subject='$pinnwand_subject', pinnwand_text='$pinnwand_text' WHERE pinnwand_id='$id'");
			header("Location: D1_pinnwand.php?page=types&type=e&id=$id");
		}
	} else if (isset($_POST['preview'])) {
		$pinnwand_subject = stripinput($_POST['pinnwand_subject']);
		$pinnwand_text = stripinput($_POST['pinnwand_text']);
		opentable($pinnwand_subject);
		echo parsesmileys(parseubb(nl2br($pinnwand_text)));
		closetable();
	} else {
		$data = dbarray(dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system WHERE pinnwand_id='$id'"));
		$pinnwand_subject = $data['pinnwand_subject'];
		$pinnwand_text = $data['pinnwand_text'];
	}
	if ($settings['version'] >= 7) add_to_title(" - ".$locale['TIBLEB007'].": ".$pinnwand_subject);
	opentable($locale['TIBLEB007'].": ".$pinnwand_subject);
	d1_pinnwand_inputform("e");
	closetable();
}

// Renders search.php
function d1_pinnwand_searchpinnwands() {
global $locale, $d1_pinnwand_settings, $rowstart, $prfx, $settings;
if (isset($_GET['query'])) $query = stripinput($_GET['query']);
else $query = "";
if (isset($_GET['type'])) $type = $_GET['type'];
$rows = dbcount("(pinnwand_id)", $prfx."d1_pinnwand_system", "pinnwand_subject LIKE '%$query%'");
if (isset($_POST['search'])) {
	$query = stripinput($_POST['query']);
	if (strlen($query) < 3) 
		header("Location: ".FUSION_SELF."?page=search&error");
	else
		header("Location: ".FUSION_SELF."?page=search&type=".$_POST['type']."&query=".stripinput($_POST['query']));
}
opentable($locale['TIBLSF002']);
	echo "<div style='text-align:center;'>";
	echo $locale['TIBLSF003'];
	echo "<form name='searchform' method='post' action=''>
		 	<br /><input type='text' name='query' value='$query' class='textbox' style='width:200px' />
			<select name='type' class='textbox'>
				<option value='1' ".(isset($type) && $type != 2 ? "selected='selected'" : "").">".$locale['TIBLSF004']."</option>
				<option value='2' ".(isset($type) && $type == 2 ? "selected='selected'" : "").">".$locale['TIBLSF007']."</option>
			</select>
			<input type='submit' name='search' value='".$locale['TIBLSF001']."' class='button' />
		  </form>";
	if (isset($_GET['query']) && $settings['version'] >= 7) 
		echo $rows." ".($rows == 1 ? $locale['TIBLSF006'] : $locale['TIBLSF005'])." ".$locale['522'];
	else if (isset($_GET['error']) && $settings['version'] >= 7)
		echo $locale['501'];
	echo "</div>";
	if (isset($_GET['query'])) {
	if ($_GET['type'] == 2) $ti_search_what = "pinnwand_text";
	else $ti_search_what = "pinnwand_subject";
	$result = dbquery("SELECT * FROM ".DB_PREFIX."d1_pinnwand_system WHERE $ti_search_what LIKE '%$query%' ORDER BY pinnwand_subject LIMIT $rowstart,".$d1_pinnwand_settings['pinnwand_limit']);
		while ($data = dbarray($result)) {
			echo "<a href='".INFUSIONS."D1_pinnwand_panel/D1_pinnwand.php?page=pinnwand_id&id=".$data['pinnwand_id']."'>".$data['pinnwand_subject']."</a><br>\n";
		}
	}
	if ($rows > $d1_pinnwand_settings['pinnwand_limit'] && !isset($_GET['error']) && isset($_GET['type'])) echo "<div align='center' style='margin-top:5px;'>\n".makePageNav($rowstart,10,$rows,3,FUSION_SELF."?page=search&type=$type&query=$query&amp;")."\n</div>\n";
closetable();
}

// BBCodes for PHP-Fusion v6
function d1_pinnwand_bbcodes() {
echo "<input type='button' value='b' class='button' style='font-weight:bold;width:25px;' onClick=\"addText('pinnwand_text', '[b]', '[/b]');\">
<input type='button' value='i' class='button' style='font-style:italic;width:25px;' onClick=\"addText('pinnwand_text', '[i]', '[/i]');\">
<input type='button' value='u' class='button' style='text-decoration:underline;width:25px;' onClick=\"addText('pinnwand_text', '[u]', '[/u]');\">
<input type='button' value='url' class='button' style='width:30px;' onClick=\"addText('pinnwand_text', '[url]', '[/url]');\">
<input type='button' value='mail' class='button' style='width:35px;' onClick=\"addText('pinnwand_text', '[mail]', '[/mail]');\">
<input type='button' value='img' class='button' style='width:30px;' onClick=\"addText('pinnwand_text', '[img]', '[/img]');\">
<input type='button' value='center' class='button' style='width:45px;' onClick=\"addText('pinnwand_text', '[center]', '[/center]');\">
<input type='button' value='small' class='button' style='width:40px;' onClick=\"addText('pinnwand_text', '[small]', '[/small]');\">
<input type='button' value='code' class='button' style='width:40px;' onClick=\"addText('pinnwand_text', '[code]', '[/code]');\">
<input type='button' value='quote' class='button' style='width:45px;' onClick=\"addText('pinnwand_text', '[quote]', '[/quote]');\">
<select name='bbcolor' class='textbox' style='width:90px;' onChange=\"addText('pinnwand_text', '[color=' + this.options[this.selectedIndex].value + ']', '[/color]');this.selectedIndex=0;\">
<option value=''>Default</option>
<option value='maroon' style='color:maroon;'>Maroon</option>
<option value='red' style='color:red;'>Red</option>
<option value='orange' style='color:orange;'>Orange</option>
<option value='brown' style='color:brown;'>Brown</option>
<option value='yellow' style='color:yellow;'>Yellow</option>
<option value='green' style='color:green;'>Green</option>
<option value='lime' style='color:lime;'>Lime</option>
<option value='olive' style='color:olive;'>Olive</option>
<option value='cyan' style='color:cyan;'>Cyan</option>
<option value='blue' style='color:blue;'>Blue</option>
<option value='navy' style='color:navy;'>Navy Blue</option>
<option value='purple' style='color:purple;'>Purple</option>
<option value='violet' style='color:violet;'>Violet</option>
<option value='black' style='color:black;'>Black</option>
<option value='gray' style='color:gray;'>Gray</option>
<option value='silver' style='color:silver;'>Silver</option>
<option value='white' style='color:white;'>White</option>
</select>";
}
?>