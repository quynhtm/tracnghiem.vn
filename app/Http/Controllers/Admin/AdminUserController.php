<?php
/*
* @Created by: HSS
* @Author    : nguyenduypt86@gmail.com
* @Date      : 08/2016
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\GroupUser;
use App\Http\Models\Admin\User;
use App\Http\Models\Admin\MenuSystem;
use App\Http\Models\Admin\RoleMenu;
use App\Http\Models\Admin\Role;

use App\Http\Models\Admin\VmDefine;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Define;
use App\Library\AdminFunction\FunctionLib;
use App\Library\AdminFunction\Loader;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AdminUserController extends BaseAdminController
{
    private $permission_view = 'user_view';
    private $permission_full_employee = 'user_full_employee';
    private $permission_create = 'user_create';
    private $permission_edit = 'user_edit';
    private $permission_change_pass = 'user_change_pass';
    private $permission_remove = 'user_remove';
    private $arrStatus = array();
    private $arrIsManager = array();
    private $arrIsReceiveLoan = array();
    private $arrUserManager = array();
    private $arrRoleType = array();
    private $arrDepartment = array();
    private $arrUser = array();
    private $arrSex = array();
    private $arrDepart = array();
    private $arrPosition = array();//chức vụ
    private $arrAutoLoan = array();
    private $arrGroupSale = array();
    private $error = array();
    private $viewOptionData = array();

    public $_user;

    public function __construct(User $user)
    {
        parent::__construct();
        $this->_user = $user;
    }

    public function getDataDefault()
    {
        $this->arrRoleType = Role::getOptionRole();
        $this->arrStatus = array(
            STATUS_HIDE => viewLanguage('status_all'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_BLOCK => viewLanguage('status_block'));

        $this->arrIsManager = array(
            STATUS_INT_KHONG => viewLanguage('Không là quản lý'),
            STATUS_INT_MOT => viewLanguage('Quản lý'));

        $this->arrSex = array(
            STATUS_HIDE => viewLanguage('sex_girl'),
            STATUS_SHOW => viewLanguage('sex_boy'));

        $this->arrIsReceiveLoan = array(
            STATUS_INT_KHONG => viewLanguage('Không nhận'),
            STATUS_INT_MOT => viewLanguage('Có nhận'));

        $this->arrAutoLoan = array(
            STATUS_INT_KHONG => viewLanguage('Không có'),
            STATUS_INT_MOT => viewLanguage('Nhận tự động'),
            STATUS_INT_HAI => viewLanguage('Toàn quyền duyệt'));

        $this->arrDepart = [];
        $arrGroupSale = [];
        $this->arrGroupSale = [0 => '---Chọn nhóm sale---'] + $arrGroupSale;

        $arrPosition = app(VmDefine::class)->getOptionNameByType(TRAC_NGHIEM_CHUC_VU);
        $this->arrPosition = [0 => '---Chọn chức vụ---'] + $arrPosition;

        $arrDepartment = [];
        $this->arrDepartment = [0 => '---Chọn phòng ban---'] + $arrDepartment;

        $this->arrUser = app(User::class)->getOptionAllUser(false);//lấy tất cả user
        $arrUserManager = app(User::class)->getOptionUserManager();
        $this->arrUserManager = [0 => '---Chọn người quản lý---'] + $arrUserManager;
    }

    public function _outDataView($data)
    {
        if (isset($data['role_type']) && is_array($data['role_type'])) {
            $arrSelectRoleType = $data['role_type'];
        } else {
            $arrSelectRoleType = (isset($data['role_type']) && trim($data['role_type']) != '') ? explode(',', $data['role_type']) : [];
        }
        $optionRoleType = FunctionLib::getOptionMultil($this->arrRoleType, $arrSelectRoleType);

        $optionStatus = FunctionLib::getOption($this->arrStatus, isset($data['user_status']) ? $data['user_status'] : CGlobal::status_show);
        $optionSex = FunctionLib::getOption($this->arrSex, isset($data['user_sex']) ? $data['user_sex'] : CGlobal::status_show);

        $optionAutoLoan = FunctionLib::getOption($this->arrAutoLoan, isset($data['auto_loan']) ? $data['auto_loan'] : STATUS_INT_KHONG);
        $optionGroupSale = FunctionLib::getOption($this->arrGroupSale, isset($data['group_sale']) ? $data['group_sale'] : STATUS_INT_KHONG);
        $optionPosition = FunctionLib::getOption($this->arrPosition, isset($data['position']) ? $data['position'] : STATUS_INT_KHONG);
        $optionIsManager = FunctionLib::getOption($this->arrIsManager, isset($data['user_is_manager']) ? $data['user_is_manager'] : STATUS_INT_KHONG);
        $optionUserManager = FunctionLib::getOption($this->arrUserManager, isset($data['user_manager_id']) ? $data['user_manager_id'] : STATUS_INT_KHONG);
        $optionaDepartment = FunctionLib::getOption($this->arrDepartment, isset($data['user_depart_id']) ? $data['user_depart_id'] : STATUS_INT_KHONG);
        $optionaIsReceiveLoan = FunctionLib::getOption($this->arrIsReceiveLoan, isset($data['is_receive_loan']) ? $data['is_receive_loan'] : STATUS_INT_KHONG);
        return $this->viewOptionData = [
            'arrStatus' => $this->arrStatus,
            'arrAutoLoan' => $this->arrAutoLoan,
            'arrPosition' => $this->arrPosition,
            'arrRoleType' => $this->arrRoleType,
            'arrUserManager' => $this->arrUserManager,
            'arrIsManager' => $this->arrIsManager,
            'arrDepartment' => $this->arrDepartment,
            'arrUser' => $this->arrUser,
            'arrIsReceiveLoan' => $this->arrIsReceiveLoan,

            'optionStatus' => $optionStatus,
            'optionSex' => $optionSex,
            'optionRoleType' => $optionRoleType,
            'optionAutoLoan' => $optionAutoLoan,
            'optionGroupSale' => $optionGroupSale,
            'optionPosition' => $optionPosition,
            'optionIsManager' => $optionIsManager,
            'optionUserManager' => $optionUserManager,
            'optionaDepartment' => $optionaDepartment,
            'optionaIsReceiveLoan' => $optionaIsReceiveLoan,

            'is_root' => $this->is_root,
            'is_boss' => $this->is_boss,
            'permission_edit' => in_array($this->permission_edit, $this->permission) ? 1 : 0,
            'permission_create' => in_array($this->permission_create, $this->permission) ? 1 : 0,
            'permission_change_pass' => in_array($this->permission_change_pass, $this->permission) ? 1 : 0,
            'permission_remove' => in_array($this->permission_remove, $this->permission) ? 1 : 0,
            'permission_full_employee' => in_array($this->permission_full_employee, $this->permission) ? 1 : 0,
        ];
    }

    public function view()
    {
        CGlobal::$pageAdminTitle = "Quản trị User | Admin CMS";
        //check permission
        if (!$this->checkMultiPermiss([$this->permission_view])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $page_no = Request::get('page_no', 1);
        $dataSearch['user_status'] = Request::get('user_status', 0);
        $dataSearch['auto_loan'] = Request::get('auto_loan', STATUS_DEFAULT);
        $dataSearch['user_email'] = Request::get('user_email', '');
        $dataSearch['user_name'] = Request::get('user_name', '');
        $dataSearch['user_phone'] = Request::get('user_phone', '');
        $dataSearch['user_group'] = Request::get('user_group', 0);
        $dataSearch['role_type'] = Request::get('role_type', 0);
        $dataSearch['position'] = Request::get('position', 0);

        $limit = CGlobal::number_limit_show;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $data = $this->_user->searchByCondition($dataSearch, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $arrGroupUser = GroupUser::getListGroupUser();

        $this->getDataDefault();
        $this->_outDataView($dataSearch);
        return view('admin.AdminUser.view', [
            'data' => $data,
            'dataSearch' => $dataSearch,
            'size' => $total,
            'start' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'arrGroupUser' => $arrGroupUser,
        ], $this->viewOptionData);
    }

    /*********************************************************************************************************
     * Sửa User
     *********************************************************************************************************/
    public function editInfo($ids)
    {
        $id = FunctionLib::outputId($ids);
        CGlobal::$pageAdminTitle = "Sửa User | " . CGlobal::web_name;
//        //check permission
        if (!$this->is_root && !in_array($this->permission_edit, $this->permission)) {
            return Redirect::route('admin.dashboard', array('error' => STATUS_INT_MOT));
        }

        Loader::loadJS('lib/chosen/jquery-3.2.1.min.js', CGlobal::$POS_END);
        Loader::loadJS('lib/chosen/chosen.jquery.js', CGlobal::$POS_END);
        Loader::loadJS('lib/chosen/prism.js', CGlobal::$POS_END);
        Loader::loadJS('lib/chosen/init.js', CGlobal::$POS_END);

        $arrUserGroupMenu = $data = array();
        if ($id > 0) {
            $data = $this->_user->getUserById($id);
            $data['user_group'] = explode(',', $data['user_group']);
            $arrUserGroupMenu = explode(',', $data['user_group_menu']);
        }

        $this->getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminUser.add', [
            'data' => $data,
            'id' => $id,
            'arrStatus' => $this->arrStatus,
            'arrUserGroupMenu' => $arrUserGroupMenu,
        ], $this->viewOptionData);
    }

    //post
    public function edit($ids)
    {
        //check permission
        if (!$this->is_root && !in_array($this->permission_edit, $this->permission)) {
            return Redirect::route('admin.dashboard', array('error' => STATUS_INT_MOT));
        }
        Loader::loadJS('lib/chosen/jquery-3.2.1.min.js', CGlobal::$POS_END);
        Loader::loadJS('lib/chosen/chosen.jquery.js', CGlobal::$POS_END);
        Loader::loadJS('lib/chosen/prism.js', CGlobal::$POS_END);
        Loader::loadJS('lib/chosen/init.js', CGlobal::$POS_END);
        $id = FunctionLib::outputId($ids);

        $data = $_POST;
        $this->validUser($id, $data);

        //check chọn role quyền
        $arrRoleCheck = [];
        if (isset($data['role_type_chose']) && !empty($data['role_type_chose'])) {
            foreach ($data['role_type_chose'] as $role_id) {
                if ($role_id > 0) {
                    $arrRoleCheck[$role_id] = $role_id;
                }
            }
        }
        if (empty($arrRoleCheck)) {
            $this->error[] = 'Bạn chưa chọn vai trò cho user này';
        }
        //lấy phân quyền theo role
        if (empty($this->error)) {
            $dataInsert = $data;
            //Insert dữ liệu
            if ($this->is_root) {
                $role_type_new = implode(',', $arrRoleCheck);
                if (strcmp($role_type_new, trim($data['role_type_old'])) != 0) {
                    $inforRole = app(Role::class)->getDataByArrayRoleId($arrRoleCheck);
                    $arr_user_group = [];
                    $arr_user_group_menu = [];
                    if ($inforRole) {
                        foreach ($inforRole as $kk => $role) {
                            $infoPermiRole = RoleMenu::getInfoByRoleId((int)$role->role_id);
                            $str_user_group = (isset($infoPermiRole->role_group_permission) && trim($infoPermiRole->role_group_permission) != '') ? $infoPermiRole->role_group_permission : '';
                            $user_group = explode(',', $str_user_group);
                            if (!empty($user_group)) {
                                foreach ($user_group as $group_id) {
                                    if ($group_id > 0 && !in_array($group_id, $arr_user_group)) {
                                        $arr_user_group[] = $group_id;
                                    }
                                }
                            }

                            //group menu
                            $str_user_group_menu = (isset($infoPermiRole->role_group_menu_id) && trim($infoPermiRole->role_group_menu_id) != '') ? $infoPermiRole->role_group_menu_id : '';
                            $user_group_menu = explode(',', $str_user_group_menu);
                            if (!empty($user_group_menu)) {
                                foreach ($user_group_menu as $group_menu) {
                                    if ($group_menu > 0 && !in_array($group_menu, $arr_user_group_menu)) {
                                        $arr_user_group_menu[] = $group_menu;
                                    }
                                }
                            }
                        }
                    }

                    $dataInsert['user_group'] = !empty($arr_user_group) ? implode(',', $arr_user_group) : '';
                    $dataInsert['user_group_menu'] = !empty($arr_user_group_menu) ? implode(',', $arr_user_group_menu) : '';
                    $dataInsert['role_type'] = implode(',', $arrRoleCheck);
                }
                $dataInsert['user_name'] = $data['user_name'];
                $dataInsert['user_email'] = $data['user_email'];
                //$dataInsert['role_name'] = isset($groupRole[$data['role_type']]) ? $groupRole[$data['role_type']] : '';
            }

            if (isset($_FILES['image']) && count($_FILES['image']) > 0 && $_FILES['image']['name'] != '') {
                $folder = FOLDER_FILE_USER_ADMIN;;
                $_max_file_size = 2 * 1024 * 1024;
                $_file_ext = 'jpg,jpeg,png,gif';
                $pathFileUpload = app(Upload::class)->uploadFile('image', $_file_ext, $folder, $_max_file_size);
                if (trim($pathFileUpload) != '') {
                    app(Upload::class)->removeFile($data['user_image']);
                    $dataInsert['user_image'] = $pathFileUpload;
                }
            }

            if ($id > 0) {
                if ($this->_user->updateUser($id, $dataInsert)) {
                    return Redirect::route('admin.user_view');
                } else {
                    $this->error[] = 'Lỗi truy xuất dữ liệu';;
                }
            } else {
                $dataInsert['user_password'] = 'Vaymuon4@!2018';
                if($dataInsert['user_team_id'] > 0){
                    $inforTeam = app(VmDefine::class)->getItemById($dataInsert['user_team_id']);
                    $departId = (isset($inforTeam->type_item) && $inforTeam->type_item > 0) ? $inforTeam->type_item : 0;
                    $inforDepart = app(VmDefine::class)->getItemById($departId);

                    $dataInsert['user_id_leader'] = isset($inforTeam->object_id) ? $inforTeam->object_id : 0;;
                    $dataInsert['user_depart_id'] = $departId;
                    $dataInsert['user_id_boss_depart'] = isset($inforDepart->object_id) ? $inforDepart->object_id : 0;
                }
                $id_new = $this->_user->createNew($dataInsert);
            }
        }
        $data['role_type'] = isset($data['role_type_chose']) ? implode(',', $data['role_type_chose']) : (isset($data['role_type'])?implode(',', $data['role_type']):[]);
        $this->getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminUser.add', [
            'data' => $data,
            'id' => $id,
            'arrStatus' => $this->arrStatus,
            'error' => $this->error,
        ], $this->viewOptionData);
    }

    private function validUser($user_id = 0, $data = array())
    {
        if (!empty($data)) {
            if (isset($data['user_name']) && trim($data['user_name']) == '') {
                $this->error[] = 'Tài khoản đăng nhập không được bỏ trống';
            } elseif (isset($data['user_name']) && trim($data['user_name']) != '') {
                $checkIssetUser = $this->_user->getUserByName($data['user_name']);
                if ($checkIssetUser && $checkIssetUser->user_id != $user_id) {
                    $this->error[] = 'Tài khoản này đã tồn tại, hãy tạo lại';
                }
            }

            if (isset($data['user_full_name']) && trim($data['user_full_name']) == '') {
                $this->error[] = 'Tên nhân viên không được bỏ trống';
            }

            if (isset($data['position']) && trim($data['position']) == STATUS_INT_KHONG) {
                $this->error[] = 'Chưa chọn Chức vụ cho User';
            }

            if (isset($data['user_status']) && trim($data['user_status']) == STATUS_INT_KHONG) {
                $this->error[] = 'Chưa chọn trạng thái hoạt động';
            }

            if (isset($data['user_email']) && trim($data['user_email']) == '') {
                $this->error[] = 'Mail không được bỏ trống';
            }elseif(isset($data['user_email']) && trim($data['user_email']) != ''){
                $checkIssetUser = $this->_user->getUserByEmail($data['user_email']);
                if ($checkIssetUser && $checkIssetUser->user_id != $user_id) {
                    $this->error[] = 'Mail này đã tồn tại, hãy tạo lại';
                }
            }
        }
        return true;
    }

    public function changePassInfo($ids)
    {
        $id = FunctionLib::outputId($ids);
        $user = $this->_user->user_login();
        if (!$this->is_root && !in_array($this->permission_change_pass, $this->permission) && (int)$id !== (int)$user['user_id']) {
            return Redirect::route('admin.dashboard', array('error' => STATUS_INT_MOT));
        }

        return view('admin.AdminUser.change', [
            'id' => $id,
            'is_root' => $this->is_root,
            'permission_change_pass' => in_array($this->permission_change_pass, $this->permission) ? 1 : 0,
        ]);
    }

    public function changePass($ids)
    {
        $id = FunctionLib::outputId($ids);
        $user = $this->_user->user_login();
        //check permission
        if (!$this->is_root && !in_array($this->permission_change_pass, $this->permission) && (int)$id !== (int)$user['user_id']) {
            return Redirect::route('admin.dashboard', array('error' => STATUS_INT_MOT));
        }

        $error = array();
        $old_password = trim(Request::get('old_password', ''));
        $new_password = trim(Request::get('new_password', ''));
        $confirm_new_password = trim(Request::get('confirm_new_password', ''));

        if (!$this->is_root && !in_array($this->permission_change_pass, $this->permission)) {
            $user_byId = $this->_user->getUserById($id);
            if ($old_password == '') {
                $error[] = 'Bạn chưa nhập mật khẩu hiện tại';
            }
            if ($this->_user->password_verify($old_password, $user_byId->user_password) == false) {
                $error[] = 'Mật khẩu hiện tại không chính xác';
            }
        }
        if ($new_password == '') {
            $error[] = 'Bạn chưa nhập mật khẩu mới';
        } elseif (strlen($new_password) < 5) {
            $error[] = 'Mật khẩu quá ngắn';
        }
        if ($confirm_new_password == '') {
            $error[] = 'Bạn chưa xác nhận mật khẩu mới';
        }
        if ($new_password != '' && $confirm_new_password != '' && $confirm_new_password !== $new_password) {
            $error[] = 'Mật khẩu xác nhận không chính xác';
        }
        if (empty($error)) {
            //Insert dữ liệu
            if ($this->_user->updatePassword($id, $new_password)) {
                if ((int)$id !== (int)$user['user_id']) {
                    return Redirect::route('admin.user_view');
                } else {
                    if (Session::has('user')) {
                        Session::forget('user');
                        return Redirect::route('admin.login');
                    }
                }
            } else {
                $error[] = 'Không update được dữ liệu';
            }
        }
        return view('admin.AdminUser.change', [
            'id' => $id,
            'is_root' => $this->is_root,
            'error' => $error,
            'permission_change_pass' => in_array($this->permission_change_pass, $this->permission) ? 1 : 0,
        ]);
    }

    public function remove($ids)
    {
        $id = FunctionLib::outputId($ids);
        $data['success'] = 0;
        if (!$this->is_root && !in_array($this->permission_remove, $this->permission)) {
            return Response::json($data);
        }
        $user = User::find($id);
        if ($user) {
            if ($this->_user->remove($user)) {
                $data['success'] = 1;
            }
        }
        return Response::json($data);
    }

    //ajax
    public function ajaxGetInfoSettingUser()
    {
        $user_ids = Request::get('user_id', '');
        $user_id = FunctionLib::outputId($user_ids);
        $arrData = $data = array();
        $arrData['intReturn'] = 1;
        $arrData['msg'] = '';

        $html = view('admin.AdminUser.infoUserSetting', [
            'data' => $data,
            'optionPayment' => [],
            'user_id' => $user_ids,
        ])->render();
        $arrData['html'] = $html;
        return response()->json($arrData);
    }

    public function getProfile()
    {
        $id = $this->user_id;
        CGlobal::$pageAdminTitle = "Profile cá nhân | " . CGlobal::web_name;
        $data = array();
        if ($id > 0) {
            $data = $this->_user->getUserById($id);
        }

        $this->getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminUser.profile', [
            'data' => $data,
            'id' => $id,
        ], $this->viewOptionData);
    }

    public function postProfile()
    {
        $id = $this->user_id;
        $inforUser = $this->_user->getUserById($id);
        $data = $_POST;
        $data['role_type'] = $inforUser['role_type'];

        $this->validUser($id, $data);
        if (empty($this->error)) {
            //Insert dữ liệu
            $dataUpdate['user_email'] = $data['user_email'];
            $dataUpdate['user_phone'] = $data['user_phone'];
            $dataUpdate['user_sex'] = $data['user_sex'];
            $dataUpdate['user_full_name'] = $data['user_full_name'];

            if(isset($_FILES['image']) && count($_FILES['image'])>0 && $_FILES['image']['name'] != '') {
                $folder = FOLDER_FILE_USER_ADMIN;;
                $_max_file_size = 2 * 1024 * 1024;
                $_file_ext = 'jpg,jpeg,png,gif';
                $pathFileUpload = app(Upload::class)->uploadFile('image', $_file_ext, $folder, $_max_file_size);
                if(trim($pathFileUpload) != ''){
                    app(Upload::class)->removeFile($data['user_image']);
                    $dataUpdate['user_image'] = $pathFileUpload;
                }
            }
            if ($id > 0) {
                if ($this->_user->updateUser($id, $dataUpdate)) {
                    showMessage('status', 'Cập nhật thành công');
                    return Redirect::route('admin.user_profile');
                } else {
                    $this->error[] = 'Lỗi truy xuất dữ liệu';;
                }
            }
        }

        $this->getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminUser.profile', [
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewOptionData);
    }



    //quản lý nhân viên
    public function viewEmployee(){
        CGlobal::$pageAdminTitle = "Quản trị nhân viên | Admin CMS";
        //check permission
        if (!$this->checkMultiPermiss([$this->permission_full_employee])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $page_no = Request::get('page_no', 1);
        $dataSearch['user_status'] = Request::get('user_status', 0);
        $dataSearch['auto_loan'] = Request::get('auto_loan', STATUS_DEFAULT);
        $dataSearch['user_email'] = Request::get('user_email', '');
        $dataSearch['user_name'] = Request::get('user_name', '');
        $dataSearch['user_phone'] = Request::get('user_phone', '');
        $dataSearch['user_group'] = Request::get('user_group', 0);
        $dataSearch['role_type'] = Request::get('role_type', 0);
        $dataSearch['position'] = Request::get('position', 0);

        $dataSearch['managerEmployee'] = ($this->is_tech)? 0 : $this->user_id;

        $limit = CGlobal::number_limit_show;
        $total = 0;
        $offset = ($page_no - 1) * $limit;
        $data = $this->_user->searchByCondition($dataSearch, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $page_no, $total, $limit, $dataSearch) : '';
        $arrGroupUser = GroupUser::getListGroupUser();

        $this->getDataDefault();
        $this->_outDataView($dataSearch);
        return view('admin.AdminUser.viewEmployee', [
            'data' => $data,
            'dataSearch' => $dataSearch,
            'size' => $total,
            'start' => ($page_no - 1) * $limit,
            'paging' => $paging,
            'arrGroupUser' => $arrGroupUser,
        ], $this->viewOptionData);
    }
    public function getEmployee($ids)
    {
        if (!$this->checkMultiPermiss([$this->permission_full_employee])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        CGlobal::$pageAdminTitle = "Sửa nhân viên | " . CGlobal::web_name;
        $data = array();
        $id = getStrVar($ids);
        if ($id > 0) {
            $data = $this->_user->getUserById($id);
        }

        $this->getDataDefault();
        $this->_outDataView($data);

        return view('admin.AdminUser.addEmployee', [
            'data' => $data,
            'id' => $id,
        ], $this->viewOptionData);
    }

    public function postEmployee($ids)
    {
        if (!$this->checkMultiPermiss([$this->permission_full_employee])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id = getStrVar($ids);
        $inforUser = $this->_user->getUserById($id);
        $data = $_POST;
        $data['role_type'] = $inforUser['role_type'];

        $this->validUser($id, $data);
        if (empty($this->error)) {
            //Insert dữ liệu
            $dataUpdate['user_email'] = $data['user_email'];
            $dataUpdate['user_phone'] = $data['user_phone'];
            $dataUpdate['user_sex'] = $data['user_sex'];
            $dataUpdate['user_full_name'] = $data['user_full_name'];

            if(isset($_FILES['image']) && count($_FILES['image'])>0 && $_FILES['image']['name'] != '') {
                $folder = FOLDER_FILE_USER_ADMIN;;
                $_max_file_size = 2 * 1024 * 1024;
                $_file_ext = 'jpg,jpeg,png,gif';
                $pathFileUpload = app(Upload::class)->uploadFile('image', $_file_ext, $folder, $_max_file_size);
                if(trim($pathFileUpload) != ''){
                    app(Upload::class)->removeFile($data['user_image']);
                    $dataUpdate['user_image'] = $pathFileUpload;
                }
            }
            if ($id > 0) {
                if ($this->_user->updateUser($id, $dataUpdate)) {
                    showMessage('status', 'Cập nhật thành công');
                    return Redirect::route('admin.viewEmployee');
                } else {
                    $this->error[] = 'Lỗi truy xuất dữ liệu';;
                }
            }
        }

        $this->getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminUser.addEmployee', [
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewOptionData);
    }
}