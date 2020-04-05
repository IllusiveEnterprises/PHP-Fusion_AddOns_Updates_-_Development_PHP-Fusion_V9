<?php
require_once "../../maincore.php";
include INFUSIONS."D1_coupon_panel/infusion_db.php";

if (!checkrights("D1CP") || !defined("iAUTH") || $_GET['aid'] != iAUTH) { redirect("../index.php"); }

$d1cpsettings = dbarray(dbquery("SELECT * FROM ".DB_D1CP_conf.""));

$d1cpcouponsb = dbarray(dbquery("SELECT * FROM ".DB_D1CP." WHERE coupon='".$_GET["coupon"]."'"));
$ccoupon = $d1cpcouponsb['coupon'];
$cstart = date("d.m.Y H:i",$d1cpcouponsb['timestart']);
$cend = date("d.m.Y H:i",$d1cpcouponsb['timeend']);
$cscores = $d1cpcouponsb['scores'];

if ($d1cpcouponsb['sonstiges'] == "1") {
	$typeaddb = "".$d1cpsettings['coupon_scores']."";
	$imageaddb = "ScoreSystem";
} elseif ($d1cpcouponsb['sonstiges'] == "2") {
	$typeaddb = "Stunden";
	$imageaddb = "PremiumSystem";
} elseif ($d1cpcouponsb['sonstiges'] == "3") {
	$typeaddb = "Tage";
	$imageaddb = "PremiumSystem";
} else {
	$typeaddb = "ERROR";
	$imageaddb = "ERROR";
}
$ccouponz = strlen($ccoupon);
$pushz = "ZZZZZZZZ";
$ctext = strlen($cscores.$typeaddb.$imageaddb.$pushz);


if($d1cpcouponsb) {
$textnr1 = 3;
$textnr2 = 5;
$textnr3 = 2;
$textnr5 = 1;

$rechnen2 = $ccouponz*4.6;
$rechnen3 = $ctext*2;
$textwidth2 = 134-$rechnen2;
$textwidth3 = 105-$rechnen3;

$filenamec = "coupons_images/coupon_".$ccoupon.".png";

$image = "images/couponhg.png";	
$bild = imagecreatefrompng($image);
//$bild = imagecreate (268 , 60);
imagecolorallocate ($bild, 255, 255, 255);
$text_farbe1 = ImageColorAllocate ($bild, 85, 85, 85);
$text_farbe2 = ImageColorAllocate ($bild, 0, 0, 0);
$text_farbe3 = ImageColorAllocate ($bild, 225, 148, 0);
$text_farbe5 = ImageColorAllocate ($bild, 160, 160, 160);
 
ImageString ($bild, $textnr1, 95, 3, "Coupon Code:", $text_farbe1);
ImageString ($bild, $textnr2, $textwidth2, 18, "$ccoupon", $text_farbe2);
ImageString ($bild, $textnr3, $textwidth3, 32, "- $cscores $typeaddb ($imageaddb) -", $text_farbe3);
ImageString ($bild, $textnr5, 10, 47, "Gültig vom $cstart bis $cend", $text_farbe5);
} /*else {
$textnr = 5;
$bild = imagecreate (268 , 60);
imagecolorallocate ($bild, 255, 255, 255);
$text_farbe = ImageColorAllocate ($bild, 255, 0, 0);
 
ImageString ($bild, $textnr, 40, 20, "Coupon existiert nicht", $text_farbe);
ImagePNG ($bild);
}*/

//header("Content-Type: image/png");
Imagepng($bild, 'coupons_images/coupon_'.$ccoupon.'.png');
ImageDestroy ($bild);

//Close Window
		//echo '<html><body onload="window.close();"></body></html>';
redirect("".INFUSIONS."D1_coupon_panel/coupons_images/coupon_".$ccoupon.".png");

?>

