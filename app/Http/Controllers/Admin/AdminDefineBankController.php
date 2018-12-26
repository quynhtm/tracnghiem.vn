<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\VmDefine;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;

class AdminDefineBankController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $arrDefineType = array();
    private $arrTypeItem = array();
    private $viewOptionData = array();
    private $viewPermission = array();
    private $prefixCode = array(
        TIEU_CHI_THAM_DINH_DEFINE_TYPE => 'TCTD',
        LY_DO_TU_CHOI_DEFINE_TYPE => 'LDTC',
        NGAN_HANG_DEFINE_TYPE => 'NH',
        PHUONG_THUC_CHUYEN_TIEN_DEFINE_TYPE => 'PTCT',
        PHUONG_THUC_THANH_TOAN_DEFINE_TYPE => 'PTTT',
        DOI_TUONG_AP_DUNG_DEFINE_TYPE => 'DTAD',
        THE_DIEN_THOAI_DEFINE_TYPE => 'TDT',
        REPAYMENT_HISTORY_HINH_THUC => 'RHHT',
        REPAYMENT_HISTORY_NOI_DUNG_TRAO_DOI => 'NDTD',
        USER_SALE_GROUP => 'USG',
        USER_POSITION => 'UP',
        DEFINE_DEPARMENT => 'DE',
    );

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý Ngân hàng hệ thống';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_STOP => viewLanguage('status_stop')
        );
        $this->arrTypeItem = array(
            STATUS_INT_KHONG => viewLanguage('Không'),
            STATUS_INT_MOT => viewLanguage('Có')
        );

        $this->arrDefineType = array(
            TIEU_CHI_THAM_DINH_DEFINE_TYPE => viewLanguage('Tiêu chí thẩm định'),
            LY_DO_TU_CHOI_DEFINE_TYPE => viewLanguage('Lý do từ chối'),
            NGAN_HANG_DEFINE_TYPE => viewLanguage('Thiết lập Ngân hàng'),
            PHUONG_THUC_CHUYEN_TIEN_DEFINE_TYPE => viewLanguage('Phương thức chuyển tiền'),
            PHUONG_THUC_THANH_TOAN_DEFINE_TYPE => viewLanguage('Phương thức thanh toán'),
            DOI_TUONG_AP_DUNG_DEFINE_TYPE => viewLanguage('Đối tượng áp dụng'),
            THE_DIEN_THOAI_DEFINE_TYPE => viewLanguage('Thẻ điện thoại'),
            REPAYMENT_HISTORY_HINH_THUC => viewLanguage('Hình thức lịch sử thu hồi'),
            REPAYMENT_HISTORY_NOI_DUNG_TRAO_DOI => viewLanguage('Nội dung trao đổi'),
            USER_SALE_GROUP => viewLanguage('Sale team'),
            USER_POSITION => viewLanguage('Chức vụ'),
            DEFINE_DEPARMENT => viewLanguage('Phòng ban'),
        );
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_DEFINE_FULL),
            'permission_view' => $this->checkPermiss(PERMISS_DEFINE_VIEW),
            'permission_create' => $this->checkPermiss(PERMISS_DEFINE_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_DEFINE_DELETE),
        ];
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['define_status']) ? $data['define_status'] : STATUS_SHOW);
        $optionDefineType = getOption($this->arrDefineType, isset($data['define_type']) ? $data['define_type'] : NGAN_HANG_DEFINE_TYPE);
        $optionTypeItem = getOption($this->arrTypeItem, isset($data['type_item']) ? $data['type_item'] : STATUS_INT_KHONG);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionDefineType' => $optionDefineType,
            'optionTypeItem' => $optionTypeItem,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
            'arrStatus' => $this->arrStatus,
            'arrTypeItem' => $this->arrTypeItem,
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_DEFINE_FULL, PERMISS_DEFINE_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_50;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['define_name'] = addslashes(Request::get('define_name', ''));
        $search['define_code'] = addslashes(Request::get('define_code', ''));
        $search['define_status'] = addslashes(Request::get('define_status', STATUS_DEFAULT));
        $search['define_type'] = addslashes(Request::get('define_type', NGAN_HANG_DEFINE_TYPE));
        //$search['field_get'] = 'id,define_code,define_name,define_note,define_type,define_status';
        $data = app(VmDefine::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($data);
        $optionSearchStatus = getOption($this->arrStatus, $search['define_status']);
        $optionSearchType = getOption($this->arrDefineType, $search['define_type']);

        return view('admin.AdminDefineBank.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionSearchStatus' => $optionSearchStatus,
            'optionSearchType' => $optionSearchType,
            'arrStatus' => $this->arrStatus
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_DEFINE_FULL, PERMISS_DEFINE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        $data['define_type'] = NGAN_HANG_DEFINE_TYPE;
        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                $prefixCode = isset($this->prefixCode[$data['define_type']]) ? $this->prefixCode[$data['define_type']] : 'DF';
                $data['define_code'] = (trim($data['define_code']) == '') ? createSequence($prefixCode, $id) : $data['define_code'];
                app(VmDefine::class)->updateItem($id, $data);
            } else {
                $_id = app(VmDefine::class)->createItem($data);
                if (isset($data['define_code']) && trim($data['define_code']) == '') {
                    $prefixCode = isset($this->prefixCode[$data['define_type']]) ? $this->prefixCode[$data['define_type']] : 'DF';
                    $_data['define_code'] = createSequence($prefixCode, $_id);
                    app(VmDefine::class)->updateItem($_id, $_data);
                }
            }
        }
        $result['url'] = URL::route('admin.viewDefineBank', ['define_type' => $data['define_type']]);
        return Response::json($result);
    }

    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_DEFINE_FULL, PERMISS_DEFINE_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(VmDefine::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function ajaxLoadForm()
    {
        if (!$this->checkMultiPermiss([PERMISS_DEFINE_FULL, PERMISS_DEFINE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id = $_POST['id'];
        $data = (($id > 0)) ? app(VmDefine::class)->getItemById($id) : [];

        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminDefineBank.component.ajax_load_item',
            array_merge([
                'data' => $data,
            ], $this->viewPermission, $this->viewOptionData));
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['define_name']) && trim($data['define_name']) == '') {
                $this->error[] = 'Tên Ngân hàng không được bỏ trống';
            }
            if (isset($data['object_id']) && trim($data['object_id']) == '') {
                $this->error[] = 'Bank ID không được bỏ trống';
            }
        }
        return true;
    }
}
