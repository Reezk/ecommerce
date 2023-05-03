<?php

function lang($phrase)
{
    static $lang = array(
        'HOME_ADMIN' => 'لوحة الادمن',
        'CATEGORIES' => 'المنتجات',
        'EDITE_PROFILE' => 'تعديل الملف الشخصي',
        'SETTINGS' => 'الاعدادات',
        'LOGOUT' => 'تسجيل الخروج',
        'LOGIN' => 'تسجيل الدخول',
        'ADMIN_LOGIN' => 'ادخل كأدمن',
        'PASSWORD' => 'كلمة المرور',
        'USERNAME' => 'اسم المستخدم',

    );
    return $lang[$phrase];
}
