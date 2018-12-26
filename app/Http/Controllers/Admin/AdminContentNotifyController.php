<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\ContentNotifications;
use App\Http\Models\Admin\Products;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use Monolog\Logger;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Notification\VMNotification;
use Illuminate\Support\Facades\Log;

class AdminContentNotifyController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();

    private $objectReceive = array();
    private $typeNoti = array();
    private $typeSend = array();
    
    private $viewOptionData = array();
    private $viewPermission = array();

    private $logger;

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Danh sách nội dung thông báo';
        date_default_timezone_set('asia/ho_chi_minh');
        $this->logger = new Logger('AdminContentNotifyController');
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('Hiện'),
            STATUS_HIDE => viewLanguage('status_hidden'));

        $this->objectReceive = array(
            STATUS_INT_KHONG => viewLanguage('status_all'),
            STATUS_INT_MOT => viewLanguage('object_nguoi_vay'),
            STATUS_INT_HAI => viewLanguage('object_nha_dau_tu'));

        $this->typeNoti = array(
            STATUS_INT_KHONG => viewLanguage('status_all'),
            STATUS_INT_MOT => viewLanguage('type_noti'),
            STATUS_INT_HAI => viewLanguage('type_sms'));
        
        $this->typeSend = array(
            STATUS_INT_KHONG => viewLanguage('type_send_schedule'),
            STATUS_INT_MOT => viewLanguage('type_send_now'));

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_CONTENT_NOTIFICATION_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_CONTENT_NOTIFICATION_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_CONTENT_NOTIFICATION_DELETE),
            'permission_lock' => $this->checkPermiss(PERMISS_CONTENT_NOTIFICATION_LOCK),
            'permission_active' => $this->checkPermiss(PERMISS_CONTENT_NOTIFICATION_ACTIVE),
        ];
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_HIDE);
        $optionObjectReceives = getOption($this->objectReceive, isset($data['object_receive']) ? $data['object_receive'] : STATUS_INT_KHONG);
        $optionTypeNoti = getOption($this->typeNoti, isset($data['type_noti']) ? $data['type_noti'] : STATUS_INT_KHONG);
        $optionTypeSend = getOption($this->typeSend, isset($data['type_send']) ? $data['type_send'] : STATUS_INT_KHONG);
        $optionProducts = getOption($this->getProductOption(), isset($data['product_receive']) ? $data['product_receive'] : -2);

        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionObjectReceives' => $optionObjectReceives,
            'optionTypeNoti' => $optionTypeNoti,
            'optionTypeSend' => $optionTypeSend,
            'optionProducts' => $optionProducts,
            'dataTypeNoti' => $this->typeNoti,
            'dataTypeSend' => $this->typeSend,
            'dataObjectReceives' => $this->objectReceive,
            'dataProducts' => $this->getProductOption(),
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
        ];
    }

    public function getProductOption()
    {
        $data = [];
        $products = app(Products::class)->getAllData();
        foreach ($products as $product) {
            $data[$product->channel] = $product->name;
        }
        return $data;
    }

    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_CONTENT_NOTIFICATION_FULL, PERMISS_CONTENT_NOTIFICATION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['code'] = addslashes(Request::get('code'));
        $search['object_receive'] = (int)Request::get('object_receive', -2);
        $search['product_receive'] = Request::get('product_receive', '');
        $search['type_noti'] = (int)Request::get('type_noti', -2);
        $search['type_send'] = (int)Request::get('type_send', -2);
        $search['s_date'] = Request::get('s_date');
        $search['e_date'] = Request::get('e_date');
        $search['field_get'] = 'id,name,code,content_send,object_receive,time_to_send,product_receive,type_noti,type_send,status,created_at,updated_at';


        $data = app(ContentNotifications::class)->searchESByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(5, $pageNo, $data['total'], $limit, $search) : '';
        $total = $data['total'];

        $this->_outDataView($search);
        return view('admin.AdminContentNotify.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $total,
            'arrStatus' => $this->arrStatus,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging
        ], $this->viewPermission,$this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_CONTENT_NOTIFICATION_FULL, PERMISS_CONTENT_NOTIFICATION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $data = (($id > 0)) ? app(ContentNotifications::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminContentNotify.add', array_merge([
            'data' => $data,
            'id' => $id,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_CONTENT_NOTIFICATION_FULL, PERMISS_CONTENT_NOTIFICATION_CREATE,PERMISS_CONTENT_NOTIFICATION_LOCK,PERMISS_CONTENT_NOTIFICATION_ACTIVE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $prefixCode = 'TB';
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            // Handle notification type
            if (isset($data['type_noti_arr']) && sizeof($data['type_noti_arr']) == 1) {
                $data['type_noti'] = $data['type_noti_arr'][0];
            } else {
                $data['type_noti'] = 0;
            }
            if(isset($data['status_lock'])){
                $data['status'] = STATUS_HIDE;
            }
            elseif(isset($data['status_active'])){
                $data['status'] = STATUS_SHOW;
            }

            if ($id > 0) {
                //cap nhat
                $data['time_to_send'] = $data['type_send'] == 0 
                    ? \Carbon\Carbon::createFromFormat('d/m/Y H:i', trim($data['time_to_send'])) 
                    : \Carbon\Carbon::now();

                $data['code'] = (trim($data['code']) == '') ? createSequence($prefixCode, $id) : $data['code'];
//                dd($data);
                if (app(ContentNotifications::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.contentNotifyView')->with('status','Cập nhật thành công');
                }
            } else {
                //them moi
                $data['time_to_send'] = $data['type_send'] == 0 
                    ? \Carbon\Carbon::createFromFormat('d/m/Y H:i', trim($data['time_to_send'])) 
                    : \Carbon\Carbon::now();
                
                if ($_id = app(ContentNotifications::class)->createItem($data)) {
                    $_data['code'] = createSequence($prefixCode, $_id);
                    app(ContentNotifications::class)->updateItem($_id, $_data);
                    return Redirect::route('admin.contentNotifyView')->with('status','Thêm mới thành công');
                }
            }
        }
        if($data['status'] == STATUS_SHOW){
            $data['status'] = STATUS_HIDE;
        }
        else{
            $data['status'] = STATUS_SHOW;
        }
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminContentNotify.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewPermission, $this->viewOptionData));
    }

    // ajax delete
    public function deleteContentNotifications()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_CONTENT_NOTIFICATION_FULL, PERMISS_CONTENT_NOTIFICATION_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(ContentNotifications::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    // ajax send
    public function ajaxSendNotificationMultiLoaner()
    {
        $this->logger->info('begin sending message |===========>>>', [Request::all()]);
        $channel = Request::get('channel');
        $content = Request::get('content');
        $id = Request::get('id');
        if ($channel == 'Total') {
            $channel = 'VM_2018';
        }
        $validator = Validator::make([
            'channel' => $channel,
            'content' => $content
        ], [
            'channel' => 'required',
            'content' => 'required'
        ]);
        try {
            if (!$validator->fails()) {
                $this->logger->info('ajaxSendNotificationMultiLoaner |============>>>', []);
                app(VMNotification::class)->pushNotificationByTopic($channel, -1, $content, env('API_ACCESS_KEY_LOANER'));
                $data = [
                    'time_to_send' => getCurrentDateTime()
                ];
                app(ContentNotifications::class)->updateItem($id,$data);
            }
        } catch (\Exception $e) {
            Log::debug('ajaxSendNotificationMultiLoaner exception |=====>>' . $e->getMessage());
        }
        return json_encode('Gửi thông báo thành công');
    }

    // ajax lock
    public function ajaxlockOrActiveContentNotifications()
    {
        $id = Request::get('id');
        $status = Request::get('status');
        $data['status'] = $status;

        if ($id > 0) {
            $isOK = app(ContentNotifications::class)->updateItem($id, $data);
            $isOK = $isOK ? 1 : 0;
            return Response::json(['isOK' => $isOK]);
        }
    }


    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['name']) && trim($data['name']) == '') {
                $this->error[] = 'Tên thông báo không được bỏ trống';
            }
            if (isset($data['content_send']) && trim($data['content_send']) == '') {
                $this->error[] = 'Nội dung gửi không được bỏ trống';
            }
            if (isset($data['time_to_send'])){
                if($this->_validateDateTime($data['time_to_send']) && $data['type_send'] == '0'){
                    $this->error[] = 'Thời gian gửi không đúng định dạng';
                }
                elseif((strtotime(str_replace('/','-',$data['time_to_send'])) < strtotime(getCurrentDateTime())) && $data['type_send'] == '0' ){
                    $this->error[] = 'Thời gian gửi phải lớn hơn thời gian hiện tại';
                }
            }
            if (isset($data['type_send'])) {
                if($data['type_send'] == -2){
                    $this->error[] = 'Vui lòng chọn phương thức gửi';
                }
                elseif (isset($data['time_to_send']) &&
                    $data['time_to_send'] == '' && 
                    $data['type_send'] == '0') {
                    $this->error[] = 'Thời gian đặt lịch không được bỏ trống';
                }
            }
            if (isset($data['object_receive']) && $data['object_receive'] == -2) {
                $this->error[] = 'Đối tượng gửi chưa được chọn';
            }

            if (isset($data['career_receive']) && $data['career_receive'] == -2) {
                $this->error[] = 'Nghề nghiệp chưa được chọn';
            }
        }
        return true;
    }

    private function _validateDateTime($date)
    {
        return preg_match('/^(([0-2]?[0-9]|3[0-1])(\.|\/|-|){1}([0]?[1-9]|1[0-2])(\.|\/|-|){1}[1-2]\d{3})( |){1}(20|21|22|23|[0-1]?\d{1})(:|){1}([0-5]?\d{1})$/', $date) == 1 ? false : true;
    }
}
