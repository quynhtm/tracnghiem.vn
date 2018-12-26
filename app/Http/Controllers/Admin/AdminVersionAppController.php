<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\VersionApp;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;

class AdminVersionAppController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();

    private $arrType = array();
    private $arrOSType = array();
    private $arrMaintenance = array();

    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý phiên bản';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_INT_AM_MOT => viewLanguage('status_new'),
            STATUS_INT_KHONG => viewLanguage('status_stop'),
            STATUS_INT_MOT => viewLanguage('status_show')
        );

        //Type
        $this->arrType = array(
            STATUS_INT_AM_MOT => viewLanguage('--Chọn type--'),
            STATUS_INT_KHONG => viewLanguage('Version'),
            STATUS_INT_MOT => viewLanguage('Maintenance')
        );

        //Os Type
        $this->arrOSType = array(
            '' => viewLanguage('--Chọn hệ điều hành'),
            TYPE_ANDROID => viewLanguage('Android'),
            TYPE_IOS => viewLanguage('IOS'),
            TYPE_MAINTENCE => viewLanguage('Maintenance')
        );

        //Maintenance
        $this->arrMaintenance = array(
            '' => viewLanguage('Có Maintence hay không'),
            'false' => viewLanguage('Không'),
            'true' => viewLanguage('Có')
        );
        //Out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_VERSION_APP_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_VERSION_APP_CREATE),
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_VERSION_APP_FULL, PERMISS_VERSION_APP_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_20;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        //$search['field_get'] = '';
        $data = app(VersionApp::class)->searchByCondition($search, $limit, $offset, $total);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($data);


        return view('admin.AdminVersionApp.view', array_merge([
            'data' => $data['data'],
            'total' => $total,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_VERSION_APP_FULL, PERMISS_VERSION_APP_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if ($this->_validData($data) && empty($this->error)) {
            if ($id > 0) {
                $data['updated_by'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                app(VersionApp::class)->updateItem($id, $data);
            } else {
                $data['created_by'] = isset($this->user['user_id']) ? $this->user['user_id'] : 0;
                app(VersionApp::class)->createItem($data);
            }
        }
        $_data['url'] = URL::route('admin.versionAppView');
        return Response::json($_data);
    }

    public function ajaxLoadForm()
    {
        if (!$this->checkMultiPermiss([PERMISS_CAREER_FULL, PERMISS_CAREER_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id = $_POST['id'];
        $data = (($id > 0)) ? app(VersionApp::class)->getItemById($id) : [];

        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminVersionApp.component.ajax_load_item',
            array_merge([
                'data' => $data,
            ], $this->viewPermission, $this->viewOptionData));
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        $optionType = getOption($this->arrType, isset($data['type']) ? $data['type'] : STATUS_INT_KHONG);
        $optionOSType = getOption($this->arrOSType, isset($data['os_type']) ? $data['os_type'] : TYPE_ANDROID);
        $optionMaintenance = getOption($this->arrMaintenance, isset($data['is_mainten']) ? $data['is_mainten'] : 'false');


        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionType' => $optionType,
            'optionOSType' => $optionOSType,
            'optionMaintenance' => $optionMaintenance,
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
