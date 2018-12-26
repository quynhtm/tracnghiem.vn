<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\User;
use App\Http\Models\Admin\UsersPermissionStringeeCall;
use App\Library\AdminFunction\CGlobal;
use App\Library\AdminFunction\Loader;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\Request;

class UsersPermissionStringeeCallController extends BaseAdminController{
    private $viewPermission = array();
    private $viewOptionData = array();

    public function __construct(){
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Phân quyền nghe gọi Stringee';
    }

    public function _getDataDefault(){
        Loader::loadJS('admin/js/call/js-stringee.js', CGlobal::$POS_END);
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_STRINGEE_CALL_ANSWER_FULL),
            'permission_view' => $this->checkPermiss(PERMISS_STRINGEE_CALL_ANSWER_VIEW),
            'permission_create' => $this->checkPermiss(PERMISS_STRINGEE_CALL_ANSWER_CREATE)
        ];
    }

    public function view(){
        if (!$this->checkMultiPermiss([PERMISS_STRINGEE_CALL_ANSWER_FULL, PERMISS_STRINGEE_CALL_ANSWER_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $this->_getDataDefault();

        $pageNo = Request::get('page_no', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $total = 0;

        $searchFields['user_full_name'] = addslashes(Request::get('user_full_name', ''));
        $searchFields['user_email'] = addslashes(Request::get('user_email', ''));
        $searchFields['field_get'] = '';

        $data = app(User::class)->searchByCondition($searchFields, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(PAGE_SCROLL, $pageNo, $total, $limit, $searchFields) : '';

        $arrUserId = getArrayByKeyToObject($data, 'user_id');
        $dataPermissionStringee = UsersPermissionStringeeCall::getDataByArrUid($arrUserId);

        return view('admin.AdminPermissionStringeeCallAnswer.view', array_merge([
            'data' => $data,
            'paging' => $paging,
            'total' => $total,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
            'search' => $searchFields,
            'dataPermissionStringee' => $dataPermissionStringee,
        ], $this->viewPermission));
    }
    public function doEdit(){

        if (!$this->checkMultiPermiss([PERMISS_STRINGEE_CALL_ANSWER_FULL, PERMISS_STRINGEE_CALL_ANSWER_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $permistion = Request::get('permistion', []);
        $permistion_me = Request::get('permistion_me', []);
        $username = Request::get('username', []);
        $usermail = Request::get('usermail', []);

        if(!empty($usermail)){
            foreach($usermail as $uid => $item){
                $check = app(UsersPermissionStringeeCall::class)->getItemByUserId($uid);
                $data = array(
                    'user_id'=>(int)$uid,
                    'user_name'=>isset($username[$uid]) ? stripcslashes($username[$uid]) : '',
                    'status_call_stringee'=>isset($permistion[$uid]) ? (int)$permistion[$uid] : 0,
                    'status_call_stringee_me'=>isset($permistion_me[$uid]) ? (int)$permistion_me[$uid] : 0,
                    'user_mail'=>$item,
                );
                if($data['status_call_stringee'] == STATUS_SHOW){
                    $data['active_created'] = time();
                    $data['disable_created'] = '';
                    if(isset($check->id) && $check->status_call_stringee == 1){
                        unset($data['active_created']);
                    }
                }
                if($data['status_call_stringee'] == STATUS_HIDE){
                    $data['disable_created'] = time();
                    unset($data['active_created']);
                }
                if(isset($check->id)){
                    app(UsersPermissionStringeeCall::class)->updateItem($check->id, $data);
                }else{
                    app(UsersPermissionStringeeCall::class)->createItem($data);
                }
            }
        }
        return redirect()->back()->with('status', viewLanguage('Cập nhật thành công.'));
    }
}
