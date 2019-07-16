<?php
/**
 * QuynhTM add
 */
namespace App\Library\AdminFunction;

use Illuminate\Support\Facades\Cache;

class memcache
{
    const CACHE_ON = 1;// 0: khong dung qua cache, 1: dung qua cache

    const CACHE_MENU_BY_ID = 'cache_menu_by_id_';
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

    const CACHE_ROLE_MENU_ID = 'cache_role_menu_id_';

    const CACHE_ROLE_ID = 'cache_role_id_';
    const CACHE_OPTION_ROLE = 'cache_option_role';
    const CACHE_ROLE_ALL = 'cache_option_all';
    const CACHE_VMDEFINE_ID = 'cache_vmdefine_id_';
    const CACHE_VMDEFINE_BY_TYPE = 'cache_vmdefine_by_type_';

    const CACHE_BANNER_ID = 'cache_banner_id_';

    const CACHE_WARDS_ID = 'cache_wards_id_';

    const CACHE_DISTRICTS_ID = 'cache_districts_id_';

    const CACHE_PROVINCE_ID = 'cache_province_id_';

    const CACHE_CONTACT_ID = 'cache_contact_id_';

    const CACHE_PRODUCT_ID = 'cache_product_id_';
    const CACHE_LIST_HOME_PRODUCT_WITH_DEPART_ID = 'cache_list_home_product_with_depart_id_';
    const CACHE_LIST_CATEGORY_PRO_WITH_DEPART_ID = 'cache_list_category_pro_with_depart_id_';

    const CACHE_PRODUCT_STORAGE_ID = 'cache_product_storage_id_';

    const CACHE_STORAGE_LOG_ID = 'cache_storage_log_id_';

    const CACHE_PROVIDER_ID = 'cache_provider_id_';
    const CACHE_ALL_PROVIDER = 'cache_all_provider';
    const CACHE_LIST_PROVIDER_BY_MEMBER_ID = 'cache_list_provider_by_member_id_';

    const CACHE_INFO_MEMBER_ID = 'cache_info_member_id_';
    const CACHE_ALL_MEMBER = 'cache_all_member';

    const CACHE_DEPARTMENT_ID = 'cache_department_id_';

    const CACHE_INFOR_SALE_ID = 'cache_infor_sale_id_';
    const CACHE_INFOR_SALE_MEMBER_ID = 'cache_infor_sale_member_id_';

    const CACHE_ALL_CATEGORY = 'cache_all_category';
    const CACHE_CATEGORY_ID = 'cache_category_id_';
    const CACHE_CATEGORY_MEMBER_ID = 'cache_category_member_id_';
    const CACHE_ALL_PARENT_CATEGORY = 'cache_all_parent_category';
    const CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID = 'cache_all_child_category_by_parent_id_';
    const CACHE_ALL_SHOW_CATEGORY_FRONT = 'cache_all_show_category_front';
    const CACHE_ALL_CATEGORY_BY_TYPE = 'cache_all_category_by_type_';
    const CACHE_TREE_CATEGORY_BY_TYPE = 'cache_tree_category_by_type_';
    const CACHE_ALL_CATEGORY_RIGHT = 'cache_all_category_right';
    const CACHE_ALL_DEPARTMENT = 'cache_all_department';

    const CACHE_ORDER_ID = 'cache_order_id_';

    const CACHE_ORDER_ITEM_ID = 'cache_order_item_id_';


    //trac nghiệm
    const CACHE_QUESTION_ID = 'cache_question_id_';
    const CACHE_QUESTION_EXAM_ID = 'cache_question_exam_id_';
    const CACHE_QUESTION_CHOSE_MIX_EXAM = 'cache_question_chose_mix_exam_';

    /**
     * @param string $key_cache
     * @return bool
     */
    public static function getCache($key_cache = ''){
        return (trim($key_cache) != '' && Memcache::CACHE_ON) ? Cache::get($key_cache) : false;
    }

    /**
     * @param string $key_cache
     * @param array $data
     * @param int $time
     * @return bool
     */
    public static function putCache($key_cache = '', $data = [] , $time = CACHE_THREE_MONTH){
        return (trim($key_cache) != ''  && !empty($data) && Memcache::CACHE_ON) ? Cache::put($key_cache, $data, $time) : false;
    }

    /**
     * @param string $key_cache
     * @return bool
     */
    public static function forgetCache($key_cache = ''){
        return (trim($key_cache) != '' && Memcache::CACHE_ON) ? Cache::forget($key_cache) : false;
    }

}
