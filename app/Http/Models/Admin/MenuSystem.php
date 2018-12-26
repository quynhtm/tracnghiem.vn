<?php
/**
 * QuynhTM
 */

namespace App\Http\Models\Admin;

use App\Http\Models\BaseModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;


class MenuSystem extends BaseModel
{
    protected $table = TABLE_MENU_SYSTEM;
    protected $primaryKey = 'menu_id';
    public $timestamps = false;

    protected $fillable = array('parent_id', 'menu_tab_top_id', 'menu_name_en', 'menu_url', 'menu_name', 'menu_type',
        'role_id', 'showcontent', 'show_permission', 'show_menu', 'ordering', 'position', 'menu_icons', 'active', 'access_data', 'allow_guest');

    public function createItem($data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $fieldInput = $this->checkFieldInTable($data);
            $item = new MenuSystem();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->save();

            DB::connection()->getPdo()->commit();
            self::removeCache($item->menu_id, $item);
            return $item->menu_id;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            DB::connection()->getPdo()->beginTransaction();
            $fieldInput = $this->checkFieldInTable($data);
            $item = MenuSystem::find($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->update();
            DB::connection()->getPdo()->commit();
            self::removeCache($item->menu_id, $item);
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
        }
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            DB::connection()->getPdo()->beginTransaction();
            $item = $dataOld = MenuSystem::find($id);
            if ($item) {
                $item->delete();
                self::removeCache($item->menu_id, $dataOld);
            }
            DB::connection()->getPdo()->commit();
            return true;
        } catch (PDOException $e) {
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
        }
        Cache::forget(Memcache::CACHE_LIST_MENU_PERMISSION);
        Cache::forget(Memcache::CACHE_ALL_PARENT_MENU);
        Cache::forget(Memcache::CACHE_TREE_MENU);
        if($data){
            Cache::forget(Memcache::CACHE_MENU_BY_TAB_ID.$data->menu_tab_top_id);
        }
    }

    public function getMenuByTab($menu_tab_top_id) {
        $data = (Memcache::CACHE_ON)? Cache::get(Memcache::CACHE_MENU_BY_TAB_ID.$menu_tab_top_id) : array();
        $data = false;
        if (!$data || sizeof($data) == 0) {
            $district = MenuSystem::where('menu_id', '>', 0)
                ->where('menu_tab_top_id', '=',$menu_tab_top_id)
                ->where('parent_id', '=',STATUS_HIDE)
                ->where('menu_type', '=',STATUS_HIDE)
                ->where('active', '=',STATUS_SHOW)
                ->orderBy('ordering', 'asc')->get();
            foreach($district as $itm) {
                $data[$itm['menu_id']] = $itm['menu_name'];
            }
            if(!empty($data) && Memcache::CACHE_ON){
                Cache::put(Memcache::CACHE_MENU_BY_TAB_ID.$menu_tab_top_id, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function conditionQuery($objQuery, $dataSearch=array()) {
        if (isset($dataSearch['menu_name']) && $dataSearch['menu_name'] != '') {
            $objQuery->where('menu_name', 'LIKE', '%' . $dataSearch['menu_name'] . '%');
        }
        if (isset($dataSearch['parent_id']) && $dataSearch['parent_id'] > -1) {
            $objQuery->where('parent_id', $dataSearch['parent_id']);
        }
        if (isset($dataSearch['active']) && $dataSearch['active'] > -1) {
            $objQuery->where('active', $dataSearch['active']);
        }
        if (isset($dataSearch['menu_tab_top_id']) && $dataSearch['menu_tab_top_id'] > -1) {
            $objQuery->where('menu_tab_top_id', $dataSearch['menu_tab_top_id']);
        }
        parent::conditionQuery($objQuery, $dataSearch);

        return $objQuery;
    }

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, &$total)
    {
        try {
            $query = MenuSystem::where('menu_id', '>', 0);
            if (isset($dataSearch['menu_name']) && $dataSearch['menu_name'] != '') {
                $query->where('menu_name', 'LIKE', '%' . $dataSearch['menu_name'] . '%');
            }

            if (isset($dataSearch['parent_id']) && $dataSearch['parent_id'] > -1) {
                $query->where('parent_id', $dataSearch['parent_id']);
            }
            if (isset($dataSearch['active']) && $dataSearch['active'] > -1) {
                $query->where('active', $dataSearch['active']);
            }
            if (isset($dataSearch['menu_tab_top_id']) && $dataSearch['menu_tab_top_id'] > -1) {
                $query->where('menu_tab_top_id', $dataSearch['menu_tab_top_id']);
            }
            $total = $query->count();
            $query->orderBy('ordering', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return $result;

        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function getAllParentMenu()
    {
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_ALL_PARENT_MENU) : array();
        if (!$data || sizeof($data) == 0) {
            $menu = MenuSystem::where('menu_id', '>', 0)
                ->where('parent_id', 0)
                ->where('active', STATUS_SHOW)
                ->orderBy('ordering', 'asc')->get();
            if ($menu) {
                foreach ($menu as $itm) {
                    $data[$itm['menu_id']] = $itm['menu_name'];
                }
            }
            if (!empty($data)) {
                Cache::put(Memcache::CACHE_ALL_PARENT_MENU, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public static function buildMenuAdmin()
    {
        $data = $menuTree = array();
        $menuTree = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_TREE_MENU) : false;
        $total = 0;
        if (!$menuTree || count($menuTree) == 0) {
            $search['active'] = STATUS_SHOW;
            $dataSearch = app(MenuSystem::class)->searchByCondition($search, 200, 0, $total);
            if (!empty($dataSearch)) {
                $data = MenuSystem::getTreeMenu($dataSearch);
                $data = !empty($data) ? $data : $dataSearch;
            }
            if (!empty($data)) {
                foreach ($data as $menu) {
                    if ($menu['parent_id'] == STATUS_HIDE && $menu['menu_type'] == STATUS_HIDE) {
                        $menuTree[$menu['menu_id']] = array(
                            'parent_id' => $menu['parent_id'],
                            'menu_id' => $menu['menu_id'],
                            'name' => $menu['menu_name'],
                            'name_en' => $menu['menu_name_en'],
                            'show_menu' => $menu['show_menu'],
                            'menu_tab_top_id' => $menu['menu_tab_top_id'],
                            'menu_type' => $menu['menu_type'],
                            'link' => 'javascript:void(0)',
                            'icon' => $menu['menu_icons']
                        );
                    }elseif ($menu['parent_id'] == STATUS_HIDE && $menu['menu_type'] == STATUS_SHOW) {
                        $menuTree[$menu['menu_id']] = array(
                            'parent_id' => $menu['parent_id'],
                            'menu_id' => $menu['menu_id'],
                            'name' => $menu['menu_name'],
                            'name_en' => $menu['menu_name_en'],
                            'show_menu' => $menu['show_menu'],
                            'menu_tab_top_id' => $menu['menu_tab_top_id'],
                            'menu_type' => $menu['menu_type'],
                            'link' => 'javascript:void(0)',
                            'icon' => $menu['menu_icons'],
                            'RouteName' => $menu['menu_url'],
                            'showcontent' => $menu['showcontent']
                        );
                    }
                    else {
                        if (isset($menuTree[$menu['parent_id']]['arr_link_sub'])) {
                            $tempLink = $menuTree[$menu['parent_id']]['arr_link_sub'];
                            array_push($tempLink, $menu['menu_url']);
                            $menuTree[$menu['parent_id']]['arr_link_sub'] = $tempLink;

                            //sub
                            $tempSub = $menuTree[$menu['parent_id']]['sub'];
                            $arrSub = array('menu_id' => $menu['menu_id'],'parent_id' => $menu['parent_id'], 'show_menu' => $menu['show_menu'], 'name' => $menu['menu_name'], 'menu_tab_top_id' => $menu['menu_tab_top_id'], 'name_en' => $menu['menu_name_en'], 'RouteName' => $menu['menu_url'], 'icon' => $menu['menu_icons'] . ' icon-4x', 'showcontent' => $menu['showcontent'], 'permission' => '');
                            array_push($tempSub, $arrSub);
                            $menuTree[$menu['parent_id']]['sub'] = $tempSub;
                        } else {
                            $menuTree[$menu['parent_id']]['arr_link_sub'] = array($menu['menu_url']);
                            $menuTree[$menu['parent_id']]['sub'] = array(
                                array('menu_id' => $menu['menu_id'],'parent_id' => $menu['parent_id'], 'show_menu' => $menu['show_menu'], 'name' => $menu['menu_name'], 'menu_tab_top_id' => $menu['menu_tab_top_id'], 'name_en' => $menu['menu_name_en'], 'RouteName' => $menu['menu_url'], 'icon' => $menu['menu_icons'] . ' icon-4x', 'showcontent' => $menu['showcontent'], 'permission' => ''),);
                        }
                    }
                }
            }
            if (!empty($menuTree)) {
                Cache::put(Memcache::CACHE_TREE_MENU, $menuTree, CACHE_THREE_MONTH);
            }
        }
        return $menuTree;
    }

    public static function getTreeMenu($data)
    {
        $max = 0;
        $aryCategoryProduct = $arrCategory = array();
        if (!empty($data)) {
            foreach ($data as $k => $value) {
                $max = ($max < $value->parent_id) ? $value->parent_id : $max;
                $arrCategory[$value->menu_id] = array(
                    'menu_id' => $value->menu_id,
                    'parent_id' => $value->parent_id,
                    'menu_tab_top_id' => $value->menu_tab_top_id,
                    'menu_type' => $value->menu_type,
                    'ordering' => $value->ordering,
                    'menu_icons' => $value->menu_icons,
                    'menu_url' => $value->menu_url,
                    'showcontent' => $value->showcontent,
                    'show_permission' => $value->show_permission,
                    'show_menu' => $value->show_menu,
                    'active' => $value->active,
                    'menu_name_en' => $value->menu_name_en,
                    'menu_name' => $value->menu_name);
            }
        }

        if ($max > 0) {
            $aryCategoryProduct = self::showMenu($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }

    public static function showMenu($max, $aryDataInput)
    {
        $aryData = array();
        if (is_array($aryDataInput) && count($aryDataInput) > 0) {
            foreach ($aryDataInput as $k => $val) {
                if ((int)$val['parent_id'] == 0) {
                    $val['padding_left'] = '';
                    $val['menu_name_parent'] = '';
                    $val['menu_name_parent_en'] = '';
                    $aryData[] = $val;
                    self::showSubMenu($val['menu_id'], $val['menu_name'], $val['menu_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }

    public static function showSubMenu($cat_id, $cat_name, $cat_name_en, $max, $aryDataInput, &$aryData)
    {
        if ($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if ($chval['parent_id'] == $cat_id) {
                    $chval['padding_left'] = '--- ';
                    $chval['menu_name_parent'] = $cat_name;
                    $chval['menu_name_parent_en'] = $cat_name_en;
                    $aryData[] = $chval;
                    self::showSubMenu($chval['menu_id'], $chval['menu_name'], $chval['menu_name_en'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }
    public static function getDataPermission(){
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_LIST_MENU_PERMISSION) : false;
        if (!$data) {
            $data = MenuSystem::where('menu_id', '>', 0)
                ->where('active', STATUS_SHOW)
                ->where('show_permission',STATUS_SHOW)
                ->orderBy('parent_id', 'asc')->orderBy('ordering', 'asc')->get();
            if ($data && Memcache::CACHE_ON) {
                Cache::put(Memcache::CACHE_LIST_MENU_PERMISSION, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public static function getListMenuPermission()
    {
        $data = self::getDataPermission();
        $result = [];
        if($data){
            foreach ($data as $k => $val){
                $result[$val->menu_tab_top_id][$val->menu_id] = ['menu_id'=>$val->menu_id,'menu_name'=>$val->menu_name,'menu_name_en'=>$val->menu_name_en];
            }
        }
        return $result;
    }
}
