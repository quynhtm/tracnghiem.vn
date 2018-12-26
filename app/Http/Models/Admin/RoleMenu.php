<?php

namespace App\Http\Models\Admin;
use App\Http\Models\BaseModel;
use Illuminate\Support\Facades\DB;
use App\Library\AdminFunction\Define;

use App\Library\AdminFunction\FunctionLib;
use Illuminate\Support\Facades\Cache;
use App\Http\Models\Admin\User;

class RoleMenu extends BaseModel
{
    protected $table = TABLE_ROLE_MENU;
    protected $primaryKey = 'role_menu_id';
    public $timestamps = false;

    protected $fillable = array('role_group_menu_id','role_group_permission', 'role_status', 'role_id', 'role_order', 'role_name','role_code','user_id_creater','user_name_creater','user_id_update','user_name_update', 'created_at', 'updated_at');

    public static function getInfoByRoleId($role_id){
        $infor = RoleMenu::where('role_id', $role_id)->first();
        return $infor;
    }

    public function createItem($data){
        try {
            $checkData = new RoleMenu();
            $fieldInput = $checkData->checkField($data);
            $item = new RoleMenu();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->user_id_creater = app(User::class)->user_id();
            $item->user_name_creater = app(User::class)->user_name();
            $item->save();
            self::removeCache($item->role_menu_id,$item);
            return $item->role_menu_id;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateItem($id,$data){
        try {
            $checkData = new RoleMenu();
            $fieldInput = $checkData->checkField($data);
            $item = RoleMenu::find($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->user_id_update = app(User::class)->user_id();
            $item->user_name_update = app(User::class)->user_name();
            $item->update();
            User::updateUserPermissionWithRole($item);
            self::removeCache($item->role_menu_id,$item);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateDataWithRoleId($role_id, $dataUpdate){
        if($role_id > 0){
            $checkData = new RoleMenu();
            $fieldInput = $checkData->checkField($dataUpdate);
            $item = self::getInfoByRoleId($role_id);
            if($item){
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
                $item->user_id_update = app(User::class)->user_id();
                $item->user_name_update = app(User::class)->user_name();
                $item->update();
                self::removeCache($item->role_menu_id,$item);
            }
            return true;
        }
    }

    public function checkField($dataInput) {
        $fields = $this->fillable;
        $dataDB = array();
        if(!empty($fields)) {
            foreach($fields as $field) {
                if(isset($dataInput[$field])) {
                    $dataDB[$field] = $dataInput[$field];
                }
            }
        }
        return $dataDB;
    }

    public function deleteItem($id){
        if($id <= 0) return false;
        try {
            $item = RoleMenu::find($id);
            if($item){
                $item->delete();
            }
            self::removeCache($item->role_menu_id,$item);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
            return false;
        }
    }

    public function searchByCondition($dataSearch = array(), $limit =0, $offset=0, &$total){
//        FunctionLib::debug($dataSearch);
        try{
            $query = RoleMenu::where('role_menu_id','>',0);
            if (isset($dataSearch['role_name']) && $dataSearch['role_name'] != '') {
                $query->where('role_name','LIKE', '%' . $dataSearch['role_name'] . '%');
            }

            $total = $query->count();
            $query->orderBy('role_status', 'desc');
            $query->orderBy('role_order', 'asc');

            //get field can lay du lieu
            $fields = (isset($dataSearch['field_get']) && trim($dataSearch['field_get']) != '') ? explode(',',trim($dataSearch['field_get'])): array();
            if(!empty($fields)){
                $result = $query->take($limit)->skip($offset)->get($fields);
            }else{
                $result = $query->take($limit)->skip($offset)->get();
            }
            return $result;

        }catch (PDOException $e){
            throw new PDOException();
        }
    }

    public static function removeCache($id = 0,$data){
        if($id > 0){
            //Cache::forget(Define::CACHE_CATEGORY_ID.$id);
           // Cache::forget(Define::CACHE_ALL_CHILD_CATEGORY_BY_PARENT_ID.$id);
        }
    }
}
