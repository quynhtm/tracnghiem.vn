<?php
/*
* @Created by: QuynhTM
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\VmDefine;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;

class TracNghiemDefineController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $arrDefineType = array();
    private $arrUrlDefine = array();
    private $viewOptionData = array();
    private $viewPermission = array();
    private $prefixCode = array(
        TRAC_NGHIEM_KHOI_LOP => 'KL',
        TRAC_NGHIEM_MON_HOC => 'MH',
        TRAC_NGHIEM_CHUYEN_DE => 'CD',
        TRAC_NGHIEM_CHUC_VU => 'CV'
    );

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý cấu hình Define hệ thống';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_STOP => viewLanguage('status_stop')
        );

        $this->arrDefineType = array(
            TRAC_NGHIEM_KHOI_LOP => viewLanguage('Khối lớp'),
            TRAC_NGHIEM_MON_HOC => viewLanguage('Môn học'),
            TRAC_NGHIEM_CHUYEN_DE => viewLanguage('Chuyên đề'),
            TRAC_NGHIEM_CHUC_VU => viewLanguage('Chức vụ'),
        );

        $this->arrUrlDefine = array(
            TRAC_NGHIEM_KHOI_LOP => ['url' => 'tracnghiem.schoolBlock', 'pageTitle' => 'Quản lý khối lớp'],
            TRAC_NGHIEM_MON_HOC => ['url' => 'tracnghiem.subjects', 'pageTitle' => 'Quản lý môn học'],
            TRAC_NGHIEM_CHUYEN_DE => ['url' => 'tracnghiem.thematic', 'pageTitle' => 'Quản lý chuyên đề'],
            TRAC_NGHIEM_CHUC_VU => ['url' => 'tracnghiem.position', 'pageTitle' => 'Quản lý chức vụ'],
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
        $optionDefineType = getOption($this->arrDefineType, isset($data['define_type']) ? $data['define_type'] : TRAC_NGHIEM_KHOI_LOP);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionDefineType' => $optionDefineType,
            'pageAdminTitle' => $this->arrUrlDefine[$data['define_type']]['pageTitle'],
            'arrStatus' => $this->arrStatus,
        ];
    }

    public function schoolBlock()
    {
        return self::view(TRAC_NGHIEM_KHOI_LOP);//khối lớp
    }

    public function subjects()
    {
        return self::view(TRAC_NGHIEM_MON_HOC);//môn học
    }

    public function thematic()
    {
        return self::view(TRAC_NGHIEM_CHUYEN_DE);//chuyên đề
    }

    public function position()
    {
        return self::view(TRAC_NGHIEM_CHUC_VU);//chức vụ
    }

    public function view($define_type)
    {
        if (!$this->checkMultiPermiss([PERMISS_DEFINE_FULL, PERMISS_DEFINE_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_50;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['define_name'] = addslashes(Request::get('define_name', ''));
        $search['define_code'] = addslashes(Request::get('define_code', ''));
        $search['define_status'] = addslashes(Request::get('define_status', STATUS_DEFAULT));
        $search['define_type'] = addslashes(Request::get('define_type', $define_type));
        //$search['field_get'] = 'id,define_code,define_name,define_note,define_type,define_status';
        $data = app(VmDefine::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($search);
        $optionSearchStatus = getOption($this->arrStatus, $search['define_status']);
        $optionSearchType = getOption($this->arrDefineType, $search['define_type']);

        return view('tracnghiem.TracNghiemDefine.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionSearchStatus' => $optionSearchStatus,
            'optionSearchType' => $optionSearchType,
            'arrStatus' => $this->arrStatus,
            'define_type' => $define_type
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_DEFINE_FULL, PERMISS_DEFINE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $result = array('isIntOk' => 0);
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
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
            $result['isIntOk']=1;
        }
        //$result['url'] = URL::route($this->arrUrlDefine[$data['define_type']]['pageTitle'], ['define_type' => $data['define_type']]);
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
        return view('tracnghiem.TracNghiemDefine.component.ajax_load_item',
            array_merge([
                'data' => $data,
                'define_type' => isset($data['define_type']) ? $data['define_type'] : TRAC_NGHIEM_KHOI_LOP,
            ], $this->viewPermission, $this->viewOptionData));
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['define_name']) && trim($data['define_name']) == '') {
                $this->error[] = 'Null';
            }
        }
        return true;
    }
}
