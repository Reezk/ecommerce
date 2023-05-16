<?php

function lang($phrase)
{
    static $lang = array(
        //navbar & login
        'HOME_ADMIN'       => 'Dashboard Admin',
        'HOME'       => 'Home',
        'CATEGORIES'       => 'Categories',
        'MEMBERS'          => 'Members',
        'ITEMS'            => 'Items',
        'STATISTICS'       => 'Statistics',
        'LOGS'             => 'Logs',
        'EDITE_PROFILE'    => 'Edite Profile',
        'SETTINGS'         => 'Settings',
        'LOGOUT'           => 'Logout',
        'LOGIN'            => 'Login',
        'ADMIN_LOGIN'      => 'Admin Login',
        'PASSWORD'         => 'Password',
        'USERNAME'         => 'Username',
        'COMMENTS'         => 'Comments',

    );
    return $lang[$phrase];
}
