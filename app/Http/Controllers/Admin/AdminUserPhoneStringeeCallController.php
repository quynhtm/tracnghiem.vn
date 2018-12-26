<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\UsersPhoneStringeeCall;
use App\Library\AdminFunction\CGlobal;
use App\Stringee;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;

class AdminUserPhoneStringeeCallController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct(){
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý số điện thoại trên stringee';
    }

    public function _getDataDefault(){
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_HIDE => viewLanguage('status_block')
        );
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_USER_PHONE_STRINGEE_CALL_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_USER_PHONE_STRINGEE_CALL_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_USER_PHONE_STRINGEE_CALL_DELETE),
        ];
    }

    public function view(){
        if (!$this->checkMultiPermiss([PERMISS_USER_PHONE_STRINGEE_CALL_FULL, PERMISS_USER_PHONE_STRINGEE_CALL_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['phone_number'] = addslashes(Request::get('phone_number', ''));
        $search['phone_status'] = addslashes(Request::get('phone_status', STATUS_DEFAULT));
        $search['field_get'] = 'id,phone_number,phone_provide,phone_created,phone_status';
        $data = app(UsersPhoneStringeeCall::class)->searchByCondition($search, $limit, $offset);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($data);

        $optionSearch = getOption($this->arrStatus, $search['phone_status']);
        return view('admin.AdminUserPhoneStringeeCall.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionSearch' => $optionSearch,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id){
        if (!$this->checkMultiPermiss([PERMISS_USER_PHONE_STRINGEE_CALL_FULL, PERMISS_USER_PHONE_STRINGEE_CALL_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;

        $data['phone_provide'] = Stringee::checkPhoneProvideStringee($data['phone_number'], 0);

        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                app(UsersPhoneStringeeCall::class)->updateItem($id, $data);
            } else {
                $data['phone_created'] = time();
                app(UsersPhoneStringeeCall::class)->createItem($data);
            }
        }
        $_data['url'] = URL::route('admin.userPhoneStringeeCallView');
        return Response::json($_data);
    }

    public function ajaxLoadForm()
    {
        if (!$this->checkMultiPermiss([PERMISS_USER_PHONE_STRINGEE_CALL_FULL, PERMISS_USER_PHONE_STRINGEE_CALL_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id = $_POST['id'];
        $data = (($id > 0)) ? app(UsersPhoneStringeeCall::class)->getItemById($id) : [];

        $this->_getDataDefault();
        $optionStatus = getOption($this->arrStatus, isset($data['phone_status']) ? $data['phone_status'] : STATUS_SHOW);
        return view('admin.AdminUserPhoneStringeeCall.component.ajax_load_item',
            array_merge([
                'data' => $data,
                'optionStatus' => $optionStatus,
            ], $this->viewPermission));
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['phone_status']) ? $data['phone_status'] : STATUS_SHOW);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
            'arrStatus' => $this->arrStatus,
        ];
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['name']) && trim($data['name']) == '') {
                $this->error[] = 'Null';
            }
        }
        return true;
    }
}
