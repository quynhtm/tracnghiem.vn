<?php

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Tracnghiem\Exam;
use App\Library\AdminFunction\CGlobal;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;

class ExamQuestionController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen

    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'QL Đề thi';
    }

    public function _getDataDefault()
    {
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),//--chọn trạng thái
            STATUS_SHOW => viewLanguage('status_show'),//Hiển thị
            STATUS_HIDE => viewLanguage('status_hidden'));//Ẩn

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_EXAMQUESTION_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_EXAMQUESTION_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_EXAMQUESTION_DELETE),
        ];
    }

    public function _outDataView($data)
    {
        $optionStatus = getOption($this->arrStatus, isset($data['status']) ? $data['status'] : STATUS_SHOW);
        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,
        ];
    }
    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_EXAMQUESTION_FULL, PERMISS_EXAMQUESTION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['name'] = addslashes(Request::get('name', ''));
        $search['status'] = (int)Request::get('status', -1);
        //$search['field_get'] = 'menu_name,menu_id,parent_id';//cac truong can lay
        //vmDebug($search);

        $data = app(Exam::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($search);
        return view('tracnghiem.ExamQuestion.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_EXAMQUESTION_FULL, PERMISS_EXAMQUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $data = (($id > 0)) ? app(Exam::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('tracnghiem.ExamQuestion.add', array_merge([
            'data' => $data,
            'id' => $id,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_EXAMQUESTION_FULL, PERMISS_EXAMQUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $id_hiden = (int)Request::get('id_hiden', 0);
        $data = $_POST;
        if(isset($_FILES['image']) && count($_FILES['image'])>0 && $_FILES['image']['name'] != '') {
            $folder = 'banner';
            $_max_file_size = 10 * 1024 * 1024;
            $_file_ext = 'jpg,jpeg,png,gif';
            $pathFileUpload = app(Upload::class)->uploadFile('image', $_file_ext, $folder, $_max_file_size);
            $data['image'] = trim($pathFileUpload) != ''? $pathFileUpload: '';
        }

        if ($this->_validData($data) && empty($this->error)) {
            $id = ($id == 0) ? $id_hiden : $id;
            if ($id > 0) {
                //cap nhat
                if (app(Exam::class)->updateItem($id, $data)) {
                    return Redirect::route('tracnghiem.questionView');
                }
            } else {
                //them moi
                if (app(Exam::class)->createItem($data)) {
                    return Redirect::route('tracnghiem.questionView');
                }
            }
        }
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('tracnghiem.ExamQuestion.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewPermission, $this->viewOptionData));
    }

    //ajax
    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_EXAMQUESTION_FULL, PERMISS_EXAMQUESTION_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(Exam::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function _validData($data = array())
    {
        if (!empty($data)) {
            if (isset($data['name']) && trim($data['name']) == '') {
                $this->error[] = 'Tên banner không được bỏ trống';
            }
            if (isset($data['url']) && trim($data['url']) == '') {
                $this->error[] = 'URL không được bỏ trống';
            }
        }
        return true;
    }
}
