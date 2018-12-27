<?php
/*
* @Created by: DUYNX
* @Author    : nguyenduypt86@gmail.com
* @Date      : 06/2016
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use App\Http\Models\Admin\User;
use App\Http\Models\Admin\GroupUserPermission;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class AdminLoginController extends Controller
{

    public $_user;

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function getLogin($url = '')
    {

        if (Session::has('user')) {
            if ($url === '' || $url === 'user') {
                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::to(self::buildUrlDecode($url));
            }
        } else {
            return view('admin.AdminUser.login');
        }
    }

    public function postLogin(Request $request, $url = '')
    {
        if (Session::has('user')) {
            if ($url === '' || $url === 'user') {
                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::to(self::buildUrlDecode($url));
            }
        }

        $token = Request::get('_token', '');
        $username = Request::get('user_name', '');
        $password = Request::get('user_password', '');
        $error = '';

        if (trim($token) != '') {
            if ($username != '' && $password != '') {
                if (strlen($username) < 3 || strlen($username) > 50 || preg_match('/[^A-Za-z0-9_\.@]/', $username) || strlen($password) < 5) {
                    $error = 'Không tồn tại tên đăng nhập!';
                } else {
                    $user = $this->_user->getUserByName($username);
                    if ($user !== NULL) {
                        if ($user->user_status == CGlobal::status_hide || $user->user_status == CGlobal::status_block) {
                            $error = 'Tài khoản bị khóa!';
                        } elseif ($user->user_status == CGlobal::status_show || $user->user_view == CGlobal::status_hide) {
                            if ($this->_user->password_verify(trim($password), $user->user_password)) {
                                $permission_code = array();
                                $group = explode(',', $user->user_group);
                                if ($group) {
                                    $permission = GroupUserPermission::getListPermissionByGroupId($group);
                                    if ($permission) {
                                        foreach ($permission as $v) {
                                            $permission_code[] = $v->permission_code;
                                        }
                                    }
                                }

                                $data = array(
                                    'user_id' => $user->user_id,
                                    'user_project' => $user->user_project,
                                    'user_object_id' => $user->user_object_id,
                                    'user_parent' => $user->user_parent,
                                    'user_name' => $user->user_name,
                                    'user_full_name' => $user->user_full_name,
                                    'user_email' => $user->user_email,
                                    'user_depart_id' => $user->user_depart_id,
                                    'user_is_admin' => $user->user_is_admin,
                                    'user_group_menu' => $user->user_group_menu,
                                    'is_boss' => $user->user_view,
                                    'role_type' => $user->role_type,
                                    'user_permission' => $permission_code,
                                    'auto_loan' => $user->auto_loan,
                                    'group_sale' => $user->group_sale,
                                    'position' => $user->position,
                                    'user_manager_id' => $user->user_manager_id,
                                    'user_is_manager' => $user->user_is_manager,
                                    'user_image' => $user->user_image,
                                    'change_pass' => $user->change_pass,
                                    'role_code' => $user->role_code,
                                );

                                Session::put('user', $data, 60 * 24);
                                $this->_user->updateLogin($user->user_id);

                                if ($url === '' || $url === 'login') {
                                    if($user->change_pass == STATUS_INT_KHONG){
                                        return Redirect::route('admin.user_change',['id'=>setStrVar($user->user_id)]);
                                    }
                                    return Redirect::route('admin.dashboard');
                                } else {
                                    return Redirect::to(self::buildUrlDecode($url));
                                }
                            } else {
                                $error = 'Mật khẩu không đúng!';
                            }
                        }
                    } else {
                        $error = 'Không tồn tại tên đăng nhập!';
                    }
                }
            } else {
                $error = 'Chưa nhập thông tin đăng nhập!';
            }
        }

        return view('admin.AdminUser.login', ['error' => $error, 'username' => $username]);
    }
    public function encode_password($password)
    {
        return password_hash($password . CGlobal::project_name . '-!@0938413368!@', PASSWORD_DEFAULT);
    }
    public function logout(Request $request){
        if (Session::has('user')) {
            $user =  Session::get('user');
            //Check user logout de chia YCV
            $user_id = isset($user['user_id']) ? $user['user_id'] : 0;
            $user_position = isset($user['position']) ? $user['position'] : 0;
            if($user_id && in_array($user_position, ServiceLoanSplit::$user_position) && ServiceLoanSplit::$usesplit){
               app(ServiceLoanSplit::class)->setSessionUserLogout($user_id);
            }
            Session::forget('user');
            //update logout
            $this->_user->updateLogOut($user_id);
            app(TBSession::class)->removeUserLogin($user_id);
        }
        return Redirect::route('admin.login');
    }

    //ajax
    public function forgot_password()
    {
        return true;
        $email_forgot_password = Request::get('email_forgot_password', '');
        $arrData = $data = array();
        $arrData['isOk'] = STATUS_INT_KHONG;
        $arrData['msg'] = 'Chưa đổi được mật khẩu. Hãy thử lại';

        if(trim($email_forgot_password) != ''){
            $user = app(User::class)->getUserByEmail(trim($email_forgot_password));
            if($user){
                if($user->user_status == CGlobal::status_hide || $user->user_status == CGlobal::status_block){
                    $arrData['msg'] = 'Tài khoản của bạn bị khóa. Liên hệ với Admin';
                }else{
                    $password_new = randomString(8);
                    $dataUser['user_password'] = self::encode_password($password_new);
                    $dataUser['change_pass'] = STATUS_INT_KHONG;
                    $abc = DB::table(TABLE_USER_ADMIN)->where('user_id', $user->user_id)->update($dataUser);
                    if($abc){
                        $dataSend['email_receive'] = $user->user_email;
                        $dataSend['name'] = $user->user_full_name;
                        $dataSend['password_new'] = $password_new;
                        /*if(app(SendMailService::class)->sentEmailForgotPassword($dataSend)){
                            $arrData['isOk'] = STATUS_INT_MOT;
                            $arrData['msg'] = 'Bạn hãy vào mail để lấy mật khẩu mới.';
                        }else{
                            $arrData['msg'] = 'Chưa gửi được mail';
                        }*/
                    }
                }
            }else{
                $arrData['msg'] = 'Không tồn tại user có Email này.';
            }
        }
        return response()->json($arrData);
    }
}