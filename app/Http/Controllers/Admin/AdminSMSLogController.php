<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\SmsForgotLog;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;

class AdminSMSLogController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Lịch sử SMS';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_success'),
            STATUS_INT_AM_MOT => viewLanguage('status_failed'));

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_SMS_LOG_FULL),
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
        if (!$this->checkMultiPermiss([PERMISS_SMS_LOG_FULL])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['send_mo'] = Request::get('send_mo', -2);
        $search['send_mt'] = Request::get('send_mt', -2);
        $search['loaner_name'] = addslashes(Request::get('loaner_name'));
        $search['loaner_phone'] = Request::get('loaner_phone');
        $search['loaner_code'] = addslashes(Request::get('loaner_code'));
        $search['loaner_id'] = Request::get('loaner_id');
        $search['s_date'] = Request::get('s_date');
        $search['e_date'] = Request::get('e_date');
        $search['field_get'] = 'id,loaner_id,loaner_name,loaner_code,loaner_phone,created_at,message_mo,message_mt,send_mo,send_mt';
        
        $data = app(SmsForgotLog::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';
        $optionStatusSendMO = getOption($this->arrStatus, $search['send_mo']);
        $optionStatusSendMT = getOption($this->arrStatus, $search['send_mt']);

        return view('admin.AdminSMSLog.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionStatusSendMO' => $optionStatusSendMO,
            'optionStatusSendMT' => $optionStatusSendMT
        ], $this->viewPermission));
    }
}
