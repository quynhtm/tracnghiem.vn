<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\DocumentEntityAttribute;
use App\Http\Models\Admin\DocumentType;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use PHPExcel_IOFactory;

class AdminDocumentEntityAttributeController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý thuộc tính hồ sơ vay';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_STOP => viewLanguage('status_stop'),
            STATUS_NEW  => viewLanguage('status_new'),
        );
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_DELETE),
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_FULL, PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_20;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        if(Request::get('name') !== ''){
            $search['name'] = Request::get('name');
        }

        $data = app(DocumentEntityAttribute::class)->searchByCondition($search, $limit, $offset);

        // mảng chứa document_type_id
        $array_document_type_id = [];
        if(isset($data['data']) && !empty($data['data'])){
            $total = $data['total'];
            foreach ($data['data'] as $value){
                $array_document_type_id[$value->document_type_id] = $value->document_type_id;
            }
        }

        if(!empty($array_document_type_id)){
            $search_document_type = ['document_type'=>$array_document_type_id,'field_get'=>'name,id'];
            $data_document_type = app(DocumentType::class)->searchByCondition($search_document_type, 40, 0,false);
        }

        $infor_document_type = [];
        if(isset($data_document_type['data']) && !empty($data_document_type['data'])){
            foreach ($data_document_type['data'] as $key_dc=>$value_dc){
                $infor_document_type[$value_dc->id] = $value_dc->name;
            }
        }
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($data);
        return view('admin.AdminDocumentEntityAttribute.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $total,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'infor_document_type'=>$infor_document_type
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_FULL, PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $data = (($id > 0)) ? app(DocumentEntityAttribute::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);

        $document_type = app(DocumentType::class)->getAllData(); // lấy hết hồ sơ

        $document_type_array = [];
        foreach($document_type  as $value_document_type){
           $document_type_array[$value_document_type->id] = $value_document_type;
        }
        //cho id của các hồ sơ vào 1 mảng để check tick bên view

        return view('admin.AdminDocumentEntityAttribute.add', array_merge([
            'data' => $data,
            'id' => $id,
            'document_types' => $document_type_array,
            'input_types' => app(DocumentEntityAttribute::class)->input_type_option
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_FULL, PERMISS_DOCUMENT_ENTITY_ATTRIBUTE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $input_data = '';
        if (Input::hasFile('file_excel_document')) {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $rowsExcel = [];
            $file = Input::file('file_excel_document');
            $ext = $file->getClientOriginalExtension();
            switch ($ext) {
                case 'xls':
                case 'xlsx':
                    $objPHPExcel = PHPExcel_IOFactory::load($file);
                    $objPHPExcel->setActiveSheetIndex(0);
                    $rowsExcel = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    break;
                default:
                    $error[] = "Invalid file type";
            }
            if (empty($rowsExcel))
                return true;
            $arrDataInput = array();
            if (!empty($rowsExcel)) {
                unset($rowsExcel[1]);
                foreach ($rowsExcel as $key => $val) {
                    if (isset($val['A']) && trim($val['A']) != '' && isset($val['B']) && trim($val['B']) != '') {
                        $arrDataInput[$val['A']] = trim($val['B']);
                    }
                }
            }

            $input_data = (!empty($arrDataInput))?json_encode($arrDataInput):'';
        } else {
            $input_data = Request::get("input_data");
        }

        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;

        $data['input_data'] = $input_data; // convert file truyên vào thành json
        $document_types = app(DocumentType::class)->getAllData(); // lấy hết hồ sơ
        $document_type_array = [];
        foreach($document_types  as $value_document_type){
            $document_type_array[$value_document_type->id] = $value_document_type;
        }
        $data['document_type_code'] = $document_type_array[$data['document_type_id']]['code'];
        $data['document_type_name'] = $document_type_array[$data['document_type_id']]['name'];


        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(DocumentEntityAttribute::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.documentEntityAttributeView');
                }
            } else {
                //them moi
                if (app(DocumentEntityAttribute::class)->createItem($data)) {
                    return Redirect::route('admin.documentEntityAttributeView');
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
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'pageAdminTitle' =>CGlobal::$pageAdminTitle
        ];
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
