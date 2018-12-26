<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\OptionCommission;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use PHPExcel_IOFactory;

class AdminOptionCommissionController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'DANH SÁCH CẤU HÌNH NGƯỜI GIỚI THIỆU';
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
            'permission_full' => $this->checkPermiss(PERMISS_OPTION_COMMISSION_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_OPTION_COMMISSION_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_OPTION_COMMISSION_DELETE),
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_OPTION_COMMISSION_FULL, PERMISS_OPTION_COMMISSION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_20;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        if(Request::get('name_options') !== ''){
            $search['name_options'] = Request::get('name_options');
        }
        $data = app(OptionCommission::class)->searchByCondition($search, $limit, $offset, true);
        $status= app(OptionCommission::class)->status_option;

        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($data);
        return view('admin.AdminOptionCommission.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $total['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'status_options' => $status
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_OPTION_COMMISSION_FULL, PERMISS_OPTION_COMMISSION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $data = (($id > 0)) ? app(OptionCommission::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);

        $status= app(OptionCommission::class)->status_option;

        return view('admin.AdminOptionCommission.add', array_merge([
            'data' => $data,
            'id' => $id,
            'statuses' => $status
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_OPTION_COMMISSION_FULL, PERMISS_OPTION_COMMISSION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;

        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(OptionCommission::class)->updateItem($id, $data)) {
                    return Redirect::route('admin.optionCommissionView');
                }
            } else {
                //them moi
                if (app(OptionCommission::class)->createItem($data)) {
                    return Redirect::route('admin.optionCommissionView');
                }
            }
        }
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('admin.AdminOptionCommission.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return $this->viewOptionData = [
//            'optionStatus' => $optionStatus,
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
