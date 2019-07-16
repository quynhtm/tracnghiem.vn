<?php
/**
 * Created by PhpStorm.
 * User: QuynhTM
 * Date: 10/17/2016
 * Time: 2:06 PM
 */

/**************************************************************************************************************
 * định nghĩa Table
 **************************************************************************************************************/
define('PREFIX', 'web_');
define('PREFIX_SHOP', 'shop_');
define('PREFIX_TRAC_NGHIEM', 'tracnghiem_');

define('TABLE_USER_ADMIN', PREFIX.'user_admin');
define('TABLE_GROUP_USER', PREFIX.'group_user');
define('TABLE_PERMISSION', PREFIX.'permission');
define('TABLE_MENU_SYSTEM',PREFIX.'menu_system');
define('TABLE_ROLE_MENU', PREFIX.'role_menu');
define('TABLE_ROLE',PREFIX.'role');
define('TABLE_DEFINE',PREFIX.'define');
define('TABLE_GROUP_USER_PERMISSION', PREFIX.'group_user_permission');

define('TABLE_MEMBER', PREFIX_SHOP.'member');
define('TABLE_PROVIDER', PREFIX_SHOP.'provider');
define('TABLE_BANNER', PREFIX_SHOP.'banner');
define('TABLE_ORDER', PREFIX_SHOP.'order');
define('TABLE_ORDER_ITEM', PREFIX_SHOP.'order_item');
define('TABLE_PROVINCE', PREFIX_SHOP.'province');
define('TABLE_DISTRICTS', PREFIX_SHOP.'districts');
define('TABLE_WARDS', PREFIX_SHOP.'wards');
define('TABLE_CONTACT', PREFIX_SHOP.'contact');
define('TABLE_DEPARTMENT', PREFIX_SHOP.'department');
define('TABLE_INFOR_SALE', PREFIX_SHOP.'infor_sale');
define('TABLE_CATEGORY', PREFIX_SHOP.'category');
define('TABLE_PRODUCT', PREFIX_SHOP.'product');
define('TABLE_PRODUCT_STORAGE', PREFIX_SHOP.'product_storage');

define('TABLE_QUESTION', PREFIX_TRAC_NGHIEM.'question');
define('TABLE_EXAM', PREFIX_TRAC_NGHIEM.'exam');
define('TABLE_QUESTION_EXAM', PREFIX_TRAC_NGHIEM.'questions_exam');

