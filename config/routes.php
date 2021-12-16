<?php

return array(

    'profile' => 'profile/init',
    'profile/update' => 'profile/update',

    // ======= USER UNIT =======

    // logout
    'user/logout' => 'user/logout',
    //update
    'user/update' => 'user/update',
    // reset password
    'user/reset-password/(\\w+)/(\\w+)' => 'user/loadResetPage/$1/$2',
    'user/reset-password' => 'user/resetPassword',
    'user/send-email' => 'user/sendEmail',
    // register
    'user/register' => 'user/register',
    // login
    'user/login/(\\w+)' => 'user/login/$1',

    'pricing' => 'pricing/init',

    '' => 'home/init',
);