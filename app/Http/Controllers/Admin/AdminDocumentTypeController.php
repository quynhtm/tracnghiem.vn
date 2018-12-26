<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\DocumentEntity;
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

class AdminDocumentTypeController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý hồ sơ vay';
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
            'permission_full' => $this->checkPermiss(PERMISS_DOCUMENT_TYPE_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_DOCUMENT_TYPE_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_DOCUMENT_TYPE_DELETE),
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_DOCUMENT_TYPE_FULL, PERMISS_DOCUMENT_TYPE_VIEW])) {
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
        $data = app(DocumentType::class)->searchByCondition($search, $limit, $offset, true);

        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($data);
        return view('admin.AdminDocumentType.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $total['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_DOCUMENT_TYPE_FULL, PERMISS_DOCUMENT_TYPE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $data = (($id > 0)) ? app(DocumentType::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);

        $data_dea = []; // data_dea = data_document_entity_attribute
        if($id > 0){
            $search_document_entity_attribute = ['document_type_id'=>$id];
            $data_dea = app(DocumentEntityAttribute::class)->searchByCondition($search_document_entity_attribute,50,0,true);
        }

        $infor_entity_attribute = [];
        $total_entity_attribute = 0;
        if(!empty($data_dea)){
           $infor_entity_attribute = $data_dea['data'];
           $total_entity_attribute = $data_dea['total'];
        }

        $purposes = app(DocumentType::class)->purpose_option;
        $requires = app(DocumentType::class)->require_option;
        $displays = app(DocumentType::class)->display_option;



        return view('admin.AdminDocumentType.add', array_merge([
            'data' => $data,
            'id' => $id,
            'purposes' => $purposes,
            'requires' => $requires,
            'displays' => $displays,
            'infor_entity_attributes' => $infor_entity_attribute,
            'total_entity_attribute' => $total_entity_attribute
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_DOCUMENT_TYPE_FULL, PERMISS_DOCUMENT_TYPE_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }


        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;

        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(DocumentType::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.documentTypeView');
                }
            } else {
                //them moi
                if (app(DocumentType::class)->createItem($data)) {
                    return Redirect::route('admin.documentTypeView');
                }
            }
        }
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminDocumentType.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
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
