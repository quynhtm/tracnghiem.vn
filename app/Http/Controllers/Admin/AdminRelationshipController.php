<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\Relationships;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;

class AdminRelationshipController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Tình trạng hôn nhân';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),
            STATUS_SHOW => viewLanguage('status_show'),
            STATUS_STOP => viewLanguage('status_stop')
        );
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_RELATIONSHIPS_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_RELATIONSHIPS_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_RELATIONSHIPS_DELETE),
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_RELATIONSHIPS_FULL, PERMISS_RELATIONSHIPS_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_20;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['name'] = addslashes(Request::get('name', ''));
        $search['code'] = addslashes(Request::get('code', ''));
        $search['status'] = addslashes(Request::get('status', STATUS_DEFAULT));
        //$search['field_get'] = '';
        $data = app(Relationships::class)->searchByCondition($search, $limit, $offset, true);

        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($data);

        $optionSearch = getOption($this->arrStatus, $search['status']);

        return view('admin.AdminRelationship.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionSearch' => $optionSearch,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_RELATIONSHIPS_FULL, PERMISS_RELATIONSHIPS_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            $data['code'] = (isset($data['name'])) ? strtolower (safe_title($data['name'],'_')) : '';
            if ($id > 0) {
                app(Relationships::class)->updateItem($id, $data);
            } else {
                app(Relationships::class)->createItem($data);
            }
        }
        $_data['url'] = URL::route('admin.relationshipsView');
        return Response::json($_data);
    }

    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_RELATIONSHIPS_FULL, PERMISS_RELATIONSHIPS_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(Relationships::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    public function ajaxLoadForm()
    {
        if (!$this->checkMultiPermiss([PERMISS_RELATIONSHIPS_FULL, PERMISS_RELATIONSHIPS_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id = $_POST['id'];
        $data = (($id > 0)) ? app(Relationships::class)->getItemById($id) : [];

        $this->_getDataDefault();
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return view('admin.AdminRelationship.component.ajax_load_item',
            array_merge([
                'data' => $data,
                'optionStatus' => $optionStatus,
            ], $this->viewPermission));
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
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
