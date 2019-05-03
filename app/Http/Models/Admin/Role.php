<?php

namespace App\Http\Models\Admin;

use App\Http\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\Memcache;
use Illuminate\Support\Facades\Cache;

class Role extends BaseModel
{
    protected $table = TABLE_ROLE;
    protected $primaryKey = 'role_id';
    public $timestamps = true;

    protected $fillable = array('role_name', 'role_code', 'role_project', 'role_order', 'role_status', 'user_id_creater', 'user_name_creater', 'user_id_update', 'user_name_update', 'created_at', 'updated_at');

    public static function createItem($data)
    {
        try {
            $checkData = new Role();
            $fieldInput = $checkData->checkField($data);
            $item = new Role();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->user_id_creater = app(User::class)->user_id();
            $item->user_name_creater = app(User::class)->user_name();
            $item->save();

            self::removeCache($item->role_id, $item);
            if($item->role_id > 0){
                $dataRoleMenu['role_id'] = $item->role_id;
                $dataRoleMenu['role_name'] = $item->role_name;
                $dataRoleMenu['role_status'] = $item->role_status;
                $dataRoleMenu['role_order'] = $item->role_order;
                $dataRoleMenu['role_code'] = $item->role_code;
                app(RoleMenu::class)->createItem($dataRoleMenu);
            }
            return $item->role_id;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function updateItem($id, $data)
    {
        try {
            $checkData = new Role();
            $fieldInput = $checkData->checkField($data);
            $item = Role::find($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->user_id_update = app(User::class)->user_id();
            $item->user_name_update = app(User::class)->user_name();
            $item->update();
            if($item->role_id > 0){
                $dataRoleMenu['role_id'] = $item->role_id;
                $dataRoleMenu['role_name'] = $item->role_name;
                $dataRoleMenu['role_status'] = $item->role_status;
                $dataRoleMenu['role_order'] = $item->role_order;
                $dataRoleMenu['role_code'] = $item->role_code;
                app(RoleMenu::class)->updateDataWithRoleId($item->role_id,$dataRoleMenu);
            }
            self::removeCache($item->role_id, $item);
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            throw new PDOException();
        }
    }

    public function checkField($dataInput)
    {
        $fields = $this->fillable;
        $dataDB = array();
        if (!empty($fields)) {
            foreach ($fields as $field) {
                if (isset($dataInput[$field])) {
                    $dataDB[$field] = $dataInput[$field];
                }
            }
        }
        return $dataDB;
    }

    public static function deleteItem($id)
    {
        if ($id <= 0) return false;
        try {
            $item = Role::find($id);
            if ($item) {
                $item->delete();
            }
            self::removeCache($item->role_id, $item);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

    public static function searchByCondition($dataSearch = array(), $limit = 0, $offset = 0, &$total)
    {
        try {
            $query = Role::where('role_id', '>', 0);
            if (isset($dataSearch['role_name']) && $dataSearch['role_name'] != '') {
                $query->where('role_name', 'LIKE', '%' . $dataSearch['role_name'] . '%');
            }
            $total = $query->count();
            $query->orderBy('role_project', 'asc');
            $query->orderBy('role_order', 'asc');

            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',', trim($dataSearch['field_get'])) : array();
            if ($limit > 0) {
                $query->take($limit);
            }
            if ($offset > 0) {
                $query->skip($offset);
            }
            if (!empty($fields)) {
                $result = $query->get($fields);
            } else {
                $result = $query->get();
            }
            return $result;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public static function removeCache($id = 0, $data)
    {
        if ($id > 0) {
            Cache::forget(Memcache::CACHE_ROLE_ID . $id);
        }
        Cache::forget(Memcache::CACHE_OPTION_ROLE . '_' . $data->role_project);
        Cache::forget(Memcache::CACHE_ROLE_ALL);
    }

    public function getItemById($id)
    {
        if ($id <= 0) return false;
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_ROLE_ID . $id) : false;
        if (!$data) {
            $data = Role::find($id);
            if ($data) {
                Cache::put(Memcache::CACHE_ROLE_ID . $id, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public static function getListAll($user_project = 0)
    {
        $data = (Define::CACHE_ON) ? Cache::get(Memcache::CACHE_ROLE_ALL) : false;
        if (!$data) {
            $query = Role::where('role_id', '>', 0);
            $query->where('role_status', '=', STATUS_SHOW);
            $data = $query->orderBy('role_order', 'ASC')->get();
            if (!empty($data)) {
                Cache::put(Memcache::CACHE_ROLE_ALL, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function getDataByArrayRoleId($arrRoleId = [])
    {
        if (!empty($arrRoleId)) {
            $query = Role::whereIn('role_id',$arrRoleId);
            $query->where('role_status', '=', STATUS_SHOW);
            $data = $query->orderBy('role_order', 'ASC')->get();
            return $data;
        }
        return false;
    }

    public static function getOptionRole($project = 0)
    {
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_OPTION_ROLE . '_' . $project) : [];
        if (!$data || empty($data)) {
            $arr = Role::getListAll($project);
            foreach ($arr as $value) {
                $data[$value->role_id] = $value->role_name;
            }
            if (!empty($data)) {
                Cache::put(Memcache::CACHE_OPTION_ROLE . '_' . $project, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }
}
