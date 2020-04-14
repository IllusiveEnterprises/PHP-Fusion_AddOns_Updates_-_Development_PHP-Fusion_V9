--------------------------------------
[INFUSION] MF-Premium-Scores_panel 1.2.0 (v7)
For PHP Fusion Version 7.x
by DeeoNe (http://www.deeone.de)
--------------------------------------

-------------
0. Introduction
-------------

A complete Premium system for PHP-Fusion v9.03.50
---------------------------------------
1. Features
---------------------------------------
Members:
- Members can activate premium times with their scores.
- Members are automatically added to a user group.
- After the premium expires, the members are automatically removed from the group.
- Notification of purchase of scores.
- Processed panel with graphics possible.
- Show benefits that the admin has entered.

Admin:
- Settings of prices and duration of the individual packages
- User group in which the members come can be set.
- Notification of scores purchase from members.
- Activate, deactivate and delete members.
- Premium Time Members + -
- Give members premium on time.
- Enter premium benefits.
- Switch premium graphics on and off.
- Display of confirmations improved.
---------------------------------------
2. Installation
---------------------------------------

The complete folder structure must be in the
Copied the "root" directory of the PHP-Fusion installation.

Then the infusion can be installed via System Admin -> Infusions.

After the installation, all you have to do is put on the panel and you're ready to go.

OPTIONAL Activate Premium Profile Field: User Admin -> Profile Fields -> Premium Status: activate



for PHP-Fusion 9.03.50:
3.8 Open file /includes/dynamics/includes/form_text.php and search for (around line 111):
   $valid_types = [
        'text', 'number', 'password', 'email', 'url', 'color', 'date', 'datetime', 'datetime-local', 'month', 'range', 'search', 'tel', 'time', 'week',
    ];


replace with:
   $valid_types = [
        'text', 'number', 'password', 'email', 'url', 'color', 'date', 'datetime', 'datetime-local', 'month', 'range', 'search', 'tel', 'time', 'week', 'hidden',
    ];


search for (arond line 162):
    switch ($options['type']) {
        case "number":
            $input_type = "number";
            $min = ((!empty($options['number_min']) || $options['number_min'] === "0") && isnum($options['number_min']) ? "min='".$options['number_min']."' " : '');
            $max = ((!empty($options['number_max']) || $options['number_max'] === "0") && isnum($options['number_max']) ? "max='".$options['number_max']."' " : '');
            // $step = "step='".str_replace(",", ".", $options['number_step'])."' ";
            $step = "step='any' ";
            break;
        case "text":
            $input_type = "text";
            break;
        case "password":
            $input_type = "password";


replace with:

    switch ($options['type']) {
        case "number":
            $input_type = "number";
            $min = ((!empty($options['number_min']) || $options['number_min'] === "0") && isnum($options['number_min']) ? "min='".$options['number_min']."' " : '');
            $max = ((!empty($options['number_max']) || $options['number_max'] === "0") && isnum($options['number_max']) ? "max='".$options['number_max']."' " : '');
            // $step = "step='".str_replace(",", ".", $options['number_step'])."' ";
            $step = "step='any' ";
            break;
        case "text":
            $input_type = "text";
            break;
        case "hidden":
            $input_type = "hidden";
            break;
        case "password":
            $input_type = "password";

Save and upload


---------------------------------------
3. Hints
---------------------------------------

This infusion or the panel has been created temporarily because it may take some time with the other premium version.

---------------------------------------
4. Update
---------------------------------------
Update 1.0.1 -> 1.1.0: Upload all files (overwrite) and install as an update.
Update 1.1.0 -> 1.1.1: Upload all files (overwrite) and install as an update.
Update 1.1.1 -> 1.2.0: Upload (overwrite) all files and install as an update.
Update 1.2.0 -> 1.2.1: Upload (overwrite) all files and install as an update.
---------------------------------------
5. Changelog
---------------------------------------
1.2.0:
+ DeeoNe develops the MF Premium Scores from 1.2.0.
+ Notification of scores purchase from members.
+ Activate, deactivate and delete members.
+ Premium Time Members + -
+ Give members premium on time.
+ Notification of purchase of scores.

1.2.1:
+ Enter premium benefits.
+ Switch premium graphics on and off.
+ Improved display of confirmations.
+ Revised panel with graphics possible.
+ Show benefits that the admin has entered.

