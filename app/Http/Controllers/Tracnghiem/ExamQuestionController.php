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
            'permission_dowload_exam' => $this->checkPermiss(PERMISS_EXAMQUESTION_DOWLOAD_EXAM),
            'permission_dowload_answer' => $this->checkPermiss(PERMISS_EXAMQUESTION_DOWLOAD_ANSWER),
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
        $search['exam_id'] = (int)Request::get('exam_id', '');

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

    //ajax
    public function dowloadFileExam()
    {
        $data = array('isIntOk' => 0);
        if (!$this->checkMultiPermiss([PERMISS_EXAMQUESTION_FULL, PERMISS_EXAMQUESTION_DOWLOAD_EXAM,PERMISS_EXAMQUESTION_DOWLOAD_ANSWER])) {
            return Response::json($data['msg'] = 'Bạn không có quyền thao tác.');
        }
        $id_de_thi = (int)Request::get('exam_id', 0);
        $type = (int)Request::get('type_file', 1);
        if($id_de_thi > 0){
            $folder = 'uploads/DeThi/';
            $ma_dethi = 'MaDe_' . $id_de_thi . '/';
            $dir = $folder . $ma_dethi;
            $filepath = ($type == 1)? "DeThi_" . $id_de_thi . ".doc": "DapAn_DeThi_" . $id_de_thi . ".doc";
            $file_url = env('APP_URL').$dir.$filepath;
            @header('Content-Type: application/octet-stream');
            @header("Content-Transfer-Encoding: Binary");
            @header("Content-Disposition: attachment; filename=\"{$file_url}\"");
            readfile($file_url);die();
        }
        die('Dowload thành công');
    }
}
