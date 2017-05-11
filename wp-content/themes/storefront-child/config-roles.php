<?php

/*
 * User Roles Config file.
 * Checks for which enviroment is currently being used. Live or Dev
 * Sets global variables for user roles.
 */

$environment;

$current_user1 = wp_get_current_user();

$user_roles1 = $current_user1->roles;
$user_role1 = array_shift($user_roles1);
$user_role1;

if ($_SERVER['HTTP_HOST'] === 'ortliebusadev.com.tempwebsite.net') {
    $environment = "dev-env";
    //Exclude the following ignite plugin user roles
    $GLOBALS['ort_premier_role'] = "ignite_level_5751dd4cdd8a7";
    $GLOBALS['ort_champion_role'] = "ignite_level_5751dd2d2fb91";
    $GLOBALS['ort_div_one_role'] = "ignite_level_5751dd3287cd9";
    $GLOBALS['ort_div_two_role'] = "ignite_level_5751dd40304f0";
    $GLOBALS['ort_div_three_role'] = "ignite_level_5751dd45b2883";
} else {
    $environment = "live-env";
    $GLOBALS['ort_premier_role'] = "ignite_level_56dc92776f14e";
    $GLOBALS['ort_champion_role'] = "ignite_level_56dd0625daf49";
    $GLOBALS['ort_div_one_role'] = "ignite_level_56dc9282595a8";
    $GLOBALS['ort_div_two_role'] = "ignite_level_56dc928ed58b1";
    $GLOBALS['ort_div_three_role'] = "ignite_level_56dc929e3b3d7";
}

// Check to see if Global Role flag is set. Based if user roll is set above.
if (($user_role1 === $GLOBALS['ort_premier_role']) || ($user_role1 === $GLOBALS['ort_champion_role']) || ($user_role1 === $GLOBALS['ort_div_one_role']) || ($user_role1 === $GLOBALS['ort_div_two_role']) || ($user_role1 === $GLOBALS['ort_div_three_role'])) {
    $GLOBALS['role_flag'] = 1;
} else {
    $GLOBALS['role_flag'] = 0;
}