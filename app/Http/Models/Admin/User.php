<?php

namespace App\Http\Models\Admin;

use App\Http\Models\BaseModel;

use App\Library\AdminFunction\FunctionLib;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use App\library\AdminFunction\Define;
use App\library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Memcache;


class User extends BaseModel
{
    protected $table = TABLE_USER_ADMIN;
    protected $primaryKey = 'user_id';
    public $timestamps = false;

    protected $fillable = array('user_id', 'user_name', 'user_project', 'user_object_id', 'user_parent', 'user_password', 'user_full_name', 'user_email', 'user_phone',
        'user_status', 'user_sex', 'user_view', 'user_group', 'user_group_menu', 'user_last_login','user_last_logout', 'user_last_ip','is_receive_loan',
        'user_depart_id','user_is_manager','user_manager_id','user_image','role_type', 'role_name', 'role_code', 'address', 'group_sale', 'position', 'change_pass', 'telephone',
        'auto_loan', 'created_flag', 'sum_all', 'last_assign', 'last_loan', 'auto_flag', 'sum_new', 'sum_old'
        ,'user_id_creater','user_name_creater','user_id_update','user_name_update', 'created_at', 'updated_at'
    );

    /**
     * @param $name
     * @return mixed
     */
    public function getUserByName($name)
    {
        return User::where('user_name', $name)->first();
    }

    /**
     * @param $user_email
     * @return User|Model|null
     */
    public function getUserByEmail($user_email)
    {
        return User::where('user_email', $user_email)->first();
    }

    public static function updateUserPermissionWithRole($role)
    {
        if ($role) {
            $arrListUser = User::where('role_type', $role->role_id)->get();
            if ($arrListUser) {
                foreach ($arrListUser as $user) {
                    $dataUpdate['user_group'] = (isset($role->role_group_permission) && trim($role->role_group_permission) != '' && $role->role_status == Define::STATUS_SHOW) ? $role->role_group_permission : '';
                    $dataUpdate['user_group_menu'] = (isset($role->role_group_menu_id) && trim($role->role_group_menu_id) != '' && $role->role_status == Define::STATUS_SHOW) ? $role->role_group_menu_id : '';
                    $dataUpdate['role_type'] = $role->role_id;
                    $dataUpdate['role_name'] = $role->role_name;
                    $dataUpdate['role_code'] = $role->role_code;
                    app(User::class)->updateUser($user->user_id, $dataUpdate);
                }
            }
        }
    }

    public function getAllUser()
    {
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_ALL_USER_ADMIN) : false;
        if (!$data) {
            $data = User::where('user_id', '>',STATUS_INT_KHONG)->get();
            if ($data) {
                Cache::put(Memcache::CACHE_ALL_USER_ADMIN, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function getOptionUserManager(){
        $listUserActive = self::getAllUser();
        $data = [];
        if($listUserActive){
            foreach ($listUserActive as $u){
                if($u->user_status == STATUS_INT_MOT && $u->user_is_manager == STATUS_INT_MOT){
                    $data[$u->user_id] = (trim($u->user_full_name) != '')? $u->user_full_name: $u->user_email;
                }
            }
        }
        return $data;
    }

    /**
     * QuynhTM: lấy user có hoạt động hay không
     * @param bool $action
     * @return array
     */
    public function getOptionAllUser($action = true)
    {
        $listUserActive = self::getAllUser();
        $data = [];
        if($listUserActive){
            foreach ($listUserActive as $u){
                if($u->user_status == STATUS_INT_MOT && $action){
                    $data[$u->user_id] = (trim($u->user_name) != '')? $u->user_name: $u->user_email;
                }else{
                    $data[$u->user_id] = (trim($u->user_name) != '')? $u->user_name: $u->user_email;
                }
            }
        }
        return $data;
    }

    /**
     * @param $password
     * @return string
     */
    public function encode_password($password)
    {
        return password_hash(User::stringCode($password), PASSWORD_DEFAULT);
    }

    public function password_verify($password = '', $hash = '')
    {
        $check = password_verify(User::stringCode(trim($password)), trim($hash)) ? true : false;
        return $check;
    }

    public function stringCode($string)
    {
        return $string . CGlobal::project_name . '-!@0938413368!@';
    }

    public function updateLogin($user_id)
    {
        if($user_id <= 0) return;
        $updateData['user_last_login'] = getCurrentDateTime();
        $updateData['user_last_ip'] = request()->ip();
        self::updateUser($user_id, $updateData);
    }

    public function updateLogOut($user_id)
    {
        if($user_id <= 0) return;
        $updateData['user_last_logout'] = getCurrentDateTime();
        $updateData['user_last_ip'] = request()->ip();
        self::updateUser($user_id, $updateData);
    }

    public function user_login()
    {
        $user = array();
        if (Session::has('user')) {
            $user = Session::get('user');
        }
        return $user;
    }

    public function get_user_project()
    {
        $user_project = 0;
        if (Session::has('user')) {
            $user = Session::get('user');
            if (!empty($user)) {
                $user_project = (isset($user['user_project'])) ? $user['user_project'] : 0;
            }
        }
        return $user_project;
    }

    public function get_project_search()
    {
        $user_project = 0;
        if (Session::has('user')) {
            $user = Session::get('user');
            if (!empty($user)) {
                if (isset($user['user_view']) && $user['user_view'] == CGlobal::status_hide) {
                    $user_project = Define::STATUS_SEARCH_ALL;
                    return $user_project;
                }
                $user_project = (isset($user['user_project'])) ? $user['user_project'] : 0;
            }
        }
        return $user_project;
    }

    public function user_id()
    {
        $id = 0;
        if (Session::has('user')) {
            $user = Session::get('user');
            $id = $user['user_id'];
        }
        return $id;
    }

    public function user_name()
    {
        $user_name = '';
        if (Session::has('user')) {
            $user = Session::get('user');
            $user_name = $user['user_name'];
        }
        return $user_name;
    }

    public function searchByCondition($data = array(), $limit = 0, $offset = 0, &$size)
    {
        try {
            $query = User::where('user_id', '>', 0);

            if (isset($data['user_view']) && $data['user_view'] == 1) {
                $query->whereIn('user_view', array(0, 1));
            }

            if (isset($data['user_id'])) {
                if (!empty($data['user_id'])) {
                    $query->whereIn('user_id', $data['user_id']);
                } else {
                    $query->where('user_id', $data['user_id']);
                }
            }

            if (isset($data['user_name']) && $data['user_name'] != '') {
                $query->where('user_name', 'LIKE', '%' . $data['user_name'] . '%');
            }
            if (isset($data['user_phone']) && $data['user_phone'] != '') {
                $query->where('user_phone', 'LIKE', '%' . $data['user_phone'] . '%');
            }
            if (isset($data['user_email']) && $data['user_email'] != '') {
                $query->where('user_email', 'LIKE', '%' . $data['user_email'] . '%');
            }
            if (isset($data['user_full_name']) && $data['user_full_name'] != '') {
                $query->where('user_full_name', 'LIKE', '%' . $data['user_full_name'] . '%');
            }
            if (isset($data['user_status']) && $data['user_status'] != 0) {
                $query->where('user_status', $data['user_status']);
            }
            if (isset($data['position']) && $data['position'] > 0) {
                $query->where('position', $data['position']);
            }
            if (isset($data['auto_loan']) && $data['auto_loan'] != STATUS_DEFAULT) {
                $query->where('auto_loan', $data['auto_loan']);
            }
            if (isset($data['user_group']) && $data['user_group'] > 0) {
                $query->whereRaw('FIND_IN_SET(' . $data['user_group'] . ',' . 'user_group)');
            }
            if (isset($data['role_type']) && $data['role_type'] > 0) {
                $query->where('role_type', $data['role_type']);
            }
            //tìm theo user quản lý các NV của họ
            if (isset($data['managerEmployee']) && $data['managerEmployee'] > 0) {
                $query->where('user_manager_id', $data['managerEmployee']);
            }
            $size = $query->get(['user_id'])->count();
            $data = $query->orderBy('user_status', 'desc')
                ->orderBy('user_last_login', 'desc')
                ->orderBy('user_last_logout', 'desc')
                ->orderBy('user_id', 'desc')->take($limit)->skip($offset)->get();

            return $data;

        } catch (PDOException $e) {
            $size = 0;
            return null;
            throw new PDOException();
        }
    }


    public function createNew($data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = new User();
            if (is_array($fieldInput) && count($fieldInput) > 0) {
                foreach ($fieldInput as $k => $v) {
                    $item->$k = $v;
                }
            }
            $item->user_password = self::encode_password($item->user_password);
            $item->user_id_creater = app(User::class)->user_id();
            $item->user_name_creater = app(User::class)->user_name();
            $item->created_at = getCurrentFull();
            $item->save();
            self::removeCache($item->user_id, $item);
            return $item->user_id;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    public function updateUser($id, $data)
    {
        try {
            $fieldInput = $this->checkFieldInTable($data);
            $item = $dataOld = self::getUserById($id);
            foreach ($fieldInput as $k => $v) {
                $item->$k = $v;
            }
            $item->user_id_update = app(User::class)->user_id();
            $item->user_name_update = app(User::class)->user_name();
            $item->updated_at = getCurrentFull();
            $item->update();

            //Disable UsersPermissionStringeeCall
            if($item->user_status != STATUS_SHOW){
                $dataPermissStringeeUpdate['status_call_stringee'] = STATUS_HIDE;
                $dataPermissStringeeUpdate['status_call_stringee_me'] = STATUS_HIDE;
                $dataPermissStringeeUpdate['disable_created'] = time();
                app(UsersPermissionStringeeCall::class)->updateItemByUid($item->user_id, $dataPermissStringeeUpdate);
            }

            self::removeCache($item->user_id, $item, $dataOld);
            return true;
        } catch (PDOException $e) {
            throw new PDOException();
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getUserById($id)
    {
        $data = (Memcache::CACHE_ON) ? Cache::get(Memcache::CACHE_USER_ADMIN_ID . $id) : false;
        if (!$data) {
            $data = User::find($id);
            if ($data) {
                Cache::put(Memcache::CACHE_USER_ADMIN_ID . $id, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }
    public function getUserByUsername($array_name)
    {
        if(is_array($array_name)){
            dd($array_name);
            $data = User::select('user_id','user_full_name','position')->whereIn('user_full_name',$array_name)->get();
        }
        else{
            $data = User::select('user_id','user_full_name','position')->where('user_full_name',$array_name)->get();
        }
        return $data;
    }

    public function updatePassWord($id, $pass)
    {
        try {
            $user = self::getUserById($id);
            $user->user_password = self::encode_password($pass);
            $user->change_pass = STATUS_INT_MOT;
            $user->update();
            self::removeCache($user->user_id, $user);
            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            throw new PDOException();
        }
    }

    public function isLogin()
    {
        $result = 0;
        if (session()->has('user')) {
            $result = 1;
        }
        return $result;
    }

    public static function isCustomerLogin()
    {
        $result = 0;
        if (session()->has('customer')) {
            $result = 1;
        }
        return $result;
    }

    public static function getList($role_type = 0)
    {
        if ($role_type == 0) {
            $user = User::where('user_status', '>', 0)->orderBy('user_id', 'desc')->get();
        } else {
            $user = User::where('user_status', '>', 0)->where('role_type', '=', $role_type)->orderBy('user_id', 'desc')->get();
        }
        return $user ? $user : array();
    }

    public static function getOptionUserFullName($role_type = 0)
    {
        $arr = User::getList($role_type);
        foreach ($arr as $value) {
            $data[$value->user_id] = $value->user_name . ' - ' . $value->user_full_name;
        }
        return $data;
    }

    public static function getListUserNameFullName()
    {
        $data = (Define::CACHE_ON) ? Cache::get(Memcache::CACHE_INFO_USER) : array();
        if (!$data) {
            $arr = User::getList();
            foreach ($arr as $value) {
                $data[$value->user_id] = $value->user_name . ' - ' . $value->user_full_name;
            }
            if (!empty($data)) {
                Cache::put(Memcache::CACHE_INFO_USER, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public static function getOptionUserFullNameAndMail()
    {
        $data = (Define::CACHE_ON) ? Cache::get(Memcache::CACHE_OPTION_USER) : array();
        if (!$data) {
            $arr = User::getList();
            foreach ($arr as $value) {
                $data[$value->user_id] = $value->user_full_name . ' - ' . $value->user_email;
            }
            if (!empty($data)) {
                Cache::put(Memcache::CACHE_OPTION_USER, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public static function getOptionUserMail()
    {
        $data = (Define::CACHE_ON) ? Cache::get(Define::CACHE_OPTION_USER_MAIL) : array();
        if (!$data) {
            $arr = User::getList();
            foreach ($arr as $value) {
                $data[$value->user_id] = $value->user_email;
            }
            if (!empty($data)) {
                Cache::put(Define::CACHE_OPTION_USER_MAIL, $data, CACHE_THREE_MONTH);
            }
        }
        return $data;
    }

    public function remove($user){
        try {
            DB::connection()->getPdo()->beginTransaction();
            $user->delete();
            DB::connection()->getPdo()->commit();
            self::removeCache($user->user_id, $user);

            //Delete UsersPermissionStringeeCall
            app(UsersPermissionStringeeCall::class)->deleteItemByUid($user->user_id);

            return true;
        } catch (PDOException $e) {
            //var_dump($e->getMessage());
            DB::connection()->getPdo()->rollBack();
            throw new PDOException();
            return false;
        }
    }

    public static function removeCache($id = 0, $dataOld, $dataNew=false)
    {
        if ($id > 0) {
            Cache::forget(Memcache::CACHE_USER_ADMIN_ID . $id);
        }
        Cache::forget(Memcache::CACHE_OPTION_USER);
        Cache::forget(Memcache::CACHE_INFO_USER);
        Cache::forget(Memcache::CACHE_ALL_USER_ADMIN);
        if($dataOld){
            Cache::forget(Memcache::CACHE_USER_BY_MANAGER.$dataOld->user_manager_id);
            Cache::forget(Memcache::CACHE_USER_BY_DEPART.$dataOld->user_depart_id.$dataOld->position);
            Cache::forget(Memcache::CACHE_USER_BY_DEPART_ONE.$dataOld->user_depart_id);
        }
        if($dataNew){
            Cache::forget(Memcache::CACHE_USER_BY_MANAGER.$dataNew->user_manager_id);
            Cache::forget(Memcache::CACHE_USER_BY_DEPART.$dataNew->user_depart_id.$dataNew->position);
            Cache::forget(Memcache::CACHE_USER_BY_DEPART_ONE.$dataNew->user_depart_id);
        }

    }

    public static function executesSQL($str_sql = '')
    {
        //return (trim($str_sql) != '') ? DB::statement(trim($str_sql)): array();
        return (trim($str_sql) != '') ? DB::select(trim($str_sql)) : array();
    }

    public static function getUserIdInArrPersonnelId($arrUserObjectId = array())
    {
        $person = array();
        if (sizeof($arrUserObjectId) > 0) {
            $result = User::whereIn('user_object_id', $arrUserObjectId)->get();
            if (sizeof($result) > 0) {
                foreach ($result as $item) {
                    $person[] = $item->user_object_id;
                }
            }
        }
        return $person;
    }

    public function getAllUserByArrRoleCode($arrRoleCode = array())
    {
        $data = array();
        if (!empty($arrRoleCode)) {
            $listUser = $this->getAllUser();
            if ($listUser) {
                foreach ($listUser as $item) {
                    if (in_array($item->role_code, $arrRoleCode)) {
                        $data[$item->user_id] = ($item->user_full_name != '') ? $item->user_full_name : $item->user_name;
                    }
                }
            }
        }
        return $data;
    }

    public static function getListUserByUserManagerId($user_manager_id){
        $data = (Define::CACHE_ON) ? Cache::get(Memcache::CACHE_USER_BY_MANAGER.$user_manager_id) : array();
        if(!$data) {
            $data = User::where('user_manager_id', $user_manager_id)->where('user_status', STATUS_SHOW)->get();
            if(!empty($data)) {
                Cache::put(Memcache::CACHE_USER_BY_MANAGER.$user_manager_id, $data, CACHE_ONE_MONTH);
            }
        }
        return $data;
    }

    public static function getListUserByUserDepartIdPosition($user_depart_id, $position){
        $data = (Define::CACHE_ON) ? Cache::get(Memcache::CACHE_USER_BY_DEPART.$user_depart_id.$position) : array();
        if(!$data) {
            $data = User::where('user_depart_id', $user_depart_id)->where('position', $position)->where('user_status', STATUS_SHOW)->get();
            if(!empty($data)) {
                Cache::put(Memcache::CACHE_USER_BY_DEPART.$user_depart_id.$position, $data, CACHE_ONE_MONTH);
            }
        }
        return $data;
    }


    public function getAllUserByUserDepartIdPosition(){
        $userLogin = app(User::class)->user_login();
        $user_current_id = isset($userLogin['user_id']) ? $userLogin['user_id'] : -1;
        $position = isset($userLogin['position']) ? $userLogin['position'] : 0;
        $user_depart_id = isset($userLogin['user_depart_id']) ? $userLogin['user_depart_id'] : 0;
        $user_manager_id = isset($userLogin['user_manager_id']) ? $userLogin['user_manager_id'] : 0;
        $result = [];
        if($user_manager_id == $user_current_id){
            $users = $this->getListUserByUserManagerId($user_manager_id);
            if($users->count() > 0){
                foreach($users as $item){
                    if($item->user_id != $user_current_id){
                        $result[$item->user_id] = $item->user_full_name;
                    }
                }
            }
            return $result;
        }

        if($user_depart_id > 0 && $position > 0){
            $users = $this->getListUserByUserDepartIdPosition($user_depart_id, $position);
            if($users->count() > 0){
                foreach($users as $item){
                    if($item->user_id != $user_current_id){
                        $result[$item->user_id] = $item->user_full_name;
                    }
                }
                return $result;
            }
        }
        return $result;
    }
    public function getArrUserByManager($user_manager_id = 0){
        $data = [];
        if($user_manager_id > 0){
            $dataUserByManager = $this->getListUserByUserManagerId($user_manager_id);
            if($dataUserByManager->count() > 0){
                foreach($dataUserByManager as $item){
                    $data[$item->user_id] = $item->user_name;
                }
            }
        }
        return $data;
    }

    public static function getListUserByUserDepartId($user_depart_id){
        $data = (Define::CACHE_ON) ? Cache::get(Memcache::CACHE_USER_BY_DEPART_ONE.$user_depart_id) : array();
        if(!$data) {
            $data = User::where('user_depart_id', $user_depart_id)->where('user_status', STATUS_SHOW)->get();
            if(!empty($data)) {
                Cache::put(Memcache::CACHE_USER_BY_DEPART_ONE.$user_depart_id, $data, CACHE_ONE_MONTH);
            }
        }
        return $data;
    }
    public function getArrUserIdByDepart($user_depart_id = 0){
        $data = [];
        if($user_depart_id > 0){
            $dataUserByDepart = $this->getListUserByUserDepartId($user_depart_id);
            if($dataUserByDepart->count() > 0){
                foreach($dataUserByDepart as $item){
                    $data[$item->user_id] = $item->user_id;
                }
            }
        }
        return $data;
    }


    public function getPermit(){
        $user = app(User::class)->user_login();
        if(!empty($user)) {
            $permission = $user['user_permission'];
            if(!empty($permission) && (in_array('root', $permission) || in_array('is_tech', $permission))) {
                return true;
            }
        }
        return false;
    }
}
