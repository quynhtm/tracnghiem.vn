<?php
/*
* @Created by: QuynhTM
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Models\Shop;

use App\Http\Models\BaseModel;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Cache;
use App\library\AdminFunction\Memcache;
use App\Http\Models\Admin\User;

class Category extends BaseModel
{
    protected $table = TABLE_CATEGORY;
    protected $primaryKey = 'category_id';
    public $timestamps = true;
    /*protected $fillable = array('category_id', 'member_id', 'category_name', 'category_parent_id', 'category_depart_id',
        'category_type', 'category_level', 'category_image_background', 'category_icons',
        'category_status', 'category_menu_status', 'category_order', 'category_menu_right',
        'meta_title', 'meta_keywords', 'meta_description', 'created_at', 'updated_at');*/

    public function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, $is_total = true)
    {
        try {
            $query = Category::where('category_id', '>', 0);
            if (isset($dataSearch['category_name']) && $dataSearch['category_name'] != '') {
                $query->where('category_name', 'LIKE', '%' . $dataSearch['category_name'] . '%');
            }
            if (isset($dataSearch['category_status']) && $dataSearch['category_status'] != -1) {
                $query->where('category_status', $dataSearch['category_status']);
            }
            if (isset($dataSearch['category_depart_id']) && $dataSearch['category_depart_id'] != -1) {
                $query->where('category_depart_id', $dataSearch['category_depart_id']);
            }
            if (isset($dataSearch['category_type']) && $dataSearch['category_type'] > 0) {
                $query->where('category_type', $dataSearch['category_type']);
            }
            if (isset($dataSearch['string_depart_id']) && $dataSearch['string_depart_id'] != '') {
                $query->whereIn('category_depart_id', explode(',', $dataSearch['string_depart_id']));
            }
            if (isset($dataSearch['category_menu_right']) && $dataSearch['category_menu_right'] != -1) {
                $query->where('category_menu_right', $dataSearch['category_menu_right']);
            }

            $total = ($is_total) ? $query->count() : 0;
            $query->orderBy('category_id', 'desc'); // desc tăng - asc giảm
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if (!empty($fields)) {
                $result = $query->take($limit)->skip($offset)->get($fields);
            } else {
                $result = $query->take($limit)->skip($offset)->get();
            }
            return ['data' => $result, 'total' => $total];

        } catch (\PDOException $e) {
            return $e->getMessage();
            throw new \PDOException();
        }
    }

    public function createItem($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new Category();
            if (is_array($fieldInput) && count($fieldInput) > STATUS_INT_KHONG) {
                foreach ($fieldInput as $k => $v) {
                    $item-> $k = $v;
                }
                //$member_id = app(User::class)->getMemberIdUser();
                //$item->member_id = $member_id;
                $item->save();
                self::removeCache($item->category_id, $item);
                return $item->category_id;
            }
            return STATUS_INT_KHONG;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function updateItem($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            //$member_id = app(User::class)->getMemberIdUser();
            $item = self::getItemById($id);
            if ($item && isset($item->category_id)) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->update();
                self::removeCache($item->category_id, $item);
            }
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
        }
    }

    public function getItemById($id)
    {
        $data = Memcache::getCache(Memcache::CACHE_CATEGORY_ID . $id);
        if (!$data) {
            $data = Category::where('category_id','=',$id)->first();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_CATEGORY_ID . $id, $data);
            }
        }
        return $data;
    }

    public function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = $dataOld = self::getItemById($id);
            if ($item) {
                $item->delete();
            }
            self::removeCache($id, $dataOld);
            return true;
        } catch (\PDOException $e) {
            throw new \PDOException();
            return false;
        }
    }

    public function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Memcache::forgetCache(Memcache::CACHE_CATEGORY_ID . $id);
            Memcache::forgetCache(Memcache::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID . $id);
        }

        if ($data) {
            Memcache::forgetCache(Memcache::CACHE_CATEGORY_MEMBER_ID . $data->member_id);
            Memcache::forgetCache(Memcache::CACHE_ALL_PARENT_CATEGORY . '_' . $data->category_type);
            Memcache::forgetCache(Memcache::CACHE_ALL_CATEGORY_BY_TYPE . $data->category_type);
        }

        Memcache::forgetCache(Memcache::CACHE_ALL_CATEGORY);
        Memcache::forgetCache(Memcache::CACHE_ALL_PARENT_CATEGORY);
        Memcache::forgetCache(Memcache::CACHE_ALL_SHOW_CATEGORY_FRONT);
        Memcache::forgetCache(Memcache::CACHE_ALL_CATEGORY_RIGHT);
    }

    public function getItemByMemberId($member_id)
    {
        $data = Memcache::getCache(Memcache::CACHE_CATEGORY_MEMBER_ID . $member_id);
        if (!$data) {
            $data = Category::where('member_id', $member_id)->first();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_CATEGORY_MEMBER_ID . $member_id, $data);
            }
        }
        return $data;
    }

    public function getAllCategory()
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_CATEGORY);
        if (!$data) {
            $data = Category::all();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_CATEGORY, $data);
            }
        }
        return $data;
    }

    public function getCategoryNameByID($id)
    {
        $category = self::getItemById($id);
        return isset($category->category_id) ? $category->category_name : '';
    }

    public function getOptionAllCategory()
    {
        $data = array();
        $category = $this->getAllCategory();
        if($category){
            foreach ($category as $itm) {
                if($itm->category_status == STATUS_INT_MOT){
                    $data[$itm->category_id] = $itm->category_name;
                }
            }
        }
        return $data;
    }

    public function getCategoryByArrayId($arrCate = array())
    {
        $data = array();
        if (!empty($arrCate)) {
            $category = $this->getAllCategory();
            foreach ($category as $itm) {
                if(in_array($itm->category_id,$arrCate) && $itm->category_status == STATUS_INT_MOT){
                    $data[$itm->category_id] = $itm->category_name;
                }
            }
            return $data;
        }
        return $data;
    }

    public function getCategoryByDepartId($depart_id = 0)
    {
    $data = array();
    if ($depart_id > 0) {
        $category = Category::where('category_depart_id', $depart_id)->orderBy('category_id', 'asc')->get();
           foreach ($category as $itm) {
               $data[$itm['category_id']] = $itm['category_name'];
           }
           return $data;
        }
    return $data;
    }

    public function getListCategoryNameById($id)
{   // lấy tên thư mục cha
    $data = array();
    $result = Category::whereIn('category_id', $id)->get(array('category_id', 'category_name'));
    if ($result) {
        foreach ($result as $itm) {
            $data[$itm->category_id] = $itm->category_name;
        }
    }
    return $data;
}

    public function getDepartIdByCategoryId($category_id = 0)
    {
        $category_depart_id = 0;
        if ($category_id > 0) {
            $category = Category::getByID($category_id);
            if (sizeof($category) !== 0) {
                $category_depart_id = isset($category->category_depart_id) ? $category->category_depart_id : 0;
            }
        }
        return $category_depart_id;
    }

    public function getAllParentCategoryId()
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_PARENT_CATEGORY);
        if (!$data) {
            $category = Category::where('category_id', '>', 0)
                ->where('category_parent_id', 0)
                ->where('category_status', STATUS_INT_MOT)
                ->orderBy('category_order', 'asc')->get();
            if ($category) {
                foreach ($category as $itm) {
                    $data[$itm['category_id']] = $itm['category_name'];
                }
            }
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_PARENT_CATEGORY, $data);

            }
        }
        return $data;
    }

    public function getAllParentCateWithType($category_type)
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_PARENT_CATEGORY . '_' . $category_type);
        if (!$data) {
            $category = Category::where('category_id', '>', 0)
                ->where('category_parent_id', 0)
                ->where('category_status', STATUS_INT_MOT)
                ->where('category_type', $category_type)
                ->orderBy('category_order', 'asc')->get();
            if ($category) {
                foreach ($category as $itm) {
                    $data[$itm['category_id']] = $itm['category_name'];
                }
            }
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_PARENT_CATEGORY . '_' . $category_type, $data);

            }
        }
        return $data;
    }

    public function getAllChildCategoryIdByParentId($parentId = 0)
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID . $parentId);
        if (!$data == 0 && $parentId > 0) {
            $category = Category::where('category_id', '>', 0)
                ->where('category_parent_id', '=', $parentId)
                ->where('category_status', STATUS_INT_MOT)
                ->orderBy('category_order', 'asc')->get();
            if ($category) {
                foreach ($category as $itm) {
                    $data[$itm['category_id']] = $itm['category_name'];
                }
            }
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID . $parentId, $data);
            }
        }
        return $data;
    }

    public function buildTreeCategory($category_type = 0)
    {
        $categories = Memcache::getCache(Memcache::CACHE_TREE_CATEGORY_BY_TYPE . $category_type);
        if (!$categories){
            if ($category_type > 0) {
                $categories = Category::where('category_id', '>', 0)
                    ->where('category_status', '=', STATUS_INT_MOT)
                    ->where('category_type', '=', $category_type)
                    ->get();
            } else {
                $categories = Category::where('category_id', '>', 0)
                    ->where('category_status', '=', STATUS_INT_MOT)
                    ->get();
            }
            Memcache::putCache(Memcache::CACHE_TREE_CATEGORY_BY_TYPE . $category_type, $categories);
        }

        return $treeCategroy = self::getTreeCategory($categories);
    }

    public function getTreeCategory($data)
    {
        $max = 0;
        $aryCategoryProduct = $arrCategory = array();
        if (!empty($data)) {
            foreach ($data as $k => $value) {
                $max = ($max < $value->category_parent_id) ? $value->category_parent_id : $max;
                $arrCategory[$value->category_id] = array(
                    'category_id' => $value->category_id,
                    'member_id' => $value->member_id,
                    'category_depart_id' => $value->category_depart_id,
                    'category_parent_id' => $value->category_parent_id,
                    'category_type' => $value->category_type,
                    'category_level' => $value->category_level,
                    'category_image_background' => $value->category_image_background,
                    'category_icons' => $value->category_icons,
                    'category_order' => $value->category_order,
                    'category_status' => $value->category_status,
                    'category_menu_status' => $value->category_menu_status,
                    'category_name' => $value->category_name,
                    'category_menu_right' => $value->category_menu_right);
            }
        }

        if ($max > 0) {
            $aryCategoryProduct = self::showCategory($max, $arrCategory);
        }
        return $aryCategoryProduct;
    }

    public function showCategory($max, $aryDataInput)
    {
        $aryData = array();
        if (is_array($aryDataInput) && count($aryDataInput) > 0) {
            foreach ($aryDataInput as $k => $val) {
                if ((int)$val['category_parent_id'] == 0) {
                    $val['padding_left'] = '';
                    $val['category_parent_name'] = '';
                    $aryData[] = $val;
                    self::showSubCategory($val['category_id'], $val['category_name'], $max, $aryDataInput, $aryData);
                }
            }
        }
        return $aryData;
    }

    public function showSubCategory($cat_id, $cat_name, $max, $aryDataInput, &$aryData)
    {
        if ($cat_id <= $max) {
            foreach ($aryDataInput as $chk => $chval) {
                if ($chval['category_parent_id'] == $cat_id) {
                    $chval['padding_left'] = '--- ';
                    $chval['category_parent_name'] = $cat_name;
                    $aryData[] = $chval;
                    self::showSubCategory($chval['category_id'], $chval['category_name'], $max, $aryDataInput, $aryData);
                }
            }
        }
    }

    public function getAllCategoryByType($type = 0, $limit = 5)
    {
        $data = Memcache::getCache(Memcache::CACHE_ALL_CATEGORY_BY_TYPE . $type);
        if (!$data) {
            $data = Category::where('category_id', '>', 0)
                ->where('category_status', STATUS_INT_MOT)
                ->where('category_type', $type)
                ->take($limit)
                ->orderBy('category_order', 'asc')->get();
            if ($data) {
                Memcache::putCache(Memcache::CACHE_ALL_CATEGORY_BY_TYPE . $type, $data);
            }
        }
        return $data;
    }

    public function makeListCatId($catid = 0, $level = 0, &$arrCat)
    {
        $listcat = explode(',', $catid);
        if (!empty($listcat)) {
            $query = Category::where('category_status', '=', STATUS_INT_MOT);
            foreach ($listcat as $cat) {
                if ($cat != end($listcat)) {
                    $query->orWhere('category_parent_id', $cat);
                } else {
                    $query->where('category_parent_id', $cat);
                }
            }
            $result = $query->get();
        }
        if ($result != null) {
            foreach ($result as $k => $v) {
                array_push($arrCat, $v->category_id);
                self::makeListCatId($v->category_id, $level + 1, $arrCat);
            }
        }
        return true;
    }
}
