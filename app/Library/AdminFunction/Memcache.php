<?php
namespace App\Library\AdminFunction;

class Memcache{
    const CACHE_ON = 1;// 0: khong dung qua cache, 1: dung qua cache

    const CACHE_MENU_BY_TAB_ID = 'cache_menu_by_tab_id_';
    const CACHE_LIST_MENU_PERMISSION = 'cache_list_menu_permission';
    const CACHE_ALL_PARENT_MENU = 'cache_all_parent_menu_';
    const CACHE_TREE_MENU = 'cache_tree_menu_';
    const CACHE_USER_ADMIN_ID = 'cache_user_admin_id_';
    const CACHE_ALL_USER_ADMIN = 'cache_all_user_admin';
    const CACHE_OPTION_USER = 'cache_option_user';
    const CACHE_INFO_USER = 'cache_info_user';
    const CACHE_USER_BY_MANAGER = 'cache_user_by_manager_';
    const CACHE_USER_BY_DEPART = 'cache_user_by_depart_';
    const CACHE_USER_BY_DEPART_ONE = 'cache_user_by_depart_one_';
    const CACHE_ROLE_ID = 'cache_role_id_';
    const CACHE_OPTION_ROLE = 'cache_option_role';
    const CACHE_ROLE_ALL = 'cache_option_all';
    const CACHE_VMDEFINE_ID = 'cache_vmdefine_id_';
    const CACHE_VMDEFINE_BY_TYPE = 'cache_vmdefine_by_type_';

    //trac nghiệm
    const CACHE_QUESTION_ID = 'cache_question_id_';
    const CACHE_QUESTION_EXAM_ID = 'cache_question_exam_id_';

}
