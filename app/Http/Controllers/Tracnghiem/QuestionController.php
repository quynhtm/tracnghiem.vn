<?php

namespace App\Http\Controllers\Tracnghiem;

use App\Http\Controllers\BaseAdminController;
use App\Http\Models\Admin\VmDefine;
use App\Http\Models\Tracnghiem\Question;
use App\Library\AdminFunction\CExtracts;
use App\Library\AdminFunction\CGlobal;
use App\Services\TracNghiemService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use App\Library\AdminFunction\Pagging;
use App\Library\AdminFunction\Upload;
use PhpOffice\PhpWord\IOFactory;

class QuestionController extends BaseAdminController
{
    private $error = array();
    private $arrStatus = array();
    private $viewOptionData = array();
    private $viewPermission = array();//check quyen
    private $arrApprove = array();

    public $commonService;
    public function __construct()
    {
        parent::__construct();
        CGlobal::$pageAdminTitle = 'QL câu hỏi';

        $this->commonService = new TracNghiemService();
    }

    public function _getDataDefault()
    {
        $this->arrApprove = Question::$arrApprove;
        $this->arrStatus = array(
            STATUS_BLOCK => viewLanguage('status_choose'),//--chọn trạng thái
            STATUS_SHOW => viewLanguage('status_show'),//Hiển thị
            STATUS_HIDE => viewLanguage('status_hidden'));//Ẩn

        //out put permiss
        $this->viewPermission = [
            'is_root' => $this->is_root,
            'permission_full' => $this->checkPermiss(PERMISS_QUESTION_FULL),
            'permission_create' => $this->checkPermiss(PERMISS_QUESTION_CREATE),
            'permission_delete' => $this->checkPermiss(PERMISS_QUESTION_DELETE),
            'permission_tron_de' => $this->checkPermiss(PERMISS_QUESTION_TRON_DE),
        ];
    }

    public function _outDataView($data)
    {
        $optionApprove = getOption($this->arrApprove, isset($data['question_approved']) ? $data['question_approved'] : STATUS_SHOW);
        $optionStatus = getOption($this->arrStatus, isset($data['question_status']) ? $data['question_status'] : STATUS_SHOW);


        $arrBlock = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_KHOI_LOP);
        $optionBlock = getOption($arrBlock, isset($data['question_school_block']) ? $data['question_school_block'] : STATUS_DEFAULT);

        $arrSubs = app(VmDefine::class)->getArrByType(TRAC_NGHIEM_MON_HOC);
        $optionSubs = getOption($arrSubs, isset($data['question_subject']) ? $data['question_subject'] : STATUS_DEFAULT);


        $arrThematic= app(VmDefine::class)->getArrByType(TRAC_NGHIEM_CHUYEN_DE);
        $optionThematic = getOption($arrThematic, isset($data['question_thematic']) ? $data['question_thematic'] : STATUS_DEFAULT);

        return $this->viewOptionData = [
            'optionStatus' => $optionStatus,
            'optionApprove' => $optionApprove,
            'pageAdminTitle' => CGlobal::$pageAdminTitle,

            'optionBlock' => $optionBlock,
            'optionSubs' => $optionSubs,
            'optionThematic' => $optionThematic,

            'arrBlock' => $arrBlock,
            'arrSubs' => $arrSubs,
            'arrThematic' => $arrThematic,
        ];
    }
    public function view()
    {
        //Check phan quyen.
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_VIEW])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $this->_getDataDefault();

        $pageNo = (int)Request::get('page_no', 1);
        $sbmValue = Request::get('submit', 1);
        $limit = LIMIT_RECORD_30;
        $offset = ($pageNo - 1) * $limit;
        $search = $data = array();

        $search['question_name'] = addslashes(Request::get('question_name', ''));
        $search['question_status'] = (int)Request::get('question_status', -1);
        $search['question_approved'] = (int)Request::get('question_approved', -1);

        $search['question_school_block'] = (int)Request::get('question_school_block', -1);
        $search['question_subject'] = (int)Request::get('question_subject', -1);
        $search['question_thematic'] = (int)Request::get('question_thematic', -1);
        $search['list_question_id'] = Request::get('list_question_id', '');
        $search['user_id_creater'] = ($this->is_root)? 0: $this->user_id;

        //$search['field_get'] = 'menu_name,menu_id,parent_id';//cac truong can lay
        //vmDebug($search);

        $data = app(Question::class)->searchByCondition($search, $limit, $offset, true);
        $paging = $data['total'] > 0 ? Pagging::getNewPager(3, $pageNo, $data['total'], $limit, $search) : '';

        $this->_outDataView($search);
        return view('tracnghiem.Question.view', array_merge([
            'data' => $data['data'],
            'search' => $search,
            'total' => $data['total'],
            'stt' => ($pageNo - 1) * $limit,
            'paging' => $paging,
            'arrApprove' => $this->arrApprove,
            'arrTypeQuestionText' => CExtracts::$arrTypeQuestionText
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function getItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_CREATE])) {
            return Redirect::route('admin.dashboard', array('error' => ERROR_PERMISSION));
        }
        $data = (($id > 0)) ? app(Question::class)->getItemById($id) : [];
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('tracnghiem.Question.add', array_merge([
            'data' => $data,
            'id' => $id,
        ], $this->viewPermission, $this->viewOptionData));
    }

    public function postItem($id)
    {
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_CREATE])) {
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
                if (app(Question::class)->updateItem($id, $data)) {
                    return Redirect::route('tracnghiem.questionView');
                }
            } else {
                //them moi
                if (app(Question::class)->createItem($data)) {
                    return Redirect::route('tracnghiem.questionView');
                }
            }
        }
        $this->_getDataDefault();
        $this->_outDataView($data);
        return view('tracnghiem.Question.add', array_merge([
            'data' => $data,
            'id' => $id,
            'error' => $this->error,
        ], $this->viewPermission, $this->viewOptionData));
    }

    //ajax
    public function deleteItem()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_QUESTION_FULL, PERMISS_QUESTION_DELETE])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id = (int)Request::get('id', 0);
        if ($id > 0 && app(Question::class)->deleteItem($id)) {
            $data['isIntOk'] = 1;
        }
        return Response::json($data);
    }

    private function _validData($data = array()){
        if (!empty($data)) {
            if (isset($data['question_name']) && trim($data['question_name']) == '') {
                $this->error[] = 'Câu hỏi không được bỏ trống';
            }
        }
        return true;
    }

}
