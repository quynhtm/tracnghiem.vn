<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\Loaners;
use App\Http\Models\Admin\Notifications;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;

class AdminNotificationController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý lịch sử thông báo';
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
            'permission_full' => $this->checkPermiss(PERMISS_NOTIFICATION_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_NOTIFICATION_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_NOTIFICATION_DELETE),
        ];
    }

    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_NOTIFICATION_FULL, PERMISS_NOTIFICATION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['created_at_from'] = Request::get('created_at_from');
        $search['created_at_to'] = Request::get('created_at_to');
        $search['loaner_id'] = Request::get('loaner_id');
        //$search['field_get'] = 'menu_name,menu_id,parent_id';//cac truong can lay
        $result = app(Notifications::class)->searchByCondition($search, $limit, $offset);

        // mảng chứa loaner_id
        $array_loaner_id = $infor_loaner = [];
        if(isset($result['data']) && !empty($result['data'])){
            $total = $result['total'];
            $data = $result['data'];
            foreach ($result['data'] as $value){
                $array_loaner_id[$value->loaner_id] = $value->loaner_id;
            }
            $infor_loaner = [];
            if(!empty($array_loaner_id)){
                $search_loaner = ['loaner_id'=>$array_loaner_id,'field_get'=>'full_name,id'];
                $data_loaner = app(Loaners::class)->searchByCondition($search_loaner, 40, 0,false);
                if(isset($data_loaner['data']) && !empty($data_loaner['data'])){
                    foreach ($data_loaner['data'] as $key_loaner=>$value_loaner){
                        $infor_loaner[$value_loaner->id] = $value_loaner->full_name;
                    }
                }
            }
        }

        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
        return view('admin.AdminNotification.view', array_merge([
            'data' => $data,
            'search' => $search,
            'infor_loaner'=>$infor_loaner,
            'total' => $total,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
//            'optionStatus' => $optionStatus,
        ], $this->viewPermission));
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
        ];
    }
}
