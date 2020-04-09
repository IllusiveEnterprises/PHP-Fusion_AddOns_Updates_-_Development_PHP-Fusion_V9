<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (c) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| Filename: user_scoresystem_include.php
| Author: Ralf Thieme
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

if ($profile_method == "input") {
	$icon = "<img src='".IMAGES."scoresystem.gif' title='Scoresystem' alt='Scoresystem' height = '30'/>";

	$options += [
		'type'   => 'hidden',
		'inline' => TRUE,
		'label_icon'  => $icon
	];

	$user_fields = form_text('uf_score', $locale['uf_score'], $field_value, $options);


} elseif ($profile_method == "display") {

	$icon = "<img src='".IMAGES."scoresystem.gif' title='Scoresystem' alt='Scoresystem' height = '30'/>";
	$pfss_units = (isset($score_settings['set_units']) && $score_settings['set_units'] != "" ? $score_settings['set_units'] : "Score");

	if (function_exists('score_account_stand')) {
		$field_value = $locale['uf_score_1'].$pfss_units.$locale['uf_score_2'].score_account_stand($user_data['user_id']);

	} else {
		$field_value = "";
	}

	$user_fields = [
		'icon'  => $icon,
		'title' => $locale['uf_score'],
		'value' => $field_value ?: ''
	];
} elseif ($profile_method == "validate_insert") {

} elseif ($profile_method == "validate_update") {

}
?>
