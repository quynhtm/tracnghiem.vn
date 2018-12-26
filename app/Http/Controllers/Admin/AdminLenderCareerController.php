<?php
/*
* @Created by: DIGO - VAYMUON
* @Author    : nguyenduypt86@gmail.com/duynx@peacesoft.net
* @Date      : 09/2018
* @Version   : 1.0
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\LenderCareers;
use App\Library\AdminFunction\CGlobal;
use \Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use App\Library\AdminFunction\Pagging;
use Illuminate\Support\Facades\URL;

class AdminLenderCareerController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'Quản lý nghề nghiệp nhà đầu tư';
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
            'permission_full' => $this->checkPermiss(PERMISS_LENDER_CAREER_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_LENDER_CAREER_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_LENDER_CAREER_DELETE),
        ];
    }

    public function view()
    {
        if (!$this->checkMultiPermiss([PERMISS_LENDER_CAREER_FULL, PERMISS_LENDER_CAREER_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();
        $pageNo = (int)Request::get('page_no', 1);
        $limit = LIMIT_RECORD_20;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();
        $total = 0;

        $search['career_name'] = addslashes(Request::get('career_name', ''));
//        $search['code'] = addslashes(Request::get('code', ''));
        $search['status'] = addslashes(Request::get('status', STATUS_DEFAULT));
        //$search['field_get'] = '';
        $data = app(LenderCareers::class)->searchByCondition($search, $limit, $offset);
        $paging = $total > 0 ? Pagging::getNewPager(3, $pageNo, $total, $limit, $search) : '';

        $this->_outDataView($data);

        $optionSearch = getOption($this->arrStatus, $search['status']);

        return view('admin.AdminLenderCareer.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $total,
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'optionSearch' => $optionSearch,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_LENDER_CAREER_FULL, PERMISS_LENDER_CAREER_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            $data['code'] = (isset($data['career_name'])) ? strtolower (safe_title($data['career_name'],'_')) : '';
            if ($id > 0) {
                app(LenderCareers::class)->updateItem($id, $data);
            } else {
                app(LenderCareers::class)->createItem($data);
            }
        }
        $_data['url'] = URL::route('admin.lenderCareerView');
        return Response::json($_data);
    }

    public function ajaxLoadForm()
    {
        if (!$this->checkMultiPermiss([PERMISS_LENDER_CAREER_FULL, PERMISS_LENDER_CAREER_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }

        $id = $_POST['id'];
        $data = (($id > 0)) ? app(LenderCareers::class)->getItemById($id) : [];

        $this->_getDataDefault();
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return view('admin.AdminLenderCareer.component.ajax_load_item',
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
            if (isset($data['career_name']) && trim($data['career_name']) == '') {
                $this->error[] = 'Null';
            }
        }
        return true;
    }
}
