<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\Products;
use App\Library\AdminFunction\CGlobal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Http\Models\Admin\DocumentType;
use App\Http\Models\Admin\ProductDocumentType;

class AdminProductsController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $arrTypeProduction = array();
    private $arrTypeCurrency = array();
    private $arrTypeDuration = array();
    private $arrStatusContent = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen
    private $success = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý sản phẩm vay';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_NEW => viewLanguage('status_new'),
            STATUS_STOP => viewLanguage('status_stop'),
            STATUS_HIDE => viewLanguage('status_hidden'));

        //type production
        $this->arrTypeProduction = array(
            TYPE_PRODUCT_TIEN_MAT => viewLanguage('Tiền mặt'),
            TYPE_PRODUCT_TIN_DUNG => viewLanguage('Tín dụng'));

        //type currency
        $this->arrTypeCurrency = array(
            CURRENCY_VND => viewLanguage('VND'),
            CURRENCY_USD => viewLanguage('USD'));

        //type duration
        $this->arrTypeDuration = array(
            TYPE_DURATION_NGAY => viewLanguage('Ngày'),
            TYPE_DURATION_THANG => viewLanguage('Tháng'));

        //type status content
        $this->arrStatusContent = array(
            STATUS_INT_MOT => viewLanguage('Hiện'),
            STATUS_INT_KHONG => viewLanguage('Ẩn'));

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_PRODUCT_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_PRODUCT_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_PRODUCT_DELETE),
            'permission_active' => $this->checkPermiss(PERMISS_PRODUCT_ACTIVE),
            'permission_deactive' => $this->checkPermiss(PERMISS_PRODUCT_DEACTIVE),
        ];
        //successful notification
        $this->success = [
          'add_success' => STATUS_ADD_SUCCESS,
          'update_success' => STATUS_UPDATE_SUCCESS,
        ];
    }

    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_PRODUCT_FULL, PERMISS_PRODUCT_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['name'] = addslashes(Request::get('name', ''));
        $search['status'] = (int)Request::get('status', -1);
        //$search['field_get'] = 'menu_name,menu_id,parent_id';//cac truong can lay

        $data = app(Products::class)->searchByCondition($search, $limit, $offset);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';
        $optionStatus = getOption($this->arrStatus, $search['status']);
        return view('admin.AdminProducts.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionStatus' => $optionStatus,
        ], $this->viewPermission));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_PRODUCT_FULL, PERMISS_PRODUCT_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }


        $data = (($id > 0)) ? app(Products::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);

//        $document_type = app(DocumentType::class)->getAllData(); // lấy hết hồ sơ


        //cho id của các hồ sơ vào 1 mảng để check tick bên view
        $array_id_product_document = array();
        if(isset($product_document_type['data']) && !empty($product_document_type['data'])){
            foreach($product_document_type['data'] as $key=>$value){
                array_push($array_id_product_document, $value['document_type_id']);
            }
        }
        if(isset($data['fee_rate'])){
            $fee_rate = is_null($data['fee_rate']) ? 0 : (float) $data['fee_rate'];
            $ensure_rate = is_null($data['ensure_rate']) ? 0 : (float) $data['ensure_rate'];
            $data['total_fee'] = numberFormat($fee_rate + $ensure_rate); // tong phi dam bao va phi san
        }


        return view('admin.AdminProducts.add', array_merge([
            'data' => $data,
            'id' => $id,
//            'document_types' => $document_type,

        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_PRODUCT_FULL, PERMISS_PRODUCT_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        foreach ($data as $key=>$value){ // bỏ hết dấu ',' trong các biến
            if(!in_array($key,['history','product_docyment_group'])){
                if(strpos($value,',') > 0){
                    $data[$key] = str_replace(',','',$value);
                }
            }
        }



        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(Products::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.productView');
                }
            } else {
                $check_exist_product = app(Products::class)->searchByCondition(['check_exist'=>$data['code']],30,0,false);
                if(isset($check_exist_product['data']) && $check_exist_product['data']->count() > 0){
                    $this->error[] = 'Đã tồn tại sản phẩm vay này';
                }else{
                    //them moi
                    if (app(Products::class)->createItem($data)) {
                        return Redirect::route('admin.productView');
                    }
                }
            }
        }

        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminProducts.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
            'success' => ($id <= 0) ? $this->success['add_success'] : $this->success['update_success']
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function _outDataView($data)
    {
        $search = array(
            'product_id' => isset($data['id']) ? $data['id'] : 0,
            'field_get' => 'document_type_id',
        );
        $product_document_type = app(ProductDocumentType::class)->searchByCondition($search,30,0,false); // lấy các hồ sơ đã thêm vào product
        $document_type = app(DocumentType::class)->getAllData(); // lấy hết hồ sơ
        $array_id_product_document = array();
        if(isset($product_document_type['data']) && !empty($product_document_type['data'])){
            foreach($product_document_type['data'] as $key=>$value){
                array_push($array_id_product_document, $value['document_type_id']);
            }
        }
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        $optionTypeProduction = getOption($this->arrTypeProduction, isset($data['type_production']) ? $data['type_production'] : TYPE_PRODUCT_TIEN_MAT);
        $optionTypeCurrency = getOption($this->arrTypeCurrency, isset($data['type_of_currency']) ? $data['type_of_currency'] : CURRENCY_VND);
        $optionTypeDuration = getOption($this->arrTypeDuration, isset($data['type_duration']) ? $data['type_duration'] : TYPE_DURATION_NGAY);
        $optionStatusContent = getOption($this->arrStatusContent, isset($data['status_content']) ? $data['status_content'] : STATUS_INT_KHONG);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'document_types' => $document_type,
            'array_id_product_document' => $array_id_product_document,
            'optionTypeProduction' => $optionTypeProduction,
            'optionTypeCurrency' =>$optionTypeCurrency,
            'optionTypeDuration' =>$optionTypeDuration,
            'optionStatusContent' =>$optionStatusContent
        ];
    }
    //ajax
    public function deleteProduct()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_PRODUCT_FULL, PERMISS_PRODUCT_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(Products::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    // ajax kich hoat san pham vay
    public function activeProduct()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_PRODUCT_FULL, PERMISS_PRODUCT_ACTIVE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        $status = Request::get('status');
        $data = ['status'=>$status,'change_status'=>'T']; // key change_status de check ben model product co goi ham xoa record trong product_document hay ko
        if ($id > 0 && app(Products::class)->updateItem($id,$data)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['banner_name']) && trim($data['banner_name']) == '') {
                $this->error[] = 'Null';
            }
        }
        return true;
    }
}
