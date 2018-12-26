<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\UsersLoanLogs;
use App\Http\Models\Admin\User;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;

class AdminUserLoanLogController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Lịch sử chia YCV';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_HIDE => viewLanguage('status_hidden'));

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_USER_LOAN_LOG_FULL),
        ];
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
        ];
    }
    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_USER_LOAN_LOG_FULL])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['user_name'] = addslashes(Request::get('user_name', ''));
        $search['loan_name'] = Request::get('loan_name','');
        $search['s_date'] = Request::get('s_date');
        $search['e_date'] = Request::get('e_date');
        $search['field_get'] = 'id,user_id,user_name,introtext,loan_name,created_at';

        $data = app(UsersLoanLogs::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        return view('admin.AdminUserLoanLog.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
        ], $this->viewPermission));
    }
}
